<?php

namespace App\Filament\Pages;

use App\Models\Cuenta;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Movimiento;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use UnitEnum;

class ImportarMovimientos extends Page
{
    protected string $view = 'filament.pages.importar-movimientos';
    protected static ?string $navigationLabel = 'Importar Movimientos';
    protected static ?string $title = 'Importar Movimientos CSV';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;
        protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 7;

    public ?string $csvContent   = null;
    public array   $preview      = [];
    public array   $errores      = [];
    public bool    $listo        = false;
    public int     $totalFilas   = 0;
    public int     $filasValidas = 0;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('plantilla')
                ->label('Descargar plantilla')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(fn () => $this->descargarPlantilla()),
        ];
    }

    public function descargarPlantilla()
    {
        $csv = "fecha,tipo_movimiento,monto,cuenta,categoria,subcategoria,descripcion,referencia,es_recurrente\n";
        $csv .= "2024-01-15,ingreso,1500.00,Cuenta Principal,Salario,,Sueldo enero,,0\n";
        $csv .= "2024-01-16,egreso,50.00,Cuenta Principal,Alimentación,Restaurantes,Almuerzo trabajo,,0\n";
        $csv .= "2024-01-17,egreso,200.00,Cuenta Ahorros,Servicios,Internet,Internet mensual,,1\n";

        return response()->streamDownload(
            fn () => print($csv),
            'plantilla_movimientos.csv',
            ['Content-Type' => 'text/csv']
        );
    }

    public function subirCsv(): void
    {
        $this->preview      = [];
        $this->errores      = [];
        $this->listo        = false;
        $this->totalFilas   = 0;
        $this->filasValidas = 0;
    }

    public function procesarArchivo(string $contenido): void
    {
        $this->csvContent = $contenido;
        $this->preview    = [];
        $this->errores    = [];

        $lineas = array_filter(explode("\n", trim($contenido)));
        $header = null;
        $fila   = 0;

        $cuentas       = Cuenta::pluck('id', 'nombre')->mapWithKeys(fn ($id, $n) => [strtolower(trim($n)) => $id]);
        $categorias    = Categoria::pluck('id', 'nombre')->mapWithKeys(fn ($id, $n) => [strtolower(trim($n)) => $id]);
        $subcategorias = Subcategoria::pluck('id', 'nombre')->mapWithKeys(fn ($id, $n) => [strtolower(trim($n)) => $id]);

        foreach ($lineas as $linea) {
            $cols = str_getcsv(trim($linea));

            if (!$header) {
                $header = array_map('strtolower', array_map('trim', $cols));
                continue;
            }

            $fila++;
            $data    = array_combine($header, $cols);
            $errFila = [];

            if (empty($data['fecha']) || !Carbon::createFromFormat('Y-m-d', $data['fecha'])) {
                $errFila[] = 'fecha inválida';
            }

            if (!in_array($data['tipo_movimiento'] ?? '', ['ingreso', 'egreso'])) {
                $errFila[] = 'tipo debe ser ingreso o egreso';
            }

            if (empty($data['monto']) || !is_numeric($data['monto']) || $data['monto'] <= 0) {
                $errFila[] = 'monto inválido';
            }

            $cuentaId = $cuentas[strtolower(trim($data['cuenta'] ?? ''))] ?? null;
            if (!$cuentaId) {
                $errFila[] = 'cuenta "' . ($data['cuenta'] ?? '') . '" no encontrada';
            }

            $categoriaId = $categorias[strtolower(trim($data['categoria'] ?? ''))] ?? null;
            if (!$categoriaId) {
                $errFila[] = 'categoría "' . ($data['categoria'] ?? '') . '" no encontrada';
            }

            $subcategoriaId = null;
            if (!empty($data['subcategoria'])) {
                $subcategoriaId = $subcategorias[strtolower(trim($data['subcategoria']))] ?? null;
            }

            $this->preview[] = [
                'fila'           => $fila,
                'fecha'          => $data['fecha'] ?? '',
                'tipo'           => $data['tipo_movimiento'] ?? '',
                'monto'          => $data['monto'] ?? '',
                'cuenta'         => $data['cuenta'] ?? '',
                'categoria'      => $data['categoria'] ?? '',
                'subcategoria'   => $data['subcategoria'] ?? '',
                'descripcion'    => $data['descripcion'] ?? '',
                'es_recurrente'  => ($data['es_recurrente'] ?? '0') === '1',
                'cuenta_id'      => $cuentaId,
                'categoria_id'   => $categoriaId,
                'subcategoria_id' => $subcategoriaId,
                'errores'        => $errFila,
                'valido'         => empty($errFila),
            ];
        }

        $this->totalFilas   = count($this->preview);
        $this->filasValidas = count(array_filter($this->preview, fn ($r) => $r['valido']));
        $this->listo        = $this->filasValidas > 0;
    }

    public function confirmarImportacion(): void
    {
        $importados = 0;
        $errores    = 0;

        DB::transaction(function () use (&$importados, &$errores) {
            foreach ($this->preview as $row) {
                if (!$row['valido']) { $errores++; continue; }

                try {
                    $mov = Movimiento::create([
                        'tipo_movimiento' => $row['tipo'],
                        'cuenta_id'       => $row['cuenta_id'],
                        'categoria_id'    => $row['categoria_id'],
                        'subcategoria_id' => $row['subcategoria_id'],
                        'monto'           => $row['monto'],
                        'fecha'           => $row['fecha'],
                        'descripcion'     => $row['descripcion'],
                        'es_recurrente'   => $row['es_recurrente'],
                    ]);

                    $cuenta = Cuenta::find($row['cuenta_id']);
                    if ($cuenta) {
                        if ($row['tipo'] === 'ingreso') {
                            $cuenta->increment('saldo_actual', $row['monto']);
                        } else {
                            $cuenta->decrement('saldo_actual', $row['monto']);
                        }
                    }

                    $importados++;
                } catch (\Exception $e) {
                    $errores++;
                }
            }
        });

        $this->preview      = [];
        $this->csvContent   = null;
        $this->listo        = false;
        $this->totalFilas   = 0;
        $this->filasValidas = 0;

        Notification::make()
            ->title("{$importados} movimientos importados" . ($errores > 0 ? ", {$errores} errores" : ''))
            ->success()
            ->send();
    }

    public function cancelar(): void
    {
        $this->preview      = [];
        $this->csvContent   = null;
        $this->listo        = false;
        $this->totalFilas   = 0;
        $this->filasValidas = 0;
        $this->errores      = [];
    }
}

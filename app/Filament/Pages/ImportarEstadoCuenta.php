<?php

namespace App\Filament\Pages;

use App\Models\Cuenta;
use App\Models\Categoria;
use App\Models\Movimiento;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;
use UnitEnum;

class ImportarEstadoCuenta extends Page
{
    protected string $view = 'filament.pages.importar-estado-cuenta';
    protected static ?string $navigationLabel = 'Importar Estado de Cuenta';
    protected static ?string $title = 'Importar Estado de Cuenta PDF';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowUp;
    protected static string|UnitEnum|null $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 8;

    public string  $banco      = 'bcp';
    public int     $cuenta_id  = 0;
    public ?array  $preview    = null;
    public ?string $error      = null;
    public bool    $listo      = false;
    public int     $totalMovs  = 0;

    public function mount(): void
    {
        $primera         = Cuenta::where('activa', true)->first();
        $this->cuenta_id = $primera?->id ?? 0;
    }

    public function getCuentas(): array
    {
        return Cuenta::where('activa', true)->pluck('nombre', 'id')->toArray();
    }

    public function getBancos(): array
    {
        return [
            'bcp'       => '🏦 BCP',
            'bbva'      => '🏦 BBVA',
            'interbank' => '🏦 Interbank',
            'scotiabank'=> '🏦 Scotiabank',
            'yape'      => '📱 Yape',
            'plin'      => '📱 Plin',
            'generico'  => '📄 Genérico',
        ];
    }

    public function procesarPdf(string $base64): void
    {
        $this->preview = null;
        $this->error   = null;
        $this->listo   = false;

        try {
            $pdfContent = base64_decode($base64);
            $parser     = new Parser();
            $pdf        = $parser->parseContent($pdfContent);
            $texto      = $pdf->getText();

            $movimientos = match($this->banco) {
                'bcp'        => $this->parsearBCP($texto),
                'bbva'       => $this->parsearBBVA($texto),
                'interbank'  => $this->parsearInterbank($texto),
                'scotiabank' => $this->parsearScotiabank($texto),
                'yape'       => $this->parsearYape($texto),
                'plin'       => $this->parsearPlin($texto),
                default      => $this->parsearGenerico($texto),
            };

            if (empty($movimientos)) {
                $this->error = 'No se encontraron movimientos en el PDF. Verifica que sea un estado de cuenta válido de ' . $this->getBancos()[$this->banco];
                return;
            }

            $this->preview   = $movimientos;
            $this->totalMovs = count($movimientos);
            $this->listo     = true;

        } catch (\Exception $e) {
            $this->error = 'Error al procesar el PDF: ' . $e->getMessage();
        }
    }

    public function confirmarImportacion(): void
    {
        if (empty($this->preview)) return;

        $importados = 0;
        $errores    = 0;

        DB::transaction(function () use (&$importados, &$errores) {
            $categoriaIngreso = Categoria::where('tipo', 'ingreso')->where('activa', true)->first();
            $categoriaEgreso  = Categoria::where('tipo', 'egreso')->where('activa', true)->first();

            foreach ($this->preview as $mov) {
                if (!$mov['incluir']) continue;

                try {
                    $categoria = $mov['tipo'] === 'ingreso' ? $categoriaIngreso : $categoriaEgreso;

                    Movimiento::create([
                        'tipo_movimiento' => $mov['tipo'],
                        'cuenta_id'       => $this->cuenta_id,
                        'categoria_id'    => $categoria?->id,
                        'monto'           => $mov['monto'],
                        'fecha'           => $mov['fecha'],
                        'descripcion'     => $mov['descripcion'],
                        'referencia'      => $mov['referencia'] ?? null,
                        'es_recurrente'   => false,
                    ]);

                    $cuenta = Cuenta::find($this->cuenta_id);
                    if ($cuenta) {
                        if ($mov['tipo'] === 'ingreso') {
                            $cuenta->increment('saldo_actual', $mov['monto']);
                        } else {
                            $cuenta->decrement('saldo_actual', $mov['monto']);
                        }
                    }

                    $importados++;
                } catch (\Exception $e) {
                    $errores++;
                }
            }
        });

        $this->preview   = null;
        $this->listo     = false;
        $this->totalMovs = 0;

        Notification::make()
            ->title("✅ {$importados} movimientos importados" . ($errores > 0 ? ", {$errores} errores" : ''))
            ->success()
            ->send();
    }

    public function toggleIncluir(int $index): void
    {
        if (isset($this->preview[$index])) {
            $this->preview[$index]['incluir'] = !$this->preview[$index]['incluir'];
        }
    }

    public function cancelar(): void
    {
        $this->preview   = null;
        $this->error     = null;
        $this->listo     = false;
        $this->totalMovs = 0;
    }

    private function parsearBCP(string $texto): array
    {
        $movimientos = [];
        $lineas = explode("\n", $texto);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (preg_match('/(\d{2}\/\d{2}\/\d{4})\s+(.+?)\s+([\d,]+\.\d{2})\s*([\d,]+\.\d{2})?/', $linea, $m)) {
                $monto = (float) str_replace(',', '', $m[3]);
                if ($monto <= 0) continue;

                $desc  = strtolower($m[2]);
                $tipo  = $this->detectarTipo($desc, isset($m[4]));

                $movimientos[] = $this->crearMovimiento($m[1], $m[2], $monto, $tipo);
            }
        }

        return $movimientos;
    }

    private function parsearBBVA(string $texto): array
    {
        $movimientos = [];
        $lineas = explode("\n", $texto);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (preg_match('/(\d{2}-\d{2}-\d{4})\s+(.+?)\s+([+-]?[\d,]+\.\d{2})/', $linea, $m)) {
                $monto = (float) str_replace([',', '+'], '', $m[3]);
                if ($monto == 0) continue;

                $tipo  = str_starts_with(trim($m[3]), '-') ? 'egreso' : 'ingreso';
                $fecha = str_replace('-', '/', $m[1]);

                $movimientos[] = $this->crearMovimiento($fecha, $m[2], abs($monto), $tipo);
            }
        }

        return $movimientos;
    }

    private function parsearInterbank(string $texto): array
    {
        $movimientos = [];
        $lineas = explode("\n", $texto);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (preg_match('/(\d{2}\/\d{2}\/\d{4})\s+(.+?)\s+([\d,]+\.\d{2})\s*([\d,]+\.\d{2})?/', $linea, $m)) {
                $monto = (float) str_replace(',', '', $m[3]);
                if ($monto <= 0) continue;

                $desc = strtolower($m[2]);
                $tipo = $this->detectarTipo($desc, isset($m[4]));

                $movimientos[] = $this->crearMovimiento($m[1], $m[2], $monto, $tipo);
            }
        }

        return $movimientos;
    }

    private function parsearScotiabank(string $texto): array
    {
        $movimientos = [];
        $lineas = explode("\n", $texto);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (preg_match('/(\d{2}\/\d{2}\/\d{4})\s+(.+?)\s+([\d,]+\.\d{2})/', $linea, $m)) {
                $monto = (float) str_replace(',', '', $m[3]);
                if ($monto <= 0) continue;

                $desc = strtolower($m[2]);
                $tipo = $this->detectarTipo($desc, false);

                $movimientos[] = $this->crearMovimiento($m[1], $m[2], $monto, $tipo);
            }
        }

        return $movimientos;
    }

    private function parsearYape(string $texto): array
    {
        $movimientos = [];
        $lineas = explode("\n", $texto);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (preg_match('/(\d{2}\/\d{2}\/\d{4})\s+(.+?)\s+S\/\s*([\d,]+\.\d{2})/', $linea, $m)) {
                $monto = (float) str_replace(',', '', $m[3]);
                if ($monto <= 0) continue;

                $desc = strtolower($m[2]);
                $tipo = str_contains($desc, 'recib') ? 'ingreso' : 'egreso';

                $movimientos[] = $this->crearMovimiento($m[1], 'Yape: ' . $m[2], $monto, $tipo);
            }
        }

        return $movimientos;
    }

    private function parsearPlin(string $texto): array
    {
        $movimientos = [];
        $lineas = explode("\n", $texto);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (preg_match('/(\d{2}\/\d{2}\/\d{4})\s+(.+?)\s+([\d,]+\.\d{2})/', $linea, $m)) {
                $monto = (float) str_replace(',', '', $m[3]);
                if ($monto <= 0) continue;

                $desc = strtolower($m[2]);
                $tipo = str_contains($desc, 'recib') || str_contains($desc, 'cobr') ? 'ingreso' : 'egreso';

                $movimientos[] = $this->crearMovimiento($m[1], 'Plin: ' . $m[2], $monto, $tipo);
            }
        }

        return $movimientos;
    }

    private function parsearGenerico(string $texto): array
    {
        $movimientos = [];
        $lineas = explode("\n", $texto);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (preg_match('/(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4})\s+(.{5,50}?)\s+([\d,]+\.\d{2})/', $linea, $m)) {
                $monto = (float) str_replace(',', '', $m[3]);
                if ($monto <= 0 || $monto > 999999) continue;

                $desc = strtolower($m[2]);
                $tipo = $this->detectarTipo($desc, false);

                $movimientos[] = $this->crearMovimiento($m[1], $m[2], $monto, $tipo);
            }
        }

        return $movimientos;
    }

    private function detectarTipo(string $desc, bool $tieneSegundoMonto): string
    {
        $kwIngreso = ['abono', 'depósito', 'deposito', 'transferencia recib', 'sueldo', 'salario',
                      'remuner', 'cobro', 'devolucion', 'devolución', 'recib', 'ingreso'];
        $kwEgreso  = ['cargo', 'débito', 'debito', 'pago', 'compra', 'retiro', 'consumo',
                      'comisión', 'comision', 'transferencia env', 'egreso'];

        foreach ($kwIngreso as $kw) {
            if (str_contains($desc, $kw)) return 'ingreso';
        }
        foreach ($kwEgreso as $kw) {
            if (str_contains($desc, $kw)) return 'egreso';
        }

        return $tieneSegundoMonto ? 'ingreso' : 'egreso';
    }

    private function crearMovimiento(string $fecha, string $desc, float $monto, string $tipo): array
    {
        $fechaNorm = $this->normalizarFecha($fecha);

        return [
            'fecha'       => $fechaNorm,
            'descripcion' => trim($desc),
            'monto'       => $monto,
            'tipo'        => $tipo,
            'referencia'  => null,
            'incluir'     => true,
        ];
    }

    private function normalizarFecha(string $fecha): string
    {
        if (preg_match('/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/', $fecha, $m)) {
            return "{$m[3]}-{$m[2]}-{$m[1]}";
        }
        if (preg_match('/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{2})/', $fecha, $m)) {
            $anio = (int)$m[3] > 50 ? '19' . $m[3] : '20' . $m[3];
            return "{$anio}-{$m[2]}-{$m[1]}";
        }
        return now()->format('Y-m-d');
    }
}

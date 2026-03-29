<?php

namespace App\Filament\Pages;

use App\Models\Cuenta;
use App\Models\Movimiento;
use App\Models\Presupuesto;
use App\Models\Setting;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class ReporteAnual extends Page
{
    protected string $view = 'filament.pages.reporte-anual';
    protected static ?string $navigationLabel = 'Reporte Anual';
    protected static ?string $title = 'Reporte Anual';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 3;

    public int $anio;

    public function mount(): void
    {
        $this->anio = now()->year;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargar')
                ->label('Descargar PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(fn () => $this->descargarPdf()),
        ];
    }

    public function descargarPdf()
    {
        $datos = $this->getDatos();

        $pdf = Pdf::loadView('pdf.reporte-anual', $datos)
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "reporte_anual_{$this->anio}.pdf"
        );
    }

    public function updatedAnio(): void {}

    public function getDatos(): array
    {
        $inicio = Carbon::create($this->anio, 1, 1)->startOfYear();
        $fin    = Carbon::create($this->anio, 12, 31)->endOfYear();

        $meses = collect(range(1, 12))->map(function ($mes) {
            $ini = Carbon::create($this->anio, $mes, 1)->startOfMonth();
            $fin = Carbon::create($this->anio, $mes, 1)->endOfMonth();

            $ingresos = Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [$ini, $fin])->sum('monto');
            $egresos = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$ini, $fin])->sum('monto');

            return [
                'mes'      => ucfirst(Carbon::create($this->anio, $mes)->translatedFormat('F')),
                'ingresos' => $ingresos,
                'egresos'  => $egresos,
                'ahorro'   => $ingresos - $egresos,
            ];
        });

        $totalIngresos = $meses->sum('ingresos');
        $totalEgresos  = $meses->sum('egresos');
        $totalAhorro   = $totalIngresos - $totalEgresos;

        $topCategorias = Movimiento::select('categorias.nombre', DB::raw('SUM(movimientos.monto) as total'))
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->where('movimientos.tipo_movimiento', 'egreso')
            ->whereBetween('movimientos.fecha', [$inicio, $fin])
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $presupuestos = Presupuesto::with(['categoria', 'subcategoria'])
            ->where('activo', true)
            ->get()
            ->map(fn ($p) => [
                'nombre'     => $p->subcategoria?->nombre
                    ? $p->categoria->nombre . ' › ' . $p->subcategoria->nombre
                    : $p->categoria->nombre,
                'limite'     => $p->monto_limite,
                'gasto'      => $p->gastoActual(),
                'porcentaje' => $p->porcentaje(),
                'superado'   => $p->superado(),
            ]);

        $cuentas  = Cuenta::where('activa', true)->get();
        $settings = Setting::first();

        return [
            'meses'          => $meses,
            'topCategorias'  => $topCategorias,
            'presupuestos'   => $presupuestos,
            'cuentas'        => $cuentas,
            'settings'       => $settings,
            'anio'           => $this->anio,
            'totalIngresos'  => $totalIngresos,
            'totalEgresos'   => $totalEgresos,
            'totalAhorro'    => $totalAhorro,
            'mejorMes'       => $meses->sortByDesc('ahorro')->first(),
            'peorMes'        => $meses->sortBy('ahorro')->first(),
        ];
    }
}

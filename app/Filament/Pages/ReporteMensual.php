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

class ReporteMensual extends Page
{
    protected string $view = 'filament.pages.reporte-mensual';

    protected static ?string $navigationLabel = 'Reporte Mensual';

    protected static ?string $title = 'Reporte Mensual';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Análisis';

    public int $mes = 0;

    public int $anio = 0;

    public function mount(): void
    {
        $this->mes = now()->month;
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

        $pdf = Pdf::loadView(
            'pdf.reporte-mensual',
            $datos
        )->setPaper('a4', 'portrait');

        $nombreMes = Carbon::create($this->anio, $this->mes)->translatedFormat('F_Y');

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            "reporte_{$nombreMes}.pdf"
        );
    }

    public function updatedMes(): void {}

    public function updatedAnio(): void {}

    public function getDatos(): array
    {
        $mes = $this->mes ?: now()->month;
        $anio = $this->anio ?: now()->year;

        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin = Carbon::create($anio, $mes, 1)->endOfMonth();

        $ingresos = Movimiento::with(['categoria', 'subcategoria', 'cuenta'])
            ->where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicio, $fin])
            ->orderBy('fecha')
            ->get();

        $egresos = Movimiento::with(['categoria', 'subcategoria', 'cuenta'])
            ->where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicio, $fin])
            ->orderBy('fecha')
            ->get();

        $gastosPorCategoria = Movimiento::select('categorias.nombre', DB::raw('SUM(movimientos.monto) as total'))
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->where('movimientos.tipo_movimiento', 'egreso')
            ->whereBetween('movimientos.fecha', [$inicio, $fin])
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->get();

        $presupuestos = Presupuesto::with(['categoria', 'subcategoria'])
            ->where('activo', true)
            ->whereDate('fecha_inicio', '<=', $fin)
            ->whereDate('fecha_fin', '>=', $inicio)
            ->get()
            ->map(fn ($p) => [
                'nombre' => $p->subcategoria?->nombre
                                    ? $p->categoria->nombre.' › '.$p->subcategoria->nombre
                                    : $p->categoria->nombre,
                'limite' => $p->monto_limite,
                'gasto' => $p->gastoActual(),
                'porcentaje' => $p->porcentaje(),
                'superado' => $p->superado(),
            ]);

        $cuentas = Cuenta::where('activa', true)->get();
        $settings = Setting::first();
        $nombreMes = $inicio->translatedFormat('F Y');

        return [
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'totalIngresos' => $ingresos->sum('monto'),
            'totalEgresos' => $egresos->sum('monto'),
            'ahorro' => $ingresos->sum('monto') - $egresos->sum('monto'),
            'gastosPorCategoria' => $gastosPorCategoria,
            'presupuestos' => $presupuestos,
            'cuentas' => $cuentas,
            'settings' => $settings,
            'nombreMes' => $nombreMes,
            'mes' => $this->mes,
            'anio' => $this->anio,
        ];
    }
}

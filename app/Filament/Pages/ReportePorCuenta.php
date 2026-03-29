<?php

namespace App\Filament\Pages;

use App\Models\Cuenta;
use App\Models\Movimiento;
use App\Models\Transferencia;
use App\Models\Setting;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class ReportePorCuenta extends Page
{
    protected string $view = 'filament.pages.reporte-por-cuenta';
    protected static ?string $navigationLabel = 'Reporte por Cuenta';
    protected static ?string $title = 'Reporte por Cuenta';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 5;

    public int    $cuenta_id = 0;
    public string $desde     = '';
    public string $hasta     = '';

    public function mount(): void
    {
        $primera          = Cuenta::where('activa', true)->first();
        $this->cuenta_id  = $primera?->id ?? 0;
        $this->desde      = now()->startOfMonth()->format('Y-m-d');
        $this->hasta      = now()->endOfMonth()->format('Y-m-d');
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
        if (!$datos['cuenta']) return;

        $pdf = Pdf::loadView('pdf.reporte-por-cuenta', $datos)
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'reporte_cuenta_' . str_replace(' ', '_', $datos['cuenta']->nombre) . '_' . now()->format('d_m_Y') . '.pdf'
        );
    }

    public function getCuentas(): array
    {
        return Cuenta::where('activa', true)->pluck('nombre', 'id')->toArray();
    }

    public function getDatos(): array
    {
        $cuenta = Cuenta::find($this->cuenta_id);
        if (!$cuenta) return ['cuenta' => null];

        $desde = $this->desde ?: now()->startOfMonth()->format('Y-m-d');
        $hasta = $this->hasta ?: now()->endOfMonth()->format('Y-m-d');

        $movimientos = Movimiento::with(['categoria', 'subcategoria'])
            ->where('cuenta_id', $this->cuenta_id)
            ->whereBetween('fecha', [$desde, $hasta])
            ->orderBy('fecha')
            ->get();

        $transferenciasOrigen = Transferencia::with(['cuentaDestino'])
            ->where('cuenta_origen_id', $this->cuenta_id)
            ->whereBetween('fecha', [$desde, $hasta])
            ->get();

        $transferenciasDestino = Transferencia::with(['cuentaOrigen'])
            ->where('cuenta_destino_id', $this->cuenta_id)
            ->whereBetween('fecha', [$desde, $hasta])
            ->get();

        $totalIngresos     = $movimientos->where('tipo_movimiento', 'ingreso')->sum('monto');
        $totalEgresos      = $movimientos->where('tipo_movimiento', 'egreso')->sum('monto');
        $totalTransfSalida = $transferenciasOrigen->sum('monto');
        $totalTransfEntrada= $transferenciasDestino->sum('monto');

        $gastosPorCategoria = $movimientos
            ->where('tipo_movimiento', 'egreso')
            ->groupBy(fn ($m) => $m->categoria?->nombre ?? 'Sin categoría')
            ->map(fn ($group) => $group->sum('monto'))
            ->sortDesc();

        $settings = Setting::first();

        return [
            'cuenta'               => $cuenta,
            'movimientos'          => $movimientos,
            'transferenciasOrigen' => $transferenciasOrigen,
            'transferenciasDestino'=> $transferenciasDestino,
            'totalIngresos'        => $totalIngresos,
            'totalEgresos'         => $totalEgresos,
            'totalTransfSalida'    => $totalTransfSalida,
            'totalTransfEntrada'   => $totalTransfEntrada,
            'gastosPorCategoria'   => $gastosPorCategoria,
            'desde'                => $desde,
            'hasta'                => $hasta,
            'settings'             => $settings,
        ];
    }
}
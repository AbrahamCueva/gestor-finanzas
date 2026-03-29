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
use UnitEnum;

class ReporteComparativoCuentas extends Page
{
    protected string $view = 'filament.pages.reporte-comparativo-cuentas';
    protected static ?string $navigationLabel = 'Comparativo de Cuentas';
    protected static ?string $title = 'Reporte Comparativo de Cuentas';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 12;

    public string $desde = '';
    public string $hasta = '';

    public function mount(): void
    {
        $this->desde = now()->startOfMonth()->format('Y-m-d');
        $this->hasta = now()->endOfMonth()->format('Y-m-d');
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

        $pdf = Pdf::loadView('pdf.reporte-comparativo-cuentas', $datos)
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'comparativo_cuentas_' . now()->format('d_m_Y') . '.pdf'
        );
    }

    public function getDatos(): array
    {
        $desde  = $this->desde ?: now()->startOfMonth()->format('Y-m-d');
        $hasta  = $this->hasta ?: now()->endOfMonth()->format('Y-m-d');
        $cuentas = Cuenta::where('activa', true)->get();

        $datos = [];
        $totalIngresos  = 0;
        $totalEgresos   = 0;
        $totalSaldo     = 0;

        foreach ($cuentas as $cuenta) {
            $ingresos = Movimiento::where('cuenta_id', $cuenta->id)
                ->where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [$desde, $hasta])
                ->sum('monto');

            $egresos = Movimiento::where('cuenta_id', $cuenta->id)
                ->where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$desde, $hasta])
                ->sum('monto');

            $transferSalida = Transferencia::where('cuenta_origen_id', $cuenta->id)
                ->whereBetween('fecha', [$desde, $hasta])
                ->sum('monto');

            $transferEntrada = Transferencia::where('cuenta_destino_id', $cuenta->id)
                ->whereBetween('fecha', [$desde, $hasta])
                ->sum('monto');

            $movimientos = Movimiento::where('cuenta_id', $cuenta->id)
                ->whereBetween('fecha', [$desde, $hasta])
                ->count();

            $totalIngresos += $ingresos;
            $totalEgresos  += $egresos;
            $totalSaldo    += $cuenta->saldo_actual;

            $topCategoria = Movimiento::selectRaw('categoria_id, SUM(monto) as total')
                ->where('cuenta_id', $cuenta->id)
                ->where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$desde, $hasta])
                ->groupBy('categoria_id')
                ->orderByDesc('total')
                ->with('categoria')
                ->first();

            $datos[] = [
                'cuenta'          => $cuenta,
                'ingresos'        => round($ingresos, 2),
                'egresos'         => round($egresos, 2),
                'ahorro'          => round($ingresos - $egresos, 2),
                'transferSalida'  => round($transferSalida, 2),
                'transferEntrada' => round($transferEntrada, 2),
                'movimientos'     => $movimientos,
                'topCategoria'    => $topCategoria?->categoria?->nombre ?? '—',
                'pctDelTotal'     => 0,
            ];
        }

        foreach ($datos as &$d) {
            $d['pctSaldo'] = $totalSaldo > 0
                ? round(($d['cuenta']->saldo_actual / $totalSaldo) * 100, 1)
                : 0;
        }

        return [
            'datos'         => $datos,
            'desde'         => $desde,
            'hasta'         => $hasta,
            'totalIngresos' => round($totalIngresos, 2),
            'totalEgresos'  => round($totalEgresos, 2),
            'totalSaldo'    => round($totalSaldo, 2),
            'totalAhorro'   => round($totalIngresos - $totalEgresos, 2),
            'settings'      => Setting::first(),
        ];
    }
}

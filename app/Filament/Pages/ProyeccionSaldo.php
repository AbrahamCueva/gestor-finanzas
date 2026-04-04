<?php

namespace App\Filament\Pages;

use App\Models\Cuenta;
use App\Models\Movimiento;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ProyeccionSaldo extends Page
{
    protected string $view = 'filament.pages.proyeccion-saldo';

    protected static ?string $navigationLabel = 'Proyección de Saldo';

    protected static ?string $title = 'Proyección de Saldo';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowTrendingUp;

    protected static string|UnitEnum|null $navigationGroup = 'Análisis';

    protected static ?int $navigationSort = 14;

    public int $cuenta_id = 0;

    public int $meses = 6;

    public string $escenario = 'actual';

    public function mount(): void
    {
        $primera = Cuenta::where('activa', true)->first();
        $this->cuenta_id = $primera?->id ?? 0;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargar')
                ->label('Descargar PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(fn() => $this->descargarPdf()),
        ];
    }

    public function getCuentas(): array
    {
        return Cuenta::where('activa', true)->pluck('nombre', 'id')->toArray();
    }

    public function getDatos(): array
    {
        $cuenta = Cuenta::find($this->cuenta_id);
        if (!$cuenta) {
            return ['cuenta' => null, 'proyeccion' => []];
        }

        $promedioIngresos = 0;
        $promedioEgresos = 0;

        for ($i = 1; $i <= 3; $i++) {
            $inicio = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();

            $promedioIngresos += Movimiento::where('cuenta_id', $this->cuenta_id)
                ->where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [$inicio, $fin])
                ->sum('monto');

            $promedioEgresos += Movimiento::where('cuenta_id', $this->cuenta_id)
                ->where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$inicio, $fin])
                ->sum('monto');
        }

        $promedioIngresos = $promedioIngresos / 3;
        $promedioEgresos = $promedioEgresos / 3;
        $promedioAhorro = $promedioIngresos - $promedioEgresos;

        $factorIngresos = match ($this->escenario) {
            'optimista' => 1.15,
            'pesimista' => 0.85,
            default => 1.0,
        };
        $factorEgresos = match ($this->escenario) {
            'optimista' => 0.90,
            'pesimista' => 1.15,
            default => 1.0,
        };

        $ingMes = $promedioIngresos * $factorIngresos;
        $egrMes = $promedioEgresos * $factorEgresos;
        $ahoMes = $ingMes - $egrMes;

        $saldoActual = $cuenta->saldo_actual;
        $proyeccion = [];

        for ($i = 1; $i <= $this->meses; $i++) {
            $mes = now()->addMonths($i);
            $saldo = $saldoActual + ($ahoMes * $i);
            $proyeccion[] = [
                'mes' => $mes->translatedFormat('M Y'),
                'saldo' => round($saldo, 2),
                'ingresos' => round($ingMes, 2),
                'egresos' => round($egrMes, 2),
                'ahorro' => round($ahoMes, 2),
            ];
        }

        $inicioMes = now()->startOfMonth();
        $finMes = now()->endOfMonth();
        $ingActual = Movimiento::where('cuenta_id', $this->cuenta_id)
            ->where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->sum('monto');
        $egrActual = Movimiento::where('cuenta_id', $this->cuenta_id)
            ->where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->sum('monto');

        return [
            'cuenta' => $cuenta,
            'proyeccion' => $proyeccion,
            'promedioIngresos' => round($promedioIngresos, 2),
            'promedioEgresos' => round($promedioEgresos, 2),
            'promedioAhorro' => round($promedioAhorro, 2),
            'ingMes' => round($ingMes, 2),
            'egrMes' => round($egrMes, 2),
            'ahoMes' => round($ahoMes, 2),
            'saldoFinal' => round($saldoActual + ($ahoMes * $this->meses), 2),
            'ingActual' => round($ingActual, 2),
            'egrActual' => round($egrActual, 2),
        ];
    }

    public function descargarPdf()
    {
        $datos = $this->getDatos();
        $cuenta = $datos['cuenta'];
        if (!$cuenta) {
            return;
        }

        $pdf = Pdf::loadView('pdf.proyeccion-saldo', [
            'datos' => $datos,
            'cuenta' => $cuenta,
            'meses' => $this->meses,
            'escenario' => $this->escenario,
            'settings' => \App\Models\Setting::first(),
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn() => print ($pdf->output()),
            'proyeccion_' . str_replace(' ', '_', $cuenta->nombre) . '_' . now()->format('d_m_Y') . '.pdf'
        );
    }

    public function updated($property): void
    {
        if (in_array($property, ['cuenta_id', 'meses', 'escenario'])) {
            $datos = $this->getDatos();
            $this->dispatch('updatePsChart', [
                'proyeccion' => $datos['proyeccion'],
                'saldoActual' => $datos['cuenta'] ? $datos['cuenta']->saldo_actual : 0,
                'escenario' => $this->escenario,
            ]);
        }
    }
}

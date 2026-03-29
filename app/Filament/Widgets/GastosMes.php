<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use App\Models\Meta;
use App\Models\Deuda;
use App\Models\Presupuesto;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GastosMes extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $gastosSemana = Movimiento::query()
            ->where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('monto');

        $ingresosMes = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('monto');

        $egresosMes = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('monto');

        $ahorroMes   = $ingresosMes - $egresosMes;
        $pctAhorro   = $ingresosMes > 0 ? round(($ahorroMes / $ingresosMes) * 100, 1) : 0;

        $ingresosMesAnterior = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->sum('monto');
        $egresosMesAnterior  = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->sum('monto');
        $ahorroMesAnterior = $ingresosMesAnterior - $egresosMesAnterior;

        $totalDeudas = Deuda::where('estado', '!=', 'pagada')
            ->where('tipo', 'debo')
            ->get()
            ->sum(fn ($d) => $d->restante());

        $presupuestosSuperados = Presupuesto::where('activo', true)
            ->get()
            ->filter(fn ($p) => $p->superado())
            ->count();

        $presupuestosTotal = Presupuesto::where('activo', true)->count();

        $metasCompletadas = Meta::where('completada', true)->count();
        $metasTotal       = Meta::count();
        $metasPendientes  = $metasTotal - $metasCompletadas;
        $proximaMeta      = Meta::where('completada', false)
            ->orderBy('fecha_limite')
            ->first();

        $tendenciaAhorro = [];
        for ($i = 5; $i >= 0; $i--) {
            $ing = Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [now()->subMonths($i)->startOfMonth(), now()->subMonths($i)->endOfMonth()])
                ->sum('monto');
            $egr = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [now()->subMonths($i)->startOfMonth(), now()->subMonths($i)->endOfMonth()])
                ->sum('monto');
            $tendenciaAhorro[] = max(0, round($ing - $egr));
        }

        return [
            Stat::make('Gastos de la Semana', 'S/ ' . number_format($gastosSemana, 2))
                ->description('Gastos registrados esta semana')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart([3, 4, 2, 6, 5, 3, 4])
                ->color('warning'),

            Stat::make('Ahorro del Mes', 'S/ ' . number_format($ahorroMes, 2))
                ->description($pctAhorro . '% de los ingresos · ' .
                    ($ahorroMes >= $ahorroMesAnterior ? '↑ Mejor que el mes pasado' : '↓ Menor que el mes pasado'))
                ->descriptionIcon($ahorroMes >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($tendenciaAhorro)
                ->color($ahorroMes >= 0 ? 'success' : 'danger'),

            Stat::make('Presupuestos', $presupuestosSuperados . ' / ' . $presupuestosTotal . ' superados')
                ->description($presupuestosSuperados > 0
                    ? "{$presupuestosSuperados} presupuesto(s) excedido(s) este mes"
                    : 'Todos los presupuestos bajo control ✓')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($presupuestosSuperados > 0 ? 'danger' : 'success'),

            Stat::make('Deudas Pendientes', 'S/ ' . number_format($totalDeudas, 2))
                ->description($metasPendientes . ' meta(s) activa(s)' .
                    ($proximaMeta ? ' · Próxima: ' . $proximaMeta->nombre : ''))
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($totalDeudas > 0 ? 'warning' : 'success'),
        ];
    }
}

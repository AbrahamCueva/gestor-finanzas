<?php

namespace App\Filament\Widgets;

use App\Models\Cuenta;
use App\Models\Movimiento;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BalanceTotal extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $ingresosMes = Movimiento::query()
            ->where('tipo_movimiento', 'ingreso')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('monto');

        $egresosMes = Movimiento::query()
            ->where('tipo_movimiento', 'egreso')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('monto');

        $ingresosSemana = Movimiento::query()
            ->where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('monto');

        $balanceTotal = Cuenta::sum('saldo_actual');

        return [

            Stat::make('Balance Total', 'S/ '.number_format($balanceTotal, 2))
                ->description('Dinero disponible en todas las cuentas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart([10, 15, 12, 18, 20, 25, 30])
                ->color('success'),

            Stat::make('Ingresos del mes', 'S/ '.number_format($ingresosMes, 2))
                ->description('Ingresos registrados este mes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([5, 10, 8, 15, 12, 18, 20])
                ->color('primary'),

            Stat::make('Egresos del mes', 'S/ '.number_format($egresosMes, 2))
                ->description('Gastos registrados este mes')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([3, 8, 6, 10, 9, 14, 16])
                ->color('danger'),

            Stat::make('Ingresos de la Semana', 'S/ '.number_format($ingresosSemana, 2))
                ->description('Ingresos registrados esta semana')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart([2, 4, 3, 5, 6, 4, 7])
                ->color('primary'),

        ];
    }
}

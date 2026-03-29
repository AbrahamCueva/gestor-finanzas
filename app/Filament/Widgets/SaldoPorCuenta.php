<?php

namespace App\Filament\Widgets;

use App\Models\Cuenta;
use Filament\Widgets\ChartWidget;

class SaldoPorCuenta extends ChartWidget
{
    protected ?string $heading = 'Saldo Por Cuenta';

    protected function getData(): array
    {
        $cuentas = Cuenta::query()->select('nombre', 'saldo_actual')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Saldo Actual',
                    'data' => $cuentas->pluck('saldo_actual')->toArray(),
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(6, 182, 212, 0.8)',
                    ],
                    'borderColor' => [
                        '#3b82f6', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4',
                    ],
                    'borderWidth' => 1,
                    'borderRadius' => 6, 
                ],
            ],
            'labels' => $cuentas->pluck('nombre')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

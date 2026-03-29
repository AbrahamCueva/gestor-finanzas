<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class GraficoCategorias extends ChartWidget
{
    protected ?string $heading = 'Gastos por Categoría';

    protected ?string $description = 'Egresos del mes actual';

    protected ?string $pollingInterval = '60s';

    protected function getHeight(): ?string
    {
        return '280px';
    }

    public ?string $filter = 'mes_actual';

    protected function getFilters(): ?array
    {
        return [
            'mes_actual' => 'Este mes',
            'ultimos_3' => 'Últimos 3 meses',
            'ultimos_6' => 'Últimos 6 meses',
            'este_anio' => 'Este año',
        ];
    }

    protected function getData(): array
    {
        [$fechaInicio, $fechaFin] = match ($this->filter) {
            'ultimos_3' => [now()->subMonths(2)->startOfMonth(), now()->endOfMonth()],
            'ultimos_6' => [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()],
            'este_anio' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };

        $data = Movimiento::query()
            ->select('categorias.nombre', DB::raw('SUM(movimientos.monto) as total'))
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->where('movimientos.tipo_movimiento', 'egreso')
            ->whereBetween('movimientos.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->get();

        $colores = [
            '#ef4444', '#f97316', '#eab308',
            '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899',
        ];

        return [
            'datasets' => [[
                'label' => 'S/',
                'data' => $data->pluck('total')->map(fn ($v) => round($v, 2))->toArray(),
                'backgroundColor' => array_slice($colores, 0, $data->count()),
                'borderColor' => '#00000015',
                'borderWidth' => 2,
                'hoverBorderColor' => '#fff',
                'hoverBorderWidth' => 3,
                'hoverOffset' => 8,
            ]],
            'labels' => $data->pluck('nombre')->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'cutout' => '72%',
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                        'padding' => 16,
                        'font' => ['size' => 12],
                        'color' => 'rgba(156, 163, 175, 0.9)',
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'padding' => 12,
                    'backgroundColor' => 'rgba(15, 23, 42, 0.9)',
                    'titleColor' => '#f1f5f9',
                    'bodyColor' => '#94a3b8',
                    'borderColor' => 'rgba(255,255,255,0.08)',
                    'borderWidth' => 1,
                    'titleFont' => ['size' => 13, 'weight' => 'bold'],
                    'bodyFont' => ['size' => 12],
                    'cornerRadius' => 8,
                    'displayColors' => true,
                    'boxPadding' => 4,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

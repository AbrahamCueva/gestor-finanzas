<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class IngresosVsEgresos extends ChartWidget
{
    protected ?string $heading = 'Ingresos vs Egresos';

    protected ?string $description = 'Resumen financiero del año actual';

    protected ?string $pollingInterval = '60s';
    public ?string $filter = 'este_anio';

    protected static ?int $sort = 1;

    protected function getFilters(): ?array
    {
        return [
            'este_anio' => 'Este año',
            'ultimos_3' => 'Últimos 3 meses',
            'ultimos_6' => 'Últimos 6 meses',
            'mes_actual' => 'Este mes',
        ];
    }
    protected function getHeight(): ?string
    {
        return '280px';
    }

    protected function getData(): array
    {
        [$fechaInicio, $fechaFin, $meses, $labels] = $this->getRango();

        $ingresos = Movimiento::query()
            ->select(DB::raw('MONTH(fecha) as mes'), DB::raw('YEAR(fecha) as anio'), DB::raw('SUM(monto) as total'))
            ->where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->groupBy('anio', 'mes')
            ->pluck('total', 'mes')->toArray();

        $egresos = Movimiento::query()
            ->select(DB::raw('MONTH(fecha) as mes'), DB::raw('YEAR(fecha) as anio'), DB::raw('SUM(monto) as total'))
            ->where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->groupBy('anio', 'mes')
            ->pluck('total', 'mes')->toArray();

        $ingresosData = [];
        $egresosData = [];

        foreach ($meses as $mes) {
            $ingresosData[] = round($ingresos[$mes] ?? 0, 2);
            $egresosData[] = round($egresos[$mes] ?? 0, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => $ingresosData,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.08)',
                    'pointBackgroundColor' => '#22c55e',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 7,
                    'pointHoverBackgroundColor' => '#22c55e',
                    'pointHoverBorderColor' => '#fff',
                    'pointHoverBorderWidth' => 2,
                    'borderWidth' => 2.5,
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Egresos',
                    'data' => $egresosData,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.08)',
                    'pointBackgroundColor' => '#ef4444',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 7,
                    'pointHoverBackgroundColor' => '#ef4444',
                    'pointHoverBorderColor' => '#fff',
                    'pointHoverBorderWidth' => 2,
                    'borderWidth' => 2.5,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }
    private function getRango(): array
    {
        return match ($this->filter) {
            'mes_actual' => [
                now()->startOfMonth(),
                now()->endOfMonth(),
                range(now()->month, now()->month),
                [now()->translatedFormat('F')],
            ],
            'ultimos_3' => $this->rangoPorMeses(3),
            'ultimos_6' => $this->rangoPorMeses(6),
            default => [  // este_anio
                now()->startOfYear(),
                now()->endOfYear(),
                range(1, 12),
                ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            ],
        };
    }

    private function rangoPorMeses(int $cantidad): array
    {
        $meses = [];
        $labels = [];
        $nombresMeses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        for ($i = $cantidad - 1; $i >= 0; $i--) {
            $mes = now()->subMonths($i)->month;
            $meses[] = $mes;
            $labels[] = $nombresMeses[$mes - 1];
        }

        return [
            now()->subMonths($cantidad - 1)->startOfMonth(),
            now()->endOfMonth(),
            $meses,
            $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                    'align' => 'end',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                        'padding' => 20,
                        'font' => ['size' => 12, 'weight' => '500'],
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                    'padding' => 12,
                    'backgroundColor' => 'rgba(15, 23, 42, 0.9)',
                    'titleColor' => '#f1f5f9',
                    'bodyColor' => '#cbd5e1',
                    'borderColor' => 'rgba(255,255,255,0.1)',
                    'borderWidth' => 1,
                    'titleFont' => ['size' => 13, 'weight' => 'bold'],
                    'bodyFont' => ['size' => 12],
                    'cornerRadius' => 8,
                    'displayColors' => true,
                    'boxPadding' => 4,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'border' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'font' => ['size' => 12],
                        'color' => 'rgba(156, 163, 175, 0.8)',
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'border' => [
                        'display' => false,
                        'dash' => [4, 4],
                    ],
                    'grid' => [
                        'color' => 'rgba(156, 163, 175, 0.1)',
                    ],
                    'ticks' => [
                        'font' => ['size' => 11],
                        'color' => 'rgba(156, 163, 175, 0.8)',
                        'maxTicksLimit' => 6,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

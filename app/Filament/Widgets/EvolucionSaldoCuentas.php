<?php

namespace App\Filament\Widgets;

use App\Models\Cuenta;
use App\Models\Movimiento;
use App\Models\Transferencia;
use Filament\Widgets\ChartWidget;

class EvolucionSaldoCuentas extends ChartWidget
{
    protected ?string $heading = 'Evolución de Saldos';

    protected ?string $description = 'Variación mensual del saldo por cuenta';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 2;

    public ?string $filter = 'este_anio';

    protected function getFilters(): ?array
    {
        return [
            'este_anio' => 'Este año',
            'ultimos_6' => 'Últimos 6 meses',
            'ultimos_3' => 'Últimos 3 meses',
            'mes_actual' => 'Este mes',
        ];
    }

    protected function getHeight(): ?string
    {
        return '180px';
    }

    protected function getData(): array
    {
        [$mesesRango, $labels] = match ($this->filter) {
            'ultimos_3' => $this->getMesesRango(3),
            'ultimos_6' => $this->getMesesRango(6),
            'mes_actual' => $this->getMesesRango(1),
            default => [
                array_map(fn ($m) => ['mes' => $m, 'anio' => now()->year], range(1, 12)),
                ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            ],
        };

        $cuentas = Cuenta::where('activa', true)->get();
        $colores = ['#3b82f6', '#22c55e', '#f97316', '#8b5cf6', '#ec4899', '#eab308'];
        $datasets = [];

        foreach ($cuentas as $index => $cuenta) {
            $saldoAcumulado = 0;
            $datos = [];

            foreach ($mesesRango as $item) {
                $ingresos = Movimiento::where('cuenta_id', $cuenta->id)
                    ->where('tipo_movimiento', 'ingreso')
                    ->whereYear('fecha', $item['anio'])
                    ->whereMonth('fecha', $item['mes'])
                    ->sum('monto');

                $egresos = Movimiento::where('cuenta_id', $cuenta->id)
                    ->where('tipo_movimiento', 'egreso')
                    ->whereYear('fecha', $item['anio'])
                    ->whereMonth('fecha', $item['mes'])
                    ->sum('monto');

                $recibidas = Transferencia::where('cuenta_destino_id', $cuenta->id)
                    ->whereYear('fecha', $item['anio'])
                    ->whereMonth('fecha', $item['mes'])
                    ->sum('monto');

                $enviadas = Transferencia::where('cuenta_origen_id', $cuenta->id)
                    ->whereYear('fecha', $item['anio'])
                    ->whereMonth('fecha', $item['mes'])
                    ->sum('monto');

                $saldoAcumulado += $ingresos - $egresos + $recibidas - $enviadas;
                $datos[] = round($saldoAcumulado + $cuenta->saldo_inicial, 2);
            }

            $color = $colores[$index % count($colores)];
            $datasets[] = [
                'label' => $cuenta->nombre,
                'data' => $datos,
                'borderColor' => $color,
                'backgroundColor' => $color.'15',
                'pointBackgroundColor' => $color,
                'pointBorderColor' => '#fff',
                'pointBorderWidth' => 2,
                'pointRadius' => 3,
                'pointHoverRadius' => 7,
                'pointHoverBackgroundColor' => $color,
                'pointHoverBorderColor' => '#fff',
                'pointHoverBorderWidth' => 2,
                'borderWidth' => 2.5,
                'fill' => false,
                'tension' => 0.4,
            ];
        }

        return ['datasets' => $datasets, 'labels' => $labels];
    }

    private function getMesesRango(int $cantidad): array
    {
        $meses = [];
        $labels = [];
        $nombres = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        for ($i = $cantidad - 1; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = ['mes' => $fecha->month, 'anio' => $fecha->year];
            $labels[] = $nombres[$fecha->month - 1];
        }

        return [$meses, $labels];
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
                        'color' => 'rgba(156, 163, 175, 0.9)',
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
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
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'border' => ['display' => false],
                    'ticks' => [
                        'font' => ['size' => 12],
                        'color' => 'rgba(156, 163, 175, 0.8)',
                    ],
                ],
                'y' => [
                    'beginAtZero' => false,
                    'border' => ['display' => false],
                    'grid' => ['color' => 'rgba(156, 163, 175, 0.1)'],
                    'ticks' => [
                        'font' => ['size' => 11],
                        'color' => 'rgba(156, 163, 175, 0.8)',
                        'maxTicksLimit' => 6,
                    ],
                ],
            ],
            'layout' => [
                'padding' => [
                    'top' => 4,
                    'bottom' => 2,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

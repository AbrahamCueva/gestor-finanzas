<?php

namespace App\Filament\Widgets;

use App\Models\Cuenta;
use App\Models\Movimiento;
use Filament\Widgets\Widget;

class IndicadorAhorro extends Widget
{
    protected string $view = 'filament.widgets.indicador-ahorro';

    protected ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public string $periodo = 'mes_actual';

    protected function getViewData(): array
    {
        [$fechaInicio, $fechaFin] = match ($this->periodo) {
            'ultimos_3' => [now()->subMonths(2)->startOfMonth(), now()->endOfMonth()],
            'ultimos_6' => [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()],
            'este_anio' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };

        $ingresos = Movimiento::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->where('tipo_movimiento', 'ingreso')->sum('monto');

        $egresos = Movimiento::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->where('tipo_movimiento', 'egreso')->sum('monto');

        $ahorro = $ingresos - $egresos;
        $porcentaje = $ingresos > 0 ? max(0, min(100, round(($ahorro / $ingresos) * 100, 1))) : 0;
        $saldoTotal = Cuenta::sum('saldo_actual');

        return [
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'ahorro' => $ahorro,
            'porcentaje' => $porcentaje,
            'mes' => $fechaInicio->translatedFormat('F Y').($this->periodo !== 'mes_actual' ? ' — '.$fechaFin->translatedFormat('F Y') : ''),
            'saldoTotal' => $saldoTotal,
            'periodo' => $this->periodo,
        ];
    }
}

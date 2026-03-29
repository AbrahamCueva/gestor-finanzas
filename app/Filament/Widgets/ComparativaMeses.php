<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\Widget;

class ComparativaMeses extends Widget
{
    protected string $view = 'filament.widgets.comparativa-meses';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 8;

    protected function getViewData(): array
    {
        $inicioActual   = now()->startOfMonth();
        $finActual      = now()->endOfMonth();
        $inicioAnterior = now()->subMonth()->startOfMonth();
        $finAnterior    = now()->subMonth()->endOfMonth();

        $ingresosActual   = Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$inicioActual, $finActual])->sum('monto');
        $egresosActual    = Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$inicioActual, $finActual])->sum('monto');
        $ingresosAnterior = Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$inicioAnterior, $finAnterior])->sum('monto');
        $egresosAnterior  = Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$inicioAnterior, $finAnterior])->sum('monto');

        $ahorroActual   = $ingresosActual - $egresosActual;
        $ahorroAnterior = $ingresosAnterior - $egresosAnterior;

        return [
            'mesActual'        => ucfirst(now()->translatedFormat('F')),
            'mesAnterior'      => ucfirst(now()->subMonth()->translatedFormat('F')),
            'ingresosActual'   => $ingresosActual,
            'egresosActual'    => $egresosActual,
            'ingresosAnterior' => $ingresosAnterior,
            'egresosAnterior'  => $egresosAnterior,
            'ahorroActual'     => $ahorroActual,
            'ahorroAnterior'   => $ahorroAnterior,
            'diffIngresos'     => $ingresosAnterior > 0 ? round((($ingresosActual - $ingresosAnterior) / $ingresosAnterior) * 100, 1) : 0,
            'diffEgresos'      => $egresosAnterior > 0 ? round((($egresosActual - $egresosAnterior) / $egresosAnterior) * 100, 1) : 0,
            'diffAhorro'       => $ahorroAnterior != 0 ? round((($ahorroActual - $ahorroAnterior) / abs($ahorroAnterior)) * 100, 1) : 0,
        ];
    }
}

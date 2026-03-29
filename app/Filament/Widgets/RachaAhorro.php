<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class RachaAhorro extends Widget
{
    protected string $view = 'filament.widgets.racha-ahorro';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 11;

    protected function getViewData(): array
    {
        $meses = collect();
        $hoy   = Carbon::now();

        for ($i = 11; $i >= 0; $i--) {
            $fecha   = $hoy->copy()->subMonths($i);
            $inicio  = $fecha->copy()->startOfMonth();
            $fin     = $fecha->copy()->endOfMonth();

            $ingresos = Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
            $egresos  = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$inicio, $fin])->sum('monto');

            $ahorro = $ingresos - $egresos;

            $meses->push([
                'label'    => ucfirst($fecha->translatedFormat('M')),
                'anio'     => $fecha->year,
                'mes'      => $fecha->month,
                'ingresos' => $ingresos,
                'egresos'  => $egresos,
                'ahorro'   => $ahorro,
                'positivo' => $ahorro > 0,
                'es_actual' => $i === 0,
            ]);
        }

        $rachaActual = 0;
        foreach ($meses->reverse() as $m) {
            if ($m['positivo']) $rachaActual++;
            else break;
        }

        $rachaMax = 0;
        $rachaTemp = 0;
        foreach ($meses as $m) {
            if ($m['positivo']) {
                $rachaTemp++;
                $rachaMax = max($rachaMax, $rachaTemp);
            } else {
                $rachaTemp = 0;
            }
        }

        $mejorMes = $meses->sortByDesc('ahorro')->first();

        $totalAnio = $meses->where('anio', $hoy->year)->sum('ahorro');

        return [
            'meses'       => $meses,
            'rachaActual' => $rachaActual,
            'rachaMax'    => $rachaMax,
            'mejorMes'    => $mejorMes,
            'totalAnio'   => $totalAnio,
            'mesActual'   => $meses->last(),
        ];
    }
}

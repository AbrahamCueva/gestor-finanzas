<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use App\Models\Cuenta;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Carbon\Carbon;
use UnitEnum;

class AnalisisPredictivo extends Page
{
    protected string $view = 'filament.pages.analisis-predictivo';
    protected static ?string $navigationLabel = 'Análisis Predictivo';
    protected static ?string $title = 'Análisis Predictivo';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 13;

    public function getDatos(): array
    {
        $hoy        = now();
        $inicioMes  = $hoy->copy()->startOfMonth();
        $finMes     = $hoy->copy()->endOfMonth();
        $diasMes    = $finMes->day;
        $diaActual  = $hoy->day;
        $diasRestantes = $diasMes - $diaActual;

        $ingresosMes = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicioMes, $hoy])
            ->sum('monto');

        $egresosMes = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicioMes, $hoy])
            ->sum('monto');

        $promDiarioIngresos = 0;
        $promDiarioEgresos  = 0;

        for ($i = 1; $i <= 3; $i++) {
            $ini = $hoy->copy()->subMonths($i)->startOfMonth();
            $fin = $hoy->copy()->subMonths($i)->endOfMonth();
            $dias = $fin->day;

            $promDiarioIngresos += Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [$ini, $fin])->sum('monto') / $dias;
            $promDiarioEgresos  += Movimiento::where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$ini, $fin])->sum('monto') / $dias;
        }

        $promDiarioIngresos = $promDiarioIngresos / 3;
        $promDiarioEgresos  = $promDiarioEgresos  / 3;

        $ingresosProyectados = $ingresosMes + ($promDiarioIngresos * $diasRestantes);
        $egresosProyectados  = $egresosMes  + ($promDiarioEgresos  * $diasRestantes);
        $ahorroProyectado    = $ingresosProyectados - $egresosProyectados;

        $gastoDiarioActual  = $diaActual > 0 ? $egresosMes / $diaActual : 0;
        $velocidad          = $promDiarioEgresos > 0
            ? round(($gastoDiarioActual / $promDiarioEgresos) * 100, 1)
            : 100;

        $saldoTotal = Cuenta::where('activa', true)->sum('saldo_actual');
        $diasHastaCero = $gastoDiarioActual > 0
            ? floor($saldoTotal / $gastoDiarioActual)
            : 999;

        $fechasCero = $diasHastaCero < 365
            ? now()->addDays($diasHastaCero)->format('d/m/Y')
            : 'Más de 1 año';

        $patronesDia = [];
        $nombresDias = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];

        for ($dia = 1; $dia <= 7; $dia++) {
            $total    = 0;
            $semanas  = 0;

            for ($i = 1; $i <= 12; $i++) {
                $ini = $hoy->copy()->subMonths($i)->startOfMonth();
                $fin = $hoy->copy()->subMonths($i)->endOfMonth();

                $gastosDia = Movimiento::where('tipo_movimiento', 'egreso')
                    ->whereBetween('fecha', [$ini, $fin])
                    ->whereRaw('DAYOFWEEK(fecha) = ?', [$dia == 7 ? 1 : $dia + 1])
                    ->sum('monto');

                $semanasMes = 4;
                $total     += $gastosDia;
                $semanas   += $semanasMes;
            }

            $patronesDia[] = [
                'dia'      => $nombresDias[$dia - 1],
                'promedio' => $semanas > 0 ? round($total / $semanas, 2) : 0,
            ];
        }

        $maxPatron = max(array_column($patronesDia, 'promedio')) ?: 1;

        $mejorMes = null;
        $peorMes  = null;
        $maxGasto = 0;
        $minGasto = PHP_INT_MAX;

        for ($i = 1; $i <= 12; $i++) {
            $ini   = $hoy->copy()->subMonths($i)->startOfMonth();
            $fin   = $hoy->copy()->subMonths($i)->endOfMonth();
            $gasto = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$ini, $fin])->sum('monto');

            if ($gasto > $maxGasto) {
                $maxGasto = $gasto;
                $peorMes  = ['mes' => $ini->translatedFormat('F Y'), 'monto' => $gasto];
            }
            if ($gasto > 0 && $gasto < $minGasto) {
                $minGasto = $gasto;
                $mejorMes = ['mes' => $ini->translatedFormat('F Y'), 'monto' => $gasto];
            }
        }

        $tendencia = [];
        for ($i = 5; $i >= 0; $i--) {
            $ini = $hoy->copy()->subMonths($i)->startOfMonth();
            $fin = $hoy->copy()->subMonths($i)->endOfMonth();
            $ing = Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$ini, $fin])->sum('monto');
            $egr = Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$ini, $fin])->sum('monto');
            $tendencia[] = [
                'mes'    => $ini->translatedFormat('M'),
                'ahorro' => round($ing - $egr, 2),
                'ing'    => round($ing, 2),
                'egr'    => round($egr, 2),
            ];
        }

        $prediccion = match(true) {
            $ahorroProyectado > 0  && $velocidad <= 100 => 'excelente',
            $ahorroProyectado > 0  && $velocidad <= 130 => 'positivo',
            $ahorroProyectado <= 0 && $velocidad <= 150 => 'negativo',
            default                                      => 'critico',
        };

        return [
            'diaActual'            => $diaActual,
            'diasMes'              => $diasMes,
            'diasRestantes'        => $diasRestantes,
            'ingresosMes'          => round($ingresosMes, 2),
            'egresosMes'           => round($egresosMes, 2),
            'ingresosProyectados'  => round($ingresosProyectados, 2),
            'egresosProyectados'   => round($egresosProyectados, 2),
            'ahorroProyectado'     => round($ahorroProyectado, 2),
            'velocidad'            => $velocidad,
            'gastoDiarioActual'    => round($gastoDiarioActual, 2),
            'promDiarioEgresos'    => round($promDiarioEgresos, 2),
            'saldoTotal'           => round($saldoTotal, 2),
            'diasHastaCero'        => $diasHastaCero,
            'fechasCero'           => $fechasCero,
            'patronesDia'          => $patronesDia,
            'maxPatron'            => $maxPatron,
            'mejorMes'             => $mejorMes,
            'peorMes'              => $peorMes,
            'tendencia'            => $tendencia,
            'prediccion'           => $prediccion,
            'mesActual'            => $hoy->translatedFormat('F Y'),
        ];
    }
}

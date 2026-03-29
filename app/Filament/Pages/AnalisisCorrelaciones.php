<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AnalisisCorrelaciones extends Page
{
    protected string $view = 'filament.pages.analisis-correlaciones';

    protected static ?string $navigationLabel = 'Análisis de Correlaciones';

    protected static ?string $title = 'Análisis de Correlaciones';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPresentationChartLine;

    protected static string|UnitEnum|null $navigationGroup = 'Análisis';

    protected static ?int $navigationSort = 15;

    public function getDatos(): array
    {
        return [
            'porDiaSemana' => $this->analizarPorDiaSemana(),
            'porMesAnio' => $this->analizarPorMes(),
            'porHora' => $this->analizarPorHora(),
            'estacionalidad' => $this->analizarEstacionalidad(),
            'patrones' => $this->detectarPatrones(),
        ];
    }

    private function analizarPorDiaSemana(): array
    {
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $resultado = [];

        for ($d = 0; $d <= 6; $d++) {
            $mysqlDia = $d + 1;

            $totalEgreso = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereRaw('DAYOFWEEK(fecha) = ?', [$mysqlDia])
                ->where('fecha', '>=', now()->subMonths(12))
                ->sum('monto');

            $totalIngreso = Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereRaw('DAYOFWEEK(fecha) = ?', [$mysqlDia])
                ->where('fecha', '>=', now()->subMonths(12))
                ->sum('monto');

            $conteo = Movimiento::whereRaw('DAYOFWEEK(fecha) = ?', [$mysqlDia])
                ->where('fecha', '>=', now()->subMonths(12))
                ->count();

            $resultado[] = [
                'dia' => $dias[$d],
                'diaCorto' => substr($dias[$d], 0, 3),
                'totalEgreso' => round($totalEgreso, 2),
                'totalIngreso' => round($totalIngreso, 2),
                'conteo' => $conteo,
                'promedio' => $conteo > 0 ? round($totalEgreso / max($conteo, 1), 2) : 0,
            ];
        }

        return $resultado;
    }

    private function analizarPorMes(): array
    {
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $resultado = [];

        for ($m = 1; $m <= 12; $m++) {
            $totalEgreso = 0;
            $totalIngreso = 0;
            $anios = 0;

            for ($i = 0; $i <= 1; $i++) {
                $anio = now()->year - $i;
                $inicio = Carbon::create($anio, $m, 1)->startOfMonth();
                $fin = Carbon::create($anio, $m, 1)->endOfMonth();

                $egr = Movimiento::where('tipo_movimiento', 'egreso')
                    ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
                $ing = Movimiento::where('tipo_movimiento', 'ingreso')
                    ->whereBetween('fecha', [$inicio, $fin])->sum('monto');

                if ($egr > 0 || $ing > 0) {
                    $totalEgreso += $egr;
                    $totalIngreso += $ing;
                    $anios++;
                }
            }

            $resultado[] = [
                'mes' => $meses[$m - 1],
                'totalEgreso' => $anios > 0 ? round($totalEgreso / $anios, 2) : 0,
                'totalIngreso' => $anios > 0 ? round($totalIngreso / $anios, 2) : 0,
                'ahorro' => $anios > 0 ? round(($totalIngreso - $totalEgreso) / $anios, 2) : 0,
            ];
        }

        return $resultado;
    }

    private function analizarPorHora(): array
    {
        $resultado = [];

        for ($h = 0; $h <= 23; $h++) {
            $total = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereRaw('HOUR(created_at) = ?', [$h])
                ->where('created_at', '>=', now()->subMonths(6))
                ->sum('monto');

            $conteo = Movimiento::whereRaw('HOUR(created_at) = ?', [$h])
                ->where('created_at', '>=', now()->subMonths(6))
                ->count();

            $resultado[] = [
                'hora' => $h,
                'label' => str_pad($h, 2, '0', STR_PAD_LEFT).'h',
                'total' => round($total, 2),
                'conteo' => $conteo,
            ];
        }

        return $resultado;
    }

    private function analizarEstacionalidad(): array
    {
        $trimestres = [
            ['Q1', 1, 3,  '☀️'],
            ['Q2', 4, 6,  '🌦️'],
            ['Q3', 7, 9,  '🧥'],
            ['Q4', 10, 12, '🌤️'],
        ];

        $resultado = [];

        foreach ($trimestres as [$nombre, $mesInicio, $mesFin, $emoji]) {
            $totalEgreso = 0;
            $totalIngreso = 0;

            for ($m = $mesInicio; $m <= $mesFin; $m++) {
                for ($i = 0; $i <= 1; $i++) {
                    $anio = now()->year - $i;
                    $inicio = Carbon::create($anio, $m, 1)->startOfMonth();
                    $fin = Carbon::create($anio, $m, 1)->endOfMonth();

                    $totalEgreso += Movimiento::where('tipo_movimiento', 'egreso')
                        ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
                    $totalIngreso += Movimiento::where('tipo_movimiento', 'ingreso')
                        ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
                }
            }

            $resultado[] = [
                'nombre' => $nombre,
                'emoji' => $emoji,
                'meses' => Carbon::create(null, $mesInicio)->translatedFormat('M').' - '.
                                  Carbon::create(null, $mesFin)->translatedFormat('M'),
                'totalEgreso' => round($totalEgreso / 2, 2),
                'totalIngreso' => round($totalIngreso / 2, 2),
                'ahorro' => round(($totalIngreso - $totalEgreso) / 2, 2),
            ];
        }

        return $resultado;
    }

    private function detectarPatrones(): array
    {
        $patrones = [];

        $porDia = $this->analizarPorDiaSemana();
        $maxDia = collect($porDia)->sortByDesc('totalEgreso')->first();
        if ($maxDia && $maxDia['totalEgreso'] > 0) {
            $patrones[] = [
                'tipo' => 'warning',
                'emoji' => '📅',
                'titulo' => "Los {$maxDia['dia']}s gastas más",
                'desc' => 'En promedio S/ '.number_format($maxDia['promedio'], 2)." por {$maxDia['dia']}. Es tu día de mayor gasto.",
            ];
        }

        $porMes = $this->analizarPorMes();
        $maxMes = collect($porMes)->sortByDesc('totalEgreso')->first();
        if ($maxMes && $maxMes['totalEgreso'] > 0) {
            $patrones[] = [
                'tipo' => 'info',
                'emoji' => '📆',
                'titulo' => "{$maxMes['mes']} es tu mes más costoso",
                'desc' => 'Históricamente gastas S/ '.number_format($maxMes['totalEgreso'], 2)." en promedio en {$maxMes['mes']}.",
            ];
        }

        $ahorros = collect($porMes)->pluck('ahorro')->toArray();
        $mesesPositivos = collect($ahorros)->filter(fn ($a) => $a > 0)->count();
        if ($mesesPositivos >= 8) {
            $patrones[] = [
                'tipo' => 'success',
                'emoji' => '🌟',
                'titulo' => 'Ahorrador consistente',
                'desc' => "Ahorras en {$mesesPositivos} de 12 meses. ¡Excelente disciplina financiera!",
            ];
        } elseif ($mesesPositivos <= 4) {
            $patrones[] = [
                'tipo' => 'danger',
                'emoji' => '⚠️',
                'titulo' => 'Pocos meses con ahorro',
                'desc' => "Solo ahorras en {$mesesPositivos} de 12 meses. Revisa tu distribución de gastos.",
            ];
        }

        $finSemana = collect($porDia)->whereIn('dia', ['Sábado', 'Domingo'])->sum('totalEgreso');
        $semana = collect($porDia)->whereNotIn('dia', ['Sábado', 'Domingo'])->sum('totalEgreso');
        $diasFS = 2;
        $diasS = 5;
        $promFS = $diasFS > 0 ? $finSemana / $diasFS : 0;
        $promS = $diasS > 0 ? $semana / $diasS : 0;

        if ($promFS > $promS * 1.3) {
            $patrones[] = [
                'tipo' => 'warning',
                'emoji' => '🎉',
                'titulo' => 'Gastas más en fin de semana',
                'desc' => 'Tu gasto promedio en fin de semana es '.round(($promFS / max($promS, 1) - 1) * 100).'% mayor que entre semana.',
            ];
        }

        return $patrones;
    }
}

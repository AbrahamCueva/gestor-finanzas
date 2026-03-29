<?php

namespace App\Filament\Pages;

use App\Models\InflacionPeruana;
use App\Models\Movimiento;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class InflacionComparativa extends Page
{
    protected string $view = 'filament.pages.inflacion-comparativa';
    protected static ?string $navigationLabel = 'Inflación vs Gastos';
    protected static ?string $title = 'Comparativa con Inflación Peruana';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowTrendingUp;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';

    public int $anios = 2;

    public function getDatos(): array
    {
        $hoy      = Carbon::now();
        $meses    = $this->anios * 12;
        $datos    = [];
        $nombres  = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        for ($i = $meses - 1; $i >= 0; $i--) {
            $fecha  = $hoy->copy()->subMonths($i);
            $anio   = $fecha->year;
            $mes    = $fecha->month;
            $inicio = $fecha->copy()->startOfMonth();
            $fin    = $fecha->copy()->endOfMonth();

            // Gasto del mes
            $gastoMes = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$inicio, $fin])
                ->sum('monto');

            // Inflación del mes
            $inflacionMensual = InflacionPeruana::getTasaMensual($anio, $mes);
            $inflacionAnual   = InflacionPeruana::where('anio', $anio)
                ->where('mes', $mes)
                ->value('tasa_anual') ?? 2.00;

            $datos[] = [
                'mes'              => $nombres[$mes - 1] . ' ' . substr($anio, 2),
                'mesLabel'         => $nombres[$mes - 1],
                'anio'             => $anio,
                'gasto'            => round($gastoMes, 2),
                'inflacionMensual' => (float) $inflacionMensual,
                'inflacionAnual'   => (float) $inflacionAnual,
            ];
        }

        // Calcular variación de gastos mes a mes
        for ($i = 1; $i < count($datos); $i++) {
            $anterior = $datos[$i - 1]['gasto'];
            $actual   = $datos[$i]['gasto'];
            $datos[$i]['variacionGasto'] = $anterior > 0
                ? round((($actual - $anterior) / $anterior) * 100, 2)
                : 0;
        }
        $datos[0]['variacionGasto'] = 0;

        // Análisis comparativo
        $analisis = $this->analizarComparativa($datos);

        // Poder adquisitivo — si gastos suben más que inflación = perdiste poder
        $primerGasto = $datos[0]['gasto'] ?: 1;
        $ultimoGasto = end($datos)['gasto'];
        $inflacionAcumulada = 0;
        foreach ($datos as $d) {
            $inflacionAcumulada += $d['inflacionMensual'];
        }
        $gastoAjustado = $primerGasto * (1 + $inflacionAcumulada / 100);
        $diferenciaPoder = round($ultimoGasto - $gastoAjustado, 2);

        return [
            'datos'              => $datos,
            'analisis'           => $analisis,
            'inflacionAcumulada' => round($inflacionAcumulada, 2),
            'ultimaInflacion'    => InflacionPeruana::getUltimaTasa(),
            'diferenciaPoder'    => $diferenciaPoder,
            'gastoAjustado'      => round($gastoAjustado, 2),
            'primerGasto'        => round($primerGasto, 2),
            'ultimoGasto'        => round($ultimoGasto, 2),
        ];
    }

    private function analizarComparativa(array $datos): array
    {
        $mesesSuperanInflacion = 0;
        $mesesBajoInflacion    = 0;

        foreach ($datos as $d) {
            if ($d['variacionGasto'] > $d['inflacionMensual']) {
                $mesesSuperanInflacion++;
            } elseif ($d['variacionGasto'] < $d['inflacionMensual']) {
                $mesesBajoInflacion++;
            }
        }

        $total = count($datos);

        return [
            'mesesSuperan' => $mesesSuperanInflacion,
            'mesesBajo'    => $mesesBajoInflacion,
            'pctSuperan'   => $total > 0 ? round(($mesesSuperanInflacion / $total) * 100) : 0,
            'estado'       => $mesesSuperanInflacion > $mesesBajoInflacion ? 'critico' : 'bueno',
        ];
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use App\Models\Categoria;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class PrediccionCategorias extends Page
{
    protected string $view = 'filament.pages.prediccion-categorias';
    protected static ?string $navigationLabel = 'Predicción de Categorías';
    protected static ?string $title = 'Predicción de Gastos por Categoría';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 26;

    public int $mesesHistorial = 3;

    public function getDatos(): array
    {
        $categorias = Categoria::where('tipo', 'egreso')
            ->where('activa', true)
            ->get();

        $predicciones = [];
        $gastoActualMes = 0;
        $gastoPredTotal = 0;

        foreach ($categorias as $cat) {
            $historial = [];

            for ($i = $this->mesesHistorial; $i >= 1; $i--) {
                $ini = now()->subMonths($i)->startOfMonth();
                $fin = now()->subMonths($i)->endOfMonth();
                $gasto = Movimiento::where('tipo_movimiento', 'egreso')
                    ->where('categoria_id', $cat->id)
                    ->whereBetween('fecha', [$ini, $fin])
                    ->sum('monto');
                $historial[] = round($gasto, 2);
            }

            // Gasto actual del mes en curso
            $gastoMesActual = Movimiento::where('tipo_movimiento', 'egreso')
                ->where('categoria_id', $cat->id)
                ->whereBetween('fecha', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('monto');

            $conDatos = array_filter($historial, fn($v) => $v > 0);
            if (empty($conDatos) && $gastoMesActual == 0)
                continue;

            // Predicción con regresión lineal simple
            $prediccion = $this->predecirConRegresion($historial);

            // Ajustar por días transcurridos del mes actual
            $diaActual = now()->day;
            $diasMes = now()->daysInMonth;
            $proyeccion = $diaActual > 0 && $gastoMesActual > 0
                ? round(($gastoMesActual / $diaActual) * $diasMes, 2)
                : $prediccion;

            // Combinar predicción histórica con proyección actual (70/30)
            $prediccionFinal = $gastoMesActual > 0
                ? round($prediccion * 0.3 + $proyeccion * 0.7, 2)
                : $prediccion;

            if ($prediccionFinal <= 0 && $gastoMesActual <= 0)
                continue;

            $promedio = count($conDatos) > 0 ? round(array_sum($conDatos) / count($conDatos), 2) : 0;
            $tendencia = $this->calcularTendencia($historial);

            $gastoActualMes += $gastoMesActual;
            $gastoPredTotal += $prediccionFinal;

            $predicciones[] = [
                'id' => $cat->id,
                'nombre' => $cat->nombre,
                'color' => $cat->color ?? '#6b7280',
                'historial' => $historial,
                'gastoActual' => round($gastoMesActual, 2),
                'promedio' => $promedio,
                'prediccion' => $prediccionFinal,
                'tendencia' => $tendencia,
                'diferencia' => round($prediccionFinal - $promedio, 2),
                'pctDiferencia' => $promedio > 0
                    ? round((($prediccionFinal - $promedio) / $promedio) * 100, 1)
                    : 0,
                'confianza' => count($conDatos) >= 3 ? 'alta' : (count($conDatos) >= 2 ? 'media' : 'baja'),
                'diasRestantes' => now()->daysInMonth - now()->day,
                'gastoDiario' => $diaActual > 0 ? round($gastoMesActual / $diaActual, 2) : 0,
            ];
        }

        // Ordenar por predicción descendente
        usort($predicciones, fn($a, $b) => $b['prediccion'] <=> $a['prediccion']);

        // Alertas
        $alertas = collect($predicciones)
            ->filter(fn($p) => $p['pctDiferencia'] > 20 && $p['tendencia'] === 'subiendo')
            ->values()
            ->toArray();

        return [
            'predicciones' => $predicciones,
            'gastoActualMes' => round($gastoActualMes, 2),
            'gastoPredTotal' => round($gastoPredTotal, 2),
            'alertas' => $alertas,
            'mesActual' => now()->translatedFormat('F Y'),
            'diaActual' => now()->day,
            'diasMes' => now()->daysInMonth,
        ];
    }

    private function predecirConRegresion(array $historial): float
    {
        $n = count($historial);
        if ($n === 0)
            return 0;
        if ($n === 1)
            return $historial[0];

        // Regresión lineal: y = a + bx
        $sumX = 0;
        $sumY = 0;
        $sumXY = 0;
        $sumX2 = 0;

        foreach ($historial as $i => $y) {
            $x = $i + 1;
            $sumX += $x;
            $sumY += $y;
            $sumXY += $x * $y;
            $sumX2 += $x * $x;
        }

        $denom = ($n * $sumX2 - $sumX * $sumX);
        if ($denom == 0)
            return round($sumY / $n, 2);

        $b = ($n * $sumXY - $sumX * $sumY) / $denom;
        $a = ($sumY - $b * $sumX) / $n;

        $prediccion = $a + $b * ($n + 1);
        return max(0, round($prediccion, 2));
    }

    private function calcularTendencia(array $historial): string
    {
        $n = count($historial);
        if ($n < 2)
            return 'estable';

        $primera = array_slice($historial, 0, (int) ceil($n / 2));
        $segunda = array_slice($historial, (int) ceil($n / 2));

        $promPrimera = count($primera) > 0 ? array_sum($primera) / count($primera) : 0;
        $promSegunda = count($segunda) > 0 ? array_sum($segunda) / count($segunda) : 0;

        if ($promPrimera == 0)
            return 'estable';

        $cambio = (($promSegunda - $promPrimera) / $promPrimera) * 100;

        return match (true) {
            $cambio > 10 => 'subiendo',
            $cambio < -10 => 'bajando',
            default => 'estable',
        };
    }
}
<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use App\Models\Categoria;
use App\Models\Presupuesto;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class PuntoEquilibrio extends Page
{
    protected string $view = 'filament.pages.punto-equilibrio';
    protected static ?string $navigationLabel = 'Punto de Equilibrio';
    protected static ?string $title = 'Punto de Equilibrio Personal';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 20;

    public function getDatos(): array
    {
        // Promediar últimos 3 meses
        $gastosFijos     = [];
        $gastosVariables = [];

        // Palabras clave de gastos fijos
        $kwFijos = [
            'alquiler',
            'arriendo',
            'internet',
            'luz',
            'agua',
            'gas',
            'telefonía',
            'cable',
            'streaming',
            'suscripci',
            'seguro',
            'instituto',
            'matrícula',
            'mensualidad',
            'servicios'
        ];

        $categorias = Categoria::where('tipo', 'egreso')->where('activa', true)->get();

        foreach ($categorias as $cat) {
            $promedioMensual = 0;
            $mesesConDatos   = 0;

            for ($i = 1; $i <= 3; $i++) {
                $ini    = now()->subMonths($i)->startOfMonth();
                $fin    = now()->subMonths($i)->endOfMonth();
                $gasto  = Movimiento::where('tipo_movimiento', 'egreso')
                    ->where('categoria_id', $cat->id)
                    ->whereBetween('fecha', [$ini, $fin])
                    ->sum('monto');

                if ($gasto > 0) {
                    $promedioMensual += $gasto;
                    $mesesConDatos++;
                }
            }

            if ($mesesConDatos === 0) continue;
            $promedioMensual = round($promedioMensual / $mesesConDatos, 2);

            $nombre   = strtolower($cat->nombre);
            $esFijo   = false;
            foreach ($kwFijos as $kw) {
                if (str_contains($nombre, $kw)) {
                    $esFijo = true;
                    break;
                }
            }

            $item = [
                'id'       => $cat->id,
                'nombre'   => $cat->nombre,
                'monto'    => $promedioMensual,
                'color'    => $cat->color ?? '#6b7280',
            ];

            if ($esFijo) $gastosFijos[]     = $item;
            else         $gastosVariables[] = $item;
        }

        $totalFijos     = array_sum(array_column($gastosFijos, 'monto'));
        $totalVariables = array_sum(array_column($gastosVariables, 'monto'));
        $totalGastos    = $totalFijos + $totalVariables;

        // Ingresos promedio últimos 3 meses
        $ingresosProm = 0;
        for ($i = 1; $i <= 3; $i++) {
            $ini = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();
            $ingresosProm += Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [$ini, $fin])->sum('monto');
        }
        $ingresosProm = round($ingresosProm / 3, 2);

        // Punto de equilibrio = gastos fijos + variables mínimos (60% variables)
        $minimoVariables    = round($totalVariables * 0.6, 2);
        $puntoEquilibrio    = round($totalFijos + $minimoVariables, 2);
        $margenSeguridad    = round($ingresosProm - $totalGastos, 2);
        $ingresoIdeal       = round($totalGastos * 1.2, 2); // 20% de ahorro
        $pctCubierto        = $ingresosProm > 0
            ? min(100, round(($ingresosProm / $totalGastos) * 100, 1))
            : 0;

        $estado = match (true) {
            $ingresosProm >= $ingresoIdeal  => 'excelente',
            $ingresosProm >= $totalGastos   => 'estable',
            $ingresosProm >= $puntoEquilibrio => 'ajustado',
            default                          => 'deficit',
        };

        // Cuántos días de trabajo necesitas al mes (asumiendo ingreso diario)
        $ingresoDiario = $ingresosProm > 0 ? round($ingresosProm / 22, 2) : 0; // 22 días laborables
        $diasParaFijos = $ingresoDiario > 0 ? ceil($totalFijos / $ingresoDiario) : 0;
        $diasParaTodo  = $ingresoDiario > 0 ? ceil($totalGastos / $ingresoDiario) : 0;

        return [
            'gastosFijos'       => $gastosFijos,
            'gastosVariables'   => $gastosVariables,
            'totalFijos'        => $totalFijos,
            'totalVariables'    => $totalVariables,
            'totalGastos'       => $totalGastos,
            'ingresosProm'      => $ingresosProm,
            'puntoEquilibrio'   => $puntoEquilibrio,
            'margenSeguridad'   => $margenSeguridad,
            'ingresoIdeal'      => $ingresoIdeal,
            'pctCubierto'       => $pctCubierto,
            'estado'            => $estado,
            'ingresoDiario'     => $ingresoDiario,
            'diasParaFijos'     => $diasParaFijos,
            'diasParaTodo'      => $diasParaTodo,
            'minimoVariables'   => $minimoVariables,
        ];
    }
}

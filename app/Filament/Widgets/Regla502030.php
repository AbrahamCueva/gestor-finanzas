<?php

namespace App\Filament\Widgets;

use App\Models\Categoria;
use App\Models\Movimiento;
use Filament\Widgets\Widget;

class Regla502030 extends Widget
{
    protected string $view = 'filament.widgets.regla-502030';
    protected static ?int $sort = 13;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $pollingInterval = null;

    public string $filtro = 'mes_actual';

    public function getFiltros(): array
    {
        return [
            'mes_actual'  => 'Este mes',
            'ultimo_mes'  => 'Mes anterior',
            'ultimos_3'   => 'Últimos 3 meses',
            'este_anio'   => 'Este año',
        ];
    }

    public function getDatos(): array
    {
        [$inicio, $fin] = match($this->filtro) {
            'ultimo_mes' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
            'ultimos_3'  => [now()->subMonths(3)->startOfMonth(), now()->endOfMonth()],
            'este_anio'  => [now()->startOfYear(), now()->endOfYear()],
            default      => [now()->startOfMonth(), now()->endOfMonth()],
        };

        $totalIngresos = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicio, $fin])
            ->sum('monto');

        $totalEgresos = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicio, $fin])
            ->sum('monto');

        $gastosPorCategoria = Movimiento::selectRaw('categoria_id, SUM(monto) as total')
            ->where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('categoria_id')
            ->with('categoria')
            ->get();

        $necesidades = 0;
        $deseos      = 0;

        $keywordsNecesidades = ['alimenta', 'transport', 'salud', 'servicio', 'arriendo', 'alquiler', 'educaci', 'médic', 'farmac', 'supermercado', 'agua', 'luz', 'internet'];
        $keywordsDeseos      = ['entretenimiento', 'restaurant', 'ropa', 'viaje', 'ocio', 'deporte', 'suscripci', 'juego', 'cine', 'moda'];

        foreach ($gastosPorCategoria as $gasto) {
            $nombre = strtolower($gasto->categoria?->nombre ?? '');
            $esNecesidad = false;
            $esDeseo     = false;

            foreach ($keywordsNecesidades as $kw) {
                if (str_contains($nombre, $kw)) { $esNecesidad = true; break; }
            }
            foreach ($keywordsDeseos as $kw) {
                if (str_contains($nombre, $kw)) { $esDeseo = true; break; }
            }

            if ($esNecesidad)      $necesidades += $gasto->total;
            elseif ($esDeseo)      $deseos      += $gasto->total;
            else                   $necesidades += $gasto->total; // default a necesidades
        }

        $ahorro = max(0, $totalIngresos - $totalEgresos);

        $pctNecesidades = $totalIngresos > 0 ? round(($necesidades / $totalIngresos) * 100, 1) : 0;
        $pctDeseos      = $totalIngresos > 0 ? round(($deseos      / $totalIngresos) * 100, 1) : 0;
        $pctAhorro      = $totalIngresos > 0 ? round(($ahorro      / $totalIngresos) * 100, 1) : 0;

        $idealNecesidades = $totalIngresos * 0.50;
        $idealDeseos      = $totalIngresos * 0.30;
        $idealAhorro      = $totalIngresos * 0.20;

        $estadoNecesidades = $pctNecesidades <= 50  ? 'ok' : ($pctNecesidades <= 60  ? 'warning' : 'danger');
        $estadoDeseos      = $pctDeseos      <= 30  ? 'ok' : ($pctDeseos      <= 40  ? 'warning' : 'danger');
        $estadoAhorro      = $pctAhorro      >= 20  ? 'ok' : ($pctAhorro      >= 10  ? 'warning' : 'danger');

        $puntaje = 0;
        if ($estadoNecesidades === 'ok') $puntaje += 34;
        elseif ($estadoNecesidades === 'warning') $puntaje += 17;
        if ($estadoDeseos === 'ok') $puntaje += 33;
        elseif ($estadoDeseos === 'warning') $puntaje += 16;
        if ($estadoAhorro === 'ok') $puntaje += 33;
        elseif ($estadoAhorro === 'warning') $puntaje += 16;

        return [
            'totalIngresos'     => $totalIngresos,
            'totalEgresos'      => $totalEgresos,
            'necesidades'       => $necesidades,
            'deseos'            => $deseos,
            'ahorro'            => $ahorro,
            'pctNecesidades'    => $pctNecesidades,
            'pctDeseos'         => $pctDeseos,
            'pctAhorro'         => $pctAhorro,
            'idealNecesidades'  => $idealNecesidades,
            'idealDeseos'       => $idealDeseos,
            'idealAhorro'       => $idealAhorro,
            'estadoNecesidades' => $estadoNecesidades,
            'estadoDeseos'      => $estadoDeseos,
            'estadoAhorro'      => $estadoAhorro,
            'puntaje'           => $puntaje,
        ];
    }
}

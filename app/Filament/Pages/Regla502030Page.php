<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Regla502030Page extends Page
{
    protected string $view = 'filament.pages.regla502030-page';
    protected static ?string $navigationLabel = 'Regla 50/30/20';
    protected static ?string $title = 'Regla 50/30/20';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartPie;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 10;

    public function getHistorial(): array
    {
        $historial = [];

        for ($i = 5; $i >= 0; $i--) {
            $inicio = now()->subMonths($i)->startOfMonth();
            $fin    = now()->subMonths($i)->endOfMonth();

            $totalIngresos = Movimiento::where('tipo_movimiento', 'ingreso')
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

            $kwNecesidades = ['alimenta', 'transport', 'salud', 'servicio', 'arriendo', 'alquiler', 'educaci', 'médic', 'farmac', 'supermercado', 'agua', 'luz', 'internet'];
            $kwDeseos      = ['entretenimiento', 'restaurant', 'ropa', 'viaje', 'ocio', 'deporte', 'suscripci', 'juego', 'cine', 'moda'];

            foreach ($gastosPorCategoria as $gasto) {
                $nombre = strtolower($gasto->categoria?->nombre ?? '');
                $esNec  = false;
                foreach ($kwNecesidades as $kw) { if (str_contains($nombre, $kw)) { $esNec = true; break; } }
                $esDes  = false;
                foreach ($kwDeseos as $kw) { if (str_contains($nombre, $kw)) { $esDes = true; break; } }

                if ($esNec)      $necesidades += $gasto->total;
                elseif ($esDes)  $deseos      += $gasto->total;
                else             $necesidades += $gasto->total;
            }

            $ahorro = max(0, $totalIngresos - ($necesidades + $deseos));

            $pctNec = $totalIngresos > 0 ? round(($necesidades / $totalIngresos) * 100, 1) : 0;
            $pctDes = $totalIngresos > 0 ? round(($deseos      / $totalIngresos) * 100, 1) : 0;
            $pctAho = $totalIngresos > 0 ? round(($ahorro      / $totalIngresos) * 100, 1) : 0;

            $puntaje = 0;
            if ($pctNec <= 50) $puntaje += 34; elseif ($pctNec <= 60) $puntaje += 17;
            if ($pctDes <= 30) $puntaje += 33; elseif ($pctDes <= 40) $puntaje += 16;
            if ($pctAho >= 20) $puntaje += 33; elseif ($pctAho >= 10) $puntaje += 16;

            $historial[] = [
                'mes'          => $inicio->translatedFormat('M Y'),
                'mesCorto'     => $inicio->translatedFormat('M'),
                'ingresos'     => round($totalIngresos, 2),
                'necesidades'  => round($necesidades, 2),
                'deseos'       => round($deseos, 2),
                'ahorro'       => round($ahorro, 2),
                'pctNec'       => $pctNec,
                'pctDes'       => $pctDes,
                'pctAho'       => $pctAho,
                'puntaje'      => $puntaje,
                'estadoNec'    => $pctNec <= 50 ? 'ok' : ($pctNec <= 60 ? 'warning' : 'danger'),
                'estadoDes'    => $pctDes <= 30 ? 'ok' : ($pctDes <= 40 ? 'warning' : 'danger'),
                'estadoAho'    => $pctAho >= 20 ? 'ok' : ($pctAho >= 10 ? 'warning' : 'danger'),
            ];
        }

        return $historial;
    }

    public function getPromedios(array $historial): array
    {
        $mesesConDatos = array_filter($historial, fn ($m) => $m['ingresos'] > 0);
        $count = count($mesesConDatos);
        if ($count === 0) return ['pctNec' => 0, 'pctDes' => 0, 'pctAho' => 0, 'puntaje' => 0];

        return [
            'pctNec'  => round(array_sum(array_column($mesesConDatos, 'pctNec'))  / $count, 1),
            'pctDes'  => round(array_sum(array_column($mesesConDatos, 'pctDes'))  / $count, 1),
            'pctAho'  => round(array_sum(array_column($mesesConDatos, 'pctAho'))  / $count, 1),
            'puntaje' => round(array_sum(array_column($mesesConDatos, 'puntaje')) / $count),
        ];
    }
}
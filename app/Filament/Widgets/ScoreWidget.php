<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use App\Models\Presupuesto;
use App\Models\Meta;
use App\Models\Deuda;
use App\Models\Cuenta;
use Filament\Widgets\Widget;

class ScoreWidget extends Widget
{
    protected string $view = 'filament.widgets.score-widget';
    protected static ?int   $sort = 14;
    protected int | string | array $columnSpan = 'full';
    protected ?string $pollingInterval = null;

    public function getScore(): array
    {
        $puntos = 0;
        for ($i = 0; $i < 3; $i++) {
            $ini = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();
            $ing = Movimiento::where('tipo_movimiento','ingreso')->whereBetween('fecha',[$ini,$fin])->sum('monto');
            $egr = Movimiento::where('tipo_movimiento','egreso')->whereBetween('fecha',[$ini,$fin])->sum('monto');
            if ($ing <= 0) continue;
            $pct = (($ing - $egr) / $ing) * 100;
            if ($pct >= 20) $puntos += 10;
            elseif ($pct >= 10) $puntos += 6;
            elseif ($pct >= 0)  $puntos += 2;
        }

        $pres = Presupuesto::where('activo',true)->get();
        if ($pres->isNotEmpty()) {
            $resp = $pres->filter(fn($p) => !$p->superado())->count();
            $puntos += round(($resp / $pres->count()) * 20);
        } else {
            $puntos += 0;
        }

        $deudas   = Deuda::where('estado','!=','pagada')->get();
        $vencidas = $deudas->filter(fn($d) => $d->estaVencida())->count();
        $puntos  += $vencidas === 0 ? 20 : max(0, 20 - ($vencidas * 5));

        $metas = Meta::all();
        if ($metas->isNotEmpty()) {
            $comp   = $metas->where('completada',true)->count();
            $puntos += min(15, ($comp * 5) + ($metas->where('completada',false)->count() > 0 ? 5 : 0));
        }

        $activos = 0;
        for ($i = 0; $i < 6; $i++) {
            $ini = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();
            if (Movimiento::whereBetween('fecha',[$ini,$fin])->count() >= 5) $activos++;
        }
        $puntos += round(($activos / 6) * 10);

        $cuentas = Cuenta::where('activa',true)->count();
        $puntos += $cuentas >= 3 ? 5 : ($cuentas >= 2 ? 3 : 1);

        $puntaje = min(100, $puntos);

        return [
            'puntaje' => $puntaje,
            'nivel'   => match(true) {
                $puntaje >= 90 => ['nombre' => 'Maestro Financiero', 'emoji' => '👑', 'color' => '#fbbf24'],
                $puntaje >= 75 => ['nombre' => 'Experto',            'emoji' => '💎', 'color' => '#60a5fa'],
                $puntaje >= 60 => ['nombre' => 'Avanzado',           'emoji' => '🔥', 'color' => '#f97316'],
                $puntaje >= 40 => ['nombre' => 'En desarrollo',      'emoji' => '📈', 'color' => '#a78bfa'],
                $puntaje >= 20 => ['nombre' => 'Principiante',       'emoji' => '🌱', 'color' => '#22c55e'],
                default        => ['nombre' => 'Sin datos',           'emoji' => '📊', 'color' => '#6b7280'],
            },
        ];
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\Cuenta;
use App\Models\Deuda;
use App\Models\Meta;
use App\Models\Movimiento;
use App\Models\Presupuesto;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ScoreFinanciero extends Page
{
    protected string $view = 'filament.pages.score-financiero';

    protected static ?string $navigationLabel = 'Score Financiero';

    protected static ?string $title = 'Score Financiero';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static string|UnitEnum|null $navigationGroup = 'Análisis';

    protected static ?int $navigationSort = 16;

    public function getDatos(): array
    {
        $categorias = [
            'ahorro' => $this->calcularAhorro(),
            'presupuestos' => $this->calcularPresupuestos(),
            'deudas' => $this->calcularDeudas(),
            'metas' => $this->calcularMetas(),
            'consistencia' => $this->calcularConsistencia(),
            'diversificacion' => $this->calcularDiversificacion(),
        ];

        $scoreTotal = collect($categorias)->sum('score');
        $maxTotal = collect($categorias)->sum('max');
        $puntaje = $maxTotal > 0 ? round(($scoreTotal / $maxTotal) * 100) : 0;

        $nivel = match (true) {
            $puntaje >= 90 => ['nombre' => 'Maestro Financiero', 'emoji' => '👑', 'color' => '#fbbf24', 'desc' => 'Gestión financiera excepcional'],
            $puntaje >= 75 => ['nombre' => 'Experto',            'emoji' => '💎', 'color' => '#60a5fa', 'desc' => 'Muy buena salud financiera'],
            $puntaje >= 60 => ['nombre' => 'Avanzado',           'emoji' => '🔥', 'color' => '#f97316', 'desc' => 'Buena gestión con áreas a mejorar'],
            $puntaje >= 40 => ['nombre' => 'En desarrollo',      'emoji' => '📈', 'color' => '#a78bfa', 'desc' => 'Progresando bien, sigue mejorando'],
            $puntaje >= 20 => ['nombre' => 'Principiante',       'emoji' => '🌱', 'color' => '#22c55e', 'desc' => 'Recién empezando, hay mucho por mejorar'],
            default => ['nombre' => 'Sin datos',           'emoji' => '📊', 'color' => '#6b7280', 'desc' => 'Registra más movimientos para obtener tu score'],
        };

        return [
            'puntaje' => $puntaje,
            'nivel' => $nivel,
            'categorias' => $categorias,
            'scoreTotal' => $scoreTotal,
            'maxTotal' => $maxTotal,
        ];
    }

    private function calcularAhorro(): array
    {
        $meses = 3;
        $puntos = 0;
        $max = 30;
        $detalles = [];

        for ($i = 0; $i < $meses; $i++) {
            $inicio = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();

            $ing = Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$inicio, $fin])->sum('monto');
            $egr = Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$inicio, $fin])->sum('monto');

            if ($ing <= 0) {
                continue;
            }

            $pctAhorro = (($ing - $egr) / $ing) * 100;

            if ($pctAhorro >= 20) {
                $puntos += 10;
                $detalles[] = ['mes' => $inicio->translatedFormat('M'), 'pct' => round($pctAhorro, 1), 'estado' => 'ok'];
            } elseif ($pctAhorro >= 10) {
                $puntos += 6;
                $detalles[] = ['mes' => $inicio->translatedFormat('M'), 'pct' => round($pctAhorro, 1), 'estado' => 'warning'];
            } elseif ($pctAhorro >= 0) {
                $puntos += 2;
                $detalles[] = ['mes' => $inicio->translatedFormat('M'), 'pct' => round($pctAhorro, 1), 'estado' => 'low'];
            } else {
                $puntos += 0;
                $detalles[] = ['mes' => $inicio->translatedFormat('M'), 'pct' => round($pctAhorro, 1), 'estado' => 'danger'];
            }
        }

        return [
            'nombre' => 'Tasa de Ahorro',
            'emoji' => '💰',
            'score' => $puntos,
            'max' => $max,
            'pct' => round(($puntos / $max) * 100),
            'detalles' => $detalles,
            'descripcion' => 'Basado en los últimos 3 meses. Meta: ahorrar ≥20% de ingresos.',
            'recomendacion' => $puntos < 20 ? 'Intenta reducir gastos no esenciales para aumentar tu tasa de ahorro.' : null,
        ];
    }

    private function calcularPresupuestos(): array
    {
        $presupuestos = Presupuesto::where('activo', true)->get();
        $max = 20;

        if ($presupuestos->isEmpty()) {
            return [
                'nombre' => 'Presupuestos', 'emoji' => '🎯',
                'score' => 0, 'max' => $max, 'pct' => 0,
                'detalles' => [],
                'descripcion' => 'No tienes presupuestos activos.',
                'recomendacion' => 'Crea presupuestos por categoría para controlar mejor tus gastos.',
            ];
        }

        $respetados = 0;
        $detalles = [];

        foreach ($presupuestos as $p) {
            $superado = $p->superado();
            if (! $superado) {
                $respetados++;
            }
            $detalles[] = [
                'nombre' => $p->categoria?->nombre,
                'pct' => $p->porcentaje(),
                'estado' => $superado ? 'danger' : ($p->porcentaje() >= 80 ? 'warning' : 'ok'),
            ];
        }

        $pct = round(($respetados / $presupuestos->count()) * 100);
        $puntos = round(($pct / 100) * $max);

        return [
            'nombre' => 'Presupuestos',
            'emoji' => '🎯',
            'score' => $puntos,
            'max' => $max,
            'pct' => $pct,
            'detalles' => $detalles,
            'descripcion' => "{$respetados} de {$presupuestos->count()} presupuestos respetados este mes.",
            'recomendacion' => $puntos < 15 ? 'Revisa los presupuestos superados y ajusta tus gastos.' : null,
        ];
    }

    private function calcularDeudas(): array
    {
        $deudas = Deuda::where('estado', '!=', 'pagada')->get();
        $max = 20;

        if ($deudas->isEmpty()) {
            return [
                'nombre' => 'Gestión de Deudas', 'emoji' => '💳',
                'score' => $max, 'max' => $max, 'pct' => 100,
                'detalles' => [],
                'descripcion' => '¡Sin deudas pendientes! Puntuación máxima.',
                'recomendacion' => null,
            ];
        }

        $vencidas = $deudas->filter(fn ($d) => $d->estaVencida())->count();
        $total = $deudas->count();
        $alDia = $total - $vencidas;
        $puntos = $vencidas === 0 ? $max : max(0, round($max * ($alDia / $total)));

        $detalles = $deudas->map(fn ($d) => [
            'nombre' => $d->nombre,
            'tipo' => $d->tipo,
            'estado' => $d->estaVencida() ? 'danger' : 'ok',
            'monto' => $d->restante(),
        ])->toArray();

        return [
            'nombre' => 'Gestión de Deudas',
            'emoji' => '💳',
            'score' => $puntos,
            'max' => $max,
            'pct' => round(($puntos / $max) * 100),
            'detalles' => $detalles,
            'descripcion' => "{$vencidas} deuda(s) vencida(s) de {$total} total.",
            'recomendacion' => $vencidas > 0 ? 'Prioriza el pago de deudas vencidas para mejorar tu score.' : null,
        ];
    }

    private function calcularMetas(): array
    {
        $metas = Meta::all();
        $max = 15;

        if ($metas->isEmpty()) {
            return [
                'nombre' => 'Metas de Ahorro', 'emoji' => '🏆',
                'score' => 0, 'max' => $max, 'pct' => 0,
                'detalles' => [],
                'descripcion' => 'No tienes metas de ahorro.',
                'recomendacion' => 'Crea al menos una meta de ahorro para mejorar tu score.',
            ];
        }

        $completadas = $metas->where('completada', true)->count();
        $enProgreso = $metas->where('completada', false)->count();
        $puntos = min($max, ($completadas * 5) + ($enProgreso > 0 ? 5 : 0));

        $detalles = $metas->map(fn ($m) => [
            'nombre' => $m->nombre,
            'pct' => $m->porcentaje(),
            'estado' => $m->completada ? 'ok' : ($m->porcentaje() >= 50 ? 'warning' : 'low'),
        ])->toArray();

        return [
            'nombre' => 'Metas de Ahorro',
            'emoji' => '🏆',
            'score' => $puntos,
            'max' => $max,
            'pct' => round(($puntos / $max) * 100),
            'detalles' => $detalles,
            'descripcion' => "{$completadas} meta(s) completada(s), {$enProgreso} en progreso.",
            'recomendacion' => $completadas === 0 ? 'Trabaja en completar tus metas de ahorro.' : null,
        ];
    }

    private function calcularConsistencia(): array
    {
        $max = 10;
        $mesesActivos = 0;

        for ($i = 0; $i < 6; $i++) {
            $inicio = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();
            $count = Movimiento::whereBetween('fecha', [$inicio, $fin])->count();
            if ($count >= 5) {
                $mesesActivos++;
            }
        }

        $puntos = round(($mesesActivos / 6) * $max);

        return [
            'nombre' => 'Consistencia',
            'emoji' => '📅',
            'score' => $puntos,
            'max' => $max,
            'pct' => round(($mesesActivos / 6) * 100),
            'detalles' => [],
            'descripcion' => "Activo en {$mesesActivos} de los últimos 6 meses (≥5 movimientos/mes).",
            'recomendacion' => $mesesActivos < 4 ? 'Registra tus movimientos de forma más constante.' : null,
        ];
    }

    private function calcularDiversificacion(): array
    {
        $max = 5;
        $cuentas = Cuenta::where('activa', true)->count();
        $puntos = min($max, $cuentas >= 3 ? 5 : ($cuentas >= 2 ? 3 : 1));

        return [
            'nombre' => 'Diversificación',
            'emoji' => '🏦',
            'score' => $puntos,
            'max' => $max,
            'pct' => round(($puntos / $max) * 100),
            'detalles' => [],
            'descripcion' => "Tienes {$cuentas} cuenta(s) activa(s).",
            'recomendacion' => $cuentas < 2 ? 'Diversifica tu dinero en múltiples cuentas o instrumentos.' : null,
        ];
    }
}

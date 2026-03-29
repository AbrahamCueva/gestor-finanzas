<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\Movimiento;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class GastosInusualesService
{
    const UMBRAL_PORCENTAJE = 50;

    public function analizar(): array
    {
        $user = auth()->user() ?? \App\Models\User::first();
        $alertas = [];
        $cacheKey = 'gastos_inusuales_'.now()->format('Y_m');

        if (Cache::has($cacheKey)) {
            return [];
        }

        $categorias = Categoria::where('tipo', 'egreso')->where('activa', true)->get();

        foreach ($categorias as $categoria) {
            $promedioHistorico = 0;
            $mesesConDatos = 0;

            for ($i = 1; $i <= 3; $i++) {
                $inicio = now()->subMonths($i)->startOfMonth();
                $fin = now()->subMonths($i)->endOfMonth();
                $gasto = Movimiento::where('categoria_id', $categoria->id)
                    ->where('tipo_movimiento', 'egreso')
                    ->whereBetween('fecha', [$inicio, $fin])
                    ->sum('monto');

                if ($gasto > 0) {
                    $promedioHistorico += $gasto;
                    $mesesConDatos++;
                }
            }

            if ($mesesConDatos === 0) {
                continue;
            }
            $promedioHistorico = $promedioHistorico / $mesesConDatos;

            $gastoActual = Movimiento::where('categoria_id', $categoria->id)
                ->where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('monto');

            if ($gastoActual === 0) {
                continue;
            }

            $diferenciaPct = $promedioHistorico > 0
                ? round((($gastoActual - $promedioHistorico) / $promedioHistorico) * 100, 1)
                : 0;

            if ($diferenciaPct >= self::UMBRAL_PORCENTAJE) {
                $alertas[] = [
                    'categoria' => $categoria->nombre,
                    'gastoActual' => round($gastoActual, 2),
                    'promedioHistorico' => round($promedioHistorico, 2),
                    'diferenciaPct' => $diferenciaPct,
                    'exceso' => round($gastoActual - $promedioHistorico, 2),
                ];

                Notification::make()
                    ->title("⚠️ Gasto inusual en {$categoria->nombre}")
                    ->body('Gastaste S/ '.number_format($gastoActual, 2)." este mes, un {$diferenciaPct}% más que tu promedio (S/ ".number_format($promedioHistorico, 2).')')
                    ->warning()
                    ->persistent()
                    ->sendToDatabase($user);

                try {
                    app(PushNotificationService::class)->enviar(
                        $user,
                        "⚠️ Gasto inusual en {$categoria->nombre}",
                        'Gastaste S/ '.number_format($gastoActual, 2)." este mes, un {$diferenciaPct}% más que tu promedio",
                        '/admin/gastos-inusuales'
                    );
                } catch (\Exception $e) {
                }
            }
        }

        if (! empty($alertas)) {
            Cache::put($cacheKey, true, now()->endOfMonth());
        }

        return $alertas;
    }

    public function getAnalisisCompleto(): array
    {
        $categorias = Categoria::where('tipo', 'egreso')->where('activa', true)->get();
        $resultado = [];

        foreach ($categorias as $categoria) {
            $historico = [];
            $total = 0;
            $meses = 0;

            for ($i = 5; $i >= 0; $i--) {
                $inicio = now()->subMonths($i)->startOfMonth();
                $fin = now()->subMonths($i)->endOfMonth();
                $gasto = Movimiento::where('categoria_id', $categoria->id)
                    ->where('tipo_movimiento', 'egreso')
                    ->whereBetween('fecha', [$inicio, $fin])
                    ->sum('monto');

                $historico[] = [
                    'mes' => $inicio->translatedFormat('M Y'),
                    'gasto' => round($gasto, 2),
                ];

                if ($gasto > 0) {
                    $total += $gasto;
                    $meses++;
                }
            }

            $promedio = $meses > 0 ? round($total / $meses, 2) : 0;
            $gastoActual = $historico[5]['gasto'];
            $diffPct = $promedio > 0
                ? round((($gastoActual - $promedio) / $promedio) * 100, 1)
                : 0;

            if ($promedio === 0 && $gastoActual === 0) {
                continue;
            }

            $resultado[] = [
                'categoria' => $categoria->nombre,
                'icono' => $categoria->icono ?? '📦',
                'color' => $categoria->color ?? '#6b7280',
                'historico' => $historico,
                'promedio' => $promedio,
                'gastoActual' => $gastoActual,
                'diffPct' => $diffPct,
                'estado' => $diffPct >= self::UMBRAL_PORCENTAJE ? 'inusual'
                    : ($diffPct >= 20 ? 'elevado' : ($diffPct <= -20 ? 'bajo' : 'normal')),
            ];
        }

        usort($resultado, fn ($a, $b) => $b['diffPct'] <=> $a['diffPct']);

        return $resultado;
    }
}

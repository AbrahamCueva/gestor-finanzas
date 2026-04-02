<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use App\Models\Categoria;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class BenchmarkFinanciero extends Page
{
    protected string $view = 'filament.pages.benchmark-financiero';
    protected static ?string $navigationLabel = 'Benchmark Financiero';
    protected static ?string $title = 'Benchmark Financiero Peruano';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 23;

    // Promedios peruanos por categoría (% del ingreso) — basado en ENAHO/INEI
    private array $benchmarksPeru = [
        'vivienda'       => ['min' => 20, 'max' => 35, 'promedio' => 28, 'label' => 'Vivienda', 'emoji' => '🏠', 'kw' => ['vivienda', 'alquiler', 'arriendo']],
        'alimentacion'   => ['min' => 20, 'max' => 35, 'promedio' => 27, 'label' => 'Alimentación', 'emoji' => '🍎', 'kw' => ['alimentaci', 'comida', 'mercado']],
        'transporte'     => ['min' => 8,  'max' => 18, 'promedio' => 13, 'label' => 'Transporte', 'emoji' => '🚌', 'kw' => ['transport']],
        'salud'          => ['min' => 3,  'max' => 8,  'promedio' => 5,  'label' => 'Salud', 'emoji' => '💊', 'kw' => ['salud', 'médic', 'farmac']],
        'educacion'      => ['min' => 5,  'max' => 15, 'promedio' => 9,  'label' => 'Educación', 'emoji' => '📚', 'kw' => ['educaci', 'estudio', 'curso']],
        'entretenimiento' => ['min' => 3,  'max' => 10, 'promedio' => 6,  'label' => 'Entretenimiento', 'emoji' => '🎮', 'kw' => ['entretenimiento', 'ocio']],
        'servicios'      => ['min' => 5,  'max' => 12, 'promedio' => 8,  'label' => 'Servicios', 'emoji' => '💡', 'kw' => ['servicios', 'luz', 'agua', 'internet']],
        'ropa'           => ['min' => 3,  'max' => 8,  'promedio' => 5,  'label' => 'Ropa/Personal', 'emoji' => '👕', 'kw' => ['ropa', 'compras', 'personal']],
    ];

    public function getDatos(): array
    {
        // Ingreso promedio últimos 3 meses
        $ingresosProm = 0;
        for ($i = 1; $i <= 3; $i++) {
            $ini = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();
            $ingresosProm += Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [$ini, $fin])->sum('monto');
        }
        $ingresosProm = $ingresosProm > 0 ? round($ingresosProm / 3, 2) : 1;

        $comparativas = [];
        $puntajeTotal = 0;
        $categorias   = Categoria::where('tipo', 'egreso')->where('activa', true)->get();

        foreach ($this->benchmarksPeru as $key => $bench) {
            // Buscar categoría que coincida por palabras clave
            $gastoMensual = 0;
            foreach ($categorias as $cat) {
                $nombre = strtolower($cat->nombre);
                foreach ($bench['kw'] as $kw) {
                    if (str_contains($nombre, $kw)) {
                        $prom = 0;
                        for ($i = 1; $i <= 3; $i++) {
                            $ini = now()->subMonths($i)->startOfMonth();
                            $fin = now()->subMonths($i)->endOfMonth();
                            $prom += Movimiento::where('tipo_movimiento', 'egreso')
                                ->where('categoria_id', $cat->id)
                                ->whereBetween('fecha', [$ini, $fin])
                                ->sum('monto');
                        }
                        $gastoMensual += $prom / 3;
                        break;
                    }
                }
            }

            $pctTuyo  = $ingresosProm > 0 ? round(($gastoMensual / $ingresosProm) * 100, 1) : 0;
            $estado   = match (true) {
                $pctTuyo <= $bench['min']    => 'bajo',
                $pctTuyo <= $bench['promedio'] => 'normal',
                $pctTuyo <= $bench['max']    => 'alto',
                default                      => 'muy_alto',
            };

            // Puntaje: 25 si estás en rango, menos si estás fuera
            $puntaje = match ($estado) {
                'bajo'    => 25,
                'normal'  => 25,
                'alto'    => 15,
                'muy_alto' => 5,
            };
            $puntajeTotal += $puntaje;

            $comparativas[] = [
                'key'          => $key,
                'label'        => $bench['label'],
                'emoji'        => $bench['emoji'],
                'tuyo'         => round($gastoMensual / 3, 2),
                'pctTuyo'      => $pctTuyo,
                'promPeru'     => $bench['promedio'],
                'minPeru'      => $bench['min'],
                'maxPeru'      => $bench['max'],
                'estado'       => $estado,
                'puntaje'      => $puntaje,
                'diferencia'   => round($pctTuyo - $bench['promedio'], 1),
            ];
        }

        $puntajeFinal = round(($puntajeTotal / (count($this->benchmarksPeru) * 25)) * 100);

        return [
            'comparativas'  => $comparativas,
            'ingresosProm'  => $ingresosProm,
            'puntaje'       => $puntajeFinal,
            'nivel'         => match (true) {
                $puntajeFinal >= 80 => ['label' => 'Por encima del promedio', 'color' => '#22c55e', 'emoji' => '🏆'],
                $puntajeFinal >= 60 => ['label' => 'En el promedio peruano',  'color' => '#60a5fa', 'emoji' => '✅'],
                $puntajeFinal >= 40 => ['label' => 'Ligeramente por encima',  'color' => '#fbbf24', 'emoji' => '⚠️'],
                default             => ['label' => 'Por encima del promedio', 'color' => '#ef4444', 'emoji' => '🚨'],
            },
        ];
    }
}

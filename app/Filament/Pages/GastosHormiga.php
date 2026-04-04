<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class GastosHormiga extends Page
{
    protected string $view = 'filament.pages.gastos-hormiga';
    protected static ?string $navigationLabel = 'Gastos Hormiga';
    protected static ?string $title = 'Detector de Gastos Hormiga';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 27;

    public int $meses = 3;
    public int $montoMaximo = 30; // S/ máximo para considerar "hormiga"
    public int $frecuenciaMin = 3; // mínimo de veces para considerar frecuente

    public function getDatos(): array
    {
        $inicio = now()->subMonths($this->meses)->startOfMonth();
        $fin = now()->endOfMonth();

        // Agrupar movimientos pequeños y frecuentes por descripción+categoría
        $movimientos = Movimiento::where('tipo_movimiento', 'egreso')
            ->where('monto', '<=', $this->montoMaximo)
            ->whereBetween('fecha', [$inicio, $fin])
            ->with('categoria')
            ->get();

        // Agrupar por descripción normalizada
        $grupos = [];
        foreach ($movimientos as $mov) {
            $desc = strtolower(trim($mov->descripcion ?? $mov->categoria?->nombre ?? 'Sin descripción'));
            $key = $desc . '_' . $mov->categoria_id;

            if (!isset($grupos[$key])) {
                $grupos[$key] = [
                    'descripcion' => ucfirst($mov->descripcion ?? $mov->categoria?->nombre ?? 'Sin descripción'),
                    'categoria' => $mov->categoria?->nombre ?? 'Sin categoría',
                    'movimientos' => [],
                    'total' => 0,
                    'conteo' => 0,
                ];
            }

            $grupos[$key]['movimientos'][] = $mov;
            $grupos[$key]['total'] += $mov->monto;
            $grupos[$key]['conteo']++;
        }

        // Filtrar por frecuencia mínima
        $hormiguitas = array_filter($grupos, fn($g) => $g['conteo'] >= $this->frecuenciaMin);

        // Calcular stats por grupo
        $resultado = [];
        foreach ($hormiguitas as $grupo) {
            $montos = array_map(fn($m) => $m->monto, $grupo['movimientos']);
            $fechas = array_map(fn($m) => Carbon::parse($m->fecha), $grupo['movimientos']);
            $promedio = round(array_sum($montos) / count($montos), 2);

            // Frecuencia: veces por semana
            $diasPeriodo = $inicio->diffInDays($fin) ?: 1;
            $vecesXSemana = round(($grupo['conteo'] / $diasPeriodo) * 7, 1);
            $vecesXMes = round($grupo['conteo'] / $this->meses, 1);
            $proyeccionAnual = round($grupo['total'] / $this->meses * 12, 2);

            // Días entre compras
            sort($fechas);
            $intervalos = [];
            for ($i = 1; $i < count($fechas); $i++) {
                $intervalos[] = $fechas[$i - 1]->diffInDays($fechas[$i]);
            }
            $promedioInterv = count($intervalos) > 0
                ? round(array_sum($intervalos) / count($intervalos), 1)
                : 0;

            $resultado[] = [
                'descripcion' => $grupo['descripcion'],
                'categoria' => $grupo['categoria'],
                'conteo' => $grupo['conteo'],
                'total' => round($grupo['total'], 2),
                'promedio' => $promedio,
                'vecesXSemana' => $vecesXSemana,
                'vecesXMes' => $vecesXMes,
                'proyeccionAnual' => $proyeccionAnual,
                'promedioInterv' => $promedioInterv,
                'impacto' => $this->calcularImpacto($proyeccionAnual),
            ];
        }

        // Ordenar por total descendente
        usort($resultado, fn($a, $b) => $b['total'] <=> $a['total']);

        // Stats globales
        $totalHormiga = array_sum(array_column($resultado, 'total'));
        $proyAnual = array_sum(array_column($resultado, 'proyeccionAnual'));
        $totalMovSmall = $movimientos->sum('monto');

        // Análisis por hora del día
        $porHora = [];
        foreach ($movimientos as $mov) {
            $hora = Carbon::parse($mov->created_at)->hour;
            $porHora[$hora] = ($porHora[$hora] ?? 0) + $mov->monto;
        }
        ksort($porHora);

        // Top 5 más costosos
        $top5 = array_slice($resultado, 0, 5);

        return [
            'gastos' => $resultado,
            'totalHormiga' => round($totalHormiga, 2),
            'proyAnual' => round($proyAnual, 2),
            'totalMovSmall' => round($totalMovSmall, 2),
            'cantidadGrupos' => count($resultado),
            'porHora' => $porHora,
            'top5' => $top5,
            'meses' => $this->meses,
            'montoMaximo' => $this->montoMaximo,
        ];
    }

    private function calcularImpacto(float $anual): string
    {
        return match (true) {
            $anual >= 1200 => 'critico',
            $anual >= 600 => 'alto',
            $anual >= 300 => 'medio',
            default => 'bajo',
        };
    }
    

    public function updated($property): void
    {
        if (in_array($property, ['meses', 'montoMaximo', 'frecuenciaMin'])) {
            $datos = $this->getDatos();
            $this->dispatch('updateGhChart', [
                'gastos' => $datos['gastos'],
            ]);
        }
    }
}
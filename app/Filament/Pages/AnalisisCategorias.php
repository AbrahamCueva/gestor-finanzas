<?php

namespace App\Filament\Pages;

use App\Models\Categoria;
use App\Models\Movimiento;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AnalisisCategorias extends Page
{
    protected string $view = 'filament.pages.analisis-categorias';
    protected static ?string $navigationLabel = 'Análisis de Categorías';
    protected static ?string $title = 'Análisis Profundo de Categorías';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 19;

    public string $tipo = 'egreso';
    public int $categoriaId = 0;
    public int $meses = 6;

    public function getCategorias(): array
    {
        return Categoria::where('tipo', $this->tipo)
            ->where('activa', true)
            ->pluck('nombre', 'id')
            ->toArray();
    }

    public function getResumenCategorias(): array
    {
        $inicio = now()->subMonths($this->meses)->startOfMonth();
        $fin = now()->endOfMonth();

        $categorias = Categoria::where('tipo', $this->tipo)
            ->where('activa', true)
            ->get();

        $resultado = [];
        $totalGeneral = Movimiento::where('tipo_movimiento', $this->tipo)
            ->whereBetween('fecha', [$inicio, $fin])
            ->sum('monto');

        foreach ($categorias as $cat) {
            $total = Movimiento::where('tipo_movimiento', $this->tipo)
                ->where('categoria_id', $cat->id)
                ->whereBetween('fecha', [$inicio, $fin])
                ->sum('monto');

            if ($total <= 0)
                continue;

            $conteo = Movimiento::where('tipo_movimiento', $this->tipo)
                ->where('categoria_id', $cat->id)
                ->whereBetween('fecha', [$inicio, $fin])
                ->count();

            $promMensual = $this->meses > 0 ? round($total / $this->meses, 2) : 0;
            $pct = $totalGeneral > 0 ? round(($total / $totalGeneral) * 100, 1) : 0;

            // Tendencia — comparar primera mitad vs segunda mitad del período
            $mitad = (int) ($this->meses / 2);
            $mitadIni = now()->subMonths($this->meses)->startOfMonth();
            $mitadMed = now()->subMonths($mitad)->startOfMonth();
            $primeraMitad = Movimiento::where('tipo_movimiento', $this->tipo)
                ->where('categoria_id', $cat->id)
                ->whereBetween('fecha', [$mitadIni, $mitadMed])
                ->sum('monto');
            $segundaMitad = Movimiento::where('tipo_movimiento', $this->tipo)
                ->where('categoria_id', $cat->id)
                ->whereBetween('fecha', [$mitadMed, $fin])
                ->sum('monto');

            $tendencia = $primeraMitad > 0
                ? round((($segundaMitad - $primeraMitad) / $primeraMitad) * 100, 1)
                : 0;

            $resultado[] = [
                'id' => $cat->id,
                'nombre' => $cat->nombre,
                'color' => $cat->color ?? '#6b7280',
                'total' => round($total, 2),
                'conteo' => $conteo,
                'promMensual' => $promMensual,
                'pct' => $pct,
                'tendencia' => $tendencia,
                'promPorMov' => $conteo > 0 ? round($total / $conteo, 2) : 0,
            ];
        }

        usort($resultado, fn($a, $b) => $b['total'] <=> $a['total']);
        return $resultado;
    }

    public function getDetalleCat(): array
    {
        if ($this->categoriaId <= 0)
            return [];

        $cat = Categoria::find($this->categoriaId);
        if (!$cat)
            return [];

        $mesesData = [];
        $nombres = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        for ($i = $this->meses - 1; $i >= 0; $i--) {
            $inicio = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();

            $total = Movimiento::where('tipo_movimiento', $this->tipo)
                ->where('categoria_id', $this->categoriaId)
                ->whereBetween('fecha', [$inicio, $fin])
                ->sum('monto');

            $conteo = Movimiento::where('tipo_movimiento', $this->tipo)
                ->where('categoria_id', $this->categoriaId)
                ->whereBetween('fecha', [$inicio, $fin])
                ->count();

            // Top subcategorías del mes
            $topSub = Movimiento::selectRaw('subcategoria_id, SUM(monto) as suma')
                ->where('tipo_movimiento', $this->tipo)
                ->where('categoria_id', $this->categoriaId)
                ->whereBetween('fecha', [$inicio, $fin])
                ->whereNotNull('subcategoria_id')
                ->groupBy('subcategoria_id')
                ->with('subcategoria')
                ->orderByDesc('suma')
                ->limit(3)
                ->get()
                ->map(fn($m) => $m->subcategoria?->nombre . ' S/' . number_format($m->suma, 0))
                ->join(', ');

            $mesesData[] = [
                'mes' => $nombres[$inicio->month - 1] . ' ' . substr($inicio->year, 2),
                'total' => round($total, 2),
                'conteo' => $conteo,
                'topSub' => $topSub ?: '—',
            ];
        }

        // Promedio
        $conDatos = array_filter($mesesData, fn($m) => $m['total'] > 0);
        $promedio = count($conDatos) > 0
            ? round(array_sum(array_column($conDatos, 'total')) / count($conDatos), 2)
            : 0;

        return [
            'categoria' => $cat,
            'meses' => $mesesData,
            'promedio' => $promedio,
            'max' => max(array_column($mesesData, 'total')) ?: 1,
        ];
    }

    public function updated($property)
    {
        if (in_array($property, ['categoriaId', 'meses', 'tipo'])) {
            $detalle = $this->getDetalleCat();

            if (!empty($detalle)) {
                $this->dispatch('updateCatChart', [
                    'meses' => $detalle['meses'],
                    'tipo' => $this->tipo,
                ]);
            }
        }
    }
}

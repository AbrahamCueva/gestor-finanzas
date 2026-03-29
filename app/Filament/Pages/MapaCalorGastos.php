<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class MapaCalorGastos extends Page
{
    protected string $view = 'filament.pages.mapa-calor-gastos';
    protected static ?string $navigationLabel = 'Mapa de Calor';
    protected static ?string $title = 'Mapa de Calor de Gastos';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFire;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 14;

    public int    $anio      = 0;
    public string $tipo      = 'egreso';

    public function mount(): void
    {
        $this->anio = now()->year;
    }

    public function getDatos(): array
    {
        $inicio = Carbon::create($this->anio, 1, 1)->startOfYear();
        $fin    = Carbon::create($this->anio, 12, 31)->endOfYear();

        $movimientos = Movimiento::where('tipo_movimiento', $this->tipo)
            ->whereBetween('fecha', [$inicio, $fin])
            ->selectRaw('DATE(fecha) as dia, SUM(monto) as total')
            ->groupBy('dia')
            ->pluck('total', 'dia')
            ->toArray();

        $maxMonto = !empty($movimientos) ? max($movimientos) : 1;

        $semanas = [];
        $fecha   = $inicio->copy()->startOfWeek(Carbon::SUNDAY);
        $finGrid = $fin->copy()->endOfWeek(Carbon::SATURDAY);

        $semanaActual = [];
        while ($fecha->lte($finGrid)) {
            $diaStr = $fecha->format('Y-m-d');
            $monto  = $movimientos[$diaStr] ?? 0;
            $enAnio = $fecha->year == $this->anio;

            $semanaActual[] = [
                'fecha'  => $diaStr,
                'monto'  => $enAnio ? round($monto, 2) : null,
                'enAnio' => $enAnio,
                'nivel'  => $enAnio && $monto > 0
                    ? $this->calcularNivel($monto, $maxMonto)
                    : 0,
                'diaSemana' => $fecha->dayOfWeek,
                'mes'    => $fecha->month,
            ];

            if ($fecha->dayOfWeek === Carbon::SATURDAY) {
                $semanas[] = $semanaActual;
                $semanaActual = [];
            }

            $fecha->addDay();
        }

        if (!empty($semanaActual)) {
            $semanas[] = $semanaActual;
        }

        $totalAnio    = array_sum($movimientos);
        $diasActivos  = count(array_filter($movimientos, fn($v) => $v > 0));
        $promedioDia  = $diasActivos > 0 ? $totalAnio / $diasActivos : 0;
        $diaMasAlto   = !empty($movimientos) ? array_search(max($movimientos), $movimientos) : null;

        $porMes = [];
        for ($m = 1; $m <= 12; $m++) {
            $inicioMes = Carbon::create($this->anio, $m, 1)->startOfMonth();
            $finMes    = Carbon::create($this->anio, $m, 1)->endOfMonth();

            $totalMes = Movimiento::where('tipo_movimiento', $this->tipo)
                ->whereBetween('fecha', [$inicioMes, $finMes])
                ->sum('monto');

            $porMes[] = [
                'mes'    => $inicioMes->translatedFormat('M'),
                'total'  => round($totalMes, 2),
            ];
        }

        $maxMes = max(array_column($porMes, 'total')) ?: 1;

        return [
            'semanas'     => $semanas,
            'maxMonto'    => $maxMonto,
            'totalAnio'   => round($totalAnio, 2),
            'diasActivos' => $diasActivos,
            'promedioDia' => round($promedioDia, 2),
            'diaMasAlto'  => $diaMasAlto,
            'montoMasAlto'=> !empty($movimientos) ? round(max($movimientos), 2) : 0,
            'porMes'      => $porMes,
            'maxMes'      => $maxMes,
        ];
    }

    private function calcularNivel(float $monto, float $max): int
    {
        if ($monto <= 0)           return 0;
        if ($monto <= $max * 0.15) return 1;
        if ($monto <= $max * 0.35) return 2;
        if ($monto <= $max * 0.60) return 3;
        if ($monto <= $max * 0.80) return 4;
        return 5;
    }
}

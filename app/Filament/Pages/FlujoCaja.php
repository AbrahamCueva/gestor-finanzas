<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use App\Models\Transferencia;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class FlujoCaja extends Page
{
    protected string $view = 'filament.pages.flujo-caja';
    protected static ?string $navigationLabel = 'Flujo de Caja';
    protected static ?string $title = 'Análisis de Flujo de Caja';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 18;

    public int $mes = 0;
    public int $anio = 0;

    public function mount(): void
    {
        $this->mes = now()->month;
        $this->anio = now()->year;
    }

    public function getMesActual(): int
    {
        return $this->mes > 0 ? $this->mes : now()->month;
    }
    public function getAnioActual(): int
    {
        return $this->anio > 0 ? $this->anio : now()->year;
    }

    public function anteriorMes(): void
    {
        $f = Carbon::create($this->getAnioActual(), $this->getMesActual(), 1)->subMonth();
        $this->mes = $f->month;
        $this->anio = $f->year;
        $this->dispatch('updateFcChart', [
            'flujo' => $this->getDatos()['flujo'],
        ]);
    }

    public function siguienteMes(): void
    {
        $f = Carbon::create($this->getAnioActual(), $this->getMesActual(), 1)->addMonth();
        $this->mes = $f->month;
        $this->anio = $f->year;
        $this->dispatch('updateFcChart', [
            'flujo' => $this->getDatos()['flujo'],
        ]);
    }

    public function getDatos(): array
    {
        $mes = $this->getMesActual();
        $anio = $this->getAnioActual();
        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin = Carbon::create($anio, $mes, 1)->endOfMonth();
        $dias = $inicio->daysInMonth;

        $flujo = [];
        $saldoAcumulado = 0;

        for ($d = 1; $d <= $dias; $d++) {
            $fecha = Carbon::create($anio, $mes, $d);
            $fechaStr = $fecha->format('Y-m-d');

            $ingresos = Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereDate('fecha', $fechaStr)->sum('monto');
            $egresos = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereDate('fecha', $fechaStr)->sum('monto');

            $neto = $ingresos - $egresos;
            $saldoAcumulado += $neto;

            $flujo[] = [
                'dia' => $d,
                'fecha' => $fecha->translatedFormat('d M'),
                'ingresos' => round($ingresos, 2),
                'egresos' => round($egresos, 2),
                'neto' => round($neto, 2),
                'acumulado' => round($saldoAcumulado, 2),
                'esFuturo' => $fecha->isFuture(),
            ];
        }

        $totalIngresos = array_sum(array_column($flujo, 'ingresos'));
        $totalEgresos = array_sum(array_column($flujo, 'egresos'));
        $diasPositivos = count(array_filter($flujo, fn($f) => $f['neto'] > 0));
        $diasNegativos = count(array_filter($flujo, fn($f) => $f['neto'] < 0));
        $mejorDia = collect($flujo)->sortByDesc('neto')->first();
        $peorDia = collect($flujo)->sortBy('neto')->first();
        $diasConMovs = count(array_filter($flujo, fn($f) => $f['ingresos'] > 0 || $f['egresos'] > 0));

        return [
            'flujo' => $flujo,
            'totalIngresos' => round($totalIngresos, 2),
            'totalEgresos' => round($totalEgresos, 2),
            'totalNeto' => round($totalIngresos - $totalEgresos, 2),
            'diasPositivos' => $diasPositivos,
            'diasNegativos' => $diasNegativos,
            'mejorDia' => $mejorDia,
            'peorDia' => $peorDia,
            'diasConMovs' => $diasConMovs,
            'mes' => $inicio->translatedFormat('F Y'),
        ];
    }
}

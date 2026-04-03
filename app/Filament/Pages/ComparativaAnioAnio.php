<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use App\Models\Categoria;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ComparativaAnioAnio extends Page
{
    protected string $view = 'filament.pages.comparativa-anio-anio';
    protected static ?string $navigationLabel = 'Año vs Año';
    protected static ?string $title = 'Comparativa Año a Año';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsUpDown;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 24;

    public int $anio1 = 0;
    public int $anio2 = 0;

    public function mount(): void
    {
        $this->anio1 = now()->year - 1;
        $this->anio2 = now()->year;
    }

    public function getAniosDisponibles(): array
    {
        $primerMov = Movimiento::oldest('fecha')->first();
        if (!$primerMov) return [now()->year];

        $anioMin = Carbon::parse($primerMov->fecha)->year;
        $anioMax = now()->year;
        $anios   = [];

        for ($a = $anioMax; $a >= $anioMin; $a--) {
            $anios[$a] = $a;
        }

        return $anios;
    }

    public function getDatosAnio(int $anio): array
    {
        $meses   = [];
        $nombres = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

        for ($m = 1; $m <= 12; $m++) {
            $inicio = Carbon::create($anio, $m, 1)->startOfMonth();
            $fin    = Carbon::create($anio, $m, 1)->endOfMonth();

            $ingresos = Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
            $egresos  = Movimiento::where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [$inicio, $fin])->sum('monto');

            $meses[] = [
                'mes'      => $nombres[$m - 1],
                'ingresos' => round($ingresos, 2),
                'egresos'  => round($egresos, 2),
                'ahorro'   => round($ingresos - $egresos, 2),
            ];
        }

        $totalIngresos = array_sum(array_column($meses, 'ingresos'));
        $totalEgresos  = array_sum(array_column($meses, 'egresos'));

        // Top categorías del año
        $topCats = Movimiento::selectRaw('categorias.nombre, SUM(movimientos.monto) as total')
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->where('movimientos.tipo_movimiento', 'egreso')
            ->whereYear('movimientos.fecha', $anio)
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($c) => [
                'nombre' => $c->nombre,
                'total'  => round($c->total, 2),
            ])
            ->toArray();

        // Mejor y peor mes
        $mejorMes = collect($meses)->sortByDesc('ahorro')->first();
        $peorMes  = collect($meses)->sortBy('ahorro')->first();

        return [
            'anio'          => $anio,
            'meses'         => $meses,
            'totalIngresos' => round($totalIngresos, 2),
            'totalEgresos'  => round($totalEgresos, 2),
            'totalAhorro'   => round($totalIngresos - $totalEgresos, 2),
            'promMensual'   => round($totalEgresos / 12, 2),
            'topCats'       => $topCats,
            'mejorMes'      => $mejorMes,
            'peorMes'       => $peorMes,
        ];
    }

    public function getDatos(): array
    {
        $a1 = $this->anio1 > 0 ? $this->anio1 : now()->year - 1;
        $a2 = $this->anio2 > 0 ? $this->anio2 : now()->year;

        $datos1 = $this->getDatosAnio($a1);
        $datos2 = $this->getDatosAnio($a2);

        // Variaciones
        $varIngresos = $datos1['totalIngresos'] > 0
            ? round((($datos2['totalIngresos'] - $datos1['totalIngresos']) / $datos1['totalIngresos']) * 100, 1)
            : 0;
        $varEgresos  = $datos1['totalEgresos'] > 0
            ? round((($datos2['totalEgresos'] - $datos1['totalEgresos']) / $datos1['totalEgresos']) * 100, 1)
            : 0;
        $varAhorro   = $datos1['totalAhorro'] != 0
            ? round((($datos2['totalAhorro'] - $datos1['totalAhorro']) / abs($datos1['totalAhorro'])) * 100, 1)
            : 0;

        // Comparativa mes a mes
        $comparativaMeses = [];
        $nombres = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        for ($i = 0; $i < 12; $i++) {
            $m1 = $datos1['meses'][$i];
            $m2 = $datos2['meses'][$i];
            $comparativaMeses[] = [
                'mes'      => $nombres[$i],
                'egr1'     => $m1['egresos'],
                'egr2'     => $m2['egresos'],
                'ing1'     => $m1['ingresos'],
                'ing2'     => $m2['ingresos'],
                'varEgr'   => $m1['egresos'] > 0
                    ? round((($m2['egresos'] - $m1['egresos']) / $m1['egresos']) * 100, 1) : 0,
                'varIng'   => $m1['ingresos'] > 0
                    ? round((($m2['ingresos'] - $m1['ingresos']) / $m1['ingresos']) * 100, 1) : 0,
            ];
        }

        return [
            'datos1'           => $datos1,
            'datos2'           => $datos2,
            'varIngresos'      => $varIngresos,
            'varEgresos'       => $varEgresos,
            'varAhorro'        => $varAhorro,
            'comparativaMeses' => $comparativaMeses,
        ];
    }
}
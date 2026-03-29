<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class ComparativaPeriodos extends Page
{
    protected string $view = 'filament.pages.comparativa-periodos';

    protected static ?string $navigationLabel = 'Comparativa de Períodos';

    protected static ?string $title = 'Comparativa de Períodos';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string|UnitEnum|null $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 5;

    public string $periodo1_desde = '';

    public string $periodo1_hasta = '';

    public string $periodo2_desde = '';

    public string $periodo2_hasta = '';

    public function mount(): void
    {
        $this->periodo1_desde = now()->subMonth()->startOfMonth()->format('Y-m-d');
        $this->periodo1_hasta = now()->subMonth()->endOfMonth()->format('Y-m-d');

        $this->periodo2_desde = now()->startOfMonth()->format('Y-m-d');
        $this->periodo2_hasta = now()->endOfMonth()->format('Y-m-d');
    }

    public function getDatos(): array
    {
        if (! $this->periodo1_desde || ! $this->periodo1_hasta ||
            ! $this->periodo2_desde || ! $this->periodo2_hasta) {
            return $this->datosVacios();
        }

        $p1 = $this->calcularPeriodo($this->periodo1_desde, $this->periodo1_hasta);
        $p2 = $this->calcularPeriodo($this->periodo2_desde, $this->periodo2_hasta);

        return [
            'p1' => $p1,
            'p2' => $p2,
            'diff' => $this->calcularDiff($p1, $p2),
            'valido' => true,
        ];
    }

    private function calcularPeriodo(string $desde, string $hasta): array
    {
        $ini = Carbon::parse($desde)->startOfDay();
        $fin = Carbon::parse($hasta)->endOfDay();

        $ingresos = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$ini, $fin])->sum('monto');
        $egresos = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$ini, $fin])->sum('monto');
        $ahorro = $ingresos - $egresos;

        $categorias = Movimiento::select('categorias.nombre', DB::raw('SUM(movimientos.monto) as total'))
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->where('movimientos.tipo_movimiento', 'egreso')
            ->whereBetween('movimientos.fecha', [$ini, $fin])
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $dias = $ini->diffInDays($fin) + 1;

        return [
            'desde' => $desde,
            'hasta' => $hasta,
            'label' => Carbon::parse($desde)->format('d/m/Y').' — '.Carbon::parse($hasta)->format('d/m/Y'),
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'ahorro' => $ahorro,
            'categorias' => $categorias,
            'dias' => $dias,
            'promDiario' => $dias > 0 ? round($egresos / $dias, 2) : 0,
        ];
    }

    private function calcularDiff(array $p1, array $p2): array
    {
        return [
            'ingresos' => $this->pct($p1['ingresos'], $p2['ingresos']),
            'egresos' => $this->pct($p1['egresos'], $p2['egresos']),
            'ahorro' => $this->pct($p1['ahorro'], $p2['ahorro']),
        ];
    }

    private function pct(float $base, float $nuevo): array
    {
        if ($base == 0) {
            return ['valor' => 0, 'sube' => true];
        }
        $pct = round((($nuevo - $base) / abs($base)) * 100, 1);

        return ['valor' => $pct, 'sube' => $pct >= 0];
    }

    private function datosVacios(): array
    {
        $vacio = ['ingresos' => 0, 'egresos' => 0, 'ahorro' => 0, 'categorias' => collect(), 'dias' => 0, 'promDiario' => 0, 'label' => '—', 'desde' => '', 'hasta' => ''];

        return ['p1' => $vacio, 'p2' => $vacio, 'diff' => ['ingresos' => ['valor' => 0, 'sube' => true], 'egresos' => ['valor' => 0, 'sube' => true], 'ahorro' => ['valor' => 0, 'sube' => true]], 'valido' => false];
    }
}

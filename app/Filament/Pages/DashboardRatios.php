<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use App\Models\Cuenta;
use App\Models\Deuda;
use App\Models\Meta;
use App\Models\Presupuesto;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class DashboardRatios extends Page
{
    protected string $view = 'filament.pages.dashboard-ratios';
    protected static ?string $navigationLabel = 'Dashboard de Ratios';
    protected static ?string $title = 'Dashboard de Ratios Financieros';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 25;

    public function getDatos(): array
    {
        $hoy = now();

        // Promedios 3 meses
        $ingresosProm = 0;
        $egresosProm = 0;
        for ($i = 1; $i <= 3; $i++) {
            $ini = $hoy->copy()->subMonths($i)->startOfMonth();
            $fin = $hoy->copy()->subMonths($i)->endOfMonth();
            $ingresosProm += Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$ini, $fin])->sum('monto');
            $egresosProm += Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$ini, $fin])->sum('monto');
        }
        $ingresosProm = round($ingresosProm / 3, 2);
        $egresosProm = round($egresosProm / 3, 2);
        $ahorroProm = $ingresosProm - $egresosProm;

        // Activos y deudas
        $totalActivos = Cuenta::where('activa', true)->sum('saldo_actual');
        $totalDeudas = Deuda::where('estado', '!=', 'pagada')->where('tipo', 'debo')
            ->get()->sum(fn($d) => $d->restante());
        $totalMeDeben = Deuda::where('estado', '!=', 'pagada')->where('tipo', 'me_deben')
            ->get()->sum(fn($d) => $d->restante());

        // Ratios
        // 1. Tasa de ahorro (% ingresos ahorrados)
        $tasaAhorro = $ingresosProm > 0
            ? round(($ahorroProm / $ingresosProm) * 100, 1) : 0;

        // 2. Ratio deuda/ingreso (DTI)
        $dti = $ingresosProm > 0
            ? round(($totalDeudas / ($ingresosProm * 12)) * 100, 1) : 0;

        // 3. Ratio de liquidez (activos / gastos mensuales)
        $liquidez = $egresosProm > 0
            ? round($totalActivos / $egresosProm, 1) : 0;

        // 4. Ratio gastos/ingresos
        $ratioGastos = $ingresosProm > 0
            ? round(($egresosProm / $ingresosProm) * 100, 1) : 0;

        // 5. Fondo de emergencia (meses que puedes vivir con tus ahorros)
        $fondoEmergencia = $egresosProm > 0
            ? round($totalActivos / $egresosProm, 1) : 0;

        // 6. Patrimonio neto
        $patrimonioNeto = $totalActivos - $totalDeudas + $totalMeDeben;

        // 7. Ratio metas cumplidas
        $totalMetas = Meta::count();
        $metasCumplidas = Meta::where('completada', true)->count();
        $ratioMetas = $totalMetas > 0
            ? round(($metasCumplidas / $totalMetas) * 100) : 0;

        // 8. Presupuestos respetados
        $presupuestos = Presupuesto::where('activo', true)->get();
        $presRespetados = $presupuestos->filter(fn($p) => !$p->superado())->count();
        $ratioPres = $presupuestos->count() > 0
            ? round(($presRespetados / $presupuestos->count()) * 100) : 100;

        // Historial ratios últimos 6 meses
        $historial = [];
        for ($i = 5; $i >= 0; $i--) {
            $ini = $hoy->copy()->subMonths($i)->startOfMonth();
            $fin = $hoy->copy()->subMonths($i)->endOfMonth();
            $ing = Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$ini, $fin])->sum('monto');
            $egr = Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$ini, $fin])->sum('monto');

            $historial[] = [
                'mes' => $ini->translatedFormat('M Y'),
                'tasaAhorro' => $ing > 0 ? round((($ing - $egr) / $ing) * 100, 1) : 0,
                'ratioGastos' => $ing > 0 ? round(($egr / $ing) * 100, 1) : 0,
            ];
        }

        return [
            'ingresosProm' => $ingresosProm,
            'egresosProm' => $egresosProm,
            'ahorroProm' => $ahorroProm,
            'totalActivos' => round($totalActivos, 2),
            'totalDeudas' => round($totalDeudas, 2),
            'patrimonioNeto' => round($patrimonioNeto, 2),
            'ratios' => [
                [
                    'nombre' => 'Tasa de Ahorro',
                    'emoji' => '💰',
                    'valor' => $tasaAhorro,
                    'unidad' => '%',
                    'meta' => 20,
                    'desc' => 'del ingreso que ahorras',
                    'estado' => $tasaAhorro >= 20 ? 'excelente' : ($tasaAhorro >= 10 ? 'bueno' : ($tasaAhorro >= 0 ? 'regular' : 'malo')),
                    'benchmark' => 'Meta ideal: ≥ 20%',
                    'invertido' => false,
                ],
                [
                    'nombre' => 'Ratio Gastos/Ingreso',
                    'emoji' => '💸',
                    'valor' => $ratioGastos,
                    'unidad' => '%',
                    'meta' => 80,
                    'desc' => 'del ingreso en gastos',
                    'estado' => $ratioGastos <= 70 ? 'excelente' : ($ratioGastos <= 80 ? 'bueno' : ($ratioGastos <= 100 ? 'regular' : 'malo')),
                    'benchmark' => 'Ideal: ≤ 80%',
                    'invertido' => true,
                ],
                [
                    'nombre' => 'Liquidez',
                    'emoji' => '🏦',
                    'valor' => $liquidez,
                    'unidad' => 'x',
                    'meta' => 6,
                    'desc' => 'meses de gastos cubiertos',
                    'estado' => $liquidez >= 6 ? 'excelente' : ($liquidez >= 3 ? 'bueno' : ($liquidez >= 1 ? 'regular' : 'malo')),
                    'benchmark' => 'Ideal: ≥ 6 meses',
                    'invertido' => false,
                ],
                [
                    'nombre' => 'DTI (Deuda/Ingreso)',
                    'emoji' => '💳',
                    'valor' => $dti,
                    'unidad' => '%',
                    'meta' => 36,
                    'desc' => 'de deuda vs ingreso anual',
                    'estado' => $dti <= 20 ? 'excelente' : ($dti <= 36 ? 'bueno' : ($dti <= 50 ? 'regular' : 'malo')),
                    'benchmark' => 'Ideal: ≤ 36%',
                    'invertido' => true,
                ],
                [
                    'nombre' => 'Fondo Emergencia',
                    'emoji' => '🛡️',
                    'valor' => $fondoEmergencia,
                    'unidad' => ' mes',
                    'meta' => 6,
                    'desc' => 'meses sin ingresos',
                    'estado' => $fondoEmergencia >= 6 ? 'excelente' : ($fondoEmergencia >= 3 ? 'bueno' : ($fondoEmergencia >= 1 ? 'regular' : 'malo')),
                    'benchmark' => 'Ideal: ≥ 6 meses',
                    'invertido' => false,
                ],
                [
                    'nombre' => 'Metas Cumplidas',
                    'emoji' => '🏆',
                    'valor' => $ratioMetas,
                    'unidad' => '%',
                    'meta' => 100,
                    'desc' => 'de metas completadas',
                    'estado' => $ratioMetas >= 80 ? 'excelente' : ($ratioMetas >= 50 ? 'bueno' : ($ratioMetas >= 20 ? 'regular' : 'malo')),
                    'benchmark' => 'Meta: 100%',
                    'invertido' => false,
                ],
                [
                    'nombre' => 'Presupuestos OK',
                    'emoji' => '🎯',
                    'valor' => $ratioPres,
                    'unidad' => '%',
                    'meta' => 100,
                    'desc' => 'de presupuestos respetados',
                    'estado' => $ratioPres >= 90 ? 'excelente' : ($ratioPres >= 70 ? 'bueno' : ($ratioPres >= 50 ? 'regular' : 'malo')),
                    'benchmark' => 'Meta: 100%',
                    'invertido' => false,
                ],
                [
                    'nombre' => 'Patrimonio Neto',
                    'emoji' => '💎',
                    'valor' => round($patrimonioNeto),
                    'unidad' => ' S/',
                    'meta' => null,
                    'desc' => 'activos - deudas + cobros',
                    'estado' => $patrimonioNeto > 0 ? 'excelente' : 'malo',
                    'benchmark' => 'Ideal: positivo y creciendo',
                    'invertido' => false,
                ],
            ],
            'historial' => $historial,
        ];
    }
}
<?php

namespace App\Filament\Pages;

use App\Models\Movimiento;
use App\Models\Cuenta;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class SimuladorEscenarios extends Page
{
    protected string $view = 'filament.pages.simulador-escenarios';
    protected static ?string $navigationLabel = 'Simulador de Escenarios';
    protected static ?string $title = 'Simulador de Escenarios Financieros';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 21;

    // Ajustes del usuario
    public float $ajusteIngresos = 0;   // % cambio en ingresos
    public float $ajusteEgresos = 0;   // % cambio en egresos
    public float $ahorroPropuesto = 20;  // % de ahorro objetivo
    public int $mesesProyeccion = 6;
    public float $gastoExtra = 0;   // gasto extra mensual
    public float $ingresoExtra = 0;   // ingreso extra mensual

    public function getBase(): array
    {
        $promedioIngresos = 0;
        $promedioEgresos = 0;

        for ($i = 1; $i <= 3; $i++) {
            $ini = now()->subMonths($i)->startOfMonth();
            $fin = now()->subMonths($i)->endOfMonth();
            $promedioIngresos += Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$ini, $fin])->sum('monto');
            $promedioEgresos += Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$ini, $fin])->sum('monto');
        }

        return [
            'ingresos' => round($promedioIngresos / 3, 2),
            'egresos' => round($promedioEgresos / 3, 2),
            'saldo' => Cuenta::where('activa', true)->sum('saldo_actual'),
        ];
    }

    public function getSimulacion(): array
    {
        $base = $this->getBase();

        // Aplicar ajustes
        $ingresosNuevos = $base['ingresos'] * (1 + $this->ajusteIngresos / 100) + $this->ingresoExtra;
        $egresosNuevos = $base['egresos'] * (1 + $this->ajusteEgresos / 100) + $this->gastoExtra;
        $ahorroMensual = $ingresosNuevos - $egresosNuevos;
        $pctAhorro = $ingresosNuevos > 0 ? round(($ahorroMensual / $ingresosNuevos) * 100, 1) : 0;

        // Proyección mes a mes
        $proyeccion = [];
        $saldoActual = $base['saldo'];
        $saldoBaseAcum = $base['saldo'];

        for ($i = 1; $i <= $this->mesesProyeccion; $i++) {
            $mes = now()->addMonths($i)->translatedFormat('M Y');
            $saldoActual += $ahorroMensual;
            $saldoBaseAcum += ($base['ingresos'] - $base['egresos']);

            $proyeccion[] = [
                'mes' => $mes,
                'ingresos' => round($ingresosNuevos, 2),
                'egresos' => round($egresosNuevos, 2),
                'ahorro' => round($ahorroMensual, 2),
                'saldo' => round($saldoActual, 2),
                'saldoBase' => round($saldoBaseAcum, 2),
            ];
        }

        // Diferencia vs escenario actual
        $diferenciaAhorro = round($ahorroMensual - ($base['ingresos'] - $base['egresos']), 2);
        $diferenciaSaldo = round($saldoActual - $saldoBaseAcum, 2);

        // Cuándo alcanzas el ahorro objetivo
        $ahorroObjetivo = $ingresosNuevos * ($this->ahorroPropuesto / 100);
        $mesesParaObjetivo = $ahorroMensual > 0 && $ahorroMensual < $ahorroObjetivo
            ? '∞'
            : ($ahorroMensual >= $ahorroObjetivo ? '✓ Ya cumples' : '∞');

        return [
            'ingresosNuevos' => round($ingresosNuevos, 2),
            'egresosNuevos' => round($egresosNuevos, 2),
            'ahorroMensual' => round($ahorroMensual, 2),
            'pctAhorro' => $pctAhorro,
            'proyeccion' => $proyeccion,
            'diferenciaAhorro' => $diferenciaAhorro,
            'diferenciaSaldo' => $diferenciaSaldo,
            'ahorroObjetivo' => round($ahorroObjetivo, 2),
            'cumpleObjetivo' => $ahorroMensual >= $ahorroObjetivo,
            'saldoFinal' => round($saldoActual, 2),
        ];
    }

    public function updated()
    {
        $sim = $this->getSimulacion();

        $this->dispatch('updateChart', proyeccion: $sim['proyeccion']);
    }
}

<?php

namespace App\Services;

use App\Models\Movimiento;
use App\Models\Cuenta;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class MovimientoRecurrenteService
{
    public function ejecutar(): array
    {
        $hoy       = Carbon::today();
        $procesados = 0;
        $omitidos   = 0;

        $movimientos = Movimiento::where('es_recurrente', true)
            ->whereNotNull('frecuencia_recurrencia')
            ->where(function ($q) use ($hoy) {
                $q->whereNull('fecha_fin_recurrencia')
                  ->orWhere('fecha_fin_recurrencia', '>=', $hoy);
            })
            ->get();

        foreach ($movimientos as $movimiento) {
            $proximaFecha = $this->calcularProximaFecha($movimiento);

            if (!$proximaFecha || $proximaFecha->gt($hoy)) {
                $omitidos++;
                continue;
            }

            $nuevo = $movimiento->replicate();
            $nuevo->fecha           = $hoy;
            $nuevo->ultima_ejecucion = $hoy;
            $nuevo->es_recurrente   = false;
            $nuevo->save();

            $cuenta = Cuenta::find($movimiento->cuenta_id);
            if ($cuenta) {
                if ($movimiento->tipo_movimiento === 'ingreso') {
                    $cuenta->saldo_actual += $movimiento->monto;
                } else {
                    $cuenta->saldo_actual -= $movimiento->monto;
                }
                $cuenta->save();
            }

            $movimiento->ultima_ejecucion = $hoy;
            $movimiento->save();

            $procesados++;
        }

        return [
            'procesados' => $procesados,
            'omitidos'   => $omitidos,
        ];
    }

    private function calcularProximaFecha(Movimiento $movimiento): ?Carbon
    {
        $base = $movimiento->ultima_ejecucion
            ? Carbon::parse($movimiento->ultima_ejecucion)
            : Carbon::parse($movimiento->fecha);

        return match ($movimiento->frecuencia_recurrencia) {
            'diario'   => $base->copy()->addDay(),
            'semanal'  => $base->copy()->addWeek(),
            'mensual'  => $base->copy()->addMonth(),
            default    => null,
        };
    }
}

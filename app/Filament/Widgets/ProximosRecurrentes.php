<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class ProximosRecurrentes extends Widget
{
    protected string $view = 'filament.widgets.proximos-recurrentes';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 9;

    protected function getViewData(): array
    {
        $hoy = Carbon::today();

        $recurrentes = Movimiento::with(['cuenta', 'categoria'])
            ->where('es_recurrente', true)
            ->whereNotNull('frecuencia_recurrencia')
            ->where(function ($q) use ($hoy) {
                $q->whereNull('fecha_fin_recurrencia')
                    ->orWhere('fecha_fin_recurrencia', '>=', $hoy);
            })
            ->get()
            ->map(function ($m) use ($hoy) {
                $base = $m->ultima_ejecucion
                    ? Carbon::parse($m->ultima_ejecucion)
                    : Carbon::parse($m->fecha);

                $proxima = match ($m->frecuencia_recurrencia) {
                    'diario' => $base->copy()->addDay(),
                    'semanal' => $base->copy()->addWeek(),
                    'mensual' => $base->copy()->addMonth(),
                    default => null,
                };

                if (! $proxima) {
                    return null;
                }

                $dias = $hoy->diffInDays($proxima, false);

                if ($dias < 0 || $dias > 7) {
                    return null;
                }

                return [
                    'nombre' => $m->descripcion ?? $m->categoria?->nombre ?? '—',
                    'cuenta' => $m->cuenta?->nombre ?? '—',
                    'tipo' => $m->tipo_movimiento,
                    'monto' => $m->monto,
                    'frecuencia' => $m->frecuencia_recurrencia,
                    'proxima' => $proxima,
                    'dias' => $dias,
                    'es_hoy' => $dias === 0,
                    'es_maniana' => $dias === 1,
                ];
            })
            ->filter()
            ->sortBy('dias')
            ->values();

        return [
            'movimientos' => $recurrentes,
            'total' => $recurrentes->count(),
            'hoy' => $recurrentes->where('es_hoy', true)->count(),
        ];
    }
}

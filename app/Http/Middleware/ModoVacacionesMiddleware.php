<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ModoVacacionesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $settings = Setting::first();

        if (!$settings?->vacaciones_activo) return $next($request);

        $hoy = Carbon::today();
        $inicio = $settings->vacaciones_inicio
            ? Carbon::parse($settings->vacaciones_inicio)
            : null;
        $fin = $settings->vacaciones_fin
            ? Carbon::parse($settings->vacaciones_fin)
            : null;

        // Si pasó la fecha fin, desactivar automáticamente
        if ($fin && $hoy->gt($fin)) {
            $settings->update(['vacaciones_activo' => false]);
            return $next($request);
        }

        // Si aún no empieza, no activar
        if ($inicio && $hoy->lt($inicio)) {
            return $next($request);
        }

        // Guardar en session que estamos en vacaciones
        session(['modo_vacaciones' => true]);

        return $next($request);
    }
}

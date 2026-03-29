<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class MantenimientoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $settings = Setting::first();

        if (!$settings?->mantenimiento_activo) {
            return $next($request);
        }

        $excluidas = [
            'mantenimiento',
            'login',
            'logout',
            'pin/*',
        ];

        foreach ($excluidas as $ruta) {
            if ($request->is($ruta) || $request->is('*/' . $ruta)) {
                return $next($request);
            }
        }

        if (auth()->check() && auth()->user()->email === config('app.admin_email')) {
            return $next($request);
        }

        return redirect()->route('mantenimiento');
    }
}

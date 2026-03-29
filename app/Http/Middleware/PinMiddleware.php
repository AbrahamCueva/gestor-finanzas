<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PinMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (!$user || !$user->pin_activo || !$user->pin) {
            return $next($request);
        }

        $excluidas = [
            'pin/verificar',
            'pin/recuperar',
            'pin/reset',
            'logout',
        ];

        foreach ($excluidas as $ruta) {
            if ($request->is($ruta) || $request->is('*/' . $ruta)) {
                return $next($request);
            }
        }

        $pinVerificado   = session('pin_verificado_en');
        $inactividad     = $user->pin_inactividad_minutos;
        $ahora           = now()->timestamp;

        if ($pinVerificado) {
            $minutosTranscurridos = ($ahora - $pinVerificado) / 60;
            if ($minutosTranscurridos < $inactividad) {
                session(['pin_verificado_en' => $ahora]);
                return $next($request);
            }
        }

        return redirect()->route('pin.verificar')->with('intended', $request->fullUrl());
    }
}

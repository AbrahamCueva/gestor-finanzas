<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (! $user) {
            return $next($request);
        }

        $excluidas = ['2fa/*', 'logout', 'pin/*', 'mantenimiento', 'onboarding*'];
        foreach ($excluidas as $ruta) {
            if ($request->routeIs($ruta) || $request->is($ruta)) {
                return $next($request);
            }
        }

        if (! $user->two_factor_secret) {
            return redirect()->route('2fa.setup');
        }

        if (! $user->two_factor_confirmed) {
            return redirect()->route('2fa.setup');
        }

        if (! session('2fa_verificado')) {
            return redirect()->route('2fa.verificar');
        }

        return $next($request);
    }
}

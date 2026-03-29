<?php

namespace App\Http\Middleware;

use App\Models\Cuenta;
use App\Models\Categoria;
use Closure;
use Illuminate\Http\Request;

class OnboardingMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) return $next($request);

        $user = auth()->user();

        $excluidas = ['onboarding*', 'logout', 'pin/*', 'mantenimiento'];
        foreach ($excluidas as $ruta) {
            if ($request->routeIs($ruta) || $request->is($ruta)) {
                return $next($request);
            }
        }

        if (!$user->onboarding_completado && !Cuenta::exists() && !Categoria::exists()) {
            return redirect()->route('onboarding');
        }

        return $next($request);
    }
}

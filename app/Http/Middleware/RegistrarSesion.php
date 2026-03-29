<?php

namespace App\Http\Middleware;

use App\Models\UserSession;
use Closure;
use Illuminate\Http\Request;

class RegistrarSesion
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            $cacheKey = 'session_reg_' . session()->getId();
            if (!cache()->has($cacheKey)) {
                UserSession::registrar();
                cache()->put($cacheKey, true, now()->addMinutes(5));
            }
        }

        return $response;
    }
}

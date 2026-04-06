<?php

use App\Http\Middleware\MantenimientoMiddleware;
use App\Http\Middleware\ModoVacacionesMiddleware;
use App\Http\Middleware\OnboardingMiddleware;
use App\Http\Middleware\PinMiddleware;
use App\Http\Middleware\RegistrarSesion;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\TwoFactorMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('web', [
            PinMiddleware::class,
            MantenimientoMiddleware::class,
            OnboardingMiddleware::class,
            TwoFactorMiddleware::class,
            RegistrarSesion::class,
            ModoVacacionesMiddleware::class,
            TrustProxies::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

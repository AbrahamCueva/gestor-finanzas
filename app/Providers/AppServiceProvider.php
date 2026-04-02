<?php

namespace App\Providers;

use App\Listeners\AuditarLoginExitoso;
use App\Listeners\AuditarLoginFallido;
use App\Models\ActivityLog;
use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Deuda;
use App\Models\Meta;
use App\Models\Presupuesto;
use App\Models\Subcategoria;
use App\Models\Transferencia;
use App\Models\User;
use App\Observers\ActivityObserver;
use App\Observers\UserObserver;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Logout;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LogoutResponse::class, function () {
            return new class implements LogoutResponse
            {
                public function toResponse($request)
                {
                    return redirect('/');
                }
            };
        });
    }

    public function boot(): void
    {
        Event::listen(Login::class,  AuditarLoginExitoso::class);
        Event::listen(Failed::class, AuditarLoginFallido::class);
        User::observe(UserObserver::class);

        Transferencia::observe(ActivityObserver::class);
        Presupuesto::observe(ActivityObserver::class);
        Meta::observe(ActivityObserver::class);
        Deuda::observe(ActivityObserver::class);
        Cuenta::observe(ActivityObserver::class);
        Categoria::observe(ActivityObserver::class);
        Subcategoria::observe(ActivityObserver::class);

        Event::listen(Login::class, function ($event) {
            ActivityLog::registrar(
                'login',
                'Inicio de sesión — IP: ' . request()->ip(),
                $event->user,
                []
            );
        });

        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                ActivityLog::registrar(
                    'logout',
                    'Cierre de sesión',
                    $event->user,
                    []
                );
            }
        });
    }
}

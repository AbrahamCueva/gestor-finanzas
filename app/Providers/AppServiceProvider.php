<?php

namespace App\Providers;

use App\Listeners\AuditarLoginExitoso;
use App\Listeners\AuditarLoginFallido;
use App\Models\User;
use App\Observers\UserObserver;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
    }
}
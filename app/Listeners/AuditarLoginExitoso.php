<?php

namespace App\Listeners;

use App\Services\AuditoriaService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;

class AuditarLoginExitoso
{
    public function handle(Login $event): void
    {
        app(AuditoriaService::class)->loginExitoso($event->user);
    }
}


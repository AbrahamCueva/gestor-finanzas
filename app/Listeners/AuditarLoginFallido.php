<?php

namespace App\Listeners;

use App\Services\AuditoriaService;
use Illuminate\Auth\Events\Failed;

class AuditarLoginFallido
{
    public function handle(Failed $event): void
    {
        app(AuditoriaService::class)->loginFallido($event->credentials['email'] ?? '');
    }
}

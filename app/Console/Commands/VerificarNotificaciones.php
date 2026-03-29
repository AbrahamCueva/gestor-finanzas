<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Services\NotificacionesService;
use Illuminate\Console\Command;

class VerificarNotificaciones extends Command
{
    protected $signature   = 'ricox:notificaciones';
    protected $description = 'Verifica presupuestos, deudas y metas y envía notificaciones';

    public function handle(): void
    {
        $settings = Setting::first();
        if ($settings?->vacaciones_activo && $settings->vacaciones_pausar_notificaciones) {
            $this->info('🏖️ Modo vacaciones activo — notificaciones pausadas.');
            return;
        }

        app(NotificacionesService::class)->verificarTodo();
        $this->info('Notificaciones verificadas.');
    }
}

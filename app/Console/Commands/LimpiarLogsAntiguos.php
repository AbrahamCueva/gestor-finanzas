<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\SecurityLog;
use Illuminate\Console\Command;

class LimpiarLogsAntiguos extends Command
{
    protected $signature = 'ricox:limpiar-logs
                                {--dias-actividad=90  : Días a conservar en activity_logs}
                                {--dias-seguridad=180 : Días a conservar en security_logs}
                                {--force              : No pedir confirmación}';

    protected $description = 'Elimina logs de actividad y seguridad más antiguos que X días';

    public function handle(): void
    {
        $diasActividad = (int) $this->option('dias-actividad');
        $diasSeguridad = (int) $this->option('dias-seguridad');

        $this->info('🧹 RICOX — Limpieza de logs antiguos');
        $this->newLine();

        // Contar antes de borrar
        $contActividad = ActivityLog::where('created_at', '<', now()->subDays($diasActividad))->count();
        $contSeguridad = SecurityLog::where('created_at', '<', now()->subDays($diasSeguridad))->count();

        $this->table(
            ['Tabla', 'Registros a eliminar', 'Antigüedad'],
            [
                ['activity_logs',  $contActividad, "Más de {$diasActividad} días"],
                ['security_logs',  $contSeguridad, "Más de {$diasSeguridad} días"],
            ]
        );

        if ($contActividad === 0 && $contSeguridad === 0) {
            $this->info('✅ No hay logs antiguos que eliminar.');

            return;
        }

        if (! $this->option('force') && ! $this->confirm('¿Confirmas la eliminación?')) {
            $this->warn('Operación cancelada.');

            return;
        }

        // Eliminar
        $eliminadosActividad = ActivityLog::where('created_at', '<', now()->subDays($diasActividad))->delete();
        $eliminadosSeguridad = SecurityLog::where('created_at', '<', now()->subDays($diasSeguridad))->delete();

        $this->newLine();
        $this->info("✅ activity_logs: {$eliminadosActividad} registros eliminados.");
        $this->info("✅ security_logs: {$eliminadosSeguridad} registros eliminados.");
        $this->newLine();
        $this->comment('Limpieza completada — '.now()->format('d/m/Y H:i'));
    }
}

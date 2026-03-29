<?php

use App\Services\NotificacionesService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Limpieza mensual automática el día 1 a las 3am
Schedule::command('ricox:limpiar-logs --force')->monthlyOn(1, '03:00');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('ricox:tipos-cambio')->dailyAt('08:00');
Schedule::command('ricox:notificaciones')->dailyAt('09:00');
Schedule::call(function () {
    app(NotificacionesService::class)->resumenSemanal();
})->weeklyOn(1, '08:00');

Schedule::command('ricox:recordar-compras')->dailyAt('09:00');
Schedule::command('ricox:resumen-semanal-ia')->weeklyOn(1, '08:00');

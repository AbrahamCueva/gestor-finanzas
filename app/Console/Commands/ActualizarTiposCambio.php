<?php

namespace App\Console\Commands;

use App\Services\TipoCambioService;
use Illuminate\Console\Command;

class ActualizarTiposCambio extends Command
{
    protected $signature   = 'ricox:tipos-cambio';
    protected $description = 'Actualiza los tipos de cambio desde la API';

    public function handle(): void
    {
        $result = app(TipoCambioService::class)->actualizar();

        if ($result['ok']) {
            $this->info('✅ Actualizados: ' . implode(', ', $result['actualizados']));
        } else {
            $this->error('❌ Error: ' . $result['error']);
        }
    }
}

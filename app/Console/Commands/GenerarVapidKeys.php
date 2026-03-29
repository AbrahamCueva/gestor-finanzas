<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\VAPID;

class GenerarVapidKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generar-vapid-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera las claves VAPID para notificaciones push';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $keys = VAPID::createVapidKeys();

        $this->info('Claves VAPID generadas:');
        $this->newLine();
        $this->line('VAPID_PUBLIC_KEY='.$keys['publicKey']);
        $this->line('VAPID_PRIVATE_KEY='.$keys['privateKey']);
        $this->newLine();
        $this->comment('Agrega estas líneas a tu .env');
    }
}

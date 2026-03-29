<?php

namespace App\Services;

use App\Models\TipoCambio;
use App\Models\TipoCambioHistorial;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TipoCambioService
{
    protected string $apiKey;
    protected array $monedas = ['USD', 'EUR', 'BRL', 'CLP'];

    public function __construct()
    {
        $this->apiKey = config('services.exchangerate.key', '');
    }

    public function actualizar(): array
    {
        try {
            $url      = "https://v6.exchangerate-api.com/v6/{$this->apiKey}/latest/PEN";
            $response = Http::timeout(10)->withoutVerifying()->get($url);

            if (!$response->ok()) {
                return ['ok' => false, 'error' => 'Error al conectar con la API'];
            }

            $data = $response->json();

            if ($data['result'] !== 'success') {
                return ['ok' => false, 'error' => $data['error-type'] ?? 'Error desconocido'];
            }

            $rates       = $data['conversion_rates'];
            $actualizados = [];

            foreach ($this->monedas as $moneda) {
                if (!isset($rates[$moneda])) continue;

                $tasa = $rates[$moneda];

                TipoCambio::updateOrCreate(
                    ['moneda_base' => 'PEN', 'moneda_destino' => $moneda],
                    ['tasa' => $tasa, 'actualizado_en' => now()]
                );

                TipoCambioHistorial::updateOrCreate(
                    [
                        'moneda_base'    => 'PEN',
                        'moneda_destino' => $moneda,
                        'fecha'          => now()->toDateString(),
                    ],
                    ['tasa' => $tasa]
                );

                $actualizados[] = $moneda;
            }

            return ['ok' => true, 'actualizados' => $actualizados];

        } catch (\Exception $e) {
            Log::error('TipoCambioService: ' . $e->getMessage());
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }
}
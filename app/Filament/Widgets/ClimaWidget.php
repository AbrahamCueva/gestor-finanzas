<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ClimaWidget extends Widget
{
    protected string $view = 'filament.widgets.clima-widget';
    protected static ?int   $sort = 0; // Primero en el dashboard
    protected int | string | array $columnSpan = 'full';

    public function getClima(): array
    {
        return Cache::remember('clima_lima', 1800, function () {
            try {
                // Open-Meteo — gratis, sin API key
                $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                    'latitude'           => -12.0464, // Lima, Perú
                    'longitude'          => -77.0428,
                    'current'            => 'temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m,apparent_temperature',
                    'timezone'           => 'America/Lima',
                    'forecast_days'      => 1,
                ]);

                if (!$response->ok()) return $this->defaultClima();

                $data    = $response->json();
                $current = $data['current'] ?? [];
                $temp    = $current['temperature_2m'] ?? 0;
                $sensacion = $current['apparent_temperature'] ?? 0;
                $humedad = $current['relative_humidity_2m'] ?? 0;
                $viento  = $current['wind_speed_10m'] ?? 0;
                $codigo  = $current['weather_code'] ?? 0;

                return [
                    'temp'       => round($temp),
                    'sensacion'  => round($sensacion),
                    'humedad'    => $humedad,
                    'viento'     => round($viento),
                    'descripcion'=> $this->getDescripcion($codigo),
                    'emoji'      => $this->getEmoji($codigo),
                    'ciudad'     => 'Lima, Perú',
                    'ok'         => true,
                ];
            } catch (\Exception $e) {
                return $this->defaultClima();
            }
        });
    }

    private function defaultClima(): array
    {
        return [
            'temp' => '--', 'sensacion' => '--',
            'humedad' => '--', 'viento' => '--',
            'descripcion' => 'Sin datos',
            'emoji' => '🌫️', 'ciudad' => 'Lima, Perú', 'ok' => false,
        ];
    }

    private function getDescripcion(int $codigo): string
    {
        return match(true) {
            $codigo === 0              => 'Despejado',
            in_array($codigo, [1,2,3]) => 'Parcialmente nublado',
            in_array($codigo, [45,48]) => 'Neblina / Garúa',
            in_array($codigo, [51,53,55]) => 'Llovizna',
            in_array($codigo, [61,63,65]) => 'Lluvia',
            in_array($codigo, [80,81,82]) => 'Chubascos',
            in_array($codigo, [95,96,99]) => 'Tormenta',
            default                    => 'Nublado',
        };
    }

    private function getEmoji(int $codigo): string
    {
        return match(true) {
            $codigo === 0              => '☀️',
            in_array($codigo, [1,2])   => '⛅',
            $codigo === 3              => '☁️',
            in_array($codigo, [45,48]) => '🌫️',
            in_array($codigo, [51,53,55,61,63,65,80,81,82]) => '🌧️',
            in_array($codigo, [95,96,99]) => '⛈️',
            default                    => '🌥️',
        };
    }
}
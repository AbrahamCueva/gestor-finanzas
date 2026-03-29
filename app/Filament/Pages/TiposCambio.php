<?php

namespace App\Filament\Pages;

use App\Models\TipoCambio;
use App\Services\TipoCambioService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class TiposCambio extends Page
{
    protected string $view = 'filament.pages.tipos-cambio';
    protected static ?string $navigationLabel = 'Tipos de Cambio';
    protected static ?string $title = 'Tipos de Cambio';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;
    protected static string|UnitEnum|null $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 4;

    public bool $actualizando = false;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('actualizar')
                ->label('Actualizar ahora')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->action(function () {
                    $this->actualizando = true;
                    $result = app(TipoCambioService::class)->actualizar();

                    if ($result['ok']) {
                        Notification::make()
                            ->title('Tipos de cambio actualizados')
                            ->body('Se actualizaron: ' . implode(', ', $result['actualizados']))
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Error al actualizar')
                            ->body($result['error'])
                            ->danger()
                            ->send();
                    }

                    $this->actualizando = false;
                }),
        ];
    }

    public function getDatos(): array
    {
        $tasas = TipoCambio::where('moneda_base', 'PEN')->get()->keyBy('moneda_destino');

        $monedas = [
            'USD' => ['nombre' => 'Dólar estadounidense', 'simbolo' => '$',  'bandera' => '🇺🇸'],
            'EUR' => ['nombre' => 'Euro',                 'simbolo' => '€',  'bandera' => '🇪🇺'],
            'BRL' => ['nombre' => 'Real brasileño',       'simbolo' => 'R$', 'bandera' => '🇧🇷'],
            'CLP' => ['nombre' => 'Peso chileno',         'simbolo' => '$',  'bandera' => '🇨🇱'],
        ];

        return [
            'tasas'   => $tasas,
            'monedas' => $monedas,
        ];
    }

    public float $montoConvertir = 100;
    public string $monedaOrigen  = 'PEN';
    public string $monedaDestino = 'USD';

    public function getResultadoConversion(): ?float
    {
        if (!$this->montoConvertir) return null;
        return TipoCambio::convertir($this->montoConvertir, $this->monedaOrigen, $this->monedaDestino);
    }
}

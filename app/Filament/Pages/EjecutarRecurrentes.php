<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Services\MovimientoRecurrenteService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class EjecutarRecurrentes extends Page
{
    protected string $view = 'filament.pages.ejecutar-recurrentes';
    protected static ?string $navigationLabel = 'Recurrentes';
    protected static ?string $title = 'Movimientos Recurrentes';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPath;
    protected static string|UnitEnum|null $navigationGroup = 'Finanzas';
    protected static ?int $navigationSort = 1;
    public int $procesados = 0;
    public int $omitidos   = 0;
    public bool $ejecutado = false;
    public function ejecutarAction(): Action
    {
        return Action::make('ejecutar')
            ->label('Ejecutar ahora')
            ->icon('heroicon-o-play')
            ->color('primary')
            ->requiresConfirmation()
            ->modalHeading('¿Ejecutar movimientos recurrentes?')
            ->modalDescription('Se crearán los movimientos que correspondan a hoy y se actualizarán los saldos de las cuentas.')
            ->modalSubmitActionLabel('Sí, ejecutar')
            ->action(function () {
                $service = new MovimientoRecurrenteService();
                $result  = $service->ejecutar();

                $this->procesados = $result['procesados'];
                $this->omitidos   = $result['omitidos'];
                $this->ejecutado  = true;

                Notification::make()
                    ->title('Recurrentes ejecutados')
                    ->body("{$result['procesados']} movimiento(s) procesado(s), {$result['omitidos']} omitido(s).")
                    ->success()
                    ->send();
            });
    }
}

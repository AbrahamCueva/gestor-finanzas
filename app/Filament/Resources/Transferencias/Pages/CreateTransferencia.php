<?php

namespace App\Filament\Resources\Transferencias\Pages;

use App\Filament\Resources\Transferencias\TransferenciaResource;
use App\Models\Cuenta;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateTransferencia extends CreateRecord
{
    protected static string $resource = TransferenciaResource::class;

    protected function afterCreate(): void
    {
        $transferencia = $this->record;

        $origen  = Cuenta::find($transferencia->cuenta_origen_id)?->nombre ?? '—';
        $destino = Cuenta::find($transferencia->cuenta_destino_id)?->nombre ?? '—';
        $monto   = number_format($transferencia->monto, 2);

        Notification::make()
            ->title('Transferencia realizada')
            ->body("Se transfirió S/ {$monto} de {$origen} → {$destino}")
            ->success()
            ->icon('heroicon-o-banknotes')
            ->sendToDatabase(auth()->user()); // 👈 guarda en DB
    }
}

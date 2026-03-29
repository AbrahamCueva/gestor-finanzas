<?php

namespace App\Filament\Resources\Movimientos\Pages;

use App\Filament\Resources\Movimientos\MovimientoResource;
use App\Models\ActivityLog;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimiento extends CreateRecord
{
    protected static string $resource = MovimientoResource::class;

    protected function afterCreate(): void
    {
        $movimiento = $this->record->load(['categoria', 'subcategoria']);
        $monto = number_format($movimiento->monto, 2);
        $tipo = ucfirst($movimiento->tipo_movimiento);
        $categoria = $movimiento->categoria?->nombre ?? '—';
        $subcat = $movimiento->subcategoria?->nombre ?? '—';

        Notification::make()
            ->title("{$tipo} registrado")
            ->body("S/ {$monto} en {$categoria} › {$subcat}")
            ->icon('heroicon-o-currency-dollar')
            ->color($movimiento->tipo_movimiento === 'ingreso' ? 'success' : 'danger')
            ->sendToDatabase(auth()->user());

        ActivityLog::registrar(
            'crear',
            'Nuevo movimiento: '.($this->record->descripcion ?: $this->record->categoria?->nombre),
            $this->record
        );
    }
}

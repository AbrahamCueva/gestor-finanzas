<?php

namespace App\Filament\Resources\Movimientos\Pages;

use App\Filament\Resources\Movimientos\MovimientoResource;
use App\Models\ActivityLog;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMovimiento extends EditRecord
{
    protected static string $resource = MovimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        ActivityLog::registrar(
            'editar',
            'Movimiento editado: '.($this->record->descripcion ?: $this->record->categoria?->nombre),
            $this->record
        );
    }
}

<?php

namespace App\Filament\Resources\ListaCompras\Pages;

use App\Filament\Resources\ListaCompras\ListaCompraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditListaCompra extends EditRecord
{
    protected static string $resource = ListaCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\ListaCompras\Pages;

use App\Filament\Resources\ListaCompras\ListaCompraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateListaCompra extends CreateRecord
{
    protected static string $resource = ListaCompraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}

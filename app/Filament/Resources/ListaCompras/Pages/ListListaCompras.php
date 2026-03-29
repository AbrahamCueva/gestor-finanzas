<?php

namespace App\Filament\Resources\ListaCompras\Pages;

use App\Filament\Resources\ListaCompras\ListaCompraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListListaCompras extends ListRecords
{
    protected static string $resource = ListaCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

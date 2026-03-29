<?php

namespace App\Filament\Resources\Deudas\Pages;

use App\Filament\Resources\Deudas\DeudaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeudas extends ListRecords
{
    protected static string $resource = DeudaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Deudas\Pages;

use App\Filament\Resources\Deudas\DeudaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeuda extends EditRecord
{
    protected static string $resource = DeudaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

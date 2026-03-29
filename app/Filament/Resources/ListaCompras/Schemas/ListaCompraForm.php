<?php

namespace App\Filament\Resources\ListaCompras\Schemas;

use App\Models\ListaCompra;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ListaCompraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Producto')
                    ->required()
                    ->placeholder('Ej: Pasta de dientes')
                    ->maxLength(255),

                TextInput::make('cantidad')
                    ->label('Cantidad')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),

                TextInput::make('precio_estimado')
                    ->label('Precio estimado')
                    ->numeric()
                    ->prefix('S/')
                    ->placeholder('0.00'),

                Select::make('categoria')
                    ->label('Categoría')
                    ->options(ListaCompra::getCategorias())
                    ->native(false),

                Select::make('prioridad')
                    ->label('Prioridad')
                    ->options([
                        'urgente'       => '🔴 Urgente',
                        'normal'        => '🟡 Normal',
                        'puede_esperar' => '🟢 Puede esperar',
                    ])
                    ->default('normal')
                    ->native(false)
                    ->required(),
            ]);
    }
}

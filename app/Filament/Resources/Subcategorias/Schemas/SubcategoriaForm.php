<?php

namespace App\Filament\Resources\Subcategorias\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class SubcategoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Concepto')
                    ->description('Asocia este registro a una categoría y define sus propiedades.')
                    ->icon('heroicon-m-rectangle-stack')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('categoria_id')
                                    ->relationship(
                                        name: 'categoria',
                                        titleAttribute: 'nombre',
                                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('nombre', 'asc'), // <--- ¡Esto es la clave!
                                    )
                                    ->label('Categoría Padre')
                                    ->placeholder('Selecciona una categoría...')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->columnSpan(1),

                                TextInput::make('nombre')
                                    ->label('Nombre del Concepto')
                                    ->placeholder('Ej. Cena con amigos, Suscripción Netflix...')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),

                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->placeholder('Añade notas adicionales sobre este concepto...')
                            ->rows(3)
                            ->columnSpanFull(),

                        Grid::make(1)
                            ->schema([
                                Toggle::make('activa')
                                    ->label('Disponible para selección')
                                    ->helperText('Si se desactiva, no podrá ser usado en nuevas transacciones.')
                                    ->default(true)
                                    ->onColor('success')
                                    ->onIcon('heroicon-m-check-circle')
                                    ->offIcon('heroicon-m-minus-circle')
                                    ->inline(false),
                            ]),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}

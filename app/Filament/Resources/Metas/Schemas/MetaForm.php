<?php

namespace App\Filament\Resources\Metas\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MetaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la Meta')
                    ->columns(2)
                    ->schema([

                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->placeholder('Ej. Fondo de emergencia')
                            ->columnSpanFull(),

                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('monto_objetivo')
                            ->label('Monto objetivo')
                            ->numeric()
                            ->prefix('S/')
                            ->minValue(0.01)
                            ->required(),

                        TextInput::make('monto_actual')
                            ->label('Monto ahorrado')
                            ->numeric()
                            ->prefix('S/')
                            ->minValue(0)
                            ->default(0),

                        DatePicker::make('fecha_limite')
                            ->label('Fecha límite')
                            ->native(false)
                            ->minDate(now()),

                        ColorPicker::make('color')
                            ->label('Color')
                            ->default('#fbbf24'),

                        Toggle::make('completada')
                            ->label('Completada')
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Deudas\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DeudaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información')
                    ->columns(2)
                    ->schema([

                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->placeholder('Ej. Préstamo personal')
                            ->columnSpanFull(),

                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(2)
                            ->columnSpanFull(),

                        Select::make('tipo')
                            ->label('Tipo')
                            ->options([
                                'debo' => 'Yo debo',
                                'me_deben' => 'Me deben',
                            ])
                            ->required()
                            ->native(false),

                        TextInput::make('acreedor_deudor')
                            ->label('Acreedor / Deudor')
                            ->required()
                            ->placeholder('Nombre de la persona o entidad'),

                        TextInput::make('monto_total')
                            ->label('Monto total')
                            ->numeric()
                            ->prefix('S/')
                            ->minValue(0.01)
                            ->required(),

                        TextInput::make('monto_pagado')
                            ->label('Monto pagado')
                            ->numeric()
                            ->prefix('S/')
                            ->minValue(0)
                            ->default(0),

                        DatePicker::make('fecha_inicio')
                            ->label('Fecha inicio')
                            ->native(false)
                            ->required(),

                        DatePicker::make('fecha_vencimiento')
                            ->label('Fecha vencimiento')
                            ->native(false),

                        Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'pagada' => 'Pagada',
                                'vencida' => 'Vencida',
                            ])
                            ->default('pendiente')
                            ->native(false),

                        ColorPicker::make('color')
                            ->label('Color')
                            ->default('#fbbf24'),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}

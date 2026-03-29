<?php

namespace App\Filament\Resources\Categorias\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Configuración de Categoría / Transacción')
                    ->description('Define los aspectos visuales y el comportamiento del registro.')
                    ->icon('heroicon-m-swatch')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('nombre')
                                    ->label('Nombre')
                                    ->placeholder('Ej. Alimentación, Ventas...')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Select::make('tipo')
                                    ->label('Tipo de Movimiento')
                                    ->options([
                                        'ingreso' => 'Ingreso',
                                        'egreso' => 'Egreso',
                                    ])
                                    ->native(false)
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('icono')
                                    ->label('Icono (Heroicon)')
                                    ->placeholder('heroicon-o-home')
                                    ->helperText('Usa nombres de Heroicons v3.')
                                    ->columnSpan(1),
                            ]),

                        Grid::make(2)
                            ->schema([
                                ColorPicker::make('color')
                                    ->label('Color Distintivo')
                                    ->default('#3b82f6')
                                    ->columnSpan(1),

                                Toggle::make('activa')
                                    ->label('Estado de disponibilidad')
                                    ->helperText('¿Esta opción aparecerá en las selecciones?')
                                    ->default(true)
                                    ->onIcon('heroicon-m-check')
                                    ->offIcon('heroicon-m-x-mark')
                                    ->inline(false)
                                    ->columnSpan(1),
                            ]),

                        Textarea::make('descripcion')
                            ->label('Descripción detallada')
                            ->placeholder('Escribe una nota interna sobre esta categoría...')
                            ->rows(3)
                            ->columnSpanFull(), 
                    ])
                    ->collapsible(),
            ]);
    }
}

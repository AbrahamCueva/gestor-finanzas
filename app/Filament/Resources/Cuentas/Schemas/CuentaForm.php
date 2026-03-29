<?php

namespace App\Filament\Resources\Cuentas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CuentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la Cuenta')
                    ->description('Configura los detalles principales y el estado de tu cuenta.')
                    ->icon('heroicon-m-credit-card')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nombre')
                                    ->label('Nombre de la cuenta')
                                    ->placeholder('Ej. Cuenta Sueldo BCP')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Select::make('tipo_cuenta')
                                    ->label('Tipo de cuenta')
                                    ->options([
                                        'banco' => 'Banco',
                                        'efectivo' => 'Efectivo',
                                        'billetera_digital' => 'Billetera digital',
                                        'ahorro' => 'Ahorro',
                                    ])
                                    ->native(false)
                                    ->required(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('saldo_inicial')
                                    ->label('Saldo inicial')
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('S/')
                                    ->required()
                                    ->placeholder('0.00')
                                    ->extraInputAttributes(
                                        [
                                            'min' => 0,
                                        ]
                                    ),

                                TextInput::make('saldo_actual')
                                    ->label('Saldo actual')
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('S/')
                                    ->required()
                                    ->placeholder('0.00')
                                    ->extraInputAttributes(
                                        [
                                            'min' => 0,
                                        ]
                                    ),

                                TextInput::make('saldo_minimo')
                                    ->label('Alerta saldo mínimo')
                                    ->numeric()
                                    ->prefix('S/')
                                    ->nullable()
                                    ->helperText('Te avisaremos cuando el saldo baje de este monto.')
                                    ->placeholder('Ej: 100.00'),
                            ]),

                        Textarea::make('descripcion')
                            ->label('Descripción adicional')
                            ->rows(3)
                            ->columnSpanFull(),

                        Toggle::make('activa')
                            ->label('¿La cuenta está activa?')
                            ->helperText('Las cuentas inactivas no aparecerán en los reportes rápidos.')
                            ->default(true)
                            ->onColor('success'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

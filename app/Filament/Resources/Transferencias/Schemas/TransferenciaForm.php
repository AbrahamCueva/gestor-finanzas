<?php

namespace App\Filament\Resources\Transferencias\Schemas;

use App\Models\Cuenta;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TransferenciaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Nueva Transferencia')
                    ->description('Mueve fondos entre tus cuentas registradas.')
                    ->icon('heroicon-m-arrows-right-left')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('cuenta_origen_id')
                                    ->label('Desde la cuenta')
                                    ->relationship('cuentaOrigen', 'nombre')
                                    ->prefixIcon('heroicon-m-minus-circle')
                                    ->prefixIconColor('danger')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn ($set) => $set('cuenta_destino_id', null)),

                                Select::make('cuenta_destino_id')
                                    ->label('Hacia la cuenta')
                                    ->relationship(
                                        name: 'cuentaDestino',
                                        titleAttribute: 'nombre',
                                        modifyQueryUsing: fn (Get $get, $query) => $query->where('id', '!=', $get('cuenta_origen_id'))
                                    )
                                    ->prefixIcon('heroicon-m-plus-circle')
                                    ->prefixIconColor('success')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('monto')
                                    ->label('Monto a transferir')
                                    ->numeric()
                                    ->prefix('S/')
                                    ->required()
                                    ->placeholder('0.00')
                                    ->minValue(1)
                                    ->columnSpan(2)
                                    ->extraInputAttributes([
                                        'class' => 'text-xl font-bold text-primary-600',
                                        'min' => 1,
                                    ])
                                    ->minValue(1)
                                    ->maxValue(fn (Get $get) => Cuenta::find($get('cuenta_origen_id'))?->saldo_actual
                                    ),

                                DatePicker::make('fecha')
                                    ->label('Fecha de transferencia')
                                    ->default(now())
                                    ->native(false)
                                    ->required()
                                    ->columnSpan(1),
                            ]),

                        Textarea::make('descripcion')
                            ->label('Nota de transferencia')
                            ->placeholder('Ej: Traspaso de ahorros a cuenta corriente...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}

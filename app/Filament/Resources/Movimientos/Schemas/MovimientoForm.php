<?php

namespace App\Filament\Resources\Movimientos\Schemas;

use App\Models\Cuenta;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class MovimientoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registro de Movimiento')
                    ->description('Ingresa los detalles de la transacción financiera.')
                    ->icon('heroicon-m-banknotes')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('tipo_movimiento')
                                    ->label('Tipo')
                                    ->options([
                                        'ingreso' => 'Ingreso',
                                        'egreso' => 'Egreso',
                                    ])
                                    ->native(false)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn ($set) => $set('categoria_id', null)),

                                Select::make('cuenta_id')
                                    ->relationship('cuenta', 'nombre')
                                    ->label('Cuenta')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live(),

                                Placeholder::make('saldo_cuenta')
                                    ->label('Saldo disponible')
                                    ->content(function (Get $get) {

                                        $cuenta = Cuenta::find($get('cuenta_id'));

                                        if (! $cuenta) {
                                            return 'Seleccione una cuenta';
                                        }

                                        return 'S/ '.number_format($cuenta->saldo_actual, 2);
                                    }),

                                DatePicker::make('fecha')
                                    ->label('Fecha')
                                    ->default(now())
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d/m/Y'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('categoria_id')
                                    ->label('Categoría')
                                    ->relationship(
                                        name: 'categoria',
                                        titleAttribute: 'nombre',
                                        modifyQueryUsing: fn (Get $get, $query) => $query->where('tipo', $get('tipo_movimiento'))
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->required()
                                    ->disabled(fn (Get $get) => ! $get('tipo_movimiento'))
                                    ->afterStateUpdated(fn ($set) => $set('subcategoria_id', null)),

                                Select::make('subcategoria_id')
                                    ->relationship(
                                        name: 'subcategoria',
                                        titleAttribute: 'nombre',
                                        modifyQueryUsing: fn (Get $get, $query) => $query->where('categoria_id', $get('categoria_id'))
                                    )
                                    ->label('Subcategoría')
                                    ->searchable()
                                    ->live()
                                    ->preload()
                                    ->disabled(fn (Get $get) => ! $get('categoria_id')),
                            ]),

                        Section::make()
                            ->schema([
                                TextInput::make('monto')
                                    ->label('Monto de la Operación')
                                    ->numeric()
                                    ->prefix('S/')
                                    ->required()
                                    ->minValue(0)
                                    ->placeholder('0.00')
                                    ->extraInputAttributes([
                                        'style' => 'font-size: 1.5rem; font-weight: bold;',
                                        'min' => 0,
                                    ])
                                    ->rule(function (Get $get) {
                                        return function ($attribute, $value, $fail) use ($get) {

                                            if ($get('tipo_movimiento') !== 'egreso') {
                                                return;
                                            }

                                            $cuenta = Cuenta::find($get('cuenta_id'));

                                            if (! $cuenta) {
                                                return;
                                            }

                                            if ($value > $cuenta->saldo_actual) {
                                                $fail('No tienes suficiente saldo en esta cuenta.');
                                            }
                                        };
                                    }),
                            ])->compact(),

                        Textarea::make('descripcion')
                            ->label('Notas / Concepto')
                            ->rows(2)
                            ->placeholder('Escribe un detalle breve...'),

                        Toggle::make('es_recurrente')
                            ->label('Movimiento recurrente')
                            ->live()
                            ->helperText('Activa para repetir este movimiento automáticamente.')
                            ->inline(false),

                        Grid::make(2)->schema([

                            Select::make('frecuencia_recurrencia')
                                ->label('Frecuencia')
                                ->options([
                                    'diario' => 'Diario',
                                    'semanal' => 'Semanal',
                                    'mensual' => 'Mensual',
                                ])
                                ->prefixIcon('heroicon-m-arrow-path')
                                ->required(fn (Get $get) => $get('es_recurrente'))
                                ->visible(fn (Get $get) => $get('es_recurrente'))
                                ->helperText('¿Con qué frecuencia se repite?'),

                            DatePicker::make('fecha_fin_recurrencia')
                                ->label('Fecha fin')
                                ->native(false)
                                ->minDate(now())
                                ->visible(fn (Get $get) => $get('es_recurrente'))
                                ->helperText('Opcional: cuándo dejar de repetirse.'),

                        ])->visible(fn (Get $get) => $get('es_recurrente')),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}

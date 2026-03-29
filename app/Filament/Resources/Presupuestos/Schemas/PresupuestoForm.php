<?php

namespace App\Filament\Resources\Presupuestos\Schemas;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PresupuestoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Nuevo Presupuesto')
                ->description('Define un límite de gasto por categoría para controlar tus finanzas.')
                ->icon('heroicon-m-chart-pie')
                ->schema([
                    Grid::make(2)->schema([

                        Select::make('categoria_id')
                            ->label('Categoría')
                            ->options(
                                Categoria::where('tipo', 'egreso')
                                    ->where('activa', true)
                                    ->pluck('nombre', 'id')
                            )
                            ->prefixIcon('heroicon-m-tag')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('subcategoria_id', null))
                            ->helperText('Solo se muestran categorías de tipo egreso.'),

                        Select::make('subcategoria_id')
                            ->label('Subcategoría')
                            ->prefixIcon('heroicon-m-tag')
                            ->options(fn (Get $get) =>
                                Subcategoria::where('categoria_id', $get('categoria_id'))
                                    ->where('activa', true)
                                    ->pluck('nombre', 'id')
                            )
                            ->searchable()
                            ->placeholder('Todas las subcategorías')
                            ->helperText('Opcional: filtra a una subcategoría específica.')
                            ->disabled(fn (Get $get) => !$get('categoria_id'))
                            ->live(),

                    ]),
                    TextInput::make('monto_limite')
                        ->label('Monto límite')
                        ->numeric()
                        ->prefix('S/')
                        ->required()
                        ->minValue(1)
                        ->placeholder('0.00')
                        ->rules(['min:0.01'])
                        ->helperText('Monto máximo que deseas gastar. No puede ser negativo ni cero.')
                        ->extraInputAttributes([
                            'min' => 1,
                        ]),
                    Select::make('periodo')
                        ->label('Período')
                        ->options([
                            'semanal' => 'Semanal (7 días)',
                            'mensual' => 'Mensual',
                            'anual'   => 'Anual',
                        ])
                        ->prefixIcon('heroicon-m-calendar-days')
                        ->required()
                        ->default('mensual')
                        ->live()
                        ->afterStateUpdated(function ($state, $set) {
                            match ($state) {
                                'semanal' => $set('fecha_inicio', now()->startOfWeek()->toDateString()),
                                'mensual' => $set('fecha_inicio', now()->startOfMonth()->toDateString()),
                                'anual'   => $set('fecha_inicio', now()->startOfYear()->toDateString()),
                                default   => null,
                            };
                            match ($state) {
                                'semanal' => $set('fecha_fin', now()->endOfWeek()->toDateString()),
                                'mensual' => $set('fecha_fin', now()->endOfMonth()->toDateString()),
                                'anual'   => $set('fecha_fin', now()->endOfYear()->toDateString()),
                                default   => null,
                            };
                        })
                        ->helperText('Selecciona el tipo de período para el presupuesto.'),

                    Grid::make(2)->schema([

                        DatePicker::make('fecha_inicio')
                            ->label('Fecha inicio')
                            ->required()
                            ->native(false)
                            ->default(now()->startOfMonth())
                            ->live()
                            ->afterStateUpdated(function ($state, $set, Get $get) {
                                if (!$state) return;
                                $inicio = \Carbon\Carbon::parse($state);
                                match ($get('periodo')) {
                                    'semanal' => $set('fecha_fin', $inicio->copy()->addDays(6)->toDateString()),
                                    'mensual' => $set('fecha_fin', $inicio->copy()->endOfMonth()->toDateString()),
                                    'anual'   => $set('fecha_fin', $inicio->copy()->endOfYear()->toDateString()),
                                    default   => null,
                                };
                            })
                            ->helperText(fn (Get $get) => match ($get('periodo')) {
                                'semanal' => 'La semana termina 7 días después.',
                                'mensual' => 'El mes termina automáticamente al fin de mes.',
                                'anual'   => 'El año termina el 31 de diciembre.',
                                default   => 'Selecciona el inicio del período.',
                            }),

                        DatePicker::make('fecha_fin')
                            ->label('Fecha fin')
                            ->required()
                            ->native(false)
                            ->default(now()->endOfMonth())
                            ->minDate(fn (Get $get) => $get('fecha_inicio'))
                            ->helperText('Se calcula automáticamente según el período.'),

                    ]),

                    Toggle::make('activo')
                        ->label('Presupuesto activo')
                        ->default(true)
                        ->helperText('Desactiva para pausar el seguimiento sin eliminar.'),

                ])
                ->collapsible()
                ->columnSpanFull(),
        ]);
    }
}

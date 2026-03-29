<?php

namespace App\Filament\Resources\Presupuestos\Tables;

use App\Filament\Exports\PresupuestoExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PresupuestosTable
{
    public static function configure(Table $table): Table
    {
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
            4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
            10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];

        return $table
            ->columns([
                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('monto_limite')
                    ->label('Límite')
                    ->money('PEN')
                    ->sortable()
                    ->color('primary'),

                TextColumn::make('gasto_actual')
                    ->label('Gastado')
                    ->state(fn ($record) => $record->gastoActual())
                    ->money('PEN')
                    ->color(fn ($record) => $record->superado() ? 'danger' : ($record->enAlerta() ? 'warning' : 'success')),

                TextColumn::make('porcentaje')
                    ->label('Progreso')
                    ->state(fn ($record) => $record->porcentaje().'%')
                    ->badge()
                    ->color(fn ($record) => $record->superado() ? 'danger' : ($record->enAlerta() ? 'warning' : 'success')),

                TextColumn::make('periodo')
                    ->label('Período')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->color('gray'),

                TextColumn::make('mes')
                    ->label('Mes')
                    ->formatStateUsing(fn ($state) => $meses[$state] ?? '—')
                    ->sortable(),

                TextColumn::make('anio')
                    ->label('Año')
                    ->sortable(),

                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('periodo')
                    ->label('Período')
                    ->options([
                        'mensual' => 'Mensual',
                        'semanal' => 'Semanal',
                        'anual' => 'Anual',
                    ]),

                SelectFilter::make('mes')
                    ->label('Mes')
                    ->options($meses),

                SelectFilter::make('anio')
                    ->label('Año')
                    ->options(
                        collect(range(now()->year - 2, now()->year + 1))
                            ->mapWithKeys(fn ($y) => [$y => $y])
                            ->toArray()
                    ),

                TernaryFilter::make('activo')
                    ->label('Estado')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar presupuestos')
                    ->exporter(PresupuestoExporter::class)
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(PresupuestoExporter::class)
                        ->label('Exportar seleccionados')
                ]),
            ]);
    }
}

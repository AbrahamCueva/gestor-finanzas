<?php

namespace App\Filament\Resources\Categorias\Tables;

use App\Filament\Exports\CategoriaExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Categoría')
                    ->icon(fn ($record) => $record->icono ?? 'heroicon-o-tag')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('tipo')
                    ->label('Tipo de Movimiento')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ingreso' => 'success',
                        'egreso' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'ingreso' => 'heroicon-m-arrow-trending-up',
                        'egreso' => 'heroicon-m-arrow-trending-down',
                        default => 'heroicon-m-minus',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                ColorColumn::make('color')
                    ->label('Color')
                    ->copyable()
                    ->copyMessage('¡Copiado!')
                    ->copyMessageDuration(1500),

                IconColumn::make('activa')
                    ->label('Estado')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('tipo')
                    ->options([
                        'ingreso' => 'Ingresos',
                        'egreso' => 'Egresos',
                    ])
                    ->native(false),

                SelectFilter::make('activa')
                    ->label('Disponibilidad')
                    ->options([
                        '1' => 'Activas',
                        '0' => 'Inactivas',
                    ])
                    ->native(false),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar categorias')
                    ->exporter(CategoriaExporter::class)
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(CategoriaExporter::class)
                        ->label('Exportar seleccionados'),
                ]),
            ]);
    }
}

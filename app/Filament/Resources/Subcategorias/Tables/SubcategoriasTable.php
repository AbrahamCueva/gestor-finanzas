<?php

namespace App\Filament\Resources\Subcategorias\Tables;

use App\Filament\Exports\SubcategoriaExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SubcategoriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Subcategoría')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('categoria.nombre')
                    ->label('Categoría Principal')
                    ->badge() 
                    ->color('gray')
                    ->icon('heroicon-m-folder')
                    ->sortable()
                    ->searchable(),

                IconColumn::make('activa')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->alignCenter(),

                TextColumn::make('updated_at')
                    ->label('Última edición')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categoria_id')
                    ->label('Filtrar por Categoría')
                    ->relationship('categoria', 'nombre')
                    ->searchable()
                    ->preload()
                    ->native(false),

                SelectFilter::make('activa')
                    ->label('Estado')
                    ->options([
                        '1' => 'Activas',
                        '0' => 'Inactivas',
                    ])
                    ->native(false),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar subcategorias')
                    ->exporter(SubcategoriaExporter::class)
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(SubcategoriaExporter::class)
                        ->label('Exportar seleccionados')
                ]),
            ]);
    }
}

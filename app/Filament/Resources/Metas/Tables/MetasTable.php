<?php

namespace App\Filament\Resources\Metas\Tables;

use App\Filament\Exports\MetaExporter;
use App\Models\Meta;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MetasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Meta')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('monto_actual')
                    ->label('Ahorrado')
                    ->money('PEN')
                    ->color('success'),

                TextColumn::make('monto_objetivo')
                    ->label('Objetivo')
                    ->money('PEN'),

                TextColumn::make('porcentaje')
                    ->label('Progreso')
                    ->state(fn (Meta $r) => $r->porcentaje().'%')
                    ->badge()
                    ->color(fn (Meta $r) => match (true) {
                        $r->porcentaje() >= 100 => 'success',
                        $r->porcentaje() >= 50 => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('fecha_limite')
                    ->label('Fecha límite')
                    ->date('d/m/Y')
                    ->color('gray'),

                IconColumn::make('completada')
                    ->label('Completada')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('completada')->label('Completada'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar metas')
                    ->exporter(MetaExporter::class)
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(MetaExporter::class)
                        ->label('Exportar seleccionados')
                ]),
            ]);
    }
}

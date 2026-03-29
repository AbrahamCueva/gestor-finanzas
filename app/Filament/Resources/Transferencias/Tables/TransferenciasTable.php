<?php

namespace App\Filament\Resources\Transferencias\Tables;

use App\Filament\Exports\TransferenciaExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransferenciasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('cuentaOrigen.nombre')
                    ->label('Flujo de Fondos')
                    ->description(fn ($record) => 'Hacia: '.$record->cuentaDestino->nombre)
                    ->icon('heroicon-m-arrow-right-start-on-rectangle')
                    ->iconColor('gray')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('monto')
                    ->label('Monto')
                    ->money('PEN')
                    ->alignment('right')
                    ->weight('bold')
                    ->color('info')
                    ->sortable(),

                TextColumn::make('descripcion')
                    ->label('Nota')
                    ->limit(20)
                    ->tooltip(fn ($record) => $record->descripcion)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('fecha', 'desc')
            ->filters([
                SelectFilter::make('cuenta_origen_id')
                    ->label('Cuenta de origen')
                    ->relationship('cuentaOrigen', 'nombre')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('cuenta_destino_id')
                    ->label('Cuenta de destino')
                    ->relationship('cuentaDestino', 'nombre')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar')
                    ->exporter(TransferenciaExporter::class),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(TransferenciaExporter::class)
                        ->label('Exportar seleccionados')
                ]),
            ]);
    }
}

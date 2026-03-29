<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use App\Filament\Exports\ActivityLogExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),

                TextColumn::make('accion')
                    ->label('Acción')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'crear' => 'success',
                        'editar' => 'warning',
                        'eliminar' => 'danger',
                        'importar' => 'info',
                        'exportar' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('modelo')
                    ->label('Módulo')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->default('Sistema'),

                TextColumn::make('ip')
                    ->label('IP')
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('accion')
                    ->label('Acción')
                    ->options([
                        'crear' => 'Crear',
                        'editar' => 'Editar',
                        'eliminar' => 'Eliminar',
                        'importar' => 'Importar',
                        'exportar' => 'Exportar',
                    ]),
                SelectFilter::make('modelo')
                    ->label('Módulo')
                    ->options([
                        'Movimiento' => 'Movimientos',
                        'Transferencia' => 'Transferencias',
                        'Cuenta' => 'Cuentas',
                        'Presupuesto' => 'Presupuestos',
                        'Meta' => 'Metas',
                        'Deuda' => 'Deudas',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s')
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar logs')
                    ->exporter(ActivityLogExporter::class)
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                ExportBulkAction::make()
                    ->exporter(ActivityLogExporter::class)
                    ->label('Exportar seleccioandos')
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}

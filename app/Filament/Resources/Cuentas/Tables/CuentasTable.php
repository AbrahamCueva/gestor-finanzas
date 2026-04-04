<?php

namespace App\Filament\Resources\Cuentas\Tables;

use App\Filament\Exports\CuentaExporter;
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

class CuentasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Cuenta')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tipo_cuenta')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'banco' => 'info',
                        'efectivo' => 'success',
                        'billetera_digital' => 'warning',
                        'ahorro' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),

                TextColumn::make('saldo_actual')
                    ->label('Saldo Actual')
                    ->money('PEN')
                    ->sortable()
                    ->alignment('right')
                    ->color(fn ($state) => $state < 0 ? 'danger' : 'success'),

                IconColumn::make('activa')
                    ->label('Estado')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('tipo_cuenta')
                    ->label('Tipo de cuenta')
                    ->options([
                        'banco' => 'Banco',
                        'efectivo' => 'Efectivo',
                        'billetera_digital' => 'Billetera digital',
                        'ahorro' => 'Ahorro',
                    ]),

                TernaryFilter::make('activa')
                    ->label('Estado de cuenta')
                    ->placeholder('Todas')
                    ->trueLabel('Solo Activas')
                    ->falseLabel('Solo Inactivas'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar Cuentas')
                    ->exporter(CuentaExporter::class)
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(CuentaExporter::class)
                        ->label('Exportar seleccionados')
                ]),
            ]);
    }
}

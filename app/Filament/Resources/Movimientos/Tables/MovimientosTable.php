<?php

namespace App\Filament\Resources\Movimientos\Tables;

use App\Filament\Exports\MovimientoExporter;
use App\Models\ActivityLog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MovimientosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('tipo_movimiento')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ingreso' => 'success',
                        'egreso' => 'danger',
                        'ajuste' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('monto')
                    ->label('Monto')
                    ->money('PEN')
                    ->weight('bold')
                    ->alignment('right')
                    ->color(fn ($record): string => match ($record->tipo_movimiento) {
                        'ingreso' => 'success',
                        'egreso' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('cuenta.nombre')
                    ->label('Cuenta')
                    ->icon('heroicon-m-credit-card')
                    ->description(fn ($record) => $record->categoria?->nombre ?? 'Sin categoría'),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(25)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('es_recurrente')
                    ->label('Recurrente')
                    ->badge()
                    ->state(fn ($record) => $record->es_recurrente ? 'Sí' : null)
                    ->color('info')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('fecha', 'desc')
            ->filters([
                SelectFilter::make('tipo_movimiento')
                    ->label('Tipo de Movimiento')
                    ->options([
                        'ingreso' => 'Ingresos',
                        'egreso' => 'Egresos',
                        'ajuste' => 'Ajustes',
                    ]),

                SelectFilter::make('cuenta_id')
                    ->label('Cuenta')
                    ->relationship('cuenta', 'nombre')
                    ->searchable()
                    ->preload(),

                Filter::make('fecha')
                    ->form([
                        DatePicker::make('desde')->label('Desde'),
                        DatePicker::make('hasta')->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['desde'], fn ($query, $date) => $query->whereDate('fecha', '>=', $date))
                            ->when($data['hasta'], fn ($query, $date) => $query->whereDate('fecha', '<=', $date));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['desde'] ?? null) {
                            $indicators[] = 'Desde: '.\Carbon\Carbon::parse($data['desde'])->format('d/m/Y');
                        }
                        if ($data['hasta'] ?? null) {
                            $indicators[] = 'Hasta: '.\Carbon\Carbon::parse($data['hasta'])->format('d/m/Y');
                        }

                        return $indicators;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->after(fn ($record) => ActivityLog::registrar('eliminar', 'Movimiento eliminado: '.$record->descripcion, $record)
                    ),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar movimientos')
                    ->exporter(MovimientoExporter::class),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(MovimientoExporter::class)
                        ->label('Exportar seleccionados'),
                ]),
            ]);
    }
}

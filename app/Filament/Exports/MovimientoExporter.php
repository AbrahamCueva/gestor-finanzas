<?php

namespace App\Filament\Exports;

use App\Models\Movimiento;
use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MovimientoExporter extends Exporter
{
    protected static ?string $model = Movimiento::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),

            ExportColumn::make('fecha')
                ->label('Fecha')
                ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('d/m/Y') : ''),

            ExportColumn::make('tipo_movimiento')
                ->label('Tipo')
                ->formatStateUsing(fn($state) => ucfirst($state)),

            ExportColumn::make('categoria.nombre')
                ->label('Categoría'),

            ExportColumn::make('subcategoria.nombre')
                ->label('Subcategoría'),

            ExportColumn::make('cuenta.nombre')
                ->label('Cuenta'),

            ExportColumn::make('monto')
                ->label('Monto (S/)')
                ->formatStateUsing(fn($state) => number_format($state, 2)),

            ExportColumn::make('descripcion')
                ->label('Descripción'),

            ExportColumn::make('referencia')
                ->label('Referencia'),

            ExportColumn::make('es_recurrente')
                ->label('Recurrente')
                ->formatStateUsing(fn($state) => $state ? 'Sí' : 'No'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Tu exportación de movimientos ha sido completada y se ' . str('ha')->plural($export->successful_rows) . ' exportado ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron al exportar.';
        }

        return $body;
    }
}

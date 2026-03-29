<?php

namespace App\Filament\Exports;

use App\Models\Transferencia;
use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class TransferenciaExporter extends Exporter
{
    protected static ?string $model = Transferencia::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('fecha')
                ->label('Fecha')
                ->formatStateUsing(fn($state) => $state
                    ? Carbon::parse($state)->format('d/m/Y')
                    : ''),

            ExportColumn::make('cuentaOrigen.nombre')
                ->label('Cuenta Origen'),

            ExportColumn::make('cuentaDestino.nombre')
                ->label('Cuenta Destino'),

            ExportColumn::make('monto')
                ->label('Monto (S/)')
                ->formatStateUsing(fn($state) => number_format($state, 2)),

            ExportColumn::make('descripcion')
                ->label('Descripción'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Tu exportación de transferencias ha sido completada y se ' . str('ha')->plural($export->successful_rows) . ' exportado ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron al exportar.';
        }

        return $body;
    }
}

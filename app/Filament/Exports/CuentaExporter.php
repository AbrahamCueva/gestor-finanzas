<?php

namespace App\Filament\Exports;

use App\Models\Cuenta;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class CuentaExporter extends Exporter
{
    protected static ?string $model = Cuenta::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('nombre')
                ->label('Nombre de la Cuenta'),

            ExportColumn::make('tipo_cuenta')
                ->label('Tipo')
                ->formatStateUsing(fn($state) => ucfirst($state)),

            // Formateamos los montos como dinero
            ExportColumn::make('saldo_inicial')
                ->label('Saldo Inicial')
                ->formatStateUsing(fn($state, $record) => $record->moneda . ' ' . number_format($state, 2)),

            ExportColumn::make('saldo_actual')
                ->label('Saldo Actual')
                ->formatStateUsing(fn($state, $record) => $record->moneda . ' ' . number_format($state, 2)),

            ExportColumn::make('saldo_minimo')
                ->label('Saldo Mínimo')
                ->formatStateUsing(fn($state, $record) => $state ? ($record->moneda . ' ' . number_format($state, 2)) : '-'),

            ExportColumn::make('moneda')
                ->label('Divisa'),

            ExportColumn::make('activa')
                ->label('Estado')
                ->formatStateUsing(fn($state) => $state ? 'Activa' : 'Inactiva'),

            ExportColumn::make('descripcion')
                ->label('Notas/Descripción'),

            ExportColumn::make('created_at')
                ->label('Fecha Apertura')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación de tus cuentas ha finalizado y se ' . str('ha')->plural($export->successful_rows) . ' exportado ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron al procesarse.';
        }

        return $body;
    }
}

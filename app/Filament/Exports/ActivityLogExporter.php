<?php

namespace App\Filament\Exports;

use App\Models\ActivityLog;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ActivityLogExporter extends Exporter
{
    protected static ?string $model = ActivityLog::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            // Mostramos el nombre del usuario, no solo el ID
            ExportColumn::make('user.name')
                ->label('Usuario'),

            ExportColumn::make('accion')
                ->label('Acción')
                ->formatStateUsing(fn($state) => strtoupper($state)), // "create" -> "CREATE"

            ExportColumn::make('modelo')
                ->label('Módulo/Tabla')
                ->formatStateUsing(fn($state) => str_replace('App\\Models\\', '', $state)), // Limpia el nombre del modelo

            ExportColumn::make('modelo_id')
                ->label('ID Registro'),

            ExportColumn::make('descripcion')
                ->label('Descripción'),

            // Si "cambios" es un array/JSON, lo hacemos un poco más legible
            ExportColumn::make('cambios')
                ->label('Detalle de Cambios')
                ->formatStateUsing(fn($state) => is_array($state) ? json_encode($state, JSON_UNESCAPED_UNICODE) : $state),

            ExportColumn::make('ip')
                ->label('Dirección IP'),

            ExportColumn::make('created_at')
                ->label('Fecha y Hora')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y H:i:s')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación del log de actividades ha finalizado y se ' . str('ha')->plural($export->successful_rows) . ' exportado ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron al exportar.';
        }

        return $body;
    }
}

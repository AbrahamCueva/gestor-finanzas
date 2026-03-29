<?php

namespace App\Filament\Exports;

use App\Models\Meta;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MetaExporter extends Exporter
{
    protected static ?string $model = Meta::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('nombre')
                ->label('Nombre de la Meta'),

            ExportColumn::make('monto_objetivo')
                ->label('Monto Objetivo')
                ->formatStateUsing(fn($state) => 'S/ ' . number_format($state, 2)),

            ExportColumn::make('monto_actual')
                ->label('Monto Ahorrado')
                ->formatStateUsing(fn($state) => 'S/ ' . number_format($state, 2)),

            // Columna extra para ver el % de progreso
            ExportColumn::make('progreso')
                ->label('% Progreso')
                ->formatStateUsing(function ($record) {
                    if ($record->monto_objetivo <= 0) return '0%';
                    $porcentaje = ($record->monto_actual / $record->monto_objetivo) * 100;
                    return number_format($porcentaje, 1) . '%';
                }),

            ExportColumn::make('fecha_limite')
                ->label('Fecha Límite')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y') ?? 'Sin fecha'),

            ExportColumn::make('completada')
                ->label('¿Lograda?')
                ->formatStateUsing(fn($state) => $state ? 'Sí ✅' : 'En proceso ⏳'),

            ExportColumn::make('descripcion')
                ->label('Notas'),

            ExportColumn::make('created_at')
                ->label('Fecha de Inicio')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación de tus metas financieras ha finalizado y se ' . str('ha')->plural($export->successful_rows) . ' exportado ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron al exportar.';
        }

        return $body;
    }
}

<?php

namespace App\Filament\Exports;

use App\Models\Presupuesto;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PresupuestoExporter extends Exporter
{
    protected static ?string $model = Presupuesto::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            // Nombres en lugar de IDs para que el Excel sea entendible
            ExportColumn::make('categoria.nombre')
                ->label('Categoría'),

            ExportColumn::make('subcategoria.nombre')
                ->label('Subcategoría')
                ->formatStateUsing(fn($state) => $state ?? 'Todas'),

            // Formato de dinero (puedes hardcodear 'S/' si solo usas soles o usar una relación)
            ExportColumn::make('monto_limite')
                ->label('Monto Límite')
                ->formatStateUsing(fn($state) => 'S/ ' . number_format($state, 2)),

            ExportColumn::make('periodo')
                ->label('Periodo')
                ->formatStateUsing(fn($state) => ucfirst($state)), // "mensual", "anual", etc.

            ExportColumn::make('fecha_inicio')
                ->label('Vence Desde')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y')),

            ExportColumn::make('fecha_fin')
                ->label('Vence Hasta')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y')),

            ExportColumn::make('activo')
                ->label('Estado')
                ->formatStateUsing(fn($state) => $state ? 'Vigente' : 'Expirado/Inactivo'),

            ExportColumn::make('created_at')
                ->label('Fecha de Registro')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación de tus presupuestos ha finalizado y se ' . str('ha')->plural($export->successful_rows) . ' exportado ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron.';
        }

        return $body;
    }
}

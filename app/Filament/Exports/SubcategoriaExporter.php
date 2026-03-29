<?php

namespace App\Filament\Exports;

use App\Models\Subcategoria;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class SubcategoriaExporter extends Exporter
{
    protected static ?string $model = Subcategoria::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            // En lugar de mostrar el ID, mostramos el nombre de la categoría relación
            ExportColumn::make('categoria.nombre')
                ->label('Categoría Padre'),

            ExportColumn::make('nombre')
                ->label('Nombre Subcategoría'),

            ExportColumn::make('descripcion')
                ->label('Descripción'),

            ExportColumn::make('activa')
                ->label('Estado')
                ->formatStateUsing(fn($state) => $state ? 'Activa' : 'Inactiva'),

            ExportColumn::make('created_at')
                ->label('Fecha de Creación')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y H:i')),

            ExportColumn::make('updated_at')
                ->label('Última Edición')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación de subcategorías ha finalizado y se ' . str('ha')->plural($export->successful_rows) . ' exportado ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' no se pudieron exportar.';
        }

        return $body;
    }
}

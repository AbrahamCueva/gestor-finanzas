<?php

namespace App\Filament\Exports;

use App\Models\Categoria;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class CategoriaExporter extends Exporter
{
    protected static ?string $model = Categoria::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('nombre')
                ->label('Nombre de Categoría'),

            ExportColumn::make('tipo')
                ->label('Tipo')
                ->formatStateUsing(fn($state) => ucfirst($state)), // "ingreso" -> "Ingreso"

            ExportColumn::make('descripcion')
                ->label('Descripción'),

            ExportColumn::make('activa')
                ->label('Estado')
                ->formatStateUsing(fn($state) => $state ? 'Activa' : 'Inactiva'),

            // Mostramos el color pero quizá con una etiqueta más clara
            ExportColumn::make('color')
                ->label('Código de Color')
                ->formatStateUsing(fn($state) => strtoupper($state)),

            // Formatear fechas para que sean legibles en Excel (D/M/Y)
            ExportColumn::make('created_at')
                ->label('Fecha de Registro')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y H:i')),

            ExportColumn::make('updated_at')
                ->label('Última Actualización')
                ->formatStateUsing(fn($state) => $state?->format('d/m/Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        // ... (tu lógica de traducción que ya quedó perfecta)
        $body = 'La exportación de categorías ha finalizado y se ' . str('ha')->plural($export->successful_rows) . ' exportado ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron.';
        }

        return $body;
    }
}

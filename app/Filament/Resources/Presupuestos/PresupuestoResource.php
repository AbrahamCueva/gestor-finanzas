<?php

namespace App\Filament\Resources\Presupuestos;

use App\Filament\Resources\Presupuestos\Pages\CreatePresupuesto;
use App\Filament\Resources\Presupuestos\Pages\EditPresupuesto;
use App\Filament\Resources\Presupuestos\Pages\ListPresupuestos;
use App\Filament\Resources\Presupuestos\Schemas\PresupuestoForm;
use App\Filament\Resources\Presupuestos\Tables\PresupuestosTable;
use App\Models\Presupuesto;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class PresupuestoResource extends Resource
{
    protected static ?string $model = Presupuesto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartPie;
    protected static string|UnitEnum|null $navigationGroup = 'Finanzas';
    protected static ?string $pluralModelLabel = 'Presupuestos';
    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'categoria.nombre';

    public static function getGloballySearchableAttributes(): array
    {
        return ['categoria.nombre', 'periodo', 'fecha_inicio', 'fecha_fin'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Límite'  => 'S/ ' . number_format($record->monto_limite, 2),
            'Período' => ucfirst($record->periodo),
            'Inicio'  => $record->fecha_inicio->format('Y-m-d'),
            'Fin'     => $record->fecha_fin->format('Y-m-d'),
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('edit', ['record' => $record]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total de presupuestos registrados';
    }

    public static function form(Schema $schema): Schema
    {
        return PresupuestoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PresupuestosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPresupuestos::route('/'),
            'create' => CreatePresupuesto::route('/create'),
            'edit' => EditPresupuesto::route('/{record}/edit'),
        ];
    }
}

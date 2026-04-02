<?php

namespace App\Filament\Resources\Deudas;

use App\Filament\Resources\Deudas\Pages\CreateDeuda;
use App\Filament\Resources\Deudas\Pages\EditDeuda;
use App\Filament\Resources\Deudas\Pages\ListDeudas;
use App\Filament\Resources\Deudas\RelationManagers\AbonosRelationManager;
use App\Filament\Resources\Deudas\Schemas\DeudaForm;
use App\Filament\Resources\Deudas\Tables\DeudasTable;
use App\Models\Deuda;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class DeudaResource extends Resource
{
    protected static ?string $model = Deuda::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowTrendingUp;

    protected static string|UnitEnum|null $navigationGroup = 'Finanzas';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nombre', 'acreedor_deudor'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Tipo' => $record->tipo === 'debo' ? 'Yo debo' : 'Me deben',
            'Restante' => 'S/ '.number_format($record->restante(), 2),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total de deudas registradas';
    }

    public static function form(Schema $schema): Schema
    {
        return DeudaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeudasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AbonosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeudas::route('/'),
            'create' => CreateDeuda::route('/create'),
            'edit' => EditDeuda::route('/{record}/edit'),
        ];
    }
}

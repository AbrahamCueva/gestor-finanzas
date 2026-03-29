<?php

namespace App\Filament\Resources\Subcategorias;

use App\Filament\Resources\Subcategorias\Pages\CreateSubcategoria;
use App\Filament\Resources\Subcategorias\Pages\EditSubcategoria;
use App\Filament\Resources\Subcategorias\Pages\ListSubcategorias;
use App\Filament\Resources\Subcategorias\Schemas\SubcategoriaForm;
use App\Filament\Resources\Subcategorias\Tables\SubcategoriasTable;
use App\Models\Subcategoria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class SubcategoriaResource extends Resource
{
    protected static ?string $model = Subcategoria::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Configuración';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nombre', 'categoria.nombre'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Categoría' => $record->categoria?->nombre ?? '—',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return SubcategoriaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubcategoriasTable::configure($table);
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
            'index' => ListSubcategorias::route('/'),
            'create' => CreateSubcategoria::route('/create'),
            'edit' => EditSubcategoria::route('/{record}/edit'),
        ];
    }
}

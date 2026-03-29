<?php

namespace App\Filament\Resources\ListaCompras;

use App\Filament\Resources\ListaCompras\Pages\CreateListaCompra;
use App\Filament\Resources\ListaCompras\Pages\EditListaCompra;
use App\Filament\Resources\ListaCompras\Pages\ListListaCompras;
use App\Filament\Resources\ListaCompras\Schemas\ListaCompraForm;
use App\Filament\Resources\ListaCompras\Tables\ListaComprasTable;
use App\Models\ListaCompra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ListaCompraResource extends Resource
{
    protected static ?string $model = ListaCompra::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;
    protected static ?string $navigationLabel = 'Lista de Compras';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Lista de Compras';
    protected static string|UnitEnum|null $navigationGroup = 'Finanzas';

    public static function form(Schema $schema): Schema
    {
        return ListaCompraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ListaComprasTable::configure($table);
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
            'index' => ListListaCompras::route('/'),
            'create' => CreateListaCompra::route('/create'),
            'edit' => EditListaCompra::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}

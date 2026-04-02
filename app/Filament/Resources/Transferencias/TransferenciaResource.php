<?php

namespace App\Filament\Resources\Transferencias;

use App\Filament\Resources\Transferencias\Pages\CreateTransferencia;
use App\Filament\Resources\Transferencias\Pages\EditTransferencia;
use App\Filament\Resources\Transferencias\Pages\ListTransferencias;
use App\Filament\Resources\Transferencias\Schemas\TransferenciaForm;
use App\Filament\Resources\Transferencias\Tables\TransferenciasTable;
use App\Models\Transferencia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class TransferenciaResource extends Resource
{
    protected static ?string $model = Transferencia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;
    protected static string|UnitEnum|null $navigationGroup = 'Finanzas';

    protected static ?string $recordTitleAttribute = 'descripcion';

    public static function getGloballySearchableAttributes(): array
    {
        return ['descripcion', 'monto', 'cuentaOrigen.nombre', 'cuentaDestino.nombre'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Origen' => $record->cuentaOrigen?->nombre ?? '—',
            'Destino' => $record->cuentaDestino?->nombre ?? '—',
            'Monto' => 'S/ '.number_format($record->monto, 2),
            'Fecha' => $record->fecha,
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('edit', ['record' => $record]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['cuentaOrigen', 'cuentaDestino']);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total de transferencias registradas';
    }

    public static function form(Schema $schema): Schema
    {
        return TransferenciaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransferenciasTable::configure($table);
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
            'index' => ListTransferencias::route('/'),
            'create' => CreateTransferencia::route('/create'),
            'edit' => EditTransferencia::route('/{record}/edit'),
        ];
    }
}

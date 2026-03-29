<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UltimosMovimientos extends TableWidget
{
    protected static  ?string $heading = 'Últimos Movimientos';

    protected static ?string $description = 'Los 5 movimientos más recientes';

    protected ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 5;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Movimiento::query()
                    ->with(['cuenta', 'categoria', 'subcategoria'])
                    ->latest('fecha')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('tipo_movimiento')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->color(fn ($state) => match ($state) {
                        'ingreso' => 'success',
                        'egreso' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('cuenta.nombre')
                    ->label('Cuenta')
                    ->icon('heroicon-m-building-library')
                    ->iconColor('gray'),

                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->icon('heroicon-m-tag')
                    ->iconColor('gray')
                    ->description(fn ($record) => $record->subcategoria?->nombre),

                TextColumn::make('monto')
                    ->label('Monto')
                    ->money('PEN')
                    ->weight('semibold')
                    ->color(fn ($record) => match ($record->tipo_movimiento) {
                        'ingreso' => 'success',
                        'egreso' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(30)
                    ->placeholder('Sin descripción')
                    ->color('gray'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->paginated(false);
    }
}

<?php

namespace App\Filament\Resources\ListaCompras\Tables;

use App\Models\ListaCompra;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ListaComprasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prioridad_emoji')
                    ->label('')
                    ->getStateUsing(fn($record) => $record->prioridad_emoji)
                    ->html(),

                TextColumn::make('nombre')
                    ->label('Producto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color(fn($record) => $record->comprado ? 'gray' : null),

                TextColumn::make('cantidad')
                    ->label('Cant.')
                    ->sortable(),

                TextColumn::make('categoria')
                    ->label('Categoría')
                    ->formatStateUsing(fn($state) => ListaCompra::getCategorias()[$state] ?? $state)
                    ->badge()
                    ->color('gray'),

                TextColumn::make('precio_estimado')
                    ->label('Precio est.')
                    ->money('PEN')
                    ->sortable(),

                TextColumn::make('prioridad')
                    ->label('Prioridad')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'urgente'       => 'danger',
                        'normal'        => 'warning',
                        'puede_esperar' => 'success',
                        default         => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'urgente'       => 'Urgente',
                        'normal'        => 'Normal',
                        'puede_esperar' => 'Puede esperar',
                        default         => $state,
                    }),

                TextColumn::make('comprado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'warning')
                    ->formatStateUsing(fn($state) => $state ? '✓ Comprado' : 'Pendiente'),

                TextColumn::make('comprado_en')
                    ->label('Comprado el')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->placeholder('—'),
            ])
            ->filters([
                SelectFilter::make('prioridad')
                    ->options([
                        'urgente'       => 'Urgente',
                        'normal'        => 'Normal',
                        'puede_esperar' => 'Puede esperar',
                    ]),
                SelectFilter::make('comprado')
                    ->options([
                        '0' => 'Pendientes',
                        '1' => 'Comprados',
                    ])
                    ->label('Estado'),
            ])
            ->recordActions([
                Action::make('marcar_comprado')
                    ->label('Comprado ✓')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => !$record->comprado)
                    ->requiresConfirmation()
                    ->modalHeading('¿Marcar como comprado?')
                    ->modalSubmitActionLabel('Sí, comprado')
                    ->action(fn($record) => $record->update([
                        'comprado'    => true,
                        'comprado_en' => now(),
                    ])),

                Action::make('desmarcar')
                    ->label('Pendiente')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('warning')
                    ->visible(fn($record) => $record->comprado)
                    ->action(fn($record) => $record->update([
                        'comprado'    => false,
                        'comprado_en' => null,
                    ])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('marcar_comprados')
                        ->label('Marcar como comprados')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each->update([
                            'comprado'    => true,
                            'comprado_en' => now(),
                        ])),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('prioridad', 'asc');
    }
}

<?php

namespace App\Filament\Resources\Deudas\Tables;

use App\Models\Deuda;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DeudasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'debo' => 'danger',
                        'me_deben' => 'success',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'debo' => 'Yo debo',
                        'me_deben' => 'Me deben',
                    }),

                TextColumn::make('acreedor_deudor')
                    ->label('Persona / Entidad')
                    ->searchable(),

                TextColumn::make('monto_total')
                    ->label('Total')
                    ->money('PEN'),

                TextColumn::make('restante')
                    ->label('Restante')
                    ->state(fn (Deuda $r) => 'S/ '.number_format($r->restante(), 2))
                    ->color(fn (Deuda $r) => $r->tipo === 'debo' ? 'danger' : 'success'),

                TextColumn::make('porcentaje')
                    ->label('Pagado')
                    ->state(fn (Deuda $r) => $r->porcentaje().'%')
                    ->badge()
                    ->color(fn (Deuda $r) => match (true) {
                        $r->porcentaje() >= 100 => 'success',
                        $r->porcentaje() >= 50 => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('fecha_vencimiento')
                    ->label('Vencimiento')
                    ->date('d/m/Y')
                    ->color(fn (Deuda $r) => $r->estaVencida() ? 'danger' : 'gray'),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pagada' => 'success',
                        'vencida' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state) => ucfirst($state)),
            ])
            ->filters([
                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'debo' => 'Yo debo',
                        'me_deben' => 'Me deben',
                    ]),
                SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'pagada' => 'Pagada',
                        'vencida' => 'Vencida',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

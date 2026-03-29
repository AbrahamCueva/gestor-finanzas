<?php

namespace App\Filament\Resources\Deudas\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AbonosRelationManager extends RelationManager
{
    protected static string $relationship = 'abonos';

    protected static ?string $title = 'Historial de Abonos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->columns(2)->schema([

                    TextInput::make('monto')
                        ->label('Monto del abono')
                        ->numeric()
                        ->prefix('S/')
                        ->minValue(0.01)
                        ->required(),

                    DatePicker::make('fecha')
                        ->label('Fecha del abono')
                        ->native(false)
                        ->default(now())
                        ->required(),

                    Textarea::make('nota')
                        ->label('Nota')
                        ->rows(2)
                        ->columnSpanFull(),

                ])
                ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('monto')
            ->columns([
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('monto')
                    ->label('Monto')
                    ->money('PEN')
                    ->color('success')
                    ->weight('bold'),

                TextColumn::make('nota')
                    ->label('Nota')
                    ->limit(40)
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->since()
                    ->color('gray'),
            ])
            ->filters([
                //
            ])
            ->defaultSort('fecha', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->label('Registrar abono')
                    ->after(fn ($record) => $record->deuda->recalcularPagado()),
            ])
            ->recordActions([
                DissociateAction::make(),
                EditAction::make()
                    ->after(fn ($record) => $record->deuda->recalcularPagado()),
                DeleteAction::make()
                    ->after(fn ($record) => $record->deuda->recalcularPagado()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\NotaFinanciera;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class NotasFinancieras extends Page
{
    protected string $view = 'filament.pages.notas-financieras';
    protected static ?string $navigationLabel = 'Notas Financieras';
    protected static ?string $title = 'Notas Financieras';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;
    protected static string|UnitEnum|null $navigationGroup = 'Finanzas';
    protected static ?int $navigationSort = 9;

    public string $buscar = '';
    public string $filtroTipo = '';

    public function getNotas(): object
    {
        return NotaFinanciera::where('user_id', auth()->id())
            ->when($this->buscar, fn ($q) => $q->where(function ($q) {
                $q->where('titulo', 'like', "%{$this->buscar}%")
                  ->orWhere('contenido', 'like', "%{$this->buscar}%");
            }))
            ->when($this->filtroTipo, fn ($q) => $q->where('tipo', $this->filtroTipo))
            ->orderByDesc('fijada')
            ->orderByDesc('created_at')
            ->get();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('nueva')
                ->label('Nueva nota')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->form($this->getFormFields())
                ->action(function (array $data) {
                    NotaFinanciera::create([
                        ...$data,
                        'user_id' => auth()->id(),
                    ]);
                    Notification::make()->title('Nota creada')->success()->send();
                }),
        ];
    }

    public function editarNota(int $id): void
    {
        // Se maneja desde el blade con modal
    }

    public function eliminarNota(int $id): void
    {
        NotaFinanciera::where('user_id', auth()->id())->find($id)?->delete();
        Notification::make()->title('Nota eliminada')->success()->send();
    }

    public function toggleFijada(int $id): void
    {
        $nota = NotaFinanciera::where('user_id', auth()->id())->find($id);
        if ($nota) {
            $nota->update(['fijada' => !$nota->fijada]);
        }
    }

    public function getFormFields(): array
    {
        return [
            TextInput::make('titulo')
                ->label('Título')
                ->required()
                ->maxLength(255)
                ->placeholder('Ej: Recordar pagar luz'),

            Select::make('tipo')
                ->label('Tipo')
                ->options([
                    'nota'          => '📝 Nota',
                    'recordatorio'  => '⏰ Recordatorio',
                    'idea'          => '💡 Idea',
                ])
                ->default('nota')
                ->native(false)
                ->required(),

            Textarea::make('contenido')
                ->label('Contenido')
                ->rows(4)
                ->placeholder('Escribe tu nota aquí...'),

            ColorPicker::make('color')
                ->label('Color')
                ->default('#fbbf24'),

            DateTimePicker::make('recordar_en')
                ->label('Recordar en (opcional)')
                ->native(false)
                ->placeholder('Selecciona fecha y hora'),
        ];
    }
}

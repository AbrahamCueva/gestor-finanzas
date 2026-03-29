<?php

namespace App\Filament\Pages;

use App\Models\ActivityLog;
use App\Models\SecurityLog;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class LimpiezaLogs extends Page
{
    protected string $view = 'filament.pages.limpieza-logs';
    protected static ?string $navigationLabel = 'Limpieza de Logs';
    protected static ?string $title = 'Limpieza de Logs';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrash;
    protected static string|UnitEnum|null $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 12;

    public int $diasActividad = 90;
    public int $diasSeguridad = 180;

    public function getEstadisticas(): array
    {
        return [
            'totalActividad'   => ActivityLog::count(),
            'totalSeguridad'   => SecurityLog::count(),
            'aEliminarActividad' => ActivityLog::where('created_at', '<', now()->subDays($this->diasActividad))->count(),
            'aEliminarSeguridad' => SecurityLog::where('created_at', '<', now()->subDays($this->diasSeguridad))->count(),
            'masAntiguoActividad'=> ActivityLog::oldest()->first()?->created_at?->format('d/m/Y') ?? '—',
            'masAntiguoSeguridad'=> SecurityLog::oldest()->first()?->created_at?->format('d/m/Y') ?? '—',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('limpiar')
                ->label('Ejecutar limpieza')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('¿Confirmar limpieza?')
                ->modalDescription('Esta acción eliminará los logs según la configuración. No se puede deshacer.')
                ->modalSubmitActionLabel('Sí, limpiar')
                ->action(fn () => $this->ejecutarLimpieza()),
        ];
    }

    public function ejecutarLimpieza(): void
    {
        $eliminadosActividad = ActivityLog::where('created_at', '<', now()->subDays($this->diasActividad))->delete();
        $eliminadosSeguridad = SecurityLog::where('created_at', '<', now()->subDays($this->diasSeguridad))->delete();

        $total = $eliminadosActividad + $eliminadosSeguridad;

        Notification::make()
            ->title("🧹 Limpieza completada — {$total} registros eliminados")
            ->body("Activity logs: {$eliminadosActividad} | Security logs: {$eliminadosSeguridad}")
            ->success()
            ->send();
    }
}
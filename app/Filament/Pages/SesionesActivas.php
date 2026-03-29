<?php

namespace App\Filament\Pages;

use App\Models\UserSession;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class SesionesActivas extends Page
{
    protected string $view = 'filament.pages.sesiones-activas';
    protected static ?string $navigationLabel = 'Sesiones Activas';
    protected static ?string $title = 'Sesiones Activas';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDevicePhoneMobile;
    protected static string|UnitEnum|null $navigationGroup = 'Ajustes de Usuario';
    protected static ?int $navigationSort = 3;

    public function getSesiones(): object
    {
        return UserSession::where('user_id', auth()->id())
            ->orderByDesc('ultima_actividad')
            ->get();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cerrar_otras')
                ->label('Cerrar otras sesiones')
                ->icon('heroicon-o-arrow-right-on-rectangle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('¿Cerrar todas las otras sesiones?')
                ->modalDescription('Se cerrarán todas las sesiones excepto la actual.')
                ->modalSubmitActionLabel('Sí, cerrar')
                ->action(fn () => $this->cerrarOtras()),
        ];
    }

    public function cerrarSesion(int $id): void
    {
        $sesion = UserSession::where('user_id', auth()->id())->find($id);

        if (!$sesion) return;

        if ($sesion->actual) {
            Notification::make()->title('No puedes cerrar la sesión actual desde aquí.')->warning()->send();
            return;
        }

        try {
            DB::table('sessions')
                ->where('id', $sesion->session_id)
                ->delete();
        } catch (\Exception $e) {}

        $sesion->delete();

        Notification::make()->title('Sesión cerrada correctamente.')->success()->send();
    }

    public function cerrarOtras(): void
    {
        $sessionActual = session()->getId();

        $sesiones = UserSession::where('user_id', auth()->id())
            ->where('session_id', '!=', $sessionActual)
            ->get();

        foreach ($sesiones as $s) {
            try {
                DB::table('sessions')
                    ->where('id', $s->session_id)
                    ->delete();
            } catch (\Exception $e) {}
            $s->delete();
        }

        Notification::make()
            ->title("✅ {$sesiones->count()} sesión(es) cerrada(s)")
            ->success()
            ->send();
    }
}

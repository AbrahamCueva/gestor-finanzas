<?php

namespace App\Services;

use App\Models\SecurityLog;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuditoriaService
{
    public function loginExitoso(User $user): void
    {
        $ip         = request()->ip();
        $userAgent  = request()->userAgent() ?? '';
        $sospechoso = false;
        $detalle    = null;

        $ipsConocidas = SecurityLog::where('user_id', $user->id)
            ->where('evento', 'login_exitoso')
            ->where('sospechoso', false)
            ->pluck('ip')
            ->unique()
            ->toArray();

        if (!empty($ipsConocidas) && !in_array($ip, $ipsConocidas)) {
            $sospechoso = true;
            $detalle    = "Login desde IP nueva: {$ip}";
            $this->notificar($user, '⚠️ Acceso desde IP nueva', "Se detectó un acceso a tu cuenta desde una IP desconocida: {$ip}");
        }

        $navegador = SecurityLog::detectarNavegadorPublico($userAgent);
        $navegadoresConocidos = SecurityLog::where('user_id', $user->id)
            ->where('evento', 'login_exitoso')
            ->pluck('navegador')
            ->unique()
            ->toArray();

        if (!empty($navegadoresConocidos) && !in_array($navegador, $navegadoresConocidos)) {
            $sospechoso = true;
            $detalle    = ($detalle ? $detalle . ' | ' : '') . "Nuevo navegador: {$navegador}";
            $this->notificar($user, '⚠️ Nuevo navegador detectado', "Se accedió a tu cuenta desde un navegador desconocido: {$navegador}");
        }

        SecurityLog::create([
            'user_id'     => $user->id,
            'evento'      => 'login_exitoso',
            'ip'          => $ip,
            'user_agent'  => $userAgent,
            'dispositivo' => SecurityLog::detectarDispositivoPublico($userAgent),
            'navegador'   => $navegador,
            'sospechoso'  => $sospechoso,
            'detalle'     => $detalle,
        ]);
    }

    public function loginFallido(string $email): void
    {
        $ip       = request()->ip();
        $cacheKey = "login_fallido_{$ip}";
        $intentos = cache()->increment($cacheKey);
        cache()->put($cacheKey, $intentos, now()->addHour());

        $sospechoso = $intentos >= 3;
        $detalle    = "Intento #{$intentos} fallido para: {$email}";

        $user = User::where('email', $email)->first();

        SecurityLog::create([
            'user_id'     => $user?->id,
            'evento'      => 'login_fallido',
            'ip'          => $ip,
            'user_agent'  => request()->userAgent(),
            'dispositivo' => SecurityLog::detectarDispositivoPublico(request()->userAgent() ?? ''),
            'navegador'   => SecurityLog::detectarNavegadorPublico(request()->userAgent() ?? ''),
            'sospechoso'  => $sospechoso,
            'detalle'     => $detalle,
        ]);

        if ($sospechoso && $user) {
            $this->notificar($user,
                '🚨 Múltiples intentos fallidos',
                "Se detectaron {$intentos} intentos fallidos de inicio de sesión desde la IP: {$ip}"
            );
        }
    }

    public function cambioPassword(User $user): void
    {
        SecurityLog::create([
            'user_id'     => $user->id,
            'evento'      => 'cambio_password',
            'ip'          => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'dispositivo' => SecurityLog::detectarDispositivoPublico(request()->userAgent() ?? ''),
            'navegador'   => SecurityLog::detectarNavegadorPublico(request()->userAgent() ?? ''),
            'sospechoso'  => false,
            'detalle'     => 'Contraseña actualizada',
        ]);

        $this->notificar($user, '🔑 Contraseña cambiada', 'Tu contraseña fue actualizada. Si no fuiste tú, contacta soporte.');
    }

    public function cambioPin(User $user): void
    {
        SecurityLog::create([
            'user_id'     => $user->id,
            'evento'      => 'cambio_pin',
            'ip'          => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'dispositivo' => SecurityLog::detectarDispositivoPublico(request()->userAgent() ?? ''),
            'navegador'   => SecurityLog::detectarNavegadorPublico(request()->userAgent() ?? ''),
            'sospechoso'  => false,
            'detalle'     => 'PIN de acceso actualizado',
        ]);

        $this->notificar($user, '🔒 PIN cambiado', 'Tu PIN de acceso fue actualizado. Si no fuiste tú, revisa tu seguridad.');
    }

    public function descargaBackup(User $user): void
    {
        SecurityLog::create([
            'user_id'     => $user->id,
            'evento'      => 'descarga_backup',
            'ip'          => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'dispositivo' => SecurityLog::detectarDispositivoPublico(request()->userAgent() ?? ''),
            'navegador'   => SecurityLog::detectarNavegadorPublico(request()->userAgent() ?? ''),
            'sospechoso'  => false,
            'detalle'     => 'Backup descargado',
        ]);

        $this->notificar($user, '🗄️ Backup descargado', 'Se realizó una descarga del backup de tus datos.');
    }

    private function notificar(User $user, string $titulo, string $mensaje): void
    {
        Notification::make()
            ->title($titulo)
            ->body($mensaje)
            ->warning()
            ->persistent()
            ->actions([
                Action::make('ver')
                    ->label('Ver auditoría')
                    ->url(route('filament.admin.pages.auditoria-seguridad'))
                    ->button(),
            ])
            ->sendToDatabase($user);

        try {
            Mail::send([], [], function ($message) use ($user, $titulo, $mensaje) {
                $message->to($user->email)
                    ->subject($titulo . ' — RICOX')
                    ->html("
                        <div style='font-family:sans-serif; max-width:480px; margin:auto;'>
                            <h2 style='color:#fbbf24;'>{$titulo}</h2>
                            <p style='color:#374151; line-height:1.6;'>{$mensaje}</p>
                            <p style='color:#6b7280; font-size:12px; margin-top:16px;'>
                                Fecha: " . now()->format('d/m/Y H:i') . "<br>
                                IP: " . request()->ip() . "
                            </p>
                            <hr style='border:none; border-top:1px solid #e5e7eb; margin:20px 0;'>
                            <p style='color:#9ca3af; font-size:11px;'>Este es un mensaje automático de seguridad de RICOX.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $table = 'user_sessions';

    protected $fillable = [
        'user_id', 'session_id', 'ip', 'user_agent',
        'dispositivo', 'navegador', 'pais', 'ultima_actividad', 'actual',
    ];

    protected $casts = [
        'ultima_actividad' => 'datetime',
        'actual'           => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function registrar(): void
    {
        $user      = auth()->user();
        $sessionId = session()->getId();
        $ua        = request()->userAgent() ?? '';

        if (!$user) return;

        static::where('user_id', $user->id)
            ->where('session_id', '!=', $sessionId)
            ->update(['actual' => false]);

        static::updateOrCreate(
            ['session_id' => $sessionId],
            [
                'user_id'           => $user->id,
                'ip'                => request()->ip(),
                'user_agent'        => $ua,
                'dispositivo'       => static::detectarDispositivo($ua),
                'navegador'         => static::detectarNavegador($ua),
                'ultima_actividad'  => now(),
                'actual'            => true,
            ]
        );
    }

    public static function detectarDispositivo(string $ua): string
    {
        if (str_contains($ua, 'Mobile') || str_contains($ua, 'Android')) return 'Móvil';
        if (str_contains($ua, 'Tablet') || str_contains($ua, 'iPad'))    return 'Tablet';
        return 'Escritorio';
    }

    public static function detectarNavegador(string $ua): string
    {
        if (str_contains($ua, 'Edg'))     return 'Edge';
        if (str_contains($ua, 'Chrome'))  return 'Chrome';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Safari'))  return 'Safari';
        if (str_contains($ua, 'Opera'))   return 'Opera';
        return 'Desconocido';
    }

    public function getIconoDispositivo(): string
    {
        return match($this->dispositivo) {
            'Móvil'     => '📱',
            'Tablet'    => '📲',
            default     => '🖥️',
        };
    }

    public function getIconoNavegador(): string
    {
        return match($this->navegador) {
            'Chrome'  => '🔵',
            'Firefox' => '🦊',
            'Safari'  => '🧭',
            'Edge'    => '🔷',
            default   => '🌐',
        };
    }
}

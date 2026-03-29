<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    protected $fillable = [
        'user_id', 'evento', 'ip', 'user_agent',
        'dispositivo', 'navegador', 'sospechoso', 'detalle',
    ];

    protected $casts = ['sospechoso' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function registrar(string $evento, bool $sospechoso = false, ?string $detalle = null): void
    {
        $request = request();
        $userAgent = $request->userAgent() ?? '';
        $dispositivo = self::detectarDispositivo($userAgent);
        $navegador = self::detectarNavegador($userAgent);

        static::create([
            'user_id' => auth()->id(),
            'evento' => $evento,
            'ip' => $request->ip(),
            'user_agent' => $userAgent,
            'dispositivo' => $dispositivo,
            'navegador' => $navegador,
            'sospechoso' => $sospechoso,
            'detalle' => $detalle,
        ]);
    }

    private static function detectarDispositivo(string $ua): string
    {
        if (str_contains($ua, 'Mobile') || str_contains($ua, 'Android')) {
            return 'Móvil';
        }
        if (str_contains($ua, 'Tablet') || str_contains($ua, 'iPad')) {
            return 'Tablet';
        }

        return 'Escritorio';
    }

    private static function detectarNavegador(string $ua): string
    {
        if (str_contains($ua, 'Chrome')) {
            return 'Chrome';
        }
        if (str_contains($ua, 'Firefox')) {
            return 'Firefox';
        }
        if (str_contains($ua, 'Safari')) {
            return 'Safari';
        }
        if (str_contains($ua, 'Edge')) {
            return 'Edge';
        }
        if (str_contains($ua, 'Opera')) {
            return 'Opera';
        }

        return 'Desconocido';
    }

    public static function detectarDispositivoPublico(string $ua): string
    {
        return self::detectarDispositivo($ua);
    }

    public static function detectarNavegadorPublico(string $ua): string
    {
        return self::detectarNavegador($ua);
    }
}

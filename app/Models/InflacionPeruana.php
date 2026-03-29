<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InflacionPeruana extends Model
{
    protected $table = 'inflacion_peruana';

    protected $fillable = ['anio', 'mes', 'tasa_mensual', 'tasa_anual', 'fuente'];

    protected $casts = [
        'tasa_mensual' => 'decimal:4',
        'tasa_anual'   => 'decimal:4',
    ];

    public static function getTasaMensual(int $anio, int $mes): float
    {
        return (float) static::where('anio', $anio)
            ->where('mes', $mes)
            ->value('tasa_mensual') ?? 0.10;
    }

    public static function getTasaAnual(int $anio): float
    {
        return (float) static::where('anio', $anio)
            ->where('mes', 12)
            ->value('tasa_anual') ?? 2.00;
    }

    public static function getUltimaTasa(): float
    {
        $ultimo = static::orderByDesc('anio')->orderByDesc('mes')->first();
        return (float) ($ultimo?->tasa_anual ?? 2.00);
    }
}
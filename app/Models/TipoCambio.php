<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $table = 'tipos_cambio';

    protected $fillable = ['moneda_base', 'moneda_destino', 'tasa', 'actualizado_en'];

    protected $casts = [
        'tasa'           => 'decimal:6',
        'actualizado_en' => 'datetime',
    ];

    public static function monedas(): array
    {
        return [
            'USD' => 'Dólar estadounidense',
            'EUR' => 'Euro',
            'BRL' => 'Real brasileño',
            'CLP' => 'Peso chileno',
        ];
    }

    public static function convertir(float $monto, string $desde, string $destino): float
    {
        if ($desde === $destino) return $monto;

        if ($desde === 'PEN') {
            $tc = self::where('moneda_base', 'PEN')
                ->where('moneda_destino', $destino)
                ->first();
            return $tc ? round($monto * $tc->tasa, 2) : $monto;
        }

        if ($destino === 'PEN') {
            $tc = self::where('moneda_base', 'PEN')
                ->where('moneda_destino', $desde)
                ->first();
            return $tc ? round($monto / $tc->tasa, 2) : $monto;
        }

        $aPen    = self::convertir($monto, $desde, 'PEN');
        return self::convertir($aPen, 'PEN', $destino);
    }
}

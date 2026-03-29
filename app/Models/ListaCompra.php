<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaCompra extends Model
{
    protected $table = 'lista_compras';

    protected $fillable = [
        'user_id', 'nombre', 'cantidad', 'precio_estimado',
        'categoria', 'prioridad', 'comprado', 'comprado_en', 'ultimo_recordatorio',
    ];

    protected $casts = [
        'comprado'            => 'boolean',
        'comprado_en'         => 'datetime',
        'ultimo_recordatorio' => 'datetime',
        'precio_estimado'     => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPrioridadColorAttribute(): string
    {
        return match($this->prioridad) {
            'urgente'        => '#ef4444',
            'normal'         => '#fbbf24',
            'puede_esperar'  => '#22c55e',
            default          => '#6b7280',
        };
    }

    public function getPrioridadEmojiAttribute(): string
    {
        return match($this->prioridad) {
            'urgente'        => '🔴',
            'normal'         => '🟡',
            'puede_esperar'  => '🟢',
            default          => '⚪',
        };
    }

    public static function getCategorias(): array
    {
        return [
            'limpieza'      => '🧹 Limpieza',
            'comida'        => '🍎 Comida',
            'higiene'       => '🧴 Higiene personal',
            'ropa'          => '👕 Ropa',
            'electronico'   => '💻 Electrónico',
            'salud'         => '💊 Salud',
            'hogar'         => '🏠 Hogar',
            'entretenimiento'=> '🎮 Entretenimiento',
            'otro'          => '📦 Otro',
        ];
    }
}
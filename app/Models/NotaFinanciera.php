<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaFinanciera extends Model
{
    protected $table = 'notas_financieras';

    protected $fillable = [
        'user_id', 'titulo', 'contenido',
        'color', 'tipo', 'fijada', 'recordar_en',
    ];

    protected $casts = [
        'fijada'      => 'boolean',
        'recordar_en' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTipoEmojiAttribute(): string
    {
        return match($this->tipo) {
            'recordatorio' => '⏰',
            'idea'         => '💡',
            default        => '📝',
        };
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'accion', 'modelo',
        'modelo_id', 'descripcion', 'cambios', 'ip',
    ];

    protected $casts = ['cambios' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function registrar(string $accion, string $descripcion, ?Model $modelo = null, ?array $cambios = null): void
    {
        static::create([
            'user_id'     => auth()->id(),
            'accion'      => $accion,
            'modelo'      => $modelo ? class_basename($modelo) : null,
            'modelo_id'   => $modelo?->id,
            'descripcion' => $descripcion,
            'cambios'     => $cambios,
            'ip'          => request()->ip(),
        ]);
    }
}

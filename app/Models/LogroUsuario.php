<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogroUsuario extends Model
{
    protected $table = 'logros_usuario';

    protected $fillable = ['user_id', 'logro_key', 'desbloqueado_en'];

    protected $casts = ['desbloqueado_en' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
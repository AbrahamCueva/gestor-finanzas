<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCambioHistorial extends Model
{
    protected $table = 'tipos_cambio_historial';

    protected $fillable = [
        'moneda_base', 'moneda_destino', 'tasa', 'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
        'tasa'  => 'float',
    ];
}
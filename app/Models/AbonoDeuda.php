<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbonoDeuda extends Model
{
    protected $table = 'abonos_deuda';

    protected $fillable = ['deuda_id', 'monto', 'fecha', 'nota'];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public function deuda()
    {
        return $this->belongsTo(Deuda::class);
    }
}

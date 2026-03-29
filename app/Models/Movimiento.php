<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';

    protected $fillable = [
        'tipo_movimiento',
        'cuenta_id',
        'categoria_id',
        'subcategoria_id',
        'monto',
        'fecha',
        'descripcion',
        'referencia',
        'es_recurrente',
        'frecuencia_recurrencia',
        'fecha_fin_recurrencia',
        'ultima_ejecucion',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_fin_recurrencia' => 'date',
        'ultima_ejecucion' => 'date',
        'es_recurrente' => 'boolean',
    ];

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }

    protected static function booted()
    {
        static::created(function ($movimiento) {

            $cuenta = $movimiento->cuenta;

            if ($movimiento->tipo_movimiento === 'ingreso') {

                $cuenta->saldo_actual += $movimiento->monto;

            }

            if ($movimiento->tipo_movimiento === 'egreso') {

                if ($cuenta->saldo_actual < $movimiento->monto) {
                    throw new \Exception('Saldo insuficiente en la cuenta.');
                }

                $cuenta->saldo_actual -= $movimiento->monto;

            }

            $cuenta->save();
        });
    }
}

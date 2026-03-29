<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuenta_origen_id',
        'cuenta_destino_id',
        'monto',
        'fecha',
        'descripcion',
    ];

    public function cuentaOrigen()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_origen_id');
    }

    public function cuentaDestino()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_destino_id');
    }

    protected static function booted()
    {
        static::creating(function ($transferencia) {

            if ($transferencia->cuenta_origen_id === $transferencia->cuenta_destino_id) {
                throw new \Exception('No se puede transferir dinero a la misma cuenta.');
            }

            $origen = Cuenta::find($transferencia->cuenta_origen_id);

            if (! $origen) {
                throw new \Exception('La cuenta de origen no existe.');
            }

            if ($origen->saldo_actual < $transferencia->monto) {
                throw new \Exception('Saldo insuficiente en la cuenta de origen.');
            }
        });

        static::created(function ($transferencia) {

            DB::transaction(function () use ($transferencia) {

                $origen = $transferencia->cuentaOrigen;
                $destino = $transferencia->cuentaDestino;

                $origen->saldo_actual -= $transferencia->monto;
                $destino->saldo_actual += $transferencia->monto;

                $origen->save();
                $destino->save();
            });
        });
    }
}

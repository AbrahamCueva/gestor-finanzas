<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'tipo', 'monto_total',
        'monto_pagado', 'fecha_inicio', 'fecha_vencimiento',
        'acreedor_deudor', 'estado', 'color',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_vencimiento' => 'date',
        'monto_total' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
    ];

    public function porcentaje(): float
    {
        if ($this->monto_total <= 0) {
            return 0;
        }

        return min(100, round(($this->monto_pagado / $this->monto_total) * 100, 1));
    }

    public function restante(): float
    {
        return max(0, $this->monto_total - $this->monto_pagado);
    }

    public function diasRestantes(): ?int
    {
        if (! $this->fecha_vencimiento) {
            return null;
        }

        return now()->diffInDays($this->fecha_vencimiento, false);
    }

    public function estaVencida(): bool
    {
        return $this->fecha_vencimiento && now()->gt($this->fecha_vencimiento) && $this->estado !== 'pagada';
    }

    public function abonos()
    {
        return $this->hasMany(AbonoDeuda::class);
    }

    public function recalcularPagado(): void
    {
        $this->monto_pagado = $this->abonos()->sum('monto');

        if ($this->monto_pagado >= $this->monto_total) {
            $this->estado = 'pagada';
        }

        $this->save();
    }
}

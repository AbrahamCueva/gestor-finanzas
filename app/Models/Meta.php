<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'monto_objetivo',
        'monto_actual', 'fecha_limite', 'icono', 'color', 'completada',
    ];

    protected $casts = [
        'fecha_limite' => 'date',
        'completada' => 'boolean',
        'monto_objetivo' => 'decimal:2',
        'monto_actual' => 'decimal:2',
    ];

    public function porcentaje(): float
    {
        if ($this->monto_objetivo <= 0) {
            return 0;
        }

        return min(100, round(($this->monto_actual / $this->monto_objetivo) * 100, 1));
    }

    public function restante(): float
    {
        return max(0, $this->monto_objetivo - $this->monto_actual);
    }

    public function diasRestantes(): ?int
    {
        if (! $this->fecha_limite) {
            return null;
        }

        return max(0, now()->diffInDays($this->fecha_limite, false));
    }
}

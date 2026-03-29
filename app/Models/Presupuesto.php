<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'subcategoria_id',
        'monto_limite',
        'periodo',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function gastoActual(): float
    {
        $settings = Setting::first();
        if ($settings?->vacaciones_activo && $settings->vacaciones_pausar_presupuestos) {
            return 0;
        }

        return Movimiento::where('categoria_id', $this->categoria_id)
            ->when($this->subcategoria_id, fn($q) => $q->where('subcategoria_id', $this->subcategoria_id))
            ->where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$this->fecha_inicio, $this->fecha_fin])
            ->sum('monto');
    }

    public function porcentaje(): float
    {
        if ($this->monto_limite <= 0) {
            return 0;
        }

        return min(100, round(($this->gastoActual() / $this->monto_limite) * 100, 1));
    }

    public function enAlerta(): bool
    {
        return $this->porcentaje() >= 80;
    }

    public function superado(): bool
    {
        return $this->gastoActual() >= $this->monto_limite;
    }
}

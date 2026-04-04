<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reto extends Model
{
    protected $fillable = [
        'user_id', 'nombre', 'descripcion', 'tipo', 'icono', 'color',
        'meta_monto', 'categoria_id', 'meta_dias', 'fecha_inicio', 'fecha_fin',
        'dificultad', 'puntos', 'estado', 'progreso_actual', 'completado_en',
    ];

    protected $casts = [
        'fecha_inicio'  => 'date',
        'fecha_fin'     => 'date',
        'completado_en' => 'datetime',
        'meta_monto'    => 'decimal:2',
        'progreso_actual' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function porcentaje(): float
    {
        if ($this->tipo === 'dias_consecutivos') {
            $meta = $this->meta_dias ?: 1;
            return min(100, round(($this->progreso_actual / $meta) * 100, 1));
        }
        $meta = $this->meta_monto ?: 1;
        return min(100, round(($this->progreso_actual / $meta) * 100, 1));
    }

    public function diasRestantes(): int
    {
        return max(0, now()->diffInDays($this->fecha_fin, false));
    }

    public function diasTranscurridos(): int
    {
        return max(0, Carbon::parse($this->fecha_inicio)->diffInDays(now()));
    }

    public function calcularProgreso(): void
    {
        $inicio = $this->fecha_inicio;
        $fin    = $this->fecha_fin->isFuture() ? now() : $this->fecha_fin;

        $progreso = match ($this->tipo) {
            'ahorro' => $this->calcularAhorro($inicio, $fin),
            'egreso_categoria' => $this->calcularEgresoCategoria($inicio, $fin),
            'sin_gastos' => $this->calcularDiasSinGastos($inicio, $fin),
            'ingreso' => $this->calcularIngreso($inicio, $fin),
            'dias_consecutivos' => $this->calcularDiasConsecutivos($inicio, $fin),
            default => 0,
        };

        $this->progreso_actual = $progreso;

        // Verificar si se completó
        if ($this->estado === 'activo') {
            $completado = match ($this->tipo) {
                'ahorro', 'ingreso' => $progreso >= $this->meta_monto,
                'egreso_categoria'  => $progreso <= $this->meta_monto,
                'sin_gastos', 'dias_consecutivos' => $progreso >= $this->meta_dias,
                default => false,
            };

            if ($completado) {
                $this->estado       = 'completado';
                $this->completado_en = now();
            } elseif ($this->fecha_fin->isPast() && $this->estado === 'activo') {
                $this->estado = 'fallido';
            }
        }

        $this->saveQuietly();
    }

    private function calcularAhorro($inicio, $fin): float
    {
        $ingresos = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
        $egresos  = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
        return max(0, round($ingresos - $egresos, 2));
    }

    private function calcularEgresoCategoria($inicio, $fin): float
    {
        return round(Movimiento::where('tipo_movimiento', 'egreso')
            ->where('categoria_id', $this->categoria_id)
            ->whereBetween('fecha', [$inicio, $fin])
            ->sum('monto'), 2);
    }

    private function calcularDiasSinGastos($inicio, $fin): int
    {
        $diasConGastos = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicio, $fin])
            ->selectRaw('DATE(fecha) as dia')
            ->distinct()
            ->count();
        $totalDias = Carbon::parse($inicio)->diffInDays($fin) + 1;
        return max(0, $totalDias - $diasConGastos);
    }

    private function calcularIngreso($inicio, $fin): float
    {
        return round(Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicio, $fin])
            ->sum('monto'), 2);
    }

    private function calcularDiasConsecutivos($inicio, $fin): int
    {
        // Días consecutivos registrando al menos un movimiento
        $fechasConMovs = Movimiento::whereBetween('fecha', [$inicio, $fin])
            ->selectRaw('DATE(fecha) as dia')
            ->distinct()
            ->orderBy('dia')
            ->pluck('dia')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->toArray();

        $maxConsecutivos = 0;
        $consecutivos    = 0;
        $anterior        = null;

        foreach ($fechasConMovs as $fecha) {
            if ($anterior && Carbon::parse($fecha)->diffInDays($anterior) === 1) {
                $consecutivos++;
            } else {
                $consecutivos = 1;
            }
            $maxConsecutivos = max($maxConsecutivos, $consecutivos);
            $anterior = $fecha;
        }

        return $maxConsecutivos;
    }
}
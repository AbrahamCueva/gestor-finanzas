<?php

namespace App\Filament\Widgets;

use App\Models\Presupuesto;
use Filament\Widgets\Widget;

class PresupuestosDashboard extends Widget
{
    protected string $view = 'filament.widgets.presupuestos-dashboard';
    protected ?string $pollingInterval = '60s';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;

    public function getViewData(): array
    {
        $presupuestos = Presupuesto::with(['categoria', 'subcategoria'])
            ->where('activo', true)
            ->whereDate('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->get()
            ->map(function ($p) {
                $gasto      = $p->gastoActual();
                $porcentaje = $p->porcentaje();
                $disponible = max(0, $p->monto_limite - $gasto);

                return [
                    'nombre'      => $p->subcategoria?->nombre
                                        ? $p->categoria->nombre . ' › ' . $p->subcategoria->nombre
                                        : $p->categoria->nombre,
                    'limite'      => $p->monto_limite,
                    'gasto'       => $gasto,
                    'disponible'  => $disponible,
                    'porcentaje'  => $porcentaje,
                    'superado'    => $p->superado(),
                    'alerta'      => $p->enAlerta(),
                    'periodo'     => ucfirst($p->periodo),
                    'fecha_inicio' => $p->fecha_inicio->format('d/m/Y'),
                    'fecha_fin'   => $p->fecha_fin->format('d/m/Y'),
                    'color'       => $p->superado() ? 'red' : ($p->enAlerta() ? 'yellow' : 'green'),
                ];
            });

        return [
            'presupuestos' => $presupuestos,
            'total'        => $presupuestos->count(),
            'superados'    => $presupuestos->where('superado', true)->count(),
            'en_alerta'    => $presupuestos->where('alerta', true)->where('superado', false)->count(),
        ];
    }
}

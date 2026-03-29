<?php

namespace App\Filament\Widgets;

use App\Models\Deuda;
use Filament\Widgets\Widget;

class DeudasWidget extends Widget
{
    protected string $view = 'filament.widgets.deudas-widget';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 7;

    protected function getViewData(): array
    {
        $deudas = Deuda::where('estado', '!=', 'pagada')
            ->orderBy('fecha_vencimiento')
            ->get();

        return [
            'deudas'       => $deudas,
            'totalDebo'    => Deuda::where('tipo', 'debo')->where('estado', '!=', 'pagada')->sum('monto_total') - Deuda::where('tipo', 'debo')->where('estado', '!=', 'pagada')->sum('monto_pagado'),
            'totalMeDeben' => Deuda::where('tipo', 'me_deben')->where('estado', '!=', 'pagada')->sum('monto_total') - Deuda::where('tipo', 'me_deben')->where('estado', '!=', 'pagada')->sum('monto_pagado'),
            'vencidas'     => $deudas->filter(fn ($d) => $d->estaVencida())->count(),
        ];
    }
}

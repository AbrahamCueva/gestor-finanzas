<?php

namespace App\Filament\Widgets;

use App\Models\Meta;
use Filament\Widgets\Widget;

class MetasWidget extends Widget
{
    protected string $view = 'filament.widgets.metas-widget';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 6;

    protected function getViewData(): array
    {
        $metas = Meta::where('completada', false)
            ->orderBy('fecha_limite')
            ->get();

        return [
            'metas'      => $metas,
            'total'      => $metas->count(),
            'completadas' => Meta::where('completada', true)->count(),
        ];
    }
}

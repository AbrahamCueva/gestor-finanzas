<?php

namespace App\Filament\Pages;

use App\Models\LogroUsuario;
use App\Services\LogrosService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class LogrosNivel extends Page
{
    protected string $view = 'filament.pages.logros-nivel';
    protected static ?string $navigationLabel = 'Logros y Nivel';
    protected static ?string $title = 'Logros y Nivel Financiero';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 9;

    public function getDatos(): array
    {
        $user   = auth()->user();
        $def    = LogrosService::definiciones();
        $unlock = LogroUsuario::where('user_id', $user->id)->get()->keyBy('logro_key');
        $puntos = LogrosService::getPuntosTotales();
        $nivel  = LogrosService::nivel($puntos);

        $logros = [];
        foreach ($def as $key => $info) {
            $logros[] = array_merge($info, [
                'key'            => $key,
                'desbloqueado'   => $unlock->has($key),
                'desbloqueado_en'=> $unlock->get($key)?->desbloqueado_en?->format('d/m/Y') ?? null,
                'puntos'         => LogrosService::puntajeLogro($key),
            ]);
        }

        $porCategoria = collect($logros)->groupBy('categoria');

        $progreso = 0;
        if ($nivel['siguiente']) {
            $rango    = $nivel['siguiente'] - $nivel['puntosNivel'];
            $actual   = $puntos - $nivel['puntosNivel'];
            $progreso = min(100, round(($actual / $rango) * 100));
        } else {
            $progreso = 100;
        }

        return [
            'puntos'        => $puntos,
            'nivel'         => $nivel,
            'progreso'      => $progreso,
            'porCategoria'  => $porCategoria,
            'total'         => count($def),
            'desbloqueados' => $unlock->count(),
        ];
    }
}

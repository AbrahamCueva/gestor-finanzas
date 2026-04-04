<?php

namespace App\Filament\Pages;

use App\Models\TipoCambio;
use App\Models\TipoCambioHistorial;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class HistorialTiposCambio extends Page
{
    protected string $view = 'filament.pages.historial-tipos-cambio';

    protected static ?string $navigationLabel = 'Historial Tipos de Cambio';

    protected static ?string $title = 'Historial de Tipos de Cambio';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPresentationChartLine;

    protected static string|UnitEnum|null $navigationGroup = 'Análisis';

    protected static ?int $navigationSort = 7;

    public string $moneda = 'USD';

    public string $periodo = '30';

    public function getMonedas(): array
    {
        return [
            'USD' => ['label' => 'Dólar', 'color' => '#60a5fa', 'emoji' => '🇺🇸'],
            'EUR' => ['label' => 'Euro', 'color' => '#a78bfa', 'emoji' => '🇪🇺'],
            'BRL' => ['label' => 'Real brasileño', 'color' => '#34d399', 'emoji' => '🇧🇷'],
            'CLP' => ['label' => 'Peso chileno', 'color' => '#fb923c', 'emoji' => '🇨🇱'],
        ];
    }

    public function getDatos(): array
    {
        $dias = (int) $this->periodo;

        $historial = TipoCambioHistorial::where('moneda_base', 'PEN')
            ->where('moneda_destino', $this->moneda)
            ->where('fecha', '>=', now()->subDays($dias)->toDateString())
            ->orderBy('fecha')
            ->get();

        if ($historial->isEmpty()) {
            $actual = TipoCambio::where('moneda_base', 'PEN')
                ->where('moneda_destino', $this->moneda)
                ->latest('actualizado_en')
                ->first();

            return [
                'labels' => [now()->format('d/m')],
                'valores' => [$actual?->tasa ?? 0],
                'actual' => $actual?->tasa ?? 0,
                'maximo' => $actual?->tasa ?? 0,
                'minimo' => $actual?->tasa ?? 0,
                'variacion' => 0,
            ];
        }

        $labels = $historial->map(fn($r) => $r->fecha->format('d/m'))->toArray();
        $valores = $historial->pluck('tasa')->map(fn($t) => round($t, 4))->toArray();
        $actual = last($valores);
        $primero = $valores[0];
        $maximo = max($valores);
        $minimo = min($valores);
        $variacion = $primero > 0 ? round((($actual - $primero) / $primero) * 100, 2) : 0;

        return compact('labels', 'valores', 'actual', 'maximo', 'minimo', 'variacion');
    }

    public function getTodasMonedas(): array
    {
        $resultado = [];
        foreach ($this->getMonedas() as $code => $info) {
            $registro = TipoCambio::where('moneda_base', 'PEN')
                ->where('moneda_destino', $code)
                ->latest('actualizado_en')
                ->first();

            $resultado[$code] = array_merge($info, [
                'tasa' => $registro?->tasa ?? '—',
                'actualizado' => $registro?->actualizado_en
                    ? Carbon::parse($registro->actualizado_en)->diffForHumans()
                    : 'Sin datos',
            ]);
        }

        return $resultado;
    }

    public function updated($property): void
    {
        if (in_array($property, ['moneda', 'periodo'])) {
            $datos = $this->getDatos();
            $monedas = $this->getMonedas();
            $this->dispatch('updateHtcChart', [
                'labels' => $datos['labels'],
                'valores' => $datos['valores'],
                'color' => $monedas[$this->moneda]['color'] ?? '#fbbf24',
                'moneda' => $this->moneda,
            ]);
        }
    }
}

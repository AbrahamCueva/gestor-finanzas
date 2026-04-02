<?php

namespace App\Filament\Pages;

use App\Models\Deuda;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class MetodoDeudas extends Page
{
    protected string $view = 'filament.pages.metodo-deudas';
    protected static ?string $navigationLabel = 'Método Deudas';
    protected static ?string $title = 'Avalancha vs Bola de Nieve';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowTrendingDown;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 22;

    public float $pagoMensualExtra = 200;
    public string $metodo          = 'avalancha';

    public function getDeudas(): array
    {
        return Deuda::where('estado', '!=', 'pagada')
            ->where('tipo', 'debo')
            ->get()
            ->map(fn($d) => [
                'id'       => $d->id,
                'nombre'   => $d->nombre,
                'restante' => round($d->restante(), 2),
                'interes'  => $d->tasa_interes ?? 0,
                'minimo'   => $d->pago_minimo ?? round($d->restante() * 0.05, 2),
            ])
            ->toArray();
    }

    public function simularMetodo(array $deudas, string $metodo): array
    {
        if (empty($deudas)) return [];

        // Ordenar según método
        usort($deudas, function($a, $b) use ($metodo) {
            if ($metodo === 'avalancha') {
                return $b['interes'] <=> $a['interes']; // Mayor interés primero
            }
            return $a['restante'] <=> $b['restante']; // Menor deuda primero
        });

        $saldos     = array_column($deudas, 'restante', 'id');
        $intereses  = array_column($deudas, 'interes',  'id');
        $minimos    = array_column($deudas, 'minimo',   'id');
        $nombres    = array_column($deudas, 'nombre',   'id');

        $mes             = 0;
        $totalIntereses  = 0;
        $historial       = [];
        $ordenPago       = array_column($deudas, 'id');
        $pagadas         = [];

        while (!empty($saldos) && $mes < 120) { // máx 10 años
            $mes++;
            $extraDisponible = $this->pagoMensualExtra;
            $snapshotMes     = [];

            // Aplicar interés mensual y pago mínimo
            foreach ($saldos as $id => $saldo) {
                $interesMes    = $saldo * ($intereses[$id] / 100 / 12);
                $totalIntereses += $interesMes;
                $saldo         += $interesMes;
                $saldo         -= $minimos[$id];
                $saldos[$id]   = max(0, $saldo);
            }

            // Aplicar pago extra a la deuda objetivo
            foreach ($ordenPago as $id) {
                if (!isset($saldos[$id]) || $saldos[$id] <= 0) continue;
                $pago          = min($extraDisponible, $saldos[$id]);
                $saldos[$id]  -= $pago;
                $extraDisponible -= $pago;
                if ($extraDisponible <= 0) break;
            }

            // Eliminar deudas pagadas
            foreach ($saldos as $id => $saldo) {
                if ($saldo <= 0) {
                    $pagadas[] = ['nombre' => $nombres[$id], 'mes' => $mes];
                    unset($saldos[$id]);
                    // El mínimo liberado se suma al extra del siguiente
                    $this->pagoMensualExtra += $minimos[$id];
                    unset($minimos[$id]);
                }
            }

            $snapshotMes = array_map(fn($s) => round($s, 2), $saldos);
            $historial[] = [
                'mes'    => $mes,
                'saldos' => $snapshotMes,
                'total'  => round(array_sum($snapshotMes), 2),
            ];

            if (empty($saldos)) break;
        }

        // Restaurar el extra original
        $this->pagoMensualExtra = request()->old('pagoMensualExtra', $this->pagoMensualExtra);

        return [
            'meses'          => $mes,
            'totalIntereses' => round($totalIntereses, 2),
            'orden'          => array_map(fn($id) => $nombres[$id] ?? '', $ordenPago),
            'pagadas'        => $pagadas,
            'historial'      => array_slice($historial, 0, 24), // max 24 meses para gráfico
        ];
    }

    public function getDatos(): array
    {
        $deudas = $this->getDeudas();

        if (empty($deudas)) return ['deudas' => [], 'avalancha' => [], 'bolaDeNieve' => []];

        $extra = $this->pagoMensualExtra;

        $avalancha   = $this->simularMetodo($deudas, 'avalancha');
        $this->pagoMensualExtra = $extra;
        $bolaDeNieve = $this->simularMetodo($deudas, 'bola_de_nieve');
        $this->pagoMensualExtra = $extra;

        $totalDeuda = array_sum(array_column($deudas, 'restante'));

        return [
            'deudas'      => $deudas,
            'totalDeuda'  => $totalDeuda,
            'avalancha'   => $avalancha,
            'bolaDeNieve' => $bolaDeNieve,
            'recomendado' => $avalancha['totalIntereses'] <= $bolaDeNieve['totalIntereses']
                ? 'avalancha' : 'bola_de_nieve',
        ];
    }
}
<?php

namespace App\Filament\Pages;

use App\Models\TipoCambio;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class CalculadoraFinanciera extends Page
{
    protected string $view = 'filament.pages.calculadora-financiera';
    protected static ?string $navigationLabel = 'Calculadora Financiera';
    protected static ?string $title = 'Calculadora Financiera';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 8;

    public string $tab = 'interes';
    public float  $int_capital    = 1000;
    public float  $int_tasa       = 5;
    public int    $int_periodo    = 12;
    public string $int_tipo       = 'compuesto';
    public string $int_frecuencia = 'mensual';
    public ?array $int_resultado  = null;
    public float  $prest_monto   = 10000;
    public float  $prest_tasa    = 12;
    public int    $prest_cuotas  = 24;
    public ?array $prest_tabla   = null;
    public ?array $prest_resumen = null;
    public float $meta_objetivo  = 5000;
    public float $meta_ahorro    = 200;
    public float $meta_tasa      = 3;
    public ?array $meta_resultado = null;
    public float  $conv_monto  = 100;
    public string $conv_desde  = 'PEN';
    public string $conv_hacia  = 'USD';
    public ?float $conv_resultado = null;
    public function calcularInteres(): void
    {
        $C = $this->int_capital;
        $r = $this->int_tasa / 100;
        $n = $this->int_periodo;

        $tasaPeriodo = match($this->int_frecuencia) {
            'mensual'   => $r / 12,
            'trimestral'=> $r / 4,
            'anual'     => $r,
            default     => $r / 12,
        };

        if ($this->int_tipo === 'simple') {
            $interes = $C * $tasaPeriodo * $n;
            $total   = $C + $interes;
        } else {
            $total   = $C * pow(1 + $tasaPeriodo, $n);
            $interes = $total - $C;
        }

        $tabla = [];
        $acumulado = $C;
        for ($i = 1; $i <= min($n, 60); $i++) {
            if ($this->int_tipo === 'simple') {
                $acumulado = $C + ($C * $tasaPeriodo * $i);
            } else {
                $acumulado = $C * pow(1 + $tasaPeriodo, $i);
            }
            $tabla[] = [
                'periodo'   => $i,
                'saldo'     => round($acumulado, 2),
                'interes'   => round($acumulado - $C, 2),
            ];
        }

        $this->int_resultado = [
            'capital'  => round($C, 2),
            'interes'  => round($interes, 2),
            'total'    => round($total, 2),
            'ganancia' => round(($interes / $C) * 100, 2),
            'tabla'    => $tabla,
        ];
    }
    public function calcularPrestamo(): void
    {
        $P = $this->prest_monto;
        $r = ($this->prest_tasa / 100) / 12;
        $n = $this->prest_cuotas;

        if ($r == 0) {
            $cuota = $P / $n;
        } else {
            $cuota = $P * ($r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1);
        }

        $tabla   = [];
        $saldo   = $P;
        $totalIntereses = 0;

        for ($i = 1; $i <= $n; $i++) {
            $interesMes   = $saldo * $r;
            $amortizacion = $cuota - $interesMes;
            $saldo        -= $amortizacion;
            $totalIntereses += $interesMes;

            $tabla[] = [
                'cuota'        => $i,
                'pago'         => round($cuota, 2),
                'interes'      => round($interesMes, 2),
                'amortizacion' => round($amortizacion, 2),
                'saldo'        => round(max($saldo, 0), 2),
            ];
        }

        $this->prest_resumen = [
            'cuota_mensual'  => round($cuota, 2),
            'total_pagar'    => round($cuota * $n, 2),
            'total_intereses'=> round($totalIntereses, 2),
            'porcentaje_int' => round(($totalIntereses / $P) * 100, 2),
        ];
        $this->prest_tabla = $tabla;
    }
    public function calcularMeta(): void
    {
        $objetivo = $this->meta_objetivo;
        $ahorro   = $this->meta_ahorro;
        $tasa     = ($this->meta_tasa / 100) / 12;

        if ($ahorro <= 0) {
            $this->meta_resultado = ['error' => 'El ahorro mensual debe ser mayor a 0'];
            return;
        }

        if ($tasa == 0) {
            $meses = ceil($objetivo / $ahorro);
        } else {
            $meses = ceil(log(1 + ($objetivo * $tasa / $ahorro)) / log(1 + $tasa));
        }

        $anios   = intdiv($meses, 12);
        $mesesR  = $meses % 12;
        $totalAportado = $ahorro * $meses;
        $interesesGanados = $objetivo - $totalAportado;

        $proyeccion = [];
        $acumulado  = 0;
        for ($i = 1; $i <= min($meses, 60); $i++) {
            $acumulado = $acumulado * (1 + $tasa) + $ahorro;
            $proyeccion[] = [
                'mes'       => $i,
                'saldo'     => round($acumulado, 2),
                'aportado'  => round($ahorro * $i, 2),
            ];
        }

        $this->meta_resultado = [
            'meses'            => $meses,
            'anios'            => $anios,
            'meses_restantes'  => $mesesR,
            'total_aportado'   => round($totalAportado, 2),
            'intereses'        => round(max($interesesGanados, 0), 2),
            'fecha_estimada'   => now()->addMonths($meses)->translatedFormat('F Y'),
            'proyeccion'       => $proyeccion,
        ];
    }
    public function calcularConversion(): void
    {
        $monedas = ['PEN', 'USD', 'EUR', 'BRL', 'CLP'];

        if (!in_array($this->conv_desde, $monedas) || !in_array($this->conv_hacia, $monedas)) {
            $this->conv_resultado = null;
            return;
        }

        if ($this->conv_desde === $this->conv_hacia) {
            $this->conv_resultado = $this->conv_monto;
            return;
        }

        if ($this->conv_desde === 'PEN') {
            $tasa = TipoCambio::where('moneda_base', 'PEN')
                ->where('moneda_destino', $this->conv_hacia)
                ->value('tasa');
            $this->conv_resultado = $tasa ? round($this->conv_monto * $tasa, 4) : null;
        } elseif ($this->conv_hacia === 'PEN') {
            $tasa = TipoCambio::where('moneda_base', 'PEN')
                ->where('moneda_destino', $this->conv_desde)
                ->value('tasa');
            $this->conv_resultado = $tasa ? round($this->conv_monto / $tasa, 4) : null;
        } else {
            $tasaDesde = TipoCambio::where('moneda_base', 'PEN')->where('moneda_destino', $this->conv_desde)->value('tasa');
            $tasaHacia = TipoCambio::where('moneda_base', 'PEN')->where('moneda_destino', $this->conv_hacia)->value('tasa');
            if ($tasaDesde && $tasaHacia) {
                $enPen = $this->conv_monto / $tasaDesde;
                $this->conv_resultado = round($enPen * $tasaHacia, 4);
            } else {
                $this->conv_resultado = null;
            }
        }
    }

    public function getMonedas(): array
    {
        return [
            'PEN' => 'S/ Sol peruano',
            'USD' => '$ Dólar',
            'EUR' => '€ Euro',
            'BRL' => 'R$ Real',
            'CLP' => 'CLP$ Peso chileno',
        ];
    }
}

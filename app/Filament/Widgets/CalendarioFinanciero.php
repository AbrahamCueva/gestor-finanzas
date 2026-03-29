<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use App\Models\Transferencia;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class CalendarioFinanciero extends Widget
{
    protected string $view = 'filament.widgets.calendario-financiero';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 10;

    public int $mes;
    public int $anio;
    public ?string $diaSeleccionado = null;

    public function mount(): void
    {
        $this->mes  = now()->month;
        $this->anio = now()->year;
    }

    public function mesAnterior(): void
    {
        $fecha = Carbon::create($this->anio, $this->mes, 1)->subMonth();
        $this->mes  = $fecha->month;
        $this->anio = $fecha->year;
        $this->diaSeleccionado = null;
    }

    public function mesSiguiente(): void
    {
        $fecha = Carbon::create($this->anio, $this->mes, 1)->addMonth();
        $this->mes  = $fecha->month;
        $this->anio = $fecha->year;
        $this->diaSeleccionado = null;
    }

    public function seleccionarDia(string $dia): void
    {
        $this->diaSeleccionado = $this->diaSeleccionado === $dia ? null : $dia;
    }

    protected function getViewData(): array
    {
        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin    = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        $movimientos = Movimiento::with(['cuenta', 'categoria'])
            ->whereBetween('fecha', [$inicio, $fin])
            ->get()
            ->groupBy(fn ($m) => Carbon::parse($m->fecha)->format('Y-m-d'));

        $transferencias = Transferencia::with(['cuentaOrigen', 'cuentaDestino'])
            ->whereBetween('fecha', [$inicio, $fin])
            ->get()
            ->groupBy(fn ($t) => Carbon::parse($t->fecha)->format('Y-m-d'));

        $diasMes     = $inicio->daysInMonth;
        $primerDia   = $inicio->dayOfWeek;
        $offsetInicio = ($primerDia + 6) % 7;

        $dias = [];
        for ($d = 1; $d <= $diasMes; $d++) {
            $key = Carbon::create($this->anio, $this->mes, $d)->format('Y-m-d');
            $movsDia = $movimientos[$key] ?? collect();
            $transDia = $transferencias[$key] ?? collect();

            $ingresos  = $movsDia->where('tipo_movimiento', 'ingreso')->sum('monto');
            $egresos   = $movsDia->where('tipo_movimiento', 'egreso')->sum('monto');
            $recurrentes = $movsDia->where('es_recurrente', true)->count();

            $dias[$d] = [
                'key'          => $key,
                'dia'          => $d,
                'ingresos'     => $ingresos,
                'egresos'      => $egresos,
                'transferencias' => $transDia->count(),
                'recurrentes'  => $recurrentes,
                'total_movs'   => $movsDia->count() + $transDia->count(),
                'es_hoy'       => $key === now()->format('Y-m-d'),
            ];
        }

        $detalle = null;
        if ($this->diaSeleccionado) {
            $movsDia  = $movimientos[$this->diaSeleccionado] ?? collect();
            $transDia = $transferencias[$this->diaSeleccionado] ?? collect();
            $detalle  = [
                'movimientos'    => $movsDia,
                'transferencias' => $transDia,
            ];
        }

        return [
            'dias'             => $dias,
            'offsetInicio'     => $offsetInicio,
            'mesNombre'        => ucfirst($inicio->translatedFormat('F Y')),
            'detalle'          => $detalle,
            'diaSeleccionado'  => $this->diaSeleccionado,
        ];
    }
}

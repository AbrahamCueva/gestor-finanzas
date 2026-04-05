<?php

namespace App\Filament\Pages;

use App\Models\Deuda;
use App\Models\Meta;
use App\Models\Movimiento;
use App\Models\NotaFinanciera;
use App\Models\Presupuesto;
use App\Models\Transferencia;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class CalendarioFinanciero extends Page
{
    protected string $view = 'filament.pages.calendario-financiero';
    protected static ?string $navigationLabel = 'Calendario Financiero';
    protected static ?string $title = 'Calendario Financiero';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 5;

    public int $mes;
    public int $anio;
    public ?string $diaSeleccionado = null;

    public function mount(): void
    {
        $this->mes = now()->month;
        $this->anio = now()->year;
    }

    public function anteriorMes(): void
    {
        $f = Carbon::create($this->anio, $this->mes, 1)->subMonth();
        $this->mes = $f->month;
        $this->anio = $f->year;
        $this->diaSeleccionado = null;
    }

    public function siguienteMes(): void
    {
        $f = Carbon::create($this->anio, $this->mes, 1)->addMonth();
        $this->mes = $f->month;
        $this->anio = $f->year;
        $this->diaSeleccionado = null;
    }

    public function seleccionarDia(string $fecha): void
    {
        $this->diaSeleccionado = $this->diaSeleccionado === $fecha ? null : $fecha;
    }

    public function getCalendario(): array
    {
        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();
        $hoy = now()->toDateString();

        // Cargar todos los datos del mes
        $movimientos = Movimiento::whereBetween('fecha', [$inicio, $fin])
            ->with('categoria')
            ->get()
            ->groupBy(fn($m) => Carbon::parse($m->fecha)->toDateString());

        $transferencias = Transferencia::whereBetween('fecha', [$inicio, $fin])
            ->with('cuentaOrigen', 'cuentaDestino')
            ->get()
            ->groupBy(fn($t) => Carbon::parse($t->fecha)->toDateString());

        $metas = Meta::whereNotNull('fecha_limite')
            ->whereBetween('fecha_limite', [$inicio, $fin])
            ->get()
            ->groupBy(fn($m) => Carbon::parse($m->fecha_limite)->toDateString());

        $presupuestos = Presupuesto::where('activo', true)
            ->where(
                fn($q) => $q
                    ->whereBetween('fecha_inicio', [$inicio, $fin])
                    ->orWhereBetween('fecha_fin', [$inicio, $fin])
            )->get();

        $recordatorios = NotaFinanciera::where('tipo', 'recordatorio')
            ->whereNotNull('recordar_en')
            ->whereBetween('recordar_en', [$inicio, $fin])
            ->get()
            ->groupBy(fn($n) => Carbon::parse($n->recordar_en)->toDateString());

        $deudas = Deuda::whereNotNull('fecha_vencimiento')
            ->whereBetween('fecha_vencimiento', [$inicio, $fin])
            ->get()
            ->groupBy(fn($d) => Carbon::parse($d->fecha_vencimiento)->toDateString());

        // Feriados peruanos fijos
        $feriados = $this->getFeriados($this->anio);

        // Construir días
        $dias = [];
        $diaInicio = $inicio->dayOfWeek; // 0=dom
        $diaInicio = $diaInicio === 0 ? 6 : $diaInicio - 1; // ajustar a lun=0

        // Días vacíos al inicio
        for ($i = 0; $i < $diaInicio; $i++) {
            $dias[] = null;
        }

        for ($d = 1; $d <= $fin->day; $d++) {
            $fecha = Carbon::create($this->anio, $this->mes, $d)->toDateString();
            $movsDia = $movimientos->get($fecha, collect());
            $transDia = $transferencias->get($fecha, collect());
            $metasDia = $metas->get($fecha, collect());
            $recDia = $recordatorios->get($fecha, collect());
            $deudasDia = $deudas->get($fecha, collect());

            $ingresos = $movsDia->where('tipo_movimiento', 'ingreso')->sum('monto');
            $egresos = $movsDia->where('tipo_movimiento', 'egreso')->sum('monto');
            $neto = $ingresos - $egresos;

            // Presupuestos activos en este día
            $presDia = $presupuestos->filter(
                fn($p) =>
                Carbon::parse($p->fecha_inicio)->lte($fecha) &&
                Carbon::parse($p->fecha_fin)->gte($fecha)
            );

            $esFeriado = isset($feriados[$fecha]);
            $esHoy = $fecha === $hoy;
            $esFuturo = $fecha > $hoy;

            $eventos = [];
            if ($movsDia->count())
                $eventos[] = ['tipo' => 'movimiento', 'count' => $movsDia->count()];
            if ($transDia->count())
                $eventos[] = ['tipo' => 'transferencia', 'count' => $transDia->count()];
            if ($metasDia->count())
                $eventos[] = ['tipo' => 'meta', 'count' => $metasDia->count()];
            if ($recDia->count())
                $eventos[] = ['tipo' => 'recordatorio', 'count' => $recDia->count()];
            if ($deudasDia->count())
                $eventos[] = ['tipo' => 'deuda', 'count' => $deudasDia->count()];
            if ($presDia->count())
                $eventos[] = ['tipo' => 'presupuesto', 'count' => $presDia->count()];

            $dias[] = [
                'dia' => $d,
                'fecha' => $fecha,
                'esHoy' => $esHoy,
                'esFuturo' => $esFuturo,
                'esFeriado' => $esFeriado,
                'feriado' => $feriados[$fecha] ?? null,
                'ingresos' => round($ingresos, 2),
                'egresos' => round($egresos, 2),
                'neto' => round($neto, 2),
                'eventos' => $eventos,
                'tieneMovs' => $movsDia->count() > 0,
                'tieneTrans' => $transDia->count() > 0,
                'tieneMetas' => $metasDia->count() > 0,
                'tieneRec' => $recDia->count() > 0,
                'tieneDeuda' => $deudasDia->count() > 0,
                'tienePres' => $presDia->count() > 0,
            ];
        }

        return $dias;
    }

    public function getDetalleDia(): array
    {
        if (!$this->diaSeleccionado)
            return [];

        $fecha = $this->diaSeleccionado;

        $movimientos = Movimiento::whereDate('fecha', $fecha)
            ->with('categoria', 'subcategoria', 'cuenta')
            ->orderByDesc('monto')
            ->get();

        $transferencias = Transferencia::whereDate('fecha', $fecha)
            ->with('cuentaOrigen', 'cuentaDestino')
            ->get();

        $metas = Meta::whereDate('fecha_limite', $fecha)->get();

        $recordatorios = NotaFinanciera::where('tipo', 'recordatorio')
            ->whereDate('recordar_en', $fecha)
            ->get();

        $deudas = Deuda::whereDate('fecha_vencimiento', $fecha)->get();

        $presupuestos = Presupuesto::where('activo', true)
            ->where('fecha_inicio', '<=', $fecha)
            ->where('fecha_fin', '>=', $fecha)
            ->with('categoria')
            ->get();

        $feriados = $this->getFeriados($this->anio);

        return [
            'fecha' => Carbon::parse($fecha)->translatedFormat('l, d \d\e F \d\e Y'),
            'esFeriado' => isset($feriados[$fecha]),
            'feriado' => $feriados[$fecha] ?? null,
            'movimientos' => $movimientos,
            'transferencias' => $transferencias,
            'metas' => $metas,
            'recordatorios' => $recordatorios,
            'deudas' => $deudas,
            'presupuestos' => $presupuestos,
            'totalIngresos' => $movimientos->where('tipo_movimiento', 'ingreso')->sum('monto'),
            'totalEgresos' => $movimientos->where('tipo_movimiento', 'egreso')->sum('monto'),
        ];
    }

    public function getResumenMes(): array
    {
        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        return [
            'ingresos' => Movimiento::whereBetween('fecha', [$inicio, $fin])->where('tipo_movimiento', 'ingreso')->sum('monto'),
            'egresos' => Movimiento::whereBetween('fecha', [$inicio, $fin])->where('tipo_movimiento', 'egreso')->sum('monto'),
            'transferencias' => Transferencia::whereBetween('fecha', [$inicio, $fin])->count(),
            'metasVencen' => Meta::whereBetween('fecha_limite', [$inicio, $fin])->count(),
            'deudasVencen' => Deuda::whereBetween('fecha_vencimiento', [$inicio, $fin])->count(),
            'recordatorios' => NotaFinanciera::where('tipo', 'recordatorio')->whereBetween('recordar_en', [$inicio, $fin])->count(),
        ];
    }

    private function getFeriados(int $anio): array
    {
        // Calcular Domingo de Pascua
        $pascua = Carbon::createFromTimestamp(easter_date($anio));

        // Semana Santa
        $juevesSanto = $pascua->copy()->subDays(3)->toDateString();
        $viernesSanto = $pascua->copy()->subDays(2)->toDateString();

        return [
            "$anio-01-01" => "Año Nuevo",

            // Semana Santa (dinámico)
            $juevesSanto => "Jueves Santo",
            $viernesSanto => "Viernes Santo",

            "$anio-05-01" => "Día del Trabajo",
            "$anio-06-07" => "Batalla de Arica",
            "$anio-06-29" => "San Pedro y San Pablo",
            "$anio-07-28" => "Fiestas Patrias",
            "$anio-07-29" => "Fiestas Patrias",
            "$anio-08-30" => "Santa Rosa de Lima",
            "$anio-10-08" => "Combate de Angamos",
            "$anio-11-01" => "Todos los Santos",
            "$anio-12-08" => "Inmaculada Concepción",
            "$anio-12-25" => "Navidad",
        ];
    }
}
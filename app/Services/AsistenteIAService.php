<?php

namespace App\Services;

use App\Models\Cuenta;
use App\Models\Deuda;
use App\Models\Meta;
use App\Models\Movimiento;
use App\Models\Presupuesto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AsistenteIAService
{
    public function responder(string $mensaje, array $historial = []): \Illuminate\Http\JsonResponse
    {
        $contexto = $this->construirContexto();

        $messages = [];

        foreach ($historial as $msg) {
            $messages[] = [
                'role' => $msg['role'],
                'content' => $msg['content'],
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $mensaje,
        ];

        $response = Http::withHeaders([
            'x-api-key' => config('services.anthropic.key'),
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model' => 'claude-haiku-4-5-20251001',
            'max_tokens' => 1024,
            'system' => $this->getSystemPrompt($contexto),
            'messages' => $messages,
        ]);

        if (! $response->ok()) {
            return response()->json(['error' => 'Error al conectar con la IA'], 500);
        }

        $data = $response->json();
        $respuesta = $data['content'][0]['text'] ?? 'No pude procesar tu consulta.';

        return response()->json(['respuesta' => $respuesta]);
    }

    private function getSystemPrompt(string $contexto): string
    {
        return <<<PROMPT
            Eres RICOX Assistant, un asistente financiero personal inteligente integrado en la app RICOX.
            Tu objetivo es ayudar al usuario a entender sus finanzas, dar consejos prácticos y sugerir acciones concretas.

            DATOS ACTUALES DEL USUARIO:
            {$contexto}

            INSTRUCCIONES:
            - Responde SIEMPRE en español
            - Sé conciso pero completo — máximo 3-4 párrafos
            - Usa los datos reales del usuario para responder
            - Cuando detectes algo preocupante (deuda vencida, presupuesto superado, poco ahorro), menciónalo
            - Sugiere acciones concretas cuando sea relevante, usando este formato al final:
            💡 **Acciones sugeridas:**
            - [acción concreta]
            - Usa emojis con moderación para hacer la respuesta más amigable
            - Si no tienes datos suficientes para responder algo, dilo claramente
            - Nunca inventes datos que no estén en el contexto
            - Trata al usuario de tú
        PROMPT;
    }

    private function construirContexto(): string
    {
        $hoy = Carbon::now();
        $mes = $hoy->month;
        $anio = $hoy->year;
        $inicio = $hoy->copy()->startOfMonth();
        $fin = $hoy->copy()->endOfMonth();

        $cuentas = Cuenta::where('activa', true)->get();
        $saldoTotal = $cuentas->sum('saldo_actual');
        $cuentasStr = $cuentas->map(fn ($c) => "- {$c->nombre} ({$c->tipo_cuenta}): S/ ".number_format($c->saldo_actual, 2)
        )->join("\n");

        $ingresosMes = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
        $egresosMes = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicio, $fin])->sum('monto');
        $ahorroMes = $ingresosMes - $egresosMes;

        $topCategorias = Movimiento::selectRaw('categorias.nombre, SUM(movimientos.monto) as total')
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->where('movimientos.tipo_movimiento', 'egreso')
            ->whereBetween('movimientos.fecha', [$inicio, $fin])
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn ($c) => "- {$c->nombre}: S/ ".number_format($c->total, 2))
            ->join("\n");

        $ultimosMovimientos = Movimiento::with('categoria')
            ->orderByDesc('fecha')
            ->limit(5)
            ->get()
            ->map(fn ($m) => "- [{$m->fecha}] {$m->tipo_movimiento}: S/ {$m->monto} en {$m->categoria?->nombre}"
            )->join("\n");

        $promedioIngresos = 0;
        $promedioEgresos = 0;
        for ($i = 1; $i <= 3; $i++) {
            $promedioIngresos += Movimiento::where('tipo_movimiento', 'ingreso')
                ->whereBetween('fecha', [
                    $hoy->copy()->subMonths($i)->startOfMonth(),
                    $hoy->copy()->subMonths($i)->endOfMonth(),
                ])->sum('monto');
            $promedioEgresos += Movimiento::where('tipo_movimiento', 'egreso')
                ->whereBetween('fecha', [
                    $hoy->copy()->subMonths($i)->startOfMonth(),
                    $hoy->copy()->subMonths($i)->endOfMonth(),
                ])->sum('monto');
        }
        $promedioIngresos = round($promedioIngresos / 3, 2);
        $promedioEgresos = round($promedioEgresos / 3, 2);

        $presupuestos = Presupuesto::with('categoria')->where('activo', true)->get();
        $presupuestosStr = $presupuestos->map(fn ($p) => "- {$p->categoria?->nombre}: S/ ".number_format($p->gastoActual(), 2).
            ' / S/ '.number_format($p->monto_limite, 2).
            " ({$p->porcentaje()}%)".
            ($p->superado() ? ' SUPERADO' : '')
        )->join("\n");

        $metas = Meta::where('completada', false)->get();
        $metasStr = $metas->map(fn ($m) => "- {$m->nombre}: S/ ".number_format($m->monto_actual, 2).
            ' / S/ '.number_format($m->monto_objetivo, 2).
            " ({$m->porcentaje()}%)".
            ($m->fecha_limite ? " · vence {$m->fecha_limite->format('d/m/Y')}" : '')
        )->join("\n");

        $deudas = Deuda::where('estado', '!=', 'pagada')->get();
        $deudasStr = $deudas->map(fn ($d) => "- {$d->nombre} ({$d->tipo}): S/ ".number_format($d->restante(), 2).
            ' pendiente'.
            ($d->estaVencida() ? ' VENCIDA' : '').
            ($d->fecha_vencimiento ? " · vence {$d->fecha_vencimiento->format('d/m/Y')}" : '')
        )->join("\n");

        $totalDeudas = $deudas->where('tipo', 'debo')->sum(fn ($d) => $d->restante());
        $totalMeDeben = $deudas->where('tipo', 'me_deben')->sum(fn ($d) => $d->restante());

        return <<<CONTEXTO
            FECHA ACTUAL: {$hoy->format('d/m/Y')} ({$hoy->translatedFormat('l')})
            MES ACTUAL: {$hoy->translatedFormat('F Y')}

            CUENTAS Y SALDOS:
            Saldo total: S/ {$saldoTotal}
            {$cuentasStr}

            MOVIMIENTOS DEL MES ACTUAL:
            Ingresos: S/ {$ingresosMes}
            Egresos: S/ {$egresosMes}
            Ahorro neto: S/ {$ahorroMes}

            PROMEDIO ÚLTIMOS 3 MESES:
            Ingresos promedio: S/ {$promedioIngresos}
            Egresos promedio: S/ {$promedioEgresos}

            TOP GASTOS DEL MES POR CATEGORÍA:
            {$topCategorias}

            ÚLTIMOS 5 MOVIMIENTOS:
            {$ultimosMovimientos}

            PRESUPUESTOS ACTIVOS:
            {$presupuestosStr}

            METAS DE AHORRO ACTIVAS:
            {$metasStr}

            DEUDAS PENDIENTES:
            Total que debo: S/ {$totalDeudas}
            Total que me deben: S/ {$totalMeDeben}
            {$deudasStr}
        CONTEXTO;
    }
}

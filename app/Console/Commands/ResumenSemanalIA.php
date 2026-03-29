<?php

namespace App\Console\Commands;

use App\Models\Movimiento;
use App\Models\Presupuesto;
use App\Models\Meta;
use App\Models\Deuda;
use App\Models\Cuenta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ResumenSemanalIA extends Command
{
    protected $signature   = 'ricox:resumen-semanal-ia';
    protected $description = 'Claude genera un análisis financiero semanal y lo envía por correo';

    public function handle(): void
    {
        $usuarios = User::all();

        foreach ($usuarios as $user) {
            $this->info("Generando resumen para {$user->email}...");

            $contexto = $this->construirContexto($user);
            $analisis = $this->generarAnalisisIA($contexto);

            if (!$analisis) {
                $this->warn("No se pudo generar análisis para {$user->email}");
                continue;
            }

            // Enviar correo
            try {
                Mail::send([], [], function ($mail) use ($user, $analisis) {
                    $mail->to($user->email)
                        ->subject('📊 Tu resumen financiero semanal — RICOX')
                        ->html($this->generarHtml($user, $analisis));
                });
                $this->info("✅ Resumen enviado a {$user->email}");
            } catch (\Exception $e) {
                $this->warn("Error enviando a {$user->email}: {$e->getMessage()}");
            }
        }

        $this->info('🤖 Resúmenes semanales enviados.');
    }

    private function construirContexto(User $user): string
    {
        $hoy       = Carbon::now();
        $inicioSem = $hoy->copy()->subDays(7)->startOfDay();
        $finSem    = $hoy->copy()->endOfDay();
        $inicioMes = $hoy->copy()->startOfMonth();

        // Movimientos de la semana
        $ingresosSem = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicioSem, $finSem])->sum('monto');
        $egresosSem  = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicioSem, $finSem])->sum('monto');

        // Top categorías semana
        $topCats = Movimiento::selectRaw('categorias.nombre, SUM(movimientos.monto) as total')
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->where('movimientos.tipo_movimiento', 'egreso')
            ->whereBetween('movimientos.fecha', [$inicioSem, $finSem])
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($c) => "- {$c->nombre}: S/ " . number_format($c->total, 2))
            ->join("\n");

        // Mes actual
        $ingresosMes = Movimiento::where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$inicioMes, $finSem])->sum('monto');
        $egresosMes  = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicioMes, $finSem])->sum('monto');

        // Semana anterior para comparar
        $inicioSemAnt = $hoy->copy()->subDays(14)->startOfDay();
        $finSemAnt    = $hoy->copy()->subDays(7)->endOfDay();
        $egresosSemAnt = Movimiento::where('tipo_movimiento', 'egreso')
            ->whereBetween('fecha', [$inicioSemAnt, $finSemAnt])->sum('monto');

        $variacionSemanal = $egresosSemAnt > 0
            ? round((($egresosSem - $egresosSemAnt) / $egresosSemAnt) * 100, 1)
            : 0;

        // Presupuestos
        $presupuestos = Presupuesto::where('activo', true)->get();
        $presSuperados = $presupuestos->filter(fn($p) => $p->superado())->count();
        $presStr = $presupuestos->map(
            fn($p) =>
            "- {$p->categoria?->nombre}: S/ " . number_format($p->gastoActual(), 2) .
                " / S/ " . number_format($p->monto_limite, 2) .
                " ({$p->porcentaje()}%)" .
                ($p->superado() ? ' ⚠️ SUPERADO' : '')
        )->join("\n");

        // Metas
        $metas = Meta::where('completada', false)->get();
        $metasStr = $metas->map(
            fn($m) =>
            "- {$m->nombre}: {$m->porcentaje()}% completada" .
                ($m->fecha_limite ? " · vence {$m->fecha_limite->format('d/m/Y')}" : '')
        )->join("\n");

        // Deudas vencidas
        $deudasVencidas = Deuda::where('estado', '!=', 'pagada')->get()
            ->filter(fn($d) => $d->estaVencida())->count();

        // Saldo total
        $saldoTotal = Cuenta::where('activa', true)->sum('saldo_actual');

        return <<<CONTEXTO
            USUARIO: {$user->name}
            FECHA: {$hoy->format('d/m/Y')} (lunes, inicio de semana)
            SEMANA: del {$inicioSem->format('d/m/Y')} al {$hoy->format('d/m/Y')}

            RESUMEN DE LA SEMANA:
            Ingresos: S/ {$ingresosSem}
            Egresos: S/ {$egresosSem}
            Ahorro neto: S/ " . round($ingresosSem - $egresosSem, 2) . "
            Variación vs semana anterior: {$variacionSemanal}%

            TOP GASTOS DE LA SEMANA:
            {$topCats}

            MES ACTUAL (acumulado):
            Ingresos: S/ {$ingresosMes}
            Egresos: S/ {$egresosMes}
            Ahorro acumulado: S/ " . round($ingresosMes - $egresosMes, 2) . "

            PRESUPUESTOS ({$presSuperados} superados):
            {$presStr}

            METAS DE AHORRO:
            {$metasStr}

            ALERTAS:
            - Deudas vencidas: {$deudasVencidas}
            - Presupuestos superados: {$presSuperados}

            SALDO TOTAL EN CUENTAS: S/ {$saldoTotal}
        CONTEXTO;
    }

    private function generarAnalisisIA(string $contexto): ?string
    {
        $response = Http::withHeaders([
            'x-api-key'         => config('services.anthropic.key'),
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->timeout(30)->post('https://api.anthropic.com/v1/messages', [
            'model'      => 'claude-haiku-4-5-20251001',
            'max_tokens' => 1500,
            'system'     => "Eres RICOX Assistant, un asesor financiero personal amigable. Tu tarea es generar un resumen semanal financiero en español. El resumen debe ser:
                - Conversacional y motivador, no robótico
                - Máximo 4 secciones: Resumen semana, Puntos positivos, Áreas de mejora, Consejo de la semana
                - Usa emojis con moderación
                - Sé específico con los números
                - Da 1 consejo accionable y concreto para la próxima semana
                - Formato: texto plano con saltos de línea, sin markdown ni asteriscos
                - Máximo 300 palabras en total",
            'messages' => [[
                'role'    => 'user',
                'content' => "Genera el resumen financiero semanal con estos datos:\n\n{$contexto}",
            ]],
        ]);

        if (!$response->ok()) return null;

        return $response->json()['content'][0]['text'] ?? null;
    }

    private function generarHtml(User $user, string $analisis): string
    {
        $hoy      = Carbon::now();
        $inicioSem = $hoy->copy()->subDays(7)->format('d/m/Y');
        $finSem    = $hoy->format('d/m/Y');

        // Convertir saltos de línea a párrafos HTML
        $parrafos = array_filter(explode("\n\n", $analisis));
        $htmlParrafos = '';
        foreach ($parrafos as $parrafo) {
            $parrafo = trim($parrafo);
            if (empty($parrafo)) continue;

            // Detectar si es un título de sección
            if (str_ends_with($parrafo, ':') || strlen($parrafo) < 50) {
                $htmlParrafos .= "<div style='font-size:13px; font-weight:700; color:#0f172a; margin:16px 0 6px;'>{$parrafo}</div>";
            } else {
                $lineas = nl2br(htmlspecialchars($parrafo));
                $htmlParrafos .= "<p style='font-size:13px; color:#475569; line-height:1.65; margin:0 0 12px;'>{$lineas}</p>";
            }
        }

        $settings = \App\Models\Setting::first();
        $appName  = $settings?->site_name ?? 'RICOX';

        return "
        <!DOCTYPE html>
        <html>
        <head><meta charset='UTF-8'></head>
        <body style='margin:0; padding:0; background:#f8fafc; font-family:-apple-system,BlinkMacSystemFont,sans-serif;'>
            <div style='max-width:580px; margin:40px auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08);'>

               
                <div style='background:#0f172a; padding:28px 32px;'>
                    <div style='font-size:22px; font-weight:900; color:#fbbf24; letter-spacing:-0.02em;'>{$appName}</div>
                    <div style='font-size:12px; color:#64748b; margin-top:4px;'>Resumen Financiero Semanal</div>
                </div>
                <div style='height:3px; background:linear-gradient(90deg,#fbbf24,#f59e0b,#d97706);'></div>

                
                <div style='background:#fffbeb; padding:12px 32px; display:flex; align-items:center; gap:8px;'>
                    <span style='font-size:16px;'>📅</span>
                    <span style='font-size:13px; font-weight:600; color:#92400e;'>Semana del {$inicioSem} al {$finSem}</span>
                </div>

                
                <div style='padding:28px 32px 0;'>
                    <h2 style='font-size:18px; font-weight:700; color:#0f172a; margin:0 0 6px;'>
                        Hola {$user->name} 👋
                    </h2>
                    <p style='font-size:13px; color:#64748b; margin:0 0 20px;'>
                        Tu asesor financiero RICOX analizó tu semana. Aquí está tu resumen:
                    </p>

                    <div style='background:#f8fafc; border-radius:12px; padding:20px 22px; border:1px solid #e2e8f0;'>
                        {$htmlParrafos}
                    </div>
                </div>

               
                <div style='padding:24px 32px; text-align:center;'>
                    <a href='/admin'
                        style='background:#fbbf24; color:#0f172a; padding:13px 32px; border-radius:10px;
                        font-weight:700; text-decoration:none; font-size:14px; display:inline-block;'>
                        Ver mi dashboard →
                    </a>
                </div>

                
                <div style='background:#f8fafc; padding:16px 32px; display:flex; justify-content:space-between; align-items:center;'>
                    <span style='font-size:11px; font-weight:700; color:#fbbf24;'>{$appName}</span>
                    <span style='font-size:11px; color:#94a3b8;'>Generado el {$hoy->format('d/m/Y H:i')}</span>
                </div>

            </div>
        </body>
        </html>
        ";
    }
}

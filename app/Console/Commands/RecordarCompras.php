<?php

namespace App\Console\Commands;

use App\Models\ListaCompra;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RecordarCompras extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature   = 'ricox:recordar-compras';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios diarios de la lista de compras pendiente';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $usuarios = User::all();

        foreach ($usuarios as $user) {
            $pendientes = ListaCompra::where('user_id', $user->id)
                ->where('comprado', false)
                ->orderByRaw("FIELD(prioridad, 'urgente', 'normal', 'puede_esperar')")
                ->get();

            if ($pendientes->isEmpty()) continue;

            $urgentes = $pendientes->where('prioridad', 'urgente')->count();
            $total    = $pendientes->count();

            // Notificación en app
            $titulo = $urgentes > 0
                ? "🛒 Tienes {$urgentes} producto(s) urgente(s) por comprar"
                : "🛒 Tienes {$total} producto(s) pendientes en tu lista";

            $cuerpo = $pendientes->take(3)->map(
                fn($p) =>
                "{$p->prioridad_emoji} {$p->nombre} (x{$p->cantidad})"
            )->join(', ');

            if ($total > 3) $cuerpo .= " y " . ($total - 3) . " más...";

            Notification::make()
                ->title($titulo)
                ->body($cuerpo)
                ->icon('heroicon-o-shopping-cart')
                ->iconColor($urgentes > 0 ? 'danger' : 'warning')
                ->actions([
                    Action::make('ver')
                        ->label('Ver lista')
                        ->url('/admin/lista-compras')
                        ->button(),
                ])
                ->sendToDatabase($user);

            // Correo
            try {
                Mail::send([], [], function ($mail) use ($user, $titulo, $pendientes, $total, $urgentes) {
                    $mail->to($user->email)
                        ->subject($titulo)
                        ->html($this->generarHtmlCorreo($user, $pendientes, $total, $urgentes));
                });
            } catch (\Exception $e) {
                $this->warn("Error enviando correo a {$user->email}: {$e->getMessage()}");
            }

            // Actualizar último recordatorio
            ListaCompra::where('user_id', $user->id)
                ->where('comprado', false)
                ->update(['ultimo_recordatorio' => now()]);

            $this->info("✅ Recordatorio enviado a {$user->email} — {$total} productos pendientes");
        }

        $this->info('🛒 Recordatorios de compras enviados.');
    }

    private function generarHtmlCorreo($user, $pendientes, int $total, int $urgentes): string
    {
        $categorias = ListaCompra::getCategorias();
        $filas = '';

        foreach ($pendientes as $p) {
            $colorPrioridad = match ($p->prioridad) {
                'urgente'       => '#ef4444',
                'normal'        => '#fbbf24',
                'puede_esperar' => '#22c55e',
                default         => '#6b7280',
            };
            $precio = $p->precio_estimado ? 'S/ ' . number_format($p->precio_estimado, 2) : '—';
            $cat    = $categorias[$p->categoria] ?? $p->categoria ?? '—';

            $filas .= "
                <tr style='border-bottom:1px solid #f1f5f9;'>
                    <td style='padding:8px 10px; font-weight:600; color:#0f172a;'>{$p->prioridad_emoji} {$p->nombre}</td>
                    <td style='padding:8px 10px; color:#6b7280;'>{$p->cantidad}</td>
                    <td style='padding:8px 10px; color:#6b7280;'>{$cat}</td>
                    <td style='padding:8px 10px; color:#6b7280;'>{$precio}</td>
                    <td style='padding:8px 10px;'>
                        <span style='background:" . $colorPrioridad . "22; color:{$colorPrioridad}; padding:2px 8px; border-radius:99px; font-size:11px; font-weight:700;'>
                            " . ucfirst(str_replace('_', ' ', $p->prioridad)) . "
                        </span>
                    </td>
                </tr>
            ";
        }

        $alertaUrgente = $urgentes > 0 ? "
            <div style='background:#fef2f2; border:1px solid #fecaca; border-radius:8px; padding:12px 16px; margin-bottom:20px;'>
                <strong style='color:#ef4444;'>⚠️ {$urgentes} producto(s) urgente(s)</strong>
                <p style='color:#7f1d1d; font-size:13px; margin:4px 0 0;'>Tienes productos marcados como urgentes. ¡No olvides comprarlos hoy!</p>
            </div>
        " : '';

        return "
        <!DOCTYPE html>
        <html>
        <head><meta charset='UTF-8'></head>
        <body style='margin:0; padding:0; background:#f8fafc; font-family:-apple-system,BlinkMacSystemFont,sans-serif;'>
            <div style='max-width:560px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);'>

                <div style='background:#0f172a; padding:24px 28px;'>
                    <div style='font-size:20px; font-weight:900; color:#fbbf24;'>RICOX</div>
                    <div style='font-size:12px; color:#64748b; margin-top:2px;'>Lista de Compras — Recordatorio diario</div>
                </div>

                <div style='height:3px; background:linear-gradient(90deg,#fbbf24,#d97706);'></div>

                <div style='padding:24px 28px;'>
                    <h2 style='font-size:18px; font-weight:700; color:#0f172a; margin:0 0 8px;'>
                        🛒 Tienes {$total} producto(s) pendientes
                    </h2>
                    <p style='color:#6b7280; font-size:14px; margin:0 0 20px;'>
                        Hola {$user->name}, aquí está tu lista de compras pendiente para hoy.
                    </p>

                    {$alertaUrgente}

                    <table style='width:100%; border-collapse:collapse; font-size:13px;'>
                        <thead>
                            <tr style='background:#f8fafc;'>
                                <th style='padding:8px 10px; text-align:left; color:#6b7280; font-size:11px; text-transform:uppercase;'>Producto</th>
                                <th style='padding:8px 10px; text-align:left; color:#6b7280; font-size:11px; text-transform:uppercase;'>Cant.</th>
                                <th style='padding:8px 10px; text-align:left; color:#6b7280; font-size:11px; text-transform:uppercase;'>Categoría</th>
                                <th style='padding:8px 10px; text-align:left; color:#6b7280; font-size:11px; text-transform:uppercase;'>Precio est.</th>
                                <th style='padding:8px 10px; text-align:left; color:#6b7280; font-size:11px; text-transform:uppercase;'>Prioridad</th>
                            </tr>
                        </thead>
                        <tbody>{$filas}</tbody>
                    </table>

                    <div style='margin-top:24px; text-align:center;'>
                        <a href='/admin/lista-compras'
                            style='background:#fbbf24; color:#0f172a; padding:12px 28px; border-radius:8px; font-weight:700; text-decoration:none; font-size:14px;'>
                            Ver lista completa →
                        </a>
                    </div>
                </div>

                <div style='background:#f8fafc; padding:16px 28px; text-align:center;'>
                    <p style='color:#94a3b8; font-size:12px; margin:0;'>
                        RICOX — Gestor de Finanzas Personales
                    </p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}

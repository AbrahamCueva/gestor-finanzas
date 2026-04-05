<?php

namespace App\Services;

use App\Models\Cuenta;
use App\Models\Deuda;
use App\Models\Meta;
use App\Models\Movimiento;
use App\Models\Presupuesto;
use App\Models\Setting;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class NotificacionesService
{
    public function verificarTodo(): void
    {
        $settings = Setting::first();
        if ($settings?->vacaciones_activo && $settings->vacaciones_pausar_notificaciones) {
            return;
        }

        $this->verificarPresupuestos();
        $this->verificarDeudas();
        $this->verificarMetas();
        $this->resumenSemanal();
        $this->verificarSaldosBajos();
    }

    public function verificarPresupuestos(): void
    {
        $presupuestos = Presupuesto::with(['categoria', 'subcategoria'])
            ->where('activo', true)
            ->get();

        foreach ($presupuestos as $p) {
            $pct = $p->porcentaje();
            if ($pct < 80) {
                continue;
            }

            $nombre = $p->subcategoria?->nombre
                ? $p->categoria->nombre . ' › ' . $p->subcategoria->nombre
                : $p->categoria->nombre;

            $cacheKey = "notif_presupuesto_{$p->id}_" . now()->format('Y_m');

            if (cache()->has($cacheKey)) {
                continue;
            }
            cache()->put($cacheKey, true, now()->endOfMonth());

            if ($p->superado()) {
                Notification::make()
                    ->title('Presupuesto superado')
                    ->body("El presupuesto de **{$nombre}** ha sido superado ({$pct}% usado).")
                    ->danger()
                    ->actions([
                        Action::make('ver')
                            ->label('Ver presupuestos')
                            ->url(route('filament.admin.resources.presupuestos.index'))
                            ->button(),
                    ])
                    ->persistent()
                    ->sendToDatabase(auth()->user() ?? User::first());
            } else {
                Notification::make()
                    ->title('Presupuesto al ' . $pct . '%')
                    ->body("El presupuesto de **{$nombre}** está al {$pct}% de su límite.")
                    ->warning()
                    ->actions([
                        Action::make('ver')
                            ->label('Ver presupuestos')
                            ->url(route('filament.admin.resources.presupuestos.index'))
                            ->button(),
                    ])
                    ->sendToDatabase(auth()->user() ?? User::first());
            }
        }
    }

    public function verificarDeudas(): void
    {
        $deudas = Deuda::where('estado', '!=', 'pagada')
            ->whereNotNull('fecha_vencimiento')
            ->get();

        foreach ($deudas as $d) {
            $dias = $d->diasRestantes();
            if ($dias === null || $dias > 7 || $dias < 0) {
                continue;
            }

            $cacheKey = "notif_deuda_{$d->id}_" . now()->format('Y_m_d');
            if (cache()->has($cacheKey)) {
                continue;
            }
            cache()->put($cacheKey, true, now()->endOfDay());

            $tipo = $d->tipo === 'debo' ? 'que debes a' : 'que te debe';

            if ($dias === 0) {
                Notification::make()
                    ->title('Deuda vence HOY')
                    ->body("La deuda {$d->nombre} ({$tipo} {$d->acreedor_deudor}) vence hoy. Restante: S/ " . number_format($d->restante(), 2))
                    ->danger()
                    ->persistent()
                    ->actions([
                        Action::make('ver')
                            ->label('Ver deuda')
                            ->url(route('filament.admin.resources.deudas.index'))
                            ->button(),
                    ])
                    ->sendToDatabase(auth()->user() ?? User::first());
            } else {
                Notification::make()
                    ->title("Deuda vence en {$dias} día(s)")
                    ->body("La deuda {$d->nombre} ({$tipo} {$d->acreedor_deudor}) vence en {$dias} días. Restante: S/ " . number_format($d->restante(), 2))
                    ->warning()
                    ->actions([
                        Action::make('ver')
                            ->label('Ver deuda')
                            ->url(route('filament.admin.resources.deudas.index'))
                            ->button(),
                    ])
                    ->sendToDatabase(auth()->user() ?? User::first());
            }
        }
    }

    public function verificarMetas(): void
    {
        $metas = Meta::where('completada', false)
            ->whereNotNull('fecha_limite')
            ->get();

        foreach ($metas as $m) {
            $dias = $m->diasRestantes();
            if ($dias === null || $dias > 7 || $dias < 0) {
                continue;
            }

            $cacheKey = "notif_meta_{$m->id}_" . now()->format('Y_m_d');
            if (cache()->has($cacheKey)) {
                continue;
            }
            cache()->put($cacheKey, true, now()->endOfDay());

            $pct = $m->porcentaje();

            if ($dias === 0) {
                Notification::make()
                    ->title('Meta vence HOY')
                    ->body("La meta {$m->nombre} vence hoy y está al {$pct}%. Falta S/ " . number_format($m->restante(), 2))
                    ->danger()
                    ->persistent()
                    ->actions([
                        Action::make('ver')
                            ->label('Ver meta')
                            ->url(route('filament.admin.resources.metas.index'))
                            ->button(),
                    ])
                    ->sendToDatabase(auth()->user() ?? User::first());
            } else {
                Notification::make()
                    ->title("Meta vence en {$dias} día(s)")
                    ->body("La meta {$m->nombre} vence en {$dias} días y está al {$pct}%. Falta S/ " . number_format($m->restante(), 2))
                    ->warning()
                    ->actions([
                        Action::make('ver')
                            ->label('Ver meta')
                            ->url(route('filament.admin.resources.metas.index'))
                            ->button(),
                    ])
                    ->sendToDatabase(auth()->user() ?? User::first());
            }
        }
    }

    public function resumenSemanal(): void
    {
        $inicio = now()->subWeek()->startOfWeek();
        $fin = now()->subWeek()->endOfWeek();

        $ingresos = Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$inicio, $fin])->sum('monto');
        $egresos = Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$inicio, $fin])->sum('monto');
        $ahorro = $ingresos - $egresos;
        $totalMovs = Movimiento::whereBetween('fecha', [$inicio, $fin])->count();

        $semana = $inicio->format('d/m') . ' — ' . $fin->format('d/m/Y');

        $emoji = $ahorro >= 0 ? '📈' : '📉';
        $color = $ahorro >= 0 ? 'success' : 'warning';

        Notification::make()
                    ->title("{$emoji} Resumen semanal — {$semana}")
                    ->body(
                        'Ingresos: S/ ' . number_format($ingresos, 2) . "\n" .
                        'Egresos: S/ ' . number_format($egresos, 2) . "\n" .
                        'Ahorro: S/ ' . number_format($ahorro, 2) . "\n" .
                        "Movimientos: {$totalMovs}"
                    )
            ->{$color}()
                ->actions([
                    Action::make('ver')
                        ->label('Ver dashboard')
                        ->url(route('filament.admin.pages.dashboard'))
                        ->button(),
                ])
                ->sendToDatabase(auth()->user() ?? User::first());
    }

    public function verificarSaldosBajos(): void
    {
        $cuentas = Cuenta::where('activa', true)
            ->whereNotNull('saldo_minimo')
            ->get();

        foreach ($cuentas as $cuenta) {
            if ($cuenta->saldo_actual > $cuenta->saldo_minimo) {
                continue;
            }

            $cacheKey = "notif_saldo_{$cuenta->id}_" . now()->format('Y_m_d');
            if (cache()->has($cacheKey)) {
                continue;
            }
            cache()->put($cacheKey, true, now()->endOfDay());

            Notification::make()
                ->title('Saldo bajo en ' . $cuenta->nombre)
                ->body(
                    "El saldo de {$cuenta->nombre} es S/ " . number_format($cuenta->saldo_actual, 2) .
                    ', por debajo del mínimo configurado de S/ ' . number_format($cuenta->saldo_minimo, 2) . '.'
                )
                ->danger()
                ->persistent()
                ->actions([
                    Action::make('ver')
                        ->label('Ver cuentas')
                        ->url(route('filament.admin.resources.cuentas.index'))
                        ->button(),
                ])
                ->sendToDatabase(auth()->user() ?? User::first());
        }
    }
}

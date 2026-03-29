<?php

namespace App\Services;

use App\Models\LogroUsuario;
use App\Models\Meta;
use App\Models\Movimiento;
use App\Models\Deuda;
use App\Models\Presupuesto;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class LogrosService
{
    public static function definiciones(): array
    {
        return [
            'primera_meta' => [
                'nombre'      => 'Primera Meta Cumplida',
                'descripcion' => 'Completaste tu primera meta de ahorro.',
                'emoji'       => '🏆',
                'color'       => '#fbbf24',
                'categoria'   => 'Metas',
            ],

            'racha_3' => [
                'nombre'      => 'Racha de 3 Meses',
                'descripcion' => 'Ahorraste 3 meses consecutivos.',
                'emoji'       => '🔥',
                'color'       => '#f97316',
                'categoria'   => 'Ahorro',
            ],
            'racha_6' => [
                'nombre'      => 'Racha de 6 Meses',
                'descripcion' => 'Ahorraste 6 meses consecutivos.',
                'emoji'       => '🔥🔥',
                'color'       => '#ef4444',
                'categoria'   => 'Ahorro',
            ],
            'racha_12' => [
                'nombre'      => 'Racha de 12 Meses',
                'descripcion' => '¡Un año entero ahorrando!',
                'emoji'       => '💎',
                'color'       => '#60a5fa',
                'categoria'   => 'Ahorro',
            ],

            'sin_deudas_vencidas' => [
                'nombre'      => 'Deudas al Día',
                'descripcion' => 'No tienes ninguna deuda vencida.',
                'emoji'       => '✅',
                'color'       => '#22c55e',
                'categoria'   => 'Deudas',
            ],

            'presupuesto_3meses' => [
                'nombre'      => 'Presupuesto Disciplinado',
                'descripcion' => 'Respetaste tu presupuesto 3 meses seguidos.',
                'emoji'       => '🎯',
                'color'       => '#a78bfa',
                'categoria'   => 'Presupuestos',
            ],

            'movimientos_10' => [
                'nombre'      => 'Primeros Pasos',
                'descripcion' => 'Registraste 10 movimientos.',
                'emoji'       => '👣',
                'color'       => '#94a3b8',
                'categoria'   => 'Actividad',
            ],
            'movimientos_50' => [
                'nombre'      => 'En Ritmo',
                'descripcion' => 'Registraste 50 movimientos.',
                'emoji'       => '📊',
                'color'       => '#38bdf8',
                'categoria'   => 'Actividad',
            ],
            'movimientos_100' => [
                'nombre'      => 'Imparable',
                'descripcion' => 'Registraste 100 movimientos.',
                'emoji'       => '🚀',
                'color'       => '#fbbf24',
                'categoria'   => 'Actividad',
            ],

            'primer_backup' => [
                'nombre'      => 'Datos Seguros',
                'descripcion' => 'Realizaste tu primer backup.',
                'emoji'       => '🗄️',
                'color'       => '#34d399',
                'categoria'   => 'Sistema',
            ],

            'app_30_dias' => [
                'nombre'      => 'Usuario Constante',
                'descripcion' => 'Usaste la app 30 días seguidos.',
                'emoji'       => '📅',
                'color'       => '#fb923c',
                'categoria'   => 'Constancia',
            ],
        ];
    }

    public static function nivel(int $puntos): array
    {
        return match(true) {
            $puntos >= 1000 => ['nombre' => 'Master',       'emoji' => '👑', 'color' => '#fbbf24', 'siguiente' => null,  'puntosNivel' => 1000],
            $puntos >= 500  => ['nombre' => 'Experto',      'emoji' => '💎', 'color' => '#60a5fa', 'siguiente' => 1000, 'puntosNivel' => 500],
            $puntos >= 200  => ['nombre' => 'Avanzado',     'emoji' => '🔥', 'color' => '#f97316', 'siguiente' => 500,  'puntosNivel' => 200],
            $puntos >= 50   => ['nombre' => 'Intermedio',   'emoji' => '⭐', 'color' => '#a78bfa', 'siguiente' => 200,  'puntosNivel' => 50],
            default         => ['nombre' => 'Novato',       'emoji' => '🌱', 'color' => '#22c55e', 'siguiente' => 50,   'puntosNivel' => 0],
        };
    }

    public static function puntajeLogro(string $key): int
    {
        return match($key) {
            'primera_meta'        => 100,
            'racha_3'             => 50,
            'racha_6'             => 100,
            'racha_12'            => 200,
            'sin_deudas_vencidas' => 75,
            'presupuesto_3meses'  => 100,
            'movimientos_10'      => 10,
            'movimientos_50'      => 30,
            'movimientos_100'     => 60,
            'primer_backup'       => 50,
            'app_30_dias'         => 150,
            default               => 0,
        };
    }

    public function verificar(): void
    {
        $user = auth()->user();
        if (!$user) return;

        $yaDesbloqueados = LogroUsuario::where('user_id', $user->id)
            ->pluck('logro_key')
            ->toArray();

        $this->verificarPrimeraMeta($user, $yaDesbloqueados);
        $this->verificarRachaAhorro($user, $yaDesbloqueados);
        $this->verificarSinDeudasVencidas($user, $yaDesbloqueados);
        $this->verificarPresupuesto3Meses($user, $yaDesbloqueados);
        $this->verificarMovimientos($user, $yaDesbloqueados);
    }

    private function desbloquear($user, string $key, array &$yaDesbloqueados): void
    {
        if (in_array($key, $yaDesbloqueados)) return;

        LogroUsuario::create([
            'user_id'         => $user->id,
            'logro_key'       => $key,
            'desbloqueado_en' => now(),
        ]);

        $yaDesbloqueados[] = $key;
        $def = self::definiciones()[$key];

        Notification::make()
            ->title("🏅 ¡Logro desbloqueado! {$def['emoji']} {$def['nombre']}")
            ->body($def['descripcion'])
            ->success()
            ->persistent()
            ->sendToDatabase($user);
    }

    private function verificarPrimeraMeta($user, array &$ya): void
    {
        if (Meta::where('completada', true)->exists()) {
            $this->desbloquear($user, 'primera_meta', $ya);
        }
    }

    private function verificarRachaAhorro($user, array &$ya): void
    {
        $racha = 0;
        for ($i = 11; $i >= 0; $i--) {
            $inicio = now()->subMonths($i)->startOfMonth();
            $fin    = now()->subMonths($i)->endOfMonth();
            $ing    = Movimiento::where('tipo_movimiento', 'ingreso')->whereBetween('fecha', [$inicio, $fin])->sum('monto');
            $egr    = Movimiento::where('tipo_movimiento', 'egreso')->whereBetween('fecha', [$inicio, $fin])->sum('monto');
            if ($ing > $egr) $racha++; else $racha = 0;
        }

        if ($racha >= 3)  $this->desbloquear($user, 'racha_3',  $ya);
        if ($racha >= 6)  $this->desbloquear($user, 'racha_6',  $ya);
        if ($racha >= 12) $this->desbloquear($user, 'racha_12', $ya);
    }

    private function verificarSinDeudasVencidas($user, array &$ya): void
    {
        $vencidas = Deuda::where('estado', 'vencida')
            ->orWhere(fn ($q) => $q->where('estado', 'pendiente')->where('fecha_vencimiento', '<', now()))
            ->count();

        if ($vencidas === 0 && Deuda::count() > 0) {
            $this->desbloquear($user, 'sin_deudas_vencidas', $ya);
        }
    }

    private function verificarPresupuesto3Meses($user, array &$ya): void
    {
        $mesesOk = 0;
        for ($i = 2; $i >= 0; $i--) {
            $inicio = now()->subMonths($i)->startOfMonth();
            $fin    = now()->subMonths($i)->endOfMonth();

            $presupuestos = Presupuesto::where('activo', true)->get();
            $todoOk = true;

            foreach ($presupuestos as $p) {
                $gasto = Movimiento::where('categoria_id', $p->categoria_id)
                    ->where('tipo_movimiento', 'egreso')
                    ->whereBetween('fecha', [$inicio, $fin])
                    ->sum('monto');

                if ($gasto > $p->monto_limite) { $todoOk = false; break; }
            }

            if ($todoOk && $presupuestos->count() > 0) $mesesOk++;
        }

        if ($mesesOk >= 3) $this->desbloquear($user, 'presupuesto_3meses', $ya);
    }

    private function verificarMovimientos($user, array &$ya): void
    {
        $total = Movimiento::count();
        if ($total >= 10)  $this->desbloquear($user, 'movimientos_10',  $ya);
        if ($total >= 50)  $this->desbloquear($user, 'movimientos_50',  $ya);
        if ($total >= 100) $this->desbloquear($user, 'movimientos_100', $ya);
    }

    public static function desbloquearBackup(): void
    {
        $user = auth()->user();
        if (!$user) return;

        $ya = LogroUsuario::where('user_id', $user->id)->pluck('logro_key')->toArray();
        if (in_array('primer_backup', $ya)) return;

        LogroUsuario::create([
            'user_id'         => $user->id,
            'logro_key'       => 'primer_backup',
            'desbloqueado_en' => now(),
        ]);

        $def = self::definiciones()['primer_backup'];
        Notification::make()
            ->title("🏅 ¡Logro desbloqueado! {$def['emoji']} {$def['nombre']}")
            ->body($def['descripcion'])
            ->success()
            ->persistent()
            ->sendToDatabase($user);
    }

    public static function getPuntosTotales(): int
    {
        $logros = LogroUsuario::where('user_id', auth()->id())->pluck('logro_key');
        return $logros->sum(fn ($k) => self::puntajeLogro($k));
    }
}

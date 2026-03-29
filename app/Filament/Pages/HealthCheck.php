<?php

namespace App\Filament\Pages;

use App\Models\ActivityLog;
use App\Models\Movimiento;
use App\Models\SecurityLog;
use App\Models\TipoCambio;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class HealthCheck extends Page
{
    protected string $view = 'filament.pages.health-check';
    protected static ?string $navigationLabel = 'Health Check';
    protected static ?string $title = 'Estado del Sistema';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedServerStack;
    protected static string|UnitEnum|null $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 13;

    public function getChecks(): array
    {
        return [
            'Base de datos'       => $this->checkDatabase(),
            'Caché'               => $this->checkCache(),
            'Storage'             => $this->checkStorage(),
            'API Tipos de Cambio' => $this->checkApiTiposCambio(),
            'Scheduler'           => $this->checkScheduler(),
            'Cola de trabajos'    => $this->checkQueue(),
            'Logs de actividad'   => $this->checkActivityLogs(),
            'Seguridad'           => $this->checkSecurity(),
        ];
    }

    public function getInfo(): array
    {
        return [
            'laravel'    => app()->version(),
            'php'        => PHP_VERSION,
            'ambiente'   => app()->environment(),
            'debug'      => config('app.debug') ? '⚠️ Activado' : '✅ Desactivado',
            'timezone'   => config('app.timezone'),
            'bd_driver'  => config('database.default'),
            'cache'      => config('cache.default'),
            'uptime'     => $this->getUptime(),
        ];
    }

    private function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            $tablas = DB::select('SELECT COUNT(*) as total FROM information_schema.tables WHERE table_schema = DATABASE()');
            $total  = $tablas[0]->total ?? 0;
            return [
                'estado'  => 'ok',
                'mensaje' => "Conectado · {$total} tablas",
                'detalle' => 'Driver: ' . config('database.default'),
            ];
        } catch (\Exception $e) {
            return ['estado' => 'error', 'mensaje' => 'Sin conexión', 'detalle' => $e->getMessage()];
        }
    }

    private function checkCache(): array
    {
        try {
            $key = 'healthcheck_' . time();
            Cache::put($key, true, 5);
            $ok = Cache::get($key) === true;
            Cache::forget($key);
            return [
                'estado'  => $ok ? 'ok' : 'warning',
                'mensaje' => $ok ? 'Funcionando' : 'No responde',
                'detalle' => 'Driver: ' . config('cache.default'),
            ];
        } catch (\Exception $e) {
            return ['estado' => 'error', 'mensaje' => 'Error', 'detalle' => $e->getMessage()];
        }
    }

    private function checkStorage(): array
    {
        try {
            $path = 'healthcheck_test.txt';
            Storage::disk('public')->put($path, 'ok');
            $ok = Storage::disk('public')->exists($path);
            Storage::disk('public')->delete($path);
            return [
                'estado'  => $ok ? 'ok' : 'warning',
                'mensaje' => $ok ? 'Lectura/escritura OK' : 'Sin permisos',
                'detalle' => 'Disk: public',
            ];
        } catch (\Exception $e) {
            return ['estado' => 'error', 'mensaje' => 'Error', 'detalle' => $e->getMessage()];
        }
    }

    private function checkApiTiposCambio(): array
    {
        $ultimaActualizacion = TipoCambio::latest('actualizado_en')->first();

        if (!$ultimaActualizacion) {
            return ['estado' => 'warning', 'mensaje' => 'Sin datos', 'detalle' => 'Corre: php artisan ricox:tipos-cambio'];
        }

        $horasDesde = $ultimaActualizacion->actualizado_en
            ? now()->diffInHours($ultimaActualizacion->actualizado_en)
            : 999;

        $estado = $horasDesde <= 25 ? 'ok' : ($horasDesde <= 48 ? 'warning' : 'error');

        return [
            'estado'  => $estado,
            'mensaje' => "Actualizado hace {$horasDesde}h",
            'detalle' => 'Última: ' . ($ultimaActualizacion->actualizado_en?->format('d/m/Y H:i') ?? '—'),
        ];
    }

    private function checkScheduler(): array
    {
        $ultimoTipoCambio = TipoCambio::latest('actualizado_en')->first();
        $diasDesde = $ultimoTipoCambio?->actualizado_en
            ? now()->diffInDays($ultimoTipoCambio->actualizado_en)
            : 999;

        $estado = $diasDesde <= 2 ? 'ok' : ($diasDesde <= 7 ? 'warning' : 'error');
        $msg    = $diasDesde <= 2 ? 'Aparentemente activo' : ($diasDesde <= 7 ? 'Posiblemente inactivo' : 'Inactivo o sin datos');

        return [
            'estado'  => $estado,
            'mensaje' => $msg,
            'detalle' => 'Agrega al cron: * * * * * php artisan schedule:run',
        ];
    }

    private function checkQueue(): array
    {
        try {
            $driver = config('queue.default');
            return [
                'estado'  => 'ok',
                'mensaje' => 'Driver: ' . $driver,
                'detalle' => $driver === 'sync' ? 'Modo síncrono (sin workers)' : 'Asíncrono',
            ];
        } catch (\Exception $e) {
            return ['estado' => 'error', 'mensaje' => 'Error', 'detalle' => $e->getMessage()];
        }
    }

    private function checkActivityLogs(): array
    {
        $total    = ActivityLog::count();
        $antiguos = ActivityLog::where('created_at', '<', now()->subDays(90))->count();

        $estado = $antiguos > 1000 ? 'warning' : 'ok';
        $msg    = "{$total} registros totales";

        return [
            'estado'  => $estado,
            'mensaje' => $msg,
            'detalle' => $antiguos > 0 ? "{$antiguos} registros con más de 90 días" : 'Sin registros antiguos',
        ];
    }

    private function checkSecurity(): array
    {
        $sospechosos = SecurityLog::where('sospechoso', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $estado = $sospechosos === 0 ? 'ok' : ($sospechosos <= 3 ? 'warning' : 'error');
        $msg    = $sospechosos === 0 ? 'Sin alertas recientes' : "{$sospechosos} alertas en los últimos 7 días";

        return [
            'estado'  => $estado,
            'mensaje' => $msg,
            'detalle' => 'Revisa la página de Auditoría de Seguridad',
        ];
    }

    private function getUptime(): string
    {
        try {
            if (PHP_OS_FAMILY === 'Windows') return 'N/A en Windows';
            $uptime = shell_exec('uptime -p') ?? '';
            return trim($uptime) ?: 'N/A';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}

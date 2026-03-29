<?php

namespace App\Filament\Pages;

use App\Models\AbonoDeuda;
use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Deuda;
use App\Models\ListaCompra;
use App\Models\Meta;
use App\Models\Movimiento;
use App\Models\NotaFinanciera;
use App\Models\Presupuesto;
use App\Models\PushSubscription;
use App\Models\Setting;
use App\Models\Subcategoria;
use App\Models\TipoCambio;
use App\Models\Transferencia;
use App\Models\UserSession;
use App\Services\AuditoriaService;
use App\Services\LogrosService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class BackupRestauracion extends Page
{
    protected string $view = 'filament.pages.backup-restauracion';

    protected static ?string $navigationLabel = 'Backup y Restauración';

    protected static ?string $title = 'Backup y Restauración';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCircleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Configuración';

    public bool $restaurando = false;

    public ?string $jsonContent = null;

    public ?array $preview = null;

    public ?string $error = null;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargar')
                ->label('Descargar Backup')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(fn() => $this->descargarBackup()),
        ];
    }

    public function descargarBackup()
    {
        $userId = auth()->id();

        $backup = [
            'version' => '2.0',
            'generado_en' => now()->toISOString(),
            'app' => 'RICOX',
            'datos' => [
                'settings' => Setting::first()?->toArray(),
                'cuentas' => Cuenta::all()->toArray(),
                'categorias' => Categoria::all()->toArray(),
                'subcategorias' => Subcategoria::all()->toArray(),
                'movimientos' => Movimiento::all()->toArray(),
                'transferencias' => Transferencia::all()->toArray(),
                'presupuestos' => Presupuesto::all()->toArray(),
                'metas' => Meta::all()->toArray(),
                'deudas' => Deuda::all()->toArray(),
                'abonos_deuda' => AbonoDeuda::all()->toArray(),
                'tipos_cambio' => TipoCambio::all()->toArray(),
                'user_sessions' => UserSession::where('user_id', $userId)->get()->toArray(),
                'push_subscriptions' => PushSubscription::where('user_id', $userId)->get()->toArray(),
                'lista_compras' => ListaCompra::where('user_id', $userId)->get()->toArray(),
                'notas_financieras' => NotaFinanciera::where('user_id', $userId)->get()->toArray(),
            ],
        ];

        $json = json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        LogrosService::desbloquearBackup();
        app(AuditoriaService::class)->descargaBackup(auth()->user());

        return response()->streamDownload(
            fn() => print($json),
            'ricox_backup_' . now()->format('d_m_Y_His') . '.json',
            ['Content-Type' => 'application/json']
        );
    }

    public function procesarJson(string $contenido): void
    {
        $this->error = null;
        $this->preview = null;

        try {
            $data = json_decode($contenido, true, 512, JSON_THROW_ON_ERROR);

            if (! isset($data['app']) || $data['app'] !== 'RICOX') {
                $this->error = 'El archivo no es un backup válido de RICOX.';

                return;
            }

            $datos = $data['datos'] ?? [];

            $this->preview = [
                'generado_en' => $data['generado_en'] ?? '—',
                'version' => $data['version'] ?? '—',
                'cuentas' => count($datos['cuentas'] ?? []),
                'categorias' => count($datos['categorias'] ?? []),
                'subcategorias' => count($datos['subcategorias'] ?? []),
                'movimientos' => count($datos['movimientos'] ?? []),
                'transferencias' => count($datos['transferencias'] ?? []),
                'presupuestos' => count($datos['presupuestos'] ?? []),
                'metas' => count($datos['metas'] ?? []),
                'deudas' => count($datos['deudas'] ?? []),
                'abonos_deuda' => count($datos['abonos_deuda'] ?? []),
                'tipos_cambio' => count($datos['tipos_cambio'] ?? []),
                'user_sessions' => count($datos['user_sessions'] ?? []),
                'push_subscriptions' => count($datos['push_subscriptions'] ?? []),
                'lista_compras' => count($datos['lista_compras'] ?? []),
                'notas_financieras' => count($datos['notas_financieras'] ?? [])
            ];

            $this->jsonContent = $contenido;
            $this->restaurando = true;
        } catch (\Exception $e) {
            $this->error = 'Error al leer el archivo: ' . $e->getMessage();
        }
    }

    public function confirmarRestauracion(): void
    {
        if (! $this->jsonContent) {
            return;
        }

        try {
            $data = json_decode($this->jsonContent, true);
            $datos = $data['datos'] ?? [];

            DB::transaction(function () use ($datos) {
                $this->restaurarCuentas($datos['cuentas'] ?? []);
                $this->restaurarCategorias($datos['categorias'] ?? []);
                $this->restaurarSubcategorias($datos['subcategorias'] ?? []);
                $this->restaurarMovimientos($datos['movimientos'] ?? []);
                $this->restaurarTransferencias($datos['transferencias'] ?? []);
                $this->restaurarPresupuestos($datos['presupuestos'] ?? []);
                $this->restaurarMetas($datos['metas'] ?? []);
                $this->restaurarDeudas($datos['deudas'] ?? []);
                $this->restaurarAbonosDeuda($datos['abonos_deuda'] ?? []);
                $this->restaurarTiposCambio($datos['tipos_cambio'] ?? []);
                $this->restaurarUserSessions($datos['user_sessions'] ?? []);
                $this->restaurarPushSubscriptions($datos['push_subscriptions'] ?? []);
                $this->restaurarListaCompras($datos['lista_compras'] ?? []);
                $this->restaurarNotasFinancieras($datos['notas_financieras'] ?? []);
            });

            $this->restaurando = false;
            $this->jsonContent = null;
            $this->preview = null;

            Notification::make()->title('Backup restaurado correctamente')->success()->send();
        } catch (\Exception $e) {
            Notification::make()->title('Error al restaurar: ' . $e->getMessage())->danger()->send();
        }
    }

    public function cancelar(): void
    {
        $this->restaurando = false;
        $this->jsonContent = null;
        $this->preview = null;
        $this->error = null;
    }

    private function restaurarCuentas(array $items): void
    {
        foreach ($items as $item) {
            Cuenta::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarCategorias(array $items): void
    {
        foreach ($items as $item) {
            Categoria::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarSubcategorias(array $items): void
    {
        foreach ($items as $item) {
            Subcategoria::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarMovimientos(array $items): void
    {
        foreach ($items as $item) {
            Movimiento::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarTransferencias(array $items): void
    {
        foreach ($items as $item) {
            Transferencia::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarPresupuestos(array $items): void
    {
        foreach ($items as $item) {
            Presupuesto::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarMetas(array $items): void
    {
        foreach ($items as $item) {
            Meta::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarDeudas(array $items): void
    {
        foreach ($items as $item) {
            Deuda::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarAbonosDeuda(array $items): void
    {
        foreach ($items as $item) {
            AbonoDeuda::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarTiposCambio(array $items): void
    {
        foreach ($items as $item) {
            TipoCambio::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarUserSessions(array $items): void
    {
        foreach ($items as $item) {
            UserSession::updateOrCreate(
                ['session_id' => $item['session_id']],
                $item
            );
        }
    }

    private function restaurarPushSubscriptions(array $items): void
    {
        foreach ($items as $item) {
            PushSubscription::updateOrCreate(
                [
                    'user_id' => $item['user_id'],
                    'endpoint' => $item['endpoint'],
                ],
                $item
            );
        }
    }

    private function restaurarListaCompras(array $items): void
    {
        foreach ($items as $item) {
            ListaCompra::firstOrCreate(['id' => $item['id']], $item);
        }
    }

    private function restaurarNotasFinancieras(array $items): void
    {
        foreach ($items as $item) {
            NotaFinanciera::firstOrCreate(['id' => $item['id']], $item);
        }
    }
}

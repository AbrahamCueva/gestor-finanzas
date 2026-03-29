<?php

namespace App\Filament\Pages;

use App\Models\SecurityLog;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AuditoriaSeguridad extends Page
{
    protected string $view = 'filament.pages.auditoria-seguridad';
    protected static ?string $navigationLabel = 'Auditoría de Seguridad';
    protected static ?string $title = 'Auditoría de Seguridad';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;
    protected static string|UnitEnum|null $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 11;

    public string $filtro = 'todos';

    public function getLogs(): object
    {
        $query = SecurityLog::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->limit(100);

        if ($this->filtro === 'sospechosos') {
            $query->where('sospechoso', true);
        } elseif ($this->filtro !== 'todos') {
            $query->where('evento', $this->filtro);
        }

        return $query->get();
    }

    public function getResumen(): array
    {
        $userId = auth()->id();
        return [
            'total'        => SecurityLog::where('user_id', $userId)->count(),
            'sospechosos'  => SecurityLog::where('user_id', $userId)->where('sospechoso', true)->count(),
            'ultimoLogin'  => SecurityLog::where('user_id', $userId)->where('evento', 'login_exitoso')->latest()->first()?->created_at?->diffForHumans() ?? '—',
            'ipsUnicas'    => SecurityLog::where('user_id', $userId)->where('evento', 'login_exitoso')->distinct('ip')->count('ip'),
        ];
    }
}
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
    public int $pagina = 1;
    public int $porPagina = 20;

    public function updatedFiltro(): void
    {
        $this->pagina = 1; // reset al cambiar filtro
    }

    public function getLogs(): array
    {
        $query = SecurityLog::where('user_id', auth()->id())
            ->orderByDesc('created_at');

        if ($this->filtro === 'sospechosos') {
            $query->where('sospechoso', true);
        } elseif ($this->filtro !== 'todos') {
            $query->where('evento', $this->filtro);
        }

        $total = $query->count();
        $items = $query->skip(($this->pagina - 1) * $this->porPagina)
            ->take($this->porPagina)
            ->get();

        return [
            'items' => $items,
            'total' => $total,
            'totalPaginas' => (int) ceil($total / $this->porPagina),
        ];
    }

    public function paginaAnterior(): void
    {
        if ($this->pagina > 1)
            $this->pagina--;
    }

    public function paginaSiguiente(int $totalPaginas): void
    {
        if ($this->pagina < $totalPaginas)
            $this->pagina++;
    }

    public function irAPagina(int $p): void
    {
        $this->pagina = $p;
    }

    public function getResumen(): array
    {
        $userId = auth()->id();
        return [
            'total' => SecurityLog::where('user_id', $userId)->count(),
            'sospechosos' => SecurityLog::where('user_id', $userId)->where('sospechoso', true)->count(),
            'ultimoLogin' => SecurityLog::where('user_id', $userId)->where('evento', 'login_exitoso')->latest()->first()?->created_at?->diffForHumans() ?? '—',
            'ipsUnicas' => SecurityLog::where('user_id', $userId)->where('evento', 'login_exitoso')->distinct('ip')->count('ip'),
        ];
    }
}
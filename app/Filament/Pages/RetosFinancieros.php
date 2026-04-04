<?php

namespace App\Filament\Pages;

use App\Models\Categoria;
use App\Models\Reto;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class RetosFinancieros extends Page
{
    protected string $view = 'filament.pages.retos-financieros';
    protected static ?string $navigationLabel = 'Retos Financieros';
    protected static ?string $title = 'Retos Financieros';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 28;

    // Form nuevo reto
    public bool $modalAbierto = false;
    public string $nombre = '';
    public string $descripcion = '';
    public string $tipo = 'ahorro';
    public string $icono = '🎯';
    public string $color = '#fbbf24';
    public ?float $meta_monto = null;
    public ?int $categoria_id = null;
    public ?int $meta_dias = null;
    public string $fecha_inicio = '';
    public string $fecha_fin = '';
    public string $dificultad = 'medio';
    public string $vistaActiva = 'activos'; // activos, completados, fallidos, plantillas

    public function mount(): void
    {
        $this->fecha_inicio = now()->toDateString();
        $this->fecha_fin = now()->addDays(7)->toDateString();
        // Sincronizar progreso al cargar
        $this->sincronizarRetos();
    }

    public function sincronizarRetos(): void
    {
        Reto::where('user_id', auth()->id())
            ->where('estado', 'activo')
            ->get()
            ->each(fn($r) => $r->calcularProgreso());
    }

    public function getRetos(): array
    {
        $query = Reto::where('user_id', auth()->id())
            ->with('categoria')
            ->orderByDesc('created_at');

        return match ($this->vistaActiva) {
            'completados' => $query->where('estado', 'completado')->get()->toArray(),
            'fallidos' => $query->whereIn('estado', ['fallido', 'abandonado'])->get()->toArray(),
            'activos' => $query->where('estado', 'activo')->get()->toArray(),
            default => $query->where('estado', 'activo')->get()->toArray(),
        };
    }

    public function getResumen(): array
    {
        $userId = auth()->id();
        return [
            'activos' => Reto::where('user_id', $userId)->where('estado', 'activo')->count(),
            'completados' => Reto::where('user_id', $userId)->where('estado', 'completado')->count(),
            'fallidos' => Reto::where('user_id', $userId)->whereIn('estado', ['fallido', 'abandonado'])->count(),
            'puntos' => Reto::where('user_id', $userId)->where('estado', 'completado')->sum('puntos'),
        ];
    }

    public function getCategorias(): array
    {
        return Categoria::where('tipo', 'egreso')->where('activa', true)
            ->pluck('nombre', 'id')->toArray();
    }

    public function getPlantillas(): array
    {
        return [
            ['icono' => '🚫', 'nombre' => 'Sin Entretenimiento', 'descripcion' => 'No gastes en entretenimiento esta semana', 'tipo' => 'egreso_categoria', 'dificultad' => 'medio', 'dias' => 7, 'puntos' => 150],
            ['icono' => '💰', 'nombre' => 'Ahorra S/ 500 este mes', 'descripcion' => 'Logra un ahorro neto de S/ 500', 'tipo' => 'ahorro', 'dificultad' => 'medio', 'dias' => 30, 'puntos' => 200],
            ['icono' => '🍔', 'nombre' => 'Sin Delivery 2 semanas', 'descripcion' => 'No gastes en delivery por 14 días', 'tipo' => 'egreso_categoria', 'dificultad' => 'dificil', 'dias' => 14, 'puntos' => 250],
            ['icono' => '📅', 'nombre' => '7 días registrando', 'descripcion' => 'Registra tus gastos 7 días seguidos', 'tipo' => 'dias_consecutivos', 'dificultad' => 'facil', 'dias' => 7, 'puntos' => 100],
            ['icono' => '🎯', 'nombre' => 'Mes sin deudas nuevas', 'descripcion' => 'No generes nuevas deudas en 30 días', 'tipo' => 'sin_gastos', 'dificultad' => 'dificil', 'dias' => 30, 'puntos' => 300],
            ['icono' => '💪', 'nombre' => 'Ingreso extra S/ 200', 'descripcion' => 'Genera S/ 200 en ingresos extra', 'tipo' => 'ingreso', 'dificultad' => 'dificil', 'dias' => 30, 'puntos' => 250],
            ['icono' => '🛒', 'nombre' => 'Presupuesto semanal', 'descripcion' => 'No superes S/ 150 en compras esta semana', 'tipo' => 'egreso_categoria', 'dificultad' => 'facil', 'dias' => 7, 'puntos' => 100],
            ['icono' => '🏆', 'nombre' => 'Ahorra S/ 1000', 'descripcion' => 'El gran reto: ahorra S/ 1000 en 2 meses', 'tipo' => 'ahorro', 'dificultad' => 'extremo', 'dias' => 60, 'puntos' => 500],
        ];
    }

    public function abrirModal(): void
    {
        $this->modalAbierto = true;
        $this->reset(['nombre', 'descripcion', 'meta_monto', 'categoria_id', 'meta_dias']);
        $this->tipo = 'ahorro';
        $this->icono = '🎯';
        $this->color = '#fbbf24';
        $this->dificultad = 'medio';
        $this->fecha_inicio = now()->toDateString();
        $this->fecha_fin = now()->addDays(7)->toDateString();
    }

    public function cerrarModal(): void
    {
        $this->modalAbierto = false;
    }

    public function usarPlantilla(int $idx): void
    {
        $p = $this->getPlantillas()[$idx];
        $this->nombre = $p['nombre'];
        $this->descripcion = $p['descripcion'];
        $this->icono = $p['icono'];
        $this->tipo = $p['tipo'];
        $this->dificultad = $p['dificultad'];
        $this->fecha_inicio = now()->toDateString();
        $this->fecha_fin = now()->addDays($p['dias'])->toDateString();
        $this->meta_dias = $p['dias'];
        $this->modalAbierto = true;
    }

    public function guardarReto(): void
    {
        $puntos = match ($this->dificultad) {
            'facil' => 100,
            'medio' => 200,
            'dificil' => 350,
            'extremo' => 500,
            default => 100,
        };

        Reto::create([
            'user_id' => auth()->id(),
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'icono' => $this->icono,
            'color' => $this->color,
            'meta_monto' => $this->meta_monto,
            'categoria_id' => $this->categoria_id,
            'meta_dias' => $this->meta_dias,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'dificultad' => $this->dificultad,
            'puntos' => $puntos,
            'estado' => 'activo',
        ]);

        $this->cerrarModal();
        $this->sincronizarRetos();
    }

    public function abandonarReto(int $id): void
    {
        Reto::where('id', $id)->where('user_id', auth()->id())
            ->update(['estado' => 'abandonado']);
    }
}
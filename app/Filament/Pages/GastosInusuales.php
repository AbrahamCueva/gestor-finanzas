<?php

namespace App\Filament\Pages;

use App\Services\GastosInusualesService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class GastosInusuales extends Page
{
    protected string $view = 'filament.pages.gastos-inusuales';
    protected static ?string $navigationLabel = 'Gastos Inusuales';
    protected static ?string $title = 'Análisis de Gastos Inusuales';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;
    protected static string|UnitEnum|null $navigationGroup = 'Análisis';
    protected static ?int $navigationSort = 11;

    public function getDatos(): array
    {
        return app(GastosInusualesService::class)->getAnalisisCompleto();
    }
}
<?php

namespace App\Filament\Pages;

use App\Models\Deuda;
use App\Models\Meta;
use App\Models\Setting;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ReporteMetasDeudas extends Page
{
    protected string $view = 'filament.pages.reporte-metas-deudas';

    protected static ?string $navigationLabel = 'Reporte Metas y Deudas';

    protected static ?string $title = 'Reporte de Metas y Deudas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Análisis';

    protected static ?int $navigationSort = 6;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargar')
                ->label('Descargar PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(fn () => $this->descargarPdf()),
        ];
    }

    public function descargarPdf()
    {
        $datos = $this->getDatos();

        $pdf = Pdf::loadView('pdf.reporte-metas-deudas', [
            'metas' => $datos['metas'],
            'deudas' => $datos['deudas'],
            'settings' => $datos['settings'],
            'totalDebo' => $datos['totalDebo'],
            'totalMeDeben' => $datos['totalMeDeben'],
            'totalMetas' => $datos['totalMetas'],
            'metasCompletas' => $datos['metasCompletas'],
            'generadoEn' => $datos['generadoEn'],
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            'reporte_metas_deudas_'.now()->format('d_m_Y').'.pdf'
        );
    }

    public function getDatos(): array
    {
        $metas = Meta::orderBy('completada')->orderBy('fecha_limite')->get();
        $deudas = Deuda::orderBy('estado')->orderBy('fecha_vencimiento')->get();

        $totalDebo = $deudas->where('tipo', 'debo')->where('estado', '!=', 'pagada')->sum(fn ($d) => $d->restante());
        $totalMeDeben = $deudas->where('tipo', 'me_deben')->where('estado', '!=', 'pagada')->sum(fn ($d) => $d->restante());
        $totalMetas = $metas->where('completada', false)->sum(fn ($m) => $m->restante());
        $metasCompletas = $metas->where('completada', true)->count();

        return [
            'metas' => $metas,
            'deudas' => $deudas,
            'settings' => Setting::first(),
            'totalDebo' => $totalDebo,
            'totalMeDeben' => $totalMeDeben,
            'totalMetas' => $totalMetas,
            'metasCompletas' => $metasCompletas,
            'generadoEn' => now()->translatedFormat('d \d\e F \d\e Y'),
        ];
    }
}

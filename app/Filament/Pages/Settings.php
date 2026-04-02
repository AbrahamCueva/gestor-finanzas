<?php

namespace App\Filament\Pages;

use App\Models\ActivityLog;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Artisan;
use UnitEnum;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationLabel = 'Ajustes del Sistema';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Configuración';

    protected string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $setting = Setting::first();

        $this->form->fill(
            $setting?->toArray() ?? []
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Section::make()
                    ->columns(3)
                    ->schema([

                        Section::make('Identidad')
                            ->description('Nombre y favicon del sistema.')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->columnSpan(1)
                            ->schema([

                                TextInput::make('site_name')
                                    ->label('Nombre del Sistema')
                                    ->required()
                                    ->placeholder('Ej. RICOX')
                                    ->prefixIcon('heroicon-o-globe-alt'),

                                FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->image()
                                    ->directory('settings')
                                    ->imagePreviewHeight('80')
                                    ->panelLayout('integrated')
                                    ->helperText('Recomendado: 32×32 px (.ico, .png)'),

                            ]),

                        Section::make('Logotipos')
                            ->description('Un logo para cada variante de tema.')
                            ->icon('heroicon-o-photo')
                            ->columnSpan(2)
                            ->columns(2)
                            ->schema([

                                FileUpload::make('logo_light')
                                    ->label('Logo Tema Claro')
                                    ->image()
                                    ->directory('settings')
                                    ->imagePreviewHeight('100')
                                    ->panelLayout('integrated')
                                    ->helperText('Se muestra en fondos claros.'),

                                FileUpload::make('logo_dark')
                                    ->label('Logo Tema Oscuro')
                                    ->image()
                                    ->directory('settings')
                                    ->imagePreviewHeight('100')
                                    ->panelLayout('integrated')
                                    ->helperText('Se muestra en fondos oscuros.'),

                            ]),



                    ]),

                Section::make('Modo Mantenimiento')
                    ->schema([
                        Toggle::make('mantenimiento_activo')
                            ->label('Activar modo mantenimiento')
                            ->helperText('Solo el admin podrá acceder mientras esté activo.')
                            ->live(),

                        TextInput::make('mantenimiento_titulo')
                            ->label('Título')
                            ->default('En mantenimiento')
                            ->visible(fn($get) => $get('mantenimiento_activo')),

                        Textarea::make('mantenimiento_mensaje')
                            ->label('Mensaje')
                            ->rows(2)
                            ->visible(fn($get) => $get('mantenimiento_activo')),

                        TextInput::make('mantenimiento_fin')
                            ->label('Regreso estimado')
                            ->placeholder('ej: Hoy a las 6:00 PM')
                            ->visible(fn($get) => $get('mantenimiento_activo')),
                    ]),

                Section::make('🏖️ Modo Vacaciones')
                    ->description('Pausa presupuestos, recurrentes y notificaciones mientras estás de vacaciones.')
                    ->schema([
                        Toggle::make('vacaciones_activo')
                            ->label('Activar modo vacaciones')
                            ->live()
                            ->helperText('Al activar, se pausarán las funciones seleccionadas abajo.'),

                        Grid::make(2)->schema([
                            DatePicker::make('vacaciones_inicio')
                                ->label('Fecha inicio')
                                ->native(false)
                                ->displayFormat('d/m/Y')
                                ->visible(fn(Get $get) => $get('vacaciones_activo')),

                            DatePicker::make('vacaciones_fin')
                                ->label('Fecha fin')
                                ->native(false)
                                ->displayFormat('d/m/Y')
                                ->visible(fn(Get $get) => $get('vacaciones_activo')),
                        ])->visible(fn(Get $get) => $get('vacaciones_activo')),

                        TextInput::make('vacaciones_mensaje')
                            ->label('Mensaje personalizado (opcional)')
                            ->placeholder('Ej: Estoy de vacaciones hasta el 15 de enero')
                            ->visible(fn(Get $get) => $get('vacaciones_activo')),

                        Grid::make(3)->schema([
                            Toggle::make('vacaciones_pausar_presupuestos')
                                ->label('Pausar presupuestos')
                                ->default(true)
                                ->visible(fn(Get $get) => $get('vacaciones_activo')),

                            Toggle::make('vacaciones_pausar_recurrentes')
                                ->label('Pausar recurrentes')
                                ->default(true)
                                ->visible(fn(Get $get) => $get('vacaciones_activo')),

                            Toggle::make('vacaciones_pausar_notificaciones')
                                ->label('Pausar notificaciones')
                                ->default(true)
                                ->visible(fn(Get $get) => $get('vacaciones_activo')),
                        ])->visible(fn(Get $get) => $get('vacaciones_activo')),
                    ])
                    ->collapsible(),

            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            $this->form->getState()
        );

        Artisan::call('filament:clear-cached-components');

        Notification::make()
            ->title('Ajustes actualizados')
            ->success()
            ->send();

        ActivityLog::registrar(
            'configuracion',
            'Configuración del sistema actualizada',
            auth()->user(),
            []
        );

        $this->redirect(request()->header('Referer'));
    }
}

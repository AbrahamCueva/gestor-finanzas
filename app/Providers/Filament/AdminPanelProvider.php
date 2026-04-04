<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Pages\DashboardRatios;
use App\Filament\Pages\PrediccionCategorias;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use App\Filament\Widgets\Regla502030;
use App\Models\Setting;
use Ariefng\FilamentCalculator\CalculatorPlugin;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use CmsMulti\FilamentClearCache\FilamentClearCachePlugin;
use Filament\Enums\UserMenuPosition;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Slimani\MediaManager\MediaManagerPlugin;
use Weave\BlockNote\Filament\BlockNotePlugin;
use YourVendor\FilamentNotificationBell\FilamentNotificationBellPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName(fn() => Setting::get('site_name') ?? 'Gestor de Finanzas')
            ->brandLogo(fn() => view('filament.clusters.brand-logo', [
                'logo' => Setting::get('logo_light')
                    ? asset('storage/' . Setting::get('logo_light'))
                    : null,
                'name' => Setting::get('site_name') ?? 'INV PRO',
            ]))
            ->darkModeBrandLogo(fn() => view('filament.clusters.brand-logo', [
                'logo' => Setting::get('logo_dark')
                    ? asset('storage/' . Setting::get('logo_dark'))
                    : null,
                'name' => Setting::get('site_name') ?? 'INV PRO',
            ]))
            ->favicon(
                fn() => Setting::get('favicon')
                    ? asset('storage/' . Setting::get('favicon'))
                    : null
            )
            ->brandLogoHeight('40px')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->userMenu(position: UserMenuPosition::Sidebar)
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->registration(false)
            ->sidebarFullyCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->plugins([
                CalculatorPlugin::make(),
                BlockNotePlugin::make(),
                FilamentShieldPlugin::make(),
                FilamentSpatieRolesPermissionsPlugin::make(),
                GlobalSearchModalPlugin::make(),
                // FilamentClearCachePlugin::make(),
                // FilamentNotificationBellPlugin::make(),
                // MediaManagerPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('Mi Perfil')
                    ->setNavigationLabel('Mi Perfil')
                    ->setNavigationGroup('Ajustes de Usuario')
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    ->canAccess(fn() => auth()->user()->id === 1)
                    ->shouldRegisterNavigation(true)
                    ->shouldShowEmailForm()
                    ->shouldShowLocaleForm(
                        options: [
                            'pt_BR' => '🇧🇷 Português',
                            'en' => '🇺🇸 Inglês',
                            'es' => '🇪🇸 Espanhol',
                        ],
                        rules: 'required'
                    )
                    ->shouldShowThemeColorForm(rules: 'required')
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowSanctumTokens()
                    ->shouldShowMultiFactorAuthentication()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(),
            ])
            ->renderHook(
                'panels::head.end',
                fn() => view('filament.pwa-head'),
            )
            ->renderHook(
                'panels::body.start',
                fn() => implode('', [
                    view('filament.notificaciones-hook')->render(),
                    view('filament.vacaciones-banner')->render(),
                ])
            )
            ->renderHook(
                'panels::body.end',
                fn() => implode('', [
                    view('filament.tour')->render(),
                    view('filament.asistente-ia')->render(),
                    view('filament.categorizacion-ia')->render(),
                    view('filament.pwa-sw')->render(),
                ])
            )
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
                Regla502030::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

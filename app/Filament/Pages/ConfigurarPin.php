<?php

namespace App\Filament\Pages;

use App\Services\AuditoriaService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use UnitEnum;

class ConfigurarPin extends Page
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.configurar-pin';

    protected static ?string $navigationLabel = 'Configurar PIN';

    protected static ?string $title = 'Configurar PIN de Acceso';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLockClosed;

    protected static string|UnitEnum|null $navigationGroup = 'Configuración';

    public ?array $data = [];

    public function mount(): void
    {
        $user = auth()->user();
        $this->form->fill([
            'pin_activo' => $user->pin_activo,
            'pin_inactividad_minutos' => $user->pin_inactividad_minutos ?? 15,
            'tiene_pin' => ! empty($user->pin),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Estado del PIN')
                    ->schema([
                        Toggle::make('pin_activo')
                            ->label('Activar PIN de acceso')
                            ->helperText('Se pedirá el PIN al abrir la app y tras inactividad.')
                            ->live(),

                        Select::make('pin_inactividad_minutos')
                            ->label('Bloquear tras inactividad')
                            ->options([
                                5 => '5 minutos',
                                10 => '10 minutos',
                                15 => '15 minutos',
                                30 => '30 minutos',
                                60 => '1 hora',
                            ])
                            ->visible(fn($get) => $get('pin_activo')),
                    ]),

                Section::make('Cambiar PIN')
                    ->schema([
                        TextInput::make('pin_nuevo')
                            ->label('Nuevo PIN')
                            ->password()
                            ->length(6)
                            ->numeric()
                            ->placeholder('••••••'),

                        TextInput::make('pin_nuevo_confirmation')
                            ->label('Confirmar PIN')
                            ->password()
                            ->length(6)
                            ->numeric()
                            ->placeholder('••••••'),
                    ]),

                Action::make('desactivar2fa')
                    ->label('Desactivar 2FA')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('danger')
                    ->form([
                        TextInput::make('code')
                            ->label('Código de verificación actual')
                            ->required()
                            ->length(6)
                            ->numeric(),
                    ])
                    ->action(function (array $data) {
                        $user  = auth()->user();
                        $g2fa  = new Google2FA();
                        $valid = $g2fa->verifyKey($user->two_factor_secret, $data['code']);

                        if (!$valid) {
                            Notification::make()
                                ->title('Código incorrecto')
                                ->danger()
                                ->send();
                            return;
                        }

                        $user->update([
                            'two_factor_secret'       => null,
                            'two_factor_confirmed'    => false,
                            'two_factor_confirmed_at' => null,
                        ]);

                        session()->forget('2fa_verificado');

                        Notification::make()
                            ->title('2FA desactivado correctamente')
                            ->success()
                            ->send();

                        redirect()->route('2fa.setup');
                    }),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('guardar')
                ->label('Guardar cambios')
                ->icon('heroicon-o-check-circle')
                ->color('primary')
                ->action(fn() => $this->guardar()),
        ];
    }

    public function guardar(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();

        $update = [
            'pin_activo' => $data['pin_activo'],
            'pin_inactividad_minutos' => $data['pin_inactividad_minutos'] ?? 15,
        ];

        if (! empty($data['pin_nuevo'])) {
            if ($data['pin_nuevo'] !== $data['pin_nuevo_confirmation']) {
                Notification::make()->title('Los PINs no coinciden.')->danger()->send();

                return;
            }
            $update['pin'] = Hash::make($data['pin_nuevo']);
            app(AuditoriaService::class)->cambioPin(auth()->user());
        }

        if ($data['pin_activo'] && empty($user->pin) && empty($data['pin_nuevo'])) {
            Notification::make()->title('Debes establecer un PIN antes de activarlo.')->warning()->send();

            return;
        }

        $user->update($update);

        if ($data['pin_activo']) {
            session(['pin_verificado_en' => now()->timestamp]);
        }

        Notification::make()->title('Configuración de PIN guardada.')->success()->send();
    }
}

<?php

use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\TwoFactorController;
use App\Models\NotaFinanciera;
use App\Models\Setting;
use App\Services\AsistenteIAService;
use App\Services\CategorizacionService;
use App\Services\GastosInusualesService;
use App\Services\LogrosService;
use App\Services\NotificacionesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/pin/verificar', [PinController::class, 'mostrar'])->name('pin.verificar');
    Route::post('/pin/verificar', [PinController::class, 'verificar'])->name('pin.verificar.post');
    Route::get('/pin/recuperar', [PinController::class, 'mostrarRecuperar'])->name('pin.recuperar');
    Route::post('/pin/recuperar', [PinController::class, 'enviarRecuperar'])->name('pin.recuperar.post');
    Route::get('/pin/reset/{token}', [PinController::class, 'mostrarReset'])->name('pin.reset');
    Route::post('/pin/reset/{token}', [PinController::class, 'reset'])->name('pin.reset.post');

    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding/cuenta', [OnboardingController::class, 'guardarCuenta'])->name('onboarding.cuenta');
    Route::post('/onboarding/categoria', [OnboardingController::class, 'guardarCategoria'])->name('onboarding.categoria');
    Route::post('/onboarding/presupuesto', [OnboardingController::class, 'guardarPresupuesto'])->name('onboarding.presupuesto');
    Route::post('/onboarding/saltar', [OnboardingController::class, 'saltar'])->name('onboarding.saltar');

    Route::get('/2fa/setup',    [TwoFactorController::class, 'mostrarSetup'])->name('2fa.setup');
    Route::post('/2fa/setup',   [TwoFactorController::class, 'confirmarSetup'])->name('2fa.setup.post');
    Route::get('/2fa/verificar',[TwoFactorController::class, 'mostrarVerificar'])->name('2fa.verificar');
    Route::post('/2fa/verificar',[TwoFactorController::class, 'verificar'])->name('2fa.verificar.post');
    Route::post('/2fa/desactivar',[TwoFactorController::class, 'desactivar'])->name('2fa.desactivar');
});

Route::get('/', function () {
    return view('welcome');
});

Route::post('/ricox/verificar-notificaciones', function () {
    app(NotificacionesService::class)->verificarTodo();

    return response()->json(['ok' => true]);
})->middleware(['auth']);

Route::post('/ricox/verificar-logros', function () {
    app(LogrosService::class)->verificar();

    return response()->json(['ok' => true]);
})->middleware(['auth']);

Route::get('/mantenimiento', function () {
    $settings = Setting::first();
    if (! $settings?->mantenimiento_activo) {
        return redirect('/');
    }

    return view('mantenimiento', compact('settings'));
})->name('mantenimiento');

Route::post('/ricox/verificar-gastos-inusuales', function () {
    app(GastosInusualesService::class)->analizar();
    return response()->json(['ok' => true]);
})->middleware(['auth']);

Route::post('/ricox/asistente-ia', function (Request $request) {
    return app(AsistenteIAService::class)->responder(
        $request->input('mensaje'),
        $request->input('historial', [])
    );
})->middleware(['auth']);

Route::post('/ricox/sugerir-categoria', function (Request $request) {
    return app(CategorizacionService::class)->sugerir(
        $request->input('descripcion'),
        $request->input('monto', 0),
        $request->input('tipo', 'egreso')
    );
})->middleware(['auth']);

Route::get('/offline', fn() => view('offline'))->name('offline');

use App\Models\PushSubscription;

// Suscribirse a push
Route::post('/ricox/push/suscribir', function (Request $request) {
    PushSubscription::updateOrCreate(
        [
            'user_id'  => auth()->id(),
            'endpoint' => $request->input('endpoint'),
        ],
        [
            'public_key' => $request->input('keys.p256dh'),
            'auth_token' => $request->input('keys.auth'),
        ]
    );
    return response()->json(['ok' => true]);
})->middleware(['auth']);

// Desuscribirse
Route::post('/ricox/push/desuscribir', function (Request $request) {
    PushSubscription::where('user_id', auth()->id())
        ->where('endpoint', $request->input('endpoint'))
        ->delete();
    return response()->json(['ok' => true]);
})->middleware(['auth']);

// Clave pública VAPID
Route::get('/ricox/push/vapid-key', function () {
    return response()->json(['key' => config('services.vapid.public_key')]);
})->middleware(['auth']);

Route::put('/ricox/notas/{id}', function (Request $request, $id) {
    NotaFinanciera::where('user_id', auth()->id())
        ->find($id)
        ?->update($request->only(['titulo', 'tipo', 'contenido', 'color']));
    return response()->json(['ok' => true]);
})->middleware(['auth']);

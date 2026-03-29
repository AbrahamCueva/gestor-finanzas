<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function mostrarSetup()
    {
        $user = auth()->user();

        if ($user->two_factor_confirmed) {
            return redirect('/admin');
        }

        if (!$user->two_factor_secret) {
            $secret = $this->google2fa->generateSecretKey();
            $user->update(['two_factor_secret' => $secret]);
        }

        $appName = config('app.name', 'RICOX');
        $qrUrl   = $this->google2fa->getQRCodeUrl($appName, $user->email, $user->two_factor_secret);

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrSvg  = $writer->writeString($qrUrl);

        $settings = Setting::first();

        return view('2fa.setup', compact('qrSvg', 'user', 'settings'));
    }

    public function confirmarSetup(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $user  = auth()->user();
        $valid = $this->google2fa->verifyKey($user->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto. Intenta de nuevo.']);
        }

        $user->update([
            'two_factor_confirmed'    => true,
            'two_factor_confirmed_at' => now(),
        ]);

        session(['2fa_verificado' => true]);

        return redirect('/admin')->with('success', '2FA activado correctamente.');
    }

    public function mostrarVerificar()
    {
        $user = auth()->user();

        if (!$user->two_factor_secret || session('2fa_verificado')) {
            return redirect('/admin');
        }

        $settings = Setting::first();
        return view('2fa.verificar', compact('user', 'settings'));
    }

    public function verificar(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $user  = auth()->user();
        $valid = $this->google2fa->verifyKey($user->two_factor_secret, $request->code);

        if (!$valid) {
            return back()
                ->withErrors(['code' => 'Código incorrecto.'])
                ->with('shake', true);
        }

        session(['2fa_verificado' => true]);

        $intended = session('url.intended', '/admin');
        return redirect($intended);
    }

    public function desactivar(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $user  = auth()->user();
        $valid = $this->google2fa->verifyKey($user->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto.']);
        }

        $user->update([
            'two_factor_secret'       => null,
            'two_factor_confirmed'    => false,
            'two_factor_confirmed_at' => null,
        ]);

        session()->forget('2fa_verificado');

        return redirect()->route('2fa.setup');
    }
}

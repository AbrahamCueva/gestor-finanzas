<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PinController extends Controller
{
    public function mostrar()
    {
        if (!auth()->user()?->pin_activo) {
            return redirect('/admin');
        }
        return view('pin.verificar');
    }

    public function verificar(Request $request)
    {
        $pin = implode('', $request->input('digits', []));

        if (strlen($pin) !== 6) {
            return back()->withErrors(['pin' => 'Ingresa los 6 dígitos.']);
        }

        if (!auth()->user()->verificarPin($pin)) {
            return back()->withErrors(['pin' => 'PIN incorrecto.'])->with('shake', true);
        }

        session(['pin_verificado_en' => now()->timestamp]);

        $intended = session('intended', '/admin');
        return redirect($intended);
    }

    public function mostrarRecuperar()
    {
        return view('pin.recuperar');
    }

    public function enviarRecuperar(Request $request)
    {
        $user = auth()->user();
        $token = Str::random(32);

        cache()->put('pin_reset_' . $user->id, $token, now()->addMinutes(15));

        $url = route('pin.reset', ['token' => $token]);

        Mail::send([], [], function ($message) use ($user, $url) {
            $message->to($user->email)
                ->subject('Recuperar PIN — RICOX')
                ->html("
                    <div style='font-family:sans-serif;max-width:480px;margin:auto;'>
                        <h2 style='color:#fbbf24;'>Recuperar PIN</h2>
                        <p>Haz click en el botón para restablecer tu PIN de acceso. El enlace expira en 15 minutos.</p>
                        <a href='{$url}' style='display:inline-block;background:#fbbf24;color:#0f172a;padding:10px 24px;border-radius:8px;text-decoration:none;font-weight:700;margin-top:16px;'>
                            Restablecer PIN
                        </a>
                        <p style='color:#6b7280;margin-top:16px;font-size:12px;'>Si no solicitaste esto, ignora este correo.</p>
                    </div>
                ");
        });

        return back()->with('enviado', 'Te enviamos un enlace a ' . $user->email);
    }

    public function mostrarReset(string $token)
    {
        $user  = auth()->user();
        $saved = cache()->get('pin_reset_' . $user->id);

        if (!$saved || $saved !== $token) {
            abort(403, 'Token inválido o expirado.');
        }

        return view('pin.reset', compact('token'));
    }

    public function reset(Request $request, string $token)
    {
        $user  = auth()->user();
        $saved = cache()->get('pin_reset_' . $user->id);

        if (!$saved || $saved !== $token) {
            abort(403, 'Token inválido o expirado.');
        }

        $request->validate([
            'pin'              => 'required|digits:6',
            'pin_confirmation' => 'required|same:pin',
        ]);

        $user->update(['pin' => Hash::make($request->pin)]);
        cache()->forget('pin_reset_' . $user->id);
        session(['pin_verificado_en' => now()->timestamp]);

        return redirect('/admin')->with('success', 'PIN restablecido correctamente.');
    }
}

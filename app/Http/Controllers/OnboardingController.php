<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        if (auth()->user()->onboarding_completado) {
            return redirect('/admin');
        }

        return view('onboarding');
    }

    public function guardarCuenta(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_cuenta' => 'required|string',
            'saldo_inicial' => 'required|numeric|min:0',
            'moneda' => 'required|string',
        ]);

        Cuenta::create([
            'nombre' => $request->nombre,
            'tipo_cuenta' => $request->tipo_cuenta,
            'saldo_inicial' => $request->saldo_inicial,
            'saldo_actual' => $request->saldo_inicial,
            'moneda' => $request->moneda,
            'activa' => true,
        ]);

        return response()->json(['ok' => true]);
    }

    public function guardarCategoria(Request $request)
    {
        $request->validate([
            'categorias' => 'required|array|min:1',
            'categorias.*.nombre' => 'required|string',
            'categorias.*.tipo' => 'required|in:ingreso,egreso',
        ]);

        $creadas = [];
        foreach ($request->categorias as $cat) {
            $creada = Categoria::create([
                'nombre' => $cat['nombre'],
                'tipo' => $cat['tipo'],
                'icono' => $cat['icono'] ?? '📦',
                'color' => $cat['color'] ?? '#6b7280',
                'activa' => true,
            ]);
            if ($creada->tipo === 'egreso') {
                $creadas[] = ['id' => $creada->id, 'nombre' => $creada->nombre];
            }
        }

        return response()->json(['ok' => true, 'categorias' => $creadas]);
    }

    public function guardarPresupuesto(Request $request)
    {
        $request->validate([
            'presupuestos' => 'required|array',
            'presupuestos.*.categoria_id' => 'required|exists:categorias,id',
            'presupuestos.*.monto_limite' => 'required|numeric|min:1',
        ]);

        foreach ($request->presupuestos as $p) {
            Presupuesto::create([
                'categoria_id' => $p['categoria_id'],
                'monto_limite' => $p['monto_limite'],
                'periodo' => 'mensual',
                'fecha_inicio' => now()->startOfMonth(),
                'fecha_fin' => now()->endOfMonth(),
                'activo' => true,
            ]);
        }

        auth()->user()->update(['onboarding_completado' => true]);

        return response()->json(['ok' => true, 'redirect' => '/admin']);
    }

    public function saltar()
    {
        auth()->user()->update(['onboarding_completado' => true]);

        return redirect('/admin');
    }
}

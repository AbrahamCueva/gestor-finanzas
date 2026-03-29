<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar PIN — RICOX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0a0a;
            color: #f9fafb;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-glow {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.07) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            padding: 2rem 2.5rem;
            width: 100%;
            max-width: 360px;
            text-align: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 900;
            color: #fbbf24;
            margin-bottom: 0.25rem;
        }

        .titulo {
            font-size: 1rem;
            font-weight: 700;
            color: #f9fafb;
            margin: 1.5rem 0 0.5rem;
        }

        .sub {
            font-size: 0.78rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .success-box {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.8rem;
            color: #22c55e;
            margin-bottom: 1rem;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.75rem;
            background: #fbbf24;
            color: #0f172a;
            font-size: 0.875rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
            margin-bottom: 1rem;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .link {
            font-size: 0.72rem;
            color: #6b7280;
            text-decoration: none;
        }

        .link:hover {
            color: #fbbf24;
        }
    </style>
</head>

<body>
    <div class="bg-glow"></div>
    <div class="card">
        @php $settings = \App\Models\Setting::first(); @endphp
        <div class="logo">{{ $settings?->site_name ?? 'RICOX' }}</div>
        <div class="titulo">Recuperar PIN</div>
        <div class="sub">Te enviaremos un enlace a tu correo para restablecer tu PIN. El enlace expira en 15 minutos.
        </div>

        @if (session('enviado'))
            <div class="success-box">{{ session('enviado') }}</div>
        @endif

        <form method="POST" action="{{ route('pin.recuperar.post') }}">
            @csrf
            <button type="submit" class="btn">Enviar enlace al correo</button>
        </form>

        <a href="{{ route('pin.verificar') }}" class="link">← Volver al PIN</a>
    </div>
</body>

</html>

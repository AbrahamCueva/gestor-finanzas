<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Página no encontrada</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #0a0a0a;
            color: #f9fafb;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Glow de fondo */
        .bg-glow {
            position: fixed;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(251,191,36,0.08) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .container {
            text-align: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
            max-width: 480px;
        }

        /* Número 404 */
        .numero {
            font-size: 8rem;
            font-weight: 900;
            letter-spacing: -0.05em;
            line-height: 1;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            animation: pulso 3s ease-in-out infinite;
        }

        @keyframes pulso {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        /* Logo */
        .logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            margin-bottom: 2rem;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: #fbbf24;
            letter-spacing: -0.02em;
        }

        /* Línea dorada */
        .gold-line {
            width: 48px; height: 3px;
            background: linear-gradient(90deg, #fbbf24, #d97706);
            border-radius: 99px;
            margin: 0 auto 1.5rem;
        }

        .titulo {
            font-size: 1.25rem;
            font-weight: 700;
            color: #f9fafb;
            margin-bottom: 0.75rem;
        }

        .descripcion {
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Botones */
        .btns {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.625rem;
            font-size: 0.825rem;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.15s, transform 0.15s;
            border: none; cursor: pointer;
        }

        .btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .btn svg { width: 15px; height: 15px; }

        .btn-primary {
            background: #fbbf24;
            color: #0f172a;
        }

        .btn-secondary {
            background: rgba(255,255,255,0.06);
            color: #9ca3af;
            border: 1px solid rgba(255,255,255,0.08);
        }

        /* Partículas decorativas */
        .particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 2px; height: 2px;
            background: #fbbf24;
            border-radius: 50%;
            opacity: 0;
            animation: flotar var(--dur) var(--delay) ease-in-out infinite;
        }

        @keyframes flotar {
            0%   { opacity: 0; transform: translateY(100vh) scale(0); }
            10%  { opacity: 0.6; }
            90%  { opacity: 0.2; }
            100% { opacity: 0; transform: translateY(-10vh) scale(1.5); }
        }
    </style>
</head>
<body>

<div class="bg-glow"></div>

<div class="particles">
    @for($i = 0; $i < 20; $i++)
        <div class="particle" style="
            left: {{ rand(0, 100) }}%;
            --dur: {{ rand(6, 14) }}s;
            --delay: {{ rand(0, 8) }}s;
            width: {{ rand(1, 3) }}px;
            height: {{ rand(1, 3) }}px;
            opacity: {{ rand(2, 6) / 10 }};
        "></div>
    @endfor
</div>

<div class="container">

    @php $settings = \App\Models\Setting::first(); @endphp
    <div class="logo-wrap">
        @if($settings?->logo_dark)
            @php
                $path = storage_path('app/public/' . $settings->logo_dark);
            @endphp
            @if(file_exists($path))
                <img src="{{ asset('storage/' . $settings->logo_dark) }}" style="height:32px; width:auto;" alt="logo">
            @endif
        @endif
        <span class="logo-text">{{ $settings?->site_name ?? 'RICOX' }}</span>
    </div>

    <div class="numero">404</div>

    <div class="gold-line"></div>

    <div class="titulo">Página no encontrada</div>
    <div class="descripcion">
        La página que buscas no existe o fue movida.<br>
        Vuelve al inicio para continuar gestionando tus finanzas.
    </div>

    <div class="btns">
        <a href="/admin" class="btn btn-primary">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            Ir al Dashboard
        </a>
        <a href="javascript:history.back()" class="btn btn-secondary">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Volver atrás
        </a>
    </div>

</div>

</body>
</html>

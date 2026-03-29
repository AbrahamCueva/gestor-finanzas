<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento — {{ $settings?->site_name ?? 'RICOX' }}</title>
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
            overflow: hidden;
        }

        .bg-glow {
            position: fixed;
            width: 600px;
            height: 600px;
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
            text-align: center;
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 100%;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 900;
            color: #fbbf24;
            margin-bottom: 2.5rem;
        }

        .icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: spin 8s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg)
            }

            100% {
                transform: rotate(360deg)
            }
        }

        .titulo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #f9fafb;
            letter-spacing: -0.02em;
            margin-bottom: 0.75rem;
        }

        .mensaje {
            font-size: 0.9rem;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .gold-line {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #d97706);
            border-radius: 99px;
            margin: 0 auto 2rem;
        }

        .fin-wrap {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.875rem;
            padding: 1rem 1.5rem;
            display: inline-block;
        }

        .fin-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .fin-valor {
            font-size: 1rem;
            font-weight: 700;
            color: #fbbf24;
        }

        /* Partículas */
        .particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #fbbf24;
            border-radius: 50%;
            opacity: 0;
            animation: flotar var(--dur) var(--delay) ease-in-out infinite;
        }

        @keyframes flotar {
            0% {
                opacity: 0;
                transform: translateY(100vh);
            }

            10% {
                opacity: 0.4;
            }

            90% {
                opacity: 0.1;
            }

            100% {
                opacity: 0;
                transform: translateY(-10vh);
            }
        }
    </style>
</head>

<body>
    <div class="bg-glow"></div>
    <div class="particles">
        @for ($i = 0; $i < 15; $i++)
            <div class="particle"
                style="left:{{ rand(0, 100) }}%; --dur:{{ rand(6, 14) }}s; --delay:{{ rand(0, 8) }}s;"></div>
        @endfor
    </div>

    <div class="card">
        <div class="logo">{{ $settings?->site_name ?? 'RICOX' }}</div>
        <div class="icon">⚙️</div>
        <div class="titulo">{{ $settings->mantenimiento_titulo ?? 'En mantenimiento' }}</div>
        <div class="gold-line"></div>
        <div class="mensaje">
            {{ $settings->mantenimiento_mensaje ?? 'Estamos trabajando para mejorar tu experiencia. Vuelve pronto.' }}
        </div>

        @if ($settings->mantenimiento_fin)
            <div class="fin-wrap">
                <div class="fin-label">Regreso estimado</div>
                <div class="fin-valor">{{ $settings->mantenimiento_fin }}</div>
            </div>
        @endif
    </div>
</body>

</html>

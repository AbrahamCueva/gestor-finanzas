<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar 2FA — RICOX</title>
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

        .wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            padding: 2rem;
            text-align: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 900;
            color: #fbbf24;
            margin-bottom: 0.25rem;
        }

        .logo-sub {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 1.75rem;
        }

        .titulo {
            font-size: 1.1rem;
            font-weight: 800;
            color: #f9fafb;
            margin-bottom: 0.5rem;
        }

        .subtitulo {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        /* Steps */
        .steps {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .step {
            display: flex;
            gap: 0.875rem;
            align-items: flex-start;
        }

        .step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #fbbf24;
            color: #0f172a;
            font-size: 0.72rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .step-content {
            flex: 1;
        }

        .step-titulo {
            font-size: 0.825rem;
            font-weight: 600;
            color: #f9fafb;
            margin-bottom: 0.2rem;
        }

        .step-desc {
            font-size: 0.72rem;
            color: #6b7280;
            line-height: 1.5;
        }

        /* QR */
        .qr-wrap {
            background: white;
            border-radius: 0.75rem;
            padding: 0.875rem;
            display: inline-block;
            margin: 0.875rem 0;
        }

        .qr-wrap svg {
            display: block;
        }

        /* Secret */
        .secret-wrap {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.625rem;
            padding: 0.625rem 0.875rem;
            font-family: monospace;
            font-size: 0.875rem;
            color: #fbbf24;
            letter-spacing: 0.1em;
            margin-bottom: 1.5rem;
            word-break: break-all;
        }

        /* Input */
        .input-wrap {
            margin-bottom: 1rem;
            text-align: left;
        }

        .input-label {
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 0.375rem;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .input-code {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.625rem;
            padding: 0.75rem 1rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #f9fafb;
            outline: none;
            text-align: center;
            letter-spacing: 0.2em;
            transition: border-color 0.15s;
        }

        .input-code:focus {
            border-color: #fbbf24;
        }

        .error-msg {
            font-size: 0.75rem;
            color: #ef4444;
            margin-bottom: 0.875rem;
        }

        .btn-primary {
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
        }

        .btn-primary:hover {
            opacity: 0.85;
        }

        .gold-line {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #d97706);
            border-radius: 99px;
            margin: 1rem auto;
        }
    </style>
</head>

<body>
    <div class="bg-glow"></div>

    <div class="wrap">
        <div class="card">
            @php $settings = \App\Models\Setting::first(); @endphp
            <div class="logo">{{ $settings?->site_name ?? 'RICOX' }}</div>
            <div class="logo-sub">Autenticación de dos factores</div>

            <div class="titulo">🔐 Configura tu 2FA</div>
            <div class="subtitulo">
                Para mayor seguridad, RICOX requiere autenticación de dos factores.
                Sigue estos pasos para configurarlo.
            </div>

            <div class="gold-line"></div>

            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-content">
                        <div class="step-titulo">Descarga Google Authenticator o Authy</div>
                        <div class="step-desc">Disponible en App Store y Google Play.</div>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-content">
                        <div class="step-titulo">Escanea el código QR</div>
                        <div class="step-desc">Abre la app y escanea el código de abajo. Si no puedes escanearlo,
                            ingresa la clave manualmente.</div>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-content">
                        <div class="step-titulo">Ingresa el código de 6 dígitos</div>
                        <div class="step-desc">La app generará un código nuevo cada 30 segundos.</div>
                    </div>
                </div>
            </div>

            <div class="qr-wrap">
                {!! $qrSvg !!}
            </div>

            <div style="font-size:0.68rem; color:#6b7280; margin-bottom:0.5rem;">O ingresa esta clave manualmente:</div>
            <div class="secret-wrap">{{ $user->two_factor_secret }}</div>

            <form method="POST" action="{{ route('2fa.setup.post') }}">
                @csrf
                <div class="input-wrap">
                    <label class="input-label">Código de verificación</label>
                    <input type="text" name="code" class="input-code" placeholder="000000" maxlength="6"
                        autocomplete="one-time-code" inputmode="numeric" autofocus>
                </div>
                @error('code')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn-primary">Activar 2FA y continuar</button>
            </form>
        </div>
    </div>
</body>

</html>

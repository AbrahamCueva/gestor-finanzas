<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIN de Acceso — RICOX</title>
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
            backdrop-filter: blur(12px);
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
            margin-bottom: 2rem;
        }

        .avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(251, 191, 36, 0.12);
            border: 2px solid rgba(251, 191, 36, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.25rem;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #f9fafb;
            margin-bottom: 0.25rem;
        }

        .user-email {
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 1.75rem;
        }

        .pin-titulo {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-bottom: 1.25rem;
        }

        /* Dots */
        .pin-dots {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 1.75rem;
        }

        .pin-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.15);
            background: transparent;
            transition: all 0.15s;
        }

        .pin-dot.filled {
            background: #fbbf24;
            border-color: #fbbf24;
        }

        .pin-dot.error {
            background: #ef4444;
            border-color: #ef4444;
        }

        /* Teclado numérico */
        .keypad {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.625rem;
            margin-bottom: 1rem;
        }

        .key {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.75rem;
            padding: 0.875rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #f9fafb;
            cursor: pointer;
            transition: background 0.1s, transform 0.1s;
            user-select: none;
        }

        .key:hover {
            background: rgba(251, 191, 36, 0.1);
            border-color: rgba(251, 191, 36, 0.2);
        }

        .key:active {
            transform: scale(0.94);
            background: rgba(251, 191, 36, 0.2);
        }

        .key-del {
            font-size: 0.875rem;
            color: #9ca3af;
        }

        .key-empty {
            visibility: hidden;
        }

        .error-msg {
            font-size: 0.75rem;
            color: #ef4444;
            margin-bottom: 1rem;
            min-height: 1.1rem;
        }

        .shake {
            animation: shake 0.4s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-8px);
            }

            40% {
                transform: translateX(8px);
            }

            60% {
                transform: translateX(-6px);
            }

            80% {
                transform: translateX(6px);
            }
        }

        .link {
            font-size: 0.72rem;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.15s;
        }

        .link:hover {
            color: #fbbf24;
        }

        @keyframes pulso {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0.6
            }
        }
    </style>
</head>

<body>

    <div class="bg-glow"></div>

    <div class="card" id="card">
        @php
            $user = auth()->user();
            $settings = \App\Models\Setting::first();
        @endphp

        <div class="logo">{{ $settings?->site_name ?? 'RICOX' }}</div>
        <div class="logo-sub">Gestor de Finanzas Personales</div>

        <div class="avatar">
            @php
                $avatarUrl = null;
                if ($user->avatar_url) {
                    $avatarUrl = filter_var($user->avatar_url, FILTER_VALIDATE_URL)
                        ? $user->avatar_url
                        : asset('storage/' . $user->avatar_url);
                }
            @endphp

            @if ($avatarUrl)
                <img src="{{ $avatarUrl }}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;"
                    alt="{{ $user->name }}">
            @else
                <span style="font-size:1.25rem;">👤</span>
            @endif
        </div>
        <div class="user-name">{{ $user->name }}</div>
        <div class="user-email">{{ $user->email }}</div>

        <div class="pin-titulo">Ingresa tu PIN de 6 dígitos</div>

        <div class="pin-dots" id="pinDots">
            @for ($i = 0; $i < 6; $i++)
                <div class="pin-dot" id="dot-{{ $i }}"></div>
            @endfor
        </div>

        <div class="error-msg" id="errorMsg">
            @error('pin')
                {{ $message }}
            @enderror
        </div>

        <form method="POST" action="{{ route('pin.verificar.post') }}" id="pinForm">
            @csrf
            @for ($i = 0; $i < 6; $i++)
                <input type="hidden" name="digits[]" id="digit-{{ $i }}" value="">
            @endfor
        </form>

        <div class="keypad" id="keypad">
            @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $n)
                <button class="key" onclick="presionar({{ $n }})">{{ $n }}</button>
            @endforeach
            <button class="key key-empty" disabled></button>
            <button class="key" onclick="presionar(0)">0</button>
            <button class="key key-del" onclick="borrar()">⌫</button>
        </div>

        <a href="{{ route('pin.recuperar') }}" class="link">¿Olvidaste tu PIN?</a>
    </div>

    <script>
        let pin = [];
        const MAX = 6;

        @if (session('shake'))
            document.getElementById('card').classList.add('shake');
        @endif

        function presionar(num) {
            if (pin.length >= MAX) return;
            pin.push(num);
            actualizarDots();
            if (pin.length === MAX) {
                setTimeout(enviar, 200);
            }
        }

        function borrar() {
            pin.pop();
            actualizarDots();
        }

        function actualizarDots() {
            for (let i = 0; i < MAX; i++) {
                const dot = document.getElementById('dot-' + i);
                dot.classList.toggle('filled', i < pin.length);
            }
        }

        function enviar() {
            pin.forEach((d, i) => {
                document.getElementById('digit-' + i).value = d;
            });
            document.getElementById('pinForm').submit();
        }

        // Teclado físico
        document.addEventListener('keydown', function(e) {
            if (e.key >= '0' && e.key <= '9') presionar(parseInt(e.key));
            if (e.key === 'Backspace') borrar();
        });
    </script>
</body>

</html>

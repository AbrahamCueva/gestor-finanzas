<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo PIN — RICOX</title>
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
            margin-bottom: 1.75rem;
        }

        .pin-titulo {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-bottom: 1rem;
        }

        .pin-dots {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 1rem;
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

        .keypad {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.625rem;
            margin-bottom: 1.25rem;
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
        }

        .key:hover {
            background: rgba(251, 191, 36, 0.1);
        }

        .key:active {
            transform: scale(0.94);
        }

        .key-del {
            font-size: 0.875rem;
            color: #9ca3af;
        }

        .key-empty {
            visibility: hidden;
        }

        .step-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 0.5rem;
        }

        .step-nuevo {
            color: #60a5fa;
        }

        .step-confirmar {
            color: #fbbf24;
        }

        .error-msg {
            font-size: 0.75rem;
            color: #ef4444;
            margin-bottom: 0.75rem;
            min-height: 1rem;
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
            opacity: 0.4;
            transition: opacity 0.15s;
        }

        .btn.listo {
            opacity: 1;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="bg-glow"></div>
    <div class="card">
        @php $settings = \App\Models\Setting::first(); @endphp
        <div class="logo">{{ $settings?->site_name ?? 'RICOX' }}</div>
        <div class="titulo">Nuevo PIN</div>
        <div class="sub">Ingresa y confirma tu nuevo PIN de 6 dígitos.</div>

        <div id="step1">
            <div class="step-label step-nuevo">Nuevo PIN</div>
            <div class="pin-dots" id="dots1">
                @for ($i = 0; $i < 6; $i++)
                    <div class="pin-dot" id="d1-{{ $i }}"></div>
                @endfor
            </div>
        </div>

        <div id="step2" style="display:none;">
            <div class="step-label step-confirmar">Confirmar PIN</div>
            <div class="pin-dots" id="dots2">
                @for ($i = 0; $i < 6; $i++)
                    <div class="pin-dot" id="d2-{{ $i }}"></div>
                @endfor
            </div>
        </div>

        <div class="error-msg" id="errMsg"></div>

        <form method="POST" action="{{ route('pin.reset', $token) }}" id="resetForm">
            @csrf
            <input type="hidden" name="pin" id="pinInput">
            <input type="hidden" name="pin_confirmation" id="pinConfInput">
        </form>

        <div class="keypad">
            @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $n)
                <button class="key" onclick="presionar({{ $n }})">{{ $n }}</button>
            @endforeach
            <button class="key key-empty" disabled></button>
            <button class="key" onclick="presionar(0)">0</button>
            <button class="key key-del" onclick="borrar()">⌫</button>
        </div>

        <button class="btn" id="btnGuardar" onclick="guardar()" disabled>Guardar PIN</button>
    </div>

    <script>
        let paso = 1,
            pin1 = [],
            pin2 = [];
        const MAX = 6;

        function presionar(n) {
            if (paso === 1) {
                if (pin1.length >= MAX) return;
                pin1.push(n);
                actualizarDots(pin1, 'd1-');
                if (pin1.length === MAX) {
                    setTimeout(() => {
                        paso = 2;
                        document.getElementById('step2').style.display = 'block';
                    }, 200);
                }
            } else {
                if (pin2.length >= MAX) return;
                pin2.push(n);
                actualizarDots(pin2, 'd2-');
                if (pin2.length === MAX) verificar();
            }
        }

        function borrar() {
            if (paso === 1) {
                pin1.pop();
                actualizarDots(pin1, 'd1-');
            } else {
                pin2.pop();
                actualizarDots(pin2, 'd2-');
            }
        }

        function actualizarDots(arr, prefix) {
            for (let i = 0; i < MAX; i++) {
                document.getElementById(prefix + i).classList.toggle('filled', i < arr.length);
            }
        }

        function verificar() {
            if (pin1.join('') !== pin2.join('')) {
                document.getElementById('errMsg').textContent = 'Los PINs no coinciden. Intenta de nuevo.';
                pin2 = [];
                actualizarDots(pin2, 'd2-');
                return;
            }
            document.getElementById('errMsg').textContent = '';
            document.getElementById('pinInput').value = pin1.join('');
            document.getElementById('pinConfInput').value = pin2.join('');
            const btn = document.getElementById('btnGuardar');
            btn.disabled = false;
            btn.classList.add('listo');
        }

        function guardar() {
            document.getElementById('resetForm').submit();
        }

        document.addEventListener('keydown', function(e) {
            if (e.key >= '0' && e.key <= '9') presionar(parseInt(e.key));
            if (e.key === 'Backspace') borrar();
        });
    </script>
</body>

</html>

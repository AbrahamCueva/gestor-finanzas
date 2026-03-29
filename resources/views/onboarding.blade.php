<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido — RICOX</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            width: 700px;
            height: 700px;
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
            max-width: 520px;
            padding: 1.5rem;
        }

        /* Header */
        .ob-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .ob-logo {
            font-size: 1.5rem;
            font-weight: 900;
            color: #fbbf24;
            margin-bottom: 0.25rem;
        }

        .ob-logo-sub {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Steps */
        .ob-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 2rem;
        }

        .ob-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.375rem;
        }

        .ob-step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            border: 2px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: #6b7280;
            transition: all 0.3s;
        }

        .ob-step.activo .ob-step-circle {
            background: #fbbf24;
            border-color: #fbbf24;
            color: #0f172a;
        }

        .ob-step.completado .ob-step-circle {
            background: rgba(34, 197, 94, 0.2);
            border-color: #22c55e;
            color: #22c55e;
        }

        .ob-step-label {
            font-size: 0.6rem;
            color: #6b7280;
            text-align: center;
            max-width: 60px;
        }

        .ob-step.activo .ob-step-label {
            color: #fbbf24;
        }

        .ob-step.completado .ob-step-label {
            color: #22c55e;
        }

        .ob-step-line {
            flex: 1;
            height: 2px;
            background: rgba(255, 255, 255, 0.08);
            margin: 0 0.5rem;
            margin-bottom: 1.25rem;
            transition: background 0.3s;
        }

        .ob-step-line.completado {
            background: #22c55e;
        }

        /* Card */
        .ob-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            padding: 2rem;
        }

        .ob-card-titulo {
            font-size: 1.25rem;
            font-weight: 800;
            color: #f9fafb;
            margin-bottom: 0.5rem;
        }

        .ob-card-sub {
            font-size: 0.825rem;
            color: #6b7280;
            margin-bottom: 1.75rem;
            line-height: 1.5;
        }

        /* Fields */
        .ob-field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            margin-bottom: 1rem;
        }

        .ob-label {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
        }

        .ob-input,
        .ob-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.625rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            color: #f9fafb;
            outline: none;
            transition: border-color 0.15s;
            width: 100%;
        }

        .ob-input:focus,
        .ob-select:focus {
            border-color: #fbbf24;
        }

        .ob-select option {
            background: #1f2937;
        }

        .ob-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        /* Categorías */
        .ob-cats-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .ob-cat-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto auto;
            gap: 0.5rem;
            align-items: center;
        }

        .ob-cat-emoji-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            color: #f9fafb;
        }

        .ob-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.4rem 0.875rem;
            border-radius: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.775rem;
            color: #9ca3af;
            cursor: pointer;
            transition: all 0.15s;
        }

        .ob-add-btn:hover {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
            border-color: rgba(251, 191, 36, 0.2);
        }

        .ob-del-btn {
            width: 28px;
            height: 28px;
            border-radius: 0.375rem;
            background: rgba(239, 68, 68, 0.1);
            border: none;
            color: #ef4444;
            cursor: pointer;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Presupuestos */
        .ob-pres-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .ob-pres-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 0.5rem;
            align-items: center;
        }

        /* Bienvenida */
        .ob-bienvenida {
            text-align: center;
            padding: 1rem 0;
        }

        .ob-bienvenida-icon {
            font-size: 3.5rem;
            margin-bottom: 1.25rem;
        }

        .ob-features {
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
            margin: 1.5rem 0;
        }

        .ob-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 0.625rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.825rem;
            color: #e5e7eb;
        }

        .ob-feature-icon {
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* Botones */
        .ob-btns {
            display: flex;
            gap: 0.625rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        .ob-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.625rem 1.5rem;
            border-radius: 0.625rem;
            background: #fbbf24;
            color: #0f172a;
            font-size: 0.875rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .ob-btn-primary:hover {
            opacity: 0.85;
        }

        .ob-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.625rem 1rem;
            border-radius: 0.625rem;
            background: rgba(255, 255, 255, 0.05);
            color: #6b7280;
            font-size: 0.825rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.08);
            cursor: pointer;
        }

        .ob-btn-secondary:hover {
            color: #9ca3af;
        }

        .ob-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 0.625rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.775rem;
            color: #ef4444;
            margin-bottom: 1rem;
            display: none;
        }

        /* Éxito */
        .ob-success {
            text-align: center;
            padding: 1.5rem 0;
        }

        .ob-success-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-10px)
            }
        }

        /* Saltar */
        .ob-saltar {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.72rem;
            color: #374151;
        }

        .ob-saltar a {
            color: #6b7280;
            text-decoration: none;
        }

        .ob-saltar a:hover {
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
                opacity: 0.3;
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

    @php
        $settings = \App\Models\Setting::first();
        $user = auth()->user();
    @endphp

    <div class="bg-glow"></div>
    <div class="particles">
        @for ($i = 0; $i < 12; $i++)
            <div class="particle"
                style="left:{{ rand(0, 100) }}%; --dur:{{ rand(6, 14) }}s; --delay:{{ rand(0, 8) }}s;"></div>
        @endfor
    </div>

    <div class="wrap">

        <div class="ob-header">
            <div class="ob-logo">{{ $settings?->site_name ?? 'RICOX' }}</div>
            <div class="ob-logo-sub">Gestor de Finanzas Personales</div>
        </div>

        <div class="ob-steps" id="stepsBar">
            <div class="ob-step activo" id="step-ind-0">
                <div class="ob-step-circle">1</div>
                <div class="ob-step-label">Bienvenida</div>
            </div>
            <div class="ob-step-line" id="line-0"></div>
            <div class="ob-step" id="step-ind-1">
                <div class="ob-step-circle">2</div>
                <div class="ob-step-label">Cuenta</div>
            </div>
            <div class="ob-step-line" id="line-1"></div>
            <div class="ob-step" id="step-ind-2">
                <div class="ob-step-circle">3</div>
                <div class="ob-step-label">Categorías</div>
            </div>
            <div class="ob-step-line" id="line-2"></div>
            <div class="ob-step" id="step-ind-3">
                <div class="ob-step-circle">4</div>
                <div class="ob-step-label">Presupuesto</div>
            </div>
        </div>

        <div class="ob-card" id="obCard">
            <div id="paso-0">
                <div class="ob-bienvenida">
                    <div class="ob-bienvenida-icon">👋</div>
                    <div class="ob-card-titulo">¡Bienvenido, {{ $user->name }}!</div>
                    <div class="ob-card-sub">
                        Vamos a configurar tu cuenta en 3 pasos rápidos para que puedas empezar a gestionar tus
                        finanzas.
                    </div>
                    <div class="ob-features">
                        <div class="ob-feature"><span class="ob-feature-icon">🏦</span> Registra tus cuentas bancarias y
                            monederos</div>
                        <div class="ob-feature"><span class="ob-feature-icon">🏷️</span> Organiza tus gastos con
                            categorías</div>
                        <div class="ob-feature"><span class="ob-feature-icon">🎯</span> Controla tus gastos con
                            presupuestos</div>
                        <div class="ob-feature"><span class="ob-feature-icon">📊</span> Visualiza tus finanzas en el
                            dashboard</div>
                    </div>
                </div>
                <div class="ob-btns">
                    <button class="ob-btn-primary" onclick="irPaso(1)">
                        Empezar
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            style="width:15px;height:15px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>
            <div id="paso-1" style="display:none;">
                <div class="ob-card-titulo">🏦 Tu primera cuenta</div>
                <div class="ob-card-sub">Agrega la cuenta principal donde recibes o guardas tu dinero.</div>

                <div id="errorCuenta" class="ob-error"></div>

                <div class="ob-field">
                    <label class="ob-label">Nombre de la cuenta</label>
                    <input class="ob-input" id="cta_nombre" placeholder="ej: Cuenta BCP, Efectivo, Yape..."
                        type="text">
                </div>
                <div class="ob-grid-2">
                    <div class="ob-field">
                        <label class="ob-label">Tipo de cuenta</label>
                        <select class="ob-select" id="cta_tipo">
                            <option value="banco">Banco</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="billetera_digital">Billetera digital</option>
                            <option value="tarjeta_credito">Tarjeta de crédito</option>
                            <option value="inversion">Inversión</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="ob-field">
                        <label class="ob-label">Moneda</label>
                        <select class="ob-select" id="cta_moneda">
                            <option value="PEN">S/ Sol peruano</option>
                            <option value="USD">$ Dólar</option>
                            <option value="EUR">€ Euro</option>
                        </select>
                    </div>
                </div>
                <div class="ob-field">
                    <label class="ob-label">Saldo inicial</label>
                    <input class="ob-input" id="cta_saldo" placeholder="0.00" type="number" min="0"
                        step="0.01" value="0">
                </div>

                <div class="ob-btns">
                    <button class="ob-btn-secondary" onclick="irPaso(0)">← Atrás</button>
                    <button class="ob-btn-primary" onclick="guardarCuenta()">
                        Continuar
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            style="width:15px;height:15px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="paso-2" style="display:none;">
                <div class="ob-card-titulo">🏷️ Categorías de gastos</div>
                <div class="ob-card-sub">Crea las categorías para clasificar tus movimientos. Puedes agregar más
                    después.</div>

                <div id="errorCategoria" class="ob-error"></div>

                <div class="ob-cats-list" id="catsList">
                </div>

                <button class="ob-add-btn" onclick="agregarCategoria()">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Agregar categoría
                </button>

                <div class="ob-btns" style="margin-top:1.25rem;">
                    <button class="ob-btn-secondary" onclick="irPaso(1)">← Atrás</button>
                    <button class="ob-btn-primary" onclick="guardarCategorias()">
                        Continuar
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            style="width:15px;height:15px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="paso-3" style="display:none;">
                <div class="ob-card-titulo">🎯 Presupuestos mensuales</div>
                <div class="ob-card-sub">Asigna un límite de gasto mensual a tus categorías de egreso. Es opcional.
                </div>

                <div id="errorPresupuesto" class="ob-error"></div>

                <div class="ob-pres-list" id="presList">
                </div>

                <button class="ob-add-btn" onclick="agregarPresupuesto()">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Agregar presupuesto
                </button>

                <div class="ob-btns" style="margin-top:1.25rem;">
                    <button class="ob-btn-secondary" onclick="irPaso(2)">← Atrás</button>
                    <button class="ob-btn-primary" onclick="guardarPresupuestos()">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            style="width:15px;height:15px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Finalizar
                    </button>
                </div>
            </div>

            <div id="paso-4" style="display:none;">
                <div class="ob-success">
                    <div class="ob-success-icon">🎉</div>
                    <div class="ob-card-titulo">¡Todo listo!</div>
                    <div class="ob-card-sub" style="margin-bottom:1.5rem;">
                        Tu cuenta está configurada. Ahora puedes empezar a registrar tus finanzas.
                    </div>
                    <button class="ob-btn-primary" onclick="window.location.href='/admin'" style="margin:0 auto;">
                        Ir al Dashboard →
                    </button>
                </div>
            </div>

        </div>

        <div class="ob-saltar" id="saltarLink">
            <a href="#" onclick="saltar()">Configurar después →</a>
        </div>

    </div>

    <script>
        let pasoActual = 0;
        let categoriasGuardadas = [];
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // Categorías por defecto
        const catsSugeridas = [{
                nombre: 'Alimentación',
                tipo: 'egreso',
                icono: '🍔',
                color: '#f97316'
            },
            {
                nombre: 'Transporte',
                tipo: 'egreso',
                icono: '🚌',
                color: '#60a5fa'
            },
            {
                nombre: 'Salario',
                tipo: 'ingreso',
                icono: '💼',
                color: '#22c55e'
            },
        ];

        function irPaso(paso) {
            document.getElementById('paso-' + pasoActual).style.display = 'none';
            document.getElementById('paso-' + paso).style.display = 'block';

            // Actualizar steps
            for (let i = 0; i < 4; i++) {
                const ind = document.getElementById('step-ind-' + i);
                ind.classList.remove('activo', 'completado');
                if (i < paso) ind.classList.add('completado');
                if (i === paso) ind.classList.add('activo');
            }
            for (let i = 0; i < 3; i++) {
                const line = document.getElementById('line-' + i);
                line.classList.toggle('completado', i < paso);
            }

            // Circles check
            document.querySelectorAll('.ob-step.completado .ob-step-circle').forEach(c => {
                c.textContent = '✓';
            });
            document.querySelectorAll('.ob-step:not(.completado) .ob-step-circle').forEach((c, i) => {
                c.textContent = i + 1;
            });

            pasoActual = paso;

            // Ocultar saltar en paso 4
            document.getElementById('saltarLink').style.display = paso === 4 ? 'none' : 'block';

            // Inicializar listas
            if (paso === 2 && document.getElementById('catsList').children.length === 0) {
                catsSugeridas.forEach(c => agregarCategoria(c));
            }
            if (paso === 3) {
                renderizarPresupuestos();
            }
        }

        // =====================
        // PASO 1 — CUENTA
        // =====================
        async function guardarCuenta() {
            const nombre = document.getElementById('cta_nombre').value.trim();
            const tipo = document.getElementById('cta_tipo').value;
            const moneda = document.getElementById('cta_moneda').value;
            const saldo = document.getElementById('cta_saldo').value;
            const err = document.getElementById('errorCuenta');

            if (!nombre) {
                mostrarError(err, 'El nombre es requerido.');
                return;
            }

            const res = await post('{{ route('onboarding.cuenta') }}', {
                nombre,
                tipo_cuenta: tipo,
                saldo_inicial: saldo,
                moneda
            });

            if (res.ok) {
                err.style.display = 'none';
                irPaso(2);
            } else mostrarError(err, res.message ?? 'Error al guardar.');
        }

        // =====================
        // PASO 2 — CATEGORÍAS
        // =====================
        let catId = 0;

        function agregarCategoria(data = {}) {
            const id = catId++;
            const row = document.createElement('div');
            row.className = 'ob-cat-row';
            row.id = 'cat-row-' + id;
            row.innerHTML = `
            <input class="ob-input" placeholder="Nombre" value="${data.nombre ?? ''}" id="cat-nombre-${id}">
            <select class="ob-select" id="cat-tipo-${id}">
                <option value="egreso"  ${(data.tipo ?? 'egreso') === 'egreso'  ? 'selected' : ''}>Egreso</option>
                <option value="ingreso" ${(data.tipo ?? '') === 'ingreso' ? 'selected' : ''}>Ingreso</option>
            </select>
            <input class="ob-input" placeholder="🏷️" value="${data.icono ?? ''}" id="cat-icono-${id}" style="width:52px; text-align:center;">
            <button class="ob-del-btn" onclick="eliminarCategoria(${id})">✕</button>
        `;
            document.getElementById('catsList').appendChild(row);
        }

        function eliminarCategoria(id) {
            document.getElementById('cat-row-' + id)?.remove();
        }

        async function guardarCategorias() {
            const rows = document.querySelectorAll('[id^="cat-row-"]');
            const err = document.getElementById('errorCategoria');
            const cats = [];

            rows.forEach(row => {
                const id = row.id.replace('cat-row-', '');
                const nombre = document.getElementById('cat-nombre-' + id)?.value.trim();
                const tipo = document.getElementById('cat-tipo-' + id)?.value;
                const icono = document.getElementById('cat-icono-' + id)?.value.trim() || '📦';
                if (nombre) cats.push({
                    nombre,
                    tipo,
                    icono,
                    color: '#6b7280'
                });
            });

            if (cats.length === 0) {
                mostrarError(err, 'Agrega al menos una categoría.');
                return;
            }

            const res = await post('{{ route('onboarding.categoria') }}', {
                categorias: cats
            });

            if (res.ok) {
                err.style.display = 'none';
                // Guardar para el paso de presupuestos
                const presRes = await fetch('/onboarding/categorias-egreso');
                categoriasGuardadas = res.categorias ?? cats.filter(c => c.tipo === 'egreso');
                irPaso(3);
            } else mostrarError(err, res.message ?? 'Error al guardar.');
        }

        // =====================
        // PASO 3 — PRESUPUESTOS
        // =====================
        let presId = 0;

        function renderizarPresupuestos() {
            const list = document.getElementById('presList');
            if (list.children.length === 0) agregarPresupuesto();
        }

        function agregarPresupuesto() {
            const id = presId++;
            const row = document.createElement('div');
            row.className = 'ob-pres-row';
            row.id = 'pres-row-' + id;

            // Opciones de categorías de egreso
            const opts = categoriasGuardadas.length > 0 ?
                categoriasGuardadas.map(c => `<option value="${c.id ?? ''}">${c.nombre}</option>`).join('') :
                '<option value="">Cargando...</option>';

            row.innerHTML = `
            <select class="ob-select" id="pres-cat-${id}">${opts}</select>
            <input class="ob-input" type="number" placeholder="Límite S/" id="pres-monto-${id}" min="1" step="10">
            <button class="ob-del-btn" onclick="eliminarPresupuesto(${id})">✕</button>
        `;
            document.getElementById('presList').appendChild(row);
        }

        function eliminarPresupuesto(id) {
            document.getElementById('pres-row-' + id)?.remove();
        }

        async function guardarPresupuestos() {
            const rows = document.querySelectorAll('[id^="pres-row-"]');
            const err = document.getElementById('errorPresupuesto');
            const pres = [];

            rows.forEach(row => {
                const id = row.id.replace('pres-row-', '');
                const catId = document.getElementById('pres-cat-' + id)?.value;
                const monto = document.getElementById('pres-monto-' + id)?.value;
                if (catId && monto && parseFloat(monto) > 0) {
                    pres.push({
                        categoria_id: catId,
                        monto_limite: monto
                    });
                }
            });

            // Presupuestos son opcionales
            const res = await post('{{ route('onboarding.presupuesto') }}', {
                presupuestos: pres
            });

            if (res.ok) {
                err.style.display = 'none';
                irPaso(4);
                setTimeout(() => window.location.href = res.redirect ?? '/admin', 2500);
            } else mostrarError(err, res.message ?? 'Error al guardar.');
        }

        // =====================
        // SALTAR
        // =====================
        async function saltar() {
            await post('{{ route('onboarding.saltar') }}', {});
            window.location.href = '/admin';
        }

        // =====================
        // HELPERS
        // =====================
        function mostrarError(el, msg) {
            el.textContent = msg;
            el.style.display = 'block';
        }

        async function post(url, data) {
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data),
                });
                return await res.json();
            } catch (e) {
                return {
                    ok: false,
                    message: 'Error de conexión.'
                };
            }
        }
    </script>
</body>

</html>

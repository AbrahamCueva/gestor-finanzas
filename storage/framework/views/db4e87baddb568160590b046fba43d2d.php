<?php
    $settings = \App\Models\Setting::first();
    $siteName  = $settings?->site_name ?? config('app.name', 'Laravel');
    $logoDark  = $settings?->logo_dark  ? asset('storage/' . $settings->logo_dark)  : null;
    $logoLight = $settings?->logo_light ? asset('storage/' . $settings->logo_light) : null;
    $favicon   = $settings?->favicon    ? asset('storage/' . $settings->favicon)    : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($siteName); ?></title>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($favicon): ?>
        <link rel="icon" type="image/png" href="<?php echo e($favicon); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #0f0f0f;
            color: #e5e5e5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Fondo animado */
        .bg-glow {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 40%, rgba(251, 191, 36, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 70%, rgba(234, 179, 8, 0.04) 0%, transparent 60%),
                #0f0f0f;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        /* Logo / nombre */
        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .brand img {
            height: 56px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #fff;
        }

        .brand-sub {
            font-size: 0.875rem;
            color: #6b7280;
            text-align: center;
            line-height: 1.6;
            max-width: 300px;
        }

        /* Card */
        .card {
            width: 100%;
            background: #161616;
            border: 1px solid #262626;
            border-radius: 1.25rem;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 0.25rem;
        }

        /* Botón primario */
        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: #fbbf24;
            color: #0f0f0f;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-primary:hover {
            background: #f59e0b;
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Botón secundario */
        .btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: transparent;
            color: #9ca3af;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid #262626;
            border-radius: 0.75rem;
            text-decoration: none;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
        }

        .btn-secondary:hover {
            border-color: #404040;
            color: #d1d5db;
        }

        /* Divisor */
        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #374151;
            font-size: 0.75rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #1f1f1f;
        }

        /* Features */
        .features {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .feature {
            background: #161616;
            border: 1px solid #1f1f1f;
            border-radius: 0.875rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .feature-icon {
            font-size: 1.25rem;
            width: 2rem;
            height: 2rem;
            background: #1f1f1f;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-icon svg {
            width: 1rem;
            height: 1rem;
            color: #fbbf24;
            stroke: #fbbf24;
        }

        .feature-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: #d1d5db;
        }

        .feature-desc {
            font-size: 0.72rem;
            color: #6b7280;
            line-height: 1.4;
        }

        /* Footer */
        .footer {
            font-size: 0.75rem;
            color: #374151;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <div class="container">
        <div class="brand">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logoLight): ?>
                <img src="<?php echo e($logoLight); ?>" alt="<?php echo e($siteName); ?>">
            <?php else: ?>
                <span class="brand-name"><?php echo e($siteName); ?></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <p class="brand-sub">Tu gestor de finanzas personales. Controla tus ingresos, gastos y presupuestos.</p>
        </div>

        <div class="card">
            <p class="card-title">Acceder a tu cuenta</p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/admin')); ?>" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1rem;height:1rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Ir al panel
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('filament.admin.auth.login')); ?>" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1rem;height:1rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Iniciar sesión
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="features">
            <div class="feature">
                <div class="feature-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75" />
                    </svg>
                </div>
                <p class="feature-title">Cuentas</p>
                <p class="feature-desc">Banco, efectivo y billeteras digitales</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <p class="feature-title">Movimientos</p>
                <p class="feature-desc">Ingresos y egresos por categoría</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                </div>
                <p class="feature-title">Transferencias</p>
                <p class="feature-desc">Mueve fondos entre cuentas</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                </div>
                <p class="feature-title">Presupuestos</p>
                <p class="feature-desc">Límites y alertas por categoría</p>
            </div>
        </div>

        <p class="footer"><?php echo e($siteName); ?> · Finanzas personales</p>

    </div>
</body>
</html>
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/welcome.blade.php ENDPATH**/ ?>
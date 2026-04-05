<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación 2FA — RICOX</title>
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

        .icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .titulo {
            font-size: 1rem;
            font-weight: 800;
            color: #f9fafb;
            margin-bottom: 0.375rem;
        }

        .subtitulo {
            font-size: 0.775rem;
            color: #6b7280;
            margin-bottom: 1.75rem;
            line-height: 1.5;
        }

        .input-code {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 2rem;
            font-weight: 700;
            color: #f9fafb;
            outline: none;
            text-align: center;
            letter-spacing: 0.25em;
            transition: border-color 0.15s;
            margin-bottom: 0.75rem;
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
            margin-bottom: 1rem;
        }

        .btn-primary:hover {
            opacity: 0.85;
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

        .hint {
            font-size: 0.7rem;
            color: #4b5563;
            line-height: 1.5;
        }

        .hint strong {
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="bg-glow"></div>

    <div class="card <?php echo e(session('shake') ? 'shake' : ''); ?>">
        <?php $settings = \App\Models\Setting::first(); ?>
        <div class="logo"><?php echo e($settings?->site_name ?? 'RICOX'); ?></div>
        <div class="logo-sub">Autenticación de dos factores</div>

        <div class="icon">🔐</div>
        <div class="titulo">Verificación 2FA</div>
        <div class="subtitulo">
            Abre <strong>Google Authenticator</strong> o <strong>Authy</strong> e ingresa el código de 6 dígitos de
            <strong><?php echo e(config('app.name', 'RICOX')); ?></strong>.
        </div>

        <form method="POST" action="<?php echo e(route('2fa.verificar.post')); ?>">
            <?php echo csrf_field(); ?>
            <input type="text" name="code" class="input-code" placeholder="000000" maxlength="6"
                autocomplete="one-time-code" inputmode="numeric" autofocus>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-msg"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <button type="submit" class="btn-primary">Verificar y entrar</button>
        </form>

        <div class="hint">
            El código cambia cada <strong>30 segundos</strong>.<br>
            Si tienes problemas, contacta al administrador.
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/2fa/verificar.blade.php ENDPATH**/ ?>
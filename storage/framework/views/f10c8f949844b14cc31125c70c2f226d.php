<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php
        $checks = $this->getChecks();
        $info = $this->getInfo();
        $totalOk = collect($checks)->where('estado', 'ok')->count();
        $totalWarning = collect($checks)->where('estado', 'warning')->count();
        $totalError = collect($checks)->where('estado', 'error')->count();
    ?>

    <style>
        :root {
            --w-bg: rgba(0, 0, 0, 0.04);
            --w-card: rgba(0, 0, 0, 0.05);
            --w-text: #111827;
            --w-text-soft: #374151;
            --w-muted: #6b7280;
            --w-border: rgba(0, 0, 0, 0.08);
        }

        .dark {
            --w-bg: rgba(255, 255, 255, 0.03);
            --w-card: rgba(255, 255, 255, 0.04);
            --w-text: #f9fafb;
            --w-text-soft: #e5e7eb;
            --w-muted: #6b7280;
            --w-border: rgba(255, 255, 255, 0.08);
        }

        .hc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .hc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .hc-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* Estado general */
        .hc-estado-wrap {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .hc-estado-badge {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            border: 3px solid;
            flex-shrink: 0;
        }

        .hc-estado-info {
            flex: 1;
        }

        .hc-estado-nombre {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .hc-estado-sub {
            font-size: 0.75rem;
            color: var(--w-muted);
            margin-top: 0.2rem;
        }

        .hc-counters {
            display: flex;
            gap: 0.75rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }

        .hc-counter {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.8rem;
        }

        .hc-counter-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Grid checks */
        .hc-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        @media(max-width:768px) {
            .hc-grid {
                grid-template-columns: 1fr;
            }
        }

        .hc-check-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            border: 1.5px solid transparent;
        }

        .hc-check-card.ok {
            border-color: rgba(34, 197, 94, 0.2);
        }

        .hc-check-card.warning {
            border-color: rgba(251, 191, 36, 0.2);
        }

        .hc-check-card.error {
            border-color: rgba(239, 68, 68, 0.2);
        }

        .hc-check-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .hc-check-icon.ok {
            background: rgba(34, 197, 94, 0.15);
        }

        .hc-check-icon.warning {
            background: rgba(251, 191, 36, 0.15);
        }

        .hc-check-icon.error {
            background: rgba(239, 68, 68, 0.15);
        }

        .hc-check-nombre {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .hc-check-mensaje {
            font-size: 0.72rem;
            margin-top: 0.1rem;
        }

        .hc-check-detalle {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-top: 0.25rem;
            font-style: italic;
        }

        /* Info sistema */
        .hc-info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
        }

        @media(max-width:768px) {
            .hc-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .hc-info-item {
            background: var(--w-card);
            border-radius: 0.625rem;
            padding: 0.625rem 0.75rem;
        }

        .hc-info-label {
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .hc-info-value {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .hc-refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            background: var(--w-card);
            color: var(--w-muted);
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }

        .hc-refresh-btn:hover {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }
    </style>

    <div class="hc-wrap">

        <div class="hc-card">
            <?php
                if ($totalError > 0) {
                    $estadoColor = '#ef4444';
                    $estadoEmoji = '🔴';
                    $estadoNombre = 'Sistema con errores';
                    $estadoSub = "{$totalError} verificación(es) fallida(s)";
                } elseif ($totalWarning > 0) {
                    $estadoColor = '#fbbf24';
                    $estadoEmoji = '🟡';
                    $estadoNombre = 'Sistema con advertencias';
                    $estadoSub = "{$totalWarning} advertencia(s) detectada(s)";
                } else {
                    $estadoColor = '#22c55e';
                    $estadoEmoji = '🟢';
                    $estadoNombre = 'Sistema saludable';
                    $estadoSub = 'Todas las verificaciones pasaron correctamente';
                }
            ?>

            <div class="hc-estado-wrap">
                <div class="hc-estado-badge" style="border-color:<?php echo e($estadoColor); ?>; background:<?php echo e($estadoColor); ?>18;">
                    <?php echo e($estadoEmoji); ?>

                </div>
                <div class="hc-estado-info">
                    <div class="hc-estado-nombre" style="color:<?php echo e($estadoColor); ?>;"><?php echo e($estadoNombre); ?></div>
                    <div class="hc-estado-sub"><?php echo e($estadoSub); ?></div>
                    <div class="hc-counters">
                        <div class="hc-counter">
                            <div class="hc-counter-dot" style="background:#22c55e;"></div>
                            <span style="color:#22c55e; font-weight:700;"><?php echo e($totalOk); ?></span>
                            <span style="color:var(--w-muted);">OK</span>
                        </div>
                        <div class="hc-counter">
                            <div class="hc-counter-dot" style="background:#fbbf24;"></div>
                            <span style="color:#fbbf24; font-weight:700;"><?php echo e($totalWarning); ?></span>
                            <span style="color:var(--w-muted);">Advertencias</span>
                        </div>
                        <div class="hc-counter">
                            <div class="hc-counter-dot" style="background:#ef4444;"></div>
                            <span style="color:#ef4444; font-weight:700;"><?php echo e($totalError); ?></span>
                            <span style="color:var(--w-muted);">Errores</span>
                        </div>
                    </div>
                </div>

                <button class="hc-refresh-btn" onclick="window.location.reload()">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Actualizar
                </button>
            </div>
        </div>

        <div class="hc-card">
            <div class="hc-title">🔍 Verificaciones</div>
            <div class="hc-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $checks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nombre => $check): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $iconoMap = [
                            'ok' => '✅',
                            'warning' => '⚠️',
                            'error' => '❌',
                        ];
                        $colorMsg = match ($check['estado']) {
                            'ok' => '#22c55e',
                            'warning' => '#fbbf24',
                            default => '#ef4444',
                        };
                    ?>
                    <div class="hc-check-card <?php echo e($check['estado']); ?>">
                        <div class="hc-check-icon <?php echo e($check['estado']); ?>">
                            <?php echo e($iconoMap[$check['estado']]); ?>

                        </div>
                        <div style="flex:1;">
                            <div class="hc-check-nombre"><?php echo e($nombre); ?></div>
                            <div class="hc-check-mensaje" style="color:<?php echo e($colorMsg); ?>;">
                                <?php echo e($check['mensaje']); ?>

                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($check['detalle']): ?>
                                <div class="hc-check-detalle"><?php echo e($check['detalle']); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <div class="hc-card">
            <div class="hc-title">💻 Información del sistema</div>
            <div class="hc-info-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [['Laravel', $info['laravel']], ['PHP', $info['php']], ['Ambiente', $info['ambiente']], ['Debug', $info['debug']], ['Timezone', $info['timezone']], ['Base datos', $info['bd_driver']], ['Caché', $info['cache']], ['Uptime', $info['uptime']]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $valor]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="hc-info-item">
                        <div class="hc-info-label"><?php echo e($label); ?></div>
                        <div class="hc-info-value"><?php echo e($valor); ?></div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <div class="hc-card">
            <div class="hc-title">🛠️ Comandos útiles</div>
            <div style="display:flex; flex-direction:column; gap:0.5rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [['php artisan ricox:tipos-cambio', 'Actualizar tipos de cambio'], ['php artisan ricox:notificaciones', 'Verificar notificaciones inteligentes'], ['php artisan ricox:limpiar-logs --force', 'Limpiar logs antiguos'], ['php artisan schedule:run', 'Ejecutar tareas programadas manualmente'], ['php artisan optimize:clear', 'Limpiar caché de la aplicación'], ['php artisan queue:work', 'Iniciar worker de colas']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$cmd, $desc]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div
                        style="background:var(--w-card); border-radius:0.5rem; padding:0.625rem 0.875rem; display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                        <code
                            style="font-size:0.75rem; color:#fbbf24; font-family:monospace;"><?php echo e($cmd); ?></code>
                        <span style="font-size:0.7rem; color:var(--w-muted);"><?php echo e($desc); ?></span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/health-check.blade.php ENDPATH**/ ?>
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
        $logs = $this->getLogs();
        $resumen = $this->getResumen();
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

        .as-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .as-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .as-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .as-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:768px) {
            .as-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .as-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .as-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .as-kpi-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .as-filtros {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .as-filtro-btn {
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .as-filtro-btn.activo {
            background: #fbbf24;
            color: #0f172a;
        }

        .as-filtro-btn.sospech {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .as-filtro-btn:hover:not(.activo):not(.sospech) {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .as-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .as-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .as-table td {
            padding: 0.5rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
            vertical-align: middle;
        }

        .as-table tr:last-child td {
            border-bottom: none;
        }

        .as-table tr:hover td {
            background: var(--w-card);
        }

        .as-table tr.sospechoso td {
            background: rgba(239, 68, 68, 0.04);
        }

        .as-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .as-badge-ok {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .as-badge-warn {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .as-badge-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .as-badge-info {
            background: rgba(96, 165, 250, 0.12);
            color: #60a5fa;
        }

        .as-badge-gray {
            background: rgba(107, 114, 128, 0.12);
            color: #6b7280;
        }
    </style>

    <div class="as-wrap">

        <div class="as-card">
            <div class="as-kpis">
                <div class="as-kpi">
                    <div class="as-kpi-label">Total eventos</div>
                    <div class="as-kpi-value"><?php echo e($resumen['total']); ?></div>
                </div>
                <div class="as-kpi">
                    <div class="as-kpi-label">Sospechosos</div>
                    <div class="as-kpi-value" style="color:<?php echo e($resumen['sospechosos'] > 0 ? '#ef4444' : '#22c55e'); ?>;">
                        <?php echo e($resumen['sospechosos']); ?>

                    </div>
                </div>
                <div class="as-kpi">
                    <div class="as-kpi-label">Último acceso</div>
                    <div class="as-kpi-value" style="font-size:0.85rem;"><?php echo e($resumen['ultimoLogin']); ?></div>
                </div>
                <div class="as-kpi">
                    <div class="as-kpi-label">IPs únicas</div>
                    <div class="as-kpi-value"><?php echo e($resumen['ipsUnicas']); ?></div>
                </div>
            </div>
        </div>

        <div class="as-card">
            <div class="as-filtros">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
        'todos' => 'Todos',
        'login_exitoso' => 'Logins',
        'login_fallido' => 'Fallidos',
        'cambio_password' => 'Contraseña',
        'cambio_pin' => 'PIN',
        'descarga_backup' => 'Backup',
        'sospechosos' => '⚠ Sospechosos',
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <button
                        class="as-filtro-btn <?php echo e($filtro === $key ? ($key === 'sospechosos' ? 'sospech' : 'activo') : ''); ?>"
                        wire:click="$set('filtro','<?php echo e($key); ?>')">
                        <?php echo e($label); ?>

                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <div style="overflow-x:auto;">
                <table class="as-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Evento</th>
                            <th>IP</th>
                            <th>Navegador</th>
                            <th>Dispositivo</th>
                            <th>Estado</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="<?php echo e($log->sospechoso ? 'sospechoso' : ''); ?>">
                                <td style="white-space:nowrap; color:var(--w-muted); font-size:0.72rem;">
                                    <?php echo e($log->created_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td>
                                    <?php
                                        $eventoInfo = match ($log->evento) {
                                            'login_exitoso' => ['🟢', 'Login exitoso', 'as-badge-ok'],
                                            'login_fallido' => ['🔴', 'Login fallido', 'as-badge-danger'],
                                            'cambio_password' => ['🔑', 'Cambio contraseña', 'as-badge-warn'],
                                            'cambio_pin' => ['🔒', 'Cambio PIN', 'as-badge-warn'],
                                            'descarga_backup' => ['🗄️', 'Backup', 'as-badge-info'],
                                            default => ['📋', $log->evento, 'as-badge-gray'],
                                        };
                                    ?>
                                    <span class="as-badge <?php echo e($eventoInfo[2]); ?>">
                                        <?php echo e($eventoInfo[0]); ?> <?php echo e($eventoInfo[1]); ?>

                                    </span>
                                </td>
                                <td style="font-family:monospace; font-size:0.72rem;"><?php echo e($log->ip ?? '—'); ?></td>
                                <td style="color:var(--w-muted);"><?php echo e($log->navegador ?? '—'); ?></td>
                                <td style="color:var(--w-muted);"><?php echo e($log->dispositivo ?? '—'); ?></td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->sospechoso): ?>
                                        <span class="as-badge as-badge-danger">⚠ Sospechoso</span>
                                    <?php else: ?>
                                        <span class="as-badge as-badge-ok">✓ Normal</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td style="color:var(--w-muted); font-size:0.72rem; max-width:200px;">
                                    <?php echo e($log->detalle ?: '—'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="7" style="text-align:center; color:var(--w-muted); padding:2rem;">
                                    No hay eventos registrados.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/auditoria-seguridad.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

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

        .pr-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .pr-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .pr-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .pr-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        .pr-badges {
            display: flex;
            gap: 0.4rem;
        }

        .pr-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.625rem;
            border-radius: 99px;
            font-size: 0.68rem;
            font-weight: 600;
        }

        .pr-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        @media (max-width: 1280px) {
            .pr-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .pr-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .pr-grid {
                grid-template-columns: 1fr;
            }
        }

        .pr-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            position: relative;
            overflow: hidden;
        }

        .pr-card-accent {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            border-radius: 99px 0 0 99px;
        }

        .pr-card-dot {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pr-card-dot svg {
            width: 14px;
            height: 14px;
        }

        .pr-card-body {
            flex: 1;
            min-width: 0;
        }

        .pr-card-name {
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--w-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pr-card-meta {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 0.15rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .pr-card-sep {
            color: var(--w-border);
        }

        .pr-card-right {
            text-align: right;
            flex-shrink: 0;
        }

        .pr-card-amount {
            font-size: 0.875rem;
            font-weight: 700;
        }

        .pr-card-when {
            font-size: 0.65rem;
            margin-top: 0.15rem;
            font-weight: 600;
            padding: 0.1rem 0.4rem;
            border-radius: 99px;
            display: inline-block;
        }

        .pr-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 0;
            color: var(--w-muted);
            gap: 0.5rem;
            text-align: center;
        }

        .pr-empty svg {
            width: 30px;
            height: 30px;
            margin-bottom: 0.25rem;
        }

        .pr-empty-title {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .pr-empty-sub {
            font-size: 0.75rem;
            opacity: 0.7;
        }
    </style>

    <div class="pr-wrap">

        <div class="pr-header">
            <div>
                <div class="pr-title">Próximos Movimientos</div>
                <div class="pr-sub">Recurrentes en los próximos 7 días</div>
            </div>
            <div class="pr-badges">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hoy > 0): ?>
                    <span class="pr-badge" style="background:rgba(251,191,36,0.15); color:#fbbf24;">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:10px;height:10px;">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                clip-rule="evenodd" />
                        </svg>
                        <?php echo e($hoy); ?> hoy
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total > 0): ?>
                    <span class="pr-badge" style="background:var(--w-card); color:var(--w-muted);">
                        <?php echo e($total); ?> próximos
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($movimientos->isEmpty()): ?>
            <div class="pr-empty">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5m-9-6h.008v.008H12V9.75zm0 3h.008v.008H12v-.008zm0 3h.008v.008H12v-.008zm-3-6h.008v.008H9V9.75zm0 3h.008v.008H9v-.008zm0 3h.008v.008H9v-.008zm-3-6h.008v.008H6V9.75zm0 3h.008v.008H6v-.008zm0 3h.008v.008H6v-.008z" />
                </svg>
                <div class="pr-empty-title">Sin movimientos próximos</div>
                <div class="pr-empty-sub">No hay recurrentes en los próximos 7 días</div>
            </div>
        <?php else: ?>
            <div class="pr-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $movimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $esIngreso = $m['tipo'] === 'ingreso';
                        $color = $esIngreso ? '#22c55e' : '#ef4444';
                        $bgColor = $esIngreso ? 'rgba(34,197,94,0.10)' : 'rgba(239,68,68,0.10)';

                        if ($m['es_hoy']) {
                            $whenLabel = 'Hoy';
                            $whenBg = 'rgba(251,191,36,0.15)';
                            $whenColor = '#fbbf24';
                        } elseif ($m['es_maniana']) {
                            $whenLabel = 'Mañana';
                            $whenBg = 'rgba(96,165,250,0.12)';
                            $whenColor = '#60a5fa';
                        } else {
                            $whenLabel = 'En ' . $m['dias'] . ' días';
                            $whenBg = 'var(--w-border)';
                            $whenColor = 'var(--w-muted)';
                        }
                    ?>
                    <div class="pr-card">
                        <div class="pr-card-accent" style="background:<?php echo e($color); ?>;"></div>

                        <div class="pr-card-dot" style="background:<?php echo e($bgColor); ?>;">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="<?php echo e($color); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($esIngreso): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                <?php else: ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </svg>
                        </div>

                        <div class="pr-card-body">
                            <div class="pr-card-name"><?php echo e($m['nombre']); ?></div>
                            <div class="pr-card-meta">
                                <span><?php echo e($m['cuenta']); ?></span>
                                <span class="pr-card-sep">·</span>
                                <span><?php echo e(ucfirst($m['frecuencia'])); ?></span>
                            </div>
                        </div>

                        <div class="pr-card-right">
                            <div class="pr-card-amount" style="color:<?php echo e($color); ?>;">
                                <?php echo e($esIngreso ? '+' : '-'); ?>S/ <?php echo e(number_format($m['monto'], 2)); ?>

                            </div>
                            <div class="pr-card-when"
                                style="background:<?php echo e($whenBg); ?>; color:<?php echo e($whenColor); ?>;">
                                <?php echo e($whenLabel); ?>

                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/widgets/proximos-recurrentes.blade.php ENDPATH**/ ?>
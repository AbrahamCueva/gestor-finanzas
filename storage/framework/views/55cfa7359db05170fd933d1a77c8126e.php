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

        .mt-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .mt-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .mt-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .mt-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        .mt-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.625rem;
            border-radius: 99px;
            font-size: 0.68rem;
            font-weight: 600;
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .mt-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        @media (max-width: 1024px) {
            .mt-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .mt-grid {
                grid-template-columns: 1fr;
            }
        }

        .mt-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .mt-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .mt-card-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--w-text);
            line-height: 1.2;
        }

        .mt-card-pct {
            font-size: 0.8rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .mt-track {
            height: 4px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .mt-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.7s ease;
        }

        .mt-amounts {
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
            color: var(--w-muted);
        }

        .mt-amount-current {
            font-weight: 700;
            color: var(--w-text-soft);
        }

        .mt-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.68rem;
            color: var(--w-muted);
        }

        .mt-dias {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .mt-dias svg {
            width: 10px;
            height: 10px;
        }

        .mt-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 0;
            color: var(--w-muted);
            gap: 0.5rem;
            text-align: center;
        }

        .mt-empty svg {
            width: 30px;
            height: 30px;
            margin-bottom: 0.25rem;
        }

        .mt-empty-title {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .mt-empty-sub {
            font-size: 0.75rem;
            opacity: 0.7;
        }
    </style>

    <div class="mt-wrap">

        <div class="mt-header">
            <div>
                <div class="mt-title">Metas de Ahorro</div>
                <div class="mt-sub"><?php echo e($completadas); ?> completadas · <?php echo e($total); ?> en progreso</div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total > 0): ?>
                <span class="mt-badge">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:11px;height:11px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.25 9.71 2 12 2c2.291 0 4.545.25 6.75.721v1.515M18.75 4.236c.982.143 1.954.317 2.916.52a6.003 6.003 0 01-5.395 4.972M18.75 4.236V4.5a6.75 6.75 0 01-2.48 5.228" />
                    </svg>
                    <?php echo e($total); ?> activas
                </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($metas->isEmpty()): ?>
            <div class="mt-empty">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.25 9.71 2 12 2c2.291 0 4.545.25 6.75.721v1.515M18.75 4.236c.982.143 1.954.317 2.916.52a6.003 6.003 0 01-5.395 4.972M18.75 4.236V4.5a6.75 6.75 0 01-2.48 5.228" />
                </svg>
                <div class="mt-empty-title">Sin metas activas</div>
                <div class="mt-empty-sub">Crea una meta para comenzar a ahorrar</div>
            </div>
        <?php else: ?>
            <div class="mt-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $metas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
                        $pct = $m->porcentaje();
                        $dias = $m->diasRestantes();
                        $color = $m->color ?? '#fbbf24';
                    ?>
                    <div class="mt-card">

                        <div class="mt-card-top">
                            <div class="mt-card-name"><?php echo e($m->nombre); ?></div>
                            <div class="mt-card-pct" style="color:<?php echo e($color); ?>;"><?php echo e($pct); ?>%</div>
                        </div>

                        <div>
                            <div class="mt-track">
                                <div class="mt-fill"
                                    style="width:<?php echo e($pct); ?>%; background:<?php echo e($color); ?>;"></div>
                            </div>
                        </div>

                        <div class="mt-amounts">
                            <span class="mt-amount-current">S/ <?php echo e(number_format($m->monto_actual, 2)); ?></span>
                            <span>de S/ <?php echo e(number_format($m->monto_objetivo, 2)); ?></span>
                        </div>

                        <div class="mt-footer">
                            <span>Falta S/ <?php echo e(number_format($m->restante(), 2)); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dias !== null): ?>
                                <span class="mt-dias">
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25" />
                                    </svg>
                                    <?php echo e($dias); ?> días
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/widgets/metas-widget.blade.php ENDPATH**/ ?>
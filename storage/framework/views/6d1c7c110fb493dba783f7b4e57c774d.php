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

    <?php
        $s = $this->getScore();
        $nivel = $s['nivel'];
    ?>
    <div
        style="
    background:var(--fi-color-gray-950,#0f172a);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:0.875rem; padding:1rem 1.5rem;
    display:flex; align-items:center; gap:1.5rem; flex-wrap:wrap;
">
        <div style="position:relative; width:64px; height:64px; flex-shrink:0;">
            <svg width="64" height="64" viewBox="0 0 64 64" style="transform:rotate(-90deg);">
                <circle cx="32" cy="32" r="26" fill="none" stroke="rgba(255,255,255,0.08)"
                    stroke-width="5" />
                <circle cx="32" cy="32" r="26" fill="none" stroke="<?php echo e($nivel['color']); ?>"
                    stroke-width="5" stroke-linecap="round" stroke-dasharray="<?php echo e(round(2 * M_PI * 26, 2)); ?>"
                    stroke-dashoffset="<?php echo e(round(2 * M_PI * 26 * (1 - $s['puntaje'] / 100), 2)); ?>" />
            </svg>
            <div
                style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:900; color:<?php echo e($nivel['color']); ?>;">
                <?php echo e($s['puntaje']); ?>

            </div>
        </div>

        <div style="flex:1;">
            <div
                style="font-size:0.68rem; color:#6b7280; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.2rem;">
                Score Financiero</div>
            <div style="font-size:1rem; font-weight:800; color:<?php echo e($nivel['color']); ?>;">
                <?php echo e($nivel['emoji']); ?> <?php echo e($nivel['nombre']); ?>

            </div>
            <div
                style="height:4px; background:rgba(255,255,255,0.08); border-radius:99px; overflow:hidden; margin-top:0.5rem; max-width:200px;">
                <div
                    style="height:100%; width:<?php echo e($s['puntaje']); ?>%; background:<?php echo e($nivel['color']); ?>; border-radius:99px;">
                </div>
            </div>
        </div>

        <a href="<?php echo e(route('filament.admin.pages.score-financiero')); ?>"
            style="padding:0.4rem 1rem; border-radius:0.5rem; background:rgba(255,255,255,0.06); color:#9ca3af; font-size:0.75rem; font-weight:600; text-decoration:none; white-space:nowrap; transition:all 0.15s;"
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='rgba(255,255,255,0.06)'">
            Ver detalle →
        </a>
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/widgets/score-widget.blade.php ENDPATH**/ ?>
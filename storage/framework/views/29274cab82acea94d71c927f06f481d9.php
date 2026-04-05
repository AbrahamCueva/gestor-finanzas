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

    <?php $c = $this->getClima(); ?>

    <div style="
    background:linear-gradient(135deg, rgba(15,23,42,0.8), rgba(30,41,59,0.6));
    border:1px solid rgba(255,255,255,0.06);
    border-radius:0.875rem; padding:0.875rem 1.25rem;
    display:flex; align-items:center; gap:1.5rem; flex-wrap:wrap;
">
        <div style="font-size:2.5rem; flex-shrink:0;"><?php echo e($c['emoji']); ?></div>

        <div style="flex:1;">
            <div style="font-size:0.62rem; color:#6b7280; text-transform:uppercase; letter-spacing:0.08em;">
                📍 <?php echo e($c['ciudad']); ?>

            </div>
            <div style="display:flex; align-items:baseline; gap:0.5rem; margin-top:0.1rem;">
                <span style="font-size:1.75rem; font-weight:900; color:#f9fafb;"><?php echo e($c['temp']); ?>°C</span>
                <span style="font-size:0.75rem; color:#6b7280;">Sensación <?php echo e($c['sensacion']); ?>°C</span>
            </div>
            <div style="font-size:0.75rem; color:#94a3b8;"><?php echo e($c['descripcion']); ?></div>
        </div>

        <div style="display:flex; gap:1rem; flex-wrap:wrap;">
            <div style="text-align:center;">
                <div style="font-size:0.6rem; color:#6b7280; text-transform:uppercase;">Humedad</div>
                <div style="font-size:0.875rem; font-weight:700; color:#60a5fa;"><?php echo e($c['humedad']); ?>%</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:0.6rem; color:#6b7280; text-transform:uppercase;">Viento</div>
                <div style="font-size:0.875rem; font-weight:700; color:#34d399;"><?php echo e($c['viento']); ?> km/h</div>
            </div>
        </div>

        <div style="font-size:0.62rem; color:#4b5563; flex-shrink:0;">
            🔄 Actualiza cada 30 min
        </div>
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
<?php endif; ?><?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/widgets/clima-widget.blade.php ENDPATH**/ ?>
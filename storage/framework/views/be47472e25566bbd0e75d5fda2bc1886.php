<?php $settings = \App\Models\Setting::first(); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings?->vacaciones_activo): ?>
    <div
        style="
    background:linear-gradient(135deg, rgba(251,191,36,0.12), rgba(249,115,22,0.08));
    border-bottom:1px solid rgba(251,191,36,0.2);
    padding:0.625rem 1.5rem;
    display:flex; align-items:center; gap:0.75rem;
    font-size:0.8rem; color:#fbbf24; flex-wrap:wrap;
">
        <span style="font-size:1.1rem;">🏖️</span>
        <span style="font-weight:700;">Modo Vacaciones activo</span>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings->vacaciones_mensaje): ?>
            <span style="color:#d97706;">— <?php echo e($settings->vacaciones_mensaje); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings->vacaciones_fin): ?>
            <span style="color:#6b7280; margin-left:auto; font-size:0.72rem;">
                Regreso: <?php echo e(\Carbon\Carbon::parse($settings->vacaciones_fin)->format('d/m/Y')); ?>

            </span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings->vacaciones_pausar_presupuestos || $settings->vacaciones_pausar_notificaciones): ?>
            <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings->vacaciones_pausar_presupuestos): ?>
                    <span
                        style="background:rgba(251,191,36,0.1); padding:0.1rem 0.5rem; border-radius:99px; font-size:0.65rem; color:#fbbf24;">
                        ⏸ Presupuestos pausados
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings->vacaciones_pausar_recurrentes): ?>
                    <span
                        style="background:rgba(251,191,36,0.1); padding:0.1rem 0.5rem; border-radius:99px; font-size:0.65rem; color:#fbbf24;">
                        ⏸ Recurrentes pausados
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings->vacaciones_pausar_notificaciones): ?>
                    <span
                        style="background:rgba(251,191,36,0.1); padding:0.1rem 0.5rem; border-radius:99px; font-size:0.65rem; color:#fbbf24;">
                        ⏸ Notificaciones pausadas
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/vacaciones-banner.blade.php ENDPATH**/ ?>
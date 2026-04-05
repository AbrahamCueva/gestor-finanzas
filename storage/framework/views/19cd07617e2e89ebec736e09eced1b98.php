<div style="display: flex; align-items: center; gap: 12px; min-width: max-content;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo): ?>
        <img src="<?php echo e($logo); ?>"
             alt="Logo"
             style="height: 36px; width: auto; flex-shrink: 0; object-fit: contain;">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <span style="font-size: 1.25rem; font-weight: 700; letter-spacing: -0.025em; line-height: 1; white-space: nowrap;"
          class="text-gray-950 dark:text-white">
        <?php echo e($name); ?>

    </span>
</div>

<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/clusters/brand-logo.blade.php ENDPATH**/ ?>
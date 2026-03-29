<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'rawTitle',
    'group',
    'isLast',
    'url',
    'result'
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title',
    'rawTitle',
    'group',
    'isLast',
    'url',
    'result'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$classes = [
    // background
    'dark:bg-[--alpha(white_/_3%)] bg-[--alpha(var(--color-gray-900)_/_5%)]',
    
    // Focus within because the focus target a tag and not this LI (for proper accessibility)
    'focus-within:dark:bg-[--alpha(white_/_8%)] focus-within:bg-[--alpha(var(--color-gray-900)_/_8%)]', 
    
    // Hover 
    'hover:bg-[--alpha(var(--color-gray-900)_/_8%)] dark:hover:bg-[--alpha(white_/_10%)]',
    
    ' my-1 py-2 px-3 duration-300 transition-colors rounded-lg flex justify-between items-center'
];

$isAssoc = \Illuminate\Support\Arr::isAssoc($result->details);

?>

<li
    <?php echo e($attributes->class(Arr::toCssClasses($classes))); ?> 
    role="option"
>
    <a 
        <?php echo e(\Filament\Support\generate_href_html($url)); ?>


        x-on:keydown.enter.stop="addToSearchHistory(<?php echo \Illuminate\Support\Js::from($rawTitle)->toHtml() ?>,<?php echo \Illuminate\Support\Js::from($group)->toHtml() ?>,<?php echo \Illuminate\Support\Js::from($url)->toHtml() ?>)"

        x-on:click="$data.close();addToSearchHistory(<?php echo \Illuminate\Support\Js::from($rawTitle)->toHtml() ?>,<?php echo \Illuminate\Support\Js::from($group)->toHtml() ?>,<?php echo \Illuminate\Support\Js::from($url)->toHtml() ?>)"

        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'fi-global-search-result-link block outline-none w-full',
            'pe-4 ps-4 pt-4' => $result->actions,
            'p-3' => !$result->actions,
        ]); ?>"
    >

        <h4 
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'text-sm text-start font-medium text-gray-950 dark:text-white',
            ]); ?>"
        >
            <span>
                <?php echo e(str($title)->sanitizeHtml()->toHtmlString()); ?>

            </span>
        </h4>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($result->details): ?>
            <dl class="mt-1 ml-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $result->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div 
                        class="text-sm text-gray-500 dark:text-gray-400 
                            flex items-center justify-start"
                    >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isAssoc): ?>
                            <dt 
                                class="inline font-medium" 
                                style="margin-right: 3px; padding-right: 1px;"
                            ><?php echo e($label); ?>:
                            </dt>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <dd class="inline"><?php echo e($value); ?></dd>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </dl>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </a>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($resultVisibleActions = $result->getVisibleActions()): ?>
        <div class="fi-global-search-result-actions">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $resultVisibleActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php echo e($action); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</li><?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\vendor\charrafimed\global-search-modal\resources\views/components/search/result-item.blade.php ENDPATH**/ ?>
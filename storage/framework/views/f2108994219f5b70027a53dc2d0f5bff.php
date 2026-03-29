<?php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\IconSize;
    use Filament\Support\View\Components\SectionComponent\IconComponent;
    use function Filament\Support\is_slot_empty;

    $afterHeader = $getChildSchema($schemaComponent::AFTER_HEADER_SCHEMA_KEY)?->toHtmlString();
    $beforeHeader = $getChildSchema($schemaComponent::BEFORE_HEADER_SCHEMA_KEY)?->toHtmlString();
    $headingContent = $getChildSchema($schemaComponent::HEADING_CONTENT_SCHEMA_KEY)?->toHtmlString();
    $isAside = $isAside();
    $isCollapsed = $isCollapsed();
    $isCollapsible = $isCollapsible();
    $isCompact = $isCompact();
    $isContained = $isContained();
    $isDivided = $isDivided();
    $isFormBefore = $isFormBefore();
    $description = $getDescription();
    $footer = $getChildSchema($schemaComponent::FOOTER_SCHEMA_KEY)?->toHtmlString();
    $heading = $getHeading();
    $headingTag = $getHeadingTag();
    $icon = $getIcon();
    $iconColor = $getIconColor();
    $iconSize = $getIconSize();
    $shouldPersistCollapsed = $shouldPersistCollapsed();
    $isSecondary = $isSecondary();
    $id = $getId();

    if (filled($iconSize) && !$iconSize instanceof IconSize) {
        $iconSize = IconSize::tryFrom($iconSize) ?? $iconSize;
    }

    $hasDescription = filled((string) $description);
    $hasHeading = filled($heading) || !is_slot_empty($headingContent);
    $hasIcon = filled($icon);
    $hasHeader =
        $hasIcon ||
        $hasHeading ||
        $hasDescription ||
        $collapsible ||
        !is_slot_empty($afterHeader) ||
        !is_slot_empty($beforeHeader);
?>

<div
    <?php echo e($attributes->merge(
            [
                'id' => $id,
            ],
            escape: false,
        )->merge($getExtraAttributes(), escape: false)->merge($getExtraAlpineAttributes(), escape: false)->class(['fi-sc-section'])); ?>>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($label = $getLabel())): ?>
        <div class="fi-sc-section-label-ctn">
            <?php echo e($getChildSchema($schemaComponent::BEFORE_LABEL_SCHEMA_KEY)); ?>


            <div class="fi-sc-section-label">
                <?php echo e($label); ?>

            </div>

            <?php echo e($getChildSchema($schemaComponent::AFTER_LABEL_SCHEMA_KEY)); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aboveContentContainer = $getChildSchema($schemaComponent::ABOVE_CONTENT_SCHEMA_KEY)?->toHtmlString()): ?>
        <?php echo e($aboveContentContainer); ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <section  x-data="{
        isCollapsed: <?php if($shouldPersistCollapsed): ?> $persist(<?php echo \Illuminate\Support\Js::from($isCollapsed)->toHtml() ?>).as(`section-${<?php echo \Illuminate\Support\Js::from($id)->toHtml() ?> ?? $el.id}-isCollapsed`) <?php else: ?> <?php echo \Illuminate\Support\Js::from($isCollapsed)->toHtml() ?> <?php endif; ?>,
    }"
        <?php if($isCollapsible): ?> x-on:collapse-section.window="if ($event.detail.id == <?php echo \Illuminate\Support\Js::from($id)->toHtml() ?> ?? $el.id) isCollapsed = true"
            x-on:expand="isCollapsed = false"
            x-on:expand-section.window="if ($event.detail.id == <?php echo \Illuminate\Support\Js::from($id)->toHtml() ?> ?? $el.id) isCollapsed = false"
            x-on:open-section.window="if ($event.detail.id == <?php echo \Illuminate\Support\Js::from($id)->toHtml() ?> ?? $el.id) isCollapsed = false"
            x-on:toggle-section.window="if ($event.detail.id == <?php echo \Illuminate\Support\Js::from($id)->toHtml() ?> ?? $el.id) isCollapsed = ! isCollapsed"
            x-bind:class="isCollapsed && 'fi-collapsed'" <?php endif; ?>
        class="<?php echo e(\Illuminate\Support\Arr::toCssClasses([
            'fi-section',
            'fi-section-not-contained' => !$isContained,
            'fi-section-has-content-before' => $isFormBefore,
            'fi-section-has-header' => $hasHeader,
            'fi-aside' => $isAside,
            'fi-compact' => $isCompact,
            'fi-collapsible' => $isCollapsible,
            'fi-divided' => $isDivided,
            'fi-secondary' => $isSecondary,
        ])); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasHeader): ?>
            <header <?php if($isCollapsible): ?> x-on:click="isCollapsed = ! isCollapsed" <?php endif; ?>
                class="fi-section-header">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!is_slot_empty($beforeHeader)): ?>
                    <div x-on:click.stop class="fi-section-header-before-ctn">
                        <?php echo e($beforeHeader); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php echo e(\Filament\Support\generate_icon_html(
                    $icon,
                    attributes: (new \Illuminate\View\ComponentAttributeBag)->color(IconComponent::class, $iconColor),
                    size: $iconSize ?? IconSize::Large,
                )); ?>


                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasHeading || $hasDescription): ?>
                    <div class="fi-section-header-text-ctn">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasHeading): ?>
                            <<?php echo e($headingTag); ?> class="fi-section-header-heading">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!is_slot_empty($headingContent)): ?>
                                    <?php echo e($headingContent); ?>

                                <?php else: ?>
                                    <?php echo e($heading); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </<?php echo e($headingTag); ?>>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasDescription): ?>
                            <p class="fi-section-header-description">
                                <?php echo e($description); ?>

                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!is_slot_empty($afterHeader)): ?>
                    <div x-on:click.stop class="fi-section-header-after-ctn">
                        <?php echo e($afterHeader); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCollapsible && !$isAside): ?>
                    <?php if (isset($component)) { $__componentOriginalf0029cce6d19fd6d472097ff06a800a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon-button','data' => ['color' => 'gray','icon' => \Filament\Support\Icons\Heroicon::ChevronUp,'iconAlias' => \Filament\Support\View\SupportIconAlias::SECTION_COLLAPSE_BUTTON,'xOn:click.stop' => 'isCollapsed = ! isCollapsed','class' => 'fi-section-collapse-btn']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\Icons\Heroicon::ChevronUp),'icon-alias' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Filament\Support\View\SupportIconAlias::SECTION_COLLAPSE_BUTTON),'x-on:click.stop' => 'isCollapsed = ! isCollapsed','class' => 'fi-section-collapse-btn']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $attributes = $__attributesOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__attributesOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1)): ?>
<?php $component = $__componentOriginalf0029cce6d19fd6d472097ff06a800a1; ?>
<?php unset($__componentOriginalf0029cce6d19fd6d472097ff06a800a1); ?>
<?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </header>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div <?php if($isCollapsible): ?> x-bind:aria-expanded="(! isCollapsed).toString()"
                <?php if($isCollapsed || $shouldPersistCollapsed): ?>
                    x-cloak <?php endif; ?>
            <?php endif; ?>
            class="fi-section-content-ctn"
            >
            <div class="fi-section-content">
                <?php echo e($getChildSchema()->extraAttributes(['class' => 'fi-section-content'])); ?>

            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!is_slot_empty($footer)): ?>
                <footer class="fi-section-footer">
                    <?php echo e($footer); ?>

                </footer>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($belowContentContainer = $getChildSchema($schemaComponent::BELOW_CONTENT_SCHEMA_KEY)?->toHtmlString()): ?>
        <?php echo e($belowContentContainer); ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\vendor\slimani\filament-media-manager\resources\views/filament/components/section.blade.php ENDPATH**/ ?>
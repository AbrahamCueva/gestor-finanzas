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

    <?php $datos = $this->getDatos(); ?>

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

        .gi-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .gi-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .gi-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* Resumen */
        .gi-resumen {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:768px) {
            .gi-resumen {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .gi-res-item {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .gi-res-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .gi-res-value {
            font-size: 1.1rem;
            font-weight: 800;
        }

        /* Grid categorías */
        .gi-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        @media(max-width:768px) {
            .gi-grid {
                grid-template-columns: 1fr;
            }
        }

        .gi-cat-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            border: 1.5px solid transparent;
        }

        .gi-cat-card.inusual {
            border-color: rgba(239, 68, 68, 0.3);
        }

        .gi-cat-card.elevado {
            border-color: rgba(251, 191, 36, 0.3);
        }

        .gi-cat-card.bajo {
            border-color: rgba(96, 165, 250, 0.2);
        }

        .gi-cat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .gi-cat-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .gi-cat-icono {
            font-size: 1.1rem;
        }

        .gi-cat-nombre {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .gi-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .gi-badge-inusual {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .gi-badge-elevado {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .gi-badge-normal {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .gi-badge-bajo {
            background: rgba(96, 165, 250, 0.12);
            color: #60a5fa;
        }

        .gi-montos {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }

        .gi-monto-item {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
        }

        .gi-monto-label {
            font-size: 0.6rem;
            color: var(--w-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .gi-monto-value {
            font-size: 0.875rem;
            font-weight: 700;
        }

        .gi-diff {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 0.375rem;
            margin-left: auto;
        }

        /* Mini sparkline */
        .gi-sparkline {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 32px;
        }

        .gi-spark-bar {
            flex: 1;
            border-radius: 2px 2px 0 0;
            min-height: 2px;
            transition: height 0.3s;
        }

        .gi-info {
            background: rgba(96, 165, 250, 0.08);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            line-height: 1.5;
            display: flex;
            gap: 0.625rem;
        }

        .gi-info svg {
            width: 16px;
            height: 16px;
            color: #60a5fa;
            flex-shrink: 0;
            margin-top: 1px;
        }
    </style>

    <div class="gi-wrap">

        <div class="gi-info">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            Se considera inusual cuando el gasto del mes actual supera en más del 50% el promedio de los últimos 3
            meses. Se muestra el historial de los últimos 6 meses por categoría.
        </div>

        <?php
            $inusuales = collect($datos)->where('estado', 'inusual')->count();
            $elevados = collect($datos)->where('estado', 'elevado')->count();
            $normales = collect($datos)->where('estado', 'normal')->count();
            $bajos = collect($datos)->where('estado', 'bajo')->count();
        ?>

        <div class="gi-card">
            <div class="gi-title">📊 Resumen del mes actual</div>
            <div class="gi-resumen">
                <div class="gi-res-item">
                    <div class="gi-res-label">⚠ Inusuales</div>
                    <div class="gi-res-value" style="color:<?php echo e($inusuales > 0 ? '#ef4444' : '#22c55e'); ?>;">
                        <?php echo e($inusuales); ?></div>
                </div>
                <div class="gi-res-item">
                    <div class="gi-res-label">📈 Elevados</div>
                    <div class="gi-res-value" style="color:#fbbf24;"><?php echo e($elevados); ?></div>
                </div>
                <div class="gi-res-item">
                    <div class="gi-res-label">✓ Normales</div>
                    <div class="gi-res-value" style="color:#22c55e;"><?php echo e($normales); ?></div>
                </div>
                <div class="gi-res-item">
                    <div class="gi-res-label">📉 Bajos</div>
                    <div class="gi-res-value" style="color:#60a5fa;"><?php echo e($bajos); ?></div>
                </div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($datos) > 0): ?>
            <div class="gi-card">
                <div class="gi-title">🏷️ Análisis por categoría</div>
                <div class="gi-grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $badgeClass = match ($cat['estado']) {
                                'inusual' => 'gi-badge-inusual',
                                'elevado' => 'gi-badge-elevado',
                                'bajo' => 'gi-badge-bajo',
                                default => 'gi-badge-normal',
                            };
                            $badgeLabel = match ($cat['estado']) {
                                'inusual' => '⚠ Inusual',
                                'elevado' => '📈 Elevado',
                                'bajo' => '📉 Bajo',
                                default => '✓ Normal',
                            };
                            $diffColor = $cat['diffPct'] > 0 ? '#ef4444' : '#22c55e';
                            $maxGasto = max(array_column($cat['historico'], 'gasto')) ?: 1;
                        ?>

                        <div class="gi-cat-card <?php echo e($cat['estado']); ?>">
                            <div class="gi-cat-header">
                                <div class="gi-cat-left">
                                    <span class="gi-cat-icono"><?php echo e($cat['icono']); ?></span>
                                    <span class="gi-cat-nombre"><?php echo e($cat['categoria']); ?></span>
                                </div>
                                <span class="gi-badge <?php echo e($badgeClass); ?>"><?php echo e($badgeLabel); ?></span>
                            </div>

                            <div class="gi-montos">
                                <div class="gi-monto-item">
                                    <span class="gi-monto-label">Este mes</span>
                                    <span class="gi-monto-value"
                                        style="color:<?php echo e($cat['estado'] === 'inusual' ? '#ef4444' : 'var(--w-text)'); ?>;">
                                        S/ <?php echo e(number_format($cat['gastoActual'], 2)); ?>

                                    </span>
                                </div>
                                <div class="gi-monto-item">
                                    <span class="gi-monto-label">Promedio</span>
                                    <span class="gi-monto-value" style="color:var(--w-muted);">
                                        S/ <?php echo e(number_format($cat['promedio'], 2)); ?>

                                    </span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cat['diffPct'] != 0): ?>
                                    <div class="gi-monto-item" style="margin-left:auto;">
                                        <span class="gi-monto-label">Variación</span>
                                        <span class="gi-monto-value" style="color:<?php echo e($diffColor); ?>;">
                                            <?php echo e($cat['diffPct'] > 0 ? '+' : ''); ?><?php echo e($cat['diffPct']); ?>%
                                        </span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="gi-sparkline">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cat['historico']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        $altura = $maxGasto > 0 ? round(($h['gasto'] / $maxGasto) * 100) : 0;
                                        $esUltimo = $i === 5;
                                        $color = $esUltimo
                                            ? ($cat['estado'] === 'inusual'
                                                ? '#ef4444'
                                                : ($cat['estado'] === 'elevado'
                                                    ? '#fbbf24'
                                                    : '#22c55e'))
                                            : 'rgba(107,114,128,0.3)';
                                    ?>
                                    <div class="gi-spark-bar"
                                        style="height:<?php echo e(max(4, $altura)); ?>%; background:<?php echo e($color); ?>;"
                                        title="<?php echo e($h['mes']); ?>: S/ <?php echo e(number_format($h['gasto'], 2)); ?>">
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <div
                                style="display:flex; justify-content:space-between; font-size:0.6rem; color:var(--w-muted); margin-top:0.25rem;">
                                <span><?php echo e($cat['historico'][0]['mes']); ?></span>
                                <span>Este mes</span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div style="text-align:center; color:var(--w-muted); padding:3rem; font-size:0.875rem;">
                No hay datos suficientes para el análisis. Registra movimientos durante al menos 2 meses.
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/gastos-inusuales.blade.php ENDPATH**/ ?>
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

        .r50-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .r50-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .r50-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .r50-filtros {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
        }

        .r50-filtro-btn {
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

        .r50-filtro-btn.activo {
            background: #fbbf24;
            color: #0f172a;
        }

        .r50-filtro-btn:hover:not(.activo) {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        /* Puntaje */
        .r50-score-wrap {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .r50-score-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 900;
            flex-shrink: 0;
            border: 3px solid;
        }

        .r50-score-info {
            flex: 1;
        }

        .r50-score-label {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .r50-score-nombre {
            font-size: 1rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .r50-score-desc {
            font-size: 0.72rem;
            color: var(--w-muted);
            margin-top: 0.15rem;
        }

        /* Grid 3 columnas */
        .r50-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.875rem;
        }

        @media(max-width:768px) {
            .r50-grid {
                grid-template-columns: 1fr;
            }
        }

        .r50-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            border: 1.5px solid transparent;
            transition: border-color 0.15s;
        }

        .r50-card.ok {
            border-color: rgba(34, 197, 94, 0.25);
        }

        .r50-card.warning {
            border-color: rgba(251, 191, 36, 0.25);
        }

        .r50-card.danger {
            border-color: rgba(239, 68, 68, 0.25);
        }

        .r50-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .r50-card-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .r50-card-emoji {
            font-size: 1.25rem;
        }

        .r50-card-nombre {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .r50-card-ideal {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        .r50-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .r50-badge.ok {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .r50-badge.warning {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .r50-badge.danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .r50-monto {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .r50-pct-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.375rem;
        }

        .r50-pct-val {
            font-size: 0.75rem;
            font-weight: 700;
            min-width: 36px;
        }

        .r50-track {
            flex: 1;
            height: 4px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .r50-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.5s ease;
        }

        .r50-ideal-line {
            font-size: 0.65rem;
            color: var(--w-muted);
        }

        /* Ingresos info */
        .r50-ingresos {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .r50-ing-item {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
        }

        .r50-ing-label {
            font-size: 0.65rem;
            color: var(--w-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .r50-ing-value {
            font-size: 0.925rem;
            font-weight: 700;
            color: var(--w-text);
        }
    </style>

    <div class="r50-wrap">
        <div class="r50-header">
            <div class="r50-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    style="width:13px;height:13px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                </svg>
                Regla 50/30/20
            </div>
            <div class="r50-filtros">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->getFiltros(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <button class="r50-filtro-btn <?php echo e($filtro === $key ? 'activo' : ''); ?>"
                        wire:click="$set('filtro','<?php echo e($key); ?>')">
                        <?php echo e($label); ?>

                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <div class="r50-ingresos">
            <div class="r50-ing-item">
                <span class="r50-ing-label">Ingresos del período</span>
                <span class="r50-ing-value" style="color:#22c55e;">S/
                    <?php echo e(number_format($datos['totalIngresos'], 2)); ?></span>
            </div>
            <div class="r50-ing-item">
                <span class="r50-ing-label">Total egresos</span>
                <span class="r50-ing-value" style="color:#ef4444;">S/
                    <?php echo e(number_format($datos['totalEgresos'], 2)); ?></span>
            </div>
            <div class="r50-ing-item">
                <span class="r50-ing-label">Ahorro neto</span>
                <span class="r50-ing-value" style="color:#60a5fa;">S/ <?php echo e(number_format($datos['ahorro'], 2)); ?></span>
            </div>
        </div>

        <?php
            $puntaje = $datos['puntaje'];
            $scoreColor = $puntaje >= 80 ? '#22c55e' : ($puntaje >= 50 ? '#fbbf24' : '#ef4444');
            $scoreNombre = $puntaje >= 80 ? '¡Excelente!' : ($puntaje >= 50 ? 'Puede mejorar' : 'Necesita atención');
            $scoreDesc =
                $puntaje >= 80
                    ? 'Tu distribución financiera es muy saludable.'
                    : ($puntaje >= 50
                        ? 'Estás cerca, pequeños ajustes marcarán la diferencia.'
                        : 'Revisa tu distribución de gastos para mejorar tu salud financiera.');
        ?>

        <div class="r50-score-wrap">
            <div class="r50-score-circle"
                style="border-color:<?php echo e($scoreColor); ?>; color:<?php echo e($scoreColor); ?>; background:<?php echo e($scoreColor); ?>12;">
                <?php echo e($puntaje); ?>

            </div>
            <div class="r50-score-info">
                <div class="r50-score-label">Puntuación 50/30/20</div>
                <div class="r50-score-nombre" style="color:<?php echo e($scoreColor); ?>;"><?php echo e($scoreNombre); ?></div>
                <div class="r50-score-desc"><?php echo e($scoreDesc); ?></div>
            </div>
        </div>

        <div class="r50-grid">
            <?php
                $c = $datos['estadoNecesidades'];
                $color = $c === 'ok' ? '#22c55e' : ($c === 'warning' ? '#fbbf24' : '#ef4444');
                $msg = $c === 'ok' ? '✓ En límite' : ($c === 'warning' ? '⚠ Un poco alto' : '✗ Excedido');
            ?>
            <div class="r50-card <?php echo e($c); ?>">
                <div class="r50-card-header">
                    <div class="r50-card-left">
                        <span class="r50-card-emoji">🏠</span>
                        <div>
                            <div class="r50-card-nombre">Necesidades</div>
                            <div class="r50-card-ideal">Ideal: máx 50%</div>
                        </div>
                    </div>
                    <span class="r50-badge <?php echo e($c); ?>"><?php echo e($msg); ?></span>
                </div>
                <div class="r50-monto" style="color:<?php echo e($color); ?>;">S/
                    <?php echo e(number_format($datos['necesidades'], 2)); ?>

                </div>
                <div class="r50-pct-row">
                    <span class="r50-pct-val"
                        style="color:<?php echo e($color); ?>;"><?php echo e($datos['pctNecesidades']); ?>%</span>
                    <div class="r50-track">
                        <div class="r50-fill"
                            style="width:<?php echo e(min(100, $datos['pctNecesidades'])); ?>%; background:<?php echo e($color); ?>;">
                        </div>
                    </div>
                </div>
                <div class="r50-ideal-line">
                    Ideal: S/ <?php echo e(number_format($datos['idealNecesidades'], 2)); ?>

                    (<?php echo e($datos['pctNecesidades'] > 50 ? '−S/ ' . number_format($datos['necesidades'] - $datos['idealNecesidades'], 2) . ' de exceso' : '+S/ ' . number_format($datos['idealNecesidades'] - $datos['necesidades'], 2) . ' disponible'); ?>)
                </div>
            </div>

            <?php
                $c = $datos['estadoDeseos'];
                $color = $c === 'ok' ? '#22c55e' : ($c === 'warning' ? '#fbbf24' : '#ef4444');
                $msg = $c === 'ok' ? '✓ En límite' : ($c === 'warning' ? '⚠ Un poco alto' : '✗ Excedido');
            ?>
            <div class="r50-card <?php echo e($c); ?>">
                <div class="r50-card-header">
                    <div class="r50-card-left">
                        <span class="r50-card-emoji">🎮</span>
                        <div>
                            <div class="r50-card-nombre">Deseos</div>
                            <div class="r50-card-ideal">Ideal: máx 30%</div>
                        </div>
                    </div>
                    <span class="r50-badge <?php echo e($c); ?>"><?php echo e($msg); ?></span>
                </div>
                <div class="r50-monto" style="color:<?php echo e($color); ?>;">S/ <?php echo e(number_format($datos['deseos'], 2)); ?>

                </div>
                <div class="r50-pct-row">
                    <span class="r50-pct-val" style="color:<?php echo e($color); ?>;"><?php echo e($datos['pctDeseos']); ?>%</span>
                    <div class="r50-track">
                        <div class="r50-fill"
                            style="width:<?php echo e(min(100, $datos['pctDeseos'])); ?>%; background:<?php echo e($color); ?>;"></div>
                    </div>
                </div>
                <div class="r50-ideal-line">
                    Ideal: S/ <?php echo e(number_format($datos['idealDeseos'], 2)); ?>

                    (<?php echo e($datos['pctDeseos'] > 30 ? '−S/ ' . number_format($datos['deseos'] - $datos['idealDeseos'], 2) . ' de exceso' : '+S/ ' . number_format($datos['idealDeseos'] - $datos['deseos'], 2) . ' disponible'); ?>)
                </div>
            </div>
            <?php
                $c = $datos['estadoAhorro'];
                $color = $c === 'ok' ? '#22c55e' : ($c === 'warning' ? '#fbbf24' : '#ef4444');
                $msg = $c === 'ok' ? '✓ Meta cumplida' : ($c === 'warning' ? '⚠ Casi llegas' : '✗ Por debajo');
            ?>
            <div class="r50-card <?php echo e($c); ?>">
                <div class="r50-card-header">
                    <div class="r50-card-left">
                        <span class="r50-card-emoji">💰</span>
                        <div>
                            <div class="r50-card-nombre">Ahorro</div>
                            <div class="r50-card-ideal">Ideal: mín 20%</div>
                        </div>
                    </div>
                    <span class="r50-badge <?php echo e($c); ?>"><?php echo e($msg); ?></span>
                </div>
                <div class="r50-monto" style="color:<?php echo e($color); ?>;">S/ <?php echo e(number_format($datos['ahorro'], 2)); ?>

                </div>
                <div class="r50-pct-row">
                    <span class="r50-pct-val" style="color:<?php echo e($color); ?>;"><?php echo e($datos['pctAhorro']); ?>%</span>
                    <div class="r50-track">
                        <div class="r50-fill"
                            style="width:<?php echo e(min(100, $datos['pctAhorro'])); ?>%; background:<?php echo e($color); ?>;"></div>
                    </div>
                </div>
                <div class="r50-ideal-line">
                    Ideal: S/ <?php echo e(number_format($datos['idealAhorro'], 2)); ?>

                    (<?php echo e($datos['pctAhorro'] < 20 ? 'faltan S/ ' . number_format($datos['idealAhorro'] - $datos['ahorro'], 2) : '+S/ ' . number_format($datos['ahorro'] - $datos['idealAhorro'], 2) . ' extra'); ?>)
                </div>
            </div>

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
<?php endif; ?>
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/widgets/regla-502030.blade.php ENDPATH**/ ?>
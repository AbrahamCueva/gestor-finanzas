<?php
    $isPositive = $ahorro >= 0;
    $label = $isPositive ? 'Rendimiento positivo' : 'Déficit mensual';
?>

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
            --w-muted: #6b7280;
            --w-border: rgba(0, 0, 0, 0.08);
        }

        .dark {
            --w-bg: rgba(255, 255, 255, 0.03);
            --w-card: rgba(255, 255, 255, 0.04);
            --w-text: #f9fafb;
            --w-muted: #6b7280;
            --w-border: rgba(255, 255, 255, 0.08);
        }

        .ia-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .ia-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .ia-title-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--w-muted);
            margin-bottom: 0.3rem;
        }

        .ia-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--w-text);
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .ia-balance-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--w-muted);
            margin-bottom: 0.3rem;
            text-align: right;
        }

        .ia-balance-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: #3b82f6;
            text-align: right;
        }

        .ia-selector select {
            font-size: 0.8rem;
            padding: 0.4rem 2rem 0.4rem 0.75rem;
            border-radius: 0.625rem;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-text);
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.6rem center;
            transition: border-color 0.15s;
        }

        .ia-selector select:focus {
            border-color: #fbbf24;
        }

        .ia-selector select option {
            background: #1f2937;
            color: #f9fafb;
        }

        .ia-metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .ia-metric {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 1rem;
        }

        .ia-metric-icon {
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.625rem;
        }

        .ia-metric-icon svg {
            width: 14px;
            height: 14px;
        }

        .ia-metric-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 0.35rem;
        }

        .ia-metric-value {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .ia-metric-sub {
            font-size: 0.65rem;
            margin-top: 0.3rem;
        }

        .ia-progress-wrap {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .ia-progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ia-progress-label {
            font-size: 0.7rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .ia-progress-label::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        .ia-progress-pct {
            font-size: 1rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ia-progress-track {
            height: 4px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .ia-progress-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.7s ease;
        }
    </style>

    <div class="ia-wrap">

        <div class="ia-header">
            <div>
                <div class="ia-title-label">Dashboard Financiero</div>
                <div class="ia-title"><?php echo e(strtoupper($mes)); ?></div>
            </div>
            <div style="display:flex; flex-direction:column; align-items:flex-end; gap:0.75rem;">
                <div class="ia-selector">
                    <select wire:model.live="periodo">
                        <option value="mes_actual">Este mes</option>
                        <option value="este_anio">Este año</option>
                        <option value="ultimos_6">Últimos 6 meses</option>
                        <option value="ultimos_3">Últimos 3 meses</option>
                    </select>
                </div>
                <div>
                    <div class="ia-balance-label">Balance Total</div>
                    <div class="ia-balance-value">S/ <?php echo e(number_format($saldoTotal, 2)); ?></div>
                </div>
            </div>
        </div>

        <div class="ia-metrics">

            <div class="ia-metric">
                <div class="ia-metric-icon"
                    style="background:rgba(<?php echo e($isPositive ? '34,197,94' : '239,68,68'); ?>,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="<?php echo e($isPositive ? '#22c55e' : '#ef4444'); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPositive): ?>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6L9 12.75l4.306-4.307a11.95 11.95 0 015.814 5.519l2.74 1.22m0 0l-5.94 2.28m5.94-2.28l-2.28-5.941" />
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </svg>
                </div>
                <div class="ia-metric-label">Ahorro Neto</div>
                <div class="ia-metric-value" style="color:<?php echo e($isPositive ? '#22c55e' : '#ef4444'); ?>;">
                    S/ <?php echo e(number_format(abs($ahorro), 2)); ?>

                </div>
                <div class="ia-metric-sub" style="color:<?php echo e($isPositive ? '#16a34a' : '#dc2626'); ?>;">
                    <?php echo e($isPositive ? 'Surplus' : 'Déficit'); ?>

                </div>
            </div>

            <div class="ia-metric">
                <div class="ia-metric-icon" style="background:rgba(34,197,94,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#22c55e">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div class="ia-metric-label">Ingresos</div>
                <div class="ia-metric-value" style="color:#22c55e;">S/ <?php echo e(number_format($ingresos, 2)); ?></div>
            </div>

            <div class="ia-metric">
                <div class="ia-metric-icon" style="background:rgba(239,68,68,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#ef4444">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                    </svg>
                </div>
                <div class="ia-metric-label">Gastos</div>
                <div class="ia-metric-value" style="color:#ef4444;">S/ <?php echo e(number_format($egresos, 2)); ?></div>
            </div>

        </div>

        <div class="ia-progress-wrap">
            <div class="ia-progress-header">
                <div class="ia-progress-label" style="color:<?php echo e($isPositive ? '#22c55e' : '#ef4444'); ?>;">
                    <?php echo e($label); ?>

                </div>
                <div class="ia-progress-pct"><?php echo e($porcentaje); ?>%</div>
            </div>
            <div class="ia-progress-track">
                <div class="ia-progress-fill"
                    style="width:<?php echo e(min($porcentaje, 100)); ?>%; background:<?php echo e($isPositive ? '#22c55e' : '#ef4444'); ?>;">
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/widgets/indicador-ahorro.blade.php ENDPATH**/ ?>
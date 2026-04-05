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

        .ra-space {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ra-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ra-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .ra-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .ra-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ra-section-title svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        .ra-selector select {
            font-size: 0.85rem;
            padding: 0.5rem 2rem 0.5rem 0.875rem;
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
            background-position: right 0.75rem center;
            transition: border-color 0.15s;
        }

        .ra-selector select:focus {
            border-color: #fbbf24;
        }

        .ra-selector select option {
            background: #1f2937;
            color: #e5e7eb;
        }

        /* KPIs */
        .ra-kpi {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
        }

        .ra-kpi-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        .ra-kpi-icon svg {
            width: 15px;
            height: 15px;
        }

        .ra-kpi-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 0.3rem;
        }

        .ra-kpi-value {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .ra-kpi-sub {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 0.3rem;
        }

        /* Tabla meses */
        .ra-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ra-table th {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            text-align: left;
            border-bottom: 1px solid var(--w-border);
        }

        .ra-table th:last-child,
        .ra-table td:last-child {
            text-align: right;
        }

        .ra-table td {
            font-size: 0.8rem;
            padding: 0.6rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
        }

        .ra-table tr:last-child td {
            border-bottom: none;
        }

        .ra-table tr:hover td {
            background: var(--w-card);
        }

        .ra-table .ra-total td {
            font-weight: 700;
            color: var(--w-text);
            background: var(--w-card);
        }

        /* Barra categorías */
        .ra-bar-row {
            margin-bottom: 0.875rem;
        }

        .ra-bar-row:last-child {
            margin-bottom: 0;
        }

        .ra-bar-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.35rem;
        }

        .ra-bar-name {
            font-size: 0.8rem;
            color: var(--w-text-soft);
        }

        .ra-bar-amount {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--w-text);
        }

        .ra-bar-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .ra-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: #fbbf24;
        }

        /* Cuentas */
        .ra-cuenta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0.75rem;
            background: var(--w-card);
            border-radius: 0.625rem;
            margin-bottom: 0.4rem;
        }

        .ra-cuenta-row:last-child {
            margin-bottom: 0;
        }

        .ra-cuenta-name {
            font-size: 0.825rem;
            font-weight: 500;
            color: var(--w-text);
        }

        .ra-cuenta-type {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 1px;
            text-transform: capitalize;
        }

        .ra-cuenta-saldo {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--w-text);
        }

        /* Presupuestos */
        .ra-budget-card {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.875rem;
        }

        .ra-budget-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .ra-budget-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--w-text);
        }

        .ra-budget-pct {
            font-size: 0.75rem;
            font-weight: 700;
        }

        .ra-budget-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .ra-budget-fill {
            height: 100%;
            border-radius: 99px;
        }

        .ra-budget-amounts {
            display: flex;
            justify-content: space-between;
            font-size: 0.68rem;
            color: var(--w-muted);
        }

        /* Highlight cards */
        .ra-highlight {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .ra-hl-card {
            flex: 1;
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.875rem;
        }

        .ra-hl-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--w-muted);
            margin-bottom: 0.3rem;
        }

        .ra-hl-mes {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ra-hl-value {
            font-size: 0.75rem;
            color: var(--w-muted);
            margin-top: 0.15rem;
        }
    </style>

    <div class="ra-space">

        <div style="display:flex; align-items:center; gap:0.75rem;">
            <div class="ra-selector">
                <select wire:model.live="anio">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = range(now()->year - 3, now()->year); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($y); ?>" <?php if($anio == $y): echo 'selected'; endif; ?>><?php echo e($y); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <span style="font-size:0.8rem; color:var(--w-muted);">Resumen del año <?php echo e($datos['anio']); ?></span>
        </div>

        <div class="ra-grid-3">
            <div class="ra-kpi">
                <div class="ra-kpi-icon" style="background:rgba(34,197,94,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#22c55e">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                </div>
                <div class="ra-kpi-label">Ingresos anuales</div>
                <div class="ra-kpi-value" style="color:#22c55e;">S/ <?php echo e(number_format($datos['totalIngresos'], 2)); ?>

                </div>
                <div class="ra-kpi-sub">Promedio S/ <?php echo e(number_format($datos['totalIngresos'] / 12, 2)); ?>/mes</div>
            </div>

            <div class="ra-kpi">
                <div class="ra-kpi-icon" style="background:rgba(239,68,68,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#ef4444">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6L9 12.75l4.306-4.307a11.95 11.95 0 015.814 5.519l2.74 1.22m0 0l-5.94 2.28m5.94-2.28l-2.28-5.941" />
                    </svg>
                </div>
                <div class="ra-kpi-label">Egresos anuales</div>
                <div class="ra-kpi-value" style="color:#ef4444;">S/ <?php echo e(number_format($datos['totalEgresos'], 2)); ?></div>
                <div class="ra-kpi-sub">Promedio S/ <?php echo e(number_format($datos['totalEgresos'] / 12, 2)); ?>/mes</div>
            </div>

            <div class="ra-kpi">
                <div class="ra-kpi-icon"
                    style="background:rgba(<?php echo e($datos['totalAhorro'] >= 0 ? '96,165,250' : '251,146,60'); ?>,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="<?php echo e($datos['totalAhorro'] >= 0 ? '#60a5fa' : '#fb923c'); ?>">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ra-kpi-label">Ahorro anual</div>
                <div class="ra-kpi-value" style="color:<?php echo e($datos['totalAhorro'] >= 0 ? '#60a5fa' : '#fb923c'); ?>;">
                    S/ <?php echo e(number_format($datos['totalAhorro'], 2)); ?>

                </div>
                <div class="ra-kpi-sub">
                    <?php echo e($datos['totalIngresos'] > 0 ? round(($datos['totalAhorro'] / $datos['totalIngresos']) * 100, 1) : 0); ?>%
                    de los ingresos
                </div>
            </div>
        </div>

        <div class="ra-highlight">
            <div class="ra-hl-card">
                <div class="ra-hl-label" style="color:#22c55e;">🏆 Mejor mes</div>
                <div class="ra-hl-mes"><?php echo e($datos['mejorMes']['mes']); ?></div>
                <div class="ra-hl-value">S/ <?php echo e(number_format($datos['mejorMes']['ahorro'], 2)); ?> ahorrado</div>
            </div>
            <div class="ra-hl-card">
                <div class="ra-hl-label" style="color:#ef4444;">📉 Mes más ajustado</div>
                <div class="ra-hl-mes"><?php echo e($datos['peorMes']['mes']); ?></div>
                <div class="ra-hl-value">S/ <?php echo e(number_format($datos['peorMes']['ahorro'], 2)); ?> ahorrado</div>
            </div>
        </div>

        <div class="ra-card">
            <div class="ra-section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3" />
                </svg>
                Resumen por Mes
            </div>
            <table class="ra-table">
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Ingresos</th>
                        <th>Egresos</th>
                        <th>Ahorro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $datos['meses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($m['mes']); ?></td>
                            <td style="color:#22c55e; font-weight:600;">S/ <?php echo e(number_format($m['ingresos'], 2)); ?></td>
                            <td style="color:#ef4444; font-weight:600;">S/ <?php echo e(number_format($m['egresos'], 2)); ?></td>
                            <td style="color:<?php echo e($m['ahorro'] >= 0 ? '#60a5fa' : '#fb923c'); ?>; font-weight:700;">
                                S/ <?php echo e(number_format($m['ahorro'], 2)); ?>

                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr class="ra-total">
                        <td>Total <?php echo e($datos['anio']); ?></td>
                        <td style="color:#22c55e;">S/ <?php echo e(number_format($datos['totalIngresos'], 2)); ?></td>
                        <td style="color:#ef4444;">S/ <?php echo e(number_format($datos['totalEgresos'], 2)); ?></td>
                        <td style="color:<?php echo e($datos['totalAhorro'] >= 0 ? '#60a5fa' : '#fb923c'); ?>;">S/
                            <?php echo e(number_format($datos['totalAhorro'], 2)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="ra-grid-2">

            <div class="ra-card">
                <div class="ra-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                    Top Categorías de Gasto
                </div>
                <?php $maxCat = $datos['topCategorias']->max('total') ?: 1; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $datos['topCategorias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="ra-bar-row">
                        <div class="ra-bar-label">
                            <span class="ra-bar-name"><?php echo e($cat->nombre); ?></span>
                            <span class="ra-bar-amount">S/ <?php echo e(number_format($cat->total, 2)); ?></span>
                        </div>
                        <div class="ra-bar-track">
                            <div class="ra-bar-fill" style="width:<?php echo e(round(($cat->total / $maxCat) * 100)); ?>%;"></div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <p style="font-size:0.8rem; color:var(--w-muted); text-align:center; padding:1.5rem 0;">Sin egresos
                        este año</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="ra-card">
                <div class="ra-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                    Saldo en Cuentas
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $datos['cuentas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuenta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="ra-cuenta-row">
                        <div>
                            <div class="ra-cuenta-name"><?php echo e($cuenta->nombre); ?></div>
                            <div class="ra-cuenta-type"><?php echo e($cuenta->tipo_cuenta); ?></div>
                        </div>
                        <div class="ra-cuenta-saldo" style="<?php echo e($cuenta->saldo_actual < 0 ? 'color:#ef4444;' : ''); ?>">
                            S/ <?php echo e(number_format($cuenta->saldo_actual, 2)); ?>

                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($datos['presupuestos']->count()): ?>
            <div class="ra-card">
                <div class="ra-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Estado de Presupuestos
                </div>
                <div class="ra-grid-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $datos['presupuestos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php $bc = $p['superado'] ? '#ef4444' : ($p['porcentaje'] >= 80 ? '#f59e0b' : '#22c55e'); ?>
                        <div class="ra-budget-card">
                            <div class="ra-budget-header">
                                <div class="ra-budget-name"><?php echo e($p['nombre']); ?></div>
                                <div class="ra-budget-pct" style="color:<?php echo e($bc); ?>;">
                                    <?php echo e($p['porcentaje']); ?>%</div>
                            </div>
                            <div class="ra-budget-track">
                                <div class="ra-budget-fill"
                                    style="width:<?php echo e(min(100, $p['porcentaje'])); ?>%; background:<?php echo e($bc); ?>;">
                                </div>
                            </div>
                            <div class="ra-budget-amounts">
                                <span>S/ <?php echo e(number_format($p['gasto'], 2)); ?></span>
                                <span>/ S/ <?php echo e(number_format($p['limite'], 2)); ?></span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/reporte-anual.blade.php ENDPATH**/ ?>
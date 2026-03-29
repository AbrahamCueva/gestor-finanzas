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

    <?php
        $datos = $this->getDatos();
        $mesActual = $this->mes ?: now()->month;
        $anioActual = $this->anio ?: now()->year;
    ?>

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

        .rm-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .rm-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .rm-grid-53 {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 1rem;
        }

        .rm-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .rm-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rm-section-title svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        .rm-kpi-icon {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            flex-shrink: 0;
        }

        .rm-kpi-icon svg {
            width: 18px;
            height: 18px;
        }

        .rm-kpi-label {
            font-size: 0.8rem;
            color: var(--w-muted);
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .rm-kpi-value {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .rm-kpi-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.4rem;
        }

        .rm-bar-row {
            margin-bottom: 1rem;
        }

        .rm-bar-row:last-child {
            margin-bottom: 0;
        }

        .rm-bar-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.4rem;
        }

        .rm-bar-name {
            font-size: 0.825rem;
            color: var(--w-text-soft);
        }

        .rm-bar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .rm-bar-pct {
            font-size: 0.7rem;
            color: var(--w-muted);
        }

        .rm-bar-amount {
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--w-text);
            min-width: 80px;
            text-align: right;
        }

        .rm-bar-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .rm-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: #fbbf24;
        }

        .rm-account-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.625rem 0.75rem;
            background: var(--w-card);
            border-radius: 0.625rem;
            margin-bottom: 0.4rem;
        }

        .rm-account-row:last-child {
            margin-bottom: 0;
        }

        .rm-account-name {
            font-size: 0.825rem;
            font-weight: 500;
            color: var(--w-text);
        }

        .rm-account-type {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 1px;
            text-transform: capitalize;
        }

        .rm-account-saldo {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .rm-budget-card {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.875rem;
        }

        .rm-budget-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.6rem;
        }

        .rm-budget-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--w-text);
        }

        .rm-budget-pct {
            font-size: 0.75rem;
            font-weight: 700;
        }

        .rm-budget-bar-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 0.6rem;
        }

        .rm-budget-bar-fill {
            height: 100%;
            border-radius: 99px;
        }

        .rm-budget-amounts {
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
            color: var(--w-muted);
        }

        .rm-select {
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
            min-width: 140px;
            transition: border-color 0.15s;
        }

        .rm-select:focus {
            border-color: #fbbf24;
        }

        .rm-select option {
            background: #1f2937;
            color: #e5e7eb;
        }

        .rm-selector-bar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .rm-period-label {
            font-size: 0.8rem;
            color: var(--w-muted);
            margin-left: 0.25rem;
        }

        .rm-space {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .rm-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 0;
            color: var(--w-muted);
            font-size: 0.825rem;
        }
    </style>

    <div class="rm-space">

        <div class="rm-selector-bar">
            <select wire:model.live="mes" class="rm-select">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <option value="<?php echo e($i + 1); ?>" <?php if($mes == $i + 1): echo 'selected'; endif; ?>><?php echo e($nombre); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <select wire:model.live="anio" class="rm-select" style="min-width:100px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = range(now()->year - 2, now()->year + 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <option value="<?php echo e($y); ?>" <?php if($anio == $y): echo 'selected'; endif; ?>><?php echo e($y); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <span class="rm-period-label"><?php echo e(ucfirst($datos['nombreMes'])); ?></span>
        </div>
        <div class="rm-grid-3">

            <div class="rm-card">
                <div class="rm-kpi-icon" style="background:rgba(34,197,94,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#22c55e">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                </div>
                <div class="rm-kpi-label">Ingresos</div>
                <div class="rm-kpi-value" style="color:#22c55e;">S/ <?php echo e(number_format($datos['totalIngresos'], 2)); ?>

                </div>
                <div class="rm-kpi-sub"><?php echo e($datos['ingresos']->count()); ?> transacciones</div>
            </div>

            <div class="rm-card">
                <div class="rm-kpi-icon" style="background:rgba(239,68,68,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#ef4444">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6L9 12.75l4.306-4.307a11.95 11.95 0 015.814 5.519l2.74 1.22m0 0l-5.94 2.28m5.94-2.28l-2.28-5.941" />
                    </svg>
                </div>
                <div class="rm-kpi-label">Egresos</div>
                <div class="rm-kpi-value" style="color:#ef4444;">S/ <?php echo e(number_format($datos['totalEgresos'], 2)); ?></div>
                <div class="rm-kpi-sub"><?php echo e($datos['egresos']->count()); ?> transacciones</div>
            </div>

            <div class="rm-card">
                <div class="rm-kpi-icon"
                    style="background:rgba(<?php echo e($datos['ahorro'] >= 0 ? '96,165,250' : '251,146,60'); ?>,0.12);">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="<?php echo e($datos['ahorro'] >= 0 ? '#60a5fa' : '#fb923c'); ?>">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="rm-kpi-label">Ahorro neto</div>
                <div class="rm-kpi-value" style="color:<?php echo e($datos['ahorro'] >= 0 ? '#60a5fa' : '#fb923c'); ?>;">
                    S/ <?php echo e(number_format($datos['ahorro'], 2)); ?>

                </div>
                <div class="rm-kpi-sub">
                    <?php echo e($datos['totalIngresos'] > 0 ? round(($datos['ahorro'] / $datos['totalIngresos']) * 100, 1) : 0); ?>%
                    de los ingresos
                </div>
            </div>

        </div>

        <div class="rm-grid-53">

            <div class="rm-card">
                <div class="rm-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                    Gastos por Categoría
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $datos['gastosPorCategoria']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php $pct = $datos['totalEgresos'] > 0 ? round(($cat->total / $datos['totalEgresos']) * 100, 1) : 0; ?>
                    <div class="rm-bar-row">
                        <div class="rm-bar-label">
                            <span class="rm-bar-name"><?php echo e($cat->nombre); ?></span>
                            <div class="rm-bar-right">
                                <span class="rm-bar-pct"><?php echo e($pct); ?>%</span>
                                <span class="rm-bar-amount">S/ <?php echo e(number_format($cat->total, 2)); ?></span>
                            </div>
                        </div>
                        <div class="rm-bar-track">
                            <div class="rm-bar-fill" style="width:<?php echo e($pct); ?>%;"></div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="rm-empty">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            style="width:28px;height:28px;margin-bottom:0.5rem;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
                        </svg>
                        Sin egresos este mes
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="rm-card">
                <div class="rm-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                    Cuentas
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $datos['cuentas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuenta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="rm-account-row">
                        <div>
                            <div class="rm-account-name"><?php echo e($cuenta->nombre); ?></div>
                            <div class="rm-account-type"><?php echo e($cuenta->tipo_cuenta); ?></div>
                        </div>
                        <div class="rm-account-saldo" style="<?php echo e($cuenta->saldo_actual < 0 ? 'color:#ef4444;' : ''); ?>">
                            S/ <?php echo e(number_format($cuenta->saldo_actual, 2)); ?>

                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($datos['presupuestos']->count()): ?>
            <div class="rm-card">
                <div class="rm-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Estado de Presupuestos
                </div>
                <div class="rm-grid-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $datos['presupuestos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php $bc = $p['superado'] ? '#ef4444' : ($p['porcentaje'] >= 80 ? '#f59e0b' : '#22c55e'); ?>
                        <div class="rm-budget-card">
                            <div class="rm-budget-header">
                                <div class="rm-budget-name"><?php echo e($p['nombre']); ?></div>
                                <div class="rm-budget-pct" style="color:<?php echo e($bc); ?>;">
                                    <?php echo e($p['porcentaje']); ?>%</div>
                            </div>
                            <div class="rm-budget-bar-track">
                                <div class="rm-budget-bar-fill"
                                    style="width:<?php echo e(min(100, $p['porcentaje'])); ?>%; background:<?php echo e($bc); ?>;">
                                </div>
                            </div>
                            <div class="rm-budget-amounts">
                                <span>S/ <?php echo e(number_format($p['gasto'], 2)); ?> gastado</span>
                                <span>límite S/ <?php echo e(number_format($p['limite'], 2)); ?></span>
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/reporte-mensual.blade.php ENDPATH**/ ?>
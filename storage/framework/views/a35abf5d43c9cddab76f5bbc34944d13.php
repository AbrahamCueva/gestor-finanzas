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
        $monedas = $this->getMonedas();
        $todas = $this->getTodasMonedas();
        $selColor = $monedas[$moneda]['color'] ?? '#fbbf24';
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

        .htc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .htc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .htc-section-title {
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

        /* Tarjetas de monedas */
        .htc-monedas {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-bottom: 0;
        }

        @media(max-width:768px) {
            .htc-monedas {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .htc-moneda-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.15s;
        }

        .htc-moneda-card:hover {
            border-color: rgba(251, 191, 36, 0.3);
        }

        .htc-moneda-card.activa {
            border-color: var(--mc);
            background: rgba(var(--mc-rgb), 0.08);
        }

        .htc-moneda-flag {
            font-size: 1.25rem;
            margin-bottom: 0.375rem;
        }

        .htc-moneda-code {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .htc-moneda-label {
            font-size: 0.65rem;
            color: var(--w-muted);
        }

        .htc-moneda-tasa {
            font-size: 1.1rem;
            font-weight: 800;
            margin-top: 0.375rem;
        }

        .htc-moneda-upd {
            font-size: 0.62rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* Filtros periodo */
        .htc-periodos {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .htc-periodo-btn {
            padding: 0.3rem 0.875rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .htc-periodo-btn.activo {
            background: #fbbf24;
            color: #0f172a;
        }

        .htc-periodo-btn:hover:not(.activo) {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        /* KPIs */
        .htc-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
            margin-bottom: 1.25rem;
        }

        @media(max-width:768px) {
            .htc-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .htc-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .htc-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .htc-kpi-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .htc-kpi-sub {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* Gráfico */
        .htc-chart-wrap {
            position: relative;
            height: 280px;
        }
    </style>

    <div class="htc-wrap">
        <div class="htc-card">
            <div class="htc-section-title">💱 Tasas actuales (base PEN)</div>
            <div class="htc-monedas">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $todas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="htc-moneda-card <?php echo e($moneda === $code ? 'activa' : ''); ?>"
                        style="--mc:<?php echo e($info['color']); ?>;" wire:click="$set('moneda', '<?php echo e($code); ?>')">
                        <div class="htc-moneda-flag"><?php echo e($info['emoji']); ?></div>
                        <div class="htc-moneda-code"><?php echo e($code); ?></div>
                        <div class="htc-moneda-label"><?php echo e($info['label']); ?></div>
                        <div class="htc-moneda-tasa" style="color:<?php echo e($info['color']); ?>;">
                            <?php echo e(is_numeric($info['tasa']) ? number_format($info['tasa'], 4) : $info['tasa']); ?>

                        </div>
                        <div class="htc-moneda-upd"><?php echo e($info['actualizado']); ?></div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <div class="htc-card">
            <div
                style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; flex-wrap:wrap; gap:0.5rem;">
                <div class="htc-section-title" style="margin-bottom:0;">
                    📈 Historial PEN → <?php echo e($moneda); ?>

                </div>
                <div class="htc-periodos">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['7' => '7 días', '15' => '15 días', '30' => '30 días', '90' => '3 meses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <button class="htc-periodo-btn <?php echo e($periodo === $val ? 'activo' : ''); ?>"
                            wire:click="$set('periodo', '<?php echo e($val); ?>')">
                            <?php echo e($lbl); ?>

                        </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>

            <div class="htc-kpis">
                <div class="htc-kpi">
                    <div class="htc-kpi-label">Tasa actual</div>
                    <div class="htc-kpi-value" style="color:<?php echo e($selColor); ?>;">
                        <?php echo e(number_format($datos['actual'], 4)); ?>

                    </div>
                    <div class="htc-kpi-sub">PEN → <?php echo e($moneda); ?></div>
                </div>
                <div class="htc-kpi">
                    <div class="htc-kpi-label">Máximo</div>
                    <div class="htc-kpi-value" style="color:#22c55e;"><?php echo e(number_format($datos['maximo'], 4)); ?></div>
                    <div class="htc-kpi-sub">en el período</div>
                </div>
                <div class="htc-kpi">
                    <div class="htc-kpi-label">Mínimo</div>
                    <div class="htc-kpi-value" style="color:#ef4444;"><?php echo e(number_format($datos['minimo'], 4)); ?></div>
                    <div class="htc-kpi-sub">en el período</div>
                </div>
                <div class="htc-kpi">
                    <div class="htc-kpi-label">Variación</div>
                    <div class="htc-kpi-value" style="color:<?php echo e($datos['variacion'] >= 0 ? '#22c55e' : '#ef4444'); ?>;">
                        <?php echo e($datos['variacion'] >= 0 ? '+' : ''); ?><?php echo e($datos['variacion']); ?>%
                    </div>
                    <div class="htc-kpi-sub">vs inicio del período</div>
                </div>
            </div>

            <div class="htc-chart-wrap">
                <canvas id="htcChart"></canvas>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function() {
            const labels = <?php echo json_encode($datos['labels'], 15, 512) ?>;
            const valores = <?php echo json_encode($datos['valores'], 15, 512) ?>;
            const color = <?php echo json_encode($selColor, 15, 512) ?>;

            const ctx = document.getElementById('htcChart');
            if (!ctx) return;

            if (window._htcChart) window._htcChart.destroy();

            window._htcChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Tasa PEN → <?php echo e($moneda); ?>',
                        data: valores,
                        borderColor: color,
                        backgroundColor: color + '18',
                        borderWidth: 2,
                        pointRadius: labels.length <= 15 ? 4 : 2,
                        pointBackgroundColor: color,
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ' ' + ctx.parsed.y.toFixed(4) + ' ' + '<?php echo e($moneda); ?>',
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255,255,255,0.04)'
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 10
                                }
                            },
                        },
                        y: {
                            grid: {
                                color: 'rgba(255,255,255,0.04)'
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 10
                                },
                                callback: v => v.toFixed(4),
                            },
                        }
                    }
                }
            });

            document.addEventListener('livewire:navigated', () => {
                if (window._htcChart) window._htcChart.destroy();
            });
        })();
    </script>
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/historial-tipos-cambio.blade.php ENDPATH**/ ?>
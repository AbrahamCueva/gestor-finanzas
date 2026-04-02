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

        .rcc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .rcc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .rcc-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .rcc-filtros {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .rcc-input {
            font-size: 0.85rem;
            padding: 0.5rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-text);
            outline: none;
        }

        .rcc-input:focus {
            border-color: #fbbf24;
        }

        .rcc-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:768px) {
            .rcc-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .rcc-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .rcc-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .rcc-kpi-value {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .rcc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .rcc-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .rcc-table td {
            padding: 0.625rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
            vertical-align: middle;
        }

        .rcc-table tr:last-child td {
            border-bottom: none;
        }

        .rcc-table tr:hover td {
            background: var(--w-card);
        }

        .rcc-table tfoot td {
            font-weight: 800;
            color: var(--w-text);
            background: var(--w-card);
            border-top: 2px solid var(--w-border);
        }

        .rcc-bar-wrap {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rcc-bar-track {
            flex: 1;
            height: 4px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
            min-width: 60px;
        }

        .rcc-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: #fbbf24;
        }

        .rcc-chart-wrap {
            position: relative;
            height: 280px;
        }
    </style>

    <div class="rcc-wrap">

        <div class="rcc-card">
            <div class="rcc-filtros">
                <div>
                    <div style="font-size:0.65rem; color:var(--w-muted); margin-bottom:0.25rem;">Desde</div>
                    <input type="date" wire:model.live="desde" class="rcc-input">
                </div>
                <div>
                    <div style="font-size:0.65rem; color:var(--w-muted); margin-bottom:0.25rem;">Hasta</div>
                    <input type="date" wire:model.live="hasta" class="rcc-input">
                </div>
                <div style="font-size:0.72rem; color:var(--w-muted); margin-top:1.25rem;">
                    <?php echo e(\Carbon\Carbon::parse($datos['desde'])->format('d/m/Y')); ?> —
                    <?php echo e(\Carbon\Carbon::parse($datos['hasta'])->format('d/m/Y')); ?>

                </div>
            </div>
        </div>

        <div class="rcc-card">
            <div class="rcc-title">📊 Totales del período</div>
            <div class="rcc-kpis">
                <div class="rcc-kpi">
                    <div class="rcc-kpi-label">Saldo total</div>
                    <div class="rcc-kpi-value" style="color:#fbbf24;">S/ <?php echo e(number_format($datos['totalSaldo'], 2)); ?>

                    </div>
                </div>
                <div class="rcc-kpi">
                    <div class="rcc-kpi-label">Ingresos</div>
                    <div class="rcc-kpi-value" style="color:#22c55e;">S/ <?php echo e(number_format($datos['totalIngresos'], 2)); ?>

                    </div>
                </div>
                <div class="rcc-kpi">
                    <div class="rcc-kpi-label">Egresos</div>
                    <div class="rcc-kpi-value" style="color:#ef4444;">S/ <?php echo e(number_format($datos['totalEgresos'], 2)); ?>

                    </div>
                </div>
                <div class="rcc-kpi">
                    <div class="rcc-kpi-label">Ahorro neto</div>
                    <div class="rcc-kpi-value" style="color:<?php echo e($datos['totalAhorro'] >= 0 ? '#60a5fa' : '#f97316'); ?>;">
                        S/ <?php echo e(number_format($datos['totalAhorro'], 2)); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="rcc-card">
            <div class="rcc-title">📈 Comparativo visual</div>
            <div class="rcc-chart-wrap">
                <canvas id="rccChart"></canvas>
            </div>
        </div>

        <div class="rcc-card">
            <div class="rcc-title">🏦 Detalle por cuenta</div>
            <div style="overflow-x:auto;">
                <table class="rcc-table">
                    <thead>
                        <tr>
                            <th>Cuenta</th>
                            <th>Tipo</th>
                            <th>Saldo actual</th>
                            <th>% del total</th>
                            <th>Ingresos</th>
                            <th>Egresos</th>
                            <th>Ahorro</th>
                            <th>Transf.</th>
                            <th>Movs.</th>
                            <th>Top categoría</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $datos['datos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fila): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td style="font-weight:700; color:var(--w-text);"><?php echo e($fila['cuenta']->nombre); ?></td>
                                <td style="color:var(--w-muted); text-transform:capitalize;">
                                    <?php echo e($fila['cuenta']->tipo_cuenta); ?></td>
                                <td style="font-weight:700; color:#fbbf24;">S/
                                    <?php echo e(number_format($fila['cuenta']->saldo_actual, 2)); ?></td>
                                <td>
                                    <div class="rcc-bar-wrap">
                                        <div class="rcc-bar-track">
                                            <div class="rcc-bar-fill" style="width:<?php echo e($fila['pctSaldo']); ?>%;"></div>
                                        </div>
                                        <span
                                            style="font-size:0.72rem; font-weight:700; color:var(--w-muted); min-width:36px;"><?php echo e($fila['pctSaldo']); ?>%</span>
                                    </div>
                                </td>
                                <td style="color:#22c55e; font-weight:600;">S/
                                    <?php echo e(number_format($fila['ingresos'], 2)); ?></td>
                                <td style="color:#ef4444; font-weight:600;">S/ <?php echo e(number_format($fila['egresos'], 2)); ?>

                                </td>
                                <td style="color:<?php echo e($fila['ahorro'] >= 0 ? '#60a5fa' : '#f97316'); ?>; font-weight:600;">
                                    <?php echo e($fila['ahorro'] >= 0 ? '+' : ''); ?>S/ <?php echo e(number_format($fila['ahorro'], 2)); ?>

                                </td>
                                <td style="color:var(--w-muted); font-size:0.72rem;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fila['transferSalida'] > 0): ?>
                                        <span style="color:#f97316;">↑ S/
                                            <?php echo e(number_format($fila['transferSalida'], 2)); ?></span><br>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fila['transferEntrada'] > 0): ?>
                                        <span style="color:#60a5fa;">↓ S/
                                            <?php echo e(number_format($fila['transferEntrada'], 2)); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fila['transferSalida'] == 0 && $fila['transferEntrada'] == 0): ?>
                                        —
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td style="text-align:center; font-weight:600;"><?php echo e($fila['movimientos']); ?></td>
                                <td style="color:var(--w-muted); font-size:0.72rem;"><?php echo e($fila['topCategoria']); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">TOTAL</td>
                            <td>S/ <?php echo e(number_format($datos['totalSaldo'], 2)); ?></td>
                            <td>100%</td>
                            <td style="color:#22c55e;">S/ <?php echo e(number_format($datos['totalIngresos'], 2)); ?></td>
                            <td style="color:#ef4444;">S/ <?php echo e(number_format($datos['totalEgresos'], 2)); ?></td>
                            <td style="color:<?php echo e($datos['totalAhorro'] >= 0 ? '#60a5fa' : '#f97316'); ?>;">
                                S/ <?php echo e(number_format($datos['totalAhorro'], 2)); ?>

                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function() {
            const datos = <?php echo json_encode($datos['datos'], 15, 512) ?>;
            const ctx = document.getElementById('rccChart');
            if (!ctx || !datos.length) return;

            if (window._rccChart) window._rccChart.destroy();

            window._rccChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: datos.map(d => d.cuenta.nombre),
                    datasets: [{
                            label: 'Saldo actual',
                            data: datos.map(d => d.cuenta.saldo_actual),
                            backgroundColor: '#fbbf2488',
                            borderColor: '#fbbf24',
                            borderWidth: 1.5,
                            borderRadius: 4,
                        },
                        {
                            label: 'Ingresos',
                            data: datos.map(d => d.ingresos),
                            backgroundColor: '#22c55e88',
                            borderColor: '#22c55e',
                            borderWidth: 1.5,
                            borderRadius: 4,
                        },
                        {
                            label: 'Egresos',
                            data: datos.map(d => d.egresos),
                            backgroundColor: '#ef444488',
                            borderColor: '#ef4444',
                            borderWidth: 1.5,
                            borderRadius: 4,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#6b7280',
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.dataset.label}: S/ ${ctx.parsed.y.toFixed(2)}`
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
                                    size: 11
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
                                    size: 11
                                },
                                callback: v => 'S/ ' + v.toLocaleString(),
                            },
                        }
                    }
                }
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/reporte-comparativo-cuentas.blade.php ENDPATH**/ ?>
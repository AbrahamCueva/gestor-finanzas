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
        $resumen = $this->getResumenCategorias();
        $detalle = $this->getDetalleCat();
        $cats = $this->getCategorias();
        $maxTotal = collect($resumen)->max('total') ?: 1;
    ?>

    <style>
        :root {
            --bg: rgba(0, 0, 0, 0.04);
            --card: rgba(0, 0, 0, 0.05);
            --text: #111827;
            --soft: #374151;
            --muted: #6b7280;
            --border: rgba(0, 0, 0, 0.08);
            --gold: #fbbf24;
            --green: #22c55e;
            --red: #ef4444;
            --blue: #60a5fa;
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
        }

        .ac {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ac-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ac-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Toolbar */
        .ac-toolbar {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .ac-select {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: .625rem;
            padding: .45rem .875rem;
            font-size: .825rem;
            color: var(--text);
            outline: none;
            cursor: pointer;
        }

        .ac-select:focus {
            border-color: var(--gold);
        }

        .ac-tipo-btns {
            display: flex;
            gap: .3rem;
        }

        .ac-tipo-btn {
            padding: .3rem .875rem;
            border-radius: 99px;
            font-size: .72rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            background: var(--card);
            color: var(--muted);
            transition: all .15s;
        }

        .ac-tipo-btn.on-egreso {
            background: rgba(239, 68, 68, .12);
            color: var(--red);
        }

        .ac-tipo-btn.on-ingreso {
            background: rgba(34, 197, 94, .12);
            color: var(--green);
        }

        /* Grid categorías */
        .ac-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: .625rem;
        }

        @media(max-width:768px) {
            .ac-grid {
                grid-template-columns: 1fr;
            }
        }

        .ac-cat-card {
            background: var(--card);
            border-radius: .875rem;
            padding: .875rem 1rem;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: all .15s;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }

        .ac-cat-card:hover {
            border-color: rgba(251, 191, 36, .2);
        }

        .ac-cat-card.activo {
            border-color: rgba(251, 191, 36, .4);
            background: rgba(251, 191, 36, .05);
        }

        .ac-cat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ac-cat-nombre {
            font-size: .825rem;
            font-weight: 700;
            color: var(--text);
        }

        .ac-cat-total {
            font-size: .9rem;
            font-weight: 900;
        }

        .ac-cat-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .68rem;
            color: var(--muted);
        }

        .ac-bar-wrap {
            height: 4px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .ac-bar-fill {
            height: 100%;
            border-radius: 99px;
        }

        .ac-tend {
            font-size: .65rem;
            font-weight: 700;
            padding: .1rem .4rem;
            border-radius: 3px;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }

        /* Detalle */
        .ac-detalle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: .375rem;
        }

        .ac-mes-item {
            background: var(--card);
            border-radius: .5rem;
            padding: .5rem;
            text-align: center;
        }

        .ac-mes-nombre {
            font-size: .58rem;
            color: var(--muted);
        }

        .ac-mes-valor {
            font-size: .78rem;
            font-weight: 800;
            margin: .1rem 0;
        }

        .ac-mes-conteo {
            font-size: .58rem;
            color: var(--muted);
        }

        .ac-chart-wrap {
            position: relative;
            height: 220px;
        }
    </style>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

    <div class="ac">

        
        <div class="ac-card">
            <div class="ac-toolbar">
                <div class="ac-tipo-btns">
                    <button class="ac-tipo-btn <?php echo e($tipo === 'egreso' ? 'on-egreso' : ''); ?>"
                        wire:click="$set('tipo','egreso')">🔴 Egresos</button>
                    <button class="ac-tipo-btn <?php echo e($tipo === 'ingreso' ? 'on-ingreso' : ''); ?>"
                        wire:click="$set('tipo','ingreso')">🟢 Ingresos</button>
                </div>

                <select wire:model.live="meses" class="ac-select">
                    <option value="3">Últimos 3 meses</option>
                    <option value="6">Últimos 6 meses</option>
                    <option value="12">Último año</option>
                </select>

                <select wire:model.live="categoriaId" class="ac-select">
                    <option value="0">— Ver detalle de categoría —</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($nombre); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
        </div>

        
        <div class="ac-card">
            <div class="ac-title">🏷️ Ranking de categorías — últimos <?php echo e($meses); ?> meses</div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($resumen) > 0): ?>
                <div class="ac-grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $resumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $color = $cat['color'] ?? '#6b7280';
                            $tendColor =
                                $cat['tendencia'] > 0 ? '#ef4444' : ($cat['tendencia'] < 0 ? '#22c55e' : '#6b7280');
                            $tendEmoji = $cat['tendencia'] > 0 ? '↑' : ($cat['tendencia'] < 0 ? '↓' : '→');
                            $esActivo = $categoriaId == $cat['id'];
                        ?>
                        <div class="ac-cat-card <?php echo e($esActivo ? 'activo' : ''); ?>"
                            wire:click="$set('categoriaId', <?php echo e($cat['id']); ?>)">

                            <div class="ac-cat-header">
                                <div class="ac-cat-nombre"><?php echo e($cat['nombre']); ?></div>
                                <div class="ac-cat-total"
                                    style="color:<?php echo e($tipo === 'egreso' ? '#ef4444' : '#22c55e'); ?>;">
                                    S/ <?php echo e(number_format($cat['total'], 0)); ?>

                                </div>
                            </div>

                            <div class="ac-bar-wrap">
                                <div class="ac-bar-fill"
                                    style="width:<?php echo e(($cat['total'] / $maxTotal) * 100); ?>%; background:<?php echo e($color); ?>;">
                                </div>
                            </div>

                            <div class="ac-cat-row">
                                <span><?php echo e($cat['pct']); ?>% del total</span>
                                <span><?php echo e($cat['conteo']); ?> movimientos</span>
                                <span class="ac-tend"
                                    style="background:<?php echo e($tendColor); ?>18; color:<?php echo e($tendColor); ?>;">
                                    <?php echo e($tendEmoji); ?> <?php echo e(abs($cat['tendencia'])); ?>%
                                </span>
                            </div>

                            <div class="ac-cat-row">
                                <span>Prom/mes: S/ <?php echo e(number_format($cat['promMensual'], 2)); ?></span>
                                <span>Prom/mov: S/ <?php echo e(number_format($cat['promPorMov'], 2)); ?></span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php else: ?>
                <div style="text-align:center; color:var(--muted); padding:2rem;">Sin datos para este período.</div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categoriaId > 0 && count($detalle) > 0): ?>
            <div class="ac-card">
                <div class="ac-title">
                    📊 Detalle — <?php echo e($detalle['categoria']->nombre); ?>

                    <span style="color:var(--muted); font-weight:400;">· Promedio S/
                        <?php echo e(number_format($detalle['promedio'], 2)); ?>/mes</span>
                </div>

                
                <div class="ac-chart-wrap" style="margin-bottom:1rem;" wire:ignore>
                    <canvas id="acChart"></canvas>
                </div>

                
                <div class="ac-detalle-grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalle['meses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php $altura = $detalle['max'] > 0 ? ($m['total'] / $detalle['max']) * 100 : 0; ?>
                        <div class="ac-mes-item">
                            <div class="ac-mes-nombre"><?php echo e($m['mes']); ?></div>
                            <div class="ac-mes-valor" style="color:<?php echo e($tipo === 'egreso' ? '#ef4444' : '#22c55e'); ?>;">
                                <?php echo e($m['total'] > 0 ? 'S/' . number_format($m['total'], 0) : '—'); ?>

                            </div>
                            <div class="ac-mes-conteo"><?php echo e($m['conteo']); ?> movs.</div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                
                <div style="margin-top:1rem;">
                    <div
                        style="font-size:.65rem; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.5rem;">
                        Top subcategorías por mes</div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalle['meses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($m['topSub'] !== '—'): ?>
                            <div
                                style="display:flex; gap:.5rem; font-size:.7rem; margin-bottom:.3rem; padding:.375rem .625rem; background:var(--card); border-radius:.375rem;">
                                <span
                                    style="font-weight:700; color:var(--text); min-width:60px;"><?php echo e($m['mes']); ?></span>
                                <span style="color:var(--muted);"><?php echo e($m['topSub']); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    <script>
        (function() {
            let acChart;

            function renderAcChart(meses, tipo) {
                // Esperar a que Chart.js esté disponible
                if (typeof Chart === 'undefined') {
                    setTimeout(() => renderAcChart(meses, tipo), 100);
                    return;
                }

                const ctx = document.getElementById('acChart');
                if (!ctx) return;

                if (acChart) {
                    acChart.destroy();
                    acChart = null;
                }

                const color = tipo === 'egreso' ? '#ef4444' : '#22c55e';

                acChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: meses.map(m => m.mes),
                        datasets: [{
                            label: 'Monto mensual',
                            data: meses.map(m => m.total),
                            backgroundColor: color + '55',
                            borderColor: color,
                            borderWidth: 2,
                            borderRadius: 6,
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
                                backgroundColor: 'rgba(15,23,42,.95)',
                                titleColor: '#f1f5f9',
                                bodyColor: '#cbd5e1',
                                callbacks: {
                                    label: c =>
                                        ` S/ ${c.parsed.y.toLocaleString(undefined, { minimumFractionDigits: 2 })}`
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255,255,255,.05)'
                                },
                                ticks: {
                                    color: '#6b7280',
                                    callback: v => 'S/ ' + v
                                }
                            }
                        }
                    }
                });
            }

            // Escuchar evento dispatch de Livewire
            document.addEventListener('livewire:init', () => {
                Livewire.on('updateCatChart', (data) => {
                    // Livewire v3 pasa los datos como array, el primer elemento es el payload
                    const payload = Array.isArray(data) ? data[0] : data;
                    setTimeout(() => renderAcChart(payload.meses, payload.tipo), 80);
                });
            });

            // Primera carga (cuando el canvas ya existe en el HTML inicial)
            document.addEventListener('DOMContentLoaded', () => {
                const initialMeses = <?php echo json_encode($detalle['meses'] ?? [], 15, 512) ?>;
                const initialTipo = <?php echo json_encode($tipo, 15, 512) ?>;
                if (initialMeses.length > 0 && document.getElementById('acChart')) {
                    renderAcChart(initialMeses, initialTipo);
                }
            });

            // Para cuando Livewire re-renderiza y el canvas aparece en el DOM
            document.addEventListener('livewire:navigated', () => {
                const initialMeses = <?php echo json_encode($detalle['meses'] ?? [], 15, 512) ?>;
                const initialTipo = <?php echo json_encode($tipo, 15, 512) ?>;
                if (initialMeses.length > 0 && document.getElementById('acChart')) {
                    setTimeout(() => renderAcChart(initialMeses, initialTipo), 80);
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/analisis-categorias.blade.php ENDPATH**/ ?>
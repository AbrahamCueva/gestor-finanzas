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

    <?php $d = $this->getDatos(); ?>

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
            --purple: #a78bfa;
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
        }

        .pc {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .pc-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .pc-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .pc-toolbar {
            display: flex;
            gap: .5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .pc-hist-btn {
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

        .pc-hist-btn.on {
            background: rgba(251, 191, 36, .15);
            color: var(--gold);
        }

        .pc-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .625rem;
        }

        @media(max-width:768px) {
            .pc-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .pc-kpi {
            background: var(--card);
            border-radius: .75rem;
            padding: .75rem;
        }

        .pc-kpi-label {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .2rem;
        }

        .pc-kpi-value {
            font-size: 1rem;
            font-weight: 900;
        }

        .pc-kpi-sub {
            font-size: .6rem;
            color: var(--muted);
            margin-top: .1rem;
        }

        .pc-alerta {
            display: flex;
            align-items: center;
            gap: .75rem;
            background: rgba(239, 68, 68, .08);
            border: 1px solid rgba(239, 68, 68, .2);
            border-radius: .75rem;
            padding: .75rem 1rem;
            margin-bottom: .5rem;
            font-size: .775rem;
        }

        .pc-alerta-emoji {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .pc-alerta-titulo {
            font-weight: 700;
            color: #ef4444;
        }

        .pc-alerta-desc {
            font-size: .68rem;
            color: var(--muted);
            margin-top: .1rem;
        }

        .pc-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .75rem;
        }

        @media(max-width:1024px) {
            .pc-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:640px) {
            .pc-grid {
                grid-template-columns: 1fr;
            }
        }

        .pc-pred-card {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
            border-left: 3px solid;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }

        .pc-pred-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pc-pred-nombre {
            font-size: .825rem;
            font-weight: 700;
            color: var(--text);
        }

        .pc-pred-tend {
            font-size: .62rem;
            font-weight: 700;
            padding: .1rem .4rem;
            border-radius: 3px;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }

        .pc-pred-valor {
            font-size: 1.1rem;
            font-weight: 900;
        }

        .pc-pred-sub {
            font-size: .65rem;
            color: var(--muted);
            margin-top: -.2rem;
        }

        .pc-prog-wrap {
            margin: .25rem 0;
        }

        .pc-prog-labels {
            display: flex;
            justify-content: space-between;
            font-size: .58rem;
            color: var(--muted);
            margin-bottom: .2rem;
        }

        .pc-prog-track {
            height: 6px;
            background: var(--border);
            border-radius: 99px;
            position: relative;
            overflow: visible;
        }

        .pc-prog-actual {
            height: 100%;
            border-radius: 99px;
        }

        .pc-prog-pred {
            position: absolute;
            top: -2px;
            height: 10px;
            width: 2px;
            background: var(--gold);
            border-radius: 99px;
            box-shadow: 0 0 4px rgba(251, 191, 36, .5);
        }

        .pc-pred-footer {
            display: flex;
            justify-content: space-between;
            font-size: .65rem;
        }

        .pc-pred-confianza {
            display: flex;
            align-items: center;
            gap: .2rem;
        }

        .pc-pred-confianza-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .pc-sparkline {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 28px;
            margin-top: .25rem;
        }

        .pc-spark-bar {
            flex: 1;
            border-radius: 2px 2px 0 0;
            min-height: 2px;
        }

        .pc-chart-wrap {
            position: relative;
            height: 280px;
        }
    </style>

    <div class="pc">

        
        <div class="pc-card">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.75rem;">
                <div>
                    <div style="font-size:.875rem; font-weight:800; color:var(--text);">
                        Predicción para <?php echo e($d['mesActual']); ?>

                    </div>
                    <div style="font-size:.7rem; color:var(--muted); margin-top:.1rem;">
                        Día <?php echo e($d['diaActual']); ?> de <?php echo e($d['diasMes']); ?> · <?php echo e($d['diasRestantes']); ?> días restantes
                    </div>
                </div>
                <div class="pc-toolbar">
                    <span style="font-size:.65rem; color:var(--muted);">Historial:</span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [3 => '3 meses', 6 => '6 meses', 12 => '1 año']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <button class="pc-hist-btn <?php echo e($mesesHistorial == $v ? 'on' : ''); ?>"
                            wire:click="$set('mesesHistorial', <?php echo e($v); ?>)"><?php echo e($label); ?></button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="pc-card">
            <div class="pc-kpis">
                <div class="pc-kpi">
                    <div class="pc-kpi-label">Gastado este mes</div>
                    <div class="pc-kpi-value" style="color:var(--red);">S/ <?php echo e(number_format($d['gastoActualMes'], 2)); ?>

                    </div>
                    <div class="pc-kpi-sub">al día <?php echo e($d['diaActual']); ?></div>
                </div>
                <div class="pc-kpi">
                    <div class="pc-kpi-label">Predicción total</div>
                    <div class="pc-kpi-value" style="color:var(--gold);">S/ <?php echo e(number_format($d['gastoPredTotal'], 2)); ?>

                    </div>
                    <div class="pc-kpi-sub">al cierre del mes</div>
                </div>
                <div class="pc-kpi">
                    <div class="pc-kpi-label">Categorías analizadas</div>
                    <div class="pc-kpi-value"><?php echo e(count($d['predicciones'])); ?></div>
                    <div class="pc-kpi-sub">con datos históricos</div>
                </div>
                <div class="pc-kpi">
                    <div class="pc-kpi-label">Alertas de alza</div>
                    <div class="pc-kpi-value"
                        style="color:<?php echo e(count($d['alertas']) > 0 ? 'var(--red)' : 'var(--green)'); ?>;">
                        <?php echo e(count($d['alertas'])); ?>

                    </div>
                    <div class="pc-kpi-sub">categorías subiendo</div>
                </div>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($d['alertas']) > 0): ?>
            <div class="pc-card">
                <div class="pc-title">⚠️ Alertas — categorías con tendencia al alza</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $d['alertas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alerta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="pc-alerta">
                        <div class="pc-alerta-emoji">📈</div>
                        <div>
                            <div class="pc-alerta-titulo"><?php echo e($alerta['nombre']); ?></div>
                            <div class="pc-alerta-desc">
                                Se predice S/ <?php echo e(number_format($alerta['prediccion'], 2)); ?> este mes,
                                un <?php echo e($alerta['pctDiferencia']); ?>% más que tu promedio de S/
                                <?php echo e(number_format($alerta['promedio'], 2)); ?>.
                                Gasto diario actual: S/ <?php echo e(number_format($alerta['gastoDiario'], 2)); ?>/día.
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="pc-card">
            <div class="pc-title">📊 Predicción vs promedio histórico por categoría</div>
            <div class="pc-chart-wrap" wire:ignore>
                <canvas id="pcChart"></canvas>
            </div>
        </div>

        
        <div class="pc-card">
            <div class="pc-title">🔮 Predicción por categoría</div>
            <div class="pc-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $d['predicciones']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pred): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $color = $pred['color'] ?? '#6b7280';
                        $tendConf = match ($pred['tendencia']) {
                            'subiendo' => ['emoji' => '↑', 'color' => '#ef4444', 'bg' => 'rgba(239,68,68,.12)'],
                            'bajando' => ['emoji' => '↓', 'color' => '#22c55e', 'bg' => 'rgba(34,197,94,.12)'],
                            default => ['emoji' => '→', 'color' => '#6b7280', 'bg' => 'rgba(107,114,128,.12)'],
                        };
                        $confColor = match ($pred['confianza']) {
                            'alta' => '#22c55e',
                            'media' => '#fbbf24',
                            default => '#ef4444',
                        };
                        $maxVal = max($pred['prediccion'], $pred['gastoActual'], $pred['promedio'], 1);
                        $pctActual = min(100, ($pred['gastoActual'] / $maxVal) * 100);
                        $pctPred = min(100, ($pred['prediccion'] / $maxVal) * 100);
                        $maxSpark = max(max($pred['historial'] ?: [0]), $pred['prediccion'], 1);
                    ?>
                    <div class="pc-pred-card" style="border-color:<?php echo e($color); ?>;">
                        <div class="pc-pred-header">
                            <div class="pc-pred-nombre"><?php echo e($pred['nombre']); ?></div>
                            <span class="pc-pred-tend"
                                style="background:<?php echo e($tendConf['bg']); ?>; color:<?php echo e($tendConf['color']); ?>;">
                                <?php echo e($tendConf['emoji']); ?> <?php echo e(ucfirst($pred['tendencia'])); ?>

                            </span>
                        </div>
                        <div>
                            <div class="pc-pred-valor" style="color:<?php echo e($color); ?>;">S/
                                <?php echo e(number_format($pred['prediccion'], 2)); ?></div>
                            <div class="pc-pred-sub">predicción al cierre</div>
                        </div>
                        <div class="pc-prog-wrap">
                            <div class="pc-prog-labels">
                                <span>Actual: S/ <?php echo e(number_format($pred['gastoActual'], 0)); ?></span>
                                <span>Pred: S/ <?php echo e(number_format($pred['prediccion'], 0)); ?></span>
                            </div>
                            <div class="pc-prog-track">
                                <div class="pc-prog-actual"
                                    style="width:<?php echo e($pctActual); ?>%; background:<?php echo e($color); ?>88;"></div>
                                <div class="pc-prog-pred" style="left:<?php echo e($pctPred); ?>%;"></div>
                            </div>
                        </div>
                        <div class="pc-sparkline">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pred['historial']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php $altura = $maxSpark > 0 ? max(4, ($h / $maxSpark) * 100) : 4; ?>
                                <div class="pc-spark-bar"
                                    style="height:<?php echo e($altura); ?>%; background:<?php echo e($color); ?>66;"></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php $alturaPred = $maxSpark > 0 ? max(4, ($pred['prediccion'] / $maxSpark) * 100) : 4; ?>
                            <div class="pc-spark-bar"
                                style="height:<?php echo e($alturaPred); ?>%; background:<?php echo e($color); ?>; border:1px dashed <?php echo e($color); ?>;">
                            </div>
                        </div>
                        <div class="pc-pred-footer">
                            <div>
                                <span style="font-size:.62rem; color:var(--muted);">Prom: </span>
                                <span style="font-size:.68rem; font-weight:700; color:var(--text);">S/
                                    <?php echo e(number_format($pred['promedio'], 0)); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pred['pctDiferencia'] != 0): ?>
                                    <span
                                        style="font-size:.6rem; color:<?php echo e($pred['pctDiferencia'] > 0 ? 'var(--red)' : 'var(--green)'); ?>;">
                                        (<?php echo e($pred['pctDiferencia'] > 0 ? '+' : ''); ?><?php echo e($pred['pctDiferencia']); ?>%)
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="pc-pred-confianza">
                                <div class="pc-pred-confianza-dot" style="background:<?php echo e($confColor); ?>;"></div>
                                <span
                                    style="font-size:.6rem; color:<?php echo e($confColor); ?>;"><?php echo e(ucfirst($pred['confianza'])); ?></span>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function() {
            function renderPcChart(predicciones) {
                if (typeof Chart === 'undefined') {
                    setTimeout(function() {
                        renderPcChart(predicciones);
                    }, 100);
                    return;
                }
                var ctx = document.getElementById('pcChart');
                if (!ctx || !predicciones.length) return;

                if (window._pcChart instanceof Chart) {
                    window._pcChart.destroy();
                    window._pcChart = null;
                }

                var top10 = predicciones.slice(0, 10);

                window._pcChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: top10.map(function(p) {
                            return p.nombre;
                        }),
                        datasets: [{
                                label: 'Gastado este mes',
                                data: top10.map(function(p) {
                                    return p.gastoActual;
                                }),
                                backgroundColor: top10.map(function(p) {
                                    return (p.color || '#6b7280') + '88';
                                }),
                                borderColor: top10.map(function(p) {
                                    return p.color || '#6b7280';
                                }),
                                borderWidth: 1.5,
                                borderRadius: 3,
                            },
                            {
                                label: 'Predicción al cierre',
                                data: top10.map(function(p) {
                                    return p.prediccion;
                                }),
                                backgroundColor: 'rgba(251,191,36,.2)',
                                borderColor: '#fbbf24',
                                borderWidth: 1.5,
                                borderRadius: 3,
                                type: 'bar',
                            },
                            {
                                label: 'Promedio histórico',
                                data: top10.map(function(p) {
                                    return p.promedio;
                                }),
                                type: 'line',
                                borderColor: '#6b7280',
                                backgroundColor: 'transparent',
                                borderWidth: 1.5,
                                borderDash: [5, 5],
                                pointRadius: 4,
                                pointBackgroundColor: '#6b7280',
                                tension: 0,
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
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
                                backgroundColor: 'rgba(15,23,42,.9)',
                                titleColor: '#f1f5f9',
                                bodyColor: '#94a3b8',
                                callbacks: {
                                    label: function(c) {
                                        return ' ' + c.dataset.label + ': S/ ' + c.parsed.y.toFixed(2);
                                    }
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
                                    },
                                    maxRotation: 30
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(255,255,255,.04)'
                                },
                                ticks: {
                                    color: '#6b7280',
                                    callback: function(v) {
                                        return 'S/' + v;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Primera carga
            renderPcChart(<?php echo \Illuminate\Support\Js::from($d['predicciones'])->toHtml() ?>);

            // Actualizaciones via dispatch
            document.addEventListener('livewire:init', function() {
                Livewire.on('updatePcChart', function(data) {
                    var payload = Array.isArray(data) ? data[0] : data;
                    setTimeout(function() {
                        renderPcChart(payload.predicciones);
                    }, 80);
                });
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/prediccion-categorias.blade.php ENDPATH**/ ?>
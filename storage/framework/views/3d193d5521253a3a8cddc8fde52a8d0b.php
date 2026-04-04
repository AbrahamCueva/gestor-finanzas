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
            --orange: #f97316;
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

        .gh {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .gh-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .gh-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Toolbar */
        .gh-toolbar {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .gh-control {
            display: flex;
            flex-direction: column;
            gap: .375rem;
        }

        .gh-control-label {
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
        }

        .gh-control-valor {
            font-size: .78rem;
            font-weight: 800;
            color: var(--gold);
        }

        .gh-slider {
            width: 160px;
            height: 4px;
            background: var(--border);
            border-radius: 99px;
            appearance: none;
            outline: none;
            cursor: pointer;
        }

        .gh-slider::-webkit-slider-thumb {
            appearance: none;
            width: 14px;
            height: 14px;
            background: var(--gold);
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid rgba(0, 0, 0, .2);
        }

        .gh-period-btns {
            display: flex;
            gap: .3rem;
        }

        .gh-period-btn {
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

        .gh-period-btn.on {
            background: rgba(251, 191, 36, .15);
            color: var(--gold);
        }

        /* KPIs */
        .gh-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .625rem;
        }

        @media(max-width:768px) {
            .gh-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .gh-kpi {
            background: var(--card);
            border-radius: .75rem;
            padding: .875rem 1rem;
        }

        .gh-kpi-label {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .25rem;
        }

        .gh-kpi-value {
            font-size: 1.1rem;
            font-weight: 900;
        }

        .gh-kpi-sub {
            font-size: .62rem;
            color: var(--muted);
            margin-top: .15rem;
        }

        /* Info banner */
        .gh-info {
            background: rgba(96, 165, 250, .07);
            border: 1px solid rgba(96, 165, 250, .15);
            border-radius: .875rem;
            padding: .875rem 1rem;
            display: flex;
            gap: .75rem;
            align-items: flex-start;
            font-size: .775rem;
            color: var(--soft);
            line-height: 1.5;
        }

        /* Top items */
        .gh-top-item {
            background: var(--card);
            border-radius: .875rem;
            padding: .875rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: .5rem;
            transition: all .15s;
        }

        .gh-top-item:hover {
            background: rgba(251, 191, 36, .04);
        }

        .gh-top-rank {
            font-size: 1.25rem;
            width: 32px;
            text-align: center;
            flex-shrink: 0;
        }

        .gh-top-nombre {
            font-size: .825rem;
            font-weight: 700;
            color: var(--text);
        }

        .gh-top-cat {
            font-size: .65rem;
            color: var(--muted);
            margin-top: .1rem;
        }

        .gh-top-stats {
            margin-left: auto;
            display: flex;
            gap: 1.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .gh-top-stat {
            text-align: right;
        }

        .gh-top-stat-val {
            font-size: .875rem;
            font-weight: 800;
        }

        .gh-top-stat-lbl {
            font-size: .58rem;
            color: var(--muted);
            text-transform: uppercase;
        }

        /* Badges */
        .gh-badge {
            padding: .15rem .5rem;
            border-radius: 99px;
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .gh-badge-critico {
            background: rgba(239, 68, 68, .12);
            color: #ef4444;
        }

        .gh-badge-alto {
            background: rgba(249, 115, 22, .12);
            color: #f97316;
        }

        .gh-badge-medio {
            background: rgba(251, 191, 36, .12);
            color: #fbbf24;
        }

        .gh-badge-bajo {
            background: rgba(34, 197, 94, .12);
            color: #22c55e;
        }

        /* Charts */
        .gh-chart-wrap {
            position: relative;
            height: 250px;
        }

        /* Horas */
        .gh-horas-bars {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 100px;
        }

        .gh-hora-bar {
            flex: 1;
            border-radius: 3px 3px 0 0;
            min-height: 2px;
            transition: all .2s;
            cursor: default;
        }

        /* Grid */
        .gh-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media(max-width:900px) {
            .gh-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* Table */
        .gh-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .775rem;
        }

        .gh-table th {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .gh-table td {
            padding: .5rem .75rem;
            color: var(--soft);
            border-bottom: 1px solid var(--border);
        }

        .gh-table tr:last-child td {
            border-bottom: none;
        }

        .gh-table tr:hover td {
            background: var(--card);
        }

        /* Empty */
        .gh-empty {
            text-align: center;
            padding: 3rem;
            color: var(--muted);
        }

        .gh-empty-emoji {
            font-size: 2.5rem;
            margin-bottom: .75rem;
        }

        .gh-empty-title {
            font-size: .875rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .25rem;
        }
    </style>

    <div class="gh">

        
        <div class="gh-info">
            <span style="font-size:1.1rem; flex-shrink:0;">🐜</span>
            <div>
                <strong style="color:var(--text);">Detector de Gastos Hormiga</strong> —
                Identifica consumos pequeños pero recurrentes que afectan tu presupuesto.
                Analizamos tus movimientos para proyectar el impacto real a largo plazo.
            </div>
        </div>

        
        <div class="gh-card">
            <div class="gh-toolbar">
                <div class="gh-control">
                    <div class="gh-control-label">Período</div>
                    <div class="gh-period-btns">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [1 => '1 mes', 3 => '3 meses', 6 => '6 meses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <button class="gh-period-btn <?php echo e($meses == $v ? 'on' : ''); ?>"
                                wire:click="$set('meses', <?php echo e($v); ?>)"><?php echo e($label); ?></button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                <div class="gh-control">
                    <div class="gh-control-label">Monto máximo</div>
                    <div class="gh-control-valor">≤ S/ <?php echo e($montoMaximo); ?></div>
                    <input type="range" class="gh-slider" min="5" max="100" step="5"
                        wire:model.live.debounce.300ms="montoMaximo">
                </div>

                <div class="gh-control">
                    <div class="gh-control-label">Frecuencia mínima</div>
                    <div class="gh-control-valor">≥ <?php echo e($frecuenciaMin); ?> veces</div>
                    <input type="range" class="gh-slider" min="2" max="10" step="1"
                        wire:model.live.debounce.300ms="frecuenciaMin">
                </div>
            </div>
        </div>

        
        <div class="gh-kpis">
            <div class="gh-kpi">
                <div class="gh-kpi-label">Total gasto hormiga</div>
                <div class="gh-kpi-value" style="color:var(--red);">S/ <?php echo e(number_format($d['totalHormiga'], 2)); ?></div>
                <div class="gh-kpi-sub">en <?php echo e($d['meses']); ?> mes(es)</div>
            </div>
            <div class="gh-kpi">
                <div class="gh-kpi-label">Proyección anual</div>
                <div class="gh-kpi-value" style="color:var(--orange);">S/ <?php echo e(number_format($d['proyAnual'], 2)); ?></div>
                <div class="gh-kpi-sub">impacto en 12 meses</div>
            </div>
            <div class="gh-kpi">
                <div class="gh-kpi-label">Patrones detectados</div>
                <div class="gh-kpi-value" style="color:var(--gold);"><?php echo e($d['cantidadGrupos']); ?></div>
                <div class="gh-kpi-sub">grupos frecuentes</div>
            </div>
            <div class="gh-kpi">
                <div class="gh-kpi-label">Movimientos pequeños</div>
                <div class="gh-kpi-value">S/ <?php echo e(number_format($d['totalMovSmall'], 2)); ?></div>
                <div class="gh-kpi-sub">bajo S/ <?php echo e($montoMaximo); ?></div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($d['gastos'])): ?>
            <div class="gh-card gh-empty">
                <div class="gh-empty-emoji">🐜</div>
                <div class="gh-empty-title">Sin resultados</div>
                <div>No encontramos gastos que coincidan con estos filtros.</div>
            </div>
        <?php else: ?>
            
            <div class="gh-card">
                <div class="gh-title">🏆 Top 5 gastos hormiga</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $d['top5']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="gh-top-item">
                        <div class="gh-top-rank"><?php echo e(['🥇', '🥈', '🥉', '4️⃣', '5️⃣'][$i]); ?></div>
                        <div>
                            <div class="gh-top-nombre"><?php echo e($g['descripcion']); ?></div>
                            <div class="gh-top-cat"><?php echo e($g['categoria']); ?></div>
                        </div>
                        <div class="gh-top-stats">
                            <div class="gh-top-stat">
                                <div class="gh-top-stat-val" style="color:var(--red);">S/
                                    <?php echo e(number_format($g['total'], 2)); ?></div>
                                <div class="gh-top-stat-lbl">en <?php echo e($d['meses']); ?>m</div>
                            </div>
                            <div class="gh-top-stat">
                                <div class="gh-top-stat-val" style="color:var(--orange);">S/
                                    <?php echo e(number_format($g['proyeccionAnual'], 0)); ?></div>
                                <div class="gh-top-stat-lbl">al año</div>
                            </div>
                            <span class="gh-badge gh-badge-<?php echo e($g['impacto']); ?>"><?php echo e($g['impacto']); ?></span>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            
            <div class="gh-grid-2">
                <div class="gh-card">
                    <div class="gh-title">📊 Distribución de gastos</div>
                    <div class="gh-chart-wrap" wire:ignore>
                        <canvas id="ghChart"></canvas>
                    </div>
                </div>

                <div class="gh-card">
                    <div class="gh-title">🕐 Concentración horaria</div>
                    <?php $maxHora = count($d['porHora']) > 0 ? max($d['porHora']) : 1; ?>
                    <div class="gh-horas-bars">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($h = 0; $h <= 23; $h++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $val = $d['porHora'][$h] ?? 0;
                                $perc = ($val / ($maxHora ?: 1)) * 100;
                                $isMax = $val > 0 && $val == $maxHora;
                            ?>
                            <div class="gh-hora-bar"
                                style="height:<?php echo e(max($perc, 4)); ?>%;
                                       background:<?php echo e($isMax ? 'var(--gold)' : 'rgba(96,165,250,0.35)'); ?>;"
                                title="<?php echo e($h); ?>h — S/ <?php echo e(number_format($val, 2)); ?>">
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                    <div
                        style="display:flex; justify-content:space-between; margin-top:.5rem; font-size:.58rem; color:var(--muted);">
                        <span>00h</span><span>06h</span><span>12h</span><span>18h</span><span>23h</span>
                    </div>
                    <div style="font-size:.65rem; color:var(--muted); margin-top:.75rem;">
                        Hora en que más registras gastos pequeños.
                    </div>
                </div>
            </div>

            
            <div class="gh-card">
                <div class="gh-title">📋 Detalle completo</div>
                <div style="overflow-x:auto;">
                    <table class="gh-table">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Frecuencia</th>
                                <th style="text-align:right;">Total período</th>
                                <th style="text-align:right;">Prom/mov</th>
                                <th style="text-align:right;">Proy. anual</th>
                                <th>Impacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $d['gastos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <td style="font-weight:700; color:var(--text);"><?php echo e($g['descripcion']); ?></td>
                                    <td><?php echo e($g['categoria']); ?></td>
                                    <td><?php echo e($g['conteo']); ?> veces</td>
                                    <td style="text-align:right; color:var(--red); font-weight:700;">S/
                                        <?php echo e(number_format($g['total'], 2)); ?></td>
                                    <td style="text-align:right; color:var(--muted);">S/
                                        <?php echo e(number_format($g['promedio'], 2)); ?></td>
                                    <td style="text-align:right; color:var(--orange); font-weight:700;">S/
                                        <?php echo e(number_format($g['proyeccionAnual'], 2)); ?></td>
                                    <td><span class="gh-badge gh-badge-<?php echo e($g['impacto']); ?>"><?php echo e($g['impacto']); ?></span>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function() {
            function renderGhChart(gastos) {
                if (typeof Chart === 'undefined') {
                    setTimeout(function() {
                        renderGhChart(gastos);
                    }, 100);
                    return;
                }
                var ctx = document.getElementById('ghChart');
                if (!ctx || !gastos.length) return;

                if (window._ghChart) {
                    window._ghChart.destroy();
                    window._ghChart = null;
                }

                var slices = gastos.slice(0, 7);

                window._ghChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: slices.map(function(g) {
                            return g.descripcion;
                        }),
                        datasets: [{
                            data: slices.map(function(g) {
                                return g.total;
                            }),
                            backgroundColor: ['#ef4444', '#f97316', '#fbbf24', '#22c55e', '#60a5fa',
                                '#a78bfa', '#ec4899'
                            ],
                            borderWidth: 0,
                            hoverOffset: 12,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: '#6b7280',
                                    usePointStyle: true,
                                    font: {
                                        size: 11
                                    },
                                    padding: 12
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15,23,42,.92)',
                                titleColor: '#f1f5f9',
                                bodyColor: '#94a3b8',
                                callbacks: {
                                    label: function(c) {
                                        return ' S/ ' + c.parsed.toFixed(2);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Primera carga
            renderGhChart(<?php echo \Illuminate\Support\Js::from($d['gastos'] ?? [])->toHtml() ?>);

            // Actualizaciones via dispatch
            document.addEventListener('livewire:init', function() {
                Livewire.on('updateGhChart', function(data) {
                    var payload = Array.isArray(data) ? data[0] : data;
                    setTimeout(function() {
                        renderGhChart(payload.gastos);
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/gastos-hormiga.blade.php ENDPATH**/ ?>
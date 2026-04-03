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
        $d = $this->getDatos();
        $anios = $this->getAniosDisponibles();
        $a1 = $this->anio1 > 0 ? $this->anio1 : now()->year - 1;
        $a2 = $this->anio2 > 0 ? $this->anio2 : now()->year;
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
            --a1: #f97316;
            --a2: #6366f1;
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
        }

        .aa {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .aa-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .aa-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Selector */
        .aa-selector {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .aa-select {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: .625rem;
            padding: .45rem .875rem;
            font-size: .875rem;
            color: var(--text);
            outline: none;
            cursor: pointer;
            font-weight: 700;
        }

        .aa-select:focus {
            border-color: var(--gold);
        }

        .aa-vs {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--muted);
        }

        /* KPIs variación */
        .aa-vars {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .625rem;
        }

        @media(max-width:600px) {
            .aa-vars {
                grid-template-columns: 1fr;
            }
        }

        .aa-var-card {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
            text-align: center;
            border: 1.5px solid transparent;
        }

        .aa-var-titulo {
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .5rem;
        }

        .aa-var-pct {
            font-size: 1.5rem;
            font-weight: 900;
            line-height: 1;
        }

        .aa-var-desc {
            font-size: .65rem;
            color: var(--muted);
            margin-top: .375rem;
        }

        .aa-var-montos {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: .5rem;
            font-size: .7rem;
        }

        /* Grid anios */
        .aa-grid-anios {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .875rem;
        }

        @media(max-width:640px) {
            .aa-grid-anios {
                grid-template-columns: 1fr;
            }
        }

        .aa-anio-card {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
        }

        .aa-anio-titulo {
            font-size: .825rem;
            font-weight: 800;
            margin-bottom: .875rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .aa-anio-row {
            display: flex;
            justify-content: space-between;
            font-size: .75rem;
            margin-bottom: .375rem;
            padding: .25rem 0;
            border-bottom: 1px solid var(--border);
        }

        .aa-anio-row:last-child {
            border-bottom: none;
        }

        .aa-anio-label {
            color: var(--muted);
        }

        .aa-anio-value {
            font-weight: 700;
        }

        .aa-top-cat {
            margin-top: .75rem;
        }

        .aa-top-cat-titulo {
            font-size: .62rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: .375rem;
        }

        .aa-top-cat-item {
            display: flex;
            justify-content: space-between;
            font-size: .7rem;
            margin-bottom: .2rem;
        }

        .aa-top-cat-nombre {
            color: var(--soft);
        }

        .aa-top-cat-monto {
            font-weight: 700;
            color: var(--red);
        }

        /* Gráficos */
        .aa-charts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .875rem;
        }

        @media(max-width:768px) {
            .aa-charts {
                grid-template-columns: 1fr;
            }
        }

        .aa-chart-wrap {
            position: relative;
            height: 240px;
        }

        /* Tabla mes a mes */
        .aa-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .775rem;
        }

        .aa-table th {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .aa-table td {
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            color: var(--soft);
        }

        .aa-table tr:last-child td {
            border-bottom: none;
        }

        .aa-table tr:hover td {
            background: var(--card);
        }

        .aa-badge {
            display: inline-block;
            padding: .1rem .4rem;
            border-radius: 3px;
            font-size: .6rem;
            font-weight: 700;
        }
    </style>

    <div class="aa">

        
        <div class="aa-card">
            <div class="aa-selector">
                <div>
                    <div style="font-size:.62rem; color:var(--muted); margin-bottom:.25rem;">Año 1</div>
                    <select wire:model.live="anio1" class="aa-select"
                        style="border-color:rgba(249,115,22,.4); color:var(--a1);">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $anios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($a); ?>" <?php echo e($a == $a1 ? 'selected' : ''); ?>><?php echo e($a); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="aa-vs">VS</div>
                <div>
                    <div style="font-size:.62rem; color:var(--muted); margin-bottom:.25rem;">Año 2</div>
                    <select wire:model.live="anio2" class="aa-select"
                        style="border-color:rgba(99,102,241,.4); color:var(--a2);">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $anios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($a); ?>" <?php echo e($a == $a2 ? 'selected' : ''); ?>><?php echo e($a); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div style="font-size:.72rem; color:var(--muted);">
                    Comparando <?php echo e($a1); ?> vs <?php echo e($a2); ?>

                </div>
            </div>
        </div>

        
        <div class="aa-card">
            <div class="aa-title">📈 Variación <?php echo e($a1); ?> → <?php echo e($a2); ?></div>
            <div class="aa-vars">
                <?php
                    $varConfig = [
                        [
                            'titulo' => '💰 Ingresos',
                            'var' => $d['varIngresos'],
                            'v1' => $d['datos1']['totalIngresos'],
                            'v2' => $d['datos2']['totalIngresos'],
                            'positivo' => true,
                        ],
                        [
                            'titulo' => '💸 Egresos',
                            'var' => $d['varEgresos'],
                            'v1' => $d['datos1']['totalEgresos'],
                            'v2' => $d['datos2']['totalEgresos'],
                            'positivo' => false,
                        ],
                        [
                            'titulo' => '💎 Ahorro',
                            'var' => $d['varAhorro'],
                            'v1' => $d['datos1']['totalAhorro'],
                            'v2' => $d['datos2']['totalAhorro'],
                            'positivo' => true,
                        ],
                    ];
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $varConfig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $esBueno = $vc['positivo'] ? $vc['var'] >= 0 : $vc['var'] <= 0;
                        $color = $esBueno ? '#22c55e' : '#ef4444';
                        $emoji = $vc['var'] > 0 ? '↑' : ($vc['var'] < 0 ? '↓' : '→');
                    ?>
                    <div class="aa-var-card" style="border-color:<?php echo e($color); ?>22;">
                        <div class="aa-var-titulo"><?php echo e($vc['titulo']); ?></div>
                        <div class="aa-var-pct" style="color:<?php echo e($color); ?>;">
                            <?php echo e($emoji); ?> <?php echo e(abs($vc['var'])); ?>%
                        </div>
                        <div class="aa-var-desc">
                            <?php echo e($vc['var'] > 0 ? 'Aumentó' : ($vc['var'] < 0 ? 'Disminuyó' : 'Sin cambio')); ?> vs
                            <?php echo e($a1); ?>

                        </div>
                        <div class="aa-var-montos">
                            <span style="color:var(--a1);"><?php echo e($a1); ?>: S/
                                <?php echo e(number_format($vc['v1'], 0)); ?></span>
                            <span style="color:var(--a2);"><?php echo e($a2); ?>: S/
                                <?php echo e(number_format($vc['v2'], 0)); ?></span>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        
        <div class="aa-grid-anios">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [$d['datos1'], $d['datos2']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $dat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php $color = $idx === 0 ? 'var(--a1)' : 'var(--a2)'; ?>
                <div class="aa-anio-card"
                    style="border:1px solid <?php echo e($idx === 0 ? 'rgba(249,115,22,.2)' : 'rgba(99,102,241,.2)'); ?>;">
                    <div class="aa-anio-titulo" style="color:<?php echo e($color); ?>;">
                        <span style="font-size:1.25rem;"><?php echo e($idx === 0 ? '🟠' : '🟣'); ?></span>
                        <?php echo e($dat['anio']); ?>

                    </div>
                    <div class="aa-anio-row">
                        <span class="aa-anio-label">Total ingresos</span>
                        <span class="aa-anio-value" style="color:var(--green);">S/
                            <?php echo e(number_format($dat['totalIngresos'], 2)); ?></span>
                    </div>
                    <div class="aa-anio-row">
                        <span class="aa-anio-label">Total egresos</span>
                        <span class="aa-anio-value" style="color:var(--red);">S/
                            <?php echo e(number_format($dat['totalEgresos'], 2)); ?></span>
                    </div>
                    <div class="aa-anio-row">
                        <span class="aa-anio-label">Ahorro total</span>
                        <span class="aa-anio-value"
                            style="color:<?php echo e($dat['totalAhorro'] >= 0 ? 'var(--blue)' : 'var(--red)'); ?>;">
                            S/ <?php echo e(number_format($dat['totalAhorro'], 2)); ?>

                        </span>
                    </div>
                    <div class="aa-anio-row">
                        <span class="aa-anio-label">Promedio mensual gasto</span>
                        <span class="aa-anio-value">S/ <?php echo e(number_format($dat['promMensual'], 2)); ?></span>
                    </div>
                    <div class="aa-anio-row">
                        <span class="aa-anio-label">Mejor mes</span>
                        <span class="aa-anio-value"
                            style="color:var(--green);"><?php echo e($dat['mejorMes']['mes'] ?? '—'); ?></span>
                    </div>
                    <div class="aa-anio-row">
                        <span class="aa-anio-label">Peor mes</span>
                        <span class="aa-anio-value"
                            style="color:var(--red);"><?php echo e($dat['peorMes']['mes'] ?? '—'); ?></span>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($dat['topCats'])): ?>
                        <div class="aa-top-cat">
                            <div class="aa-top-cat-titulo">Top 5 gastos</div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dat['topCats']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="aa-top-cat-item">
                                    <span class="aa-top-cat-nombre"><?php echo e($cat['nombre']); ?></span>
                                    <span class="aa-top-cat-monto">S/ <?php echo e(number_format($cat['total'], 0)); ?></span>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="aa-charts">
            <div class="aa-card">
                <div class="aa-title">💸 Egresos mensuales</div>
                <div class="aa-chart-wrap">
                    <canvas id="aaChartEgr"></canvas>
                </div>
            </div>
            <div class="aa-card">
                <div class="aa-title">💰 Ingresos mensuales</div>
                <div class="aa-chart-wrap">
                    <canvas id="aaChartIng"></canvas>
                </div>
            </div>
        </div>

        
        <div class="aa-card">
            <div class="aa-title">📅 Comparativa mes a mes</div>
            <div style="overflow-x:auto;">
                <table class="aa-table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th style="text-align:right;">Egr. <?php echo e($a1); ?></th>
                            <th style="text-align:right;">Egr. <?php echo e($a2); ?></th>
                            <th style="text-align:right;">Var. egr.</th>
                            <th style="text-align:right;">Ing. <?php echo e($a1); ?></th>
                            <th style="text-align:right;">Ing. <?php echo e($a2); ?></th>
                            <th style="text-align:right;">Var. ing.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $d['comparativaMeses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fila): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td style="font-weight:700; color:var(--text);"><?php echo e($fila['mes']); ?></td>
                                <td style="text-align:right; color:var(--a1);">S/ <?php echo e(number_format($fila['egr1'], 0)); ?>

                                </td>
                                <td style="text-align:right; color:var(--a2);">S/ <?php echo e(number_format($fila['egr2'], 0)); ?>

                                </td>
                                <td style="text-align:right;">
                                    <span class="aa-badge"
                                        style="background:<?php echo e($fila['varEgr'] > 0 ? 'rgba(239,68,68,.12)' : 'rgba(34,197,94,.12)'); ?>; color:<?php echo e($fila['varEgr'] > 0 ? '#ef4444' : '#22c55e'); ?>;">
                                        <?php echo e($fila['varEgr'] > 0 ? '↑' : '↓'); ?> <?php echo e(abs($fila['varEgr'])); ?>%
                                    </span>
                                </td>
                                <td style="text-align:right; color:var(--a1);">S/ <?php echo e(number_format($fila['ing1'], 0)); ?>

                                </td>
                                <td style="text-align:right; color:var(--a2);">S/ <?php echo e(number_format($fila['ing2'], 0)); ?>

                                </td>
                                <td style="text-align:right;">
                                    <span class="aa-badge"
                                        style="background:<?php echo e($fila['varIng'] >= 0 ? 'rgba(34,197,94,.12)' : 'rgba(239,68,68,.12)'); ?>; color:<?php echo e($fila['varIng'] >= 0 ? '#22c55e' : '#ef4444'); ?>;">
                                        <?php echo e($fila['varIng'] >= 0 ? '↑' : '↓'); ?> <?php echo e(abs($fila['varIng'])); ?>%
                                    </span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        function initAaCharts() {
            const meses = <?php echo json_encode($d['comparativaMeses'], 15, 512) ?>;
            const a1 = <?php echo json_encode($a1, 15, 512) ?>;
            const a2 = <?php echo json_encode($a2, 15, 512) ?>;
            const labels = meses.map(m => m.mes);

            // Egresos
            const ctxEgr = document.getElementById('aaChartEgr');
            if (ctxEgr) {
                if (window._aaChartEgr) window._aaChartEgr.destroy();
                window._aaChartEgr = new Chart(ctxEgr, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                label: String(a1),
                                data: meses.map(m => m.egr1),
                                backgroundColor: 'rgba(249,115,22,.5)',
                                borderColor: '#f97316',
                                borderWidth: 1.5,
                                borderRadius: 3,
                            },
                            {
                                label: String(a2),
                                data: meses.map(m => m.egr2),
                                backgroundColor: 'rgba(99,102,241,.5)',
                                borderColor: '#6366f1',
                                borderWidth: 1.5,
                                borderRadius: 3,
                            },
                        ]
                    },
                    options: chartOpts('S/')
                });
            }

            // Ingresos
            const ctxIng = document.getElementById('aaChartIng');
            if (ctxIng) {
                if (window._aaChartIng) window._aaChartIng.destroy();
                window._aaChartIng = new Chart(ctxIng, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                label: String(a1),
                                data: meses.map(m => m.ing1),
                                backgroundColor: 'rgba(249,115,22,.5)',
                                borderColor: '#f97316',
                                borderWidth: 1.5,
                                borderRadius: 3,
                            },
                            {
                                label: String(a2),
                                data: meses.map(m => m.ing2),
                                backgroundColor: 'rgba(99,102,241,.5)',
                                borderColor: '#6366f1',
                                borderWidth: 1.5,
                                borderRadius: 3,
                            },
                        ]
                    },
                    options: chartOpts('S/')
                });
            }
        }

        function chartOpts(prefix) {
            return {
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
                            label: c => ` ${c.dataset.label}: ${prefix}${c.parsed.y.toFixed(0)}`
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
                        grid: {
                            color: 'rgba(255,255,255,.04)'
                        },
                        ticks: {
                            color: '#6b7280',
                            callback: v => prefix + v.toLocaleString()
                        }
                    }
                }
            };
        }

        initAaCharts();
        document.addEventListener('livewire:updated', initAaCharts);
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/comparativa-anio-anio.blade.php ENDPATH**/ ?>
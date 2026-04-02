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

        .ic-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ic-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ic-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .ic-filtros {
            display: flex;
            gap: 0.5rem;
        }

        .ic-filtro-btn {
            padding: 0.35rem 0.875rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-bg);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .ic-filtro-btn.activo {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
        }

        .ic-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:768px) {
            .ic-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .ic-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .ic-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .ic-kpi-value {
            font-size: 1rem;
            font-weight: 800;
        }

        .ic-kpi-sub {
            font-size: 0.62rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        .ic-chart-wrap {
            position: relative;
            height: 300px;
        }

        .ic-analisis {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            padding: 0.875rem 1rem;
            border-radius: 0.875rem;
            margin-bottom: 1rem;
        }

        .ic-analisis.bueno {
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .ic-analisis.critico {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .ic-analisis-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .ic-analisis-titulo {
            font-size: 0.875rem;
            font-weight: 700;
        }

        .ic-analisis-desc {
            font-size: 0.75rem;
            color: var(--w-muted);
            margin-top: 0.15rem;
            line-height: 1.4;
        }

        .ic-tabla {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .ic-tabla th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .ic-tabla td {
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            color: var(--w-text-soft);
        }

        .ic-tabla tr:last-child td {
            border-bottom: none;
        }

        .ic-tabla tr:hover td {
            background: var(--w-card);
        }

        .ic-badge {
            display: inline-block;
            padding: 0.1rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .ic-badge-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .ic-badge-success {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .ic-badge-neutral {
            background: rgba(107, 114, 128, 0.12);
            color: #6b7280;
        }

        .ic-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem;
        }

        @media(max-width:640px) {
            .ic-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .ic-poder-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            border-left: 3px solid;
        }

        .ic-poder-titulo {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
            margin-bottom: 0.375rem;
        }

        .ic-poder-valor {
            font-size: 1.25rem;
            font-weight: 900;
        }

        .ic-poder-desc {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.25rem;
            line-height: 1.4;
        }

        .ic-fuente {
            font-size: 0.65rem;
            color: var(--w-muted);
            text-align: right;
            margin-top: 0.5rem;
            font-style: italic;
        }
    </style>

    <div class="ic-wrap">

        
        <div class="ic-card">
            <div class="ic-filtros">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [1 => '1 año', 2 => '2 años', 3 => '3 años']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <button class="ic-filtro-btn <?php echo e($anios == $val ? 'activo' : ''); ?>"
                        wire:click="$set('anios', <?php echo e($val); ?>)">
                        <?php echo e($label); ?>

                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        
        <div class="ic-analisis <?php echo e($d['analisis']['estado']); ?>">
            <div class="ic-analisis-icon">
                <?php echo e($d['analisis']['estado'] === 'bueno' ? '✅' : '⚠️'); ?>

            </div>
            <div>
                <div class="ic-analisis-titulo"
                    style="color:<?php echo e($d['analisis']['estado'] === 'bueno' ? '#22c55e' : '#ef4444'); ?>;">
                    <?php echo e($d['analisis']['estado'] === 'bueno'
    ? 'Tus gastos crecen menos que la inflación'
    : 'Tus gastos crecen más que la inflación'); ?>

                </div>
                <div class="ic-analisis-desc">
                    En <?php echo e($d['analisis']['mesesSuperan']); ?> de <?php echo e(count($d['datos'])); ?> meses tus gastos subieron más
                    que la inflación (<?php echo e($d['analisis']['pctSuperan']); ?>% del tiempo).
                    La inflación acumulada del período fue <?php echo e($d['inflacionAcumulada']); ?>%.
                </div>
            </div>
        </div>

        
        <div class="ic-card">
            <div class="ic-kpis">
                <div class="ic-kpi">
                    <div class="ic-kpi-label">Inflación actual</div>
                    <div class="ic-kpi-value" style="color:#fbbf24;"><?php echo e($d['ultimaInflacion']); ?>%</div>
                    <div class="ic-kpi-sub">anual (BCRP)</div>
                </div>
                <div class="ic-kpi">
                    <div class="ic-kpi-label">Inflación acumulada</div>
                    <div class="ic-kpi-value" style="color:#f97316;"><?php echo e($d['inflacionAcumulada']); ?>%</div>
                    <div class="ic-kpi-sub">en <?php echo e($anios); ?> año(s)</div>
                </div>
                <div class="ic-kpi">
                    <div class="ic-kpi-label">Meses sobre inflación</div>
                    <div class="ic-kpi-value" style="color:#ef4444;"><?php echo e($d['analisis']['mesesSuperan']); ?></div>
                    <div class="ic-kpi-sub">de <?php echo e(count($d['datos'])); ?> meses</div>
                </div>
                <div class="ic-kpi">
                    <div class="ic-kpi-label">Meses bajo inflación</div>
                    <div class="ic-kpi-value" style="color:#22c55e;"><?php echo e($d['analisis']['mesesBajo']); ?></div>
                    <div class="ic-kpi-sub">de <?php echo e(count($d['datos'])); ?> meses</div>
                </div>
            </div>
        </div>

        
        <div class="ic-card">
            <div class="ic-title">📈 Variación de gastos vs inflación mensual</div>
            <div class="ic-chart-wrap">
                <canvas id="icChart"></canvas>
            </div>
            <div class="ic-fuente">Fuente: BCRP — Banco Central de Reserva del Perú</div>
        </div>

        
        <div class="ic-grid-2">
            <div class="ic-poder-card" style="border-color:<?php echo e($d['diferenciaPoder'] > 0 ? '#ef4444' : '#22c55e'); ?>;">
                <div class="ic-poder-titulo">💰 Poder adquisitivo</div>
                <div class="ic-poder-valor" style="color:<?php echo e($d['diferenciaPoder'] > 0 ? '#ef4444' : '#22c55e'); ?>;">
                    <?php echo e($d['diferenciaPoder'] > 0 ? '↑ +' : '↓ '); ?>S/ <?php echo e(number_format(abs($d['diferenciaPoder']), 2)); ?>

                </div>
                <div class="ic-poder-desc">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($d['diferenciaPoder'] > 0): ?>
                        Tus gastos reales son S/ <?php echo e(number_format($d['diferenciaPoder'], 2)); ?> más de lo que deberían
                        considerando la inflación. Estás gastando más de lo que la inflación justifica.
                    <?php else: ?>
                        Tus gastos están S/ <?php echo e(number_format(abs($d['diferenciaPoder']), 2)); ?> por debajo de lo que
                        la inflación proyectaría. ¡Buen control de gastos!
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="ic-poder-card" style="border-color:#60a5fa;">
                <div class="ic-poder-titulo">📊 Gasto ajustado por inflación</div>
                <div style="display:flex; flex-direction:column; gap:0.375rem; margin-top:0.375rem;">
                    <div style="display:flex; justify-content:space-between; font-size:0.78rem;">
                        <span style="color:var(--w-muted);">Primer mes</span>
                        <span style="font-weight:700; color:var(--w-text);">S/
                            <?php echo e(number_format($d['primerGasto'], 2)); ?></span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:0.78rem;">
                        <span style="color:var(--w-muted);">Esperado con inflación</span>
                        <span style="font-weight:700; color:#60a5fa;">S/
                            <?php echo e(number_format($d['gastoAjustado'], 2)); ?></span>
                    </div>
                    <div
                        style="display:flex; justify-content:space-between; font-size:0.78rem; border-top:1px solid var(--w-border); padding-top:0.375rem;">
                        <span style="color:var(--w-muted);">Gasto actual</span>
                        <span
                            style="font-weight:700; color:<?php echo e($d['ultimoGasto'] > $d['gastoAjustado'] ? '#ef4444' : '#22c55e'); ?>;">
                            S/ <?php echo e(number_format($d['ultimoGasto'], 2)); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="ic-card">
            <div class="ic-title">📅 Detalle mensual</div>
            <div style="overflow-x:auto; max-height:400px; overflow-y:auto;">
                <table class="ic-tabla">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th style="text-align:right;">Gasto</th>
                            <th style="text-align:right;">Var. gasto</th>
                            <th style="text-align:right;">Inflación mens.</th>
                            <th style="text-align:right;">Inflación anual</th>
                            <th style="text-align:center;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = array_reverse($d['datos']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fila): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td style="font-weight:600; color:var(--w-text);"><?php echo e($fila['mes']); ?></td>
                                <td style="text-align:right; font-weight:600;">
                                    S/ <?php echo e(number_format($fila['gasto'], 2)); ?>

                                </td>
                                <td
                                    style="text-align:right; font-weight:700; color:<?php echo e($fila['variacionGasto'] > 0 ? '#ef4444' : ($fila['variacionGasto'] < 0 ? '#22c55e' : '#6b7280')); ?>;">
                                    <?php echo e($fila['variacionGasto'] > 0 ? '+' : ''); ?><?php echo e($fila['variacionGasto']); ?>%
                                </td>
                                <td style="text-align:right; color:#fbbf24; font-weight:600;">
                                    <?php echo e($fila['inflacionMensual']); ?>%
                                </td>
                                <td style="text-align:right; color:#f97316; font-weight:600;">
                                    <?php echo e($fila['inflacionAnual']); ?>%
                                </td>
                                <td style="text-align:center;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fila['variacionGasto'] == 0): ?>
                                        <span class="ic-badge ic-badge-neutral">—</span>
                                    <?php elseif($fila['variacionGasto'] > $fila['inflacionMensual']): ?>
                                        <span class="ic-badge ic-badge-danger">↑ Sobre inflación</span>
                                    <?php else: ?>
                                        <span class="ic-badge ic-badge-success">✓ Bajo inflación</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="ic-fuente">Datos de inflación: BCRP — Banco Central de Reserva del Perú</div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function () {
            const datos = <?php echo json_encode($d['datos'], 15, 512) ?>;
            const ctx = document.getElementById('icChart');
            if (!ctx || !datos.length) return;

            if (window._icChart) window._icChart.destroy();

            window._icChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: datos.map(d => d.mes),
                    datasets: [
                        {
                            label: 'Variación gasto %',
                            data: datos.map(d => d.variacionGasto),
                            borderColor: '#ef4444',
                            backgroundColor: '#ef444422',
                            pointBackgroundColor: '#ef4444',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: false,
                        },
                        {
                            label: 'Inflación mensual %',
                            data: datos.map(d => d.inflacionMensual),
                            borderColor: '#fbbf24',
                            backgroundColor: '#fbbf2422',
                            pointBackgroundColor: '#fbbf24',
                            borderWidth: 2,
                            tension: 0.4,
                            borderDash: [5, 5],
                            fill: false,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { labels: { color: '#6b7280', font: { size: 11 } } },
                        tooltip: {
                            backgroundColor: 'rgba(15,23,42,0.9)',
                            titleColor: '#f1f5f9',
                            bodyColor: '#94a3b8',
                            callbacks: {
                                label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}%`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(255,255,255,0.04)' },
                            ticks: { color: '#6b7280', font: { size: 10 }, maxRotation: 45 },
                        },
                        y: {
                            grid: { color: 'rgba(255,255,255,0.04)' },
                            ticks: {
                                color: '#6b7280', font: { size: 11 },
                                callback: v => v + '%',
                            },
                        }
                    }
                }
            });

            // Línea de referencia en 0
            const plugin = {
                id: 'zeroLine',
                afterDraw(chart) {
                    const { ctx, scales: { y } } = chart;
                    const yPos = y.getPixelForValue(0);
                    ctx.save();
                    ctx.strokeStyle = 'rgba(255,255,255,0.2)';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(chart.chartArea.left, yPos);
                    ctx.lineTo(chart.chartArea.right, yPos);
                    ctx.stroke();
                    ctx.restore();
                }
            };
            Chart.register(plugin);
            window._icChart.update();
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
<?php endif; ?><?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/inflacion-comparativa.blade.php ENDPATH**/ ?>
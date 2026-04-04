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
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
        }

        .pe {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .pe-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .pe-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Estado principal */
        .pe-estado {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            padding: 1.25rem;
            border-radius: .875rem;
            margin-bottom: 1rem;
        }

        .pe-estado-icon {
            font-size: 2.5rem;
            flex-shrink: 0;
        }

        .pe-estado-titulo {
            font-size: 1.1rem;
            font-weight: 900;
        }

        .pe-estado-desc {
            font-size: .78rem;
            color: var(--muted);
            margin-top: .2rem;
            line-height: 1.5;
        }

        /* KPIs */
        .pe-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .625rem;
        }

        @media(max-width:768px) {
            .pe-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .pe-kpi {
            background: var(--card);
            border-radius: .75rem;
            padding: .75rem;
        }

        .pe-kpi-label {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .2rem;
        }

        .pe-kpi-value {
            font-size: 1rem;
            font-weight: 900;
        }

        .pe-kpi-sub {
            font-size: .6rem;
            color: var(--muted);
            margin-top: .1rem;
        }

        /* Barra de equilibrio */
        .pe-barra-wrap {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .pe-barra-labels {
            display: flex;
            justify-content: space-between;
            font-size: .65rem;
            color: var(--muted);
            margin-bottom: .375rem;
        }

        .pe-barra-track {
            height: 16px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
            position: relative;
        }

        .pe-barra-fija {
            height: 100%;
            border-radius: 0;
            background: #ef4444;
            float: left;
            transition: width .5s;
        }

        .pe-barra-var {
            height: 100%;
            border-radius: 0;
            background: #f97316;
            float: left;
            transition: width .5s;
        }

        .pe-barra-margen {
            height: 100%;
            border-radius: 0 99px 99px 0;
            background: #22c55e;
            float: left;
            transition: width .5s;
        }

        .pe-barra-marker {
            position: absolute;
            top: 0;
            height: 100%;
            width: 2px;
            background: white;
            opacity: .8;
        }

        .pe-barra-footer {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: .5rem;
        }

        .pe-barra-item {
            display: flex;
            align-items: center;
            gap: .35rem;
            font-size: .65rem;
            color: var(--muted);
        }

        .pe-barra-dot {
            width: 10px;
            height: 10px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        /* Grid 2 */
        .pe-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .875rem;
        }

        @media(max-width:640px) {
            .pe-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* Lista gastos */
        .pe-gasto-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .5rem .625rem;
            background: var(--card);
            border-radius: .5rem;
            margin-bottom: .375rem;
            font-size: .75rem;
        }

        .pe-gasto-nombre {
            font-weight: 600;
            color: var(--text);
        }

        .pe-gasto-monto {
            font-weight: 700;
        }

        /* Días de trabajo */
        .pe-dias-wrap {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .pe-dia-card {
            flex: 1;
            min-width: 120px;
            background: var(--card);
            border-radius: .75rem;
            padding: .875rem;
            text-align: center;
        }

        .pe-dia-num {
            font-size: 2rem;
            font-weight: 900;
            line-height: 1;
        }

        .pe-dia-label {
            font-size: .65rem;
            color: var(--muted);
            margin-top: .2rem;
        }

        /* Progreso cubierto */
        .pe-prog-wrap {
            margin-top: 1rem;
        }

        .pe-prog-label {
            display: flex;
            justify-content: space-between;
            font-size: .72rem;
            color: var(--muted);
            margin-bottom: .375rem;
        }

        .pe-prog-track {
            height: 8px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .pe-prog-fill {
            height: 100%;
            border-radius: 99px;
            transition: width .5s;
        }
    </style>

    <div class="pe">

        
        <?php
            $cfg = match ($d['estado']) {
                'excelente' => ['color' => '#22c55e', 'bg' => 'rgba(34,197,94,.08)', 'border' => 'rgba(34,197,94,.2)', 'emoji' => '🚀', 'titulo' => '¡Excelente equilibrio!', 'desc' => 'Tus ingresos superan tus gastos en un 20% o más. Tienes margen para ahorrar e invertir.'],
                'estable' => ['color' => '#60a5fa', 'bg' => 'rgba(96,165,250,.08)', 'border' => 'rgba(96,165,250,.2)', 'emoji' => '✅', 'titulo' => 'Equilibrio estable', 'desc' => 'Cubres todos tus gastos pero el margen de ahorro es bajo. Intenta reducir gastos variables.'],
                'ajustado' => ['color' => '#fbbf24', 'bg' => 'rgba(251,191,36,.08)', 'border' => 'rgba(251,191,36,.2)', 'emoji' => '⚠️', 'titulo' => 'Equilibrio ajustado', 'desc' => 'Cubres los mínimos pero no todos tus gastos habituales. Necesitas aumentar ingresos o reducir gastos.'],
                default => ['color' => '#ef4444', 'bg' => 'rgba(239,68,68,.08)', 'border' => 'rgba(239,68,68,.2)', 'emoji' => '🚨', 'titulo' => 'Déficit financiero', 'desc' => 'Tus ingresos no cubren tus gastos mínimos. Necesitas acción inmediata.'],
            };
        ?>

        <div class="pe-card">
            <div class="pe-estado" style="background:<?php echo e($cfg['bg']); ?>; border:1px solid <?php echo e($cfg['border']); ?>;">
                <div class="pe-estado-icon"><?php echo e($cfg['emoji']); ?></div>
                <div>
                    <div class="pe-estado-titulo" style="color:<?php echo e($cfg['color']); ?>;"><?php echo e($cfg['titulo']); ?></div>
                    <div class="pe-estado-desc"><?php echo e($cfg['desc']); ?></div>
                </div>
            </div>

            
            <div class="pe-barra-wrap">
                <?php
                    $total = max($d['ingresoIdeal'], $d['totalGastos'], $d['ingresosProm']);
                    $pctFijo = $total > 0 ? ($d['totalFijos'] / $total) * 100 : 0;
                    $pctVar = $total > 0 ? ($d['totalVariables'] / $total) * 100 : 0;
                    $pctMarg = $total > 0 ? (max(0, $d['margenSeguridad']) / $total) * 100 : 0;
                    $markerPE = $total > 0 ? ($d['puntoEquilibrio'] / $total) * 100 : 0;
                    $markerIngreso = $total > 0 ? ($d['ingresosProm'] / $total) * 100 : 0;
                ?>
                <div style="font-size:.7rem; color:var(--muted); margin-bottom:.5rem;">Distribución del ingreso vs
                    gastos</div>
                <div class="pe-barra-track">
                    <div class="pe-barra-fija" style="width:<?php echo e(min(100, $pctFijo)); ?>%;"></div>
                    <div class="pe-barra-var" style="width:<?php echo e(min(100, $pctVar)); ?>%;"></div>
                    <div class="pe-barra-margen" style="width:<?php echo e(min(100, $pctMarg)); ?>%;"></div>
                    <div class="pe-barra-marker" style="left:<?php echo e(min(99, $markerIngreso)); ?>%;" title="Ingresos actuales">
                    </div>
                </div>
                <div class="pe-barra-footer">
                    <div class="pe-barra-item">
                        <div class="pe-barra-dot" style="background:#ef4444;"></div> Gastos fijos S/
                        <?php echo e(number_format($d['totalFijos'], 0)); ?>

                    </div>
                    <div class="pe-barra-item">
                        <div class="pe-barra-dot" style="background:#f97316;"></div> Gastos variables S/
                        <?php echo e(number_format($d['totalVariables'], 0)); ?>

                    </div>
                    <div class="pe-barra-item">
                        <div class="pe-barra-dot" style="background:#22c55e;"></div> Margen S/
                        <?php echo e(number_format(max(0, $d['margenSeguridad']), 0)); ?>

                    </div>
                    <div class="pe-barra-item">
                        <div class="pe-barra-dot" style="background:white; opacity:.8;"></div> Tu ingreso actual
                    </div>
                </div>
            </div>

            
            <div class="pe-prog-wrap">
                <div class="pe-prog-label">
                    <span>Cobertura de gastos</span>
                    <span style="font-weight:700; color:<?php echo e($cfg['color']); ?>;"><?php echo e($d['pctCubierto']); ?>%</span>
                </div>
                <div class="pe-prog-track">
                    <div class="pe-prog-fill" style="width:<?php echo e($d['pctCubierto']); ?>%; background:<?php echo e($cfg['color']); ?>;">
                    </div>
                </div>
            </div>
        </div>

        
        <div class="pe-card">
            <div class="pe-kpis">
                <div class="pe-kpi">
                    <div class="pe-kpi-label">Ingreso promedio</div>
                    <div class="pe-kpi-value" style="color:var(--green);">S/ <?php echo e(number_format($d['ingresosProm'], 2)); ?>

                    </div>
                    <div class="pe-kpi-sub">últimos 3 meses</div>
                </div>
                <div class="pe-kpi">
                    <div class="pe-kpi-label">Punto de equilibrio</div>
                    <div class="pe-kpi-value" style="color:var(--gold);">S/
                        <?php echo e(number_format($d['puntoEquilibrio'], 2)); ?></div>
                    <div class="pe-kpi-sub">mínimo para sobrevivir</div>
                </div>
                <div class="pe-kpi">
                    <div class="pe-kpi-label">Ingreso ideal</div>
                    <div class="pe-kpi-value" style="color:var(--blue);">S/ <?php echo e(number_format($d['ingresoIdeal'], 2)); ?>

                    </div>
                    <div class="pe-kpi-sub">para ahorrar 20%</div>
                </div>
                <div class="pe-kpi">
                    <div class="pe-kpi-label">Margen de seguridad</div>
                    <div class="pe-kpi-value"
                        style="color:<?php echo e($d['margenSeguridad'] >= 0 ? 'var(--green)' : 'var(--red)'); ?>;">
                        <?php echo e($d['margenSeguridad'] >= 0 ? '+' : ''); ?>S/ <?php echo e(number_format($d['margenSeguridad'], 2)); ?>

                    </div>
                    <div class="pe-kpi-sub">ingresos - gastos totales</div>
                </div>
            </div>
        </div>

        
        <div class="pe-card">
            <div class="pe-title">⏱️ ¿Cuántos días trabajas para cubrir tus gastos?</div>
            <div class="pe-dias-wrap">
                <div class="pe-dia-card">
                    <div class="pe-dia-num" style="color:var(--red);"><?php echo e($d['diasParaFijos']); ?></div>
                    <div class="pe-dia-label">días para<br>gastos fijos</div>
                </div>
                <div class="pe-dia-card">
                    <div class="pe-dia-num" style="color:var(--orange);"><?php echo e($d['diasParaTodo']); ?></div>
                    <div class="pe-dia-label">días para<br>todos los gastos</div>
                </div>
                <div class="pe-dia-card">
                    <div class="pe-dia-num" style="color:var(--green);"><?php echo e(max(0, 22 - $d['diasParaTodo'])); ?></div>
                    <div class="pe-dia-label">días libres<br>de gastos</div>
                </div>
                <div class="pe-dia-card">
                    <div class="pe-dia-num" style="color:var(--gold);">S/ <?php echo e(number_format($d['ingresoDiario'], 0)); ?>

                    </div>
                    <div class="pe-dia-label">ingreso<br>diario estimado</div>
                </div>
            </div>
        </div>

        
        <div class="pe-grid-2">
            <div class="pe-card">
                <div class="pe-title">🔒 Gastos fijos — S/ <?php echo e(number_format($d['totalFijos'], 2)); ?>/mes</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $d['gastosFijos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="pe-gasto-item">
                        <span class="pe-gasto-nombre"><?php echo e($g['nombre']); ?></span>
                        <span class="pe-gasto-monto" style="color:var(--red);">S/ <?php echo e(number_format($g['monto'], 2)); ?></span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div style="font-size:.75rem; color:var(--muted); text-align:center; padding:1rem;">
                        No se detectaron gastos fijos automáticamente.
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div style="font-size:.65rem; color:var(--muted); margin-top:.5rem; font-style:italic;">
                    Detectados automáticamente por palabras clave. Puede variar.
                </div>
            </div>

            <div class="pe-card">
                <div class="pe-title">🔓 Gastos variables — S/ <?php echo e(number_format($d['totalVariables'], 2)); ?>/mes</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $d['gastosVariables']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="pe-gasto-item">
                        <span class="pe-gasto-nombre"><?php echo e($g['nombre']); ?></span>
                        <span class="pe-gasto-monto" style="color:var(--orange);">S/
                            <?php echo e(number_format($g['monto'], 2)); ?></span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div style="font-size:.75rem; color:var(--muted); text-align:center; padding:1rem;">
                        Sin gastos variables registrados.
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

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
<?php endif; ?><?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/punto-equilibrio.blade.php ENDPATH**/ ?>
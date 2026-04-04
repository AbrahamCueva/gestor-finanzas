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
        $dias = $this->getCalendario();
        $detalle = $this->getDetalleDia();
        $resumen = $this->getResumenMes();
        $nombresMeses = [
            '',
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre',
        ];
        $diasSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        $hoy = now()->toDateString();
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
            --purple: #a78bfa;
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

        .cal {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .cal-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        /* Header nav */
        .cal-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .cal-nav-btn {
            width: 34px;
            height: 34px;
            border-radius: .625rem;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--muted);
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .cal-nav-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .cal-mes-titulo {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.01em;
        }

        /* Resumen mes */
        .cal-resumen {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: .5rem;
        }

        @media(max-width:900px) {
            .cal-resumen {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:500px) {
            .cal-resumen {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .cal-res-item {
            background: var(--card);
            border-radius: .75rem;
            padding: .625rem .75rem;
            text-align: center;
        }

        .cal-res-label {
            font-size: .58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
        }

        .cal-res-value {
            font-size: .95rem;
            font-weight: 900;
            margin-top: .15rem;
        }

        /* Leyenda */
        .cal-leyenda {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
            font-size: .65rem;
            color: var(--muted);
        }

        .cal-ley-item {
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        .cal-ley-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Grid semana */
        .cal-week-headers {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px;
            margin-bottom: 3px;
        }

        .cal-week-header {
            text-align: center;
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            padding: .4rem 0;
        }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px;
        }

        /* Día celda */
        .cal-dia {
            background: var(--card);
            border-radius: .625rem;
            padding: .5rem;
            min-height: 80px;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: all .15s;
            display: flex;
            flex-direction: column;
            gap: .2rem;
            position: relative;
            overflow: hidden;
        }

        .cal-dia:hover {
            border-color: rgba(251, 191, 36, .3);
        }

        .cal-dia.hoy {
            border-color: var(--gold);
            background: rgba(251, 191, 36, .06);
        }

        .cal-dia.seleccionado {
            border-color: var(--blue);
            background: rgba(96, 165, 250, .07);
        }

        .cal-dia.feriado {
            background: rgba(167, 139, 250, .06);
        }

        .cal-dia.futuro {
            opacity: .55;
        }

        .cal-dia.vacio {
            background: transparent;
            cursor: default;
        }

        .cal-dia-num {
            font-size: .78rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
        }

        .cal-dia.hoy .cal-dia-num {
            color: var(--gold);
        }

        .cal-dia-feriado-tag {
            font-size: .5rem;
            color: var(--purple);
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cal-dia-montos {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .cal-dia-ingreso {
            font-size: .6rem;
            font-weight: 700;
            color: var(--green);
        }

        .cal-dia-egreso {
            font-size: .6rem;
            font-weight: 700;
            color: var(--red);
        }

        .cal-dia-dots {
            display: flex;
            gap: 2px;
            flex-wrap: wrap;
            margin-top: .2rem;
        }

        .cal-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Indicador positivo/negativo */
        .cal-dia-indicator {
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            border-radius: 3px 0 0 3px;
        }

        /* Panel detalle */
        .cal-detalle {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .cal-detalle-titulo {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .cal-section-title {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--muted);
            margin: .875rem 0 .5rem;
            display: flex;
            align-items: center;
            gap: .375rem;
        }

        .cal-item {
            background: var(--card);
            border-radius: .625rem;
            padding: .625rem .875rem;
            margin-bottom: .375rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
        }

        .cal-item-left {
            display: flex;
            flex-direction: column;
            gap: .1rem;
        }

        .cal-item-nombre {
            font-size: .8rem;
            font-weight: 700;
            color: var(--text);
        }

        .cal-item-sub {
            font-size: .65rem;
            color: var(--muted);
        }

        .cal-item-monto {
            font-size: .9rem;
            font-weight: 900;
            flex-shrink: 0;
        }

        .cal-badge {
            font-size: .58rem;
            font-weight: 700;
            padding: .1rem .4rem;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .cal-kpis-dia {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .5rem;
            margin-bottom: 1rem;
        }

        .cal-kpi-dia {
            background: var(--card);
            border-radius: .625rem;
            padding: .625rem .75rem;
            text-align: center;
        }

        .cal-kpi-dia-label {
            font-size: .58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
        }

        .cal-kpi-dia-value {
            font-size: .95rem;
            font-weight: 900;
            margin-top: .1rem;
        }

        .cal-empty {
            text-align: center;
            color: var(--muted);
            padding: 1.5rem;
            font-size: .8rem;
        }
    </style>

    <div class="cal">

        
        <div class="cal-card">
            <div class="cal-nav">
                <div style="display:flex; align-items:center; gap:.75rem;">
                    <button class="cal-nav-btn" wire:click="anteriorMes">‹</button>
                    <div class="cal-mes-titulo">
                        <?php echo e($nombresMeses[$mes]); ?> <?php echo e($anio); ?>

                    </div>
                    <button class="cal-nav-btn" wire:click="siguienteMes">›</button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mes != now()->month || $anio != now()->year): ?>
                        <button class="cal-nav-btn"
                            wire:click="$set('mes', <?php echo e(now()->month); ?>); $set('anio', <?php echo e(now()->year); ?>)"
                            style="font-size:.65rem; width:auto; padding:0 .5rem;">Hoy</button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="cal-resumen">
                    <div class="cal-res-item">
                        <div class="cal-res-label">Ingresos</div>
                        <div class="cal-res-value" style="color:var(--green);">S/
                            <?php echo e(number_format($resumen['ingresos'], 0)); ?></div>
                    </div>
                    <div class="cal-res-item">
                        <div class="cal-res-label">Egresos</div>
                        <div class="cal-res-value" style="color:var(--red);">S/
                            <?php echo e(number_format($resumen['egresos'], 0)); ?></div>
                    </div>
                    <div class="cal-res-item">
                        <div class="cal-res-label">Neto</div>
                        <?php $neto = $resumen['ingresos'] - $resumen['egresos']; ?>
                        <div class="cal-res-value" style="color:<?php echo e($neto >= 0 ? 'var(--blue)' : 'var(--red)'); ?>;">
                            <?php echo e($neto >= 0 ? '+' : ''); ?>S/ <?php echo e(number_format($neto, 0)); ?>

                        </div>
                    </div>
                    <div class="cal-res-item">
                        <div class="cal-res-label">Transf.</div>
                        <div class="cal-res-value" style="color:var(--purple);"><?php echo e($resumen['transferencias']); ?></div>
                    </div>
                    <div class="cal-res-item">
                        <div class="cal-res-label">Metas</div>
                        <div class="cal-res-value" style="color:var(--gold);"><?php echo e($resumen['metasVencen']); ?></div>
                    </div>
                    <div class="cal-res-item">
                        <div class="cal-res-label">Alertas</div>
                        <div class="cal-res-value" style="color:var(--orange);">
                            <?php echo e($resumen['recordatorios'] + $resumen['deudasVencen']); ?></div>
                    </div>
                </div>
            </div>
        </div>

        
        <div style="padding:0 .25rem;">
            <div class="cal-leyenda">
                <div class="cal-ley-item">
                    <div class="cal-ley-dot" style="background:var(--green);"></div>Ingresos
                </div>
                <div class="cal-ley-item">
                    <div class="cal-ley-dot" style="background:var(--red);"></div>Egresos
                </div>
                <div class="cal-ley-item">
                    <div class="cal-ley-dot" style="background:var(--purple);"></div>Transferencia
                </div>
                <div class="cal-ley-item">
                    <div class="cal-ley-dot" style="background:var(--gold);"></div>Meta
                </div>
                <div class="cal-ley-item">
                    <div class="cal-ley-dot" style="background:var(--orange);"></div>Recordatorio
                </div>
                <div class="cal-ley-item">
                    <div class="cal-ley-dot" style="background:var(--red); opacity:.5;"></div>Deuda
                </div>
                <div class="cal-ley-item">
                    <div class="cal-ley-dot" style="background:var(--blue);"></div>Presupuesto
                </div>
                <div class="cal-ley-item">
                    <div class="cal-ley-dot" style="background:var(--purple); opacity:.4;"></div>Feriado
                </div>
            </div>
        </div>

        
        <div class="cal-card" style="padding:1rem;">
            <div class="cal-week-headers">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $diasSemana; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="cal-week-header"><?php echo e($ds); ?></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <div class="cal-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia === null): ?>
                        <div class="cal-dia vacio"></div>
                    <?php else: ?>
                        <?php
                            $clases = 'cal-dia';
                            if ($dia['esHoy']) {
                                $clases .= ' hoy';
                            }
                            if ($dia['esFuturo']) {
                                $clases .= ' futuro';
                            }
                            if ($dia['esFeriado']) {
                                $clases .= ' feriado';
                            }
                            if ($diaSeleccionado === $dia['fecha']) {
                                $clases .= ' seleccionado';
                            }
                            $indicadorColor = '';
                            if ($dia['tieneMovs'] && !$dia['esFuturo']) {
                                $indicadorColor = $dia['neto'] >= 0 ? 'var(--green)' : 'var(--red)';
                            }
                        ?>
                        <div class="<?php echo e($clases); ?>" wire:click="seleccionarDia('<?php echo e($dia['fecha']); ?>')">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($indicadorColor): ?>
                                <div class="cal-dia-indicator" style="background:<?php echo e($indicadorColor); ?>;"></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="cal-dia-num"><?php echo e($dia['dia']); ?></div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['esFeriado']): ?>
                                <div class="cal-dia-feriado-tag">🎌 <?php echo e($dia['feriado']); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <div class="cal-dia-dots">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['tieneMovs']): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['ingresos'] > 0): ?>
                                        <div class="cal-dot" style="background:var(--green);" title="Ingresos"></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['egresos'] > 0): ?>
                                        <div class="cal-dot" style="background:var(--red);" title="Egresos"></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['tieneTrans']): ?>
                                    <div class="cal-dot" style="background:var(--purple);" title="Transferencia"></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['tieneMetas']): ?>
                                    <div class="cal-dot" style="background:var(--gold);" title="Meta"></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['tieneRec']): ?>
                                    <div class="cal-dot" style="background:var(--orange);" title="Recordatorio"></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['tieneDeuda']): ?>
                                    <div class="cal-dot" style="background:var(--red); opacity:.6;" title="Deuda">
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['tienePres']): ?>
                                    <div class="cal-dot" style="background:var(--blue);" title="Presupuesto"></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$dia['esFuturo'] && $dia['tieneMovs']): ?>
                                <div class="cal-dia-montos">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['ingresos'] > 0): ?>
                                        <div class="cal-dia-ingreso">+<?php echo e(number_format($dia['ingresos'], 0)); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dia['egresos'] > 0): ?>
                                        <div class="cal-dia-egreso">-<?php echo e(number_format($dia['egresos'], 0)); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($diaSeleccionado && count($detalle) > 0): ?>
            <div class="cal-detalle">
                <div class="cal-detalle-titulo">
                    📅 <?php echo e($detalle['fecha']); ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle['esFeriado']): ?>
                        · <span style="color:var(--purple);">🎌 <?php echo e($detalle['feriado']); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle['totalIngresos'] > 0 || $detalle['totalEgresos'] > 0): ?>
                    <div class="cal-kpis-dia">
                        <div class="cal-kpi-dia">
                            <div class="cal-kpi-dia-label">Ingresos</div>
                            <div class="cal-kpi-dia-value" style="color:var(--green);">S/
                                <?php echo e(number_format($detalle['totalIngresos'], 2)); ?></div>
                        </div>
                        <div class="cal-kpi-dia">
                            <div class="cal-kpi-dia-label">Egresos</div>
                            <div class="cal-kpi-dia-value" style="color:var(--red);">S/
                                <?php echo e(number_format($detalle['totalEgresos'], 2)); ?></div>
                        </div>
                        <div class="cal-kpi-dia">
                            <?php $netoDia = $detalle['totalIngresos'] - $detalle['totalEgresos']; ?>
                            <div class="cal-kpi-dia-label">Neto</div>
                            <div class="cal-kpi-dia-value"
                                style="color:<?php echo e($netoDia >= 0 ? 'var(--blue)' : 'var(--red)'); ?>;">
                                <?php echo e($netoDia >= 0 ? '+' : ''); ?>S/ <?php echo e(number_format($netoDia, 2)); ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle['movimientos']->count()): ?>
                    <div class="cal-section-title">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--green);display:inline-block;"></span>
                        Movimientos (<?php echo e($detalle['movimientos']->count()); ?>)
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalle['movimientos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="cal-item">
                            <div class="cal-item-left">
                                <div class="cal-item-nombre">
                                    <?php echo e($mov->descripcion ?: $mov->categoria?->nombre ?? '—'); ?></div>
                                <div class="cal-item-sub">
                                    <?php echo e($mov->categoria?->nombre ?? '—'); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mov->cuenta): ?>
                                        · <?php echo e($mov->cuenta->nombre); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mov->es_recurrente): ?>
                                        · <span style="color:var(--blue);">🔄 Recurrente</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <div class="cal-item-monto"
                                style="color:<?php echo e($mov->tipo_movimiento === 'ingreso' ? 'var(--green)' : 'var(--red)'); ?>;">
                                <?php echo e($mov->tipo_movimiento === 'ingreso' ? '+' : '-'); ?>S/
                                <?php echo e(number_format($mov->monto, 2)); ?>

                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle['transferencias']->count()): ?>
                    <div class="cal-section-title">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--purple);display:inline-block;"></span>
                        Transferencias (<?php echo e($detalle['transferencias']->count()); ?>)
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalle['transferencias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="cal-item">
                            <div class="cal-item-left">
                                <div class="cal-item-nombre"><?php echo e($trans->cuentaOrigen?->nombre); ?> →
                                    <?php echo e($trans->cuentaDestino?->nombre); ?></div>
                                <div class="cal-item-sub"><?php echo e($trans->descripcion ?: 'Sin descripción'); ?></div>
                            </div>
                            <div class="cal-item-monto" style="color:var(--purple);">S/
                                <?php echo e(number_format($trans->monto, 2)); ?></div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle['recordatorios']->count()): ?>
                    <div class="cal-section-title">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--orange);display:inline-block;"></span>
                        Recordatorios (<?php echo e($detalle['recordatorios']->count()); ?>)
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalle['recordatorios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="cal-item">
                            <div class="cal-item-left">
                                <div class="cal-item-nombre"><?php echo e($rec->titulo); ?></div>
                                <div class="cal-item-sub"><?php echo e(Str::limit($rec->contenido, 80)); ?></div>
                            </div>
                            <span class="cal-badge" style="background:rgba(249,115,22,.12);color:var(--orange);">⏰
                                Recordatorio</span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle['metas']->count()): ?>
                    <div class="cal-section-title">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--gold);display:inline-block;"></span>
                        Metas con vencimiento (<?php echo e($detalle['metas']->count()); ?>)
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalle['metas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="cal-item">
                            <div class="cal-item-left">
                                <div class="cal-item-nombre"><?php echo e($meta->icono ?? '🎯'); ?> <?php echo e($meta->nombre); ?></div>
                                <div class="cal-item-sub">
                                    S/ <?php echo e(number_format($meta->monto_actual, 2)); ?> / S/
                                    <?php echo e(number_format($meta->monto_objetivo, 2)); ?>

                                    · <?php echo e($meta->porcentaje()); ?>%
                                </div>
                            </div>
                            <span class="cal-badge"
                                style="background:<?php echo e($meta->completada ? 'rgba(34,197,94,.12)' : 'rgba(251,191,36,.12)'); ?>;color:<?php echo e($meta->completada ? 'var(--green)' : 'var(--gold)'); ?>;">
                                <?php echo e($meta->completada ? '✓ Lograda' : '⏳ Pendiente'); ?>

                            </span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle['deudas']->count()): ?>
                    <div class="cal-section-title">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--red);opacity:.7;display:inline-block;"></span>
                        Deudas con vencimiento (<?php echo e($detalle['deudas']->count()); ?>)
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalle['deudas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deuda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="cal-item">
                            <div class="cal-item-left">
                                <div class="cal-item-nombre"><?php echo e($deuda->nombre); ?></div>
                                <div class="cal-item-sub"><?php echo e($deuda->acreedor_deudor ?? '—'); ?> ·
                                    <?php echo e(ucfirst($deuda->tipo)); ?></div>
                            </div>
                            <div class="cal-item-monto" style="color:var(--red);">S/
                                <?php echo e(number_format($deuda->monto_total - $deuda->monto_pagado, 2)); ?></div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle['presupuestos']->count()): ?>
                    <div class="cal-section-title">
                        <span
                            style="width:8px;height:8px;border-radius:50%;background:var(--blue);display:inline-block;"></span>
                        Presupuestos activos (<?php echo e($detalle['presupuestos']->count()); ?>)
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalle['presupuestos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pres): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php $pct = $pres->porcentaje(); ?>
                        <div class="cal-item">
                            <div class="cal-item-left" style="flex:1;">
                                <div class="cal-item-nombre"><?php echo e($pres->categoria?->nombre ?? '—'); ?></div>
                                <div class="cal-item-sub">
                                    S/ <?php echo e(number_format($pres->gastoActual(), 2)); ?> / S/
                                    <?php echo e(number_format($pres->monto_limite, 2)); ?>

                                </div>
                                <div
                                    style="height:3px;background:var(--border);border-radius:99px;margin-top:.3rem;overflow:hidden;">
                                    <div
                                        style="height:100%;border-radius:99px;width:<?php echo e(min($pct, 100)); ?>%;background:<?php echo e($pct >= 100 ? 'var(--red)' : ($pct >= 80 ? 'var(--orange)' : 'var(--blue)')); ?>;">
                                    </div>
                                </div>
                            </div>
                            <span class="cal-badge"
                                style="background:<?php echo e($pct >= 100 ? 'rgba(239,68,68,.12)' : 'rgba(96,165,250,.12)'); ?>;color:<?php echo e($pct >= 100 ? 'var(--red)' : 'var(--blue)'); ?>;">
                                <?php echo e($pct); ?>%
                            </span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(
                    !$detalle['movimientos']->count() &&
                        !$detalle['transferencias']->count() &&
                        !$detalle['recordatorios']->count() &&
                        !$detalle['metas']->count() &&
                        !$detalle['deudas']->count() &&
                        !$detalle['presupuestos']->count()): ?>
                    <div class="cal-empty">Sin eventos para este día.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/calendario-financiero.blade.php ENDPATH**/ ?>
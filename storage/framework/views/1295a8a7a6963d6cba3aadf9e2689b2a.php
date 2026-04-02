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

        .md {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .md-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .md-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Info métodos */
        .md-metodos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .875rem;
        }

        @media(max-width:640px) {
            .md-metodos {
                grid-template-columns: 1fr;
            }
        }

        .md-metodo-card {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
            border: 2px solid transparent;
            transition: all .15s;
            cursor: pointer;
        }

        .md-metodo-card.activo-avalancha {
            border-color: #ef4444;
            background: rgba(239, 68, 68, .05);
        }

        .md-metodo-card.activo-bola {
            border-color: #60a5fa;
            background: rgba(96, 165, 250, .05);
        }

        .md-metodo-card:hover {
            opacity: .9;
        }

        .md-metodo-emoji {
            font-size: 1.75rem;
            margin-bottom: .5rem;
        }

        .md-metodo-titulo {
            font-size: .875rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: .25rem;
        }

        .md-metodo-desc {
            font-size: .72rem;
            color: var(--muted);
            line-height: 1.5;
        }

        .md-metodo-badge {
            display: inline-block;
            margin-top: .5rem;
            padding: .15rem .5rem;
            border-radius: 99px;
            font-size: .62rem;
            font-weight: 700;
        }

        /* Control extra */
        .md-control {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
        }

        .md-control-label {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .5rem;
        }

        .md-control-valor {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--gold);
            text-align: center;
            margin: .5rem 0;
        }

        .md-slider {
            width: 100%;
            appearance: none;
            height: 4px;
            border-radius: 99px;
            background: var(--border);
            outline: none;
            cursor: pointer;
        }

        .md-slider::-webkit-slider-thumb {
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--gold);
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .2);
        }

        /* Comparativa */
        .md-comparativa {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .875rem;
        }

        @media(max-width:640px) {
            .md-comparativa {
                grid-template-columns: 1fr;
            }
        }

        .md-comp {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
        }

        .md-comp-titulo {
            font-size: .75rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: .375rem;
        }

        .md-comp-row {
            display: flex;
            justify-content: space-between;
            font-size: .75rem;
            margin-bottom: .35rem;
            padding: .25rem 0;
            border-bottom: 1px solid var(--border);
        }

        .md-comp-row:last-child {
            border-bottom: none;
        }

        .md-comp-label {
            color: var(--muted);
        }

        .md-comp-value {
            font-weight: 700;
        }

        /* Orden de pago */
        .md-orden {
            display: flex;
            flex-direction: column;
            gap: .375rem;
        }

        .md-orden-item {
            display: flex;
            align-items: center;
            gap: .625rem;
            background: var(--card);
            border-radius: .5rem;
            padding: .5rem .75rem;
            font-size: .775rem;
        }

        .md-orden-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .65rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        /* Deudas lista */
        .md-deuda-item {
            background: var(--card);
            border-radius: .75rem;
            padding: .875rem;
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .md-deuda-nombre {
            font-size: .825rem;
            font-weight: 700;
            color: var(--text);
        }

        .md-deuda-datos {
            display: flex;
            gap: 1rem;
            font-size: .72rem;
            color: var(--muted);
        }

        .md-deuda-monto {
            font-size: .925rem;
            font-weight: 800;
            color: var(--red);
        }

        /* Gráfico */
        .md-chart-wrap {
            position: relative;
            height: 260px;
        }

        /* Recomendado badge */
        .md-recomendado {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .875rem 1rem;
            border-radius: .875rem;
            background: rgba(34, 197, 94, .08);
            border: 1px solid rgba(34, 197, 94, .2);
        }
    </style>

    <div class="md">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($d['deudas'])): ?>
            <div class="md-card" style="text-align:center; padding:3rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">🎉</div>
                <div style="font-size:1rem; font-weight:700; color:var(--text);">¡Sin deudas pendientes!</div>
                <div style="font-size:.825rem; color:var(--muted); margin-top:.375rem;">No tienes deudas del tipo "debo"
                    registradas.</div>
            </div>
        <?php else: ?>

            
            <div class="md-recomendado">
                <div style="font-size:1.5rem;">💡</div>
                <div>
                    <div style="font-size:.875rem; font-weight:700; color:#22c55e;">
                        Recomendamos: <?php echo e($d['recomendado'] === 'avalancha' ? '🌊 Método Avalancha' : '⚽ Bola de Nieve'); ?>

                    </div>
                    <div style="font-size:.72rem; color:var(--muted); margin-top:.15rem;">
                        <?php echo e($d['recomendado'] === 'avalancha'
            ? 'Pagarás menos intereses en total con el método avalancha.'
            : 'El método bola de nieve te dará más victorias rápidas y motivación.'); ?>

                    </div>
                </div>
            </div>

            
            <div class="md-card">
                <div class="md-title">🎯 Elige tu método</div>
                <div class="md-metodos">
                    <div class="md-metodo-card <?php echo e($metodo === 'avalancha' ? 'activo-avalancha' : ''); ?>"
                        wire:click="$set('metodo','avalancha')">
                        <div class="md-metodo-emoji">🌊</div>
                        <div class="md-metodo-titulo">Método Avalancha</div>
                        <div class="md-metodo-desc">
                            Pagas primero la deuda con <strong>mayor tasa de interés</strong>.
                            Matemáticamente óptimo — pagas menos intereses en total.
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($d['recomendado'] === 'avalancha'): ?>
                            <span class="md-metodo-badge" style="background:rgba(34,197,94,.12); color:#22c55e;">✓
                                Recomendado</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="md-metodo-card <?php echo e($metodo === 'bola_de_nieve' ? 'activo-bola' : ''); ?>"
                        wire:click="$set('metodo','bola_de_nieve')">
                        <div class="md-metodo-emoji">⚽</div>
                        <div class="md-metodo-titulo">Bola de Nieve</div>
                        <div class="md-metodo-desc">
                            Pagas primero la deuda <strong>más pequeña</strong>.
                            Psicológicamente motivador — ves resultados rápido.
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($d['recomendado'] === 'bola_de_nieve'): ?>
                            <span class="md-metodo-badge" style="background:rgba(34,197,94,.12); color:#22c55e;">✓
                                Recomendado</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="md-card">
                <div class="md-control">
                    <div class="md-control-label">💰 Pago extra mensual disponible</div>
                    <div class="md-control-valor">S/ <?php echo e(number_format($pagoMensualExtra, 2)); ?>/mes</div>
                    <input type="range" class="md-slider" min="50" max="2000" step="50" wire:model.live="pagoMensualExtra">
                    <div
                        style="display:flex; justify-content:space-between; font-size:.6rem; color:var(--muted); margin-top:.25rem;">
                        <span>S/ 50</span><span>S/ 1,000</span><span>S/ 2,000</span>
                    </div>
                    <div style="font-size:.68rem; color:var(--muted); margin-top:.5rem; text-align:center;">
                        Este es el dinero extra que puedes destinar a pagar deudas cada mes, además del pago mínimo.
                    </div>
                </div>
            </div>

            
            <div class="md-comparativa">
                
                <div class="md-comp" style="border:1px solid rgba(239,68,68,.2);">
                    <div class="md-comp-titulo" style="color:#ef4444;">🌊 Avalancha</div>
                    <div class="md-comp-row">
                        <span class="md-comp-label">Meses para saldar</span>
                        <span class="md-comp-value" style="color:var(--text);"><?php echo e($d['avalancha']['meses'] ?? '—'); ?>

                            meses</span>
                    </div>
                    <div class="md-comp-row">
                        <span class="md-comp-label">Total en intereses</span>
                        <span class="md-comp-value" style="color:var(--red);">S/
                            <?php echo e(number_format($d['avalancha']['totalIntereses'] ?? 0, 2)); ?></span>
                    </div>
                    <div class="md-comp-row">
                        <span class="md-comp-label">Orden de pago</span>
                        <span class="md-comp-value"
                            style="font-size:.65rem; color:var(--muted);"><?php echo e(implode(' → ', array_slice($d['avalancha']['orden'] ?? [], 0, 3))); ?></span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($d['avalancha']['pagadas'])): ?>
                        <div style="margin-top:.5rem;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $d['avalancha']['pagadas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div style="font-size:.65rem; color:#22c55e;">✓ <?php echo e($p['nombre']); ?> — mes <?php echo e($p['mes']); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="md-comp" style="border:1px solid rgba(96,165,250,.2);">
                    <div class="md-comp-titulo" style="color:#60a5fa;">⚽ Bola de Nieve</div>
                    <div class="md-comp-row">
                        <span class="md-comp-label">Meses para saldar</span>
                        <span class="md-comp-value" style="color:var(--text);"><?php echo e($d['bolaDeNieve']['meses'] ?? '—'); ?>

                            meses</span>
                    </div>
                    <div class="md-comp-row">
                        <span class="md-comp-label">Total en intereses</span>
                        <span class="md-comp-value" style="color:var(--red);">S/
                            <?php echo e(number_format($d['bolaDeNieve']['totalIntereses'] ?? 0, 2)); ?></span>
                    </div>
                    <div class="md-comp-row">
                        <span class="md-comp-label">Orden de pago</span>
                        <span class="md-comp-value"
                            style="font-size:.65rem; color:var(--muted);"><?php echo e(implode(' → ', array_slice($d['bolaDeNieve']['orden'] ?? [], 0, 3))); ?></span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($d['bolaDeNieve']['pagadas'])): ?>
                        <div style="margin-top:.5rem;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $d['bolaDeNieve']['pagadas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div style="font-size:.65rem; color:#22c55e;">✓ <?php echo e($p['nombre']); ?> — mes <?php echo e($p['mes']); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <?php
                $difMeses = ($d['bolaDeNieve']['meses'] ?? 0) - ($d['avalancha']['meses'] ?? 0);
                $difIntereses = ($d['bolaDeNieve']['totalIntereses'] ?? 0) - ($d['avalancha']['totalIntereses'] ?? 0);
            ?>
            <div class="md-card" style="background:rgba(167,139,250,.06); border:1px solid rgba(167,139,250,.2);">
                <div style="display:flex; gap:2rem; flex-wrap:wrap;">
                    <div>
                        <div style="font-size:.62rem; color:var(--muted); text-transform:uppercase; letter-spacing:.06em;">
                            Diferencia en tiempo</div>
                        <div style="font-size:1.1rem; font-weight:900; color:var(--purple);">
                            <?php echo e(abs($difMeses)); ?> mes(es)
                            <span style="font-size:.72rem; font-weight:400; color:var(--muted);">
                                <?php echo e($difMeses > 0 ? 'avalancha es más rápido' : ($difMeses < 0 ? 'bola de nieve es más rápida' : 'igual tiempo')); ?>

                            </span>
                        </div>
                    </div>
                    <div>
                        <div style="font-size:.62rem; color:var(--muted); text-transform:uppercase; letter-spacing:.06em;">
                            Diferencia en intereses</div>
                        <div style="font-size:1.1rem; font-weight:900; color:var(--purple);">
                            S/ <?php echo e(number_format(abs($difIntereses), 2)); ?>

                            <span style="font-size:.72rem; font-weight:400; color:var(--muted);">
                                <?php echo e($difIntereses > 0 ? 'ahorras con avalancha' : ($difIntereses < 0 ? 'ahorras con bola de nieve' : 'igual costo')); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="md-card">
                <div class="md-title">📈 Evolución del total de deuda</div>
                <div class="md-chart-wrap">
                    <canvas id="mdChart"></canvas>
                </div>
            </div>

            
            <div class="md-card">
                <div class="md-title">💳 Tus deudas actuales</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $d['deudas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deuda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="md-deuda-item">
                        <div>
                            <div class="md-deuda-nombre"><?php echo e($deuda['nombre']); ?></div>
                            <div class="md-deuda-datos">
                                <span>Interés: <?php echo e($deuda['interes']); ?>% anual</span>
                                <span>Mínimo: S/ <?php echo e(number_format($deuda['minimo'], 2)); ?>/mes</span>
                            </div>
                        </div>
                        <div class="md-deuda-monto">S/ <?php echo e(number_format($deuda['restante'], 2)); ?></div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div style="font-size:.65rem; color:var(--muted); margin-top:.5rem; font-style:italic;">
                    💡 Para mejorar la simulación, asegúrate de tener la tasa de interés y pago mínimo en cada deuda.
                </div>
            </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function () {
            const avalancha = <?php echo json_encode($d['avalancha']['historial'] ?? [], 15, 512) ?>;
            const bolaDeNieve = <?php echo json_encode($d['bolaDeNieve']['historial'] ?? [], 15, 512) ?>;
            const ctx = document.getElementById('mdChart');
            if (!ctx || !avalancha.length) return;
            if (window._mdChart) window._mdChart.destroy();

            window._mdChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: avalancha.map(h => 'Mes ' + h.mes),
                    datasets: [
                        {
                            label: '🌊 Avalancha',
                            data: avalancha.map(h => h.total),
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239,68,68,.08)',
                            borderWidth: 2.5, tension: 0.4,
                            pointRadius: 2, fill: true,
                        },
                        {
                            label: '⚽ Bola de Nieve',
                            data: bolaDeNieve.map(h => h.total),
                            borderColor: '#60a5fa',
                            backgroundColor: 'rgba(96,165,250,.08)',
                            borderWidth: 2.5, tension: 0.4,
                            pointRadius: 2, fill: true,
                        },
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { labels: { color: '#6b7280', font: { size: 11 } } },
                        tooltip: {
                            backgroundColor: 'rgba(15,23,42,.9)',
                            titleColor: '#f1f5f9', bodyColor: '#94a3b8',
                            callbacks: { label: c => ` ${c.dataset.label}: S/ ${c.parsed.y.toFixed(2)}` }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#6b7280', font: { size: 10 } } },
                        y: { grid: { color: 'rgba(255,255,255,.04)' }, ticks: { color: '#6b7280', callback: v => 'S/' + v.toLocaleString() } }
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
<?php endif; ?><?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/metodo-deudas.blade.php ENDPATH**/ ?>
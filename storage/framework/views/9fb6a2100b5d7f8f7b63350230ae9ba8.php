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
        $nivel = $datos['nivel'];
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

        .ln-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ln-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ln-nivel-wrap {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .ln-nivel-badge {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            border: 3px solid;
            flex-shrink: 0;
        }

        .ln-nivel-info {
            flex: 1;
            min-width: 200px;
        }

        .ln-nivel-nombre {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .ln-nivel-puntos {
            font-size: 0.8rem;
            color: var(--w-muted);
            margin-bottom: 0.625rem;
        }

        .ln-prog-wrap {
            height: 6px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 0.375rem;
        }

        .ln-prog-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.6s ease;
        }

        .ln-prog-label {
            font-size: 0.65rem;
            color: var(--w-muted);
        }

        .ln-nivel-stats {
            display: flex;
            gap: 1rem;
            margin-top: 0.875rem;
            flex-wrap: wrap;
        }

        .ln-stat {
            text-align: center;
        }

        .ln-stat-val {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .ln-stat-lab {
            font-size: 0.62rem;
            color: var(--w-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ln-logros-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:1024px) {
            .ln-logros-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:640px) {
            .ln-logros-grid {
                grid-template-columns: 1fr;
            }
        }

        .ln-logro {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            border: 1.5px solid transparent;
            transition: all 0.15s;
        }

        .ln-logro.desbloqueado {
            border-color: rgba(251, 191, 36, 0.3);
        }

        .ln-logro.bloqueado {
            opacity: 0.45;
            filter: grayscale(0.6);
        }

        .ln-logro-emoji {
            font-size: 1.5rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .ln-logro-info {
            flex: 1;
        }

        .ln-logro-nombre {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ln-logro-desc {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 0.15rem;
            line-height: 1.4;
        }

        .ln-logro-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.5rem;
        }

        .ln-logro-pts {
            font-size: 0.68rem;
            font-weight: 700;
        }

        .ln-badge {
            display: inline-block;
            padding: 0.12rem 0.5rem;
            border-radius: 99px;
            font-size: 0.6rem;
            font-weight: 700;
        }

        .ln-badge-ok {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .ln-badge-locked {
            background: rgba(107, 114, 128, 0.12);
            color: #6b7280;
        }

        .ln-cat-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 0.625rem;
            margin-top: 0.25rem;
        }
    </style>

    <div class="ln-wrap">

        <div class="ln-card">
            <div class="ln-nivel-wrap">
                <div class="ln-nivel-badge"
                    style="border-color:<?php echo e($nivel['color']); ?>; background:<?php echo e($nivel['color']); ?>18;">
                    <?php echo e($nivel['emoji']); ?>

                </div>
                <div class="ln-nivel-info">
                    <div class="ln-nivel-nombre" style="color:<?php echo e($nivel['color']); ?>;"><?php echo e($nivel['nombre']); ?></div>
                    <div class="ln-nivel-puntos"><?php echo e($datos['puntos']); ?> puntos acumulados</div>
                    <div class="ln-prog-wrap">
                        <div class="ln-prog-fill"
                            style="width:<?php echo e($datos['progreso']); ?>%; background:<?php echo e($nivel['color']); ?>;"></div>
                    </div>
                    <div class="ln-prog-label">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nivel['siguiente']): ?>
                            <?php echo e($datos['progreso']); ?>% hacia
                            <?php echo e(\App\Services\LogrosService::nivel($nivel['siguiente'])['nombre']); ?>

                            (faltan <?php echo e($nivel['siguiente'] - $datos['puntos']); ?> pts)
                        <?php else: ?>
                            ¡Nivel máximo alcanzado! 👑
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="ln-nivel-stats">
                    <div class="ln-stat">
                        <div class="ln-stat-val" style="color:#fbbf24;"><?php echo e($datos['desbloqueados']); ?></div>
                        <div class="ln-stat-lab">Logros</div>
                    </div>
                    <div class="ln-stat">
                        <div class="ln-stat-val" style="color:#6b7280;"><?php echo e($datos['total'] - $datos['desbloqueados']); ?>

                        </div>
                        <div class="ln-stat-lab">Bloqueados</div>
                    </div>
                    <div class="ln-stat">
                        <div class="ln-stat-val" style="color:<?php echo e($nivel['color']); ?>;"><?php echo e($datos['puntos']); ?></div>
                        <div class="ln-stat-lab">Puntos</div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $datos['porCategoria']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $logros): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="ln-card">
                <div class="ln-cat-title">
                    <?php echo e($logros->where('desbloqueado', true)->count()); ?>/<?php echo e($logros->count()); ?> — <?php echo e($categoria); ?>

                </div>
                <div class="ln-logros-grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $logros->sortByDesc('desbloqueado'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="ln-logro <?php echo e($logro['desbloqueado'] ? 'desbloqueado' : 'bloqueado'); ?>">
                            <div class="ln-logro-emoji"><?php echo e($logro['emoji']); ?></div>
                            <div class="ln-logro-info">
                                <div class="ln-logro-nombre"><?php echo e($logro['nombre']); ?></div>
                                <div class="ln-logro-desc"><?php echo e($logro['descripcion']); ?></div>
                                <div class="ln-logro-bottom">
                                    <span class="ln-logro-pts" style="color:<?php echo e($logro['color']); ?>;">
                                        +<?php echo e($logro['puntos']); ?> pts
                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logro['desbloqueado']): ?>
                                        <span class="ln-badge ln-badge-ok">✓ <?php echo e($logro['desbloqueado_en']); ?></span>
                                        <button
                                            onclick="abrirShare('<?php echo e($logro['emoji']); ?>','<?php echo e(addslashes($logro['nombre'])); ?>','<?php echo e(addslashes($logro['descripcion'])); ?>',<?php echo e($logro['puntos']); ?>,'<?php echo e($logro['color']); ?>')"
                                            style="background:rgba(251,191,36,0.1); border:none; border-radius:0.375rem; padding:0.2rem 0.5rem; font-size:0.65rem; color:#fbbf24; cursor:pointer; margin-top:0.375rem; width:100%;">
                                            📤 Compartir
                                        </button>
                                    <?php else: ?>
                                        <span class="ln-badge ln-badge-locked">🔒 Bloqueado</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    </div>

    <div id="shareModal"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:99999; align-items:center; justify-content:center;">
        <div
            style="background:#0f172a; border:1px solid rgba(255,255,255,0.1); border-radius:1rem; padding:1.5rem; max-width:380px; width:90%; text-align:center;">
            <div style="font-size:0.8rem; color:#6b7280; margin-bottom:1rem;">Vista previa</div>
            <div id="shareCard"
                style="
            background:#1e293b;
            border-radius:14px;
            padding:28px;
            margin-bottom:1rem;
            border:1px solid rgba(251,191,36,0.2);
            font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
        ">
                <div
                    style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:#fbbf24; margin-bottom:16px;">
                    RICOX — Logro Desbloqueado
                </div>
                <div id="shareEmoji" style="font-size:48px; margin-bottom:12px; line-height:1;"></div>
                <div id="shareNombre" style="font-size:18px; font-weight:800; color:#f9fafb; margin-bottom:6px;"></div>
                <div id="shareDesc" style="font-size:12px; color:#94a3b8; margin-bottom:16px; line-height:1.5;"></div>
                <div id="sharePts"
                    style="display:inline-block; padding:4px 14px; border-radius:99px; font-size:12px; font-weight:700;">
                </div>
            </div>

            <div style="display:flex; gap:0.5rem; justify-content:center;">
                <button onclick="descargarLogro()"
                    style="background:#fbbf24; color:#0f172a; border:none; border-radius:0.5rem; padding:0.5rem 1.25rem; font-weight:700; font-size:0.825rem; cursor:pointer;">⬇️
                    Descargar</button>
                <button onclick="cerrarShare()"
                    style="background:rgba(255,255,255,0.06); color:#9ca3af; border:1px solid rgba(255,255,255,0.08); border-radius:0.5rem; padding:0.5rem 1.25rem; font-size:0.825rem; cursor:pointer;">Cerrar</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function abrirShare(emoji, nombre, desc, pts, color) {
            document.getElementById('shareEmoji').textContent = emoji;
            document.getElementById('shareNombre').textContent = nombre;
            document.getElementById('shareDesc').textContent = desc;
            document.getElementById('sharePts').textContent = '+' + pts + ' pts';
            document.getElementById('sharePts').style.background = color + '33';
            document.getElementById('sharePts').style.color = color;
            document.getElementById('shareModal').style.display = 'flex';
        }

        function cerrarShare() {
            document.getElementById('shareModal').style.display = 'none';
        }

        async function descargarLogro() {
            const card = document.getElementById('shareCard');

            try {
                const canvas = await html2canvas(card, {
                    backgroundColor: '#1e293b',
                    scale: 2,
                    logging: false,
                    useCORS: false,
                    allowTaint: true,
                    // Ignorar estilos externos que usen oklch
                    onclone: function(doc) {
                        const el = doc.getElementById('shareCard');
                        // Remover cualquier stylesheet externo clonado
                        doc.querySelectorAll('link[rel="stylesheet"]').forEach(l => l.remove());
                        doc.querySelectorAll('style').forEach(s => s.remove());
                    }
                });

                const a = document.createElement('a');
                a.download = 'ricox_logro.png';
                a.href = canvas.toDataURL('image/png');
                a.click();
            } catch (e) {
                console.error('Error al generar imagen:', e);
                alert('Error al generar la imagen. Intenta de nuevo.');
            }
        }

        document.getElementById('shareModal').addEventListener('click', function(e) {
            if (e.target === this) cerrarShare();
        });
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/logros-nivel.blade.php ENDPATH**/ ?>
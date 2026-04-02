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

        .br-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .br-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .br-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .br-info {
            background: rgba(96, 165, 250, 0.08);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            line-height: 1.5;
        }

        .br-info svg {
            width: 16px;
            height: 16px;
            color: #60a5fa;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Drop zone */
        .br-dropzone {
            border: 2px dashed var(--w-border);
            border-radius: 0.875rem;
            padding: 2.5rem 1.5rem;
            text-align: center;
            transition: border-color 0.2s, background 0.2s;
            cursor: pointer;
        }

        .br-dropzone:hover,
        .br-dropzone.drag-over {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.05);
        }

        .br-dropzone-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .br-dropzone-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--w-text);
            margin-bottom: 0.25rem;
        }

        .br-dropzone-sub {
            font-size: 0.75rem;
            color: var(--w-muted);
        }

        /* Error */
        .br-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.8rem;
            color: #ef4444;
        }

        /* Preview grid */
        .br-preview-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
            margin-bottom: 1rem;
        }

        @media(max-width:768px) {
            .br-preview-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .br-preview-item {
            background: var(--w-card);
            border-radius: 0.625rem;
            padding: 0.625rem 0.75rem;
        }

        .br-preview-label {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .br-preview-value {
            font-size: 1rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .br-meta {
            font-size: 0.72rem;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* Botones */
        .br-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .br-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.25rem;
            border-radius: 0.625rem;
            font-size: 0.825rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .br-btn:hover {
            opacity: 0.85;
        }

        .br-btn svg {
            width: 14px;
            height: 14px;
        }

        .br-btn-primary {
            background: #fbbf24;
            color: #0f172a;
        }

        .br-btn-secondary {
            background: var(--w-card);
            color: var(--w-muted);
        }

        .br-btn-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }
    </style>

    <div class="br-wrap">

        <div class="br-info">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            El backup incluye todos tus datos: cuentas, movimientos, transferencias, presupuestos, metas, deudas y tipos
            de cambio. Al restaurar solo se importan los registros que no existen aún.
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($error): ?>
            <div class="br-error">⚠️ <?php echo e($error); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$restaurando): ?>
            <div class="br-card">
                <div class="br-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Restaurar desde archivo
                </div>

                <div class="br-dropzone" id="brDropzone" onclick="document.getElementById('brInput').click()">
                    <div class="br-dropzone-title">Arrastra tu backup aquí o haz click para seleccionar</div>
                    <div class="br-dropzone-sub">Solo archivos .json generados por RICOX</div>
                    <input type="file" id="brInput" accept=".json" style="display:none" onchange="leerJson(event)">
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($restaurando && $preview): ?>
            <div class="br-card">
                <div class="br-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Vista previa del backup
                </div>

                <div class="br-meta">
                    📅 Generado el <?php echo e(\Carbon\Carbon::parse($preview['generado_en'])->format('d/m/Y H:i')); ?>

                    &nbsp;·&nbsp; versión <?php echo e($preview['version']); ?>

                </div>

                <div class="br-preview-grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [['Cuentas', $preview['cuentas'], '🏦'], ['Categorías', $preview['categorias'], '🏷️'], ['Subcategorías', $preview['subcategorias'], '📂'], ['Movimientos', $preview['movimientos'], '💸'], ['Transferencias', $preview['transferencias'], '🔁'], ['Presupuestos', $preview['presupuestos'], '🎯'], ['Metas', $preview['metas'], '🏆'], ['Deudas', $preview['deudas'], '💳'], ['Abonos', $preview['abonos_cambio'] ?? $preview['abonos_deuda'], '📝'], ['Tipos de Cambio', $preview['tipos_cambio'], '💱']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $count, $icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="br-preview-item">
                            <div class="br-preview-label"><?php echo e($icon); ?> <?php echo e($label); ?></div>
                            <div class="br-preview-value"><?php echo e($count); ?></div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                <div class="br-actions">
                    <button class="br-btn br-btn-secondary" wire:click="cancelar">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                    <button class="br-btn br-btn-primary" wire:click="confirmarRestauracion"
                        wire:confirm="¿Restaurar el backup? Solo se importarán los registros que no existen.">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Restaurar backup
                    </button>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    <script>
        function leerJson(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('procesarJson', e.target.result);
            reader.readAsText(file, 'UTF-8');
        }

        const dz = document.getElementById('brDropzone');
        if (dz) {
            dz.addEventListener('dragover', e => {
                e.preventDefault();
                dz.classList.add('drag-over');
            });
            dz.addEventListener('dragleave', () => dz.classList.remove('drag-over'));
            dz.addEventListener('drop', e => {
                e.preventDefault();
                dz.classList.remove('drag-over');
                const file = e.dataTransfer.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = ev => window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('procesarJson', ev.target.result);
                    reader.readAsText(file, 'UTF-8');
                }
            });
        }
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
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/backup-restauracion.blade.php ENDPATH**/ ?>
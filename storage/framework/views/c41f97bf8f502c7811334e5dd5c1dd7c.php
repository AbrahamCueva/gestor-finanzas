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
        $usuarios = $this->getUsuarios();
        $roles = $this->getRoles(); 
    ?>

    <style>
        :root {
            --w-bg: rgba(0, 0, 0, 0.04);
            --w-card: rgba(0, 0, 0, 0.05);
            --w-text: #111827;
            --w-soft: #374151;
            --w-muted: #6b7280;
            --w-border: rgba(0, 0, 0, 0.08);
        }

        .dark {
            --w-bg: rgba(255, 255, 255, 0.03);
            --w-card: rgba(255, 255, 255, 0.04);
            --w-text: #f9fafb;
            --w-soft: #e5e7eb;
            --w-muted: #6b7280;
            --w-border: rgba(255, 255, 255, 0.08);
        }

        .gu-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .gu-card {
            background: var(--w-bg);
            border: 1px solid var(--w-border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .gu-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:600px) {
            .gu-stats {
                grid-template-columns: 1fr;
            }
        }

        .gu-stat {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .gu-stat-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .gu-stat-value {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .gu-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        .gu-table th {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .gu-table td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--w-border);
            vertical-align: middle;
        }

        .gu-table tr:last-child td {
            border-bottom: none;
        }

        .gu-table tr:hover td {
            background: var(--w-card);
        }

        .gu-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 800;
            color: white;
            flex-shrink: 0;
        }

        .gu-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .gu-nombre {
            font-weight: 700;
            color: var(--w-text);
            font-size: 0.825rem;
        }

        .gu-email {
            font-size: 0.68rem;
            color: var(--w-muted);
        }

        .gu-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.625rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .gu-badge-admin {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .gu-badge-usuario {
            background: rgba(99, 102, 241, 0.12);
            color: #818cf8;
        }

        .gu-select {
            background: var(--w-card);
            border: 1px solid var(--w-border);
            border-radius: 0.5rem;
            padding: 0.3rem 0.625rem;
            font-size: 0.72rem;
            color: var(--w-text);
            outline: none;
            cursor: pointer;
            transition: border-color 0.15s;
        }

        .gu-select:focus {
            border-color: #fbbf24;
        }

        .gu-btn {
            padding: 0.3rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.72rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .gu-btn:hover {
            opacity: 0.8;
        }

        .gu-btn-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .gu-yo {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            padding: 0.1rem 0.5rem;
            border-radius: 99px;
            font-size: 0.6rem;
            font-weight: 700;
        }
    </style>

    <div class="gu-wrap">

        
        <div class="gu-card">
            <div class="gu-stats">
                <div class="gu-stat">
                    <div class="gu-stat-label">Total usuarios</div>
                    <div class="gu-stat-value" style="color:#fbbf24;"><?php echo e($usuarios->count()); ?></div>
                </div>
                <div class="gu-stat">
                    <div class="gu-stat-label">Super Admins</div>
                    <div class="gu-stat-value" style="color:#f97316;">
                        <?php echo e($usuarios->filter(fn($u) => $u->hasRole('super_admin'))->count()); ?>

                    </div>
                </div>
                <div class="gu-stat">
                    <div class="gu-stat-label">Usuarios</div>
                    <div class="gu-stat-value" style="color:#818cf8;">
                        <?php echo e($usuarios->filter(fn($u) => $u->hasRole('usuario'))->count()); ?>

                    </div>
                </div>
            </div>
        </div>

        
        <div class="gu-card">
            <div
                style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--w-muted); margin-bottom:1rem;">
                👥 Usuarios registrados
            </div>

            <div style="overflow-x:auto;">
                <table class="gu-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Rol actual</th>
                            <th>Registrado</th>
                            <th>Cambiar rol</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $rolActual = $u->roles->first()?->name ?? 'sin rol';
                                $esYo = $u->id === auth()->id();
                                $inicial = strtoupper(substr($u->name, 0, 1));
                                $badgeClass = $rolActual === 'super_admin' ? 'gu-badge-admin' : 'gu-badge-usuario';
                                $rolLabel = $rolActual === 'super_admin' ? '👑 Super Admin' : '👤 Usuario';
                            ?>
                            <tr>
                                <td>
                                    <div class="gu-user-info">
                                        <div class="gu-avatar"><?php echo e($inicial); ?></div>
                                        <div>
                                            <div class="gu-nombre">
                                                <?php echo e($u->name); ?>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($esYo): ?>
                                                    <span class="gu-yo">Tú</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div class="gu-email"><?php echo e($u->email); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="gu-badge <?php echo e($badgeClass); ?>"><?php echo e($rolLabel); ?></span>
                                </td>
                                <td style="color:var(--w-muted); font-size:0.72rem;">
                                    <?php echo e($u->created_at->format('d/m/Y')); ?>

                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$esYo): ?>
                                        <select class="gu-select" wire:change="cambiarRol(<?php echo e($u->id); ?>, $event.target.value)">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <option value="<?php echo e($rol); ?>" <?php echo e($rolActual === $rol ? 'selected' : ''); ?>>
                                                    <?php echo e($rol === 'super_admin' ? '👑 Super Admin' : '👤 Usuario'); ?>

                                                </option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                    <?php else: ?>
                                        <span style="font-size:0.68rem; color:var(--w-muted);">Tu propio rol</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$esYo): ?>
                                        <button class="gu-btn gu-btn-danger" wire:click="eliminarUsuario(<?php echo e($u->id); ?>)"
                                            wire:confirm="¿Eliminar a <?php echo e($u->name); ?>? Esta acción no se puede deshacer.">
                                            🗑 Eliminar
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
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
<?php endif; ?><?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/pages/gestion-usuarios.blade.php ENDPATH**/ ?>
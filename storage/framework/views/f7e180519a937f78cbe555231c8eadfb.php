<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #374151;
            background: #fff;
        }

        /* ── HEADER ── */
        .header {
            background: #0f172a;
            padding: 28px 36px;
            margin-bottom: 0;
            position: relative;
            overflow: hidden;
        }

        .header-accent {
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 100%;
            background: linear-gradient(135deg, transparent 40%, rgba(251, 191, 36, 0.08) 100%);
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-logo {
            height: 40px;
            width: auto;
        }

        .header-logo-placeholder {
            font-size: 22px;
            font-weight: 800;
            color: #fbbf24;
            letter-spacing: -0.03em;
        }

        .header-meta {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .header-sitename {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
        }

        .header-subtitle {
            font-size: 10px;
            color: #64748b;
        }

        .header-badge {
            background: #fbbf24;
            color: #0f172a;
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            text-transform: capitalize;
        }

        /* ── BANDA DORADA ── */
        .gold-band {
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #f59e0b, #d97706);
            margin-bottom: 28px;
        }

        /* ── CONTENEDOR ── */
        .container {
            padding: 0 36px;
        }

        /* ── KPI CARDS ── */
        .kpi-row {
            display: flex;
            gap: 12px;
            margin-bottom: 28px;
        }

        .kpi-card {
            flex: 1;
            border-radius: 10px;
            padding: 14px 16px;
        }

        .kpi-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 6px;
        }

        .kpi-value {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .kpi-sub {
            font-size: 9px;
            margin-top: 3px;
        }

        .kpi-green {
            background: #f0fdf4;
        }

        .kpi-green .kpi-label {
            color: #15803d;
        }

        .kpi-green .kpi-value {
            color: #16a34a;
        }

        .kpi-green .kpi-sub {
            color: #86efac;
        }

        .kpi-red {
            background: #fef2f2;
        }

        .kpi-red .kpi-label {
            color: #b91c1c;
        }

        .kpi-red .kpi-value {
            color: #dc2626;
        }

        .kpi-red .kpi-sub {
            color: #fca5a5;
        }

        .kpi-blue {
            background: #eff6ff;
        }

        .kpi-blue .kpi-label {
            color: #1d4ed8;
        }

        .kpi-blue .kpi-value {
            color: #2563eb;
        }

        .kpi-blue .kpi-sub {
            color: #93c5fd;
        }

        /* ── SECCIÓN ── */
        .section {
            margin-bottom: 26px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            padding-bottom: 7px;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fbbf24;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: #6b7280;
        }

        /* ── CUENTAS ── */
        .cuentas-grid {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cuenta-card {
            flex: 1;
            min-width: 110px;
            background: #f8fafc;
            border-left: 3px solid #fbbf24;
            border-radius: 6px;
            padding: 10px 12px;
        }

        .cuenta-tipo {
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 2px;
        }

        .cuenta-nombre {
            font-size: 10px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .cuenta-saldo {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
        }

        /* ── TABLAS ── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }

        thead tr {
            background: #f8fafc;
        }

        th {
            padding: 8px 10px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 7px 10px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) td {
            background: #fafafa;
        }

        .text-right {
            text-align: right;
        }

        .fw {
            font-weight: 700;
        }

        .text-green {
            color: #16a34a;
            font-weight: 700;
        }

        .text-red {
            color: #dc2626;
            font-weight: 700;
        }

        .total-row td {
            background: #f8fafc !important;
            font-weight: 800;
            color: #0f172a;
            border-top: 2px solid #e2e8f0;
        }

        /* ── SUBCATEGORIA ── */
        .sub-cat {
            font-size: 8.5px;
            color: #94a3b8;
            margin-top: 1px;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 8.5px;
            font-weight: 700;
        }

        .badge-green {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-red {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-yellow {
            background: #fef9c3;
            color: #a16207;
        }

        /* ── BARRA PROGRESO ── */
        .prog-wrap {
            background: #e5e7eb;
            border-radius: 99px;
            height: 5px;
            width: 80px;
            display: inline-block;
            vertical-align: middle;
            overflow: hidden;
        }

        .prog-fill {
            height: 5px;
            border-radius: 99px;
        }

        /* ── FOOTER ── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 14px 36px;
            background: #0f172a;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            font-size: 9px;
            color: #475569;
        }

        .footer-right {
            font-size: 9px;
            color: #475569;
        }

        .footer-brand {
            font-size: 11px;
            font-weight: 700;
            color: #fbbf24;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-accent"></div>
        <div class="header-inner">
            <div class="header-left">
                <?php
                    $logoUrl = null;
                    if ($settings?->logo_dark) {
                        $path = storage_path('app/public/' . $settings->logo_dark);
                        if (file_exists($path)) {
                            $mime = mime_content_type($path);
                            $logoUrl = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
                        }
                    }
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logoUrl): ?>
                    <img src="<?php echo e($logoUrl); ?>" class="header-logo" alt="logo">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="header-meta">
                    <div class="header-sitename"><?php echo e($settings?->site_name ?? 'RICOX'); ?></div>
                    <div class="header-subtitle">Reporte Financiero Mensual</div>
                </div>
            </div>
            <div class="header-badge"><?php echo e(ucfirst($nombreMes)); ?></div>
        </div>
    </div>
    <div class="gold-band"></div>

    <div class="container">

        <div class="kpi-row">
            <div class="kpi-card kpi-green">
                <div class="kpi-label">Ingresos</div>
                <div class="kpi-value">S/ <?php echo e(number_format($totalIngresos, 2)); ?></div>
                <div class="kpi-sub"><?php echo e($ingresos->count()); ?> transacciones</div>
            </div>
            <div class="kpi-card kpi-red">
                <div class="kpi-label">Egresos</div>
                <div class="kpi-value">S/ <?php echo e(number_format($totalEgresos, 2)); ?></div>
                <div class="kpi-sub"><?php echo e($egresos->count()); ?> transacciones</div>
            </div>
            <div class="kpi-card kpi-blue">
                <div class="kpi-label">Ahorro Neto</div>
                <div class="kpi-value">S/ <?php echo e(number_format($ahorro, 2)); ?></div>
                <div class="kpi-sub">
                    <?php echo e($totalIngresos > 0 ? round(($ahorro / $totalIngresos) * 100, 1) : 0); ?>% de los ingresos
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-dot"></div>
                <div class="section-title">Saldo en Cuentas</div>
            </div>
            <div class="cuentas-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cuentas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuenta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="cuenta-card">
                        <div class="cuenta-tipo"><?php echo e($cuenta->tipo_cuenta); ?></div>
                        <div class="cuenta-nombre"><?php echo e($cuenta->nombre); ?></div>
                        <div class="cuenta-saldo">S/ <?php echo e(number_format($cuenta->saldo_actual, 2)); ?></div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gastosPorCategoria->count()): ?>
            <div class="section">
                <div class="section-header">
                    <div class="section-dot"></div>
                    <div class="section-title">Gastos por Categoría</div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">% del total</th>
                            <th>Distribución</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $gastosPorCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $pct = $totalEgresos > 0 ? round(($cat->total / $totalEgresos) * 100, 1) : 0; ?>
                            <tr>
                                <td class="fw"><?php echo e($cat->nombre); ?></td>
                                <td class="text-right text-red">S/ <?php echo e(number_format($cat->total, 2)); ?></td>
                                <td class="text-right"><?php echo e($pct); ?>%</td>
                                <td>
                                    <div class="prog-wrap">
                                        <div class="prog-fill" style="width:<?php echo e($pct); ?>%; background:#ef4444;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ingresos->count()): ?>
            <div class="section">
                <div class="section-header">
                    <div class="section-dot" style="background:#22c55e;"></div>
                    <div class="section-title">Detalle de Ingresos</div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cuenta</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th class="text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ingresos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($m->fecha->format('d/m/Y')); ?></td>
                                <td><?php echo e($m->cuenta?->nombre ?? '—'); ?></td>
                                <td>
                                    <div><?php echo e($m->categoria?->nombre ?? '—'); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($m->subcategoria?->nombre): ?>
                                        <div class="sub-cat">↳ <?php echo e($m->subcategoria->nombre); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td><?php echo e($m->descripcion ?? '—'); ?></td>
                                <td class="text-right text-green">S/ <?php echo e(number_format($m->monto, 2)); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr class="total-row">
                            <td colspan="4">Total Ingresos</td>
                            <td class="text-right text-green">S/ <?php echo e(number_format($totalIngresos, 2)); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($egresos->count()): ?>
            <div class="section">
                <div class="section-header">
                    <div class="section-dot" style="background:#ef4444;"></div>
                    <div class="section-title">Detalle de Egresos</div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cuenta</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th class="text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $egresos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($m->fecha->format('d/m/Y')); ?></td>
                                <td><?php echo e($m->cuenta?->nombre ?? '—'); ?></td>
                                <td>
                                    <div><?php echo e($m->categoria?->nombre ?? '—'); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($m->subcategoria?->nombre): ?>
                                        <div class="sub-cat">↳ <?php echo e($m->subcategoria->nombre); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td><?php echo e($m->descripcion ?? '—'); ?></td>
                                <td class="text-right text-red">S/ <?php echo e(number_format($m->monto, 2)); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr class="total-row">
                            <td colspan="4">Total Egresos</td>
                            <td class="text-right text-red">S/ <?php echo e(number_format($totalEgresos, 2)); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($presupuestos->count()): ?>
            <div class="section">
                <div class="section-header">
                    <div class="section-dot" style="background:#a78bfa;"></div>
                    <div class="section-title">Estado de Presupuestos</div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th class="text-right">Límite</th>
                            <th class="text-right">Gastado</th>
                            <th class="text-right">Disponible</th>
                            <th>Progreso</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $presupuestos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php
                                $disponible = $p['limite'] - $p['gasto'];
                                $bc = $p['superado'] ? '#ef4444' : ($p['porcentaje'] >= 80 ? '#f59e0b' : '#22c55e');
                            ?>
                            <tr>
                                <td class="fw"><?php echo e($p['nombre']); ?></td>
                                <td class="text-right">S/ <?php echo e(number_format($p['limite'], 2)); ?></td>
                                <td class="text-right text-red">S/ <?php echo e(number_format($p['gasto'], 2)); ?></td>
                                <td class="text-right"
                                    style="color:<?php echo e($disponible < 0 ? '#dc2626' : '#16a34a'); ?>; font-weight:700;">
                                    <?php echo e($disponible < 0 ? '-' : ''); ?>S/ <?php echo e(number_format(abs($disponible), 2)); ?>

                                </td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <div class="prog-wrap">
                                            <div class="prog-fill"
                                                style="width:<?php echo e(min(100, $p['porcentaje'])); ?>%; background:<?php echo e($bc); ?>;">
                                            </div>
                                        </div>
                                        <span style="font-size:8.5px; color:#6b7280;"><?php echo e($p['porcentaje']); ?>%</span>
                                    </div>
                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p['superado']): ?>
                                        <span class="badge badge-red">Superado</span>
                                    <?php elseif($p['porcentaje'] >= 80): ?>
                                        <span class="badge badge-yellow">En alerta</span>
                                    <?php else: ?>
                                        <span class="badge badge-green">OK</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    <div class="footer">
        <div>
            <div class="footer-brand"><?php echo e($settings?->site_name ?? 'RICOX'); ?></div>
            <div class="footer-left">Reporte Financiero Mensual</div>
        </div>
        <div class="footer-right">
            Generado el <?php echo e(now()->translatedFormat('d \d\e F \d\e Y')); ?>

        </div>
    </div>

</body>

</html>
<?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/pdf/reporte-mensual.blade.php ENDPATH**/ ?>
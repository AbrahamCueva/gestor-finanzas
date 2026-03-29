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

        .header {
            background: #0f172a;
            padding: 22px 30px;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .site-name {
            font-size: 15px;
            font-weight: 800;
            color: #fbbf24;
            letter-spacing: -0.02em;
        }

        .header-sub {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }

        .header-badge {
            background: #fbbf24;
            color: #0f172a;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 800;
        }

        .gold-band {
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #f59e0b, #d97706);
            margin-bottom: 22px;
        }

        .container {
            padding: 0 30px;
        }

        .kpi-row {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }

        .kpi-card {
            flex: 1;
            border-radius: 7px;
            padding: 10px 12px;
        }

        .kpi-label {
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 3px;
        }

        .kpi-value {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .kpi-sub {
            font-size: 7.5px;
            margin-top: 2px;
            color: #6b7280;
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

        .kpi-yellow {
            background: #fffbeb;
        }

        .kpi-yellow .kpi-label {
            color: #b45309;
        }

        .kpi-yellow .kpi-value {
            color: #d97706;
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

        .kpi-green {
            background: #f0fdf4;
        }

        .kpi-green .kpi-label {
            color: #15803d;
        }

        .kpi-green .kpi-value {
            color: #16a34a;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 7px;
            padding-bottom: 5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .section-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        thead tr {
            background: #f8fafc;
        }

        th {
            padding: 6px 7px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 5px 7px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) td {
            background: #fafafa;
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

        .text-blue {
            color: #2563eb;
            font-weight: 700;
        }

        .text-yellow {
            color: #d97706;
            font-weight: 700;
        }

        .prog-wrap {
            background: #e5e7eb;
            border-radius: 99px;
            height: 4px;
            overflow: hidden;
            width: 60px;
            display: inline-block;
            vertical-align: middle;
        }

        .prog-fill {
            height: 4px;
            border-radius: 99px;
        }

        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 99px;
            font-size: 7.5px;
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

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px 30px;
            background: #0f172a;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-brand {
            font-size: 10px;
            font-weight: 700;
            color: #fbbf24;
        }

        .footer-right {
            font-size: 7.5px;
            color: #475569;
        }
    </style>
</head>

<body>

    @php
        $settings = $settings ?? null;
        $metas = $metas ?? collect();
        $deudas = $deudas ?? collect();
        $totalDebo = $totalDebo ?? 0;
        $totalMeDeben = $totalMeDeben ?? 0;
        $totalMetas = $totalMetas ?? 0;
        $metasCompletas = $metasCompletas ?? 0;
        $generadoEn = $generadoEn ?? now()->format('d/m/Y');

        $logoUrl = null;
        if ($settings?->logo_dark) {
            $path = storage_path('app/public/' . $settings->logo_dark);
            if (file_exists($path)) {
                $mime = mime_content_type($path);
                $logoUrl = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
            }
        }
    @endphp

    <div class="header">
        <div class="header-inner">
            <div class="header-left">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" style="height:32px; width:auto;" alt="logo">
                @endif
                <div>
                    <div class="site-name">{{ $settings?->site_name ?? 'RICOX' }}</div>
                    <div class="header-sub">Reporte de Metas y Deudas</div>
                </div>
            </div>
            <div class="header-badge">{{ now()->format('d/m/Y') }}</div>
        </div>
    </div>
    <div class="gold-band"></div>

    <div class="container">

        <div class="kpi-row">
            <div class="kpi-card kpi-blue">
                <div class="kpi-label">Metas activas</div>
                <div class="kpi-value">{{ $metas->where('completada', false)->count() }}</div>
                <div class="kpi-sub">{{ $metasCompletas }} completadas</div>
            </div>
            <div class="kpi-card kpi-yellow">
                <div class="kpi-label">Falta ahorrar</div>
                <div class="kpi-value">S/ {{ number_format($totalMetas, 2) }}</div>
                <div class="kpi-sub">en metas activas</div>
            </div>
            <div class="kpi-card kpi-red">
                <div class="kpi-label">Total que debo</div>
                <div class="kpi-value">S/ {{ number_format($totalDebo, 2) }}</div>
                <div class="kpi-sub">pendiente de pago</div>
            </div>
            <div class="kpi-card kpi-green">
                <div class="kpi-label">Me deben</div>
                <div class="kpi-value">S/ {{ number_format($totalMeDeben, 2) }}</div>
                <div class="kpi-sub">pendiente de cobro</div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-dot" style="background:#60a5fa;"></div>
                <div class="section-title">Metas de Ahorro</div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ahorrado</th>
                        <th>Objetivo</th>
                        <th>Progreso</th>
                        <th>Falta</th>
                        <th>Fecha límite</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($metas as $m)
                        @php
                            $pct = $m->porcentaje();
                            $bc = $pct >= 100 ? '#22c55e' : ($pct >= 50 ? '#f59e0b' : '#60a5fa');
                        @endphp
                        <tr>
                            <td class="fw">{{ $m->nombre }}</td>
                            <td class="text-green">S/ {{ number_format($m->monto_actual, 2) }}</td>
                            <td>S/ {{ number_format($m->monto_objetivo, 2) }}</td>
                            <td>
                                <div class="prog-wrap">
                                    <div class="prog-fill"
                                        style="width:{{ min(100, $pct) }}%; background:{{ $bc }};"></div>
                                </div>
                                <span
                                    style="font-size:8px; color:{{ $bc }}; font-weight:700; margin-left:4px;">{{ $pct }}%</span>
                            </td>
                            <td>S/ {{ number_format($m->restante(), 2) }}</td>
                            <td>{{ $m->fecha_limite?->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                @if ($m->completada)
                                    <span class="badge badge-green">Completada</span>
                                @else
                                    <span class="badge badge-blue">En progreso</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-dot" style="background:#f59e0b;"></div>
                <div class="section-title">Deudas y Préstamos</div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Persona/Entidad</th>
                        <th>Total</th>
                        <th>Pagado</th>
                        <th>Restante</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deudas as $d)
                        <tr>
                            <td class="fw">{{ $d->nombre }}</td>
                            <td>
                                <span class="badge {{ $d->tipo === 'debo' ? 'badge-red' : 'badge-green' }}">
                                    {{ $d->tipo === 'debo' ? 'Debo' : 'Me deben' }}
                                </span>
                            </td>
                            <td>{{ $d->acreedor_deudor }}</td>
                            <td>S/ {{ number_format($d->monto_total, 2) }}</td>
                            <td class="text-green">S/ {{ number_format($d->monto_pagado, 2) }}</td>
                            <td class="text-red">S/ {{ number_format($d->restante(), 2) }}</td>
                            <td style="{{ $d->estaVencida() ? 'color:#dc2626; font-weight:700;' : '' }}">
                                {{ $d->fecha_vencimiento?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td>
                                @if ($d->estado === 'pagada')
                                    <span class="badge badge-green">Pagada</span>
                                @elseif($d->estado === 'vencida' || $d->estaVencida())
                                    <span class="badge badge-red">Vencida</span>
                                @else
                                    <span class="badge badge-yellow">Pendiente</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="footer">
        <div>
            <div class="footer-brand">{{ $settings?->site_name ?? 'RICOX' }}</div>
            <div style="font-size:7.5px; color:#475569;">Reporte de Metas y Deudas</div>
        </div>
        <div class="footer-right">Generado el {{ $generadoEn }}</div>
    </div>

</body>

</html>

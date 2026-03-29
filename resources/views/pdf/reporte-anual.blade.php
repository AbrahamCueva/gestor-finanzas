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
            padding: 24px 32px;
            margin-bottom: 0;
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
            font-size: 16px;
            font-weight: 800;
            color: #fbbf24;
            letter-spacing: -0.02em;
        }

        .header-subtitle {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }

        .anio-badge {
            background: #fbbf24;
            color: #0f172a;
            padding: 5px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 800;
        }

        .gold-band {
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #f59e0b, #d97706);
            margin-bottom: 24px;
        }

        .container {
            padding: 0 32px;
        }

        /* KPIs */
        .kpi-row {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .kpi-card {
            flex: 1;
            border-radius: 8px;
            padding: 12px 14px;
        }

        .kpi-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 4px;
        }

        .kpi-value {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .kpi-sub {
            font-size: 8px;
            margin-top: 2px;
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

        .kpi-blue {
            background: #eff6ff;
        }

        .kpi-blue .kpi-label {
            color: #1d4ed8;
        }

        .kpi-blue .kpi-value {
            color: #2563eb;
        }

        /* Highlights */
        .hl-row {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .hl-card {
            flex: 1;
            background: #f8fafc;
            border-left: 3px solid #fbbf24;
            border-radius: 6px;
            padding: 10px 12px;
        }

        .hl-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 3px;
        }

        .hl-mes {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
        }

        .hl-val {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Sección */
        .section {
            margin-bottom: 22px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #fbbf24;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: #6b7280;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }

        thead tr {
            background: #f8fafc;
        }

        th {
            padding: 7px 8px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 6px 8px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
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

        .text-blue {
            color: #2563eb;
            font-weight: 700;
        }

        .text-orange {
            color: #ea580c;
            font-weight: 700;
        }

        .total-row td {
            background: #f8fafc !important;
            font-weight: 800;
            color: #0f172a;
            border-top: 2px solid #e2e8f0;
        }

        /* Barras */
        .prog-wrap {
            background: #e5e7eb;
            border-radius: 99px;
            height: 4px;
            overflow: hidden;
        }

        .prog-fill {
            height: 4px;
            border-radius: 99px;
        }

        /* Cuentas */
        .cuentas-grid {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .cuenta-card {
            flex: 1;
            min-width: 100px;
            background: #f8fafc;
            border-left: 3px solid #fbbf24;
            border-radius: 6px;
            padding: 8px 10px;
        }

        .cuenta-tipo {
            font-size: 7.5px;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 1px;
        }

        .cuenta-nombre {
            font-size: 9px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 3px;
        }

        .cuenta-saldo {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
        }

        /* Presupuestos */
        .budget-grid {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .budget-card {
            flex: 1;
            min-width: 130px;
            background: #f8fafc;
            border-radius: 6px;
            padding: 8px 10px;
        }

        .budget-name {
            font-size: 9px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .budget-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 8.5px;
            color: #6b7280;
        }

        .badge {
            display: inline-block;
            padding: 1px 7px;
            border-radius: 99px;
            font-size: 8px;
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

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 32px;
            background: #0f172a;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-brand {
            font-size: 11px;
            font-weight: 700;
            color: #fbbf24;
        }

        .footer-right {
            font-size: 8px;
            color: #475569;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-inner">
            <div class="header-left">
                @php
                    $logoUrl = null;
                    if ($settings?->logo_dark) {
                        $path = storage_path('app/public/' . $settings->logo_dark);
                        if (file_exists($path)) {
                            $mime = mime_content_type($path);
                            $logoUrl = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
                        }
                    }
                @endphp
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" style="height:36px; width:auto;" alt="logo">
                @endif
                <div>
                    <div class="site-name">{{ $settings?->site_name ?? 'RICOX' }}</div>
                    <div class="header-subtitle">Reporte Financiero Anual</div>
                </div>
            </div>
            <div class="anio-badge">{{ $anio }}</div>
        </div>
    </div>
    <div class="gold-band"></div>

    <div class="container">

        <div class="kpi-row">
            <div class="kpi-card kpi-green">
                <div class="kpi-label">Ingresos anuales</div>
                <div class="kpi-value">S/ {{ number_format($totalIngresos, 2) }}</div>
                <div class="kpi-sub">Prom. S/ {{ number_format($totalIngresos / 12, 2) }}/mes</div>
            </div>
            <div class="kpi-card kpi-red">
                <div class="kpi-label">Egresos anuales</div>
                <div class="kpi-value">S/ {{ number_format($totalEgresos, 2) }}</div>
                <div class="kpi-sub">Prom. S/ {{ number_format($totalEgresos / 12, 2) }}/mes</div>
            </div>
            <div class="kpi-card kpi-blue">
                <div class="kpi-label">Ahorro anual</div>
                <div class="kpi-value">S/ {{ number_format($totalAhorro, 2) }}</div>
                <div class="kpi-sub">{{ $totalIngresos > 0 ? round(($totalAhorro / $totalIngresos) * 100, 1) : 0 }}% de
                    los ingresos</div>
            </div>
        </div>

        <div class="hl-row">
            <div class="hl-card">
                <div class="hl-label">🏆 Mejor mes</div>
                <div class="hl-mes">{{ $mejorMes['mes'] }}</div>
                <div class="hl-val">S/ {{ number_format($mejorMes['ahorro'], 2) }} ahorrado</div>
            </div>
            <div class="hl-card">
                <div class="hl-label">📉 Mes más ajustado</div>
                <div class="hl-mes">{{ $peorMes['mes'] }}</div>
                <div class="hl-val">S/ {{ number_format($peorMes['ahorro'], 2) }} ahorrado</div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-dot"></div>
                <div class="section-title">Resumen por Mes</div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th class="text-right">Ingresos</th>
                        <th class="text-right">Egresos</th>
                        <th class="text-right">Ahorro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meses as $m)
                        <tr>
                            <td class="fw">{{ $m['mes'] }}</td>
                            <td class="text-right text-green">S/ {{ number_format($m['ingresos'], 2) }}</td>
                            <td class="text-right text-red">S/ {{ number_format($m['egresos'], 2) }}</td>
                            <td class="text-right {{ $m['ahorro'] >= 0 ? 'text-blue' : 'text-orange' }}">
                                S/ {{ number_format($m['ahorro'], 2) }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Total {{ $anio }}</td>
                        <td class="text-right text-green">S/ {{ number_format($totalIngresos, 2) }}</td>
                        <td class="text-right text-red">S/ {{ number_format($totalEgresos, 2) }}</td>
                        <td class="text-right {{ $totalAhorro >= 0 ? 'text-blue' : 'text-orange' }}">S/
                            {{ number_format($totalAhorro, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($topCategorias->count())
            <div class="section">
                <div class="section-header">
                    <div class="section-dot" style="background:#ef4444;"></div>
                    <div class="section-title">Top Categorías de Gasto</div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Categoría</th>
                            <th class="text-right">Total gastado</th>
                            <th class="text-right">% del total</th>
                            <th>Distribución</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topCategorias as $i => $cat)
                            @php $pct = $totalEgresos > 0 ? round(($cat->total / $totalEgresos) * 100, 1) : 0; @endphp
                            <tr>
                                <td style="color:#94a3b8;">{{ $i + 1 }}</td>
                                <td class="fw">{{ $cat->nombre }}</td>
                                <td class="text-right text-red">S/ {{ number_format($cat->total, 2) }}</td>
                                <td class="text-right">{{ $pct }}%</td>
                                <td style="width:80px;">
                                    <div class="prog-wrap">
                                        <div class="prog-fill" style="width:{{ $pct }}%; background:#ef4444;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="section">
            <div class="section-header">
                <div class="section-dot" style="background:#60a5fa;"></div>
                <div class="section-title">Saldo en Cuentas</div>
            </div>
            <div class="cuentas-grid">
                @foreach ($cuentas as $cuenta)
                    <div class="cuenta-card">
                        <div class="cuenta-tipo">{{ $cuenta->tipo_cuenta }}</div>
                        <div class="cuenta-nombre">{{ $cuenta->nombre }}</div>
                        <div class="cuenta-saldo">S/ {{ number_format($cuenta->saldo_actual, 2) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        @if ($presupuestos->count())
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
                            <th>Progreso</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presupuestos as $p)
                            @php $bc = $p['superado'] ? '#ef4444' : ($p['porcentaje'] >= 80 ? '#f59e0b' : '#22c55e'); @endphp
                            <tr>
                                <td class="fw">{{ $p['nombre'] }}</td>
                                <td class="text-right">S/ {{ number_format($p['limite'], 2) }}</td>
                                <td class="text-right text-red">S/ {{ number_format($p['gasto'], 2) }}</td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:5px;">
                                        <div class="prog-wrap" style="width:70px;">
                                            <div class="prog-fill"
                                                style="width:{{ min(100, $p['porcentaje']) }}%; background:{{ $bc }};">
                                            </div>
                                        </div>
                                        <span style="font-size:8px; color:#6b7280;">{{ $p['porcentaje'] }}%</span>
                                    </div>
                                </td>
                                <td>
                                    @if ($p['superado'])
                                        <span class="badge badge-red">Superado</span>
                                    @elseif($p['porcentaje'] >= 80)
                                        <span class="badge badge-yellow">Alerta</span>
                                    @else
                                        <span class="badge badge-green">OK</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

    <div class="footer">
        <div>
            <div class="footer-brand">{{ $settings?->site_name ?? 'RICOX' }}</div>
            <div style="font-size:8px; color:#475569;">Reporte Financiero Anual {{ $anio }}</div>
        </div>
        <div class="footer-right">Generado el {{ now()->translatedFormat('d \d\e F \d\e Y') }}</div>
    </div>

</body>

</html>

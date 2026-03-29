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

        .site-name {
            font-size: 15px;
            font-weight: 800;
            color: #fbbf24;
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

        .cuenta-header {
            background: #f8fafc;
            border-radius: 7px;
            padding: 12px 14px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
        }

        .cuenta-nombre {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
        }

        .cuenta-tipo {
            font-size: 9px;
            color: #6b7280;
            margin-top: 2px;
        }

        .cuenta-saldo {
            font-size: 14px;
            font-weight: 800;
            color: #fbbf24;
        }

        .kpi-row {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }

        .kpi {
            flex: 1;
            background: #f8fafc;
            border-radius: 6px;
            padding: 8px 10px;
        }

        .kpi-label {
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .kpi-value {
            font-size: 12px;
            font-weight: 800;
        }

        .section-title {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5px;
            margin-bottom: 16px;
        }

        th {
            padding: 5px 6px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            font-size: 7.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 4px 6px;
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
        }

        .text-red {
            color: #dc2626;
        }

        .text-blue {
            color: #2563eb;
        }

        .text-orange {
            color: #ea580c;
        }

        .badge {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 99px;
            font-size: 7px;
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

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-orange {
            background: #ffedd5;
            color: #c2410c;
        }

        .bar-wrap {
            background: #e5e7eb;
            border-radius: 99px;
            height: 3px;
            overflow: hidden;
            width: 60px;
            display: inline-block;
            vertical-align: middle;
        }

        .bar-fill {
            height: 3px;
            border-radius: 99px;
            background: #fbbf24;
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
        }

        .footer-brand {
            font-size: 9px;
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
        $cuenta = $cuenta ?? null;
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
            <div>
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" style="height:32px; width:auto;" alt="logo">
                @endif
                <div class="site-name">{{ $settings?->site_name ?? 'RICOX' }}</div>
                <div class="header-sub">Reporte por Cuenta</div>
            </div>
            <div class="header-badge">{{ now()->format('d/m/Y') }}</div>
        </div>
    </div>
    <div class="gold-band"></div>

    <div class="container">

        <div class="cuenta-header">
            <div>
                <div class="cuenta-nombre">{{ $cuenta?->nombre }}</div>
                <div class="cuenta-tipo">{{ $cuenta?->tipo_cuenta }} · {{ $cuenta?->moneda }} · Período:
                    {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} —
                    {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</div>
            </div>
            <div class="cuenta-saldo">S/ {{ number_format($cuenta?->saldo_actual ?? 0, 2) }}</div>
        </div>

        <div class="kpi-row">
            <div class="kpi">
                <div class="kpi-label">Ingresos</div>
                <div class="kpi-value text-green">S/ {{ number_format($totalIngresos ?? 0, 2) }}</div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Egresos</div>
                <div class="kpi-value text-red">S/ {{ number_format($totalEgresos ?? 0, 2) }}</div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Transf. salida</div>
                <div class="kpi-value text-orange">S/ {{ number_format($totalTransfSalida ?? 0, 2) }}</div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Transf. entrada</div>
                <div class="kpi-value text-blue">S/ {{ number_format($totalTransfEntrada ?? 0, 2) }}</div>
            </div>
        </div>

        @if (($gastosPorCategoria ?? collect())->count())
            <div class="section-title">Gastos por Categoría</div>
            <table>
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th class="text-right">Monto</th>
                        <th class="text-right">%</th>
                        <th>Distribución</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gastosPorCategoria as $cat => $total)
                        @php $pct = ($totalEgresos ?? 0) > 0 ? round(($total / $totalEgresos) * 100, 1) : 0; @endphp
                        <tr>
                            <td>{{ $cat }}</td>
                            <td class="text-right fw">S/ {{ number_format($total, 2) }}</td>
                            <td class="text-right">{{ $pct }}%</td>
                            <td>
                                <div class="bar-wrap">
                                    <div class="bar-fill" style="width:{{ $pct }}%;"></div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if (($movimientos ?? collect())->count())
            <div class="section-title">Movimientos ({{ $movimientos->count() }})</div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th class="text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movimientos as $m)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y') }}</td>
                            <td>
                                <span
                                    class="badge {{ $m->tipo_movimiento === 'ingreso' ? 'badge-green' : 'badge-red' }}">
                                    {{ ucfirst($m->tipo_movimiento) }}
                                </span>
                            </td>
                            <td>{{ $m->categoria?->nombre ?? '—' }}</td>
                            <td>{{ $m->descripcion ?: '—' }}</td>
                            <td
                                class="text-right fw {{ $m->tipo_movimiento === 'ingreso' ? 'text-green' : 'text-red' }}">
                                {{ $m->tipo_movimiento === 'ingreso' ? '+' : '-' }}S/
                                {{ number_format($m->monto, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if (($transferenciasOrigen ?? collect())->count() || ($transferenciasDestino ?? collect())->count())
            <div class="section-title">Transferencias</div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Cuenta</th>
                        <th>Descripción</th>
                        <th class="text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transferenciasOrigen ?? [] as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->fecha)->format('d/m/Y') }}</td>
                            <td><span class="badge badge-orange">Salida</span></td>
                            <td>→ {{ $t->cuentaDestino?->nombre }}</td>
                            <td>{{ $t->descripcion ?: '—' }}</td>
                            <td class="text-right fw text-orange">-S/ {{ number_format($t->monto, 2) }}</td>
                        </tr>
                    @endforeach
                    @foreach ($transferenciasDestino ?? [] as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->fecha)->format('d/m/Y') }}</td>
                            <td><span class="badge badge-blue">Entrada</span></td>
                            <td>← {{ $t->cuentaOrigen?->nombre }}</td>
                            <td>{{ $t->descripcion ?: '—' }}</td>
                            <td class="text-right fw text-blue">+S/ {{ number_format($t->monto, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    <div class="footer">
        <div class="footer-brand">{{ $settings?->site_name ?? 'RICOX' }}</div>
        <div class="footer-right">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

</body>

</html>

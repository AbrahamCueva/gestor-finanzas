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

        .section-title {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        .cuenta-header {
            background: #f8fafc;
            border-radius: 7px;
            padding: 12px 14px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .escenario-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 8px;
            font-weight: 700;
            margin-left: 8px;
        }

        .escenario-actual {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .escenario-optimista {
            background: #dcfce7;
            color: #15803d;
        }

        .escenario-pesimista {
            background: #fee2e2;
            color: #b91c1c;
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
            font-size: 13px;
            font-weight: 800;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 16px;
        }

        th {
            padding: 5px 7px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            font-size: 7.5px;
            text-transform: uppercase;
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

        .text-yellow {
            color: #d97706;
        }

        .arrow-up {
            color: #16a34a;
        }

        .arrow-down {
            color: #dc2626;
        }

        .info-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 16px;
            font-size: 8px;
            color: #92400e;
            line-height: 1.5;
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
        $datos = $datos ?? [];
        $meses = $meses ?? 6;
        $escenario = $escenario ?? 'actual';
        $logoUrl = null;

        if ($settings?->logo_dark) {
            $path = storage_path('app/public/' . $settings->logo_dark);
            if (file_exists($path)) {
                $mime = mime_content_type($path);
                $logoUrl = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
            }
        }

        $escenarioLabel = match ($escenario) {
            'optimista' => 'Optimista (+15% ing, -10% egr)',
            'pesimista' => 'Pesimista (-15% ing, +15% egr)',
            default => 'Escenario actual',
        };
        $escenarioColor = match ($escenario) {
            'optimista' => '#16a34a',
            'pesimista' => '#dc2626',
            default => '#2563eb',
        };
    @endphp

    <div class="header">
        <div class="header-inner">
            <div>
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" style="height:28px; width:auto; margin-bottom:4px;" alt="logo">
                @endif
                <div class="site-name">{{ $settings?->site_name ?? 'RICOX' }}</div>
                <div class="header-sub">Proyección de Saldo</div>
            </div>
            <div class="header-badge">{{ now()->format('d/m/Y') }}</div>
        </div>
    </div>
    <div class="gold-band"></div>

    <div class="container">

        <div class="cuenta-header">
            <div>
                <div class="cuenta-nombre">
                    {{ $cuenta?->nombre }}
                    <span class="escenario-badge escenario-{{ $escenario }}">{{ $escenarioLabel }}</span>
                </div>
                <div class="cuenta-tipo">{{ $cuenta?->tipo_cuenta }} · {{ $cuenta?->moneda }} · Proyección
                    {{ $meses }} meses</div>
            </div>
            <div class="cuenta-saldo">S/ {{ number_format($cuenta?->saldo_actual ?? 0, 2) }}</div>
        </div>

        <div class="info-box">
            ⚠ Esta proyección está basada en el promedio de los últimos 3 meses de actividad.
            Los resultados son estimados y pueden variar según el comportamiento financiero real.
        </div>

        <div class="kpi-row">
            <div class="kpi">
                <div class="kpi-label">Saldo actual</div>
                <div class="kpi-value text-yellow">S/ {{ number_format($cuenta?->saldo_actual ?? 0, 2) }}</div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Saldo proyectado</div>
                <div class="kpi-value" style="color:{{ $escenarioColor }};">
                    S/ {{ number_format($datos['saldoFinal'] ?? 0, 2) }}
                </div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Ingreso mensual est.</div>
                <div class="kpi-value text-green">S/ {{ number_format($datos['ingMes'] ?? 0, 2) }}</div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Egreso mensual est.</div>
                <div class="kpi-value text-red">S/ {{ number_format($datos['egrMes'] ?? 0, 2) }}</div>
            </div>
        </div>

        <div class="section-title">Proyección mes a mes</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mes</th>
                    <th class="text-right">Ingresos est.</th>
                    <th class="text-right">Egresos est.</th>
                    <th class="text-right">Ahorro est.</th>
                    <th class="text-right">Saldo proyectado</th>
                    <th class="text-right">Variación</th>
                </tr>
            </thead>
            <tbody>
                @php $saldoAnterior = $cuenta?->saldo_actual ?? 0; @endphp
                @foreach ($datos['proyeccion'] ?? [] as $i => $fila)
                    @php
                        $sube = $fila['saldo'] >= $saldoAnterior;
                        $variacion = $fila['saldo'] - $saldoAnterior;
                    @endphp
                    <tr>
                        <td style="color:#9ca3af;">{{ $i + 1 }}</td>
                        <td class="fw">{{ $fila['mes'] }}</td>
                        <td class="text-right text-green fw">S/ {{ number_format($fila['ingresos'], 2) }}</td>
                        <td class="text-right text-red fw">S/ {{ number_format($fila['egresos'], 2) }}</td>
                        <td class="text-right {{ $fila['ahorro'] >= 0 ? 'text-blue' : 'text-red' }} fw">
                            {{ $fila['ahorro'] >= 0 ? '+' : '' }}S/ {{ number_format($fila['ahorro'], 2) }}
                        </td>
                        <td class="text-right fw" style="color:{{ $escenarioColor }};">
                            S/ {{ number_format($fila['saldo'], 2) }}
                        </td>
                        <td class="text-right {{ $sube ? 'arrow-up' : 'arrow-down' }} fw">
                            {{ $sube ? '↑' : '↓' }} S/ {{ number_format(abs($variacion), 2) }}
                        </td>
                    </tr>
                    @php $saldoAnterior = $fila['saldo']; @endphp
                @endforeach
            </tbody>
        </table>

        <div class="section-title">Base del cálculo — Promedio últimos 3 meses</div>
        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th class="text-right">Promedio histórico</th>
                    <th class="text-right">Ajuste escenario</th>
                    <th class="text-right">Valor usado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ingresos mensuales</td>
                    <td class="text-right">S/ {{ number_format($datos['promedioIngresos'] ?? 0, 2) }}</td>
                    <td class="text-right">
                        {{ match ($escenario) {'optimista' => '+15%','pesimista' => '-15%',default => '0%'} }}
                    </td>
                    <td class="text-right fw text-green">S/ {{ number_format($datos['ingMes'] ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td>Egresos mensuales</td>
                    <td class="text-right">S/ {{ number_format($datos['promedioEgresos'] ?? 0, 2) }}</td>
                    <td class="text-right">
                        {{ match ($escenario) {'optimista' => '-10%','pesimista' => '+15%',default => '0%'} }}
                    </td>
                    <td class="text-right fw text-red">S/ {{ number_format($datos['egrMes'] ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td class="fw">Ahorro neto mensual</td>
                    <td class="text-right">S/ {{ number_format($datos['promedioAhorro'] ?? 0, 2) }}</td>
                    <td class="text-right">—</td>
                    <td class="text-right fw text-blue">
                        {{ ($datos['ahoMes'] ?? 0) >= 0 ? '+' : '' }}S/ {{ number_format($datos['ahoMes'] ?? 0, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="footer">
        <div class="footer-brand">{{ $settings?->site_name ?? 'RICOX' }}</div>
        <div class="footer-right">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

</body>

</html>

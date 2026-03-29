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
            font-size: 9px;
            color: #374151;
        }

        .header {
            background: #0f172a;
            padding: 18px 24px;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .site-name {
            font-size: 14px;
            font-weight: 800;
            color: #fbbf24;
        }

        .header-sub {
            font-size: 8px;
            color: #64748b;
            margin-top: 2px;
        }

        .header-badge {
            background: #fbbf24;
            color: #0f172a;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 9px;
            font-weight: 800;
        }

        .gold-band {
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #f59e0b, #d97706);
            margin-bottom: 18px;
        }

        .container {
            padding: 0 24px;
        }

        .periodo {
            font-size: 8px;
            color: #6b7280;
            margin-bottom: 12px;
            background: #f8fafc;
            padding: 6px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .kpi-row {
            display: flex;
            gap: 6px;
            margin-bottom: 14px;
        }

        .kpi {
            flex: 1;
            background: #f8fafc;
            border-radius: 5px;
            padding: 7px 9px;
        }

        .kpi-label {
            font-size: 7px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .kpi-value {
            font-size: 12px;
            font-weight: 800;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        th {
            padding: 5px 6px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            font-size: 7px;
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

        tfoot td {
            font-weight: 800;
            background: #f1f5f9;
            border-top: 2px solid #e2e8f0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
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

        .text-orange {
            color: #ea580c;
        }

        .bar-wrap {
            background: #e5e7eb;
            border-radius: 99px;
            height: 3px;
            overflow: hidden;
            width: 50px;
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
            padding: 7px 24px;
            background: #0f172a;
            display: flex;
            justify-content: space-between;
        }

        .footer-brand {
            font-size: 8px;
            font-weight: 700;
            color: #fbbf24;
        }

        .footer-right {
            font-size: 7px;
            color: #475569;
        }
    </style>
</head>

<body>

    @php
        $settings = $settings ?? null;
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
                    <img src="{{ $logoUrl }}" style="height:24px; width:auto; margin-bottom:3px;" alt="logo">
                @endif
                <div class="site-name">{{ $settings?->site_name ?? 'RICOX' }}</div>
                <div class="header-sub">Reporte Comparativo de Cuentas</div>
            </div>
            <div class="header-badge">{{ now()->format('d/m/Y') }}</div>
        </div>
    </div>
    <div class="gold-band"></div>

    <div class="container">

        <div class="periodo">
            Período: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} —
            {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}
        </div>

        <div class="kpi-row">
            <div class="kpi">
                <div class="kpi-label">Saldo total</div>
                <div class="kpi-value text-yellow">S/ {{ number_format($totalSaldo, 2) }}</div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Total ingresos</div>
                <div class="kpi-value text-green">S/ {{ number_format($totalIngresos, 2) }}</div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Total egresos</div>
                <div class="kpi-value text-red">S/ {{ number_format($totalEgresos, 2) }}</div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Ahorro neto</div>
                <div class="kpi-value {{ $totalAhorro >= 0 ? 'text-blue' : 'text-red' }}">
                    S/ {{ number_format($totalAhorro, 2) }}
                </div>
            </div>
            <div class="kpi">
                <div class="kpi-label">Cuentas activas</div>
                <div class="kpi-value">{{ count($datos) }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Cuenta</th>
                    <th>Tipo</th>
                    <th class="text-right">Saldo actual</th>
                    <th>% Total</th>
                    <th class="text-right">Ingresos</th>
                    <th class="text-right">Egresos</th>
                    <th class="text-right">Ahorro</th>
                    <th class="text-right">T. Salida</th>
                    <th class="text-right">T. Entrada</th>
                    <th class="text-center">Movs.</th>
                    <th>Top Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $fila)
                    <tr>
                        <td class="fw">{{ $fila['cuenta']->nombre }}</td>
                        <td style="text-transform:capitalize;">{{ $fila['cuenta']->tipo_cuenta }}</td>
                        <td class="text-right fw text-yellow">S/ {{ number_format($fila['cuenta']->saldo_actual, 2) }}
                        </td>
                        <td>
                            <div class="bar-wrap">
                                <div class="bar-fill" style="width:{{ $fila['pctSaldo'] }}%;"></div>
                            </div>
                            <span style="margin-left:3px;">{{ $fila['pctSaldo'] }}%</span>
                        </td>
                        <td class="text-right fw text-green">S/ {{ number_format($fila['ingresos'], 2) }}</td>
                        <td class="text-right fw text-red">S/ {{ number_format($fila['egresos'], 2) }}</td>
                        <td class="text-right fw {{ $fila['ahorro'] >= 0 ? 'text-blue' : 'text-red' }}">
                            {{ $fila['ahorro'] >= 0 ? '+' : '' }}S/ {{ number_format($fila['ahorro'], 2) }}
                        </td>
                        <td class="text-right text-orange">
                            {{ $fila['transferSalida'] > 0 ? 'S/ ' . number_format($fila['transferSalida'], 2) : '—' }}
                        </td>
                        <td class="text-right text-blue">
                            {{ $fila['transferEntrada'] > 0 ? 'S/ ' . number_format($fila['transferEntrada'], 2) : '—' }}
                        </td>
                        <td class="text-center fw">{{ $fila['movimientos'] }}</td>
                        <td style="color:#6b7280;">{{ $fila['topCategoria'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">TOTAL</td>
                    <td class="text-right text-yellow">S/ {{ number_format($totalSaldo, 2) }}</td>
                    <td>100%</td>
                    <td class="text-right text-green">S/ {{ number_format($totalIngresos, 2) }}</td>
                    <td class="text-right text-red">S/ {{ number_format($totalEgresos, 2) }}</td>
                    <td class="text-right {{ $totalAhorro >= 0 ? 'text-blue' : 'text-red' }}">
                        S/ {{ number_format($totalAhorro, 2) }}
                    </td>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        </table>

    </div>

    <div class="footer">
        <div class="footer-brand">{{ $settings?->site_name ?? 'RICOX' }}</div>
        <div class="footer-right">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

</body>

</html>

<x-filament-panels::page>
    @php
        $datos = $this->getDatos();
        $cuenta = $datos['cuenta'] ?? null;
    @endphp

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

        .ps-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ps-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ps-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .ps-filtros {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .ps-select,
        .ps-input {
            font-size: 0.85rem;
            padding: 0.5rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-text);
            outline: none;
            cursor: pointer;
        }

        .ps-select:focus,
        .ps-input:focus {
            border-color: #fbbf24;
        }

        .ps-escenarios {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .ps-esc-btn {
            padding: 0.35rem 0.875rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .ps-esc-btn:hover {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .ps-esc-btn.activo-actual {
            background: #60a5fa22;
            color: #60a5fa;
        }

        .ps-esc-btn.activo-optimista {
            background: #22c55e22;
            color: #22c55e;
        }

        .ps-esc-btn.activo-pesimista {
            background: #ef444422;
            color: #ef4444;
        }

        .ps-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
            margin-bottom: 1rem;
        }

        @media(max-width:768px) {
            .ps-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .ps-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .ps-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .ps-kpi-value {
            font-size: 1rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .ps-kpi-sub {
            font-size: 0.62rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        .ps-chart-wrap {
            position: relative;
            height: 300px;
            margin-bottom: 1rem;
        }

        .ps-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .ps-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .ps-table td {
            padding: 0.5rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
        }

        .ps-table tr:last-child td {
            border-bottom: none;
        }

        .ps-table tr:hover td {
            background: var(--w-card);
        }

        .ps-info {
            background: rgba(96, 165, 250, 0.08);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            line-height: 1.5;
            display: flex;
            gap: 0.625rem;
            align-items: flex-start;
        }

        .ps-info svg {
            width: 16px;
            height: 16px;
            color: #60a5fa;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .ps-meses-btns {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
        }

        .ps-mes-btn {
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .ps-mes-btn.activo {
            background: #fbbf24;
            color: #0f172a;
        }

        .ps-mes-btn:hover:not(.activo) {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }
    </style>

    <div class="ps-wrap">

        <div class="ps-info">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            La proyección se basa en el promedio de tus últimos 3 meses. El escenario optimista asume +15% ingresos y
            −10% egresos; el pesimista −15% ingresos y +15% egresos.
        </div>

        <div class="ps-card">
            <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap; justify-content:space-between;">
                <div class="ps-filtros">
                    <select wire:model.live="cuenta_id" class="ps-select">
                        @foreach ($this->getCuentas() as $id => $nombre)
                            <option value="{{ $id }}">{{ $nombre }}</option>
                        @endforeach
                    </select>

                    <div class="ps-meses-btns">
                        @foreach ([3 => '3 meses', 6 => '6 meses', 12 => '12 meses'] as $val => $lbl)
                            <button class="ps-mes-btn {{ $meses == $val ? 'activo' : '' }}"
                                wire:click="$set('meses', {{ $val }})">{{ $lbl }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="ps-escenarios">
                    <button class="ps-esc-btn {{ $escenario === 'actual' ? 'activo-actual' : '' }}"
                        wire:click="$set('escenario','actual')">📊 Actual</button>
                    <button class="ps-esc-btn {{ $escenario === 'optimista' ? 'activo-optimista' : '' }}"
                        wire:click="$set('escenario','optimista')">📈 Optimista</button>
                    <button class="ps-esc-btn {{ $escenario === 'pesimista' ? 'activo-pesimista' : '' }}"
                        wire:click="$set('escenario','pesimista')">📉 Pesimista</button>
                </div>
            </div>
        </div>

        @if ($cuenta)

            <div class="ps-card">
                @php
                    $escColor = match ($escenario) {
                        'optimista' => '#22c55e',
                        'pesimista' => '#ef4444',
                        default => '#60a5fa',
                    };
                @endphp
                <div class="ps-kpis">
                    <div class="ps-kpi">
                        <div class="ps-kpi-label">Saldo actual</div>
                        <div class="ps-kpi-value" style="color:#fbbf24;">S/
                            {{ number_format($cuenta->saldo_actual, 2) }}</div>
                        <div class="ps-kpi-sub">{{ $cuenta->nombre }}</div>
                    </div>
                    <div class="ps-kpi">
                        <div class="ps-kpi-label">Saldo proyectado</div>
                        <div class="ps-kpi-value" style="color:{{ $escColor }};">S/
                            {{ number_format($datos['saldoFinal'], 2) }}</div>
                        <div class="ps-kpi-sub">en {{ $meses }} meses</div>
                    </div>
                    <div class="ps-kpi">
                        <div class="ps-kpi-label">Ingreso mensual est.</div>
                        <div class="ps-kpi-value" style="color:#22c55e;">S/ {{ number_format($datos['ingMes'], 2) }}
                        </div>
                        <div class="ps-kpi-sub">promedio ajustado</div>
                    </div>
                    <div class="ps-kpi">
                        <div class="ps-kpi-label">Egreso mensual est.</div>
                        <div class="ps-kpi-value" style="color:#ef4444;">S/ {{ number_format($datos['egrMes'], 2) }}
                        </div>
                        <div class="ps-kpi-sub">promedio ajustado</div>
                    </div>
                </div>

                <div class="ps-chart-wrap">
                    <canvas id="psChart"></canvas>
                </div>
            </div>

            <div class="ps-card">
                <div class="ps-section-title">📅 Proyección mes a mes</div>
                <table class="ps-table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Ingresos est.</th>
                            <th>Egresos est.</th>
                            <th>Ahorro est.</th>
                            <th>Saldo proyectado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $saldoAnterior = $cuenta->saldo_actual; @endphp
                        @foreach ($datos['proyeccion'] as $fila)
                            @php $subeOBaja = $fila['saldo'] >= $saldoAnterior; @endphp
                            <tr>
                                <td style="font-weight:600; color:var(--w-text);">{{ $fila['mes'] }}</td>
                                <td style="color:#22c55e; font-weight:600;">S/
                                    {{ number_format($fila['ingresos'], 2) }}</td>
                                <td style="color:#ef4444; font-weight:600;">S/ {{ number_format($fila['egresos'], 2) }}
                                </td>
                                <td style="color:{{ $fila['ahorro'] >= 0 ? '#60a5fa' : '#f97316' }}; font-weight:600;">
                                    {{ $fila['ahorro'] >= 0 ? '+' : '' }}S/ {{ number_format($fila['ahorro'], 2) }}
                                </td>
                                <td style="font-weight:800; color:{{ $escColor }};">
                                    S/ {{ number_format($fila['saldo'], 2) }}
                                    <span
                                        style="font-size:0.65rem; color:{{ $subeOBaja ? '#22c55e' : '#ef4444' }}; margin-left:0.25rem;">
                                        {{ $subeOBaja ? '↑' : '↓' }}
                                    </span>
                                </td>
                            </tr>
                            @php $saldoAnterior = $fila['saldo']; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align:center; color:var(--w-muted); padding:3rem; font-size:0.875rem;">
                Selecciona una cuenta para ver la proyección.
            </div>
        @endif

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function() {
            const proyeccion = @json($datos['proyeccion'] ?? []);
            const saldoActual = {{ $cuenta?->saldo_actual ?? 0 }};
            const escenario = '{{ $escenario }}';
            const escColor = escenario === 'optimista' ? '#22c55e' : (escenario === 'pesimista' ? '#ef4444' :
            '#60a5fa');

            const ctx = document.getElementById('psChart');
            if (!ctx || !proyeccion.length) return;

            if (window._psChart) window._psChart.destroy();

            const labels = ['Hoy', ...proyeccion.map(p => p.mes)];
            const saldos = [saldoActual, ...proyeccion.map(p => p.saldo)];

            window._psChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Saldo proyectado',
                        data: saldos,
                        borderColor: escColor,
                        backgroundColor: escColor + '18',
                        borderWidth: 2.5,
                        pointRadius: 5,
                        pointBackgroundColor: escColor,
                        tension: 0.4,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ' S/ ' + ctx.parsed.y.toFixed(2),
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255,255,255,0.04)'
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 11
                                }
                            },
                        },
                        y: {
                            grid: {
                                color: 'rgba(255,255,255,0.04)'
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 11
                                },
                                callback: v => 'S/ ' + v.toLocaleString(),
                            },
                        }
                    }
                }
            });
        })();
    </script>

</x-filament-panels::page>

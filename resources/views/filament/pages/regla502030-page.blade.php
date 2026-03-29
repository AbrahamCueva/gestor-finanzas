<x-filament-panels::page>
    @php
        $historial = $this->getHistorial();
        $promedios = $this->getPromedios($historial);
        $mesActual = last($historial);
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

        .r50p-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .r50p-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .r50p-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* KPIs promedios */
        .r50p-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:768px) {
            .r50p-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .r50p-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .r50p-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .r50p-kpi-value {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .r50p-kpi-sub {
            font-size: 0.62rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* Tabla historial */
        .r50p-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .r50p-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .r50p-table td {
            padding: 0.625rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
            vertical-align: middle;
        }

        .r50p-table tr:last-child td {
            border-bottom: none;
        }

        .r50p-table tr:hover td {
            background: var(--w-card);
        }

        .r50p-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .r50p-badge-ok {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .r50p-badge-warning {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .r50p-badge-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .r50p-mini-bar {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .r50p-track {
            flex: 1;
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
            min-width: 40px;
        }

        .r50p-fill {
            height: 100%;
            border-radius: 99px;
        }

        /* Gráfico */
        .r50p-chart-wrap {
            position: relative;
            height: 280px;
        }

        /* Puntaje círculo */
        .r50p-score {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 900;
            border: 2px solid;
            flex-shrink: 0;
        }
    </style>

    <div class="r50p-wrap">

        <div class="r50p-card">
            <div class="r50p-title">📊 Promedio últimos 6 meses</div>
            <div class="r50p-kpis">
                <div class="r50p-kpi">
                    <div class="r50p-kpi-label">Puntaje promedio</div>
                    @php $sc = $promedios['puntaje'] >= 80 ? '#22c55e' : ($promedios['puntaje'] >= 50 ? '#fbbf24' : '#ef4444'); @endphp
                    <div class="r50p-kpi-value" style="color:{{ $sc }};">{{ $promedios['puntaje'] }}/100</div>
                    <div class="r50p-kpi-sub">
                        {{ $promedios['puntaje'] >= 80 ? 'Excelente' : ($promedios['puntaje'] >= 50 ? 'Puede mejorar' : 'Necesita atención') }}
                    </div>
                </div>
                <div class="r50p-kpi">
                    <div class="r50p-kpi-label">🏠 Necesidades</div>
                    @php $c = $promedios['pctNec'] <= 50 ? '#22c55e' : ($promedios['pctNec'] <= 60 ? '#fbbf24' : '#ef4444'); @endphp
                    <div class="r50p-kpi-value" style="color:{{ $c }};">{{ $promedios['pctNec'] }}%</div>
                    <div class="r50p-kpi-sub">ideal ≤ 50%</div>
                </div>
                <div class="r50p-kpi">
                    <div class="r50p-kpi-label">🎮 Deseos</div>
                    @php $c = $promedios['pctDes'] <= 30 ? '#22c55e' : ($promedios['pctDes'] <= 40 ? '#fbbf24' : '#ef4444'); @endphp
                    <div class="r50p-kpi-value" style="color:{{ $c }};">{{ $promedios['pctDes'] }}%</div>
                    <div class="r50p-kpi-sub">ideal ≤ 30%</div>
                </div>
                <div class="r50p-kpi">
                    <div class="r50p-kpi-label">💰 Ahorro</div>
                    @php $c = $promedios['pctAho'] >= 20 ? '#22c55e' : ($promedios['pctAho'] >= 10 ? '#fbbf24' : '#ef4444'); @endphp
                    <div class="r50p-kpi-value" style="color:{{ $c }};">{{ $promedios['pctAho'] }}%</div>
                    <div class="r50p-kpi-sub">ideal ≥ 20%</div>
                </div>
            </div>
        </div>

        <div class="r50p-card">
            <div class="r50p-title">📈 Evolución mensual</div>
            <div class="r50p-chart-wrap">
                <canvas id="r50Chart"></canvas>
            </div>
        </div>

        <div class="r50p-card">
            <div class="r50p-title">📅 Historial mes a mes</div>
            <div style="overflow-x:auto;">
                <table class="r50p-table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Ingresos</th>
                            <th>🏠 Necesidades</th>
                            <th>🎮 Deseos</th>
                            <th>💰 Ahorro</th>
                            <th>Puntaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_reverse($historial) as $fila)
                            <tr>
                                <td style="font-weight:600; color:var(--w-text);">{{ $fila['mes'] }}</td>
                                <td style="color:#22c55e; font-weight:600;">
                                    S/ {{ number_format($fila['ingresos'], 2) }}
                                </td>

                                <td>
                                    <div class="r50p-mini-bar">
                                        <span
                                            style="font-size:0.72rem; font-weight:700; min-width:36px;
                                        color:{{ $fila['estadoNec'] === 'ok' ? '#22c55e' : ($fila['estadoNec'] === 'warning' ? '#fbbf24' : '#ef4444') }};">
                                            {{ $fila['pctNec'] }}%
                                        </span>
                                        <div class="r50p-track">
                                            <div class="r50p-fill"
                                                style="width:{{ min(100, $fila['pctNec']) }}%;
                                            background:{{ $fila['estadoNec'] === 'ok' ? '#22c55e' : ($fila['estadoNec'] === 'warning' ? '#fbbf24' : '#ef4444') }};">
                                            </div>
                                        </div>
                                        <span class="r50p-badge r50p-badge-{{ $fila['estadoNec'] }}">
                                            {{ $fila['estadoNec'] === 'ok' ? '✓' : ($fila['estadoNec'] === 'warning' ? '⚠' : '✗') }}
                                        </span>
                                    </div>
                                    <div style="font-size:0.65rem; color:var(--w-muted); margin-top:0.1rem;">
                                        S/ {{ number_format($fila['necesidades'], 2) }}
                                    </div>
                                </td>

                                <td>
                                    <div class="r50p-mini-bar">
                                        <span
                                            style="font-size:0.72rem; font-weight:700; min-width:36px;
                                        color:{{ $fila['estadoDes'] === 'ok' ? '#22c55e' : ($fila['estadoDes'] === 'warning' ? '#fbbf24' : '#ef4444') }};">
                                            {{ $fila['pctDes'] }}%
                                        </span>
                                        <div class="r50p-track">
                                            <div class="r50p-fill"
                                                style="width:{{ min(100, $fila['pctDes']) }}%;
                                            background:{{ $fila['estadoDes'] === 'ok' ? '#22c55e' : ($fila['estadoDes'] === 'warning' ? '#fbbf24' : '#ef4444') }};">
                                            </div>
                                        </div>
                                        <span class="r50p-badge r50p-badge-{{ $fila['estadoDes'] }}">
                                            {{ $fila['estadoDes'] === 'ok' ? '✓' : ($fila['estadoDes'] === 'warning' ? '⚠' : '✗') }}
                                        </span>
                                    </div>
                                    <div style="font-size:0.65rem; color:var(--w-muted); margin-top:0.1rem;">
                                        S/ {{ number_format($fila['deseos'], 2) }}
                                    </div>
                                </td>

                                <td>
                                    <div class="r50p-mini-bar">
                                        <span
                                            style="font-size:0.72rem; font-weight:700; min-width:36px;
                                        color:{{ $fila['estadoAho'] === 'ok' ? '#22c55e' : ($fila['estadoAho'] === 'warning' ? '#fbbf24' : '#ef4444') }};">
                                            {{ $fila['pctAho'] }}%
                                        </span>
                                        <div class="r50p-track">
                                            <div class="r50p-fill"
                                                style="width:{{ min(100, $fila['pctAho']) }}%;
                                            background:{{ $fila['estadoAho'] === 'ok' ? '#22c55e' : ($fila['estadoAho'] === 'warning' ? '#fbbf24' : '#ef4444') }};">
                                            </div>
                                        </div>
                                        <span class="r50p-badge r50p-badge-{{ $fila['estadoAho'] }}">
                                            {{ $fila['estadoAho'] === 'ok' ? '✓' : ($fila['estadoAho'] === 'warning' ? '⚠' : '✗') }}
                                        </span>
                                    </div>
                                    <div style="font-size:0.65rem; color:var(--w-muted); margin-top:0.1rem;">
                                        S/ {{ number_format($fila['ahorro'], 2) }}
                                    </div>
                                </td>
                                <td>
                                    @php $sc = $fila['puntaje'] >= 80 ? '#22c55e' : ($fila['puntaje'] >= 50 ? '#fbbf24' : '#ef4444'); @endphp
                                    <div class="r50p-score"
                                        style="border-color:{{ $sc }}; color:{{ $sc }}; background:{{ $sc }}12;">
                                        {{ $fila['puntaje'] }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function() {
            const historial = @json($historial);
            const ctx = document.getElementById('r50Chart');
            if (!ctx) return;

            if (window._r50Chart) window._r50Chart.destroy();

            window._r50Chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: historial.map(h => h.mes),
                    datasets: [{
                            label: 'Necesidades %',
                            data: historial.map(h => h.pctNec),
                            backgroundColor: '#60a5fa88',
                            borderColor: '#60a5fa',
                            borderWidth: 1.5,
                            borderRadius: 4,
                        },
                        {
                            label: 'Deseos %',
                            data: historial.map(h => h.pctDes),
                            backgroundColor: '#a78bfa88',
                            borderColor: '#a78bfa',
                            borderWidth: 1.5,
                            borderRadius: 4,
                        },
                        {
                            label: 'Ahorro %',
                            data: historial.map(h => h.pctAho),
                            backgroundColor: '#34d39988',
                            borderColor: '#34d399',
                            borderWidth: 1.5,
                            borderRadius: 4,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#6b7280',
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}%`
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
                                callback: v => v + '%',
                            },
                            max: 100,
                        }
                    }
                }
            });

            const plugin = {
                id: 'idealLines',
                afterDraw(chart) {
                    const {
                        ctx,
                        scales: {
                            y
                        }
                    } = chart;
                    const lines = [{
                            y: 50,
                            color: '#60a5fa',
                            label: '50% ideal nec.'
                        },
                        {
                            y: 30,
                            color: '#a78bfa',
                            label: '30% ideal des.'
                        },
                        {
                            y: 20,
                            color: '#34d399',
                            label: '20% ideal aho.'
                        },
                    ];
                    lines.forEach(({
                        y: yVal,
                        color,
                        label
                    }) => {
                        const yPos = y.getPixelForValue(yVal);
                        ctx.save();
                        ctx.setLineDash([4, 4]);
                        ctx.strokeStyle = color + '88';
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(chart.chartArea.left, yPos);
                        ctx.lineTo(chart.chartArea.right, yPos);
                        ctx.stroke();
                        ctx.restore();
                    });
                }
            };
            Chart.register(plugin);
            window._r50Chart.update();
        })();
    </script>

</x-filament-panels::page>

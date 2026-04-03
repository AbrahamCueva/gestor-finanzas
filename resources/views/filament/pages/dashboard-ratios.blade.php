<x-filament-panels::page>
    @php $d = $this->getDatos(); @endphp

    <style>
        :root {
            --bg: rgba(0, 0, 0, 0.04);
            --card: rgba(0, 0, 0, 0.05);
            --text: #111827;
            --soft: #374151;
            --muted: #6b7280;
            --border: rgba(0, 0, 0, 0.08);
            --gold: #fbbf24;
            --excelente: #22c55e;
            --bueno: #60a5fa;
            --regular: #fbbf24;
            --malo: #ef4444;
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
        }

        .dr {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .dr-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .dr-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* KPIs base */
        .dr-base {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .625rem;
        }

        @media(max-width:600px) {
            .dr-base {
                grid-template-columns: 1fr;
            }
        }

        .dr-base-item {
            background: var(--card);
            border-radius: .75rem;
            padding: .875rem;
        }

        .dr-base-label {
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .2rem;
        }

        .dr-base-value {
            font-size: 1.1rem;
            font-weight: 900;
        }

        /* Grid ratios */
        .dr-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .75rem;
        }

        @media(max-width:1024px) {
            .dr-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:480px) {
            .dr-grid {
                grid-template-columns: 1fr;
            }
        }

        .dr-ratio {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
            border: 1.5px solid transparent;
            position: relative;
            overflow: hidden;
            transition: transform .15s;
        }

        .dr-ratio:hover {
            transform: translateY(-2px);
        }

        .dr-ratio.excelente {
            border-color: rgba(34, 197, 94, .25);
        }

        .dr-ratio.bueno {
            border-color: rgba(96, 165, 250, .25);
        }

        .dr-ratio.regular {
            border-color: rgba(251, 191, 36, .25);
        }

        .dr-ratio.malo {
            border-color: rgba(239, 68, 68, .25);
        }

        .dr-ratio-bg {
            position: absolute;
            inset: 0;
            opacity: .04;
            border-radius: .875rem;
        }

        .dr-ratio.excelente .dr-ratio-bg {
            background: #22c55e;
        }

        .dr-ratio.bueno .dr-ratio-bg {
            background: #60a5fa;
        }

        .dr-ratio.regular .dr-ratio-bg {
            background: #fbbf24;
        }

        .dr-ratio.malo .dr-ratio-bg {
            background: #ef4444;
        }

        .dr-ratio-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: .5rem;
            position: relative;
        }

        .dr-ratio-left {
            display: flex;
            align-items: center;
            gap: .375rem;
        }

        .dr-ratio-emoji {
            font-size: 1rem;
        }

        .dr-ratio-nombre {
            font-size: .72rem;
            font-weight: 700;
            color: var(--text);
        }

        .dr-ratio-badge {
            font-size: .55rem;
            font-weight: 700;
            padding: .1rem .375rem;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .dr-ratio.excelente .dr-ratio-badge {
            background: rgba(34, 197, 94, .15);
            color: #22c55e;
        }

        .dr-ratio.bueno .dr-ratio-badge {
            background: rgba(96, 165, 250, .15);
            color: #60a5fa;
        }

        .dr-ratio.regular .dr-ratio-badge {
            background: rgba(251, 191, 36, .15);
            color: #fbbf24;
        }

        .dr-ratio.malo .dr-ratio-badge {
            background: rgba(239, 68, 68, .15);
            color: #ef4444;
        }

        .dr-ratio-valor {
            font-size: 1.5rem;
            font-weight: 900;
            line-height: 1;
            position: relative;
            margin-bottom: .25rem;
        }

        .dr-ratio.excelente .dr-ratio-valor {
            color: #22c55e;
        }

        .dr-ratio.bueno .dr-ratio-valor {
            color: #60a5fa;
        }

        .dr-ratio.regular .dr-ratio-valor {
            color: #fbbf24;
        }

        .dr-ratio.malo .dr-ratio-valor {
            color: #ef4444;
        }

        .dr-ratio-desc {
            font-size: .62rem;
            color: var(--muted);
            margin-bottom: .625rem;
            position: relative;
        }

        .dr-ratio-benchmark {
            font-size: .6rem;
            color: var(--muted);
            font-style: italic;
            position: relative;
        }

        /* Barra de progreso */
        .dr-prog-wrap {
            margin-bottom: .375rem;
            position: relative;
        }

        .dr-prog-track {
            height: 4px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .dr-prog-fill {
            height: 100%;
            border-radius: 99px;
            transition: width .5s;
        }

        .dr-ratio.excelente .dr-prog-fill {
            background: #22c55e;
        }

        .dr-ratio.bueno .dr-prog-fill {
            background: #60a5fa;
        }

        .dr-ratio.regular .dr-prog-fill {
            background: #fbbf24;
        }

        .dr-ratio.malo .dr-prog-fill {
            background: #ef4444;
        }

        /* Historial */
        .dr-chart-wrap {
            position: relative;
            height: 220px;
        }

        /* Patrimonio destacado */
        .dr-patrimonio {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            padding: 1rem;
            background: var(--card);
            border-radius: .875rem;
            border: 1px solid var(--border);
        }

        .dr-pat-item {
            flex: 1;
            min-width: 100px;
            text-align: center;
        }

        .dr-pat-label {
            font-size: .6rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: .2rem;
        }

        .dr-pat-value {
            font-size: 1rem;
            font-weight: 800;
        }
    </style>

    <div class="dr">

        {{-- Base --}}
        <div class="dr-card">
            <div class="dr-title">📊 Base de cálculo — promedio últimos 3 meses</div>
            <div class="dr-base">
                <div class="dr-base-item">
                    <div class="dr-base-label">Ingresos promedio</div>
                    <div class="dr-base-value" style="color:#22c55e;">S/ {{ number_format($d['ingresosProm'], 2) }}</div>
                </div>
                <div class="dr-base-item">
                    <div class="dr-base-label">Egresos promedio</div>
                    <div class="dr-base-value" style="color:#ef4444;">S/ {{ number_format($d['egresosProm'], 2) }}</div>
                </div>
                <div class="dr-base-item">
                    <div class="dr-base-label">Ahorro promedio</div>
                    <div class="dr-base-value" style="color:{{ $d['ahorroProm'] >= 0 ? '#60a5fa' : '#ef4444' }};">
                        S/ {{ number_format($d['ahorroProm'], 2) }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Patrimonio --}}
        <div class="dr-card">
            <div class="dr-title">💎 Posición patrimonial</div>
            <div class="dr-patrimonio">
                <div class="dr-pat-item">
                    <div class="dr-pat-label">Total activos</div>
                    <div class="dr-pat-value" style="color:#22c55e;">S/ {{ number_format($d['totalActivos'], 2) }}</div>
                </div>
                <div style="font-size:1.25rem; color:var(--muted);">−</div>
                <div class="dr-pat-item">
                    <div class="dr-pat-label">Total deudas</div>
                    <div class="dr-pat-value" style="color:#ef4444;">S/ {{ number_format($d['totalDeudas'], 2) }}</div>
                </div>
                <div style="font-size:1.25rem; color:var(--muted);">=</div>
                <div class="dr-pat-item">
                    <div class="dr-pat-label">Patrimonio neto</div>
                    <div class="dr-pat-value"
                        style="color:{{ $d['patrimonioNeto'] >= 0 ? '#fbbf24' : '#ef4444' }}; font-size:1.25rem;">
                        S/ {{ number_format($d['patrimonioNeto'], 2) }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid ratios --}}
        <div class="dr-card">
            <div class="dr-title">📐 Ratios financieros personales</div>
            <div class="dr-grid">
                @foreach ($d['ratios'] as $r)
                    @php
                        // Calcular progreso de barra
                        if ($r['meta'] !== null) {
                            if ($r['invertido']) {
                                $prog =
                                    $r['meta'] > 0 ? max(0, min(100, (1 - $r['valor'] / ($r['meta'] * 1.5)) * 100)) : 0;
                            } else {
                                $prog = $r['meta'] > 0 ? min(100, ($r['valor'] / $r['meta']) * 100) : 0;
                            }
                        } else {
                            $prog = $r['valor'] > 0 ? 75 : 25;
                        }

                        $estadoLabel = match ($r['estado']) {
                            'excelente' => '✓ Excelente',
                            'bueno' => '↑ Bueno',
                            'regular' => '~ Regular',
                            'malo' => '⚠ Mejorar',
                        };

                        // Formatear valor
                        $valorDisplay =
                            $r['unidad'] === ' S/'
                                ? 'S/ ' . number_format(abs($r['valor']), 0)
                                : number_format($r['valor'], 1) . $r['unidad'];
                    @endphp

                    <div class="dr-ratio {{ $r['estado'] }}">
                        <div class="dr-ratio-bg"></div>
                        <div class="dr-ratio-header">
                            <div class="dr-ratio-left">
                                <span class="dr-ratio-emoji">{{ $r['emoji'] }}</span>
                                <span class="dr-ratio-nombre">{{ $r['nombre'] }}</span>
                            </div>
                            <span class="dr-ratio-badge">{{ $estadoLabel }}</span>
                        </div>

                        <div class="dr-ratio-valor">{{ $valorDisplay }}</div>
                        <div class="dr-ratio-desc">{{ $r['desc'] }}</div>

                        @if ($r['meta'] !== null)
                            <div class="dr-prog-wrap">
                                <div class="dr-prog-track">
                                    <div class="dr-prog-fill" style="width:{{ round($prog) }}%;"></div>
                                </div>
                            </div>
                        @endif

                        <div class="dr-ratio-benchmark">{{ $r['benchmark'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Historial tasa de ahorro --}}
        <div class="dr-card">
            <div class="dr-title">📈 Evolución de ratios — últimos 6 meses</div>
            <div class="dr-chart-wrap">
                <canvas id="drChart"></canvas>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        function initDrChart() {
            const historial = @json($d['historial']);
            const ctx = document.getElementById('drChart');
            if (!ctx || !historial.length) return;
            if (window._drChart) window._drChart.destroy();

            window._drChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: historial.map(h => h.mes),
                    datasets: [{
                            label: 'Tasa de ahorro %',
                            data: historial.map(h => h.tasaAhorro),
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34,197,94,.08)',
                            borderWidth: 2.5,
                            tension: 0.4,
                            pointRadius: 4,
                            fill: true,
                            pointBackgroundColor: '#22c55e',
                        },
                        {
                            label: 'Ratio gastos %',
                            data: historial.map(h => h.ratioGastos),
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239,68,68,.08)',
                            borderWidth: 2.5,
                            tension: 0.4,
                            pointRadius: 4,
                            fill: true,
                            pointBackgroundColor: '#ef4444',
                        },
                        {
                            label: 'Objetivo ahorro (20%)',
                            data: historial.map(() => 20),
                            borderColor: 'rgba(251,191,36,.5)',
                            borderWidth: 1.5,
                            borderDash: [5, 5],
                            pointRadius: 0,
                            fill: false,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
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
                            backgroundColor: 'rgba(15,23,42,.9)',
                            titleColor: '#f1f5f9',
                            bodyColor: '#94a3b8',
                            callbacks: {
                                label: c => ` ${c.dataset.label}: ${c.parsed.y.toFixed(1)}%`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 10
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255,255,255,.04)'
                            },
                            ticks: {
                                color: '#6b7280',
                                callback: v => v + '%'
                            },
                            min: 0,
                            max: 120,
                        }
                    }
                }
            });
        }

        initDrChart();
        document.addEventListener('livewire:updated', initDrChart);
    </script>
</x-filament-panels::page>

<x-filament-panels::page>
    @php
        $datos = $this->getDatos();
        $monedas = $this->getMonedas();
        $todas = $this->getTodasMonedas();
        $selColor = $monedas[$moneda]['color'] ?? '#fbbf24';
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

        .htc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .htc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .htc-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Tarjetas de monedas */
        .htc-monedas {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-bottom: 0;
        }

        @media(max-width:768px) {
            .htc-monedas {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .htc-moneda-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.15s;
        }

        .htc-moneda-card:hover {
            border-color: rgba(251, 191, 36, 0.3);
        }

        .htc-moneda-card.activa {
            border-color: var(--mc);
            background: rgba(var(--mc-rgb), 0.08);
        }

        .htc-moneda-flag {
            font-size: 1.25rem;
            margin-bottom: 0.375rem;
        }

        .htc-moneda-code {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .htc-moneda-label {
            font-size: 0.65rem;
            color: var(--w-muted);
        }

        .htc-moneda-tasa {
            font-size: 1.1rem;
            font-weight: 800;
            margin-top: 0.375rem;
        }

        .htc-moneda-upd {
            font-size: 0.62rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* Filtros periodo */
        .htc-periodos {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .htc-periodo-btn {
            padding: 0.3rem 0.875rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .htc-periodo-btn.activo {
            background: #fbbf24;
            color: #0f172a;
        }

        .htc-periodo-btn:hover:not(.activo) {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        /* KPIs */
        .htc-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
            margin-bottom: 1.25rem;
        }

        @media(max-width:768px) {
            .htc-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .htc-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .htc-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .htc-kpi-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .htc-kpi-sub {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* Gráfico */
        .htc-chart-wrap {
            position: relative;
            height: 280px;
        }
    </style>

    <div class="htc-wrap">
        <div class="htc-card">
            <div class="htc-section-title">💱 Tasas actuales (base PEN)</div>
            <div class="htc-monedas">
                @foreach ($todas as $code => $info)
                    <div class="htc-moneda-card {{ $moneda === $code ? 'activa' : '' }}"
                        style="--mc:{{ $info['color'] }};" wire:click="$set('moneda', '{{ $code }}')">
                        <div class="htc-moneda-flag">{{ $info['emoji'] }}</div>
                        <div class="htc-moneda-code">{{ $code }}</div>
                        <div class="htc-moneda-label">{{ $info['label'] }}</div>
                        <div class="htc-moneda-tasa" style="color:{{ $info['color'] }};">
                            {{ is_numeric($info['tasa']) ? number_format($info['tasa'], 4) : $info['tasa'] }}
                        </div>
                        <div class="htc-moneda-upd">{{ $info['actualizado'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="htc-card">
            <div
                style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; flex-wrap:wrap; gap:0.5rem;">
                <div class="htc-section-title" style="margin-bottom:0;">
                    📈 Historial PEN → {{ $moneda }}
                </div>
                <div class="htc-periodos">
                    @foreach (['7' => '7 días', '15' => '15 días', '30' => '30 días', '90' => '3 meses'] as $val => $lbl)
                        <button class="htc-periodo-btn {{ $periodo === $val ? 'activo' : '' }}"
                            wire:click="$set('periodo', '{{ $val }}')">
                            {{ $lbl }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="htc-kpis">
                <div class="htc-kpi">
                    <div class="htc-kpi-label">Tasa actual</div>
                    <div class="htc-kpi-value" style="color:{{ $selColor }};">
                        {{ number_format($datos['actual'], 4) }}
                    </div>
                    <div class="htc-kpi-sub">PEN → {{ $moneda }}</div>
                </div>
                <div class="htc-kpi">
                    <div class="htc-kpi-label">Máximo</div>
                    <div class="htc-kpi-value" style="color:#22c55e;">{{ number_format($datos['maximo'], 4) }}</div>
                    <div class="htc-kpi-sub">en el período</div>
                </div>
                <div class="htc-kpi">
                    <div class="htc-kpi-label">Mínimo</div>
                    <div class="htc-kpi-value" style="color:#ef4444;">{{ number_format($datos['minimo'], 4) }}</div>
                    <div class="htc-kpi-sub">en el período</div>
                </div>
                <div class="htc-kpi">
                    <div class="htc-kpi-label">Variación</div>
                    <div class="htc-kpi-value" style="color:{{ $datos['variacion'] >= 0 ? '#22c55e' : '#ef4444' }};">
                        {{ $datos['variacion'] >= 0 ? '+' : '' }}{{ $datos['variacion'] }}%
                    </div>
                    <div class="htc-kpi-sub">vs inicio del período</div>
                </div>
            </div>

            <div class="htc-chart-wrap">
                <canvas id="htcChart"></canvas>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function() {
            const labels = @json($datos['labels']);
            const valores = @json($datos['valores']);
            const color = @json($selColor);

            const ctx = document.getElementById('htcChart');
            if (!ctx) return;

            if (window._htcChart) window._htcChart.destroy();

            window._htcChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Tasa PEN → {{ $moneda }}',
                        data: valores,
                        borderColor: color,
                        backgroundColor: color + '18',
                        borderWidth: 2,
                        pointRadius: labels.length <= 15 ? 4 : 2,
                        pointBackgroundColor: color,
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
                                label: ctx => ' ' + ctx.parsed.y.toFixed(4) + ' ' + '{{ $moneda }}',
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
                                    size: 10
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
                                    size: 10
                                },
                                callback: v => v.toFixed(4),
                            },
                        }
                    }
                }
            });

            document.addEventListener('livewire:navigated', () => {
                if (window._htcChart) window._htcChart.destroy();
            });
        })();
    </script>
</x-filament-panels::page>

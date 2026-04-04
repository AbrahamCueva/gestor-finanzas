<x-filament-panels::page>
    @php
        $d = $this->getDatos();
        $mes = $this->getMesActual();
        $anio = $this->getAnioActual();
        $nombresMeses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
    @endphp

    <style>
        :root {
            --bg: rgba(0, 0, 0, 0.04);
            --card: rgba(0, 0, 0, 0.05);
            --text: #111827;
            --soft: #374151;
            --muted: #6b7280;
            --border: rgba(0, 0, 0, 0.08);
            --hover: rgba(0, 0, 0, 0.06);
            --gold: #fbbf24;
            --gold-dim: rgba(251, 191, 36, 0.1);
            --green: #22c55e;
            --red: #ef4444;
            --blue: #60a5fa;
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
            --hover: rgba(255, 255, 255, 0.05);
        }

        .fc {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .fc-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .fc-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Toolbar */
        .fc-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .fc-nav {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .fc-nav-btn {
            width: 30px;
            height: 30px;
            border-radius: .5rem;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all .15s;
        }

        .fc-nav-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .fc-periodo {
            font-size: .95rem;
            font-weight: 800;
            color: var(--text);
            min-width: 180px;
            text-align: center;
        }

        /* KPIs */
        .fc-kpis {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: .625rem;
        }

        @media(max-width:900px) {
            .fc-kpis {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:600px) {
            .fc-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .fc-kpi {
            background: var(--card);
            border-radius: .75rem;
            padding: .75rem;
        }

        .fc-kpi-label {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .2rem;
        }

        .fc-kpi-value {
            font-size: 1rem;
            font-weight: 900;
        }

        .fc-kpi-sub {
            font-size: .6rem;
            color: var(--muted);
            margin-top: .1rem;
        }

        /* Gráfico */
        .fc-chart-wrap {
            position: relative;
            height: 280px;
        }

        /* Tabla */
        .fc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .775rem;
        }

        .fc-table th {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .fc-table td {
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            color: var(--soft);
            vertical-align: middle;
        }

        .fc-table tr:last-child td {
            border-bottom: none;
        }

        .fc-table tr:hover td {
            background: var(--card);
        }

        .fc-table tr.futuro td {
            opacity: .4;
        }

        .fc-bar {
            display: flex;
            align-items: center;
            gap: .375rem;
        }

        .fc-bar-track {
            flex: 1;
            height: 4px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
            min-width: 40px;
        }

        .fc-bar-fill {
            height: 100%;
            border-radius: 99px;
        }

        .fc-badge {
            display: inline-block;
            padding: .1rem .4rem;
            border-radius: 3px;
            font-size: .6rem;
            font-weight: 700;
        }
    </style>

    <div class="fc">

        {{-- Toolbar --}}
        <div class="fc-card">
            <div class="fc-toolbar">
                <div class="fc-nav">
                    <button class="fc-nav-btn" wire:click="anteriorMes">‹</button>
                    <div class="fc-periodo">{{ $nombresMeses[$mes] }} {{ $anio }}</div>
                    <button class="fc-nav-btn" wire:click="siguienteMes">›</button>
                </div>
                <div style="font-size:.72rem; color:var(--muted);">
                    {{ $d['diasConMovs'] }} días con movimientos de {{ count($d['flujo']) }} días totales
                </div>
            </div>
        </div>

        {{-- KPIs --}}
        <div class="fc-card">
            <div class="fc-kpis">
                <div class="fc-kpi">
                    <div class="fc-kpi-label">Total ingresos</div>
                    <div class="fc-kpi-value" style="color:var(--green);">S/ {{ number_format($d['totalIngresos'], 2) }}
                    </div>
                </div>
                <div class="fc-kpi">
                    <div class="fc-kpi-label">Total egresos</div>
                    <div class="fc-kpi-value" style="color:var(--red);">S/ {{ number_format($d['totalEgresos'], 2) }}
                    </div>
                </div>
                <div class="fc-kpi">
                    <div class="fc-kpi-label">Flujo neto</div>
                    <div class="fc-kpi-value" style="color:{{ $d['totalNeto'] >= 0 ? 'var(--blue)' : 'var(--red)' }};">
                        {{ $d['totalNeto'] >= 0 ? '+' : '' }}S/ {{ number_format($d['totalNeto'], 2) }}
                    </div>
                </div>
                <div class="fc-kpi">
                    <div class="fc-kpi-label">Mejor día</div>
                    <div class="fc-kpi-value" style="color:var(--green);">
                        {{ $d['mejorDia'] ? 'Día ' . $d['mejorDia']['dia'] : '—' }}
                    </div>
                    <div class="fc-kpi-sub">
                        {{ $d['mejorDia'] ? '+S/ ' . number_format($d['mejorDia']['neto'], 2) : '' }}
                    </div>
                </div>
                <div class="fc-kpi">
                    <div class="fc-kpi-label">Peor día</div>
                    <div class="fc-kpi-value" style="color:var(--red);">
                        {{ $d['peorDia'] ? 'Día ' . $d['peorDia']['dia'] : '—' }}
                    </div>
                    <div class="fc-kpi-sub">
                        {{ $d['peorDia'] ? 'S/ ' . number_format($d['peorDia']['neto'], 2) : '' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico --}}
        <div class="fc-card">
            <div class="fc-title">📈 Flujo acumulado del mes</div>
            <div class="fc-chart-wrap" wire:ignore>
                <canvas id="fcChart"></canvas>
            </div>
        </div>

        {{-- Tabla día a día --}}
        <div class="fc-card">
            <div class="fc-title">📅 Detalle día a día</div>
            <div style="overflow-x:auto; max-height:420px; overflow-y:auto;">
                <table class="fc-table">
                    <thead>
                        <tr>
                            <th>Día</th>
                            <th style="text-align:right;">Ingresos</th>
                            <th style="text-align:right;">Egresos</th>
                            <th style="text-align:right;">Neto del día</th>
                            <th style="text-align:right;">Acumulado</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($d['flujo'] as $fila)
                            @if ($fila['ingresos'] > 0 || $fila['egresos'] > 0 || !$fila['esFuturo'])
                                <tr class="{{ $fila['esFuturo'] ? 'futuro' : '' }}">
                                    <td style="font-weight:700; color:var(--text);">
                                        {{ $fila['fecha'] }}
                                        @if ($fila['esFuturo'])
                                            <span style="font-size:.58rem; color:var(--muted);">futuro</span>
                                        @endif
                                    </td>
                                    <td style="text-align:right; color:var(--green); font-weight:600;">
                                        {{ $fila['ingresos'] > 0 ? '+S/ ' . number_format($fila['ingresos'], 2) : '—' }}
                                    </td>
                                    <td style="text-align:right; color:var(--red); font-weight:600;">
                                        {{ $fila['egresos'] > 0 ? '-S/ ' . number_format($fila['egresos'], 2) : '—' }}
                                    </td>
                                    <td
                                        style="text-align:right; font-weight:700; color:{{ $fila['neto'] >= 0 ? 'var(--green)' : 'var(--red)' }};">
                                        {{ $fila['neto'] >= 0 ? '+' : '' }}S/ {{ number_format($fila['neto'], 2) }}
                                    </td>
                                    <td
                                        style="text-align:right; font-weight:700; color:{{ $fila['acumulado'] >= 0 ? 'var(--blue)' : 'var(--red)' }};">
                                        S/ {{ number_format($fila['acumulado'], 2) }}
                                    </td>
                                    <td>
                                        @if ($fila['neto'] > 0)
                                            <span class="fc-badge"
                                                style="background:rgba(34,197,94,.12); color:var(--green);">✓
                                                Positivo</span>
                                        @elseif($fila['neto'] < 0)
                                            <span class="fc-badge"
                                                style="background:rgba(239,68,68,.12); color:var(--red);">↓
                                                Negativo</span>
                                        @else
                                            <span class="fc-badge" style="background:var(--card); color:var(--muted);">—
                                                Neutro</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        (function() {
            function renderFcChart(flujo) {
                if (typeof Chart === 'undefined') {
                    setTimeout(() => renderFcChart(flujo), 100);
                    return;
                }

                const ctx = document.getElementById('fcChart');
                if (!ctx) return;

                if (window._fcChart) {
                    window._fcChart.destroy();
                    window._fcChart = null;
                }

                const conDatos = flujo.filter(f => !f.esFuturo);

                window._fcChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: conDatos.map(f => f.fecha),
                        datasets: [{
                                label: 'Ingresos',
                                data: conDatos.map(f => f.ingresos),
                                backgroundColor: 'rgba(34,197,94,.5)',
                                borderColor: '#22c55e',
                                borderWidth: 1,
                                borderRadius: 3,
                            },
                            {
                                label: 'Egresos',
                                data: conDatos.map(f => -f.egresos),
                                backgroundColor: 'rgba(239,68,68,.5)',
                                borderColor: '#ef4444',
                                borderWidth: 1,
                                borderRadius: 3,
                            },
                            {
                                label: 'Acumulado',
                                data: conDatos.map(f => f.acumulado),
                                type: 'line',
                                borderColor: '#60a5fa',
                                backgroundColor: 'rgba(96,165,250,.08)',
                                borderWidth: 2.5,
                                tension: 0.4,
                                pointRadius: 3,
                                fill: true,
                                yAxisID: 'y1',
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
                                    label: c => ` ${c.dataset.label}: S/ ${Math.abs(c.parsed.y).toFixed(2)}`
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
                                    },
                                    maxRotation: 45
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(255,255,255,.04)'
                                },
                                ticks: {
                                    color: '#6b7280',
                                    callback: v => 'S/' + v
                                }
                            },
                            y1: {
                                position: 'right',
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#60a5fa',
                                    callback: v => 'S/' + v
                                }
                            },
                        }
                    }
                });
            }

            // Escuchar evento del backend
            document.addEventListener('livewire:init', () => {
                Livewire.on('updateFcChart', (data) => {
                    const payload = Array.isArray(data) ? data[0] : data;
                    setTimeout(() => renderFcChart(payload.flujo), 80);
                });
            });

            // Primera carga
            document.addEventListener('DOMContentLoaded', () => {
                renderFcChart(@json($d['flujo']));
            });

            // Re-render por navegación Livewire
            document.addEventListener('livewire:navigated', () => {
                setTimeout(() => renderFcChart(@json($d['flujo'])), 80);
            });
        })();
    </script>
</x-filament-panels::page>

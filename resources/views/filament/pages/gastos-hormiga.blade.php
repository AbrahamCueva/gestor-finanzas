<x-filament-panels::page>
    @php $d = $this->getDatos(); @endphp

    <style>
        :root {
            --gh-bg: #ffffff;
            --gh-card: #f8fafc;
            --gh-text: #0f172a;
            --gh-soft: #334155;
            --gh-muted: #64748b;
            --gh-border: #e2e8f0;
            --gh-gold: #eab308;
            --gh-green: #22c55e;
            --gh-red: #ef4444;
            --gh-blue: #3b82f6;
            --gh-orange: #f97316;
            --gh-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        }

        .dark :root,
        .dark {
            --gh-bg: #09090b;
            --gh-card: #18181b;
            --gh-text: #f8fafc;
            --gh-soft: #e2e8f0;
            --gh-muted: #a1a1aa;
            --gh-border: #27272a;
            --gh-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.3);
        }

        .gh-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            color: var(--gh-text);
            font-family: inherit;
        }

        .gh-card {
            background: var(--gh-card);
            border: 1px solid var(--gh-border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--gh-shadow);
        }

        .gh-title {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--gh-muted);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Toolbar / Filtros */
        .gh-toolbar {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .gh-control {
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }

        .gh-control-label {
            font-size: .7rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gh-muted);
        }

        .gh-control-valor {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--gh-gold);
        }

        .gh-slider {
            width: 180px;
            height: 6px;
            background: var(--gh-border);
            border-radius: 5px;
            appearance: none;
            outline: none;
        }

        .gh-slider::-webkit-slider-thumb {
            appearance: none;
            width: 18px;
            height: 18px;
            background: var(--gh-gold);
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .gh-hist-btns {
            display: flex;
            background: var(--gh-border);
            padding: 3px;
            border-radius: 0.75rem;
            width: fit-content;
        }

        .gh-hist-btn {
            padding: 0.4rem 1rem;
            border-radius: 0.6rem;
            font-size: .75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: transparent;
            color: var(--gh-muted);
            transition: all 0.2s;
        }

        .gh-hist-btn.on {
            background: var(--gh-card);
            color: var(--gh-gold);
            box-shadow: var(--gh-shadow);
        }

        /* KPIs */
        .gh-kpis {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .gh-kpi {
            background: var(--gh-bg);
            border: 1px solid var(--gh-border);
            border-radius: 0.8rem;
            padding: 1.25rem;
            transition: transform 0.2s;
        }

        .gh-kpi:hover {
            transform: translateY(-2px);
        }

        .gh-kpi-label {
            font-size: .65rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gh-muted);
            margin-bottom: 0.5rem;
        }

        .gh-kpi-value {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .gh-kpi-sub {
            font-size: .7rem;
            color: var(--gh-muted);
            margin-top: 0.4rem;
        }

        /* Listado Top 5 */
        .gh-top-item {
            background: var(--gh-bg);
            border: 1px solid var(--gh-border);
            border-radius: 0.8rem;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .gh-top-rank {
            font-size: 1.5rem;
            width: 40px;
            text-align: center;
        }

        .gh-top-nombre {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .gh-top-cat {
            font-size: 0.75rem;
            color: var(--gh-muted);
        }

        .gh-top-stats {
            margin-left: auto;
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .gh-top-stat {
            text-align: right;
        }

        .gh-top-stat-val {
            font-weight: 800;
            font-size: 1rem;
        }

        .gh-top-stat-lbl {
            font-size: 0.65rem;
            color: var(--gh-muted);
            text-transform: uppercase;
        }

        /* Impact Badges */
        .gh-impacto {
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .gh-impacto-critico {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .gh-impacto-alto {
            background: rgba(249, 115, 22, 0.15);
            color: #f97316;
        }

        .gh-impacto-medio {
            background: rgba(234, 179, 8, 0.15);
            color: #eab308;
        }

        .gh-impacto-bajo {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        /* Gráfico de Barras por Hora */
        .gh-horas-container {
            display: flex;
            flex-direction: column;
            height: 180px;
            justify-content: flex-end;
        }

        .gh-horas-bars {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 120px;
        }

        .gh-hora-bar {
            flex: 1;
            border-radius: 4px 4px 1px 1px;
            min-height: 2px;
            position: relative;
            background: rgba(99, 102, 241, 0.2);
            transition: all 0.3s;
        }

        .gh-hora-bar:hover {
            filter: brightness(1.2);
            cursor: pointer;
        }

        /* Table Styles */
        .gh-table-container {
            overflow-x: auto;
            margin-top: 1rem;
        }

        .gh-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .gh-table th {
            text-align: left;
            padding: 1rem;
            color: var(--gh-muted);
            border-bottom: 2px solid var(--gh-border);
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        .gh-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gh-border);
        }

        .gh-table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .gh-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 1024px) {
            .gh-grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="gh-container">

        {{-- Header Info --}}
        <div class="gh-card" style="background: linear-gradient(to right, rgba(59, 130, 246, 0.1), transparent);">
            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                <div style="background: var(--gh-blue); padding: 0.5rem; border-radius: 0.5rem; color: white;">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.25rem;">Detector de Gastos Hormiga
                    </h2>
                    <p style="font-size: 0.85rem; color: var(--gh-muted); max-width: 800px;">
                        Identifica consumos pequeños pero recurrentes que afectan tu presupuesto. Analizamos tus
                        movimientos para proyectar el impacto real a largo plazo.
                    </p>
                </div>
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="gh-card">
            <div class="gh-toolbar">
                <div class="gh-control">
                    <label class="gh-control-label">Período de Análisis</label>
                    <div class="gh-hist-btns">
                        @foreach ([1 => '1 mes', 3 => '3 meses', 6 => '6 meses'] as $v => $label)
                            <button class="gh-hist-btn {{ $meses == $v ? 'on' : '' }}"
                                wire:click="$set('meses', {{ $v }})">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="gh-control">
                    <label class="gh-control-label">Monto Máximo (S/)</label>
                    <div class="gh-control-valor">≤ S/ {{ $montoMaximo }}</div>
                    <input type="range" class="gh-slider" min="5" max="100" step="5"
                        wire:model.live="montoMaximo">
                </div>
                <div class="gh-control">
                    <label class="gh-control-label">Frecuencia Mínima</label>
                    <div class="gh-control-valor">≥ {{ $frecuenciaMin }} veces</div>
                    <input type="range" class="gh-slider" min="2" max="10" step="1"
                        wire:model.live="frecuenciaMin">
                </div>
            </div>
        </div>

        {{-- KPIs --}}
        <div class="gh-kpis">
            <div class="gh-kpi">
                <div class="gh-kpi-label">Total Gasto Hormiga ({{ $d['meses'] }}m)</div>
                <div class="gh-kpi-value" style="color:var(--gh-red);">S/ {{ number_format($d['totalHormiga'], 2) }}
                </div>
                <div class="gh-kpi-sub">Acumulado en el periodo</div>
            </div>
            <div class="gh-kpi">
                <div class="gh-kpi-label">Proyección Anual</div>
                <div class="gh-kpi-value" style="color:var(--gh-orange);">S/ {{ number_format($d['proyAnual'], 2) }}
                </div>
                <div class="gh-kpi-sub">Impacto en 12 meses</div>
            </div>
            <div class="gh-kpi">
                <div class="gh-kpi-label">Patrones Detectados</div>
                <div class="gh-kpi-value" style="color:var(--gh-gold);">{{ $d['cantidadGrupos'] }}</div>
                <div class="gh-kpi-sub">Grupos de gastos frecuentes</div>
            </div>
            <div class="gh-kpi">
                <div class="gh-kpi-label">Total Mov. Pequeños</div>
                <div class="gh-kpi-value">S/ {{ number_format($d['totalMovSmall'], 2) }}</div>
                <div class="gh-kpi-sub">Bajo el umbral de S/ {{ $montoMaximo }}</div>
            </div>
        </div>

        @if (empty($d['gastos']))
            <div class="gh-card" style="text-align:center; padding:4rem;">
                <span style="font-size: 3rem;">🐜</span>
                <h3 style="margin-top:1.5rem; font-weight:700;">Sin resultados</h3>
                <p style="color:var(--gh-muted);">No encontramos gastos que coincidan con estos filtros.</p>
            </div>
        @else
            {{-- Top 5 --}}
            <div class="gh-card">
                <div class="gh-title">🏆 Top 5 Gastos Hormiga</div>
                @foreach ($d['top5'] as $i => $g)
                    <div class="gh-top-item">
                        <div class="gh-top-rank">{{ ['🥇', '🥈', '🥉', '4️⃣', '5️⃣'][$i] }}</div>
                        <div class="gh-top-info">
                            <div class="gh-top-nombre">{{ $g['descripcion'] }}</div>
                            <div class="gh-top-cat">{{ $g['categoria'] }}</div>
                        </div>
                        <div class="gh-top-stats">
                            <div class="gh-top-stat">
                                <div class="gh-top-stat-val" style="color:var(--gh-red);">S/
                                    {{ number_format($g['total'], 2) }}</div>
                                <div class="gh-top-stat-lbl">en {{ $d['meses'] }}m</div>
                            </div>
                            <div class="gh-top-stat">
                                <div class="gh-top-stat-val" style="color:var(--gh-orange);">S/
                                    {{ number_format($g['proyeccionAnual'], 0) }}</div>
                                <div class="gh-top-stat-lbl">al año</div>
                            </div>
                            <span class="gh-impacto gh-impacto-{{ $g['impacto'] }}">{{ $g['impacto'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="gh-grid-2">
                {{-- Distribución Chart --}}
                <div class="gh-card">
                    <div class="gh-title">📊 Distribución de Gastos</div>
                    <div style="height: 250px; position: relative;">
                        <canvas id="ghChart"></canvas>
                    </div>
                </div>

                {{-- Horas Chart --}}
                <div class="gh-card">
                    <div class="gh-title">🕐 Concentración Horaria</div>
                    <div class="gh-horas-container">
                        @php $maxHora = count($d['porHora']) > 0 ? max($d['porHora']) : 1; @endphp
                        <div class="gh-horas-bars">
                            @for ($h = 0; $h <= 23; $h++)
                                @php
                                    $val = $d['porHora'][$h] ?? 0;
                                    $perc = ($val / ($maxHora ?: 1)) * 100;
                                    $isMax = $val > 0 && $val == $maxHora;
                                @endphp
                                <div class="gh-hora-bar"
                                    style="height: {{ max($perc, 5) }}%; background: {{ $isMax ? 'var(--gh-gold)' : 'rgba(99, 102, 241, 0.4)' }}"
                                    title="S/ {{ number_format($val, 2) }}">
                                </div>
                            @endfor
                        </div>
                        <div
                            style="display:flex; justify-content: space-between; margin-top: 1rem; color: var(--gh-muted); font-size: 0.65rem;">
                            <span>00h</span><span>06h</span><span>12h</span><span>18h</span><span>23h</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="gh-card">
                <div class="gh-title">📋 Detalle de Movimientos</div>
                <div class="gh-table-container">
                    <table class="gh-table">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Frecuencia</th>
                                <th>Total Periodo</th>
                                <th>Proyección Anual</th>
                                <th>Impacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($d['gastos'] as $g)
                                <tr>
                                    <td style="font-weight: 600;">{{ $g['descripcion'] }}</td>
                                    <td>{{ $g['categoria'] }}</td>
                                    <td>{{ $g['conteo'] }} veces</td>
                                    <td style="color:var(--gh-red); font-weight:700;">S/
                                        {{ number_format($g['total'], 2) }}</td>
                                    <td style="color:var(--gh-orange); font-weight:700;">S/
                                        {{ number_format($g['proyeccionAnual'], 2) }}</td>
                                    <td><span
                                            class="gh-impacto gh-impacto-{{ $g['impacto'] }}">{{ $g['impacto'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        function initGhChart() {
            const data = @json($d['gastos'] ?? []);
            const ctx = document.getElementById('ghChart');
            if (!ctx || data.length === 0) return;

            if (window._ghChart) window._ghChart.destroy();

            const slices = data.slice(0, 7);
            window._ghChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: slices.map(g => g.descripcion),
                    datasets: [{
                        data: slices.map(g => g.total),
                        backgroundColor: ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#6366f1',
                            '#a855f7'
                        ],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: '#a1a1aa',
                                usePointStyle: true,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }
        document.addEventListener('livewire:initialized', () => {
            initGhChart();
            Livewire.on('updated', () => {
                setTimeout(initGhChart, 50);
            });
        });
    </script>
</x-filament-panels::page>

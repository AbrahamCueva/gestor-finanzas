<x-filament-panels::page>
    @php
        $resumen = $this->getResumenCategorias();
        $detalle = $this->getDetalleCat();
        $cats = $this->getCategorias();
        $maxTotal = collect($resumen)->max('total') ?: 1;
    @endphp

    <style>
        :root {
            --bg: rgba(0, 0, 0, 0.04);
            --card: rgba(0, 0, 0, 0.05);
            --text: #111827;
            --soft: #374151;
            --muted: #6b7280;
            --border: rgba(0, 0, 0, 0.08);
            --gold: #fbbf24;
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
        }

        .ac {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ac-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ac-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Toolbar */
        .ac-toolbar {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .ac-select {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: .625rem;
            padding: .45rem .875rem;
            font-size: .825rem;
            color: var(--text);
            outline: none;
            cursor: pointer;
        }

        .ac-select:focus {
            border-color: var(--gold);
        }

        .ac-tipo-btns {
            display: flex;
            gap: .3rem;
        }

        .ac-tipo-btn {
            padding: .3rem .875rem;
            border-radius: 99px;
            font-size: .72rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            background: var(--card);
            color: var(--muted);
            transition: all .15s;
        }

        .ac-tipo-btn.on-egreso {
            background: rgba(239, 68, 68, .12);
            color: var(--red);
        }

        .ac-tipo-btn.on-ingreso {
            background: rgba(34, 197, 94, .12);
            color: var(--green);
        }

        /* Grid categorías */
        .ac-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: .625rem;
        }

        @media(max-width:768px) {
            .ac-grid {
                grid-template-columns: 1fr;
            }
        }

        .ac-cat-card {
            background: var(--card);
            border-radius: .875rem;
            padding: .875rem 1rem;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: all .15s;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }

        .ac-cat-card:hover {
            border-color: rgba(251, 191, 36, .2);
        }

        .ac-cat-card.activo {
            border-color: rgba(251, 191, 36, .4);
            background: rgba(251, 191, 36, .05);
        }

        .ac-cat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ac-cat-nombre {
            font-size: .825rem;
            font-weight: 700;
            color: var(--text);
        }

        .ac-cat-total {
            font-size: .9rem;
            font-weight: 900;
        }

        .ac-cat-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .68rem;
            color: var(--muted);
        }

        .ac-bar-wrap {
            height: 4px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .ac-bar-fill {
            height: 100%;
            border-radius: 99px;
        }

        .ac-tend {
            font-size: .65rem;
            font-weight: 700;
            padding: .1rem .4rem;
            border-radius: 3px;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }

        /* Detalle */
        .ac-detalle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: .375rem;
        }

        .ac-mes-item {
            background: var(--card);
            border-radius: .5rem;
            padding: .5rem;
            text-align: center;
        }

        .ac-mes-nombre {
            font-size: .58rem;
            color: var(--muted);
        }

        .ac-mes-valor {
            font-size: .78rem;
            font-weight: 800;
            margin: .1rem 0;
        }

        .ac-mes-conteo {
            font-size: .58rem;
            color: var(--muted);
        }

        .ac-chart-wrap {
            position: relative;
            height: 220px;
        }
    </style>

    <div class="ac">

        {{-- Toolbar --}}
        <div class="ac-card">
            <div class="ac-toolbar">
                <div class="ac-tipo-btns">
                    <button class="ac-tipo-btn {{ $tipo === 'egreso' ? 'on-egreso' : '' }}"
                        wire:click="$set('tipo','egreso')">🔴 Egresos</button>
                    <button class="ac-tipo-btn {{ $tipo === 'ingreso' ? 'on-ingreso' : '' }}"
                        wire:click="$set('tipo','ingreso')">🟢 Ingresos</button>
                </div>

                <select wire:model.live="meses" class="ac-select">
                    <option value="3">Últimos 3 meses</option>
                    <option value="6">Últimos 6 meses</option>
                    <option value="12">Último año</option>
                </select>

                <select wire:model.live="categoriaId" class="ac-select">
                    <option value="0">— Ver detalle de categoría —</option>
                    @foreach($cats as $id => $nombre)
                        <option value="{{ $id }}">{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Resumen categorías --}}
        <div class="ac-card">
            <div class="ac-title">🏷️ Ranking de categorías — últimos {{ $meses }} meses</div>

            @if(count($resumen) > 0)
                <div class="ac-grid">
                    @foreach($resumen as $cat)
                        @php
                            $color = $cat['color'] ?? '#6b7280';
                            $tendColor = $cat['tendencia'] > 0 ? '#ef4444' : ($cat['tendencia'] < 0 ? '#22c55e' : '#6b7280');
                            $tendEmoji = $cat['tendencia'] > 0 ? '↑' : ($cat['tendencia'] < 0 ? '↓' : '→');
                            $esActivo = $categoriaId == $cat['id'];
                        @endphp
                        <div class="ac-cat-card {{ $esActivo ? 'activo' : '' }}"
                            wire:click="$set('categoriaId', {{ $cat['id'] }})">

                            <div class="ac-cat-header">
                                <div class="ac-cat-nombre">{{ $cat['nombre'] }}</div>
                                <div class="ac-cat-total" style="color:{{ $tipo === 'egreso' ? '#ef4444' : '#22c55e' }};">
                                    S/ {{ number_format($cat['total'], 0) }}
                                </div>
                            </div>

                            <div class="ac-bar-wrap">
                                <div class="ac-bar-fill"
                                    style="width:{{ ($cat['total'] / $maxTotal) * 100 }}%; background:{{ $color }};"></div>
                            </div>

                            <div class="ac-cat-row">
                                <span>{{ $cat['pct'] }}% del total</span>
                                <span>{{ $cat['conteo'] }} movimientos</span>
                                <span class="ac-tend" style="background:{{ $tendColor }}18; color:{{ $tendColor }};">
                                    {{ $tendEmoji }} {{ abs($cat['tendencia']) }}%
                                </span>
                            </div>

                            <div class="ac-cat-row">
                                <span>Prom/mes: S/ {{ number_format($cat['promMensual'], 2) }}</span>
                                <span>Prom/mov: S/ {{ number_format($cat['promPorMov'], 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; color:var(--muted); padding:2rem;">Sin datos para este período.</div>
            @endif
        </div>

        {{-- Detalle de categoría seleccionada --}}
        @if($categoriaId > 0 && count($detalle) > 0)
            <div class="ac-card">
                <div class="ac-title">
                    📊 Detalle — {{ $detalle['categoria']->nombre }}
                    <span style="color:var(--muted); font-weight:400;">· Promedio S/
                        {{ number_format($detalle['promedio'], 2) }}/mes</span>
                </div>

                {{-- Gráfico --}}
                <div class="ac-chart-wrap" style="margin-bottom:1rem;">
                    <canvas id="acChart"></canvas>
                </div>

                {{-- Grid meses --}}
                <div class="ac-detalle-grid">
                    @foreach($detalle['meses'] as $m)
                        @php $altura = $detalle['max'] > 0 ? ($m['total'] / $detalle['max']) * 100 : 0; @endphp
                        <div class="ac-mes-item">
                            <div class="ac-mes-nombre">{{ $m['mes'] }}</div>
                            <div class="ac-mes-valor" style="color:{{ $tipo === 'egreso' ? '#ef4444' : '#22c55e' }};">
                                {{ $m['total'] > 0 ? 'S/' . number_format($m['total'], 0) : '—' }}
                            </div>
                            <div class="ac-mes-conteo">{{ $m['conteo'] }} movs.</div>
                        </div>
                    @endforeach
                </div>

                {{-- Top subcategorías por mes --}}
                <div style="margin-top:1rem;">
                    <div
                        style="font-size:.65rem; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.5rem;">
                        Top subcategorías por mes</div>
                    @foreach($detalle['meses'] as $m)
                        @if($m['topSub'] !== '—')
                            <div
                                style="display:flex; gap:.5rem; font-size:.7rem; margin-bottom:.3rem; padding:.375rem .625rem; background:var(--card); border-radius:.375rem;">
                                <span style="font-weight:700; color:var(--text); min-width:60px;">{{ $m['mes'] }}</span>
                                <span style="color:var(--muted);">{{ $m['topSub'] }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
            <script>
                function initAcChart() {
                    const meses = @json($detalle['meses'] ?? []);
                    const ctx = document.getElementById('acChart');
                    if (!ctx) return;
                    if (window._acChart) window._acChart.destroy();

                    const color = tipo === 'egreso' ? '#ef4444' : '#22c55e';

                    window._acChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: meses.map(m => m.mes),
                            datasets: [{
                                label: 'Gasto mensual',
                                data: meses.map(m => m.total),
                                backgroundColor: color + '44',
                                borderColor: color,
                                borderWidth: 1.5, borderRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(15,23,42,.9)',
                                    titleColor: '#f1f5f9', bodyColor: '#94a3b8',
                                    callbacks: { label: c => ` S/ ${c.parsed.y.toFixed(2)}` }
                                }
                            },
                            scales: {
                                x: { grid: { display: false }, ticks: { color: '#6b7280', font: { size: 10 } } },
                                y: { grid: { color: 'rgba(255,255,255,.04)' }, ticks: { color: '#6b7280', callback: v => 'S/' + v } }
                            }
                        }
                    });
                };

                initAcChart();

                document.addEventListener('livewire:updated', initAcChart);
            </script>
        @endif

    </div>
</x-filament-panels::page>
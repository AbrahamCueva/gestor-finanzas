<x-filament-panels::page>
    @php
        $base = $this->getBase();
        $sim = $this->getSimulacion();
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
            --purple: #a78bfa;
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
        }

        .se {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .se-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .se-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Controles */
        .se-controles {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .875rem;
        }

        @media(max-width:768px) {
            .se-controles {
                grid-template-columns: 1fr;
            }
        }

        .se-control {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
        }

        .se-control-label {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .se-control-valor {
            font-size: 1.1rem;
            font-weight: 900;
            text-align: center;
            margin: .5rem 0;
        }

        .se-slider {
            width: 100%;
            appearance: none;
            height: 4px;
            border-radius: 99px;
            background: var(--border);
            outline: none;
            cursor: pointer;
        }

        .se-slider::-webkit-slider-thumb {
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--gold);
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .2);
        }

        .se-input {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: .5rem;
            padding: .4rem .75rem;
            font-size: .85rem;
            color: var(--text);
            outline: none;
            text-align: center;
            transition: border-color .15s;
        }

        .se-input:focus {
            border-color: var(--gold);
        }

        .se-reset-btn {
            padding: .3rem .875rem;
            border-radius: 99px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--muted);
            font-size: .72rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .se-reset-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        /* Comparativa */
        .se-comparativa {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: .625rem;
        }

        @media(max-width:640px) {
            .se-comparativa {
                grid-template-columns: 1fr;
            }
        }

        .se-comp-card {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
            border: 1.5px solid transparent;
            text-align: center;
        }

        .se-comp-card.actual {
            border-color: rgba(96, 165, 250, .2);
        }

        .se-comp-card.simulado {
            border-color: rgba(251, 191, 36, .2);
        }

        .se-comp-card.diferencia {
            border-color: rgba(167, 139, 250, .2);
        }

        .se-comp-titulo {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .625rem;
        }

        .se-comp-row {
            display: flex;
            justify-content: space-between;
            font-size: .75rem;
            margin-bottom: .35rem;
        }

        .se-comp-label {
            color: var(--muted);
        }

        .se-comp-value {
            font-weight: 700;
        }

        /* KPIs resultado */
        .se-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .625rem;
        }

        @media(max-width:768px) {
            .se-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .se-kpi {
            background: var(--card);
            border-radius: .75rem;
            padding: .75rem;
        }

        .se-kpi-label {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            margin-bottom: .2rem;
        }

        .se-kpi-value {
            font-size: 1rem;
            font-weight: 900;
        }

        .se-kpi-sub {
            font-size: .6rem;
            color: var(--muted);
            margin-top: .1rem;
        }

        /* Tabla proyección */
        .se-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .775rem;
        }

        .se-table th {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .se-table td {
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            color: var(--soft);
        }

        .se-table tr:last-child td {
            border-bottom: none;
        }

        .se-table tr:hover td {
            background: var(--card);
        }

        /* Objetivo badge */
        .se-objetivo {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .875rem 1rem;
            border-radius: .875rem;
            margin-bottom: 1rem;
        }

        .se-objetivo.cumple {
            background: rgba(34, 197, 94, .08);
            border: 1px solid rgba(34, 197, 94, .2);
        }

        .se-objetivo.falta {
            background: rgba(251, 191, 36, .08);
            border: 1px solid rgba(251, 191, 36, .2);
        }

        .se-chart-wrap {
            position: relative;
            height: 260px;
        }

        /* Presets */
        .se-presets {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .se-preset-btn {
            padding: .3rem .875rem;
            border-radius: 99px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--muted);
            font-size: .72rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .se-preset-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
        }
    </style>

    <div class="se">

        {{-- Presets rápidos --}}
        <div class="se-card">
            <div class="se-title">⚡ Escenarios rápidos</div>
            <div class="se-presets">
                <button class="se-preset-btn" wire:click="$set('ajusteIngresos',20);$set('ajusteEgresos',0)">📈 +20%
                    sueldo</button>
                <button class="se-preset-btn" wire:click="$set('ajusteEgresos',-20);$set('ajusteIngresos',0)">✂️ -20%
                    gastos</button>
                <button class="se-preset-btn" wire:click="$set('ajusteIngresos',10);$set('ajusteEgresos',-10)">⚖️
                    Optimista (+10% ing, -10% egr)</button>
                <button class="se-preset-btn" wire:click="$set('ajusteIngresos',-15);$set('ajusteEgresos',15)">😰
                    Pesimista (-15% ing, +15% egr)</button>
                <button class="se-preset-btn"
                    wire:click="$set('ajusteIngresos',0);$set('ajusteEgresos',0);$set('gastoExtra',0);$set('ingresoExtra',0)">🔄
                    Resetear</button>
            </div>
        </div>

        {{-- Controles --}}
        <div class="se-card">
            <div class="se-title">🎛️ Ajusta tu escenario</div>
            <div class="se-controles">

                {{-- Ajuste ingresos --}}
                <div class="se-control">
                    <div class="se-control-label">
                        <span>💰 Cambio en ingresos</span>
                    </div>
                    <div class="se-control-valor" style="color:{{ $ajusteIngresos >= 0 ? '#22c55e' : '#ef4444' }};">
                        {{ $ajusteIngresos >= 0 ? '+' : '' }}{{ $ajusteIngresos }}%
                    </div>
                    <input type="range" class="se-slider" min="-50" max="100" step="5" wire:model.live="ajusteIngresos">
                    <div
                        style="display:flex; justify-content:space-between; font-size:.58rem; color:var(--muted); margin-top:.25rem;">
                        <span>-50%</span><span>0%</span><span>+100%</span>
                    </div>
                </div>

                {{-- Ajuste egresos --}}
                <div class="se-control">
                    <div class="se-control-label">
                        <span>💸 Cambio en gastos</span>
                    </div>
                    <div class="se-control-valor" style="color:{{ $ajusteEgresos <= 0 ? '#22c55e' : '#ef4444' }};">
                        {{ $ajusteEgresos >= 0 ? '+' : '' }}{{ $ajusteEgresos }}%
                    </div>
                    <input type="range" class="se-slider" min="-50" max="100" step="5" wire:model.live="ajusteEgresos">
                    <div
                        style="display:flex; justify-content:space-between; font-size:.58rem; color:var(--muted); margin-top:.25rem;">
                        <span>-50%</span><span>0%</span><span>+100%</span>
                    </div>
                </div>

                {{-- Objetivo ahorro --}}
                <div class="se-control">
                    <div class="se-control-label">
                        <span>🎯 Objetivo de ahorro</span>
                    </div>
                    <div class="se-control-valor" style="color:var(--gold);">{{ $ahorroPropuesto }}%</div>
                    <input type="range" class="se-slider" min="5" max="50" step="5" wire:model.live="ahorroPropuesto">
                    <div
                        style="display:flex; justify-content:space-between; font-size:.58rem; color:var(--muted); margin-top:.25rem;">
                        <span>5%</span><span>25%</span><span>50%</span>
                    </div>
                </div>

                {{-- Ingreso extra --}}
                <div class="se-control">
                    <div class="se-control-label"><span>➕ Ingreso extra/mes</span></div>
                    <input type="number" class="se-input" wire:model.live="ingresoExtra" placeholder="0.00" min="0">
                    <div style="font-size:.62rem; color:var(--muted); margin-top:.35rem; text-align:center;">Ej: trabajo
                        freelance</div>
                </div>

                {{-- Gasto extra --}}
                <div class="se-control">
                    <div class="se-control-label"><span>➖ Gasto extra/mes</span></div>
                    <input type="number" class="se-input" wire:model.live="gastoExtra" placeholder="0.00" min="0">
                    <div style="font-size:.62rem; color:var(--muted); margin-top:.35rem; text-align:center;">Ej: nuevo
                        alquiler</div>
                </div>

                {{-- Meses proyección --}}
                <div class="se-control">
                    <div class="se-control-label"><span>📅 Meses a proyectar</span></div>
                    <div class="se-control-valor" style="color:var(--blue);">{{ $mesesProyeccion }} meses</div>
                    <input type="range" class="se-slider" min="1" max="24" step="1" wire:model.live="mesesProyeccion">
                    <div
                        style="display:flex; justify-content:space-between; font-size:.58rem; color:var(--muted); margin-top:.25rem;">
                        <span>1 mes</span><span>1 año</span><span>2 años</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Objetivo de ahorro --}}
        <div class="se-objetivo {{ $sim['cumpleObjetivo'] ? 'cumple' : 'falta' }}">
            <div style="font-size:1.5rem;">{{ $sim['cumpleObjetivo'] ? '✅' : '⚠️' }}</div>
            <div>
                <div
                    style="font-size:.875rem; font-weight:700; color:{{ $sim['cumpleObjetivo'] ? '#22c55e' : '#fbbf24' }};">
                    {{ $sim['cumpleObjetivo'] ? '¡Cumples tu objetivo de ahorro del ' . $ahorroPropuesto . '%!' : 'No alcanzas tu objetivo de ahorro del ' . $ahorroPropuesto . '%' }}
                </div>
                <div style="font-size:.72rem; color:var(--muted); margin-top:.15rem;">
                    Ahorro necesario: S/ {{ number_format($sim['ahorroObjetivo'], 2) }}/mes ·
                    Ahorro simulado: S/ {{ number_format($sim['ahorroMensual'], 2) }}/mes
                    @if(!$sim['cumpleObjetivo'])
                        · Te faltan S/ {{ number_format($sim['ahorroObjetivo'] - $sim['ahorroMensual'], 2) }}/mes
                    @endif
                </div>
            </div>
        </div>

        {{-- Comparativa --}}
        <div class="se-comparativa">
            <div class="se-comp-card actual">
                <div class="se-comp-titulo">📊 Situación actual</div>
                <div class="se-comp-row">
                    <span class="se-comp-label">Ingresos</span>
                    <span class="se-comp-value" style="color:var(--green);">S/
                        {{ number_format($base['ingresos'], 2) }}</span>
                </div>
                <div class="se-comp-row">
                    <span class="se-comp-label">Egresos</span>
                    <span class="se-comp-value" style="color:var(--red);">S/
                        {{ number_format($base['egresos'], 2) }}</span>
                </div>
                <div class="se-comp-row"
                    style="border-top:1px solid var(--border); padding-top:.35rem; margin-top:.35rem;">
                    <span class="se-comp-label">Ahorro</span>
                    <span class="se-comp-value" style="color:var(--blue);">S/
                        {{ number_format($base['ingresos'] - $base['egresos'], 2) }}</span>
                </div>
            </div>

            <div class="se-comp-card simulado">
                <div class="se-comp-titulo">🔮 Escenario simulado</div>
                <div class="se-comp-row">
                    <span class="se-comp-label">Ingresos</span>
                    <span class="se-comp-value" style="color:var(--green);">S/
                        {{ number_format($sim['ingresosNuevos'], 2) }}</span>
                </div>
                <div class="se-comp-row">
                    <span class="se-comp-label">Egresos</span>
                    <span class="se-comp-value" style="color:var(--red);">S/
                        {{ number_format($sim['egresosNuevos'], 2) }}</span>
                </div>
                <div class="se-comp-row"
                    style="border-top:1px solid var(--border); padding-top:.35rem; margin-top:.35rem;">
                    <span class="se-comp-label">Ahorro ({{ $sim['pctAhorro'] }}%)</span>
                    <span class="se-comp-value"
                        style="color:{{ $sim['ahorroMensual'] >= 0 ? 'var(--blue)' : 'var(--red)' }};">
                        S/ {{ number_format($sim['ahorroMensual'], 2) }}
                    </span>
                </div>
            </div>

            <div class="se-comp-card diferencia">
                <div class="se-comp-titulo">📈 Diferencia</div>
                <div class="se-comp-row">
                    <span class="se-comp-label">Ingresos</span>
                    <span class="se-comp-value"
                        style="color:{{ ($sim['ingresosNuevos'] - $base['ingresos']) >= 0 ? 'var(--green)' : 'var(--red)' }};">
                        {{ ($sim['ingresosNuevos'] - $base['ingresos']) >= 0 ? '+' : '' }}S/
                        {{ number_format($sim['ingresosNuevos'] - $base['ingresos'], 2) }}
                    </span>
                </div>
                <div class="se-comp-row">
                    <span class="se-comp-label">Egresos</span>
                    <span class="se-comp-value"
                        style="color:{{ ($sim['egresosNuevos'] - $base['egresos']) <= 0 ? 'var(--green)' : 'var(--red)' }};">
                        {{ ($sim['egresosNuevos'] - $base['egresos']) >= 0 ? '+' : '' }}S/
                        {{ number_format($sim['egresosNuevos'] - $base['egresos'], 2) }}
                    </span>
                </div>
                <div class="se-comp-row"
                    style="border-top:1px solid var(--border); padding-top:.35rem; margin-top:.35rem;">
                    <span class="se-comp-label">Ahorro extra</span>
                    <span class="se-comp-value"
                        style="color:{{ $sim['diferenciaAhorro'] >= 0 ? 'var(--purple)' : 'var(--red)' }};">
                        {{ $sim['diferenciaAhorro'] >= 0 ? '+' : '' }}S/
                        {{ number_format($sim['diferenciaAhorro'], 2) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Gráfico proyección --}}
        <div class="se-card">
            <div class="se-title">📈 Proyección de saldo — {{ $mesesProyeccion }} meses</div>
            <div class="se-chart-wrap">
                <canvas id="seChart"></canvas>
            </div>
        </div>

        {{-- Tabla proyección --}}
        <div class="se-card">
            <div class="se-title">📅 Detalle mes a mes</div>
            <div style="overflow-x:auto;">
                <table class="se-table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th style="text-align:right;">Ingresos</th>
                            <th style="text-align:right;">Egresos</th>
                            <th style="text-align:right;">Ahorro</th>
                            <th style="text-align:right;">Saldo simulado</th>
                            <th style="text-align:right;">Saldo actual</th>
                            <th style="text-align:right;">Diferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sim['proyeccion'] as $fila)
                            <tr>
                                <td style="font-weight:700; color:var(--text);">{{ $fila['mes'] }}</td>
                                <td style="text-align:right; color:var(--green); font-weight:600;">S/
                                    {{ number_format($fila['ingresos'], 2) }}
                                </td>
                                <td style="text-align:right; color:var(--red);   font-weight:600;">S/
                                    {{ number_format($fila['egresos'], 2) }}
                                </td>
                                <td
                                    style="text-align:right; color:{{ $fila['ahorro'] >= 0 ? 'var(--blue)' : 'var(--red)' }}; font-weight:600;">
                                    {{ $fila['ahorro'] >= 0 ? '+' : '' }}S/ {{ number_format($fila['ahorro'], 2) }}
                                </td>
                                <td style="text-align:right; font-weight:700; color:var(--gold);">S/
                                    {{ number_format($fila['saldo'], 2) }}
                                </td>
                                <td style="text-align:right; color:var(--muted);">S/
                                    {{ number_format($fila['saldoBase'], 2) }}
                                </td>
                                <td
                                    style="text-align:right; font-weight:700; color:{{ ($fila['saldo'] - $fila['saldoBase']) >= 0 ? 'var(--purple)' : 'var(--red)' }};">
                                    {{ ($fila['saldo'] - $fila['saldoBase']) >= 0 ? '+' : '' }}S/
                                    {{ number_format($fila['saldo'] - $fila['saldoBase'], 2) }}
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
        function initSeChart() {
            const proyeccion = @json($sim['proyeccion']);
            const ctx = document.getElementById('seChart');
            if (!ctx) return;
            if (window._seChart) window._seChart.destroy();

            window._seChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: proyeccion.map(p => p.mes),
                    datasets: [
                        {
                            label: 'Saldo simulado',
                            data: proyeccion.map(p => p.saldo),
                            borderColor: '#fbbf24',
                            backgroundColor: 'rgba(251,191,36,.1)',
                            borderWidth: 2.5, tension: 0.4,
                            pointRadius: 4, fill: true,
                        },
                        {
                            label: 'Saldo actual (sin cambios)',
                            data: proyeccion.map(p => p.saldoBase),
                            borderColor: '#6b7280',
                            backgroundColor: 'transparent',
                            borderWidth: 1.5, tension: 0.4,
                            borderDash: [5, 5], pointRadius: 3,
                        },
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { labels: { color: '#6b7280', font: { size: 11 } } },
                        tooltip: {
                            backgroundColor: 'rgba(15,23,42,.9)',
                            titleColor: '#f1f5f9', bodyColor: '#94a3b8',
                            callbacks: { label: c => ` ${c.dataset.label}: S/ ${c.parsed.y.toFixed(2)}` }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#6b7280', font: { size: 10 } } },
                        y: { grid: { color: 'rgba(255,255,255,.04)' }, ticks: { color: '#6b7280', callback: v => 'S/' + v.toLocaleString() } }
                    }
                }
            });

            // Actualizar gráfico cuando Livewire actualiza
            document.addEventListener('livewire:updated', () => {
                if (window._seChart) window._seChart.destroy();
            });
        };

        initSeChart();
        document.addEventListener('livewire:updated', initSeChart);
    </script>
</x-filament-panels::page>
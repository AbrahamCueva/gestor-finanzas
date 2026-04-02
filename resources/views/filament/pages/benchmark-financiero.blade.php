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
            --green: #22c55e;
            --red: #ef4444;
            --blue: #60a5fa;
            --orange: #f97316;
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
        }

        .bf {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .bf-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .bf-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* Score */
        .bf-score-wrap {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .bf-score-circle {
            position: relative;
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .bf-score-circle svg {
            transform: rotate(-90deg);
        }

        .bf-score-num {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .bf-score-val {
            font-size: 1.25rem;
            font-weight: 900;
            line-height: 1;
        }

        .bf-score-max {
            font-size: .55rem;
            color: var(--muted);
        }

        .bf-score-info {
            flex: 1;
        }

        .bf-score-titulo {
            font-size: 1rem;
            font-weight: 800;
        }

        .bf-score-desc {
            font-size: .75rem;
            color: var(--muted);
            margin-top: .2rem;
        }

        /* Grid comparativas */
        .bf-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: .75rem;
        }

        @media(max-width:768px) {
            .bf-grid {
                grid-template-columns: 1fr;
            }
        }

        .bf-comp-card {
            background: var(--card);
            border-radius: .875rem;
            padding: 1rem;
            border-left: 3px solid transparent;
        }

        .bf-comp-card.bajo {
            border-color: #60a5fa;
        }

        .bf-comp-card.normal {
            border-color: #22c55e;
        }

        .bf-comp-card.alto {
            border-color: #fbbf24;
        }

        .bf-comp-card.muy_alto {
            border-color: #ef4444;
        }

        .bf-comp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: .625rem;
        }

        .bf-comp-left {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .bf-comp-emoji {
            font-size: 1.1rem;
        }

        .bf-comp-nombre {
            font-size: .825rem;
            font-weight: 700;
            color: var(--text);
        }

        .bf-comp-estado {
            font-size: .6rem;
            font-weight: 700;
            padding: .1rem .4rem;
            border-radius: 99px;
        }

        /* Barras */
        .bf-barra-wrap {
            margin-bottom: .375rem;
        }

        .bf-barra-label {
            display: flex;
            justify-content: space-between;
            font-size: .62rem;
            color: var(--muted);
            margin-bottom: .2rem;
        }

        .bf-barra-track {
            height: 6px;
            background: var(--border);
            border-radius: 99px;
            overflow: visible;
            position: relative;
        }

        .bf-barra-rango {
            position: absolute;
            height: 100%;
            border-radius: 99px;
            background: rgba(34, 197, 94, .2);
            border: 1px solid rgba(34, 197, 94, .3);
        }

        .bf-barra-tuyo {
            position: absolute;
            height: 10px;
            top: -2px;
            width: 3px;
            border-radius: 99px;
            background: var(--gold);
            box-shadow: 0 0 6px rgba(251, 191, 36, .6);
        }

        .bf-barra-promedio {
            position: absolute;
            height: 10px;
            top: -2px;
            width: 2px;
            background: rgba(255, 255, 255, .4);
        }

        .bf-comp-nums {
            display: flex;
            justify-content: space-between;
            font-size: .68rem;
            margin-top: .5rem;
        }

        .bf-comp-tuyo {
            font-weight: 700;
        }

        .bf-comp-peru {
            color: var(--muted);
        }

        .bf-comp-diff {
            font-weight: 700;
        }

        /* Leyenda */
        .bf-leyenda {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            margin-top: .75rem;
            padding-top: .75rem;
            border-top: 1px solid var(--border);
        }

        .bf-ley-item {
            display: flex;
            align-items: center;
            gap: .35rem;
            font-size: .62rem;
            color: var(--muted);
        }

        .bf-ley-dot {
            width: 10px;
            height: 4px;
            border-radius: 2px;
        }

        /* Gráfico radar */
        .bf-chart-wrap {
            position: relative;
            height: 320px;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Tabla resumen */
        .bf-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .775rem;
        }

        .bf-table th {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        .bf-table td {
            padding: .5rem .75rem;
            border-bottom: 1px solid var(--border);
            color: var(--soft);
        }

        .bf-table tr:last-child td {
            border-bottom: none;
        }

        .bf-table tr:hover td {
            background: var(--card);
        }

        .bf-fuente {
            font-size: .62rem;
            color: var(--muted);
            text-align: right;
            margin-top: .5rem;
            font-style: italic;
        }
    </style>

    <div class="bf">

        {{-- Score --}}
        <div class="bf-card">
            <div class="bf-score-wrap">
                <div class="bf-score-circle">
                    <svg width="80" height="80" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="32" fill="none" stroke="var(--border)" stroke-width="6" />
                        <circle cx="40" cy="40" r="32" fill="none" stroke="{{ $d['nivel']['color'] }}" stroke-width="6"
                            stroke-linecap="round" stroke-dasharray="{{ round(2 * M_PI * 32, 2) }}"
                            stroke-dashoffset="{{ round(2 * M_PI * 32 * (1 - $d['puntaje'] / 100), 2) }}" />
                    </svg>
                    <div class="bf-score-num">
                        <span class="bf-score-val" style="color:{{ $d['nivel']['color'] }};">{{ $d['puntaje'] }}</span>
                        <span class="bf-score-max">/100</span>
                    </div>
                </div>
                <div class="bf-score-info">
                    <div class="bf-score-titulo" style="color:{{ $d['nivel']['color'] }};">
                        {{ $d['nivel']['emoji'] }} {{ $d['nivel']['label'] }}
                    </div>
                    <div class="bf-score-desc">
                        Comparado con el peruano promedio según datos del INEI/ENAHO.
                        Ingreso base: S/ {{ number_format($d['ingresosProm'], 2) }}/mes (promedio últimos 3 meses).
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico radar --}}
        <div class="bf-card">
            <div class="bf-title">📊 Radar de categorías vs promedio peruano</div>
            <div class="bf-chart-wrap">
                <canvas id="bfChart"></canvas>
            </div>
        </div>

        {{-- Grid comparativas --}}
        <div class="bf-card">
            <div class="bf-title">🔍 Análisis por categoría</div>
            <div class="bf-grid">
                @foreach($d['comparativas'] as $c)
                    @php
                        $estadoConfig = match ($c['estado']) {
                            'bajo' => ['color' => '#60a5fa', 'label' => '↓ Bajo promedio', 'bg' => 'rgba(96,165,250,.12)'],
                            'normal' => ['color' => '#22c55e', 'label' => '✓ En el promedio', 'bg' => 'rgba(34,197,94,.12)'],
                            'alto' => ['color' => '#fbbf24', 'label' => '↑ Sobre promedio', 'bg' => 'rgba(251,191,36,.12)'],
                            'muy_alto' => ['color' => '#ef4444', 'label' => '⚠ Muy alto', 'bg' => 'rgba(239,68,68,.12)'],
                        };
                        $maxRango = $c['maxPeru'] + 5;
                        $pctTuyoBar = min(100, ($c['pctTuyo'] / $maxRango) * 100);
                        $pctMinBar = ($c['minPeru'] / $maxRango) * 100;
                        $pctMaxBar = ($c['maxPeru'] / $maxRango) * 100;
                        $pctPromBar = ($c['promPeru'] / $maxRango) * 100;
                    @endphp
                    <div class="bf-comp-card {{ $c['estado'] }}">
                        <div class="bf-comp-header">
                            <div class="bf-comp-left">
                                <span class="bf-comp-emoji">{{ $c['emoji'] }}</span>
                                <span class="bf-comp-nombre">{{ $c['label'] }}</span>
                            </div>
                            <span class="bf-comp-estado"
                                style="background:{{ $estadoConfig['bg'] }}; color:{{ $estadoConfig['color'] }};">
                                {{ $estadoConfig['label'] }}
                            </span>
                        </div>

                        {{-- Barra visual --}}
                        <div class="bf-barra-wrap">
                            <div class="bf-barra-label">
                                <span>0%</span>
                                <span>Rango peruano: {{ $c['minPeru'] }}% — {{ $c['maxPeru'] }}%</span>
                                <span>{{ $maxRango }}%</span>
                            </div>
                            <div class="bf-barra-track">
                                {{-- Rango normal --}}
                                <div class="bf-barra-rango"
                                    style="left:{{ $pctMinBar }}%; width:{{ $pctMaxBar - $pctMinBar }}%;"></div>
                                {{-- Promedio peruano --}}
                                <div class="bf-barra-promedio" style="left:{{ $pctPromBar }}%;"></div>
                                {{-- Tu gasto --}}
                                <div class="bf-barra-tuyo" style="left:{{ $pctTuyoBar }}%;"></div>
                            </div>
                        </div>

                        <div class="bf-comp-nums">
                            <div>
                                <div style="font-size:.58rem; color:var(--muted);">Tu gasto</div>
                                <span class="bf-comp-tuyo" style="color:{{ $estadoConfig['color'] }};">{{ $c['pctTuyo'] }}%
                                    (S/ {{ number_format($c['tuyo'], 0) }})</span>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-size:.58rem; color:var(--muted);">Promedio Perú</div>
                                <span class="bf-comp-peru">{{ $c['promPeru'] }}%</span>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-size:.58rem; color:var(--muted);">Diferencia</div>
                                <span class="bf-comp-diff"
                                    style="color:{{ $c['diferencia'] > 0 ? '#ef4444' : '#22c55e' }};">
                                    {{ $c['diferencia'] > 0 ? '+' : '' }}{{ $c['diferencia'] }}%
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bf-leyenda">
                <div class="bf-ley-item">
                    <div class="bf-ley-dot" style="background:rgba(34,197,94,.4);"></div> Rango normal peruano
                </div>
                <div class="bf-ley-item">
                    <div style="width:2px; height:10px; background:rgba(255,255,255,.4); border-radius:99px;"></div>
                    Promedio exacto
                </div>
                <div class="bf-ley-item">
                    <div
                        style="width:3px; height:10px; background:var(--gold); border-radius:99px; box-shadow:0 0 6px rgba(251,191,36,.6);">
                    </div> Tu gasto
                </div>
            </div>

            <div class="bf-fuente">Fuente: INEI — Encuesta Nacional de Hogares (ENAHO) · Datos referenciales</div>
        </div>

        {{-- Tabla resumen --}}
        <div class="bf-card">
            <div class="bf-title">📋 Resumen comparativo</div>
            <div style="overflow-x:auto;">
                <table class="bf-table">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th style="text-align:right;">Tu %</th>
                            <th style="text-align:right;">Promedio Perú</th>
                            <th style="text-align:right;">Rango normal</th>
                            <th style="text-align:right;">Diferencia</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($d['comparativas'] as $c)
                            @php
                                $sc = match ($c['estado']) {
                                    'bajo' => '#60a5fa',
                                    'normal' => '#22c55e',
                                    'alto' => '#fbbf24',
                                    'muy_alto' => '#ef4444',
                                };
                                $sl = match ($c['estado']) {
                                    'bajo' => '↓ Bajo',
                                    'normal' => '✓ Normal',
                                    'alto' => '↑ Alto',
                                    'muy_alto' => '⚠ Muy alto',
                                };
                            @endphp
                            <tr>
                                <td style="font-weight:600; color:var(--text);">{{ $c['emoji'] }} {{ $c['label'] }}</td>
                                <td style="text-align:right; font-weight:700; color:{{ $sc }};">{{ $c['pctTuyo'] }}%</td>
                                <td style="text-align:right; color:var(--muted);">{{ $c['promPeru'] }}%</td>
                                <td style="text-align:right; color:var(--muted);">{{ $c['minPeru'] }}% —
                                    {{ $c['maxPeru'] }}%</td>
                                <td
                                    style="text-align:right; font-weight:700; color:{{ $c['diferencia'] > 0 ? '#ef4444' : '#22c55e' }};">
                                    {{ $c['diferencia'] > 0 ? '+' : '' }}{{ $c['diferencia'] }}%
                                </td>
                                <td>
                                    <span
                                        style="background:{{ $sc }}18; color:{{ $sc }}; padding:.1rem .4rem; border-radius:3px; font-size:.65rem; font-weight:700;">
                                        {{ $sl }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bf-fuente">Fuente: INEI — Encuesta Nacional de Hogares (ENAHO) · Datos referenciales</div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        function initBfChart() {
            const comparativas = @json($d['comparativas']);
            const ctx = document.getElementById('bfChart');
            if (!ctx || !comparativas.length) return;
            if (window._bfChart) window._bfChart.destroy();

            window._bfChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: comparativas.map(c => c.emoji + ' ' + c.label),
                    datasets: [
                        {
                            label: 'Tu gasto %',
                            data: comparativas.map(c => c.pctTuyo),
                            borderColor: '#fbbf24',
                            backgroundColor: 'rgba(251,191,36,.15)',
                            borderWidth: 2, pointRadius: 4,
                            pointBackgroundColor: '#fbbf24',
                        },
                        {
                            label: 'Promedio Perú %',
                            data: comparativas.map(c => c.promPeru),
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34,197,94,.1)',
                            borderWidth: 2, pointRadius: 3,
                            borderDash: [5, 5],
                            pointBackgroundColor: '#22c55e',
                        },
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { color: '#6b7280', font: { size: 11 } } },
                        tooltip: {
                            backgroundColor: 'rgba(15,23,42,.9)',
                            titleColor: '#f1f5f9', bodyColor: '#94a3b8',
                            callbacks: { label: c => ` ${c.dataset.label}: ${c.parsed.r}%` }
                        }
                    },
                    scales: {
                        r: {
                            grid: { color: 'rgba(255,255,255,.06)' },
                            ticks: { color: '#6b7280', font: { size: 9 }, backdropColor: 'transparent', callback: v => v + '%' },
                            pointLabels: { color: '#9ca3af', font: { size: 10 } },
                            angleLines: { color: 'rgba(255,255,255,.06)' },
                        }
                    }
                }
            });
        }

        initBfChart();
        document.addEventListener('livewire:updated', initBfChart);
    </script>
</x-filament-panels::page>
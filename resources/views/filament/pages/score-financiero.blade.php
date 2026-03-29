<x-filament-panels::page>
    @php
        $d = $this->getDatos();
        $nivel = $d['nivel'];
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

        .sf-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .sf-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .sf-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* Score principal */
        .sf-score-wrap {
            display: flex;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .sf-score-circle {
            position: relative;
            width: 120px;
            height: 120px;
            flex-shrink: 0;
        }

        .sf-score-circle svg {
            transform: rotate(-90deg);
        }

        .sf-score-number {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .sf-score-val {
            font-size: 1.75rem;
            font-weight: 900;
            line-height: 1;
        }

        .sf-score-max {
            font-size: 0.65rem;
            color: var(--w-muted);
        }

        .sf-score-info {
            flex: 1;
            min-width: 200px;
        }

        .sf-score-nivel {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .sf-score-desc {
            font-size: 0.8rem;
            color: var(--w-muted);
            margin-bottom: 0.875rem;
        }

        .sf-score-bar-wrap {
            height: 6px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 0.375rem;
        }

        .sf-score-bar {
            height: 100%;
            border-radius: 99px;
            transition: width 0.8s ease;
        }

        .sf-score-bar-label {
            font-size: 0.65rem;
            color: var(--w-muted);
        }

        /* Categorías */
        .sf-cats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        @media(max-width:768px) {
            .sf-cats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:480px) {
            .sf-cats {
                grid-template-columns: 1fr;
            }
        }

        .sf-cat-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            border: 1.5px solid transparent;
            transition: border-color 0.15s;
        }

        .sf-cat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.625rem;
        }

        .sf-cat-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sf-cat-emoji {
            font-size: 1.1rem;
        }

        .sf-cat-nombre {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .sf-cat-score {
            font-size: 0.875rem;
            font-weight: 800;
        }

        .sf-cat-bar-wrap {
            height: 4px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .sf-cat-bar {
            height: 100%;
            border-radius: 99px;
        }

        .sf-cat-desc {
            font-size: 0.68rem;
            color: var(--w-muted);
            line-height: 1.4;
        }

        .sf-cat-rec {
            font-size: 0.68rem;
            color: #fbbf24;
            margin-top: 0.375rem;
            background: rgba(251, 191, 36, 0.08);
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            line-height: 1.4;
        }

        /* Detalles */
        .sf-detalles {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem;
            margin-top: 0.5rem;
        }

        .sf-detalle-badge {
            font-size: 0.62rem;
            padding: 0.1rem 0.5rem;
            border-radius: 99px;
            font-weight: 600;
        }

        .sf-detalle-badge.ok {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .sf-detalle-badge.warning {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .sf-detalle-badge.low {
            background: rgba(249, 115, 22, 0.12);
            color: #f97316;
        }

        .sf-detalle-badge.danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        /* Recomendaciones globales */
        .sf-recs {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sf-rec {
            background: var(--w-card);
            border-radius: 0.625rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            border-left: 3px solid #fbbf24;
        }
    </style>

    <div class="sf-wrap">

        <div class="sf-card">
            <div class="sf-score-wrap">

                <div class="sf-score-circle">
                    <svg width="120" height="120" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="var(--w-border)"
                            stroke-width="8" />
                        <circle cx="60" cy="60" r="50" fill="none" stroke="{{ $nivel['color'] }}"
                            stroke-width="8" stroke-linecap="round" stroke-dasharray="{{ round(2 * M_PI * 50, 2) }}"
                            stroke-dashoffset="{{ round(2 * M_PI * 50 * (1 - $d['puntaje'] / 100), 2) }}" />
                    </svg>
                    <div class="sf-score-number">
                        <span class="sf-score-val" style="color:{{ $nivel['color'] }};">{{ $d['puntaje'] }}</span>
                        <span class="sf-score-max">/100</span>
                    </div>
                </div>

                <div class="sf-score-info">
                    <div class="sf-score-nivel" style="color:{{ $nivel['color'] }};">
                        {{ $nivel['emoji'] }} {{ $nivel['nombre'] }}
                    </div>
                    <div class="sf-score-desc">{{ $nivel['desc'] }}</div>

                    <div class="sf-score-bar-wrap">
                        <div class="sf-score-bar"
                            style="width:{{ $d['puntaje'] }}%; background:{{ $nivel['color'] }};"></div>
                    </div>
                    <div class="sf-score-bar-label">
                        {{ $d['scoreTotal'] }} / {{ $d['maxTotal'] }} puntos totales
                    </div>
                </div>

            </div>
        </div>

        <div class="sf-card">
            <div class="sf-title">📊 Desglose por categoría</div>
            <div class="sf-cats">
                @foreach ($d['categorias'] as $cat)
                    @php
                        $color = $cat['pct'] >= 75 ? '#22c55e' : ($cat['pct'] >= 50 ? '#fbbf24' : '#ef4444');
                    @endphp
                    <div class="sf-cat-card" style="border-color:{{ $color }}22;">
                        <div class="sf-cat-header">
                            <div class="sf-cat-left">
                                <span class="sf-cat-emoji">{{ $cat['emoji'] }}</span>
                                <span class="sf-cat-nombre">{{ $cat['nombre'] }}</span>
                            </div>
                            <span class="sf-cat-score" style="color:{{ $color }};">
                                {{ $cat['score'] }}/{{ $cat['max'] }}
                            </span>
                        </div>

                        <div class="sf-cat-bar-wrap">
                            <div class="sf-cat-bar"
                                style="width:{{ $cat['pct'] }}%; background:{{ $color }};"></div>
                        </div>

                        <div class="sf-cat-desc">{{ $cat['descripcion'] }}</div>

                        @if (!empty($cat['detalles']))
                            <div class="sf-detalles">
                                @foreach (array_slice($cat['detalles'], 0, 4) as $det)
                                    <span class="sf-detalle-badge {{ $det['estado'] }}">
                                        @if (isset($det['mes']))
                                            {{ $det['mes'] }} {{ $det['pct'] }}%
                                        @elseif(isset($det['nombre']))
                                            {{ $det['nombre'] }}
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if ($cat['recomendacion'])
                            <div class="sf-cat-rec">💡 {{ $cat['recomendacion'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        @php
            $recs = collect($d['categorias'])
                ->filter(fn($c) => !empty($c['recomendacion']))
                ->pluck('recomendacion')
                ->values();
        @endphp
        @if ($recs->count() > 0)
            <div class="sf-card">
                <div class="sf-title">💡 Plan de mejora</div>
                <div class="sf-recs">
                    @foreach ($recs as $rec)
                        <div class="sf-rec">
                            <span>⚡</span>
                            <span>{{ $rec }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>

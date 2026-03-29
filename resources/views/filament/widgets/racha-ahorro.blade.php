<x-filament-widgets::widget>
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

        .ra-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ra-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .ra-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ra-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* KPIs */
        .ra-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        @media(max-width:768px) {
            .ra-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .ra-kpi {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
        }

        .ra-kpi-icon {
            font-size: 1.25rem;
            margin-bottom: 0.4rem;
            line-height: 1;
        }

        .ra-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--w-muted);
            margin-bottom: 0.25rem;
        }

        .ra-kpi-value {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1;
        }

        .ra-kpi-sub {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 0.25rem;
        }

        /* Racha badge grande */
        .ra-racha-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        /* Historial de barras */
        .ra-hist-title {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 0.75rem;
        }

        .ra-bars-wrap {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 60px;
        }

        .ra-bar-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            height: 100%;
            gap: 3px;
        }

        .ra-bar-rect {
            width: 100%;
            border-radius: 3px 3px 0 0;
            min-height: 3px;
            transition: height 0.5s ease;
            position: relative;
        }

        .ra-bar-rect.ra-actual {
            box-shadow: 0 0 8px rgba(251, 191, 36, 0.4);
        }

        .ra-bar-mes {
            font-size: 0.55rem;
            color: var(--w-muted);
            font-weight: 500;
            white-space: nowrap;
        }

        .ra-bar-col.ra-actual-col .ra-bar-mes {
            color: #fbbf24;
            font-weight: 700;
        }

        /* Línea de meses */
        .ra-meses-row {
            display: flex;
            gap: 4px;
            margin-top: 0.75rem;
        }

        .ra-mes-chip {
            flex: 1;
            text-align: center;
            padding: 0.3rem 0;
            border-radius: 0.375rem;
            font-size: 0.62rem;
            font-weight: 600;
        }
    </style>

    <div class="ra-wrap">

        <div class="ra-header">
            <div>
                <div class="ra-title">Racha de Ahorro</div>
                <div class="ra-sub">Últimos 12 meses</div>
            </div>
            @if ($rachaActual >= 3)
                <span class="ra-racha-badge" style="background:rgba(251,191,36,0.15); color:#fbbf24;">
                    ¡{{ $rachaActual }} meses seguidos ahorrando!
                </span>
            @elseif($rachaActual > 0)
                <span class="ra-racha-badge" style="background:rgba(34,197,94,0.12); color:#22c55e;">
                    {{ $rachaActual }} {{ $rachaActual === 1 ? 'mes' : 'meses' }} de racha
                </span>
            @else
                <span class="ra-racha-badge" style="background:rgba(239,68,68,0.12); color:#ef4444;">
                    Sin racha activa
                </span>
            @endif
        </div>

        <div class="ra-kpis">
            <div class="ra-kpi">
                <div class="ra-kpi-icon">🔥</div>
                <div class="ra-kpi-label">Racha actual</div>
                <div class="ra-kpi-value"
                    style="color:{{ $rachaActual >= 3 ? '#fbbf24' : ($rachaActual > 0 ? '#22c55e' : '#ef4444') }};">
                    {{ $rachaActual }}
                </div>
                <div class="ra-kpi-sub">{{ $rachaActual === 1 ? 'mes consecutivo' : 'meses consecutivos' }}</div>
            </div>

            <div class="ra-kpi">
                <div class="ra-kpi-icon">🏆</div>
                <div class="ra-kpi-label">Racha máxima</div>
                <div class="ra-kpi-value" style="color:#a78bfa;">{{ $rachaMax }}</div>
                <div class="ra-kpi-sub">en los últimos 12 meses</div>
            </div>

            <div class="ra-kpi">
                <div class="ra-kpi-icon">⭐</div>
                <div class="ra-kpi-label">Mejor mes</div>
                <div class="ra-kpi-value" style="color:#60a5fa; font-size:1.1rem;">{{ $mejorMes['label'] }}</div>
                <div class="ra-kpi-sub">S/ {{ number_format($mejorMes['ahorro'], 0) }} ahorrado</div>
            </div>

            <div class="ra-kpi">
                <div class="ra-kpi-icon">💰</div>
                <div class="ra-kpi-label">Ahorro {{ now()->year }}</div>
                <div class="ra-kpi-value" style="color:{{ $totalAnio >= 0 ? '#22c55e' : '#ef4444' }}; font-size:1rem;">
                    S/ {{ number_format($totalAnio, 0) }}
                </div>
                <div class="ra-kpi-sub">acumulado este año</div>
            </div>
        </div>

        <div class="ra-hist-title">Historial de ahorro — mes a mes</div>

        @php
            $maxAbs = $meses->max(fn($m) => abs($m['ahorro'])) ?: 1;
        @endphp

        <div class="ra-bars-wrap">
            @foreach ($meses as $m)
                @php
                    $altura = max(3, round((abs($m['ahorro']) / $maxAbs) * 56));
                    $color = $m['positivo'] ? '#22c55e' : '#ef4444';
                    $bg = $m['positivo'] ? 'rgba(34,197,94,0.15)' : 'rgba(239,68,68,0.15)';
                @endphp
                <div class="ra-bar-col {{ $m['es_actual'] ? 'ra-actual-col' : '' }}">
                    <div class="ra-bar-rect {{ $m['es_actual'] ? 'ra-actual' : '' }}"
                        style="height:{{ $altura }}px; background:{{ $m['es_actual'] ? $color : $bg }}; border: 1.5px solid {{ $color }};"
                        title="{{ $m['label'] }}: S/ {{ number_format($m['ahorro'], 2) }}"></div>
                    <span class="ra-bar-mes">{{ $m['label'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="ra-meses-row">
            @foreach ($meses as $m)
                <div class="ra-mes-chip"
                    style="
                    background:{{ $m['positivo'] ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.08)' }};
                    color:{{ $m['es_actual'] ? '#fbbf24' : ($m['positivo'] ? '#22c55e' : '#ef4444') }};
                    {{ $m['es_actual'] ? 'border: 1px solid #fbbf24;' : '' }}
                "
                    title="S/ {{ number_format($m['ahorro'], 2) }}">
                    {{ $m['positivo'] ? '↑' : '↓' }}
                </div>
            @endforeach
        </div>

    </div>
</x-filament-widgets::widget>

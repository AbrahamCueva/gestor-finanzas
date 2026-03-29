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

        .cm-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .cm-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .cm-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .cm-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        .cm-months {
            display: flex;
            gap: 0.4rem;
        }

        .cm-month-pill {
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .cm-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .cm-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
        }

        .cm-card-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .cm-card-label svg {
            width: 12px;
            height: 12px;
            flex-shrink: 0;
        }

        .cm-row {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .cm-mes-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cm-mes-name {
            font-size: 0.72rem;
            color: var(--w-muted);
        }

        .cm-mes-value {
            font-size: 0.9rem;
            font-weight: 700;
        }

        .cm-bar-wrap {
            display: flex;
            gap: 0.4rem;
            align-items: flex-end;
            height: 40px;
        }

        .cm-bar-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            gap: 0.25rem;
            height: 100%;
        }

        .cm-bar {
            width: 100%;
            border-radius: 4px 4px 0 0;
            min-height: 3px;
            transition: height 0.5s ease;
        }

        .cm-bar-label-b {
            font-size: 0.6rem;
            color: var(--w-muted);
            white-space: nowrap;
        }

        .cm-diff {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.5rem;
            border-radius: 99px;
            font-size: 0.68rem;
            font-weight: 700;
        }

        .cm-diff svg {
            width: 10px;
            height: 10px;
        }

        .cm-divider {
            height: 1px;
            background: var(--w-border);
            margin: 0.25rem 0;
        }
    </style>

    <div class="cm-wrap">

        <div class="cm-header">
            <div>
                <div class="cm-title">Comparativa Mensual</div>
                <div class="cm-sub">{{ $mesAnterior }} vs {{ $mesActual }}</div>
            </div>
            <div class="cm-months">
                <span class="cm-month-pill" style="background:var(--w-card); color:var(--w-muted);">
                    {{ $mesAnterior }}
                </span>
                <span class="cm-month-pill" style="background:rgba(251,191,36,0.12); color:#fbbf24;">
                    {{ $mesActual }}
                </span>
            </div>
        </div>

        <div class="cm-grid">

            <div class="cm-card">
                <div class="cm-card-label" style="color:#22c55e;">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                    Ingresos
                </div>

                @php
                    $maxI = max($ingresosActual, $ingresosAnterior, 1);
                    $hActualI = round(($ingresosActual / $maxI) * 40);
                    $hAnteriorI = round(($ingresosAnterior / $maxI) * 40);
                @endphp

                <div class="cm-bar-wrap">
                    <div class="cm-bar-col">
                        <div class="cm-bar" style="height:{{ $hAnteriorI }}px; background:rgba(34,197,94,0.25);">
                        </div>
                        <div class="cm-bar-label-b">{{ substr($mesAnterior, 0, 3) }}</div>
                    </div>
                    <div class="cm-bar-col">
                        <div class="cm-bar" style="height:{{ $hActualI }}px; background:#22c55e;"></div>
                        <div class="cm-bar-label-b">{{ substr($mesActual, 0, 3) }}</div>
                    </div>
                </div>

                <div class="cm-divider"></div>

                <div class="cm-row">
                    <div class="cm-mes-row">
                        <span class="cm-mes-name">{{ $mesAnterior }}</span>
                        <span class="cm-mes-value" style="color:var(--w-muted);">S/
                            {{ number_format($ingresosAnterior, 2) }}</span>
                    </div>
                    <div class="cm-mes-row">
                        <span class="cm-mes-name">{{ $mesActual }}</span>
                        <span class="cm-mes-value" style="color:#22c55e;">S/
                            {{ number_format($ingresosActual, 2) }}</span>
                    </div>
                </div>

                <div>
                    @php $di = $diffIngresos; @endphp
                    <span class="cm-diff"
                        style="background:{{ $di >= 0 ? 'rgba(34,197,94,0.12)' : 'rgba(239,68,68,0.12)' }}; color:{{ $di >= 0 ? '#22c55e' : '#ef4444' }};">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            @if ($di >= 0)
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                            @endif
                        </svg>
                        {{ abs($di) }}% vs mes anterior
                    </span>
                </div>
            </div>

            <div class="cm-card">
                <div class="cm-card-label" style="color:#ef4444;">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6L9 12.75l4.306-4.307a11.95 11.95 0 015.814 5.519l2.74 1.22m0 0l-5.94 2.28m5.94-2.28l-2.28-5.941" />
                    </svg>
                    Egresos
                </div>

                @php
                    $maxE = max($egresosActual, $egresosAnterior, 1);
                    $hActualE = round(($egresosActual / $maxE) * 40);
                    $hAnteriorE = round(($egresosAnterior / $maxE) * 40);
                @endphp

                <div class="cm-bar-wrap">
                    <div class="cm-bar-col">
                        <div class="cm-bar" style="height:{{ $hAnteriorE }}px; background:rgba(239,68,68,0.25);">
                        </div>
                        <div class="cm-bar-label-b">{{ substr($mesAnterior, 0, 3) }}</div>
                    </div>
                    <div class="cm-bar-col">
                        <div class="cm-bar" style="height:{{ $hActualE }}px; background:#ef4444;"></div>
                        <div class="cm-bar-label-b">{{ substr($mesActual, 0, 3) }}</div>
                    </div>
                </div>

                <div class="cm-divider"></div>

                <div class="cm-row">
                    <div class="cm-mes-row">
                        <span class="cm-mes-name">{{ $mesAnterior }}</span>
                        <span class="cm-mes-value" style="color:var(--w-muted);">S/
                            {{ number_format($egresosAnterior, 2) }}</span>
                    </div>
                    <div class="cm-mes-row">
                        <span class="cm-mes-name">{{ $mesActual }}</span>
                        <span class="cm-mes-value" style="color:#ef4444;">S/
                            {{ number_format($egresosActual, 2) }}</span>
                    </div>
                </div>

                <div>
                    @php $de = $diffEgresos; @endphp
                    <span class="cm-diff"
                        style="background:{{ $de <= 0 ? 'rgba(34,197,94,0.12)' : 'rgba(239,68,68,0.12)' }}; color:{{ $de <= 0 ? '#22c55e' : '#ef4444' }};">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            @if ($de <= 0)
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                            @endif
                        </svg>
                        {{ abs($de) }}% vs mes anterior
                    </span>
                </div>
            </div>

            <div class="cm-card">
                <div class="cm-card-label" style="color:#60a5fa;">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ahorro Neto
                </div>

                @php
                    $maxA = max(abs($ahorroActual), abs($ahorroAnterior), 1);
                    $hActualA = round((abs($ahorroActual) / $maxA) * 40);
                    $hAnteriorA = round((abs($ahorroAnterior) / $maxA) * 40);
                @endphp

                <div class="cm-bar-wrap">
                    <div class="cm-bar-col">
                        <div class="cm-bar" style="height:{{ $hAnteriorA }}px; background:rgba(96,165,250,0.25);">
                        </div>
                        <div class="cm-bar-label-b">{{ substr($mesAnterior, 0, 3) }}</div>
                    </div>
                    <div class="cm-bar-col">
                        <div class="cm-bar" style="height:{{ $hActualA }}px; background:#60a5fa;"></div>
                        <div class="cm-bar-label-b">{{ substr($mesActual, 0, 3) }}</div>
                    </div>
                </div>

                <div class="cm-divider"></div>

                <div class="cm-row">
                    <div class="cm-mes-row">
                        <span class="cm-mes-name">{{ $mesAnterior }}</span>
                        <span class="cm-mes-value" style="color:var(--w-muted);">S/
                            {{ number_format($ahorroAnterior, 2) }}</span>
                    </div>
                    <div class="cm-mes-row">
                        <span class="cm-mes-name">{{ $mesActual }}</span>
                        <span class="cm-mes-value" style="color:#60a5fa;">S/
                            {{ number_format($ahorroActual, 2) }}</span>
                    </div>
                </div>

                <div>
                    @php $da = $diffAhorro; @endphp
                    <span class="cm-diff"
                        style="background:{{ $da >= 0 ? 'rgba(96,165,250,0.12)' : 'rgba(239,68,68,0.12)' }}; color:{{ $da >= 0 ? '#60a5fa' : '#ef4444' }};">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            @if ($da >= 0)
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                            @endif
                        </svg>
                        {{ abs($da) }}% vs mes anterior
                    </span>
                </div>
            </div>

        </div>
    </div>
</x-filament-widgets::widget>

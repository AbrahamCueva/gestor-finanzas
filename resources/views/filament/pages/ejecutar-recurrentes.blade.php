<x-filament-panels::page>
    @php
        $recurrentes = \App\Models\Movimiento::with(['cuenta', 'categoria'])
            ->where('es_recurrente', true)
            ->whereNotNull('frecuencia_recurrencia')
            ->where(function ($q) {
                $q->whereNull('fecha_fin_recurrencia')->orWhere('fecha_fin_recurrencia', '>=', now());
            })
            ->orderBy('fecha')
            ->get();
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

        .er-space {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .er-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .er-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .er-how-label {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 0.5rem;
        }

        .er-how-text {
            font-size: 0.825rem;
            color: var(--w-muted);
            line-height: 1.6;
        }

        .er-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .er-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .er-freq-card {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .er-freq-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            background: rgba(251, 191, 36, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .er-freq-icon svg {
            width: 14px;
            height: 14px;
            stroke: #fbbf24;
        }

        .er-freq-label {
            font-size: 0.75rem;
            color: var(--w-muted);
        }

        .er-freq-value {
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--w-text-soft);
            margin-top: 1px;
        }

        .er-result-card {
            border-radius: 0.875rem;
            padding: 1.25rem;
            text-align: center;
        }

        .er-result-number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }

        .er-result-label {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.4rem;
        }

        .er-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem;
            background: var(--w-card);
            border-radius: 0.75rem;
            margin-bottom: 0.4rem;
        }

        .er-row:last-child {
            margin-bottom: 0;
        }

        .er-row-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .er-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .er-row-name {
            font-size: 0.825rem;
            font-weight: 500;
            color: var(--w-text);
        }

        .er-row-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 1px;
        }

        .er-row-right {
            text-align: right;
        }

        .er-row-amount {
            font-size: 0.825rem;
            font-weight: 700;
        }

        .er-row-date {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 1px;
        }

        .er-sep {
            margin: 0 0.25rem;
            color: var(--w-border);
        }

        .er-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 0;
            color: var(--w-muted);
            font-size: 0.825rem;
            gap: 0.5rem;
        }

        .er-empty svg {
            width: 28px;
            height: 28px;
        }

        .er-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.625rem;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .er-list-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
    </style>

    <div class="er-space">

        <div class="er-card">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                <div style="flex:1; min-width:200px;">
                    <div class="er-how-label">¿Cómo funciona?</div>
                    <p class="er-how-text">
                        El sistema revisará los movimientos recurrentes activos y creará una copia
                        de los que correspondan a hoy, actualizando el saldo de cada cuenta automáticamente.
                    </p>
                </div>
                <div style="flex-shrink:0; padding-top:0.25rem;">
                    {{ $this->ejecutarAction() }}
                </div>
            </div>

            <div style="margin-top:1rem;" class="er-grid-3">
                <div class="er-freq-card">
                    <div class="er-freq-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="er-freq-label">Diario</div>
                        <div class="er-freq-value">Cada día</div>
                    </div>
                </div>
                <div class="er-freq-card">
                    <div class="er-freq-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="er-freq-label">Semanal</div>
                        <div class="er-freq-value">Cada 7 días</div>
                    </div>
                </div>
                <div class="er-freq-card">
                    <div class="er-freq-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="er-freq-label">Mensual</div>
                        <div class="er-freq-value">Cada mes</div>
                    </div>
                </div>
            </div>
        </div>

        @if ($ejecutado)
            <div class="er-card">
                <div class="er-section-title">Resultado de la última ejecución</div>
                <div class="er-grid-2">
                    <div class="er-result-card" style="background:rgba(34,197,94,0.08);">
                        <div class="er-result-number" style="color:#22c55e;">{{ $procesados }}</div>
                        <div class="er-result-label">Movimientos creados</div>
                    </div>
                    <div class="er-result-card" style="background:var(--w-card);">
                        <div class="er-result-number" style="color:var(--w-muted);">{{ $omitidos }}</div>
                        <div class="er-result-label">No correspondían a hoy</div>
                    </div>
                </div>
            </div>
        @endif

        <div class="er-card">
            <div class="er-list-header">
                <div class="er-section-title" style="margin-bottom:0;">
                    Movimientos recurrentes activos
                </div>
                @if ($recurrentes->isNotEmpty())
                    <span class="er-badge" style="background:rgba(251,191,36,0.12); color:#fbbf24;">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            style="width:11px;height:11px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        {{ $recurrentes->count() }} activos
                    </span>
                @endif
            </div>

            @if ($recurrentes->isEmpty())
                <div class="er-empty">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    No tienes movimientos recurrentes configurados
                </div>
            @else
                @foreach ($recurrentes as $m)
                    <div class="er-row">
                        <div class="er-row-left">
                            <div class="er-dot"
                                style="background:{{ $m->tipo_movimiento === 'ingreso' ? '#22c55e' : '#ef4444' }};">
                            </div>
                            <div>
                                <div class="er-row-name">{{ $m->descripcion ?? ($m->categoria?->nombre ?? '—') }}</div>
                                <div class="er-row-sub">
                                    {{ $m->cuenta?->nombre }}
                                    <span class="er-sep">·</span>
                                    {{ ucfirst($m->frecuencia_recurrencia) }}
                                    @if ($m->fecha_fin_recurrencia)
                                        <span class="er-sep">·</span>
                                        hasta {{ $m->fecha_fin_recurrencia->format('d/m/Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="er-row-right">
                            <div class="er-row-amount"
                                style="color:{{ $m->tipo_movimiento === 'ingreso' ? '#22c55e' : '#ef4444' }};">
                                {{ $m->tipo_movimiento === 'egreso' ? '-' : '+' }}S/ {{ number_format($m->monto, 2) }}
                            </div>
                            <div class="er-row-date">
                                Última: {{ $m->ultima_ejecucion?->format('d/m/Y') ?? 'Nunca' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</x-filament-panels::page>

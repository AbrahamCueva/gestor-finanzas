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

        .dw-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .dw-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .dw-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .dw-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        .dw-summary {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .dw-summary-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.625rem;
            border-radius: 99px;
            font-size: 0.68rem;
            font-weight: 600;
        }

        .dw-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        @media (max-width: 1024px) {
            .dw-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .dw-grid {
                grid-template-columns: 1fr;
            }
        }

        .dw-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .dw-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .dw-card-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--w-text);
        }

        .dw-card-person {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.15rem;
        }

        .dw-tipo-badge {
            padding: 0.2rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .dw-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .dw-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.7s ease;
        }

        .dw-amounts {
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
            color: var(--w-muted);
        }

        .dw-amount-paid {
            font-weight: 700;
            color: var(--w-text-soft);
        }

        .dw-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.68rem;
            color: var(--w-muted);
        }

        .dw-vencida {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            color: #ef4444;
            font-weight: 600;
        }

        .dw-vencida svg {
            width: 10px;
            height: 10px;
        }

        .dw-dias {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .dw-dias svg {
            width: 10px;
            height: 10px;
        }

        .dw-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 0;
            color: var(--w-muted);
            gap: 0.5rem;
            text-align: center;
        }

        .dw-empty svg {
            width: 30px;
            height: 30px;
            margin-bottom: 0.25rem;
        }

        .dw-empty-title {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .dw-empty-sub {
            font-size: 0.75rem;
            opacity: 0.7;
        }
    </style>

    <div class="dw-wrap">

        <div class="dw-header">
            <div>
                <div class="dw-title">Deudas y Préstamos</div>
                <div class="dw-sub">Seguimiento de lo que debes y te deben</div>
            </div>
            <div class="dw-summary">
                @if ($totalDebo > 0)
                    <span class="dw-summary-pill" style="background:rgba(239,68,68,0.12); color:#f87171;">
                        Debo S/ {{ number_format($totalDebo, 2) }}
                    </span>
                @endif
                @if ($totalMeDeben > 0)
                    <span class="dw-summary-pill" style="background:rgba(34,197,94,0.12); color:#4ade80;">
                        Me deben S/ {{ number_format($totalMeDeben, 2) }}
                    </span>
                @endif
                @if ($vencidas > 0)
                    <span class="dw-summary-pill" style="background:rgba(239,68,68,0.12); color:#f87171;">
                        ⚠ {{ $vencidas }} vencida{{ $vencidas > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>
        </div>

        @if ($deudas->isEmpty())
            <div class="dw-empty">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                <div class="dw-empty-title">Sin deudas pendientes</div>
                <div class="dw-empty-sub">Registra una deuda o préstamo para darle seguimiento</div>
            </div>
        @else
            <div class="dw-grid">
                @foreach ($deudas as $d)
                    @php
                        $pct = $d->porcentaje();
                        $dias = $d->diasRestantes();
                        $color = $d->color ?? '#fbbf24';
                        $esDebo = $d->tipo === 'debo';
                    @endphp
                    <div class="dw-card">

                        <div class="dw-card-top">
                            <div>
                                <div class="dw-card-name">{{ $d->nombre }}</div>
                                <div class="dw-card-person">{{ $d->acreedor_deudor }}</div>
                            </div>
                            <span class="dw-tipo-badge"
                                style="background:{{ $esDebo ? 'rgba(239,68,68,0.12)' : 'rgba(34,197,94,0.12)' }}; color:{{ $esDebo ? '#f87171' : '#4ade80' }};">
                                {{ $esDebo ? 'Debo' : 'Me deben' }}
                            </span>
                        </div>

                        <div>
                            <div class="dw-track">
                                <div class="dw-fill"
                                    style="width:{{ $pct }}%; background:{{ $color }};"></div>
                            </div>
                        </div>

                        <div class="dw-amounts">
                            <span class="dw-amount-paid">S/ {{ number_format($d->monto_pagado, 2) }} pagado</span>
                            <span>{{ $pct }}%</span>
                        </div>

                        <div class="dw-footer">
                            <span>Resta S/ {{ number_format($d->restante(), 2) }}</span>
                            @if ($d->estaVencida())
                                <span class="dw-vencida">
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                    Vencida
                                </span>
                            @elseif($dias !== null)
                                <span class="dw-dias">
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25" />
                                    </svg>
                                    {{ $dias }} días
                                </span>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-filament-widgets::widget>

<x-filament-widgets::widget>
    <style>
        :root {
            --w-bg: rgba(0, 0, 0, 0.04);
            --w-card: rgba(0, 0, 0, 0.05);
            --w-text: #111827;
            --w-muted: #6b7280;
            --w-border: rgba(0, 0, 0, 0.08);
        }

        .dark {
            --w-bg: rgba(255, 255, 255, 0.03);
            --w-card: rgba(255, 255, 255, 0.04);
            --w-text: #f9fafb;
            --w-muted: #6b7280;
            --w-border: rgba(255, 255, 255, 0.08);
        }

        .pb-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .pb-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .pb-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--w-text);
            margin-bottom: 0.15rem;
        }

        .pb-subtitle {
            font-size: 0.7rem;
            color: var(--w-muted);
        }

        .pb-badges {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .pb-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.625rem;
            border-radius: 99px;
            font-size: 0.68rem;
            font-weight: 600;
        }

        .pb-badge svg {
            width: 10px;
            height: 10px;
        }

        .pb-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        @media (max-width: 1024px) {
            .pb-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .pb-grid {
                grid-template-columns: 1fr;
            }
        }

        .pb-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
            transition: background 0.15s;
        }

        .pb-card:hover {
            filter: brightness(1.05);
        }

        .pb-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .pb-card-period {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .pb-card-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--w-text);
            line-height: 1.2;
        }

        .pb-card-dates {
            font-size: 0.65rem;
            color: var(--w-muted);
            text-align: right;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .pb-progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.4rem;
        }

        .pb-progress-consume {
            font-size: 0.68rem;
            color: var(--w-muted);
        }

        .pb-progress-pct {
            font-size: 0.8rem;
            font-weight: 700;
        }

        .pb-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .pb-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.7s ease;
        }

        .pb-metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
        }

        .pb-metric-label {
            font-size: 0.63rem;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .pb-metric-value {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .pb-alert {
            font-size: 0.68rem;
            padding: 0.375rem 0.625rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .pb-alert svg {
            width: 11px;
            height: 11px;
            flex-shrink: 0;
        }

        .pb-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 0;
            color: var(--w-muted);
            gap: 0.5rem;
            text-align: center;
        }

        .pb-empty svg {
            width: 32px;
            height: 32px;
            margin-bottom: 0.25rem;
        }

        .pb-empty-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--w-muted);
        }

        .pb-empty-sub {
            font-size: 0.75rem;
            color: var(--w-muted);
            opacity: 0.6;
        }
    </style>

    <div class="pb-wrap">

        <div class="pb-header">
            <div>
                <div class="pb-title">Presupuestos</div>
                <div class="pb-subtitle">Control de gastos activos</div>
            </div>
            <div class="pb-badges">
                @if ($superados > 0)
                    <span class="pb-badge" style="background:rgba(239,68,68,0.12); color:#f87171;">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $superados }} crítico{{ $superados > 1 ? 's' : '' }}
                    </span>
                @endif
                @if ($en_alerta > 0)
                    <span class="pb-badge" style="background:rgba(245,158,11,0.12); color:#fbbf24;">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $en_alerta }} en alerta
                    </span>
                @endif
                @if ($superados === 0 && $en_alerta === 0 && $total > 0)
                    <span class="pb-badge" style="background:rgba(34,197,94,0.12); color:#4ade80;">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                        Todo saludable
                    </span>
                @endif
            </div>
        </div>

        @if ($total === 0)
            <div class="pb-empty">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
                <div class="pb-empty-title">No hay presupuestos activos</div>
                <div class="pb-empty-sub">Crea uno para comenzar a controlar tus gastos</div>
            </div>
        @else
            <div class="pb-grid">
                @foreach ($presupuestos as $p)
                    @php
                        $bc = $p['color'] === 'red' ? '#ef4444' : ($p['color'] === 'yellow' ? '#f59e0b' : '#22c55e');
                    @endphp
                    <div class="pb-card">
                        <div class="pb-card-header">
                            <div>
                                <div class="pb-card-period">{{ $p['periodo'] }}</div>
                                <div class="pb-card-name">{{ $p['nombre'] }}</div>
                            </div>
                            <div class="pb-card-dates">{{ $p['fecha_inicio'] }}<br>{{ $p['fecha_fin'] }}</div>
                        </div>

                        <div>
                            <div class="pb-progress-header">
                                <span class="pb-progress-consume">Consumo</span>
                                <span class="pb-progress-pct" style="color:{{ $bc }};">
                                    {{ min($p['porcentaje'], 100) }}%
                                </span>
                            </div>
                            <div class="pb-track">
                                <div class="pb-fill"
                                    style="width:{{ min($p['porcentaje'], 100) }}%; background:{{ $bc }};">
                                </div>
                            </div>
                        </div>

                        <div class="pb-metrics">
                            <div>
                                <div class="pb-metric-label">Gastado</div>
                                <div class="pb-metric-value">S/ {{ number_format($p['gasto'], 2) }}</div>
                            </div>
                            <div>
                                <div class="pb-metric-label">Límite</div>
                                <div class="pb-metric-value">S/ {{ number_format($p['limite'], 2) }}</div>
                            </div>
                            <div>
                                <div class="pb-metric-label">Disponible</div>
                                <div class="pb-metric-value"
                                    style="color:{{ $p['disponible'] < 0 ? '#ef4444' : '#22c55e' }};">
                                    {{ $p['disponible'] < 0 ? '-' : '' }}S/
                                    {{ number_format(abs($p['disponible']), 2) }}
                                </div>
                            </div>
                        </div>

                        @if ($p['superado'])
                            <div class="pb-alert" style="background:rgba(239,68,68,0.08); color:#f87171;">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                Has superado el límite
                            </div>
                        @elseif($p['alerta'])
                            <div class="pb-alert" style="background:rgba(245,158,11,0.08); color:#fbbf24;">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                Estás cerca del límite
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-filament-widgets::widget>

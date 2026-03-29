<x-filament-panels::page>

    @php $datos = $this->getDatos(); @endphp

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

        .rmd-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .rmd-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .rmd-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rmd-section-title svg {
            width: 13px;
            height: 13px;
        }

        .rmd-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        @media(max-width:768px) {
            .rmd-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .rmd-kpi {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
        }

        .rmd-kpi-icon {
            font-size: 1.1rem;
            margin-bottom: 0.375rem;
        }

        .rmd-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .rmd-kpi-value {
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .rmd-kpi-sub {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-top: 0.2rem;
        }

        .rmd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rmd-table th {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .rmd-table td {
            font-size: 0.8rem;
            padding: 0.6rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
        }

        .rmd-table tr:last-child td {
            border-bottom: none;
        }

        .rmd-table tr:hover td {
            background: var(--w-card);
        }

        .rmd-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
            width: 80px;
        }

        .rmd-fill {
            height: 100%;
            border-radius: 99px;
        }

        .rmd-badge {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }
    </style>

    <div class="rmd-wrap">

        <div class="rmd-card">
            <div class="rmd-kpis">
                <div class="rmd-kpi">
                    <div class="rmd-kpi-label">Metas activas</div>
                    <div class="rmd-kpi-value" style="color:#60a5fa;">
                        {{ $datos['metas']->where('completada', false)->count() }}</div>
                    <div class="rmd-kpi-sub">{{ $datos['metasCompletas'] }} completadas</div>
                </div>
                <div class="rmd-kpi">
                    <div class="rmd-kpi-label">Falta ahorrar</div>
                    <div class="rmd-kpi-value" style="color:#fbbf24;">S/ {{ number_format($datos['totalMetas'], 2) }}
                    </div>
                    <div class="rmd-kpi-sub">en metas activas</div>
                </div>
                <div class="rmd-kpi">
                    <div class="rmd-kpi-label">Total que debo</div>
                    <div class="rmd-kpi-value" style="color:#ef4444;">S/ {{ number_format($datos['totalDebo'], 2) }}
                    </div>
                    <div class="rmd-kpi-sub">pendiente de pago</div>
                </div>
                <div class="rmd-kpi">
                    <div class="rmd-kpi-label">Total que me deben</div>
                    <div class="rmd-kpi-value" style="color:#22c55e;">S/ {{ number_format($datos['totalMeDeben'], 2) }}
                    </div>
                    <div class="rmd-kpi-sub">pendiente de cobro</div>
                </div>
            </div>
        </div>

        <div class="rmd-card">
            <div class="rmd-section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497" />
                </svg>
                Metas de Ahorro
            </div>
            <table class="rmd-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ahorrado</th>
                        <th>Objetivo</th>
                        <th>Progreso</th>
                        <th>Falta</th>
                        <th>Fecha límite</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos['metas'] as $m)
                        @php
                            $pct = $m->porcentaje();
                            $color = $pct >= 100 ? '#22c55e' : ($pct >= 50 ? '#fbbf24' : '#60a5fa');
                        @endphp
                        <tr>
                            <td style="font-weight:600; color:var(--w-text);">{{ $m->nombre }}</td>
                            <td style="color:#22c55e; font-weight:600;">S/ {{ number_format($m->monto_actual, 2) }}</td>
                            <td>S/ {{ number_format($m->monto_objetivo, 2) }}</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    <div class="rmd-track">
                                        <div class="rmd-fill"
                                            style="width:{{ min(100, $pct) }}%; background:{{ $color }};"></div>
                                    </div>
                                    <span
                                        style="font-size:0.72rem; font-weight:700; color:{{ $color }};">{{ $pct }}%</span>
                                </div>
                            </td>
                            <td style="color:var(--w-muted);">S/ {{ number_format($m->restante(), 2) }}</td>
                            <td style="color:var(--w-muted);">{{ $m->fecha_limite?->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                @if ($m->completada)
                                    <span class="rmd-badge" style="background:rgba(34,197,94,0.12); color:#22c55e;">✅
                                        Completada</span>
                                @else
                                    <span class="rmd-badge" style="background:rgba(96,165,250,0.12); color:#60a5fa;">En
                                        progreso</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="rmd-card">
            <div class="rmd-section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                Deudas y Préstamos
            </div>
            <table class="rmd-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Persona/Entidad</th>
                        <th>Total</th>
                        <th>Pagado</th>
                        <th>Restante</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos['deudas'] as $d)
                        <tr>
                            <td style="font-weight:600; color:var(--w-text);">{{ $d->nombre }}</td>
                            <td>
                                <span class="rmd-badge"
                                    style="background:{{ $d->tipo === 'debo' ? 'rgba(239,68,68,0.12)' : 'rgba(34,197,94,0.12)' }}; color:{{ $d->tipo === 'debo' ? '#ef4444' : '#22c55e' }};">
                                    {{ $d->tipo === 'debo' ? 'Debo' : 'Me deben' }}
                                </span>
                            </td>
                            <td style="color:var(--w-muted);">{{ $d->acreedor_deudor }}</td>
                            <td>S/ {{ number_format($d->monto_total, 2) }}</td>
                            <td style="color:#22c55e; font-weight:600;">S/ {{ number_format($d->monto_pagado, 2) }}
                            </td>
                            <td style="color:#ef4444; font-weight:600;">S/ {{ number_format($d->restante(), 2) }}</td>
                            <td style="color:{{ $d->estaVencida() ? '#ef4444' : 'var(--w-muted)' }};">
                                {{ $d->fecha_vencimiento?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td>
                                @if ($d->estado === 'pagada')
                                    <span class="rmd-badge"
                                        style="background:rgba(34,197,94,0.12); color:#22c55e;">Pagada</span>
                                @elseif($d->estado === 'vencida' || $d->estaVencida())
                                    <span class="rmd-badge"
                                        style="background:rgba(239,68,68,0.12); color:#ef4444;">Vencida</span>
                                @else
                                    <span class="rmd-badge"
                                        style="background:rgba(251,191,36,0.12); color:#fbbf24;">Pendiente</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</x-filament-panels::page>

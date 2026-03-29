<x-filament-panels::page>
    @php
        $datos = $this->getDatos();
        $p1 = $datos['p1'];
        $p2 = $datos['p2'];
        $diff = $datos['diff'];
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

        .cp-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .cp-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .cp-section-title {
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

        /* Selectores de fechas */
        .cp-periodos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media(max-width:768px) {
            .cp-periodos {
                grid-template-columns: 1fr;
            }
        }

        .cp-periodo-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
        }

        .cp-periodo-label {
            font-size: 0.72rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cp-periodo-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .cp-fecha-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .cp-field label {
            display: block;
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--w-muted);
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .cp-field input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid var(--w-border);
            background: var(--w-bg);
            color: var(--w-text);
            font-size: 0.8rem;
            outline: none;
            transition: border-color 0.15s;
        }

        .cp-field input:focus {
            border-color: #fbbf24;
        }

        /* Comparativa grid */
        .cp-comp-grid {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 1rem;
            align-items: start;
        }

        @media(max-width:768px) {
            .cp-comp-grid {
                grid-template-columns: 1fr;
            }
        }

        .cp-col-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--w-text);
            margin-bottom: 0.875rem;
            padding-bottom: 0.625rem;
            border-bottom: 2px solid var(--w-border);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cp-col-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .cp-stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--w-border);
        }

        .cp-stat-row:last-child {
            border-bottom: none;
        }

        .cp-stat-label {
            font-size: 0.75rem;
            color: var(--w-muted);
        }

        .cp-stat-value {
            font-size: 0.875rem;
            font-weight: 700;
        }

        /* Flecha central */
        .cp-center {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            align-items: center;
            padding-top: 2.5rem;
        }

        .cp-diff-pill {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.2rem;
            padding: 0.4rem 0.625rem;
            border-radius: 0.5rem;
            font-size: 0.68rem;
            font-weight: 700;
            min-width: 64px;
            text-align: center;
        }

        .cp-diff-label {
            font-size: 0.58rem;
            font-weight: 500;
            opacity: 0.75;
        }

        .cp-vs {
            font-size: 0.65rem;
            font-weight: 800;
            color: var(--w-muted);
            letter-spacing: 0.1em;
            padding: 0.25rem 0;
        }

        /* Categorías */
        .cp-cat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media(max-width:768px) {
            .cp-cat-grid {
                grid-template-columns: 1fr;
            }
        }

        .cp-cat-col {}

        .cp-cat-title {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--w-muted);
            margin-bottom: 0.625rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .cp-cat-row {
            margin-bottom: 0.625rem;
        }

        .cp-cat-row:last-child {
            margin-bottom: 0;
        }

        .cp-cat-label-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--w-text-soft);
            margin-bottom: 0.25rem;
        }

        .cp-cat-amount {
            font-weight: 600;
        }

        .cp-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .cp-fill {
            height: 100%;
            border-radius: 99px;
        }

        .cp-empty {
            font-size: 0.75rem;
            color: var(--w-muted);
            font-style: italic;
            padding: 0.5rem 0;
        }
    </style>

    <div class="cp-wrap">

        <div class="cp-card">
            <div class="cp-section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    style="width:13px;height:13px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25" />
                </svg>
                Selecciona los períodos a comparar
            </div>

            <div class="cp-periodos">
                <div class="cp-periodo-card" style="border-left: 3px solid #a78bfa;">
                    <div class="cp-periodo-label" style="color:#a78bfa;">
                        <div class="cp-periodo-dot" style="background:#a78bfa;"></div>
                        Período 1
                    </div>
                    <div class="cp-fecha-row">
                        <div class="cp-field">
                            <label>Desde</label>
                            <input type="date" wire:model.live="periodo1_desde" value="{{ $periodo1_desde }}">
                        </div>
                        <div class="cp-field">
                            <label>Hasta</label>
                            <input type="date" wire:model.live="periodo1_hasta" value="{{ $periodo1_hasta }}">
                        </div>
                    </div>
                </div>

                <div class="cp-periodo-card" style="border-left: 3px solid #fbbf24;">
                    <div class="cp-periodo-label" style="color:#fbbf24;">
                        <div class="cp-periodo-dot" style="background:#fbbf24;"></div>
                        Período 2
                    </div>
                    <div class="cp-fecha-row">
                        <div class="cp-field">
                            <label>Desde</label>
                            <input type="date" wire:model.live="periodo2_desde" value="{{ $periodo2_desde }}">
                        </div>
                        <div class="cp-field">
                            <label>Hasta</label>
                            <input type="date" wire:model.live="periodo2_hasta" value="{{ $periodo2_hasta }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cp-card">
            <div class="cp-section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    style="width:13px;height:13px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
                Resumen comparativo
            </div>

            <div class="cp-comp-grid">

                <div>
                    <div class="cp-col-title">
                        <div class="cp-col-dot" style="background:#a78bfa;"></div>
                        <span style="color:#a78bfa;">Período 1</span>
                        <span
                            style="font-size:0.65rem; color:var(--w-muted); font-weight:400;">{{ $p1['label'] }}</span>
                    </div>

                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Ingresos</span>
                        <span class="cp-stat-value" style="color:#22c55e;">S/
                            {{ number_format($p1['ingresos'], 2) }}</span>
                    </div>
                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Egresos</span>
                        <span class="cp-stat-value" style="color:#ef4444;">S/
                            {{ number_format($p1['egresos'], 2) }}</span>
                    </div>
                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Ahorro neto</span>
                        <span class="cp-stat-value" style="color:{{ $p1['ahorro'] >= 0 ? '#60a5fa' : '#fb923c' }};">S/
                            {{ number_format($p1['ahorro'], 2) }}</span>
                    </div>
                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Días del período</span>
                        <span class="cp-stat-value" style="color:var(--w-text);">{{ $p1['dias'] }}</span>
                    </div>
                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Gasto promedio/día</span>
                        <span class="cp-stat-value" style="color:#ef4444;">S/
                            {{ number_format($p1['promDiario'], 2) }}</span>
                    </div>
                </div>

                <div class="cp-center">
                    <div class="cp-vs">VS</div>

                    @php
                        $items = [
                            ['label' => 'Ingresos', 'diff' => $diff['ingresos'], 'bueno_sube' => true],
                            ['label' => 'Egresos', 'diff' => $diff['egresos'], 'bueno_sube' => false],
                            ['label' => 'Ahorro', 'diff' => $diff['ahorro'], 'bueno_sube' => true],
                        ];
                    @endphp

                    @foreach ($items as $item)
                        @php
                            $d = $item['diff'];
                            $esBueno = $item['bueno_sube'] ? $d['sube'] : !$d['sube'];
                            $color = $esBueno ? '#22c55e' : '#ef4444';
                            $bg = $esBueno ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)';
                            $flecha = $d['sube'] ? '↑' : '↓';
                        @endphp
                        <div class="cp-diff-pill" style="background:{{ $bg }}; color:{{ $color }};">
                            <span>{{ $flecha }} {{ abs($d['valor']) }}%</span>
                            <span class="cp-diff-label">{{ $item['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                <div>
                    <div class="cp-col-title">
                        <div class="cp-col-dot" style="background:#fbbf24;"></div>
                        <span style="color:#fbbf24;">Período 2</span>
                        <span
                            style="font-size:0.65rem; color:var(--w-muted); font-weight:400;">{{ $p2['label'] }}</span>
                    </div>

                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Ingresos</span>
                        <span class="cp-stat-value" style="color:#22c55e;">S/
                            {{ number_format($p2['ingresos'], 2) }}</span>
                    </div>
                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Egresos</span>
                        <span class="cp-stat-value" style="color:#ef4444;">S/
                            {{ number_format($p2['egresos'], 2) }}</span>
                    </div>
                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Ahorro neto</span>
                        <span class="cp-stat-value" style="color:{{ $p2['ahorro'] >= 0 ? '#60a5fa' : '#fb923c' }};">S/
                            {{ number_format($p2['ahorro'], 2) }}</span>
                    </div>
                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Días del período</span>
                        <span class="cp-stat-value" style="color:var(--w-text);">{{ $p2['dias'] }}</span>
                    </div>
                    <div class="cp-stat-row">
                        <span class="cp-stat-label">Gasto promedio/día</span>
                        <span class="cp-stat-value" style="color:#ef4444;">S/
                            {{ number_format($p2['promDiario'], 2) }}</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="cp-card">
            <div class="cp-section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    style="width:13px;height:13px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                </svg>
                Top categorías de gasto
            </div>

            <div class="cp-cat-grid">

                <div class="cp-cat-col">
                    <div class="cp-cat-title" style="color:#a78bfa;">
                        <div class="cp-periodo-dot" style="background:#a78bfa;"></div>
                        Período 1
                    </div>
                    @php $maxP1 = $p1['categorias']->max('total') ?: 1; @endphp
                    @forelse($p1['categorias'] as $cat)
                        <div class="cp-cat-row">
                            <div class="cp-cat-label-row">
                                <span>{{ $cat->nombre }}</span>
                                <span class="cp-cat-amount">S/ {{ number_format($cat->total, 2) }}</span>
                            </div>
                            <div class="cp-track">
                                <div class="cp-fill"
                                    style="width:{{ round(($cat->total / $maxP1) * 100) }}%; background:#a78bfa;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="cp-empty">Sin egresos en este período</div>
                    @endforelse
                </div>

                <div class="cp-cat-col">
                    <div class="cp-cat-title" style="color:#fbbf24;">
                        <div class="cp-periodo-dot" style="background:#fbbf24;"></div>
                        Período 2
                    </div>
                    @php $maxP2 = $p2['categorias']->max('total') ?: 1; @endphp
                    @forelse($p2['categorias'] as $cat)
                        <div class="cp-cat-row">
                            <div class="cp-cat-label-row">
                                <span>{{ $cat->nombre }}</span>
                                <span class="cp-cat-amount">S/ {{ number_format($cat->total, 2) }}</span>
                            </div>
                            <div class="cp-track">
                                <div class="cp-fill"
                                    style="width:{{ round(($cat->total / $maxP2) * 100) }}%; background:#fbbf24;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="cp-empty">Sin egresos en este período</div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
</x-filament-panels::page>

<x-filament-panels::page>
    @php $d = $this->getDatos(); @endphp

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

        .ac-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ac-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ac-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* Patrones */
        .ac-patrones {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:640px) {
            .ac-patrones {
                grid-template-columns: 1fr;
            }
        }

        .ac-patron {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            border-left: 3px solid;
        }

        .ac-patron.success {
            border-color: #22c55e;
        }

        .ac-patron.warning {
            border-color: #fbbf24;
        }

        .ac-patron.danger {
            border-color: #ef4444;
        }

        .ac-patron.info {
            border-color: #60a5fa;
        }

        .ac-patron-emoji {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .ac-patron-titulo {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ac-patron-desc {
            font-size: 0.72rem;
            color: var(--w-muted);
            margin-top: 0.15rem;
            line-height: 1.4;
        }

        /* Días semana */
        .ac-dias {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.375rem;
        }

        .ac-dia-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }

        .ac-dia-bar-wrap {
            width: 100%;
            background: var(--w-border);
            border-radius: 3px;
            overflow: hidden;
            height: 80px;
            display: flex;
            align-items: flex-end;
        }

        .ac-dia-bar {
            width: 100%;
            border-radius: 3px 3px 0 0;
        }

        .ac-dia-nombre {
            font-size: 0.62rem;
            color: var(--w-muted);
        }

        .ac-dia-monto {
            font-size: 0.65rem;
            font-weight: 700;
            color: #ef4444;
        }

        .ac-dia-conteo {
            font-size: 0.58rem;
            color: var(--w-muted);
        }

        /* Meses */
        .ac-meses {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 0.375rem;
        }

        @media(max-width:768px) {
            .ac-meses {
                grid-template-columns: repeat(6, 1fr);
            }
        }

        .ac-mes-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }

        .ac-mes-bars {
            width: 100%;
            display: flex;
            gap: 1px;
            height: 70px;
            align-items: flex-end;
        }

        .ac-mes-bar {
            flex: 1;
            border-radius: 2px 2px 0 0;
        }

        .ac-mes-nombre {
            font-size: 0.6rem;
            color: var(--w-muted);
        }

        /* Trimestres */
        .ac-trimestres {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:640px) {
            .ac-trimestres {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .ac-trim-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem;
            text-align: center;
        }

        .ac-trim-emoji {
            font-size: 1.5rem;
            margin-bottom: 0.375rem;
        }

        .ac-trim-nombre {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ac-trim-meses {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-bottom: 0.625rem;
        }

        .ac-trim-egreso {
            font-size: 0.825rem;
            font-weight: 700;
            color: #ef4444;
        }

        .ac-trim-ingreso {
            font-size: 0.825rem;
            font-weight: 700;
            color: #22c55e;
        }

        .ac-trim-ahorro {
            font-size: 0.72rem;
            margin-top: 0.25rem;
        }

        /* Horas */
        .ac-horas {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 60px;
            overflow-x: auto;
        }

        .ac-hora-bar {
            flex-shrink: 0;
            width: 20px;
            border-radius: 2px 2px 0 0;
            min-height: 2px;
        }

        .ac-horas-labels {
            display: flex;
            gap: 2px;
            margin-top: 4px;
        }

        .ac-hora-label {
            flex-shrink: 0;
            width: 20px;
            font-size: 0.55rem;
            color: var(--w-muted);
            text-align: center;
        }

        .ac-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem;
        }

        @media(max-width:640px) {
            .ac-grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="ac-wrap">

        @if (count($d['patrones']) > 0)
            <div class="ac-card">
                <div class="ac-title">🔍 Patrones detectados</div>
                <div class="ac-patrones">
                    @foreach ($d['patrones'] as $p)
                        <div class="ac-patron {{ $p['tipo'] }}">
                            <span class="ac-patron-emoji">{{ $p['emoji'] }}</span>
                            <div>
                                <div class="ac-patron-titulo">{{ $p['titulo'] }}</div>
                                <div class="ac-patron-desc">{{ $p['desc'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="ac-card">
            <div class="ac-title">📅 Gasto promedio por día de la semana (últimos 12 meses)</div>
            @php $maxDia = max(array_column($d['porDiaSemana'], 'totalEgreso')) ?: 1; @endphp
            <div class="ac-dias">
                @foreach ($d['porDiaSemana'] as $dia)
                    @php
                        $altura = round(($dia['totalEgreso'] / $maxDia) * 100);
                        $esMayor = $dia['totalEgreso'] === max(array_column($d['porDiaSemana'], 'totalEgreso'));
                    @endphp
                    <div class="ac-dia-item">
                        <div class="ac-dia-bar-wrap">
                            <div class="ac-dia-bar" style="height:{{ max(2, $altura) }}%;
                                background:{{ $esMayor ? '#ef4444' : '#ef444466' }};">
                            </div>
                        </div>
                        <div class="ac-dia-nombre" style="{{ $esMayor ? 'color:#ef4444; font-weight:700;' : '' }}">
                            {{ $dia['diaCorto'] }}
                        </div>
                        <div class="ac-dia-monto">{{ number_format($dia['totalEgreso'], 0) }}</div>
                        <div class="ac-dia-conteo">{{ $dia['conteo'] }} movs.</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="ac-grid-2">
            <div class="ac-card">
                <div class="ac-title">📊 Promedio mensual histórico</div>
                @php
                    $maxEgr = max(array_column($d['porMesAnio'], 'totalEgreso')) ?: 1;
                    $maxIng = max(array_column($d['porMesAnio'], 'totalIngreso')) ?: 1;
                    $maxVal = max($maxEgr, $maxIng);
                @endphp
                <div class="ac-meses">
                    @foreach ($d['porMesAnio'] as $mes)
                        @php
                            $altEgr = round(($mes['totalEgreso'] / $maxVal) * 100);
                            $altIng = round(($mes['totalIngreso'] / $maxVal) * 100);
                        @endphp
                        <div class="ac-mes-item">
                            <div class="ac-mes-bars">
                                <div class="ac-mes-bar" style="height:{{ max(2, $altIng) }}%; background:#22c55e88;">
                                </div>
                                <div class="ac-mes-bar" style="height:{{ max(2, $altEgr) }}%; background:#ef444488;">
                                </div>
                            </div>
                            <div class="ac-mes-nombre">{{ $mes['mes'] }}</div>
                        </div>
                    @endforeach
                </div>
                <div style="display:flex; gap:0.75rem; margin-top:0.5rem; font-size:0.65rem; color:var(--w-muted);">
                    <span style="display:flex; align-items:center; gap:0.25rem;">
                        <span
                            style="width:8px; height:8px; border-radius:2px; background:#22c55e; display:inline-block;"></span>
                        Ingresos
                    </span>
                    <span style="display:flex; align-items:center; gap:0.25rem;">
                        <span
                            style="width:8px; height:8px; border-radius:2px; background:#ef4444; display:inline-block;"></span>
                        Egresos
                    </span>
                </div>
            </div>

            <div class="ac-card">
                <div class="ac-title">🌍 Estacionalidad por trimestre</div>
                <div class="ac-trimestres">
                    @foreach ($d['estacionalidad'] as $t)
                        <div class="ac-trim-card">
                            <div class="ac-trim-emoji">{{ $t['emoji'] }}</div>
                            <div class="ac-trim-nombre">{{ $t['nombre'] }}</div>
                            <div class="ac-trim-meses">{{ $t['meses'] }}</div>
                            <div class="ac-trim-egreso">-S/ {{ number_format($t['totalEgreso'], 0) }}</div>
                            <div class="ac-trim-ingreso">+S/ {{ number_format($t['totalIngreso'], 0) }}</div>
                            <div class="ac-trim-ahorro" style="color:{{ $t['ahorro'] >= 0 ? '#60a5fa' : '#f97316' }};">
                                {{ $t['ahorro'] >= 0 ? '✓' : '⚠' }} S/ {{ number_format($t['ahorro'], 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="ac-card">
            <div class="ac-title">🕐 Registros por hora del día (últimos 6 meses)</div>
            @php $maxHora = max(array_column($d['porHora'], 'conteo')) ?: 1; @endphp

            <div style="display:flex; align-items: flex-end; gap: 3px; height: 120px; padding-top: 8px;">
                @foreach ($d['porHora'] as $hora)
                        @php
                            $altura = round(($hora['conteo'] / $maxHora) * 100);
                            $esPico = $hora['conteo'] === max(array_column($d['porHora'], 'conteo'));
                        @endphp
                        <div style="
                        flex: 1;
                        height: {{ max(2, $altura) }}%;
                        border-radius: 3px 3px 0 0;
                        background: {{ $esPico ? '#6366f1' : '#6366f144' }};
                        min-width: 0;
                        transition: background .15s;
                        cursor: default;
                        position: relative;
                    " title="{{ $hora['label'] }}: {{ $hora['conteo'] }} registros"></div>
                @endforeach
            </div>

            {{-- Labels --}}
            <div style="display:flex; gap: 3px; margin-top: 4px;">
                @foreach ($d['porHora'] as $hora)
                        <div style="
                        flex: 1;
                        font-size: 0.55rem;
                        color: var(--w-muted);
                        text-align: center;
                        min-width: 0;
                    ">{{ $hora['hora'] % 6 === 0 ? $hora['label'] : '' }}</div>
                @endforeach
            </div>

            <div style="font-size:0.68rem; color:var(--w-muted); margin-top:0.5rem;">
                Hora en que más registros creas — útil para saber cuándo eres más activo en la app.
            </div>
        </div>

    </div>
</x-filament-panels::page>
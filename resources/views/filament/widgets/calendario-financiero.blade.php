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

        .cf-wrap {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .cf-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .cf-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .cf-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        .cf-nav {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cf-nav-btn {
            width: 1.875rem;
            height: 1.875rem;
            border-radius: 0.5rem;
            background: var(--w-card);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--w-muted);
            transition: background 0.15s, color 0.15s;
        }

        .cf-nav-btn:hover {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .cf-nav-btn svg {
            width: 13px;
            height: 13px;
        }

        .cf-mes-label {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--w-text);
            min-width: 130px;
            text-align: center;
        }

        /* Leyenda */
        .cf-leyenda {
            display: flex;
            gap: 0.875rem;
            margin-bottom: 0.875rem;
            flex-wrap: wrap;
        }

        .cf-ley-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.68rem;
            color: var(--w-muted);
        }

        .cf-ley-dot {
            width: 8px;
            height: 8px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        /* Header semana */
        .cf-semana-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px;
            margin-bottom: 3px;
        }

        .cf-semana-dia-nombre {
            text-align: center;
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.2rem 0;
        }

        /* Grid días */
        .cf-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px;
        }

        .cf-dia {
            border-radius: 0.5rem;
            background: var(--w-card);
            padding: 5px 5px 4px;
            display: flex;
            flex-direction: column;
            gap: 3px;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            border: 1.5px solid transparent;
            min-height: 44px;
        }

        .cf-dia:hover {
            background: rgba(251, 191, 36, 0.08);
            transform: scale(1.04);
        }

        /* Hoy — fondo amarillo suave + borde amarillo */
        .cf-dia.cf-hoy {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.1);
        }

        /* Seleccionado — borde azul */
        .cf-dia.cf-seleccionado {
            border-color: #60a5fa;
            background: rgba(96, 165, 250, 0.08);
        }

        /* Con movimientos — borde sutil */
        .cf-dia.cf-tiene-movs:not(.cf-hoy):not(.cf-seleccionado) {
            border-color: var(--w-border);
            background: var(--w-card);
        }

        /* Sin movimientos — más apagado */
        .cf-dia.cf-sin-movs:not(.cf-hoy) {
            background: transparent;
            opacity: 0.45;
        }

        .cf-dia.cf-vacio {
            background: transparent;
            cursor: default;
            pointer-events: none;
            border: none;
            opacity: 1;
        }

        .cf-dia-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cf-dia-num {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--w-text-soft);
            line-height: 1;
        }

        .cf-dia.cf-hoy .cf-dia-num {
            color: #fbbf24;
            font-weight: 800;
        }

        .cf-dia-count {
            font-size: 0.55rem;
            font-weight: 700;
            color: var(--w-muted);
            background: var(--w-bg);
            border-radius: 99px;
            padding: 0 3px;
            line-height: 1.5;
        }

        .cf-dia.cf-hoy .cf-dia-count {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
        }

        /* Barras de color — más visibles que puntos */
        .cf-bars {
            display: flex;
            gap: 2px;
        }

        .cf-bar {
            height: 4px;
            border-radius: 99px;
            flex: 1;
            min-width: 4px;
        }

        /* Detalle */
        .cf-detalle {
            margin-top: 0.875rem;
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            animation: cfFade 0.18s ease;
        }

        @keyframes cfFade {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cf-detalle-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            padding-bottom: 0.625rem;
            border-bottom: 1px solid var(--w-border);
        }

        .cf-detalle-fecha {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .cf-detalle-sub {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 2px;
        }

        .cf-detalle-close {
            width: 1.625rem;
            height: 1.625rem;
            border-radius: 0.375rem;
            background: var(--w-bg);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--w-muted);
        }

        .cf-detalle-close svg {
            width: 11px;
            height: 11px;
        }

        /* Resumen del día */
        .cf-resumen {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }

        .cf-resumen-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.2rem 0.625rem;
            border-radius: 99px;
            font-size: 0.68rem;
            font-weight: 700;
        }

        /* Lista movimientos */
        .cf-seccion-label {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--w-muted);
            margin: 0.625rem 0 0.375rem;
        }

        .cf-seccion-label:first-child {
            margin-top: 0;
        }

        .cf-mov-list {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .cf-mov-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.625rem;
            background: var(--w-bg);
            border-radius: 0.5rem;
            gap: 0.5rem;
        }

        .cf-mov-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 0;
        }

        .cf-mov-icon {
            width: 1.625rem;
            height: 1.625rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cf-mov-icon svg {
            width: 11px;
            height: 11px;
        }

        .cf-mov-nombre {
            font-size: 0.775rem;
            font-weight: 500;
            color: var(--w-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cf-mov-meta {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-top: 1px;
        }

        .cf-mov-right {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            flex-shrink: 0;
        }

        .cf-mov-badge {
            font-size: 0.58rem;
            font-weight: 700;
            padding: 0.12rem 0.4rem;
            border-radius: 99px;
        }

        .cf-mov-monto {
            font-size: 0.825rem;
            font-weight: 700;
        }

        .cf-detalle-empty {
            text-align: center;
            padding: 1.25rem 0;
            font-size: 0.8rem;
            color: var(--w-muted);
        }
    </style>

    <div class="cf-wrap">

        <div class="cf-header">
            <div>
                <div class="cf-title">Calendario Financiero</div>
                <div class="cf-sub">Movimientos del mes por día</div>
            </div>
            <div class="cf-nav">
                <button class="cf-nav-btn" wire:click="mesAnterior">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <span class="cf-mes-label">{{ $mesNombre }}</span>
                <button class="cf-nav-btn" wire:click="mesSiguiente">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="cf-leyenda">
            <div class="cf-ley-item">
                <div class="cf-ley-dot" style="background:#22c55e;"></div> Ingresos
            </div>
            <div class="cf-ley-item">
                <div class="cf-ley-dot" style="background:#ef4444;"></div> Egresos
            </div>
            <div class="cf-ley-item">
                <div class="cf-ley-dot" style="background:#60a5fa;"></div> Transferencias
            </div>
            <div class="cf-ley-item">
                <div class="cf-ley-dot" style="background:#fbbf24;"></div> Recurrentes
            </div>
            <div class="cf-ley-item">
                <div class="cf-ley-dot" style="background:var(--w-border); opacity:0.4;"></div> Sin movimientos
            </div>
        </div>

        <div class="cf-semana-header">
            @foreach (['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $n)
                <div class="cf-semana-dia-nombre">{{ $n }}</div>
            @endforeach
        </div>

        <div class="cf-grid">
            @for ($i = 0; $i < $offsetInicio; $i++)
                <div class="cf-dia cf-vacio"></div>
            @endfor

            @foreach ($dias as $d => $info)
                @php $tieneMovs = $info['total_movs'] > 0; @endphp
                <div class="cf-dia {{ $info['es_hoy'] ? 'cf-hoy' : '' }} {{ $diaSeleccionado === $info['key'] ? 'cf-seleccionado' : '' }} {{ $tieneMovs ? 'cf-tiene-movs' : 'cf-sin-movs' }}"
                    wire:click="seleccionarDia('{{ $info['key'] }}')">
                    <div class="cf-dia-top">
                        <span class="cf-dia-num">{{ $d }}</span>
                        @if ($tieneMovs)
                            <span class="cf-dia-count">{{ $info['total_movs'] }}</span>
                        @endif
                    </div>

                    @if ($tieneMovs)
                        <div class="cf-bars">
                            @if ($info['ingresos'] > 0)
                                <div class="cf-bar" style="background:#22c55e;"></div>
                            @endif
                            @if ($info['egresos'] > 0)
                                <div class="cf-bar" style="background:#ef4444;"></div>
                            @endif
                            @if ($info['transferencias'] > 0)
                                <div class="cf-bar" style="background:#60a5fa;"></div>
                            @endif
                            @if ($info['recurrentes'] > 0)
                                <div class="cf-bar" style="background:#fbbf24;"></div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($diaSeleccionado && $detalle)
            <div class="cf-detalle">
                <div class="cf-detalle-header">
                    <div>
                        <div class="cf-detalle-fecha">
                            {{ \Carbon\Carbon::parse($diaSeleccionado)->translatedFormat('l, d \d\e F') }}
                        </div>
                        <div class="cf-detalle-sub">
                            {{ $detalle['movimientos']->count() + $detalle['transferencias']->count() }} movimiento(s)
                        </div>
                    </div>
                    <button class="cf-detalle-close" wire:click="seleccionarDia('{{ $diaSeleccionado }}')">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @php
                    $totalIngDia = $detalle['movimientos']->where('tipo_movimiento', 'ingreso')->sum('monto');
                    $totalEgrDia = $detalle['movimientos']->where('tipo_movimiento', 'egreso')->sum('monto');
                    $totalTrDia = $detalle['transferencias']->sum('monto');
                @endphp
                <div class="cf-resumen">
                    @if ($totalIngDia > 0)
                        <span class="cf-resumen-pill" style="background:rgba(34,197,94,0.12); color:#22c55e;">
                            +S/ {{ number_format($totalIngDia, 2) }}
                        </span>
                    @endif
                    @if ($totalEgrDia > 0)
                        <span class="cf-resumen-pill" style="background:rgba(239,68,68,0.12); color:#ef4444;">
                            -S/ {{ number_format($totalEgrDia, 2) }}
                        </span>
                    @endif
                    @if ($totalTrDia > 0)
                        <span class="cf-resumen-pill" style="background:rgba(96,165,250,0.12); color:#60a5fa;">
                            ⇄ S/ {{ number_format($totalTrDia, 2) }}
                        </span>
                    @endif
                </div>

                @if ($detalle['movimientos']->isEmpty() && $detalle['transferencias']->isEmpty())
                    <div class="cf-detalle-empty">Sin movimientos este día</div>
                @else
                    <div class="cf-mov-list">

                        @if ($detalle['movimientos']->isNotEmpty())
                            <div class="cf-seccion-label">Movimientos</div>
                            @foreach ($detalle['movimientos'] as $m)
                                @php
                                    $esIng = $m->tipo_movimiento === 'ingreso';
                                    $clr = $esIng ? '#22c55e' : '#ef4444';
                                    $bg = $esIng ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)';
                                @endphp
                                <div class="cf-mov-item">
                                    <div class="cf-mov-left">
                                        <div class="cf-mov-icon" style="background:{{ $bg }};">
                                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                                stroke="{{ $clr }}">
                                                @if ($esIng)
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4.5v15m7.5-7.5h-15" />
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 12h-15" />
                                                @endif
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="cf-mov-nombre">
                                                {{ $m->descripcion ?: $m->categoria?->nombre ?? '—' }}</div>
                                            <div class="cf-mov-meta">
                                                {{ $m->cuenta?->nombre ?? '—' }}
                                                @if ($m->categoria)
                                                    · {{ $m->categoria->nombre }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cf-mov-right">
                                        @if ($m->es_recurrente)
                                            <span class="cf-mov-badge"
                                                style="background:rgba(251,191,36,0.12); color:#fbbf24;">🔄 rec</span>
                                        @endif
                                        <span class="cf-mov-monto" style="color:{{ $clr }};">
                                            {{ $esIng ? '+' : '-' }}S/ {{ number_format($m->monto, 2) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if ($detalle['transferencias']->isNotEmpty())
                            <div class="cf-seccion-label">Transferencias</div>
                            @foreach ($detalle['transferencias'] as $t)
                                <div class="cf-mov-item">
                                    <div class="cf-mov-left">
                                        <div class="cf-mov-icon" style="background:rgba(96,165,250,0.1);">
                                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="#60a5fa">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="cf-mov-nombre">{{ $t->descripcion ?: 'Transferencia' }}</div>
                                            <div class="cf-mov-meta">
                                                {{ $t->cuentaOrigen?->nombre ?? '—' }} →
                                                {{ $t->cuentaDestino?->nombre ?? '—' }}
                                            </div>
                                        </div>
                                    </div>
                                    <span class="cf-mov-monto" style="color:#60a5fa;">
                                        S/ {{ number_format($t->monto, 2) }}
                                    </span>
                                </div>
                            @endforeach
                        @endif

                    </div>
                @endif
            </div>
        @endif

    </div>
</x-filament-widgets::widget>

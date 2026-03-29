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

        .mc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .mc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .mc-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* Filtros */
        .mc-filtros {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .mc-select {
            font-size: 0.85rem;
            padding: 0.5rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-text);
            outline: none;
            cursor: pointer;
        }

        .mc-select:focus {
            border-color: #fbbf24;
        }

        .mc-tipo-btns {
            display: flex;
            gap: 0.375rem;
        }

        .mc-tipo-btn {
            padding: 0.35rem 0.875rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .mc-tipo-btn.activo-egreso {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .mc-tipo-btn.activo-ingreso {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        .mc-tipo-btn:hover {
            opacity: 0.8;
        }

        /* KPIs */
        .mc-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
            margin-bottom: 1rem;
        }

        @media(max-width:768px) {
            .mc-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .mc-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .mc-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .mc-kpi-value {
            font-size: 1rem;
            font-weight: 800;
        }

        .mc-kpi-sub {
            font-size: 0.62rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* Heatmap */
        .mc-heatmap-wrap {
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }

        .mc-heatmap {
            display: flex;
            gap: 3px;
        }

        .mc-col-meses {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            margin-right: 4px;
        }

        .mc-mes-label {
            font-size: 0.6rem;
            color: var(--w-muted);
            height: 12px;
            line-height: 12px;
            white-space: nowrap;
        }

        .mc-dias-label {
            display: flex;
            flex-direction: column;
            gap: 3px;
            margin-right: 4px;
            padding-top: 16px;
        }

        .mc-dia-label {
            font-size: 0.6rem;
            color: var(--w-muted);
            height: 12px;
            line-height: 12px;
        }

        .mc-semana {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .mc-mes-header {
            height: 16px;
            font-size: 0.6rem;
            color: var(--w-muted);
            white-space: nowrap;
            overflow: visible;
        }

        .mc-celda {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            cursor: pointer;
            transition: transform 0.1s;
            position: relative;
        }

        .mc-celda:hover {
            transform: scale(1.4);
            z-index: 10;
        }

        .mc-celda.vacia {
            background: var(--w-border);
        }

        .mc-celda.fuera {
            background: transparent;
        }

        .mc-celda.nivel-0 {
            background: var(--w-border);
        }

        /* Colores egreso (rojo) */
        .tipo-egreso .mc-celda.nivel-1 {
            background: #fca5a5;
        }

        .tipo-egreso .mc-celda.nivel-2 {
            background: #f87171;
        }

        .tipo-egreso .mc-celda.nivel-3 {
            background: #ef4444;
        }

        .tipo-egreso .mc-celda.nivel-4 {
            background: #dc2626;
        }

        .tipo-egreso .mc-celda.nivel-5 {
            background: #b91c1c;
        }

        /* Colores ingreso (verde) */
        .tipo-ingreso .mc-celda.nivel-1 {
            background: #86efac;
        }

        .tipo-ingreso .mc-celda.nivel-2 {
            background: #4ade80;
        }

        .tipo-ingreso .mc-celda.nivel-3 {
            background: #22c55e;
        }

        .tipo-ingreso .mc-celda.nivel-4 {
            background: #16a34a;
        }

        .tipo-ingreso .mc-celda.nivel-5 {
            background: #15803d;
        }

        /* Leyenda */
        .mc-leyenda {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            margin-top: 0.75rem;
            font-size: 0.65rem;
            color: var(--w-muted);
        }

        .mc-leyenda-celda {
            width: 12px;
            height: 12px;
            border-radius: 2px;
        }

        /* Tooltip */
        .mc-tooltip {
            position: fixed;
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.72rem;
            color: #f9fafb;
            pointer-events: none;
            z-index: 9999;
            display: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        /* Barras por mes */
        .mc-meses-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 0.375rem;
        }

        @media(max-width:768px) {
            .mc-meses-grid {
                grid-template-columns: repeat(6, 1fr);
            }
        }

        .mc-mes-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }

        .mc-mes-bar-wrap {
            width: 100%;
            background: var(--w-border);
            border-radius: 3px;
            overflow: hidden;
            height: 60px;
            display: flex;
            align-items: flex-end;
        }

        .mc-mes-bar {
            width: 100%;
            border-radius: 3px 3px 0 0;
            transition: height 0.3s;
        }

        .mc-mes-nombre {
            font-size: 0.6rem;
            color: var(--w-muted);
        }

        .mc-mes-monto {
            font-size: 0.62rem;
            font-weight: 700;
        }
    </style>

    <div class="mc-tooltip" id="mcTooltip"></div>

    <div class="mc-wrap">

        <div class="mc-card">
            <div class="mc-filtros">
                <select wire:model.live="anio" class="mc-select">
                    @foreach (range(now()->year - 2, now()->year) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>

                <div class="mc-tipo-btns">
                    <button class="mc-tipo-btn {{ $tipo === 'egreso' ? 'activo-egreso' : '' }}"
                        wire:click="$set('tipo','egreso')">
                        🔴 Gastos
                    </button>
                    <button class="mc-tipo-btn {{ $tipo === 'ingreso' ? 'activo-ingreso' : '' }}"
                        wire:click="$set('tipo','ingreso')">
                        🟢 Ingresos
                    </button>
                </div>
            </div>
        </div>

        <div class="mc-card">
            @php $color = $tipo === 'egreso' ? '#ef4444' : '#22c55e'; @endphp
            <div class="mc-kpis">
                <div class="mc-kpi">
                    <div class="mc-kpi-label">Total {{ $anio }}</div>
                    <div class="mc-kpi-value" style="color:{{ $color }};">S/
                        {{ number_format($d['totalAnio'], 2) }}</div>
                    <div class="mc-kpi-sub">{{ $tipo === 'egreso' ? 'en gastos' : 'en ingresos' }}</div>
                </div>
                <div class="mc-kpi">
                    <div class="mc-kpi-label">Días activos</div>
                    <div class="mc-kpi-value">{{ $d['diasActivos'] }}</div>
                    <div class="mc-kpi-sub">días con {{ $tipo === 'egreso' ? 'gasto' : 'ingreso' }}</div>
                </div>
                <div class="mc-kpi">
                    <div class="mc-kpi-label">Promedio por día</div>
                    <div class="mc-kpi-value">S/ {{ number_format($d['promedioDia'], 2) }}</div>
                    <div class="mc-kpi-sub">en días activos</div>
                </div>
                <div class="mc-kpi">
                    <div class="mc-kpi-label">Día más alto</div>
                    <div class="mc-kpi-value" style="color:{{ $color }};">
                        S/ {{ number_format($d['montoMasAlto'], 2) }}
                    </div>
                    <div class="mc-kpi-sub">
                        {{ $d['diaMasAlto'] ? \Carbon\Carbon::parse($d['diaMasAlto'])->format('d/m/Y') : '—' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mc-card">
            <div class="mc-title">🗓️ Mapa de calor — {{ $anio }}</div>

            <div class="mc-heatmap-wrap">
                <div class="mc-heatmap tipo-{{ $tipo }}">
                    <div class="mc-dias-label">
                        <div class="mc-dia-label"></div>
                        <div class="mc-dia-label">Lun</div>
                        <div class="mc-dia-label"></div>
                        <div class="mc-dia-label">Mié</div>
                        <div class="mc-dia-label"></div>
                        <div class="mc-dia-label">Vie</div>
                        <div class="mc-dia-label"></div>
                    </div>

                    @php
                        $mesesMostrados = [];
                    @endphp
                    @foreach ($d['semanas'] as $si => $semana)
                        <div class="mc-semana">
                            @php
                                $primerDiaEnAnio = collect($semana)->firstWhere('enAnio', true);
                                $mostrarMes = '';
                                if ($primerDiaEnAnio && !in_array($primerDiaEnAnio['mes'], $mesesMostrados)) {
                                    $mesesMostrados[] = $primerDiaEnAnio['mes'];
                                    $mostrarMes = \Carbon\Carbon::create(
                                        null,
                                        $primerDiaEnAnio['mes'],
                                    )->translatedFormat('M');
                                }
                            @endphp
                            <div class="mc-mes-header">{{ $mostrarMes }}</div>

                            @foreach ($semana as $dia)
                                <div class="mc-celda {{ !$dia['enAnio'] ? 'fuera' : 'nivel-' . $dia['nivel'] }}"
                                    @if ($dia['enAnio'] && $dia['monto'] > 0) onmouseenter="mostrarTooltip(event, '{{ \Carbon\Carbon::parse($dia['fecha'])->format('d/m/Y') }}', {{ $dia['monto'] }})"
                                    onmouseleave="ocultarTooltip()" @endif>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mc-leyenda">
                <span>Menos</span>
                @foreach ([0, 1, 2, 3, 4, 5] as $n)
                    <div class="mc-leyenda-celda nivel-{{ $n }} tipo-{{ $tipo }}"
                        style="{{ $n === 0 ? 'background:var(--w-border)' : '' }}"></div>
                @endforeach
                <span>Más</span>
            </div>
        </div>

        <div class="mc-card">
            <div class="mc-title">📊 Distribución mensual</div>
            <div class="mc-meses-grid">
                @foreach ($d['porMes'] as $mes)
                    @php
                        $altura = $d['maxMes'] > 0 ? round(($mes['total'] / $d['maxMes']) * 100) : 0;
                        $barColor = $tipo === 'egreso' ? '#ef4444' : '#22c55e';
                        $esMayor = $mes['total'] === $d['maxMes'];
                    @endphp
                    <div class="mc-mes-item">
                        <div class="mc-mes-bar-wrap">
                            <div class="mc-mes-bar"
                                style="height:{{ max(0, $altura) }}%; background:{{ $esMayor ? $barColor : $barColor . '66' }};">
                            </div>
                        </div>
                        <div class="mc-mes-nombre">{{ $mes['mes'] }}</div>
                        <div class="mc-mes-monto" style="color:{{ $barColor }};">
                            {{ $mes['total'] > 0 ? number_format($mes['total'], 0) : '' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
        function mostrarTooltip(event, fecha, monto) {
            const tip = document.getElementById('mcTooltip');
            tip.innerHTML = `<strong>${fecha}</strong><br>S/ ${parseFloat(monto).toFixed(2)}`;
            tip.style.display = 'block';
            tip.style.left = (event.clientX + 12) + 'px';
            tip.style.top = (event.clientY - 40) + 'px';
        }

        function ocultarTooltip() {
            document.getElementById('mcTooltip').style.display = 'none';
        }

        document.addEventListener('mousemove', function(e) {
            const tip = document.getElementById('mcTooltip');
            if (tip.style.display === 'block') {
                tip.style.left = (e.clientX + 12) + 'px';
                tip.style.top = (e.clientY - 40) + 'px';
            }
        });
    </script>

</x-filament-panels::page>

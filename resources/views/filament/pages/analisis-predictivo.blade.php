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
            --w-muted: #6b7280;F
            --w-border: rgba(255, 255, 255, 0.08);
        }

        .ap-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ap-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ap-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* Predicción principal */
        .ap-prediccion {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            padding: 1.25rem;
            border-radius: 0.875rem;
            margin-bottom: 1rem;
        }

        .ap-pred-excelente {
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .ap-pred-positivo {
            background: rgba(96, 165, 250, 0.08);
            border: 1px solid rgba(96, 165, 250, 0.2);
        }

        .ap-pred-negativo {
            background: rgba(251, 191, 36, 0.08);
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .ap-pred-critico {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .ap-pred-icon {
            font-size: 2.5rem;
            flex-shrink: 0;
        }

        .ap-pred-info {
            flex: 1;
        }

        .ap-pred-titulo {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .ap-pred-desc {
            font-size: 0.8rem;
            color: var(--w-muted);
            line-height: 1.5;
        }

        /* Progreso del mes */
        .ap-prog-wrap {
            margin-bottom: 1rem;
        }

        .ap-prog-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--w-muted);
            margin-bottom: 0.375rem;
        }

        .ap-prog-track {
            height: 6px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .ap-prog-fill {
            height: 100%;
            border-radius: 99px;
            background: #fbbf24;
        }

        /* KPIs */
        .ap-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:768px) {
            .ap-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .ap-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .ap-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .ap-kpi-value {
            font-size: 1rem;
            font-weight: 800;
        }

        .ap-kpi-sub {
            font-size: 0.62rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* Velocidad */
        .ap-velocidad {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .ap-vel-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 900;
            flex-shrink: 0;
            border: 3px solid;
        }

        .ap-vel-info {
            flex: 1;
        }

        .ap-vel-label {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .ap-vel-desc {
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--w-text);
        }

        .ap-vel-sub {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }

        /* Patrones días */
        .ap-dias {
            display: flex;
            align-items: flex-end;
            gap: 0.375rem;
            height: 80px;
        }

        .ap-dia-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }

        .ap-dia-bar {
            width: 100%;
            border-radius: 3px 3px 0 0;
            min-height: 3px;
            transition: height 0.3s;
        }

        .ap-dia-label {
            font-size: 0.62rem;
            color: var(--w-muted);
        }

        /* Tendencia */
        .ap-tend {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0.375rem;
        }

        .ap-tend-item {
            background: var(--w-card);
            border-radius: 0.5rem;
            padding: 0.5rem 0.375rem;
            text-align: center;
        }

        .ap-tend-mes {
            font-size: 0.6rem;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .ap-tend-val {
            font-size: 0.75rem;
            font-weight: 700;
        }

        /* Grid 2 */
        .ap-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem;
        }

        @media(max-width:640px) {
            .ap-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .ap-info-item {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.875rem;
        }

        .ap-info-label {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ap-info-value {
            font-size: 0.925rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ap-info-sub {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 0.1rem;
        }
    </style>

    <div class="ap-wrap">

        <div class="ap-card">
            <div class="ap-title">🔮 Predicción para {{ $d['mesActual'] }}</div>

            @php
                $predConfig = match ($d['prediccion']) {
                    'excelente' => [
                        'color' => '#22c55e',
                        'emoji' => '🚀',
                        'titulo' => '¡Mes excelente!',
                        'desc' =>
                            'Vas muy bien. Tu ritmo de gasto está por debajo del promedio y cerrarás el mes con ahorro positivo.',
                    ],
                    'positivo' => [
                        'color' => '#60a5fa',
                        'emoji' => '😊',
                        'titulo' => 'Mes positivo',
                        'desc' =>
                            'Cerrarás el mes en positivo, aunque el gasto está algo elevado. Mantén el control los días restantes.',
                    ],
                    'negativo' => [
                        'color' => '#fbbf24',
                        'emoji' => '⚠️',
                        'titulo' => 'Mes ajustado',
                        'desc' =>
                            'Podrías cerrar el mes con poco o sin ahorro. Reduce gastos no esenciales en los próximos días.',
                    ],
                    'critico' => [
                        'color' => '#ef4444',
                        'emoji' => '🚨',
                        'titulo' => 'Mes crítico',
                        'desc' => 'El ritmo de gasto actual proyecta un déficit. Revisa tus gastos urgentemente.',
                    ],
                    default => [
                        'color' => '#6b7280',
                        'emoji' => '📊',
                        'titulo' => 'Sin datos',
                        'desc' => 'No hay suficientes datos históricos para hacer una predicción.',
                    ],
                };
            @endphp

            <div class="ap-prediccion ap-pred-{{ $d['prediccion'] }}">
                <div class="ap-pred-icon">{{ $predConfig['emoji'] }}</div>
                <div class="ap-pred-info">
                    <div class="ap-pred-titulo" style="color:{{ $predConfig['color'] }};">{{ $predConfig['titulo'] }}
                    </div>
                    <div class="ap-pred-desc">{{ $predConfig['desc'] }}</div>
                </div>
            </div>

            <div class="ap-prog-wrap">
                <div class="ap-prog-label">
                    <span>Día {{ $d['diaActual'] }} de {{ $d['diasMes'] }}</span>
                    <span>{{ $d['diasRestantes'] }} días restantes</span>
                </div>
                <div class="ap-prog-track">
                    <div class="ap-prog-fill" style="width:{{ round(($d['diaActual'] / $d['diasMes']) * 100) }}%;">
                    </div>
                </div>
            </div>

            <div class="ap-kpis">
                <div class="ap-kpi">
                    <div class="ap-kpi-label">Ingresos proyectados</div>
                    <div class="ap-kpi-value" style="color:#22c55e;">S/
                        {{ number_format($d['ingresosProyectados'], 2) }}</div>
                    <div class="ap-kpi-sub">actual S/ {{ number_format($d['ingresosMes'], 2) }}</div>
                </div>
                <div class="ap-kpi">
                    <div class="ap-kpi-label">Egresos proyectados</div>
                    <div class="ap-kpi-value" style="color:#ef4444;">S/
                        {{ number_format($d['egresosProyectados'], 2) }}</div>
                    <div class="ap-kpi-sub">actual S/ {{ number_format($d['egresosMes'], 2) }}</div>
                </div>
                <div class="ap-kpi">
                    <div class="ap-kpi-label">Ahorro proyectado</div>
                    <div class="ap-kpi-value" style="color:{{ $d['ahorroProyectado'] >= 0 ? '#60a5fa' : '#ef4444' }};">
                        {{ $d['ahorroProyectado'] >= 0 ? '+' : '' }}S/ {{ number_format($d['ahorroProyectado'], 2) }}
                    </div>
                    <div class="ap-kpi-sub">al fin del mes</div>
                </div>
                <div class="ap-kpi">
                    <div class="ap-kpi-label">Saldo total</div>
                    <div class="ap-kpi-value" style="color:#fbbf24;">S/ {{ number_format($d['saldoTotal'], 2) }}</div>
                    <div class="ap-kpi-sub">en todas las cuentas</div>
                </div>
            </div>
        </div>

        <div class="ap-grid-2">
            <div class="ap-card">
                <div class="ap-title">⚡ Velocidad de gasto</div>
                @php
                    $velColor = $d['velocidad'] <= 100 ? '#22c55e' : ($d['velocidad'] <= 130 ? '#fbbf24' : '#ef4444');
                    $velDesc =
                        $d['velocidad'] <= 100
                            ? 'Gastando menos que tu promedio ✓'
                            : ($d['velocidad'] <= 130
                                ? 'Gastando un poco más que lo normal'
                                : 'Gastando significativamente más');
                @endphp
                <div class="ap-velocidad">
                    <div class="ap-vel-circle"
                        style="border-color:{{ $velColor }}; color:{{ $velColor }}; background:{{ $velColor }}12;">
                        {{ $d['velocidad'] }}%
                    </div>
                    <div class="ap-vel-info">
                        <div class="ap-vel-label">Ritmo actual vs promedio histórico</div>
                        <div class="ap-vel-desc" style="color:{{ $velColor }};">{{ $velDesc }}</div>
                        <div class="ap-vel-sub">
                            Gasto diario: S/ {{ number_format($d['gastoDiarioActual'], 2) }}
                            · Promedio: S/ {{ number_format($d['promDiarioEgresos'], 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="ap-card">
                <div class="ap-title">💰 Proyección de saldo</div>
                <div class="ap-grid-2" style="gap:0.5rem;">
                    <div class="ap-info-item">
                        <div class="ap-info-label">Días hasta saldo 0</div>
                        <div class="ap-info-value"
                            style="color:{{ $d['diasHastaCero'] < 30 ? '#ef4444' : ($d['diasHastaCero'] < 90 ? '#fbbf24' : '#22c55e') }};">
                            {{ $d['diasHastaCero'] >= 365 ? '+365 días' : $d['diasHastaCero'] . ' días' }}
                        </div>
                        <div class="ap-info-sub">si mantienes el ritmo actual</div>
                    </div>
                    <div class="ap-info-item">
                        <div class="ap-info-label">Fecha estimada</div>
                        <div class="ap-info-value" style="color:var(--w-text);">{{ $d['fechasCero'] }}</div>
                        <div class="ap-info-sub">con gasto actual de S/
                            {{ number_format($d['gastoDiarioActual'], 2) }}/día</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ap-card">
            <div class="ap-title">📅 Gastos promedio por día de la semana</div>
            <div class="ap-dias">
                @foreach ($d['patronesDia'] as $patron)
                    @php
                        $altura = $d['maxPatron'] > 0 ? round(($patron['promedio'] / $d['maxPatron']) * 100) : 0;
                        $esMayor = $patron['promedio'] === max(array_column($d['patronesDia'], 'promedio'));
                    @endphp
                    <div class="ap-dia-wrap">
                        <div style="font-size:0.65rem; color:var(--w-muted); margin-bottom:2px;">
                            S/ {{ number_format($patron['promedio'], 0) }}
                        </div>
                        <div class="ap-dia-bar"
                            style="height:{{ max(4, $altura) }}%;
                        background:{{ $esMayor ? '#ef4444' : '#6366f1' }}88;
                        border:1px solid {{ $esMayor ? '#ef4444' : '#6366f1' }};">
                        </div>
                        <div class="ap-dia-label" style="{{ $esMayor ? 'color:#ef4444; font-weight:700;' : '' }}">
                            {{ $patron['dia'] }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="font-size:0.68rem; color:var(--w-muted); margin-top:0.5rem;">
                El día en rojo es cuando más gastas en promedio histórico.
            </div>
        </div>

        <div class="ap-grid-2">
            <div class="ap-card">
                <div class="ap-title">📈 Tendencia de ahorro (6 meses)</div>
                <div class="ap-tend">
                    @foreach ($d['tendencia'] as $t)
                        @php $color = $t['ahorro'] >= 0 ? '#22c55e' : '#ef4444'; @endphp
                        <div class="ap-tend-item">
                            <div class="ap-tend-mes">{{ $t['mes'] }}</div>
                            <div class="ap-tend-val" style="color:{{ $color }};">
                                {{ $t['ahorro'] >= 0 ? '+' : '' }}{{ number_format($t['ahorro'], 0) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="ap-card">
                <div class="ap-title">🏆 Récords históricos (12 meses)</div>
                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                    @if ($d['mejorMes'])
                        <div class="ap-info-item" style="border-left:3px solid #22c55e;">
                            <div class="ap-info-label">✅ Mejor mes (menos gasto)</div>
                            <div class="ap-info-value" style="color:#22c55e;">{{ $d['mejorMes']['mes'] }}</div>
                            <div class="ap-info-sub">S/ {{ number_format($d['mejorMes']['monto'], 2) }} en egresos
                            </div>
                        </div>
                    @endif
                    @if ($d['peorMes'])
                        <div class="ap-info-item" style="border-left:3px solid #ef4444;">
                            <div class="ap-info-label">⚠️ Mes con más gasto</div>
                            <div class="ap-info-value" style="color:#ef4444;">{{ $d['peorMes']['mes'] }}</div>
                            <div class="ap-info-sub">S/ {{ number_format($d['peorMes']['monto'], 2) }} en egresos</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>

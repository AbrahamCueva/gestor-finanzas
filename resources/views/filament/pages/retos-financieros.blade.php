<x-filament-panels::page>
    @php
        $retos = $this->getRetos();
        $resumen = $this->getResumen();
        $cats = $this->getCategorias();
        $plantillas = $this->getPlantillas();
    @endphp

    <style>
        :root {
            --bg: rgba(0, 0, 0, 0.04);
            --card: rgba(0, 0, 0, 0.05);
            --text: #111827;
            --soft: #374151;
            --muted: #6b7280;
            --border: rgba(0, 0, 0, 0.08);
            --gold: #fbbf24;
            --green: #22c55e;
            --red: #ef4444;
            --blue: #60a5fa;
            --purple: #a78bfa;
            --orange: #f97316;
        }

        .dark {
            --bg: rgba(255, 255, 255, 0.03);
            --card: rgba(255, 255, 255, 0.04);
            --text: #f9fafb;
            --soft: #e5e7eb;
            --muted: #6b7280;
            --border: rgba(255, 255, 255, 0.07);
        }

        .rt {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .rt-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .rt-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* KPIs */
        .rt-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .625rem;
        }

        @media(max-width:768px) {
            .rt-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .rt-kpi {
            background: var(--card);
            border-radius: .75rem;
            padding: .875rem 1rem;
            text-align: center;
        }

        .rt-kpi-label {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
        }

        .rt-kpi-value {
            font-size: 1.4rem;
            font-weight: 900;
            margin-top: .15rem;
        }

        .rt-kpi-sub {
            font-size: .62rem;
            color: var(--muted);
            margin-top: .1rem;
        }

        /* Tabs */
        .rt-tabs {
            display: flex;
            gap: .3rem;
            flex-wrap: wrap;
        }

        .rt-tab {
            padding: .35rem .875rem;
            border-radius: 99px;
            font-size: .72rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            background: var(--card);
            color: var(--muted);
            transition: all .15s;
        }

        .rt-tab.on {
            background: rgba(251, 191, 36, .15);
            color: var(--gold);
        }

        /* Botón nuevo */
        .rt-btn-nuevo {
            padding: .45rem 1.125rem;
            border-radius: .625rem;
            font-size: .78rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            background: var(--gold);
            color: #0f172a;
            transition: all .15s;
            display: flex;
            align-items: center;
            gap: .375rem;
        }

        .rt-btn-nuevo:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        /* Grid retos */
        .rt-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .875rem;
        }

        @media(max-width:1100px) {
            .rt-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:640px) {
            .rt-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Tarjeta reto */
        .rt-reto {
            background: var(--card);
            border-radius: 1rem;
            padding: 1.125rem;
            border-left: 4px solid;
            display: flex;
            flex-direction: column;
            gap: .75rem;
            position: relative;
            overflow: hidden;
            transition: transform .15s;
        }

        .rt-reto:hover {
            transform: translateY(-2px);
        }

        .rt-reto-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .5rem;
        }

        .rt-reto-emoji {
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .rt-reto-nombre {
            font-size: .875rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
        }

        .rt-reto-desc {
            font-size: .68rem;
            color: var(--muted);
            margin-top: .15rem;
            line-height: 1.4;
        }

        .rt-badge {
            font-size: .58rem;
            font-weight: 700;
            padding: .15rem .5rem;
            border-radius: 99px;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .rt-badge-facil {
            background: rgba(34, 197, 94, .12);
            color: #22c55e;
        }

        .rt-badge-medio {
            background: rgba(251, 191, 36, .12);
            color: #fbbf24;
        }

        .rt-badge-dificil {
            background: rgba(249, 115, 22, .12);
            color: #f97316;
        }

        .rt-badge-extremo {
            background: rgba(239, 68, 68, .12);
            color: #ef4444;
        }

        /* Progress */
        .rt-prog-wrap {
            display: flex;
            flex-direction: column;
            gap: .375rem;
        }

        .rt-prog-header {
            display: flex;
            justify-content: space-between;
            font-size: .68rem;
        }

        .rt-prog-label {
            color: var(--muted);
        }

        .rt-prog-pct {
            font-weight: 800;
            color: var(--text);
        }

        .rt-prog-track {
            height: 6px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .rt-prog-fill {
            height: 100%;
            border-radius: 99px;
            transition: width .5s ease;
        }

        /* Footer reto */
        .rt-reto-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .rt-dias {
            font-size: .65rem;
            color: var(--muted);
        }

        .rt-puntos {
            font-size: .68rem;
            font-weight: 700;
            color: var(--gold);
        }

        .rt-btn-abandonar {
            font-size: .6rem;
            font-weight: 700;
            padding: .15rem .5rem;
            border-radius: .375rem;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            transition: all .15s;
        }

        .rt-btn-abandonar:hover {
            border-color: var(--red);
            color: var(--red);
        }

        /* Completado badge */
        .rt-completado-badge {
            position: absolute;
            top: .75rem;
            right: .75rem;
            font-size: .62rem;
            font-weight: 700;
            padding: .2rem .5rem;
            border-radius: 99px;
            background: rgba(34, 197, 94, .15);
            color: #22c55e;
        }

        /* Plantillas */
        .rt-plantillas {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .625rem;
        }

        @media(max-width:1100px) {
            .rt-plantillas {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:640px) {
            .rt-plantillas {
                grid-template-columns: 1fr;
            }
        }

        .rt-plantilla {
            background: var(--card);
            border-radius: .875rem;
            padding: .875rem;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: all .15s;
            display: flex;
            flex-direction: column;
            gap: .375rem;
        }

        .rt-plantilla:hover {
            border-color: rgba(251, 191, 36, .3);
            background: rgba(251, 191, 36, .04);
        }

        .rt-plantilla-emoji {
            font-size: 1.5rem;
        }

        .rt-plantilla-nombre {
            font-size: .78rem;
            font-weight: 700;
            color: var(--text);
        }

        .rt-plantilla-desc {
            font-size: .65rem;
            color: var(--muted);
            line-height: 1.3;
        }

        .rt-plantilla-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: .25rem;
        }

        /* Modal */
        .rt-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .rt-modal {
            background: #1f2937;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 1.25rem;
            padding: 1.5rem;
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .dark .rt-modal {
            background: #111827;
        }

        .rt-modal-titulo {
            font-size: 1rem;
            font-weight: 800;
            color: #f9fafb;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .rt-field {
            display: flex;
            flex-direction: column;
            gap: .375rem;
            margin-bottom: .875rem;
        }

        .rt-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9ca3af;
        }

        .rt-input {
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: .625rem;
            padding: .5rem .875rem;
            font-size: .825rem;
            color: #f9fafb;
            outline: none;
            width: 100%;
            transition: border-color .15s;
        }

        .rt-input:focus {
            border-color: var(--gold);
        }

        .rt-input option {
            background: #1f2937;
        }

        .rt-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
        }

        .rt-tipos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .375rem;
            margin-bottom: .875rem;
        }

        .rt-tipo-btn {
            padding: .5rem;
            border-radius: .625rem;
            border: 1.5px solid rgba(255, 255, 255, .1);
            background: rgba(255, 255, 255, .04);
            cursor: pointer;
            transition: all .15s;
            text-align: center;
            font-size: .65rem;
            font-weight: 700;
            color: #9ca3af;
        }

        .rt-tipo-btn.on {
            border-color: var(--gold);
            background: rgba(251, 191, 36, .1);
            color: var(--gold);
        }

        .rt-tipo-btn-emoji {
            font-size: 1.1rem;
            display: block;
            margin-bottom: .2rem;
        }

        .rt-modal-footer {
            display: flex;
            gap: .75rem;
            justify-content: flex-end;
            margin-top: 1.25rem;
        }

        .rt-btn-cancelar {
            padding: .5rem 1.125rem;
            border-radius: .625rem;
            font-size: .8rem;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, .1);
            background: transparent;
            color: #9ca3af;
            cursor: pointer;
        }

        .rt-btn-guardar {
            padding: .5rem 1.25rem;
            border-radius: .625rem;
            font-size: .8rem;
            font-weight: 700;
            border: none;
            background: var(--gold);
            color: #0f172a;
            cursor: pointer;
            transition: all .15s;
        }

        .rt-btn-guardar:hover {
            opacity: .9;
        }

        .rt-empty {
            text-align: center;
            padding: 3rem;
            color: var(--muted);
        }

        .rt-empty-emoji {
            font-size: 2.5rem;
            margin-bottom: .75rem;
        }

        .rt-empty-title {
            font-size: .875rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .375rem;
        }
    </style>

    <div class="rt">

        {{-- KPIs --}}
        <div class="rt-kpis">
            <div class="rt-kpi">
                <div class="rt-kpi-label">Retos activos</div>
                <div class="rt-kpi-value" style="color:var(--blue);">{{ $resumen['activos'] }}</div>
                <div class="rt-kpi-sub">en progreso</div>
            </div>
            <div class="rt-kpi">
                <div class="rt-kpi-label">Completados</div>
                <div class="rt-kpi-value" style="color:var(--green);">{{ $resumen['completados'] }}</div>
                <div class="rt-kpi-sub">logros</div>
            </div>
            <div class="rt-kpi">
                <div class="rt-kpi-label">Fallidos</div>
                <div class="rt-kpi-value" style="color:var(--red);">{{ $resumen['fallidos'] }}</div>
                <div class="rt-kpi-sub">abandonados</div>
            </div>
            <div class="rt-kpi">
                <div class="rt-kpi-label">Puntos totales</div>
                <div class="rt-kpi-value" style="color:var(--gold);">{{ number_format($resumen['puntos']) }}</div>
                <div class="rt-kpi-sub">⭐ XP ganados</div>
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="rt-card">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.75rem;">
                <div class="rt-tabs">
                    @foreach (['activos' => '⚡ Activos', 'completados' => '✅ Completados', 'fallidos' => '❌ Fallidos', 'plantillas' => '📋 Plantillas'] as $key => $label)
                        <button class="rt-tab {{ $vistaActiva === $key ? 'on' : '' }}"
                            wire:click="$set('vistaActiva', '{{ $key }}')">{{ $label }}</button>
                    @endforeach
                </div>
                <button class="rt-btn-nuevo" wire:click="abrirModal">
                    ➕ Nuevo reto
                </button>
            </div>
        </div>

        {{-- Plantillas --}}
        @if ($vistaActiva === 'plantillas')
            <div class="rt-card">
                <div class="rt-title">📋 Plantillas de retos populares</div>
                <div class="rt-plantillas">
                    @foreach ($plantillas as $i => $p)
                        <div class="rt-plantilla" wire:click="usarPlantilla({{ $i }})">
                            <div class="rt-plantilla-emoji">{{ $p['icono'] }}</div>
                            <div class="rt-plantilla-nombre">{{ $p['nombre'] }}</div>
                            <div class="rt-plantilla-desc">{{ $p['descripcion'] }}</div>
                            <div class="rt-plantilla-footer">
                                <span class="rt-badge rt-badge-{{ $p['dificultad'] }}">{{ $p['dificultad'] }}</span>
                                <span style="font-size:.65rem; color:var(--gold); font-weight:700;">⭐
                                    {{ $p['puntos'] }} pts</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Grid retos --}}
            @if (count($retos) === 0)
                <div class="rt-card rt-empty">
                    <div class="rt-empty-emoji">
                        {{ $vistaActiva === 'completados' ? '🏆' : ($vistaActiva === 'fallidos' ? '💔' : '🎯') }}
                    </div>
                    <div class="rt-empty-title">
                        {{ $vistaActiva === 'completados' ? 'Aún no has completado retos' : ($vistaActiva === 'fallidos' ? 'Sin retos fallidos' : 'No tienes retos activos') }}
                    </div>
                    <div>{{ $vistaActiva === 'activos' ? 'Crea un nuevo reto o usa una plantilla para empezar.' : '' }}
                    </div>
                </div>
            @else
                <div class="rt-grid">
                    @foreach ($retos as $reto)
                        @php
                            $color = $reto['color'] ?? '#fbbf24';
                            $pct = 0;
                            if (in_array($reto['tipo'], ['ahorro', 'ingreso', 'egreso_categoria'])) {
                                $meta = $reto['meta_monto'] ?: 1;
                                $pct = min(100, round(($reto['progreso_actual'] / $meta) * 100, 1));
                            } else {
                                $meta = $reto['meta_dias'] ?: 1;
                                $pct = min(100, round(($reto['progreso_actual'] / $meta) * 100, 1));
                            }
                            $diasRestantes = max(0, now()->diffInDays($reto['fecha_fin'], false));
                            $fillColor =
                                $reto['estado'] === 'completado' ? '#22c55e' : ($pct >= 80 ? '#fbbf24' : $color);
                        @endphp
                        <div class="rt-reto" style="border-color:{{ $color }};">
                            @if ($reto['estado'] === 'completado')
                                <div class="rt-completado-badge">✅ Completado</div>
                            @elseif($reto['estado'] === 'fallido')
                                <div class="rt-completado-badge" style="background:rgba(239,68,68,.15);color:#ef4444;">❌
                                    Fallido</div>
                            @elseif($reto['estado'] === 'abandonado')
                                <div class="rt-completado-badge"
                                    style="background:rgba(107,114,128,.15);color:#6b7280;">🚫 Abandonado</div>
                            @endif

                            <div class="rt-reto-header">
                                <div class="rt-reto-emoji">{{ $reto['icono'] }}</div>
                                <div style="flex:1;">
                                    <div class="rt-reto-nombre">{{ $reto['nombre'] }}</div>
                                    @if ($reto['descripcion'])
                                        <div class="rt-reto-desc">{{ $reto['descripcion'] }}</div>
                                    @endif
                                </div>
                                <span
                                    class="rt-badge rt-badge-{{ $reto['dificultad'] }}">{{ $reto['dificultad'] }}</span>
                            </div>

                            {{-- Progreso --}}
                            <div class="rt-prog-wrap">
                                <div class="rt-prog-header">
                                    <span class="rt-prog-label">
                                        @if (in_array($reto['tipo'], ['ahorro', 'ingreso']))
                                            S/ {{ number_format($reto['progreso_actual'], 2) }} / S/
                                            {{ number_format($reto['meta_monto'], 2) }}
                                        @elseif($reto['tipo'] === 'egreso_categoria')
                                            Gastado: S/ {{ number_format($reto['progreso_actual'], 2) }} / límite S/
                                            {{ number_format($reto['meta_monto'], 2) }}
                                        @else
                                            {{ $reto['progreso_actual'] }} / {{ $reto['meta_dias'] }} días
                                        @endif
                                    </span>
                                    <span class="rt-prog-pct"
                                        style="color:{{ $fillColor }};">{{ $pct }}%</span>
                                </div>
                                <div class="rt-prog-track">
                                    <div class="rt-prog-fill"
                                        style="width:{{ $pct }}%; background:{{ $fillColor }};"></div>
                                </div>
                            </div>

                            <div class="rt-reto-footer">
                                <div>
                                    <div class="rt-dias">
                                        📅 {{ Carbon\Carbon::parse($reto['fecha_inicio'])->format('d/m') }} —
                                        {{ Carbon\Carbon::parse($reto['fecha_fin'])->format('d/m/Y') }}
                                    </div>
                                    @if ($reto['estado'] === 'activo')
                                        <div class="rt-dias">⏳ {{ $diasRestantes }} días restantes</div>
                                    @endif
                                </div>
                                <div style="display:flex; align-items:center; gap:.5rem;">
                                    <span class="rt-puntos">⭐ {{ number_format($reto['puntos']) }} pts</span>
                                    @if ($reto['estado'] === 'activo')
                                        <button class="rt-btn-abandonar"
                                            wire:click="abandonarReto({{ $reto['id'] }})"
                                            wire:confirm="¿Abandonar este reto?">
                                            Abandonar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

    </div>

    {{-- Modal --}}
    @if ($modalAbierto)
        <div class="rt-modal-overlay" wire:click.self="cerrarModal">
            <div class="rt-modal">
                <div class="rt-modal-titulo">
                    <span>🎯 Nuevo Reto Financiero</span>
                    <button wire:click="cerrarModal"
                        style="background:none;border:none;cursor:pointer;color:#9ca3af;font-size:1.2rem;">✕</button>
                </div>

                {{-- Tipo de reto --}}
                <div class="rt-label" style="margin-bottom:.5rem;">Tipo de reto</div>
                <div class="rt-tipos">
                    @foreach ([
        'ahorro' => ['💰', 'Ahorro neto'],
        'egreso_categoria' => ['🚫', 'Limitar categoría'],
        'sin_gastos' => ['🧘', 'Días sin gastos'],
        'ingreso' => ['📈', 'Meta de ingreso'],
        'dias_consecutivos' => ['📅', 'Días seguidos'],
    ] as $key => [$emoji, $label])
                        <button class="rt-tipo-btn {{ $tipo === $key ? 'on' : '' }}"
                            wire:click="$set('tipo','{{ $key }}')">
                            <span class="rt-tipo-btn-emoji">{{ $emoji }}</span>
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="rt-field">
                    <label class="rt-label">Nombre del reto</label>
                    <input class="rt-input" wire:model="nombre" placeholder="Ej: Sin delivery esta semana">
                </div>

                <div class="rt-field">
                    <label class="rt-label">Descripción (opcional)</label>
                    <input class="rt-input" wire:model="descripcion" placeholder="Describe tu reto...">
                </div>

                @if (in_array($tipo, ['ahorro', 'ingreso']))
                    <div class="rt-field">
                        <label class="rt-label">Meta en soles (S/)</label>
                        <input class="rt-input" type="number" wire:model="meta_monto" placeholder="500.00">
                    </div>
                @elseif($tipo === 'egreso_categoria')
                    <div class="rt-grid-2">
                        <div class="rt-field">
                            <label class="rt-label">Categoría</label>
                            <select class="rt-input" wire:model="categoria_id">
                                <option value="">— Seleccionar —</option>
                                @foreach ($cats as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="rt-field">
                            <label class="rt-label">Límite máximo (S/)</label>
                            <input class="rt-input" type="number" wire:model="meta_monto" placeholder="100.00">
                        </div>
                    </div>
                @elseif(in_array($tipo, ['sin_gastos', 'dias_consecutivos']))
                    <div class="rt-field">
                        <label class="rt-label">Meta en días</label>
                        <input class="rt-input" type="number" wire:model="meta_dias" placeholder="7">
                    </div>
                @endif

                <div class="rt-grid-2">
                    <div class="rt-field">
                        <label class="rt-label">Fecha inicio</label>
                        <input class="rt-input" type="date" wire:model="fecha_inicio">
                    </div>
                    <div class="rt-field">
                        <label class="rt-label">Fecha fin</label>
                        <input class="rt-input" type="date" wire:model="fecha_fin">
                    </div>
                </div>

                <div class="rt-field">
                    <label class="rt-label">Dificultad</label>
                    <select class="rt-input" wire:model="dificultad">
                        <option value="facil">😊 Fácil — 100 pts</option>
                        <option value="medio">💪 Medio — 200 pts</option>
                        <option value="dificil">🔥 Difícil — 350 pts</option>
                        <option value="extremo">💀 Extremo — 500 pts</option>
                    </select>
                </div>

                <div class="rt-grid-2">
                    <div class="rt-field">
                        <label class="rt-label">Emoji</label>
                        <input class="rt-input" wire:model="icono" placeholder="🎯">
                    </div>
                    <div class="rt-field">
                        <label class="rt-label">Color</label>
                        <input class="rt-input" type="color" wire:model="color"
                            style="height:42px;padding:.25rem;">
                    </div>
                </div>

                <div class="rt-modal-footer">
                    <button class="rt-btn-cancelar" wire:click="cerrarModal">Cancelar</button>
                    <button class="rt-btn-guardar" wire:click="guardarReto">Crear reto 🚀</button>
                </div>
            </div>
        </div>
    @endif

</x-filament-panels::page>

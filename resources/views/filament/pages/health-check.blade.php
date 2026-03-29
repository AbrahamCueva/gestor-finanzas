<x-filament-panels::page>
    @php
        $checks = $this->getChecks();
        $info = $this->getInfo();
        $totalOk = collect($checks)->where('estado', 'ok')->count();
        $totalWarning = collect($checks)->where('estado', 'warning')->count();
        $totalError = collect($checks)->where('estado', 'error')->count();
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

        .hc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .hc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .hc-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        /* Estado general */
        .hc-estado-wrap {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .hc-estado-badge {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            border: 3px solid;
            flex-shrink: 0;
        }

        .hc-estado-info {
            flex: 1;
        }

        .hc-estado-nombre {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .hc-estado-sub {
            font-size: 0.75rem;
            color: var(--w-muted);
            margin-top: 0.2rem;
        }

        .hc-counters {
            display: flex;
            gap: 0.75rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }

        .hc-counter {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.8rem;
        }

        .hc-counter-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Grid checks */
        .hc-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        @media(max-width:768px) {
            .hc-grid {
                grid-template-columns: 1fr;
            }
        }

        .hc-check-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            border: 1.5px solid transparent;
        }

        .hc-check-card.ok {
            border-color: rgba(34, 197, 94, 0.2);
        }

        .hc-check-card.warning {
            border-color: rgba(251, 191, 36, 0.2);
        }

        .hc-check-card.error {
            border-color: rgba(239, 68, 68, 0.2);
        }

        .hc-check-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .hc-check-icon.ok {
            background: rgba(34, 197, 94, 0.15);
        }

        .hc-check-icon.warning {
            background: rgba(251, 191, 36, 0.15);
        }

        .hc-check-icon.error {
            background: rgba(239, 68, 68, 0.15);
        }

        .hc-check-nombre {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .hc-check-mensaje {
            font-size: 0.72rem;
            margin-top: 0.1rem;
        }

        .hc-check-detalle {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-top: 0.25rem;
            font-style: italic;
        }

        /* Info sistema */
        .hc-info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
        }

        @media(max-width:768px) {
            .hc-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .hc-info-item {
            background: var(--w-card);
            border-radius: 0.625rem;
            padding: 0.625rem 0.75rem;
        }

        .hc-info-label {
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .hc-info-value {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .hc-refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            background: var(--w-card);
            color: var(--w-muted);
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }

        .hc-refresh-btn:hover {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }
    </style>

    <div class="hc-wrap">

        <div class="hc-card">
            @php
                if ($totalError > 0) {
                    $estadoColor = '#ef4444';
                    $estadoEmoji = '🔴';
                    $estadoNombre = 'Sistema con errores';
                    $estadoSub = "{$totalError} verificación(es) fallida(s)";
                } elseif ($totalWarning > 0) {
                    $estadoColor = '#fbbf24';
                    $estadoEmoji = '🟡';
                    $estadoNombre = 'Sistema con advertencias';
                    $estadoSub = "{$totalWarning} advertencia(s) detectada(s)";
                } else {
                    $estadoColor = '#22c55e';
                    $estadoEmoji = '🟢';
                    $estadoNombre = 'Sistema saludable';
                    $estadoSub = 'Todas las verificaciones pasaron correctamente';
                }
            @endphp

            <div class="hc-estado-wrap">
                <div class="hc-estado-badge" style="border-color:{{ $estadoColor }}; background:{{ $estadoColor }}18;">
                    {{ $estadoEmoji }}
                </div>
                <div class="hc-estado-info">
                    <div class="hc-estado-nombre" style="color:{{ $estadoColor }};">{{ $estadoNombre }}</div>
                    <div class="hc-estado-sub">{{ $estadoSub }}</div>
                    <div class="hc-counters">
                        <div class="hc-counter">
                            <div class="hc-counter-dot" style="background:#22c55e;"></div>
                            <span style="color:#22c55e; font-weight:700;">{{ $totalOk }}</span>
                            <span style="color:var(--w-muted);">OK</span>
                        </div>
                        <div class="hc-counter">
                            <div class="hc-counter-dot" style="background:#fbbf24;"></div>
                            <span style="color:#fbbf24; font-weight:700;">{{ $totalWarning }}</span>
                            <span style="color:var(--w-muted);">Advertencias</span>
                        </div>
                        <div class="hc-counter">
                            <div class="hc-counter-dot" style="background:#ef4444;"></div>
                            <span style="color:#ef4444; font-weight:700;">{{ $totalError }}</span>
                            <span style="color:var(--w-muted);">Errores</span>
                        </div>
                    </div>
                </div>

                <button class="hc-refresh-btn" onclick="window.location.reload()">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Actualizar
                </button>
            </div>
        </div>

        <div class="hc-card">
            <div class="hc-title">🔍 Verificaciones</div>
            <div class="hc-grid">
                @foreach ($checks as $nombre => $check)
                    @php
                        $iconoMap = [
                            'ok' => '✅',
                            'warning' => '⚠️',
                            'error' => '❌',
                        ];
                        $colorMsg = match ($check['estado']) {
                            'ok' => '#22c55e',
                            'warning' => '#fbbf24',
                            default => '#ef4444',
                        };
                    @endphp
                    <div class="hc-check-card {{ $check['estado'] }}">
                        <div class="hc-check-icon {{ $check['estado'] }}">
                            {{ $iconoMap[$check['estado']] }}
                        </div>
                        <div style="flex:1;">
                            <div class="hc-check-nombre">{{ $nombre }}</div>
                            <div class="hc-check-mensaje" style="color:{{ $colorMsg }};">
                                {{ $check['mensaje'] }}
                            </div>
                            @if ($check['detalle'])
                                <div class="hc-check-detalle">{{ $check['detalle'] }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="hc-card">
            <div class="hc-title">💻 Información del sistema</div>
            <div class="hc-info-grid">
                @foreach ([['Laravel', $info['laravel']], ['PHP', $info['php']], ['Ambiente', $info['ambiente']], ['Debug', $info['debug']], ['Timezone', $info['timezone']], ['Base datos', $info['bd_driver']], ['Caché', $info['cache']], ['Uptime', $info['uptime']]] as [$label, $valor])
                    <div class="hc-info-item">
                        <div class="hc-info-label">{{ $label }}</div>
                        <div class="hc-info-value">{{ $valor }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="hc-card">
            <div class="hc-title">🛠️ Comandos útiles</div>
            <div style="display:flex; flex-direction:column; gap:0.5rem;">
                @foreach ([['php artisan ricox:tipos-cambio', 'Actualizar tipos de cambio'], ['php artisan ricox:notificaciones', 'Verificar notificaciones inteligentes'], ['php artisan ricox:limpiar-logs --force', 'Limpiar logs antiguos'], ['php artisan schedule:run', 'Ejecutar tareas programadas manualmente'], ['php artisan optimize:clear', 'Limpiar caché de la aplicación'], ['php artisan queue:work', 'Iniciar worker de colas']] as [$cmd, $desc])
                    <div
                        style="background:var(--w-card); border-radius:0.5rem; padding:0.625rem 0.875rem; display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                        <code
                            style="font-size:0.75rem; color:#fbbf24; font-family:monospace;">{{ $cmd }}</code>
                        <span style="font-size:0.7rem; color:var(--w-muted);">{{ $desc }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-filament-panels::page>

<x-filament-panels::page>
    @php
        $logs = $this->getLogs();
        $resumen = $this->getResumen();
        $totalPaginas = $logs['totalPaginas'];
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

        .as-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .as-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .as-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .as-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
        }

        @media(max-width:768px) {
            .as-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .as-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .as-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .as-kpi-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .as-filtros {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .as-filtro-btn {
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .as-filtro-btn.activo {
            background: #fbbf24;
            color: #0f172a;
        }

        .as-filtro-btn.sospech {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .as-filtro-btn:hover:not(.activo):not(.sospech) {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .as-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .as-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .as-table td {
            padding: 0.5rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
            vertical-align: middle;
        }

        .as-table tr:last-child td {
            border-bottom: none;
        }

        .as-table tr:hover td {
            background: var(--w-card);
        }

        .as-table tr.sospechoso td {
            background: rgba(239, 68, 68, 0.04);
        }

        .as-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .as-badge-ok {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .as-badge-warn {
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .as-badge-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .as-badge-info {
            background: rgba(96, 165, 250, 0.12);
            color: #60a5fa;
        }

        .as-badge-gray {
            background: rgba(107, 114, 128, 0.12);
            color: #6b7280;
        }

        .as-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .as-pag-info {
            font-size: 0.72rem;
            color: var(--w-muted);
        }

        .as-pag-btns {
            display: flex;
            gap: 0.25rem;
            flex-wrap: wrap;
        }

        .as-pag-btn {
            min-width: 30px;
            height: 30px;
            padding: 0 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.72rem;
            font-weight: 600;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-muted);
            cursor: pointer;
            transition: all 0.15s;
        }

        .as-pag-btn:hover:not(:disabled) {
            border-color: #fbbf24;
            color: #fbbf24;
        }

        .as-pag-btn.activo {
            background: #fbbf24;
            color: #0f172a;
            border-color: #fbbf24;
        }

        .as-pag-btn:disabled {
            opacity: 0.35;
            cursor: default;
        }
    </style>

    <div class="as-wrap">

        {{-- KPIs --}}
        <div class="as-card">
            <div class="as-kpis">
                <div class="as-kpi">
                    <div class="as-kpi-label">Total eventos</div>
                    <div class="as-kpi-value">{{ $resumen['total'] }}</div>
                </div>
                <div class="as-kpi">
                    <div class="as-kpi-label">Sospechosos</div>
                    <div class="as-kpi-value" style="color:{{ $resumen['sospechosos'] > 0 ? '#ef4444' : '#22c55e' }};">
                        {{ $resumen['sospechosos'] }}
                    </div>
                </div>
                <div class="as-kpi">
                    <div class="as-kpi-label">Último acceso</div>
                    <div class="as-kpi-value" style="font-size:0.85rem;">{{ $resumen['ultimoLogin'] }}</div>
                </div>
                <div class="as-kpi">
                    <div class="as-kpi-label">IPs únicas</div>
                    <div class="as-kpi-value">{{ $resumen['ipsUnicas'] }}</div>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="as-card">
            <div class="as-filtros">
                @foreach ([
        'todos' => 'Todos',
        'login_exitoso' => 'Logins',
        'login_fallido' => 'Fallidos',
        'cambio_password' => 'Contraseña',
        'cambio_pin' => 'PIN',
        'descarga_backup' => 'Backup',
        'sospechosos' => '⚠ Sospechosos',
    ] as $key => $label)
                    <button
                        class="as-filtro-btn {{ $filtro === $key ? ($key === 'sospechosos' ? 'sospech' : 'activo') : '' }}"
                        wire:click="$set('filtro','{{ $key }}')">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div style="overflow-x:auto;">
                <table class="as-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Evento</th>
                            <th>IP</th>
                            <th>Navegador</th>
                            <th>Dispositivo</th>
                            <th>Estado</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs['items'] as $log)
                            <tr class="{{ $log->sospechoso ? 'sospechoso' : '' }}">
                                <td style="white-space:nowrap; color:var(--w-muted); font-size:0.72rem;">
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    @php
                                        $eventoInfo = match ($log->evento) {
                                            'login_exitoso' => ['🟢', 'Login exitoso', 'as-badge-ok'],
                                            'login_fallido' => ['🔴', 'Login fallido', 'as-badge-danger'],
                                            'cambio_password' => ['🔑', 'Cambio contraseña', 'as-badge-warn'],
                                            'cambio_pin' => ['🔒', 'Cambio PIN', 'as-badge-warn'],
                                            'descarga_backup' => ['🗄️', 'Backup', 'as-badge-info'],
                                            default => ['📋', $log->evento, 'as-badge-gray'],
                                        };
                                    @endphp
                                    <span class="as-badge {{ $eventoInfo[2] }}">
                                        {{ $eventoInfo[0] }} {{ $eventoInfo[1] }}
                                    </span>
                                </td>
                                <td style="font-family:monospace; font-size:0.72rem;">{{ $log->ip ?? '—' }}</td>
                                <td style="color:var(--w-muted);">{{ $log->navegador ?? '—' }}</td>
                                <td style="color:var(--w-muted);">{{ $log->dispositivo ?? '—' }}</td>
                                <td>
                                    @if ($log->sospechoso)
                                        <span class="as-badge as-badge-danger">⚠ Sospechoso</span>
                                    @else
                                        <span class="as-badge as-badge-ok">✓ Normal</span>
                                    @endif
                                </td>
                                <td style="color:var(--w-muted); font-size:0.72rem; max-width:200px;">
                                    {{ $log->detalle ?: '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; color:var(--w-muted); padding:2rem;">
                                    No hay eventos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if ($totalPaginas > 1)
                <div class="as-pagination">
                    <div class="as-pag-info">
                        Página {{ $pagina }} de {{ $totalPaginas }} · {{ $logs['total'] }} registros
                    </div>
                    <div class="as-pag-btns">
                        <button class="as-pag-btn" wire:click="paginaAnterior" @disabled($pagina <= 1)>‹</button>

                        @php
                            $inicio = max(1, $pagina - 2);
                            $fin = min($totalPaginas, $pagina + 2);
                        @endphp

                        @if ($inicio > 1)
                            <button class="as-pag-btn" wire:click="irAPagina(1)">1</button>
                            @if ($inicio > 2)
                                <span style="color:var(--w-muted); padding:0 .25rem; line-height:30px;">…</span>
                            @endif
                        @endif

                        @for ($i = $inicio; $i <= $fin; $i++)
                            <button class="as-pag-btn {{ $pagina == $i ? 'activo' : '' }}"
                                wire:click="irAPagina({{ $i }})">{{ $i }}</button>
                        @endfor

                        @if ($fin < $totalPaginas)
                            @if ($fin < $totalPaginas - 1)
                                <span style="color:var(--w-muted); padding:0 .25rem; line-height:30px;">…</span>
                            @endif
                            <button class="as-pag-btn"
                                wire:click="irAPagina({{ $totalPaginas }})">{{ $totalPaginas }}</button>
                        @endif

                        <button class="as-pag-btn" wire:click="paginaSiguiente({{ $totalPaginas }})"
                            @disabled($pagina >= $totalPaginas)>›</button>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-filament-panels::page>

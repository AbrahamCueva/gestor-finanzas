<x-filament-panels::page>
    @php
        $datos = $this->getDatos();
        $cuenta = $datos['cuenta'] ?? null;
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

        .rpc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .rpc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .rpc-section-title {
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

        .rpc-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        @media(max-width:768px) {
            .rpc-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .rpc-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .rpc-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .rpc-kpi-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--w-text);
        }

        .rpc-filtros {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .rpc-select {
            font-size: 0.85rem;
            padding: 0.5rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-text);
            outline: none;
            cursor: pointer;
        }

        .rpc-select:focus {
            border-color: #fbbf24;
        }

        .rpc-input {
            font-size: 0.85rem;
            padding: 0.5rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-text);
            outline: none;
        }

        .rpc-input:focus {
            border-color: #fbbf24;
        }

        .rpc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .rpc-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .rpc-table td {
            padding: 0.5rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
        }

        .rpc-table tr:last-child td {
            border-bottom: none;
        }

        .rpc-table tr:hover td {
            background: var(--w-card);
        }

        .rpc-badge {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .rpc-bar-row {
            margin-bottom: 0.625rem;
        }

        .rpc-bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            margin-bottom: 0.25rem;
        }

        .rpc-bar-track {
            height: 3px;
            background: var(--w-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .rpc-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: #fbbf24;
        }

        .rpc-cuenta-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }

        .rpc-cuenta-icon {
            font-size: 1.5rem;
        }

        .rpc-cuenta-nombre {
            font-size: 1rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .rpc-cuenta-tipo {
            font-size: 0.72rem;
            color: var(--w-muted);
            text-transform: capitalize;
        }

        .rpc-cuenta-saldo {
            font-size: 1.1rem;
            font-weight: 800;
            color: #fbbf24;
            margin-left: auto;
        }
    </style>

    <div class="rpc-wrap">

        <div class="rpc-card">
            <div class="rpc-filtros">
                <select wire:model.live="cuenta_id" class="rpc-select">
                    @foreach ($this->getCuentas() as $id => $nombre)
                        <option value="{{ $id }}">{{ $nombre }}</option>
                    @endforeach
                </select>
                <input type="date" wire:model.live="desde" class="rpc-input">
                <input type="date" wire:model.live="hasta" class="rpc-input">
            </div>
        </div>

        @if ($cuenta)

            <div class="rpc-card">
                <div class="rpc-cuenta-header">
                    <div class="rpc-cuenta-icon">🏦</div>
                    <div>
                        <div class="rpc-cuenta-nombre">{{ $cuenta->nombre }}</div>
                        <div class="rpc-cuenta-tipo">{{ $cuenta->tipo_cuenta }} · {{ $cuenta->moneda }}</div>
                    </div>
                    <div class="rpc-cuenta-saldo">S/ {{ number_format($cuenta->saldo_actual, 2) }}</div>
                </div>

                <div class="rpc-grid-4">
                    <div class="rpc-kpi">
                        <div class="rpc-kpi-label">Ingresos</div>
                        <div class="rpc-kpi-value" style="color:#22c55e;">S/
                            {{ number_format($datos['totalIngresos'], 2) }}</div>
                    </div>
                    <div class="rpc-kpi">
                        <div class="rpc-kpi-label">Egresos</div>
                        <div class="rpc-kpi-value" style="color:#ef4444;">S/
                            {{ number_format($datos['totalEgresos'], 2) }}</div>
                    </div>
                    <div class="rpc-kpi">
                        <div class="rpc-kpi-label">Transf. salida</div>
                        <div class="rpc-kpi-value" style="color:#f97316;">S/
                            {{ number_format($datos['totalTransfSalida'], 2) }}</div>
                    </div>
                    <div class="rpc-kpi">
                        <div class="rpc-kpi-label">Transf. entrada</div>
                        <div class="rpc-kpi-value" style="color:#60a5fa;">S/
                            {{ number_format($datos['totalTransfEntrada'], 2) }}</div>
                    </div>
                </div>
            </div>

            @if ($datos['gastosPorCategoria']->count())
                <div class="rpc-card">
                    <div class="rpc-section-title">📊 Gastos por categoría</div>
                    @foreach ($datos['gastosPorCategoria'] as $cat => $total)
                        @php $pct = $datos['totalEgresos'] > 0 ? round(($total / $datos['totalEgresos']) * 100, 1) : 0; @endphp
                        <div class="rpc-bar-row">
                            <div class="rpc-bar-label">
                                <span>{{ $cat }}</span>
                                <span style="font-weight:600;">S/ {{ number_format($total, 2) }}
                                    ({{ $pct }}%)</span>
                            </div>
                            <div class="rpc-bar-track">
                                <div class="rpc-bar-fill" style="width:{{ $pct }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="rpc-card">
                <div class="rpc-section-title">💸 Movimientos ({{ $datos['movimientos']->count() }})</div>
                @if ($datos['movimientos']->count())
                    <div style="overflow-x:auto;">
                        <table class="rpc-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                    <th style="text-align:right;">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datos['movimientos'] as $m)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="rpc-badge"
                                                style="background:{{ $m->tipo_movimiento === 'ingreso' ? 'rgba(34,197,94,0.12)' : 'rgba(239,68,68,0.12)' }}; color:{{ $m->tipo_movimiento === 'ingreso' ? '#22c55e' : '#ef4444' }};">
                                                {{ ucfirst($m->tipo_movimiento) }}
                                            </span>
                                        </td>
                                        <td style="color:var(--w-muted);">{{ $m->categoria?->nombre ?? '—' }}</td>
                                        <td style="color:var(--w-muted);">{{ $m->descripcion ?: '—' }}</td>
                                        <td
                                            style="text-align:right; font-weight:600; color:{{ $m->tipo_movimiento === 'ingreso' ? '#22c55e' : '#ef4444' }};">
                                            {{ $m->tipo_movimiento === 'ingreso' ? '+' : '-' }}S/
                                            {{ number_format($m->monto, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align:center; color:var(--w-muted); padding:2rem; font-size:0.825rem;">
                        Sin movimientos en este período
                    </div>
                @endif
            </div>

            @if ($datos['transferenciasOrigen']->count() || $datos['transferenciasDestino']->count())
                <div class="rpc-card">
                    <div class="rpc-section-title">🔁 Transferencias</div>
                    <div style="overflow-x:auto;">
                        <table class="rpc-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Cuenta</th>
                                    <th>Descripción</th>
                                    <th style="text-align:right;">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datos['transferenciasOrigen'] as $t)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($t->fecha)->format('d/m/Y') }}</td>
                                        <td><span class="rpc-badge"
                                                style="background:rgba(249,115,22,0.12); color:#f97316;">Salida</span>
                                        </td>
                                        <td style="color:var(--w-muted);">→ {{ $t->cuentaDestino?->nombre }}</td>
                                        <td style="color:var(--w-muted);">{{ $t->descripcion ?: '—' }}</td>
                                        <td style="text-align:right; font-weight:600; color:#f97316;">-S/
                                            {{ number_format($t->monto, 2) }}</td>
                                    </tr>
                                @endforeach
                                @foreach ($datos['transferenciasDestino'] as $t)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($t->fecha)->format('d/m/Y') }}</td>
                                        <td><span class="rpc-badge"
                                                style="background:rgba(96,165,250,0.12); color:#60a5fa;">Entrada</span>
                                        </td>
                                        <td style="color:var(--w-muted);">← {{ $t->cuentaOrigen?->nombre }}</td>
                                        <td style="color:var(--w-muted);">{{ $t->descripcion ?: '—' }}</td>
                                        <td style="text-align:right; font-weight:600; color:#60a5fa;">+S/
                                            {{ number_format($t->monto, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @else
            <div style="text-align:center; color:var(--w-muted); padding:3rem; font-size:0.875rem;">
                Selecciona una cuenta para ver el reporte.
            </div>
        @endif

    </div>
</x-filament-panels::page>

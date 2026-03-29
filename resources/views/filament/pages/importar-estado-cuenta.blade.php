<x-filament-panels::page>
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

        .iec-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .iec-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .iec-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .iec-select,
        .iec-input-sel {
            font-size: 0.85rem;
            padding: 0.5rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-text);
            outline: none;
            cursor: pointer;
        }

        .iec-select:focus {
            border-color: #fbbf24;
        }

        .iec-bancos {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        @media(max-width:640px) {
            .iec-bancos {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .iec-banco-btn {
            padding: 0.5rem;
            border-radius: 0.625rem;
            border: 1.5px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-muted);
            cursor: pointer;
            font-size: 0.775rem;
            font-weight: 600;
            text-align: center;
            transition: all 0.15s;
        }

        .iec-banco-btn:hover {
            border-color: rgba(251, 191, 36, 0.3);
            color: #fbbf24;
        }

        .iec-banco-btn.activo {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.08);
            color: #fbbf24;
        }

        .iec-dropzone {
            border: 2px dashed var(--w-border);
            border-radius: 0.875rem;
            padding: 2.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .iec-dropzone:hover,
        .iec-dropzone.drag-over {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.05);
        }

        .iec-dz-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .iec-dz-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--w-text);
            margin-bottom: 0.25rem;
        }

        .iec-dz-sub {
            font-size: 0.75rem;
            color: var(--w-muted);
        }

        .iec-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.8rem;
            color: #ef4444;
        }

        .iec-stats {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .iec-stat {
            background: var(--w-card);
            border-radius: 0.625rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .iec-stat-num {
            font-weight: 800;
            font-size: 1rem;
        }

        .iec-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .iec-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
        }

        .iec-table td {
            padding: 0.5rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
            vertical-align: middle;
        }

        .iec-table tr:last-child td {
            border-bottom: none;
        }

        .iec-table tr:hover td {
            background: var(--w-card);
        }

        .iec-table tr.excluido td {
            opacity: 0.4;
        }

        .iec-badge {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .iec-badge-ing {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .iec-badge-egr {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .iec-toggle {
            width: 32px;
            height: 18px;
            border-radius: 99px;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }

        .iec-toggle.on {
            background: #22c55e;
        }

        .iec-toggle.off {
            background: rgba(107, 114, 128, 0.3);
        }

        .iec-toggle::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: white;
            top: 3px;
            transition: left 0.2s;
        }

        .iec-toggle.on::after {
            left: 17px;
        }

        .iec-toggle.off::after {
            left: 3px;
        }

        .iec-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .iec-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.25rem;
            border-radius: 0.625rem;
            font-size: 0.825rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .iec-btn:hover {
            opacity: 0.85;
        }

        .iec-btn-primary {
            background: #fbbf24;
            color: #0f172a;
        }

        .iec-btn-secondary {
            background: var(--w-card);
            color: var(--w-muted);
        }

        .iec-info {
            background: rgba(96, 165, 250, 0.08);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            line-height: 1.5;
            display: flex;
            gap: 0.625rem;
        }

        .iec-info svg {
            width: 16px;
            height: 16px;
            color: #60a5fa;
            flex-shrink: 0;
            margin-top: 1px;
        }
    </style>

    <div class="iec-wrap">

        <div class="iec-info">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            Sube el PDF de tu estado de cuenta y el sistema extraerá los movimientos automáticamente. Revisa la vista
            previa antes de confirmar. La categoría se asigna automáticamente y puedes cambiarla después.
        </div>

        @if (!$preview)
            <div class="iec-card">
                <div class="iec-title">⚙️ Configuración</div>

                <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;">
                    <div>
                        <div
                            style="font-size:0.65rem; color:var(--w-muted); margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.05em;">
                            Cuenta destino</div>
                        <select wire:model="cuenta_id" class="iec-select">
                            @foreach ($this->getCuentas() as $id => $nombre)
                                <option value="{{ $id }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div
                    style="font-size:0.65rem; color:var(--w-muted); margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.05em;">
                    Banco / App</div>
                <div class="iec-bancos">
                    @foreach ($this->getBancos() as $key => $label)
                        <button class="iec-banco-btn {{ $banco === $key ? 'activo' : '' }}"
                            wire:click="$set('banco', '{{ $key }}')">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                @if ($error)
                    <div class="iec-error" style="margin-bottom:1rem;">⚠️ {{ $error }}</div>
                @endif

                <div class="iec-dropzone" id="iecDropzone" onclick="document.getElementById('iecInput').click()">
                    <div class="iec-dz-icon">📄</div>
                    <div class="iec-dz-title">Arrastra tu PDF aquí o haz click para seleccionar</div>
                    <div class="iec-dz-sub">Solo archivos .pdf — estado de cuenta del banco seleccionado</div>
                    <input type="file" id="iecInput" accept=".pdf" style="display:none" onchange="leerPdf(event)">
                </div>
            </div>
        @endif

        @if ($preview)
            <div class="iec-card">
                <div class="iec-title">👁️ Vista previa — {{ $totalMovs }} movimientos detectados</div>

                @php
                    $incluidos = collect($preview)->where('incluir', true)->count();
                    $excluidos = $totalMovs - $incluidos;
                    $totalIng = collect($preview)->where('incluir', true)->where('tipo', 'ingreso')->sum('monto');
                    $totalEgr = collect($preview)->where('incluir', true)->where('tipo', 'egreso')->sum('monto');
                @endphp

                <div class="iec-stats">
                    <div class="iec-stat">
                        <span class="iec-stat-num" style="color:#22c55e;">{{ $incluidos }}</span>
                        <span style="color:var(--w-muted);">a importar</span>
                    </div>
                    <div class="iec-stat">
                        <span class="iec-stat-num" style="color:#6b7280;">{{ $excluidos }}</span>
                        <span style="color:var(--w-muted);">excluidos</span>
                    </div>
                    <div class="iec-stat">
                        <span class="iec-stat-num" style="color:#22c55e;">+S/ {{ number_format($totalIng, 2) }}</span>
                    </div>
                    <div class="iec-stat">
                        <span class="iec-stat-num" style="color:#ef4444;">-S/ {{ number_format($totalEgr, 2) }}</span>
                    </div>
                </div>

                <div style="overflow-x:auto; max-height:400px; overflow-y:auto;">
                    <table class="iec-table">
                        <thead>
                            <tr>
                                <th>✓</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th style="text-align:right;">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preview as $i => $mov)
                                <tr class="{{ !$mov['incluir'] ? 'excluido' : '' }}">
                                    <td>
                                        <button class="iec-toggle {{ $mov['incluir'] ? 'on' : 'off' }}"
                                            wire:click="toggleIncluir({{ $i }})">
                                        </button>
                                    </td>
                                    <td style="white-space:nowrap; color:var(--w-muted);">
                                        {{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y') }}
                                    </td>
                                    <td style="max-width:250px;">{{ $mov['descripcion'] }}</td>
                                    <td>
                                        <span
                                            class="iec-badge {{ $mov['tipo'] === 'ingreso' ? 'iec-badge-ing' : 'iec-badge-egr' }}">
                                            {{ ucfirst($mov['tipo']) }}
                                        </span>
                                    </td>
                                    <td
                                        style="text-align:right; font-weight:600; color:{{ $mov['tipo'] === 'ingreso' ? '#22c55e' : '#ef4444' }};">
                                        {{ $mov['tipo'] === 'ingreso' ? '+' : '-' }}S/
                                        {{ number_format($mov['monto'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="iec-actions">
                    <button class="iec-btn iec-btn-secondary" wire:click="cancelar">
                        ✕ Cancelar
                    </button>
                    @if ($listo && $incluidos > 0)
                        <button class="iec-btn iec-btn-primary" wire:click="confirmarImportacion"
                            wire:confirm="¿Importar {{ $incluidos }} movimientos a la cuenta seleccionada?">
                            ⬇️ Importar {{ $incluidos }} movimientos
                        </button>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <script>
        function leerPdf(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => {
                const base64 = e.target.result.split(',')[1];
                @this.call('procesarPdf', base64);
            };
            reader.readAsDataURL(file);
        }

        const dz = document.getElementById('iecDropzone');
        if (dz) {
            dz.addEventListener('dragover', e => {
                e.preventDefault();
                dz.classList.add('drag-over');
            });
            dz.addEventListener('dragleave', () => dz.classList.remove('drag-over'));
            dz.addEventListener('drop', e => {
                e.preventDefault();
                dz.classList.remove('drag-over');
                const file = e.dataTransfer.files[0];
                if (file && file.type === 'application/pdf') {
                    const reader = new FileReader();
                    reader.onload = ev => {
                        const base64 = ev.target.result.split(',')[1];
                        @this.call('procesarPdf', base64);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
</x-filament-panels::page>

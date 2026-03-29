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

        .im-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .im-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .im-section-title {
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

        .im-section-title svg {
            width: 13px;
            height: 13px;
        }

        /* Drop zone */
        .im-dropzone {
            border: 2px dashed var(--w-border);
            border-radius: 0.875rem;
            padding: 2.5rem 1.5rem;
            text-align: center;
            transition: border-color 0.2s, background 0.2s;
            cursor: pointer;
        }

        .im-dropzone:hover,
        .im-dropzone.drag-over {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.05);
        }

        .im-dropzone-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .im-dropzone-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--w-text);
            margin-bottom: 0.25rem;
        }

        .im-dropzone-sub {
            font-size: 0.75rem;
            color: var(--w-muted);
        }

        .im-dropzone input[type=file] {
            display: none;
        }

        /* Stats */
        .im-stats {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .im-stat {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem;
            border-radius: 0.625rem;
            background: var(--w-card);
            font-size: 0.8rem;
        }

        .im-stat-num {
            font-weight: 800;
            font-size: 1rem;
        }

        /* Tabla preview */
        .im-table-wrap {
            overflow-x: auto;
        }

        .im-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .im-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.625rem;
            border-bottom: 1px solid var(--w-border);
            text-align: left;
            white-space: nowrap;
        }

        .im-table td {
            padding: 0.5rem 0.625rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
            vertical-align: middle;
        }

        .im-table tr:last-child td {
            border-bottom: none;
        }

        .im-table tr.im-row-ok:hover td {
            background: var(--w-card);
        }

        .im-table tr.im-row-err td {
            background: rgba(239, 68, 68, 0.05);
        }

        .im-fila-num {
            font-size: 0.65rem;
            color: var(--w-muted);
        }

        .im-badge {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .im-err-list {
            font-size: 0.68rem;
            color: #ef4444;
            margin-top: 0.2rem;
        }

        /* Botones */
        .im-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .im-btn {
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

        .im-btn:hover {
            opacity: 0.85;
        }

        .im-btn-primary {
            background: #fbbf24;
            color: #0f172a;
        }

        .im-btn-secondary {
            background: var(--w-card);
            color: var(--w-muted);
        }

        /* Columnas requeridas */
        .im-cols-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
        }

        @media(max-width:768px) {
            .im-cols-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .im-col-item {
            background: var(--w-card);
            border-radius: 0.5rem;
            padding: 0.625rem 0.75rem;
        }

        .im-col-name {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--w-text);
            font-family: monospace;
        }

        .im-col-desc {
            font-size: 0.68rem;
            color: var(--w-muted);
            margin-top: 0.15rem;
        }

        .im-col-req {
            font-size: 0.6rem;
            font-weight: 700;
            margin-top: 0.25rem;
        }
    </style>

    <div class="im-wrap">

        @if (empty($preview))
            <div class="im-card">
                <div class="im-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Subir archivo CSV
                </div>

                <div class="im-dropzone" id="dropzone" onclick="document.getElementById('csvInput').click()">
                    <div class="im-dropzone-title">Arrastra tu CSV aquí o haz click para seleccionar</div>
                    <div class="im-dropzone-sub">Solo archivos .csv — máx. 2MB</div>
                    <input type="file" id="csvInput" accept=".csv" onchange="leerCsv(event)">
                </div>
            </div>

            <div class="im-card">
                <div class="im-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                    </svg>
                    Formato del CSV
                </div>
                <div class="im-cols-grid">
                    @foreach ([['fecha', 'Fecha del movimiento', 'YYYY-MM-DD', true], ['tipo_movimiento', 'ingreso o egreso', 'ingreso/egreso', true], ['monto', 'Monto en soles', 'ej: 150.00', true], ['cuenta', 'Nombre exacto de la cuenta', 'ej: Cuenta Principal', true], ['categoria', 'Nombre exacto de categoría', 'ej: Alimentación', true], ['subcategoria', 'Nombre de subcategoría', 'ej: Restaurantes', false], ['descripcion', 'Descripción del movimiento', 'ej: Almuerzo', false], ['referencia', 'Referencia o código', 'ej: TRX-001', false], ['es_recurrente', '1 si es recurrente, 0 si no', '0 o 1', false]] as [$col, $desc, $ejemplo, $req])
                        <div class="im-col-item">
                            <div class="im-col-name">{{ $col }}</div>
                            <div class="im-col-desc">{{ $desc }}</div>
                            <div class="im-col-desc" style="font-style:italic;">ej: {{ $ejemplo }}</div>
                            <div class="im-col-req" style="color:{{ $req ? '#ef4444' : '#22c55e' }};">
                                {{ $req ? '* Requerido' : 'Opcional' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if (!empty($preview))
            <div class="im-card">
                <div class="im-section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Vista previa — {{ $totalFilas }} filas detectadas
                </div>

                <div class="im-stats">
                    <div class="im-stat">
                        <span class="im-stat-num" style="color:#22c55e;">{{ $filasValidas }}</span>
                        <span style="color:var(--w-muted);">filas válidas</span>
                    </div>
                    <div class="im-stat">
                        <span class="im-stat-num" style="color:#ef4444;">{{ $totalFilas - $filasValidas }}</span>
                        <span style="color:var(--w-muted);">con errores</span>
                    </div>
                    <div class="im-stat">
                        <span class="im-stat-num" style="color:var(--w-text);">{{ $totalFilas }}</span>
                        <span style="color:var(--w-muted);">total</span>
                    </div>
                </div>

                <div class="im-table-wrap">
                    <table class="im-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                                <th>Cuenta</th>
                                <th>Categoría</th>
                                <th>Subcategoría</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preview as $row)
                                <tr class="{{ $row['valido'] ? 'im-row-ok' : 'im-row-err' }}">
                                    <td><span class="im-fila-num">{{ $row['fila'] }}</span></td>
                                    <td>{{ $row['fecha'] }}</td>
                                    <td>
                                        <span class="im-badge"
                                            style="background:{{ $row['tipo'] === 'ingreso' ? 'rgba(34,197,94,0.12)' : 'rgba(239,68,68,0.12)' }}; color:{{ $row['tipo'] === 'ingreso' ? '#22c55e' : '#ef4444' }};">
                                            {{ $row['tipo'] }}
                                        </span>
                                    </td>
                                    <td style="font-weight:600;">S/ {{ number_format($row['monto'], 2) }}</td>
                                    <td>{{ $row['cuenta'] }}</td>
                                    <td>{{ $row['categoria'] }}</td>
                                    <td style="color:var(--w-muted);">{{ $row['subcategoria'] ?: '—' }}</td>
                                    <td style="color:var(--w-muted);">{{ $row['descripcion'] ?: '—' }}</td>
                                    <td>
                                        @if ($row['valido'])
                                            <span class="im-badge"
                                                style="background:rgba(34,197,94,0.12); color:#22c55e;">✓ OK</span>
                                        @else
                                            <span class="im-badge"
                                                style="background:rgba(239,68,68,0.12); color:#ef4444;">✗ Error</span>
                                            <div class="im-err-list">{{ implode(', ', $row['errores']) }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="im-actions">
                    <button class="im-btn im-btn-secondary" wire:click="cancelar">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            style="width:14px;height:14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                    @if ($listo)
                        <button class="im-btn im-btn-primary" wire:click="confirmarImportacion"
                            wire:confirm="¿Importar {{ $filasValidas }} movimientos válidos?">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                style="width:14px;height:14px;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12M12 16.5V3" />
                            </svg>
                            Importar {{ $filasValidas }} movimientos
                        </button>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <script>
        function leerCsv(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const contenido = e.target.result;
                @this.call('procesarArchivo', contenido);
            };
            reader.readAsText(file, 'UTF-8');
        }

        const dz = document.getElementById('dropzone');
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
                if (file) {
                    const reader = new FileReader();
                    reader.onload = ev => @this.call('procesarArchivo', ev.target.result);
                    reader.readAsText(file, 'UTF-8');
                }
            });
        }
    </script>
</x-filament-panels::page>

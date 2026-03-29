<x-filament-panels::page>
    @php $notas = $this->getNotas(); @endphp

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

        .nf-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Barra búsqueda */
        .nf-toolbar {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .nf-search {
            flex: 1;
            min-width: 200px;
            background: var(--w-bg);
            border: 1px solid var(--w-border);
            border-radius: 0.625rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.85rem;
            color: var(--w-text);
            outline: none;
            transition: border-color 0.15s;
        }

        .nf-search:focus {
            border-color: #fbbf24;
        }

        .nf-tipo-btns {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
        }

        .nf-tipo-btn {
            padding: 0.35rem 0.875rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-bg);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .nf-tipo-btn.activo {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
        }

        .nf-tipo-btn:hover {
            opacity: 0.8;
        }

        /* Grid notas */
        .nf-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 0.875rem;
        }

        .nf-nota {
            border-radius: 0.875rem;
            padding: 1rem 1.125rem;
            border: 1.5px solid transparent;
            position: relative;
            transition: transform 0.15s, box-shadow 0.15s;
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
            min-height: 140px;
        }

        .nf-nota:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .nf-nota.fijada {
            border-style: solid;
        }

        .nf-nota-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .nf-nota-titulo {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--w-text);
            flex: 1;
            line-height: 1.3;
        }

        .nf-nota-acciones {
            display: flex;
            gap: 0.25rem;
            opacity: 0;
            transition: opacity 0.15s;
            flex-shrink: 0;
        }

        .nf-nota:hover .nf-nota-acciones {
            opacity: 1;
        }

        .nf-accion-btn {
            width: 26px;
            height: 26px;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.1);
            color: var(--w-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            transition: all 0.15s;
        }

        .nf-accion-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--w-text);
        }

        .nf-nota-contenido {
            font-size: 0.78rem;
            color: var(--w-muted);
            line-height: 1.5;
            flex: 1;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }

        .nf-nota-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            margin-top: auto;
        }

        .nf-nota-tipo {
            font-size: 0.62rem;
            font-weight: 600;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--w-muted);
        }

        .nf-nota-fecha {
            font-size: 0.62rem;
            color: var(--w-muted);
        }

        .nf-pin {
            font-size: 0.75rem;
        }

        .nf-recordar {
            font-size: 0.68rem;
            color: #60a5fa;
            background: rgba(96, 165, 250, 0.1);
            border-radius: 0.375rem;
            padding: 0.2rem 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nf-empty {
            text-align: center;
            color: var(--w-muted);
            padding: 4rem 2rem;
            font-size: 0.875rem;
            grid-column: 1/-1;
        }

        .nf-empty-icon {
            font-size: 3rem;
            margin-bottom: 0.75rem;
        }

        /* Modal editar */
        .nf-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9990;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            display: none;
        }

        .nf-modal-overlay.abierto {
            display: flex;
        }

        .nf-modal {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
            padding: 1.5rem;
            width: 100%;
            max-width: 480px;
            animation: modalIn 0.2s ease;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.96);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .nf-modal-titulo {
            font-size: 0.875rem;
            font-weight: 700;
            color: #f9fafb;
            margin-bottom: 1rem;
        }

        .nf-modal-field {
            margin-bottom: 0.875rem;
        }

        .nf-modal-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            margin-bottom: 0.35rem;
            display: block;
        }

        .nf-modal-input,
        .nf-modal-textarea,
        .nf-modal-select {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.625rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.85rem;
            color: #f9fafb;
            outline: none;
            transition: border-color 0.15s;
        }

        .nf-modal-input:focus,
        .nf-modal-textarea:focus,
        .nf-modal-select:focus {
            border-color: #fbbf24;
        }

        .nf-modal-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .nf-modal-btns {
            display: flex;
            gap: 0.625rem;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .nf-modal-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 0.625rem;
            font-size: 0.825rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .nf-modal-btn:hover {
            opacity: 0.85;
        }

        .nf-modal-btn-primary {
            background: #fbbf24;
            color: #0f172a;
        }

        .nf-modal-btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: #9ca3af;
        }
    </style>

    {{-- Modal editar --}}
    <div class="nf-modal-overlay" id="nfModalOverlay">
        <div class="nf-modal">
            <div class="nf-modal-titulo">✏️ Editar nota</div>
            <input type="hidden" id="nfEditId">

            <div class="nf-modal-field">
                <label class="nf-modal-label">Título</label>
                <input type="text" id="nfEditTitulo" class="nf-modal-input" placeholder="Título de la nota">
            </div>
            <div class="nf-modal-field">
                <label class="nf-modal-label">Tipo</label>
                <select id="nfEditTipo" class="nf-modal-select">
                    <option value="nota">📝 Nota</option>
                    <option value="recordatorio">⏰ Recordatorio</option>
                    <option value="idea">💡 Idea</option>
                </select>
            </div>
            <div class="nf-modal-field">
                <label class="nf-modal-label">Contenido</label>
                <textarea id="nfEditContenido" class="nf-modal-textarea" placeholder="Contenido..."></textarea>
            </div>
            <div class="nf-modal-field">
                <label class="nf-modal-label">Color</label>
                <input type="color" id="nfEditColor"
                    style="width:60px; height:36px; border-radius:0.5rem; border:none; cursor:pointer; background:transparent;">
            </div>

            <div class="nf-modal-btns">
                <button class="nf-modal-btn nf-modal-btn-secondary" onclick="cerrarModal()">Cancelar</button>
                <button class="nf-modal-btn nf-modal-btn-primary" onclick="guardarEdicion()">Guardar</button>
            </div>
        </div>
    </div>

    <div class="nf-wrap">

        {{-- Toolbar --}}
        <div class="nf-toolbar">
            <input type="text" wire:model.live="buscar" class="nf-search" placeholder="🔍 Buscar notas...">

            <div class="nf-tipo-btns">
                @foreach (['' => 'Todas', 'nota' => '📝 Notas', 'recordatorio' => '⏰ Recordatorios', 'idea' => '💡 Ideas'] as $val => $label)
                    <button class="nf-tipo-btn {{ $filtroTipo === $val ? 'activo' : '' }}"
                        wire:click="$set('filtroTipo', '{{ $val }}')">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Grid --}}
        <div class="nf-grid">
            @forelse($notas as $nota)
                @php
                    $bgColor = $nota->color . '18';
                    $borderColor = $nota->color . '44';
                @endphp
                <div class="nf-nota {{ $nota->fijada ? 'fijada' : '' }}"
                    style="background:{{ $bgColor }}; border-color:{{ $borderColor }};">

                    <div class="nf-nota-header">
                        <div class="nf-nota-titulo">
                            @if ($nota->fijada)
                                <span class="nf-pin">📌</span>
                            @endif
                            {{ $nota->titulo }}
                        </div>
                        <div class="nf-nota-acciones">
                            <button class="nf-accion-btn"
                                onclick="abrirEditar({{ $nota->id }}, '{{ addslashes($nota->titulo) }}', '{{ $nota->tipo }}', '{{ addslashes($nota->contenido ?? '') }}', '{{ $nota->color }}')"
                                title="Editar">✏️</button>
                            <button class="nf-accion-btn" wire:click="toggleFijada({{ $nota->id }})"
                                title="{{ $nota->fijada ? 'Desfijar' : 'Fijar' }}">
                                {{ $nota->fijada ? '📌' : '📍' }}
                            </button>
                            <button class="nf-accion-btn" wire:click="eliminarNota({{ $nota->id }})"
                                wire:confirm="¿Eliminar esta nota?" title="Eliminar" style="color:#ef4444;">🗑️</button>
                        </div>
                    </div>

                    @if ($nota->contenido)
                        <div class="nf-nota-contenido">{{ $nota->contenido }}</div>
                    @endif

                    @if ($nota->recordar_en)
                        <div class="nf-recordar">
                            ⏰ {{ $nota->recordar_en->format('d/m/Y H:i') }}
                        </div>
                    @endif

                    <div class="nf-nota-footer">
                        <span class="nf-nota-tipo">{{ $nota->tipo_emoji }} {{ ucfirst($nota->tipo) }}</span>
                        <span class="nf-nota-fecha">{{ $nota->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="nf-empty">
                    <div class="nf-empty-icon">📝</div>
                    <div>No hay notas todavía.</div>
                    <div style="font-size:0.75rem; margin-top:0.375rem;">Crea tu primera nota con el botón de arriba.
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

        function abrirEditar(id, titulo, tipo, contenido, color) {
            document.getElementById('nfEditId').value = id;
            document.getElementById('nfEditTitulo').value = titulo;
            document.getElementById('nfEditTipo').value = tipo;
            document.getElementById('nfEditContenido').value = contenido;
            document.getElementById('nfEditColor').value = color || '#fbbf24';
            document.getElementById('nfModalOverlay').classList.add('abierto');
        }

        function cerrarModal() {
            document.getElementById('nfModalOverlay').classList.remove('abierto');
        }

        async function guardarEdicion() {
            const id = document.getElementById('nfEditId').value;
            const titulo = document.getElementById('nfEditTitulo').value;
            const tipo = document.getElementById('nfEditTipo').value;
            const contenido = document.getElementById('nfEditContenido').value;
            const color = document.getElementById('nfEditColor').value;

            await fetch(`/ricox/notas/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify({
                    titulo,
                    tipo,
                    contenido,
                    color
                }),
            });

            cerrarModal();
            window.Livewire?.all().forEach(c => {
                try {
                    c.$wire.call('$refresh');
                } catch (e) {}
            });
        }

        // Cerrar modal al hacer click fuera
        document.getElementById('nfModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>
</x-filament-panels::page>

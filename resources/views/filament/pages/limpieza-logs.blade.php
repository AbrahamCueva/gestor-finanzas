<x-filament-panels::page>
    @php $est = $this->getEstadisticas(); @endphp

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

        .ll-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ll-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .ll-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .ll-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.875rem;
        }

        @media(max-width:640px) {
            .ll-grid {
                grid-template-columns: 1fr;
            }
        }

        .ll-tabla-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            border: 1.5px solid var(--w-border);
        }

        .ll-tabla-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.875rem;
        }

        .ll-tabla-nombre {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ll-tabla-emoji {
            font-size: 1.25rem;
        }

        .ll-stats {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .ll-stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ll-stat-label {
            font-size: 0.72rem;
            color: var(--w-muted);
        }

        .ll-stat-value {
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--w-text);
        }

        .ll-a-eliminar {
            background: rgba(239, 68, 68, 0.08);
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ll-a-eliminar-label {
            font-size: 0.72rem;
            color: #ef4444;
            font-weight: 600;
        }

        .ll-a-eliminar-value {
            font-size: 1rem;
            font-weight: 800;
            color: #ef4444;
        }

        .ll-config {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.875rem;
        }

        @media(max-width:640px) {
            .ll-config {
                grid-template-columns: 1fr;
            }
        }

        .ll-field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .ll-label {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
        }

        .ll-input {
            background: var(--w-card);
            border: 1px solid var(--w-border);
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            color: var(--w-text);
            outline: none;
            transition: border-color 0.15s;
            width: 100%;
        }

        .ll-input:focus {
            border-color: #fbbf24;
        }

        .ll-opciones {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 0.25rem;
        }

        .ll-opcion-btn {
            padding: 0.2rem 0.625rem;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .ll-opcion-btn:hover {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .ll-info {
            background: rgba(96, 165, 250, 0.08);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            line-height: 1.5;
            display: flex;
            gap: 0.625rem;
        }

        .ll-info svg {
            width: 16px;
            height: 16px;
            color: #60a5fa;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .ll-schedule {
            background: rgba(34, 197, 94, 0.08);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            line-height: 1.5;
            display: flex;
            gap: 0.625rem;
            align-items: flex-start;
        }

        .ll-schedule svg {
            width: 16px;
            height: 16px;
            color: #22c55e;
            flex-shrink: 0;
            margin-top: 1px;
        }
    </style>

    <div class="ll-wrap">

        <div class="ll-info">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            Los logs de actividad y seguridad se acumulan con el tiempo. Esta herramienta te permite eliminar los
            registros más antiguos para mantener la base de datos limpia y eficiente.
        </div>

        <div class="ll-schedule">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            La limpieza automática corre el <strong>día 1 de cada mes a las 3:00 AM</strong> con los valores por defecto
            (90 días actividad, 180 días seguridad). Asegúrate de tener el scheduler de Laravel activo.
        </div>

        <div class="ll-card">
            <div class="ll-title">📊 Estado actual</div>
            <div class="ll-grid">

                <div class="ll-tabla-card">
                    <div class="ll-tabla-header">
                        <div class="ll-tabla-nombre">Activity Logs</div>
                        <span class="ll-tabla-emoji">📋</span>
                    </div>
                    <div class="ll-stats">
                        <div class="ll-stat-row">
                            <span class="ll-stat-label">Total registros</span>
                            <span class="ll-stat-value">{{ number_format($est['totalActividad']) }}</span>
                        </div>
                        <div class="ll-stat-row">
                            <span class="ll-stat-label">Registro más antiguo</span>
                            <span class="ll-stat-value">{{ $est['masAntiguoActividad'] }}</span>
                        </div>
                    </div>
                    <div class="ll-a-eliminar">
                        <span class="ll-a-eliminar-label">A eliminar (> {{ $diasActividad }} días)</span>
                        <span class="ll-a-eliminar-value">{{ number_format($est['aEliminarActividad']) }}</span>
                    </div>
                </div>

                <div class="ll-tabla-card">
                    <div class="ll-tabla-header">
                        <div class="ll-tabla-nombre">Security Logs</div>
                        <span class="ll-tabla-emoji">🔒</span>
                    </div>
                    <div class="ll-stats">
                        <div class="ll-stat-row">
                            <span class="ll-stat-label">Total registros</span>
                            <span class="ll-stat-value">{{ number_format($est['totalSeguridad']) }}</span>
                        </div>
                        <div class="ll-stat-row">
                            <span class="ll-stat-label">Registro más antiguo</span>
                            <span class="ll-stat-value">{{ $est['masAntiguoSeguridad'] }}</span>
                        </div>
                    </div>
                    <div class="ll-a-eliminar">
                        <span class="ll-a-eliminar-label">A eliminar (> {{ $diasSeguridad }} días)</span>
                        <span class="ll-a-eliminar-value">{{ number_format($est['aEliminarSeguridad']) }}</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="ll-card">
            <div class="ll-title">⚙️ Configuración de limpieza</div>
            <div class="ll-config">
                <div class="ll-field">
                    <label class="ll-label">Conservar activity logs (días)</label>
                    <input type="number" class="ll-input" wire:model.live="diasActividad" min="7"
                        max="365">
                    <div class="ll-opciones">
                        @foreach ([30 => '30d', 60 => '60d', 90 => '90d', 180 => '6m', 365 => '1año'] as $val => $lbl)
                            <button class="ll-opcion-btn"
                                wire:click="$set('diasActividad', {{ $val }})">{{ $lbl }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="ll-field">
                    <label class="ll-label">Conservar security logs (días)</label>
                    <input type="number" class="ll-input" wire:model.live="diasSeguridad" min="7"
                        max="730">
                    <div class="ll-opciones">
                        @foreach ([90 => '90d', 180 => '6m', 365 => '1año', 730 => '2años'] as $val => $lbl)
                            <button class="ll-opcion-btn"
                                wire:click="$set('diasSeguridad', {{ $val }})">{{ $lbl }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>

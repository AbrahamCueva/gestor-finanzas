<x-filament-panels::page>
    @php $sesiones = $this->getSesiones(); @endphp

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

        .sa-wrap {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .sa-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .sa-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .sa-sesion {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1.5px solid transparent;
            transition: border-color 0.15s;
            flex-wrap: wrap;
        }

        .sa-sesion.actual {
            border-color: rgba(34, 197, 94, 0.3);
        }

        .sa-sesion-icon {
            width: 42px;
            height: 42px;
            border-radius: 0.75rem;
            background: var(--w-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .sa-sesion-info {
            flex: 1;
            min-width: 150px;
        }

        .sa-sesion-dispositivo {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--w-text);
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .sa-sesion-detalle {
            font-size: 0.7rem;
            color: var(--w-muted);
            margin-top: 0.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .sa-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .sa-badge-actual {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .sa-badge-inactivo {
            background: rgba(107, 114, 128, 0.12);
            color: #6b7280;
        }

        .sa-sesion-tiempo {
            font-size: 0.7rem;
            color: var(--w-muted);
            text-align: right;
            min-width: 100px;
        }

        .sa-cerrar-btn {
            padding: 0.35rem 0.875rem;
            border-radius: 0.5rem;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .sa-cerrar-btn:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .sa-info {
            background: rgba(96, 165, 250, 0.08);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.775rem;
            color: var(--w-text-soft);
            line-height: 1.5;
            display: flex;
            gap: 0.625rem;
        }

        .sa-info svg {
            width: 16px;
            height: 16px;
            color: #60a5fa;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .sa-empty {
            text-align: center;
            color: var(--w-muted);
            padding: 2rem;
            font-size: 0.875rem;
        }
    </style>

    <div class="sa-wrap">

        <div class="sa-info">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            Estas son todas las sesiones activas de tu cuenta. Si detectas una sesión desconocida, ciérrala
            inmediatamente y cambia tu contraseña.
        </div>

        <div class="sa-card">
            <div class="sa-title">
                🖥️ Sesiones activas — {{ $sesiones->count() }} dispositivo(s)
            </div>

            @forelse($sesiones as $sesion)
                <div class="sa-sesion {{ $sesion->actual ? 'actual' : '' }}" style="margin-bottom:0.625rem;">

                    <div class="sa-sesion-icon">
                        {{ $sesion->getIconoDispositivo() }}
                    </div>

                    <div class="sa-sesion-info">
                        <div class="sa-sesion-dispositivo">
                            {{ $sesion->dispositivo }}
                            @if ($sesion->actual)
                                <span class="sa-badge sa-badge-actual">✓ Este dispositivo</span>
                            @endif
                        </div>
                        <div class="sa-sesion-detalle">
                            <span>{{ $sesion->getIconoNavegador() }} {{ $sesion->navegador }}</span>
                            <span>·</span>
                            <span>🌐 {{ $sesion->ip }}</span>
                            @if ($sesion->pais)
                                <span>·</span>
                                <span>📍 {{ $sesion->pais }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="sa-sesion-tiempo">
                        <div style="font-weight:600; color:var(--w-text); font-size:0.775rem;">
                            {{ $sesion->ultima_actividad->diffForHumans() }}
                        </div>
                        <div>{{ $sesion->ultima_actividad->format('d/m/Y H:i') }}</div>
                    </div>

                    @if (!$sesion->actual)
                        <button class="sa-cerrar-btn" wire:click="cerrarSesion({{ $sesion->id }})"
                            wire:confirm="¿Cerrar esta sesión?">
                            Cerrar sesión
                        </button>
                    @endif
                </div>
            @empty
                <div class="sa-empty">
                    No hay sesiones registradas aún.<br>
                    Se registrarán automáticamente con el uso.
                </div>
            @endforelse
        </div>

    </div>
</x-filament-panels::page>

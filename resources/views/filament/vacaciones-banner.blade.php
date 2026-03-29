@php $settings = \App\Models\Setting::first(); @endphp
@if ($settings?->vacaciones_activo)
    <div
        style="
    background:linear-gradient(135deg, rgba(251,191,36,0.12), rgba(249,115,22,0.08));
    border-bottom:1px solid rgba(251,191,36,0.2);
    padding:0.625rem 1.5rem;
    display:flex; align-items:center; gap:0.75rem;
    font-size:0.8rem; color:#fbbf24; flex-wrap:wrap;
">
        <span style="font-size:1.1rem;">🏖️</span>
        <span style="font-weight:700;">Modo Vacaciones activo</span>
        @if ($settings->vacaciones_mensaje)
            <span style="color:#d97706;">— {{ $settings->vacaciones_mensaje }}</span>
        @endif
        @if ($settings->vacaciones_fin)
            <span style="color:#6b7280; margin-left:auto; font-size:0.72rem;">
                Regreso: {{ \Carbon\Carbon::parse($settings->vacaciones_fin)->format('d/m/Y') }}
            </span>
        @endif
        @if ($settings->vacaciones_pausar_presupuestos || $settings->vacaciones_pausar_notificaciones)
            <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                @if ($settings->vacaciones_pausar_presupuestos)
                    <span
                        style="background:rgba(251,191,36,0.1); padding:0.1rem 0.5rem; border-radius:99px; font-size:0.65rem; color:#fbbf24;">
                        ⏸ Presupuestos pausados
                    </span>
                @endif
                @if ($settings->vacaciones_pausar_recurrentes)
                    <span
                        style="background:rgba(251,191,36,0.1); padding:0.1rem 0.5rem; border-radius:99px; font-size:0.65rem; color:#fbbf24;">
                        ⏸ Recurrentes pausados
                    </span>
                @endif
                @if ($settings->vacaciones_pausar_notificaciones)
                    <span
                        style="background:rgba(251,191,36,0.1); padding:0.1rem 0.5rem; border-radius:99px; font-size:0.65rem; color:#fbbf24;">
                        ⏸ Notificaciones pausadas
                    </span>
                @endif
            </div>
        @endif
    </div>
@endif

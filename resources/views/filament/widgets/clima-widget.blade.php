<x-filament-widgets::widget>
    @php $c = $this->getClima(); @endphp

    <div style="
    background:linear-gradient(135deg, rgba(15,23,42,0.8), rgba(30,41,59,0.6));
    border:1px solid rgba(255,255,255,0.06);
    border-radius:0.875rem; padding:0.875rem 1.25rem;
    display:flex; align-items:center; gap:1.5rem; flex-wrap:wrap;
">
        <div style="font-size:2.5rem; flex-shrink:0;">{{ $c['emoji'] }}</div>

        <div style="flex:1;">
            <div style="font-size:0.62rem; color:#6b7280; text-transform:uppercase; letter-spacing:0.08em;">
                📍 {{ $c['ciudad'] }}
            </div>
            <div style="display:flex; align-items:baseline; gap:0.5rem; margin-top:0.1rem;">
                <span style="font-size:1.75rem; font-weight:900; color:#f9fafb;">{{ $c['temp'] }}°C</span>
                <span style="font-size:0.75rem; color:#6b7280;">Sensación {{ $c['sensacion'] }}°C</span>
            </div>
            <div style="font-size:0.75rem; color:#94a3b8;">{{ $c['descripcion'] }}</div>
        </div>

        <div style="display:flex; gap:1rem; flex-wrap:wrap;">
            <div style="text-align:center;">
                <div style="font-size:0.6rem; color:#6b7280; text-transform:uppercase;">Humedad</div>
                <div style="font-size:0.875rem; font-weight:700; color:#60a5fa;">{{ $c['humedad'] }}%</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:0.6rem; color:#6b7280; text-transform:uppercase;">Viento</div>
                <div style="font-size:0.875rem; font-weight:700; color:#34d399;">{{ $c['viento'] }} km/h</div>
            </div>
        </div>

        <div style="font-size:0.62rem; color:#4b5563; flex-shrink:0;">
            🔄 Actualiza cada 30 min
        </div>
    </div>
</x-filament-widgets::widget>
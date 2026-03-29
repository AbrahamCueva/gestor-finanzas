<x-filament-widgets::widget>
    @php
        $s = $this->getScore();
        $nivel = $s['nivel'];
    @endphp
    <div
        style="
    background:var(--fi-color-gray-950,#0f172a);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:0.875rem; padding:1rem 1.5rem;
    display:flex; align-items:center; gap:1.5rem; flex-wrap:wrap;
">
        <div style="position:relative; width:64px; height:64px; flex-shrink:0;">
            <svg width="64" height="64" viewBox="0 0 64 64" style="transform:rotate(-90deg);">
                <circle cx="32" cy="32" r="26" fill="none" stroke="rgba(255,255,255,0.08)"
                    stroke-width="5" />
                <circle cx="32" cy="32" r="26" fill="none" stroke="{{ $nivel['color'] }}"
                    stroke-width="5" stroke-linecap="round" stroke-dasharray="{{ round(2 * M_PI * 26, 2) }}"
                    stroke-dashoffset="{{ round(2 * M_PI * 26 * (1 - $s['puntaje'] / 100), 2) }}" />
            </svg>
            <div
                style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:900; color:{{ $nivel['color'] }};">
                {{ $s['puntaje'] }}
            </div>
        </div>

        <div style="flex:1;">
            <div
                style="font-size:0.68rem; color:#6b7280; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.2rem;">
                Score Financiero</div>
            <div style="font-size:1rem; font-weight:800; color:{{ $nivel['color'] }};">
                {{ $nivel['emoji'] }} {{ $nivel['nombre'] }}
            </div>
            <div
                style="height:4px; background:rgba(255,255,255,0.08); border-radius:99px; overflow:hidden; margin-top:0.5rem; max-width:200px;">
                <div
                    style="height:100%; width:{{ $s['puntaje'] }}%; background:{{ $nivel['color'] }}; border-radius:99px;">
                </div>
            </div>
        </div>

        <a href="{{ route('filament.admin.pages.score-financiero') }}"
            style="padding:0.4rem 1rem; border-radius:0.5rem; background:rgba(255,255,255,0.06); color:#9ca3af; font-size:0.75rem; font-weight:600; text-decoration:none; white-space:nowrap; transition:all 0.15s;"
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='rgba(255,255,255,0.06)'">
            Ver detalle →
        </a>
    </div>
</x-filament-widgets::widget>

<x-filament-panels::page>
    @php $datos = $this->getDatos(); @endphp

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

        .tc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .tc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .tc-section-title {
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

        .tc-section-title svg {
            width: 13px;
            height: 13px;
        }

        .tc-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        @media(max-width:1024px) {
            .tc-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:640px) {
            .tc-grid {
                grid-template-columns: 1fr;
            }
        }

        .tc-moneda-card {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .tc-moneda-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .tc-bandera {
            font-size: 1.5rem;
            line-height: 1;
        }

        .tc-code {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 99px;
            background: rgba(251, 191, 36, 0.12);
            color: #fbbf24;
        }

        .tc-nombre {
            font-size: 0.75rem;
            color: var(--w-muted);
        }

        .tc-tasa {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--w-text);
            letter-spacing: -0.02em;
        }

        .tc-tasa-sub {
            font-size: 0.7rem;
            color: var(--w-muted);
        }

        .tc-updated {
            font-size: 0.65rem;
            color: var(--w-muted);
            margin-top: 0.25rem;
        }

        .tc-no-data {
            font-size: 0.75rem;
            color: var(--w-muted);
            font-style: italic;
        }

        /* Simulador */
        .tc-sim {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 1rem;
            align-items: end;
        }

        @media(max-width:640px) {
            .tc-sim {
                grid-template-columns: 1fr;
            }
        }

        .tc-field label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--w-muted);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .tc-field input,
        .tc-field select {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid var(--w-border);
            background: var(--w-card);
            color: var(--w-text);
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.15s;
        }

        .tc-field input:focus,
        .tc-field select:focus {
            border-color: #fbbf24;
        }

        .tc-field select option {
            background: #1f2937;
            color: #e5e7eb;
        }

        .tc-arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-bottom: 0.25rem;
        }

        .tc-arrow svg {
            width: 20px;
            height: 20px;
            color: var(--w-muted);
        }

        .tc-resultado {
            margin-top: 1.25rem;
            padding: 1rem;
            background: var(--w-card);
            border-radius: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tc-resultado-left {
            font-size: 0.8rem;
            color: var(--w-muted);
        }

        .tc-resultado-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fbbf24;
            letter-spacing: -0.02em;
        }
    </style>

    <div class="tc-wrap">

        <div class="tc-card">
            <div class="tc-section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tasas actuales — Base: PEN (Sol peruano)
            </div>

            <div class="tc-grid">
                @foreach ($datos['monedas'] as $code => $info)
                    @php $tc = $datos['tasas'][$code] ?? null; @endphp
                    <div class="tc-moneda-card">
                        <div class="tc-moneda-top">
                            <span class="tc-bandera">{{ $info['bandera'] }}</span>
                            <span class="tc-code">{{ $code }}</span>
                        </div>
                        <div class="tc-nombre">{{ $info['nombre'] }}</div>
                        @if ($tc)
                            <div class="tc-tasa">{{ $info['simbolo'] }} {{ number_format($tc->tasa, 4) }}</div>
                            <div class="tc-tasa-sub">1 PEN = {{ $info['simbolo'] }} {{ number_format($tc->tasa, 4) }}
                                {{ $code }}</div>
                            <div class="tc-updated">
                                Actualizado {{ $tc->actualizado_en?->diffForHumans() ?? '—' }}
                            </div>
                        @else
                            <div class="tc-no-data">Sin datos — presiona "Actualizar ahora"</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="tc-card">
            <div class="tc-section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0012 2.25z" />
                </svg>
                Simulador de Conversión
            </div>

            <div class="tc-sim">
                <div class="tc-field">
                    <label>Monto</label>
                    <input type="number" wire:model.live="montoConvertir" min="0" step="0.01"
                        placeholder="100.00">
                </div>

                <div class="tc-field">
                    <label>De</label>
                    <select wire:model.live="monedaOrigen">
                        <option value="PEN">🇵🇪 PEN — Sol</option>
                        <option value="USD">🇺🇸 USD — Dólar</option>
                        <option value="EUR">🇪🇺 EUR — Euro</option>
                        <option value="BRL">🇧🇷 BRL — Real</option>
                        <option value="CLP">🇨🇱 CLP — Peso</option>
                    </select>
                </div>

                <div class="tc-arrow">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </div>

                <div class="tc-field">
                    <label>A</label>
                    <select wire:model.live="monedaDestino">
                        <option value="PEN">🇵🇪 PEN — Sol</option>
                        <option value="USD">🇺🇸 USD — Dólar</option>
                        <option value="EUR">🇪🇺 EUR — Euro</option>
                        <option value="BRL">🇧🇷 BRL — Real</option>
                        <option value="CLP">🇨🇱 CLP — Peso</option>
                    </select>
                </div>
            </div>

            <div class="tc-resultado">
                <div class="tc-resultado-left">
                    {{ number_format($montoConvertir, 2) }} {{ $monedaOrigen }} =
                </div>
                <div class="tc-resultado-value">
                    @php $resultado = $this->getResultadoConversion(); @endphp
                    @if ($resultado !== null)
                        {{ number_format($resultado, 2) }} {{ $monedaDestino }}
                    @else
                        —
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>

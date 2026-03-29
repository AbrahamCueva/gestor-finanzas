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

        .calc-wrap {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .calc-card {
            background: var(--w-bg);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        /* Tabs */
        .calc-tabs {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .calc-tab {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 0.625rem;
            font-size: 0.8rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .calc-tab:hover {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .calc-tab.activo {
            background: #fbbf24;
            color: #0f172a;
        }

        /* Grid form */
        .calc-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.875rem;
        }

        @media(max-width:640px) {
            .calc-grid {
                grid-template-columns: 1fr;
            }
        }

        .calc-grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        @media(max-width:640px) {
            .calc-grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .calc-field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .calc-label {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
        }

        .calc-input,
        .calc-select {
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

        .calc-input:focus,
        .calc-select:focus {
            border-color: #fbbf24;
        }

        /* Botón calcular */
        .calc-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.625rem 1.5rem;
            border-radius: 0.625rem;
            background: #fbbf24;
            color: #0f172a;
            font-size: 0.875rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
            margin-top: 0.5rem;
        }

        .calc-btn:hover {
            opacity: 0.85;
        }

        /* Resultados KPIs */
        .calc-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.625rem;
            margin-top: 1.25rem;
        }

        @media(max-width:768px) {
            .calc-kpis {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .calc-kpi {
            background: var(--w-card);
            border-radius: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .calc-kpi-label {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            margin-bottom: 0.2rem;
        }

        .calc-kpi-value {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--w-text);
        }

        /* Tabla amortización */
        .calc-table-wrap {
            overflow-x: auto;
            margin-top: 1.25rem;
            max-height: 320px;
            overflow-y: auto;
            border-radius: 0.75rem;
        }

        .calc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .calc-table th {
            font-size: 0.62rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--w-muted);
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid var(--w-border);
            text-align: right;
            position: sticky;
            top: 0;
            background: var(--w-bg);
        }

        .calc-table th:first-child {
            text-align: center;
        }

        .calc-table td {
            padding: 0.45rem 0.75rem;
            color: var(--w-text-soft);
            border-bottom: 1px solid var(--w-border);
            text-align: right;
        }

        .calc-table td:first-child {
            text-align: center;
            color: var(--w-muted);
        }

        .calc-table tr:last-child td {
            border-bottom: none;
        }

        .calc-table tr:hover td {
            background: var(--w-card);
        }

        /* Resultado conversión */
        .calc-conv-result {
            background: var(--w-card);
            border-radius: 0.875rem;
            padding: 1.5rem;
            text-align: center;
            margin-top: 1rem;
        }

        .calc-conv-from {
            font-size: 0.8rem;
            color: var(--w-muted);
            margin-bottom: 0.25rem;
        }

        .calc-conv-value {
            font-size: 2rem;
            font-weight: 900;
            color: #fbbf24;
            letter-spacing: -0.02em;
        }

        .calc-conv-moneda {
            font-size: 0.875rem;
            color: var(--w-muted);
            margin-top: 0.25rem;
        }

        .calc-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-muted);
            margin-bottom: 1rem;
        }

        .calc-divider {
            height: 1px;
            background: var(--w-border);
            margin: 1.25rem 0;
        }

        .calc-tipo-btns {
            display: flex;
            gap: 0.5rem;
        }

        .calc-tipo-btn {
            padding: 0.35rem 0.875rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: var(--w-card);
            color: var(--w-muted);
            transition: all 0.15s;
        }

        .calc-tipo-btn.activo {
            background: #fbbf24;
            color: #0f172a;
        }
    </style>

    <div class="calc-wrap">

        <div class="calc-card">
            <div class="calc-tabs">
                <button class="calc-tab {{ $tab === 'interes' ? 'activo' : '' }}" wire:click="$set('tab','interes')">
                    Interés
                </button>
                <button class="calc-tab {{ $tab === 'prestamo' ? 'activo' : '' }}" wire:click="$set('tab','prestamo')">
                    Préstamo
                </button>
                <button class="calc-tab {{ $tab === 'meta' ? 'activo' : '' }}" wire:click="$set('tab','meta')">
                    Meta de Ahorro
                </button>
                <button class="calc-tab {{ $tab === 'conversion' ? 'activo' : '' }}"
                    wire:click="$set('tab','conversion')">
                    Conversión
                </button>
            </div>
        </div>

        @if ($tab === 'interes')
            <div class="calc-card">
                <div class="calc-section-title">Calculadora de Interés Simple y Compuesto</div>

                <div class="calc-grid">
                    <div class="calc-field">
                        <label class="calc-label">Capital inicial (S/)</label>
                        <input class="calc-input" type="number" wire:model="int_capital" min="0" step="100">
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Tasa de interés anual (%)</label>
                        <input class="calc-input" type="number" wire:model="int_tasa" min="0" step="0.1">
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Número de períodos</label>
                        <input class="calc-input" type="number" wire:model="int_periodo" min="1">
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Frecuencia</label>
                        <select class="calc-select" wire:model="int_frecuencia">
                            <option value="mensual">Mensual</option>
                            <option value="trimestral">Trimestral</option>
                            <option value="anual">Anual</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:1rem;">
                    <label class="calc-label" style="display:block; margin-bottom:0.5rem;">Tipo de interés</label>
                    <div class="calc-tipo-btns">
                        <button class="calc-tipo-btn {{ $int_tipo === 'simple' ? 'activo' : '' }}"
                            wire:click="$set('int_tipo','simple')">Simple</button>
                        <button class="calc-tipo-btn {{ $int_tipo === 'compuesto' ? 'activo' : '' }}"
                            wire:click="$set('int_tipo','compuesto')">Compuesto</button>
                    </div>
                </div>

                <button class="calc-btn" wire:click="calcularInteres">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:15px;height:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Calcular
                </button>

                @if ($int_resultado)
                    <div class="calc-kpis">
                        <div class="calc-kpi">
                            <div class="calc-kpi-label">Capital inicial</div>
                            <div class="calc-kpi-value">S/ {{ number_format($int_resultado['capital'], 2) }}</div>
                        </div>
                        <div class="calc-kpi">
                            <div class="calc-kpi-label">Interés ganado</div>
                            <div class="calc-kpi-value" style="color:#22c55e;">S/
                                {{ number_format($int_resultado['interes'], 2) }}</div>
                        </div>
                        <div class="calc-kpi">
                            <div class="calc-kpi-label">Total acumulado</div>
                            <div class="calc-kpi-value" style="color:#fbbf24;">S/
                                {{ number_format($int_resultado['total'], 2) }}</div>
                        </div>
                        <div class="calc-kpi">
                            <div class="calc-kpi-label">Ganancia</div>
                            <div class="calc-kpi-value" style="color:#60a5fa;">+{{ $int_resultado['ganancia'] }}%</div>
                        </div>
                    </div>

                    @if (count($int_resultado['tabla']) > 1)
                        <div class="calc-table-wrap">
                            <table class="calc-table">
                                <thead>
                                    <tr>
                                        <th>Período</th>
                                        <th>Saldo</th>
                                        <th>Interés acumulado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($int_resultado['tabla'] as $fila)
                                        <tr>
                                            <td>{{ $fila['periodo'] }}</td>
                                            <td>S/ {{ number_format($fila['saldo'], 2) }}</td>
                                            <td style="color:#22c55e;">S/ {{ number_format($fila['interes'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif
            </div>
        @endif

        @if ($tab === 'prestamo')
            <div class="calc-card">
                <div class="calc-section-title">Calculadora de Préstamo con Amortización</div>

                <div class="calc-grid">
                    <div class="calc-field">
                        <label class="calc-label">Monto del préstamo (S/)</label>
                        <input class="calc-input" type="number" wire:model="prest_monto" min="0" step="500">
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Tasa de interés anual (%)</label>
                        <input class="calc-input" type="number" wire:model="prest_tasa" min="0" step="0.1">
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Número de cuotas (meses)</label>
                        <input class="calc-input" type="number" wire:model="prest_cuotas" min="1"
                            max="360">
                    </div>
                </div>

                <button class="calc-btn" wire:click="calcularPrestamo">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:15px;height:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Calcular
                </button>

                @if ($prest_resumen)
                    <div class="calc-kpis">
                        <div class="calc-kpi">
                            <div class="calc-kpi-label">Cuota mensual</div>
                            <div class="calc-kpi-value" style="color:#fbbf24;">S/
                                {{ number_format($prest_resumen['cuota_mensual'], 2) }}</div>
                        </div>
                        <div class="calc-kpi">
                            <div class="calc-kpi-label">Total a pagar</div>
                            <div class="calc-kpi-value">S/ {{ number_format($prest_resumen['total_pagar'], 2) }}</div>
                        </div>
                        <div class="calc-kpi">
                            <div class="calc-kpi-label">Total intereses</div>
                            <div class="calc-kpi-value" style="color:#ef4444;">S/
                                {{ number_format($prest_resumen['total_intereses'], 2) }}</div>
                        </div>
                        <div class="calc-kpi">
                            <div class="calc-kpi-label">Costo del crédito</div>
                            <div class="calc-kpi-value" style="color:#f59e0b;">
                                +{{ $prest_resumen['porcentaje_int'] }}%</div>
                        </div>
                    </div>

                    <div class="calc-table-wrap">
                        <table class="calc-table">
                            <thead>
                                <tr>
                                    <th>Cuota</th>
                                    <th>Pago</th>
                                    <th>Interés</th>
                                    <th>Amortización</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prest_tabla as $fila)
                                    <tr>
                                        <td>{{ $fila['cuota'] }}</td>
                                        <td>S/ {{ number_format($fila['pago'], 2) }}</td>
                                        <td style="color:#ef4444;">S/ {{ number_format($fila['interes'], 2) }}</td>
                                        <td style="color:#22c55e;">S/ {{ number_format($fila['amortizacion'], 2) }}
                                        </td>
                                        <td>S/ {{ number_format($fila['saldo'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif

        @if ($tab === 'meta')
            <div class="calc-card">
                <div class="calc-section-title">¿Cuándo alcanzaré mi meta de ahorro?</div>

                <div class="calc-grid">
                    <div class="calc-field">
                        <label class="calc-label">Monto objetivo (S/)</label>
                        <input class="calc-input" type="number" wire:model="meta_objetivo" min="0"
                            step="500">
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Ahorro mensual (S/)</label>
                        <input class="calc-input" type="number" wire:model="meta_ahorro" min="0"
                            step="50">
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Tasa de interés anual (%) — opcional</label>
                        <input class="calc-input" type="number" wire:model="meta_tasa" min="0"
                            step="0.1">
                    </div>
                </div>

                <button class="calc-btn" wire:click="calcularMeta">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:15px;height:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Calcular
                </button>

                @if ($meta_resultado)
                    @if (isset($meta_resultado['error']))
                        <div style="color:#ef4444; font-size:0.8rem; margin-top:1rem;">⚠️
                            {{ $meta_resultado['error'] }}</div>
                    @else
                        <div class="calc-kpis">
                            <div class="calc-kpi">
                                <div class="calc-kpi-label">Tiempo estimado</div>
                                <div class="calc-kpi-value" style="color:#fbbf24;">
                                    {{ $meta_resultado['anios'] > 0 ? $meta_resultado['anios'] . 'a ' : '' }}{{ $meta_resultado['meses_restantes'] }}m
                                </div>
                            </div>
                            <div class="calc-kpi">
                                <div class="calc-kpi-label">Total de meses</div>
                                <div class="calc-kpi-value">{{ $meta_resultado['meses'] }}</div>
                            </div>
                            <div class="calc-kpi">
                                <div class="calc-kpi-label">Total aportado</div>
                                <div class="calc-kpi-value">S/
                                    {{ number_format($meta_resultado['total_aportado'], 2) }}</div>
                            </div>
                            <div class="calc-kpi">
                                <div class="calc-kpi-label">Fecha estimada</div>
                                <div class="calc-kpi-value" style="color:#60a5fa; font-size:0.85rem;">
                                    {{ $meta_resultado['fecha_estimada'] }}</div>
                            </div>
                        </div>

                        @if (count($meta_resultado['proyeccion']) > 1)
                            <div class="calc-table-wrap">
                                <table class="calc-table">
                                    <thead>
                                        <tr>
                                            <th>Mes</th>
                                            <th>Saldo acumulado</th>
                                            <th>Total aportado</th>
                                            <th>Intereses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($meta_resultado['proyeccion'] as $fila)
                                            <tr>
                                                <td>{{ $fila['mes'] }}</td>
                                                <td style="color:#fbbf24; font-weight:600;">S/
                                                    {{ number_format($fila['saldo'], 2) }}</td>
                                                <td>S/ {{ number_format($fila['aportado'], 2) }}</td>
                                                <td style="color:#22c55e;">S/
                                                    {{ number_format(max($fila['saldo'] - $fila['aportado'], 0), 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
        @endif

        @if ($tab === 'conversion')
            <div class="calc-card">
                <div class="calc-section-title">Conversión de Monedas</div>

                <div class="calc-grid calc-grid-3">
                    <div class="calc-field">
                        <label class="calc-label">Monto</label>
                        <input class="calc-input" type="number" wire:model="conv_monto" min="0"
                            step="1">
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Desde</label>
                        <select class="calc-select" wire:model="conv_desde">
                            @foreach ($this->getMonedas() as $code => $label)
                                <option value="{{ $code }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="calc-field">
                        <label class="calc-label">Hacia</label>
                        <select class="calc-select" wire:model="conv_hacia">
                            @foreach ($this->getMonedas() as $code => $label)
                                <option value="{{ $code }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button class="calc-btn" wire:click="calcularConversion">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        style="width:15px;height:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    Convertir
                </button>

                @if ($conv_resultado !== null)
                    <div class="calc-conv-result">
                        <div class="calc-conv-from">
                            {{ number_format($conv_monto, 2) }} {{ $conv_desde }} equivale a
                        </div>
                        <div class="calc-conv-value">
                            {{ number_format($conv_resultado, 4) }}
                        </div>
                        <div class="calc-conv-moneda">{{ $conv_hacia }}</div>
                    </div>
                @elseif($conv_resultado === null && $tab === 'conversion')
                    <div style="font-size:0.75rem; color:var(--w-muted); margin-top:1rem; text-align:center;">
                        Tasas obtenidas de la tabla de tipos de cambio. Actualiza las tasas con <code>php artisan
                            ricox:tipos-cambio</code>
                    </div>
                @endif
            </div>
        @endif

    </div>
</x-filament-panels::page>

<style>
    .cat-sugerencia {
        display: none;
        background: rgba(99, 102, 241, 0.08);
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 0.625rem;
        padding: 0.5rem 0.875rem;
        font-size: 0.775rem;
        color: #a5b4fc;
        margin-top: 0.375rem;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.15s;
        flex-wrap: wrap;
    }

    .cat-sugerencia:hover {
        background: rgba(99, 102, 241, 0.15);
        border-color: rgba(99, 102, 241, 0.4);
    }

    .cat-sugerencia.visible {
        display: flex;
    }

    .cat-sug-badge {
        background: rgba(99, 102, 241, 0.2);
        padding: 0.1rem 0.5rem;
        border-radius: 99px;
        font-size: 0.65rem;
        font-weight: 700;
        color: #818cf8;
    }

    .cat-sug-confianza {
        font-size: 0.62rem;
        margin-left: auto;
    }

    .cat-sug-confianza.alta {
        color: #22c55e;
    }

    .cat-sug-confianza.media {
        color: #fbbf24;
    }

    .cat-sug-confianza.baja {
        color: #f97316;
    }
</style>

<script>
    (function() {
        let catTimer = null;

        function iniciarCategorizacion() {
            const observer = new MutationObserver(() => {
                const inputs = document.querySelectorAll(
                    'textarea[id*="descripcion"], ' +
                    'textarea[wire\\:model*="descripcion"], ' +
                    'textarea[wire\\:model\\.live*="descripcion"], ' +
                    'textarea[placeholder*="detalle"], ' +
                    'textarea[placeholder*="Escribe"]'
                );

                inputs.forEach(input => {
                    if (input.dataset.catObservado) return;
                    input.dataset.catObservado = '1';

                    console.log('✅ Cat IA: campo encontrado', input.id, input.placeholder);

                    const sug = document.createElement('div');
                    sug.className = 'cat-sugerencia';
                    sug.id = 'catSug_' + Math.random().toString(36).substr(2, 9);

                    const wrapper = input.closest('.fi-fo-textarea') ||
                        input.closest('.fi-fo-field-wrp') ||
                        input.closest('[class*="fi-fo"]') ||
                        input.parentNode;

                    wrapper.style.position = 'relative';
                    wrapper.appendChild(sug);

                    input.addEventListener('input', function() {
                        clearTimeout(catTimer);
                        const val = this.value.trim();
                        if (val.length < 3) {
                            sug.classList.remove('visible');
                            return;
                        }
                        catTimer = setTimeout(() => buscarSugerencia(val, sug), 800);
                    });
                });
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }

        async function buscarSugerencia(descripcion, sugEl) {
            const tipoEl = document.querySelector(
                'select[id*="tipo_movimiento"], ' +
                'button[id*="tipo_movimiento"], ' +
                '[id*="tipo_movimiento"] button[role="combobox"]'
            );

            let tipo = 'egreso';
            if (tipoEl) {
                const texto = tipoEl.textContent?.toLowerCase() || '';
                tipo = texto.includes('ingreso') ? 'ingreso' : 'egreso';
            }

            const montoInput = document.querySelector('input[id*="monto"]');
            const monto = parseFloat(montoInput?.value || 0);

            try {
                const res = await fetch('/ricox/sugerir-categoria', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                            '',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        descripcion,
                        monto,
                        tipo
                    }),
                });

                const data = await res.json();
                if (!data.sugerencia) return;

                const s = data.sugerencia;
                const confianzaColor = s.confianza === 'alta' ? '#22c55e' : (s.confianza === 'media' ?
                    '#fbbf24' : '#f97316');
                const confianzaLabel = s.confianza === 'alta' ? '✓ Alta confianza' : (s.confianza === 'media' ?
                    '~ Media confianza' : '? Baja confianza');

                sugEl.innerHTML = `
                <span style="color:#818cf8;">🤖 IA sugiere:</span>
                <span class="cat-sug-badge">${s.categoria_nombre}</span>
                ${s.subcategoria_nombre ? `<span class="cat-sug-badge" style="background:rgba(99,102,241,0.1);">${s.subcategoria_nombre}</span>` : ''}
                <span style="color:#6b7280; font-size:0.65rem;">— Click para aplicar</span>
                <span class="cat-sug-confianza ${s.confianza}" style="color:${confianzaColor};">${confianzaLabel}</span>
            `;
                sugEl.classList.add('visible');
                sugEl.onclick = () => aplicarSugerencia(s, sugEl);

            } catch (e) {
                console.error('Cat IA error:', e);
            }
        }

        function aplicarSugerencia(sugerencia, sugEl) {
            let component = null;

            if (window.Livewire) {
                window.Livewire.all().forEach(c => {
                    try {
                        const snap = c.snapshot?.data;
                        if (snap && 'data' in snap && ('isCreating' in snap || 'record' in snap)) {
                            component = c;
                        }
                    } catch (e) {}
                });
            }

            if (!component) {
                sugEl.innerHTML = `⚠️ Selecciona <strong>${sugerencia.categoria_nombre}</strong> manualmente`;
                setTimeout(() => sugEl.classList.remove('visible'), 3000);
                return;
            }

            component.$wire.set('data.categoria_id', sugerencia.categoria_id);

            sugEl.innerHTML =
                `✅ Categoría: <strong>${sugerencia.categoria_nombre}</strong>${sugerencia.subcategoria_nombre ? ` · Subcategoría sugerida: <strong>${sugerencia.subcategoria_nombre}</strong> (selecciona manualmente)` : ''} aplicado`;
            sugEl.style.cursor = 'default';
            setTimeout(() => sugEl.classList.remove('visible'), 4000);

            sugEl.innerHTML =
                `✅ <strong>${sugerencia.categoria_nombre}</strong>${sugerencia.subcategoria_nombre ? ' › ' + sugerencia.subcategoria_nombre : ''} aplicado`;
            sugEl.style.cursor = 'default';
            setTimeout(() => sugEl.classList.remove('visible'), 3000);
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', iniciarCategorizacion);
        } else {
            iniciarCategorizacion();
        }
    })();
</script>

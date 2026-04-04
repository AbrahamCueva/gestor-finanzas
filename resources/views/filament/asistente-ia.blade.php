<style>
    .ia-fab {
        position: fixed;
        bottom: 5rem;
        right: 1.5rem;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(99, 102, 241, 0.4);
        z-index: 9997;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .ia-fab:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 24px rgba(99, 102, 241, 0.5);
    }

    .ia-fab svg {
        width: 20px;
        height: 20px;
    }

    .ia-modal {
        position: fixed;
        bottom: 9.5rem;
        right: 1.5rem;
        width: 380px;
        max-height: 560px;
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.25rem;
        display: none;
        flex-direction: column;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        z-index: 9996;
        overflow: hidden;
        animation: iaSlideIn 0.2s ease;
    }

    @media(max-width:480px) {
        .ia-modal {
            width: calc(100vw - 2rem);
            right: 1rem;
            bottom: 8rem;
        }
    }

    @keyframes iaSlideIn {
        from {
            opacity: 0;
            transform: translateY(12px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .ia-modal.abierto {
        display: flex;
    }

    .ia-header {
        background: linear-gradient(135deg, #1e1b4b, #1e1035);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        flex-shrink: 0;
    }

    .ia-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .ia-header-info {
        flex: 1;
    }

    .ia-header-nombre {
        font-size: 0.875rem;
        font-weight: 700;
        color: #f9fafb;
    }

    .ia-header-estado {
        font-size: 0.65rem;
        color: #22c55e;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .ia-header-estado::before {
        content: '●';
    }

    .ia-close-btn {
        background: rgba(255, 255, 255, 0.06);
        border: none;
        border-radius: 0.375rem;
        width: 28px;
        height: 28px;
        cursor: pointer;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
    }

    .ia-close-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #f9fafb;
    }

    .ia-close-btn svg {
        width: 14px;
        height: 14px;
    }

    .ia-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
    }

    .ia-msg {
        display: flex;
        gap: 0.5rem;
        align-items: flex-start;
    }

    .ia-msg.user {
        flex-direction: row-reverse;
    }

    .ia-msg-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    .ia-msg.assistant .ia-msg-avatar {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
    }

    .ia-msg.user .ia-msg-avatar {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
        font-weight: 700;
    }

    .ia-msg-bubble {
        max-width: 85%;
        padding: 0.625rem 0.875rem;
        border-radius: 1rem;
        font-size: 0.8rem;
        line-height: 1.55;
    }

    .ia-msg.assistant .ia-msg-bubble {
        background: rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
        border-radius: 0.25rem 1rem 1rem 1rem;
    }

    .ia-msg.user .ia-msg-bubble {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-radius: 1rem 0.25rem 1rem 1rem;
    }

    .ia-typing {
        display: flex;
        gap: 4px;
        align-items: center;
        padding: 0.625rem 0.875rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 0.25rem 1rem 1rem 1rem;
        width: fit-content;
    }

    .ia-typing span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #6366f1;
        animation: iaBounce 1.2s infinite;
    }

    .ia-typing span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .ia-typing span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes iaBounce {

        0%,
        60%,
        100% {
            transform: translateY(0);
        }

        30% {
            transform: translateY(-6px);
        }
    }

    /* Sugerencias rápidas */
    .ia-sugerencias {
        padding: 0.5rem 1rem;
        display: flex;
        gap: 0.375rem;
        flex-wrap: wrap;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        flex-shrink: 0;
    }

    .ia-sug-btn {
        padding: 0.25rem 0.625rem;
        border-radius: 99px;
        background: rgba(99, 102, 241, 0.12);
        color: #818cf8;
        border: 1px solid rgba(99, 102, 241, 0.2);
        font-size: 0.65rem;
        cursor: pointer;
        transition: all 0.15s;
        white-space: nowrap;
    }

    .ia-sug-btn:hover {
        background: rgba(99, 102, 241, 0.25);
        color: #a5b4fc;
    }

    .ia-input-wrap {
        padding: 0.75rem 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .ia-input {
        flex: 1;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 0.75rem;
        padding: 0.5rem 0.875rem;
        font-size: 0.825rem;
        color: #f9fafb;
        outline: none;
        resize: none;
        line-height: 1.4;
        transition: border-color 0.15s;
    }

    .ia-input:focus {
        border-color: rgba(99, 102, 241, 0.5);
    }

    .ia-input::placeholder {
        color: #4b5563;
    }

    .ia-send-btn {
        width: 36px;
        height: 36px;
        border-radius: 0.625rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        cursor: pointer;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.15s;
        flex-shrink: 0;
        align-self: flex-end;
    }

    .ia-send-btn:hover {
        opacity: 0.85;
    }

    .ia-send-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .ia-send-btn svg {
        width: 15px;
        height: 15px;
    }

    .ia-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #ef4444;
        color: white;
        font-size: 0.6rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #0f172a;
    }
</style>

<div style="position:relative; display:inline-block;">
    <button class="ia-fab" onclick="toggleIA()" title="Asistente IA">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
        </svg>
    </button>
</div>

<div class="ia-modal" id="iaModal">

    <div class="ia-header">
        <div class="ia-avatar">🤖</div>
        <div class="ia-header-info">
            <div class="ia-header-nombre">RICOX Assistant</div>
            <div class="ia-header-estado">En línea · Powered by Claude</div>
        </div>
        <button class="ia-close-btn" onclick="toggleIA()">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="ia-messages" id="iaMessages">
        <div class="ia-msg assistant">
            <div class="ia-msg-avatar">🤖</div>
            <div class="ia-msg-bubble">
                ¡Hola! 👋 Soy tu asistente financiero personal. Tengo acceso a tus datos de RICOX y puedo ayudarte a
                analizar tus finanzas, responder preguntas y sugerirte acciones concretas.<br><br>
                ¿En qué puedo ayudarte hoy?
            </div>
        </div>
    </div>

    <div class="ia-sugerencias" id="iaSugerencias">
        <button class="ia-sug-btn" onclick="enviarSugerencia(this)">¿En qué gasté más este mes?</button>
        <button class="ia-sug-btn" onclick="enviarSugerencia(this)">¿Cómo va mi ahorro?</button>
        <button class="ia-sug-btn" onclick="enviarSugerencia(this)">¿Tengo deudas vencidas?</button>
        <button class="ia-sug-btn" onclick="enviarSugerencia(this)">Dame consejos financieros</button>
        <button class="ia-sug-btn" onclick="enviarSugerencia(this)">¿Cumplo la regla 50/30/20?</button>
        <button class="ia-sug-btn" onclick="enviarSugerencia(this)">¿Cuándo podré pagar mis deudas?</button>
    </div>

    <div class="ia-input-wrap">
        <textarea class="ia-input" id="iaInput" placeholder="Pregúntame sobre tus finanzas..." rows="1"
            onkeydown="iaKeyDown(event)" oninput="autoResize(this)"></textarea>
        <button class="ia-send-btn" id="iaSendBtn" onclick="enviarMensaje()">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
            </svg>
        </button>
    </div>
</div>

<script>
    let iaAbierto = false;
    let iaHistorial = [];
    if (!window.CSRF) {
        window.CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    function toggleIA() {
        iaAbierto = !iaAbierto;
        const modal = document.getElementById('iaModal');
        modal.classList.toggle('abierto', iaAbierto);
        if (iaAbierto) {
            setTimeout(() => document.getElementById('iaInput')?.focus(), 100);
        }
    }

    function iaKeyDown(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            enviarMensaje();
        }
    }

    function autoResize(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 100) + 'px';
    }

    function enviarSugerencia(btn) {
        document.getElementById('iaInput').value = btn.textContent;
        document.getElementById('iaSugerencias').style.display = 'none';
        enviarMensaje();
    }

    function agregarMensaje(role, content) {
        const container = document.getElementById('iaMessages');
        const isUser = role === 'user';

        const div = document.createElement('div');
        div.className = `ia-msg ${role}`;

        const avatar = document.createElement('div');
        avatar.className = 'ia-msg-avatar';
        avatar.textContent = isUser ? '👤' : '🤖';

        const bubble = document.createElement('div');
        bubble.className = 'ia-msg-bubble';

        bubble.innerHTML = content
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/\n/g, '<br>')
            .replace(/💡 <strong>Acciones sugeridas:<\/strong>/g,
                '<div style="margin-top:0.5rem; padding:0.5rem 0.75rem; background:rgba(99,102,241,0.1); border-radius:0.5rem; border-left:2px solid #6366f1;">💡 <strong style="color:#a5b4fc;">Acciones sugeridas:</strong>'
            );

        div.appendChild(avatar);
        div.appendChild(bubble);
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
    }

    function mostrarTyping() {
        const container = document.getElementById('iaMessages');
        const div = document.createElement('div');
        div.className = 'ia-msg assistant';
        div.id = 'iaTyping';

        const avatar = document.createElement('div');
        avatar.className = 'ia-msg-avatar';
        avatar.textContent = '🤖';

        const typing = document.createElement('div');
        typing.className = 'ia-typing';
        typing.innerHTML = '<span></span><span></span><span></span>';

        div.appendChild(avatar);
        div.appendChild(typing);
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
    }

    function quitarTyping() {
        document.getElementById('iaTyping')?.remove();
    }

    async function enviarMensaje() {
        const input = document.getElementById('iaInput');
        const sendBtn = document.getElementById('iaSendBtn');
        const mensaje = input.value.trim();

        if (!mensaje) return;

        agregarMensaje('user', mensaje);
        iaHistorial.push({
            role: 'user',
            content: mensaje
        });

        input.value = '';
        input.style.height = 'auto';
        sendBtn.disabled = true;
        mostrarTyping();

        try {
            const res = await fetch('/ricox/asistente-ia', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    mensaje,
                    historial: iaHistorial.slice(-10),
                }),
            });

            const data = await res.json();
            quitarTyping();

            if (data.error) {
                agregarMensaje('assistant', '❌ Hubo un error al procesar tu consulta. Intenta de nuevo.');
            } else {
                agregarMensaje('assistant', data.respuesta);
                iaHistorial.push({
                    role: 'assistant',
                    content: data.respuesta
                });
            }
        } catch (e) {
            quitarTyping();
            agregarMensaje('assistant', '❌ No pude conectarme. Verifica tu conexión e intenta de nuevo.');
        } finally {
            sendBtn.disabled = false;
            input.focus();
        }
    }
</script>
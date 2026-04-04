<style>
    .pwa-install-banner {
        position: fixed;
        bottom: 5rem;
        left: 1.5rem;
        background: #0f172a;
        border: 1px solid rgba(251, 191, 36, 0.3);
        border-radius: 0.875rem;
        padding: 0.875rem 1.25rem;
        display: none;
        align-items: center;
        gap: 0.875rem;
        z-index: 9995;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        max-width: 320px;
        animation: slideInLeft 0.3s ease;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .pwa-install-banner.visible {
        display: flex;
    }

    .pwa-install-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .pwa-install-info {
        flex: 1;
    }

    .pwa-install-titulo {
        font-size: 0.825rem;
        font-weight: 700;
        color: #f9fafb;
    }

    .pwa-install-desc {
        font-size: 0.68rem;
        color: #6b7280;
        margin-top: 0.1rem;
    }

    .pwa-install-btns {
        display: flex;
        gap: 0.375rem;
        margin-top: 0.5rem;
    }

    .pwa-install-btn {
        padding: 0.25rem 0.625rem;
        border-radius: 0.375rem;
        font-size: 0.7rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: opacity 0.15s;
    }

    .pwa-install-btn:hover {
        opacity: 0.85;
    }

    .pwa-btn-primary {
        background: #fbbf24;
        color: #0f172a;
    }

    .pwa-btn-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #9ca3af;
    }

    .pwa-push-banner {
        position: fixed;
        top: 5rem;
        right: 1.5rem;
        background: #0f172a;
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 0.875rem;
        padding: 0.875rem 1.25rem;
        display: none;
        align-items: center;
        gap: 0.75rem;
        z-index: 9995;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        max-width: 300px;
    }

    .pwa-push-banner.visible {
        display: flex;
    }
</style>

<div class="pwa-install-banner" id="pwaInstallBanner">
    <div class="pwa-install-icon">📱</div>
    <div class="pwa-install-info">
        <div class="pwa-install-titulo">Instalar RICOX</div>
        <div class="pwa-install-desc">Accede más rápido desde tu pantalla de inicio</div>
        <div class="pwa-install-btns">
            <button class="pwa-install-btn pwa-btn-primary" onclick="instalarPWA()">Instalar</button>
            <button class="pwa-install-btn pwa-btn-secondary" onclick="cerrarBannerInstall()">Ahora no</button>
        </div>
    </div>
</div>

<div class="pwa-push-banner" id="pwaPushBanner">
    <span style="font-size:1.25rem;">🔔</span>
    <div style="flex:1;">
        <div style="font-size:0.775rem; font-weight:600; color:#f9fafb;">¿Activar notificaciones?</div>
        <div style="font-size:0.65rem; color:#6b7280; margin-top:0.1rem;">Recibe alertas de presupuestos y deudas</div>
        <div style="display:flex; gap:0.375rem; margin-top:0.5rem;">
            <button class="pwa-install-btn pwa-btn-primary" style="background:#6366f1; color:white;"
                onclick="activarPush()">Activar</button>
            <button class="pwa-install-btn pwa-btn-secondary" onclick="cerrarBannerPush()">No gracias</button>
        </div>
    </div>
</div>

<script>
    if (!window.CSRF) {
        window.CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
    }
    let deferredPrompt = null;

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', async () => {
            try {
                const reg = await navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                });
                console.log('PWA: SW registrado', reg.scope);

                setTimeout(() => {
                    if ('PushManager' in window && Notification.permission === 'default') {
                        const pushDismissed = localStorage.getItem('push_dismissed');
                        if (!pushDismissed) {
                            document.getElementById('pwaPushBanner').classList.add('visible');
                        }
                    }
                }, 5000);

            } catch (e) {
                console.warn('PWA: Error registrando SW', e);
            }
        });
    }

    window.addEventListener('beforeinstallprompt', e => {
        e.preventDefault();
        deferredPrompt = e;

        const dismissed = localStorage.getItem('pwa_install_dismissed');
        if (!dismissed) {
            setTimeout(() => {
                document.getElementById('pwaInstallBanner').classList.add('visible');
            }, 3000);
        }
    });

    async function instalarPWA() {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        const result = await deferredPrompt.userChoice;
        console.log('PWA: Resultado instalación:', result.outcome);
        deferredPrompt = null;
        cerrarBannerInstall();
    }

    function cerrarBannerInstall() {
        document.getElementById('pwaInstallBanner').classList.remove('visible');
        localStorage.setItem('pwa_install_dismissed', '1');
    }

    window.addEventListener('appinstalled', () => {
        cerrarBannerInstall();
        console.log('PWA: App instalada correctamente');
    });

    async function activarPush() {
        cerrarBannerPush();

        try {
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') return;

            const keyRes = await fetch('/ricox/push/vapid-key');
            const {
                key
            } = await keyRes.json();

            const reg = await navigator.serviceWorker.ready;
            const sub = await reg.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(key),
            });

            await fetch('/ricox/push/suscribir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify(sub.toJSON()),
            });

            console.log('PWA: Push activado correctamente');

        } catch (e) {
            console.warn('PWA: Error activando push', e);
        }
    }

    function cerrarBannerPush() {
        document.getElementById('pwaPushBanner').classList.remove('visible');
        localStorage.setItem('push_dismissed', '1');
    }

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const raw = window.atob(base64);
        const output = new Uint8Array(raw.length);
        for (let i = 0; i < raw.length; ++i) output[i] = raw.charCodeAt(i);
        return output;
    }
</script>
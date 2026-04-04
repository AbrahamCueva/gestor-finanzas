const CACHE_NAME = "ricox-v1";
const OFFLINE_URL = "/offline";

const PRECACHE = [
    "/",
    "/offline",
    "/manifest.json",
    "/icons/icon-192.png",
    "/icons/icon-512.png",
];

// =================== INSTALL ===================
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE).catch((err) => {
                console.warn("PWA: Error precaching", err);
            });
        }),
    );
    self.skipWaiting();
});

// =================== ACTIVATE ===================
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches
            .keys()
            .then((keys) =>
                Promise.all(
                    keys
                        .filter((k) => k !== CACHE_NAME)
                        .map((k) => caches.delete(k)),
                ),
            ),
    );
    self.clients.claim();
});

// =================== FETCH ===================
self.addEventListener("fetch", (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Solo manejar requests del mismo origen
    if (url.origin !== location.origin) return;

    // NO cachear nada de admin, livewire, api ni POST
    if (
        url.pathname.startsWith("/livewire") ||
        url.pathname.startsWith("/admin") ||
        url.pathname.startsWith("/ricox/") ||
        url.pathname.startsWith("/api/") ||
        url.pathname.includes("sanctum") ||
        url.pathname.includes("csrf") ||
        request.method !== "GET"
    ) {
        return;
    }

    event.respondWith(
        caches.match(request).then((cached) => {
            if (cached) return cached;

            return fetch(request)
                .then((response) => {
                    // Solo cachear recursos estáticos
                    if (
                        response.ok &&
                        (url.pathname.startsWith("/build/") ||
                            url.pathname.startsWith("/icons/") ||
                            url.pathname.endsWith(".css") ||
                            url.pathname.endsWith(".js") ||
                            url.pathname.endsWith(".png") ||
                            url.pathname.endsWith(".svg"))
                    ) {
                        const clone = response.clone();
                        caches
                            .open(CACHE_NAME)
                            .then((cache) => cache.put(request, clone));
                    }
                    return response;
                })
                .catch(() => {
                    if (request.headers.get("accept")?.includes("text/html")) {
                        return caches.match(OFFLINE_URL);
                    }
                });
        }),
    );
});

// =================== PUSH NOTIFICATIONS ===================
self.addEventListener("push", (event) => {
    if (!event.data) return;

    let data = {};
    try {
        data = event.data.json();
    } catch (e) {
        data = { title: "RICOX", body: event.data.text() };
    }

    const options = {
        body: data.body || "Nueva notificación",
        icon: data.icon || "/icons/icon-192.png",
        badge: data.badge || "/icons/icon-96.png",
        image: data.image || null,
        data: data.data || { url: "/admin" },
        actions: data.actions || [
            { action: "open", title: "Ver", icon: "/icons/icon-96.png" },
            { action: "close", title: "Cerrar", icon: "/icons/icon-96.png" },
        ],
        vibrate: [100, 50, 100],
        requireInteraction: data.requireInteraction || false,
        tag: data.tag || "ricox-notif",
    };

    event.waitUntil(
        self.registration.showNotification(data.title || "RICOX", options),
    );
});

// =================== NOTIFICATION CLICK ===================
self.addEventListener("notificationclick", (event) => {
    event.notification.close();

    if (event.action === "close") return;

    const url = event.notification.data?.url || "/admin";

    event.waitUntil(
        clients
            .matchAll({ type: "window", includeUncontrolled: true })
            .then((clientList) => {
                for (const client of clientList) {
                    if (client.url.includes("/admin") && "focus" in client) {
                        return client.focus().then((c) => c.navigate(url));
                    }
                }
                return clients.openWindow(url);
            }),
    );
});

// =================== BACKGROUND SYNC ===================
self.addEventListener("sync", (event) => {
    if (event.tag === "sync-movimientos") {
        event.waitUntil(sincronizarMovimientos());
    }
});

async function sincronizarMovimientos() {
    console.log("PWA: Background sync ejecutado");
}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 — RICOX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0a0a;
            color: #f9fafb;
            overflow: hidden;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 2rem;
            max-width: 480px;
        }

        .logo {
            font-size: 2rem;
            font-weight: 900;
            color: #fbbf24;
            margin-bottom: 0.25rem;
            letter-spacing: -0.03em;
        }

        .gold-line {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #d97706);
            border-radius: 99px;
            margin: 0.75rem auto 2rem;
        }

        .code {
            font-size: 5rem;
            font-weight: 900;
            color: #ef4444;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .titulo {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .desc {
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .btns {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.625rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: opacity 0.15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .btn-primary {
            background: #fbbf24;
            color: #0f172a;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <canvas id="c"></canvas>
    <div class="content">
        <div class="logo">RICOX</div>
        <div class="gold-line"></div>
        <div class="code">500</div>
        <div class="titulo">Error interno del servidor</div>
        <div class="desc">
            Algo salió mal en el servidor. No es tu culpa — nuestro equipo ya fue notificado.
            Intenta de nuevo en unos momentos.
        </div>
        <div class="btns">
            <a href="javascript:history.back()" class="btn btn-secondary">← Volver</a>
            <a href="/admin" class="btn btn-primary">🏠 Ir al inicio</a>
        </div>
    </div>
    <script>
        const canvas = document.getElementById('c');
        const ctx = canvas.getContext('2d');
        let W, H, particles = [];

        function resize() {
            W = canvas.width = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }

        function init() {
            particles = Array.from({
                length: 60
            }, () => ({
                x: Math.random() * W,
                y: Math.random() * H,
                r: Math.random() * 1.5 + 0.5,
                dx: (Math.random() - 0.5) * 0.3,
                dy: (Math.random() - 0.5) * 0.3,
                o: Math.random() * 0.4 + 0.1,
                c: Math.random() > 0.7 ? '#ef4444' : '#fbbf24',
            }));
        }

        function draw() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.c;
                ctx.globalAlpha = p.o;
                ctx.fill();
                p.x += p.dx;
                p.y += p.dy;
                if (p.x < 0 || p.x > W) p.dx *= -1;
                if (p.y < 0 || p.y > H) p.dy *= -1;
            });
            ctx.globalAlpha = 1;
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', () => {
            resize();
            init();
        });
        resize();
        init();
        draw();
    </script>
</body>

</html>

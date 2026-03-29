<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sin conexión — RICOX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0a0a;
            color: #f9fafb;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            text-align: center;
            padding: 2.5rem;
            max-width: 360px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 900;
            color: #fbbf24;
            margin-bottom: 0.5rem;
        }

        .gold-line {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #fbbf24, #d97706);
            border-radius: 99px;
            margin: 0.75rem auto 2rem;
        }

        .icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
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

        .btn {
            background: #fbbf24;
            color: #0f172a;
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 2rem;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .btn:hover {
            opacity: 0.85;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="logo">RICOX</div>
        <div class="gold-line"></div>
        <div class="icon">📡</div>
        <div class="titulo">Sin conexión</div>
        <div class="desc">
            No hay conexión a internet. Algunas funciones no están disponibles en modo offline.
            Verifica tu conexión y vuelve a intentarlo.
        </div>
        <button class="btn" onclick="window.location.reload()">🔄 Reintentar</button>
    </div>
</body>

</html>

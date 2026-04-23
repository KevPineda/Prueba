<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle — {{ $publicacion->titulo }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; }

        header {
            background: #2c3e50;
            color: white;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 { font-size: 1.3rem; }
        .btn-logout {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: .9rem;
        }
        .btn-logout:hover { background: #c0392b; }

        .container { max-width: 760px; margin: 32px auto; padding: 0 16px; }

        .card {
            background: white;
            border-radius: 8px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            font-size: .9rem;
        }
        .back-link:hover { text-decoration: underline; }

        .card img {
            width: 100%;
            max-height: 380px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 24px;
        }

        h2 { color: #2c3e50; font-size: 1.6rem; margin-bottom: 12px; }

        .meta {
            font-size: .85rem;
            color: #888;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contenido {
            line-height: 1.7;
            color: #444;
            font-size: 1rem;
            white-space: pre-wrap;
        }

        hr { border: none; border-top: 1px solid #eee; margin: 20px 0; }

        .field-label { font-size: .8rem; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 2px; }
        .field-value { font-size: .95rem; color: #333; margin-bottom: 16px; }

        
    </style>
</head>
<body>

<header>
    <h1>📄 Detalle de publicación</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn-logout" type="submit">Cerrar sesión</button>
    </form>
</header>

<div class="container">
    <a class="back-link" href="{{ route('admin.listado') }}">← Volver al listado</a>

    <div class="card">
        <img src="{{ asset('storage/' . $publicacion->imagen) }}" alt="imagen de la publicación">

        <h2>{{ $publicacion->titulo }}</h2>

        <div class="meta">
            <span>✉️ {{ $publicacion->email_registro }}</span>
            <span>🕒 {{ $publicacion->fecha_registro }}</span>
            <span>#{{ $publicacion->id }}</span>
        </div>

        <hr>

        <div class="field-label">Contenido</div>
        <div class="contenido">{{ $publicacion->contenido }}</div>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Publicaciones</title>
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

        .container { max-width: 1000px; margin: 32px auto; padding: 0 16px; }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }
        th {
            background: #2c3e50;
            color: white;
            padding: 12px 14px;
            text-align: left;
            font-size: .9rem;
        }
        td { padding: 12px 14px; border-bottom: 1px solid #eee; font-size: .9rem; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8f9fa; }

        td img { width: 80px; height: 60px; object-fit: cover; border-radius: 4px; }

        .btn-ver {
            background: #3498db;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none;
            font-size: .85rem;
        }
        .btn-ver:hover { background: #2980b9; }

        .btn-eliminar {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 4px;
    font-size: .85rem;
    cursor: pointer;
    margin-left: 6px;
}

.btn-eliminar:hover {
    background: #c0392b;
}
    </style>
</head>
<body>

<header>
    <h1>📋 Administración de publicaciones</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn-logout" type="submit">Cerrar sesión</button>
    </form>
</header>

<div class="container">
    @if(session('success'))
    <div style="background:#d4edda;color:#155724;padding:10px;border-radius:4px;margin-bottom:16px;">
        {{ session('success') }}
    </div>
@endif
    <h2 style="margin-bottom:20px; color:#2c3e50;">
        Publicaciones ({{ $publicaciones->count() }})
    </h2>

    @if($publicaciones->isEmpty())
        <p>No hay publicaciones registradas.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Título</th>
                    <th>Correo</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($publicaciones as $pub)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $pub->imagen) }}" alt="imagen">
                        </td>
                        <td>{{ $pub->titulo }}</td>
                        <td>{{ $pub->email_registro }}</td>
                        <td>{{ $pub->fecha_registro }}</td>
                        <td>
                            <a class="btn-ver"
                               href="{{ route('admin.detalle', $pub->id) }}">
                               Ver detalle
                            </a>
                            <form action="{{ route('admin.eliminar', $pub->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar"
                            onclick="return confirm('¿Seguro que quieres eliminar esta publicación?')">
                             Eliminar
                            </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
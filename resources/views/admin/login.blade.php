<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Iniciar sesión</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            background: white;
            padding: 40px 36px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,.12);
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 { text-align: center; margin-bottom: 28px; color: #2c3e50; }

        label { display: block; margin-bottom: 4px; font-weight: bold; font-size: .9rem; }
        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 6px;
        }
        input:focus { outline: none; border-color: #3498db; }

        .error-text { color: #e74c3c; font-size: .85rem; margin-bottom: 14px; display: block; }

        .btn {
            width: 100%;
            background: #2c3e50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 6px;
        }
        .btn:hover { background: #1a252f; }

        .volver { text-align: center; margin-top: 16px; font-size: .9rem; }
        .volver a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>🔐 Panel de administración</h2>

    @if(session('error'))
        <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:4px;margin-bottom:16px;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <label>Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@blog.com">
        @error('email')
            <span class="error-text">{{ $message }}</span>
        @enderror

        <label>Contraseña</label>
        <input type="password" name="password" placeholder="••••••••">
        @error('password')
            <span class="error-text">{{ $message }}</span>
        @enderror

        <button class="btn" type="submit">Ingresar</button>
    </form>

    <div class="volver"><a href="{{ route('listado') }}">← Volver al blog</a></div>
</div>

</body>
</html>
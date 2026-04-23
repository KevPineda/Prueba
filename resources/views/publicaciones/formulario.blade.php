<!DOCTYPE html>
<html lang="es">
<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blog</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }

        header {
            background: #2c3e50;
            color: white;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 { font-size: 1.4rem; }
        header a {
            color: #ecf0f1;
            text-decoration: none;
            background: #3498db;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        header a:hover { background: #2980b9; }

        .container { max-width: 860px; margin: 32px auto; padding: 0 16px; }

        .card {
            background: white;
            border-radius: 8px;
            padding: 28px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            margin-bottom: 32px;
        }
        .card h2 { margin-bottom: 20px; color: #2c3e50; }

        label { display: block; margin-bottom: 4px; font-weight: bold; font-size: .9rem; }
        input[type=text], input[type=email], textarea, input[type=file] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 4px;
        }
        textarea { height: 120px; resize: vertical; }
        .error-msg { color: #e74c3c; font-size: .85rem; margin-bottom: 12px; display: block; }

        .btn {
            background: #27ae60;
            color: white;
            border: none;
            padding: 11px 28px;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 8px;
        }
        .btn:hover { background: #219150; }

        #mensaje-ok {
            display: none;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 16px;
        }

        .pub-item {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        .pub-item img {
            width: 120px;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }
        .pub-info h3 { color: #2c3e50; margin-bottom: 6px; }
        .pub-info p  { font-size: .9rem; color: #555; margin-bottom: 4px; }
        .pub-meta    { font-size: .8rem; color: #888; margin-top: 8px; }
    </style>
</head>
<body>

<header>
    <h1>📝 Blog</h1>
    <a href="{{ route('login') }}">Panel de administración</a>
</header>

<div class="container">

    <div class="card">
        <h2>Nueva publicación</h2>

        <div id="mensaje-ok">✅ ¡Publicación guardada correctamente!</div>

        <div>
            <label>Título *</label>
            <input type="text" id="titulo" placeholder="Escribe el título">
            <span class="error-msg" id="error-titulo"></span>

            <label>Contenido *</label>
            <textarea id="contenido" placeholder="Escribe el contenido"></textarea>
            <span class="error-msg" id="error-contenido"></span>

            <label>Imagen * (jpeg, png, jpg, webp — máx 5MB)</label>
            <input type="file" id="imagen" accept=".jpeg,.jpg,.png,.webp">
            <span class="error-msg" id="error-imagen"></span>

            <label>Correo electrónico *</label>
            <input type="email" id="email" placeholder="ejemplo@correo.com">
            <span class="error-msg" id="error-email"></span>

            <div class="g-recaptcha"
                 data-sitekey="{{ config('services.recaptcha.site_key') }}"
                 style="margin-bottom: 12px; margin-top: 8px;">
            </div>
            <span class="error-msg" id="error-captcha"></span>

            <button class="btn" onclick="guardarPublicacion()">Guardar publicación</button>
        </div>
    </div>

    <h2 style="margin-bottom:16px; color:#2c3e50;">Publicaciones recientes</h2>

    <div id="contenedor-publicaciones">
        @forelse($publicaciones as $pub)
            <div class="pub-item">
                <img src="{{ asset('storage/' . $pub->imagen) }}" alt="imagen">
                <div class="pub-info">
                    <h3>{{ $pub->titulo }}</h3>
                    <p>{{ $pub->contenido }}</p>
                    <div class="pub-meta">
                        ✉️ {{ $pub->email_registro }} &nbsp;|&nbsp;
                        🕒 {{ $pub->fecha_registro }}
                    </div>
                </div>
            </div>
        @empty
            <p>Aún no hay publicaciones.</p>
        @endforelse
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function guardarPublicacion() {
    document.querySelectorAll('.error-msg').forEach(e => e.textContent = '');
    document.getElementById('mensaje-ok').style.display = 'none';

    const titulo    = document.getElementById('titulo').value;
    const contenido = document.getElementById('contenido').value;
    const email     = document.getElementById('email').value;
    const imagen    = document.getElementById('imagen').files[0];

    const formData = new FormData();
    formData.append('titulo',    titulo);
    formData.append('contenido', contenido);
    formData.append('email',     email);
    if (imagen) formData.append('imagen', imagen);

    const captchaToken = grecaptcha.getResponse();
    formData.append('g-recaptcha-response', captchaToken);

    axios.post('{{ route("publicaciones.store") }}', formData)
        .then(response => {
            if (response.data.success) {
                document.getElementById('titulo').value    = '';
                document.getElementById('contenido').value = '';
                document.getElementById('email').value     = '';
                document.getElementById('imagen').value    = '';

                grecaptcha.reset();

                document.getElementById('mensaje-ok').style.display = 'block';

                const pub = response.data.publicacion;
                const contenedor = document.getElementById('contenedor-publicaciones');

                const noHay = contenedor.querySelector('p');
                if (noHay) noHay.remove();

                const div = document.createElement('div');
                div.className = 'pub-item';
                div.innerHTML = `
                    <img src="${pub.imagen_url}" alt="imagen">
                    <div class="pub-info">
                        <h3>${pub.titulo}</h3>
                        <p>${pub.contenido}</p>
                        <div class="pub-meta">
                            ✉️ ${pub.email_registro} &nbsp;|&nbsp;
                            🕒 ${pub.fecha_registro}
                        </div>
                    </div>`;
                contenedor.insertBefore(div, contenedor.firstChild);
            }
        })
        .catch(error => {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;

                for (const campo in errors) {
                    const el = document.getElementById('error-' + campo);
                    if (el) el.textContent = errors[campo][0];
                }

                grecaptcha.reset();

            } else {
                alert('Error en el servidor. Intenta de nuevo.');
            }
        });
}
</script>

</body>
</html>
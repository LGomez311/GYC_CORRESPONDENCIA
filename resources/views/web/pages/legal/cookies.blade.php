<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Política de Cookies | EASYCOR</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#00b5a3",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        display: ["Public Sans", "sans-serif"]
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Public Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light text-[#0d121b] antialiased">

<!-- HEADER -->
<header class="bg-white border-b border-[#e7ebf3] px-6 md:px-20 py-4">
    <div class="max-w-[1280px] mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-primary text-white p-2 rounded-lg">
                <span class="material-symbols-outlined">cookie</span>
            </div>
            <h1 class="text-xl font-extrabold">EASYCOR</h1>
        </div>

        <a href="{{ url('/') }}" class="text-sm font-bold text-primary hover:underline">
            Volver al inicio
        </a>
    </div>
</header>

<!-- HERO -->
<section class="bg-white py-20 border-b border-[#e7ebf3]">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-6">
            Política de Cookies
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Esta política explica qué son las cookies y cómo las utilizamos en EASYCOR.
        </p>
    </div>
</section>

<!-- CONTENIDO -->
<section class="py-20 bg-background-light">
    <div class="max-w-[900px] mx-auto px-6 md:px-0 space-y-12 text-sm leading-relaxed text-[#4c669a]">

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">1. ¿Qué son las cookies?</h2>
            <p>
                Las cookies son pequeños archivos de texto que se almacenan en el
                dispositivo del usuario cuando visita un sitio web. Se utilizan
                para mejorar la experiencia de navegación.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">2. Cookies que utilizamos</h2>
            <p>
                EASYCOR puede utilizar cookies técnicas y funcionales necesarias
                para el correcto funcionamiento de la plataforma.
            </p>
            <ul class="list-disc ml-6 mt-3 space-y-2">
                <li>Cookies de sesión para autenticación.</li>
                <li>Cookies de seguridad.</li>
                <li>Cookies de preferencias del usuario.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">3. Cookies de terceros</h2>
            <p>
                Actualmente, EASYCOR no utiliza cookies de terceros con fines
                publicitarios. En caso de integrarse servicios externos, esta
                política será actualizada.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">4. Gestión de cookies</h2>
            <p>
                El usuario puede configurar su navegador para aceptar o rechazar
                cookies. La desactivación de cookies puede afectar algunas
                funcionalidades del sistema.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">5. Cambios en esta política</h2>
            <p>
                EASYCOR se reserva el derecho de modificar esta Política de Cookies
                en cualquier momento. Los cambios serán publicados en esta página.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">6. Contacto</h2>
            <p>
                Si tienes dudas sobre esta Política de Cookies, puedes comunicarte
                con nosotros a través de la sección de contacto.
            </p>
        </div>

    </div>
</section>

<!-- FOOTER -->
<footer class="bg-white border-t border-[#e7ebf3] py-10 text-center">
    <p class="text-xs text-[#4c669a]">
        © 2026 EASYCOR. Todos los derechos reservados.
    </p>
</footer>

</body>
</html>

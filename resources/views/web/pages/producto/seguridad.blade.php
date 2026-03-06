<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seguridad | IncolDEV</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#135bec",
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
                <span class="material-symbols-outlined">shield</span>
            </div>
            <h1 class="text-xl font-extrabold">IncolDEV</h1>
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
            Seguridad de la información
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Protección, confidencialidad y control total sobre la información
            crítica de su institución.
        </p>
    </div>
</section>

<!-- IMPORTANCIA -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h2 class="text-3xl font-black mb-6">
                La seguridad no es opcional
            </h2>
            <p class="text-[#4c669a] mb-6">
                La correspondencia institucional contiene información sensible
                que debe ser protegida contra accesos no autorizados,
                pérdidas o manipulaciones.
            </p>

            <ul class="space-y-3 text-sm font-semibold">
                <li>❌ Accesos sin control</li>
                <li>❌ Fugas de información</li>
                <li>❌ Alteración de documentos</li>
                <li>❌ Falta de auditoría</li>
            </ul>
        </div>

        <div class="bg-white p-10 rounded-2xl border border-[#e7ebf3] shadow-sm">
            <h3 class="font-bold text-lg mb-4">
                Con IncolDEV su información está:
            </h3>
            <ul class="space-y-3 text-sm">
                <li>✔ Protegida</li>
                <li>✔ Restringida por roles</li>
                <li>✔ Auditada</li>
                <li>✔ Respaldada</li>
            </ul>
        </div>

    </div>
</section>

<!-- CAPAS DE SEGURIDAD -->
<section class="py-20 bg-white">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-black">
            Capas de seguridad implementadas
        </h2>
        <p class="text-[#4c669a] mt-4">
            Arquitectura diseñada para entornos administrativos y gubernamentales.
        </p>
    </div>

    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Control de accesos</h3>
            <p class="text-sm text-[#4c669a]">
                Acceso por roles y permisos según el cargo del usuario.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Autenticación segura</h3>
            <p class="text-sm text-[#4c669a]">
                Inicio de sesión protegido contra accesos no autorizados.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Auditoría de acciones</h3>
            <p class="text-sm text-[#4c669a]">
                Registro de cada acción realizada por los usuarios.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Integridad de datos</h3>
            <p class="text-sm text-[#4c669a]">
                Protección contra modificaciones no autorizadas.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Respaldos periódicos</h3>
            <p class="text-sm text-[#4c669a]">
                Copias de seguridad para prevenir pérdidas de información.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Disponibilidad continua</h3>
            <p class="text-sm text-[#4c669a]">
                Sistema preparado para operar de forma estable y confiable.
            </p>
        </div>

    </div>
</section>

<!-- CONFIANZA -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center">

        <h2 class="text-3xl md:text-4xl font-black mb-6">
            Confianza para su institución
        </h2>

        <p class="text-[#4c669a] max-w-3xl mx-auto mb-10">
            Diseñado para cumplir con buenas prácticas de seguridad informática
            y protección de datos en entornos institucionales.
        </p>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl border border-[#e7ebf3]">
                <p class="font-bold">Confidencialidad</p>
                <p class="text-sm text-[#4c669a] mt-2">
                    Solo personal autorizado accede a la información.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-[#e7ebf3]">
                <p class="font-bold">Integridad</p>
                <p class="text-sm text-[#4c669a] mt-2">
                    Los datos no pueden ser alterados sin autorización.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-[#e7ebf3]">
                <p class="font-bold">Disponibilidad</p>
                <p class="text-sm text-[#4c669a] mt-2">
                    Acceso a la información cuando se necesita.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-[900px] mx-auto px-6">

        <h2 class="text-3xl md:text-4xl font-black mb-6">
            Seguridad diseñada para instituciones
        </h2>

        <p class="mb-8 text-white/90">
            Nuestro equipo puede asesorarle sobre cómo proteger
            la información de su entidad.
        </p>

        @php
            $msg = "Hola 👋, quiero conocer más sobre la seguridad de IncolDEV.
¿Podrían brindarme asesoría?";
            $url = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($msg);
        @endphp

        <a href="{{ $url }}" target="_blank">
            <button class="bg-white text-primary px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition">
                Contactar asesor
            </button>
        </a>

    </div>
</section>

<!-- FOOTER -->
<footer class="bg-white border-t border-[#e7ebf3] py-10 text-center">
    <p class="text-xs text-[#4c669a]">
        © 2026 IncolDEV. Todos los derechos reservados.
    </p>
</footer>

</body>
</html>
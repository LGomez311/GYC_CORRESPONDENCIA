<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Características | EASYCOR</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#1e63e9",
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

<!-- HEADER SIMPLE -->
<header class="bg-white border-b border-[#e7ebf3] px-6 md:px-20 py-4">
    <div class="max-w-[1280px] mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-primary text-white p-2 rounded-lg">
                <span class="material-symbols-outlined">mail</span>
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
            Características de EASYCOR
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Centralice, controle y asegure toda la correspondencia institucional
            en una sola plataforma moderna, confiable y eficiente.
        </p>
    </div>
</section>

<!-- PROBLEMA -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h2 class="text-3xl font-black mb-6">
                ¿Por qué digitalizar la correspondencia?
            </h2>
            <p class="text-[#4c669a] mb-6">
                La gestión manual genera pérdidas de información, retrasos y falta
                de control sobre documentos críticos.
            </p>

            <ul class="space-y-3 text-sm font-semibold">
                <li>❌ Registros físicos vulnerables</li>
                <li>❌ Dificultad para hacer seguimiento</li>
                <li>❌ Procesos lentos y errores humanos</li>
                <li>❌ Falta de reportes confiables</li>
            </ul>
        </div>

        <div class="bg-white p-10 rounded-2xl border border-[#e7ebf3] shadow-sm">
            <h3 class="font-bold text-lg mb-4">
                Con EASYCOR su institución obtiene:
            </h3>
            <ul class="space-y-3 text-sm">
                <li>✔ Registro digital inmediato</li>
                <li>✔ Historial completo por documento</li>
                <li>✔ Acceso seguro y controlado</li>
                <li>✔ Información en tiempo real</li>
            </ul>
        </div>

    </div>
</section>

<!-- MÓDULOS -->
<section class="py-20 bg-white">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-black">
            Funcionalidades principales
        </h2>
        <p class="text-[#4c669a] mt-4">
            Módulos diseñados para entornos administrativos e institucionales.
        </p>
    </div>

    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Recepción de documentos</h3>
            <p class="text-sm text-[#4c669a]">
                Registro de correspondencia entrante con datos clave y trazabilidad.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Despacho y entrega</h3>
            <p class="text-sm text-[#4c669a]">
                Seguimiento detallado de documentos salientes hasta su destino.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Trazabilidad completa</h3>
            <p class="text-sm text-[#4c669a]">
                Historial completo de cada documento desde su registro.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Gestión por áreas</h3>
            <p class="text-sm text-[#4c669a]">
                Asignación de correspondencia según estructura organizacional.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Usuarios y permisos</h3>
            <p class="text-sm text-[#4c669a]">
                Control de accesos por roles jerárquicos.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <h3 class="font-bold text-lg mb-3">Reportes e indicadores</h3>
            <p class="text-sm text-[#4c669a]">
                Métricas claras para toma de decisiones administrativas.
            </p>
        </div>

    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-[900px] mx-auto px-6">

        <h2 class="text-3xl md:text-4xl font-black mb-6">
            Modernice su gestión documental
        </h2>

        <p class="mb-8 text-white/90">
            Nuestro equipo puede asesorarle según las necesidades
            específicas de su institución.
        </p>

        @php
            $msg = "Hola 👋, quiero conocer más sobre las características de EASYCOR.
¿Podrían asesorarme?";
            $url = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($msg);
        @endphp

        <a href="{{ $url }}" target="_blank">
            <button class="bg-white text-primary px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition">
                Contactar asesor
            </button>
        </a>

    </div>
</section>

<!-- FOOTER SIMPLE -->
<footer class="bg-white border-t border-[#e7ebf3] py-10 text-center">
    <p class="text-xs text-[#4c669a]">
        © 2026 EASYCOR. Todos los derechos reservados.
    </p>
</footer>

</body>
</html>

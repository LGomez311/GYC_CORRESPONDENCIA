<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog | EASYCOR</title>

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
                <span class="material-symbols-outlined">article</span>
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
            Blog EASYCOR
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Artículos, guías y novedades sobre gestión de correspondencia,
            tecnología y desarrollo de software.
        </p>
    </div>
</section>

<!-- BLOG GRID -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <!-- POST 1 -->
        <article class="bg-white rounded-2xl border border-[#e7ebf3] shadow-sm hover:shadow-lg transition overflow-hidden">
            <img src="https://via.placeholder.com/600x350" alt="Gestión digital" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-xs font-bold text-primary uppercase">Gestión</span>
                <h3 class="text-lg font-bold mt-2 mb-3">
                    ¿Por qué digitalizar la correspondencia institucional?
                </h3>
                <p class="text-sm text-[#4c669a] mb-4">
                    Descubra cómo la digitalización mejora el control, la trazabilidad
                    y la eficiencia en las organizaciones.
                </p>
                <span class="text-xs text-gray-400">Publicado · Febrero 2026</span>
            </div>
        </article>

        <!-- POST 2 -->
        <article class="bg-white rounded-2xl border border-[#e7ebf3] shadow-sm hover:shadow-lg transition overflow-hidden">
            <img src="https://via.placeholder.com/600x350" alt="Seguridad" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-xs font-bold text-primary uppercase">Seguridad</span>
                <h3 class="text-lg font-bold mt-2 mb-3">
                    Buenas prácticas para proteger información sensible
                </h3>
                <p class="text-sm text-[#4c669a] mb-4">
                    Conozca las principales recomendaciones para mantener segura
                    la información institucional.
                </p>
                <span class="text-xs text-gray-400">Publicado · Febrero 2026</span>
            </div>
        </article>

        <!-- POST 3 -->
        <article class="bg-white rounded-2xl border border-[#e7ebf3] shadow-sm hover:shadow-lg transition overflow-hidden">
            <img src="https://via.placeholder.com/600x350" alt="Mobile" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-xs font-bold text-primary uppercase">Mobile</span>
                <h3 class="text-lg font-bold mt-2 mb-3">
                    Ventajas de gestionar procesos desde el móvil
                </h3>
                <p class="text-sm text-[#4c669a] mb-4">
                    El acceso móvil permite a los equipos responder en tiempo real
                    sin importar su ubicación.
                </p>
                <span class="text-xs text-gray-400">Publicado · Enero 2026</span>
            </div>
        </article>

        <!-- POST 4 -->
        <article class="bg-white rounded-2xl border border-[#e7ebf3] shadow-sm hover:shadow-lg transition overflow-hidden">
            <img src="https://via.placeholder.com/600x350" alt="Desarrollo" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-xs font-bold text-primary uppercase">Desarrollo</span>
                <h3 class="text-lg font-bold mt-2 mb-3">
                    Cómo nació EASYCOR: de idea a proyecto real
                </h3>
                <p class="text-sm text-[#4c669a] mb-4">
                    Conozca la historia detrás del desarrollo del sistema por
                    estudiantes del SENA.
                </p>
                <span class="text-xs text-gray-400">Publicado · Enero 2026</span>
            </div>
        </article>

        <!-- POST 5 -->
        <article class="bg-white rounded-2xl border border-[#e7ebf3] shadow-sm hover:shadow-lg transition overflow-hidden">
            <img src="https://via.placeholder.com/600x350" alt="Procesos" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-xs font-bold text-primary uppercase">Procesos</span>
                <h3 class="text-lg font-bold mt-2 mb-3">
                    Errores comunes en la gestión de correspondencia
                </h3>
                <p class="text-sm text-[#4c669a] mb-4">
                    Identifique los errores más frecuentes y cómo evitarlos
                    usando soluciones digitales.
                </p>
                <span class="text-xs text-gray-400">Publicado · Diciembre 2025</span>
            </div>
        </article>

        <!-- POST 6 -->
        <article class="bg-white rounded-2xl border border-[#e7ebf3] shadow-sm hover:shadow-lg transition overflow-hidden">
            <img src="https://via.placeholder.com/600x350" alt="Tecnología" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-xs font-bold text-primary uppercase">Tecnología</span>
                <h3 class="text-lg font-bold mt-2 mb-3">
                    El rol del software en la transformación digital
                </h3>
                <p class="text-sm text-[#4c669a] mb-4">
                    La tecnología como pilar clave para modernizar procesos
                    administrativos.
                </p>
                <span class="text-xs text-gray-400">Publicado · Diciembre 2025</span>
            </div>
        </article>

    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-[900px] mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-black mb-6">
            ¿Desea conocer más sobre EASYCOR?
        </h2>
        <p class="mb-8 text-white/90">
            Nuestro blog comparte conocimiento, experiencias y soluciones reales.
        </p>

        @php
            $msg = "Hola 👋, me gustaría recibir más información sobre EASYCOR.";
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
        © 2026 EASYCOR. Todos los derechos reservados.
    </p>
</footer>

</body>
</html>

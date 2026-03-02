<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sobre Nosotros | IncolDEV</title>

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
                <span class="material-symbols-outlined">groups</span>
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
            Sobre nosotros
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Conoce el origen, propósito y visión detrás de IncolDEV.
        </p>
    </div>
</section>

<!-- HISTORIA -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h2 class="text-3xl font-black mb-6">
                Un proyecto creado con propósito
            </h2>

            <p class="text-[#4c669a] mb-4 leading-relaxed">
                IncolDEV nace como un proyecto desarrollado por <strong>tres jóvenes estudiantes del SENA</strong>,
                pertenecientes al programa de <strong>Análisis y Desarrollo de Software</strong>.
            </p>

            <p class="text-[#4c669a] mb-4 leading-relaxed">
                Identificamos una necesidad real en muchas organizaciones: la falta de control,
                trazabilidad y digitalización en la gestión de correspondencia institucional.
            </p>

            <p class="text-[#4c669a] leading-relaxed">
                A partir de esta problemática, decidimos crear una solución moderna, eficiente y segura,
                aplicando nuestros conocimientos en desarrollo de software y buenas prácticas tecnológicas.
            </p>
        </div>

        <div class="bg-white p-10 rounded-2xl border border-[#e7ebf3] shadow-sm">
            <h3 class="font-bold text-lg mb-4">Nuestros valores</h3>

            <ul class="space-y-3 text-sm text-[#4c669a]">
                <li>✔ Compromiso con la calidad</li>
                <li>✔ Innovación constante</li>
                <li>✔ Aprendizaje continuo</li>
                <li>✔ Enfoque en soluciones reales</li>
                <li>✔ Responsabilidad y ética profesional</li>
            </ul>
        </div>

    </div>
</section>

<!-- MISIÓN Y VISIÓN -->
<section class="py-20 bg-white">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-12">

        <div class="p-10 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <span class="material-symbols-outlined text-primary text-4xl mb-4">target</span>
            <h3 class="text-xl font-bold mb-3">Nuestra misión</h3>
            <p class="text-sm text-[#4c669a] leading-relaxed">
                Desarrollar soluciones tecnológicas que optimicen los procesos institucionales,
                mejorando la eficiencia, el control y la toma de decisiones en las organizaciones.
            </p>
        </div>

        <div class="p-10 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <span class="material-symbols-outlined text-primary text-4xl mb-4">visibility</span>
            <h3 class="text-xl font-bold mb-3">Nuestra visión</h3>
            <p class="text-sm text-[#4c669a] leading-relaxed">
                Convertirnos en una solución confiable y reconocida en la gestión de correspondencia
                digital a nivel nacional, destacándonos por nuestra innovación y crecimiento constante.
            </p>
        </div>

    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-[900px] mx-auto px-6">

        <h2 class="text-3xl md:text-4xl font-black mb-6">
            Creado por jóvenes, pensado para organizaciones reales
        </h2>

        <p class="mb-8 text-white/90">
            IncolDEV es el resultado de aprendizaje, esfuerzo y visión tecnológica.
        </p>

        @php
            $msg = "Hola 👋, me gustaría conocer más sobre IncolDEV y su equipo de desarrollo.";
            $url = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($msg);
        @endphp

        <a href="{{ $url }}" target="_blank">
            <button class="bg-white text-primary px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition">
                Contactar al equipo
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
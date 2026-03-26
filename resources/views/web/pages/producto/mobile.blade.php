<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Versión Mobile | EASYCOR</title>

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
                <span class="material-symbols-outlined">phone_android</span>
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
            Versión móvil de EASYCOR
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Controle y gestione su correspondencia desde cualquier lugar con una
            experiencia optimizada para dispositivos móviles.
        </p>
    </div>
</section>

<!-- BENEFICIOS -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h2 class="text-3xl font-black mb-6">
                ¿Por qué usar la versión móvil?
            </h2>
            <p class="text-[#4c669a] mb-6">
                El mundo no espera. Su equipo puede recibir y responder en tiempo
                real, sin necesidad de estar frente a una computadora.
            </p>

            <ul class="space-y-3 text-sm font-semibold">
                <li>✔ Registro de entrada de correspondencia desde el celular</li>
                <li>✔ Envío y seguimiento al instante</li>
                <li>✔ Notificaciones en tiempo real</li>
                <li>✔ Acceso seguro desde cualquier lugar</li>
            </ul>
        </div>

        <div class="bg-white p-10 rounded-2xl border border-[#e7ebf3] shadow-sm">
            <h3 class="font-bold text-lg mb-4">Ideal para su equipo móvil</h3>
            <ul class="space-y-3 text-sm text-[#4c669a]">
                <li>✔ Trabajo remoto y en campo</li>
                <li>✔ Acceso a reportes desde la app</li>
                <li>✔ Sincronización en tiempo real</li>
                <li>✔ Compatible con iOS y Android</li>
            </ul>
        </div>

    </div>
</section>

<!-- INTERFAZ -->
<section class="py-20 bg-white">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-black">
            Interfaz intuitiva y simple
        </h2>
        <p class="text-[#4c669a] mt-4">
            Una experiencia móvil pensada para personas que necesitan resultados, no complicaciones.
        </p>
    </div>

    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid sm:grid-cols-1 md:grid-cols-3 gap-8">

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <span class="material-symbols-outlined text-primary text-4xl mb-3">dashboard</span>
            <p class="text-sm text-[#4c669a]">
                Tablero con información clave al instante.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <span class="material-symbols-outlined text-primary text-4xl mb-3">send_to_mobile</span>
            <p class="text-sm text-[#4c669a]">
                Registración de documentos desde el teléfono.
            </p>
        </div>

        <div class="p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary transition">
            <span class="material-symbols-outlined text-primary text-4xl mb-3">notifications</span>
            <p class="text-sm text-[#4c669a]">
                Notificaciones y alertas en tiempo real.
            </p>
        </div>

    </div>
</section>

<!-- EJEMPLOS / MOCKUPS -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-black">
            Así se ve EASYCOR en móvil
        </h2>
    </div>

    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid sm:grid-cols-1 md:grid-cols-2 gap-8">

        <div class="bg-white p-8 rounded-2xl border border-[#e7ebf3] shadow-sm">
            <img src="https://via.placeholder.com/400x800" alt="Mockup EASYCOR Mobile 1" class="w-full rounded-xl">
        </div>

        <div class="bg-white p-8 rounded-2xl border border-[#e7ebf3] shadow-sm">
            <img src="https://via.placeholder.com/400x800" alt="Mockup EASYCOR Mobile 2" class="w-full rounded-xl">
        </div>

    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-[900px] mx-auto px-6">

        <h2 class="text-3xl md:text-4xl font-black mb-6">
            Lleve EASYCOR siempre con usted
        </h2>

        <p class="mb-8 text-white/90">
            La versión móvil le permite estar al tanto de todo sin perder un minuto.
        </p>

        @php
            $msg = "Hola 👋, quiero saber más sobre la versión móvil de EASYCOR. ¿Podrían brindarme información?";
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

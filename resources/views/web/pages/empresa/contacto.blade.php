<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacto | IncolDEV</title>

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
                <span class="material-symbols-outlined">support_agent</span>
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
            Contáctanos
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            ¿Tienes dudas, quieres una demostración o necesitas asesoría?
            Estamos listos para ayudarte.
        </p>
    </div>
</section>

<!-- CONTENIDO -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-16 items-start">

        <!-- INFO -->
        <div>
            <h2 class="text-3xl font-black mb-6">
                Hablemos
            </h2>
            <p class="text-[#4c669a] mb-8">
                En IncolDEV creemos en la comunicación directa. Nuestro equipo
                te acompañará desde el primer contacto.
            </p>

            <div class="space-y-6">

                <div class="flex items-start gap-4">
                    <div class="bg-primary/10 text-primary p-3 rounded-xl">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Horario de atención</h4>
                        <p class="text-sm text-[#4c669a]">
                            Lunes a viernes<br>
                            8:00 a.m. – 6:00 p.m. (Hora Colombia)
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="bg-primary/10 text-primary p-3 rounded-xl">
                        <span class="material-symbols-outlined">location_on</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Ubicación</h4>
                        <p class="text-sm text-[#4c669a]">
                            Colombia Ibagué-Tolima<br>
                            Atención 100% digital
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="bg-primary/10 text-primary p-3 rounded-xl">
                        <span class="material-symbols-outlined">chat</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Canal principal</h4>
                        <p class="text-sm text-[#4c669a]">
                            WhatsApp para atención rápida y personalizada
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- CTA WHATSAPP -->
        <div class="bg-white p-10 rounded-2xl border border-[#e7ebf3] shadow-sm">
            <h3 class="text-2xl font-black mb-4">
                Escríbenos ahora
            </h3>
            <p class="text-[#4c669a] mb-8">
                Da clic en el botón y uno de nuestros asesores te atenderá
                de inmediato.
            </p>

            @php
                $mensaje = "Hola 👋, quiero más información sobre IncolDEV.";
                $whatsappUrl = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($mensaje);
            @endphp

            <a href="{{ $whatsappUrl }}" target="_blank">
                <button
                    class="w-full bg-primary text-white py-4 rounded-xl font-bold
                    hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">chat</span>
                    Contactar por WhatsApp
                </button>
            </a>

            <p class="text-xs text-[#4c669a] mt-6 text-center">
                Respuesta promedio: menos de 5 minutos
            </p>
        </div>

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
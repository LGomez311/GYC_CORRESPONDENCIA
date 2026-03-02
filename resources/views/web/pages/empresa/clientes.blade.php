<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clientes | IncolDEV</title>

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
                <span class="material-symbols-outlined">handshake</span>
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
            Nuestros clientes
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            IncolDEV está diseñado para organizaciones que buscan eficiencia,
            control y transformación digital.
        </p>
    </div>
</section>

<!-- TIPOS DE CLIENTES -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20">
        <h2 class="text-3xl font-black text-center mb-16">
            ¿Quiénes pueden usar IncolDEV?
        </h2>

        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-white p-8 rounded-2xl border border-[#e7ebf3] shadow-sm hover:border-primary transition">
                <span class="material-symbols-outlined text-primary text-4xl mb-4">account_balance</span>
                <h3 class="font-bold text-lg mb-2">Entidades públicas</h3>
                <p class="text-sm text-[#4c669a]">
                    Alcaldías, gobernaciones y entidades estatales que requieren
                    trazabilidad y control documental.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-[#e7ebf3] shadow-sm hover:border-primary transition">
                <span class="material-symbols-outlined text-primary text-4xl mb-4">business</span>
                <h3 class="font-bold text-lg mb-2">Empresas privadas</h3>
                <p class="text-sm text-[#4c669a]">
                    Organizaciones que desean optimizar sus procesos internos
                    de mensajería y correspondencia.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-[#e7ebf3] shadow-sm hover:border-primary transition">
                <span class="material-symbols-outlined text-primary text-4xl mb-4">school</span>
                <h3 class="font-bold text-lg mb-2">Instituciones educativas</h3>
                <p class="text-sm text-[#4c669a]">
                    Colegios, universidades y centros de formación que manejan
                    alto volumen documental.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- CONFIANZA -->
<section class="py-20 bg-white">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-16 items-center">

        <div>
            <h2 class="text-3xl font-black mb-6">
                Un sistema pensado para crecer
            </h2>
            <p class="text-[#4c669a] mb-4">
                Aunque IncolDEV nace como un proyecto académico, está construido
                siguiendo buenas prácticas de desarrollo y pensado para escalar
                a nivel empresarial.
            </p>
            <p class="text-[#4c669a]">
                Nuestro objetivo es acompañar a las organizaciones en su proceso
                de transformación digital con una solución sólida y confiable.
            </p>
        </div>

        <div class="bg-background-light p-10 rounded-2xl border border-[#e7ebf3]">
            <h3 class="font-bold text-lg mb-4">¿Por qué confiar en IncolDEV?</h3>
            <ul class="space-y-3 text-sm text-[#4c669a]">
                <li>✔ Desarrollo basado en necesidades reales</li>
                <li>✔ Seguridad y control de la información</li>
                <li>✔ Soporte y acompañamiento continuo</li>
                <li>✔ Plataforma adaptable a distintos sectores</li>
            </ul>
        </div>

    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-[900px] mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-black mb-6">
            ¿Quiere ser parte de nuestros clientes?
        </h2>
        <p class="mb-8 text-white/90">
            IncolDEV está listo para adaptarse a su organización.
        </p>

        @php
            $msg = "Hola 👋, me gustaría saber si IncolDEV es adecuado para mi organización.";
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
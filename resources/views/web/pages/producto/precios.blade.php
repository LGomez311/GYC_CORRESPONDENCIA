<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Precios | EASYCOR</title>

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

<!-- HEADER -->
<header class="bg-white border-b border-[#e7ebf3] px-6 md:px-20 py-4">
    <div class="max-w-[1280px] mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-primary text-white p-2 rounded-lg">
                <span class="material-symbols-outlined">payments</span>
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
            Planes y precios
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Elija el plan que mejor se adapte a las necesidades de su institución.
            Precios claros, sin costos ocultos.
        </p>
    </div>
</section>

<!-- PLANES -->
<section class="py-20 bg-background-light">
    <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 lg:grid-cols-4 gap-8">

        <!-- MENSUAL -->
        <div class="bg-white rounded-2xl border border-[#e7ebf3] p-8 flex flex-col">
            <h3 class="text-lg font-bold mb-2">Mensual</h3>
            <p class="text-sm text-[#4c669a] mb-6">Ideal para pruebas o proyectos cortos</p>

            <p class="text-3xl font-black mb-6">
                $200.000 <span class="text-sm font-medium">COP</span>
            </p>

            <ul class="space-y-3 text-sm mb-8">
                <li>✔ Acceso completo al sistema</li>
                <li>✔ Soporte básico</li>
                <li>✔ Gestión de correspondencia</li>
                <li>✔ Usuarios y permisos</li>
                <li>✔ Reportes básicos</li>
            </ul>

            @php
                $msg = "Hola 👋, estoy interesado en el plan Mensual de EASYCOR por $200.000 COP. ¿Podrían brindarme más información?";
                $url = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($msg);
            @endphp

            <a href="{{ $url }}" target="_blank" class="mt-auto">
                <button class="w-full h-11 rounded-xl font-bold bg-[#e7ebf3] hover:bg-primary hover:text-white transition">
                    Contactar asesor
                </button>
            </a>
        </div>

        <!-- TRIMESTRAL -->
        <div class="bg-white rounded-2xl border border-[#e7ebf3] p-8 flex flex-col">
            <h3 class="text-lg font-bold mb-2">Trimestral</h3>
            <p class="text-sm text-[#4c669a] mb-6">Ahorro frente al plan mensual</p>

            <p class="text-3xl font-black mb-6">
                $540.000 <span class="text-sm font-medium">COP</span>
            </p>

            <ul class="space-y-3 text-sm mb-8">
                <li>✔ Acceso completo al sistema</li>
                <li>✔ Soporte prioritario</li>
                <li>✔ Trazabilidad completa</li>
                <li>✔ Gestión por áreas</li>
                <li>✔ Reportes administrativos</li>
            </ul>

            @php
                $msg = "Hola 👋, estoy interesado en el plan Trimestral de EASYCOR por $540.000 COP. ¿Podrían brindarme más información?";
                $url = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($msg);
            @endphp

            <a href="{{ $url }}" target="_blank" class="mt-auto">
                <button class="w-full h-11 rounded-xl font-bold bg-[#e7ebf3] hover:bg-primary hover:text-white transition">
                    Contactar asesor
                </button>
            </a>
        </div>

        <!-- SEMESTRAL (DESTACADO) -->
        <div class="bg-white rounded-2xl border-2 border-primary p-8 flex flex-col shadow-lg shadow-primary/20 scale-[1.02]">
            <span class="text-xs font-bold text-primary mb-2">RECOMENDADO</span>

            <h3 class="text-lg font-bold mb-2">Semestral</h3>
            <p class="text-sm text-[#4c669a] mb-6">Mejor equilibrio costo / beneficio</p>

            <p class="text-3xl font-black mb-6">
                $1.040.000 <span class="text-sm font-medium">COP</span>
            </p>

            <ul class="space-y-3 text-sm mb-8">
                <li>✔ Acceso completo al sistema</li>
                <li>✔ Soporte prioritario</li>
                <li>✔ Auditoría y seguridad</li>
                <li>✔ Reportes avanzados</li>
                <li>✔ Acompañamiento técnico</li>
            </ul>

            @php
                $msg = "Hola 👋, estoy interesado en el plan Semestral de EASYCOR por $1.040.000 COP. ¿Podrían asesorarme?";
                $url = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($msg);
            @endphp

            <a href="{{ $url }}" target="_blank" class="mt-auto">
                <button class="w-full h-11 rounded-xl font-bold bg-primary text-white hover:bg-blue-700 transition">
                    Seleccionar plan
                </button>
            </a>
        </div>

        <!-- ANUAL -->
        <div class="bg-white rounded-2xl border border-[#e7ebf3] p-8 flex flex-col">
            <h3 class="text-lg font-bold mb-2">Anual</h3>
            <p class="text-sm text-[#4c669a] mb-6">Máximo ahorro y estabilidad</p>

            <p class="text-3xl font-black mb-6">
                $1.950.000 <span class="text-sm font-medium">COP</span>
            </p>

            <ul class="space-y-3 text-sm mb-8">
                <li>✔ Acceso completo al sistema</li>
                <li>✔ Soporte prioritario</li>
                <li>✔ Seguridad avanzada</li>
                <li>✔ Reportes gerenciales</li>
                <li>✔ Soporte continuo</li>
            </ul>

            @php
                $msg = "Hola 👋, estoy interesado en el plan Anual de EASYCOR por $1.950.000 COP. ¿Podrían brindarme más información?";
                $url = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($msg);
            @endphp

            <a href="{{ $url }}" target="_blank" class="mt-auto">
                <button class="w-full h-11 rounded-xl font-bold bg-[#e7ebf3] hover:bg-primary hover:text-white transition">
                    Contactar asesor
                </button>
            </a>
        </div>

    </div>
</section>

<!-- CTA FINAL -->
<section class="py-20 bg-primary text-white text-center">
    <div class="max-w-[900px] mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-black mb-6">
            ¿Necesita un plan personalizado?
        </h2>

        <p class="mb-8 text-white/90">
            Podemos adaptar EASYCOR a los requerimientos
            específicos de su institución.
        </p>

        @php
            $msg = "Hola 👋, estoy interesado en un plan personalizado de EASYCOR. ¿Podrían asesorarme?";
            $url = "https://wa.me/" . config('services.whatsapp.number') . "?text=" . urlencode($msg);
        @endphp

        <a href="{{ $url }}" target="_blank">
            <button class="bg-white text-primary px-10 py-4 rounded-xl font-bold hover:bg-gray-100 transition">
                Hablar con un asesor
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

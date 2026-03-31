<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Política de Privacidad | EASYCOR</title>

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
                <span class="material-symbols-outlined">policy</span>
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
            Política de Privacidad
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Tu privacidad es importante para nosotros. Esta política describe
            cómo recopilamos y protegemos tu información.
        </p>
    </div>
</section>

<!-- CONTENIDO -->
<section class="py-20 bg-background-light">
    <div class="max-w-[900px] mx-auto px-6 md:px-0 space-y-12 text-sm leading-relaxed text-[#4c669a]">

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">1. Información general</h2>
            <p>
                EASYCOR es un proyecto de desarrollo de software creado con fines
                académicos y tecnológicos. Nos comprometemos a proteger la información
                personal de los usuarios que interactúan con nuestra plataforma.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">2. Información que recopilamos</h2>
            <p>
                Podemos recopilar información personal como nombre, correo electrónico,
                número de contacto y datos relacionados con el uso del sistema,
                únicamente cuando el usuario los proporciona de manera voluntaria.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">3. Uso de la información</h2>
            <p>
                La información recopilada se utiliza para:
            </p>
            <ul class="list-disc ml-6 mt-3 space-y-2">
                <li>Brindar acceso y funcionamiento adecuado del sistema.</li>
                <li>Ofrecer soporte técnico y atención al usuario.</li>
                <li>Mejorar la experiencia y calidad del servicio.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">4. Protección de la información</h2>
            <p>
                Implementamos medidas técnicas y organizativas razonables para proteger
                la información personal contra accesos no autorizados, pérdida o uso indebido.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">5. Compartir información</h2>
            <p>
                EASYCOR no comparte, vende ni alquila información personal a terceros,
                salvo cuando sea requerido por ley o con autorización expresa del usuario.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">6. Derechos del usuario</h2>
            <p>
                El usuario tiene derecho a acceder, actualizar o solicitar la eliminación
                de su información personal en cualquier momento, comunicándose a través
                de nuestros canales oficiales.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">7. Cambios en esta política</h2>
            <p>
                Nos reservamos el derecho de actualizar esta Política de Privacidad en
                cualquier momento. Los cambios serán publicados en esta página.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">8. Contacto</h2>
            <p>
                Si tienes preguntas sobre esta Política de Privacidad, puedes contactarnos
                a través de WhatsApp o los canales indicados en nuestra sección de contacto.
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

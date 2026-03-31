<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Términos de Servicio | EASYCOR</title>

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
                <span class="material-symbols-outlined">gavel</span>
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
            Términos de Servicio
        </h1>
        <p class="text-lg text-[#4c669a] max-w-3xl mx-auto">
            Al utilizar EASYCOR aceptas los siguientes términos y condiciones.
        </p>
    </div>
</section>

<!-- CONTENIDO -->
<section class="py-20 bg-background-light">
    <div class="max-w-[900px] mx-auto px-6 md:px-0 space-y-12 text-sm leading-relaxed text-[#4c669a]">

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">1. Aceptación de los términos</h2>
            <p>
                Al acceder y utilizar la plataforma EASYCOR, el usuario acepta
                cumplir con los presentes Términos de Servicio. Si no está de acuerdo
                con alguno de ellos, debe abstenerse de utilizar el sistema.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">2. Descripción del servicio</h2>
            <p>
                EASYCOR es una plataforma de software orientada a la gestión y
                control de procesos internos. El sistema puede encontrarse en
                desarrollo y algunas funcionalidades pueden cambiar o mejorar
                con el tiempo.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">3. Uso adecuado</h2>
            <p>
                El usuario se compromete a utilizar la plataforma de manera
                responsable y legal, evitando cualquier acción que pueda afectar
                el funcionamiento, seguridad o integridad del sistema.
            </p>
            <ul class="list-disc ml-6 mt-3 space-y-2">
                <li>No usar el sistema para fines ilícitos.</li>
                <li>No intentar acceder a información sin autorización.</li>
                <li>No interferir con el funcionamiento del servicio.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">4. Cuentas de usuario</h2>
            <p>
                El usuario es responsable de la confidencialidad de sus credenciales
                de acceso y de todas las actividades realizadas desde su cuenta.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">5. Disponibilidad del servicio</h2>
            <p>
                EASYCOR procura mantener la plataforma disponible, pero no garantiza
                un funcionamiento ininterrumpido. Podrán presentarse interrupciones
                por mantenimiento, mejoras o causas externas.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">6. Propiedad intelectual</h2>
            <p>
                Todo el contenido, diseño y código de EASYCOR es propiedad de sus
                desarrolladores y no puede ser reproducido sin autorización previa.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">7. Limitación de responsabilidad</h2>
            <p>
                EASYCOR no será responsable por daños directos o indirectos derivados
                del uso o imposibilidad de uso de la plataforma.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">8. Modificaciones</h2>
            <p>
                Nos reservamos el derecho de modificar estos Términos de Servicio en
                cualquier momento. Las modificaciones serán publicadas en esta página.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-[#0d121b] mb-3">9. Contacto</h2>
            <p>
                Para cualquier duda relacionada con estos Términos de Servicio,
                el usuario puede comunicarse a través de los canales indicados
                en la sección de contacto.
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

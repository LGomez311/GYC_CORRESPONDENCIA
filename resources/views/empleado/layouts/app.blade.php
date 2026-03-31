<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gestión de Correspondencia (Empleado)</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
        }

        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1;
        }
    </style>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1e63e9",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Public Sans"]
                    },
                },
            },
        }
    </script>
</head>

<body class="font-display">

    {{-- ======= BANNER LICENCIA ======= --}}
    {{-- Banner superior para licencia bloqueada --}}
    @if (isset($licenciaBloqueada) && $licenciaBloqueada)
        <div class="fixed top-0 left-0 right-0 z-50 bg-red-600 text-white">
            <div class="flex items-center justify-between px-6 py-2 text-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-white text-base">
                        warning
                    </span>
                    <span>
                        El sistema se encuentra bloqueado por falta de pago de licencia. Contacte al administrador.
                    </span>
                </div>
            </div>
        </div>
    @endif


    {{-- ======= LAYOUT PRINCIPAL ======= --}}
    <div class="flex h-screen w-full bg-background-light dark:bg-background-dark overflow-hidden">
        {{-- Overlay móvil --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden" onclick="toggleSidebar()">
        </div>

        {{-- Sidebar --}}
        @include('empleado.layouts.sidebar')

        {{-- Contenedor contenido --}}
        <div class="flex-1 flex flex-col">

            {{-- Header móvil --}}
            <div
                class="md:hidden flex items-center justify-between p-4 border-b dark:border-gray-800 bg-white dark:bg-[#161d2b]">
                <button onclick="toggleSidebar()"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <h2 class="font-bold dark:text-white">
                    Panel de Empleado
                </h2>
            </div>

            {{-- Contenido --}}
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>

        </div>

    </div>


    {{-- ======= MODALES ======= --}}
    @yield('modals')
    @include('admin.layouts.profile_modal')


    {{-- ======= ALERTAS SWEETALERT ======= --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: "{{ session('success') }}"
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error al procesar la solicitud',
                html: `<ul style="text-align:left;margin:0;padding-left:1.2em">{!! implode('', array_map(fn($e) => '<li>' . e($e) . '</li>', $errors->all())) !!}</ul>`,
                confirmButtonColor: '#1e63e9'
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: "{{ session('warning') }}"
            });
        </script>
    @endif


    {{-- Evitar cache back button --}}
    <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>


    {{-- Toggle Sidebar --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    @yield('scripts')

</body>

</html>

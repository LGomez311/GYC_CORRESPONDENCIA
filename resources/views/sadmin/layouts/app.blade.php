<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gestión de Empresas (Super Admin)</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#00b5a3",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Public Sans"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-white antialiased">
    <div class="flex h-screen overflow-hidden relative">
        {{-- Overlay móvil --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        @include('sadmin.layouts.sidebar')

        {{-- Content --}}
        <main class="flex-1 flex flex-col overflow-y-auto">

            {{-- Header móvil --}}
            <div class="md:hidden flex items-center justify-between p-4 border-b dark:border-gray-800 bg-white dark:bg-[#161d2b]">
                <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h2 class="font-bold dark:text-white text-sm truncate">Super Admin Portal</h2>
            </div>

            {{-- Header (Desktop/Optional) --}}
            @include('sadmin.layouts.header')

            {{-- Page content --}}
            <div class="p-4 md:p-6 lg:p-8">
                @yield('content')
            </div>

        </main>

    </div>

    @yield('modals')
    @include('admin.layouts.profile_modal')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

    <style>
        /* Contenedor principal */
        .select2-container .select2-selection--single {
            height: 41px !important;
            border: 1.5px solid #d1d5db !important;
            /* gris tailwind */
            border-radius: 0.5rem !important;
            /* rounded-lg */
            display: flex !important;
            align-items: center !important;
            padding: 0 12px !important;
            font-size: 14px;
        }

        /* Texto seleccionado */
        .select2-selection__rendered {
            line-height: normal !important;
            padding-left: 0 !important;
        }

        /* Flecha */
        .select2-selection__arrow {
            height: 100% !important;
        }

        /* Cuando está enfocado */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #00b5a3 !important;
            box-shadow: 0 0 0 2px rgba(0, 181, 163, 0.2) !important;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
@yield('scripts')

</html>

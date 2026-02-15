<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gestión de Usuarios (Admin.)</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&amp;display=swap"
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
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
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
</head>


<body class="font-display">
    @if (!empty($licenciaBloqueada))
        <div class="fixed top-0 left-0 right-0 z-50 bg-red-600 text-white">
            <div class="flex items-center justify-between px-6 py-2 text-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined fill text-white text-base">
                        warning
                    </span>
                    <span>
                        Tu licencia está bloqueada. Realiza el pago para continuar usando el sistema.
                    </span>
                </div>
            </div>
        </div>
    @endif

    <div
        class="relative flex h-auto min-h-screen w-full flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden
        @if (!empty($licenciaBloqueada)) pt-10 @endif">
        <div class="flex min-h-screen">
            @include('admin.layouts.sidebar')

            <main class="flex-1 p-8">

                @yield('content')
            </main>
        </div>
    </div>


    @yield('modals')
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

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: "{{ session('warning') }}"
            });
        </script>
    @endif

</body>


</html>

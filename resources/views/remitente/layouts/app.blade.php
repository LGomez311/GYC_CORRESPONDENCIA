<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Ventanilla</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />

    <!-- jQuery and Select2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    


    {{-- ======= LAYOUT PRINCIPAL ======= --}}
    <div class="flex h-screen w-full bg-background-light dark:bg-background-dark overflow-hidden">

        {{-- Overlay móvil --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden" onclick="toggleSidebar()">
        </div>

        {{-- Sidebar --}}
        @include('remitente.layouts.sidebar')

        {{-- Contenedor contenido --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Header móvil --}}
            <div
                class="md:hidden flex items-center justify-between p-4 border-b dark:border-gray-800 bg-white dark:bg-[#161d2b]">
                <button onclick="toggleSidebar()"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <h2 class="font-bold dark:text-white">
                    Panel Ventanilla
                </h2>
            </div>

            {{-- Contenido --}}
            <main class="flex-1 overflow-y-auto min-w-0 relative">
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

        // Funciones Globales para Modales
        window.openModal = function(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const inner = modal.querySelector('.relative');
                if(inner) {
                    inner.classList.remove('scale-95', 'opacity-0', 'translate-y-4');
                    inner.classList.add('scale-100', 'opacity-100', 'translate-y-0');
                }
            }, 10);
        };

        window.closeModal = function(id) {
            const modal = document.getElementById(id);
            if (!modal) return;

            const inner = modal.querySelector('.relative');
            if(inner) {
                inner.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
                inner.classList.add('scale-95', 'opacity-0', 'translate-y-4');
            }
            modal.classList.add('opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }, 300); // 300ms matches Tailwind duration-300
        };

        // Cerrar modales al hacer clic por fuera
        document.addEventListener('click', function(e) {
            if (e.target.hasAttribute('role') && e.target.getAttribute('role') === 'dialog' && !e.target.classList.contains('hidden')) {
                window.closeModal(e.target.id);
            }
        });

        // Validación Global de Tamaño de Archivos (20MB)
        document.addEventListener('change', function(e) {
            if (e.target.type === 'file') {
                const files = e.target.files;
                let totalSize = 0;
                for (let i = 0; i < files.length; i++) {
                    totalSize += files[i].size;
                }

                const limit = 20 * 1024 * 1024; // 20MB
                if (totalSize > limit) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Archivo demasiado pesado',
                        text: 'El tamaño total de los archivos no debe superar los 20MB. Por favor, reduce el peso de los documentos.',
                        confirmButtonColor: '#1e63e9'
                    });
                    e.target.value = ''; // Limpiar el input
                }
            }
        });

        // Validación al enviar cualquier formulario
        document.addEventListener('submit', function(e) {
            const fileInputs = e.target.querySelectorAll('input[type="file"]');
            let totalSize = 0;
            fileInputs.forEach(input => {
                for (let i = 0; i < input.files.length; i++) {
                    totalSize += input.files[i].size;
                }
            });

            if (totalSize > 20 * 1024 * 1024) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Límite de peso excedido',
                    text: 'La suma de todos los archivos adjuntos supera los 20MB. El registro ha sido bloqueado por seguridad.',
                    confirmButtonColor: '#1e63e9'
                });
            }
        });
    </script>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>

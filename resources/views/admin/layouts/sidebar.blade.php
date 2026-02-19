<!-- Sidebar -->
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

<aside id="sidebar"
    class="fixed md:relative z-50 md:z-auto
           w-64 h-full md:h-full
           -translate-x-full md:translate-x-0
           transition-transform duration-300 ease-in-out
           flex-shrink-0 border-r border-[#cfd7e7]
           dark:border-gray-800 bg-white dark:bg-[#161d2b]
           flex flex-col">



    <div class="p-6 flex items-center gap-3">
        <div class="size-8 bg-primary rounded-lg flex items-center justify-center text-white">
            <span class="material-symbols-outlined">shield_person</span>
        </div>
        <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight tracking-tight">
            {{ auth()->user()->empresa->nomb_empresa ?? 'Sin empresa asignada' }}
        </h2>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
        <div class="flex flex-col gap-1">

            @if (!empty($licenciaBloqueada))
                <!-- SOLO cuando la licencia está vencida -->

                <h1 class="text-[#4c669a] dark:text-gray-400 text-[10px] uppercase font-bold px-3 py-2">
                    Licencia vencida
                </h1>

                <a href="{{ route('admin.planes') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
            text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined">payments</span>
                    <p class="text-sm font-medium leading-normal">Pagar planes</p>
                </a>

                <a href="{{ route('admin.historialp') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
            text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined">corporate_fare</span>
                    <p class="text-sm font-medium">Historial de pagos</p>
                </a>
            @else
                <!-- MENÚ NORMAL (licencia activa) -->

                <h1 class="text-[#4c669a] dark:text-gray-400 text-[10px] uppercase font-bold px-3 py-2">
                    Gestión Central
                </h1>



                <!-- Usuarios -->
                <a href="{{ route('admin.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
            text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined">group</span>
                    <p class="text-sm font-medium">Usuarios</p>
                </a>

                <!-- Pagar planes -->
                <a href="{{ route('admin.planes') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
            text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined">payments</span>
                    <p class="text-sm font-medium leading-normal">Pagar planes</p>
                </a>

                <!-- Historial -->
                <a href="{{ route('admin.historialp') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
            text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined">corporate_fare</span>
                    <p class="text-sm font-medium">Historial de pagos</p>
                </a>

                <!-- Otros -->
                <a href="{{ route('admin.otros') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
   text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">

                    <span class="material-symbols-outlined">
                        format_list_bulleted
                    </span>

                    <p class="text-sm font-medium">
                        Otros
                    </p>
                </a>


                <!-- Configuración -->
                {{-- <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
            text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined">settings</span>
                    <p class="text-sm font-medium">Configuración</p>
                </a> --}}
            @endif

        </div>

    </nav>

    <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800">
        <div class="flex items-center gap-3 px-2">
            <div class="size-10 rounded-full bg-cover bg-center border-2 border-primary/20"
                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDJcGRY-BUZTWEM5ibdEl0CAPx6S68HRHNI75XLKXGYO_z1Yd7z2gBTZpw0ZjxccQMZRPFckRBrh-k7UE4xhSIaLL0haUdYWhwJV-R6N0qYwl3sPmvAFlE9FWn1Q5cnjIBQhPIHL_W1uUjO8qxMuQot0PIQwxRKisYbuWi7hiavy--o7Mj7AxnATmf44PtXGyJwvy_d7zhcMujMnynV0amQBSz0Zd2oZuguH4G1yeeA5wQUDqNieSzOs_pwq9oJk6WCOwYWzncf6FA");'>
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold truncate dark:text-white">
                    {{ auth()->user()->rol->rol_nom }}
                </p>
                <p class="text-xs text-[#4c669a] truncate dark:text-gray-400">
                    {{ auth()->user()->emple_nombres }} {{ auth()->user()->emple_apellidos }}
                </p>
            </div>
        </div>
    </div>
    <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800">
        <!-- Botón Cerrar Sesión -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg
                       text-red-600 dark:text-red-400
                       hover:bg-red-50 dark:hover:bg-red-900/20
                       transition-colors text-sm font-medium">
                <span class="material-symbols-outlined text-base">logout</span>
                Cerrar sesión
            </button>
        </form>
    </div>

</aside>

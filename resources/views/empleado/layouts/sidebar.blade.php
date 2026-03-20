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


            @if (isset($licenciaBloqueada) && $licenciaBloqueada)
                <h1 class="text-[#4c669a] dark:text-gray-400 text-[10px] uppercase font-bold px-3 py-2">
                    Licencia vencida
                </h1>

                <div class="px-3 py-2 rounded-lg text-red-500">
                    <p class="text-sm">Sistema bloqueado.</p>
                </div>
            @else
                <!-- Inicio -->
                <a href="{{ route('empleado.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                    {{ request()->routeIs('empleado.index')
                        ? 'bg-primary/10 text-primary'
                        : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <span class="material-symbols-outlined">home</span>
                    <p class="text-sm font-medium">Inicio</p>
                </a>

                <!-- Correspondencia Recibida -->
                <a href="{{ route('empleado.correspondencia_recibida') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                    {{ request()->routeIs('empleado.correspondencia_recibida')
                        ? 'bg-primary/10 text-primary'
                        : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <span class="material-symbols-outlined">inbox</span>
                    <p class="text-sm font-medium">Correspondencia Recibida</p>
                </a>

                <!-- Correspondencia Finalizada -->
                <a href="{{ route('empleado.correspondencia_finalizada') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                    {{ request()->routeIs('empleado.correspondencia_finalizada')
                        ? 'bg-primary/10 text-primary'
                        : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <p class="text-sm font-medium">Correspondencia Finalizada</p>
                </a>

                <!-- Mis Envíos Internos (NUEVO) -->
                <a href="{{ route('empleado.envios_internos') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                    {{ request()->routeIs('empleado.envios_internos*') || request()->routeIs('empleado.historial_interna')
                        ? 'bg-primary/10 text-primary'
                        : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <span class="material-symbols-outlined">send_and_archive</span>
                    <p class="text-sm font-medium">Mis Envíos Internos</p>
                </a>

                <!-- Reportes -->
                <a href="{{ route('empleado.reportes') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                    {{ request()->routeIs('empleado.reportes')
                        ? 'bg-primary/10 text-primary'
                        : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <span class="material-symbols-outlined">bar_chart</span>
                    <p class="text-sm font-medium">Reportes</p>
                </a>
            @endif

        </div>

    </nav>

    <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-3 px-2 overflow-hidden flex-1">
            <div class="size-10 rounded-full bg-cover bg-center border-2 border-primary/20 flex-shrink-0"
                style='background-image: url("{{ auth()->user()->emple_img ? asset('storage/' . auth()->user()->emple_img) : asset('images/default-avatar.png') }}");'>
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold truncate dark:text-white">
                    {{ auth()->user()->rol->rol_nom ?? 'Empleado' }}
                </p>
                <p class="text-xs text-[#4c669a] truncate dark:text-gray-400">
                    {{ auth()->user()->emple_nombres ?? '' }} {{ auth()->user()->emple_apellidos ?? '' }}
                </p>
            </div>
        </div>
        <!-- Botón Configurar Perfil -->
        <button type="button" onclick="openUserProfileModal()" 
            class="p-1.5 text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" 
            title="Configurar Perfil">
            <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
        </button>
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

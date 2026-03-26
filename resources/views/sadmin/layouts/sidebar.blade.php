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
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-[#161d2b] border-r border-[#cfd7e7] dark:border-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col">

    <div class="p-6 flex items-center gap-3">
        <div class="size-8 bg-primary rounded-lg flex items-center justify-center text-white">
            <span class="material-symbols-outlined">shield_person</span>
        </div>
        <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight tracking-tight">
            Nombre de la empresa
        </h2>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#4c669a] dark:text-gray-400 text-[10px] uppercase font-bold px-3 py-2">
                Gestión Central
            </h1>

            <!-- Resumen -->
            <a href="{{ route('sadmin.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                {{ request()->routeIs('sadmin.index')
                    ? 'bg-primary/10 text-primary'
                    : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <p class="text-sm font-medium">Inicio</p>
            </a>

            <!-- Empresas -->
            <a href="{{ route('empresas') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                {{ request()->routeIs('empresas*')
                    ? 'bg-primary/10 text-primary'
                    : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined">bar_chart</span>
                <p class="text-sm font-medium">Empresas</p>
            </a>

            <!-- Planes -->
            <a href="{{ route('cplanes') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                {{ request()->routeIs('cplanes*')
                    ? 'bg-primary/10 text-primary'
                    : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined">corporate_fare</span>
                <p class="text-sm font-medium">Planes</p>
            </a>

            <!-- Administradores -->
            <a href="{{ route('admins') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
    {{ request()->routeIs('admins*')
        ? 'bg-primary/10 text-primary'
        : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined">group</span>
                <p class="text-sm font-medium">Administradores</p>
            </a>

            <!-- Pagos -->
            <a href="{{ route('sadmin.pagos') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
    {{ request()->routeIs('sadmin.pagos*')
        ? 'bg-primary/10 text-primary'
        : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined">payments</span>
                <p class="text-sm font-medium leading-normal">Pagos</p>
            </a>

            <!-- Licencias -->
            <a href="{{ route('sadmin.licencias') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
    {{ request()->routeIs('sadmin.licencias*')
        ? 'bg-primary/10 text-primary'
        : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined">badge</span>
                <p class="text-sm font-medium leading-normal">Licencias</p>
            </a>


            <!-- Configuración
             
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors
                {{ request()->routeIs('configuracion*')
                    ? 'bg-primary/10 text-primary'
                    : 'text-[#4c669a] dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <span class="material-symbols-outlined">settings</span>
                <p class="text-sm font-medium">Configuración</p>
            </a>
            -->

        </div>
    </nav>

<<<<<<< HEAD
    <div class="mt-auto">
        <div class="p-3 border-t border-[#cfd7e7] dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/20 flex items-center justify-between">
            <div class="flex items-center gap-3 px-2 overflow-hidden flex-1">
                <div class="size-9 rounded-full bg-cover bg-center border border-gray-200 dark:border-gray-700 shrink-0 shadow-sm"
                    style='background-image: url("{{ auth()->user()->emple_img ? asset('storage/' . auth()->user()->emple_img) : asset('images/default-avatar.png') }}");'>
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold truncate text-gray-900 dark:text-white">
                        {{ auth()->user()->rol->rol_nom ?? 'SuperAdmin' }}
                    </p>
                    <p class="text-xs text-[#4c669a] truncate dark:text-gray-400 font-medium">
                        {{ auth()->user()->emple_nombres }} {{ auth()->user()->emple_apellidos }}
                    </p>
                </div>
=======
    <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-3 px-2 overflow-hidden flex-1">
            <div class="size-10 rounded-full bg-cover bg-center border-2 border-primary/20 flex-shrink-0"
                style='background-image: url("{{ auth()->user()->emple_img ? asset('storage/' . auth()->user()->emple_img) : asset('images/default-avatar.png') }}");'>
>>>>>>> Luis
            </div>
            <!-- Botón Configurar Perfil -->
            <button type="button" onclick="openUserProfileModal()" 
                class="p-1.5 text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" 
                title="Configurar Perfil">
                <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
            </button>
        </div>

        <div class="p-3 pt-1 border-t border-transparent">
            <!-- Botón Cerrar Sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg
                           text-red-600 bg-red-50 dark:text-red-400 dark:bg-red-900/10
                           hover:bg-red-100 dark:hover:bg-red-900/30
                           transition-all duration-200 text-sm font-semibold shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</aside>

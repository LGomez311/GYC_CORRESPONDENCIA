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

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }

    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #334155;
    }
</style>

<aside id="sidebar"
    class="fixed md:relative z-50 md:z-auto
           w-64 h-full md:h-full
           -translate-x-full md:translate-x-0
           transition-transform duration-300 ease-in-out
           flex-shrink-0 border-r border-[#cfd7e7]
           dark:border-gray-800 bg-white dark:bg-[#161d2b]
           flex flex-col">

    <div class="p-4 flex items-center gap-3">
        <div
            class="size-8 bg-primary rounded-lg flex items-center justify-center text-white shrink-0 shadow-sm shadow-primary/30">
            <span class="material-symbols-outlined text-[20px]">apartment</span>
        </div>
        <h2 class="text-[#0d121b] dark:text-white text-base font-bold leading-tight tracking-tight truncate">
            {{ auth()->user()->empresa->nomb_empresa ?? 'Sin empresa asignada' }}
        </h2>
    </div>

    <nav class="flex-1 px-4 py-1 space-y-2 overflow-y-auto custom-scrollbar">

        <div class="flex flex-col gap-0.5">
            <h1 class="text-[#4c669a] dark:text-gray-500 text-[10px] uppercase font-bold px-3 pb-1 pt-2 tracking-wider">
                Gestión Central
            </h1>

            {{-- Dashboard --}}
            <a href="{{ route('remitente.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('remitente.index') || request()->is('remitente') ? 'bg-primary/10 text-primary font-bold dark:bg-primary/20' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                <span
                    class="material-symbols-outlined text-[20px] {{ request()->routeIs('remitente.index') || request()->is('remitente') ? 'fill' : '' }}">space_dashboard</span>
                <p class="text-sm leading-normal">Dashboard</p>
            </a>
        </div>

        <div class="flex flex-col gap-0.5">
            <h1 class="text-[#4c669a] dark:text-gray-500 text-[10px] uppercase font-bold px-3 pb-1 pt-2 tracking-wider">
                Trámites Activos
            </h1>

            <a href="{{ route('remitente.recibidos') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('remitente.recibidos') ? 'text-primary bg-primary/10 font-bold dark:bg-primary/20' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                <span
                    class="material-symbols-outlined text-[20px] {{ request()->routeIs('remitente.recibidos') ? 'fill' : 'text-gray-500 dark:text-gray-400' }}">mark_email_unread</span>
                <p class="text-sm font-medium leading-normal">Recibidos</p>
            </a>

            <a href="{{ route('remitente.externaenv') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('remitente.externaenv') ? 'text-primary bg-primary/10 font-bold dark:bg-primary/20' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                <span
                    class="material-symbols-outlined text-[20px] {{ request()->routeIs('remitente.externaenv') ? 'fill' : 'text-gray-500 dark:text-gray-400' }}">forward_to_inbox</span>
                <p class="text-sm font-medium leading-normal">Enviados</p>
            </a>
        </div>

        <div class="flex flex-col gap-0.5">
            <h1 class="text-[#4c669a] dark:text-gray-500 text-[10px] uppercase font-bold px-3 pb-1 pt-2 tracking-wider">
                Reportes
            </h1>

        
        </div>
    </nav>

    <div class="mt-auto">
        <div class="p-3 border-t border-[#cfd7e7] dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/20 flex items-center justify-between">
            <div class="flex items-center gap-3 px-2 overflow-hidden flex-1">
                <div class="size-9 rounded-full bg-cover bg-center border border-gray-200 dark:border-gray-700 shrink-0 shadow-sm"
                    style='background-image: url("{{ auth()->user()->emple_img ? asset('storage/' . auth()->user()->emple_img) : asset('images/default-avatar.png') }}");'>
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold truncate text-gray-900 dark:text-white">
                        Remitente
                    </p>
                    <p class="text-xs text-[#4c669a] truncate dark:text-gray-400 font-medium">
                        {{ auth()->user()->rem_nombres }} {{ auth()->user()->rem_apellidos }}
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

        <div class="p-3 pt-1 border-t border-transparent">
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

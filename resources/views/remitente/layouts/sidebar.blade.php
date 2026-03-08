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

            <h1 class="text-[#4c669a] dark:text-gray-400 text-[10px] uppercase font-bold px-3 py-2">
                Gestión Central
            </h1>

            {{-- Dashboard --}}
            <a href="{{ route('remitente.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('remitente') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                <span class="material-symbols-outlined fill">dashboard</span>
                <p class="text-sm font-bold leading-normal">Dashboard</p>
            </a>

            {{-- INTERNA --}}
            <a href="{{ route('remitente.interna') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('remitente.interna') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                <span
                    class="material-symbols-outlined {{ request()->routeIs('remitente.interna') ? 'fill' : '' }}">inbox</span>
                <p class="text-sm font-medium leading-normal">Interna</p>
            </a>

            {{-- EXTERNA --}}
            {{-- EXTERNA --}}
            <details class="group"
                {{ request()->routeIs('remitente.externarec', 'remitente.externaenv') ? 'open' : '' }}>

                <summary
                    class="flex items-center justify-between w-full gap-3 px-3 py-2 rounded-lg cursor-pointer list-none [&::-webkit-details-marker]:hidden transition-colors {{ request()->routeIs('remitente.externarec', 'remitente.externaenv') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined">outbox</span>
                        <p class="text-sm font-medium leading-normal">Externa</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-sm transition-transform duration-200 group-open:rotate-180">
                        keyboard_arrow_down
                    </span>
                </summary>

                <div class="mt-1 ml-4 border-l-2 border-gray-200 dark:border-gray-600">
                    <a href="{{ route('remitente.externarec') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('remitente.externarec') ? 'text-primary bg-primary/5 font-semibold' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                        <span class="material-symbols-outlined text-base">call_received</span>
                        <p class="text-sm">Recibidos</p>
                    </a>

                    <a href="{{ route('remitente.externaenv') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('remitente.externaenv') ? 'text-primary bg-primary/5 font-semibold' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                        <span class="material-symbols-outlined text-base">send</span>
                        <p class="text-sm">Enviados</p>
                    </a>
                </div>
            </details>
        </div>
    </nav>

    <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800">
        <div class="flex items-center gap-3 px-2">
            <div class="size-10 rounded-full bg-cover bg-center border-2 border-primary/20"
                style='background-image: url("{{ auth()->user()->emple_img ? asset('storage/' . auth()->user()->emple_img) : asset('images/default-avatar.png') }}");'>
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold truncate dark:text-white">
                    Remitente
                </p>
                <p class="text-xs text-[#4c669a] truncate dark:text-gray-400">
                    {{ auth()->user()->rem_nombres }} {{ auth()->user()->rem_apellidos }}
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

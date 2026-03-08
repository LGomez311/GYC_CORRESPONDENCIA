<header
    class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-8 sticky top-0 z-10">
    <div class="flex items-center gap-4 flex-1 max-w-xl">
        <div class="relative w-full">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
            <input
                class="w-full pl-10 pr-4 py-2 bg-background-light dark:bg-slate-800 border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/50 transition-all"
                placeholder="Buscar correspondencia..." type="text" />
        </div>
    </div>
    <div class="flex items-center gap-4">
        <button class="relative p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
            <span class="material-symbols-outlined">notifications</span>
            <span
                class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
        </button>
        <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
            <span class="material-symbols-outlined">help</span>
        </button>
        <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700 mx-2"></div>
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium">{{ auth()->user()->emple_nombres ?? 'Empleado' }}</span>
            <div class="w-9 h-9 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                {{ substr(auth()->user()->emple_nombres ?? 'E', 0, 1) }}
            </div>
        </div>
    </div>
</header>

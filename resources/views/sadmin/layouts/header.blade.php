<header
    class="h-16 bg-white dark:bg-[#161d2b] border-b border-[#cfd7e7] dark:border-gray-800 px-8 flex items-center justify-between sticky top-0 z-10">
    <form method="GET" action="" class="flex items-center gap-4 w-1/3">
        <div class="relative w-full max-w-md">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a]">
                search
            </span>

            <input name="search" value="{{ request('search') }}"
                class="w-full h-10 pl-10 pr-4 bg-background-light dark:bg-background-dark border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/50 dark:text-white"
                placeholder="Buscar..." type="text">
        </div>
    </form>


</header>

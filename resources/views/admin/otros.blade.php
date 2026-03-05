@extends('admin.layouts.app')

@section('title', 'Configuración General')

@section('content')

    <div class="flex flex-col min-h-screen p-4 md:p-8 lg:p-8">

        <!-- ================= HEADER ================= -->
        <header class="mb-1">

            <!-- Title -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white">
                        Otros Modulos
                    </h1>

                    <p class="mt-2 text-lg text-slate-500 dark:text-slate-400">
                        Administre los módulos adicionales del sistema.
                    </p>
                </div>

            </div>

        </header>


        <!-- ================= GRID ================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 flex-1 auto-rows-fr">

            <!-- 1. Área -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col h-full">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">corporate_fare</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Área</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 flex-1">
                    Gestionar sectores organizacionales y departamentos internos de la empresa.
                </p>
                <a href="{{ route('admin.area.index') }}"
                    class="w-full py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span>Administrar</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>

            </div>

            <!-- 2. Ciudad -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col h-full">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">location_city</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Ciudad</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 flex-1">
                    Configurar y actualizar la lista de ciudades habilitadas para operaciones y envíos.
                </p>
                <a href="{{ route('admin.ciudad.index') }}"
                    class="w-full py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span>Administrar</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- 3. Departamento -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col h-full">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">map</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Departamento</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 flex-1">
                    Controlar las divisiones administrativas de alto nivel y regiones geográficas.
                </p>
                <a href="{{ route('admin.departamento.index') }}"
                    class="w-full py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span>Administrar</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>

            </div>

            <!-- 4. Prioridad -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col h-full">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">priority_high</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Prioridad</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 flex-1">
                    Definir niveles de urgencia de  una correspondencia (Alta, Media, Baja).
                </p>
                <a href="{{ route('admin.prioridad.index') }}"
                    class="w-full py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span>Administrar</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- 5. Tipo -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col h-full">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">category</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Tipo correspondencia
                </h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 flex-1">
                    Crea tipos de correspondencia (Interna, Externa, Oficio, etc.).
                </p>
                <a href="{{ route('admin.tipo.index') }}"
                    class="w-full py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span>Administrar</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- 6. Estado -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col h-full">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">dynamic_form</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Estado</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 flex-1">
                    Administrar los estados del flujo de trabajo (Pendiente, En Proceso, Completado).
                </p>
                <a href="{{ route('admin.estado.index') }}"
                    class="w-full py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span>Administrar</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- 7. Rol  -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col h-full">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">person</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Rol</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 flex-1">
                    Administrar los roles de usuarios del sistema.
                </p>
                <a href="{{ route('admin.rol.index') }}"
                    class="w-full py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span>Administrar</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- 8. Radicados -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col h-full">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">pin</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Radicados</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 flex-1">
                    Administrar los números de radicado oficiales del sistema.
                </p>
                <a href="{{ route('admin.radicado.index') }}"
                    class="w-full py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span>Administrar</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

        </div>

    </div>

@endsection

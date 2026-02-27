@extends('admin.layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="w-full max-w-7xl mx-auto p-4 md:px-6 lg:px-8 py-6">
        
        <!-- ================= HEADER ================= -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
            <div>
                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight mb-1">
                    Gestión de Usuarios
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Administra los accesos y perfiles de los empleados de la organización.
                </p>
            </div>
            <button
                class="flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all active:scale-95">
                <span class="material-symbols-outlined text-lg">add</span>
                Crear Nuevo Usuario
            </button>
        </div>

        <!-- ================= STATS GRID ================= -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Usuarios -->
            <div class="bg-white dark:bg-[#161d2b] p-4 rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#4c669a] text-xs font-bold uppercase tracking-wider">Total Usuarios</span>
                    <span class="material-symbols-outlined text-primary">groups</span>
                </div>
                <div class="mt-2 text-2xl font-bold dark:text-white">1,248</div>
            </div>

            <!-- Activos -->
            <div class="bg-white dark:bg-[#161d2b] p-4 rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#4c669a] text-xs font-bold uppercase tracking-wider">Activos</span>
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                </div>
                <div class="mt-2 text-2xl font-bold dark:text-white">1,120</div>
            </div>

            <!-- Inactivos -->
            <div class="bg-white dark:bg-[#161d2b] p-4 rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#4c669a] text-xs font-bold uppercase tracking-wider">Inactivos</span>
                    <span class="material-symbols-outlined text-slate-400">do_not_disturb_on</span>
                </div>
                <div class="mt-2 text-2xl font-bold dark:text-white">128</div>
            </div>

            <!-- Nuevos -->
            <div class="bg-white dark:bg-[#161d2b] p-4 rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#4c669a] text-xs font-bold uppercase tracking-wider">Nuevos (Mes)</span>
                    <span class="material-symbols-outlined text-orange-400">person_add</span>
                </div>
                <div class="mt-2 text-2xl font-bold dark:text-white">42</div>
            </div>
        </div>

        <!-- ================= TABLE ================= -->
        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-background-dark/50 border-b border-[#cfd7e7] dark:border-gray-800">
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Nombre Completo</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Correo Electrónico</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Área</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        <!-- Example Row 1 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-gray-800 flex items-center justify-center font-bold text-xs text-[#4c669a]">
                                        JP
                                    </div>
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">Juan Pérez</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">
                                juan.perez@empresa.com
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                    Administrador
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">IT</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-sm font-medium text-[#0d121b] dark:text-gray-300">Activo</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Ver Detalles">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors" title="Eliminar">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-gray-800 flex items-center justify-center font-bold text-xs text-[#4c669a]">
                                        MG
                                    </div>
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">María García</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">
                                maria.garcia@empresa.com
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    Editor
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">Marketing</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-sm font-medium text-[#0d121b] dark:text-gray-300">Activo</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Ver Detalles">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors" title="Eliminar">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-background-dark/30 border-t border-[#cfd7e7] dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs font-medium text-[#4c669a]">
                    Mostrando 1-2 de 1,248 usuarios
                </span>
                <div class="flex gap-1">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 transition-all disabled:opacity-50" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-xs shadow-sm">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 font-medium text-xs dark:text-gray-300">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 font-medium text-xs dark:text-gray-300">3</button>
                    <span class="flex items-center px-1 text-slate-400">...</span>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 font-medium text-xs dark:text-gray-300">312</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 transition-all">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('admin.layouts.app')


@section('title', 'Panel de Admin de empresa')
<!-- Main Content -->
@section('content')
   
        
        
        <div class="p-1">
            <!-- Page Title and Action -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">Gestión de
                        Usuarios</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Administra los accesos y perfiles de
                        los empleados de la organización.</p>
                </div>
                <button
                    class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold text-sm shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Crear Nuevo Usuario
                </button>
            </div>
            <!-- Stats Overview (Optional but adds to the modern look) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div
                    class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total
                            Usuarios</span>
                        <span class="material-symbols-outlined text-primary">groups</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold">1,248</div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Activos</span>
                        <span class="material-symbols-outlined text-green-500">check_circle</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold">1,120</div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Inactivos</span>
                        <span class="material-symbols-outlined text-slate-400">do_not_disturb_on</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold">128</div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Nuevos
                            (Mes)</span>
                        <span class="material-symbols-outlined text-orange-400">person_add</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold">42</div>
                </div>
            </div>
            <!-- Users Table -->
            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Nombre Completo</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Correo Electrónico</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Rol</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Área</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Estado</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <!-- Row 1 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center font-bold text-xs text-slate-500">
                                            JP</div>
                                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">Juan
                                            Pérez</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    juan.perez@empresa.com</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">Administrador</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">IT</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        <span
                                            class="text-sm font-medium text-slate-700 dark:text-slate-300">Activo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-colors"
                                            title="Ver Detalles">
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center font-bold text-xs text-slate-500">
                                            MG</div>
                                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">María
                                            García</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    maria.garcia@empresa.com</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">Editor</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Marketing</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        <span
                                            class="text-sm font-medium text-slate-700 dark:text-slate-300">Activo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-colors"
                                            title="Ver Detalles">
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Mostrando 1-4 de 1,248
                        usuarios</span>
                    <div class="flex gap-1">
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 disabled:opacity-50 transition-all"
                            disabled="">
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-xs shadow-sm">1</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 font-medium text-xs">2</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 font-medium text-xs">3</button>
                        <span class="flex items-center px-1 text-slate-400">...</span>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 font-medium text-xs">312</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 transition-all">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
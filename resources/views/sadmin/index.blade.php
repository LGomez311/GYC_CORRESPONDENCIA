@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

@section('content')
    <div class="p-8 max-w-7xl mx-auto w-full">
        <!-- Page Heading -->
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                    Panel de Gestión de Licencias</h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">Supervise y controle el ciclo
                    de vida de los servicios de correspondencia.</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Nueva Licencia
                </button>
            </div>
        </div>
        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex justify-between items-start">
                    <p class="text-[#4c669a] dark:text-gray-400 text-sm font-medium leading-normal">Licencias
                        Activas</p>
                    <span class="material-symbols-outlined text-primary">verified</span>
                </div>
                <p class="text-[#0d121b] dark:text-white tracking-tight text-3xl font-bold leading-tight">1,240
                </p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[#07883b] text-sm">trending_up</span>
                    <p class="text-[#07883b] text-xs font-bold leading-normal">+5.4% este mes</p>
                </div>
            </div>
            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex justify-between items-start">
                    <p class="text-[#4c669a] dark:text-gray-400 text-sm font-medium leading-normal">Próximas a
                        Vencer</p>
                    <span class="material-symbols-outlined text-orange-500">warning</span>
                </div>
                <p class="text-[#0d121b] dark:text-white tracking-tight text-3xl font-bold leading-tight">45</p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-orange-500 text-sm">schedule</span>
                    <p class="text-orange-500 text-xs font-bold leading-normal">Vencen en &lt; 30 días</p>
                </div>
            </div>
            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex justify-between items-start">
                    <p class="text-[#4c669a] dark:text-gray-400 text-sm font-medium leading-normal">Inactivas /
                        Suspendidas</p>
                    <span class="material-symbols-outlined text-red-500">block</span>
                </div>
                <p class="text-[#0d121b] dark:text-white tracking-tight text-3xl font-bold leading-tight">12
                </p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-red-500 text-sm">trending_down</span>
                    <p class="text-red-500 text-xs font-bold leading-normal">-2% desde ayer</p>
                </div>
            </div>
        </div>
        <!-- Section: Active Licenses -->
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Listado Detallado de
                    Licencias</h2>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1.5 text-xs font-bold border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-1 dark:text-white">
                        <span class="material-symbols-outlined text-sm">filter_list</span> Filtrar
                    </button>
                    <button
                        class="px-3 py-1.5 text-xs font-bold border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-1 dark:text-white">
                        <span class="material-symbols-outlined text-sm">download</span> Exportar
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Empresa / ID</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Estado</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Tipo de Plan</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                F. Expiración</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-right">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        <!-- Row 1 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">Tech
                                        Solutions S.A.</span>
                                    <span class="text-xs text-[#4c669a] dark:text-gray-400">ID:
                                        LIC-2024-001</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Activa
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">Enterprise Pro</td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">12 Dic, 2024</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Renovar">
                                        <span class="material-symbols-outlined text-[20px]">autorenew</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Suspender">
                                        <span class="material-symbols-outlined text-[20px]">block</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">Logística
                                        Global</span>
                                    <span class="text-xs text-[#4c669a] dark:text-gray-400">ID:
                                        LIC-2024-152</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                    Próxima a vencer
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">Standard Plan</td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">15 Oct, 2024</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-primary hover:scale-110 transition-transform"
                                        title="Renovar Ahora">
                                        <span class="material-symbols-outlined text-[20px]">notification_important</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Suspender">
                                        <span class="material-symbols-outlined text-[20px]">block</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">Inversiones
                                        Delta</span>
                                    <span class="text-xs text-[#4c669a] dark:text-gray-400">ID:
                                        LIC-2023-998</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    Suspendida
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">Basic Monthly</td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">Expirado</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-primary hover:text-primary transition-colors" title="Activar">
                                        <span class="material-symbols-outlined text-[20px]">play_circle</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Eliminar">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">Constructora
                                        Norte</span>
                                    <span class="text-xs text-[#4c669a] dark:text-gray-400">ID:
                                        LIC-2024-405</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Activa
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">Enterprise Pro</td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">20 Feb, 2025</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                        title="Renovar">
                                        <span class="material-symbols-outlined text-[20px]">autorenew</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Suspender">
                                        <span class="material-symbols-outlined text-[20px]">block</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800 flex items-center justify-between">
                <p class="text-xs text-[#4c669a] dark:text-gray-400">Mostrando 4 de 1,240 licencias</p>
                <div class="flex gap-1">
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button
                        class="size-8 flex items-center justify-center rounded bg-primary text-white font-bold text-xs">1</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 text-xs">2</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 text-xs">3</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>



@endsection

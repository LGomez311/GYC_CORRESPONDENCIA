@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

@section('content')
    <div class="p-8 max-w-7xl mx-auto w-full">
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">Gestión de
                    Empresas</h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">Administre el directorio de empresas
                    clientes y sus planes activos.</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Añadir Empresa
                </button>
            </div>
        </div>
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Empresas Registradas</h2>
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
                                Logo / Empresa</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                NIT / ID Fiscal</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Plan Actual</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Usuarios</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Estado</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-right">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                                        <span class="material-symbols-outlined text-gray-400">factory</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">Tech Solutions
                                            S.A.</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">Sector: Tecnología</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">900.123.456-1</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    Enterprise Pro
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">45 / 50</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Activo
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Desactivar">
                                        <span class="material-symbols-outlined text-[20px]">block</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                                        <span class="material-symbols-outlined text-gray-400">local_shipping</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">Logística
                                            Global</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">Sector: Transporte</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">800.555.222-0</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    Standard Plan
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">12 / 15</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Activo
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Desactivar">
                                        <span class="material-symbols-outlined text-[20px]">block</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                                        <span class="material-symbols-outlined text-gray-400">account_balance</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">Inversiones
                                            Delta</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">Sector: Finanzas</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">901.888.333-5</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    Basic Monthly
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">5 / 5</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    Inactivo
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-primary hover:text-primary transition-colors" title="Reactivar">
                                        <span class="material-symbols-outlined text-[20px]">play_circle</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                                        <span class="material-symbols-outlined text-gray-400">apartment</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">Constructora
                                            Norte</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">Sector: Construcción</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">890.111.999-9</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    Enterprise Pro
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-gray-300">10 / 50</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Activo
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                        title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Desactivar">
                                        <span class="material-symbols-outlined text-[20px]">block</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800 flex items-center justify-between">
                <p class="text-xs text-[#4c669a] dark:text-gray-400">Mostrando 4 de 24 empresas registradas</p>
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
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

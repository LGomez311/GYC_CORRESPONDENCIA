@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

@section('content')
    <div class="p-8 max-w-7xl mx-auto w-full">
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                    Validación de Pagos</h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">Gestione y verifique los
                    pagos de servicios realizados por las empresas.</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="px-4 py-2 border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-[#161d2b] rounded-lg font-bold text-sm flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    <span class="material-symbols-outlined text-sm">history</span>
                    Historial de Pagos
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div
                class="flex flex-col gap-2 rounded-xl p-5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <p class="text-[#4c669a] dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                    Pendientes</p>
                <p class="text-[#0d121b] dark:text-white text-2xl font-black">24</p>
                <div class="h-1 bg-orange-100 dark:bg-orange-900/30 rounded-full mt-2">
                    <div class="h-full bg-orange-500 rounded-full w-2/3"></div>
                </div>
            </div>
            <div
                class="flex flex-col gap-2 rounded-xl p-5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <p class="text-[#4c669a] dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                    Verificados Hoy</p>
                <p class="text-[#0d121b] dark:text-white text-2xl font-black">156</p>
                <div class="h-1 bg-green-100 dark:bg-green-900/30 rounded-full mt-2">
                    <div class="h-full bg-green-500 rounded-full w-full"></div>
                </div>
            </div>
            <div
                class="flex flex-col gap-2 rounded-xl p-5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <p class="text-[#4c669a] dark:text-gray-400 text-xs font-bold uppercase tracking-wider">Monto
                    Total Pendiente</p>
                <p class="text-[#0d121b] dark:text-white text-2xl font-black">$4,250.00</p>
                <div class="h-1 bg-blue-100 dark:bg-blue-900/30 rounded-full mt-2">
                    <div class="h-full bg-primary rounded-full w-1/2"></div>
                </div>
            </div>
            <div
                class="flex flex-col gap-2 rounded-xl p-5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <p class="text-[#4c669a] dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                    Denegados (Mes)</p>
                <p class="text-[#0d121b] dark:text-white text-2xl font-black">8</p>
                <div class="h-1 bg-red-100 dark:bg-red-900/30 rounded-full mt-2">
                    <div class="h-full bg-red-500 rounded-full w-1/4"></div>
                </div>
            </div>
        </div>
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Solicitudes de Pago
                    Pendientes</h2>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1.5 text-xs font-bold border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-1 dark:text-white">
                        <span class="material-symbols-outlined text-sm">filter_list</span> Filtrar
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Empresa</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Usuario</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Monto</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                F. Solicitud</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Método de Pago</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Comprobante</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-center">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-[#0d121b] dark:text-white">Tech Solutions
                                    S.A.</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="size-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-[10px] font-bold">JD</span>
                                    </div>
                                    <span class="text-sm text-[#0d121b] dark:text-gray-300">Juan Delgado</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-[#0d121b] dark:text-white">$450.00</td>
                            <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400">12 Oct, 2024 -
                                14:20</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    <span class="material-symbols-outlined text-xs">account_balance</span>
                                    Transferencia
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-[#0d121b] dark:text-white text-xs font-bold rounded flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span> Ver
                                    Comprobante
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white rounded text-xs font-bold hover:bg-green-700 transition-colors shadow-sm"
                                        title="Confirmar Pago">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Confirmar
                                    </button>
                                    <button
                                        class="flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700 transition-colors shadow-sm"
                                        title="Denegar Pago">
                                        <span class="material-symbols-outlined text-sm">cancel</span> Denegar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-[#0d121b] dark:text-white">Logística
                                    Global</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="size-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-[10px] font-bold">MP</span>
                                    </div>
                                    <span class="text-sm text-[#0d121b] dark:text-gray-300">María Pérez</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-[#0d121b] dark:text-white">$1,200.00
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400">12 Oct, 2024 -
                                15:10</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                    <span class="material-symbols-outlined text-xs">credit_card</span> Tarjeta
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-[#0d121b] dark:text-white text-xs font-bold rounded flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span> Ver
                                    Comprobante
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white rounded text-xs font-bold hover:bg-green-700 transition-colors shadow-sm">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Confirmar
                                    </button>
                                    <button
                                        class="flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700 transition-colors shadow-sm">
                                        <span class="material-symbols-outlined text-sm">cancel</span> Denegar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-[#0d121b] dark:text-white">Inversiones
                                    Delta</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="size-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-[10px] font-bold">CR</span>
                                    </div>
                                    <span class="text-sm text-[#0d121b] dark:text-gray-300">Carlos Ruiz</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-[#0d121b] dark:text-white">$300.00</td>
                            <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400">12 Oct, 2024 -
                                16:45</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    <span class="material-symbols-outlined text-xs">account_balance</span>
                                    Transferencia
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-[#0d121b] dark:text-white text-xs font-bold rounded flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span> Ver
                                    Comprobante
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white rounded text-xs font-bold hover:bg-green-700 transition-colors shadow-sm">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Confirmar
                                    </button>
                                    <button
                                        class="flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700 transition-colors shadow-sm">
                                        <span class="material-symbols-outlined text-sm">cancel</span> Denegar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-[#0d121b] dark:text-white">Constructora
                                    Norte</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="size-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-[10px] font-bold">AL</span>
                                    </div>
                                    <span class="text-sm text-[#0d121b] dark:text-gray-300">Ana López</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-[#0d121b] dark:text-white">$2,100.00
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400">13 Oct, 2024 -
                                09:00</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                    <span class="material-symbols-outlined text-xs">money</span> Depósito
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-[#0d121b] dark:text-white text-xs font-bold rounded flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span> Ver
                                    Comprobante
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white rounded text-xs font-bold hover:bg-green-700 transition-colors shadow-sm">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Confirmar
                                    </button>
                                    <button
                                        class="flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded text-xs font-bold hover:bg-red-700 transition-colors shadow-sm">
                                        <span class="material-symbols-outlined text-sm">cancel</span> Denegar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800 flex items-center justify-between">
                <p class="text-xs text-[#4c669a] dark:text-gray-400">Mostrando 4 de 24 solicitudes pendientes
                </p>
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

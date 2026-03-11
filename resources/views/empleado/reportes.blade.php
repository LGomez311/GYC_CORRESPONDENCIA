@extends('empleado.layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reportes de Correspondencia</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Análisis visual de los radicados del mes actual y su estado de trámite.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button class="bg-white dark:bg-slate-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">download</span>
                Exportar PDF
            </button>
            <select class="form-select border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-200 text-sm px-4 py-2">
                <option>Mes Actual (Marzo 2026)</option>
                <option>Febrero 2026</option>
                <option>Enero 2026</option>
                <option>Últimos 3 Meses</option>
                <option>Todo el año 2026</option>
            </select>
        </div>
    </div>

    <!-- Dynamic Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Recibidos -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-blue-50 to-transparent dark:from-blue-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Recibidos</p>
                    <h3 class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $countRecibido }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <span class="material-symbols-outlined">inbox</span>
                </div>
            </div>
        </div>

        <!-- En Trámite -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-yellow-50 to-transparent dark:from-yellow-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">En Trámite</p>
                    <h3 class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $countTramite }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
            </div>
        </div>

        <!-- Finalizados -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-green-50 to-transparent dark:from-green-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Finalizados</p>
                    <h3 class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $countFinalizado }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center text-green-600 dark:text-green-400">
                    <span class="material-symbols-outlined">task_alt</span>
                </div>
            </div>
        </div>

        <!-- Rechazados -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-red-50 to-transparent dark:from-red-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Rechazados</p>
                    <h3 class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $countRechazado }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-red-600 dark:text-red-400">
                    <span class="material-symbols-outlined">cancel</span>
                </div>
            </div>
        </div>

        <!-- Archivados -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-gray-50 to-transparent dark:from-gray-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Archivados</p>
                    <h3 class="text-3xl font-bold text-gray-600 dark:text-gray-400">{{ $countArchivado }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined">folder</span>
                </div>
            </div>
        </div>

        <!-- Total Radicados Únicos -->
        <div class="bg-slate-900 dark:bg-white p-6 rounded-xl border border-transparent shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-primary/20 to-transparent"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-400 dark:text-gray-500 mb-1">Total Único</p>
                    <h3 class="text-3xl font-bold text-white dark:text-gray-900">{{ $totalUnicos }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-white/10 dark:bg-slate-100 flex items-center justify-center text-white dark:text-slate-900">
                    <span class="material-symbols-outlined">tag</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Data Summary -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="font-bold text-lg dark:text-white mb-4">Sumario por Dependencia (Departamentos Asignados)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-medium">Dependencia</th>
                        <th class="px-4 py-3 font-medium text-center">Asignados</th>
                        <th class="px-4 py-3 font-medium text-center">En Trámite</th>
                        <th class="px-4 py-3 font-medium text-center">Finalizados</th>
                        <th class="px-4 py-3 font-medium text-center text-red-500">Vencidos</th>
                        <th class="px-4 py-3 font-medium text-right">Eficiencia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50">
                        <td class="px-4 py-3 font-medium dark:text-gray-300">Jurídica</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">45</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">10</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">35</td>
                        <td class="px-4 py-3 text-center text-red-500">0</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <div class="w-16 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500" style="width: 77%"></div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 border-l border-gray-300 dark:border-gray-600 pl-2">77%</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50">
                        <td class="px-4 py-3 font-medium dark:text-gray-300">Planeación</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">30</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">12</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">15</td>
                        <td class="px-4 py-3 text-center text-red-500 font-medium">3</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <div class="w-16 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400" style="width: 50%"></div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 border-l border-gray-300 dark:border-gray-600 pl-2">50%</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50">
                        <td class="px-4 py-3 font-medium dark:text-gray-300">Talento Humano</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">15</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">5</td>
                        <td class="px-4 py-3 text-center dark:text-gray-300">10</td>
                        <td class="px-4 py-3 text-center text-red-500">0</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <div class="w-16 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500" style="width: 66%"></div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 border-l border-gray-300 dark:border-gray-600 pl-2">66%</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

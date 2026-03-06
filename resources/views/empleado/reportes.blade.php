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

    <!-- Charts area - Top Layer -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Estado de Correspondencia Chart (Pie/Doughnut Placeholder) -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
            <h3 class="font-bold text-lg dark:text-white mb-4">Estado General de Trámites</h3>
            <div class="relative h-64 w-full flex items-center justify-center">
                <!-- Decorative Graphic (Pie Chart lookalike) -->
                <div class="relative w-48 h-48 rounded-full border-[16px] border-blue-500 flex items-center justify-center" style="border-top-color: #3b82f6; border-right-color: #eab308; border-bottom-color: #22c55e; border-left-color: #ef4444;">
                    <div class="text-center">
                        <p class="text-3xl font-bold dark:text-white">124</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Recibidos (40%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">En Trámite (30%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Finalizados (25%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Vencidos (5%)</span>
                </div>
            </div>
        </div>

        <!-- Recepción por día (Bar Chart Placeholder) -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
            <h3 class="font-bold text-lg dark:text-white mb-4">Volumen de Ingreso (Últimos 7 días)</h3>
            <div class="h-64 flex items-end justify-between gap-2 border-b border-l border-gray-200 dark:border-gray-700 p-2 pb-0 opacity-80">
                <div class="w-full bg-blue-500/80 hover:bg-blue-600 transition-colors rounded-t cursor-pointer relative" style="height: 30%;" title="26 Feb: 15 ingresados">
                    <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400">15</span>
                </div>
                <div class="w-full bg-blue-500/80 hover:bg-blue-600 transition-colors rounded-t cursor-pointer relative" style="height: 50%;" title="27 Feb: 25 ingresados">
                    <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400">25</span>
                </div>
                <div class="w-full bg-blue-500/80 hover:bg-blue-600 transition-colors rounded-t cursor-pointer relative" style="height: 40%;" title="28 Feb: 20 ingresados">
                    <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400">20</span>
                </div>
                <div class="w-full bg-blue-500/80 hover:bg-blue-600 transition-colors rounded-t cursor-pointer relative" style="height: 80%;" title="01 Mar: 40 ingresados">
                    <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400">40</span>
                </div>
                <div class="w-full bg-blue-500/80 hover:bg-blue-600 transition-colors rounded-t cursor-pointer relative" style="height: 60%;" title="02 Mar: 30 ingresados">
                    <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400">30</span>
                </div>
                <div class="w-full bg-gray-300 dark:bg-gray-700/80 rounded-t relative" style="height: 10%;" title="03 Mar: 5 (Fin de semana)">
                    <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400">5</span>
                </div>
                <div class="w-full bg-blue-500/80 hover:bg-blue-600 transition-colors rounded-t cursor-pointer relative" style="height: 70%;" title="04 Mar: 35 ingresados">
                    <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400">35</span>
                </div>
            </div>
            <div class="flex justify-between mt-2 px-2 text-xs text-gray-500 dark:text-gray-400">
                <span>26 F</span>
                <span>27 F</span>
                <span>28 F</span>
                <span>01 M</span>
                <span>02 M</span>
                <span>03 M</span>
                <span>04 M</span>
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

@extends('admin.layouts.app')

@section('title', 'Consulta de Correspondencia')

@section('content')
    <div class="w-full max-w-7xl mx-auto p-4 md:px-6 lg:px-8 py-6">
        
        <!-- ================= HEADER ================= -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
            <div>
                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight mb-1">
                    Consulta de Correspondencia
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Vista detallada del historial de documentos recibidos y enviados.
                </p>
            </div>
            <div class="flex gap-3">
                <button
                    class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Exportar
                </button>
            </div>
        </div>

        <!-- ================= STATS GRID ================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Recibidos Hoy -->
            <div class="bg-white dark:bg-[#161d2b] p-6 rounded-2xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-[#4c669a] uppercase tracking-wider">Recibidos Hoy</p>
                    <span class="p-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                        <span class="material-symbols-outlined">inbox</span>
                    </span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold dark:text-white">24</h3>
                    <span class="text-xs font-bold text-emerald-500 flex items-center">
                        <span class="material-symbols-outlined text-[14px]">trending_up</span>
                        12%
                    </span>
                </div>
                <p class="text-xs text-slate-400 dark:text-gray-500 mt-2">Documentos procesados este turno</p>
            </div>

            <!-- Pendientes -->
            <div class="bg-white dark:bg-[#161d2b] p-6 rounded-2xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-[#4c669a] uppercase tracking-wider">Pendientes de Trámite</p>
                    <span class="p-2 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold dark:text-white">08</h3>
                </div>
                <p class="text-xs text-slate-400 dark:text-gray-500 mt-2">Documentos en proceso de revisión</p>
            </div>

            <!-- Enviados -->
            <div class="bg-white dark:bg-[#161d2b] p-6 rounded-2xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-xs font-bold text-[#4c669a] uppercase tracking-wider">Enviados (Mes)</p>
                    <span class="p-2 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                        <span class="material-symbols-outlined">outbox</span>
                    </span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold dark:text-white">342</h3>
                </div>
                <p class="text-xs text-slate-400 dark:text-gray-500 mt-2">Total de envíos registrados este mes</p>
            </div>
        </div>

        <!-- ================= FILTERS ================= -->
        <div class="bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 rounded-2xl p-6 mb-6">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-bold text-[#4c669a] uppercase tracking-wider mb-2">
                        Rango de Fechas
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">calendar_today</span>
                        <input class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-gray-800 border border-[#cfd7e7] dark:border-gray-700 rounded-xl text-sm focus:ring-primary focus:border-primary dark:text-white"
                            type="text" value="01 Dic, 2024 - 15 Dic, 2024" />
                    </div>
                </div>
                <div class="w-full sm:w-48">
                    <label class="block text-xs font-bold text-[#4c669a] uppercase tracking-wider mb-2">Tipo</label>
                    <select class="w-full px-4 py-2.5 bg-slate-50 dark:bg-gray-800 border border-[#cfd7e7] dark:border-gray-700 rounded-xl text-sm focus:ring-primary focus:border-primary dark:text-white">
                        <option>Todos los tipos</option>
                        <option>Recibido Externo</option>
                        <option>Enviado Externo</option>
                        <option>Interno</option>
                    </select>
                </div>
                <div class="w-full sm:w-48">
                    <label class="block text-xs font-bold text-[#4c669a] uppercase tracking-wider mb-2">Estado</label>
                    <select class="w-full px-4 py-2.5 bg-slate-50 dark:bg-gray-800 border border-[#cfd7e7] dark:border-gray-700 rounded-xl text-sm focus:ring-primary focus:border-primary dark:text-white">
                        <option>Cualquier estado</option>
                        <option>Radicado</option>
                        <option>En Trámite</option>
                        <option>Finalizado</option>
                    </select>
                </div>
                <div class="flex gap-2 w-full lg:w-auto">
                    <button class="flex-1 lg:flex-none bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                        Filtrar
                    </button>
                    <button class="flex-1 lg:flex-none px-4 py-2.5 text-[#4c669a] dark:text-gray-400 hover:text-primary transition-colors text-sm font-semibold">
                        Limpiar
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= TABLE ================= -->
        <div class="bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[800px]">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-background-dark/50 border-b border-[#cfd7e7] dark:border-gray-800">
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">No. Radicado / ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Institución / Origen</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Asunto</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Fecha / Hora</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider text-center">Estado</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        <!-- Example Row 1 -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#0d121b] dark:text-white">EXT-2024-00124</span>
                                    <span class="text-xs text-[#4c669a] font-mono">ID: 88412</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-gray-800 flex items-center justify-center text-[#4c669a]">
                                        <span class="material-symbols-outlined text-[18px]">business</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold dark:text-white">Ministerio de Transporte</span>
                                        <span class="text-xs text-[#4c669a]">Bogotá D.C.</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 dark:text-gray-300 max-w-xs truncate">
                                    Solicitud de prórroga licitación corredor vial norte etapa 2...
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm dark:text-white">12 Dic, 2024</span>
                                    <span class="text-xs text-[#4c669a]">09:45 AM</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    Radicado
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Ver detalle">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Descargar Adjunto">
                                        <span class="material-symbols-outlined text-[20px]">attachment</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Repeat rows as needed -->
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-background-dark/30 border-t border-[#cfd7e7] dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-[#4c669a]">
                    Mostrando <span class="font-medium text-[#0d121b] dark:text-white">1</span> a <span class="font-medium text-[#0d121b] dark:text-white">3</span> de <span class="font-medium text-[#0d121b] dark:text-white">124</span> resultados
                </p>
                <div class="flex gap-2">
                    <button class="px-4 py-2 text-sm font-bold text-[#4c669a] bg-white dark:bg-gray-800 border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors disabled:opacity-50" disabled>
                        Anterior
                    </button>
                    <button class="px-4 py-2 text-sm font-bold text-white bg-primary rounded-lg hover:bg-primary/90 transition-colors">
                        Siguiente
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

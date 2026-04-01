@extends('empleado.layouts.app')

@section('title', 'Reporte de Productividad Personal')

@section('content')
<div class="flex-1 flex flex-col p-8 overflow-y-auto bg-slate-50/50 dark:bg-slate-900/50 scroll-smooth">
    <div class="max-w-7xl mx-auto w-full space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-1000">

        <!-- Header Page with Background Effect -->
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary shadow-inner">
                        <span class="material-symbols-outlined !text-4xl">monitoring</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Reporte de Productividad</h1>
                        <p class="text-slate-500 dark:text-slate-400 font-medium mt-1 uppercase text-xs tracking-widest">{{ $rangoFechas }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('empleado.reportes.export.pdf', ['mes' => $mesSelect, 'rango' => $rangoSelect]) }}" target="_blank" 
                       class="group flex items-center gap-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 py-3 rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-200 dark:shadow-none font-bold text-sm">
                        <span class="material-symbols-outlined text-xl group-hover:rotate-12 transition-transform">picture_as_pdf</span>
                        DESCARGAR PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Control Premium -->
        <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl p-2 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <form id="filterForm" action="{{ route('empleado.reportes') }}" method="GET" class="flex flex-wrap items-center gap-4 p-2">
                <div class="flex-1 min-w-[200px] relative">
                    <input type="month" name="mes" value="{{ $mesSelect }}" max="{{ date('Y-m') }}" onchange="document.getElementById('filterForm').submit()" 
                           class="w-full bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl px-4 py-3 font-bold focus:ring-2 focus:ring-primary appearance-none cursor-pointer">
                </div>

                <div class="flex p-1 bg-slate-100 dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <button type="button" onclick="setRango('mes')" class="px-6 py-2 text-xs font-black rounded-xl transition-all {{ $rangoSelect == 'mes' ? 'bg-white dark:bg-slate-700 shadow-lg text-primary' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">Mensual</button>
                    <button type="button" onclick="setRango('trimestre')" class="px-6 py-2 text-xs font-black rounded-xl transition-all {{ $rangoSelect == 'trimestre' ? 'bg-white dark:bg-slate-700 shadow-lg text-primary' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">Trimestre</button>
                    <button type="button" onclick="setRango('anio')" class="px-6 py-2 text-xs font-black rounded-xl transition-all {{ $rangoSelect == 'anio' ? 'bg-white dark:bg-slate-700 shadow-lg text-primary' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">Anual</button>
                </div>
                <input type="hidden" name="rango" id="rangoInput" value="{{ $rangoSelect }}">
            </form>
        </div>

        @php
            $eficienciaActual = $totalDocs > 0 ? round(($countFinalizado / $totalDocs) * 100) : 0;
        @endphp

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Principal Performance Card -->
            <div class="lg:col-span-1 group bg-slate-900 dark:bg-white p-1 rounded-[2rem] shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="bg-slate-800 dark:bg-slate-50 rounded-[1.8rem] p-8 h-full border border-slate-700 dark:border-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-primary/20 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary/40">
                            <span class="material-symbols-outlined !text-3xl">star</span>
                        </div>
                        <div class="text-right">
                             <span class="text-[10px] font-black text-primary uppercase tracking-widest bg-primary/10 px-2 py-1 rounded-lg">Performance</span>
                             <p class="text-[40px] font-black text-white dark:text-slate-900 mt-2 leading-none">{{ $eficienciaActual }}%</p>
                        </div>
                    </div>
                    <h4 class="text-slate-400 dark:text-slate-500 text-sm font-bold uppercase tracking-tighter">Índice de Productividad Personal</h4>
                    <div class="mt-4 w-full h-2 bg-slate-700 dark:bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-primary" style="width: {{ $eficienciaActual }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Volume Detail Cards -->
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                 <!-- Total Card -->
                 <div class="group bg-white dark:bg-slate-900 p-1 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[1.8rem] p-6 h-full border border-white dark:border-slate-700/50">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined">inbox</span>
                            </div>
                            <span class="text-xs font-black text-slate-400">TOTAL</span>
                        </div>
                        <h4 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tighter">Radicados Recibidos</h4>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">{{ $countRecibido }}</span>
                        </div>
                    </div>
                </div>

                <!-- En Tramite Card -->
                <div class="group bg-white dark:bg-slate-900 p-1 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[1.8rem] p-6 h-full border border-white dark:border-slate-700/50">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600">
                                <span class="material-symbols-outlined">pending_actions</span>
                            </div>
                            <span class="text-xs font-black text-slate-400">TRÁMITE</span>
                        </div>
                        <h4 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tighter">En Trámite Actual</h4>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">{{ $countTramite }}</span>
                        </div>
                    </div>
                </div>

                <!-- Finalizados Card -->
                <div class="group bg-white dark:bg-slate-900 p-1 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[1.8rem] p-6 h-full border border-white dark:border-slate-700/50">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600">
                                <span class="material-symbols-outlined">task_alt</span>
                            </div>
                            <span class="text-xs font-black text-slate-400">FINALIZADOS</span>
                        </div>
                        <h4 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tighter">Tareas Completadas</h4>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">{{ $countFinalizado }}</span>
                        </div>
                    </div>
                </div>

                <!-- Vencidos Card -->
                <div class="group bg-white dark:bg-slate-900 p-1 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[1.8rem] p-6 h-full border border-white dark:border-slate-700/50">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-500/10 rounded-2xl flex items-center justify-center text-red-600">
                                <span class="material-symbols-outlined">running_with_errors</span>
                            </div>
                            <span class="text-xs font-black text-slate-400">CRÍTICO</span>
                        </div>
                        <h4 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tighter">Radicados Vencidos</h4>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-4xl font-black {{ $countVencidos > 0 ? 'text-red-500' : 'text-slate-900 dark:text-white' }}">{{ $countVencidos }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactive Chart Section -->
        <div class="bg-white/50 dark:bg-slate-900/50 backdrop-blur-md rounded-[2.5rem] p-8 border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Análisis de Operaciones</h3>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Desglose porcentual y numérico por estado</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.1em] uppercase shadow-sm">
                        TOTAL: {{ $totalDocs }} DOCS
                    </div>
                    <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400">
                        <span class="material-symbols-outlined text-xl">insights</span>
                    </div>
                </div>
            </div>
            
            <div class="h-[450px] w-full">
                <canvas id="metricsChart"></canvas>
            </div>
        </div>

        <!-- Archivo & Rechazo Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-8">
            <div class="bg-slate-100 dark:bg-slate-800/50 p-6 rounded-3xl flex items-center gap-5 border border-slate-200 dark:border-slate-700">
                <div class="w-14 h-14 bg-slate-900 dark:bg-white rounded-2xl flex items-center justify-center text-white dark:text-slate-900">
                    <span class="material-symbols-outlined">inventory</span>
                </div>
                <div>
                    <h5 class="text-xs font-black text-slate-400 uppercase tracking-widest">Documentos Archivados</h5>
                    <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $countArchivado }}</p>
                </div>
            </div>

            <div class="bg-red-50 dark:bg-red-900/10 p-6 rounded-3xl flex items-center gap-5 border border-red-100 dark:border-red-900/30">
                <div class="w-14 h-14 bg-red-500 rounded-2xl flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">block</span>
                </div>
                <div>
                    <h5 class="text-xs font-black text-red-400/80 uppercase tracking-widest">Radicados Rechazados</h5>
                    <p class="text-2xl font-black text-red-600 dark:text-red-400">{{ $countRechazado }}</p>
                </div>
            </div>
        </div>



        <!-- ====================================================== -->
        <!-- NUEVA SECCIÓN: EXPORTAR CORRESPONDENCIA A PDF            -->
        <!-- ====================================================== -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden relative">
            <!-- Decoración de fondo -->
            <div class="absolute top-0 right-0 w-48 h-48 bg-primary/5 rounded-full -translate-y-16 translate-x-16 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-500/5 rounded-full translate-y-10 -translate-x-10 pointer-events-none"></div>

            <!-- Header de la sección -->
            <div class="relative p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-700 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                        <span class="material-symbols-outlined text-2xl">picture_as_pdf</span>
                    </div>
                    <div>
                        <h3 class="font-black text-lg text-slate-900 dark:text-white tracking-tight">Exportar Correspondencia a PDF</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Aplica los filtros y exporta exactamente lo que ves en pantalla.</p>
                    </div>
                </div>
                <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl">
                    <span class="material-symbols-outlined text-blue-500 text-sm">info</span>
                    <span class="text-[10px] font-bold text-blue-700 dark:text-blue-300">El PDF refleja exactamente los filtros aplicados</span>
                </div>
            </div>

            <!-- Formulario de filtros -->
            <form id="correspondenciaExportForm"
                  method="GET"
                  action="{{ route('empleado.reportes.export.correspondencia.pdf') }}"
                  class="relative p-6 space-y-6">

                <!-- Fila 1: Fechas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Desde -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">
                            <span class="material-symbols-outlined text-[12px] align-middle">calendar_today</span>
                            Fecha Desde
                        </label>
                        <input type="date" name="desde" id="filtro_desde"
                               value="{{ request('desde') }}"
                               max="{{ date('Y-m-d') }}"
                               class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-semibold p-3 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all dark:text-white outline-none">
                    </div>

                    <!-- Hasta -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">
                            <span class="material-symbols-outlined text-[12px] align-middle">event</span>
                            Fecha Hasta
                        </label>
                        <input type="date" name="hasta" id="filtro_hasta"
                               value="{{ request('hasta', date('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}"
                               class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-semibold p-3 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all dark:text-white outline-none">
                    </div>

                    <!-- Área -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">
                            <span class="material-symbols-outlined text-[12px] align-middle">corporate_fare</span>
                            Área / Dependencia
                        </label>
                        <div class="relative">
                            <select name="area_id" id="filtro_area"
                                    class="w-full appearance-none bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-semibold p-3 pr-10 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all dark:text-white outline-none">
                                <option value="">Todas las áreas</option>
                                @if(isset($areas) && $areas->count())
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id_area }}" {{ request('area_id') == $area->id_area ? 'selected' : '' }}>
                                            {{ $area->area_nom }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-slate-400 text-sm">expand_more</span>
                        </div>
                    </div>

                    <!-- Tipo Documento -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">
                            <span class="material-symbols-outlined text-[12px] align-middle">description</span>
                            Tipo de Documento
                        </label>
                        <div class="relative">
                            <select name="tipo_id" id="filtro_tipo"
                                    class="w-full appearance-none bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-semibold p-3 pr-10 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all dark:text-white outline-none">
                                <option value="">Todos los tipos</option>
                                @if(isset($tipos) && $tipos->count())
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}" {{ request('tipo_id') == $tipo->id_tipo ? 'selected' : '' }}>
                                            {{ $tipo->tipo_nombre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-slate-400 text-sm">expand_more</span>
                        </div>
                    </div>
                </div>

                <!-- Fila 2: Estado + Previsualización de filtros + Botones -->
                <div class="flex flex-wrap items-end gap-4">
                    <!-- Estado -->
                    <div class="w-full sm:w-56">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">
                            <span class="material-symbols-outlined text-[12px] align-middle">flag</span>
                            Estado
                        </label>
                        <div class="relative">
                            <select name="estado_id" id="filtro_estado"
                                    class="w-full appearance-none bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-semibold p-3 pr-10 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all dark:text-white outline-none">
                                <option value="">Todos los estados</option>
                                @foreach(\App\Models\Estado::whereIn('id_estado',[7,8,9,10,11,12,13,14,15])->get() as $est)
                                    <option value="{{ $est->id_estado }}" {{ request('estado_id') == $est->id_estado ? 'selected' : '' }}>
                                        {{ $est->estado_nomb }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-slate-400 text-sm">expand_more</span>
                        </div>
                    </div>

                    <!-- Preview de filtros activos -->
                    <div id="filtrosPreview" class="flex-1 hidden">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Filtros a aplicar</p>
                        <div id="filtrosTagsContainer" class="flex flex-wrap gap-2 min-h-[38px] bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl px-3 py-2">
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex gap-3 ml-auto">
                        <!-- Limpiar -->
                        <button type="button" id="btnLimpiarFiltros"
                                class="flex items-center gap-2 px-5 py-3 text-sm font-bold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-2xl transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                            Limpiar
                        </button>
                        <!-- Vista previa -->
                        <button type="button" id="btnPreviewFiltros"
                                class="flex items-center gap-2 px-5 py-3 text-sm font-bold text-blue-600 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 border border-blue-200 dark:border-blue-800 rounded-2xl transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                            Ver Filtros
                        </button>
                        <!-- Exportar PDF -->
                        <button type="submit"
                                class="group flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-primary to-blue-700 hover:from-blue-700 hover:to-primary rounded-2xl transition-all shadow-lg shadow-primary/30 hover:shadow-primary/50 active:scale-95">
                            <span class="material-symbols-outlined text-[20px] group-hover:rotate-12 transition-transform">picture_as_pdf</span>
                            Exportar PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- FIN SECCIÓN EXPORTAR CORRESPONDENCIA -->


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function setRango(val) {
        document.getElementById('rangoInput').value = val;
        document.getElementById('filterForm').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('metricsChart').getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#94a3b8' : '#64748b';
        const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

        const data = {
            labels: ['Recibidos', 'En Trámite', 'Finalizados', 'Rechazados', 'Archivados', 'Vencidos'],
            datasets: [{
                label: 'Docs',
                data: [
                    {{ $countRecibido }},
                    {{ $countTramite }},
                    {{ $countFinalizado }},
                    {{ $countRechazado }},
                    {{ $countArchivado }},
                    {{ $countVencidos }}
                ],
                backgroundColor: [
                    '#3b82f6',  
                    '#f59e0b',   
                    '#10b981',   
                    '#ef4444',   
                    '#64748b', 
                    '#f97316'   
                ],
                borderRadius: 20,
                borderSkipped: false,
                barThickness: 50,
            }]
        };

        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 12,
                        backgroundColor: isDark ? '#1e293b' : '#ffffff',
                        titleColor: isDark ? '#ffffff' : '#1e293b',
                        bodyColor: textColor,
                        bodyFont: { weight: 'bold' },
                        borderColor: gridColor,
                        borderWidth: 1,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: textColor, font: { weight: 'bold' }, precision: 0 },
                        grid: { color: gridColor }
                    },
                    x: {
                        ticks: { color: textColor, font: { weight: 'bold', size: 11 } },
                        grid: { display: false }
                    }
                }
            }
        });
    });


    // ======= CORRESPONDENCIA EXPORT - FILTROS PREVIEW =======
    const FILTROS_LABELS = {
        'filtro_desde':  { label: 'Desde',    type: 'date'   },
        'filtro_hasta':  { label: 'Hasta',    type: 'date'   },
        'filtro_area':   { label: 'Área',     type: 'select' },
        'filtro_tipo':   { label: 'Tipo Doc.',type: 'select' },
        'filtro_estado': { label: 'Estado',   type: 'select' },
    };

    function buildFilterTags() {
        const container = document.getElementById('filtrosTagsContainer');
        const preview   = document.getElementById('filtrosPreview');
        if (!container) return;
        container.innerHTML = '';
        let hasTags = false;

        Object.keys(FILTROS_LABELS).forEach(function(id) {
            const info = FILTROS_LABELS[id];
            const el   = document.getElementById(id);
            if (!el || !el.value) return;

            let display = el.value;
            if (info.type === 'select') {
                const opt = el.options[el.selectedIndex];
                display = opt ? opt.text : el.value;
            } else if (info.type === 'date') {
                try {
                    const parts = el.value.split('-');
                    display = parts[2]+'/'+parts[1]+'/'+parts[0];
                } catch(e) { display = el.value; }
            }

            const tag = document.createElement('span');
            tag.className = 'inline-flex items-center gap-1 px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-[11px] font-bold rounded-full border border-blue-200 dark:border-blue-700';
            tag.innerHTML = '<span class="text-blue-400">'+info.label+':</span> '+display+
                ' <button type="button" onclick="clearFilter(\''+id+'\')" class="ml-1 hover:text-red-500 transition-colors"><span class="material-symbols-outlined" style="font-size:13px;">close</span></button>';
            container.appendChild(tag);
            hasTags = true;
        });

        if (!hasTags) {
            container.innerHTML = '<span style="font-size:11px;color:#94a3b8;font-style:italic">Sin filtros activos — se exportará toda la correspondencia.</span>';
        }
        preview.classList.remove('hidden');
    }

    window.clearFilter = function(id) {
        const el = document.getElementById(id);
        if (el) el.value = '';
        buildFilterTags();
    };

    document.addEventListener('DOMContentLoaded', function() {
        const btnPrev = document.getElementById('btnPreviewFiltros');
        if (btnPrev) btnPrev.addEventListener('click', buildFilterTags);

        const btnLimp = document.getElementById('btnLimpiarFiltros');
        if (btnLimp) btnLimp.addEventListener('click', function() {
            ['filtro_desde','filtro_hasta','filtro_area','filtro_tipo','filtro_estado'].forEach(function(id) {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            const container = document.getElementById('filtrosTagsContainer');
            const preview   = document.getElementById('filtrosPreview');
            if (container) container.innerHTML = '';
            if (preview)   preview.classList.add('hidden');
        });

        // Auto-mostrar tags si hay params en URL
        const params = new URLSearchParams(window.location.search);
        if (['desde','hasta','area_id','tipo_id','estado_id'].some(k => params.has(k) && params.get(k))) {
            buildFilterTags();
        }
    });


</script>
@endsection

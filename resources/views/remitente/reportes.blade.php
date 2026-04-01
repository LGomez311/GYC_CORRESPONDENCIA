@extends('remitente.layouts.app')

@section('title', 'Reporte de Gestión Estratégica')

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
                    <span class="material-symbols-outlined text-4xl">analytics</span>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Reporte de Gestión</h1>
                    <p class="text-sm text-slate-500 dark:text-gray-400 mt-1 font-medium italic">
                        Análisis detallado de eficiencia y carga de trabajo institucional.
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <form id="exportForm" action="{{ route('remitente.reportes.export.pdf') }}" method="POST">
                    @csrf
                    <input type="hidden" name="periodo" value="{{ request('periodo') }}">
                    <input type="hidden" name="fecha" value="{{ request('fecha') }}">
                    <input type="hidden" name="mes" value="{{ request('mes') }}">
                    <input type="hidden" name="trimestre" value="{{ request('trimestre') }}">
                    <input type="hidden" name="ano" value="{{ request('ano') }}">
                    <input type="hidden" name="barChart" id="barChartData">
                    <input type="hidden" name="doughnutChart" id="doughnutChartData">
                    
                    <button type="button" onclick="exportToPdf()" class="group flex items-center gap-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 py-3 rounded-2xl transition-all shadow-xl hover:scale-105 active:scale-95 text-sm font-bold">
                        <span class="material-symbols-outlined text-xl transition-transform group-hover:rotate-12">picture_as_pdf</span>
                        Exportar Reporte
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if(isset($mensaje))
        <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-400 p-6 rounded-2xl animate-pulse">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-800 rounded-full flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined">warning</span>
                </div>
                <p class="text-sm font-bold text-amber-800 dark:text-amber-400">{{ $mensaje }}</p>
            </div>
        </div>
    @else
        <!-- Stats Summary Cards -->
        @php
            $totalAsignados = collect($reporteAreas)->sum('asignados');
            $totalTramite = collect($reporteAreas)->sum('tramite');
            $totalFinalizado = collect($reporteAreas)->sum('finalizado');
            $totalVencidos = collect($reporteAreas)->sum('vencidos');
            $eficienciaGlobal = $totalAsignados > 0 ? round(($totalFinalizado / $totalAsignados) * 100) : 0;
        @endphp
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat: Total -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 group">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl">inbox</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Total Asignados</p>
                        <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalAsignados) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Stat: Tramite -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 group">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center text-amber-600 dark:text-amber-400 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl">pending</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">En Proceso</p>
                        <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalTramite) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Stat: Finalizados -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 group">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl">task_alt</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Finalizados</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalFinalizado) }}</h3>
                            <span class="text-xs font-bold text-emerald-600">{{ $eficienciaGlobal }}% de éxito</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat: Vencidos -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 group">
                <div class="flex flex-col gap-4">
                    <div class="w-12 h-12 bg-rose-50 dark:bg-rose-900/30 rounded-2xl flex items-center justify-center text-rose-600 dark:text-rose-400 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl">warning</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Registros Vencidos</p>
                        <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1 text-rose-600">{{ number_format($totalVencidos) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seccion: Distribucion por Tipo -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-100/50 dark:bg-slate-800/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                <div>
                    <h4 class="text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-widest">Interna</h4>
                    <p class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $resumenTipos['Interna'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center text-indigo-600">
                    <span class="material-symbols-outlined text-xl">corporate_fare</span>
                </div>
            </div>
            <div class="bg-slate-100/50 dark:bg-slate-800/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                <div>
                    <h4 class="text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-widest">Externa</h4>
                    <p class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $resumenTipos['Externa'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-orange-50 dark:bg-orange-900/30 rounded-xl flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined text-xl">mail</span>
                </div>
            </div>
            <div class="bg-slate-100/50 dark:bg-slate-800/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                <div>
                    <h4 class="text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-widest">Saliente</h4>
                    <p class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $resumenTipos['Saliente'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-xl">send</span>
                </div>
            </div>
        </div>

        <!-- Filter Control Panel -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm overflow-hidden relative">
            <form method="GET" action="{{ route('remitente.reportes') }}" class="flex flex-wrap items-end gap-6 relative z-10">
                <div class="w-full sm:w-auto min-w-[180px]">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Escenario Temporal</label>
                    <div class="relative">
                        <select name="periodo" id="periodo" onchange="toggleFiltros()" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold p-3.5 focus:ring-2 focus:ring-primary/20 transition-all dark:text-white appearance-none">
                            <option value="todo" {{ request('periodo') == 'todo' ? 'selected' : '' }}>Histórico Completo</option>
                            <option value="dia" {{ request('periodo') == 'dia' ? 'selected' : '' }}>Día Específico</option>
                            <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Mensual</option>
                            <option value="trimestre" {{ request('periodo') == 'trimestre' ? 'selected' : '' }}>Trimestral</option>
                            <option value="ano" {{ request('periodo') == 'ano' ? 'selected' : '' }}>Anual</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <!-- Dinámicos -->
                <div id="divDia" class="filter-group hidden w-full sm:w-auto min-w-[180px]">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Seleccionar Fecha</label>
                    <input type="date" name="fecha" value="{{ request('fecha', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold p-3.5 focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                </div>

                <div id="divMes" class="filter-group hidden w-full sm:w-auto min-w-[180px]">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Mes de Gestión</label>
                    <input type="month" name="mes" value="{{ request('mes', date('Y-m')) }}" max="{{ date('Y-m') }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold p-3.5 focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                </div>

                <div id="divTrimestre" class="filter-group hidden w-full sm:w-auto min-w-[180px]">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Trimestre Académico/Fiscal</label>
                    <div class="relative">
                        <select name="trimestre" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold p-3.5 focus:ring-2 focus:ring-primary/20 transition-all dark:text-white appearance-none">
                            <option value="1" {{ request('trimestre') == '1' ? 'selected' : '' }}>1º Trimestre (Ene-Mar)</option>
                            <option value="2" {{ request('trimestre') == '2' ? 'selected' : '' }}>2º Trimestre (Abr-Jun)</option>
                            <option value="3" {{ request('trimestre') == '3' ? 'selected' : '' }}>3º Trimestre (Jul-Sep)</option>
                            <option value="4" {{ request('trimestre') == '4' ? 'selected' : '' }}>4º Trimestre (Oct-Dic)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <div id="divAno" class="filter-group hidden w-full sm:w-auto min-w-[120px]">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Año</label>
                    <div class="relative">
                        <select name="ano" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm font-bold p-3.5 focus:ring-2 focus:ring-primary/20 transition-all dark:text-white appearance-none">
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('ano') == $y || (!request('ano') && $y == date('Y')) ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <button type="submit" class="flex-1 sm:flex-none bg-primary text-white px-8 py-3.5 rounded-2xl text-sm font-black transition-all shadow-lg shadow-primary/30 hover:shadow-primary/40 active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">filter_list</span>
                    Sincronizar Datos
                </button>
            </form>
        </div>

        <!-- Charts Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Workload Chart -->
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="font-black text-lg dark:text-white tracking-tight">Carga por Dependencia</h3>
                        <p class="text-xs text-slate-500">Distribución de correspondencia asignada vs finalizada.</p>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-2xl text-blue-600">
                        <span class="material-symbols-outlined">bar_chart</span>
                    </div>
                </div>
                <div class="h-80 relative">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <!-- Efficiency Doughnut -->
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="font-black text-lg dark:text-white tracking-tight">Índice de Eficiencia</h3>
                        <p class="text-xs text-slate-500">Porcentaje de éxito resolutivo por departamento.</p>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl text-emerald-600">
                        <span class="material-symbols-outlined">pie_chart</span>
                    </div>
                </div>
                <div class="h-80 relative flex justify-center items-center">
                    <canvas id="doughnutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $eficienciaGlobal }}%</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Global</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics Table -->
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
                <div>
                    <h3 class="font-black text-xl dark:text-white tracking-tight">Eficiencia de Áreas</h3>
                    <p class="text-xs text-slate-500 mt-1">Desglose numérico por dependencia organizacional.</p>
                </div>
                <div class="hidden sm:flex gap-2">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                        <span class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Excelente</span>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl">
                        <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                        <span class="text-[10px] font-bold text-slate-600 dark:text-slate-400">En Mejora</span>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-800/40 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.15em] border-b border-slate-100 dark:border-slate-800">
                            <th class="px-8 py-5">Dependencia</th>
                            <th class="px-6 py-5 text-center">Asignados</th>
                            <th class="px-6 py-5 text-center">En Trámite</th>
                            <th class="px-6 py-5 text-center">Finalizados</th>
                            <th class="px-6 py-5 text-center text-rose-500">Fuera de Término</th>
                            <th class="px-8 py-5 text-right">Eficiencia Percibida</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($reporteAreas as $area)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 group-hover:scale-110 transition-transform shadow-sm">
                                            <span class="material-symbols-outlined text-lg">corporate_fare</span>
                                        </div>
                                        <span class="font-bold text-slate-700 dark:text-slate-200">{{ $area['area_nom'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center font-bold text-slate-600 dark:text-slate-400">{{ $area['asignados'] }}</td>
                                <td class="px-6 py-5 text-center font-bold text-amber-600">{{ $area['tramite'] }}</td>
                                <td class="px-6 py-5 text-center font-bold text-emerald-600">{{ $area['finalizado'] }}</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-black {{ $area['vencidos'] > 0 ? 'bg-rose-50 text-rose-600 dark:bg-rose-900/20' : 'text-slate-300' }}">
                                        {{ $area['vencidos'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col items-end gap-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-black {{ $area['eficiencia'] >= 70 ? 'text-emerald-500' : ($area['eficiencia'] >= 45 ? 'text-amber-500' : 'text-rose-500') }}">
                                                {{ $area['eficiencia'] }}%
                                            </span>
                                        </div>
                                        <div class="w-32 h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden shadow-inner">
                                            <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $area['eficiencia'] >= 70 ? 'bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.3)]' : ($area['eficiencia'] >= 45 ? 'bg-amber-500 shadow-[0_0_10px_rgba(245,158,11,0.3)]' : 'bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.3)]') }}" 
                                                 style="width: {{ $area['eficiencia'] }}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4 opacity-50">
                                        <span class="material-symbols-outlined text-6xl">database_off</span>
                                        <p class="font-bold text-slate-400 italic">No se encontraron registros en la línea temporal seleccionada.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.exportToPdf = function() {
        const barCanvas = document.getElementById('barChart');
        const doughnutCanvas = document.getElementById('doughnutChart');

        if (!barCanvas || !doughnutCanvas) {
            alert('Gráficas no disponibles.');
            return;
        }

        document.getElementById('barChartData').value = barCanvas.toDataURL("image/png");
        document.getElementById('doughnutChartData').value = doughnutCanvas.toDataURL("image/png");
        document.getElementById('exportForm').submit();
    }

    window.toggleFiltros = function() {
        const periodo = document.getElementById('periodo').value;
        const groups = document.querySelectorAll('.filter-group');
        groups.forEach(g => g.classList.add('hidden'));

        if (periodo === 'dia') {
            document.getElementById('divDia').classList.remove('hidden');
        } else if (periodo === 'mes') {
            document.getElementById('divMes').classList.remove('hidden');
        } else if (periodo === 'trimestre') {
            document.getElementById('divTrimestre').classList.remove('hidden');
            document.getElementById('divAno').classList.remove('hidden');
        } else if (periodo === 'ano') {
            document.getElementById('divAno').classList.remove('hidden');
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        toggleFiltros();

        const dataAreas = @json($reporteAreas);
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#94a3b8' : '#64748b';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.03)';
        
        if (dataAreas.length > 0) {
            const labels = dataAreas.map(item => item.area_nom);
            const asignados = dataAreas.map(item => item.asignados);
            const finalizados = dataAreas.map(item => item.finalizado);
            const eficiencias = dataAreas.map(item => item.eficiencia);

            // Chart Configuration: Bar
            new Chart(document.getElementById('barChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Asignados',
                            data: asignados,
                            backgroundColor: '#3b82f6',
                            borderRadius: 12,
                            borderSkipped: false,
                            barThickness: 24,
                        },
                        {
                            label: 'Finalizados',
                            data: finalizados,
                            backgroundColor: '#10b981',
                            borderRadius: 12,
                            borderSkipped: false,
                            barThickness: 24,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            position: 'top',
                            align: 'end',
                            labels: {
                                color: textColor,
                                font: { weight: 'bold', size: 10 },
                                boxWidth: 8,
                                boxHeight: 8,
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: isDark ? '#1e293b' : '#ffffff',
                            titleColor: isDark ? '#ffffff' : '#1e293b',
                            bodyColor: isDark ? '#94a3b8' : '#64748b',
                            padding: 12,
                            cornerRadius: 16,
                            borderWidth: 1,
                            borderColor: gridColor
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: gridColor, drawBorder: false },
                            ticks: { color: textColor, font: { size: 10, weight: 'bold' } }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { color: textColor, font: { size: 10, weight: 'bold' } }
                        }
                    }
                }
            });

            // Chart Configuration: Doughnut
            new Chart(document.getElementById('doughnutChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: eficiencias,
                        backgroundColor: [
                            '#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#f43f5e', '#06b6d4', '#ec4899'
                        ],
                        borderWidth: isDark ? 8 : 4,
                        borderColor: isDark ? '#0f172a' : '#ffffff',
                        hoverOffset: 20,
                        hoverBorderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { 
                        legend: { 
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => ` ${context.label}: ${context.raw}% de Eficiencia`
                            },
                            backgroundColor: isDark ? '#1e293b' : '#ffffff',
                            titleColor: isDark ? '#ffffff' : '#1e293b',
                            padding: 15,
                            cornerRadius: 16
                        }
                    }
                }
            });
        }
    });
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fade-in 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection

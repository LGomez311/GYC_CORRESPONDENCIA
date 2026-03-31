@extends('admin.layouts.app')

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
                        <span class="material-symbols-outlined !text-4xl">analytics</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Reporte General de Gestión</h1>
                        <p class="text-slate-500 dark:text-slate-400 font-medium mt-1 uppercase text-xs tracking-widest">Panel de Control Administrativo · {{ date('Y') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <form id="exportForm" action="{{ route('admin.reportes.export.pdf') }}" method="POST">
                        @csrf
                        <input type="hidden" name="periodo" value="{{ request('periodo') }}">
                        <input type="hidden" name="fecha" value="{{ request('fecha') }}">
                        <input type="hidden" name="mes" value="{{ request('mes') }}">
                        <input type="hidden" name="trimestre" value="{{ request('trimestre') }}">
                        <input type="hidden" name="ano" value="{{ request('ano') }}">
                        <input type="hidden" name="tipo_doc" value="{{ request('tipo_doc') }}">
                        <input type="hidden" name="estado_rep" value="{{ request('estado_rep') }}">
                        <input type="hidden" name="area_id" value="{{ request('area_id') }}">
                        <input type="hidden" name="barChart" id="barChartData">
                        <input type="hidden" name="doughnutChart" id="doughnutChartData">
                        
                        <button type="button" onclick="exportToPdf()" class="group flex items-center gap-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 py-3 rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-200 dark:shadow-none font-bold text-sm">
                            <span class="material-symbols-outlined text-xl group-hover:rotate-12 transition-transform">picture_as_pdf</span>
                            EXPORTAR REPORTE
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(isset($mensaje))
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-6 rounded-3xl flex items-center gap-4 animate-pulse">
                <span class="material-symbols-outlined text-amber-500 text-3xl">warning</span>
                <p class="text-amber-800 dark:text-amber-400 font-bold">{{ $mensaje }}</p>
            </div>
        @else
            <!-- Control de Filtros Premium -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl p-2 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <form method="GET" action="{{ route('admin.reportes') }}" class="flex flex-wrap items-center gap-4 p-2">
                    <div class="flex-1 min-w-[200px] relative">
                        <select name="periodo" id="periodo" onchange="toggleFiltros()" class="w-full bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl focus:ring-2 focus:ring-primary appearance-none px-4 py-3 font-bold">
                            <option value="todo" {{ request('periodo') == 'todo' ? 'selected' : '' }}>Historico Completo</option>
                            <option value="dia" {{ request('periodo') == 'dia' ? 'selected' : '' }}>Reporte Diario</option>
                            <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Reporte Mensual</option>
                            <option value="trimestre" {{ request('periodo') == 'trimestre' ? 'selected' : '' }}>Reporte Trimestral</option>
                            <option value="ano" {{ request('periodo') == 'ano' ? 'selected' : '' }}>Reporte Anual</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <span class="material-symbols-outlined">expand_more</span>
                        </div>
                    </div>

                    <div id="divDia" class="filter-group hidden">
                        <input type="date" name="fecha" value="{{ request('fecha') }}" max="{{ date('Y-m-d') }}" class="bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl px-4 py-3 font-bold focus:ring-2 focus:ring-primary">
                    </div>

                    <div id="divMes" class="filter-group hidden">
                        <input type="month" name="mes" value="{{ request('mes') }}" max="{{ date('Y-m') }}" class="bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl px-4 py-3 font-bold focus:ring-2 focus:ring-primary">
                    </div>

                    <div id="divTrimestre" class="filter-group hidden">
                        <select name="trimestre" class="bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl px-4 py-3 font-bold focus:ring-2 focus:ring-primary">
                            <option value="1" {{ request('trimestre') == '1' ? 'selected' : '' }}>1er Trimestre</option>
                            <option value="2" {{ request('trimestre') == '2' ? 'selected' : '' }}>2do Trimestre</option>
                            <option value="3" {{ request('trimestre') == '3' ? 'selected' : '' }}>3er Trimestre</option>
                            <option value="4" {{ request('trimestre') == '4' ? 'selected' : '' }}>4to Trimestre</option>
                        </select>
                    </div>

                    <div id="divAno" class="filter-group hidden">
                        <select name="ano" class="bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl px-4 py-3 font-bold focus:ring-2 focus:ring-primary">
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('ano') == $y || (!request('ano') && $y == date('Y')) ? 'selected' : '' }}>Año {{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- T6: Filtro por Tipo de Documento --}}
                    <div class="relative">
                        <select name="tipo_doc" class="bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl px-4 py-3 font-bold focus:ring-2 focus:ring-primary appearance-none pr-8">
                            <option value="">Todos los tipos</option>
                            @foreach(\App\Models\Tipo::orderBy('tipo_nombre')->get() as $tp)
                                <option value="{{ $tp->id_tipo }}" {{ request('tipo_doc') == $tp->id_tipo ? 'selected' : '' }}>{{ $tp->tipo_nombre }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <span class="material-symbols-outlined text-sm">expand_more</span>
                        </div>
                    </div>

                    {{-- T6: Filtro por Estado --}}
                    <div class="relative">
                        <select name="estado_rep" class="bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl px-4 py-3 font-bold focus:ring-2 focus:ring-primary appearance-none pr-8">
                            <option value="">Todos los estados</option>
                            <option value="7" {{ request('estado_rep') == '7' ? 'selected' : '' }}>Recibido</option>
                            <option value="8" {{ request('estado_rep') == '8' ? 'selected' : '' }}>En Trámite</option>
                            <option value="9" {{ request('estado_rep') == '9' ? 'selected' : '' }}>Resuelto</option>
                            <option value="10" {{ request('estado_rep') == '10' ? 'selected' : '' }}>Archivado</option>
                            <option value="11" {{ request('estado_rep') == '11' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <span class="material-symbols-outlined text-sm">expand_more</span>
                        </div>
                    </div>

                    {{-- Filtro por Área --}}
                    <div class="relative">
                        <select name="area_id" class="bg-slate-50 dark:bg-slate-800 border-none text-slate-900 dark:text-white text-sm rounded-2xl px-4 py-3 font-bold focus:ring-2 focus:ring-primary appearance-none pr-8">
                            <option value="">Todas las áreas</option>
                            @foreach(\App\Models\Area::orderBy('area_nom')->get() as $area)
                                <option value="{{ $area->id_area }}" {{ request('area_id') == $area->id_area ? 'selected' : '' }}>{{ $area->area_nom }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <span class="material-symbols-outlined text-sm">expand_more</span>
                        </div>
                    </div>

                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-2xl text-sm font-black transition-all shadow-lg shadow-primary/20 hover:scale-105">
                        ACTUALIZAR DATOS
                    </button>
                </form>
            </div>

            @php
                $totalAsignados = collect($reporteAreas)->sum('asignados');
                $totalTramite = collect($reporteAreas)->sum('tramite');
                $totalFinalizado = collect($reporteAreas)->sum('finalizado');
                $totalVencidos = collect($reporteAreas)->sum('vencidos');
                $eficienciaGlobal = $totalAsignados > 0 ? round(($totalFinalizado / $totalAsignados) * 100) : 0;
            @endphp

            <!-- KPI Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Card -->
                <div class="group bg-white dark:bg-slate-900 p-1 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[1.8rem] p-6 h-full border border-white dark:border-slate-700/50">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-600 transition-transform group-hover:rotate-12">
                                <span class="material-symbols-outlined">inventory_2</span>
                            </div>
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded-lg">Volumen Total</span>
                        </div>
                        <h4 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tighter">Radicados Asignados</h4>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">{{ number_format($totalAsignados) }}</span>
                        </div>
                    </div>
                </div>

                <!-- En Proceso Card -->
                <div class="group bg-white dark:bg-slate-900 p-1 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[1.8rem] p-6 h-full border border-white dark:border-slate-700/50">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600 transition-transform group-hover:rotate-12">
                                <span class="material-symbols-outlined">pending_actions</span>
                            </div>
                            <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest bg-amber-50 dark:bg-amber-900/30 px-2 py-1 rounded-lg">Activos</span>
                        </div>
                        <h4 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tighter">En Trámite</h4>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">{{ number_format($totalTramite) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Finalizados Card -->
                <div class="group bg-white dark:bg-slate-900 p-1 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[1.8rem] p-6 h-full border border-white dark:border-slate-700/50">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 transition-transform group-hover:rotate-12">
                                <span class="material-symbols-outlined">verified</span>
                            </div>
                            <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-lg">Completados</span>
                        </div>
                        <h4 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tighter">Finalizados</h4>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">{{ number_format($totalFinalizado) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Eficiencia Card -->
                <div class="group bg-slate-900 dark:bg-white p-1 rounded-[2rem] shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="bg-slate-800 dark:bg-slate-50 rounded-[1.8rem] p-6 h-full border border-slate-700 dark:border-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary/40">
                                <span class="material-symbols-outlined">bolt</span>
                            </div>
                            <span class="text-[10px] font-black text-primary uppercase tracking-widest bg-primary/10 px-2 py-1 rounded-lg">Performance</span>
                        </div>
                        <h4 class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-tighter">Índice Eficiencia</h4>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-4xl font-black text-white dark:text-slate-900">{{ $eficienciaGlobal }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Bar Chart Canvas -->
                <div class="bg-white/50 dark:bg-slate-900/50 backdrop-blur-md rounded-[2.5rem] p-8 border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Carga por Dependencia</h3>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Distribución de trabajo por área</p>
                        </div>
                        <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400">
                             <span class="material-symbols-outlined text-xl">bar_chart</span>
                        </div>
                    </div>
                    <div class="h-80 w-full">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <!-- Radar/Efficiency Chart -->
                <div class="bg-white/50 dark:bg-slate-900/50 backdrop-blur-md rounded-[2.5rem] p-8 border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Radar de Eficiencia</h3>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Cumplimiento porcentual por área</p>
                        </div>
                        <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400">
                             <span class="material-symbols-outlined text-xl">radar</span>
                        </div>
                    </div>
                    <div class="h-80 w-full flex justify-center">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detailed Table Section -->
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden pb-6">
                <div class="p-8 flex items-center justify-between border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Desglose Detallado</h3>
                        <p class="font-bold text-xs text-slate-500 uppercase tracking-widest mt-1">Métricas específicas por departamento</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($totalVencidos > 0)
                            <div class="bg-red-50 dark:bg-red-900/20 text-red-600 px-4 py-2 rounded-2xl flex items-center gap-2 animate-bounce">
                                <span class="material-symbols-outlined text-sm">error</span>
                                <span class="text-xs font-black">{{ $totalVencidos }} Radicados Vencidos</span>
                            </div>
                        @else
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 px-4 py-2 rounded-2xl flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">verified_user</span>
                                <span class="text-xs font-black">Sin Pendientes Vencidos</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                                <th class="px-8 py-4">Departamento / Área</th>
                                <th class="px-4 py-4 text-center">Asignados</th>
                                <th class="px-4 py-4 text-center">Trámite</th>
                                <th class="px-4 py-4 text-center">Finalizados</th>
                                <th class="px-4 py-4 text-center">Vencidos</th>
                                <th class="px-8 py-4 text-right">Eficiencia</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                            @foreach($reporteAreas as $area)
                                <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-2 h-2 rounded-full {{ $area['eficiencia'] >= 80 ? 'bg-emerald-500' : ($area['eficiencia'] >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"></div>
                                            <span class="font-bold text-slate-700 dark:text-slate-300">{{ $area['area_nom'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center font-black text-slate-900 dark:text-white">{{ $area['asignados'] }}</td>
                                    <td class="px-4 py-5 text-center font-bold text-amber-600 bg-amber-50/30 dark:bg-transparent">{{ $area['tramite'] }}</td>
                                    <td class="px-4 py-5 text-center font-bold text-emerald-600 bg-emerald-50/30 dark:bg-transparent">{{ $area['finalizado'] }}</td>
                                    <td class="px-4 py-5 text-center">
                                        <span class="font-black {{ $area['vencidos'] > 0 ? 'text-red-500 scale-110 block' : 'text-slate-300 dark:text-slate-700' }}">
                                            {{ $area['vencidos'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center justify-end gap-3">
                                            <div class="w-24 h-2.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden shadow-inner">
                                                <div class="h-full transition-all duration-1000 ease-out {{ $area['eficiencia'] >= 80 ? 'bg-emerald-500' : ($area['eficiencia'] >= 50 ? 'bg-amber-500' : 'bg-red-500') }}" 
                                                     style="width: {{ $area['eficiencia'] }}%"></div>
                                            </div>
                                            <span class="text-sm font-black text-slate-900 dark:text-white w-10 text-right">{{ $area['eficiencia'] }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
            Swal.fire('Error', 'Las gráficas aún se están procesando.', 'error');
            return;
        }

        document.getElementById('barChartData').value = barCanvas.toDataURL("image/png", 1.0);
        document.getElementById('doughnutChartData').value = doughnutCanvas.toDataURL("image/png", 1.0);

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
        const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
        
        const labels = dataAreas.map(item => item.area_nom);
        const asignados = dataAreas.map(item => item.asignados);
        const finalizados = dataAreas.map(item => item.finalizado);
        const eficiencias = dataAreas.map(item => item.eficiencia);

        // Bar Chart
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Asignados',
                        data: asignados,
                        backgroundColor: '#3b82f6',
                        borderRadius: 12,
                        barThickness: 20,
                    },
                    {
                        label: 'Finalizados',
                        data: finalizados,
                        backgroundColor: '#10b981',
                        borderRadius: 12,
                        barThickness: 20,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: true, position: 'top', align: 'end', labels: { color: textColor, font: { weight: 'bold', size: 10 } } },
                    tooltip: { backgroundColor: isDark ? '#1e293b' : '#ffffff', titleColor: isDark ? '#ffffff' : '#1e293b', bodyColor: textColor, borderColor: gridColor, borderWidth: 1 }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor, font: { weight: 'bold' } } },
                    x: { grid: { display: false }, ticks: { color: textColor, font: { weight: 'bold' } } }
                }
            }
        });

        // Doughnut Chart (Radar inspired)
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: eficiencias,
                    backgroundColor: [
                        '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444', '#10b981', '#6366f1', '#ec4899'
                    ],
                    borderWidth: 0,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: { 
                    legend: { position: 'bottom', labels: { color: textColor, padding: 20, font: { weight: 'bold', size: 11 } } }
                }
            }
        });
    });
</script>
@endsection

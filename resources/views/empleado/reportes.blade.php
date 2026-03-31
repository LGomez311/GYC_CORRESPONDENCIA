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
</script>
@endsection

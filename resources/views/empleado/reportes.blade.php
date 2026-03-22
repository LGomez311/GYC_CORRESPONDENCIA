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
            <form id="filterForm" action="{{ route('empleado.reportes') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <a href="{{ route('empleado.reportes.export.pdf', ['mes' => $mesSelect, 'rango' => $rangoSelect]) }}" target="_blank" class="bg-white dark:bg-slate-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Exportar PDF
                </a>
                
                <input type="month" name="mes" value="{{ $mesSelect }}" max="{{ date('Y-m') }}" onchange="document.getElementById('filterForm').submit()" class="form-input border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-200 text-sm px-4 py-2" required title="Seleccionar Mes Base">
                
                <div class="flex items-center p-1 bg-gray-100 dark:bg-slate-900 rounded-lg">
                    <button type="button" onclick="setRango('mes')" class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all {{ $rangoSelect == 'mes' ? 'bg-white dark:bg-slate-800 shadow-sm text-blue-600 dark:text-blue-400' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Mes</button>
                    <button type="button" onclick="setRango('trimestre')" class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all {{ $rangoSelect == 'trimestre' ? 'bg-white dark:bg-slate-800 shadow-sm text-blue-600 dark:text-blue-400' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Trimestre</button>
                    <button type="button" onclick="setRango('anio')" class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all {{ $rangoSelect == 'anio' ? 'bg-white dark:bg-slate-800 shadow-sm text-blue-600 dark:text-blue-400' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">Año</button>
                </div>
                <input type="hidden" name="rango" id="rangoInput" value="{{ $rangoSelect }}">
            </form>

            <script>
                function setRango(val) {
                    document.getElementById('rangoInput').value = val;
                    document.getElementById('filterForm').submit();
                }
            </script>
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

        <!-- Total de Documentos -->
        <div class="bg-slate-900 border border-slate-900 dark:bg-white p-6 rounded-xl shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-full w-32 bg-gradient-to-l from-primary/30 to-transparent opacity-80"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-xs uppercase font-bold tracking-widest text-[#a8b8d8] dark:text-gray-500 mb-1">Total General</p>
                    <h3 class="text-3xl font-bold text-white dark:text-gray-900">{{ $totalDocs }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-white/10 dark:bg-slate-100 flex items-center justify-center text-white dark:text-slate-900 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">calculate</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Data Summary / Interactive Chart.js -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-lg dark:text-white">Métricas Consolidadas</h3>
            <div class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-lg">format_list_numbered</span>
                Total de Trámites: {{ $totalDocs }}
            </div>
        </div>
        <div class="w-full h-80 relative">
            <canvas id="metricsChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('metricsChart').getContext('2d');
        const data = {
            labels: ['Recibidos', 'En Trámite', 'Finalizados', 'Rechazados', 'Archivados', 'Vencidos'],
            datasets: [{
                label: 'Documentos',
                data: [
                    {{ $countRecibido }},
                    {{ $countTramite }},
                    {{ $countFinalizado }},
                    {{ $countRechazado }},
                    {{ $countArchivado }},
                    {{ $countVencidos }}
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',  
                    'rgba(234, 179, 8, 0.7)',   
                    'rgba(34, 197, 94, 0.7)',   
                    'rgba(239, 68, 68, 0.7)',   
                    'rgba(100, 116, 139, 0.7)', 
                    'rgba(249, 115, 22, 0.7)'   
                ],
                borderColor: [
                    'rgb(37, 99, 235)',
                    'rgb(202, 138, 4)',
                    'rgb(22, 163, 74)',
                    'rgb(220, 38, 38)',
                    'rgb(71, 85, 105)',
                    'rgb(234, 88, 12)'
                ],
                borderWidth: 1,
                borderRadius: 4
            }]
        };

        const isDarkMode = document.documentElement.classList.contains('dark');
        const textColor = isDarkMode ? '#e2e8f0' : '#334155';
        const gridColor = isDarkMode ? '#334155' : '#e2e8f0';

        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Documentos: ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: textColor, precision: 0 },
                        grid: { color: gridColor }
                    },
                    x: {
                        ticks: { color: textColor },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection

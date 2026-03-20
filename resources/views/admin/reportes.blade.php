@extends('admin.layouts.app')

@section('title', 'Reportes Avanzados')

@section('content')
<div class="space-y-6">

    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reportes Avanzados</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Análisis visual y numérico del estado de correspondencia por dependencias.
            </p>
        </div>
        <div>
            <form id="exportForm" action="{{ route('admin.reportes.export.pdf') }}" method="POST" class="inline-block">
                @csrf
                <!-- Arrastrar Filtros -->
                <input type="hidden" name="periodo" value="{{ request('periodo') }}">
                <input type="hidden" name="fecha" value="{{ request('fecha') }}">
                <input type="hidden" name="mes" value="{{ request('mes') }}">
                <input type="hidden" name="trimestre" value="{{ request('trimestre') }}">
                <input type="hidden" name="ano" value="{{ request('ano') }}">

                <input type="hidden" name="barChart" id="barChartData">
                <input type="hidden" name="doughnutChart" id="doughnutChartData">
                <button type="button" onclick="exportToPdf()" class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-xl transition-colors shadow-sm text-sm font-medium">
                    <span class="material-symbols-outlined text-base">picture_as_pdf</span>
                    Exportar PDF
                </button>
            </form>
        </div>
    </div>

    @if(isset($mensaje))
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="material-symbols-outlined text-yellow-400">info</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">{{ $mensaje }}</p>
                </div>
            </div>
        </div>
    @else
        <!-- Panel de Filtros -->
        <form method="GET" action="{{ route('admin.reportes') }}" class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-wrap gap-4 items-end mb-6">
            <div>
                <label class="block text-xs font-medium text-slate-500 dark:text-gray-400 mb-1">Periodo</label>
                <select name="periodo" id="periodo" onchange="toggleFiltros()" class="bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-primary focus:border-primary p-2">
                    <option value="todo" {{ request('periodo') == 'todo' ? 'selected' : '' }}>Todo</option>
                    <option value="dia" {{ request('periodo') == 'dia' ? 'selected' : '' }}>Día Específico</option>
                    <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Mensual</option>
                    <option value="trimestre" {{ request('periodo') == 'trimestre' ? 'selected' : '' }}>Trimestral</option>
                    <option value="ano" {{ request('periodo') == 'ano' ? 'selected' : '' }}>Anual</option>
                </select>
            </div>

            <!-- Día -->
            <div id="divDia" class="filter-group hidden">
                <label class="block text-xs font-medium text-slate-500 dark:text-gray-400 mb-1">Fecha</label>
                <input type="date" name="fecha" value="{{ request('fecha') }}" max="{{ date('Y-m-d') }}" class="bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-lg p-2">
            </div>

            <!-- Mes -->
            <div id="divMes" class="filter-group hidden">
                <label class="block text-xs font-medium text-slate-500 dark:text-gray-400 mb-1">Mes</label>
                <input type="month" name="mes" value="{{ request('mes') }}" max="{{ date('Y-m') }}" class="bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-lg p-2">
            </div>

            <!-- Trimestre -->
            <div id="divTrimestre" class="filter-group hidden flex gap-2">
                <div>
                    <label class="block text-xs font-medium text-slate-500 dark:text-gray-400 mb-1">Trimestre</label>
                    <select name="trimestre" class="bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-lg p-2">
                        <option value="1" {{ request('trimestre') == '1' ? 'selected' : '' }}>Tr 1 (Ene-Mar)</option>
                        <option value="2" {{ request('trimestre') == '2' ? 'selected' : '' }}>Tr 2 (Abr-Jun)</option>
                        <option value="3" {{ request('trimestre') == '3' ? 'selected' : '' }}>Tr 3 (Jul-Sep)</option>
                        <option value="4" {{ request('trimestre') == '4' ? 'selected' : '' }}>Tr 4 (Oct-Dic)</option>
                    </select>
                </div>
            </div>

            <!-- Año -->
            <div id="divAno" class="filter-group hidden">
                <label class="block text-xs font-medium text-slate-500 dark:text-gray-400 mb-1">Año</label>
                <select name="ano" class="bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-lg p-2">
                    @for($y = date('Y'); $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ request('ano') == $y || (!request('ano') && $y == date('Y')) ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                Filtrar / Actualizar
            </button>
        </form>

        <!-- Sección de Gráficas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Gráfica de Barras -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                <h3 class="font-bold text-base dark:text-white mb-4">Carga de Trabajo por Área</h3>
                <div class="h-64">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <!-- Gráfica Circular de Eficiencia -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                <h3 class="font-bold text-base dark:text-white mb-4">Eficiencia Promedio</h3>
                <div class="h-64 flex justify-center">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabla Sumario -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
            <h3 class="font-bold text-lg dark:text-white mb-4">Sumario General por Área</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-800/50 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-medium">Área</th>
                            <th class="px-4 py-3 font-medium text-center">Asignados</th>
                            <th class="px-4 py-3 font-medium text-center">En Trámite</th>
                            <th class="px-4 py-3 font-medium text-center">Finalizados</th>
                            <th class="px-4 py-3 font-medium text-center text-red-500">Vencidos</th>
                            <th class="px-4 py-3 font-medium text-right">Eficiencia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach($reporteAreas as $area)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50">
                                <td class="px-4 py-3 font-medium dark:text-gray-300">
                                    {{ $area['area_nom'] }}
                                </td>
                                <td class="px-4 py-3 text-center dark:text-gray-300">
                                    {{ $area['asignados'] }}
                                </td>
                                <td class="px-4 py-3 text-center dark:text-gray-300">
                                    {{ $area['tramite'] }}
                                </td>
                                <td class="px-4 py-3 text-center dark:text-gray-300">
                                    {{ $area['finalizado'] }}
                                </td>
                                <td class="px-4 py-3 text-center text-red-500 {{ $area['vencidos'] > 0 ? 'font-bold' : '' }}">
                                    {{ $area['vencidos'] }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="w-20 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full {{ $area['eficiencia'] >= 70 ? 'bg-green-500' : ($area['eficiencia'] >= 45 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                                 style="width: {{ $area['eficiencia'] }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 pl-2">
                                            {{ $area['eficiencia'] }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if(empty($reporteAreas))
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    No hay datos para reportar.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

<!-- Cargar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.exportToPdf = function() {
        const barCanvas = document.getElementById('barChart');
        const doughnutCanvas = document.getElementById('doughnutChart');

        if (!barCanvas || !doughnutCanvas) {
            alert('Las gráficas no están listas.');
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
        toggleFiltros(); // Inicializar

        const dataAreas = @json($reporteAreas);
        
        const labels = dataAreas.map(item => item.area_nom);
        const asignados = dataAreas.map(item => item.asignados);
        const finalizados = dataAreas.map(item => item.finalizado);
        const eficiencias = dataAreas.map(item => item.eficiencia);

        // Gráfica de Barras
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Asignados',
                        data: asignados,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    },
                    {
                        label: 'Finalizados',
                        data: finalizados,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(156, 163, 175, 0.1)' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Gráfica Doughnut (Promedio o Comparativa)
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Eficiencia %',
                    data: eficiencias,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(168, 85, 247, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(234, 179, 8, 0.7)',
                        'rgba(34, 197, 94, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });
</script>
@endsection


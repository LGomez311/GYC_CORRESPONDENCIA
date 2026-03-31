@extends('sadmin.layouts.app')

@section('title', 'Inicio - Super Admin')

@section('content')

<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
            Bienvenido, tu rol es <span class="text-primary">Superadmin</span>
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Resumen estadístico de las empresas y sus licencias en el sistema.
        </p>
    </div>
</div>

<!-- Tarjetas de Estadísticas Rápidas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Total Empresas -->
    <div class="bg-white dark:bg-[#161d2b] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 flex flex-col">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">apartment</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Empresas</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalEmpresas }}</h3>
            </div>
        </div>
    </div>

    <!-- Licencias Activas -->
    <div class="bg-white dark:bg-[#161d2b] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 flex flex-col">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Licencias Activas</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $activas }}</h3>
            </div>
        </div>
    </div>

    <!-- Sin Licencia o Vencida -->
    <div class="bg-white dark:bg-[#161d2b] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 flex flex-col">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-50 dark:bg-red-900/30 rounded-lg flex items-center justify-center text-red-600 dark:text-red-400">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Sin Licencias</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $inactivasOsinLicencia }}</h3>
            </div>
        </div>
    </div>

    <!-- Próximas a Vencer -->
    <div class="bg-white dark:bg-[#161d2b] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 flex flex-col">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-50 dark:bg-orange-900/30 rounded-lg flex items-center justify-center text-orange-600 dark:text-orange-400">
                <span class="material-symbols-outlined text-2xl">warning</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Próximas a Vencer</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $proximasAVencer }}</h3>
                <span class="text-xs text-gray-400 mt-1 block">En menos de 15 días</span>
            </div>
        </div>
    </div>
</div>

<!-- Gráficas y Lista -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Gráfica de Donut: Estado Global -->
    <div class="col-span-1 bg-white dark:bg-[#161d2b] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Estado Global de Licencias</h3>
        <div class="relative h-64 w-full flex items-center justify-center">
            @if($totalEmpresas > 0)
                <canvas id="estadoGlobalChart"></canvas>
            @else
                <p class="text-gray-400">No hay datos para mostrar</p>
            @endif
        </div>
    </div>

    <!-- Lista de Empresas (Detalle rápido) -->
    <div class="col-span-1 lg:col-span-2 bg-white dark:bg-[#161d2b] rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
            <div class="flex items-center justify-between w-full md:w-auto">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Resumen por Empresas</h3>
                <a href="{{ route('empresas') }}" class="text-sm text-primary hover:underline font-medium md:hidden">Ver todas</a>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <form id="filterForm" action="{{ route('sadmin.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto">
                    <input type="text" 
                           id="diasInput"
                           inputmode="numeric"
                           pattern="[0-9]*"
                           name="dias_restantes" 
                           value="{{ $filtroDias }}" 
                           placeholder="Días restantes (ej: 30)..." 
                           class="w-full md:w-48 px-3 py-1.5 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/50">
                    <button type="submit" class="hidden md:block px-3 py-1.5 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary/90 transition-colors">
                        Buscar
                    </button>
                    @if(request()->has('dias_restantes') && request('dias_restantes') != '')
                        <a href="{{ route('sadmin.index') }}" class="px-3 py-1.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Limpiar
                        </a>
                    @endif
                </form>
                <a href="{{ route('empresas') }}" class="hidden md:block text-sm text-primary hover:underline font-medium ml-2">Ver todas</a>
            </div>
        </div>
        
        <div id="tableContainer">
            @include('sadmin.partials.empresas_table', ['empresasPaginadas' => $empresasPaginadas])
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('estadoGlobalChart');
        
        if(ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Activas', 'Próximas a Vencer', 'Inactivas'],
                    datasets: [{
                        data: [
                            {{ $activas - $proximasAVencer }}, 
                            {{ $proximasAVencer }}, 
                            {{ $inactivasOsinLicencia }}
                        ],
                        backgroundColor: [
                            '#10B981', // green-500
                            '#F59E0B', // orange-500
                            '#EF4444'  // red-500
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#4B5563',
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    cutout: '75%'
                }
            });
        }

        // AJAX filtering and pagination script
        const diasInput = document.getElementById('diasInput');
        const tableContainer = document.getElementById('tableContainer');
        
        function fetchTableData(url) {
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;
                attachPaginationEvents();
            })
            .catch(error => console.error('Error fetching table data:', error));
        }

        function attachPaginationEvents() {
            // Re-attach click events to the new pagination links
            const paginationLinks = tableContainer.querySelectorAll('.ajax-pagination a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchTableData(this.href);
                });
            });
        }

        if (diasInput) {
            let typingTimer;
            diasInput.addEventListener('input', function() {
                // Ensure only numbers are kept
                this.value = this.value.replace(/[^0-9]/g, '');
                
                clearTimeout(typingTimer);
                
                // Submit after 400ms of inactivity
                typingTimer = setTimeout(() => {
                    const url = new URL('{{ route('sadmin.index') }}');
                    if(this.value) {
                         url.searchParams.set('dias_restantes', this.value);
                    } else {
                         url.searchParams.delete('dias_restantes');
                    }
                    fetchTableData(url.toString());
                }, 400);
            });
            
            // Prevent default form submission via Enter
            document.getElementById('filterForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const url = new URL('{{ route('sadmin.index') }}');
                if(diasInput.value) {
                     url.searchParams.set('dias_restantes', diasInput.value);
                } else {
                     url.searchParams.delete('dias_restantes');
                }
                fetchTableData(url.toString());
            });
        }
        
        // Initial setup for existing pagination links on page load
        attachPaginationEvents();
    });
</script>
@endsection

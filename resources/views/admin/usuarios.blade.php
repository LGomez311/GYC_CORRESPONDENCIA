@extends('admin.layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="w-full max-w-7xl mx-auto p-4 md:px-6 lg:px-8 py-6">
        
        <!-- ================= HEADER ================= -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
            <div>
                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight mb-1">
                    Gestión de Usuarios
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Administra los accesos y perfiles de los empleados de la organización.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto mt-4 lg:mt-0">
                <button
                    class="flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-[#161d2b] text-[#0d121b] dark:text-white border border-[#cfd7e7] dark:border-gray-800 rounded-lg font-bold text-sm hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all active:scale-95 w-full sm:w-auto shadow-sm">
                    <span class="material-symbols-outlined text-lg text-emerald-500">person_add</span>
                    Crear Remitente
                </button>
                <button
                    class="flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all active:scale-95 w-full sm:w-auto">
                    <span class="material-symbols-outlined text-lg">badge</span>
                    Crear Empleado
                </button>
            </div>
        </div>

        <!-- ================= STATS GRID ================= -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Usuarios -->
            <div class="bg-white dark:bg-[#161d2b] p-4 rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#4c669a] text-xs font-bold uppercase tracking-wider">Total Usuarios</span>
                    <span class="material-symbols-outlined text-primary">groups</span>
                </div>
                <div class="mt-2 text-2xl font-bold dark:text-white">{{ $stats['total'] }}</div>
            </div>

            <!-- Activos -->
            <div class="bg-white dark:bg-[#161d2b] p-4 rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#4c669a] text-xs font-bold uppercase tracking-wider">Activos</span>
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                </div>
                <div class="mt-2 text-2xl font-bold dark:text-white">{{ $stats['activos'] }}</div>
            </div>

            <!-- Inactivos -->
            <div class="bg-white dark:bg-[#161d2b] p-4 rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#4c669a] text-xs font-bold uppercase tracking-wider">Inactivos</span>
                    <span class="material-symbols-outlined text-slate-400">do_not_disturb_on</span>
                </div>
                <div class="mt-2 text-2xl font-bold dark:text-white">{{ $stats['inactivos'] }}</div>
            </div>

            <!-- Nuevos -->
            <div class="bg-white dark:bg-[#161d2b] p-4 rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#4c669a] text-xs font-bold uppercase tracking-wider">Nuevos (Mes)</span>
                    <span class="material-symbols-outlined text-orange-400">person_add</span>
                </div>
                <div class="mt-2 text-2xl font-bold dark:text-white">{{ $stats['nuevos'] }}</div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm overflow-hidden mb-8">
            <!-- Table Header / Search -->
            <div class="px-6 py-4 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-background-dark/20">
                <div>
                    <h2 class="text-lg font-bold text-[#0d121b] dark:text-white">Empleados (Internos)</h2>
                    <p class="text-xs text-[#4c669a] dark:text-gray-400">Personal interno con acceso y roles específicos.</p>
                </div>
                <div class="relative w-full md:w-72">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a] text-lg">search</span>
                    <input type="text" id="searchEmpleado" placeholder="Buscar por documento..." 
                        class="pl-10 pr-4 py-2 bg-white dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm focus:outline-none focus:border-primary transition-all w-full shadow-sm">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-background-dark/50 border-b border-[#cfd7e7] dark:border-gray-800">
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Nombre Completo</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Correo Electrónico</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Área</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableEmpleados" class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @forelse($empleados as $empleado)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors" data-doc="{{ $empleado->emple_doc }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-gray-800 flex items-center justify-center font-bold text-xs text-[#4c669a]">
                                        {{ strtoupper(substr($empleado->emple_nombres, 0, 1) . substr($empleado->emple_apellidos, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">{{ $empleado->emple_nombres }} {{ $empleado->emple_apellidos }} </span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">Documento: {{ $empleado->emple_doc }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">
                                {{ $empleado->emple_correo }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                    {{ $empleado->rol->rol_nom ?? 'Sin Rol' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">{{ $empleado->area->area_nom ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-xs text-[#4c669a]">
                                <div class="font-bold text-[#0d121b] dark:text-white">{{ $empleado->empresa->nomb_empresa ?? 'N/A' }}</div>
                                <div>NIT: {{ $empleado->nit_empresa ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($empleado->emple_estado == 1)
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        {{ $empleado->estado->estado_nomb ?? 'Activo' }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                        {{ $empleado->estado->estado_nomb ?? 'Inactivo' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Ver Detalles">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors" title="Eliminar">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-[#4c669a]">
                                No hay empleados registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION EMPLEADOS -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-background-dark/30 border-t border-[#cfd7e7] dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs font-medium text-[#4c669a]">
                    Total: {{ count($empleados) }} empleados
                </span>
                <div class="flex gap-1">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 transition-all disabled:opacity-50" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-xs shadow-sm">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 transition-all disabled:opacity-50" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm overflow-hidden mb-8">
            <!-- Table Header / Search -->
            <div class="px-6 py-4 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-background-dark/20">
                <div>
                    <h2 class="text-lg font-bold text-[#0d121b] dark:text-white">Remitentes (Externos)</h2>
                    <p class="text-xs text-[#4c669a] dark:text-gray-400">Usuarios registrados para envío de correspondencia.</p>
                </div>
                <div class="relative w-full md:w-72">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a] text-lg">search</span>
                    <input type="text" id="searchRemitente" placeholder="Buscar por documento..." 
                        class="pl-10 pr-4 py-2 bg-white dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm focus:outline-none focus:border-primary transition-all w-full shadow-sm">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-background-dark/50 border-b border-[#cfd7e7] dark:border-gray-800">
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Nombre Completo</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Correo Electrónico</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Ciudad</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Teléfono</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableRemitentes" class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @forelse($remitentes as $rem)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors" data-doc="{{ $rem->rem_doc }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-gray-800 flex items-center justify-center font-bold text-xs text-[#4c669a]">
                                        {{ strtoupper(substr($rem->rem_nombres, 0, 1) . substr($rem->rem_apellidos, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">{{ $rem->rem_nombres }} {{ $rem->rem_apellidos }}</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400"> Documento: {{ $rem->rem_doc }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">
                                {{ $rem->rem_correo }}
                            </td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">{{ $rem->ciudad->ciudad_nom ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-[#4c669a]">{{ $rem->rem_tel }}</td>
                            <td class="px-6 py-4 text-xs text-[#4c669a]">
                                <div class="font-bold text-[#0d121b] dark:text-white">{{ $rem->empresa->nomb_empresa ?? 'N/A' }}</div>
                                <div>NIT: {{ $rem->nit_empresa ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($rem->rem_estado == 1)
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Ver Detalles">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors" title="Eliminar">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-[#4c669a]">
                                No hay remitentes registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION REMITENTES -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-background-dark/30 border-t border-[#cfd7e7] dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs font-medium text-[#4c669a]">
                    Total: {{ count($remitentes) }} remitentes
                </span>
                <div class="flex gap-1">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 transition-all disabled:opacity-50" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-xs shadow-sm">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#cfd7e7] dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 transition-all disabled:opacity-50" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchEmpleado = document.getElementById('searchEmpleado');
            const tableEmpleados = document.getElementById('tableEmpleados');
            const rowsEmpleados = tableEmpleados.querySelectorAll('tr[data-doc]');

            const searchRemitente = document.getElementById('searchRemitente');
            const tableRemitentes = document.getElementById('tableRemitentes');
            const rowsRemitentes = tableRemitentes.querySelectorAll('tr[data-doc]');

            function filterTable(input, rows) {
                const term = input.value.toLowerCase();
                rows.forEach(row => {
                    const doc = row.getAttribute('data-doc').toLowerCase();
                    if (doc.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            if (searchEmpleado) {
                searchEmpleado.addEventListener('input', () => filterTable(searchEmpleado, rowsEmpleados));
            }

            if (searchRemitente) {
                searchRemitente.addEventListener('input', () => filterTable(searchRemitente, rowsRemitentes));
            }
        });
    </script>
@endsection
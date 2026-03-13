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
                <button id="btnOpenCrearRemitente"
                    class="flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-[#161d2b] text-[#0d121b] dark:text-white border border-[#cfd7e7] dark:border-gray-800 rounded-lg font-bold text-sm hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all active:scale-95 w-full sm:w-auto shadow-sm">
                    <span class="material-symbols-outlined text-lg text-emerald-500">person_add</span>
                    Crear Remitente
                </button>
                <button id="btnOpenCrearEmpleado"
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
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-full whitespace-nowrap">
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
                            <td class="px-6 py-4" data-label="Usuario">
                                <div class="flex items-center gap-3">
                                    @if($empleado->emple_img)
                                        <img src="{{ asset('storage/' . $empleado->emple_img) }}" alt="Foto" class="w-8 h-8 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                            {{ substr($empleado->emple_nombres, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold dark:text-white">
                                            {{ $empleado->emple_nombres }} {{ $empleado->emple_apellidos }}
                                        </span>
                                        <span class="text-xs text-[#4c669a]">
                                            {{ $empleado->emple_correo }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Documento">
                                <div class="flex flex-col">
                                    <span class="text-sm text-[#0d121b] dark:text-white font-medium">
                                        {{ implode(' ', str_split($empleado->emple_doc, 3)) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Rol / Área">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="inline-flex w-max items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                        {{ $empleado->rol->rol_nom === 'sadmin'
                                            ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-400'
                                            : ($empleado->rol->rol_nom === 'admin'
                                                ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400'
                                                : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400') }}">
                                        {{ $empleado->rol->rol_nom }}
                                    </span>
                                    <span class="text-xs text-[#4c669a]">
                                        {{ optional($empleado->area)->area_nom ?? 'Sin área' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Estado">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border
                                    {{ $empleado->emple_estado == 'activo'
                                        ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800'
                                        : 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800' }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $empleado->emple_estado == 'activo' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ ucfirst($empleado->emple_estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors btn-view-details" title="Ver Detalles"
                                        data-type="empleado"
                                        data-doc="{{ $empleado->emple_doc }}"
                                        data-nombres="{{ $empleado->emple_nombres }} {{ $empleado->emple_apellidos }}"
                                        data-correo="{{ $empleado->emple_correo }}"
                                        data-telefono="{{ $empleado->emple_tel }}"
                                        data-empresa="{{ $empleado->empresa->nomb_empresa ?? 'N/A' }}"
                                        data-nit="{{ $empleado->nit_empresa ?? 'N/A' }}"
                                        data-area="{{ $empleado->area->area_nom ?? 'N/A' }}"
                                        data-rol="{{ $empleado->rol->rol_nom ?? 'Sin Rol' }}"
                                        data-estado="{{ $empleado->estado->estado_nomb ?? 'Inactivo' }}"
                                        data-avatar="{{ $empleado->emple_img ? asset('storage/' . $empleado->emple_img) : '' }}">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors btn-open-edit-empleado"
                                        title="Editar Empleado"
                                        data-id="{{ $empleado->emple_doc }}"
                                        data-documento="{{ $empleado->emple_doc }}"
                                        data-nombres="{{ $empleado->emple_nombres }}"
                                        data-apellidos="{{ $empleado->emple_apellidos }}"
                                        data-telefono="{{ $empleado->emple_tel }}"
                                        data-correo="{{ $empleado->emple_correo }}"
                                        data-area="{{ $empleado->emple_area }}"
                                        data-estado="{{ $empleado->emple_estado }}">
                                        <span class="material-symbols-outlined text-xl">edit</span>
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
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-full whitespace-nowrap responsive-table">
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
                            <td class="px-6 py-4" data-label="Nombre Completo">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">{{ $rem->rem_nombres }} {{ $rem->rem_apellidos }}</span>
                                    <span class="text-xs text-[#4c669a] dark:text-gray-400">Documento: {{ $rem->rem_doc }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Correo Electrónico">
                                <div class="flex flex-col">
                                    <span class="text-sm text-[#4c669a] dark:text-gray-300">{{ $rem->rem_correo }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Ciudad">
                                <span class="px-2.5 py-1 text-xs font-medium rounded border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-[#161d2b] text-[#4c669a] dark:text-gray-300">
                                    {{ $rem->ciudad->ciudad_nom ?? 'No definida' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0d121b] dark:text-white" data-label="Teléfono">
                                {{ $rem->rem_tel ?: 'No registrado' }}
                            </td>
                            <td class="px-6 py-4" data-label="Empresa">
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#0d121b] dark:text-white text-sm">{{ $rem->empresa->nomb_empresa ?? 'Ninguna' }}</span>
                                    @if($rem->empresa)
                                    <span class="text-xs text-[#4c669a] dark:text-gray-400">NIT: {{ $rem->empresa->nit_empresa }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Estado">
                                @if($rem->rem_estado == 1)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right actions-cell" data-label="Acciones">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors btn-view-details" title="Ver Detalles"
                                        data-type="remitente"
                                        data-doc="{{ $rem->rem_doc }}"
                                        data-nombres="{{ $rem->rem_nombres }} {{ $rem->rem_apellidos }}"
                                        data-correo="{{ $rem->rem_correo }}"
                                        data-telefono="{{ $rem->rem_tel }}"
                                        data-empresa="{{ $rem->empresa->nomb_empresa ?? 'N/A' }}"
                                        data-nit="{{ $rem->nit_empresa ?? 'N/A' }}"
                                        data-ciudad="{{ $rem->ciudad->ciudad_nom ?? 'N/A' }}"
                                        data-direccion="{{ $rem->rem_dir ?? 'N/A' }}"
                                        data-estado="{{ $rem->rem_estado == 1 ? 'Activo' : 'Inactivo' }}">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors btn-open-edit-remitente"
                                        title="Editar Remitente"
                                        data-id="{{ $rem->rem_doc }}"
                                        data-documento="{{ $rem->rem_doc }}"
                                        data-nombres="{{ $rem->rem_nombres }}"
                                        data-apellidos="{{ $rem->rem_apellidos }}"
                                        data-telefono="{{ $rem->rem_tel }}"
                                        data-correo="{{ $rem->rem_correo }}"
                                        data-ciudad="{{ $rem->rem_ciudad }}"
                                        data-direccion="{{ $rem->rem_dir }}"
                                        data-estado="{{ $rem->rem_estado }}">
                                        <span class="material-symbols-outlined text-xl">edit</span>
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

{{-- MODAL CREAR EMPLEADO --}}
<div id="empleadoModal" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white dark:bg-[#161d2b] w-full max-w-3xl rounded-xl shadow-xl relative my-10 max-h-[90vh] flex flex-col overflow-hidden">
        <div class="px-6 pt-6 bg-white dark:bg-[#161d2b]">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-800 pb-4 mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-[#0d121b] dark:text-white">Registrar Nuevo Empleado</h2>
                    <p class="text-sm text-[#4c669a] dark:text-gray-400">Complete los datos, los campos con (*) son obligatorios.</p>
                </div>
                <button class="btn-close text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.empleado.store') }}" id="empleadoForm" enctype="multipart/form-data" class="flex-1 overflow-y-auto px-6 pb-6 space-y-6 bg-white dark:bg-[#161d2b]">
            @csrf
            <input type="hidden" name="modal_type_empleado" value="create">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- DOCUMENTO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Documento (*)</label>
                    <input name="emple_doc" id="doc_empleado" type="text" maxlength="10" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ingrese documento..." value="{{ old('emple_doc') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-doc-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- ÁREA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Área (*)</label>
                    <select name="emple_area" id="area_empleado" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white" required>
                        <option value="">Seleccionar área...</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id_area }}">{{ $area->area_nom }}</option>
                        @endforeach
                    </select>
                    <p id="error-area-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- NOMBRES -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombres (*)</label>
                    <input name="emple_nombres" id="nom_empleado" type="text" maxlength="50" placeholder="Ingrese nombres..." value="{{ old('emple_nombres') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-nom-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- APELLIDOS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellidos (*)</label>
                    <input name="emple_apellidos" id="ape_empleado" type="text" maxlength="50" placeholder="Ingrese apellidos..." value="{{ old('emple_apellidos') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-ape-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono (*)</label>
                    <input name="emple_tel" id="tel_empleado" type="text" maxlength="12" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ingrese teléfono..." value="{{ old('emple_tel') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-tel-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CORREO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo (*)</label>
                    <input name="emple_correo" id="cor_empleado" type="email" maxlength="150" placeholder="Ingrese correo electrónico..." value="{{ old('emple_correo') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-cor-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CONTRASEÑA -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña (*)</label>
                    <div class="relative w-full">
                        <input name="password" id="pass_empleado" type="password" maxlength="64" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="Ingrese contraseña segura..." class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white pr-10">
                        <button type="button" class="btn-toggle-password absolute right-3 top-1/2 -translate-y-1/2 mt-[2px] text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white focus:outline-none" tabindex="-1">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                    <p id="error-pass-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- FOTO -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto de perfil (Solo formato JPEG, PNG, WEBP)</label>
                    <input name="emple_img" id="img_empleado" type="file" accept=".jpg,.jpeg,.png,.webp" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:file:bg-gray-700 dark:file:text-white">
                    <p id="error-img-emp" class="text-sm text-red-600 hidden"></p>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-800">
                <button type="button" class="btn-close px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">Cancelar</button>
                <button id="btnGuardarEmpleado" type="submit" class="px-6 py-2 rounded-lg bg-primary hover:bg-primary/90 text-white flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined">save</span>
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDITAR EMPLEADO --}}
<div id="empleadoModalEdit" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white dark:bg-[#161d2b] w-full max-w-3xl rounded-xl shadow-xl relative my-10 max-h-[90vh] flex flex-col overflow-hidden">
        <div class="px-6 pt-6">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-800 pb-4 mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-[#0d121b] dark:text-white">Editar Empleado</h2>
                    <p class="text-sm text-[#4c669a] dark:text-gray-400">Modifique los datos, los campos con (*) son obligatorios.</p>
                </div>
                <button class="btn-close text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>

        <form method="POST" id="formEditEmpleado" enctype="multipart/form-data" class="flex-1 overflow-y-auto px-6 pb-6 space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="modal_type_empleado" value="edit">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- DOCUMENTO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Documento (*)</label>
                    <input type="text" name="emple_doc" id="edit_doc_empleado" maxlength="10" readonly class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 cursor-not-allowed">
                </div>

                <!-- ÁREA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Área (*)</label>
                    <select name="emple_area" id="edit_area_empleado" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white" required>
                        <option value="">Seleccionar área...</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id_area }}">{{ $area->area_nom }}</option>
                        @endforeach
                    </select>
                    <p id="edit-error-area-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- NOMBRES -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombres (*)</label>
                    <input type="text" name="emple_nombres" id="edit_nom_empleado" maxlength="50" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="edit-error-nom-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- APELLIDOS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellidos (*)</label>
                    <input type="text" name="emple_apellidos" id="edit_ape_empleado" maxlength="50" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="edit-error-ape-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono (*)</label>
                    <input type="text" name="emple_tel" id="edit_tel_empleado" maxlength="12" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="edit-error-tel-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CORREO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo (*)</label>
                    <input type="email" name="emple_correo" id="edit_cor_empleado" maxlength="150" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="edit-error-cor-emp" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- ESTADO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                    <select name="emple_estado" id="edit_estado_empleado" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                        <option value="">Seleccionar estado...</option>
                        @foreach($estados as $estado)
                            @if(in_array($estado->id_estado, [1, 2]))
                                <option value="{{ $estado->id_estado }}" {{ old('emple_estado') == $estado->id_estado ? 'selected' : '' }}>
                                    {{ $estado->estado_nomb }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- FOTO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nueva Foto (Opcional)</label>
                    <input type="file" name="emple_img" id="edit_img_empleado" accept=".jpg,.jpeg,.png,.webp" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:file:bg-gray-700 dark:file:text-white">
                    <p id="edit-error-img-emp" class="text-sm text-red-600 hidden"></p>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-800">
                <button type="button" class="btn-close px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">Cancelar</button>
                <button id="btnGuardarEditEmpleado" type="submit" class="px-6 py-2 rounded-lg bg-primary text-white flex items-center gap-2 hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">save</span>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL CREAR REMITENTE --}}
<div id="remitenteModal" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white dark:bg-[#161d2b] w-full max-w-3xl rounded-xl shadow-xl relative my-10 max-h-[90vh] flex flex-col overflow-hidden">
        <div class="px-6 pt-6">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-800 pb-4 mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-[#0d121b] dark:text-white">Registrar Nuevo Remitente</h2>
                    <p class="text-sm text-[#4c669a] dark:text-gray-400">Complete los datos, los campos con (*) son obligatorios.</p>
                </div>
                <button class="btn-close text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.remitente.store') }}" id="remitenteForm" class="flex-1 overflow-y-auto px-6 pb-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- DOCUMENTO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Documento (*)</label>
                    <input name="rem_doc" id="doc_remitente" type="text" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ingrese documento..." value="{{ old('rem_doc') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-doc-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CIUDAD -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ciudad (*)</label>
                    <select name="rem_ciudad" id="ciudad_remitente" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white select2-ciudad" required>
                        <option value="">Seleccionar ciudad...</option>
                        @foreach($ciudades as $ciudad)
                            <option value="{{ $ciudad->ciudad_cod_post }}">{{ $ciudad->ciudad_nom }} - {{ $ciudad->departamento->dpto_nombre ?? '' }}</option>
                        @endforeach
                    </select>
                    <p id="error-ciu-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- NOMBRES -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombres (*)</label>
                    <input name="rem_nombres" id="nom_remitente" type="text" maxlength="50" placeholder="Ingrese nombres..." value="{{ old('rem_nombres') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-nom-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- APELLIDOS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellidos (*)</label>
                    <input name="rem_apellidos" id="ape_remitente" type="text" maxlength="50" placeholder="Ingrese apellidos..." value="{{ old('rem_apellidos') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-ape-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono (*)</label>
                    <input name="rem_tel" id="tel_remitente" type="text" maxlength="12" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ingrese teléfono..." value="{{ old('rem_tel') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-tel-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CORREO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo (*)</label>
                    <input name="rem_correo" id="cor_remitente" type="email" maxlength="150" placeholder="Ingrese correo electrónico..." value="{{ old('rem_correo') }}" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="error-cor-rem" class="text-sm text-red-600 hidden"></p>
                </div>


                <!-- CONTRASEÑA -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña (*)</label>
                    <div class="relative w-full">
                        <input name="password" id="pass_remitente" type="password" maxlength="64" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="Ingrese contraseña segura..." class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white pr-10">
                        <button type="button" class="btn-toggle-password absolute right-3 top-1/2 -translate-y-1/2 mt-[2px] text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white focus:outline-none" tabindex="-1">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                    <p id="error-pass-rem" class="text-sm text-red-600 hidden"></p>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-800">
                <button type="button" class="btn-close px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">Cancelar</button>
                <button id="btnGuardarRemitente" type="submit" class="px-6 py-2 rounded-lg bg-primary hover:bg-primary/90 text-white flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined">save</span>
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDITAR REMITENTE --}}
<div id="remitenteModalEdit" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white dark:bg-[#161d2b] w-full max-w-3xl rounded-xl shadow-xl relative my-10 max-h-[90vh] flex flex-col overflow-hidden">
        <div class="px-6 pt-6">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-800 pb-4 mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-[#0d121b] dark:text-white">Editar Remitente</h2>
                    <p class="text-sm text-[#4c669a] dark:text-gray-400">Modifique los datos, los campos con (*) son obligatorios.</p>
                </div>
                <button class="btn-close text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>

        <form method="POST" id="formEditRemitente" class="flex-1 overflow-y-auto px-6 pb-6 space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="modal_type_remitente" value="edit">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- DOCUMENTO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Documento (*)</label>
                    <input type="text" name="rem_doc" id="edit_doc_remitente" maxlength="15" readonly class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 cursor-not-allowed">
                </div>

                <!-- CIUDAD -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ciudad (*)</label>
                    <select name="rem_ciudad" id="edit_ciudad_remitente" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white select2-ciudad" required>
                        <option value="">Seleccionar ciudad...</option>
                        @foreach($ciudades as $ciudad)
                            <option value="{{ $ciudad->ciudad_cod_post }}">{{ $ciudad->ciudad_nom }} - {{ $ciudad->departamento->dpto_nombre ?? '' }}</option>
                        @endforeach
                    </select>
                    <p id="edit-error-ciu-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- NOMBRES -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombres (*)</label>
                    <input type="text" name="rem_nombres" id="edit_nom_remitente" maxlength="50" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="edit-error-nom-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- APELLIDOS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellidos (*)</label>
                    <input type="text" name="rem_apellidos" id="edit_ape_remitente" maxlength="50" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="edit-error-ape-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono (*)</label>
                    <input type="text" name="rem_tel" id="edit_tel_remitente" maxlength="12" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="edit-error-tel-rem" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CORREO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo (*)</label>
                    <input type="email" name="rem_correo" id="edit_cor_remitente" maxlength="150" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                    <p id="edit-error-cor-rem" class="text-sm text-red-600 hidden"></p>
                </div>


                <!-- ESTADO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                    <select name="rem_estado" id="edit_estado_remitente" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-[#0d121b] dark:text-white">
                        <option value="">Seleccionar estado...</option>
                        @foreach($estados as $estado)
                            @if(in_array($estado->id_estado, [1, 2]))
                                <option value="{{ $estado->id_estado }}" {{ old('rem_estado') == $estado->id_estado ? 'selected' : '' }}>
                                    {{ $estado->estado_nomb }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-800">
                <button type="button" class="btn-close px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">Cancelar</button>
                <button id="btnGuardarEditRemitente" type="submit" class="px-6 py-2 rounded-lg bg-primary text-white flex items-center gap-2 hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">save</span>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL VER DETALLES --}}
<div id="detallesModal" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white dark:bg-[#161d2b] w-full max-w-2xl rounded-xl shadow-xl relative my-10 max-h-[90vh] flex flex-col overflow-hidden">
        <div class="px-6 pt-6 pb-4 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-[#0d121b] dark:text-white" id="detallesTitle">Detalles del Usuario</h2>
            <button class="btn-close text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto text-sm text-[#4c669a] dark:text-gray-300">
            <div class="flex flex-col md:flex-row gap-6 mb-6 items-start">
                <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-gray-800 flex-shrink-0 flex justify-center items-center overflow-hidden border border-[#cfd7e7] dark:border-gray-700" id="detallesAvatarContainer">
                    <span class="material-symbols-outlined text-4xl text-gray-400">person</span>
                </div>
                <div class="flex flex-col gap-1 flex-1">
                    <h3 class="text-2xl font-bold text-[#0d121b] dark:text-white" id="detallesNombres">-</h3>
                    <p class="text-base font-medium flex items-center gap-2"><span class="material-symbols-outlined text-sm">badge</span> <span id="detallesDoc">-</span></p>
                    <p class="flex items-center gap-2 w-fit px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-lg text-xs font-semibold mt-1" id="detallesEstadoContainer">
                        <span id="detallesEstado">-</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Correo Electrónico</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium break-all" id="detallesCorreo">-</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Teléfono</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detallesTelefono">-</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Empresa Asociada</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detallesEmpresa">-</p>
                    <p class="text-xs mt-0.5">NIT: <span id="detallesNit">-</span></p>
                </div>
                <div id="detallesExtra1Container">
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1" id="detallesExtra1Label">Extra 1</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detallesExtra1Value">-</p>
                </div>
                <div id="detallesExtra2Container">
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1" id="detallesExtra2Label">Extra 2</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detallesExtra2Value">-</p>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800 flex justify-end">
            <button class="btn-close px-6 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-colors font-medium">Cerrar</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ===========================
           VARIABLES GENERALES
        ============================*/
        const btnOpenEmpleado = document.getElementById('btnOpenCrearEmpleado');
        const modalEmpleado = document.getElementById('empleadoModal');
        const modalEmpleadoEdit = document.getElementById('empleadoModalEdit');

        const btnOpenRemitente = document.getElementById('btnOpenCrearRemitente');
        const modalRemitente = document.getElementById('remitenteModal');
        const modalRemitenteEdit = document.getElementById('remitenteModalEdit');

        const modalDetalles = document.getElementById('detallesModal');

        // Inicializar Select2
        try {
            $('#ciudad_remitente').select2({
                placeholder: "Buscar ciudad...",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#remitenteModal')
            });
            $('#edit_ciudad_remitente').select2({
                placeholder: "Buscar ciudad...",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#remitenteModalEdit')
            });
            
            // Validar Select2 en real-time
            $('#ciudad_remitente').on('change', function() {
                camposTocados['ciudad_remitente'] = true;
                if(typeof validarCampoIndividual === 'function') {
                    validarCampoIndividual('ciudad_remitente', reglasCrearRemitente);
                }
            });
            $('#edit_ciudad_remitente').on('change', function() {
                if(typeof validarCampoEditar === 'function') {
                    validarCampoEditar('edit_ciudad_remitente', reglasEditarRemitente);
                }
            });
        } catch (error) {
            console.error('Select2 initialization error:', error);
        }

        /* ===========================
           MODALES ABRIR / CERRAR
        ============================*/
        if (btnOpenEmpleado) {
            btnOpenEmpleado.addEventListener('click', () => modalEmpleado.classList.remove('hidden'));
        }
        if (btnOpenRemitente) {
            btnOpenRemitente.addEventListener('click', () => modalRemitente.classList.remove('hidden'));
        }

        // Toggle eye button for passwords
        document.querySelectorAll('.btn-toggle-password').forEach(btn => {
            const input = btn.previousElementSibling;
            const icon = btn.querySelector('.material-symbols-outlined');
            
            const showPassword = () => {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            };
            
            const hidePassword = () => {
                input.type = 'password';
                icon.textContent = 'visibility';
            };

            btn.addEventListener('mousedown', showPassword);
            btn.addEventListener('mouseup', hidePassword);
            btn.addEventListener('mouseleave', hidePassword);
            
            // For mobile
            btn.addEventListener('touchstart', showPassword, {passive: true});
            btn.addEventListener('touchend', hidePassword, {passive: true});
        });

        document.querySelectorAll('.btn-close').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.closest('.fixed').classList.add('hidden');
            });
        });

        const btnGuardarEditEmpleado = document.getElementById('btnGuardarEditEmpleado');
        const btnGuardarEditRemitente = document.getElementById('btnGuardarEditRemitente');

        let originalEditEmpleadoData = {};
        let originalEditRemitenteData = {};

        /* ===========================
           MODAL EDITAR EMPLEADO
        ============================*/
        document.querySelectorAll('.btn-open-edit-empleado').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = {
                    documento: btn.dataset.documento || '',
                    nombres: btn.dataset.nombres || '',
                    apellidos: btn.dataset.apellidos || '',
                    telefono: btn.dataset.telefono || '',
                    correo: btn.dataset.correo || '',
                    area: btn.dataset.area || '',
                    estado: btn.dataset.estado || ''
                };

                originalEditEmpleadoData = { ...data };

                document.getElementById('edit_doc_empleado').value = data.documento;
                document.getElementById('edit_nom_empleado').value = data.nombres;
                document.getElementById('edit_ape_empleado').value = data.apellidos;
                document.getElementById('edit_tel_empleado').value = data.telefono;
                document.getElementById('edit_cor_empleado').value = data.correo;
                document.getElementById('edit_area_empleado').value = data.area;
                document.getElementById('edit_estado_empleado').value = data.estado;

                document.getElementById('formEditEmpleado').action = "{{ url('admin/usuarios/empleado') }}/" + data.documento;

                if(btnGuardarEditEmpleado) {
                    btnGuardarEditEmpleado.disabled = false;
                    btnGuardarEditEmpleado.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                // Reset validations
                Object.keys(reglasEditarEmpleado).forEach(id => {
                    const el = document.getElementById(id);
                    if(el) el.classList.remove('border-red-500', 'border-green-500');
                    const err = document.getElementById(reglasEditarEmpleado[id].error);
                    if(err) err.classList.add('hidden');
                });

                modalEmpleadoEdit.classList.remove('hidden');
            });
        });

        /* ===========================
           MODAL EDITAR REMITENTE
        ============================*/
        document.querySelectorAll('.btn-open-edit-remitente').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = {
                    documento: btn.dataset.documento || '',
                    nombres: btn.dataset.nombres || '',
                    apellidos: btn.dataset.apellidos || '',
                    telefono: btn.dataset.telefono || '',
                    correo: btn.dataset.correo || '',
                    ciudad: btn.dataset.ciudad || '',
                    estado: btn.dataset.estado || ''
                };

                originalEditRemitenteData = { ...data };

                document.getElementById('edit_doc_remitente').value = data.documento;
                document.getElementById('edit_nom_remitente').value = data.nombres;
                document.getElementById('edit_ape_remitente').value = data.apellidos;
                document.getElementById('edit_tel_remitente').value = data.telefono;
                document.getElementById('edit_cor_remitente').value = data.correo;
                document.getElementById('edit_estado_remitente').value = data.estado;
                
                if (typeof jQuery !== 'undefined') {
                    $('#edit_ciudad_remitente').val(data.ciudad).trigger('change');
                } else {
                    document.getElementById('edit_ciudad_remitente').value = data.ciudad;
                }
                
                // Forzar trigger de cambio de estado para visualización si es necesario
                const editEstadoRemitente = document.getElementById('edit_estado_remitente');
                if(editEstadoRemitente) {
                    editEstadoRemitente.value = data.estado;
                }

                document.getElementById('formEditRemitente').action = "{{ url('admin/usuarios/remitente') }}/" + data.documento;

                if(btnGuardarEditRemitente) {
                    btnGuardarEditRemitente.disabled = false;
                    btnGuardarEditRemitente.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                // Reset validations
                Object.keys(reglasEditarRemitente).forEach(id => {
                    const el = document.getElementById(id);
                    if(el) el.classList.remove('border-red-500', 'border-green-500');
                    const err = document.getElementById(reglasEditarRemitente[id].error);
                    if(err) err.classList.add('hidden');
                });

                modalRemitenteEdit.classList.remove('hidden');
            });
        });

        /* ===========================
           MODAL VER DETALLES
        ============================*/
        document.querySelectorAll('.btn-view-details').forEach(btn => {
            btn.addEventListener('click', function() {
                const type = btn.dataset.type;
                
                document.getElementById('detallesNombres').textContent = btn.dataset.nombres || '-';
                document.getElementById('detallesDoc').textContent = btn.dataset.doc || '-';
                document.getElementById('detallesCorreo').textContent = btn.dataset.correo || '-';
                document.getElementById('detallesTelefono').textContent = btn.dataset.telefono || '-';
                document.getElementById('detallesEmpresa').textContent = btn.dataset.empresa || '-';
                document.getElementById('detallesNit').textContent = btn.dataset.nit || '-';
                
                const estado = btn.dataset.estado || 'Inactivo';
                const elEstado = document.getElementById('detallesEstado');
                elEstado.textContent = estado;
                
                const avatarContainer = document.getElementById('detallesAvatarContainer');
                if(btn.dataset.avatar) {
                    avatarContainer.innerHTML = `<img src="${btn.dataset.avatar}" class="w-full h-full object-cover">`;
                } else {
                    avatarContainer.innerHTML = `<span class="material-symbols-outlined text-4xl text-gray-400">person</span>`;
                }

                const extra1Container = document.getElementById('detallesExtra1Container');
                const extra2Container = document.getElementById('detallesExtra2Container');

                if (type === 'empleado') {
                    document.getElementById('detallesTitle').textContent = "Detalles del Empleado";
                    document.getElementById('detallesExtra1Label').textContent = "Área";
                    document.getElementById('detallesExtra1Value').textContent = btn.dataset.area || '-';
                    extra1Container.style.display = 'block';

                    document.getElementById('detallesExtra2Label').textContent = "Rol";
                    document.getElementById('detallesExtra2Value').textContent = btn.dataset.rol || '-';
                    extra2Container.style.display = 'block';
                } else if (type === 'remitente') {
                    document.getElementById('detallesTitle').textContent = "Detalles del Remitente";
                    document.getElementById('detallesExtra1Label').textContent = "Ciudad";
                    document.getElementById('detallesExtra1Value').textContent = btn.dataset.ciudad || '-';
                    extra1Container.style.display = 'block';

                    document.getElementById('detallesExtra2Label').textContent = "Dirección";
                    document.getElementById('detallesExtra2Value').textContent = btn.dataset.direccion || '-';
                    extra2Container.style.display = 'block';
                }
                
                modalDetalles.classList.remove('hidden');
            });
        });

        /* ===========================
           MECANISMOS DE VALIDACIÓN
        ============================*/
        let camposTocados = {};

        function initRealTimeValidation(reglasDict) {
            Object.keys(reglasDict).forEach(id => {
                const input = document.getElementById(id);
                if (!input) return;

                input.addEventListener('input', () => {
                    const valor = input.value.trim();
                    if (valor.length > 0) camposTocados[id] = true;
                    validarCampoIndividual(id, reglasDict);
                });

                input.addEventListener('blur', () => {
                    camposTocados[id] = true;
                    validarCampoIndividual(id, reglasDict);
                });
            });
        }

        function validarCampoIndividual(id, reglasDict) {
            const input = document.getElementById(id);
            const regla = reglasDict[id];
            if (!input || !regla) return;
            
            const error = document.getElementById(regla.error);
            if (!camposTocados[id]) return;

            const valor = input.value.trim();

            input.classList.remove('border-red-500', 'border-green-500');
            if(error) error.classList.add('hidden');

            if (regla.isPassword) {
                if (valor === '') {
                    input.classList.add('border-red-500');
                    if(error) { error.textContent = regla.mensajes.required; error.classList.remove('hidden'); }
                    return;
                }
                if (valor.length > regla.max) {
                    input.classList.add('border-red-500');
                    if(error) { error.textContent = regla.mensajes.max; error.classList.remove('hidden'); }
                    return;
                }
                const regexEstructura = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!"#$%&\/()=@.,;:?~^_*+\-])[^\s]{10,64}$/;
                if (!regexEstructura.test(valor)) {
                    input.classList.add('border-red-500');
                    if(error) { error.textContent = regla.mensajes.regex; error.classList.remove('hidden'); }
                    return;
                }
                if (valor.length < regla.min) {
                    input.classList.add('border-red-500');
                    if(error) { error.textContent = regla.mensajes.min; error.classList.remove('hidden'); }
                    return;
                }
                input.classList.add('border-green-500');
                return;
            }

            if (regla.required && valor === '') {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.required; error.classList.remove('hidden'); }
                return;
            }
            if (regla.min && valor.length < regla.min) {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.min; error.classList.remove('hidden'); }
                return;
            }
            if (regla.max && valor.length > regla.max) {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.max; error.classList.remove('hidden'); }
                return;
            }
            if (regla.custom && !regla.custom(valor)) {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.custom; error.classList.remove('hidden'); }
                return;
            }
            if (regla.regex && !regla.regex.test(valor)) {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.regex; error.classList.remove('hidden'); }
                return;
            }
            if (valor !== '' || regla.required) {
                input.classList.add('border-green-500');
            }
        }

        function validarFormulario(reglasDict) {
            let todoValido = true;
            Object.keys(reglasDict).forEach(id => {
                const input = document.getElementById(id);
                if(!input) return;
                const valor = input.value.trim();
                const regla = reglasDict[id];

                if (regla.isPassword) {
                    const regexEstructura = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s])[^\s]{10,64}$/;
                    if (valor === '' || valor.length < regla.min || valor.length > regla.max || !regexEstructura.test(valor)) {
                        todoValido = false;
                        camposTocados[id] = true;
                        validarCampoIndividual(id, reglasDict);
                    }
                    return;
                }

                if (
                    (regla.required && valor === '') ||
                    (regla.min && valor.length < regla.min) ||
                    (regla.max && valor.length > regla.max) ||
                    (regla.custom && !regla.custom(valor)) ||
                    (regla.regex && valor !== '' && !regla.regex.test(valor))
                ) {
                    todoValido = false;
                    camposTocados[id] = true;
                    validarCampoIndividual(id, reglasDict);
                }
            });
            return todoValido;
        }

        function validarCampoEditar(id, reglasDict) {
            const input = document.getElementById(id);
            const regla = reglasDict[id];
            if (!input || !regla) return true;
            
            const error = document.getElementById(regla.error);
            const valor = input.value.trim();

            input.classList.remove('border-red-500', 'border-green-500');
            if(error) error.classList.add('hidden');

            if (regla.required && valor === '') {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.required; error.classList.remove('hidden'); }
                return false;
            }
            if (regla.min && valor.length < regla.min) {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.min; error.classList.remove('hidden'); }
                return false;
            }
            if (regla.max && valor.length > regla.max) {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.max; error.classList.remove('hidden'); }
                return false;
            }
            if (regla.custom && !regla.custom(valor)) {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.custom; error.classList.remove('hidden'); }
                return false;
            }
            if (regla.regex && valor !== '' && !regla.regex.test(valor)) {
                input.classList.add('border-red-500');
                if(error) { error.textContent = regla.mensajes.regex; error.classList.remove('hidden'); }
                return false;
            }

            if(valor !== '') input.classList.add('border-green-500');
            return true;
        }

        function initRealTimeValidationEditar(reglasDict) {
            Object.keys(reglasDict).forEach(id => {
                const input = document.getElementById(id);
                if (!input) return;
                input.addEventListener('input', () => {
                    validarCampoEditar(id, reglasDict);
                });
            });
        }

        function validarEditarForm(reglasDict) {
            let todoValido = true;
            Object.keys(reglasDict).forEach(id => {
                if (!validarCampoEditar(id, reglasDict)) {
                    todoValido = false;
                }
            });
            return todoValido;
        }

        function validarImagen(idInput, idError, maxMB) {
            const inputImagen = document.getElementById(idInput);
            const errorImagen = document.getElementById(idError);
            if(!inputImagen) return true;
            const archivo = inputImagen.files[0];

            if (!archivo) return true;

            const tamañoMaximo = maxMB * 1024 * 1024;
            const tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

            if (archivo.size > tamañoMaximo) {
                if(errorImagen) {
                    errorImagen.textContent = `La imagen no puede superar los ${maxMB}MB`;
                    errorImagen.classList.remove('hidden');
                }
                Swal.fire({ icon: 'error', title: 'Archivo demasiado grande', text: `La imagen no puede superar los ${maxMB}MB`, confirmButtonText: 'OK' });
                return false;
            }

            if (!tiposPermitidos.includes(archivo.type)) {
                if(errorImagen) {
                    errorImagen.textContent = "Formato inválido. Solo JPG, PNG o WEBP.";
                    errorImagen.classList.remove('hidden');
                }
                Swal.fire({ icon: 'error', title: 'Formato inválido', text: 'Solo se permiten imágenes JPG, PNG o WEBP.', confirmButtonText: 'OK' });
                return false;
            }

            if(errorImagen) errorImagen.classList.add('hidden');
            return true;
        }

        /* ===========================
           REGLAS EMPLEADO CREAR
        ===========================*/
        const reglasCrearEmpleado = {
            doc_empleado: { required: true, min: 6, max: 10, regex: /^[0-9]+$/, custom: val => !/^(\d)\1+$/.test(val), error: 'error-doc-emp', mensajes: { required: 'El documento es obligatorio.', min: 'Mínimo 6 dígitos.', max: 'Máximo 10 dígitos.', regex: 'Solo números.', custom: 'No se permiten repetidos.' } },
            area_empleado: { required: true, error: 'error-area-emp', mensajes: { required: 'Debe seleccionar un área.' } },
            rol_empleado: { required: true, error: 'error-rol-emp', mensajes: { required: 'Debe seleccionar un rol.' } },
            nom_empleado: { required: true, min: 3, max: 50, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/, custom: val => val.trim().split(/\s+/).length <= 2, error: 'error-nom-emp', mensajes: { required: 'El nombre es obligatorio.', min: 'Mínimo 3 letras.', max: 'No puede superar 50 caracteres.', regex: 'Solo letras, sin espacios.', custom: 'Máximo 2 palabras.' } },
            ape_empleado: { required: true, min: 3, max: 50, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/, custom: val => val.trim().split(/\s+/).length <= 2, error: 'error-ape-emp', mensajes: { required: 'Los apellidos son obligatorios.', min: 'Mínimo 3 letras.', max: 'No puede superar 50 caracteres.', regex: 'Solo letras, sin espacios.', custom: 'Máximo 2 palabras.' } },
            tel_empleado: { required: true, min: 7, max: 12, regex: /^[0-9]+$/, error: 'error-tel-emp', mensajes: { required: 'El teléfono es obligatorio.', min: 'Mínimo 7 dígitos.', max: 'Máximo 12 dígitos.', regex: 'Solo números.' } },
            cor_empleado: { required: true, min: 8, max: 150, regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, error: 'error-cor-emp', mensajes: { required: 'El correo es obligatorio.', min: 'El correo debe tener mínimo 8 caracteres.', max: 'El correo no puede superar 150 caracteres.', regex: 'Debe tener un formato válido ejemplo: texto@texto.dominio' } },
            pass_empleado: { required: true, min: 10, max: 64, isPassword: true, error: 'error-pass-emp', mensajes: { required: 'La contraseña es obligatoria.', min: 'Debe tener mínimo 10 caracteres.', max: 'No puede superar 64 caracteres.', regex: 'Debe incluir: 1 mayúscula, 1 minúscula, 1 número, 1 carácter especial y sin espacios.' } }
        };

        initRealTimeValidation(reglasCrearEmpleado);

        const formCrearEmpleado = document.getElementById('empleadoForm');
        if(formCrearEmpleado) {
            formCrearEmpleado.addEventListener('submit', function(e) {
                if (!validarFormulario(reglasCrearEmpleado)) {
                    e.preventDefault();
                    Swal.fire({ icon: 'warning', title: 'Campos Incompletos', text: 'Por favor, revise los campos marcados en rojo.', confirmButtonText: 'OK' });
                    return;
                }
                if (!validarImagen('img_empleado', 'error-img-emp', 1)) {
                    e.preventDefault();
                    return;
                }
            });
        }

        /* ===========================
           REGLAS EMPLEADO EDITAR
        ============================*/
        const reglasEditarEmpleado = {
            edit_area_empleado: { required: true, error: 'edit-error-area-emp', mensajes: { required: 'El área es obligatoria.' } },
            edit_nom_empleado: { required: true, min: 3, max: 50, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/, custom: val => val.trim().split(/\s+/).length <= 2, error: 'edit-error-nom-emp', mensajes: { required: 'El nombre es obligatorio.', min: 'Mínimo 3 letras.', max: 'No puede superar 50 caracteres.', regex: 'Solo letras, sin espacios.', custom: 'Máximo 2 palabras.' } },
            edit_ape_empleado: { required: true, min: 3, max: 50, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/, custom: val => val.trim().split(/\s+/).length <= 2, error: 'edit-error-ape-emp', mensajes: { required: 'Los apellidos son obligatorios.', min: 'Mínimo 3 letras.', max: 'No puede superar 50 caracteres.', regex: 'Solo letras, sin espacios.', custom: 'Máximo 2 palabras.' } },
            edit_tel_empleado: { required: true, min: 7, max: 12, regex: /^[0-9]+$/, error: 'edit-error-tel-emp', mensajes: { required: 'El teléfono es obligatorio.', min: 'Mínimo 7 dígitos.', max: 'Máximo 12 dígitos.', regex: 'Solo números.' } },
            edit_cor_empleado: { required: true, min: 8, max: 150, regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, error: 'edit-error-cor-emp', mensajes: { required: 'El correo es obligatorio.', min: 'Mínimo 8 caracteres.', max: 'Máximo 150 caracteres.', regex: 'Formato inválido.' } }
        };

        initRealTimeValidationEditar(reglasEditarEmpleado);

        let ultimoEnvioEditEmp = 0;
        const formEditEmpleado = document.getElementById('formEditEmpleado');
        if(formEditEmpleado) {
            formEditEmpleado.addEventListener('submit', function(e) {
                const ahora = Date.now();
                if (ahora - ultimoEnvioEditEmp < 2000) { e.preventDefault(); return; }
                ultimoEnvioEditEmp = ahora;

                if (!validarEditarForm(reglasEditarEmpleado)) {
                    e.preventDefault();
                    Swal.fire({ icon: 'warning', title: 'Errores de Validación', text: 'Por favor, verifica los campos resaltados', timer: 2000, confirmButtonText: 'OK' });
                    return;
                }

                if (!validarImagen('edit_img_empleado', 'edit-error-img-emp', 1)) {
                    e.preventDefault();
                    return;
                }

                const fotoInput = document.getElementById('edit_img_empleado');
                const huboCambios = (
                    originalEditEmpleadoData.documento !== document.getElementById('edit_doc_empleado').value.trim() ||
                    originalEditEmpleadoData.nombres !== document.getElementById('edit_nom_empleado').value.trim() ||
                    originalEditEmpleadoData.apellidos !== document.getElementById('edit_ape_empleado').value.trim() ||
                    originalEditEmpleadoData.telefono !== document.getElementById('edit_tel_empleado').value.trim() ||
                    originalEditEmpleadoData.correo !== document.getElementById('edit_cor_empleado').value.trim() ||
                    originalEditEmpleadoData.area !== document.getElementById('edit_area_empleado').value ||
                    originalEditEmpleadoData.estado !== document.getElementById('edit_estado_empleado').value ||
                    (fotoInput && fotoInput.files.length > 0)
                );

                if (!huboCambios) {
                    e.preventDefault();
                    Swal.fire({ icon: 'info', title: 'Sin cambios', text: 'No hay cambios que guardar.', timer: 2000, confirmButtonText: 'OK' });
                    return;
                }
            });
        }

        /* ===========================
           REGLAS REMITENTE CREAR
        ===========================*/
        const reglasCrearRemitente = {
            doc_remitente: { required: true, min: 6, max: 15, regex: /^[0-9]+$/, custom: val => !/^(\d)\1+$/.test(val), error: 'error-doc-rem', mensajes: { required: 'El documento es obligatorio.', min: 'Mínimo 6 dígitos.', max: 'Máximo 15 dígitos.', regex: 'Solo números.', custom: 'No se permiten repetidos.' } },
            ciudad_remitente: { required: true, error: 'error-ciu-rem', mensajes: { required: 'La ciudad es obligatoria.' } },
            nom_remitente: { required: true, min: 3, max: 50, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/, custom: val => val.trim().split(/\s+/).length <= 2, error: 'error-nom-rem', mensajes: { required: 'El nombre es obligatorio.', min: 'Mínimo 3 letras.', max: 'No puede superar 50 caracteres.', regex: 'Solo letras, sin espacios.', custom: 'Máximo 2 palabras.' } },
            ape_remitente: { required: true, min: 3, max: 50, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/, custom: val => val.trim().split(/\s+/).length <= 2, error: 'error-ape-rem', mensajes: { required: 'Los apellidos son obligatorios.', min: 'Mínimo 3 letras.', max: 'No puede superar 50 caracteres.', regex: 'Solo letras, sin espacios.', custom: 'Máximo 2 palabras.' } },
            tel_remitente: { required: true, min: 7, max: 12, regex: /^[0-9]+$/, error: 'error-tel-rem', mensajes: { required: 'El teléfono es obligatorio.', min: 'Mínimo 7 dígitos.', max: 'Máximo 12 dígitos.', regex: 'Solo números.' } },
            cor_remitente: { required: true, min: 8, max: 150, regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, error: 'error-cor-rem', mensajes: { required: 'El correo es obligatorio.', min: 'El correo debe tener mínimo 8 caracteres.', max: 'El correo no puede superar 150 caracteres.', regex: 'Debe tener un formato válido.' } },
            pass_remitente: { required: true, min: 10, max: 64, isPassword: true, error: 'error-pass-rem', mensajes: { required: 'La contraseña es obligatoria.', min: 'Debe tener mínimo 10 caracteres.', max: 'No puede superar 64 caracteres.', regex: 'Debe incluir: 1 mayúscula, 1 minúscula, 1 número, 1 carácter especial y sin espacios.' } }
        };

        initRealTimeValidation(reglasCrearRemitente);

        const formCrearRemitente = document.getElementById('remitenteForm');
        if(formCrearRemitente) {
            formCrearRemitente.addEventListener('submit', function(e) {
                if (!validarFormulario(reglasCrearRemitente)) {
                    e.preventDefault();
                    Swal.fire({ icon: 'warning', title: 'Campos Incompletos', text: 'Por favor, revise los campos marcados en rojo.', confirmButtonText: 'OK' });
                    return;
                }
            });
        }

        /* ===========================
           REGLAS REMITENTE EDITAR
        ============================*/
        const reglasEditarRemitente = {
            edit_ciudad_remitente: { required: true, error: 'edit-error-ciu-rem', mensajes: { required: 'La ciudad es obligatoria.' } },
            edit_nom_remitente: { required: true, min: 3, max: 50, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/, custom: val => val.trim().split(/\s+/).length <= 2, error: 'edit-error-nom-rem', mensajes: { required: 'El nombre es obligatorio.', min: 'Mínimo 3 letras.', max: 'No puede superar 50 caracteres.', regex: 'Solo letras, sin espacios.', custom: 'Máximo 2 palabras.' } },
            edit_ape_remitente: { required: true, min: 3, max: 50, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/, custom: val => val.trim().split(/\s+/).length <= 2, error: 'edit-error-ape-rem', mensajes: { required: 'Los apellidos son obligatorios.', min: 'Mínimo 3 letras.', max: 'No puede superar 50 caracteres.', regex: 'Solo letras, sin espacios.', custom: 'Máximo 2 palabras.' } },
            edit_tel_remitente: { required: true, min: 7, max: 12, regex: /^[0-9]+$/, error: 'edit-error-tel-rem', mensajes: { required: 'El teléfono es obligatorio.', min: 'Mínimo 7 dígitos.', max: 'Máximo 12 dígitos.', regex: 'Solo números.' } },
            edit_cor_remitente: { required: true, min: 8, max: 150, regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, error: 'edit-error-cor-rem', mensajes: { required: 'El correo es obligatorio.', min: 'Mínimo 8 caracteres.', max: 'Máximo 150 caracteres.', regex: 'Formato inválido.' } }
        };

        initRealTimeValidationEditar(reglasEditarRemitente);

        let ultimoEnvioEditRem = 0;
        const formEditRemitente = document.getElementById('formEditRemitente');
        if(formEditRemitente) {
            formEditRemitente.addEventListener('submit', function(e) {
                const ahora = Date.now();
                if (ahora - ultimoEnvioEditRem < 2000) { e.preventDefault(); return; }
                ultimoEnvioEditRem = ahora;

                if (!validarEditarForm(reglasEditarRemitente)) {
                    e.preventDefault();
                    Swal.fire({ icon: 'warning', title: 'Errores de Validación', text: 'Por favor, verifica los campos resaltados', timer: 2000, confirmButtonText: 'OK' });
                    return;
                }

                const huboCambios = (
                    originalEditRemitenteData.documento !== document.getElementById('edit_doc_remitente').value.trim() ||
                    originalEditRemitenteData.nombres !== document.getElementById('edit_nom_remitente').value.trim() ||
                    originalEditRemitenteData.apellidos !== document.getElementById('edit_ape_remitente').value.trim() ||
                    originalEditRemitenteData.telefono !== document.getElementById('edit_tel_remitente').value.trim() ||
                    originalEditRemitenteData.correo !== document.getElementById('edit_cor_remitente').value.trim() ||
                    originalEditRemitenteData.ciudad !== document.getElementById('edit_ciudad_remitente').value ||
                    originalEditRemitenteData.estado !== document.getElementById('edit_estado_remitente').value
                );

                if (!huboCambios) {
                    e.preventDefault();
                    Swal.fire({ icon: 'info', title: 'Sin cambios', text: 'No hay cambios que guardar.', timer: 2000, confirmButtonText: 'OK' });
                    return;
                }
            });
        }
        // Fin duplicado removido
    });
</script>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const modalTypeEmpleado = "{{ old('modal_type_empleado') }}";
        const modalTypeRemitente = "{{ old('modal_type_remitente') }}";

        if (modalTypeEmpleado === 'edit') {
            const modalEditarEmpleado = document.getElementById('empleadoModalEdit');
            modalEditarEmpleado.classList.remove('hidden');

            const documento = "{{ old('emple_doc') }}";
            if (documento) {
                document.getElementById('formEditEmpleado').action = "{{ url('admin/usuarios/empleado') }}/" + documento;
            }

            modalEditarEmpleado.querySelectorAll('input, select, textarea').forEach(input => {
                const name = input.name;
                if (!name) return;
                const valorOld = "{{ old('" + name + "') }}";
                // Don't overwrite document and rol if not needed, but typically ok in edit
                if (valorOld !== '') input.value = valorOld;
            });
        } 
        else if (modalTypeRemitente === 'edit') {
            const modalEditarRemitente = document.getElementById('remitenteModalEdit');
            modalEditarRemitente.classList.remove('hidden');

            const documento = "{{ old('rem_doc') }}";
            if (documento) {
                document.getElementById('formEditRemitente').action = "{{ url('admin/usuarios/remitente') }}/" + documento;
            }

            modalEditarRemitente.querySelectorAll('input, select, textarea').forEach(input => {
                const name = input.name;
                if (!name) return;
                const valorOld = "{{ old('" + name + "') }}";
                if (valorOld !== '') {
                    input.value = valorOld;
                    if(name === 'rem_ciudad' && typeof jQuery !== 'undefined') {
                        $('#edit_ciudad_remitente').val(valorOld).trigger('change');
                    }
                }
            });
        } 
        else {
            if ("{{ old('emple_doc') }}" || "{{ old('emple_nombres') }}") {
                const modalCrearEmpleado = document.getElementById('empleadoModal');
                modalCrearEmpleado.classList.remove('hidden');

                modalCrearEmpleado.querySelectorAll('input, select, textarea').forEach(input => {
                    const name = input.name;
                    if (!name) return;
                    const valorOld = "{{ old('" + name + "') }}";
                    if (valorOld !== '') input.value = valorOld;
                });
            }

            if ("{{ old('rem_doc') }}" || "{{ old('rem_nombres') }}") {
                const modalCrearRemitente = document.getElementById('remitenteModal');
                modalCrearRemitente.classList.remove('hidden');

                modalCrearRemitente.querySelectorAll('input, select, textarea').forEach(input => {
                    const name = input.name;
                    if (!name) return;
                    const valorOld = "{{ old('" + name + "') }}";
                    if (valorOld !== '') {
                        input.value = valorOld;
                        if(name === 'rem_ciudad' && typeof jQuery !== 'undefined') {
                            $('#ciudad_remitente').val(valorOld).trigger('change');
                        }
                    }
                });
            }
        }
    });
</script>
@endif

{{-- SWEET ALERTS --}}
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Operación exitosa',
            text: "{{ session('success') }}",
            confirmButtonColor: '#16a34a',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Entendido'
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'error',
            title: 'Errores en el formulario',
            html: `
            <ul style="text-align:left;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            `,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    });
</script>
@endif

@endsection

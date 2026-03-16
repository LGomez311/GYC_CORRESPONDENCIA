@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

@section('content')
<div class="p-4 md:p-8 max-w-7xl mx-auto w-full">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                Gestión de Licencias
            </h1>
            <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">
                Cree, gestione y active/desactive licencias para las empresas.
            </p>
        </div>
    </div>

    {{-- CONTENEDOR DE TABLA --}}
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

        {{-- HEADER TABLA --}}
        <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Listado de Licencias</h2>
            <div class="flex items-center gap-3">
                {{-- Botón Historial --}}
                <button id="btnOpenHistorial" class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                    <span class="material-symbols-outlined text-sm">history</span>
                    Historial
                </button>

                {{-- Botón Exportar --}}
                <button onclick="openExportModal()" class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Exportar
                </button>
            </div>

            <!-- Modal Exportar -->
            <div id="exportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5 relative">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Exportar como</h3>

                    <div class="flex flex-col gap-3">
                        <!-- PDF -->
                        <a href="{{ route('sadmin.licencias.export.pdf') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                            <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                            PDF
                        </a>

                        <!-- Excel -->
                        <a href="{{ route('sadmin.licencias.export.excel') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                            <span class="material-symbols-outlined text-green-600">grid_on</span>
                            Excel
                        </a>
                    </div>

                    <button onclick="closeExportModal()"
                        class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        Cancelar
                    </button>
                </div>
            </div>



        </div>

        {{-- TABLA --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Empresa</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Plan</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Estado</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Inicio</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Fin</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Tipo</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                    @forelse($licencias as $licencia)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-6 py-4 text-sm">{{ $licencia->id_licencia }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $licencia->pago->admin->empresa->nomb_empresa ?? 'Empresa no encontrada' }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    NIT: {{ $licencia->pago->admin->empresa->nit_empresa ?? '-' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $licencia->pago->plan->nomb_plan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $licencia->estado->estado_nomb ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ \Carbon\Carbon::parse($licencia->fecha_inicio)->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ \Carbon\Carbon::parse($licencia->fecha_fin)->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $licencia->tipo_licencia }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('sadmin.licencias.toggle', $licencia->id_licencia) }}"
                                method="POST"
                                class="form-toggle">
                                @csrf
                                <button type="button"
                                    class="btn-toggle px-3 py-1.5 rounded text-xs font-bold text-white
                                    {{ $licencia->id_estado == 1 ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">

                                    {{ $licencia->id_estado == 1 ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-400">
                            No hay licencias registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        {{-- PAGINACIÓN --}}
        <div class="flex gap-1">
            {{ $licencias->links() }}
        </div>

    </div>
</div>

{{-- MODAL HISTORIAL --}}
<div id="historialModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-4xl max-h-[85vh] flex flex-col">
        <div class="p-5 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    Historial de Modificaciones
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Registro de cambios realizados a las licencias en el sistema.
                </p>
            </div>
            <button onclick="closeHistorialModal()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="p-5 overflow-y-auto flex-1">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 dark:bg-gray-800/50 sticky top-0">
                        <tr>
                            <th
                                class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Fecha / Hora</th>
                            <th
                                class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Licencia Afectada</th>
                            <th
                                class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Modificado Por</th>
                            <th
                                class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
                                Detalles</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($auditorias as $auditoria)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td
                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $auditoria->fecha_cambio->format('d/m/Y H:i A') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    <div class="font-semibold text-primary">
                                        Licencia #{{ $auditoria->id_licencia_afectada }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    <div class="font-semibold">
                                        {{ $auditoria->responsable->emple_nombres ?? 'Sistema' }}
                                        {{ $auditoria->responsable->emple_apellidos ?? '' }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $auditoria->usuario_app ? 'C.C. ' . $auditoria->usuario_app : 'BD' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button onclick="verDetallesCambio({{ $auditoria->id_log }})"
                                        class="text-primary hover:text-blue-700 bg-blue-50 dark:bg-blue-900/20 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 mx-auto transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        Ver Cambios
                                    </button>
                                    <!-- Datos Ocultos para JS -->
                                    <div id="datos-ant-{{ $auditoria->id_log }}" class="hidden">
                                        {{ json_encode($auditoria->datos_anteriores) }}
                                    </div>
                                    <div id="datos-nue-{{ $auditoria->id_log }}" class="hidden">
                                        {{ json_encode($auditoria->datos_nuevos) }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <span
                                            class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">history</span>
                                        Aún no hay registros de modificaciones
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETALLES DE CAMBIOS --}}
<div id="detallesCambioModal"
    class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-[60] p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl w-full max-w-3xl flex flex-col overflow-hidden">
        <div
            class="p-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h4 class="text-md font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">compare_arrows</span>
                Comparación de Datos
            </h4>
            <button onclick="closeDetallesCambioModal()"
                class="text-gray-500 hover:text-red-600 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto max-h-[70vh]">
            <div class="grid grid-cols-2 gap-6" id="contenedor-comparacion">
                <!-- Se renderiza via JS -->
            </div>
        </div>
        
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button onclick="closeDetallesCambioModal()" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg transition-colors">
                Cerrar Detalles
            </button>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalExport = document.getElementById('exportModal');

        // Abrir modal
        window.openExportModal = function() {
            modalExport.classList.remove('hidden');
            modalExport.classList.add('flex');
        }

        // Cerrar modal
        window.closeExportModal = function() {
            modalExport.classList.add('hidden');
            modalExport.classList.remove('flex');
        }

        // Cerrar al hacer click fuera del modal
        modalExport.addEventListener('click', function(e) {
            if (e.target.id === 'exportModal') {
                closeExportModal();
            }
        });

        /* ===========================
           HISTORIAL DE AUDITORÍA
        ============================*/
        const btnHistorial = document.getElementById('btnOpenHistorial');
        if (btnHistorial) {
            btnHistorial.addEventListener('click', () => {
                document.getElementById('historialModal').classList.remove('hidden');
            });
        }

        window.closeHistorialModal = function() {
            document.getElementById('historialModal').classList.add('hidden');
        }

        window.closeDetallesCambioModal = function() {
            document.getElementById('detallesCambioModal').classList.add('hidden');
        }

        window.verDetallesCambio = function(idLog) {
            const modal = document.getElementById('detallesCambioModal');
            const contenedor = document.getElementById('contenedor-comparacion');
            
            // Mapas de nombres
            const estadosMap = {!! $estados->pluck('estado_nomb', 'id_estado')->toJson() !!};

            try {
                const datosAnt = JSON.parse(document.getElementById(`datos-ant-${idLog}`).textContent
                .trim() || '{}');
                const datosNue = JSON.parse(document.getElementById(`datos-nue-${idLog}`).textContent
                .trim() || '{}');
                
                let htmlAnt =
                    '<div class="flex flex-col gap-3"><h5 class="font-bold text-red-600 border-b pb-2 mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">remove_circle</span> Datos Anteriores</h5>';
                let htmlNue =
                    '<div class="flex flex-col gap-3"><h5 class="font-bold text-green-600 border-b pb-2 mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">add_circle</span> Datos Nuevos</h5>';
                
                const camposRelevantes = ['id_estado', 'id_pago', 'fecha_inicio', 'fecha_fin', 'tipo_licencia', 'licencia_origen'];
                const labelsMap = {
                    'id_estado': 'Estado de Licencia',
                    'id_pago': 'ID Pago Asociado',
                    'fecha_inicio': 'Fecha de Inicio',
                    'fecha_fin': 'Fecha de Finalización',
                    'tipo_licencia': 'Tipo de Licencia',
                    'licencia_origen': 'Licencia Origen (Renovación)'
                };
                
                camposRelevantes.forEach(campo => {
                    let valAnt = datosAnt[campo] ?? 'No definido';
                    let valNue = datosNue[campo] ?? 'No definido';
                    
                    const esDiferente = String(valAnt) !== String(valNue);

                    // Reemplazo de IDs por Nombres si aplica
                    if (campo === 'id_estado') {
                        valAnt = estadosMap[valAnt] || valAnt;
                        valNue = estadosMap[valNue] || valNue;
                    }
                    
                    // Resaltar si cambió
                    const claseAnt = esDiferente ?
                        'bg-red-50 text-red-700 p-2 rounded border border-red-100' :
                        'p-2 text-gray-600';
                    const claseNue = esDiferente ?
                        'bg-green-50 text-green-700 p-2 rounded border border-green-100' :
                        'p-2 text-gray-600';
                    
                    const label = labelsMap[campo] || campo;
                    
                    htmlAnt += `
                        <div class="${claseAnt}">
                            <div class="text-xs font-bold uppercase tracking-wider mb-1 opacity-70">${label}</div>
                            <div class="text-sm break-words">${valAnt}</div>
                        </div>
                    `;
                    
                    htmlNue += `
                        <div class="${claseNue}">
                            <div class="text-xs font-bold uppercase tracking-wider mb-1 opacity-70">${label}</div>
                            <div class="text-sm break-words">${valNue}</div>
                        </div>
                    `;
                });
                
                htmlAnt += '</div>';
                htmlNue += '</div>';

                contenedor.innerHTML = htmlAnt + htmlNue;
                modal.classList.remove('hidden');

            } catch (error) {
                console.error("Error al procesar JSON de detalles", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Datos',
                    text: 'No se pudieron cargar los detalles de este cambio.'
                });
            }
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.btn-toggle').forEach(button => {

            button.addEventListener('click', function() {

                const form = this.closest('form');
                const isActive = this.textContent.trim() === 'Desactivar';

                Swal.fire({
                    title: isActive ? '¿Desactivar licencia?' : '¿Activar licencia?',
                    text: isActive ?
                        "La empresa perderá acceso al sistema." : "La empresa podrá acceder nuevamente al sistema.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: isActive ? '#dc2626' : '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: isActive ? 'Sí, desactivar' : 'Sí, activar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });

        });

    });
</script>
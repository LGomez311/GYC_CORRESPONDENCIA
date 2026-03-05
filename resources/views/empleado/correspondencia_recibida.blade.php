@extends('empleado.layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Correspondencia Recibida</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Gestiona y haz seguimiento a todos los documentos radicados que han ingresado.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span>
                Nuevo Ingreso
            </button>
        </div>
    </div>

    <!-- Stats Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined">inbox</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Recibidas</p>
                <p class="text-2xl font-bold dark:text-white">124</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                <span class="material-symbols-outlined">hourglass_empty</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">En Trámite</p>
                <p class="text-2xl font-bold dark:text-white">45</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Finalizadas</p>
                <p class="text-2xl font-bold dark:text-white">72</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                <span class="material-symbols-outlined">error</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Vencidas / Alerta</p>
                <p class="text-2xl font-bold dark:text-white">7</p>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        
        <!-- Filters -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="flex gap-2 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
                    <input type="text" placeholder="Buscar por radicado, asunto..." 
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50">
                </div>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <select class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-slate-900 dark:text-white py-2 px-3">
                    <option value="">Todos los estados</option>
                    <option value="recibido">Recibido</option>
                    <option value="tramite">En Trámite</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 font-medium">No. Radicado</th>
                        <th class="px-6 py-3 font-medium">Remitente</th>
                        <th class="px-6 py-3 font-medium">Asunto</th>
                        <th class="px-6 py-3 font-medium">Fecha Ingreso</th>
                        <th class="px-6 py-3 font-medium">Estado Actual</th>
                        <th class="px-6 py-3 font-medium text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-primary dark:text-blue-400">RAD-2026-00123</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium dark:text-white">Alcaldía Municipal</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">NIT o CC: 890.123.456-7</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-[200px] truncate dark:text-white" title="Solicitud de información predial zona sur">Solicitud de información predial zona sur</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="dark:text-white">05 Mar 2026</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">08:30 AM</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                En Trámite
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button title="Ver y añadir seguimiento" onclick="toggleModal('modalSeguimiento')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                <span class="material-symbols-outlined text-xl">timeline</span>
                            </button>
                            <button title="Actualizar estado" onclick="toggleModal('modalEstado')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                <span class="material-symbols-outlined text-xl">edit_document</span>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-primary dark:text-blue-400">RAD-2026-00122</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium dark:text-white">Juan Pérez</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">CC: 1.023.456.789</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-[200px] truncate dark:text-white" title="Petición queja sobre servicio de acueducto y alcantarillado comunal">Petición queja sobre servicio de acue...</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="dark:text-white">04 Mar 2026</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">14:15 PM</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                Finalizado
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button title="Ver y añadir seguimiento" onclick="toggleModal('modalSeguimiento')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                <span class="material-symbols-outlined text-xl">timeline</span>
                            </button>
                            <button title="Actualizar estado" onclick="toggleModal('modalEstado')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                <span class="material-symbols-outlined text-xl">edit_document</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-primary dark:text-blue-400">RAD-2026-00121</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium dark:text-white">Ministerio de Trabajo</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">NIT: 830.123.456-0</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-[200px] truncate dark:text-white" title="Circular informativa regulaciones 2026">Circular informativa regulaciones 2026</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="dark:text-white">04 Mar 2026</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">09:00 AM</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                Recibido
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button title="Ver y añadir seguimiento" onclick="toggleModal('modalSeguimiento')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                <span class="material-symbols-outlined text-xl">timeline</span>
                            </button>
                            <button title="Actualizar estado" onclick="toggleModal('modalEstado')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                <span class="material-symbols-outlined text-xl">edit_document</span>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
            <div>Mostrando 1 a 3 de 124 correpondencias</div>
            <div class="flex gap-1">
                <button class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-slate-700 disabled:opacity-50" disabled>Anterior</button>
                <button class="px-3 py-1 bg-primary text-white rounded hover:bg-blue-700">1</button>
                <button class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-slate-700">2</button>
                <button class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-slate-700">Siguiente</button>
            </div>
        </div>

    </div>

</div>
@endsection

@section('modals')
<!-- Modal Seguimiento y Timeline -->
<div id="modalSeguimiento" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-lg dark:text-white">Seguimiento Radicado #RAD-2026-00123</h3>
            <button onclick="toggleModal('modalSeguimiento')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1">
            <div class="relative border-l-2 border-gray-200 dark:border-gray-700 ml-3 space-y-8">
                <!-- Timeline Item 1 -->
                <div class="relative pl-6">
                    <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-blue-500 border-2 border-white dark:border-slate-900"></div>
                    <div class="text-xs text-gray-400 mb-1">Hoy, 10:45 AM</div>
                    <div class="font-semibold text-sm dark:text-white">Pasado a revisión jurídica</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        El documento fue trasladado al área jurídica para su análisis y concepto.
                    </div>
                    <div class="text-xs font-medium text-gray-400 mt-2">Por: Carlos Empleado</div>
                </div>

                <!-- Timeline Item 2 -->
                <div class="relative pl-6">
                    <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-yellow-500 border-2 border-white dark:border-slate-900"></div>
                    <div class="text-xs text-gray-400 mb-1">05 Mar 2026, 09:15 AM</div>
                    <div class="font-semibold text-sm dark:text-white">En Trámite - Asignado</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Radicado asignado al departamento de planeación.
                    </div>
                    <div class="text-xs font-medium text-gray-400 mt-2">Por: Sistema</div>
                </div>

                <!-- Timeline Item 3 -->
                <div class="relative pl-6">
                    <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-gray-400 border-2 border-white dark:border-slate-900"></div>
                    <div class="text-xs text-gray-400 mb-1">05 Mar 2026, 08:30 AM</div>
                    <div class="font-semibold text-sm dark:text-white">Documento Recibido</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Ingreso del documento en recepción, radicación exitosa.
                    </div>
                    <div class="text-xs font-medium text-gray-400 mt-2">Por: María Recepcionista</div>
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800/50 flex justify-end">
            <button onclick="toggleModal('modalSeguimiento')" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                Cerrar
            </button>
        </div>
    </div>
</div>

<!-- Modal Actualizar Estado -->
<div id="modalEstado" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl w-full max-w-md overflow-hidden flex flex-col">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-bold text-lg dark:text-white">Actualizar Radicado #RAD-2026-00123</h3>
            <button onclick="toggleModal('modalEstado')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nuevo Estado</label>
                <select class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-slate-800 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50">
                    <option value="">Seleccione...</option>
                    <option value="tramite">En Trámite</option>
                    <option value="juridica">Revisión Jurídica</option>
                    <option value="finalizado">Finalizado / Contestado</option>
                    <option value="rechazado">Rechazado</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Comentario al Seguimiento</label>
                <textarea rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-slate-800 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50" placeholder="Escriba los detalles de este cambio de estado..."></textarea>
            </div>
        </div>

        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
            <button onclick="toggleModal('modalEstado')" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                Cancelar
            </button>
            <button onclick="toggleModal('modalEstado')" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-blue-700">
                Guardar Actualización
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>
@endsection

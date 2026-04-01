@extends('remitente.layouts.app')

@section('title', 'Recibidos en Proceso - Remitente')

@section('content')
    <div class="flex flex-col p-6 min-w-0 gap-8">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Recibidos en Proceso
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Correspondencia recibida y registrada por ti, pendiente
                        de respuesta.</p>
                </div>
                <div class="flex flex-col sm:flex-row w-full md:w-auto gap-4">
                    <button type="button" onclick="openModal('modalCorrespondencia')"
                        class="flex items-center justify-center gap-3 px-6 py-3 text-sm font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all active:scale-95 w-full sm:w-auto shadow-md">
                        <span class="material-symbols-outlined text-[24px]">move_to_inbox</span>
                        Registrar Recibido
                    </button>
                </div>
            </div>


            <!-- Correspondence Table Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-12 block w-full">
                <!-- Header with Filters -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 block w-full">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 w-full">
                        <div class="w-full">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Correspondencia Recibida</h2>
                            <p class="text-sm text-gray-500 mt-1">Gestione sus registros y consulte sus estados actuales.</p>
                        </div>
                        <form method="GET" action="{{ route('remitente.recibidos') }}"
                            class="flex flex-col sm:flex-row w-full lg:w-auto gap-4">


                        {{-- Filtro Fecha --}}
                        <div class="relative w-full sm:w-56 flex items-center gap-2">
                            <input type="date" name="fecha" value="{{ request('fecha') }}" onchange="this.form.submit()"
                                max="{{ date('Y-m-d') }}"
                                class="block w-full h-11 px-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-2 focus:ring-primary focus:border-primary dark:text-white appearance-none cursor-pointer flex-1">
                            @if (request('fecha'))
                                <a href="{{ request()->fullUrlWithQuery(['fecha' => null]) }}"
                                    class="p-2 bg-red-50 dark:bg-red-400/10 text-red-500 hover:bg-red-100 dark:hover:bg-red-400/20 rounded-xl transition-all"
                                    title="Limpiar filtro de fecha">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </a>
                            @endif
                        </div>
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="material-symbols-outlined text-gray-400 text-sm">search</span>
                            </span>
                            <input type="text" id="tableSearch"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary dark:text-white"
                                placeholder="Filtrar por asunto, radicado...">
                        </div>
                    </form>
                </div>
                <div class="table-container-remitente overflow-x-auto w-full custom-scrollbar min-w-0" style="min-height: 400px; padding-bottom: 2rem;">
                    <table class="w-full text-left text-sm responsive-table min-w-[1200px]">
                        <thead class="text-[10px] text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400 tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-black">Radicados</th>
                                <th class="px-6 py-4 font-black">Procedencia / Remitente</th>
                                <th class="px-6 py-4 font-black">Asunto / Tipo Dossier</th>
                                <th class="px-6 py-4 font-black">Asignación ACTUAL</th>
                                <th class="px-6 py-4 font-black text-center">Fecha Registro</th>
                                <th class="px-6 py-4 font-black text-center">Estado</th>
                                <th class="px-6 py-4 font-black text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="correspondenceTableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recibidos as $c)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top group">

                                    <td class="px-6 py-4 whitespace-nowrap align-middle" data-label="Radicados">
                                        <div class="flex flex-col gap-1.5 items-start">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 text-[11px] font-black border border-[#cfd7e7] dark:border-slate-700 shadow-sm">
                                                <span class="material-symbols-outlined text-[15px] font-variation-icon">tag</span>
                                                {{ $c->radicado ? $c->radicado->num_radicado : 'SIN RADICADO' }}
                                            </span>
                                            @if ($c->num_radicado_ext)
                                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md bg-indigo-50 dark:bg-indigo-900/20 text-indigo-500 dark:text-indigo-400 text-[9px] font-black uppercase border border-indigo-100/50 dark:border-indigo-800/50">
                                                    EXT: {{ $c->num_radicado_ext }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4" data-label="Procedencia">
                                        <div class="font-medium dark:text-white max-w-[180px] break-words whitespace-normal">
                                            {{ $c->nom_institucion ?: ($c->nombre_persona ?? 'Particular') }}
                                        </div>
                                        <span class="inline-flex items-center gap-0.5 text-xs {{ $c->nom_institucion ? 'text-blue-500' : 'text-purple-500' }} mt-0.5">
                                            <span class="material-symbols-outlined" style="font-size:13px">{{ $c->nom_institucion ? 'business' : 'person' }}</span>
                                            {{ $c->nom_institucion ? 'Entidad / Empresa' : 'Persona Natural' }}
                                        </span>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                            <span class="material-symbols-outlined text-[14px]">location_on</span>
                                            {{ $c->ciudad ? $c->ciudad->ciudad_nom : 'Desconocida' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm" data-label="Asunto">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 mb-1 max-w-[200px] whitespace-normal break-words">{{ $c->asunto }}</div>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <div class="flex items-center gap-0.5 text-[10px] text-gray-500 font-bold uppercase">
                                                <span class="material-symbols-outlined text-[14px]">layers</span>
                                                F: {{ $c->folio ?? 0 }}
                                            </div>
                                            @if ($c->id_tipo_rec)
                                                <div class="flex items-center gap-0.5 text-[10px] text-orange-600 font-bold uppercase">
                                                    {{ $c->tipo ? $c->tipo->tipo_nombre : 'TIPO' }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4" data-label="Destinatarios">
                                        <div class="flex flex-wrap gap-2 max-w-[200px]">
                                            @php
                                                $ultimosPorEmpleado = $c->detalles->sortByDesc('id_det_recibido')->unique('det_doc_empleado');
                                                $hayResuelto = $ultimosPorEmpleado->contains(fn($d) => in_array($d->id_estado_rec, [9, 10, 14]));
                                                $filteredDetalles = $hayResuelto
                                                    ? $ultimosPorEmpleado->filter(fn($d) => in_array($d->id_estado_rec, [9, 10, 14]))
                                                    : $ultimosPorEmpleado->filter(fn($d) => $d->id_estado_rec != 9);
                                            @endphp
                                            @forelse($filteredDetalles as $det)
                                                <div class="flex items-center gap-2 group/user" title="{{ $det->empleado->emple_nombres ?? 'Usuario' }}">
                                                    <div class="w-8 h-8 rounded-full {{ $det->empleado && $det->empleado->emple_img ? '' : 'bg-blue-600' }} flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-700 flex-shrink-0 shadow-sm">
                                                        @if ($det->empleado && $det->empleado->emple_img)
                                                            <img src="{{ asset('storage/' . $det->empleado->emple_img) }}" class="w-full h-full object-cover">
                                                        @else
                                                            <span class="text-[10px] font-bold text-white">
                                                                {{ strtoupper(substr($det->empleado->emple_nombres ?? 'U', 0, 1)) }}{{ strtoupper(substr($det->empleado->emple_apellidos ?? 'A', 0, 1)) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex flex-col min-w-0">
                                                        <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300 leading-tight truncate">
                                                            {{ $det->empleado->emple_nombres ?? 'Usuario' }}
                                                        </span>
                                                        @php
                                                            $detStatusClass = match ($det->id_estado_rec) {
                                                                7 => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                                                11 => 'bg-red-50 text-red-600 border-red-100',
                                                                8 => 'bg-amber-50 text-amber-600 border-amber-100',
                                                                9, 10, 14 => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                                default => 'bg-gray-50 text-gray-500 border-gray-100',
                                                            };
                                                        @endphp
                                                        <span class="px-1 px-1 py-0.5 rounded text-[8px] font-black uppercase border {{ $detStatusClass }} mt-1">
                                                            {{ $det->estado->estado_nomb ?? 'Pendiente' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @empty
                                                <span class="text-gray-400 text-xs italic">Sin asignar</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Registro">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $c->fecha_hora_recib ? \Carbon\Carbon::parse($c->fecha_hora_recib)->format('d M Y') : 'N/A' }}
                                        </div>
                                        <div class="text-[10px] text-gray-500">{{ $c->fecha_hora_recib ? \Carbon\Carbon::parse($c->fecha_hora_recib)->format('h:i A') : '' }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-center" data-label="Estado">
                                        @php
                                            $lowDesc = strtolower($c->estado ? $c->estado->estado_nomb : '');
                                            $idEst = $c->id_estado_rec;
                                            $clases = 'bg-gray-100 text-gray-600 border-gray-200';
                                            
                                            if (str_contains($lowDesc, 'resuelto') || $idEst == 9 || in_array($idEst, [10, 14])) {
                                                $clases = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                            } elseif (str_contains($lowDesc, 'enviado') || $idEst == 12) {
                                                $clases = 'bg-blue-50 text-blue-600 border-blue-200';
                                            } elseif (str_contains($lowDesc, 'recibido') || $idEst == 7) {
                                                $clases = 'bg-indigo-50 text-indigo-600 border-indigo-200';
                                            } elseif (str_contains($lowDesc, 'pendiente') || in_array($idEst, [8, 13])) {
                                                $clases = 'bg-amber-50 text-amber-600 border-amber-200';
                                            } elseif (str_contains($lowDesc, 'rechazado') || $idEst == 11) {
                                                $clases = 'bg-red-50 text-red-600 border-red-200';
                                            }
                                        @endphp
                                        <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase border {{ $clases }}">
                                            {{ $c->estado ? $c->estado->estado_nomb : 'PENDIENTE' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-center align-middle">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="viewDetails({{ $c->id_recibido }})"
                                                class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                                title="Ver Gestión y Documentos">
                                                <span
                                                    class="material-symbols-outlined text-[20px] font-variation-icon">visibility</span>
                                            </button>
                                            <a href="{{ url('/remitente/historial') }}?q={{ $c->radicado ? $c->radicado->num_radicado : '' }}"
                                                class="p-1.5 text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-gray-700/50 rounded-lg transition-colors"
                                                title="Ver en Historial General">
                                                <span
                                                    class="material-symbols-outlined text-[20px] font-variation-icon">history_edu</span>
                                            </a>
                                            <button onclick="showHistory({{ $c->num_radicado_int }}, '{{ $c->radicado ? $c->radicado->num_radicado : ($c->num_radicado_ext ?: 'EN PROCESO') }}', 'EXT')"
                                                class="p-1.5 text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-gray-700/50 rounded-lg transition-colors"
                                                title="Trazabilidad Rápida">
                                                <span
                                                    class="material-symbols-outlined text-[20px] font-variation-icon">timeline</span>
                                            </button>
                                            @if ($c->id_estado_rec == 11)
                                                <button onclick="openEditModalById({{ $c->id_recibido }})"
                                                    class="p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                    title="Corregir">
                                                    <span class="material-symbols-outlined text-[20px]">edit_note</span>
                                                </button>
                                                <button onclick="confirmFinalize({{ $c->id_recibido }})"
                                                    class="p-1.5 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors"
                                                    title="Finalizar">
                                                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                                </button>
                                                {{-- Botones de Asignar y Rechazar eliminados por solicitud del usuario --}}
                                            @else
                                            
                                                {{-- No Registrar Saliente here anymore --}}
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-14 h-14 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center">
                                                <span
                                                    class="material-symbols-outlined text-gray-400 text-3xl font-variation-icon">inventory_2</span>
                                            </div>
                                            <p class="text-gray-500 text-sm font-medium">No se encontraron registros de
                                                correspondencia.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $recibidos->appends(request()->query())->links() }}
                </div>
            </div>
    </div>

    <!-- View Details Modal -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen w-full p-4 relative">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                onclick="closeModal('detailsModal')"></div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden transform transition-all my-auto">
                <div class="absolute top-4 right-4 z-10">
                    <button onclick="closeModal('detailsModal')"
                        class="p-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full transition-colors text-gray-500 dark:text-gray-400">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row h-full">
                    <!-- Detail Header Area -->
                    <div
                        class="w-full md:w-1/3 bg-gray-50 dark:bg-gray-900/50 p-8 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col items-center text-center">
                            <div class="p-4 bg-primary/10 rounded-2xl text-primary mb-4">
                                <span class="material-symbols-outlined text-4xl">description</span>
                            </div>
                            <h3 id="detailRadicado" class="text-xl font-bold text-gray-900 dark:text-white mb-1"></h3>
                            <span id="detailStatus" class="px-3 py-1 rounded-full text-[10px] font-bold mb-6"></span>

                            <div class="w-full space-y-4 text-left">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fecha Registro
                                    </p>
                                    <p id="detailDate" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tipo Documento
                                    </p>
                                    <p id="detailType" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Folios</p>
                                    <p id="detailFolios" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Content Area -->
                    <div class="flex-1 p-8 space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Asunto</h4>
                            <p id="detailAsunto" class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                            </p>
                        </div>

                        <div id="detailInstitutionRow">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Institución / Ciudad
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span id="detailInstitution" class="font-bold text-gray-700 dark:text-gray-300"></span>
                                <span class="mx-2">•</span>
                                <span id="detailCity"></span>
                            </p>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Observaciones</h4>
                            <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl text-sm text-gray-600 dark:text-gray-400 italic"
                                id="detailObservations"></div>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Destinatarios
                                Asignados</h4>
                            <div id="detailRecipients" class="flex flex-wrap gap-2"></div>
                        </div>

                        <div id="detailActionsContainer" class="pt-4 flex gap-3">
                            <a id="detailDownload" href="#" target="_blank"
                                class="flex-1 flex items-center justify-center gap-2 px-5 py-3 text-sm font-bold text-primary bg-primary/10 rounded-xl hover:bg-primary/20 transition-all">
                                <span class="material-symbols-outlined text-[20px]">download</span>
                                Ver Documento
                            </a>
                            <button id="detailActionBtn"
                                class="flex-1 flex items-center justify-center gap-2 px-5 py-3 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/95 transition-all shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                Editar Solicitud
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen w-full p-4 relative">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                onclick="closeModal('historyModal')"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden transform transition-all my-auto">
                <div
                    class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Trazabilidad de Documento</h3>
                        <p class="text-xs text-gray-500 mt-0.5" id="historyRadText"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a id="btnDownloadTrazabilidad" href="#" target="_blank"
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-blue-200 dark:shadow-none">
                            <span class="material-symbols-outlined text-[16px]">download</span>
                            Descargar
                        </a>
                        <button onclick="closeModal('historyModal')"
                            class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                </div>
                <div class="p-8 max-h-[70vh] overflow-y-auto bg-white dark:bg-gray-800">
                    <div id="historyTimeline" class="relative">
                        <!-- History items will be injected here -->
                    </div>
                </div>
                <div
                    class="px-8 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20 flex justify-end">
                    <button onclick="closeModal('historyModal')"
                        class="px-6 py-2 text-sm font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (for rejected) -->
    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen w-full p-4 relative">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('editModal')">
            </div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all my-auto">
                <form id="editForm" method="POST" class="flex flex-col flex-1 min-h-0">
                    @csrf
                    <div
                        class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20 shrink-0">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Corregir Correspondencia</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Ajusta los datos y genera un nuevo radicado de envío.
                            </p>
                        </div>
                        <button type="button" onclick="closeModal('editModal')"
                            class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto form-body-scroll p-8 space-y-6">
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Asunto</label>
                            <input type="text" name="asunto" id="editAsunto"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white font-medium transition-all"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Observaciones
                                de Corrección</label>
                            <textarea name="observaciones" id="editObs" rows="3"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white text-sm transition-all"
                                placeholder="Explica brevemente los cambios realizados..."></textarea>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <label
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Destinatarios</label>
                                <div class="relative w-48">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                        <span class="material-symbols-outlined text-gray-400 text-xs">search</span>
                                    </span>
                                    <input type="text" id="recipientSearch"
                                        class="block w-full pl-7 pr-2 py-1.5 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-[10px] focus:ring-primary focus:border-primary dark:text-white"
                                        placeholder="Documento, nombre o área...">
                                </div>
                            </div>
                            <div
                                class="bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden">
                                <div id="recipientList" class="max-h-56 overflow-y-auto p-2 space-y-1">
                                    @php
                                        $empleados = \App\Models\Empleado::with('area')
                                            ->where('emple_rol', '=', 3)
                                            ->orderBy('emple_nombres')
                                            ->get();
                                    @endphp
                                    @foreach ($empleados as $e)
                                        <label
                                            class="recipient-item flex items-center gap-3 p-2 rounded-lg hover:bg-white dark:hover:bg-gray-700 cursor-pointer transition-all border border-transparent hover:border-gray-100 dark:hover:border-gray-600"
                                            data-name="{{ strtolower($e->emple_nombres . ' ' . $e->emple_apellidos) }}"
                                            data-doc="{{ $e->emple_doc }}"
                                            data-area="{{ strtolower($e->area ? $e->area->area_nom : 'sin área') }}">
                                            <input type="checkbox" name="destinatarios[]" value="{{ $e->emple_doc }}"
                                                class="recipient-checkbox w-4 h-4 text-primary bg-white border-gray-300 rounded focus:ring-primary dark:bg-gray-600 dark:border-gray-500">

                                            <div class="flex items-center gap-3 flex-1">
                                                @if ($e->emple_img)
                                                    <img src="{{ asset('storage/' . $e->emple_img) }}"
                                                        class="w-8 h-8 rounded-full object-cover">
                                                @else
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-sm border border-blue-700">
                                                        {{ strtoupper(substr($e->emple_nombres, 0, 1)) }}{{ strtoupper(substr($e->emple_apellidos, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $e->emple_nombres }}
                                                        {{ $e->emple_apellidos }}</span>
                                                    <span
                                                        class="text-[10px] text-gray-400 capitalize">{{ $e->area ? $e->area->area_nom : 'Sin área' }}
                                                        • {{ $e->emple_doc }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">info</span>
                                Esta acción generará un nuevo número de radicado y archivará la solicitud anterior.
                            </p>
                        </div>
                    </div>
                    <div
                        class="px-8 py-6 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50/50 dark:bg-gray-900/20 shrink-0">
                        <button type="button" onclick="closeModal('editModal')"
                            class="px-6 py-2.5 text-sm text-gray-600 dark:text-gray-400 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cancelar</button>
                        <button type="submit"
                            class="px-8 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/95 transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            Generar Nuevo Envío
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Global data store to avoid quote/escaping issues in onclick handlers
        window.correspondenceData = @json($recibidos->keyBy('id_recibido'));

        // Modal general logic
        function openModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const inner = modal.querySelector('.relative');
                if(inner) {
                    inner.classList.remove('scale-95', 'opacity-0', 'translate-y-4');
                    inner.classList.add('scale-100', 'opacity-100', 'translate-y-0');
                }
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;

            const inner = modal.querySelector('.relative');
            if(inner) {
                inner.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
                inner.classList.add('scale-95', 'opacity-0', 'translate-y-4');
            }
            modal.classList.add('opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }, 300);
        }

        // Registrar Saliente Modal Logic
        function openSalienteModal(id) {
            const c = window.correspondenceData[id];
            if (!c) return;

            // Set Form action
            document.getElementById('salienteForm').action = `/ventanilla/${id}/store-saliente`;

            // Pre-fill data
            document.getElementById('salienteDestino').value = c.nom_institucion || c.nombre_persona || '';
            document.getElementById('salienteAsunto').value = 'R: ' + c.asunto;
            document.getElementById('salienteFolio').value = c.folio || 0;

            // Set Notification Email
            const emailInput = document.getElementById('salienteEmailNotif');
            const emailContainer = document.getElementById('emailNotifContainer');
            if (c.correo_persona) {
                emailInput.value = c.correo_persona;
                emailContainer.classList.remove('hidden');
            } else {
                emailInput.value = '';
                emailContainer.classList.add('hidden');
            }

            // Preview documents
            const preview = document.getElementById('salienteFilePreview');
            preview.innerHTML = '';
            
            if (c.archivo) {
                const fileName = c.archivo.split('/').pop();
                preview.innerHTML += `
                    <div class="flex items-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl">
                        <span class="material-symbols-outlined text-emerald-600">description</span>
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-emerald-900 dark:text-emerald-400 uppercase tracking-widest">Documento Principal</p>
                            <p class="text-xs text-emerald-700/60 dark:text-emerald-500/60 truncate font-mono">${fileName}</p>
                        </div>
                    </div>
                `;
            }

            openModal('salienteModal');
        }

        document.addEventListener("DOMContentLoaded", function() {
            if (new URLSearchParams(window.location.search).get('abrir') === 'nuevo') {
                openModal('modalCorrespondencia');
            }
        });

        // Helper for initials/avatar
        function getAvatarHtml(dest) {
            if (dest.emple_img) {
                return `<img src="/storage/${dest.emple_img}" class="w-6 h-6 rounded-full object-cover border border-white dark:border-gray-700">`;
            }
            const initials = ((dest.emple_nombres ? dest.emple_nombres[0] : 'U') + (dest.emple_apellidos ? dest
                .emple_apellidos[0] : 'A')).toUpperCase();
            return `<div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold border border-blue-700 shadow-sm">${initials}</div>`;
        }

        // View Details Logic
        function viewDetails(id) {
            const c = window.correspondenceData[id];
            if (!c) return;

            document.getElementById('detailRadicado').textContent = c.radicado ? c.radicado.num_radicado : 'SIN RADICADO';
            document.getElementById('detailAsunto').textContent = c.asunto;
            document.getElementById('detailDate').textContent = new Date(c.fecha_hora_recib).toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('detailType').textContent = c.tipo ? c.tipo.tipo_nombre : 'No especificado';
            document.getElementById('detailFolios').textContent = c.folio || '0';
            document.getElementById('detailObservations').textContent = c.observaciones || 'Sin observaciones.';
            document.getElementById('detailInstitution').textContent = c.nom_institucion || 'Particular';
            document.getElementById('detailCity').textContent = c.ciudad ? c.ciudad.ciudad_nomb : 'No disponible';

            // Status pill
            const statusSpan = document.getElementById('detailStatus');
            statusSpan.textContent = c.estado ? c.estado.estado_nomb : 'Desconocido';
            statusSpan.className = 'px-3 py-1 rounded-full text-[10px] font-bold mb-6 ';
            if (c.id_estado_rec == 11) {
                statusSpan.classList.add('bg-red-100', 'text-red-700', 'dark:bg-red-900/50', 'dark:text-red-400');
            } else if (c.id_estado_rec == 9 || c.id_estado_rec == 10) {
                statusSpan.classList.add('bg-green-100', 'text-green-700', 'dark:bg-green-900/50', 'dark:text-green-400');
            } else {
                statusSpan.classList.add('bg-blue-100', 'text-blue-700', 'dark:bg-blue-900/50', 'dark:text-blue-400');
            }

            // Recipients refined with avatars
            const recipientsContainer = document.getElementById('detailRecipients');
            recipientsContainer.innerHTML = '';
            if (c.destinatarios && c.destinatarios.length > 0) {
                // Sorting and filtering in Details Modal to show latest active status
                const activeRecipients = c.destinatarios.filter(dest => {
                    const allDets = c.detalles ? c.detalles.filter(d => d.det_doc_empleado == dest.emple_doc) : [];
                    if (allDets.length === 0) return true;

                    // Get latest detail for this employee
                    const latestDet = allDets.sort((a, b) => b.id_det_recibido - a.id_det_recibido)[0];

                    // Filter out finished historical statuses (9)
                    // We keep status 10 (Archivado) visible because it's assigned to other 
                    // recipients when someone "takes" the document.
                    return parseInt(latestDet.id_estado_rec) !== 9;
                });

                if (activeRecipients.length > 0) {
                    activeRecipients.forEach(dest => {
                        const avatar = getAvatarHtml(dest);
                        const div = document.createElement('div');
                        div.className =
                            'inline-flex items-center gap-2 px-2 py-1 rounded-lg text-[10px] font-bold bg-gray-50 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-100 dark:border-gray-600';

                        const allDets = c.detalles ? c.detalles.filter(d => d.det_doc_empleado == dest.emple_doc) :
                            [];
                        const det = allDets.sort((a, b) => b.id_det_recibido - a.id_det_recibido)[0];

                        let statusHtml = '';
                        if (det) {
                            const statusName = det.estado ? det.estado.estado_nomb : (det.id_estado_rec == 7 ?
                                'Recibido' : (det.id_estado_rec == 11 ? 'Rechazado' : 'Pendiente'));
                            let colorClass = 'text-gray-500';
                            if (det.id_estado_rec == 7) colorClass = 'text-green-600 dark:text-green-400';
                            else if (det.id_estado_rec == 11) colorClass = 'text-red-600 dark:text-red-400';
                            else if (det.id_estado_rec == 8) colorClass = 'text-amber-600 dark:text-amber-400';
                            else if ([9, 10, 14].includes(parseInt(det.id_estado_rec))) colorClass =
                                'text-emerald-600 dark:text-emerald-400';

                            statusHtml =
                                `<span class="text-[8px] font-medium ${colorClass} mt-0.5">${statusName}</span>`;
                        }
                        div.innerHTML =
                            `${avatar} <div class="flex flex-col"><span class="leading-none">${dest.emple_nombres} ${dest.emple_apellidos}</span>${statusHtml}</div>`;
                        recipientsContainer.appendChild(div);
                    });
                } else {
                    recipientsContainer.innerHTML =
                        '<p class="text-gray-400 text-xs italic">Sin destinatarios activos.</p>';
                }
            } else {
                recipientsContainer.innerHTML =
                    '<p class="text-gray-400 text-xs italic">No hay destinatarios asignados.</p>';
            }

            // Attachments List Logic - Refactored to show Sent and Received docs
            const actionArea = document.getElementById('detailActionsContainer');
            actionArea.innerHTML = ''; // Clear action area

            const docsWrapper = document.createElement('div');
            docsWrapper.className = 'w-full space-y-6';
            actionArea.appendChild(docsWrapper);

            // SECTION 1: DOCUMENTOS ENVIADOS (ORIGINAL)
            const sentSection = document.createElement('div');
            sentSection.innerHTML =
                '<h5 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 px-1">Documentos Enviados</h5>';
            const sentGrid = document.createElement('div');
            sentGrid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-2';
            sentSection.appendChild(sentGrid);
            docsWrapper.appendChild(sentSection);

            // Principal
            if (c.archivo) {
                const btn = document.createElement('a');
                btn.href = `/storage/${c.archivo}`;
                btn.target = '_blank';
                btn.className =
                    'flex items-center gap-2 px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 rounded-xl hover:bg-blue-100 transition-all border border-blue-100 dark:border-blue-800';
                btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">description</span> Principal';
                sentGrid.appendChild(btn);
            }

            // Annexes
            if (c.anexos && c.anexos.length > 0) {
                c.anexos.forEach((anexo, idx) => {
                    const btn = document.createElement('a');
                    btn.href = `/storage/${anexo.ruta_archivo}`;
                    btn.target = '_blank';
                    btn.className =
                        'flex items-center gap-2 px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-gray-600 bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400 rounded-xl hover:bg-gray-100 transition-all border border-gray-100 dark:border-gray-600';
                    btn.title = anexo.nombre_original;
                    btn.innerHTML =
                        `<span class="material-symbols-outlined text-[18px]">attach_file</span> Anexo ${idx + 1}`;
                    sentGrid.appendChild(btn);
                });
            }

            // SECTION 2: RESPUESTAS RECIBIDAS
            const hasResponses = c.detalles && c.detalles.some(d => d.archivo_res || (d.anexos_respuesta && d
                .anexos_respuesta.length > 0));

            if (hasResponses) {
                const respSection = document.createElement('div');
                respSection.className = 'pt-2 border-t border-gray-100 dark:border-gray-700';
                respSection.innerHTML =
                    '<h5 class="text-[10px] font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400 mb-2 px-1">Respuestas y Evidencias</h5>';
                const respGrid = document.createElement('div');
                respGrid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-2';
                respSection.appendChild(respGrid);
                docsWrapper.appendChild(respSection);

                c.detalles.forEach(d => {
                    // Response Main Document
                    if (d.archivo_res) {
                        const btn = document.createElement('a');
                        btn.href = `/storage/${d.archivo_res}`;
                        btn.target = '_blank';
                        btn.className =
                            'flex items-center gap-2 px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400 rounded-xl hover:bg-emerald-100 transition-all border border-emerald-100 dark:border-emerald-800';
                        const empName = d.empleado ? d.empleado.emple_nombres.split(' ')[0] : 'Funcionario';
                        btn.innerHTML =
                            `<span class="material-symbols-outlined text-[18px]">task</span> Respuesta (${empName})`;
                        respGrid.appendChild(btn);
                    }

                    // Response Annexes
                    if (d.anexos_respuesta && d.anexos_respuesta.length > 0) {
                        d.anexos_respuesta.forEach((anexo, idx) => {
                            const btn = document.createElement('a');
                            btn.href = `/storage/${anexo.ruta_archivo}`;
                            btn.target = '_blank';
                            btn.className =
                                'flex items-center gap-2 px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-teal-600 bg-teal-50 dark:bg-teal-900/20 dark:text-teal-400 rounded-xl hover:bg-teal-100 transition-all border border-teal-100 dark:border-teal-800';
                            btn.innerHTML =
                                `<span class="material-symbols-outlined text-[18px]">attachment</span> Evidencia ${idx + 1}`;
                            respGrid.appendChild(btn);
                        });
                    }
                });
            }

            // SECTION 3: ACTIONS (Correction if rejected)
            if (c.id_estado_rec == 11) {
                const editDiv = document.createElement('div');
                editDiv.className = 'pt-4';
                const editBtn = document.createElement('button');
                editBtn.className =
                    'w-full flex items-center justify-center gap-2 px-5 py-3 text-xs font-black uppercase tracking-widest text-white bg-red-500 rounded-2xl hover:bg-red-600 transition-all shadow-lg shadow-red-200 dark:shadow-red-900/30 active:scale-[0.98]';
                editBtn.innerHTML =
                    '<span class="material-symbols-outlined">edit_note</span> Corregir Correspondencia ahora';
                editBtn.onclick = () => {
                    closeModal('detailsModal');
                    openEditModalById(id);
                };
                editDiv.appendChild(editBtn);
                docsWrapper.appendChild(editDiv);
            }

            openModal('detailsModal');
        }

        // Rechazar Correspondencia Logic
        function openRejectModal(id, radicadoText) {
            document.getElementById('rejectRadText').textContent = `Radicado: ${radicadoText || 'EN PROCESO'}`;
            document.getElementById('rejectForm').action = `/ventanilla/externarec/${id}/rechazar`;
            document.getElementById('rejectObs').value = '';
            openModal('rejectModal');
        }

        // History Timeline Logic
        function showHistory(id, radTextStr, tipoCor) {
            const historyTimeline = document.getElementById('historyTimeline');
            const btnDownload = document.getElementById('btnDownloadTrazabilidad');
            
            // Set download URL
            if (btnDownload && radTextStr) {
                const isEnvioLink = tipoCor === 'SAL' || tipoCor === 'INT';
                btnDownload.href = `{{ url('/ventanilla/trazabilidad') }}/${id}/pdf?tipo=${isEnvioLink ? 'envio' : 'recibido'}`;
            }

            historyTimeline.innerHTML =
                '<div class="flex justify-center p-12"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div></div>';
            openModal('historyModal');

            fetch(`{{ url('/ventanilla/history') }}/${id}?type=${tipoCor}`)
                .then(response => response.json())
                .then(data => {
                    historyTimeline.innerHTML = '';

                    if (!data || data.length === 0) {
                        historyTimeline.innerHTML =
                            '<div class="flex flex-col items-center py-12 text-gray-400"><span class="material-symbols-outlined text-4xl mb-2">history</span><p class="text-sm italic">No hay historial disponible.</p></div>';
                        return;
                    }

                    // Update header radicado info
                    const firstRecord = data.find(r => r.num_radicado);
                    document.getElementById('historyRadText').textContent = firstRecord ?
                        `Radicado: ${firstRecord.num_radicado}` : 'Historial de movimientos';

                    data.forEach((item, index) => {
                        const isLast = index === data.length - 1;
                        const dateObj = new Date(item.fecha);
                        const dateStr = dateObj.toLocaleDateString('es-ES', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        const timeStr = dateObj.toLocaleTimeString('es-ES', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });

                        // Icon and color mapping
                        let icon = 'info';
                        let colorClass = 'bg-blue-500';
                        let circleClass = 'bg-blue-100 text-blue-600';

                        if (item.type === 'registry') {
                            icon = 'outgoing_mail';
                            colorClass = 'bg-primary';
                            circleClass = 'bg-primary/10 text-primary';
                        } else {
                            const statusId = parseInt(item.id_estado_rec);
                            switch (statusId) {
                                case 7: // Recibido
                                    icon = 'inbox';
                                    colorClass = 'bg-orange-500';
                                    circleClass = 'bg-orange-100 text-orange-600';
                                    break;
                                case 8: // En Tramite
                                    icon = 'pending';
                                    colorClass = 'bg-amber-500';
                                    circleClass = 'bg-amber-100 text-amber-600';
                                    break;
                                case 9: // Resuelto
                                case 10: // Archivado
                                    icon = 'check_circle';
                                    colorClass = 'bg-green-500';
                                    circleClass = 'bg-green-100 text-green-600';
                                    break;
                                case 11: // Rechazado
                                    icon = 'cancel';
                                    colorClass = 'bg-red-500';
                                    circleClass = 'bg-red-100 text-red-600';
                                    break;
                                case 12: // Enviado
                                    icon = 'send';
                                    colorClass = 'bg-blue-500';
                                    circleClass = 'bg-blue-100 text-blue-600';
                                    break;
                                case 14: // Saliente
                                    icon = 'outbox';
                                    colorClass = 'bg-emerald-500';
                                    circleClass = 'bg-emerald-100 text-emerald-600';
                                    break;
                            }
                        }

                        const avatar = getAvatarHtml({
                            emple_img: item.img,
                            emple_nombres: item.nombres,
                            emple_apellidos: item.apellidos
                        });

                        const html = `
                            <div class="flex gap-4 relative">
                                ${!isLast ? `<div class="absolute left-[19px] top-10 bottom-0 w-0.5 bg-gray-100 dark:bg-gray-700/50"></div>` : ''}
                                
                                <div class="relative z-10">
                                    <div class="w-10 h-10 rounded-full ${circleClass} flex items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[20px]">${icon}</span>
                                    </div>
                                </div>

                                <div class="flex-1 pb-10">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-1 gap-1">
                                        <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">${item.estado_nomb}</span>
                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-gray-400 bg-gray-50 dark:bg-gray-700 px-2 py-0.5 rounded-lg border border-gray-100 dark:border-gray-600">
                                            <span class="material-symbols-outlined text-[12px]">schedule</span>
                                            ${dateStr} • ${timeStr}
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 mb-3 mt-2 p-2 bg-gray-50/50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700/50 w-fit">
                                        ${avatar}
                                        <div class="flex flex-col pr-4">
                                            <p class="text-[11px] text-gray-800 dark:text-gray-200 font-bold leading-none">${item.nombres} ${item.apellidos}</p>
                                            <span class="text-[9px] text-gray-400 font-medium">Actor Responsable</span>
                                        </div>
                                    </div>

                                    ${item.observaciones ? `
                                                                                <div class="relative p-4 bg-white dark:bg-gray-800 border-l-4 border-primary/20 rounded-r-xl shadow-sm group hover:border-primary transition-colors">
                                                                                    <span class="material-symbols-outlined absolute -right-2 -top-2 text-primary/5 text-4xl group-hover:scale-110 transition-transform">format_quote</span>
                                                                                    <p class="text-[12px] text-gray-600 dark:text-gray-400 italic leading-relaxed">"${item.observaciones}"</p>
                                                                                </div>
                                                                            ` : ''}

                                    ${item.archivo_res ? `
                                                                    <div class="mt-3">
                                                                        <a href="/storage/${item.archivo_res}" target="_blank" 
                                                                           class="inline-flex items-center gap-2 px-3 py-2 text-xs font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl hover:bg-emerald-100 transition-all">
                                                                            <span class="material-symbols-outlined text-[18px]">task</span>
                                                                            Ver Documento de Respuesta
                                                                        </a>
                                                                    </div>
                                                                ` : ''}

                                    ${item.anexos && item.anexos.length > 0 ? `
                                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                                        ${item.anexos.map((anexo, idx) => `
                                                <a href="/storage/${anexo.ruta_archivo}" target="_blank" 
                                                   class="inline-flex items-center gap-2 px-2.5 py-1.5 text-[10px] font-bold text-teal-600 bg-teal-50 dark:bg-teal-900/20 border border-teal-100 dark:border-teal-800 rounded-lg hover:bg-teal-100 transition-all"
                                                   title="${anexo.nombre_original}">
                                                    <span class="material-symbols-outlined text-[16px]">attachment</span>
                                                    Anexo ${idx + 1}
                                                </a>
                                            `).join('')}
                                                                    </div>
                                                                ` : ''}
                                </div>
                            </div>
                        `;
                        historyTimeline.innerHTML += html;
                    });
                })
                .catch(error => {
                    console.error('History error:', error);
                    historyTimeline.innerHTML =
                        '<div class="alert alert-danger p-4 rounded-xl text-red-500 bg-red-50 text-sm font-bold">Error al cargar el historial. Intenta de nuevo.</div>';
                });
        }

        // Edit Modal Logic with improved selection
        function openEditModalById(id) {
            const c = window.correspondenceData[id];
            if (!c) return;

            document.getElementById('editAsunto').value = c.asunto;
            document.getElementById('editObs').value = ''; // Clear notes for new corrections
            document.getElementById('editForm').action = `/ventanilla/${c.id_recibido}/update-rejected`;

            // Clear and set checkboxes
            const checkboxes = document.querySelectorAll('.recipient-checkbox');
            const currentRecipients = c.destinatarios ? c.destinatarios.map(d => String(d.emple_doc)) : [];

            checkboxes.forEach(cb => {
                cb.checked = currentRecipients.includes(String(cb.value));
            });

            openModal('editModal');
        }

        // Search recipients in Edit Modal (Multi-attribute)
        document.getElementById('recipientSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.recipient-item');

            items.forEach(item => {
                const name = item.dataset.name;
                const doc = item.dataset.doc;
                const area = item.dataset.area;

                const matches = name.includes(term) || doc.includes(term) || area.includes(term);
                item.style.display = matches ? 'flex' : 'none';
            });
        });

        // Search table logic
        document.getElementById('tableSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#correspondenceTableBody tr');

            rows.forEach(row => {
                // Skips "No se encontraron registros" row
                if (row.cells.length < 2) return;
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // SweetAlert for Finalize
        function confirmFinalize(id) {
            Swal.fire({
                title: '¿Finalizar correspondencia?',
                text: "Esta acción marcará la solicitud rechazada como archivada definitivamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#135bec',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, finalizar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    container: 'font-display',
                    popup: 'rounded-3xl border-none shadow-2xl dark:bg-gray-800 dark:text-white',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`finalize-form-${id}`).submit();
                }
            });
        }
        // Session Success Notifications (SweetAlert)
        @if (session('success'))
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#135bec',
                customClass: {
                    container: 'font-display',
                    popup: 'rounded-3xl border-none shadow-2xl dark:bg-gray-800 dark:text-white',
                    confirmButton: 'rounded-xl px-8 py-2.5 font-bold'
                }
            });
        @endif

        async function openSalienteModal(id) {
            const c = window.correspondenceData[id];
            if (!c) return;



            // Find response data
            const responseDetail = c.detalles.find(d => d.archivo_res);
            const responseAnnexes = c.detalles.flatMap(d => d.anexos_respuesta || []);

            document.getElementById('salienteForm').action = `/ventanilla/${id}/store-saliente`;
            document.getElementById('salienteAsunto').value = 'RESPUESTA: ' + c.asunto;
            document.getElementById('salienteDestino').value = c.nom_institucion || (c.nombre_persona ? c
                .nombre_persona : '');

            // Pre-fill fields
            const typeSelect = document.getElementById('salienteTipo');
            if (c.id_tipo) typeSelect.value = c.id_tipo;

            const officialSelect = document.getElementById('salienteFuncionario');
            if (responseDetail && responseDetail.det_doc_empleado) {
                officialSelect.value = responseDetail.det_doc_empleado;
            }

            // File Preview Section
            const previewContainer = document.getElementById('salienteFilePreview');
            previewContainer.innerHTML = '';

            if (responseDetail && responseDetail.archivo_res) {
                const mainFileDiv = document.createElement('div');
                mainFileDiv.className =
                    'flex items-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl mb-2 group cursor-pointer hover:bg-emerald-100 transition-all';
                mainFileDiv.onclick = () => window.open(`/storage/${responseDetail.archivo_res}`, '_blank');
                mainFileDiv.innerHTML = `
                    <span class="material-symbols-outlined text-emerald-600">description</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-bold text-emerald-900 dark:text-emerald-100 truncate">Documento Principal de Respuesta</p>
                        <p class="text-[9px] text-emerald-600 font-medium">Click para ver documento</p>
                    </div>
                    <span class="material-symbols-outlined text-emerald-400 text-sm group-hover:translate-x-0.5 transition-transform">open_in_new</span>
                `;
                previewContainer.appendChild(mainFileDiv);

                // Start page counting sum logic
                const folioInput = document.getElementById('salienteFolio');
                if (folioInput) {
                    folioInput.value = 'Calculando...';
                    folioInput.readOnly = true;

                    try {
                        let totalPages = 0;

                        // Set worker source if needed
                        if (typeof pdfjsLib !== 'undefined') {
                            pdfjsLib.GlobalWorkerOptions.workerSrc =
                                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                        }

                        // Main document
                        if (responseDetail.archivo_res) {
                            const pdfPath = `/storage/${responseDetail.archivo_res}`;
                            const loadingTask = pdfjsLib.getDocument(pdfPath);
                            const pdf = await loadingTask.promise;
                            totalPages += pdf.numPages;
                        }

                        // Annexes
                        if (responseAnnexes && responseAnnexes.length > 0) {
                            for (const anexo of responseAnnexes) {
                                if (anexo.ruta_archivo && anexo.ruta_archivo.toLowerCase().endsWith('.pdf')) {
                                    try {
                                        const loadingTaskAnexo = pdfjsLib.getDocument(`/storage/${anexo.ruta_archivo}`);
                                        const pdfAnexo = await loadingTaskAnexo.promise;
                                        totalPages += pdfAnexo.numPages;
                                    } catch (e) {
                                        console.error('Error counting annex PDF pages', e);
                                        totalPages += 1; // Fallback
                                    }
                                } else if (anexo.ruta_archivo) {
                                    totalPages += 1; // Non-PDF annexes
                                }
                            }
                        }

                        folioInput.value = totalPages > 0 ? totalPages : 1;
                    } catch (error) {
                        console.error('Error counting PDF pages:', error);
                        folioInput.value = 1; // General Fallback
                    }
                }
            }

            if (responseAnnexes.length > 0) {
                const annexGrid = document.createElement('div');
                annexGrid.className = 'grid grid-cols-1 gap-2';
                responseAnnexes.forEach((anexo, idx) => {
                    const div = document.createElement('div');
                    div.className =
                        'flex items-center gap-3 p-2.5 bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/50 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 transition-all group';
                    div.onclick = () => window.open(`/storage/${anexo.ruta_archivo}`, '_blank');
                    div.innerHTML = `
                        <span class="material-symbols-outlined text-gray-400 text-[18px]">attachment</span>
                        <p class="text-[10px] font-medium text-gray-600 dark:text-gray-300 truncate flex-1">${anexo.nombre_original || `Anexo ${idx + 1}`}</p>
                        <span class="material-symbols-outlined text-gray-300 text-sm group-hover:translate-x-0.5 transition-transform">visibility</span>
                    `;
                    annexGrid.appendChild(div);
                });
                previewContainer.appendChild(annexGrid);
            }

            // Set Notification Email
            const emailInput = document.getElementById('salienteEmailNotif');
            const emailContainer = document.getElementById('emailNotifContainer');
            if (c.correo_persona) {
                emailInput.value = c.correo_persona;
                emailContainer.classList.remove('hidden');
            } else {
                emailInput.value = '';
                emailContainer.classList.add('hidden');
            }

            openModal('salienteModal');
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (new URLSearchParams(window.location.search).get('abrir') === 'nuevo') {
                openModal('modalCorrespondencia');
            }

            // Auto-abrir el modal si hay errores de validación del intento anterior
            @if ($errors->any())
                openModal('modalCorrespondencia');
                // Scroll al tope del modal principal
                setTimeout(function() {
                    const formBody = document.querySelector('#modalCorrespondencia .form-body-scroll');
                    if (formBody) formBody.scrollTop = 0;
                }, 100);
            @endif



            // ===== ASIDE DETALLE DE REGISTRO =====
            const asideVacio = document.getElementById('asideVacio');
            const asideContenido = document.getElementById('asideContenido');

            function poblarAside(fila) {
                const d = fila.dataset;
                document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('bg-blue-50',
                    'dark:bg-blue-900/10'));
                fila.classList.add('bg-blue-50', 'dark:bg-blue-900/10');

                // Guardamos todo el dataset en sessionStorage para mantenerlo entre páginas
                const dataToSave = {
                    ...d
                };
                sessionStorage.setItem('externarec_selected', JSON.stringify(dataToSave));

                renderAsideData(dataToSave);
                cargarArchivosAside(d.id, d.archivo);
            }

            function renderAsideData(d) {
                document.getElementById('aside-asunto').textContent = d.asunto || '(Sin asunto)';
                let radTxt = '';
                if (d.radicadoInt) radTxt += 'Int: ' + d.radicadoInt;
                if (d.radicadoExt) radTxt += (radTxt ? '  ·  Ext: ' : 'Ext: ') + d.radicadoExt;
                document.getElementById('aside-radicados').textContent = radTxt;
                const esPersona = d.tipoRemitente === 'persona';
                const iconEl = document.getElementById('aside-tipo-icon');
                iconEl.textContent = esPersona ? 'person' : 'business';
                iconEl.className = 'material-symbols-outlined text-sm ' + (esPersona ? 'text-purple-500' :
                    'text-blue-500');
                document.getElementById('aside-remitente').textContent = d.remitente || '—';
                const docEl = document.getElementById('aside-documento');
                if (d.documento) {
                    docEl.textContent = (esPersona ? 'CC: ' : 'NIT: ') + d.documento;
                    docEl.classList.remove('hidden');
                } else {
                    docEl.classList.add('hidden');
                }
                const correoEl = document.getElementById('aside-correo');
                if (d.correo) {
                    correoEl.textContent = d.correo;
                    correoEl.classList.remove('hidden');
                } else {
                    correoEl.classList.add('hidden');
                }
                const telEl = document.getElementById('aside-telefono');
                if (d.telefono) {
                    telEl.textContent = '📞 ' + d.telefono;
                    telEl.classList.remove('hidden');
                } else {
                    telEl.classList.add('hidden');
                }
                document.getElementById('aside-fecha').textContent = d.fecha || '—';
                const tipoDocWrap = document.getElementById('aside-tipo-doc-wrap');
                if (d.tipoDoc) {
                    document.getElementById('aside-tipo-doc').textContent = d.tipoDoc;
                    tipoDocWrap.classList.remove('hidden');
                } else {
                    tipoDocWrap.classList.add('hidden');
                }

                const destWrap = document.getElementById('aside-destinatarios-wrap');
                if (d.destinatarios && d.destinatarios !== '—') {
                    document.getElementById('aside-destinatarios').innerHTML = d.destinatarios.replace(/,/g,
                        '<br>');
                    destWrap.classList.remove('hidden');
                } else {
                    destWrap.classList.add('hidden');
                }

                const obsWrap = document.getElementById('aside-observaciones-wrap');
                if (d.observaciones) {
                    document.getElementById('aside-observaciones').textContent = d.observaciones;
                    obsWrap.classList.remove('hidden');
                } else {
                    obsWrap.classList.add('hidden');
                }

                const priorEl = document.getElementById('aside-prioridad');
                priorEl.textContent = d.prioridad || '—';
                priorEl.className = 'text-xs font-medium px-2 py-0.5 rounded-full ' + (d.prioridadClases ||
                    'bg-gray-100 text-gray-600');
                const estadoEl = document.getElementById('aside-estado');
                estadoEl.textContent = d.estado || '—';
                estadoEl.className = 'text-xs font-medium px-2 py-0.5 rounded-full ' + (d.estadoClases ||
                    'bg-gray-100 text-gray-600');
                asideVacio.classList.add('hidden');
                asideContenido.classList.remove('hidden');

                cargarArchivosAside(d.id, d.archivo);
            }

            function cargarArchivosAside(id, archivoPrincipalRow) {
                const lista = document.getElementById('aside-archivos-lista');
                const spinner = document.getElementById('aside-archivos-spinner');
                const errorEl = document.getElementById('aside-archivos-error');

                lista.innerHTML = '';
                errorEl.classList.add('hidden');
                spinner.classList.remove('hidden');

                // Si tenemos el archivo principal en el row de una vez lo mostramos (optimistic UI)
                if (archivoPrincipalRow) {
                    const nombre = archivoPrincipalRow.split('/').pop();
                    lista.innerHTML = `
                                <div class="mb-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-2">Documento Principal</div>
                                <a href="/storage/${archivoPrincipalRow}" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center gap-2 p-2.5 rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors group mb-2 text-left">
                                    <span class="material-symbols-outlined text-blue-500 text-base flex-shrink-0">picture_as_pdf</span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-blue-700 dark:text-blue-300 truncate group-hover:underline">${nombre}</p>
                                    </div>
                                    <span class="material-symbols-outlined text-blue-400 text-xs flex-shrink-0">open_in_new</span>
                                </a>
                            `;
                }

                fetch('{{ url('/ventanilla/externarec') }}/' + id + '/archivos', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        spinner.classList.add('hidden');

                        const tienePrincipal = !!data.archivo_principal;
                        const tieneAnexos = data.anexos && data.anexos.length > 0;

                        if (!tienePrincipal && !tieneAnexos) {
                            lista.innerHTML =
                                '<div class="text-xs text-gray-400 dark:text-gray-500 italic p-3 text-center bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">Sin archivos adjuntos.</div>';
                            return;
                        }

                        let html = '';

                        if (tienePrincipal) {
                            const href = '/storage/' + data.archivo_principal;
                            const nombre = data.archivo_principal.split('/').pop();
                            html += `
                                    <div class="mb-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-2">Documento Principal</div>
                                    <a href="${href}" target="_blank" rel="noopener noreferrer"
                                        class="flex items-center gap-2 p-2.5 rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors group mb-2 text-left">
                                        <span class="material-symbols-outlined text-blue-500 text-base flex-shrink-0">picture_as_pdf</span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-blue-700 dark:text-blue-300 truncate group-hover:underline">${nombre}</p>
                                        </div>
                                        <span class="material-symbols-outlined text-blue-400 text-xs flex-shrink-0">open_in_new</span>
                                    </a>
                                `;
                        }

                        if (tieneAnexos) {
                            html +=
                                `<div class="mb-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-3">Anexos</div>`;
                            data.anexos.forEach(a => {
                                const href = '/storage/' + a.ruta_archivo;
                                html += `
                                        <a href="${href}" target="_blank" rel="noopener noreferrer"
                                            class="flex items-center gap-2 p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group mb-2 text-left">
                                            <span class="material-symbols-outlined text-gray-400 text-base flex-shrink-0">attach_file</span>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate group-hover:underline">${a.nombre_original}</p>
                                            </div>
                                            <span class="material-symbols-outlined text-gray-400 text-xs flex-shrink-0">open_in_new</span>
                                        </a>
                                    `;
                            });
                        }

                        lista.innerHTML = html;
                    })
                    .catch(() => {
                        spinner.classList.add('hidden');
                        if (!archivoPrincipalRow) {
                            errorEl.classList.remove('hidden');
                        }
                    });
            }

            document.getElementById('tablaRecibidosBody').addEventListener('click', function(e) {
                const fila = e.target.closest('.fila-registro');
                if (fila) poblarAside(fila);
            });

            document.getElementById('btnCerrarAside').addEventListener('click', function() {
                asideVacio.classList.remove('hidden');
                asideContenido.classList.add('hidden');
                document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('bg-blue-50',
                    'dark:bg-blue-900/10'));
                sessionStorage.removeItem('externarec_selected');
            });

            // Intentar recuperar el estado previo al cargar la página
            const storedAside = sessionStorage.getItem('externarec_selected');
            if (storedAside) {
                try {
                    const data = JSON.parse(storedAside);
                    renderAsideData(data);
                    // Resaltar la fila si existe en la página actual
                    const sRow = document.querySelector(`.fila-registro[data-id="${data.id}"]`);
                    if (sRow) {
                        sRow.classList.add('bg-blue-50', 'dark:bg-blue-900/10');
                    }
                } catch (e) {
                    sessionStorage.removeItem('externarec_selected');
                }
            }
            }
        });
    </script>

    <!-- Saliente Modal (Registrar Respuesta) -->
    <div id="salienteModal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen w-full p-4 relative">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('salienteModal')"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-hidden transform transition-all font-display flex flex-col my-auto z-10">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-emerald-50/50 dark:bg-emerald-900/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <span class="material-symbols-outlined">outbox</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">Registrar Saliente</h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Generar Radicado SAL-</p>
                        </div>
                    </div>
                    <button onclick="closeModal('salienteModal')" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form id="salienteForm" method="POST" class="flex-1 flex flex-col min-h-0">
                    @csrf
                    <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Destino / Institución</label>
                            <input type="text" name="destino" id="salienteDestino" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Asunto</label>
                            <input type="text" name="asunto" id="salienteAsunto" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Tipo de Envío</label>
                                <select name="id_tipo_envio" id="salienteTipo" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($tipos as $t)
                                        <option value="{{ $t->id_tipo }}">{{ $t->tipo_nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Folios</label>
                                <input type="text" name="folio" id="salienteFolio" required readonly class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm dark:text-gray-400 cursor-not-allowed">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Funcionario que envía</label>
                            <select name="doc_quien_envia" id="salienteFuncionario" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white">
                                <option value="">Seleccionar...</option>
                                @foreach ($empleados as $e)
                                    <option value="{{ $e->emple_doc }}">{{ $e->emple_nombres }} {{ $e->emple_apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="salienteFilePreview" class="space-y-2"></div>
                    </div>
                    <div class="p-6 bg-gray-50/50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700 flex gap-3 shrink-0">
                        <button type="button" onclick="closeModal('salienteModal')" class="flex-1 px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-500 hover:text-gray-700 transition-all">Cancelar</button>
                        <button type="submit" class="flex-[2] flex items-center justify-center gap-2 px-6 py-3 text-xs font-bold text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 transition-all shadow-lg active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[18px]">done_all</span>
                            Registrar Envío Saliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('remitente.partials.modal_recibido')

    {{-- MODAL ASIGNAR DESTINATARIOS --}}
    <div id="modalAsignar" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen w-full p-4 relative">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity btnCerrarAsignar"></div>
            <div class="relative bg-white dark:bg-slate-900 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden my-auto z-10 transition-all">
                <form id="formAsignar" method="POST" class="flex flex-col flex-1 min-h-0">
                    @csrf
                    
                    {{-- Header Fijo --}}
                    <div class="px-8 py-5 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex justify-between items-center shrink-0">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Asignar Destinatarios</h3>
                        <button type="button" class="btnCerrarAsignar p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full">
                            <span class="material-symbols-outlined font-bold text-xl leading-none">close</span>
                        </button>
                    </div>

                    {{-- Body con scroll --}}
                    <div class="flex-1 overflow-y-auto form-body-scroll p-8 space-y-6 bg-white dark:bg-slate-900">
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800">
                        <p class="text-xs font-semibold text-blue-800 dark:text-blue-300 uppercase tracking-wider mb-1">
                            Correspondencia</p>
                        <p id="asignar-radicado" class="text-sm font-bold text-slate-900 dark:text-white"></p>
                        <p id="asignar-asunto" class="text-xs text-slate-500 dark:text-slate-400 mt-0.5"></p>
                    </div>

                    <div class="space-y-3">
                        <label class="text-slate-900 dark:text-white text-sm font-medium leading-normal">
                            Seleccionar Destinatario(s) <span class="text-red-500">*</span>
                        </label>
                        <div id="asignar-destinatarios-container" class="space-y-2">
                            {{-- El primer bloque se usa como template y base --}}
                            <div class="destinatario-block-asignar flex items-start gap-2" data-index="0">
                                <input type="hidden" name="destinatarios[]" class="dest-hidden-input">
                                <div class="relative flex-1" style="min-width:0">
                                    <button type="button"
                                        class="dest-btn-toggle form-input flex items-center justify-between w-full rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal text-left">
                                        <span class="dest-label text-slate-400">Seleccione un documento o nombre...</span>
                                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div
                                        class="dest-dropdown hidden absolute z-20 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg shadow-lg overflow-hidden">
                                        <div class="p-2 border-b border-slate-200 dark:border-slate-700">
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                                <input type="text"
                                                    class="dest-search-input w-full rounded-md border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-900 text-slate-900 dark:text-white py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
                                                    placeholder="Buscar por cédula o nombre..." />
                                            </div>
                                        </div>
                                        <ul
                                            class="dest-list max-h-48 overflow-y-auto py-1 text-sm text-slate-700 dark:text-slate-200">
                                            <li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>
                                        </ul>
                                    </div>
                                </div>
                                <button type="button"
                                    class="dest-btn-remove hidden mt-1 flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg border border-red-200 dark:border-red-800 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="btnAgregarDestinatarioAsignar"
                            class="flex items-center gap-1.5 text-sm font-medium text-primary hover:text-primary/80 transition-colors mt-1">
                            <span class="material-symbols-outlined text-base">person_add</span>
                            + Agregar otro destinatario
                        </button>
                    </div>

                    <div class="space-y-2">
                        <label
                            class="text-slate-900 dark:text-white text-sm font-medium leading-normal">Observaciones</label>
                        <textarea name="observaciones" rows="2"
                            class="form-textarea flex w-full min-w-0 flex-1 resize-y rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 p-3.5 text-base font-normal"
                            placeholder="Opcional..."></textarea>
                    </div>

                    </div>

                    {{-- Footer Fijo --}}
                    <div class="flex items-center justify-end gap-4 px-8 py-5 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shrink-0">
                        <button type="button"
                            class="btnCerrarAsignar h-11 px-6 rounded-lg text-sm font-bold bg-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors">Cancelar</button>
                        <button type="submit"
                            class="h-11 px-6 rounded-lg text-sm font-bold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">Confirmar Asignación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalAsignar = document.getElementById('modalAsignar');
            const formAsignar = document.getElementById('formAsignar');
            const asignarRadicadoLabel = document.getElementById('asignar-radicado');
            const asignarAsuntoLabel = document.getElementById('asignar-asunto');
            const ALL_DESTINATARIOS = @json($todosDestinatarios);



            function initBuscadorAsignar(block) {
                const btnToggle = block.querySelector('.dest-btn-toggle');
                const dropdown = block.querySelector('.dest-dropdown');
                const searchInput = block.querySelector('.dest-search-input');
                const list = block.querySelector('.dest-list');
                const label = block.querySelector('.dest-label');
                const hidden = block.querySelector('.dest-hidden-input');
                const btnRemove = block.querySelector('.dest-btn-remove');

                function render(items) {
                    list.innerHTML = '';
                    if (items.length === 0) {
                        list.innerHTML =
                            '<li class="px-3 py-2 text-slate-400 italic">No se encontraron resultados</li>';
                        return;
                    }
                    items.forEach(item => {
                        const li = document.createElement('li');
                        li.className =
                            'px-3 py-2.5 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer border-b border-slate-50 dark:border-slate-700/50 last:border-0';
                        li.innerHTML = `
                                    <div class="flex flex-col gap-0.5">
                                        <span class="font-bold text-slate-700 dark:text-slate-200">${item.emple_nombres} ${item.emple_apellidos}</span>
                                        <span class="text-[10px] text-blue-500 font-mono">CC: ${item.emple_doc} ${item.area_nombre ? '— ' + item.area_nombre : ''}</span>
                                    </div>
                                `;
                        li.addEventListener('click', (e) => {
                            e.stopPropagation();
                            hidden.value = item.emple_doc;
                            label.textContent = `${item.emple_nombres} ${item.emple_apellidos}`;
                            label.classList.remove('text-slate-400');
                            label.classList.add('text-slate-900', 'dark:text-white');
                            dropdown.classList.add('hidden');
                        });
                        list.appendChild(li);
                    });
                }

                btnToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    modalAsignar.querySelectorAll('.dest-dropdown').forEach(d => {
                        if (d !== dropdown) d.classList.add('hidden');
                    });
                    dropdown.classList.toggle('hidden');
                    if (!dropdown.classList.contains('hidden')) {
                        searchInput.focus();
                        render(ALL_DESTINATARIOS);
                    }
                });

                searchInput.addEventListener('input', function() {
                    const q = this.value.toLowerCase();
                    const filtrados = ALL_DESTINATARIOS.filter(d =>
                        d.emple_doc.toLowerCase().includes(q) ||
                        d.emple_nombres.toLowerCase().includes(q) ||
                        d.emple_apellidos.toLowerCase().includes(q)
                    );
                    render(filtrados);
                });

                if (btnRemove) {
                    btnRemove.addEventListener('click', () => block.remove());
                }
            }

            window.openAsignarModal = function(id, radicado, asunto) {
                asignarRadicadoLabel.textContent = radicado;
                asignarAsuntoLabel.textContent = asunto;
                formAsignar.action = `{{ url('/ventanilla/externarec') }}/${id}/asignar`;

                const container = document.getElementById('asignar-destinatarios-container');
                const blocks = container.querySelectorAll('.destinatario-block-asignar');
                for (let i = 1; i < blocks.length; i++) blocks[i].remove();

                const firstBlock = blocks[0];
                firstBlock.querySelector('.dest-hidden-input').value = '';
                firstBlock.querySelector('.dest-label').textContent = 'Seleccione un documento o nombre...';
                firstBlock.querySelector('.dest-label').classList.add('text-slate-400');
                firstBlock.querySelector('.dest-search-input').value = '';

                initBuscadorAsignar(firstBlock);
                window.openModal('modalAsignar');
            };

            document.querySelectorAll('.btnCerrarAsignar').forEach(btn => {
                btn.addEventListener('click', () => window.closeModal('modalAsignar'));
            });

            document.getElementById('btnAgregarDestinatarioAsignar').addEventListener('click', function() {
                const container = document.getElementById('asignar-destinatarios-container');
                const template = container.querySelector('.destinatario-block-asignar');
                const clone = template.cloneNode(true);

                clone.querySelector('.dest-hidden-input').value = '';
                clone.querySelector('.dest-label').textContent = 'Seleccione un documento o nombre...';
                clone.querySelector('.dest-label').classList.add('text-slate-400');
                clone.querySelector('.dest-search-input').value = '';
                clone.querySelector('.dest-btn-remove').classList.remove('hidden');

                container.appendChild(clone);
                initBuscadorAsignar(clone);
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.destinatario-block-asignar') && !e.target.closest(
                        '.destinatario-block')) {
                    document.querySelectorAll('.dest-dropdown').forEach(d => d.classList.add('hidden'));
                }
            });

            // (Redundant registration logic removed, handled by partial)
        });
    </script>

    <script>
        // Global data store for Recibidos
        window.correspondenceData = @json($recibidos->keyBy('id_recibido'));

        // Registrar Saliente Modal Logic
        function openSalienteModal(id) {
            const c = window.correspondenceData[id];
            if (!c) return;

            document.getElementById('salienteForm').action = `{{ url('/ventanilla') }}/${id}/store-saliente`;
            document.getElementById('salienteDestino').value = c.nom_institucion || c.nombre_persona || '';
            document.getElementById('salienteAsunto').value = 'R: ' + (c.asunto || '');
            document.getElementById('salienteFolio').value = c.folio || 0;
            
            // Auto-fill Email and Type
            if (document.getElementById('salienteEmailNotif')) {
                document.getElementById('salienteEmailNotif').value = c.correo_persona || '';
            }
            if (document.getElementById('salienteTipo')) {
                document.getElementById('salienteTipo').value = c.id_tipo || '';
            }

            // Auto-select Funcionario (Current logged user)
            if (document.getElementById('salienteFuncionario')) {
                const currentDoc = "{{ auth()->guard('remitente')->user()->rem_doc }}";
                document.getElementById('salienteFuncionario').value = currentDoc;
            }

            const preview = document.getElementById('salienteFilePreview');
            preview.innerHTML = '';
            if (c.archivo) {
                const fileName = c.archivo.split('/').pop();
                preview.innerHTML += `
                    <div class="flex items-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl">
                        <span class="material-symbols-outlined text-emerald-600">description</span>
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-emerald-900 dark:text-emerald-400 uppercase tracking-widest">Documento Principal</p>
                            <p class="text-xs text-emerald-700/60 dark:text-emerald-500/60 truncate font-mono">${fileName}</p>
                        </div>
                    </div>
                `;
            }
            window.openModal('salienteModal');
        }

        function openRejectModal(id, radicado) {
            document.getElementById('rejectRadText').textContent = 'Radicado: ' + radicado;
            document.getElementById('rejectForm').action = `{{ url('/ventanilla') }}/${id}/rechazar`;
            window.openModal('rejectModal');
        }
    </script>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 z-[60] hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen w-full p-4 relative">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('rejectModal')"></div>
        <div class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh] my-auto">
            <div class="shrink-0 px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-red-50/50 dark:bg-red-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined font-variation-icon text-xl">cancel</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">Rechazar Correspondencia</h3>
                        <p id="rejectRadText" class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Radicado: ---</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('rejectModal')" class="p-2 text-gray-400 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <form id="rejectForm" method="POST" action="" class="flex flex-col overflow-hidden h-full">
                @csrf
                <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
                    <div class="space-y-5">
                        <div class="p-4 bg-orange-50 border border-orange-200 rounded-xl text-orange-800 dark:bg-orange-900/20 dark:border-orange-800 dark:text-orange-200 text-sm mb-4 flex items-start gap-3">
                            <span class="material-symbols-outlined shrink-0 mt-0.5" style="font-size: 20px;">info</span>
                            <p>Al rechazar, esta correspondencia se dará por terminada con estado de <strong>Rechazo</strong> y se enviará una notificación por correo al remitente original explicando los motivos indicados abajo.</p>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-1.5 ml-1">
                                <span class="material-symbols-outlined text-[14px]">text_snippet</span> Motivo del Rechazo <span class="text-red-500">*</span>
                            </label>
                            <textarea name="observaciones" id="rejectObs" required rows="4" maxlength="250" placeholder="Escriba aquí los detalles..." class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50 focus:bg-white dark:bg-gray-900/50 dark:focus:bg-gray-800 dark:text-white focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition-all text-sm resize-none"></textarea>
                        </div>
                    </div>
                </div>
                <div class="shrink-0 px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-end gap-3 rounded-b-3xl">
                    <button type="button" onclick="closeModal('rejectModal')" class="px-5 py-2.5 text-sm font-bold text-gray-600 border border-gray-200 bg-white rounded-xl hover:bg-gray-50 transition-all active:scale-95">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">cancel</span> Confirmar Rechazo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
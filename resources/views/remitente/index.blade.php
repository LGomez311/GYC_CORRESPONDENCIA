@extends('remitente.layouts.app')

@section('title', 'Panel de Remitente')

@section('content')
    <div class="flex flex-col h-screen w-full bg-gray-50 dark:bg-gray-900 overflow-hidden">
        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col p-6 overflow-y-auto">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Mi Dashboard
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Gestiona y rastrea tu correspondencia enviada.</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('remitente.externarec') }}"
                        class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">move_to_inbox</span>
                        Registrar Recibido
                    </a>

                    <a href="{{ route('remitente.externaenv') }}"
                        class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">outbox</span>
                        Registrar Saliente
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card: Total -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-110 transition-transform">
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-primary/10 rounded-xl text-primary">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Enviados</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Rejected -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-red-500/5 rounded-full group-hover:scale-110 transition-transform">
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl text-red-600 dark:text-red-400">
                            <span class="material-symbols-outlined">cancel</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rechazados</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['rejected'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Pending -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/5 rounded-full group-hover:scale-110 transition-transform">
                    </div>
                    <div class="flex items-center gap-4">
                        <div
                            class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-xl text-orange-600 dark:text-orange-400">
                            <span class="material-symbols-outlined">pending_actions</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">En Trámite</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Resolved -->
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-green-500/5 rounded-full group-hover:scale-110 transition-transform">
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl text-green-600 dark:text-green-400">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Finalizados</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['resolved'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Correspondence Table -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col flex-1">
                <div
                    class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Correspondencia Reciente</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Listado de tus registros y sus estados actuales.</p>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="material-symbols-outlined text-gray-400 text-sm">search</span>
                        </span>
                        <input type="text" id="tableSearch"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary dark:text-white"
                            placeholder="Filtrar por asunto, radicado...">
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-sm text-left">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-gray-900/30 border-b border-gray-100 dark:border-gray-800">
                                    <th
                                        class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                        Radicados</th>
                                    <th class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                        Procedencia</th>
                                    <th class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                        Detalles Documento</th>
                                    <th class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                        Destinatarios</th>
                                    <th class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                        Detalles Técnicos</th>
                                    <th class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                        Ingreso / Registro</th>
                                    <th
                                        class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                        Docs</th>
                                    <th
                                        class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                        Estado</th>
                                    <th
                                        class="px-3 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest text-center">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="correspondenceTableBody" class="divide-y divide-gray-50 dark:divide-gray-800/50">
                                @forelse($correspondencias as $c)
                                    <tr
                                        class="group hover:bg-gray-50/30 dark:hover:bg-gray-800/10 transition-all duration-200">
                                        <!-- Radicados -->
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex flex-col gap-1">
                                                <span
                                                    class="text-xs font-black text-gray-900 dark:text-white tracking-tight">
                                                    {{ $c->radicado ? $c->radicado->num_radicado : 'SIN RADICADO' }}
                                                </span>
                                                @if ($c->num_radicado_ext)
                                                    <span
                                                        class="text-[10px] font-bold text-primary bg-primary/5 dark:bg-primary/10 px-1.5 py-0.5 rounded border border-primary/10 w-fit">
                                                        EXT: {{ $c->num_radicado_ext }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Procedencia -->
                                        <td class="px-3 py-5">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center gap-1">
                                                    <span
                                                        class="material-symbols-outlined text-[14px] text-gray-400 font-variation-icon">business</span>
                                                    <span
                                                        class="text-[11px] font-bold text-gray-700 dark:text-gray-200 truncate max-w-[100px]"
                                                        title="{{ $c->nom_institucion ?? 'Particular' }}">
                                                        {{ $c->nom_institucion ?? 'Particular' }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-1 text-primary">
                                                    <span
                                                        class="material-symbols-outlined text-[14px] font-variation-icon">location_on</span>
                                                    <span class="text-[10px] font-black uppercase tracking-tight">
                                                        {{ $c->ciudad ? $c->ciudad->ciudad_nom : '-' }}
                                                        @if ($c->ciudad && $c->ciudad->departamento)
                                                            - {{ $c->ciudad->departamento->dpto_nombre }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Detalles Documento -->
                                        <td class="px-3 py-5">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center gap-1">
                                                    <span
                                                        class="material-symbols-outlined text-[14px] text-gray-400 font-variation-icon">description</span>
                                                    <span
                                                        class="text-[11px] font-medium text-gray-600 dark:text-gray-300 truncate max-w-[110px]"
                                                        title="{{ $c->asunto }}">
                                                        {{ $c->asunto }}
                                                    </span>
                                                </div>
                                                <div class="flex flex-wrap gap-1">
                                                    <div
                                                        class="flex items-center gap-0.5 bg-gray-100 dark:bg-gray-700/50 px-1 py-0.5 rounded text-[8px] font-bold text-gray-500 uppercase tracking-tighter">
                                                        <span
                                                            class="material-symbols-outlined text-[10px] font-variation-icon">layers</span>
                                                        F: {{ $c->folio ?? 0 }}
                                                    </div>
                                                    @if ($c->id_tipo_rec)
                                                        <div
                                                            class="flex items-center gap-0.5 bg-orange-50 dark:bg-orange-900/10 px-1 py-0.5 rounded text-[8px] font-bold text-orange-600 uppercase tracking-tighter">
                                                            {{ $c->tipo ? substr($c->tipo->tipo_nombre, 0, 10) : 'TIPO' }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Destinatarios -->
                                        <td class="px-3 py-5">
                                            <div class="flex flex-col gap-1 max-w-[120px]">
                                                @forelse($c->destinatarios->take(2) as $dest)
                                                    <div class="flex items-center gap-1.5">
                                                        <span
                                                            class="text-[9px] font-black text-gray-600 dark:text-gray-300 truncate">{{ explode(' ', $dest->emple_nombres)[0] }}</span>
                                                    </div>
                                                @empty
                                                    <span class="text-gray-400 text-xs">-</span>
                                                @endforelse
                                            </div>
                                        </td>

                                        <!-- Detalles Técnicos -->
                                        <td class="px-3 py-5">
                                            <div class="flex items-center gap-1">
                                                <span
                                                    class="material-symbols-outlined text-[14px] text-green-500 font-variation-icon">task_alt</span>
                                                <span
                                                    class="text-[9px] font-black text-gray-700 dark:text-gray-300 whitespace-nowrap uppercase tracking-tighter">
                                                    {{ $c->id_estado_rec == 10 ? 'Finalizado' : 'Gestión' }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Ingreso / Registro -->
                                        <td class="px-3 py-5 whitespace-nowrap">
                                            <div
                                                class="flex flex-col gap-0 text-[9px] font-bold text-gray-400 dark:text-gray-500">
                                                <div class="flex items-center gap-1">
                                                    <span
                                                        class="material-symbols-outlined text-[12px] font-variation-icon">calendar_today</span>
                                                    {{ \Carbon\Carbon::parse($c->fecha_hora_recib)->format('d/m/y') }}
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <span
                                                        class="material-symbols-outlined text-[12px] font-variation-icon">schedule</span>
                                                    {{ \Carbon\Carbon::parse($c->fecha_hora_recib)->format('h:i A') }}
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Archivos / Anexos -->
                                        <td class="px-3 py-5 text-center">
                                            <button onclick="viewDetails({{ $c->id_recibido }})"
                                                class="p-2 text-primary hover:bg-primary/5 rounded-lg transition-all"
                                                title="Ver Documentos">
                                                <span
                                                    class="material-symbols-outlined text-[18px] font-variation-icon">folder_open</span>
                                            </button>
                                        </td>

                                        <!-- Estado -->
                                        <td class="px-3 py-5 text-center">
                                            @php
                                                $statusColor = match ($c->id_estado_rec) {
                                                    11 => 'bg-red-500 text-white',
                                                    9, 10 => 'bg-green-500 text-white',
                                                    default => 'bg-primary text-white',
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-tighter shadow-sm {{ $statusColor }}">
                                                {{ $c->estado ? substr($c->estado->estado_nomb, 0, 10) : 'PEND' }}
                                            </span>
                                        </td>

                                        <!-- Acciones -->
                                        <td class="px-3 py-5 text-center">
                                            <div class="flex items-center justify-center gap-0.5">
                                                <button onclick="viewDetails({{ $c->id_recibido }})"
                                                    class="p-1.5 text-gray-400 hover:text-primary transition-all"
                                                    title="Ver Detalles">
                                                    <span
                                                        class="material-symbols-outlined text-[18px] font-variation-icon">visibility</span>
                                                </button>
                                                <button onclick="showHistory({{ $c->id_recibido }})"
                                                    class="p-1.5 text-gray-400 hover:text-primary transition-all"
                                                    title="Trazabilidad">
                                                    <span
                                                        class="material-symbols-outlined text-[18px] font-variation-icon">timeline</span>
                                                </button>
                                                @if ($c->id_estado_rec == 11)
                                                    <button onclick="openEditModalById({{ $c->id_recibido }})"
                                                        class="p-1.5 text-red-500 hover:text-red-700 transition-all font-variation-icon"
                                                        title="Corregir">
                                                        <span
                                                            class="material-symbols-outlined text-[18px]">edit_note</span>
                                                    </button>
                                                    <button onclick="confirmFinalize({{ $c->id_recibido }})"
                                                        class="p-1.5 text-green-500 hover:text-green-700 transition-all font-variation-icon"
                                                        title="Finalizar">
                                                        <span
                                                            class="material-symbols-outlined text-[18px]">check_circle</span>
                                                    </button>
                                                    <form id="finalize-form-{{ $c->id_recibido }}"
                                                        action="{{ route('remitente.finalize', $c->id_recibido) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                    </form>
                                                @else
                                                    <span
                                                        class="material-symbols-outlined text-gray-200 dark:text-gray-700 text-[18px] font-variation-icon cursor-not-allowed"
                                                        title="Bloqueado (Ya corregido o finalizado)">lock</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div
                                                    class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                                    <span
                                                        class="material-symbols-outlined text-gray-300 text-4xl font-variation-icon">inventory_2</span>
                                                </div>
                                                <p class="text-gray-400 font-medium italic">No se encontraron registros de
                                                    correspondencia.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $correspondencias->appends(request()->query())->links() }}
                </div>
            </div>
        </main>
    </div>

    <!-- View Details Modal -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                onclick="closeModal('detailsModal')"></div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden transform transition-all">
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

                        <div class="pt-4 flex gap-3">
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
    <div id="historyModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                onclick="closeModal('historyModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-middle bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div
                    class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Trazabilidad de Documento</h3>
                        <p class="text-xs text-gray-500 mt-0.5" id="historyRadText"></p>
                    </div>
                    <button onclick="closeModal('historyModal')"
                        class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                        <span class="material-symbols-outlined">close</span>
                    </button>
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
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('editModal')">
            </div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden transform transition-all">
                <form id="editForm" method="POST">
                    @csrf
                    <div
                        class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
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
                    <div class="p-8 space-y-6">
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
                                                        class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
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
                        class="px-8 py-6 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50/50 dark:bg-gray-900/20">
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
        window.correspondenceData = @json($correspondencias->keyBy('id_recibido'));

        // Modal general logic
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Helper for initials/avatar
        function getAvatarHtml(dest) {
            if (dest.emple_img) {
                return `<img src="/storage/${dest.emple_img}" class="w-6 h-6 rounded-full object-cover border border-white dark:border-gray-700">`;
            }
            const initials = (dest.emple_nombres[0] + (dest.emple_apellidos ? dest.emple_apellidos[0] : '')).toUpperCase();
            return `<div class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[10px] font-bold border border-primary/20">${initials}</div>`;
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
                c.destinatarios.forEach(dest => {
                    const avatar = getAvatarHtml(dest);
                    const div = document.createElement('div');
                    div.className =
                        'inline-flex items-center gap-2 px-2 py-1 rounded-lg text-[10px] font-bold bg-gray-50 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-100 dark:border-gray-600';
                    div.innerHTML = `${avatar} <span>${dest.emple_nombres} ${dest.emple_apellidos}</span>`;
                    recipientsContainer.appendChild(div);
                });
            } else {
                recipientsContainer.innerHTML =
                    '<p class="text-gray-400 text-xs italic">No hay destinatarios asignados.</p>';
            }

            // Attachments List Logic
            const filesContainer = document.querySelector('#detailDownload').parentNode;
            filesContainer.innerHTML = ''; // Clear action area

            // 1. Principal Document
            if (c.archivo) {
                const btn = document.createElement('a');
                btn.href = `/storage/${c.archivo}`;
                btn.target = '_blank';
                btn.className =
                    'flex-1 flex items-center justify-center gap-2 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-primary bg-primary/10 rounded-xl hover:bg-primary/20 transition-all';
                btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">description</span> Principal';
                filesContainer.appendChild(btn);
            }

            // 2. Anexos
            if (c.anexos && c.anexos.length > 0) {
                c.anexos.forEach((anexo, idx) => {
                    const btn = document.createElement('a');
                    btn.href = `/storage/${anexo.ruta_archivo}`;
                    btn.target = '_blank';
                    btn.className =
                        'flex-1 flex items-center justify-center gap-2 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-400 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all';
                    btn.title = anexo.nombre_original;
                    btn.innerHTML =
                        `<span class="material-symbols-outlined text-[18px]">attach_file</span> Anexo ${idx + 1}`;
                    filesContainer.appendChild(btn);
                });
            }

            // 3. Edit Action if rejected
            if (c.id_estado_rec == 11) {
                const editBtn = document.createElement('button');
                editBtn.className =
                    'flex-1 flex items-center justify-center gap-2 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-white bg-red-500 rounded-xl hover:bg-red-600 transition-all shadow-lg shadow-red-200 dark:shadow-red-900/20';
                editBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]">edit</span> Corregir Ahora';
                editBtn.onclick = () => {
                    closeModal('detailsModal');
                    openEditModalById(id);
                };
                filesContainer.appendChild(editBtn);
            }

            openModal('detailsModal');
        }

        // History Timeline Logic
        function showHistory(id) {
            const historyTimeline = document.getElementById('historyTimeline');
            historyTimeline.innerHTML =
                '<div class="flex justify-center p-12"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div></div>';
            openModal('historyModal');

            fetch(`/remitente/history/${id}`)
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
            document.getElementById('editForm').action = `/remitente/${c.id_recibido}/update-rejected`;

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
    </script>
@endsection

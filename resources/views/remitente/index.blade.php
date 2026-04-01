@extends('remitente.layouts.app')

@section('title', 'Panel de Remitente')

@section('content')
    <div class="flex flex-col p-4 md:p-6 min-w-0 gap-8">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 w-full">
                <div class="w-full md:w-auto">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Inicio
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Registros actuales en trámite.</p>
                </div>
                <div class="flex flex-col sm:flex-row w-full md:w-auto gap-4">
                    <button onclick="openModal('modalCorrespondencia')"
                        class="flex items-center justify-center gap-3 px-6 py-3 text-sm font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all active:scale-95 w-full sm:w-auto shadow-md">
                        <span class="material-symbols-outlined text-[24px]">move_to_inbox</span>
                        Registrar Recibido
                    </button>

                    <a href="{{ route('ventanilla.externaenv') }}?abrir=nuevo"
                        class="flex items-center justify-center gap-3 px-6 py-3 text-sm font-bold text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 transition-all active:scale-95 w-full sm:w-auto shadow-md">
                        <span class="material-symbols-outlined text-[24px]">outbox</span>
                        Registrar Saliente
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10 w-full relative z-0">
                <!-- Stat Card: Total -->
                <div
                    class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-[20px]">description</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Registros</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Rejected -->
                <div
                    class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center text-red-600 dark:text-red-400 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-[20px]">cancel</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Rechazados</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['rejected'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Pending -->
                <div
                    class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center text-orange-600 dark:text-orange-400 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-[20px]">pending_actions</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">En Trámite</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['pending'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Resolved -->
                <div
                    class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Finalizados</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['resolved'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Correspondence Table Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-12 block w-full">
                <!-- Header with Filters -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 block w-full">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 w-full">
                        <div class="w-full">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Correspondencia Reciente</h2>
                            <p class="text-sm text-gray-500 mt-1">Listado de registros y estados actuales.</p>
                        </div>
                        <form method="GET" action="{{ route('remitente.index') }}"
                            class="flex flex-col sm:flex-row w-full lg:w-auto gap-4">
                            <div class="relative w-full sm:w-56">
                                <select name="estado_id" onchange="this.form.submit()"
                                    class="block w-full h-11 px-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-2 focus:ring-primary focus:border-primary dark:text-white appearance-none">
                                    <option value="">Todos los estados</option>
                                @foreach ($estados as $est)
                                    @if (in_array($est->id_estado, [7, 8, 9, 10, 11, 12, 13, 14, 15]))
                                        <option value="{{ $est->id_estado }}"
                                            {{ request('estado_id') == $est->id_estado ? 'selected' : '' }}>
                                            {{ $est->estado_nomb }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

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
                                <th class="px-6 py-4 font-black text-center whitespace-nowrap">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="correspondenceTableBody" class="divide-y divide-gray-50 dark:divide-gray-800/50">

                            @forelse($correspondenciaNueva as $c)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top group">
                                        <!-- Radicados -->
                                        <td class="px-6 py-4 whitespace-nowrap" data-label="Radicados">
                                            <div class="flex flex-col gap-1 items-start">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 text-xs font-bold border border-[#cfd7e7] dark:border-slate-700">
                                                    <span class="material-symbols-outlined text-[14px]">tag</span>
                                                    {{ $c->radicado }}
                                                </span>
                                                @if (isset($c->radicado_ext) && $c->radicado_ext)
                                                    <span class="block text-[10px] text-slate-400 mt-1 uppercase font-medium">RAD EMP: {{ $c->radicado_ext }}</span>
                                                @endif
                                            </div>
                                        </td>

                                    <td class="px-6 py-4" data-label="Procedencia">
                                        <div class="font-medium dark:text-white max-w-[180px] break-words whitespace-normal">{{ $c->contacto }}</div>
                                        <span class="inline-flex items-center gap-0.5 text-xs text-{{ $c->clase }}-500 mt-0.5">
                                            <span class="material-symbols-outlined" style="font-size:13px">description</span>
                                            {{ $c->tipo_label }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm" data-label="Asunto">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 mb-1 max-w-[200px] whitespace-normal break-words">{{ $c->asunto }}</div>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <div class="flex items-center gap-0.5 text-[10px] text-gray-500 font-bold uppercase">
                                                <span class="material-symbols-outlined text-[14px]">layers</span> F: {{ $c->folios ?? 0 }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4" data-label="Destinatarios">
                                        <div class="flex flex-wrap gap-2 max-w-[200px]">
                                            @if ($c->tipo === 'Externa')
                                                @if (isset($c->destinatarios) && $c->destinatarios->count() > 0)
                                                    <div class="flex -space-x-2 overflow-hidden">
                                                        @foreach($c->destinatarios->take(4) as $dest)
                                                            <div class="inline-block w-8 h-8 rounded-full ring-2 ring-white dark:ring-gray-800 bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold shadow-sm" title="{{ $dest->emple_nombres }} {{ $dest->emple_apellidos }}">
                                                                {{ strtoupper(substr($dest->emple_nombres, 0, 1)) }}{{ strtoupper(substr($dest->emple_apellidos, 0, 1)) }}
                                                            </div>
                                                        @endforeach
                                                        @if($c->destinatarios->count() > 4)
                                                            <div class="inline-block w-8 h-8 rounded-full ring-2 ring-white dark:ring-gray-800 bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[10px] font-medium text-gray-600 dark:text-gray-300 shadow-sm border border-gray-200 dark:border-gray-600">
                                                                +{{ $c->destinatarios->count() - 4 }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-[10px] bg-gray-50 border border-gray-100 px-1.5 py-0.5 rounded italic">Sin asignar</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400 text-xs italic">-</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4" data-label="Registro">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($c->fecha)->format('d M Y') }}</div>
                                        <div class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($c->fecha)->format('h:i A') }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-center" data-label="Estado">
                                        @php
                                            $lowDesc = strtolower($c->estado);
                                            $idEst = $c->id_estado;
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
                                            {{ $c->estado }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center" data-label="Acciones">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="viewDetails('{{ $c->id }}', '{{ $c->tipo_label }}')" class="p-1 px-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors border border-transparent hover:border-blue-200" title="Ver Detalles">
                                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                                            </button>

                                            <button onclick="showHistory('{{ $c->rad_id }}', '{{ $c->radicado ?? $c->radicado_ext ?? '' }}', '{{ $c->tipo_label }}')" class="p-1 px-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:hover:text-white rounded-lg transition-colors border border-transparent hover:border-gray-200" title="Trazabilidad">
                                                <span class="material-symbols-outlined text-[18px]">timeline</span>
                                            </button>

                                            @if ($c->tipo === 'Externa')
                                                @if ($c->id_estado == 11)
                                                    <button onclick="openEditModalById({{ $c->id_original }})" class="p-1 px-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors border border-red-100" title="Corregir">
                                                        <span class="material-symbols-outlined text-[18px]">edit_note</span>
                                                    </button>
                                                    <button onclick="confirmFinalize({{ $c->id_original }})" class="p-1 px-2 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors border border-green-100" title="Finalizar">
                                                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                                    </button>
                                                @elseif($c->id_estado == 12 && !$c->is_assigned)
                                                    <button onclick="openAssignModal({{ $c->id_original }}, '{{ $c->radicado ?? $c->radicado_ext ?? '' }}')" class="p-1 px-2 text-blue-600 bg-blue-50 border border-blue-100 hover:bg-blue-100 rounded-lg transition-colors" title="Asignar">
                                                        <span class="material-symbols-outlined text-[18px]">person_add</span>
                                                    </button>
                                                    <button onclick="openRejectModal({{ $c->id_original }}, '{{ $c->radicado ?? $c->radicado_ext ?? '' }}')" class="p-1 px-2 text-red-600 bg-red-50 border border-red-100 hover:bg-red-100 rounded-lg transition-colors" title="Rechazar">
                                                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                                                    </button>
                                                @elseif($c->id_estado == 9)
                                                    @if (!isset($c->has_response) || !$c->has_response)
                                                        <button onclick="openSalienteModal({{ $c->id_original }})"
                                                            class="p-1 px-2 text-emerald-600 bg-emerald-50 border border-emerald-100 hover:bg-emerald-100 rounded-lg transition-colors"
                                                            title="Responder">
                                                            <span class="material-symbols-outlined text-[18px]">outbox</span>
                                                        </button>
                                                    @else
                                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-lg uppercase tracking-tight flex items-center gap-1">
                                                            <span class="material-symbols-outlined text-xs">done_all</span> Respondido
                                                        </span>
                                                    @endif
                                                @endif
                                            @elseif ($c->tipo === 'Saliente')
                                                @if ($c->id_estado == 0)
                                                    <button onclick="openSalienteModal({{ $c->id_original }})"
                                                        class="p-1 px-2 text-blue-600 bg-blue-50 border border-blue-100 hover:bg-blue-100 rounded-lg transition-colors"
                                                        title="Despachar Correspondencia">
                                                        <span class="material-symbols-outlined text-[18px]">send</span>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                @if (!isset($enviosPendientes) || count($enviosPendientes) == 0)
                                    <tr>
                                        <td colspan="7" class="px-4 py-4 align-middle text-center" data-label="Estado">
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
                                @endif
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $correspondenciaNueva->links() }}
                </div>
            </div>
        </div>

    <!-- View Details Modal (Expanded with Traceability) -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 w-full">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('detailsModal')"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden transform transition-all my-auto flex flex-col font-display">
                <!-- Header -->
                <div class="px-8 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        <div>
                            <h3 id="detailRadicadoHeader" class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">Detalles de la Correspondencia</h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest" id="detailRadicadoSub">Radicado: ---</p>
                        </div>
                    </div>
                    <button onclick="closeModal('detailsModal')" class="p-2 text-gray-400 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl hover:bg-gray-100 transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <div class="flex flex-col lg:flex-row flex-1 min-h-0 overflow-hidden">
                    <!-- Column 1: Info (Left) -->
                    <div class="w-full lg:w-1/4 bg-gray-50/30 dark:bg-gray-900/10 p-6 border-b lg:border-b-0 lg:border-r border-gray-100 dark:border-gray-700 overflow-y-auto custom-scrollbar text-left">
                        <div class="flex flex-col items-center text-center mb-8">
                            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-3xl text-indigo-600 dark:text-indigo-400 mb-4 shadow-sm border border-indigo-100/50 dark:border-indigo-800/30">
                                <span class="material-symbols-outlined text-4xl">description</span>
                            </div>
                            <h3 id="detailRadicado" class="text-lg font-black text-gray-900 dark:text-white mb-2"></h3>
                            <span id="detailStatus" class="px-3 py-1 rounded-full text-[10px] font-bold"></span>
                        </div>

                        <div class="space-y-6">
                            <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-50 dark:border-gray-700 pb-2">Información de Registro</p>
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500">
                                            <span class="material-symbols-outlined text-sm">calendar_month</span>
                                        </div>
                                        <div>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Fecha y Hora</p>
                                            <p id="detailDate" class="text-[11px] font-bold text-gray-700 dark:text-gray-300"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500">
                                            <span class="material-symbols-outlined text-sm">category</span>
                                        </div>
                                        <div>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Tipo de Documento</p>
                                            <p id="detailType" class="text-[11px] font-bold text-gray-700 dark:text-gray-300"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500">
                                            <span class="material-symbols-outlined text-sm">layers</span>
                                        </div>
                                        <div>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Folios</p>
                                            <p id="detailFolios" class="text-[11px] font-bold text-gray-700 dark:text-gray-300"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-50 dark:border-gray-700 pb-2">Destinatarios</p>
                                <div id="detailRecipients" class="flex flex-wrap gap-1.5"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Content (Middle) -->
                    <div class="flex-1 p-8 space-y-6 overflow-y-auto custom-scrollbar text-left">
                        <div>
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Resumen del Asunto</h4>
                            <p id="detailAsunto" class="text-xl font-bold text-gray-900 dark:text-white leading-tight mb-2"></p>
                            <div class="flex items-center gap-2 p-3 bg-indigo-50/50 dark:bg-indigo-900/10 rounded-2xl border border-indigo-100/50 dark:border-indigo-800/20 w-fit">
                                <span class="material-symbols-outlined text-indigo-500 text-sm">business</span>
                                <p class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                    <span id="detailInstitution"></span>
                                    <span class="mx-2 text-gray-300 dark:text-gray-600">•</span>
                                    <span id="detailCity" class="text-indigo-600 dark:text-indigo-400"></span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Cuerpo / Observaciones</h4>
                            <div class="bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl text-[13px] text-gray-700 dark:text-gray-300 italic leading-relaxed border border-slate-100 dark:border-slate-800 shadow-inner" id="detailObservations"></div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Archivos y Acciones</h4>
                            <div id="detailActionsContainer" class="flex flex-col gap-3"></div>
                        </div>
                    </div>

                    <!-- Column 3: Traceability (Right) -->
                    <div class="w-full lg:w-1/3 bg-gray-50/50 dark:bg-gray-900/20 border-t lg:border-t-0 lg:border-l border-gray-100 dark:border-gray-700 flex flex-col overflow-hidden text-left">
                        <div class="shrink-0 px-6 py-4 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <h4 class="text-[10px] font-black text-gray-600 dark:text-gray-300 uppercase tracking-widest flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">timeline</span>
                                Trazabilidad
                            </h4>
                            <a id="detailTraceDownloadBtn" href="#" target="_blank" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all" title="Descargar PDF">
                                <span class="material-symbols-outlined">download</span>
                            </a>
                        </div>
                        <div class="flex-1 p-6 overflow-y-auto custom-scrollbar" id="detailTraceTimeline">
                            <!-- Timeline items -->
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="shrink-0 px-8 py-4 bg-gray-50/80 dark:bg-gray-900/40 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 rounded-b-3xl">
                    <button onclick="closeModal('detailsModal')" class="px-6 py-2.5 text-xs font-black uppercase tracking-widest text-gray-500 hover:text-gray-700 transition-all">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 w-full">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                onclick="closeModal('historyModal')"></div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden shadow-2xl transform transition-all">
                <div
                    class="shrink-0 px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
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
                <div class="flex-1 p-8 overflow-y-auto custom-scrollbar bg-white dark:bg-gray-800">
                    <div id="historyTimeline" class="relative">
                        <!-- History items will be injected here -->
                    </div>
                </div>
                <div
                    class="shrink-0 px-8 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20 flex justify-end">
                    <button onclick="closeModal('historyModal')"
                        class="px-6 py-2 text-sm font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (for rejected) -->
    <div id="editModal" class="fixed inset-0 z-[60] hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 w-full relative">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('editModal')">
            </div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all my-auto">
                <form id="editForm" method="POST" class="flex flex-col h-full overflow-hidden">
                    @csrf
                    <div
                        class="shrink-0 px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
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
                    <div class="flex-1 p-8 space-y-6 overflow-y-auto custom-scrollbar">
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
                                        class="block w-full pl-7 pr-2 py-1.5 border border-gray-100 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700 text-[10px] focus:ring-primary focus:border-primary dark:text-white"
                                        placeholder="Documento, nombre o área...">
                                </div>
                            </div>
                            <div
                                class="bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden">
                                <div id="recipientList" class="max-h-56 overflow-y-auto p-2 space-y-1">
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

    <!-- Assign Modal -->
    <div id="assignModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                onclick="closeModal('assignModal')"></div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden transform transition-all font-display">
                <form id="assignForm" method="POST">
                    @csrf
                    <div
                        class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-blue-50/50 dark:bg-blue-900/20">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-2xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <span class="material-symbols-outlined">person_add</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                    Asignar Destinatarios</h3>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest"
                                    id="assignRadText">Radicado: -</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeModal('assignModal')"
                            class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="p-8 space-y-6">
                        <div>
                            <div class="flex justify-between items-end mb-3">
                                <label
                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Seleccionar
                                    Funcionarios</label>
                                <div class="relative w-48">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                        <span class="material-symbols-outlined text-gray-400 text-xs">search</span>
                                    </span>
                                    <input type="text" id="assignRecipientSearch"
                                        class="block w-full pl-7 pr-2 py-1.5 border border-gray-100 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900/50 text-[10px] focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none dark:text-white"
                                        placeholder="Buscar...">
                                </div>
                            </div>
                            <div
                                class="bg-gray-50/50 dark:bg-gray-900/30 border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden">
                                <div id="assignRecipientList" class="max-h-64 overflow-y-auto p-2 space-y-1">
                                    @foreach ($todosDestinatarios as $e)
                                        <label
                                            class="assign-recipient-item flex items-center gap-3 p-2.5 rounded-xl hover:bg-white dark:hover:bg-gray-800 cursor-pointer transition-all border border-transparent hover:border-gray-100 dark:hover:border-gray-700 select-none"
                                            data-name="{{ strtolower($e['emple_nombres'] . ' ' . $e['emple_apellidos']) }}"
                                            data-doc="{{ $e['emple_doc'] }}"
                                            data-area="{{ strtolower($e['area_nombre'] ?? 'sin área') }}">
                                            <input type="checkbox" name="destinatarios[]" value="{{ $e['emple_doc'] }}"
                                                class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500/20 dark:bg-gray-700 dark:border-gray-600">

                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-sm border border-blue-700">
                                                    {{ strtoupper(substr($e['emple_nombres'], 0, 1)) }}{{ strtoupper(substr($e['emple_apellidos'], 0, 1)) }}
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <span
                                                        class="text-sm font-semibold text-gray-700 dark:text-gray-200 truncate">{{ $e['emple_nombres'] }}
                                                        {{ $e['emple_apellidos'] }}</span>
                                                    <span
                                                        class="text-[10px] text-gray-400 truncate">{{ $e['area_nombre'] ?? 'Sin área' }}
                                                        • {{ $e['emple_doc'] }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <p class="text-[9px] text-gray-400 mt-3 px-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">info</span>
                                Puedes seleccionar varios empleados para asignarles esta correspondencia.
                            </p>
                        </div>
                    </div>

                    <div
                        class="p-6 bg-gray-50/50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700 flex gap-3">
                        <button type="button" onclick="closeModal('assignModal')"
                            class="flex-1 px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-500 hover:text-gray-700 transition-all">Cancelar</button>
                        <button type="submit"
                            class="flex-[2] flex items-center justify-center gap-2 px-6 py-3 text-xs font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 dark:shadow-blue-900/30 active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[18px]">person_add</span>
                            Confirmar Asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Global data store to avoid quote/escaping issues in onclick handlers
        window.correspondenceData = @json($correspondencias->keyBy('id_recibido'));
        window.enviosPendientesData = @json($enviosPendientes->keyBy('id_envio'));

        // Modal general logic
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Assignment Modal Logic
        function openAssignModal(id, radText = '') {
            const c = window.correspondenceData[id];
            if (!c) return;

            document.getElementById('assignRadText').textContent =
                `Radicado: ${radText || 'SIN RADICADO'}`;
            document.getElementById('assignForm').action = `/ventanilla/externarec/${id}/asignar`;

            // Clear previous selections
            document.querySelectorAll('#assignRecipientList input[type="checkbox"]').forEach(cb => cb.checked = false);

            openModal('assignModal');
        }

        // Unified Search Logic for Recipients
        function setupRecipientSearch(inputId, listId, itemClass) {
            const searchInput = document.getElementById(inputId);
            const items = document.querySelectorAll(`.${itemClass}`);

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();

                    items.forEach(item => {
                        const name = item.getAttribute('data-name') || '';
                        const doc = item.getAttribute('data-doc') || '';
                        const area = item.getAttribute('data-area') || '';

                        if (name.includes(query) || doc.includes(query) || area.includes(query)) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupRecipientSearch('recipientSearch', 'recipientList', 'recipient-item');
            setupRecipientSearch('assignRecipientSearch', 'assignRecipientList', 'assign-recipient-item');
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

            document.getElementById('detailRadicado').textContent = c.radicado ? c.radicado : 'SIN RADICADO';
            document.getElementById('detailAsunto').textContent = c.asunto;
            document.getElementById('detailDate').textContent = new Date(c.fecha_hora_recib || c.fecha).toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('detailType').textContent = c.tipo_label || 'No especificado';
            document.getElementById('detailFolios').textContent = c.folios || '0';

            // Observaciones
            let observacionesMostrar = c.observaciones || 'Sin observaciones.';
            document.getElementById('detailObservations').textContent = observacionesMostrar;
            document.getElementById('detailInstitution').textContent = c.contacto || 'Particular';
            document.getElementById('detailCity').textContent = c.ciudad || 'No disponible';

            // Status pill
            const statusSpan = document.getElementById('detailStatus');
            statusSpan.textContent = c.estado || 'Desconocido';
            statusSpan.className = 'px-3 py-1 rounded-full text-[10px] font-bold ';
            if (c.id_estado == 11) {
                statusSpan.classList.add('bg-red-100', 'text-red-700', 'dark:bg-red-900/50', 'dark:text-red-400');
            } else if (c.id_estado == 9 || c.id_estado == 10) {
                statusSpan.classList.add('bg-green-100', 'text-green-700', 'dark:bg-green-900/50', 'dark:text-green-400');
            } else {
                statusSpan.classList.add('bg-blue-100', 'text-blue-700', 'dark:bg-blue-900/50', 'dark:text-blue-400');
            }

            // Recipients
            const recipientsContainer = document.getElementById('detailRecipients');
            recipientsContainer.innerHTML = '';
            if (c.destinatarios && c.destinatarios.length > 0) {
                c.destinatarios.forEach(dest => {
                    const avatar = getAvatarHtml(dest);
                    const div = document.createElement('div');
                    div.className = 'inline-flex items-center gap-2 px-2 py-1 rounded-lg text-[10px] font-bold bg-gray-50 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-100 dark:border-gray-600';
                    div.innerHTML = `${avatar} <span class="leading-none">${dest.emple_nombres}</span>`;
                    recipientsContainer.appendChild(div);
                });
            } else {
                recipientsContainer.innerHTML = '<p class="text-gray-400 text-[10px] italic">Sin asignar.</p>';
            }

            // Actions Area
            const actionArea = document.getElementById('detailActionsContainer');
            actionArea.innerHTML = ''; 
            
            if (c.archivo) {
                const btn = document.createElement('a');
                btn.href = `/storage/${c.archivo}`;
                btn.target = '_blank';
                btn.className = 'flex items-center gap-2 px-4 py-2.5 text-[11px] font-bold text-blue-600 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl hover:bg-blue-100 transition-all';
                btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">description</span> Ver Documento Principal';
                actionArea.appendChild(btn);
            }

            // Integrated Traceability
            const radStr = c.radicado || 'SIN RADICADO';
            document.getElementById('detailRadicadoSub').textContent = `Radicado: ${radStr}`;
            const idRad = c.rad_id || c.id_rad || null;
            if (idRad) {
                renderTimelineInto('detailTraceTimeline', idRad, c.tipo_label, radStr, 'detailTraceDownloadBtn');
            } else {
                document.getElementById('detailTraceTimeline').innerHTML = '<p class="text-xs italic text-gray-400">Trazabilidad no disponible.</p>';
            }

            openModal('detailsModal');
        }

        // Generic function to render timeline into a container
        function renderTimelineInto(containerId, id, type, radStr, downloadBtnId = null) {
            const container = document.getElementById(containerId);
            if (downloadBtnId) {
                const btn = document.getElementById(downloadBtnId);
                const isEnv = type === 'SAL' || type === 'INT' || type === 'Saliente';
                btn.href = `{{ url('/ventanilla/trazabilidad') }}/${id}/pdf?tipo=${isEnv ? 'envio' : 'recibido'}`;
            }

            container.innerHTML = '<div class="flex justify-center p-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div></div>';
            
            fetch(`{{ url('/ventanilla/history') }}/${id}?type=${type}`)
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = '';
                    if (!data || data.length === 0) {
                        container.innerHTML = '<div class="flex flex-col items-center py-12 text-gray-400"><span class="material-symbols-outlined text-4xl mb-2">history</span><p class="text-sm italic">No hay historial.</p></div>';
                        return;
                    }

                    data.forEach((item, index) => {
                        const isLast = index === data.length - 1;
                        const dateObj = new Date(item.fecha);
                        const dateStr = dateObj.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                        const timeStr = dateObj.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', hour12: true });

                        let icon = 'info', circleClass = 'bg-blue-100 text-blue-600';
                        if (item.type === 'registry') {
                            icon = 'outgoing_mail'; circleClass = 'bg-primary/10 text-primary';
                        } else {
                            const sid = parseInt(item.id_estado_rec);
                            switch(sid) {
                                case 7: icon = 'inbox'; circleClass = 'bg-orange-100 text-orange-600'; break;
                                case 8: icon = 'pending'; circleClass = 'bg-amber-100 text-amber-600'; break;
                                case 9: case 10: icon = 'check_circle'; circleClass = 'bg-green-100 text-green-600'; break;
                                case 11: icon = 'cancel'; circleClass = 'bg-red-100 text-red-600'; break;
                                case 12: icon = 'send'; circleClass = 'bg-blue-100 text-blue-600'; break;
                                case 14: icon = 'outbox'; circleClass = 'bg-emerald-100 text-emerald-600'; break;
                            }
                        }

                        container.innerHTML += `
                            <div class="flex gap-4 relative">
                                ${!isLast ? `<div class="absolute left-[19px] top-10 bottom-0 w-0.5 bg-gray-100 dark:bg-gray-700/50"></div>` : ''}
                                <div class="relative z-10">
                                    <div class="w-10 h-10 rounded-full ${circleClass} flex items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">${icon}</span>
                                    </div>
                                </div>
                                <div class="flex-1 pb-8 text-left">
                                    <div class="flex flex-col mb-1">
                                        <span class="text-[11px] font-black text-gray-900 dark:text-white uppercase tracking-tight">${item.estado_nomb}</span>
                                        <span class="text-[9px] font-bold text-gray-400">${dateStr} • ${timeStr}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mb-2 p-1.5 bg-gray-50/50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700/50 w-fit">
                                        ${getAvatarHtml({emple_img: item.img, emple_nombres: item.nombres, emple_apellidos: item.apellidos})}
                                        <p class="text-[10px] text-gray-800 dark:text-gray-200 font-bold pr-2">${item.nombres}</p>
                                    </div>
                                    ${item.observaciones ? `<div class="p-3 bg-white dark:bg-gray-800 border-l-2 border-primary/20 rounded-r-xl shadow-sm"><p class="text-[11px] text-gray-600 dark:text-gray-400 italic">"${item.observaciones}"</p></div>` : ''}
                                </div>
                            </div>
                        `;
                    });
                })
                .catch(e => {
                    console.error(e);
                    container.innerHTML = '<p class="text-xs text-red-500">Error.</p>';
                });
        }

        // History Timeline Logic
        function showHistory(id, radTextStr, tipoCor) {
            renderTimelineInto('historyTimeline', id, tipoCor, radTextStr, 'btnDownloadTrazabilidad');
            document.getElementById('historyRadText').textContent = `Radicado: ${radTextStr}`;
            openModal('historyModal');
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
        document.getElementById('tableSearch')?.addEventListener('input', function(e) {
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
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`finalize-form-${id}`).submit();
                }
            });
        }

        // SweetAlert for Reject Confirmation
        document.getElementById('rejectForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: '¿Confirmar rechazo?',
                text: "Se notificará al remitente por correo electrónico con el motivo proporcionado. ¿Está seguro de continuar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    container: 'font-display',
                    popup: 'rounded-3xl border-none shadow-2xl dark:bg-gray-800 dark:text-white',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
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

        async function openSalienteModal(id, radText = '') {
            const c = window.correspondenceData[id];
            if (!c) return;

            // Optional: You can use radText here if needed instead of c.radicado

            // Find response data
            const responseDetail = c.detalles.find(d => d.archivo_res);
            const responseAnnexes = c.detalles.flatMap(d => d.anexos_respuesta || []);

            document.getElementById('salienteForm').action = `/ventanilla/${id}/store-saliente`;
            document.getElementById('salienteAsunto').value = 'Rpta: ' + c.asunto;
            document.getElementById('salienteFolio').value = c.folio || 0;
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

                // Start page counting
                const folioInput = document.getElementById('salienteFolio');
                folioInput.value = '...';
                folioInput.readOnly = true;

                let totalPages = 0;
                try {
                    // Count main document
                    if (responseDetail.archivo_res && responseDetail.archivo_res.toLowerCase().endsWith('.pdf')) {
                        const loadingTask = pdfjsLib.getDocument(`/storage/${responseDetail.archivo_res}`);
                        const pdf = await loadingTask.promise;
                        totalPages += pdf.numPages;
                    } else if (responseDetail.archivo_res) {
                        totalPages += 1;
                    }

                    // Count annexes
                    for (const anexo of responseAnnexes) {
                        if (anexo.ruta_archivo && anexo.ruta_archivo.toLowerCase().endsWith('.pdf')) {
                            try {
                                const loadingTask = pdfjsLib.getDocument(`/storage/${anexo.ruta_archivo}`);
                                const pdf = await loadingTask.promise;
                                totalPages += pdf.numPages;
                            } catch (annexError) {
                                console.error('Error counting annex PDF:', annexError);
                                totalPages += 1;
                            }
                        } else {
                            totalPages += 1;
                        }
                    }
                    folioInput.value = totalPages > 0 ? totalPages : 1;
                } catch (error) {
                    console.error('Error counting PDF pages:', error);
                    folioInput.value = 1;
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
                if (emailContainer) emailContainer.classList.remove('hidden');
            } else {
                emailInput.value = '';
                if (emailContainer) emailContainer.classList.add('hidden');
            }

            // Clear observaciones
            document.getElementById('salienteObservaciones').value = '';

            openModal('salienteModal');
        }

        async function openSalienteModalEnvio(id) {
            const envio = window.enviosPendientesData[id];
            if (!envio) return;

            document.getElementById('salienteForm').action = `/ventanilla/envio/${id}/store-saliente`;
            document.getElementById('salienteAsunto').value = envio.asunto;
            document.getElementById('salienteDestino').value = envio.destino && envio.destino !== 'Ventanilla' ? envio
                .destino : '';

            // Pre-fill fields
            const typeSelect = document.getElementById('salienteTipo');
            if (envio.id_tipo_envio) typeSelect.value = envio.id_tipo_envio;

            const officialSelect = document.getElementById('salienteFuncionario');
            officialSelect.value = envio.doc_quien_envia || '';

            // File Preview Section
            const previewContainer = document.getElementById('salienteFilePreview');
            previewContainer.innerHTML = '';

            if (envio.archivo) {
                const mainFileDiv = document.createElement('div');
                mainFileDiv.className =
                    'flex items-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl mb-2 group cursor-pointer hover:bg-emerald-100 transition-all';
                mainFileDiv.onclick = () => window.open(`/storage/${envio.archivo}`, '_blank');
                mainFileDiv.innerHTML = `
                    <span class="material-symbols-outlined text-emerald-600">description</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-bold text-emerald-900 dark:text-emerald-100 truncate">Documento a Enviar</p>
                        <p class="text-[9px] text-emerald-600 font-medium">Click para ver documento</p>
                    </div>
                    <span class="material-symbols-outlined text-emerald-400 text-sm group-hover:translate-x-0.5 transition-transform">open_in_new</span>
                `;
                previewContainer.appendChild(mainFileDiv);
            }

            // Render Annexes
            const anexos = envio.anexos || [];
            if (anexos.length > 0) {
                const annexGrid = document.createElement('div');
                annexGrid.className = 'grid grid-cols-1 gap-2';
                anexos.forEach((anexo, idx) => {
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

            const folioInput = document.getElementById('salienteFolio');
            folioInput.value = envio.folio || 1;
            folioInput.readOnly = true;

            const originalRecibido = envio.radicado && envio.radicado.recibido ? envio.radicado.recibido : null;
            const emailInput = document.getElementById('salienteEmailNotif');
            const emailContainer = document.getElementById('emailNotifContainer');
            
            if (originalRecibido && originalRecibido.correo_persona) {
                emailInput.value = originalRecibido.correo_persona;
                if (emailContainer) emailContainer.classList.remove('hidden');
            } else {
                emailInput.value = '';
                if (emailContainer) emailContainer.classList.add('hidden');
            }
            document.getElementById('salienteObservaciones').value = '';

            openModal('salienteModal');
        }

        function openRejectModal(id, radText = '') {
            const c = window.correspondenceData[id];
            if (!c) return;

            document.getElementById('rejectRadText').textContent =
                `Radicado: ${radText || 'SIN RADICADO'}`;
            document.getElementById('rejectForm').action = `{{ url('/ventanilla/externarec') }}/${id}/rechazar`;
            document.getElementById('rejectObs').value = '';

            openModal('rejectModal');
        }
    </script>
@endsection

@section('modals')
    @include('remitente.partials.modal_recibido')

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

    <!-- Assign Modal -->
    <div id="assignModal" class="fixed inset-0 z-[60] hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 w-full relative">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('assignModal')"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all font-display my-auto">
                <form id="assignForm" method="POST">
                    @csrf
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Asignar Correspondencia</h3>
                            <p id="assignRadText" class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Radicado: ---</p>
                        </div>
                        <button type="button" onclick="closeModal('assignModal')" class="p-2 text-gray-400 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl hover:bg-blue-50 hover:text-blue-500 transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                    
                    <div class="flex-1 p-8 overflow-y-auto custom-scrollbar space-y-6">
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl text-blue-800 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-200 text-xs flex items-start gap-3">
                            <span class="material-symbols-outlined shrink-0" style="font-size: 20px;">info</span>
                            <p>Seleccione uno o más funcionarios para asignar esta correspondencia. Ellos recibirán una notificación y podrán iniciar la gestión del radicado.</p>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Buscar Destinatarios</label>
                                <span id="selectedCount" class="px-2 py-0.5 bg-blue-600 text-white text-[9px] font-black rounded-full hidden">0 Seleccionados</span>
                            </div>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">search</span>
                                </span>
                                <input type="text" id="assignSearch" placeholder="Nombre, área o documento..." class="w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none dark:text-white">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Lista de Funcionarios</label>
                            <div id="assignList" class="grid grid-cols-1 gap-2 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach ($todosDestinatarios as $dest)
                                    <label class="flex items-center gap-4 p-3.5 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-blue-300 dark:hover:border-blue-800 hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-all group relative overflow-hidden" data-name="{{ strtolower($dest['emple_nombres'] . ' ' . $dest['emple_apellidos']) }}" data-area="{{ strtolower($dest['area_nombre'] ?? '') }}" data-doc="{{ $dest['emple_doc'] }}">
                                        <input type="checkbox" name="destinatarios[]" value="{{ $dest['emple_doc'] }}" class="assign-checkbox w-5 h-5 rounded-lg border-gray-200 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate group-hover:text-blue-600 transition-colors">{{ $dest['emple_nombres'] }} {{ $dest['emple_apellidos'] }}</p>
                                            <p class="text-[10px] text-gray-500 font-medium uppercase tracking-tight">{{ $dest['area_nombre'] ?? 'Sin Área' }}</p>
                                        </div>
                                        <span class="material-symbols-outlined text-gray-300 dark:text-gray-700 transition-all group-hover:scale-110 opacity-0 group-hover:opacity-100">check_circle</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1 mb-2 block">Instrucciones de Asignación (Opcional)</label>
                            <textarea name="observaciones" rows="3" placeholder="Indique alguna instrucción específica para la gestión..." class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none dark:text-white resize-none"></textarea>
                        </div>
                    </div>

                    <div class="px-8 py-5 bg-gray-50 dark:bg-gray-900/40 border-t border-gray-100 dark:border-gray-700 flex gap-3 shrink-0 rounded-b-3xl">
                        <button type="button" onclick="closeModal('assignModal')" class="flex-1 px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition-all">Cancelar</button>
                        <button type="submit" class="flex-[2] flex items-center justify-center gap-2 px-6 py-3 text-xs font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 dark:shadow-none active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[18px]">person_add</span>
                            Asignar Correspondencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Saliente Modal (Respuesta) -->
    <div id="salienteModal" class="fixed inset-0 z-[60] hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen w-full p-4 relative">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('salienteModal')"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-hidden transform transition-all font-display flex flex-col my-auto z-10">
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
                    <button onclick="closeModal('salienteModal')" class="p-2 text-gray-400 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl hover:bg-emerald-50 hover:text-emerald-500 transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">close</span>
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
                                <select name="id_tipo_envio" id="salienteTipo" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white appearance-none">
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
                            <select name="doc_quien_envia" id="salienteFuncionario" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white appearance-none">
                                <option value="">Seleccionar...</option>
                                {{-- Add the current Remitente (Ventanilla) --}}
                                <option value="{{ auth()->guard('remitente')->user()->rem_doc }}">
                                    {{ auth()->guard('remitente')->user()->rem_nombres }} {{ auth()->guard('remitente')->user()->rem_apellidos }} (Ventanilla)
                                </option>
                                @foreach ($empleados as $e)
                                    @if($e->emple_doc != auth()->guard('remitente')->user()->rem_doc)
                                        <option value="{{ $e->emple_doc }}">{{ $e->emple_nombres }} {{ $e->emple_apellidos }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Correo Electrónico (Notificación)</label>
                            <input type="email" name="correo" id="salienteCorreo" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white" placeholder="usuario@ejemplo.com">
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
@endsection


@section('scripts')
    <script>
        // Store IDs to avoid duplicates if data overlaps
        window.correspondenceData = {};
        @foreach($correspondenciaNueva as $c)
            window.correspondenceData['{{ $c->id }}'] = @json($c);
        @endforeach

        // 1. Details & History
        async function viewDetails(id, typeLabel) {
            const c = window.correspondenceData[id];
            if (!c) return;

            document.getElementById('detailRadicadoHeader').textContent = `Detalles de la Correspondencia (${typeLabel})`;
            document.getElementById('detailRadicadoSub').textContent = `Radicado: ${c.radicado || 'S/R'}`;
            document.getElementById('detailRadicado').textContent = c.radicado || 'SIN RADICADO';
            
            const statusEl = document.getElementById('detailStatus');
            statusEl.textContent = c.estado;
            statusEl.className = 'px-3 py-1 rounded-full text-[10px] font-bold ' + getStatusClasses(c.id_estado);

            document.getElementById('detailDate').textContent = c.fecha ? new Date(c.fecha).toLocaleString() : '---';
            document.getElementById('detailType').textContent = typeLabel || 'Estandar';
            document.getElementById('detailFolios').textContent = c.folios || '0';
            document.getElementById('detailAsunto').textContent = c.asunto || 'Sin Asunto';
            document.getElementById('detailInstitution').textContent = c.contacto || 'Externo';
            document.getElementById('detailCity').textContent = c.ciudad || '';
            document.getElementById('detailObservations').textContent = c.observaciones || 'Sin observaciones adicionales.';

            const recipientsContainer = document.getElementById('detailRecipients');
            recipientsContainer.innerHTML = '';
            if (c.destinatarios && c.destinatarios.length > 0) {
                c.destinatarios.forEach(d => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-2 p-1.5 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-100 dark:border-gray-600';
                    div.innerHTML = `
                        <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[8px] font-bold">
                            ${d.emple_nombres[0]}${d.emple_apellidos[0]}
                        </div>
                        <span class="text-[9px] font-bold text-gray-700 dark:text-gray-300">${d.emple_nombres}</span>
                    `;
                    recipientsContainer.appendChild(div);
                });
            } else {
                recipientsContainer.innerHTML = '<span class="text-gray-400 text-[10px] italic">Sin asignar</span>';
            }

            const actionsContainer = document.getElementById('detailActionsContainer');
            actionsContainer.innerHTML = '';
            if (c.archivo) {
                const fileName = c.archivo.split('/').pop();
                actionsContainer.innerHTML += `
                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm group hover:border-blue-200 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-sm">description</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Documento Principal</p>
                                <p class="text-xs font-bold text-gray-700 dark:text-gray-300 truncate max-w-[200px]">${fileName}</p>
                            </div>
                        </div>
                        <a href="/storage/${c.archivo}" target="_blank" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                            <span class="material-symbols-outlined">open_in_new</span>
                        </a>
                    </div>
                `;
            }

            renderTimelineInto('detailTraceTimeline', c.id_original, c.radicado, 'detailTraceDownloadBtn');
            openModal('detailsModal');
        }

        async function renderTimelineInto(containerId, resourceId, radicado, downloadBtnId = null) {
            const container = document.getElementById(containerId);
            if (!container) return;

            container.innerHTML = `<div class="flex flex-col items-center justify-center py-12 gap-3 text-gray-400"><div class="w-8 h-8 border-4 border-blue-100 border-t-blue-600 rounded-full animate-spin"></div><p class="text-[10px] font-black uppercase tracking-widest">Cargando...</p></div>`;

            if (downloadBtnId) {
                document.getElementById(downloadBtnId).href = `{{ url('/ventanilla/trazabilidad') }}/${resourceId}/pdf?tipo=recibido`;
            }

            try {
                const response = await fetch(`{{ url('/ventanilla/history') }}/${resourceId}`);
                const history = await response.json();

                if (!history || history.length === 0) {
                    container.innerHTML = `<p class="text-xs text-gray-400 text-center py-8">No hay registros.</p>`;
                    return;
                }

                container.innerHTML = '<div class="relative pl-6 border-l-2 border-gray-100 dark:border-gray-700 ml-3 space-y-8"></div>';
                const timelineItems = container.querySelector('div');

                history.forEach((step, index) => {
                    const isLast = index === history.length - 1;
                    const dateObj = new Date(step.fecha);
                    const dateStr = dateObj.toLocaleDateString('es-ES', { day: '2-digit', month: 'short' });
                    const timeStr = dateObj.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

                    const item = document.createElement('div');
                    item.className = 'relative';
                    item.innerHTML = `
                        <div class="absolute -left-[33px] top-0 w-4 h-4 rounded-full border-4 border-white dark:border-gray-800 ${isLast ? 'bg-blue-600 ring-4 ring-blue-100 dark:ring-blue-900/30' : 'bg-gray-300'}"></div>
                        <div class="flex flex-col gap-1 text-left">
                            <span class="px-2 py-0.5 w-fit rounded-md bg-gray-100 dark:bg-gray-700 text-[9px] font-black uppercase text-gray-500">${step.estado_nomb}</span>
                            <p class="text-[11px] font-bold text-gray-900 dark:text-gray-100 mt-1">${step.nombres} ${step.apellidos}</p>
                            <p class="text-[10px] text-gray-500 italic">${step.observaciones || 'Sin detalles'}</p>
                            <span class="text-[9px] text-gray-400 mt-1">${dateStr} • ${timeStr}</span>
                        </div>
                    `;
                    timelineItems.appendChild(item);
                });
            } catch (error) {
                container.innerHTML = `<p class="text-xs text-red-500">Error.</p>`;
            }
        }

        function getAvatarHtml(step) {
            if (step.img) { return `<img src="/storage/${step.img}" class="w-6 h-6 rounded-lg object-cover">`; }
            const initials = (step.nombres[0] || '') + (step.apellidos[0] || '');
            return `<div class="w-6 h-6 rounded-lg bg-indigo-500 text-white flex items-center justify-center text-[8px] font-black border border-indigo-600 shadow-sm">${initials}</div>`;
        }

        function getStatusClasses(id_estado) {
            const s = { '9': 'bg-emerald-100 text-emerald-700', '10': 'bg-emerald-100 text-emerald-700', '11': 'bg-red-100 text-red-700', '12': 'bg-blue-100 text-blue-700', '7': 'bg-indigo-100 text-indigo-700', '8': 'bg-amber-100 text-amber-700' };
            return s[id_estado] || 'bg-gray-100 text-gray-700';
        }

        async function showHistory(radIdInt, radText, type) {
            document.getElementById('historyRadText').textContent = 'Radicado: ' + (radText || '---');
            document.getElementById('btnDownloadTrazabilidad').href = `{{ url('/ventanilla/trazabilidad') }}/${radIdInt}/pdf?tipo=${type === 'INT' ? 'envio' : 'recibido'}`;
            await renderTimelineInto('historyTimeline', radIdInt, radText);
            openModal('historyModal');
        }

        // 2. Modals Actions
        function openAssignModal(id, radicado) {
            document.getElementById('assignRadText').textContent = 'Radicado: ' + radicado;
            document.getElementById('assignForm').action = `{{ url('/ventanilla/externarec') }}/${id}/asignar`;
            document.querySelectorAll('.assign-checkbox').forEach(cb => cb.checked = false);
            updateSelectedCount();
            openModal('assignModal');
        }

        function openRejectModal(id, radicado) {
            document.getElementById('rejectRadText').textContent = 'Radicado: ' + radicado;
            document.getElementById('rejectForm').action = `{{ url('/ventanilla/externarec') }}/${id}/rechazar`;
            document.getElementById('rejectObs').value = '';
            openModal('rejectModal');
        }

        function openSalienteModal(id) {
            let c = null;
            for (let k in window.correspondenceData) {
                if (window.correspondenceData[k].id_original == id) {
                    c = window.correspondenceData[k];
                    break;
                }
            }
            if (!c) return;

            let actionUrl = `{{ url('/ventanilla') }}/${c.id_original}/store-saliente`;
            if (c.tipo_label === 'SAL') {
                actionUrl = `{{ url('/ventanilla') }}/envio/${c.id_original}/store-saliente`;
            }

            document.getElementById('salienteForm').action = actionUrl;
            document.getElementById('salienteDestino').value = c.contacto || '';
            document.getElementById('salienteAsunto').value = (c.tipo_label === 'SAL' ? '' : 'R: ') + c.asunto;
            document.getElementById('salienteFolio').value = c.folios || 1;
            document.getElementById('salienteCorreo').value = c.correo || '';
            
            const submitBtn = document.querySelector('#salienteForm button[type="submit"]');
            if (submitBtn) {
                if (c.tipo_label === 'SAL') {
                    submitBtn.innerHTML = `<span class="material-symbols-outlined text-[18px]">send</span> Despachar Correspondencia`;
                    submitBtn.className = submitBtn.className.replace('bg-emerald-600', 'bg-blue-600').replace('hover:bg-emerald-700', 'hover:bg-blue-700');
                } else {
                    submitBtn.innerHTML = `<span class="material-symbols-outlined text-[18px]">done_all</span> Registrar Envío Saliente`;
                    submitBtn.className = submitBtn.className.replace('bg-blue-600', 'bg-emerald-600').replace('hover:bg-blue-700', 'hover:bg-emerald-700');
                }
            }
            
            // Auto-fill Type and Official
            const typeSelect = document.getElementById('salienteTipo');
            if (typeSelect && c.id_tipo) typeSelect.value = c.id_tipo;
            
            const officialSelect = document.getElementById('salienteFuncionario');
            if (officialSelect) {
                const currentRemDoc = "{{ auth()->guard('remitente')->user()->rem_doc }}";
                officialSelect.value = currentRemDoc;
            }

            document.getElementById('salienteFilePreview').innerHTML = c.archivo ? `<div class='p-3 bg-emerald-50 rounded-2xl flex items-center gap-3'><span class='material-symbols-outlined text-emerald-600'>description</span><p class='text-xs font-bold text-emerald-900'>Documento Principal</p></div>` : '';
            openModal('salienteModal');
        }

        function openEditModalById(id) {
            let item = null;
            for (let k in window.correspondenceData) { if (window.correspondenceData[k].id_original == id) { item = window.correspondenceData[k]; break; } }
            if (!item) return;

            document.getElementById('editForm').action = `{{ url('/remitente') }}/${id}/update-rejected`;
            document.getElementById('editAsunto').value = item.asunto;
            document.getElementById('editObs').value = '';
            document.querySelectorAll('.recipient-checkbox').forEach(cb => cb.checked = false);

            if (item.destinatarios && item.destinatarios.length > 0) {
                const ids = item.destinatarios.map(d => String(d.emple_doc));
                document.querySelectorAll('.recipient-checkbox').forEach(cb => { if (ids.includes(String(cb.value))) cb.checked = true; });
            }
            openModal('editModal');
        }

        async function confirmFinalize(id) {
            if (confirm('¿Estás seguro de que deseas marcar esta correspondencia como FINALIZADA?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('/remitente') }}/${id}/finalize`;
                form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">`;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // 3. Utils
        function setupRecipientSearch() {
            const assignSearch = document.getElementById('assignSearch');
            if (assignSearch) {
                assignSearch.addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase();
                    document.querySelectorAll('#assignList label').forEach(item => {
                        item.style.display = item.innerText.toLowerCase().includes(term) ? 'flex' : 'none';
                    });
                });
            }
            const editSearch = document.getElementById('recipientSearch');
            if (editSearch) {
                editSearch.addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase();
                    document.querySelectorAll('.recipient-item').forEach(item => {
                        const txt = (item.dataset.name || '') + (item.dataset.area || '') + (item.dataset.doc || '');
                        item.style.display = txt.toLowerCase().includes(term) ? 'flex' : 'none';
                    });
                });
            }
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('assign-checkbox')) updateSelectedCount();
            });
        }

        function updateSelectedCount() {
            const count = document.querySelectorAll('.assign-checkbox:checked').length;
            const badge = document.getElementById('selectedCount');
            if (badge) { badge.textContent = `${count} Seleccionados`; badge.classList.toggle('hidden', count === 0); }
        }

        window.viewDetails = viewDetails;
        window.showHistory = showHistory;
        window.openAssignModal = openAssignModal;
        window.openRejectModal = openRejectModal;
        window.openSalienteModal = openSalienteModal;
        window.openEditModalById = openEditModalById;
        window.confirmFinalize = confirmFinalize;

        document.addEventListener('DOMContentLoaded', setupRecipientSearch);
    </script>
@endsection
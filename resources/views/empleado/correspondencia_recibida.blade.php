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
    </div>

    <!-- Tabs -->
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="correspondenciaTabs" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg border-primary text-primary dark:border-blue-500 dark:text-blue-500 transition-colors" id="externa-tab" type="button" role="tab" onclick="switchTab('externa')">Bandeja Externa</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:text-gray-400 text-gray-500 transition-colors" id="interna-tab" type="button" role="tab" onclick="switchTab('interna')">Bandeja Interna</button>
            </li>
        </ul>
    </div>

    <div id="tabContent">
        <!-- ================= EXTERNA TAB ================= -->
        <div id="externa" role="tabpanel">
    <!-- Stats Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined">inbox</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Recibidas</p>
                <p class="text-2xl font-bold dark:text-white">{{ $totalRecibidas }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                <span class="material-symbols-outlined">hourglass_empty</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">En Trámite</p>
                <p class="text-2xl font-bold dark:text-white">{{ $enTramite }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Finalizadas</p>
                <p class="text-2xl font-bold dark:text-white">{{ $finalizadas }}</p>
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
                        <th class="px-6 py-3 font-medium">Radicados</th>
                        <th class="px-6 py-3 font-medium">Procedencia</th>
                        <th class="px-6 py-3 font-medium">Detalles Documento</th>
                        <th class="px-6 py-3 font-medium">Ingreso / Registro</th>
                        <th class="px-6 py-3 font-medium">Archivos / Anexos</th>
                        <th class="px-6 py-3 font-medium">Observaciones</th>
                        <th class="px-6 py-3 font-medium">Estado</th>
                        <th class="px-6 py-3 font-medium text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @php 
                        $radicadosProcesadosExterna = []; 
                    @endphp
                    @forelse($correspondencias as $item)
                        @php
                            // Check if this is the latest row for this radicado
                            $isLatestExterna = false;
                            $radicadoStr = $item->radicado ? $item->radicado->num_radicado : $item->id_recibido;
                            if (!in_array($radicadoStr, $radicadosProcesadosExterna)) {
                                $isLatestExterna = true;
                                $radicadosProcesadosExterna[] = $radicadoStr;
                            }
                            // Also lock if state is Rechazado
                            $estadoNombL = strtolower($item->estado ? $item->estado->estado_nomb : '');
                            $isRechazado = str_contains($estadoNombL, 'rechazado');
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top">
                            <!-- Radicados -->
                            <td class="px-6 py-4">
                                <div class="font-medium text-primary dark:text-blue-400" title="Radicado Interno">
                                    {{ $item->radicado ? $item->radicado->num_radicado : 'S/R' }}
                                </div>
                                @if($item->num_radicado_ext)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1" title="Radicado Externo">
                                    EXT: {{ $item->num_radicado_ext }}
                                </div>
                                @endif
                            </td>
                            
                            <!-- Procedencia -->
                            <td class="px-6 py-4">
                                <div class="font-medium dark:text-white max-w-[180px] break-words whitespace-normal">{{ $item->nom_institucion }}</div>
                                @if($item->ciudad)
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    {{ $item->ciudad->ciudad_nom ?? 'Desconocida' }}
                                </div>
                                @endif
                            </td>
                            
                            <!-- Detalles Documento -->
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium text-gray-900 dark:text-gray-100 mb-1 max-w-[200px] whitespace-normal break-words" title="{{ $item->asunto }}">
                                    {{ $item->asunto }}
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    <span class="flex items-center gap-1" title="Tipo Documento">
                                        <span class="material-symbols-outlined text-[14px]">description</span>
                                        {{ $item->tipo ? $item->tipo->tipo_nombre : 'N/A' }}
                                    </span>
                                    <span class="flex items-center gap-1" title="Folios">
                                        <span class="material-symbols-outlined text-[14px]">layers</span>
                                        Folios: {{ $item->folio ?? 0 }}
                                    </span>
                                </div>
                            </td>
                            
                            <!-- Ingreso / Registro -->
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $item->fecha_hora_recib ? \Carbon\Carbon::parse($item->fecha_hora_recib)->format('d M Y') : 'N/A' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                                    {{ $item->fecha_hora_recib ? \Carbon\Carbon::parse($item->fecha_hora_recib)->format('h:i A') : '' }}
                                </div>
                                @if($item->registradoPor)
                                <div class="text-xs text-gray-600 dark:text-gray-300 flex items-center gap-1 mt-2" title="Registrado por (Remitente)">
                                    <span class="material-symbols-outlined text-[14px]">person</span>
                                    Remitente: {{ $item->registradoPor->rem_nombres }} {{ $item->registradoPor->rem_apellidos }}
                                </div>
                                @endif
                                @if($item->dirigidoA)
                                <div class="text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1 mt-1" title="Dirigido a">
                                    <span class="material-symbols-outlined text-[14px]">forward_to_inbox</span>
                                    Para: {{ $item->dirigidoA->emple_nombres }} {{ $item->dirigidoA->emple_apellidos }}
                                </div>
                                @endif
                            </td>
                            
                            <!-- Archivos / Anexos -->
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col gap-2">
                                    @if($item->archivo)
                                        <a href="{{ asset('storage/' . $item->archivo) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-400 dark:hover:bg-blue-900/50 rounded-md transition-colors w-fit" title="Ver Documento Principal">
                                            <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span>
                                            Principal
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">Sin principal</span>
                                    @endif
                                    
                                    @if($item->anexos && $item->anexos->count() > 0)
                                        <div class="mt-2 flex flex-col gap-1.5">
                                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Anexos:</span>
                                            @foreach($item->anexos as $anexoItem)
                                                <a href="{{ asset('storage/' . $anexoItem->ruta_archivo) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-medium text-gray-700 bg-gray-100 border border-gray-200 hover:bg-gray-200 rounded-md transition-colors w-fit" title="{{ $anexoItem->nombre_original }}">
                                                    <span class="material-symbols-outlined text-[14px]">attachment</span> 
                                                    {{ Str::limit($anexoItem->nombre_original, 15) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @elseif($item->anexo)
                                        <div class="mt-1 text-xs text-gray-600 dark:text-gray-400 max-w-[180px] whitespace-normal break-words">
                                            <span class="font-semibold text-gray-700 dark:text-gray-300">Anexo (Texto):</span> 
                                            {{ $item->anexo }}
                                        </div>
                                    @endif
                                    @if($item->folio > 0)
                                        <div class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                            <span class="font-semibold text-gray-700 dark:text-gray-300">Folios:</span> {{ $item->folio }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Observaciones -->
                            <td class="px-6 py-4 text-sm max-w-[200px] align-top">
                                @if($item->observaciones && strtoupper($item->observaciones) !== 'NINGUNO' && strtoupper($item->observaciones) !== 'NINGUNA')
                                    <div class="whitespace-normal text-xs text-gray-600 dark:text-gray-400 italic border-l-2 border-yellow-400 dark:border-yellow-600 pl-2">
                                        {{ $item->observaciones }}
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            
                            <!-- Estado -->
                            <td class="px-6 py-4">
                                @php
                                    $estadoNomb = $item->estado ? strtolower($item->estado->estado_nomb) : '';
                                    $bgClass = 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
                                    if(str_contains($estadoNomb, 'recibido')) {
                                        $bgClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400';
                                    } elseif(str_contains($estadoNomb, 'tramite') || str_contains($estadoNomb, 'trámite')) {
                                        $bgClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                                    } elseif(str_contains($estadoNomb, 'finalizado') || str_contains($estadoNomb, 'resuelto')) {
                                        $bgClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgClass }}">
                                    {{ $item->estado ? $item->estado->estado_nomb : 'Sin estado' }}
                                </span>
                            </td>
                            
                            <!-- Acciones -->
                            <td class="px-6 py-4 text-right">
                                <button title="Ver y añadir seguimiento" onclick="toggleModal('modalSeguimiento')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                    <span class="material-symbols-outlined text-xl">timeline</span>
                                </button>
                                
                                @if(in_array($item->id_estado_rec, [9, 10]) || $isRechazado || !$isLatestExterna)
                                    <button title="Registro Bloqueado (Solo Lectura)" class="text-gray-300 dark:text-gray-600 p-1 cursor-not-allowed">
                                        <span class="material-symbols-outlined text-xl">lock</span>
                                    </button>
                                @else
                                    <button title="Actualizar estado" onclick="openEstadoModal({{ $item->id_recibido }}, '{{ $item->estado ? $item->estado->estado_nomb : '' }}', '{{ $item->radicado ? $item->radicado->num_radicado : '' }}', 'externa')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                        <span class="material-symbols-outlined text-xl">edit_document</span>
                                    </button>
                                    <button title="Reasignar a otro empleado" onclick="openReasignarModal({{ $item->id_recibido }}, '{{ $item->radicado ? $item->radicado->num_radicado : '' }}')" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                        <span class="material-symbols-outlined text-xl">forward</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2 text-gray-400">inbox</span>
                                <p>No hay correspondencias recibidas registradas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex flex-col md:flex-row items-center justify-between text-sm text-gray-500 dark:text-gray-400">
            <div class="mb-4 md:mb-0">
                Mostrando {{ $correspondencias->firstItem() ?? 0 }} a {{ $correspondencias->lastItem() ?? 0 }} de {{ $correspondencias->total() }} correspondencias
            </div>
            <div class="w-full md:w-auto">
                {{ $correspondencias->appends(['int_page' => request('int_page')])->links() }}
            </div>
        </div>

    </div>
        </div>

        <!-- ================= INTERNA TAB ================= -->
        <div id="interna" class="hidden" role="tabpanel">
            <!-- Stats Boxes Interna -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined">inbox</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Internas</p>
                        <p class="text-2xl font-bold dark:text-white">{{ $totalInternas }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                        <span class="material-symbols-outlined">hourglass_empty</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">En Trámite</p>
                        <p class="text-2xl font-bold dark:text-white">{{ $enTramiteInt }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Finalizadas</p>
                        <p class="text-2xl font-bold dark:text-white">{{ $finalizadasInt }}</p>
                    </div>
                </div>
            </div>

            <!-- Table Interna -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
                    <h2 class="font-bold text-gray-800 dark:text-white">Correspondencia Interna</h2>
                    <button onclick="toggleModal('modalNuevaInterna')" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        Nueva Interna
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 font-medium">Radicados</th>
                                <th class="px-6 py-3 font-medium">Remitente Interno</th>
                                <th class="px-6 py-3 font-medium">Detalles Documento</th>
                                <th class="px-6 py-3 font-medium">Observaciones</th>
                                <th class="px-6 py-3 font-medium">Fecha Traslado</th>
                                <th class="px-6 py-3 font-medium">Archivos<br>Principal</th>
                                <th class="px-6 py-3 font-medium">Anexos y Folios</th>
                                <th class="px-6 py-3 font-medium">Estado</th>
                                <th class="px-6 py-3 font-medium text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @php 
                        $radicadosProcesadosInterna = []; 
                    @endphp
                    @forelse($correspondenciasInternas as $int)
                        @php
                            // Check if this is the latest row for this internal radicado
                            $isLatestInterna = false;
                            $radicadoIntStr = $int->envio && $int->envio->radicado ? $int->envio->radicado->num_radicado : $int->id_envio;
                            if (!in_array($radicadoIntStr, $radicadosProcesadosInterna)) {
                                $isLatestInterna = true;
                                $radicadosProcesadosInterna[] = $radicadoIntStr;
                            }
                            // Also lock if state is Rechazado
                            $estadoNombIntL = strtolower($int->estado ? $int->estado->estado_nomb : '');
                            $isRechazadoInt = str_contains($estadoNombIntL, 'rechazado');
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top">
                                    <td class="px-6 py-4 font-medium text-primary dark:text-blue-400">
                                        {{ $int->envio->radicado->num_radicado ?? 'INT-N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium dark:text-white">
                                            {{ $int->quienEnvia ? $int->quienEnvia->emple_nombres . ' ' . $int->quienEnvia->emple_apellidos : 'Desconocido' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm max-w-[200px] whitespace-normal break-words">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 mb-1">{{ $int->envio->asunto ?? 'Sin Asunto' }}</div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                            <span class="material-symbols-outlined text-[14px]">description</span> 
                                            {{ $int->envio->tipoEnvio ? $int->envio->tipoEnvio->tipo_nombre : 'Interno' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($int->observaciones)
                                            <button onclick="openObservacionModal('{{ addslashes($int->observaciones) }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-purple-700 bg-purple-50 border border-purple-200 hover:bg-purple-100 rounded-md transition-colors w-fit">
                                                <span class="material-symbols-outlined text-[16px]">visibility</span> Ver Nota
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Sin observaciones</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $int->fecha_traslado ? \Carbon\Carbon::parse($int->fecha_traslado)->format('d M Y') : 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            {{ $int->fecha_traslado ? \Carbon\Carbon::parse($int->fecha_traslado)->format('h:i A') : '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="flex flex-col gap-2">
                                            @if($int->envio && $int->envio->archivo)
                                                <a href="{{ asset('storage/' . $int->envio->archivo) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-md transition-colors w-fit">
                                                    <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span> Principal
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Sin principal</span>
                                            @endif
                                            @if($int->archivo_respuesta)
                                                <a href="{{ asset('storage/' . $int->archivo_respuesta) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-green-700 bg-green-50 border border-green-200 hover:bg-green-100 rounded-md transition-colors w-fit" title="Respuesta adjuntada">
                                                    <span class="material-symbols-outlined text-[16px]">attachment</span> Respuesta
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Nueva Columna: Anexos y Folios Separados -->
                                    <td class="px-6 py-4 align-top">
                                        <div class="flex flex-col gap-3">
                                            <!-- Sección Envío Original -->
                                            <div class="bg-gray-50 dark:bg-slate-800/80 p-2 rounded border border-gray-100 dark:border-gray-700">
                                                <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Del Envío:</div>
                                                
                                                @if($int->envio && $int->envio->anexos && $int->envio->anexos->count() > 0)
                                                    <div class="flex flex-col gap-1.5 mb-2">
                                                        @foreach($int->envio->anexos as $anexoItem)
                                                            <a href="{{ asset('storage/' . $anexoItem->ruta_archivo) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-medium text-gray-700 bg-white border border-gray-200 hover:bg-gray-100 rounded-md transition-colors w-fit dark:bg-slate-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-slate-600" title="{{ $anexoItem->nombre_original }}">
                                                                <span class="material-symbols-outlined text-[14px] text-gray-500">attachment</span> 
                                                                {{ Str::limit($anexoItem->nombre_original, 15) }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @elseif($int->envio && $int->envio->anexo)
                                                    <div class="mt-1 text-xs text-gray-600 max-w-[150px] whitespace-normal break-words dark:text-gray-400 mb-2">
                                                        {{ $int->envio->anexo }}
                                                    </div>
                                                @else
                                                    <span class="text-xs text-gray-400 italic mb-2 block">Sin anexos</span>
                                                @endif

                                                @if($int->envio && $int->envio->folio > 0)
                                                    <div class="text-[11px] text-gray-600 dark:text-gray-400">
                                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Folios:</span> {{ $int->envio->folio }}
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Sección Respuesta (Solo mostrar si hay) -->
                                            @if(($int->anexosRespuesta && $int->anexosRespuesta->count() > 0) || $int->folios_respuesta > 0)
                                                <div class="bg-green-50/50 dark:bg-green-900/10 p-2 rounded border border-green-100 dark:border-green-800/50">
                                                    <div class="text-[11px] font-bold text-green-600 dark:text-green-500 uppercase tracking-wider mb-1">De la Respuesta:</div>
                                                    
                                                    @if($int->anexosRespuesta && $int->anexosRespuesta->count() > 0)
                                                        <div class="flex flex-col gap-1.5 mb-2">
                                                            @foreach($int->anexosRespuesta as $respAnexoItem)
                                                                <a href="{{ asset('storage/' . $respAnexoItem->ruta_archivo) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-medium text-green-800 bg-white border border-green-200 hover:bg-green-100 rounded-md transition-colors w-fit dark:bg-green-800/40 dark:text-green-300 dark:border-green-700/50 dark:hover:bg-green-800/60" title="{{ $respAnexoItem->nombre_original }}">
                                                                    <span class="material-symbols-outlined text-[14px]">attachment</span> 
                                                                    {{ Str::limit($respAnexoItem->nombre_original, 15) }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @if($int->folios_respuesta > 0)
                                                        <div class="text-[11px] text-green-700 dark:text-green-400">
                                                            <span class="font-semibold text-green-800 dark:text-green-300">Folios:</span> {{ $int->folios_respuesta }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $estadoNomb = $int->estado ? strtolower($int->estado->estado_nomb) : '';
                                            $bgClass = 'bg-gray-100 text-gray-800';
                                            if(str_contains($estadoNomb, 'recibido')) $bgClass = 'bg-blue-100 text-blue-800';
                                            elseif(str_contains($estadoNomb, 'tramite') || str_contains($estadoNomb, 'trámite')) $bgClass = 'bg-yellow-100 text-yellow-800';
                                            elseif(str_contains($estadoNomb, 'finalizado') || str_contains($estadoNomb, 'resuelto')) $bgClass = 'bg-green-100 text-green-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgClass }}">
                                            {{ $int->estado ? $int->estado->estado_nomb : 'Sin estado' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(in_array($int->id_estado_rec, [9, 10]) || $isRechazadoInt || !$isLatestInterna)
                                            <button title="Registro Bloqueado (Solo Lectura)" class="text-gray-300 dark:text-gray-600 p-1 cursor-not-allowed">
                                                <span class="material-symbols-outlined text-xl">lock</span>
                                            </button>
                                        @else
                                            <button title="Actualizar estado" onclick="openEstadoModal({{ $int->id_detalle }}, '{{ $int->estado ? $int->estado->estado_nomb : '' }}', '{{ $int->envio->radicado->num_radicado ?? '' }}', 'interna')" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-blue-400 p-1">
                                                <span class="material-symbols-outlined text-xl">edit_document</span>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <span class="material-symbols-outlined text-4xl mb-2 text-gray-400">inbox</span>
                                        <p>No hay correspondencias internas registradas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex flex-col md:flex-row items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div class="mb-4 md:mb-0">
                        Mostrando {{ $correspondenciasInternas->firstItem() ?? 0 }} a {{ $correspondenciasInternas->lastItem() ?? 0 }} de {{ $correspondenciasInternas->total() }} correspondencias
                    </div>
                    <div class="w-full md:w-auto">
                        {{ $correspondenciasInternas->appends(['ext_page' => request('ext_page')])->links() }}
                    </div>
                </div>
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
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-lg dark:text-white" id="modalEstadoTitle">Actualizar Estado</h3>
            <button onclick="toggleModal('modalEstado')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form id="formUpdateEstado" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <!-- Hidden input to know which pagination page to return to -->
            <input type="hidden" name="int_page" id="intPageInput" value="1">

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado Actual</label>
                    <input type="text" id="estado_actual_input" readonly class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-slate-800 dark:text-gray-500 py-2 px-3 text-sm cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nuevo Estado <span class="text-red-500">*</span></label>
                    <select name="estado_nomb" id="estadoSelectOptions" required onchange="toggleArchivoRespuesta()" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50">
                        <option value="">Seleccione el nuevo estado...</option>
                        <option value="En Tramite">En Trámite</option>
                        <option value="Resuelto">Finalizado / Resuelto</option>
                        <option value="Rechazado">Rechazado</option>
                        <!-- Add more states strictly matching those in the database -->
                    </select>
                </div>
                
                <div id="archivoRespuestaContainer" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Archivo de Respuesta (Opcional, Solo PDF)</label>
                    <input type="file" name="archivo_respuesta" accept=".pdf" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 file:cursor-pointer cursor-pointer border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 mb-4">

                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anexos de Respuesta (Opcional, Múltiples PDFs)</label>
                    
                    <!-- Custom Multiple File Upload Area for Respuestas -->
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors cursor-pointer relative" onclick="document.getElementById('archivos_respuesta_input').click()">
                        <span class="material-symbols-outlined text-gray-400 text-3xl mb-2">upload_file</span>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Clic aquí para añadir anexos (PDF)</p>
                        <p class="text-xs text-gray-500 mt-1">Puedes agregar varios archivos uno por uno sin usar la tecla Ctrl.</p>
                        <!-- Actual Hidden Input -->
                        <input type="file" id="archivos_respuesta_input" name="archivos_respuesta[]" multiple accept=".pdf" class="hidden" onchange="handleFileSelect(event, 'respuestasList', 'archivos_respuesta_input')">
                    </div>
                    
                    <!-- Container for Selected Files Pills -->
                    <div id="respuestasList" class="mt-3 flex flex-wrap gap-2 empty:hidden"></div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Folios de la Respuesta (Opcional, Número)</label>
                        <input type="number" name="folios_respuesta" min="0" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-green-600/50 focus:border-green-600 transition-colors" placeholder="Ej: 5">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Comentario / Observación</label>
                    <textarea name="observaciones" rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50" placeholder="Escriba los detalles de este cambio de estado (ej: Se turnó para revisión)"></textarea>
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-slate-800/50">
                <button type="button" onclick="toggleModal('modalEstado')" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-blue-700 transition-colors">
                    Guardar Actualización
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reasignar Radicado -->
<div id="modalReasignar" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl w-full max-w-md overflow-hidden flex flex-col">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-lg dark:text-white" id="modalReasignarTitle">Reasignar Radicado</h3>
            <button onclick="toggleModal('modalReasignar')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form id="formReasignar" method="POST" action="">
            @csrf
            <div class="p-6 space-y-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 p-3 rounded-lg text-sm border border-blue-200 dark:border-blue-800">
                    <span class="material-symbols-outlined align-middle mr-1" style="font-size: 18px;">info</span>
                    Al reasignar este documento, se enviará a la bandeja del empleado seleccionado y desaparecerá de tu lista de pendientes.
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Empleado Destino <span class="text-red-500">*</span></label>
                    <select name="doc_quien_dirige" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50">
                        <option value="">Seleccione a quién reasignar...</option>
                        @foreach($empleados ?? [] as $emp)
                            @if($emp->emple_doc != Auth::user()->emple_doc)
                                <option value="{{ $emp->emple_doc }}">{{ $emp->emple_nombres }} {{ $emp->emple_apellidos }} ({{ $emp->area->area_nom ?? 'Sin Área' }})</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivo de la Reasignación <span class="text-red-500">*</span></label>
                    <textarea name="observaciones" required rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50" placeholder="Escriba el motivo por el cual reasigna este documento..."></textarea>
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-slate-800/50">
                <button type="button" onclick="toggleModal('modalReasignar')" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">forward</span>
                    Confirmar Reasignación
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Nueva Correspondencia Interna -->
<div id="modalNuevaInterna" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl w-full max-w-2xl overflow-hidden flex flex-col my-8">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-lg text-gray-800 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary dark:text-blue-400">edit_square</span>
                Redactar Correspondencia Interna
            </h3>
            <button onclick="toggleModal('modalNuevaInterna')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors p-1 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-700">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form action="{{ route('empleado.nueva_interna') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-5">
                <!-- Destinatario -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Para (Destinatario) <span class="text-red-500">*</span></label>
                    <select name="doc_quien_dirigido" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                        <option value="">Seleccione el destinatario interno...</option>
                        @foreach($empleados ?? [] as $emp)
                            @if($emp->emple_doc != Auth::user()->emple_doc)
                                <option value="{{ $emp->emple_doc }}">{{ $emp->emple_nombres }} {{ $emp->emple_apellidos }} ({{ $emp->area->area_nom ?? 'Sin Área' }})</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Asunto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asunto <span class="text-red-500">*</span></label>
                        <input type="text" name="asunto" required placeholder="Ej. Solicitud de Viáticos" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                    </div>

                    <!-- Tipo de Documento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Documento <span class="text-red-500">*</span></label>
                        <select name="id_tipo_envio" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                            <option value="">Seleccione el tipo...</option>
                            @foreach($tipos ?? [] as $tipo)
                                <option value="{{ $tipo->id_tipo }}">{{ $tipo->tipo_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Archivo y Anexos -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-4 bg-gray-50 dark:bg-slate-800/30 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento Principal (PDF, JPG, PNG)</label>
                        <input type="file" name="archivo" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tamaño máximo: 5MB</p>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anexos (PDFs Opcionales)</label>
                        
                        <!-- Custom Multiple File Upload Area for Nuevos Anexos -->
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 text-center hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors cursor-pointer relative" onclick="document.getElementById('anexos_nuevos_input').click()">
                            <span class="material-symbols-outlined text-gray-400 text-2xl mb-1">note_add</span>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Clic aquí para añadir PDFs</p>
                            <!-- Actual Hidden Input -->
                            <input type="file" id="anexos_nuevos_input" name="anexos[]" multiple accept=".pdf" class="hidden" onchange="handleFileSelect(event, 'anexosNuevosList', 'anexos_nuevos_input')">
                        </div>
                        
                        <!-- Container for Selected Files Pills -->
                        <div id="anexosNuevosList" class="mt-2 flex flex-wrap gap-2 empty:hidden"></div>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Folios</label>
                        <input type="number" name="folio" min="0" placeholder="Ej. 3" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                    </div>
                </div>

                <!-- Mensaje/Observaciones -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cuerpo del Mensaje / Observaciones</label>
                    <textarea name="observaciones" rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" placeholder="Escriba aquí los detalles de su correspondencia interna..."></textarea>
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-slate-800/50">
                <button type="button" onclick="toggleModal('modalNuevaInterna')" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    Enviar Correspondencia
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ver Observación -->
<div id="modalVerObservacion" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl w-full max-w-lg overflow-hidden flex flex-col">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-purple-50 dark:bg-purple-900/20">
            <h3 class="font-bold text-lg text-purple-800 dark:text-purple-300 flex items-center gap-2">
                <span class="material-symbols-outlined">message</span>
                Observaciones del Remitente
            </h3>
            <button onclick="toggleModal('modalVerObservacion')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6">
            <div id="contenidoObservacion" class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed bg-gray-50 dark:bg-slate-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                <!-- Content injected via JS -->
            </div>
        </div>

        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end bg-gray-50 dark:bg-slate-800/50">
            <button onclick="toggleModal('modalVerObservacion')" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors shadow-sm">
                Cerrar
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

    function switchTab(tab) {
        const extBtn = document.getElementById('externa-tab');
        const intBtn = document.getElementById('interna-tab');
        const extContent = document.getElementById('externa');
        const intContent = document.getElementById('interna');

        const activeClasses = ['border-primary', 'text-primary', 'dark:border-blue-500', 'dark:text-blue-500'];
        const inactiveClasses = ['border-transparent', 'text-gray-500', 'dark:text-gray-400'];

        if (tab === 'externa') {
            extContent.classList.remove('hidden');
            intContent.classList.add('hidden');
            
            extBtn.classList.add(...activeClasses);
            extBtn.classList.remove(...inactiveClasses);
            
            intBtn.classList.add(...inactiveClasses);
            intBtn.classList.remove(...activeClasses);
        } else {
            intContent.classList.remove('hidden');
            extContent.classList.add('hidden');
            
            intBtn.classList.add(...activeClasses);
            intBtn.classList.remove(...inactiveClasses);
            
            extBtn.classList.add(...inactiveClasses);
            extBtn.classList.remove(...activeClasses);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('int_page')) {
            switchTab('interna');
        }
    });

    let currentModalType = '';

    function openEstadoModal(id, estadoActual, radicado, tipo) {
        document.getElementById('modalEstadoTitle').innerText = 'Actualizar Radicado ' + (radicado || '');
        document.getElementById('estado_actual_input').value = estadoActual || 'Sin Estado';
        
        const form = document.getElementById('formUpdateEstado');
        const fileContainer = document.getElementById('archivoRespuestaContainer');
        
        // Grab current pagination page from URL if exists
        const urlParams = new URLSearchParams(window.location.search);
        let intPage = urlParams.get('int_page') || 1;
        
        const intPageInput = document.getElementById('intPageInput');
        if (intPageInput) {
            intPageInput.value = intPage;
        }

        if (tipo === 'externa') {
            form.action = `/empleado/correspondencia-recibida/${id}/estado`;
            if (fileContainer) fileContainer.classList.add('hidden'); // Solo para externa
        } else {
            form.action = `/empleado/correspondencia-interna/${id}/estado`;
            // It will be hidden initially, and toggleArchivoRespuesta will handle showing it if Resuelto is selected
            if (fileContainer) fileContainer.classList.add('hidden'); 
        }
        
        // Reset the select so it doesn't accidentally keep purely visual form states
        const stateSelect = document.getElementById('estadoSelectOptions');
        if(stateSelect) stateSelect.value = "";
        
        currentModalType = tipo;
        
        toggleModal('modalEstado');
    }

    function openReasignarModal(id, radicado) {
        document.getElementById('modalReasignarTitle').innerText = 'Reasignar Radicado ' + (radicado || '');
        const form = document.getElementById('formReasignar');
        form.action = `/empleado/correspondencia-recibida/${id}/reasignar`;
        toggleModal('modalReasignar');
    }

    function openObservacionModal(texto) {
        document.getElementById('contenidoObservacion').innerText = texto;
        toggleModal('modalVerObservacion');
    }

    function toggleArchivoRespuesta() {
        const select = document.getElementById('estadoSelectOptions');
        const fileContainer = document.getElementById('archivoRespuestaContainer');
        const formAction = document.getElementById('formUpdateEstado').action;
        
        // Only toggle for internal correspondence forms when changing state
        if (formAction.includes('interna')) {
            if (select.value === 'Resuelto') {
                fileContainer.classList.remove('hidden');
            } else {
                fileContainer.classList.add('hidden');
                
                // Clear the main answer file
                const fileInputMain = fileContainer.querySelector('input[name="archivo_respuesta"]');
                if(fileInputMain) fileInputMain.value = '';
                
                // Clear custom anexos responses
                clearCustomFileInput('archivos_respuesta_input', 'respuestasList');
            }
        }
    }

    // ==========================================
    // CUSTOM MULTIPLE FILE UPLOAD LOGIC
    // ==========================================
    
    // Dictionary to store the selected files for each input ID
    const customFilesState = {
        'archivos_respuesta_input': new DataTransfer(),
        'anexos_nuevos_input': new DataTransfer()
    };

    function handleFileSelect(event, listContainerId, inputId) {
        const input = event.target;
        const newFiles = input.files;
        const dt = customFilesState[inputId];
        
        // Loop through selected files and add them to our DataTransfer object
        for (let i = 0; i < newFiles.length; i++) {
            // Prevent duplicate files by checking name & size
            let isDuplicate = false;
            for (let j = 0; j < dt.items.length; j++) {
                if (dt.items[j].getAsFile().name === newFiles[i].name && dt.items[j].getAsFile().size === newFiles[i].size) {
                    isDuplicate = true;
                    break;
                }
            }
            
            if (!isDuplicate) {
                dt.items.add(newFiles[i]);
            }
        }
        
        // Sync the true input with our accumulated files
        input.files = dt.files;
        
        // Render the UI
        renderFilePills(inputId, listContainerId);
    }

    function removeFile(inputId, listContainerId, fileName, fileSize) {
        const input = document.getElementById(inputId);
        const dt = customFilesState[inputId];
        const newDt = new DataTransfer();
        
        for (let i = 0; i < dt.items.length; i++) {
            const file = dt.items[i].getAsFile();
            if (file.name !== fileName || file.size !== fileSize) {
                newDt.items.add(file);
            }
        }
        
        // Update our state
        customFilesState[inputId] = newDt;
        // Sync with actual input
        input.files = newDt.files;
        
        // Render UI
        renderFilePills(inputId, listContainerId);
    }

    function renderFilePills(inputId, listContainerId) {
        const container = document.getElementById(listContainerId);
        const dt = customFilesState[inputId];
        
        container.innerHTML = '';
        
        for (let i = 0; i < dt.items.length; i++) {
            const file = dt.items[i].getAsFile();
            
            // Truncate name for display
            let display = file.name;
            if (display.length > 20) {
                display = display.substring(0, 15) + '...' + display.substring(display.lastIndexOf('.'));
            }
            
            const pill = document.createElement('div');
            pill.className = 'flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 px-2 py-1 rounded text-xs font-medium dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800';
            
            pill.innerHTML = `
                <span class="material-symbols-outlined text-[14px]">description</span>
                <span title="${file.name}">${display}</span>
                <button type="button" class="text-blue-500 hover:text-red-500 hover:bg-red-50 rounded-full w-4 h-4 flex items-center justify-center transition-colors ml-1 focus:outline-none" onclick="event.stopPropagation(); removeFile('${inputId}', '${listContainerId}', '${file.name}', ${file.size})">
                    <span class="material-symbols-outlined text-[12px]">close</span>
                </button>
            `;
            
            container.appendChild(pill);
        }
    }
    
    function clearCustomFileInput(inputId, listContainerId) {
        customFilesState[inputId] = new DataTransfer();
        const input = document.getElementById(inputId);
        if(input) input.files = customFilesState[inputId].files;
        const container = document.getElementById(listContainerId);
        if(container) container.innerHTML = '';
    }
</script>
@endsection

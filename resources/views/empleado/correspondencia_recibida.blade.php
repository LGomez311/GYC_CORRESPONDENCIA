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
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
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
            <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400">
                <span class="material-symbols-outlined">folder</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Archivadas</p>
                <p class="text-2xl font-bold dark:text-white">{{ $archivadas }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                <span class="material-symbols-outlined">error</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Vencidas / Alerta</p>
                <p class="text-2xl font-bold dark:text-white">{{ $vencidas }}</p>
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
            <table class="w-full text-left text-sm">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 font-medium">Radicados</th>
                        <th class="px-6 py-3 font-medium">Procedencia</th>
                        <th class="px-6 py-3 font-medium">Detalles Documento</th>
                        <th class="px-6 py-3 font-medium hidden lg:table-cell">Ingreso / Registro</th>
                        <th class="px-6 py-3 font-medium">Archivos / Anexos</th>
                        <th class="px-6 py-3 font-medium hidden md:table-cell">Observaciones</th>
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
                                <div class="flex flex-col gap-1.5 text-xs mt-2">
                                    <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1" title="Tipo Documento">
                                            <span class="material-symbols-outlined text-[14px]">description</span>
                                            {{ $item->tipo ? $item->tipo->tipo_nombre : 'N/A' }}
                                        </span>
                                        <span class="flex items-center gap-1" title="Folios">
                                            <span class="material-symbols-outlined text-[14px]">layers</span>
                                            Folios: {{ $item->folio ?? 0 }}
                                        </span>
                                    </div>
                                    @if($item->tipo)
                                        <div class="flex flex-col gap-1 mt-0.5">
                                            <!-- Prioridad Info -->
                                            <span class="flex items-center gap-1 {{ ($item->tipo->id_prioridad == 3) ? 'text-red-600 dark:text-red-400 font-medium' : (($item->tipo->id_prioridad == 2) ? 'text-yellow-600 dark:text-yellow-400 font-medium' : 'text-green-600 dark:text-green-400') }}" title="Prioridad">
                                                <span class="material-symbols-outlined text-[14px]">flag</span>
                                                Prioridad: {{ $item->tipo->prioridad->prioridad_nombre ?? 'N/A' }}
                                            </span>
                                            
                                            <!-- Días de Respuesta de la DB -->
                                            <span class="flex items-center gap-1 text-gray-500 dark:text-gray-400" title="Días Asignados">
                                                <span class="material-symbols-outlined text-[14px]">event_note</span>
                                                Días de Respuesta: {{ $item->tipo->dias_respuesta ?? 'N/A' }}
                                            </span>
                                            
                                            <!-- Cálculo Días Restantes -->
                                            @php
                                                $fechaBase = \Carbon\Carbon::parse($item->fecha_hora_recib);
                                                $hoy = \Carbon\Carbon::now();
                                                
                                                // Calcular días hábiles transcurridos (Lunes a Viernes)
                                                $diasTranscurridos = $fechaBase->diffInDaysFiltered(function(\Carbon\Carbon $date) {
                                                    return $date->isWeekday();
                                                }, $hoy);
                                                
                                                $diasTotales = $item->tipo->dias_respuesta ?? 15;
                                                $diasRestantes = $diasTotales - $diasTranscurridos;
                                                
                                                // Colores según días restantes
                                                $diasClass = 'text-green-600 dark:text-green-400 font-medium'; // Tiempo de sobra
                                                $iconoDias = 'schedule';
                                                
                                                if ($diasRestantes < 0) {
                                                    $diasClass = 'text-red-600 dark:text-red-400 font-bold'; // Vencido
                                                    $iconoDias = 'warning';
                                                } elseif ($diasRestantes <= 2) {
                                                    $diasClass = 'text-yellow-600 dark:text-yellow-400 font-bold'; // Por vencer
                                                    $iconoDias = 'hourglass_empty';
                                                }
                                            @endphp
                                            <span class="flex items-center gap-1 {{ $diasClass }} mt-0.5" title="Días Hábiles Restantes">
                                                <span class="material-symbols-outlined text-[14px]">{{ $iconoDias }}</span>
                                                @if($diasRestantes < 0)
                                                    ¡Vencido por {{ abs($diasRestantes) }} días!
                                                @else
                                                    Quedan: {{ $diasRestantes }} días hábiles
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Ingreso / Registro -->
                            <td class="px-6 py-4 hidden lg:table-cell">
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
                                @if($item->destinatarios && $item->destinatarios->count() > 0)
                                <div class="text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1 mt-1" title="Dirigido a">
                                    <span class="material-symbols-outlined text-[14px]">forward_to_inbox</span>
                                    Para: {{ $item->destinatarios->first()->emple_nombres }} {{ $item->destinatarios->first()->emple_apellidos }}
                                </div>
                                @endif
                            </td>
                            
                            <!-- Archivos / Anexos -->
                            <td class="px-6 py-4 align-top">
                                @php
                                    $archivosDatos = [
                                        'principal' => $item->archivo ? asset('storage/' . $item->archivo) : null,
                                        'anexos' => [],
                                        'anexo_texto' => $item->anexo,
                                        'folios' => $item->folio,
                                        'respuesta_principal' => null,
                                        'respuestas_anexos' => [],
                                        'folios_respuesta' => 0
                                    ];
                                    if($item->anexos) {
                                        foreach($item->anexos as $ax) {
                                            $archivosDatos['anexos'][] = [
                                                'nombre' => $ax->nombre_original,
                                                'ruta' => asset('storage/' . $ax->ruta_archivo)
                                            ];
                                        }
                                    }
                                @endphp
                                <button type="button" data-archivos="{{ json_encode($archivosDatos) }}" onclick="abrirModalArchivos(this.dataset.archivos)" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-400 dark:hover:bg-blue-900/50 rounded-md transition-colors w-full max-w-[140px] justify-center shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">folder_open</span>
                                    Ver Documentos
                                </button>
                            </td>

                            <!-- Observaciones -->
                            <td class="px-6 py-4 text-sm max-w-[200px] align-top hidden md:table-cell">
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
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
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
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined">folder</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Archivadas</p>
                        <p class="text-2xl font-bold dark:text-white">{{ $archivadasInt }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined">error</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Vencidas / Alerta</p>
                        <p class="text-2xl font-bold dark:text-white">{{ $vencidasInt }}</p>
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
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 font-medium">Radicados</th>
                                <th class="px-6 py-3 font-medium">Remitente Interno</th>
                                <th class="px-6 py-3 font-medium">Detalles Documento</th>
                                <th class="px-6 py-3 font-medium hidden lg:table-cell">Observaciones</th>
                                <th class="px-6 py-3 font-medium hidden md:table-cell">Fecha Traslado</th>
                                <th class="px-6 py-3 font-medium">Documentos <br> y Anexos</th>
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
                                        @if($int->quienEnvia && $int->quienEnvia->area)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                <strong class="font-bold text-gray-700 dark:text-gray-300">Área:</strong> {{ $int->quienEnvia->area->area_nom ?? 'Desconocida' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm max-w-[200px] whitespace-normal break-words">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 mb-1">{{ $int->envio->asunto ?? 'Sin Asunto' }}</div>
                                        
                                        <div class="flex flex-col gap-1.5 text-xs mt-2">
                                            <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center gap-1" title="Tipo Documento">
                                                    <span class="material-symbols-outlined text-[14px]">description</span> 
                                                    {{ $int->envio->tipoEnvio ? $int->envio->tipoEnvio->tipo_nombre : 'Interno' }}
                                                </span>
                                            </div>
                                            
                                            @if($int->envio->tipoEnvio)
                                                <div class="flex flex-col gap-1 mt-0.5">
                                                    <!-- Prioridad Info -->
                                                    <span class="flex items-center gap-1 {{ ($int->envio->tipoEnvio->id_prioridad == 3) ? 'text-red-600 dark:text-red-400 font-medium' : (($int->envio->tipoEnvio->id_prioridad == 2) ? 'text-yellow-600 dark:text-yellow-400 font-medium' : 'text-green-600 dark:text-green-400') }}" title="Prioridad">
                                                        <span class="material-symbols-outlined text-[14px]">flag</span>
                                                        Prioridad: {{ $int->envio->tipoEnvio->prioridad->prioridad_nombre ?? 'N/A' }}
                                                    </span>

                                                    <!-- Días de Respuesta de la DB -->
                                                    <span class="flex items-center gap-1 text-gray-500 dark:text-gray-400" title="Días Asignados">
                                                        <span class="material-symbols-outlined text-[14px]">event_note</span>
                                                        Días de Respuesta: {{ $int->envio->tipoEnvio->dias_respuesta ?? 'N/A' }}
                                                    </span>
                                                    
                                                    <!-- Días de Respuesta -->
                                                    @php
                                                        // Usamos la fecha de traslado (cuando el remitente interno lo pasó al empleado actual)
                                                        $fechaBaseInt = \Carbon\Carbon::parse($int->fecha_traslado ?? $int->envio->fecha);
                                                        $hoyInt = \Carbon\Carbon::now();
                                                        
                                                        // Calcular días hábiles transcurridos (Lunes a Viernes)
                                                        $diasTranscurridosInt = $fechaBaseInt->diffInDaysFiltered(function(\Carbon\Carbon $date) {
                                                            return $date->isWeekday();
                                                        }, $hoyInt);
                                                        
                                                        $diasTotalesInt = $int->envio->tipoEnvio->dias_respuesta ?? 15;
                                                        $diasRestantesInt = $diasTotalesInt - $diasTranscurridosInt;
                                                        
                                                        // Colores según días restantes
                                                        $diasClassInt = 'text-green-600 dark:text-green-400 font-medium'; // Tiempo de sobra
                                                        $iconoDiasInt = 'schedule';
                                                        
                                                        if ($diasRestantesInt < 0) {
                                                            $diasClassInt = 'text-red-600 dark:text-red-400 font-bold'; // Vencido
                                                            $iconoDiasInt = 'warning';
                                                        } elseif ($diasRestantesInt <= 2) {
                                                            $diasClassInt = 'text-yellow-600 dark:text-yellow-400 font-bold'; // Por vencer
                                                            $iconoDiasInt = 'hourglass_empty';
                                                        }
                                                    @endphp
                                                    <span class="flex items-center gap-1 {{ $diasClassInt }} mt-0.5" title="Días Hábiles Restantes">
                                                        <span class="material-symbols-outlined text-[14px]">{{ $iconoDiasInt }}</span>
                                                        @if($diasRestantesInt < 0)
                                                            ¡Vencido por {{ abs($diasRestantesInt) }} d!
                                                        @else
                                                            Quedan {{ $diasRestantesInt }} días hábiles
                                                        @endif
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        @if($int->observaciones)
                                            <button onclick="openObservacionModal('{{ addslashes($int->observaciones) }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-purple-700 bg-purple-50 border border-purple-200 hover:bg-purple-100 rounded-md transition-colors w-fit">
                                                <span class="material-symbols-outlined text-[16px]">visibility</span> Ver Nota
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Sin observaciones</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $int->fecha_traslado ? \Carbon\Carbon::parse($int->fecha_traslado)->format('d M Y') : 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            {{ $int->fecha_traslado ? \Carbon\Carbon::parse($int->fecha_traslado)->format('h:i A') : '' }}
                                        </div>
                                    </td>
                                    <!-- Documentos y Anexos -->
                                    <td class="px-6 py-4 align-top">
                                        @php
                                            $archivosDatos = [
                                                'principal' => ($int->envio && $int->envio->archivo) ? asset('storage/' . $int->envio->archivo) : null,
                                                'anexos' => [],
                                                'anexo_texto' => ($int->envio && $int->envio->anexo) ? $int->envio->anexo : null,
                                                'folios' => ($int->envio && $int->envio->folio) ? $int->envio->folio : 0,
                                                'respuesta_principal' => $int->archivo_respuesta ? asset('storage/' . $int->archivo_respuesta) : null,
                                                'respuestas_anexos' => [],
                                                'folios_respuesta' => $int->folios_respuesta ?? 0
                                            ];
                                            if($int->envio && $int->envio->anexos) {
                                                foreach($int->envio->anexos as $ax) {
                                                    $archivosDatos['anexos'][] = [
                                                        'nombre' => $ax->nombre_original,
                                                        'ruta' => asset('storage/' . $ax->ruta_archivo)
                                                    ];
                                                }
                                            }
                                            if($int->anexosRespuesta) {
                                                foreach($int->anexosRespuesta as $axUrl) {
                                                    $archivosDatos['respuestas_anexos'][] = [
                                                        'nombre' => $axUrl->nombre_original,
                                                        'ruta' => asset('storage/' . $axUrl->ruta_archivo)
                                                    ];
                                                }
                                            }
                                        @endphp
                                        <button type="button" data-archivos="{{ json_encode($archivosDatos) }}" onclick="abrirModalArchivos(this.dataset.archivos)" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/40 dark:border-blue-800 dark:text-blue-400 dark:hover:bg-blue-900/60 rounded-md transition-colors shadow-sm w-full max-w-[140px] justify-center">
                                            <span class="material-symbols-outlined text-[16px]">folder_open</span>
                                            Ver Documentos
                                        </button>
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
<div id="modalEstado" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 w-full h-full">
    <div class="bg-white dark:bg-slate-900 rounded-[1rem] shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-md flex flex-col max-h-[90vh] overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50 shrink-0">
            <h3 class="font-bold text-lg dark:text-white" id="modalEstadoTitle">Actualizar Estado</h3>
            <button onclick="toggleModal('modalEstado')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form id="formUpdateEstado" method="POST" action="" enctype="multipart/form-data" class="flex flex-col overflow-hidden">
            @csrf
            <!-- Hidden input to know which pagination page to return to -->
            <input type="hidden" name="int_page" id="intPageInput" value="1">

            <div class="p-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado Actual</label>
                    <input type="text" id="estado_actual_input" readonly class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-slate-800 dark:text-gray-500 py-2 px-3 text-sm cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nuevo Estado <span class="text-red-500">*</span></label>
                    <select name="estado_nomb" id="estadoSelectOptions" required onchange="toggleArchivoRespuesta()" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50">
                        <option value="">Seleccione el nuevo estado...</option>
                        <!-- Options injected via JS based on current state -->
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

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-slate-800/50 shrink-0 border-b-[1rem]">
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
    <div class="bg-white dark:bg-slate-900 rounded-[1rem] shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-md overflow-hidden flex flex-col">
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

<!-- Modal Ver Archivos -->
<div id="modalArchivos" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto w-full h-full">
    <div class="bg-white dark:bg-slate-900 rounded-[1rem] shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-2xl flex flex-col max-h-[90vh] overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50 shrink-0">
            <h3 class="font-bold text-lg text-gray-800 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">folder_open</span>
                Documentos y Anexos
            </h3>
            <button onclick="toggleModal('modalArchivos')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors p-1 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-700">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6 space-y-6 overflow-y-auto flex-1" id="modalArchivosContent">
            <!-- Content will be injected by JS -->
        </div>

        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end bg-gray-50 dark:bg-slate-800/50 shrink-0">
            <button type="button" onclick="toggleModal('modalArchivos')" class="px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-white rounded-lg text-sm hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                Cerrar
            </button>
        </div>
    </div>
</div>

<!-- Modal Nueva Correspondencia Interna -->
<div id="modalNuevaInterna" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 w-full h-full">
    <div class="bg-white dark:bg-slate-900 rounded-[1rem] shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-2xl flex flex-col max-h-[90vh] overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50 shrink-0">
            <h3 class="font-bold text-lg text-gray-800 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary dark:text-blue-400">edit_square</span>
                Redactar Correspondencia Interna
            </h3>
            <button onclick="toggleModal('modalNuevaInterna')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors p-1 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-700">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form action="{{ route('empleado.nueva_interna') }}" method="POST" enctype="multipart/form-data" class="flex flex-col overflow-hidden">
            @csrf
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <!-- Destinatario (Rich Dropdown Selector) -->
                <div class="relative" id="destiniesDropdownContainer">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Para (Destinatario/s) <span class="text-red-500">*</span></label>
                    
                    <!-- Faux Input Box containing Pills and the actual Search Input -->
                    <div id="fauxInputContainer" class="flex flex-wrap items-center gap-1.5 w-full min-h-[42px] px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-slate-900 focus-within:ring-2 focus-within:ring-primary/50 cursor-text transition-all" onclick="abrirDropdownDestinatarios()">
                        
                        <!-- Actual Search Input -->
                        <input type="text" id="busquedaDestinatarios" placeholder="Buscar empleado o área..." 
                            class="flex-1 min-w-[120px] bg-transparent border-none p-0 focus:ring-0 text-sm dark:text-white dark:placeholder-gray-400 m-0"
                            autocomplete="off"
                            onkeyup="filtrarDestinatarios()" onfocus="abrirDropdownDestinatarios()">
                    </div>

                    <!-- Dropdown List of Available Users (Hidden by default, positioned absolutely or relative below) -->
                    <div id="dropdownDestinatariosList" class="hidden absolute z-10 w-full mt-1 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-800 shadow-lg max-h-60 overflow-y-auto">
                        
                        <!-- Select All Visible Button -->
                        <div id="selectAllContainer" class="sticky top-0 bg-white dark:bg-slate-800 p-2 border-b border-gray-100 dark:border-gray-700 z-10 flex justify-between items-center">
                            <span class="text-xs text-gray-500 font-medium">Resultados de búsqueda</span>
                            <button type="button" onclick="seleccionarTodosVisibles()" class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 flex items-center gap-1 bg-blue-50 dark:bg-blue-900/40 hover:bg-blue-100 dark:hover:bg-blue-900/60 px-2 py-1 rounded transition-colors">
                                <span class="material-symbols-outlined text-[14px]">done_all</span>
                                Seleccionar todos los visibles
                            </button>
                        </div>

                        <div id="listaDestinatarios" class="flex flex-col">
                            @foreach($empleados ?? [] as $emp)
                                @if($emp->emple_doc != Auth::user()->emple_doc)
                                    <label class="destinatario-item flex items-center justify-between px-4 py-2 hover:bg-gray-50 dark:hover:bg-slate-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors" data-nombre="{{ strtolower($emp->emple_nombres . ' ' . $emp->emple_apellidos) }}" data-area="{{ strtolower($emp->area->area_nom ?? 'sin área') }}">
                                        <div class="flex items-center gap-3 w-full">
                                            <div class="relative flex items-center justify-center">
                                                <input type="checkbox" name="doc_quien_dirigido[]" value="{{ $emp->emple_doc }}" 
                                                    class="destinatario-checkbox w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2 dark:bg-slate-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                                    onchange="actualizarPillsDestinatarios(this, '{{ addslashes($emp->emple_nombres . ' ' . $emp->emple_apellidos) }}', '{{ $emp->emple_doc }}')">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $emp->emple_nombres }} {{ $emp->emple_apellidos }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[12px]">work</span>
                                                    {{ $emp->area->area_nom ?? 'Sin Área' }}
                                                </span>
                                            </div>
                                        </div>
                                    </label>
                                @endif
                            @endforeach
                            <!-- No results message -->
                            <div id="noDestinatariosMsg" class="hidden px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                No se encontraron destinatarios que coincidan con la búsqueda.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selected Pills Container -->
                <div id="destinatariosSeleccionados" class="flex flex-wrap gap-2 empty:hidden items-center mt-2">
                    <!-- Pills se inyectan acá -->
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Asunto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asunto <span class="text-red-500">*</span></label>
                        <input type="text" name="asunto" required placeholder="Ej. Solicitud de Viáticos" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 dark:text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                    </div>

                    <!-- Tipo de Documento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Documento <span class="text-red-500">*</span></label>
                        <select name="id_tipo_envio" required class="w-full border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 dark:text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                            <option value="">Seleccione el tipo...</option>
                            @foreach($tipos ?? [] as $tipo)
                                <option value="{{ $tipo->id_tipo }}">{{ $tipo->tipo_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Archivo y Anexos -->
                <div class="p-4 bg-gray-50 dark:bg-slate-800/30 rounded-xl border border-gray-200 dark:border-gray-700 space-y-4">
                    <!-- Principal Full Width so it doesn't truncate long names -->
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento Principal (PDF, JPG, PNG)</label>
                        <input type="file" name="archivo" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 transition-colors">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tamaño máximo: 5MB. Este archivo es el oficio principal.</p>
                    </div>

                    <!-- Anexos y Folios Side by Side -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anexos Extras (PDFs)</label>
                            
                            <!-- Custom Multiple File Upload Area for Nuevos Anexos -->
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-3 text-center hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors cursor-pointer relative" onclick="document.getElementById('anexos_nuevos_input').click()">
                                <span class="material-symbols-outlined text-gray-400 text-2xl mb-1">note_add</span>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Clic aquí para añadir PDFs adicionales</p>
                                <!-- Actual Hidden Input -->
                                <input type="file" id="anexos_nuevos_input" name="anexos[]" multiple accept=".pdf" class="hidden" onchange="handleFileSelect(event, 'anexosNuevosList', 'anexos_nuevos_input')">
                            </div>
                            
                            <!-- Container for Selected Files Pills -->
                            <div id="anexosNuevosList" class="mt-2 flex flex-wrap gap-2 empty:hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total de Folios</label>
                            <input type="number" name="folio" min="0" placeholder="Ej. 3" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Mensaje/Observaciones -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cuerpo del Mensaje / Observaciones</label>
                    <textarea name="observaciones" rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 dark:text-white py-2.5 px-3 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" placeholder="Escriba aquí los detalles de su correspondencia interna..."></textarea>
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-slate-800/50 shrink-0 border-b-xl">
                <button type="button" onclick="toggleModal('modalNuevaInterna')" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2 bg-primary text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    Enviar Correspondencia
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ver Observación -->
<div id="modalVerObservacion" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-[1rem] shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-lg overflow-hidden flex flex-col">
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
        
        // Dynamic Dropdown Options Logic based on current state
        const stateSelect = document.getElementById('estadoSelectOptions');
        if(stateSelect) {
            stateSelect.innerHTML = '<option value="">Seleccione el nuevo estado...</option>';
            
            const estActualL = (estadoActual || '').toLowerCase();
            
            // Logica de limitacion de estados segun requerimiento:
            if (estActualL.includes('recibido')) {
                // If current is Recibido, allow En Tramite, Archivado and Rechazado
                stateSelect.innerHTML += `<option value="Archivado">Archivado</option>`;
                stateSelect.innerHTML += `<option value="En Tramite">En Trámite</option>`;
                stateSelect.innerHTML += `<option value="Rechazado">Rechazado</option>`;
            } else if (estActualL.includes('tramite') || estActualL.includes('trámite')) {
                // If current is En Tramite, allow only Resuelto (and maybe Archivado if they change their mind, but per user request Resuelto for now)
                stateSelect.innerHTML += `<option value="Resuelto">Finalizado / Resuelto</option>`;
            } else {
                // Fallback for any other state (like final states that shouldn't be edited anyway, or generic ones)
                // Just keep it empty or add all as fallback if necessary.
                // Assuming finalized states just shouldn't be updated, but we leave it empty.
            }
            
            stateSelect.value = "";
        }
        
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

    // ==========================================
    // CUSTOM RECIPIENT SELECTOR LOGIC (RICH DROPDOWN)
    // ==========================================
    
    function abrirDropdownDestinatarios() {
        const dropdown = document.getElementById('dropdownDestinatariosList');
        const input = document.getElementById('busquedaDestinatarios');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            input.focus();
            // Disparar filtrado inicial (sin texto = mostrar todos)
            filtrarDestinatarios();
        }
    }

    function cerrarDropdownDestinatarios() {
        const dropdown = document.getElementById('dropdownDestinatariosList');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
        }
    }

    // Cerrar al hacer clic fuera
    document.addEventListener('click', function(event) {
        const container = document.getElementById('destiniesDropdownContainer');
        if (container && !container.contains(event.target)) {
            cerrarDropdownDestinatarios();
        }
    });

    function filtrarDestinatarios() {
        const input = document.getElementById('busquedaDestinatarios').value.toLowerCase().trim();
        const items = document.querySelectorAll('.destinatario-item');
        const noMsg = document.getElementById('noDestinatariosMsg');
        const selectAllContainer = document.getElementById('selectAllContainer');
        let visibleCount = 0;

        items.forEach(item => {
            const nombre = item.getAttribute('data-nombre');
            const area = item.getAttribute('data-area');
            
            // Si no hay texto, mostramos todos
            if (input.length === 0 || nombre.includes(input) || area.includes(input)) {
                item.classList.remove('hidden');
                item.classList.add('flex');
                visibleCount++;
            } else {
                item.classList.add('hidden');
                item.classList.remove('flex');
            }
        });

        if (visibleCount === 0 && items.length > 0) {
            noMsg.classList.remove('hidden');
            if (selectAllContainer) selectAllContainer.classList.add('hidden');
        } else {
            noMsg.classList.add('hidden');
            if (selectAllContainer) {
                // If visibleCount is small logic or just always show when items are visible
                selectAllContainer.classList.remove('hidden');
            }
        }
    }

    function seleccionarTodosVisibles() {
        const items = document.querySelectorAll('.destinatario-item.flex'); // Solo los visibles
        
        // Verificar si todos los visibles ya están seleccionados
        let allSelected = true;
        items.forEach(item => {
            const checkbox = item.querySelector('.destinatario-checkbox');
            if (checkbox && !checkbox.checked) {
                allSelected = false;
            }
        });

        // Alternar (toggle) selección
        items.forEach(item => {
            const checkbox = item.querySelector('.destinatario-checkbox');
            if (checkbox) {
                const nombreCompleto = item.querySelector('.text-sm.font-medium').innerText;
                const docId = checkbox.value;
                
                if (allSelected) {
                    // Deseleccionar si ya estaban todos
                    if (checkbox.checked) {
                        checkbox.checked = false;
                        actualizarPillsDestinatarios(checkbox, nombreCompleto, docId);
                    }
                } else {
                    // Seleccionar si faltaba alguno
                    if (!checkbox.checked) {
                        checkbox.checked = true;
                        actualizarPillsDestinatarios(checkbox, nombreCompleto, docId);
                    }
                }
            }
        });
        
        document.getElementById('busquedaDestinatarios').focus();
    }

    function actualizarPillsDestinatarios(checkboxElem, nombreCompleto, docId) {
        const container = document.getElementById('destinatariosSeleccionados');
        const existingPill = document.getElementById(`pill_dest_${docId}`);

        if (checkboxElem.checked) {
            // Add Pill if checked
            if (!existingPill) {
                const pill = document.createElement('div');
                pill.id = `pill_dest_${docId}`;
                pill.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800 transition-all';
                
                pill.innerHTML = `
                    <span class="material-symbols-outlined text-[16px]">person</span>
                    ${nombreCompleto}
                    <button type="button" class="text-blue-600 hover:text-red-500 dark:text-blue-400 dark:hover:text-red-400 ml-1 rounded-full w-4 h-4 flex items-center justify-center transition-colors focus:outline-none focus:ring-2 focus:ring-red-400" onclick="removerSeleccionDestinatario('${docId}')" aria-label="Remover ${nombreCompleto}">
                        <span class="material-symbols-outlined text-[14px]">close</span>
                    </button>
                `;
                container.appendChild(pill);
            }
        } else {
            // Remove Pill if unchecked
            if (existingPill) {
                existingPill.remove();
            }
        }
        
        // Remove empty hidden class validation fix so standard validation handles it
        // Or manually check custom validation if required
        validarDestinatariosMinimos();
    }

    function removerSeleccionDestinatario(docId) {
        // Uncheck the checkbox
        const checkbox = document.querySelector(`.destinatario-checkbox[value="${docId}"]`);
        if (checkbox) {
            checkbox.checked = false;
            // Force change event manual check
            actualizarPillsDestinatarios(checkbox, '', docId);
        }
    }

    function validarDestinatariosMinimos() {
        const checkboxes = document.querySelectorAll('.destinatario-checkbox');
        let checkedCount = 0;
        
        checkboxes.forEach(cb => {
            if (cb.checked) checkedCount++;
        });
        
        // Native HTML5 validation handling across group of checkboxes
        // Setting custom validity on the first visible one
        if (checkboxes.length > 0) {
            const firstCb = checkboxes[0];
            if (checkedCount === 0) {
                firstCb.setCustomValidity("Seleccione al menos un destinatario.");
            } else {
                firstCb.setCustomValidity("");
                // Clear on all just in case
                checkboxes.forEach(cb => cb.setCustomValidity(""));
            }
        }
    }

    // Call validation on modal open to ensure state is clean
    document.addEventListener('DOMContentLoaded', () => {
        // Wait for DOM to load before setting initial validity
        setTimeout(validarDestinatariosMinimos, 500);
    });

    function abrirModalArchivos(datosJson) {
        const datos = JSON.parse(datosJson);
        const container = document.getElementById('modalArchivosContent');
        container.innerHTML = ''; // Clear previous content

        let html = '';

        // SECCIÓN: DEL ENVÍO ORIGINAL
        html += `<div class="bg-gray-50 dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700">`;
        html += `<h4 class="font-bold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">input</span> Envío Original</h4>`;
        
        html += `<div class="flex flex-col gap-3">`;
        // Documento Principal
        if (datos.principal) {
            html += `<div class="flex items-center justify-between bg-white dark:bg-slate-900 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600">picture_as_pdf</span>
                            <span class="text-sm font-medium dark:text-white">Documento Principal</span>
                        </div>
                        <a href="${datos.principal}" target="_blank" class="px-3 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md text-xs font-medium dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors">Ver Archivo</a>
                     </div>`;
        } else {
            html += `<div class="text-sm text-gray-500 italic px-2">No adjunta documento principal.</div>`;
        }

        // Folios
        if (datos.folios > 0) {
            html += `<div class="text-sm text-gray-600 dark:text-gray-400 px-2 mt-1"><strong>Folios físicos de envío:</strong> ${datos.folios}</div>`;
        }

        // Anexo texto
        if (datos.anexo_texto) {
            html += `<div class="text-sm text-gray-600 dark:text-gray-400 px-2 mt-1"><strong>Anexo físico:</strong> ${datos.anexo_texto}</div>`;
        }

        // Anexos Digitales
        if (datos.anexos && datos.anexos.length > 0) {
            html += `<div class="mt-2"><h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 px-2">Anexos Digitales:</h5>`;
            html += `<div class="grid grid-cols-1 md:grid-cols-2 gap-2">`;
            datos.anexos.forEach(ax => {
                html += `<a href="${ax.ruta}" target="_blank" class="flex items-center gap-2 p-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-gray-600 rounded drop-shadow-sm hover:border-blue-300 dark:hover:border-blue-600 transition-colors" title="${ax.nombre}">
                            <span class="material-symbols-outlined text-gray-400 text-[18px]">attachment</span>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate w-full">${ax.nombre}</span>
                         </a>`;
            });
            html += `</div></div>`;
        }
        
        html += `</div></div>`; // End Envío Original

        // SECCIÓN: DE LA RESPUESTA
        const hasRespuestaPrincipal = datos.respuesta_principal;
        const hasRespuestaAnexos = datos.respuestas_anexos && datos.respuestas_anexos.length > 0;
        const hasRespuestaFolios = datos.folios_respuesta > 0;

        if (hasRespuestaPrincipal || hasRespuestaAnexos || hasRespuestaFolios) {
            html += `<div class="mt-4 bg-green-50/30 dark:bg-green-900/10 p-4 rounded-xl border border-green-100 dark:border-green-800/30">`;
            html += `<h4 class="font-bold text-green-800 dark:text-green-500 mb-3 flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">output</span> Respuesta del Destinatario</h4>`;
            html += `<div class="flex flex-col gap-3">`;

            // Documento Respuesta
            if (datos.respuesta_principal) {
                html += `<div class="flex items-center justify-between bg-white dark:bg-slate-900/50 p-3 rounded-lg border border-green-200 dark:border-green-800/50">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-600">picture_as_pdf</span>
                                <span class="text-sm font-medium dark:text-white">Oficio de Respuesta</span>
                            </div>
                            <a href="${datos.respuesta_principal}" target="_blank" class="px-3 py-1 bg-green-50 text-green-700 hover:bg-green-100 rounded-md text-xs font-medium dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition-colors">Ver Archivo</a>
                         </div>`;
            }

            // Folios Respuesta
            if (datos.folios_respuesta > 0) {
                html += `<div class="text-sm text-green-700 dark:text-green-400 px-2 mt-1"><strong>Folios de respuesta:</strong> ${datos.folios_respuesta}</div>`;
            }

            // Anexos Respuesta
            if (datos.respuestas_anexos && datos.respuestas_anexos.length > 0) {
                html += `<div class="mt-2"><h5 class="text-xs font-bold text-green-600 dark:text-green-500 uppercase tracking-wider mb-2 px-2">Anexos de Respuesta:</h5>`;
                html += `<div class="grid grid-cols-1 md:grid-cols-2 gap-2">`;
                datos.respuestas_anexos.forEach(ax => {
                    html += `<a href="${ax.ruta}" target="_blank" class="flex items-center gap-2 p-2 bg-white dark:bg-slate-900/50 border border-green-200 dark:border-green-800/50 rounded drop-shadow-sm hover:border-green-300 dark:hover:border-green-600 transition-colors" title="${ax.nombre}">
                                <span class="material-symbols-outlined text-green-500 text-[18px]">attachment</span>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate w-full">${ax.nombre}</span>
                             </a>`;
                });
                html += `</div></div>`;
            }

            html += `</div></div>`;
        }

        container.innerHTML = html;
        toggleModal('modalArchivos');
    }

</script>
@endsection

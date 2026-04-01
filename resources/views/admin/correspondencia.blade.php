@extends('admin.layouts.app')

@section('title', 'Consulta de Correspondencia')

@section('content')
<div class="space-y-6">

    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Consulta de Correspondencia</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Haz seguimiento a todos los documentos radicados vinculados a tu empresa.
            </p>
            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800">
                <form action="{{ route('admin.correspondencia') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <input type="hidden" name="tab" value="{{ request('tab', 'externa') }}">
                    
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Buscar por Asunto, Radicado o Empresa</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a] text-lg">search</span>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Escriba algo..." 
                                class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm focus:outline-none focus:border-primary transition-all">
                        </div>
                    </div>

                    <div class="w-full sm:w-48">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Ciudad (Externa)</label>
                        <select name="ciudad" class="w-full px-3 py-2 bg-gray-50 dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm outline-none focus:border-primary">
                            <option value="">Todas</option>
                            @foreach($ciudades as $ciu)
                                <option value="{{ $ciu->ciudad_cod_post }}" {{ request('ciudad') == $ciu->ciudad_cod_post ? 'selected' : '' }}>{{ $ciu->ciudad_nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- T5: Tipo Documento -->
                    <div class="w-full sm:w-48">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Tipo Documento</label>
                        <select name="tipo" class="w-full px-3 py-2 bg-gray-50 dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm outline-none focus:border-primary">
                            <option value="">Todos</option>
                            @foreach($tipos as $tp)
                                <option value="{{ $tp->id_tipo }}" {{ request('tipo') == $tp->id_tipo ? 'selected' : '' }}>{{ $tp->tipo_nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- T6: Estado -->
                    <div class="w-full sm:w-40">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Estado</label>
                        <select name="estado_fil" class="w-full px-3 py-2 bg-gray-50 dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm outline-none focus:border-primary">
                            <option value="">Todos</option>
                            <option value="7" {{ request('estado_fil') == '7' ? 'selected' : '' }}>Recibido</option>
                            <option value="8" {{ request('estado_fil') == '8' ? 'selected' : '' }}>En Trámite</option>
                            <option value="9" {{ request('estado_fil') == '9' ? 'selected' : '' }}>Resuelto</option>
                            <option value="10" {{ request('estado_fil') == '10' ? 'selected' : '' }}>Archivado</option>
                            <option value="11" {{ request('estado_fil') == '11' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>

                    <!-- T6: Rango de Fechas -->
                    <div class="w-full sm:w-44">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Desde</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm outline-none focus:border-primary">
                    </div>
                    <div class="w-full sm:w-44">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" max="{{ date('Y-m-d') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm outline-none focus:border-primary">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-5 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition shadow-lg shadow-primary/20 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                            Filtrar
                        </button>
                        @if(request()->anyFilled(['q', 'ciudad', 'tipo', 'estado_fil', 'fecha_desde', 'fecha_hasta']))
                            <a href="{{ route('admin.correspondencia') }}" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                                Borrar
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div>
            <button onclick="openExportModalCor()" class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white shadow-sm">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Exportar
            </button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="correspondenciaTabs" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg border-primary text-primary dark:border-blue-500 dark:text-blue-500 transition-colors" id="externa-tab" type="button" role="tab" onclick="switchTab('externa')">
                    Bandeja Externa
                    <span class="ml-1 px-1.5 py-0.5 text-[10px] bg-blue-100 text-blue-700 rounded-full font-black">{{ $totalRecibidas ?? 0 }}</span>
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:text-gray-400 text-gray-500 transition-colors" id="interna-tab" type="button" role="tab" onclick="switchTab('interna')">
                    Bandeja Interna
                    <span class="ml-1 px-1.5 py-0.5 text-[10px] bg-indigo-100 text-indigo-700 rounded-full font-black">{{ $totalInternas ?? 0 }}</span>
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:text-gray-400 text-gray-500 transition-colors" id="saliente-tab" type="button" role="tab" onclick="switchTab('saliente')">
                    Correspondencia Saliente
                    <span class="ml-1 px-1.5 py-0.5 text-[10px] bg-orange-100 text-orange-700 rounded-full font-black">{{ $totalSalientes ?? 0 }}</span>
                </button>
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

            <!-- Buscador columna Externa -->
            <div class="mb-3 flex gap-2">
                <input type="text" id="searchExterna" onkeyup="filtrarTabla('searchExterna','tablaExterna')" placeholder="Buscar radicado, procedencia, asunto..." class="w-full sm:w-80 px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-slate-900 focus:outline-none focus:border-primary dark:text-white">
            </div>

            <!-- Table Section Externa -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="tablaExterna" class="w-full text-left text-sm responsive-table">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 font-medium whitespace-nowrap">Radicados</th>
                                <th class="px-6 py-3 font-medium whitespace-nowrap">Procedencia</th>
                                <th class="px-6 py-3 font-medium whitespace-nowrap">Detalles Documento</th>
                                <th class="px-6 py-3 font-medium">Detalles Técnicos</th>
                                <th class="px-6 py-3 font-medium">Ingreso / Registro</th>
                                <th class="px-6 py-3 font-medium whitespace-nowrap">Archivos</th>
                                <th class="px-6 py-3 font-medium text-center whitespace-nowrap">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($correspondencias as $rec)
                                @php
                                    $estadoNombL = strtolower($rec->estado ? $rec->estado->estado_nomb : '');
                                    $isRechazado = str_contains($estadoNombL, 'rechazado');
                                    $isFinalizedExt = str_contains($estadoNombL, 'finalizado') || str_contains($estadoNombL, 'resuelto') || str_contains($estadoNombL, 'archivado') || $isRechazado;

                                    $esEmpresa = !empty($rec->nom_institucion);
                                    $procedencia = $esEmpresa ? $rec->nom_institucion : ($rec->nombre_persona ?? $rec->doc_persona ?? '—');
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top">
                                <td class="px-6 py-4" data-label="Radicado">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 text-xs font-bold border border-[#cfd7e7] dark:border-slate-700">
                                        <span class="material-symbols-outlined text-[14px]">tag</span>
                                        {{ $rec->radicado?->num_radicado ?? 'N/A' }}
                                    </span>
                                    @if($rec->num_radicado_ext)
                                        <span class="block text-[10px] text-slate-400 mt-1 uppercase font-medium">Ext: {{ $rec->num_radicado_ext }}</span>
                                    @endif
                                </td>
                                    <td class="px-6 py-4" data-label="Procedencia">
                                        <div class="font-medium dark:text-white max-w-[180px] break-words whitespace-normal">{{ $procedencia }}</div>
                                        <span class="inline-flex items-center gap-0.5 text-xs {{ $esEmpresa ? 'text-blue-500' : 'text-purple-500' }} mt-0.5">
                                            <span class="material-symbols-outlined" style="font-size:13px">{{ $esEmpresa ? 'business' : 'person' }}</span>
                                            {{ $esEmpresa ? 'Entidad / Empresa' : 'Persona Natural' }}
                                        </span>
                                        @if($rec->ciudad)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                                <span class="material-symbols-outlined text-[14px]">location_on</span>
                                                {{ $rec->ciudad->ciudad_nom ?? 'Desconocida' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm" data-label="Asunto">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 mb-1 max-w-[200px] whitespace-normal break-words">{{ $rec->asunto }}</div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Detalles">
                                        <div class="flex flex-col gap-1.5 text-[11px] leading-tight text-gray-600 dark:text-gray-400">
                                            <div><span class="material-symbols-outlined text-[14px] align-text-bottom">description</span> {{ $rec->tipo ? $rec->tipo->tipo_nombre : 'Externo' }}</div>
                                            <div><span class="material-symbols-outlined text-[14px] align-text-bottom">layers</span> Folios: {{ $rec->folio ?? 0 }}</div>
                                            @if($rec->tipo)
                                                @php
                                                    $prioColor = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                                    $prioNombre = $rec->tipo->prioridad->prioridad_nombre ?? 'N/A';
                                                    $prioUpper = strtoupper($prioNombre);
                                                    if (str_contains($prioUpper, 'URGENTE')) $prioColor = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                                    elseif (str_contains($prioUpper, 'ALTA')) $prioColor = 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400';
                                                    elseif (str_contains($prioUpper, 'MEDIA')) $prioColor = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                                                    elseif (str_contains($prioUpper, 'BAJA')) $prioColor = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                                @endphp
                                                <div class="flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">flag</span>
                                                    <span class="px-1 rounded {{ $prioColor }}">{{ $prioNombre }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Fecha">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $rec->fecha_hora_recib ? \Carbon\Carbon::parse($rec->fecha_hora_recib)->format('d M Y') : 'N/A' }}</div>
                                    </td>
                                     <td class="px-6 py-4" data-label="Archivos">
                                          @php
                                              $archivosDatos = [
                                                  'id' => $rec->id_recibido,
                                                  'tipo_cor' => 'Externa',
                                                  'radicado' => $rec->radicado?->num_radicado,
                                                  'radicado_ext' => $rec->num_radicado_ext,
                                                  'procedencia' => $procedencia,
                                                  'asunto' => $rec->asunto,
                                                  'fecha' => $rec->fecha_hora_recib ? \Carbon\Carbon::parse($rec->fecha_hora_recib)->format('d M Y, h:i A') : 'N/A',
                                                  'tipo_doc' => $rec->tipo ? $rec->tipo->tipo_nombre : 'Externo',
                                                  'estado' => $rec->estado ? $rec->estado->estado_nomb : 'Sin estado',
                                                  'principal' => $rec->archivo ? asset('storage/' . $rec->archivo) : null,
                                                  'anexos' => [],
                                                  'anexo_texto' => $rec->anexo,
                                                  'folios' => $rec->folio
                                              ];
                                              if ($rec->anexos) {
                                                  foreach($rec->anexos as $ax) {
                                                      $archivosDatos['anexos'][] = ['nombre' => $ax->nombre_original, 'ruta' => asset('storage/' . $ax->ruta_archivo)];
                                                  }
                                              }
                                              if ($rec->detalles) {
                                                  foreach($rec->detalles as $det) {
                                                      if ($det->anexosRespuesta) {
                                                          foreach($det->anexosRespuesta as $axR) {
                                                              $archivosDatos['anexos'][] = ['nombre' => '(R) ' . $axR->nombre_original, 'ruta' => asset('storage/' . $axR->ruta_archivo)];
                                                          }
                                                      }
                                                  }
                                              }
                                          @endphp
                                          <button type="button" data-detalle="{{ json_encode($archivosDatos) }}" onclick="abrirModalDetalle(this.dataset.detalle)" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-400 rounded-md transition-colors shadow-sm">
                                              <span class="material-symbols-outlined text-[16px]">visibility</span> Ver Detalle
                                          </button>
                                     </td>
                                    <td class="px-6 py-4 actions-cell" data-label="Estado">
                                        @php
                                            $lowDesc = strtolower($rec->estado ? $rec->estado->estado_nomb : '');
                                            $idEst = $rec->id_estado_rec;
                                            $clases = 'bg-gray-100 text-gray-600 border-gray-200';
                                            
                                            if (str_contains($lowDesc, 'resuelto') || $idEst == 9) {
                                                $clases = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                            } elseif (str_contains($lowDesc, 'enviado') || str_contains($lowDesc, 'saliente') || $idEst == 12) {
                                                $clases = 'bg-blue-50 text-blue-600 border-blue-200';
                                            } elseif (str_contains($lowDesc, 'recibido') || $idEst == 7) {
                                                $clases = 'bg-indigo-50 text-indigo-600 border-indigo-200';
                                            } elseif (str_contains($lowDesc, 'pendiente') || in_array($idEst, [8, 13])) {
                                                $clases = 'bg-amber-50 text-amber-600 border-amber-200';
                                            } elseif (str_contains($lowDesc, 'rechazado') || $idEst == 11) {
                                                $clases = 'bg-red-50 text-red-600 border-red-200';
                                            } elseif (str_contains($lowDesc, 'archivado') || $idEst == 10) {
                                                $clases = 'bg-slate-50 text-slate-600 border-slate-200';
                                            }
                                        @endphp
                                        <div class="flex flex-col gap-2 items-center">
                                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase border {{ $clases }}">{{ $rec->estado ? $rec->estado->estado_nomb : 'Sin estado' }}</span>
                                            <a href="{{ route('admin.correspondencia.historial_externa', $rec->id_recibido) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-primary hover:text-blue-800 transition-colors whitespace-nowrap">
                                                <span class="material-symbols-outlined text-[14px]">history</span> Historial
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No hay correspondencias externas registradas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $correspondencias->appends(request()->except('ext_page'))->links() }}
                </div>
            </div>
        </div>

        <!-- ================= INTERNA TAB ================= -->
        <div id="interna" class="hidden" role="tabpanel">
            <!-- Stats Boxes Interna -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <!-- Similar design as Externa -->
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600"><span class="material-symbols-outlined">inbox</span></div>
                    <div><p class="text-sm text-gray-500">Total Internas</p><p class="text-2xl font-bold">{{ $totalInternas }}</p></div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600"><span class="material-symbols-outlined">hourglass_empty</span></div>
                    <div><p class="text-sm text-gray-500">En Trámite</p><p class="text-2xl font-bold">{{ $enTramiteInt }}</p></div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600"><span class="material-symbols-outlined">check_circle</span></div>
                    <div><p class="text-sm text-gray-500">Finalizadas</p><p class="text-2xl font-bold">{{ $finalizadasInt }}</p></div>
                </div>
            </div>

            <!-- Buscador columna Interna -->
            <div class="mb-3 flex gap-2">
                <input type="text" id="searchInterna" onkeyup="filtrarTabla('searchInterna','tablaInterna')" placeholder="Buscar radicado, remitente, asunto..." class="w-full sm:w-80 px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-slate-900 focus:outline-none focus:border-primary dark:text-white">
            </div>

            <!-- Table Section Interna -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="tablaInterna" class="w-full text-left text-sm responsive-table">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 font-medium whitespace-nowrap">Radicado</th>
                                <th class="px-6 py-3 font-medium whitespace-nowrap">Remitente</th>
                                <th class="px-6 py-3 font-medium whitespace-nowrap">Destinatario</th>
                                <th class="px-6 py-3 font-medium">Asunto</th>
                                <th class="px-6 py-3 font-medium">Fecha</th>
                                <th class="px-6 py-3 font-medium text-center">Docs</th>
                                <th class="px-6 py-3 font-medium text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($correspondenciasInternas as $int)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top">
                                    <td class="px-6 py-4" data-label="Radicado">
                                         <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 text-xs font-bold border border-[#cfd7e7] dark:border-slate-700">
                                             <span class="material-symbols-outlined text-[14px]">tag</span>
                                             {{ $int->radicado ? $int->radicado->num_radicado : 'INT-N/A' }}
                                         </span>
                                     </td>
                                     <td class="px-6 py-4" data-label="Remitente">{{ $int->quienEnvia ? $int->quienEnvia->emple_nombres . ' ' . $int->quienEnvia->emple_apellidos : 'N/A' }}</td>
                                     <td class="px-6 py-4" data-label="Destinatario">
                                         @if($int->detalles->count() > 0)
                                             {{ $int->detalles->first()->quienRecibe ? $int->detalles->first()->quienRecibe->emple_nombres : 'N/A' }}
                                         @else
                                             N/A
                                         @endif
                                     </td>
                                     <td class="px-6 py-4" data-label="Asunto">{{ $int->asunto }}</td>
                                     <td class="px-6 py-4" data-label="Fecha">{{ \Carbon\Carbon::parse($int->fecha)->format('d M Y') }}</td>
                                     <td class="px-6 py-4" data-label="Archivos">
                                         @php
                                             $quienRecibeNom = 'N/A';
                                             if($int->detalles->count() > 0 && $int->detalles->first()->quienRecibe) {
                                                 $quienRecibeNom = $int->detalles->first()->quienRecibe->emple_nombres . ' ' . $int->detalles->first()->quienRecibe->emple_apellidos;
                                             }

                                             $archivosInt = [
                                                 'id' => $int->id_envio,
                                                 'tipo_cor' => 'Interna',
                                                 'radicado' => $int->radicado?->num_radicado,
                                                 'procedencia' => $int->quienEnvia ? $int->quienEnvia->emple_nombres . ' ' . $int->quienEnvia->emple_apellidos : 'N/A',
                                                 'destinatario' => $quienRecibeNom,
                                                 'asunto' => $int->asunto,
                                                 'fecha' => \Carbon\Carbon::parse($int->fecha)->format('d M Y, h:i A'),
                                                 'tipo_doc' => $int->tipoEnvio ? $int->tipoEnvio->tipo_nombre : 'Interna',
                                                 'estado' => $int->estadoEnvio ? $int->estadoEnvio->estado_nomb : 'Sin estado',
                                                 'principal' => $int->archivo ? asset('storage/' . $int->archivo) : null,
                                                 'anexos' => [],
                                                 'folios' => $int->folio
                                             ];
                                             if ($int->anexos) {
                                                 foreach($int->anexos as $ax) {
                                                     $archivosInt['anexos'][] = ['nombre' => $ax->nombre_original, 'ruta' => asset('storage/' . $ax->ruta_archivo)];
                                                 }
                                             }
                                             if ($int->detalles) {
                                                 foreach($int->detalles as $det) {
                                                     if ($det->anexosRespuesta) {
                                                         foreach($det->anexosRespuesta as $axR) {
                                                             $archivosInt['anexos'][] = ['nombre' => '(R) ' . $axR->nombre_original, 'ruta' => asset('storage/' . $axR->ruta_archivo)];
                                                         }
                                                     }
                                                 }
                                             }
                                         @endphp
                                         <button type="button" data-detalle="{{ json_encode($archivosInt) }}" onclick="abrirModalDetalle(this.dataset.detalle)" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition-colors">
                                             <span class="material-symbols-outlined text-[16px]">visibility</span> Ver Detalle
                                         </button>
                                     </td>
                                    <td class="px-6 py-4 actions-cell" data-label="Estado">
                                        <div class="flex flex-col gap-2 items-center">
                                            @php
                                                $idEstInt = $int->id_estado_envio;
                                                $lowInt = strtolower($int->estadoEnvio ? $int->estadoEnvio->estado_nomb : '');
                                                $clasesInt = 'bg-gray-100 text-gray-600 border-gray-200';
                                                
                                                if (str_contains($lowInt, 'resuelto') || $idEstInt == 9) $clasesInt = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                                elseif (str_contains($lowInt, 'enviado') || $idEstInt == 12) $clasesInt = 'bg-blue-50 text-blue-600 border-blue-200';
                                                elseif (str_contains($lowInt, 'pendiente') || in_array($idEstInt, [8, 13])) $clasesInt = 'bg-amber-50 text-amber-600 border-amber-200';
                                                elseif ($idEstInt == 11) $clasesInt = 'bg-red-50 text-red-600 border-red-200';
                                                elseif ($idEstInt == 10) $clasesInt = 'bg-slate-50 text-slate-600 border-slate-200';
                                            @endphp
                                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase border {{ $clasesInt }}">{{ $int->estadoEnvio ? $int->estadoEnvio->estado_nomb : 'Sin estado' }}</span>
                                            <a href="{{ route('admin.correspondencia.historial_interna', $int->id_envio) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-primary hover:text-blue-800 transition-colors whitespace-nowrap">
                                                <span class="material-symbols-outlined text-[14px]">history</span> Historial
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No hay correspondencias internas registradas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $correspondenciasInternas->appends(['ext_page' => request('ext_page'), 'tab' => 'interna'])->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SALIENTE TAB ================= -->
    <div id="saliente" class="hidden" role="tabpanel">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined">outbox</span>
                </div>
                <div><p class="text-sm text-gray-500 dark:text-gray-400">Total Salientes</p><p class="text-2xl font-bold dark:text-white">{{ $totalSalientes }}</p></div>
            </div>
        </div>

        <!-- Buscador columna Saliente -->
        <div class="mb-3 flex gap-2">
            <input type="text" id="searchSaliente" onkeyup="filtrarTabla('searchSaliente','tablaSaliente')" placeholder="Buscar radicado, remitente, asunto..." class="w-full sm:w-80 px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-slate-900 focus:outline-none focus:border-primary dark:text-white">
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table id="tablaSaliente" class="w-full text-left text-sm responsive-table">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-3 font-medium whitespace-nowrap">Radicado</th>
                            <th class="px-6 py-3 font-medium whitespace-nowrap">Enviado Por</th>
                            <th class="px-6 py-3 font-medium whitespace-nowrap">Destinatario</th>
                            <th class="px-6 py-3 font-medium">Asunto</th>
                            <th class="px-6 py-3 font-medium">Fecha</th>
                            <th class="px-6 py-3 font-medium text-center">Docs</th>
                            <th class="px-6 py-3 font-medium text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($correspondenciasSalientes as $sal)
                            @php
                                $estadoSalNomb = $sal->estadoEnvio ? $sal->estadoEnvio->estado_nomb : 'Sin estado';
                                $quienRecibeNom = $sal->destino ?? 'N/A';
                                if($sal->detalles->count() > 0 && $sal->detalles->first()->quienRecibe) {
                                    $quienRecibeNom = $sal->detalles->first()->quienRecibe->emple_nombres . ' ' . $sal->detalles->first()->quienRecibe->emple_apellidos;
                                }
                                $areaDestSal = 'N/A';
                                if($sal->detalles->count() > 0 && $sal->detalles->first()->quienRecibe) {
                                    $areaDestSal = $sal->detalles->first()->quienRecibe->area->area_nom ?? 'Sin área';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top" data-envio-id="{{ $sal->id_envio }}">
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-orange-50 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 text-xs font-bold border border-orange-200 dark:border-orange-800">
                                        <span class="material-symbols-outlined text-[14px]">outbox</span>
                                        {{ $sal->radicado ? $sal->radicado->num_radicado : 'SAL-N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4" data-label="Enviado Por">{{ $sal->quienEnvia ? $sal->quienEnvia->emple_nombres . ' ' . $sal->quienEnvia->emple_apellidos : 'N/A' }}</td>
                                <td class="px-6 py-4" data-label="Destinatario">{{ $quienRecibeNom }}</td>
                                <td class="px-6 py-4 max-w-[180px] whitespace-normal break-words" data-label="Asunto">{{ $sal->asunto }}</td>
                                <td class="px-6 py-4" data-label="Fecha">{{ $sal->fecha ? \Carbon\Carbon::parse($sal->fecha)->format('d M Y') : 'N/A' }}</td>
                                <td class="px-6 py-4" data-label="Archivos">
                                    @php
                                        $archivosSal = [
                                            'id' => $sal->id_envio,
                                            'tipo_cor' => 'Saliente',
                                            'radicado' => $sal->radicado?->num_radicado,
                                            'procedencia' => $sal->quienEnvia ? $sal->quienEnvia->emple_nombres . ' ' . $sal->quienEnvia->emple_apellidos : 'N/A',
                                            'destinatario' => $quienRecibeNom,
                                            'asunto' => $sal->asunto,
                                            'fecha' => $sal->fecha ? \Carbon\Carbon::parse($sal->fecha)->format('d M Y, h:i A') : 'N/A',
                                            'tipo_doc' => $sal->tipoEnvio ? $sal->tipoEnvio->tipo_nombre : 'Saliente',
                                            'estado' => $estadoSalNomb,
                                            'principal' => $sal->archivo ? asset('storage/' . $sal->archivo) : null,
                                            'anexos' => [],
                                            'folios' => $sal->folio
                                        ];
                                        if ($sal->anexos) {
                                            foreach($sal->anexos as $ax) {
                                                $archivosSal['anexos'][] = ['nombre' => $ax->nombre_original, 'ruta' => asset('storage/' . $ax->ruta_archivo)];
                                            }
                                        }
                                    @endphp
                                    <button type="button" data-detalle="{{ json_encode($archivosSal) }}" onclick="abrirModalDetalle(this.dataset.detalle)" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-orange-700 bg-orange-50 border border-orange-200 rounded-md hover:bg-orange-100 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span> Ver Detalle
                                    </button>
                                </td>
                                <td class="px-6 py-4 actions-cell" data-label="Estado">
                                    <div class="flex flex-col gap-2 items-center">
                                        @php
                                            $idEstSal = $sal->id_estado_envio;
                                            $lowSal = strtolower($sal->estadoEnvio ? $sal->estadoEnvio->estado_nomb : '');
                                            $clasesSal = 'bg-gray-100 text-gray-600 border-gray-200';
                                            
                                            if (str_contains($lowSal, 'resuelto') || $idEstSal == 9) $clasesSal = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                            elseif (str_contains($lowSal, 'enviado') || $idEstSal == 12) $clasesSal = 'bg-blue-50 text-blue-600 border-blue-200';
                                            elseif (str_contains($lowSal, 'pendiente') || in_array($idEstSal, [8, 13])) $clasesSal = 'bg-amber-50 text-amber-600 border-amber-200';
                                            elseif ($idEstSal == 11) $clasesSal = 'bg-red-50 text-red-600 border-red-200';
                                            elseif ($idEstSal == 10) $clasesSal = 'bg-slate-50 text-slate-600 border-slate-200';
                                        @endphp
                                        <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase border {{ $clasesSal }}">{{ $estadoSalNomb }}</span>
                                        <a href="{{ route('admin.correspondencia.historial_interna', $sal->id_envio) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-primary hover:text-blue-800 transition-colors whitespace-nowrap">
                                            <span class="material-symbols-outlined text-[14px]">history</span> Historial
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No hay correspondencias salientes registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $correspondenciasSalientes->appends(request()->except('sal_page'))->links() }}
            </div>
        </div>
    </div>

</div>

<!-- Modal Ver Detalle (Unificado) -->
<div id="modalDetalleCor" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white dark:bg-slate-900 rounded-[1rem] shadow-xl w-full max-w-3xl flex flex-col max-h-[95vh] overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-lg text-gray-800 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">description</span>
                Detalle de Correspondencia
            </h3>
            <button onclick="toggleModal('modalDetalleCor')" class="text-gray-400 hover:text-gray-600"><span class="material-symbols-outlined">close</span></button>
        </div>
        <div class="p-6 space-y-6 overflow-y-auto flex-1" id="modalDetalleContent"></div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end bg-gray-50 dark:bg-slate-800/80">
            <button type="button" onclick="toggleModal('modalDetalleCor')" class="px-6 py-2 bg-gray-200 dark:bg-slate-700 rounded-lg text-sm text-gray-800 dark:text-white font-bold">Cerrar</button>
        </div>
    </div>



<!-- Modal Exportar -->
<div id="exportModalCor" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5 relative">
        <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Exportar Correspondencia</h3>
        <div class="flex flex-col gap-3">
            <a id="btnExportPdf" href="#" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:text-white"><span class="material-symbols-outlined text-red-600">picture_as_pdf</span> PDF</a>
            <a href="{{ route('admin.correspondencia.export.excel') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:text-white"><span class="material-symbols-outlined text-green-600">grid_on</span> Excel</a>
        </div>
        <button onclick="closeExportModalCor()" class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700">Cancelar</button>
    </div>
</div>

<script>
    function toggleModal(id) { 
        const m = document.getElementById(id); 
        if(m && m.classList.contains('hidden')) { openModal(id); } else { closeModal(id); } 
    }

    // ── Buscador por columna ─────────────────────────────────────────
    function filtrarTabla(inputId, tableId) {
        const filtro = document.getElementById(inputId).value.toLowerCase();
        const filas  = document.querySelectorAll('#' + tableId + ' tbody tr');
        filas.forEach(fila => {
            fila.style.display = fila.textContent.toLowerCase().includes(filtro) ? '' : 'none';
        });
    }

    function switchTab(tab) {
        const tabs = ['externa', 'interna', 'saliente'];
        const active = ['border-primary', 'text-primary'], inactive = ['border-transparent', 'text-gray-500'];

        tabs.forEach(t => {
            const btn = document.getElementById(t + '-tab');
            const content = document.getElementById(t);
            if (t === tab) {
                content.classList.remove('hidden');
                btn.classList.add(...active); btn.classList.remove(...inactive);
            } else {
                content.classList.add('hidden');
                btn.classList.remove(...active); btn.classList.add(...inactive);
            }
        });
        sessionStorage.setItem('activeCorrespondenceTab', tab);

        // Actualizar URL del PDF con la pestaña activa
        actualizarUrlPdf(tab);
    }

    // ── PDF filtrado: pasa los query params actuales + tab activa ─────
    function actualizarUrlPdf(tab) {
        const params = new URLSearchParams(window.location.search);
        params.set('tab', tab);
        const base = '{{ route("admin.correspondencia.export.pdf") }}';
        const btn = document.getElementById('btnExportPdf');
        if (btn) btn.href = base + '?' + params.toString();
    }

    // T4: Polling de estados en tiempo real cada 30 segundos
    function iniciarPollingEstados() {
        setInterval(function() {
            document.querySelectorAll('[data-recibido-id]').forEach(function(row) {
                const id = row.dataset.recibidoId;
                fetch(`/admin/correspondencia/recibido/${id}/estado`)
                    .then(r => r.json())
                    .then(data => {
                        const badge = row.querySelector('.estado-badge');
                        if (badge) badge.textContent = data.estado;
                    }).catch(() => {});
            });
            document.querySelectorAll('[data-envio-id]').forEach(function(row) {
                const id = row.dataset.envioId;
                fetch(`/admin/correspondencia/envio/${id}/estado`)
                    .then(r => r.json())
                    .then(data => {
                        const badge = row.querySelector('.estado-badge');
                        if (badge) badge.textContent = data.estado;
                    }).catch(() => {});
            });
        }, 30000);
    }

    function abrirModalDetalle(datosJson) {
        const datos = JSON.parse(datosJson);
        const container = document.getElementById('modalDetalleContent');
        
        let html = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="border-b pb-2">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Información General</h4>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-black">Radicado</p>
                            <p class="text-sm font-bold text-primary">${datos.radicado || 'N/A'}</p>
                            ${datos.radicado_ext ? `<p class="text-[10px] text-slate-400">Ext: ${datos.radicado_ext}</p>` : ''}
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-black">Tipo Trámite</p>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-200">${datos.tipo_cor}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-black">Fecha Registro</p>
                            <p class="text-xs text-gray-700 dark:text-gray-300 font-medium">${datos.fecha}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-black">Estado Actual</p>
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-black uppercase rounded-full border border-blue-100">${datos.estado}</span>
                        </div>
                    </div>
                    <div class="pt-2">
                        <p class="text-[10px] text-gray-500 uppercase font-black mb-1">Asunto / Descripción</p>
                        <div class="p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-100 dark:border-slate-800 text-sm italic text-slate-600 dark:text-slate-400">
                            "${datos.asunto}"
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="border-b pb-2">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Actores y Documentos</h4>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-sm mt-0.5">person</span>
                            <div>
                                <p class="text-[10px] text-gray-500 uppercase font-black">Remitente / Procedencia</p>
                                <p class="text-sm font-bold text-gray-800 dark:text-white">${datos.procedencia}</p>
                            </div>
                        </div>
                        ${datos.destinatario ? `
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-sm mt-0.5">forward_to_inbox</span>
                            <div>
                                <p class="text-[10px] text-gray-500 uppercase font-black">Destinatario Principal</p>
                                <p class="text-sm font-bold text-gray-800 dark:text-white">${datos.destinatario}</p>
                            </div>
                        </div>` : ''}
                    </div>
                    <div class="pt-4 space-y-3">
                        <p class="text-[10px] text-gray-500 uppercase font-black mb-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">attach_file</span> Archivos Adjuntos
                        </p>
                        ${datos.principal ? `
                        <a href="${datos.principal}" target="_blank" class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl hover:bg-blue-100 transition-colors group">
                           <div class="flex items-center gap-2">
                               <span class="material-symbols-outlined text-blue-600">picture_as_pdf</span>
                               <span class="text-xs font-bold text-blue-900 dark:text-blue-200">Documento Principal</span>
                               <span class="text-[10px] text-blue-400">(${datos.folios || 0} folios)</span>
                           </div>
                           <span class="material-symbols-outlined text-blue-400 group-hover:translate-x-1 transition-transform">open_in_new</span>
                        </a>` : '<p class="text-xs text-slate-400 italic">No hay documento principal cargado.</p>'}
                        ${datos.anexos && datos.anexos.length > 0 ? `
                        <div class="grid grid-cols-1 gap-2 mt-2">
                            ${datos.anexos.map(ax => `
                                <a href="${ax.ruta}" target="_blank" class="flex items-center gap-2 p-2.5 bg-slate-50 dark:bg-slate-800 border rounded-lg hover:border-primary transition-all text-xs text-slate-600 dark:text-slate-300">
                                    <span class="material-symbols-outlined text-sm">attachment</span>
                                    <span class="truncate flex-1">${ax.nombre}</span>
                                    <span class="material-symbols-outlined text-xs">download</span>
                                </a>
                            `).join('')}
                        </div>` : ''}
                        ${datos.anexo_texto ? `
                        <div class="p-2 border-l-4 border-orange-400 bg-orange-50 dark:bg-orange-900/20 text-[11px] text-orange-800 dark:text-orange-200">
                            <strong>Nota de Anexo Físico:</strong> ${datos.anexo_texto}
                        </div>` : ''}
                    </div>
                </div>
            </div>
        `;
        container.innerHTML = html;
        toggleModal('modalDetalleCor');
    }

    function openExportModalCor() { openModal('exportModalCor'); }
    function closeExportModalCor() { closeModal('exportModalCor'); }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab') || sessionStorage.getItem('activeCorrespondenceTab') || 'externa';
        if (tab) switchTab(tab);
        iniciarPollingEstados();
    });
</script>

    <style>
        @media print {
            aside, nav, header, #exportModalCor, .p-6.border-b, .mb-4.border-b, .grid.grid-cols-1.md\:grid-cols-5, .mb-3.flex.gap-2, .px-6.py-4.border-t, tr td:last-child, button {
                display: none !important;
            }
            body {
                background-color: white !important;
                color: black !important;
                font-size: 10pt;
            }
            .space-y-6 {
                padding: 0 !important;
            }
            .bg-white.dark\:bg-slate-800 {
                margin: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th, td {
                border: 1px solid #ddd !important;
                padding: 8px !important;
                -webkit-print-color-adjust: exact;
            }
            th {
                background-color: #f8f9fa !important;
            }
            .hidden {
                display: table-cell !important;
            }
            .lg\:table-cell, .md\:table-cell, .sm\:table-cell {
                display: table-cell !important;
            }
        }
    </style>
@endsection

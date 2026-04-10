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
        </div>
        <div>
            <button onclick="openExportModalCor()" class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white shadow-sm">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Exportar
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
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

            <div class="w-full sm:w-64">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Ciudad (Externa)</label>
                <select name="ciudad" class="w-full px-3 py-2 bg-gray-50 dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm select2">
                    <option value="">Todas</option>
                    @foreach($ciudades as $ciu)
                        <option value="{{ $ciu->ciudad_cod_post }}" {{ request('ciudad') == $ciu->ciudad_cod_post ? 'selected' : '' }}>{{ $ciu->ciudad_nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-64">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Tipo Documento</label>
                <select name="tipo" class="w-full px-3 py-2 bg-gray-50 dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm select2">
                    <option value="">Todos</option>
                    @foreach($tipos as $tp)
                        <option value="{{ $tp->id_tipo }}" {{ request('tipo') == $tp->id_tipo ? 'selected' : '' }}>{{ $tp->tipo_nombre }}</option>
                    @endforeach
                </select>
            </div>

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
                <!-- Se mantienen los stats modernos -->
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined text-lg">inbox</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase uppercase">Total Recibidas</p>
                        <p class="text-xl font-bold dark:text-white">{{ $totalRecibidas }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                        <span class="material-symbols-outlined text-lg">hourglass_empty</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">En Trámite</p>
                        <p class="text-xl font-bold dark:text-white">{{ $enTramite }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Finalizadas</p>
                        <p class="text-xl font-bold dark:text-white">{{ $finalizadas }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-lg">folder</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Archivadas</p>
                        <p class="text-xl font-bold dark:text-white">{{ $archivadas }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center gap-4 shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined text-lg">error</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Vencidas / Alerta</p>
                        <p class="text-xl font-bold dark:text-white">{{ $vencidas }}</p>
                    </div>
                </div>
            </div>

            <!-- Buscador local -->
            <div class="mb-3">
                <input type="text" id="searchExterna" onkeyup="filtrarTabla('searchExterna','tablaExterna')" placeholder="Filtrar por cualquier columna en esta página..." class="w-full sm:w-80 px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-slate-900 focus:outline-none dark:text-white shadow-sm">
            </div>

            <!-- Table Section Externa -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table id="tablaExterna" class="w-full text-left text-sm responsive-table">
                        <thead class="text-[10px] text-gray-400 uppercase bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-4 font-black">Radicado</th>
                                <th class="px-6 py-4 font-black">Procedencia</th>
                                <th class="px-6 py-4 font-black">Asunto</th>
                                <th class="px-6 py-4 font-black">Detalles</th>
                                <th class="px-6 py-4 font-black">Fecha</th>
                                <th class="px-6 py-4 font-black text-center">Estado</th>
                                <th class="px-6 py-4 font-black text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($correspondencias as $rec)
                                @php
                                    $esEmpresa = !empty($rec->nom_institucion);
                                    $procedencia = $esEmpresa ? $rec->nom_institucion : ($rec->nombre_persona ?? $rec->doc_persona ?? '—');
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top">
                                    <td class="px-6 py-4" data-label="Radicado">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#0d121b] dark:text-white text-xs font-black border border-[#cfd7e7] dark:border-slate-700">
                                            {{ $rec->radicado?->num_radicado ?? 'N/A' }}
                                        </span>
                                        @if($rec->num_radicado_ext)
                                            <span class="block text-[10px] text-slate-400 mt-1 uppercase font-medium">Ext: {{ $rec->num_radicado_ext }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4" data-label="Procedencia">
                                        <div class="font-bold dark:text-white break-words">{{ $procedencia }}</div>
                                        <div class="text-[10px] text-gray-500 uppercase flex items-center gap-1 mt-1">
                                            <span class="material-symbols-outlined text-xs">{{ $esEmpresa ? 'business' : 'person' }}</span>
                                            {{ $rec->ciudad->ciudad_nom ?? 'Desconocida' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Asunto">
                                        <div class="text-xs text-gray-700 dark:text-gray-300 max-w-[250px] whitespace-normal italic">"{{ $rec->asunto }}"</div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Detalles">
                                        <div class="flex flex-col gap-1 text-[10px] text-gray-500 font-bold uppercase">
                                            <span>{{ $rec->tipo ? $rec->tipo->tipo_nombre : 'Externo' }}</span>
                                            <span>Folios: {{ $rec->folio ?? 0 }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Fecha">
                                        <div class="text-xs font-bold dark:text-white">{{ $rec->fecha_hora_recib ? \Carbon\Carbon::parse($rec->fecha_hora_recib)->format('d/m/Y') : 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center" data-label="Estado">
                                        @php
                                            $idEst = $rec->id_estado_rec;
                                            $clases = 'bg-gray-100 text-gray-600 border-gray-200';
                                            if ($idEst == 9) $clases = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                            elseif ($idEst == 7) $clases = 'bg-indigo-50 text-indigo-600 border-indigo-200';
                                            elseif (in_array($idEst, [8, 13])) $clases = 'bg-amber-50 text-amber-600 border-amber-200';
                                            elseif ($idEst == 11) $clases = 'bg-red-50 text-red-600 border-red-200';
                                        @endphp
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-black uppercase border {{ $clases }}">
                                            {{ $rec->estado ? $rec->estado->estado_nomb : 'Sin estado' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                         @php
                                              $archivosDatos = [
                                                  'id' => $rec->id_recibido,
                                                  'tipo_cor' => 'Externa',
                                                  'radicado' => $rec->radicado?->num_radicado,
                                                  'radicado_ext' => $rec->num_radicado_ext,
                                                  'procedencia' => $procedencia,
                                                  'asunto' => $rec->asunto,
                                                  'fecha' => $rec->fecha_hora_recib ? \Carbon\Carbon::parse($rec->fecha_hora_recib)->format('d/m/Y, h:i A') : 'N/A',
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
                                          @endphp
                                         <div class="flex items-center justify-center gap-1">
                                            <button onclick="abrirModalDetalle('{{ json_encode($archivosDatos) }}')" class="p-1.5 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Ver Detalle">
                                                <span class="material-symbols-outlined">visibility</span>
                                            </button>
                                            <a href="{{ route('admin.correspondencia.historial_externa', $rec->id_recibido) }}" class="p-1.5 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors" title="Ver Historial">
                                                <span class="material-symbols-outlined">history</span>
                                            </a>
                                         </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">No se encontraron registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $correspondencias->appends(request()->except('ext_page'))->links() }}
                </div>
            </div>
        </div>

        <!-- ================= INTERNA TAB ================= -->
        <div id="interna" class="hidden" role="tabpanel">
             <div class="mb-3">
                <input type="text" id="searchInterna" onkeyup="filtrarTabla('searchInterna','tablaInterna')" placeholder="Filtrar bandeja interna..." class="w-full sm:w-80 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 dark:bg-slate-900 focus:outline-none dark:text-white shadow-sm">
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table id="tablaInterna" class="w-full text-left text-sm responsive-table">
                        <thead class="text-[10px] text-gray-400 uppercase bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-4 font-black">Radicado</th>
                                <th class="px-6 py-4 font-black">Remitente</th>
                                <th class="px-6 py-4 font-black">Destinatario</th>
                                <th class="px-6 py-4 font-black">Asunto</th>
                                <th class="px-6 py-4 font-black">Fecha</th>
                                <th class="px-6 py-4 font-black text-center">Estado</th>
                                <th class="px-6 py-4 font-black text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($correspondenciasInternas as $int)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-xs font-black border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white">
                                            {{ $int->radicado ? $int->radicado->num_radicado : 'INT-N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $int->quienEnvia ? $int->quienEnvia->emple_nombres . ' ' . $int->quienEnvia->emple_apellidos : 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        @if($int->detalles->count() > 0)
                                            {{ $int->detalles->first()->quienRecibe ? $int->detalles->first()->quienRecibe->emple_nombres : 'N/A' }}
                                        @else N/A @endif
                                    </td>
                                    <td class="px-6 py-4 italic text-gray-600 dark:text-gray-400">"{{ $int->asunto }}"</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($int->fecha)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $idEstInt = $int->id_estado_envio;
                                            $clasesInt = ($idEstInt == 9) ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-gray-100 text-gray-600 border-gray-200';
                                        @endphp
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-black uppercase border {{ $clasesInt }}">
                                            {{ $int->estadoEnvio ? $int->estadoEnvio->estado_nomb : 'Sin estado' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
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
                                                 'fecha' => \Carbon\Carbon::parse($int->fecha)->format('d/m/Y, h:i A'),
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
                                         @endphp
                                         <div class="flex items-center justify-center gap-1">
                                             <button onclick="abrirModalDetalle('{{ json_encode($archivosInt) }}')" class="p-1.5 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Ver Detalle">
                                                <span class="material-symbols-outlined">visibility</span>
                                            </button>
                                            <a href="{{ route('admin.correspondencia.historial_interna', $int->id_envio) }}" class="p-1.5 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors" title="Ver Historial">
                                                <span class="material-symbols-outlined">history</span>
                                            </a>
                                         </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">No hay registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $correspondenciasInternas->appends(request()->except('int_page'))->links() }}
                </div>
            </div>
        </div>

        <!-- ================= SALIENTE TAB ================= -->
        <div id="saliente" class="hidden" role="tabpanel">
            <div class="mb-3">
                <input type="text" id="searchSaliente" onkeyup="filtrarTabla('searchSaliente','tablaSaliente')" placeholder="Filtrar bandeja saliente..." class="w-full sm:w-80 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 dark:bg-slate-900 focus:outline-none dark:text-white shadow-sm">
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table id="tablaSaliente" class="w-full text-left text-sm responsive-table">
                        <thead class="text-[10px] text-gray-400 uppercase bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-4 font-black">Radicado</th>
                                <th class="px-6 py-4 font-black">Remitente</th>
                                <th class="px-6 py-4 font-black">Destinatario</th>
                                <th class="px-6 py-4 font-black">Asunto</th>
                                <th class="px-6 py-4 font-black">Fecha</th>
                                <th class="px-6 py-4 font-black text-center">Estado</th>
                                <th class="px-6 py-4 font-black text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($correspondenciasSalientes as $sal)
                                @php
                                    $quienRecibeNom = $sal->destino ?? 'N/A';
                                    if($sal->detalles->count() > 0 && $sal->detalles->first()->quienRecibe) {
                                        $quienRecibeNom = $sal->detalles->first()->quienRecibe->emple_nombres . ' ' . $sal->detalles->first()->quienRecibe->emple_apellidos;
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-orange-50 dark:bg-orange-900/30 text-xs font-black border border-orange-200 dark:border-orange-800 text-orange-800 dark:text-orange-300">
                                            {{ $sal->radicado ? $sal->radicado->num_radicado : 'SAL-N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $sal->quienEnvia ? $sal->quienEnvia->emple_nombres . ' ' . $sal->quienEnvia->emple_apellidos : 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $quienRecibeNom }}</td>
                                    <td class="px-6 py-4 italic text-gray-600 dark:text-gray-400">"{{ $sal->asunto }}"</td>
                                    <td class="px-6 py-4">{{ $sal->fecha ? \Carbon\Carbon::parse($sal->fecha)->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-black uppercase border bg-gray-100 text-gray-600 border-gray-200">
                                            {{ $sal->estadoEnvio ? $sal->estadoEnvio->estado_nomb : 'Sin estado' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $archivosSal = [
                                                'id' => $sal->id_envio,
                                                'tipo_cor' => 'Saliente',
                                                'radicado' => $sal->radicado?->num_radicado,
                                                'procedencia' => $sal->quienEnvia ? $sal->quienEnvia->emple_nombres . ' ' . $sal->quienEnvia->emple_apellidos : 'N/A',
                                                'destinatario' => $quienRecibeNom,
                                                'asunto' => $sal->asunto,
                                                'fecha' => $sal->fecha ? \Carbon\Carbon::parse($sal->fecha)->format('d/m/Y, h:i A') : 'N/A',
                                                'tipo_doc' => $sal->tipoEnvio ? $sal->tipoEnvio->tipo_nombre : 'Saliente',
                                                'estado' => $sal->estadoEnvio ? $sal->estadoEnvio->estado_nomb : 'Sin estado',
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
                                        <div class="flex items-center justify-center gap-1">
                                            <button onclick="abrirModalDetalle('{{ json_encode($archivosSal) }}')" class="p-1.5 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Ver Detalle">
                                                <span class="material-symbols-outlined">visibility</span>
                                            </button>
                                            <a href="{{ route('admin.correspondencia.historial_interna', $sal->id_envio) }}" class="p-1.5 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors" title="Ver Historial">
                                                <span class="material-symbols-outlined">history</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-10 text-center text-gray-500 italic">No hay registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $correspondenciasSalientes->appends(request()->except('sal_page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EXPORTAR -->
<div id="exportModalCor" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-xs p-6 transform transition-all">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tighter">Exportar Datos</h3>
            <button onclick="toggleModal('exportModalCor')" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                <span class="material-symbols-outlined text-gray-400">close</span>
            </button>
        </div>
        
        <div class="space-y-3">
            <a id="btnExportPdf" href="{{ route('admin.correspondencia.export.pdf', request()->all()) }}" 
                class="flex items-center gap-3 w-full px-4 py-3 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-700 dark:text-red-400 rounded-xl transition-all group border border-red-100 dark:border-red-900/50">
                <span class="material-symbols-outlined">picture_as_pdf</span>
                <span class="font-bold text-sm">Documento PDF</span>
                <span class="material-symbols-outlined text-xs ml-auto group-hover:translate-x-1 transition-transform">chevron_right</span>
            </a>
            
            <a id="btnExportExcel" href="{{ route('admin.correspondencia.export.excel', request()->all()) }}" 
                class="flex items-center gap-3 w-full px-4 py-3 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl transition-all group border border-emerald-100 dark:border-emerald-900/50">
                <span class="material-symbols-outlined">grid_on</span>
                <span class="font-bold text-sm">Hoja de Excel</span>
                <span class="material-symbols-outlined text-xs ml-auto group-hover:translate-x-1 transition-transform">chevron_right</span>
            </a>
        </div>
        
        <p class="mt-6 text-[10px] text-gray-400 font-medium text-center italic">
            * Los archivos reflejarán los filtros actuales
        </p>
    </div>
</div>

<!-- HISTORY MODAL -->
<div id="historyModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white dark:bg-slate-900 rounded-[1.5rem] shadow-2xl w-full max-w-xl max-h-[85vh] flex flex-col overflow-hidden transform transition-all">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
            <div>
                <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">Trazabilidad de Documento</h3>
                <p id="historyRadText" class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1"></p>
            </div>
            <button onclick="toggleModal('historyModal')" class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition-all"><span class="material-symbols-outlined">close</span></button>
        </div>
        <div id="historyTimeline" class="flex-1 overflow-y-auto custom-scrollbar p-8 space-y-6">
            <!-- Items via JS -->
        </div>
        <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex justify-end bg-gray-50/50 dark:bg-slate-800/80">
            <button type="button" onclick="toggleModal('historyModal')" class="px-6 py-2 bg-gray-100 dark:bg-slate-700 rounded-lg text-xs text-gray-600 dark:text-white font-black uppercase tracking-wider">Cerrar</button>
        </div>
    </div>
</div>

<div id="modalDetalleCor" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white dark:bg-slate-900 rounded-[1rem] shadow-xl w-full max-w-3xl flex flex-col max-h-[95vh] overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-black text-xs text-gray-400 uppercase tracking-widest flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-sm">description</span>
                Detalle de Correspondencia
            </h3>
            <button onclick="toggleModal('modalDetalleCor')" class="text-gray-400 hover:text-gray-600"><span class="material-symbols-outlined">close</span></button>
        </div>
        <div class="p-6 space-y-6 overflow-y-auto flex-1" id="modalDetalleContent"></div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end bg-gray-50 dark:bg-slate-800/80">
            <button type="button" onclick="toggleModal('modalDetalleCor')" class="px-6 py-2 bg-gray-200 dark:bg-slate-700 rounded-lg text-xs text-gray-800 dark:text-white font-black uppercase tracking-wider">Cerrar</button>
        </div>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    function openExportModalCor() { toggleModal('exportModalCor'); }
    function closeExportModalCor() { toggleModal('exportModalCor'); }

    function filtrarTabla(inputId, tableId) {
        const input = document.getElementById(inputId);
        const filter = input.value.toLowerCase();
        const table = document.getElementById(tableId);
        const tr = table.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) {
            let rowText = tr[i].textContent.toLowerCase();
            tr[i].style.display = rowText.includes(filter) ? "" : "none";
        }
    }

    function switchTab(tab) {
        const tabs = ['externa', 'interna', 'saliente'];
        const active = ['border-primary', 'text-primary'], inactive = ['border-transparent', 'text-gray-500'];
        tabs.forEach(t => {
            const btn = document.getElementById(t + '-tab');
            const target = document.getElementById(t);
            if (t === tab) {
                if (target) target.classList.remove('hidden');
                if (btn) { btn.classList.add(...active); btn.classList.remove(...inactive); }
            } else {
                if (target) target.classList.add('hidden');
                if (btn) { btn.classList.remove(...active); btn.classList.add(...inactive); }
            }
        });
        sessionStorage.setItem('activeCorrespondenceTab', tab);
        const tabInput = document.querySelector('input[name="tab"]');
        if (tabInput) tabInput.value = tab;
        actualizarUrlsExport(tab);
    }

    function actualizarUrlsExport(tab) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('tab', tab);
        const qs = urlParams.toString();
        const bPdf = '{{ route("admin.correspondencia.export.pdf") }}';
        const bExcel = '{{ route("admin.correspondencia.export.excel") }}';
        const pdf = document.getElementById('btnExportPdf');
        const excel = document.getElementById('btnExportExcel');
        if (pdf) pdf.href = bPdf + '?' + qs;
        if (excel) excel.href = bExcel + '?' + qs;
    }

    function abrirModalDetalle(json) {
        const d = JSON.parse(json);
        const cont = document.getElementById('modalDetalleContent');
        let html = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-5">
                    <div class="border-l-4 border-primary pl-3">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tipo de Trámite</h4>
                        <p class="text-lg font-black text-gray-800 dark:text-white">${d.tipo_cor}</p>
                        <p class="text-[11px] font-bold text-slate-400 italic">${d.tipo_doc || '-'}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase">Radicado Sistema</p>
                            <p class="text-sm font-black text-primary">${d.radicado}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase">Fecha Registro</p>
                            <p class="text-sm font-bold dark:text-gray-300">${d.fecha}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-gray-100 dark:border-slate-800">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Asunto</p>
                        <p class="text-sm italic text-gray-600 dark:text-gray-400 leading-relaxed">"${d.asunto}"</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-100 pb-1">Procedencia y Destino</h4>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-gray-400 uppercase">Remitente</p>
                                    <p class="text-xs font-bold dark:text-white">${d.procedencia}</p>
                                </div>
                            </div>
                            ${d.destinatario ? `
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                                    <span class="material-symbols-outlined text-sm">forward_to_inbox</span>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-gray-400 uppercase">Destinatario</p>
                                    <p class="text-xs font-bold dark:text-white">${d.destinatario}</p>
                                </div>
                            </div>` : ''}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-100 pb-1">Documentos y Anexos</h4>
                        <div class="space-y-2">
                             ${d.principal ? `
                             <a href="${d.principal}" target="_blank" class="flex items-center justify-between p-3 bg-primary/5 border border-primary/10 rounded-xl hover:bg-primary/10 transition-all group">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">picture_as_pdf</span>
                                    <span class="text-xs font-black text-primary">DOCUMENTO PRINCIPAL</span>
                                </div>
                                <span class="material-symbols-outlined text-xs text-primary/50 group-hover:translate-x-1 transition-transform">open_in_new</span>
                             </a>` : '<p class="text-[10px] text-gray-400 italic">Sin PDF principal</p>'}
                             
                             ${d.anexos && d.anexos.length > 0 ? `
                                <div class="pt-2 space-y-2">
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Anexos Adjuntos</p>
                                    ${d.anexos.map(ax => `
                                        <a href="${ax.ruta}" target="_blank" class="flex items-center justify-between p-2 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-lg hover:border-primary transition-all group">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-xs text-slate-400">attachment</span>
                                                <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300 truncate max-w-[200px]">${ax.nombre}</span>
                                            </div>
                                            <span class="material-symbols-outlined text-xs text-slate-300 group-hover:text-primary transition-colors">download</span>
                                        </a>
                                    `).join('')}
                                </div>
                             ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
        cont.innerHTML = html;
        toggleModal('modalDetalleCor');
    }

    function showHistory(radId, radNum, type) {
        if (!radId || radId === 'undefined') {
            alert('Este registro no tiene un radicado asociado para ver historial.');
            return;
        }

        const tl = document.getElementById('historyTimeline');
        const hText = document.getElementById('historyRadText');
        hText.innerText = `Radicado: ${radNum || 'N/A'}`;
        tl.innerHTML = '<div class="flex justify-center p-12"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div></div>';
        
        toggleModal('historyModal');

        fetch(`/admin/history/${radId}`)
            .then(res => res.json())
            .then(data => {
                if (!data || data.length === 0) {
                    tl.innerHTML = '<p class="text-center text-gray-400 italic">No hay historial disponible.</p>';
                    return;
                }

                let html = '';
                data.forEach((h, index) => {
                    const isLast = index === data.length - 1;
                    const date = new Date(h.fecha).toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                    
                    html += `
                        <div class="relative pl-8 ${!isLast ? 'pb-8' : ''}">
                            ${!isLast ? '<div class="absolute left-[11px] top-6 bottom-0 w-[2px] bg-slate-100 dark:bg-slate-800"></div>' : ''}
                            <div class="absolute left-0 top-0 w-6 h-6 rounded-full ${h.type === 'registry' ? 'bg-indigo-600 border-4 border-indigo-100' : 'bg-emerald-500 border-4 border-emerald-100'} z-10"></div>
                            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-black uppercase text-gray-400">${date}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase ${h.type === 'registry' ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600'}">${h.estado_nomb}</span>
                                </div>
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500">
                                        <span class="material-symbols-outlined text-[18px]">person</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black dark:text-gray-200">${h.nombres} ${h.apellidos}</span>
                                        <span class="text-[9px] text-gray-400 font-bold uppercase">${h.area_e || 'Funcionario'}</span>
                                    </div>
                                </div>
                                ${h.observaciones ? `<p class="text-[11px] text-gray-500 dark:text-gray-400 italic leading-relaxed bg-slate-50 dark:bg-slate-900/50 p-2 rounded-lg border border-slate-100 dark:border-slate-800">"${h.observaciones}"</p>` : ''}
                            </div>
                        </div>
                    `;
                });
                tl.innerHTML = html;
            })
            .catch(err => {
                tl.innerHTML = '<p class="text-center text-red-500 text-xs">Error cargando el historial.</p>';
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const u = new URLSearchParams(window.location.search);
        const t = u.get('tab') || sessionStorage.getItem('activeCorrespondenceTab') || 'externa';
        switchTab(t);
        // Inicializar Select2
        $('.select2').select2({ width: '100%', allowClear: true });
    });
</script>
@endsection

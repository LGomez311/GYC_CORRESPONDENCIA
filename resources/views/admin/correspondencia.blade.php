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

            <!-- Table Section Externa -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 font-medium">Radicados</th>
                                <th class="px-6 py-3 font-medium">Procedencia</th>
                                <th class="px-6 py-3 font-medium">Detalles Documento</th>
                                <th class="px-6 py-3 font-medium hidden lg:table-cell">Detalles Técnicos</th>
                                <th class="px-6 py-3 font-medium hidden lg:table-cell">Ingreso / Registro</th>
                                <th class="px-6 py-3 font-medium">Archivos / Anexos</th>
                                <th class="px-6 py-3 font-medium">Estado</th>
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
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-primary dark:text-blue-400">
                                            {{ $rec->radicado ? $rec->radicado->num_radicado : 'S/R' }}
                                        </div>
                                        @if($rec->num_radicado_ext)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">EXT: {{ $rec->num_radicado_ext }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 mb-1 max-w-[200px] whitespace-normal break-words">{{ $rec->asunto }}</div>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
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
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $rec->fecha_hora_recib ? \Carbon\Carbon::parse($rec->fecha_hora_recib)->format('d M Y') : 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                         @php
                                             $archivosDatos = [
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
                                         <button type="button" data-archivos="{{ json_encode($archivosDatos) }}" onclick="abrirModalArchivos(this.dataset.archivos)" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-400 rounded-md transition-colors shadow-sm">
                                             <span class="material-symbols-outlined text-[16px]">folder_open</span> Ver Docs
                                         </button>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $bgClass = 'bg-gray-100 text-gray-800';
                                            if (str_contains($estadoNombL, 'recibido')) $bgClass = 'bg-blue-100 text-blue-800';
                                            elseif (str_contains($estadoNombL, 'tramite') || str_contains($estadoNombL, 'trámite')) $bgClass = 'bg-yellow-100 text-yellow-800';
                                            elseif (str_contains($estadoNombL, 'finalizado')) $bgClass = 'bg-green-100 text-green-800';
                                        @endphp
                                        <div class="flex flex-col gap-2 items-start">
                                            <span class="px-2 py-0.5 rounded-full text-xs {{ $bgClass }}">{{ $rec->estado ? $rec->estado->estado_nomb : 'Sin estado' }}</span>
                                            <a href="{{ route('admin.correspondencia.historial_externa', $rec->id_recibido) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-primary hover:text-blue-800 transition-colors">
                                                <span class="material-symbols-outlined text-[14px]">history</span> Ver Historial
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
                    {{ $correspondencias->appends(['int_page' => request('int_page'), 'tab' => 'externa'])->links() }}
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

            <!-- Table Section Interna -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 font-medium">Radicado</th>
                                <th class="px-6 py-3 font-medium">De / Remitente</th>
                                <th class="px-6 py-3 font-medium">Para / Destinatario</th>
                                <th class="px-6 py-3 font-medium">Asunto</th>
                                <th class="px-6 py-3 font-medium">Fecha</th>
                                <th class="px-6 py-3 font-medium">Documentos</th>
                                <th class="px-6 py-3 font-medium">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($correspondenciasInternas as $int)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors align-top">
                                    <td class="px-6 py-4 font-medium text-primary">{{ $int->radicado ? $int->radicado->num_radicado : 'INT-N/A' }}</td>
                                    <td class="px-6 py-4">{{ $int->quienEnvia ? $int->quienEnvia->emple_nombres . ' ' . $int->quienEnvia->emple_apellidos : 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        @if($int->detalles->count() > 0)
                                            {{ $int->detalles->first()->quienRecibe ? $int->detalles->first()->quienRecibe->emple_nombres : 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $int->asunto }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($int->fecha)->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $archivosInt = [
                                                'principal' => $int->archivo ? asset('storage/' . $int->archivo) : null,
                                                'anexos' => [],
                                                'folios' => $int->folio
                                            ];
                                            // Anexos del documento principal
                                            if ($int->anexos) {
                                                foreach($int->anexos as $ax) {
                                                    $archivosInt['anexos'][] = ['nombre' => $ax->nombre_original, 'ruta' => asset('storage/' . $ax->ruta_archivo)];
                                                }
                                            }
                                            // Anexos de respuestas/trazabilidad
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
                                        <button type="button" data-archivos="{{ json_encode($archivosInt) }}" onclick="abrirModalArchivos(this.dataset.archivos)" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">folder_open</span> Docs
                                        </button>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2 items-start">
                                            <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-800">{{ $int->estadoEnvio ? $int->estadoEnvio->estado_nomb : 'Sin estado' }}</span>
                                            <a href="{{ route('admin.correspondencia.historial_interna', $int->id_envio) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-primary hover:text-blue-800 transition-colors">
                                                <span class="material-symbols-outlined text-[14px]">history</span> Ver Historial
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

</div>

<!-- Modal Ver Archivos (Unificado) -->
<div id="modalArchivos" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white dark:bg-slate-900 rounded-[1rem] shadow-xl w-full max-w-2xl flex flex-col max-h-[90vh] overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-lg text-gray-800 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">folder_open</span>
                Documentos y Anexos
            </h3>
            <button onclick="toggleModal('modalArchivos')" class="text-gray-400 hover:text-gray-600"><span class="material-symbols-outlined">close</span></button>
        </div>
        <div class="p-6 space-y-4 overflow-y-auto flex-1" id="modalArchivosContent"></div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end bg-gray-50"><button type="button" onclick="toggleModal('modalArchivos')" class="px-4 py-2 bg-gray-200 rounded-lg text-sm text-gray-800">Cerrar</button></div>
    </div>
</div>

<!-- Modal Exportar -->
<div id="exportModalCor" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5 relative">
        <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Exportar Correspondencia</h3>
        <div class="flex flex-col gap-3">
            <a href="{{ route('admin.correspondencia.export.pdf') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:text-white"><span class="material-symbols-outlined text-red-600">picture_as_pdf</span> PDF</a>
            <a href="{{ route('admin.correspondencia.export.excel') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:text-white"><span class="material-symbols-outlined text-green-600">grid_on</span> Excel</a>
        </div>
        <button onclick="closeExportModalCor()" class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700">Cancelar</button>
    </div>
</div>

<script>
    function toggleModal(id) { document.getElementById(id).classList.toggle('hidden'); }

    function switchTab(tab) {
        const extBtn = document.getElementById('externa-tab'), intBtn = document.getElementById('interna-tab');
        const extContent = document.getElementById('externa'), intContent = document.getElementById('interna');
        const active = ['border-primary', 'text-primary'], inactive = ['border-transparent', 'text-gray-500'];

        if (tab === 'externa') {
            extContent.classList.remove('hidden'); intContent.classList.add('hidden');
            extBtn.classList.add(...active); extBtn.classList.remove(...inactive);
            intBtn.classList.add(...inactive); intBtn.classList.remove(...active);
        } else {
            intContent.classList.remove('hidden'); extContent.classList.add('hidden');
            intBtn.classList.add(...active); intBtn.classList.remove(...inactive);
            extBtn.classList.add(...inactive); extBtn.classList.remove(...active);
        }
        sessionStorage.setItem('activeCorrespondenceTab', tab);
    }

    function abrirModalArchivos(datosJson) {
        const datos = JSON.parse(datosJson);
        const container = document.getElementById('modalArchivosContent');
        let html = '<div class="space-y-4">';

        if (datos.principal) {
            html += `<div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg border">
                        <span class="text-sm font-medium">Documento Principal</span>
                        <a href="${datos.principal}" target="_blank" class="px-3 py-1 bg-blue-50 text-blue-700 rounded text-xs">Ver archivo</a>
                     </div>`;
        }

        if (datos.anexo_texto) html += `<p class="text-sm text-gray-600"><strong>Anexo Físico:</strong> ${datos.anexo_texto}</p>`;
        if (datos.folios > 0) html += `<p class="text-sm text-gray-600"><strong>Folios:</strong> ${datos.folios}</p>`;

        if (datos.anexos && datos.anexos.length > 0) {
            html += `<h4 class="text-xs font-bold text-gray-500 uppercase">Anexos digitales</h4><div class="grid grid-cols-1 gap-2">`;
            datos.anexos.forEach(ax => {
                html += `<a href="${ax.ruta}" target="_blank" class="flex items-center gap-2 p-2 border rounded hover:bg-gray-50 text-sm"><span class="material-symbols-outlined text-gray-400">attachment</span> ${ax.nombre}</a>`;
            });
            html += `</div>`;
        }
        html += '</div>';
        container.innerHTML = html;
        toggleModal('modalArchivos');
    }

    function openExportModalCor() { document.getElementById('exportModalCor').classList.remove('hidden'); }
    function closeExportModalCor() { document.getElementById('exportModalCor').classList.add('hidden'); }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab') || sessionStorage.getItem('activeCorrespondenceTab') || 'externa';
        if (tab) switchTab(tab);
    });
</script>

@endsection

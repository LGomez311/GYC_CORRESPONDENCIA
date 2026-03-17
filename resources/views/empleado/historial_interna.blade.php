@extends('empleado.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs">
                    <li class="inline-flex items-center">
                        <a href="{{ route('empleado.envios_internos') }}" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-white">Mis Envíos Internos</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-sm text-gray-400">chevron_right</span>
                            <span class="ml-1 text-gray-500 dark:text-gray-400">Detalle Seguimiento</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-3xl text-primary">history_edu</span>
                Detalle y Trazabilidad de Respuesta
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Consulta el flujo completo y las respuestas del radicado <span class="font-bold text-primary">{{ $detalle->envio->radicado->num_radicado ?? 'S/R' }}</span>
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('empleado.envios_internos') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Regresar a Mis Envíos
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Izquierda: Información del Documento -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2 text-sm uppercase tracking-wider">
                        <span class="material-symbols-outlined text-blue-500 text-[18px]">info</span>
                        Información General
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Asunto</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $detalle->envio->asunto }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Tipo</p>
                            <p class="text-sm text-gray-800 dark:text-gray-200">{{ $detalle->envio->tipoEnvio->tipo_nombre ?? 'Interno' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Folios</p>
                            <p class="text-sm text-gray-800 dark:text-gray-200">{{ $detalle->envio->folio }}</p>
                        </div>
                    </div>
                    <hr class="border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Remitente</p>
                        <div class="flex items-center gap-3 mt-1">
                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xs font-bold">
                                {{ substr($detalle->quienEnvia->emple_nombres, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium dark:text-white">{{ $detalle->quienEnvia->emple_nombres }} {{ $detalle->quienEnvia->emple_apellidos }}</p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ $detalle->quienEnvia->area->area_nom ?? 'Sin Área' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Fecha Envío</p>
                        <p class="text-sm text-gray-800 dark:text-gray-200 flex items-center gap-2 mt-1">
                            <span class="material-symbols-outlined text-[16px] text-gray-400">calendar_month</span>
                            {{ $detalle->envio->fecha->format('d/m/Y h:i A') }}
                        </p>
                    </div>
                    @if($detalle->envio->archivo)
                        <div class="pt-2">
                            <a href="{{ asset('storage/' . $detalle->envio->archivo) }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-primary/10 text-primary dark:bg-blue-900/20 dark:text-blue-400 rounded-lg text-xs font-bold hover:bg-primary hover:text-white dark:hover:bg-blue-600 dark:hover:text-white transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                VER DOCUMENTO ORIGINAL
                            </a>
                        </div>
                    @endif

                    @if($detalle->envio->anexos && $detalle->envio->anexos->count() > 0)
                        <div class="space-y-2 mt-4">
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">attachment</span>
                                Anexos Digitales
                            </p>
                            <div class="grid grid-cols-1 gap-2">
                                @foreach($detalle->envio->anexos as $anexo)
                                    <a href="{{ asset('storage/' . $anexo->ruta_archivo) }}" target="_blank" class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-gray-700 rounded-lg hover:border-blue-400 transition-colors group">
                                        <span class="material-symbols-outlined text-[18px] text-gray-400 group-hover:text-blue-500">description</span>
                                        <span class="text-[11px] font-medium text-gray-700 dark:text-gray-300 truncate" title="{{ $anexo->nombre_original }}">{{ $anexo->nombre_original }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Listado de Destinatarios y su estado actual -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2 text-sm uppercase tracking-wider">
                        <span class="material-symbols-outlined text-green-500 text-[18px]">group</span>
                        Destinatarios ({{ $destinatarios->count() }})
                    </h3>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($destinatarios as $dest_id => $trazas)
                            @php 
                                $ultimo = $trazas->last();
                                $estadoNomb = strtolower($ultimo->estado?->estado_nomb ?? '');
                                $badgeClass = 'bg-gray-100 text-gray-600';
                                if(str_contains($estadoNomb, 'recibido')) $badgeClass = 'bg-blue-100 text-blue-700';
                                elseif(str_contains($estadoNomb, 'tramite') || str_contains($estadoNomb, 'trámite')) $badgeClass = 'bg-yellow-100 text-yellow-700';
                                elseif(str_contains($estadoNomb, 'finalizado') || str_contains($estadoNomb, 'resuelto')) $badgeClass = 'bg-green-100 text-green-700';
                                elseif(str_contains($estadoNomb, 'rechazado')) $badgeClass = 'bg-red-100 text-red-700';
                            @endphp
                            <li class="p-4 hover:bg-gray-50 dark:hover:bg-slate-900 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-[18px] text-gray-400">person</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold dark:text-white">{{ $ultimo->quienRecibe->emple_nombres }}</p>
                                            <p class="text-[10px] text-gray-500">{{ $ultimo->quienRecibe->area->area_nom ?? 'Sin Área' }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $badgeClass }}">
                                        {{ $ultimo->estado?->estado_nomb ?? 'N/A' }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Timeline de Trazabilidad -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="font-bold text-lg dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                        Línea de Vida del Documento
                    </h2>
                </div>
                
                <div class="p-8">
                    <div class="relative border-l-2 border-gray-100 dark:border-gray-700 ml-4 space-y-10 pb-4">
                        @foreach($trazabilidad as $trace)
                            @php
                                $estadoTrace = strtolower($trace->estado?->estado_nomb ?? '');
                                $pointColor = 'bg-gray-300';
                                $icon = 'radio_button_checked';
                                if(str_contains($estadoTrace, 'recibido')) { $pointColor = 'bg-blue-500'; $icon = 'mark_email_read'; }
                                elseif(str_contains($estadoTrace, 'tramite')) { $pointColor = 'bg-yellow-500'; $icon = 'pending'; }
                                elseif(str_contains($estadoTrace, 'finalizado') || str_contains($estadoTrace, 'resuelto')) { $pointColor = 'bg-green-500'; $icon = 'verified'; }
                                elseif(str_contains($estadoTrace, 'archivado')) { $pointColor = 'bg-slate-500'; $icon = 'archive'; }
                                elseif(str_contains($estadoTrace, 'rechazado')) { $pointColor = 'bg-red-500'; $icon = 'cancel'; }
                            @endphp
                            <div class="relative pl-10">
                                <!-- Indicador Timeline -->
                                <div class="absolute -left-[11px] top-0 w-5 h-5 rounded-full {{ $pointColor }} ring-4 ring-white dark:ring-slate-800 flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined text-white text-[12px]">{{ $icon }}</span>
                                </div>

                                <div class="bg-gray-50 dark:bg-slate-900/50 rounded-xl p-5 border border-gray-100 dark:border-gray-700 group hover:shadow-md transition-shadow">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="px-3 py-1 bg-white dark:bg-slate-800 rounded-full text-xs font-bold text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                                {{ $trace->estado?->estado_nomb ?? 'Cambio de Estado' }}
                                            </span>
                                            <span class="text-[11px] text-gray-400 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">calendar_month</span>
                                                {{ $trace->fecha_traslado->translatedFormat('d M, Y - h:i A') }}
                                            </span>
                                        </div>
                                        <span class="text-[11px] font-bold text-primary dark:text-blue-400 bg-primary/5 px-2 py-0.5 rounded">
                                            {{ $trace->quienRecibe->emple_nombres }}
                                        </span>
                                        @if($trace->id_estado_rec == 11 && Auth::user()->emple_doc == $detalle->envio->doc_quien_envia)
                                            @if($trace->id_detalle == $destinatarios[$trace->id_quien_recibe]->last()->id_detalle)
                                                <button onclick="abrirModalGestionRechazo({{ $trace->id_detalle }}, '{{ $trace->quienRecibe->emple_nombres }}')" 
                                                    class="px-3 py-1 bg-red-600 text-white rounded text-[10px] font-bold hover:bg-red-700 transition-colors shadow-sm flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">settings_backup_restore</span>
                                                    Gestionar Rechazo
                                                </button>
                                            @else
                                                <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-gray-500 rounded text-[10px] font-bold flex items-center gap-1 cursor-not-allowed">
                                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                                    Rechazo Gestionado
                                                </span>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Observaciones -->
                                    <div class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                        @if($trace->observaciones)
                                            "{{ $trace->observaciones }}"
                                        @else
                                            <span class="opacity-40 italic">Sin observaciones adicionales.</span>
                                        @endif
                                    </div>

                                    <!-- Archivos de Respuesta -->
                                    @if($trace->archivo_respuesta || $trace->anexosRespuesta->count() > 0)
                                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @if($trace->archivo_respuesta)
                                                <a href="{{ asset('storage/' . $trace->archivo_respuesta) }}" target="_blank" class="{{ $trace->id_quien_envie == $detalle->envio->doc_quien_envia ? 'hover:border-blue-500' : 'hover:border-green-500' }} flex items-center gap-3 p-3 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg transition-colors group/file">
                                                    <div class="w-10 h-10 rounded bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600">
                                                        <span class="material-symbols-outlined text-2xl">picture_as_pdf</span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-bold dark:text-white truncate">
                                                            {{ $trace->id_quien_envie == $detalle->envio->doc_quien_envia ? 'Documento Principal Corregido.pdf' : 'Respuesta Principal.pdf' }}
                                                        </p>
                                                        <p class="text-[10px] text-gray-400 uppercase font-bold {{ $trace->id_quien_envie == $detalle->envio->doc_quien_envia ? 'text-blue-500' : 'text-green-500' }}">
                                                            {{ $trace->id_quien_envie == $detalle->envio->doc_quien_envia ? 'Documento Corregido (Reenvío)' : 'Documento de Cierre' }}
                                                        </p>
                                                    </div>
                                                </a>
                                            @endif

                                            @foreach($trace->anexosRespuesta as $anexo)
                                                <a href="{{ asset('storage/' . $anexo->ruta_archivo) }}" target="_blank" class="flex items-center gap-3 p-3 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-500 transition-colors group/file">
                                                    <div class="w-10 h-10 rounded bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                                                        <span class="material-symbols-outlined text-2xl">attachment</span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-bold dark:text-white truncate">{{ $anexo->nombre_original }}</p>
                                                        <p class="text-[10px] text-gray-400 uppercase font-bold {{ $trace->id_quien_envie == $detalle->envio->doc_quien_envia ? 'text-blue-500' : '' }}">
                                                            {{ $trace->id_quien_envie == $detalle->envio->doc_quien_envia ? 'Anexo Corrección' : 'Anexo Adjunto' }}
                                                        </p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                        <div class="mt-3 text-[10px] text-right font-medium text-gray-400">
                                            Total folios reportados: <span class="text-gray-600 dark:text-gray-300">{{ $trace->folios_respuesta ?? 0 }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Information Footer (Dinámico) -->
            @php
                $todosFinalizados = true;
                foreach($destinatarios as $id_recibe => $trazas) {
                    $u = $trazas->last();
                    $est = strtolower($u->estado?->estado_nomb ?? '');
                    if(!str_contains($est, 'finalizado') && !str_contains($est, 'resuelto') && !str_contains($est, 'archivado') && !str_contains($est, 'rechazado')) {
                        $todosFinalizados = false;
                        break;
                    }
                }
            @endphp

            @if($todosFinalizados)
                <div class="bg-green-600 rounded-xl p-6 text-white flex items-center gap-6 shadow-lg">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-4xl">check_circle</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold">Proceso Consolidado</h4>
                        <p class="text-sm opacity-90">Todos los destinatarios han dado respuesta a esta correspondencia. El radicado se encuentra totalmente gestionado.</p>
                    </div>
                </div>
            @else
                <div class="bg-blue-600 rounded-xl p-6 text-white flex items-center gap-6 shadow-lg">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-4xl">pending_actions</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold">Seguimiento en Curso</h4>
                        <p class="text-sm opacity-90">Esta correspondencia aún tiene respuestas pendientes por parte de algunos integrantes. Puedes continuar haciendo seguimiento desde esta vista.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Gestión de Rechazo -->
<div id="modalGestionRechazo" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl w-full max-w-lg overflow-hidden flex flex-col">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-red-50 dark:bg-red-900/20">
            <h3 class="font-bold text-lg text-red-800 dark:text-red-400 flex items-center gap-2">
                <span class="material-symbols-outlined text-[24px]">gavel</span>
                Gestionar Rechazo de <span id="gestionNombreDestinatario"></span>
            </h3>
            <button onclick="toggleModal('modalGestionRechazo')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form action="{{ route('empleado.gestionar_rechazo_interna') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_detalle" id="gestionIdDetalle">
            
            <div class="p-6 space-y-5 overflow-y-auto max-h-[70vh]">
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">¿Qué acción deseas tomar?</label>
                    <div class="grid grid-cols-1 gap-3">
                        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-800 cursor-pointer transition-colors">
                            <input type="radio" name="accion" value="finalizar" required class="w-4 h-4 text-primary" onchange="toggleAccionGestion(this.value)">
                            <div class="ml-3">
                                <span class="block text-sm font-bold dark:text-white">Finalizar trámite</span>
                                <span class="block text-xs text-gray-500">Aceptar el rechazo y dar por terminado este hilo de respuesta.</span>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-800 cursor-pointer transition-colors">
                            <input type="radio" name="accion" value="reenviar" class="w-4 h-4 text-primary" onchange="toggleAccionGestion(this.value)">
                            <div class="ml-3">
                                <span class="block text-sm font-bold dark:text-white">Corregir y Reenviar</span>
                                <span class="block text-xs text-gray-500">Actualizar el documento y volver a enviarlo al mismo destinatario.</span>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-800 cursor-pointer transition-colors">
                            <input type="radio" name="accion" value="reasignar" class="w-4 h-4 text-primary" onchange="toggleAccionGestion(this.value)">
                            <div class="ml-3">
                                <span class="block text-sm font-bold dark:text-white">Reasignar a otro colaborador</span>
                                <span class="block text-xs text-gray-500">Enviar esta correspondencia a una persona distinta.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Campo dinámico: Archivos (Principal y Anexos) -->
                <div id="gestionArchivoContainer" class="hidden animate-fade-in space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nuevo Documento Principal (Opcional, Max 5MB)</label>
                        <input type="file" name="archivo_nuevo" id="archivo_nuevo_gestion" accept=".pdf" onchange="window.handleFileSelectAndCount(event, 'folios_nuevos_gestion')" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 transition-colors">
                        <p class="mt-1 text-[10px] text-gray-500">Si subes un archivo, este reemplazará al archivo principal anterior.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anexos Adicionales (Opcional, Max 25MB c/u)</label>
                        <input type="file" name="anexos_nuevos[]" id="anexos_nuevos_gestion" accept=".pdf" multiple onchange="window.handleMultipleFilesAndCount(event, 'folios_nuevos_gestion')" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-slate-600 file:text-white hover:file:bg-slate-700 file:cursor-pointer cursor-pointer border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 transition-colors">
                        <p class="mt-1 text-[10px] text-gray-500">Los anexos subidos se sumarán a los ya existentes (si no se especifica, se mantienen los anteriores).</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Folios Totales</label>
                        <input type="number" name="folios_nuevos" id="folios_nuevos_gestion" value="{{ $detalle->envio->folio }}" class="w-24 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-slate-800 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50 text-center font-bold" min="0" readonly>
                        <p class="mt-1 text-[10px] text-gray-500">Se actualizan automáticamente al seleccionar PDFs.</p>
                    </div>
                </div>

                <!-- Campo dinámico: Nuevo Destinatario -->
                <div id="gestionReasignarContainer" class="hidden animate-fade-in">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nuevo Destinatario <span class="text-red-500">*</span></label>
                    <select name="id_nuevo_destinatario" id="selectNuevoDestinatario" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50">
                        <option value="">Seleccione el nuevo responsable...</option>
                        @foreach($empleados ?? [] as $emp)
                            <option value="{{ $emp->emple_doc }}">{{ $emp->emple_nombres }} {{ $emp->emple_apellidos }} ({{ $emp->area->area_nom ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observaciones <span class="text-red-500">*</span></label>
                    <textarea name="observaciones" required rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-slate-900 dark:text-white py-2 px-3 text-sm focus:ring-2 focus:ring-primary/50" placeholder="Explique la decisión tomada..."></textarea>
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-slate-800/50">
                <button type="button" onclick="toggleModal('modalGestionRechazo')" class="px-4 py-2 border border-blue-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-xl text-sm font-medium hover:bg-red-700 transition-colors shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">send_and_archive</span>
                    Confirmar Acción
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.toggle('hidden');
        }
    }

    function abrirModalGestionRechazo(idDetalle, nombre) {
        document.getElementById('gestionIdDetalle').value = idDetalle;
        document.getElementById('gestionNombreDestinatario').innerText = nombre;
        toggleModal('modalGestionRechazo');
    }

    function toggleAccionGestion(accion) {
        const archivoContainer = document.getElementById('gestionArchivoContainer');
        const reasignarContainer = document.getElementById('gestionReasignarContainer');
        const selectDest = document.getElementById('selectNuevoDestinatario');
        
        // Reset inputs when changing action
        document.getElementById('archivo_nuevo_gestion').value = '';
        document.getElementById('anexos_nuevos_gestion').value = '';
        document.getElementById('folios_nuevos_gestion').value = '{{ $detalle->envio->folio }}'; // Reset to original

        if (accion === 'reenviar') {
            archivoContainer.classList.remove('hidden');
            reasignarContainer.classList.add('hidden');
            selectDest.removeAttribute('required');
        } else if (accion === 'reasignar') {
            archivoContainer.classList.add('hidden');
            reasignarContainer.classList.remove('hidden');
            selectDest.setAttribute('required', 'required');
        } else {
            archivoContainer.classList.add('hidden');
            reasignarContainer.classList.add('hidden');
            selectDest.removeAttribute('required');
        }
    }
</script>

<!-- Script para PDF.js y Conteo de Folios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    // Configurar worker de PDF.js
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

    async function contarPaginasPDF(file) {
        if (!file || file.type !== 'application/pdf') return 0;
        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
            return pdf.numPages;
        } catch (error) {
            console.error('Error al leer el PDF:', error);
            return 0;
        }
    }

    window.handleFileSelectAndCount = async function(event, foliosInputId) {
        const foliosInput = document.getElementById(foliosInputId);
        if (!foliosInput) return;
        
        let totalPages = 0;
        
        // Count main file
        const mainInput = document.getElementById('archivo_nuevo_gestion');
        if (mainInput && mainInput.files && mainInput.files.length > 0) {
            const file = mainInput.files[0];
            if (file.size > 5 * 1024 * 1024) {
                alert('El documento principal no debe superar los 5MB.');
                mainInput.value = '';
                return;
            }
            const pages = await contarPaginasPDF(file);
            totalPages += pages;
        }
        
        // Count anexos
        const anexosInput = document.getElementById('anexos_nuevos_gestion');
        if (anexosInput && anexosInput.files && anexosInput.files.length > 0) {
            for (let i = 0; i < anexosInput.files.length; i++) {
                const file = anexosInput.files[i];
                if (file.size > 25 * 1024 * 1024) {
                    alert('Cada anexo no debe superar los 25MB.');
                    anexosInput.value = '';
                    continue;
                }
                const pages = await contarPaginasPDF(file);
                totalPages += pages;
            }
        }
        
        if (totalPages > 0) {
            foliosInput.value = totalPages;
            foliosInput.classList.add('ring-2', 'ring-green-400', 'bg-green-50', 'dark:bg-green-900/20');
            setTimeout(() => {
                foliosInput.classList.remove('ring-2', 'ring-green-400', 'bg-green-50', 'dark:bg-green-900/20');
            }, 1000);
        } else {
            // Revert back to original folios if no new files
            foliosInput.value = '{{ $detalle->envio->folio }}';
        }
    };
    
    window.handleMultipleFilesAndCount = window.handleFileSelectAndCount;

</script>

@endsection

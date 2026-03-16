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
                            <a href="{{ asset('storage/' . $detalle->envio->archivo) }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-primary/10 text-primary dark:bg-blue-900/20 dark:text-blue-400 rounded-lg text-xs font-bold hover:bg-primary hover:text-white dark:hover:bg-blue-600 dark:hover:text-white transition-all">
                                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                VER DOCUMENTO ORIGINAL
                            </a>
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
                                                <a href="{{ asset('storage/' . $trace->archivo_respuesta) }}" target="_blank" class="flex items-center gap-3 p-3 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-green-500 transition-colors group/file">
                                                    <div class="w-10 h-10 rounded bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600">
                                                        <span class="material-symbols-outlined text-2xl">picture_as_pdf</span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-bold dark:text-white truncate">Respuesta Principal.pdf</p>
                                                        <p class="text-[10px] text-gray-400 uppercase">Documento de Cierre</p>
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
                                                        <p class="text-[10px] text-gray-400 uppercase">Anexo Adjunto</p>
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
@endsection

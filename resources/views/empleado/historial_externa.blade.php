@extends('empleado.layouts.app')

@section('content')

<style>
    /* 
       SECCIÓN DE ESTILOS DE IMPRESIÓN
       Configura cómo se verá el documento al ser impreso, ocultando elementos interactivos
       y ajustando el diseño para que quepa en una hoja de papel.
    */
    @media print {
        /* Hide all interactive elements */
        aside, nav, header, button, input, select, .no-print,
        [id^="btn-"], .flex.gap-2, .transition-all {
            display: none !important;
        }

        /* Show print content */
        .overflow-y-auto, .max-h-\[60vh\],
        .max-h-\[calc\(100vh-280px\)\] {
            overflow: visible !important;
            max-height: none !important;
        }

        body {
            background-color: white !important;
            color: #1a1a1a !important;
            font-size: 11pt;
            margin: 10mm;
        }

        .space-y-6 { display: block; }
        .grid { display: block !important; }
        .lg\:col-span-1, .lg\:col-span-2 { width: 100% !important; }

        /* Card styles */
        .bg-white { background-color: white !important; }
        .dark\:bg-slate-800 { background-color: white !important; }
        .rounded-xl { page-break-inside: avoid; }

        /* Header */
        h1, h2 { 
            font-size: 16pt !important;
            font-weight: bold !important;
            margin: 15pt 0 10pt 0 !important;
            color: #1a1a1a !important;
        }

        h3 { 
            font-size: 12pt !important;
            font-weight: bold !important;
            margin: 10pt 0 5pt 0 !important;
        }

        /* Info boxes */
        .p-5, .p-4 { page-break-inside: avoid; }

        /* Timeline */
        .relative.border-l-2 { border-left: 2px solid #333 !important; }
        .bg-gray-50, .bg-slate-50 { background-color: #f5f5f5 !important; }

        /* Lists */
        ul, li { margin: 5pt 0 !important; }

        /* Links and text */
        a { 
            color: #0066cc !important; 
            text-decoration: underline !important;
        }

        /* Status badges */
        .px-3.py-1 { 
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            border: 1px solid #333;
            display: inline-block;
        }

        /* Hidden elements visibility */
        .hidden.lg\:table-cell,
        .hidden.md\:table-cell,
        .hidden.sm\:table-cell { 
            display: table-cell !important; 
        }

        /* Dark mode override */
        .dark\:text-white, .text-white { color: #1a1a1a !important; }
        .dark\:text-gray-300, .text-gray-300 { color: #333 !important; }
        .dark\:bg-slate-900 { background-color: white !important; }
        .dark\:border-gray-700 { border-color: #333 !important; }
    }
</style>

    <div class="space-y-6">
        <!-- 
            ENCABEZADO DE LA PÁGINA 
            Contiene el breadcrumb (ruta de navegación), el título principal y los botones de acción (Imprimir y Regresar).
        -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs">
                        <li class="inline-flex items-center">
                            <a href="{{ route('empleado.correspondencia_recibida') }}"
                                class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-white">Correspondencia Recibida</a>
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
                    Detalle y Seguimiento de Correspondencia Externa
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Consulta el flujo completo y las respuestas del radicado <span
                        class="font-bold text-primary">{{ $detalle->recibido->radicado->num_radicado ?? 'S/R' }}</span>
                </p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    Imprimir
                </button>
                <a href="{{ route('empleado.correspondencia_recibida') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Regresar a Bandeja
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- 
                COLUMNA IZQUIERDA: INFORMACIÓN DETALLADA DEL DOCUMENTO 
                Muestra los datos técnicos del radicado, el remitente y los archivos adjuntos.
            -->
            <div class="lg:col-span-1 space-y-6">
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-900/50">
                        <h3
                            class="font-bold text-gray-900 dark:text-white flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="material-symbols-outlined text-blue-500 text-[18px]">info</span>
                            Información General
                        </h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Asunto</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $detalle->recibido->asunto }}
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Tipo</p>
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    {{ $detalle->recibido->tipo->tipo_nombre ?? 'Externo' }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Folios</p>
                                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $detalle->recibido->folio }}</p>
                            </div>
                        </div>
                        <hr class="border-gray-100 dark:border-gray-700">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Procedencia / Remitente</p>
                            <div class="flex items-start gap-3 mt-1">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xs font-bold shrink-0">
                                    <span class="material-symbols-outlined text-sm">{{ !empty($detalle->recibido->nom_institucion) ? 'business' : 'person' }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium dark:text-white break-words">
                                        {{ !empty($detalle->recibido->nom_institucion) ? $detalle->recibido->nom_institucion : ($detalle->recibido->nombre_persona ?? $detalle->recibido->doc_persona) }}
                                    </p>
                                    @if($detalle->recibido->ciudad)
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                                            {{ $detalle->recibido->ciudad->ciudad_nom }} • {{ $detalle->recibido->nit_persona ?? 'S/N' }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase">Fecha Registro</p>
                            <p class="text-sm text-gray-800 dark:text-gray-200 flex items-center gap-2 mt-1">
                                <span class="material-symbols-outlined text-[16px] text-gray-400">calendar_month</span>
                                {{ $detalle->recibido->fecha_hora_recib->format('d/m/Y h:i A') }}
                            </p>
                        </div>
                        @if ($detalle->recibido->archivo)
                            <div class="pt-2">
                                <a href="{{ asset('storage/' . $detalle->recibido->archivo) }}" target="_blank"
                                    class="flex items-center justify-center gap-2 w-full py-2 bg-primary/10 text-primary dark:bg-blue-900/20 dark:text-blue-400 rounded-lg text-xs font-bold hover:bg-primary hover:text-white dark:hover:bg-blue-600 dark:hover:text-white transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                    VER DOCUMENTO ORIGINAL
                                </a>
                            </div>
                        @endif

                        @if ($detalle->recibido->anexos && $detalle->recibido->anexos->count() > 0)
                            <div class="space-y-2 mt-4">
                                <p
                                    class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">attachment</span>
                                    Anexos Digitales
                                </p>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach ($detalle->recibido->anexos as $anexo)
                                        <a href="{{ asset('storage/' . $anexo->ruta_archivo) }}" target="_blank"
                                            class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-gray-700 rounded-lg hover:border-blue-400 transition-colors group">
                                            <span
                                                class="material-symbols-outlined text-[18px] text-gray-400 group-hover:text-blue-500">description</span>
                                            <span class="text-[11px] font-medium text-gray-700 dark:text-gray-300 truncate"
                                                title="{{ $anexo->nombre_original }}">{{ $anexo->nombre_original }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 
                    LISTADO DE COLABORADORES
                    Identifica a las personas asignadas a este radicado y el estado actual de su gestión individual.
                -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-900/50">
                        <h3
                            class="font-bold text-gray-900 dark:text-white flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="material-symbols-outlined text-green-500 text-[18px]">group</span>
                            Colaboradores en el Radicado ({{ $destinatarios->count() }})
                        </h3>
                    </div>
                    <div class="p-0">
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($destinatarios as $dest_id => $trazas)
                                @php
                                    $ultimo = $trazas->last();
                                    $estadoNomb = strtolower($ultimo->titulo ?? '');
                                    $badgeClass = 'bg-gray-100 text-gray-600';
                                    if (str_contains($estadoNomb, 'recibido')) {
                                        $badgeClass = 'bg-blue-100 text-blue-700';
                                    } elseif (
                                        str_contains($estadoNomb, 'tramite') ||
                                        str_contains($estadoNomb, 'trámite')
                                    ) {
                                        $badgeClass = 'bg-yellow-100 text-yellow-700';
                                    } elseif (
                                        str_contains($estadoNomb, 'finalizado') ||
                                        str_contains($estadoNomb, 'resuelto')
                                    ) {
                                        $badgeClass = 'bg-green-100 text-blue-700';
                                    } elseif (str_contains($estadoNomb, 'rechazado')) {
                                        $badgeClass = 'bg-red-100 text-red-700';
                                    }
                                @endphp
                                <li class="p-4 hover:bg-gray-50 dark:hover:bg-slate-900 transition-colors">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                                                <span
                                                    class="material-symbols-outlined text-[18px] text-gray-400">person</span>
                                            </div>
                                            <div>
                                                @php
                                                    $displayName = $ultimo->responsable;
                                                    $displayArea = $ultimo->area;
                                                @endphp
                                                <p class="text-sm font-bold dark:text-white">
                                                    {{ $displayName }}</p>
                                                <p class="text-[10px] text-gray-500">
                                                    {{ $displayArea }}</p>
                                            </div>
                                        </div>
                                        <span
                                            class="px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $badgeClass }}">
                                            {{ $ultimo->titulo ?? 'N/A' }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 
                COLUMNA DERECHA: LÍNEA DE TIEMPO (TRAZABILIDAD) 
                Visualiza cronológicamente todos los movimientos, respuestas y cambios de estado del documento.
            -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h2 class="font-bold text-lg dark:text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">analytics</span>
                            Línea de Vida del Documento (Externo)
                        </h2>
                    </div>

                    <div class="p-8">
                        <div class="relative border-l-2 border-gray-100 dark:border-gray-700 ml-4 space-y-10">
                            @foreach ($trazabilidad as $trace)
                                <div class="relative pl-10">
                                    <!-- Indicador Timeline -->
                                    <div
                                        class="absolute -left-[11px] top-0 w-5 h-5 rounded-full {{ $trace->color }} ring-4 ring-white dark:ring-slate-800 flex items-center justify-center shadow-sm">
                                        <span
                                            class="material-symbols-outlined text-white text-[12px]">{{ $trace->icon }}</span>
                                    </div>

                                    <div
                                        class="bg-gray-50 dark:bg-slate-900/50 rounded-xl p-5 border border-gray-100 dark:border-gray-700 group hover:shadow-md transition-shadow">
                                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-3">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="px-3 py-1 bg-white dark:bg-slate-800 rounded-full text-xs font-bold text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                                    {{ $trace->titulo }}
                                                </span>
                                                <span class="text-[11px] text-gray-400 flex items-center gap-1">
                                                    <span
                                                        class="material-symbols-outlined text-[14px]">calendar_month</span>
                                                    {{ $trace->fecha->translatedFormat('d M, Y - h:i A') }}
                                                </span>
                                                @php
                                                    $isInternalRad = str_starts_with($detalle->recibido->radicado->num_radicado ?? '', 'INT-');
                                                @endphp
                                                @if($isInternalRad)
                                                    <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded font-black uppercase">Interna</span>
                                                @elseif($trace->tipo === 'Entrada')
                                                    <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-black uppercase">Entrada</span>
                                                @else
                                                    <span class="text-[10px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded font-black uppercase">Salida</span>
                                                @endif
                                            </div>
                                            <div class="flex flex-col md:items-end">
                                                <span class="text-[11px] font-bold text-primary dark:text-blue-400 bg-primary/5 px-2 py-0.5 rounded">
                                                    {{ $trace->responsable }}
                                                </span>
                                                <span class="text-[10px] text-gray-400">{{ $trace->area }}</span>
                                            </div>
                                        </div>

                                        <div class="relative">
                                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed italic">
                                                "{{ $trace->detalle }}"
                                            </p>
                                        </div>

                                        {{-- Anexos si existen en el objeto original --}}
                                        @php
                                            $anexos = collect();
                                            if (!$trace->is_main) {
                                                if(isset($trace->original->anexosRespuesta)) {
                                                    $anexos = $trace->original->anexosRespuesta;
                                                }
                                            }
                                        @endphp

                                        @if ($anexos->count() > 0)
                                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Archivos Adjuntos:</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($anexos as $anexo)
                                                        <a href="{{ asset('storage/' . $anexo->ruta_archivo) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg text-xs text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 hover:border-primary transition-all group/file">
                                                            <span class="material-symbols-outlined text-sm text-gray-400 group-hover/file:text-primary">description</span>
                                                            <span class="font-medium truncate max-w-[150px]">{{ $anexo->nombre_original }}</span>
                                                            <span class="material-symbols-outlined text-sm">download</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <div class="mt-3 text-[10px] text-right font-medium text-gray-400">
                                            Total folios reportados: <span
                                                class="text-gray-600 dark:text-gray-300">{{ $trace->folios_res ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 
                    RESUMEN DE ESTADO (FOOTER DEL CONTENIDO)
                    Determina visualmente si el trámite está "Consolidado" (todos terminaron) o "En Seguimiento".
                -->
                @php
                    $isConsolidado = true;
                    $conAsignaciones = false;

                    foreach ($destinatarios as $doc => $trazas) {
                        $u = $trazas->where('is_main', false)->last();
                        
                        if (!$u) {
                            continue;
                        }

                        $conAsignaciones = true;
                        $estadoId = $u->id_estado ?? ($u->det_id_estado ?? ($u->id_estado_rec ?? ($u->id_estado_envio ?? 0)));
                        if (!in_array($estadoId, [9, 10])) {
                            $isConsolidado = false;
                        }
                    }

                    if (!$conAsignaciones) {
                        $isConsolidado = false;
                    }
                @endphp

                @if ($isConsolidado)
                    <div class="bg-green-600 rounded-xl p-6 text-white flex items-center gap-6 shadow-lg">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-4xl">check_circle</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold">Trámite Consolidado</h4>
                            <p class="text-sm opacity-90">Este radicado externo ha sido gestionado por todos los colaboradores asignados. El proceso se considera cerrado.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-600 rounded-xl p-6 text-white flex items-center gap-6 shadow-lg">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-4xl">pending_actions</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold">En Seguimiento</h4>
                            <p class="text-sm opacity-90">Esta correspondencia externa sigue activa en las bandejas de algunos colaboradores. Puedes monitorear el progreso desde aquí.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@extends('remitente.layouts.app')

@section('title', 'Panel de Remitente - Enviados')

@section('content')

    {{-- Área principal con scroll --}}
    <div class="flex-1 flex flex-col p-6 overflow-y-auto min-w-0">

        @if (session('success'))
            <div
                class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Cabecera y Botón Nueva Correspondencia --}}
        <div class="flex flex-wrap justify-between items-center gap-3">
            <h1 class="text-gray-900 dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">
                Correspondencia Externa Enviada
            </h1>

            <button id="btnAbrirModal"
                class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all shadow-sm dark:bg-blue-500 dark:hover:bg-blue-600 w-max">
                <span class="material-symbols-outlined text-base">add</span>
                Nueva Correspondencia
            </button>
        </div>

        {{-- Barra de Búsqueda y Filtros --}}
        <div class="mt-6 flex flex-col sm:flex-row gap-4">
            <div class="flex-grow">
                <form id="formSearchGlobal" method="GET" action="{{ route('remitente.externaenv') }}" class="flex flex-col min-w-40 h-10 w-full">
                    <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                        <div
                            class="text-gray-500 dark:text-gray-400 flex border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                            <span id="searchIconGlobal" class="material-symbols-outlined">search</span>
                        </div>
                        <input id="searchInputGlobal" type="text" autocomplete="off" name="search"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden {{ request('search') ? '' : 'rounded-r-lg' }} text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal"
                            placeholder="Buscar documento enviado..." value="{{ request('search') }}" />
                        <button type="button" id="btnClearSearchGlobal" 
                            class="{{ request('search') ? 'flex' : 'hidden' }} items-center justify-center px-4 border border-gray-200 border-l-0 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-r-lg transition-colors" title="Limpiar búsqueda">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex gap-3 items-center flex-wrap">
                <button
                    class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">filter_list</span>
                    <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Prioridad</p>
                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                </button>

                <button
                    class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">description</span>
                    <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Tipo de Documento</p>
                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                </button>
            </div>
        </div>

        {{-- Contenedor de la Tabla --}}
        <div
            class="mt-6 flex flex-col bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <div class="overflow-x-auto overflow-y-auto max-h-[calc(100vh-280px)]">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead
                        class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 font-bold w-12 text-center" scope="col">Tipo</th>
                            <th class="px-6 py-3 font-bold" scope="col">Asunto</th>
                            <th class="px-6 py-3 font-bold" scope="col">Destinatario</th>
                            <th class="px-6 py-3 font-bold" scope="col">Fecha de Envío</th>
                            <th class="px-6 py-3 font-bold" scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEnviadosBody">
                        @forelse ($envios as $envio)
                            @php
                                // Ajustamos el acceso a las relaciones según tu modelo Envio
                                $nombrePrioridad = $envio->tipoEnvio->prioridad->prioridad_nombre ?? 'Baja'; // Asume que Tipo tiene relación con Prioridad

                                $colorPrioridad = match (strtolower($nombrePrioridad)) {
                                    'alta', 'urgente' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    'media' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
                                    default => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                };

                                $nombreEstado = $envio->estadoEnvio->estado_nomb ?? 'Desconocido';
                                $colorEstado = match (strtolower($nombreEstado)) {
                                    'enviado',
                                    'resuelto',
                                    'digitalizado'
                                        => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'pendiente',
                                    'en espera',
                                    'en tramite'
                                        => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'rechazado' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200',
                                };

                                // Aquí concatenas el nombre del destinatario según lo que devuelva tu relación quienDirigido
                                $nombreDestinatario = $envio->quienDirigido
                                    ? $envio->quienDirigido->emple_nombres . ' ' . $envio->quienDirigido->emple_apellidos
                                    : $envio->destino ?? 'Destino no especificado';

                                $fechaEnvio = $envio->fecha->format('d M, Y - h:i A'); // Como tienes 'fecha' => 'datetime' en tus $casts
                                $numRadicado = $envio->radicado->num_radicado ?? 'Sin Radicado';

                                $iconoDoc = str_ends_with(strtolower($envio->archivo), '.pdf')
                                    ? 'picture_as_pdf'
                                    : 'description';
                                $colorIcono = str_ends_with(strtolower($envio->archivo), '.pdf')
                                    ? 'text-red-500'
                                    : 'text-blue-500';
                                $rutaArchivo = asset('storage/' . $envio->archivo);
                            @endphp

                            <tr class="fila-registro border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer bg-white dark:bg-gray-800 transition-colors"
                                data-id="{{ $envio->id_envio }}" data-asunto="{{ $envio->asunto }}"
                                data-radicado="{{ $numRadicado }}"
                                data-destinatario="{{ $nombreDestinatario }}"
                                data-fecha="{{ $fechaEnvio }}" data-prioridad="{{ $nombrePrioridad }}"
                                data-estado="{{ $nombreEstado }}" data-icono="{{ $iconoDoc }}"
                                data-archivo="{{ $rutaArchivo }}" data-anexos='@json($envio->anexos)'>

                                <td class="px-6 py-4 text-center">
                                    <span class="material-symbols-outlined {{ $colorIcono }}">{{ $iconoDoc }}</span>
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $envio->asunto ?? 'Sin asunto' }}
                                    <span class="block text-xs text-blue-600 font-normal">Radicado: {{ $numRadicado }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $nombreDestinatario }}</span>
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                    {{ $fechaEnvio }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $colorEstado }}">{{ $nombreEstado }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
                                    <p>No se encontraron registros de correspondencia enviada.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Paginación Real de Laravel --}}
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    {{ $envios->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- ===== ASIDE DE DETALLES (Igual al de Entrante) ===== --}}
    <aside id="asideDetalle"
        class="w-80 shrink-0 border-l border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-col sticky top-0 h-screen overflow-y-auto z-40">

        {{-- Estado vacío --}}
        <div id="asideVacio" class="flex flex-col items-center justify-center h-full p-6 text-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-500">outbox</span>
            </div>
            <p class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Detalle de Envío</p>
            <p class="text-xs text-gray-400 dark:text-gray-600 mt-2">Selecciona un registro para ver su trazabilidad</p>
        </div>

        {{-- Contenido dinámico --}}
        <div id="asideContenido" class="hidden flex flex-col h-full">
            
            {{-- Cabecera --}}
            <div class="px-5 pt-6 pb-4 border-b border-gray-100 dark:border-gray-700 flex items-start justify-between gap-3 bg-gray-50/50 dark:bg-gray-900/20">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                        <span id="aside-tipo-icon-header" class="material-symbols-outlined text-blue-600 dark:text-blue-400">description</span>
                    </div>
                    <div class="min-w-0">
                        <h2 id="aside-asunto" class="text-sm font-black text-gray-900 dark:text-white leading-tight line-clamp-2 uppercase tracking-tight"></h2>
                        <p id="aside-radicados" class="text-[10px] font-bold text-blue-500 mt-1 uppercase tracking-widest"></p>
                    </div>
                </div>
                <button id="btnCerrarAside" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-5 py-6 space-y-8">
                
                {{-- Info Section --}}
                <div class="grid grid-cols-1 gap-6">
                    {{-- Destino --}}
                    <div>
                        <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-2">Destino / Institución</span>
                        <div class="flex items-start gap-2.5 p-3 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-800">
                            <span class="material-symbols-outlined text-gray-400 text-lg mt-0.5">location_on</span>
                            <span id="aside-destinatario" class="text-xs font-bold text-gray-700 dark:text-gray-300 leading-relaxed"></span>
                        </div>
                    </div>

                    {{-- Metadata Row --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-2">Fecha Envío</span>
                            <p id="aside-fecha" class="text-xs font-bold text-gray-900 dark:text-white"></p>
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-2">Prioridad</span>
                            <span id="aside-prioridad" class="inline-block text-[10px] font-bold px-2.5 py-1 rounded-lg"></span>
                        </div>
                    </div>

                    <div>
                        <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-2">Estado Actual</span>
                        <span id="aside-estado" class="inline-block text-[10px] font-bold px-3 py-1.5 rounded-xl"></span>
                    </div>
                </div>

                {{-- Trazabilidad Section --}}
                <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                            Trazabilidad Digital
                        </span>
                        <span id="history-spinner" class="hidden material-symbols-outlined animate-spin text-blue-500 text-sm">progress_activity</span>
                    </div>

                    <div id="history-timeline" class="relative">
                        {{-- Timeline items here --}}
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="pt-6 border-t border-gray-100 dark:border-gray-700 space-y-3">
                    <button id="btnVerDocumento"
                        class="w-full h-11 flex items-center justify-center gap-2 px-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all shadow-lg shadow-blue-200 dark:shadow-blue-900/20 active:scale-[0.98]">
                        <span class="material-symbols-outlined text-lg">visibility</span> 
                        VER EXPEDIENTE COMPLETO
                    </button>
                    <p class="text-[10px] text-gray-400 text-center font-medium italic">Incluye documento principal y anexos</p>
                </div>
            </div>
        </div>
    </aside>

@endsection

{{-- ===== SECCIÓN DE MODALES ===== --}}
@section('modals')
    {{-- Modal Visor de Documentos --}}
    <div id="modalVisorDocumentos" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
        <div
            class="relative w-full max-w-4xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl flex flex-col max-h-[90vh]">
            {{-- Header --}}
            <div class="flex items-center justify-between p-5 border-b dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">visibility</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Visor de Documentos</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Expediente de correspondencia</p>
                    </div>
                </div>
                <button type="button"
                    class="btnCerrarVisor text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-8">
                {{-- Documento Principal --}}
                <section>
                    <h4
                        class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                        Documento Principal
                    </h4>
                    <div id="contenedorPrincipal"
                        class="bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="material-symbols-outlined text-red-500 text-3xl">picture_as_pdf</span>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                        Archivo_Principal.pdf</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Documento base del envío</p>
                                </div>
                            </div>
                            <div class="flex gap-2 shrink-0">
                                <a id="btnDescargarPrincipal" href="#" target="_blank"
                                    class="p-2 text-slate-600 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 transition-colors"
                                    title="Descargar">
                                    <span class="material-symbols-outlined">download</span>
                                </a>
                                <a id="btnVerPrincipal" href="#" target="_blank"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    VER DOCUMENTO
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Anexos --}}
                <section>
                    <h4
                        class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        Anexos Adjuntos
                    </h4>
                    <div id="listaAnexos" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        {{-- Se puebla dinámicamente --}}
                    </div>
                    <div id="sinAnexos"
                        class="hidden text-center py-8 bg-slate-50 dark:bg-slate-800/30 rounded-xl border border-dashed border-slate-300 dark:border-slate-700">
                        <span
                            class="material-symbols-outlined text-slate-300 dark:text-slate-600 text-4xl mb-2">folder_off</span>
                        <p class="text-sm text-slate-500 dark:text-slate-400">No se encontraron anexos para este envío</p>
                    </div>
                </section>
            </div>

            {{-- Footer --}}
            <div class="p-5 border-t dark:border-slate-800 flex justify-end">
                <button type="button"
                    class="btnCerrarVisor px-6 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                    Cerrar Visor
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Nueva Correspondencia Enviada --}}
    <div id="modalCorrespondencia" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
        <div class="relative w-full max-w-4xl max-h-full my-auto">
            <form action="{{ route('remitente.externaenv.store') }}" method="POST" enctype="multipart/form-data"
                id="formNuevaCorrespondencia" class="relative">
                @csrf
                <div
                    class="space-y-6 bg-white dark:bg-slate-900 p-8 rounded-xl border border-slate-200 dark:border-slate-800 shadow-2xl max-h-[90vh] overflow-y-auto">

                    <div
                        class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 pb-4 mb-4">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Registrar Correspondencia Saliente
                        </h3>
                        <button id="btnCerrarModalX" type="button"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                        {{-- Asunto --}}
                        <div class="sm:col-span-2">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Asunto *</label>
                            <input type="text" name="asunto" required
                                class="form-input w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-11 px-3.5 text-base"
                                placeholder="Resumen del documento" />
                        </div>
                        {{-- Destinatario (Destino) --}}
                        <div class="sm:col-span-2">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Destino *</label>
                            <textarea name="destino" required rows="3"
                                class="form-input w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 p-3.5 text-base"
                                placeholder="Especifique el destino o persona a quien va dirigido"></textarea>
                        </div>

                        {{-- Tipo de Documento --}}
                        <div class="sm:col-span-1">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Tipo de Documento
                                *</label>
                            <select name="id_tipo_envio" required
                                class="form-select w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-11 px-3.5 text-base">
                                <option value="">Seleccione tipo</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id_tipo }}">{{ $tipo->tipo_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Persona que Envía (Empleado) --}}
                        <div class="sm:col-span-1 relative">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Persona que Envía
                                *</label>
                            <input type="text" id="searchEnvia" autocomplete="off"
                                class="form-input w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-11 px-3.5 text-base"
                                placeholder="Buscar empleado..." />
                            <input type="hidden" name="doc_quien_envia" id="doc_quien_envia" required>
                            <div id="resultsEnvia"
                                class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg hidden overflow-hidden">
                            </div>
                        </div>

                        {{-- Folio --}}
                        <div class="sm:col-span-1">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Número de Folios
                                *</label>
                            <input type="number" name="folio" required min="1" value="1"
                                class="form-input w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-11 px-3.5 text-base"
                                placeholder="Cantidad de hojas" />
                        </div>

                        {{-- Archivo --}}
                        <div class="sm:col-span-1">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Adjuntar Documento
                                (PDF)</label>
                            <input type="file" name="archivo" accept="application/pdf"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <button id="btnCerrarModal" type="button"
                            class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Cancelar</button>
                        <button type="submit"
                            class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">
                            Registrar Envío
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script básico para interacción visual (Igual al de la vista Recibida para mantener la coherencia UI) --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- MODAL ---
            const modal = document.getElementById('modalCorrespondencia');
            const btnAbrir = document.getElementById('btnAbrirModal');
            const btnCerrar = document.getElementById('btnCerrarModal');
            const btnCerrarX = document.getElementById('btnCerrarModalX');

            const toggleModal = (show) => {
                modal.classList.toggle('hidden', !show);
                modal.classList.toggle('flex', show);
                document.body.style.overflow = show ? 'hidden' : '';
            };

            btnAbrir.addEventListener('click', () => toggleModal(true));
            btnCerrar.addEventListener('click', () => toggleModal(false));
            btnCerrarX.addEventListener('click', () => toggleModal(false));

            // --- AJAX SEARCH HELPERS ---
            function setupSearch(inputId, resultsId, hiddenId, url) {
                const input = document.getElementById(inputId);
                const results = document.getElementById(resultsId);
                const hidden = document.getElementById(hiddenId);

                input.addEventListener('input', async function() {
                    const q = this.value.trim();
                    if (q.length < 2) {
                        results.classList.add('hidden');
                        return;
                    }

                    try {
                        const response = await fetch(`${url}?q=${q}`);
                        const data = await response.json();

                        results.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.className =
                                    'px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer text-sm dark:text-gray-200';
                                const displayArea = item.area_nom ?
                                    ` - Area: ${item.area_nom}` : '';
                                div.textContent =
                                    `${item.emple_nombres} ${item.emple_apellidos} (${item.emple_doc})${displayArea}`;
                                div.addEventListener('click', () => {
                                    input.value =
                                        `${item.emple_nombres} ${item.emple_apellidos}`;
                                    hidden.value = item.emple_doc;
                                    results.classList.add('hidden');
                                });
                                results.appendChild(div);
                            });
                            results.classList.remove('hidden');
                        } else {
                            results.innerHTML =
                                '<div class="px-4 py-2 text-sm text-gray-500">No se encontraron resultados</div>';
                            results.classList.remove('hidden');
                        }
                    } catch (error) {
                        console.error('Error in search:', error);
                    }
                });

                // Close results when clicking outside
                document.addEventListener('click', (e) => {
                    if (!input.contains(e.target) && !results.contains(e.target)) {
                        results.classList.add('hidden');
                    }
                });
            }

            setupSearch('searchEnvia', 'resultsEnvia', 'doc_quien_envia',
                '{{ route('remitente.buscar_empleados') }}');

            // --- ASIDE ---
            const asideVacio = document.getElementById('asideVacio');
            const asideContenido = document.getElementById('asideContenido');

            document.querySelectorAll('.fila-registro').forEach(fila => {
                fila.addEventListener('click', function() {
                    document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove(
                        'bg-blue-50', 'dark:bg-blue-900/10'));
                    this.classList.add('bg-blue-50', 'dark:bg-blue-900/10');

                    const data = this.dataset;
                    
                    // Llenar datos base
                    document.getElementById('aside-asunto').textContent = data.asunto;
                    document.getElementById('aside-radicados').textContent = 'Radicado: ' + data.radicado;
                    document.getElementById('aside-destinatario').textContent = data.destinatario;
                    document.getElementById('aside-fecha').textContent = data.fecha;
                    
                    // Estilos Prioridad
                    const priorityEl = document.getElementById('aside-prioridad');
                    priorityEl.textContent = data.prioridad;
                    priorityEl.className = 'inline-block text-[10px] font-bold px-2.5 py-1 rounded-lg ' + 
                        (data.prioridad === 'Alta' ? 'bg-red-50 text-red-600 dark:bg-red-900/20' : 
                         data.prioridad === 'Media' ? 'bg-amber-50 text-amber-600 dark:bg-amber-900/20' : 
                         'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20');

                    // Estilos Estado
                    const statusEl = document.getElementById('aside-estado');
                    statusEl.textContent = data.estado;
                    statusEl.className = 'inline-block text-[10px] font-bold px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20';

                    // Actualizar icono cabecera
                    const iconHeader = document.getElementById('aside-tipo-icon-header');
                    iconHeader.textContent = data.icono;

                    // Almacenar datos para el visor
                    const btnVer = document.getElementById('btnVerDocumento');
                    btnVer.dataset.archivo = data.archivo;
                    btnVer.dataset.anexos = data.anexos;

                    asideVacio.classList.add('hidden');
                    asideContenido.classList.remove('hidden');

                    // Cargar Historial
                    loadHistory(data.id);
                });
            });

            function loadHistory(id) {
                const timeline = document.getElementById('history-timeline');
                const spinner = document.getElementById('history-spinner');
                
                timeline.innerHTML = '';
                spinner.classList.remove('hidden');

                fetch(`/remitente/externaenv/${id}/history`)
                    .then(res => res.json())
                    .then(data => {
                        spinner.classList.add('hidden');
                        if (data.length === 0) {
                            timeline.innerHTML = '<p class="text-[10px] text-gray-400 p-4 font-bold uppercase tracking-widest text-center">Sin trazabilidad registrada</p>';
                            return;
                        }

                        data.forEach((item, index) => {
                            const date = new Date(item.fecha);
                            const dateStr = date.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
                            const timeStr = date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                            const isLast = index === data.length - 1;

                            let icon = 'info';
                            let circleClass = 'bg-gray-100 text-gray-600';

                            if (item.type === 'registry') {
                                icon = 'edit_document';
                                circleClass = 'bg-blue-100 text-blue-600';
                            } else {
                                switch (parseInt(item.id_estado_rec)) {
                                    case 7: icon = 'mark_email_read'; circleClass = 'bg-green-100 text-green-600'; break;
                                    case 8: icon = 'pending_actions'; circleClass = 'bg-amber-100 text-amber-600'; break;
                                    case 9: case 10: icon = 'check_circle'; circleClass = 'bg-emerald-100 text-emerald-600'; break;
                                    case 11: icon = 'cancel'; circleClass = 'bg-red-100 text-red-600'; break;
                                    case 12: icon = 'send'; circleClass = 'bg-blue-100 text-blue-600'; break;
                                    case 14: icon = 'outbox'; circleClass = 'bg-emerald-100 text-emerald-600'; break;
                                }
                            }

                            const html = `
                                <div class="flex gap-4 relative">
                                    ${!isLast ? `<div class="absolute left-[19px] top-10 bottom-0 w-0.5 bg-gray-100 dark:bg-gray-700/50"></div>` : ''}
                                    
                                    <div class="relative z-10">
                                        <div class="w-10 h-10 rounded-xl ${circleClass} flex items-center justify-center shadow-sm border border-white dark:border-gray-800">
                                            <span class="material-symbols-outlined text-[18px]">${icon}</span>
                                        </div>
                                    </div>

                                    <div class="flex-1 pb-10">
                                        <div class="flex flex-col mb-1 gap-1">
                                            <span class="text-[11px] font-black text-gray-900 dark:text-white uppercase tracking-tight">${item.estado_nomb}</span>
                                            <div class="flex items-center gap-1.5 text-[9px] font-bold text-gray-400">
                                                <span class="material-symbols-outlined text-[12px]">schedule</span>
                                                ${dateStr} • ${timeStr}
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 mb-3 mt-2 p-1.5 bg-gray-50/50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700/50 w-fit">
                                            <div class="w-6 h-6 rounded-lg bg-blue-600 flex items-center justify-center overflow-hidden shrink-0">
                                                ${item.img ? `<img src="/storage/${item.img}" class="w-full h-full object-cover">` : 
                                                  `<span class="text-[8px] font-bold text-white">${item.nombres.charAt(0)}${item.apellidos.charAt(0)}</span>`}
                                            </div>
                                            <div class="flex flex-col pr-2">
                                                <p class="text-[10px] text-gray-800 dark:text-gray-200 font-bold leading-none">${item.nombres} ${item.apellidos}</p>
                                                <span class="text-[8px] text-gray-400 font-medium">Responsable</span>
                                            </div>
                                        </div>

                                        ${item.observaciones ? `
                                            <div class="relative p-3 bg-white dark:bg-gray-800 border-l-2 border-blue-500/20 rounded-r-xl shadow-sm group hover:border-blue-500 transition-colors">
                                                <span class="material-symbols-outlined absolute -right-1 -top-1 text-blue-500/5 text-2xl">format_quote</span>
                                                <p class="text-[10px] text-gray-600 dark:text-gray-400 italic leading-relaxed">"${item.observaciones}"</p>
                                            </div>
                                        ` : ''}

                                        ${item.archivo_res ? `
                                            <div class="mt-3">
                                                <a href="/storage/${item.archivo_res}" target="_blank" 
                                                   class="inline-flex items-center gap-2 px-3 py-1.5 text-[10px] font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-lg hover:bg-emerald-100 transition-all">
                                                    <span class="material-symbols-outlined text-[16px]">task</span>
                                                    DOCUMENTO DE RESPUESTA
                                                </a>
                                            </div>
                                        ` : ''}
                                        
                                        ${item.anexos && item.anexos.length > 0 ? `
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                ${item.anexos.map(a => `
                                                    <a href="/storage/${a.ruta_archivo}" target="_blank" class="flex items-center gap-1.5 px-2 py-1 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-lg text-[9px] font-bold text-amber-700 hover:bg-amber-100 transition-colors">
                                                        <span class="material-symbols-outlined text-[14px]">attachment</span>
                                                        ${a.nombre_original}
                                                    </a>
                                                `).join('')}
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                            `;
                            timeline.innerHTML += html;
                        });
                    })
                    .catch(err => {
                        spinner.classList.add('hidden');
                        timeline.innerHTML = '<p class="text-[10px] text-red-500 p-4 font-bold uppercase tracking-widest text-center">Error al cargar trazabilidad</p>';
                        console.error(err);
                    });
            }

            document.getElementById('btnCerrarAside').addEventListener('click', () => {
                asideVacio.classList.remove('hidden');
                asideContenido.classList.add('hidden');
                document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('bg-blue-50',
                    'dark:bg-blue-900/10'));
            });

            // --- VISOR DE DOCUMENTOS ---
            const modalVisor = document.getElementById('modalVisorDocumentos');
            const btnVerDocumento = document.getElementById('btnVerDocumento');
            const btnCerrarVisor = document.querySelectorAll('.btnCerrarVisor');

            btnVerDocumento.addEventListener('click', () => {
                const archivoPrincipal = btnVerDocumento.dataset.archivo;
                const anexos = JSON.parse(btnVerDocumento.dataset.anexos || '[]');

                // Poblar Principal
                document.getElementById('btnVerPrincipal').href = archivoPrincipal;
                document.getElementById('btnDescargarPrincipal').href = archivoPrincipal;

                // Poblar Anexos
                const listaAnexos = document.getElementById('listaAnexos');
                const sinAnexos = document.getElementById('sinAnexos');
                listaAnexos.innerHTML = '';

                if (anexos.length > 0) {
                    sinAnexos.classList.add('hidden');
                    listaAnexos.classList.remove('hidden');
                    anexos.forEach(anexo => {
                        const ruta = `{{ asset('storage') }}/${anexo.ruta_archivo}`;
                        const item = `
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="material-symbols-outlined text-amber-500 text-xl">description</span>
                                    <p class="text-xs font-medium text-slate-700 dark:text-slate-300 truncate">${anexo.nombre_original || 'Anexo'}</p>
                                </div>
                                <div class="flex gap-1 shrink-0">
                                    <a href="${ruta}" target="_blank" class="p-1.5 text-slate-400 hover:text-blue-500 transition-colors">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                    <a href="${ruta}" download class="p-1.5 text-slate-400 hover:text-green-500 transition-colors">
                                        <span class="material-symbols-outlined text-lg">download</span>
                                    </a>
                                </div>
                            </div>
                        `;
                        listaAnexos.insertAdjacentHTML('beforeend', item);
                    });
                } else {
                    sinAnexos.classList.remove('hidden');
                    listaAnexos.classList.add('hidden');
                }

                modalVisor.classList.remove('hidden');
                modalVisor.classList.add('flex');
            });

            btnCerrarVisor.forEach(btn => {
                btn.addEventListener('click', () => {
                    modalVisor.classList.add('hidden');
                    modalVisor.classList.remove('flex');
                });
            });

            // Cerrar al click afuera
            modalVisor.addEventListener('click', (e) => {
                if (e.target === modalVisor) {
                    modalVisor.classList.add('hidden');
                }
            });

            // --- SEARCH LOGIC ---
            const searchForm = document.getElementById('formSearchGlobal');
            const searchInput = document.getElementById('searchInputGlobal');
            const btnClearSearch = document.getElementById('btnClearSearchGlobal');

            if (searchInput) {
                searchInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        searchForm.submit();
                    }
                });
            }

            if (btnClearSearch) {
                btnClearSearch.addEventListener('click', () => {
                    window.location.href = "{{ route('remitente.externaenv') }}";
                });
            }
        });
    </script>
@endsection

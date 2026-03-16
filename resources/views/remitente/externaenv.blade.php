@extends('remitente.layouts.app')

@section('title', 'Panel de Remitente - Enviados')

@section('content')

    {{-- Área principal con scroll --}}
    <div class="flex-1 flex flex-col p-6 overflow-y-auto min-w-0">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
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
                <form id="formSearchGlobal" onsubmit="return false;" class="flex flex-col min-w-40 h-10 w-full">
                    <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                        <div
                            class="text-gray-500 dark:text-gray-400 flex border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                            <span id="searchIconGlobal" class="material-symbols-outlined">search</span>
                        </div>
                        <input id="searchInputGlobal" type="text" autocomplete="off"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal"
                            placeholder="Buscar documento enviado..." />
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
                            <th class="px-6 py-3 font-bold" scope="col">Prioridad</th>
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
                                data-asunto="{{ $envio->asunto }}" data-destinatario="{{ $nombreDestinatario }}"
                                data-fecha="{{ $fechaEnvio }}" data-prioridad="{{ $nombrePrioridad }}"
                                data-estado="{{ $nombreEstado }}" data-icono="{{ $iconoDoc }}"
                                data-archivo="{{ $rutaArchivo }}"
                                data-anexos='@json($envio->anexos)'>

                                <td class="px-6 py-4 text-center">
                                    <span class="material-symbols-outlined {{ $colorIcono }}">{{ $iconoDoc }}</span>
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $envio->asunto ?? 'Sin asunto' }}
                                    <span class="block text-xs text-blue-600 font-normal">Int: {{ $numRadicado }}</span>
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
                                        class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $colorPrioridad }}">{{ $nombrePrioridad }}</span>
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
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $envios->links() }}
                </div>
            </div>

            {{-- Paginación (Visual) --}}
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Mostrando <span
                        class="font-semibold text-gray-900 dark:text-white">1-3</span> de <span
                        class="font-semibold text-gray-900 dark:text-white">45</span></span>
                <ul class="inline-flex -space-x-px text-sm h-8">
                    <li><a class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            href="#">Anterior</a></li>
                    <li><a class="flex items-center justify-center px-3 h-8 text-primary bg-primary/10 border border-primary hover:bg-primary/20 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                            href="#">1</a></li>
                    <li><a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            href="#">Siguiente</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ===== ASIDE DE DETALLES (Igual al de Entrante) ===== --}}
    <aside id="asideDetalle"
        class="w-72 shrink-0 border-l border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-col sticky top-0 h-screen overflow-y-auto">

        {{-- Estado vacío --}}
        <div id="asideVacio" class="flex flex-col items-center justify-center h-full p-6 text-center">
            <span class="material-symbols-outlined text-5xl text-gray-300 dark:text-gray-600 mb-3">outbox</span>
            <p class="text-sm font-medium text-gray-400 dark:text-gray-500">Selecciona un registro enviado para ver su
                detalle</p>
        </div>

        {{-- Contenido dinámico --}}
        <div id="asideContenido" class="hidden flex flex-col h-full">
            <div
                class="px-5 pt-5 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-start justify-between gap-2">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="material-symbols-outlined text-blue-500 text-2xl shrink-0">description</span>
                    <div class="min-w-0">
                        <h2 id="aside-asunto"
                            class="text-sm font-bold text-gray-900 dark:text-white leading-tight line-clamp-2"></h2>
                        <p id="aside-radicados" class="text-xs text-blue-500 mt-0.5">Correspondencia Saliente</p>
                    </div>
                </div>
                <button id="btnCerrarAside"
                    class="shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors"
                    title="Cerrar">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
                {{-- Destinatario --}}
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Destinatario</span>
                    <div class="flex items-center gap-1.5 mt-1">
                        <span id="aside-tipo-icon" class="material-symbols-outlined text-xs"></span>
                        <span id="aside-destinatario" class="text-sm font-medium text-gray-900 dark:text-white"></span>
                    </div>
                </div>

                {{-- Fecha --}}
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Fecha de Envío</span>
                    <p id="aside-fecha" class="text-sm font-medium text-gray-900 dark:text-white mt-1"></p>
                </div>

                {{-- Prioridad + Estado --}}
                <div class="flex gap-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Prioridad</span>
                        <div class="mt-1">
                            <span id="aside-prioridad"
                                class="text-xs font-medium px-2 py-0.5 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300"></span>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Estado</span>
                        <div class="mt-1">
                            <span id="aside-estado"
                                class="text-xs font-medium px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300"></span>
                        </div>
                    </div>
                </div>

                {{-- Acciones Rápidas Dummy (Opcionales para visualización) --}}
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-col gap-2">
                    <button id="btnVerDocumento"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-bold text-blue-700 bg-blue-50 border border-blue-200 dark:text-blue-300 dark:bg-blue-900/20 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-all">
                        <span class="material-symbols-outlined text-base">visibility</span> Ver Documento
                    </button>
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
        <div class="relative w-full max-w-4xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl flex flex-col max-h-[90vh]">
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
                <button type="button" class="btnCerrarVisor text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-8">
                {{-- Documento Principal --}}
                <section>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                        Documento Principal
                    </h4>
                    <div id="contenedorPrincipal" class="bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="material-symbols-outlined text-red-500 text-3xl">picture_as_pdf</span>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">Archivo_Principal.pdf</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Documento base del envío</p>
                                </div>
                            </div>
                            <div class="flex gap-2 shrink-0">
                                <a id="btnDescargarPrincipal" href="#" target="_blank" class="p-2 text-slate-600 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 transition-colors" title="Descargar">
                                    <span class="material-symbols-outlined">download</span>
                                </a>
                                <a id="btnVerPrincipal" href="#" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    VER DOCUMENTO
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Anexos --}}
                <section>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        Anexos Adjuntos
                    </h4>
                    <div id="listaAnexos" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        {{-- Se puebla dinámicamente --}}
                    </div>
                    <div id="sinAnexos" class="hidden text-center py-8 bg-slate-50 dark:bg-slate-800/30 rounded-xl border border-dashed border-slate-300 dark:border-slate-700">
                        <span class="material-symbols-outlined text-slate-300 dark:text-slate-600 text-4xl mb-2">folder_off</span>
                        <p class="text-sm text-slate-500 dark:text-slate-400">No se encontraron anexos para este envío</p>
                    </div>
                </section>
            </div>
            
            {{-- Footer --}}
            <div class="p-5 border-t dark:border-slate-800 flex justify-end">
                <button type="button" class="btnCerrarVisor px-6 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                    Cerrar Visor
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Nueva Correspondencia Enviada --}}
    <div id="modalCorrespondencia" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
        <div class="relative w-full max-w-4xl max-h-full my-auto">
            <form action="{{ route('remitente.externaenv.store') }}" method="POST" enctype="multipart/form-data" id="formNuevaCorrespondencia" class="relative">
                @csrf
                <div class="space-y-6 bg-white dark:bg-slate-900 p-8 rounded-xl border border-slate-200 dark:border-slate-800 shadow-2xl max-h-[90vh] overflow-y-auto">

                    <div class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 pb-4 mb-4">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Registrar Correspondencia Saliente</h3>
                        <button id="btnCerrarModalX" type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                        {{-- Destinatario (Destino) --}}
                        <div class="sm:col-span-2">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Destino *</label>
                            <textarea name="destino" required rows="3"
                                class="form-input w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 p-3.5 text-base"
                                placeholder="Especifique el destino o persona a quien va dirigido"></textarea>
                        </div>

                        {{-- Asunto --}}
                        <div class="sm:col-span-2">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Asunto *</label>
                            <input type="text" name="asunto" required
                                class="form-input w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-11 px-3.5 text-base"
                                placeholder="Resumen del documento" />
                        </div>

                        {{-- Tipo de Documento --}}
                        <div class="sm:col-span-1">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Tipo de Documento *</label>
                            <select name="id_tipo_envio" required
                                class="form-select w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-11 px-3.5 text-base">
                                <option value="">Seleccione tipo</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id_tipo }}">{{ $tipo->tipo_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Persona que Envía (Empleado) --}}
                        <div class="sm:col-span-1 relative">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Persona que Envía *</label>
                            <input type="text" id="searchEnvia" autocomplete="off"
                                class="form-input w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-11 px-3.5 text-base"
                                placeholder="Buscar empleado..." />
                            <input type="hidden" name="doc_quien_envia" id="doc_quien_envia" required>
                            <div id="resultsEnvia" class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg hidden overflow-hidden"></div>
                        </div>

                        {{-- Folio --}}
                        <div class="sm:col-span-1">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Número de Folios *</label>
                            <input type="number" name="folio" required min="1" value="1"
                                class="form-input w-full rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-11 px-3.5 text-base"
                                placeholder="Cantidad de hojas" />
                        </div>

                        {{-- Archivo --}}
                        <div class="sm:col-span-1">
                            <label class="block text-slate-900 dark:text-white text-sm font-medium pb-2">Adjuntar Documento (PDF)</label>
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
                                div.className = 'px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer text-sm dark:text-gray-200';
                                const displayArea = item.area_nom ? ` - Area: ${item.area_nom}` : '';
                                div.textContent = `${item.emple_nombres} ${item.emple_apellidos} (${item.emple_doc})${displayArea}`;
                                div.addEventListener('click', () => {
                                    input.value = `${item.emple_nombres} ${item.emple_apellidos}`;
                                    hidden.value = item.emple_doc;
                                    results.classList.add('hidden');
                                });
                                results.appendChild(div);
                            });
                            results.classList.remove('hidden');
                        } else {
                            results.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">No se encontraron resultados</div>';
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

            setupSearch('searchEnvia', 'resultsEnvia', 'doc_quien_envia', '{{ route("remitente.buscar_empleados") }}');

            // --- ASIDE ---
            const asideVacio = document.getElementById('asideVacio');
            const asideContenido = document.getElementById('asideContenido');

            document.querySelectorAll('.fila-registro').forEach(fila => {
                fila.addEventListener('click', function() {
                    document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('bg-blue-50', 'dark:bg-blue-900/10'));
                    this.classList.add('bg-blue-50', 'dark:bg-blue-900/10');

                    const data = this.dataset;
                    document.getElementById('aside-asunto').textContent = data.asunto;
                    document.getElementById('aside-destinatario').textContent = data.destinatario;
                    document.getElementById('aside-fecha').textContent = data.fecha;
                    document.getElementById('aside-prioridad').textContent = data.prioridad;
                    document.getElementById('aside-estado').textContent = data.estado;

                    const iconEl = document.getElementById('aside-tipo-icon');
                    iconEl.textContent = data.icono;
                    iconEl.className = 'material-symbols-outlined text-sm ' + (data.icono === 'person' ? 'text-purple-500' : 'text-blue-500');

                    // Almacenar datos para el visor
                    const btnVer = document.getElementById('btnVerDocumento');
                    btnVer.dataset.archivo = data.archivo;
                    btnVer.dataset.anexos = data.anexos;

                    asideVacio.classList.add('hidden');
                    asideContenido.classList.remove('hidden');
                });
            });

            document.getElementById('btnCerrarAside').addEventListener('click', () => {
                asideVacio.classList.remove('hidden');
                asideContenido.classList.add('hidden');
                document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('bg-blue-50', 'dark:bg-blue-900/10'));
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
                    modalVisor.classList.remove('flex');
                }
            });
        });
    </script>
@endsection

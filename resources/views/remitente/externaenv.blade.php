@extends('remitente.layouts.app')

@section('title', 'Panel de Remitente - Enviados')

@section('content')

    {{-- Área principal con scroll --}}
    <div class="flex-1 flex flex-col p-6 overflow-y-auto min-w-0">

        @if (session('success'))
            <div
                class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800 text-blue-700 dark:text-green-300 rounded-lg flex items-center gap-2">
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

        {{-- Cabecera y Stats --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Correspondencia Externa Enviada
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Administre y consulte todos los envíos realizados.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('remitente.recibidos') }}"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">move_to_inbox</span>
                    Registrar Recibido
                </a>

                <button id="btnAbrirModal" type="button"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">outbox</span>
                    Registrar Saliente
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Stat Card: Total -->
            <div
                class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex flex-col gap-3">
                    <div
                        class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                        <span class="material-symbols-outlined text-[20px]">description</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Registros</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>

            <!-- Stat Card: Rejected -- (We change icon to match 'Rechazados') -->
            <div
                class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex flex-col gap-3">
                    <div
                        class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center text-red-600 dark:text-red-400 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Rechazados</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['rejected'] }}</h3>
                    </div>
                </div>
            </div>

            <!-- Stat Card: Pending -- (We change icon to map 'Pendientes') -->
            <div
                class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex flex-col gap-3">
                    <div
                        class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center text-orange-600 dark:text-orange-400 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <span class="material-symbols-outlined text-[20px]">pending_actions</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pendientes</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['pending'] }}</h3>
                    </div>
                </div>
            </div>

            <!-- Stat Card: Resolved -- (We change to match 'Enviados') -->
            <div
                class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex flex-col gap-3">
                    <div
                        class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Enviados</p>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['resolved'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barra de Búsqueda y Filtros --}}
        <div class="mt-6 flex flex-col sm:flex-row gap-4">
            <div class="flex-grow">
                <form id="formSearchGlobal" method="GET" action="{{ route('remitente.externaenv') }}"
                    class="flex flex-col sm:flex-row min-w-40 sm:h-10 w-full gap-3">
                    <div class="w-full sm:w-48 h-10 sm:h-full">
                        <select name="estado_id" onchange="this.form.submit()"
                            class="block w-full h-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-sm focus:ring-primary focus:border-primary dark:text-white">
                            <option value="">Todos los estados</option>
                            @foreach ($estados as $est)
                                <option value="{{ $est->id_estado }}"
                                    {{ request('estado_id') == $est->id_estado ? 'selected' : '' }}>
                                    {{ $est->estado_nomb }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex w-full flex-1 items-stretch rounded-lg h-10 sm:h-full">
                        <div
                            class="text-gray-500 dark:text-gray-400 flex border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                            <span id="searchIconGlobal" class="material-symbols-outlined">search</span>
                        </div>
                        <input id="searchInputGlobal" type="text" autocomplete="off" name="search"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden {{ request('search') ? '' : 'rounded-r-lg' }} text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal"
                            placeholder="Buscar documento enviado..." value="{{ request('search') }}" />
                        <button type="button" id="btnClearSearchGlobal"
                            class="{{ request('search') ? 'flex' : 'hidden' }} items-center justify-center px-4 border border-gray-200 border-l-0 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-r-lg transition-colors"
                            title="Limpiar búsqueda">
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
                            <th class="px-6 py-3 font-bold" scope="col">Asunto / Radicado</th>
                            <th class="px-6 py-3 font-bold" scope="col">Destino</th>
                            <th class="px-6 py-3 font-bold" scope="col">Departamento</th>
                            <th class="px-6 py-3 font-bold" scope="col">Fecha Envoy</th>
                            <th class="px-6 py-3 font-bold" scope="col">Prioridad</th>
                            <th class="px-6 py-3 font-bold" scope="col">Estado</th>
                            <th class="px-6 py-3 font-bold" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEnviadosBody">
                        @forelse ($envios as $envio)
                            @php
                                // Ajustamos el acceso a las relaciones según tu modelo Envio
                                $nombrePrioridad = $envio->tipoEnvio->prioridad->prioridad_nombre ?? 'Baja'; // Asume que Tipo tiene relación con Prioridad
                                $pl = strtolower($nombrePrioridad);
                                $priorClases = 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
                                if (
                                    str_contains($pl, 'alta') ||
                                    str_contains($pl, 'urgente') ||
                                    str_contains($pl, 'critica') ||
                                    str_contains($pl, 'crítica')
                                ) {
                                    $priorClases = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                } elseif (
                                    str_contains($pl, 'media') ||
                                    str_contains($pl, 'normal') ||
                                    str_contains($pl, 'moderada')
                                ) {
                                    $priorClases =
                                        'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300';
                                } elseif (str_contains($pl, 'baja') || str_contains($pl, 'bajo')) {
                                    $priorClases = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                }

                                $nombreEstado = $envio->estadoEnvio->estado_nomb ?? 'Desconocido';
                                if (str_contains(strtolower($nombreEstado), 'saliente')) {
                                    $nombreEstado = 'Respuesta Enviada';
                                }
                                $low = strtolower($nombreEstado);
                                if (str_contains($low, 'pendiente') || str_contains($low, 'en espera')) {
                                    $estadoClases =
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                                } elseif (
                                    str_contains($low, 'enviado') ||
                                    str_contains($low, 'resuelto') ||
                                    str_contains($low, 'respuesta enviada') ||
                                    str_contains($low, 'digitalizado') ||
                                    str_contains($low, 'en tramite')
                                ) {
                                    $estadoClases = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                                } elseif (str_contains($low, 'rechazado')) {
                                    $estadoClases = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                } else {
                                    $estadoClases = 'bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200';
                                }

                                // Aquí concatenas el nombre del destinatario según lo que devuelva tu relación quienDirigido
                                $nombreDestinatario = $envio->quienDirigido
                                    ? $envio->quienDirigido->emple_nombres .
                                        ' ' .
                                        $envio->quienDirigido->emple_apellidos
                                    : $envio->destino ?? 'Destino no especificado';

                                $fechaEnvio = $envio->fecha
                                    ? \Carbon\Carbon::parse($envio->fecha)->format('d M, Y - H:i')
                                    : '—';
                                $numRadicado = $envio->radicado->num_radicado ?? '';

                                $iconoDoc = str_ends_with(strtolower($envio->archivo), '.pdf')
                                    ? 'picture_as_pdf'
                                    : 'description';
                                $rutaArchivo = $envio->archivo ? asset('storage/' . $envio->archivo) : '';
                                $tipoDoc = $envio->tipoEnvio->tipo_nombre ?? '';
                            @endphp

                            <tr class="fila-registro border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer bg-white dark:bg-gray-800 transition-colors"
                                data-id="{{ $envio->id_envio }}" data-asunto="{{ $envio->asunto }}"
                                data-radicado="{{ $numRadicado }}" data-destinatario="{{ $nombreDestinatario }}"
                                data-area="{{ $envio->quienDirigido->area->area_nom ?? 'Remitente / Externo' }}"
                                data-fecha="{{ $fechaEnvio }}" data-prioridad="{{ $nombrePrioridad }}"
                                data-prioridad-clases="{{ $priorClases }}" data-estado="{{ $nombreEstado }}"
                                data-estado-clases="{{ $estadoClases }}" data-icono="{{ $iconoDoc }}"
                                data-tipo-doc="{{ $tipoDoc }}" data-archivo="{{ $rutaArchivo }}"
                                data-anexos='@json($envio->anexos)'>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $envio->asunto ?? '(Sin asunto)' }}
                                    @if ($numRadicado)
                                        <span class="block text-xs text-blue-600 font-normal">Radicado:
                                            {{ $numRadicado }}</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $nombreDestinatario }}</span>
                                    <span
                                        class="flex items-center gap-0.5 text-[10px] uppercase tracking-wider font-bold text-blue-500 mt-1 pb-0.5 w-fit">
                                        <span class="material-symbols-outlined" style="font-size:12px">location_on</span>
                                        Destino
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($envio->quienDirigido && $envio->quienDirigido->area)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800">
                                            {{ $envio->quienDirigido->area->area_nom }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No asignado</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                    {{ $fechaEnvio }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="{{ $priorClases }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $nombrePrioridad }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="{{ $estadoClases }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $nombreEstado }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                            class="btn-ver-detalle flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 rounded-lg text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Detalle
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyStateRow">
                                <td colspan="6" class="px-6 py-14 text-center text-gray-400 dark:text-gray-500">
                                    <span class="material-symbols-outlined text-5xl mb-3 block">inbox</span>
                                    <p class="text-sm font-medium">No se encontraron registros de correspondencia enviada.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Paginación fuera del scroll, pegada al borde inferior de la card --}}
                <div id="paginacionEnviados"
                    class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    {{ $envios->links() }}
                </div>
            </div>
        </div>
    </div>


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

    <!-- View Details Modal (Externa Envíos) -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen w-full p-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                onclick="closeModal('detailsModal')"></div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden transform transition-all">
                <div class="absolute top-4 right-4 z-10">
                    <button onclick="closeModal('detailsModal')"
                        class="p-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full transition-colors text-gray-500 dark:text-gray-400">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row h-full">
                    <!-- Detail Header Area -->
                    <div
                        class="w-full md:w-1/3 bg-gray-50 dark:bg-gray-900/50 p-8 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col items-center text-center">
                            <div class="p-4 bg-primary/10 rounded-2xl text-primary mb-4">
                                <span class="material-symbols-outlined text-4xl" id="detailIconHeader">description</span>
                            </div>
                            <h3 id="detailRadicado" class="text-xl font-bold text-gray-900 dark:text-white mb-1"></h3>
                            <span id="detailStatus" class="px-3 py-1 rounded-full text-[10px] font-bold mb-6"></span>

                            <div class="w-full space-y-4 text-left">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fecha Envío</p>
                                    <p id="detailDate" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tipo Documento</p>
                                    <p id="detailType" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Prioridad</p>
                                    <p id="detailPriority" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Content Area -->
                    <div class="flex-1 p-8 space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Asunto</h4>
                            <p id="detailAsunto" class="text-lg font-bold text-gray-900 dark:text-white leading-tight"></p>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Destinatario / Institución</h4>
                            <p id="detailDestinatario" class="text-sm text-gray-700 dark:text-gray-300 font-bold"></p>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Departamento (Área)</h4>
                            <p id="detailArea" class="text-sm text-gray-700 dark:text-gray-300 font-bold"></p>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Trazabilidad Reciente</h4>
                                <button id="btnVerTrazabilidadCompleta" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">Ver Historial</button>
                            </div>
                            <div id="detailTimeline" class="space-y-4 max-h-48 overflow-y-auto pr-2">
                                <!-- Mini timeline here -->
                                <p class="text-[10px] text-gray-400 italic">Cargando trazabilidad...</p>
                            </div>
                        </div>

                        <div class="pt-4">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Documentos del Envío</h4>
                            <div id="detailActionsContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Documents buttons here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen w-full p-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('historyModal')"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden transform transition-all">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Trazabilidad de Envío</h3>
                        <p class="text-xs text-gray-500 mt-0.5" id="historyRadText"></p>
                    </div>
                    <button onclick="closeModal('historyModal')" class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="p-8 max-h-[70vh] overflow-y-auto bg-white dark:bg-gray-800">
                    <div id="history-timeline" class="relative space-y-6">
                        <!-- Timeline items injected here -->
                        <div id="history-spinner" class="flex justify-center p-8">
                             <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20 flex justify-end">
                    <button onclick="closeModal('historyModal')" class="px-6 py-2 text-sm font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Nueva Correspondencia Enviada --}}
    <div id="modalCorrespondencia" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalCorrespondencia')"></div>
        <div class="relative w-full max-w-2xl p-4 transform transition-all">
            <form action="{{ route('remitente.externaenv.store') }}" method="POST" enctype="multipart/form-data"
                id="formNuevaCorrespondencia">
                @csrf
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <!-- Modal Header -->
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Registrar Nueva Correspondencia</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Completa los datos para el envío de correspondencia saliente.
                            </p>
                        </div>
                        <button type="button" onclick="closeModal('modalCorrespondencia')"
                            class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-8 space-y-6">
                        {{-- Asunto --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Asunto *</label>
                            <input type="text" name="asunto" required maxlength="100"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white font-medium transition-all"
                                placeholder="Resumen del documento" />
                        </div>

                        {{-- Destinatario (Destino) --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Destino *</label>
                            <textarea name="destino" required rows="3" maxlength="200"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white text-sm transition-all"
                                placeholder="Especifique el destino o persona a quien va dirigido"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Tipo de Documento --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tipo de Documento *</label>
                                <div class="relative" id="tipoDropdownContainer">
                                    <div id="tipoInputContainer" class="flex items-center gap-2 w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus-within:ring-2 focus-within:ring-primary/50 transition-all cursor-text" onclick="toggleTipoDropdown()">
                                        <input type="text" id="busquedaTipo" placeholder="Buscar tipo..." 
                                            class="flex-1 bg-transparent border-none p-0 focus:ring-0 text-sm font-medium dark:text-white dark:placeholder-gray-400"
                                            autocomplete="off" onkeyup="filtrarTipos()">
                                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                                    </div>
                                    <div id="dropdownTipoList" class="hidden absolute z-[60] w-full mt-1 border border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 shadow-xl max-h-48 overflow-y-auto">
                                        @foreach ($tipos as $tipo)
                                            <div class="tipo-item px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer border-b border-gray-50 dark:border-gray-700/50 last:border-0 text-sm dark:text-gray-200 transition-colors" 
                                                 data-nombre="{{ strtolower($tipo->tipo_nombre) }}" 
                                                 onclick="seleccionarTipo('{{ addslashes($tipo->tipo_nombre) }}', '{{ $tipo->id_tipo }}')">
                                                {{ $tipo->tipo_nombre }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="id_tipo_envio" id="id_tipo_hidden" required>
                                </div>
                            </div>

                            {{-- Departamento (Area) --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Departamento (Área) *</label>
                                <select id="selectAreaEnvia" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white text-sm transition-all appearance-none">
                                    <option value="">Filtrar por departamento</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id_area }}">{{ $area->area_nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Persona que Envía (Empleado) --}}
                            <div class="relative">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Persona que Envía *</label>
                                <div class="relative group">
                                    <input type="text" id="searchEnvia" autocomplete="off"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white font-medium transition-all pr-10"
                                        placeholder="Buscar empleado..." />
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">person_search</span>
                                </div>
                                <input type="hidden" name="doc_quien_envia" id="doc_quien_envia" required>
                                <div id="resultsEnvia"
                                    class="absolute z-[60] w-full mt-1 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-xl hidden overflow-hidden max-h-60 overflow-y-auto">
                                </div>
                            </div>

                            {{-- Folio --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Número de Folios *</label>
                                <input type="number" name="folio" required min="1" value="1"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white font-medium transition-all"
                                    placeholder="Cantidad" />
                            </div>

                            {{-- Archivo --}}
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Adjuntar Documento (PDF)</label>
                                <input type="file" name="archivo" accept="application/pdf"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700/30 p-1" />
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-8 py-6 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50/50 dark:bg-gray-900/20">
                        <button type="button" onclick="closeModal('modalCorrespondencia')"
                            class="px-6 py-2.5 text-sm text-gray-600 dark:text-gray-400 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cancelar</button>
                        <button type="submit"
                            class="px-8 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/95 transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            Registrar Envío
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- View Details Modal -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('detailsModal')"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden transform transition-all m-4">
            <button onclick="closeModal('detailsModal')" class="absolute top-4 right-4 p-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full transition-colors text-gray-500 dark:text-gray-400 z-10">
                <span class="material-symbols-outlined">close</span>
            </button>

            <div class="flex flex-col md:flex-row">
                <!-- Header Area -->
                <div class="w-full md:w-1/3 bg-gray-50 dark:bg-gray-900/40 p-8 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-4 bg-primary/10 rounded-2xl text-primary mb-4">
                            <span id="detailIconHeader" class="material-symbols-outlined text-4xl">outbox</span>
                        </div>
                        <h3 id="detailRadicado" class="text-xl font-bold text-gray-900 dark:text-white mb-1"></h3>
                        <span id="detailStatus" class="px-3 py-1 rounded-full text-[10px] font-bold mb-6"></span>

                        <div class="w-full space-y-4 text-left">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fecha Registro</p>
                                <p id="detailDate" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tipo Documento</p>
                                <p id="detailType" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Prioridad</p>
                                <span id="detailPriority" class="text-xs font-bold"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="flex-1 p-8 space-y-6">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Asunto</h4>
                        <p id="detailAsunto" class="text-lg font-bold text-gray-900 dark:text-white leading-tight"></p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Destinatario / Destino</h4>
                        <p id="detailDestinatario" class="text-sm text-gray-600 dark:text-gray-400 font-medium"></p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Trazabilidad Reciente</h4>
                        <div id="detailTimeline" class="space-y-4">
                            <!-- Injected by JS -->
                        </div>
                        <button id="btnVerTrazabilidadCompleta" class="mt-4 text-[10px] font-bold text-primary uppercase tracking-widest hover:underline">Ver Historial Completo</button>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Documentos y Anexos</h4>
                        <div id="detailActionsContainer" class="flex flex-wrap gap-2">
                            <!-- Injected by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('historyModal')"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden transform transition-all m-4">
            <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Historial de Movimientos</h3>
                    <p class="text-[10px] text-gray-500 font-bold mt-0.5" id="historyRadText"></p>
                </div>
                <button onclick="closeModal('historyModal')" class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-8 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <div id="history-spinner" class="hidden flex justify-center py-10">
                    <div class="w-8 h-8 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                </div>
                <div id="history-timeline" class="space-y-0">
                    <!-- Injected by JS -->
                </div>
            </div>
            <div class="px-8 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20 flex justify-end">
                <button onclick="closeModal('historyModal')" class="px-6 py-2 text-xs font-bold text-gray-500 uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cerrar</button>
            </div>
        </div>
    </div>

    {{-- Script básico para interacción visual --}}
    <script>
        // Funciones Globales para Modales
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('hidden');
                el.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('hidden');
                el.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // --- MODALES ---
            const btnAbrir = document.getElementById('btnAbrirModal');
            const btnCerrar = document.getElementById('btnCerrarModal');

            if (btnAbrir) btnAbrir.addEventListener('click', () => openModal('modalCorrespondencia'));
            if (btnCerrar) btnCerrar.addEventListener('click', () => closeModal('modalCorrespondencia'));

            if (new URLSearchParams(window.location.search).get('abrir') === 'nuevo') {
                openModal('modalCorrespondencia');
            }

            // --- AJAX SEARCH HELPERS ---
            function setupSearch(inputId, resultsId, hiddenId, url) {
                const input = document.getElementById(inputId);
                const results = document.getElementById(resultsId);
                const hidden = document.getElementById(hiddenId);
                const areaSelect = document.getElementById('selectAreaEnvia');

                if (!input || !results) return;

                input.addEventListener('input', async function() {
                    const q = this.value.trim();
                    const areaId = areaSelect ? areaSelect.value : '';
                    
                    if (q.length < 2 && !areaId) {
                        results.classList.add('hidden');
                        return;
                    }

                    try {
                        const response = await fetch(`${url}?q=${q}&area_id=${areaId}`);
                        const data = await response.json();

                        results.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'px-4 py-3 hover:bg-primary/5 hover:text-primary cursor-pointer flex flex-col border-b border-gray-50 dark:border-gray-700/50 last:border-0 transition-colors group';
                                
                                const areaInfo = item.area_nom ? `<span class="text-[10px] text-primary font-bold uppercase tracking-wider">${item.area_nom}</span>` : '';
                                
                                div.innerHTML = `
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">${item.emple_nombres} ${item.emple_apellidos}</span>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[10px] text-gray-400 font-medium italic">Doc: ${item.emple_doc}</span>
                                            ${areaInfo}
                                        </div>
                                    </div>
                                `;
                                
                                div.addEventListener('mousedown', (e) => {
                                    // Use mousedown to trigger before the input's potential blur
                                    e.preventDefault(); 
                                    input.value = `${item.emple_nombres} ${item.emple_apellidos}`;
                                    hidden.value = item.emple_doc;
                                    results.classList.add('hidden');
                                });
                                results.appendChild(div);
                            });
                            results.classList.remove('hidden');
                        } else {
                            results.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 italic text-center">No se encontraron empleados</div>';
                            results.classList.remove('hidden');
                        }
                    } catch (error) {
                        console.error('Error in search:', error);
                    }
                });

                if(areaSelect) {
                    areaSelect.addEventListener('change', () => {
                        if(input.value.length >= 2 || areaSelect.value) {
                            input.dispatchEvent(new Event('input'));
                        }
                    });
                }
            }

            setupSearch('searchEnvia', 'resultsEnvia', 'doc_quien_envia',
                '{{ route('remitente.buscar_empleados') }}');

            // --- SEARCHABLE SELECT LOGIC ---
            window.toggleTipoDropdown = function() {
                const list = document.getElementById('dropdownTipoList');
                list.classList.toggle('hidden');
            }

            window.filtrarTipos = function() {
                const q = document.getElementById('busquedaTipo').value.toLowerCase();
                const items = document.querySelectorAll('.tipo-item');
                let match = false;
                items.forEach(item => {
                    const text = item.dataset.nombre;
                    if (text.includes(q)) {
                        item.classList.remove('hidden');
                        match = true;
                    } else {
                        item.classList.add('hidden');
                    }
                });
                document.getElementById('dropdownTipoList').classList.remove('hidden');
            }

            window.seleccionarTipo = function(nombre, id) {
                document.getElementById('busquedaTipo').value = nombre;
                document.getElementById('id_tipo_hidden').value = id;
                document.getElementById('dropdownTipoList').classList.add('hidden');
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                const container = document.getElementById('tipoDropdownContainer');
                if (container && !container.contains(e.target)) {
                    document.getElementById('dropdownTipoList')?.classList.add('hidden');
                }
            });

            // --- DETALLE LOGIC ---
            document.querySelectorAll('.fila-registro').forEach(fila => {
                fila.addEventListener('click', function() {
                    const data = this.dataset;
                    openDetalleModal(data);
                });
            });

            // Prevent row click when clicking the "Detalle" button specifically
            document.querySelectorAll('.btn-ver-detalle').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const fila = this.closest('.fila-registro');
                    if (fila) openDetalleModal(fila.dataset);
                });
            });

            function openDetalleModal(data) {
                try {
                    // Llenar datos base Modal
                    document.getElementById('detailRadicado').textContent = data.radicado || 'SIN RADICADO';
                    document.getElementById('detailAsunto').textContent = data.asunto || '(Sin asunto)';
                    document.getElementById('detailDestinatario').textContent = data.destinatario || '—';
                    if (document.getElementById('detailArea')) {
                        document.getElementById('detailArea').textContent = data.area || '—';
                    }
                    document.getElementById('detailDate').textContent = data.fecha || '—';
                    document.getElementById('detailType').textContent = data.tipoDoc || 'No especificado';
                    document.getElementById('detailPriority').textContent = data.prioridad || '—';
                    
                    if (document.getElementById('detailIconHeader')) {
                        document.getElementById('detailIconHeader').textContent = data.icono || 'description';
                    }

                    // Estilos Estado
                    const statusEl = document.getElementById('detailStatus');
                    statusEl.textContent = data.estado || '—';
                    statusEl.className = 'px-3 py-1 rounded-full text-[10px] font-bold mb-6 ' + (data.estadoClases || 'bg-gray-100 text-gray-700');

                    // Documentos
                    const actionArea = document.getElementById('detailActionsContainer');
                    actionArea.innerHTML = '';

                    // Principal
                    if (data.archivo) {
                        const btn = document.createElement('a');
                        btn.href = data.archivo;
                        btn.target = '_blank';
                        btn.className = 'flex items-center gap-2 px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 rounded-xl hover:bg-blue-100 transition-all border border-blue-100 dark:border-blue-800';
                        btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">description</span> Principal';
                        actionArea.appendChild(btn);
                    }

                    // Anexos
                    let anexos = [];
                    try {
                        anexos = JSON.parse(data.anexos || '[]');
                    } catch (e) {
                        console.error("Error parsing anexos JSOn:", e);
                    }

                    if (anexos.length > 0) {
                        anexos.forEach((anexo, idx) => {
                            const btn = document.createElement('a');
                            btn.href = `/storage/${anexo.ruta_archivo}`;
                            btn.target = '_blank';
                            btn.className = 'flex items-center gap-2 px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-gray-600 bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400 rounded-xl hover:bg-gray-100 transition-all border border-gray-100 dark:border-gray-600';
                            btn.title = anexo.nombre_original;
                            btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">attach_file</span> Anexo ${idx + 1}`;
                            actionArea.appendChild(btn);
                        });
                    }

                    // Configurar botón "Ver Historial"
                    document.getElementById('btnVerTrazabilidadCompleta').onclick = () => {
                        window.closeModal('detailsModal');
                        showHistoryModal(data.id, data.radicado);
                    };

                    // Cargar mini-trazabilidad
                    loadMiniHistory(data.id);

                    window.openModal('detailsModal');
                } catch (err) {
                    console.error("Error in openDetalleModal:", err);
                }
            }

            function loadMiniHistory(id) {
                const timeline = document.getElementById('detailTimeline');
                timeline.innerHTML = '<p class="text-[10px] text-gray-400 italic animate-pulse">Cargando...</p>';

                fetch(`/remitente/externaenv/${id}/history`)
                    .then(res => res.json())
                    .then(data => {
                        timeline.innerHTML = '';
                        if (data.length === 0) {
                            timeline.innerHTML = '<p class="text-[10px] text-gray-400 italic">Sin movimientos registrados</p>';
                            return;
                        }

                        // Mostrar últimos 3 movimientos
                        data.slice(0, 3).forEach(item => {
                            const date = new Date(item.fecha);
                            const dateStr = date.toLocaleDateString('es-ES', { day: '2-digit', month: 'short' });
                            
                            const div = document.createElement('div');
                            div.className = 'flex gap-3 text-[11px]';
                            div.innerHTML = `
                                <span class="text-gray-400 font-bold shrink-0">${dateStr}</span>
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800 dark:text-gray-200 uppercase tracking-tight">${item.estado_nomb}</span>
                                    <span class="text-gray-500 text-[10px]">${item.nombres} ${item.apellidos}</span>
                                </div>
                            `;
                            timeline.appendChild(div);
                        });
                    });
            }

            function showHistoryModal(id, radicado) {
                document.getElementById('historyRadText').textContent = radicado ? `Radicado: ${radicado}` : 'Historial de movimientos';
                loadHistory(id);
                openModal('historyModal');
            }

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
                            timeline.innerHTML =
                                '<p class="text-[10px] text-gray-400 p-4 font-bold uppercase tracking-widest text-center">Sin trazabilidad registrada</p>';
                            return;
                        }

                        data.forEach((item, index) => {
                            const date = new Date(item.fecha);
                            const dateStr = date.toLocaleDateString('es-ES', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });
                            const timeStr = date.toLocaleTimeString('es-ES', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            const isLast = index === data.length - 1;

                            let icon = 'info';
                            let circleClass = 'bg-gray-100 text-gray-600';

                            if (item.type === 'registry') {
                                icon = 'edit_document';
                                circleClass = 'bg-blue-100 text-blue-600';
                            } else {
                                switch (parseInt(item.id_estado_rec)) {
                                    case 7:
                                        icon = 'mark_email_read';
                                        circleClass = 'bg-green-100 text-green-600';
                                        break;
                                    case 8:
                                        icon = 'pending_actions';
                                        circleClass = 'bg-amber-100 text-amber-600';
                                        break;
                                    case 9:
                                    case 10:
                                        icon = 'check_circle';
                                        circleClass = 'bg-emerald-100 text-emerald-600';
                                        break;
                                    case 11:
                                        icon = 'cancel';
                                        circleClass = 'bg-red-100 text-red-600';
                                        break;
                                    case 12:
                                        icon = 'send';
                                        circleClass = 'bg-blue-100 text-blue-600';
                                        break;
                                    case 14:
                                        icon = 'outbox';
                                        circleClass = 'bg-emerald-100 text-emerald-600';
                                        break;
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
                                                <span class="text-[8px] text-gray-500 font-bold uppercase mt-0.5">${item.area_e || 'Remitente'}</span>
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
                        timeline.innerHTML =
                            '<p class="text-[10px] text-red-500 p-4 font-bold uppercase tracking-widest text-center">Error al cargar trazabilidad</p>';
                        console.error(err);
                    });
            }

            // Removed non-existent aside logic

            // --- VISOR DE DOCUMENTOS ---
            const modalVisor = document.getElementById('modalVisorDocumentos');
            const btnVerDocumento = document.getElementById('btnVerDocumento');
            const btnCerrarVisor = document.querySelectorAll('.btnCerrarVisor');

            if (btnVerDocumento) {
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
                        sinAnexos?.classList.remove('hidden');
                        listaAnexos?.classList.add('hidden');
                    }

                    openModal('modalVisorDocumentos');
                });
            }

            if (btnCerrarVisor) {
                btnCerrarVisor.forEach(btn => {
                    btn.addEventListener('click', () => {
                        closeModal('modalVisorDocumentos');
                    });
                });
            }

            // Cerrar al click afuera
            if (modalVisor) {
                modalVisor.addEventListener('click', (e) => {
                    if (e.target === modalVisor) {
                        closeModal('modalVisorDocumentos');
                    }
                });
            }

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
            
            // Initialize Select2 if jQuery is loaded
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.select2 !== 'undefined') {
                $('.select2-tipo').select2({
                    placeholder: "Buscar tipo...",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#modalCorrespondencia')
                });
            }
    </script>
@endsection

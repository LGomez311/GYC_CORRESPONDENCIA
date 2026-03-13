@extends('remitente.layouts.app')


@section('title', 'Panel de Remitente')
<!-- Main Content -->
@section('content')
    {{-- Ãrea principal con scroll --}}
    <div class="flex-1 flex flex-col p-6 overflow-y-auto min-w-0">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <h1 class="text-gray-900 dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">
                        Correspondencia Externa Recibida
                    </h1>

                    <button id="btnAbrirModal"
                        class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all shadow-sm dark:bg-blue-500 dark:hover:bg-blue-600 w-max">
                        <span class="material-symbols-outlined text-base">add</span>
                        Nueva Correspondencia
                    </button>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-grow">                        <form id="formSearchGlobal" method="GET" action="{{ url()->current() }}" class="flex flex-col min-w-40 h-10 w-full" onsubmit="return false;">
                            @if(request('tipo') && request('tipo') !== 'todos')
                                <input type="hidden" name="tipo" value="{{ request('tipo') }}">
                            @endif
                            <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                                <div class="text-gray-500 dark:text-gray-400 flex border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                                    <span id="searchIconGlobal" class="material-symbols-outlined">search</span>
                                    <span id="searchSpinnerGlobal" class="material-symbols-outlined animate-spin hidden text-primary">progress_activity</span>
                                </div>
                                <input
                                    id="searchInputGlobal"
                                    name="search"
                                    type="text"
                                    autocomplete="off"
                                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden {{ request('search') ? '' : 'rounded-r-lg' }} text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal"
                                    placeholder="Buscar documento..." value="{{ request('search') }}" />
                                <button type="button" id="btnClearSearchGlobal" class="{{ request('search') ? 'flex' : 'hidden' }} items-center justify-center px-4 border border-gray-200 border-l-0 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-r-lg transition-colors" title="Limpiar búsqueda">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <button
                            class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <span
                                class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">filter_list</span>
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Prioridad</p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button>
                        {{-- <button
                            class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <span
                                class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">description</span>
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Tipo de
                                Documento</p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button> --}}

                        {{-- Filtro: Tipo de Remitente --}}
                        <div class="relative" id="filtroRemitenteWrapper">
                            <button type="button" id="btnFiltroRemitente"
                                class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg px-4 border transition-colors
                                    {{ $tipoFiltro !== 'todos'
                                        ? 'bg-blue-50 dark:bg-blue-900/30 border-blue-300 dark:border-blue-700 text-blue-700 dark:text-blue-300'
                                        : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                                <span class="material-symbols-outlined text-sm
                                    {{ $tipoFiltro !== 'todos' ? 'text-blue-500' : 'text-gray-500 dark:text-gray-400' }}">person_search</span>
                                <p id="btnFiltroRemitenteLabel"
                                    class="text-sm font-medium leading-normal
                                    {{ $tipoFiltro !== 'todos' ? 'text-blue-700 dark:text-blue-300 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                                    @if($tipoFiltro === 'persona') Persona Natural
                                    @elseif($tipoFiltro === 'entidad') Entidad / Empresa
                                    @else Remitente
                                    @endif
                                </p>
                                <span class="material-symbols-outlined {{ $tipoFiltro !== 'todos' ? 'text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">expand_more</span>
                            </button>
                            <div id="dropdownFiltroRemitente"
                                class="hidden absolute right-0 z-20 mt-1 w-52 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg overflow-hidden">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-300">
                                    <li><button type="button" data-tipo="todos"
                                            class="filtro-remitente-btn w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700
                                                {{ $tipoFiltro === 'todos' ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'font-medium' }}">Todos</button>
                                    </li>
                                    <li><button type="button" data-tipo="persona"
                                            class="filtro-remitente-btn w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700
                                                {{ $tipoFiltro === 'persona' ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">Persona
                                            Natural</button></li>
                                    <li><button type="button" data-tipo="entidad"
                                            class="filtro-remitente-btn w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700
                                                {{ $tipoFiltro === 'entidad' ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">Entidad
                                            / Empresa</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 flex flex-col bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <div class="overflow-x-auto overflow-y-auto max-h-[calc(100vh-280px)]">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 sticky top-0">
                                <tr>
                                    <th class="px-6 py-3 font-bold" scope="col">Asunto</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Remitente</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Destinatarios</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Fecha de Recepción</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Prioridad</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody id="tablaRecibidosBody">
                                @forelse($recibidos as $rec)
                                    @php
                                        // --- Tipo de remitente ---
                                        $esPersona = !empty($rec->nombre_persona) || !empty($rec->doc_persona);
                                        $tipoRow = $esPersona ? 'persona' : 'entidad';

                                        // --- Remitente display ---
                                        $remitenteDisplay = $esPersona
                                            ? ($rec->nombre_persona ?:
                                            $rec->doc_persona)
                                            : ($rec->nom_institucion ?:
                                            '—');

                                        // --- Estado badge ---
                                        $estadoNombre = $rec->estado_nomb ?? 'Sin estado';
                                        $low = strtolower($estadoNombre);
                                        if (str_contains($low, 'pendiente') || str_contains($low, 'recibido')) {
                                            $estadoClases =
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                                        } elseif (
                                            str_contains($low, 'tramite') ||
                                            str_contains($low, 'proceso') ||
                                            str_contains($low, 'tránsito')
                                        ) {
                                            $estadoClases =
                                                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                                        } elseif (
                                            str_contains($low, 'finaliz') ||
                                            str_contains($low, 'complet') ||
                                            str_contains($low, 'resuel')
                                        ) {
                                            $estadoClases =
                                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                        } elseif (str_contains($low, 'rechaz') || str_contains($low, 'cancel')) {
                                            $estadoClases = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                        } elseif (
                                            str_contains($low, 'leido') ||
                                            str_contains($low, 'leído') ||
                                            str_contains($low, 'visto')
                                        ) {
                                            $estadoClases =
                                                'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300';
                                        } elseif (str_contains($low, 'archiv')) {
                                            $estadoClases =
                                                'bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200';
                                        } else {
                                            $estadoClases =
                                                'bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200';
                                        }

                                        // --- Prioridad badge ---
                                        $priorNombre = $rec->prioridad_nombre ?? null;
                                        $priorClases = 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
                                        if ($priorNombre) {
                                            $pl = strtolower($priorNombre);
                                            if (
                                                str_contains($pl, 'alta') ||
                                                str_contains($pl, 'urgente') ||
                                                str_contains($pl, 'critica') ||
                                                str_contains($pl, 'crítica')
                                            ) {
                                                $priorClases =
                                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                            } elseif (
                                                str_contains($pl, 'media') ||
                                                str_contains($pl, 'normal') ||
                                                str_contains($pl, 'moderada')
                                            ) {
                                                $priorClases =
                                                    'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300';
                                            } elseif (str_contains($pl, 'baja') || str_contains($pl, 'bajo')) {
                                                $priorClases =
                                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                            }
                                        }

                                        // --- Fecha ---
                                        $fechaFormateada = $rec->fecha_hora_recib
                                            ? \Carbon\Carbon::parse($rec->fecha_hora_recib)->format('d M, Y - H:i')
                                            : '—';
                                    @endphp
                                    <tr data-tipo="{{ $tipoRow }}"
                                        data-id="{{ $rec->id_recibido }}"
                                        data-asunto="{{ $rec->asunto ?? '' }}"
                                        data-radicado-ext="{{ $rec->num_radicado_ext ?? '' }}"
                                        data-radicado-int="{{ $rec->num_radicado ?? '' }}"
                                        data-remitente="{{ $remitenteDisplay }}"
                                        data-correo="{{ $rec->correo_persona ?? '' }}"
                                        data-telefono="{{ $rec->tel_persona ?? '' }}"
                                        data-fecha="{{ $fechaFormateada }}"
                                        data-prioridad="{{ $priorNombre ?? '' }}"
                                        data-prioridad-clases="{{ $priorClases }}"
                                        data-estado="{{ $estadoNombre }}"
                                        data-estado-clases="{{ $estadoClases }}"
                                        data-tipo-remitente="{{ $esPersona ? 'persona' : 'entidad' }}"
                                        data-tipo-doc="{{ $rec->tipo_nombre ?? '' }}"
                                        data-archivo="{{ $rec->archivo ?? '' }}"
                                        data-destinatarios="{{ $rec->destinatarios_nombres ?? '—' }}"
                                        data-observaciones="{{ $rec->observaciones ?? '' }}"
                                        class="fila-registro border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer bg-white dark:bg-gray-800 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $rec->asunto ?? '(Sin asunto)' }}
                                            @if ($rec->num_radicado_ext)
                                                <span class="block text-xs text-blue-600 font-normal">Ext:
                                                    {{ $rec->num_radicado_ext }}</span>
                                            @endif
                                            <span class="block text-xs text-blue-600 font-normal">Int:
                                                {{ $rec->num_radicado }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="font-medium text-gray-900 dark:text-white">{{ $remitenteDisplay }}</span>
                                            @if ($esPersona && $rec->correo_persona)
                                                <span class="block text-xs text-gray-400">{{ $rec->correo_persona }}</span>
                                            @endif
                                            <span
                                                class="flex items-center gap-0.5 text-xs {{ $esPersona ? 'text-purple-500' : 'text-blue-500' }} mt-0.5">
                                                <span class="material-symbols-outlined"
                                                    style="font-size:13px">{{ $esPersona ? 'person' : 'business' }}</span>
                                                {{ $esPersona ? 'Persona Natural' : 'Entidad / Empresa' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 max-w-[200px]">
                                            @if(isset($rec->destinatarios_nombres) && $rec->destinatarios_nombres !== '—' && !empty($rec->destinatarios_nombres))
                                                {!! str_replace(', ', '<br>', e($rec->destinatarios_nombres)) !!}
                                            @else
                                                <span class="text-gray-400 italic">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                            {{ $fechaFormateada }}</td>
                                        <td class="px-6 py-4">
                                            @if ($priorNombre)
                                                <span
                                                    class="{{ $priorClases }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $priorNombre }}</span>
                                            @else
                                                <span class="text-gray-400 text-xs italic">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="{{ $estadoClases }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $estadoNombre }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyStateRow">
                                        <td colspan="6" class="px-6 py-14 text-center text-gray-400 dark:text-gray-500">
                                            <span class="material-symbols-outlined text-5xl mb-3 block">inbox</span>
                                            <p class="text-sm font-medium">No hay correspondencia registrada aún.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Paginación fuera del scroll, pegada al borde inferior de la card --}}
                    <div id="paginacionRecibidos" class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                        {{ $recibidos->links() }}
                    </div>
                </div>
            </div>

            <aside id="asideDetalle"
                class="w-72 shrink-0 border-l border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-col sticky top-0 h-screen overflow-y-auto">

                {{-- Estado vacío --}}
                <div id="asideVacio" class="flex flex-col items-center justify-center h-full p-6 text-center">
                    <span class="material-symbols-outlined text-5xl text-gray-300 dark:text-gray-600 mb-3">article</span>
                    <p class="text-sm font-medium text-gray-400 dark:text-gray-500">Selecciona un registro de la tabla para ver su detalle</p>
                </div>

                {{-- Contenido dinámico (oculto hasta selección) --}}
                <div id="asideContenido" class="hidden flex flex-col h-full">

                    {{-- Cabecera del aside --}}
                    <div class="px-5 pt-5 pb-3 border-b border-gray-100 dark:border-gray-700 flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="material-symbols-outlined text-blue-500 text-2xl shrink-0">description</span>
                            <div class="min-w-0">
                                <h2 id="aside-asunto" class="text-sm font-bold text-gray-900 dark:text-white leading-tight line-clamp-2"></h2>
                                <p id="aside-radicados" class="text-xs text-blue-500 mt-0.5"></p>
                            </div>
                        </div>
                        <button id="btnCerrarAside" class="shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors" title="Cerrar">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>

                    {{-- Información del registro --}}
                    <div class="flex-1 overflow-y-auto px-5 py-4 space-y-4">

                        {{-- Remitente --}}
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Remitente</span>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span id="aside-tipo-icon" class="material-symbols-outlined text-xs"></span>
                                <span id="aside-remitente" class="text-sm font-medium text-gray-900 dark:text-white"></span>
                            </div>
                            <p id="aside-correo" class="text-xs text-gray-400 mt-0.5 hidden"></p>
                            <p id="aside-telefono" class="text-xs text-gray-400 hidden"></p>
                        </div>

                        {{-- Fecha --}}
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Fecha de Recepción</span>
                            <p id="aside-fecha" class="text-sm font-medium text-gray-900 dark:text-white mt-1"></p>
                        </div>

                        {{-- Tipo de documento --}}
                        <div id="aside-tipo-doc-wrap">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Tipo Documento</span>
                            <p id="aside-tipo-doc" class="text-sm font-medium text-gray-900 dark:text-white mt-1"></p>
                        </div>

                        {{-- Destinatarios --}}
                        <div id="aside-destinatarios-wrap">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Dirigido A</span>
                            <div class="mt-1 flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-sm text-gray-400 mt-0.5">groups</span>
                                <p id="aside-destinatarios" class="text-sm font-medium text-gray-900 dark:text-white leading-relaxed"></p>
                            </div>
                        </div>

                        {{-- Observaciones --}}
                        <div id="aside-observaciones-wrap" class="hidden">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Observaciones</span>
                            <div class="mt-1 flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-sm text-gray-400 mt-0.5">comment</span>
                                <p id="aside-observaciones" class="text-sm font-medium text-gray-900 dark:text-white leading-relaxed"></p>
                            </div>
                        </div>

                        {{-- Prioridad + Estado --}}
                        <div class="flex gap-4">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Prioridad</span>
                                <div class="mt-1">
                                    <span id="aside-prioridad" class="text-xs font-medium px-2 py-0.5 rounded-full">—</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Estado</span>
                                <div class="mt-1">
                                    <span id="aside-estado" class="text-xs font-medium px-2 py-0.5 rounded-full"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Archivos Adjuntos --}}
                        <div class="pt-2">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Documentos Adjuntos</span>
                                <span id="aside-archivos-spinner" class="hidden material-symbols-outlined animate-spin text-blue-500" style="font-size: 14px;">progress_activity</span>
                            </div>
                            
                            <div id="aside-archivos-lista" class="space-y-2">
                                {{-- Se llena dinámicamente via JS --}}
                            </div>
                            
                            <div id="aside-archivos-error" class="hidden mt-2 p-2 rounded-lg bg-red-50 text-red-600 text-xs flex items-center gap-1.5 border border-red-100 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                                <span class="material-symbols-outlined text-sm shrink-0">error</span>
                                <span>Error al cargar documentos.</span>
                            </div>
                        </div>

                    </div>

                </div>
            </aside>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const modal = document.getElementById('modalCorrespondencia');
                    const btnAbrir = document.getElementById('btnAbrirModal');
                    const btnCerrar = document.getElementById('btnCerrarModal');

                    // Función para abrir el modal
                    btnAbrir.addEventListener('click', function(e) {
                        e.preventDefault();
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                    });

                    // Auto-abrir el modal si hay errores de validación del intento anterior
                    @if ($errors->any())
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                        // Scroll al tope del modal para ver el bloque de errores
                        setTimeout(function() {
                            const scrollable = modal.querySelector('.overflow-y-auto');
                            if (scrollable) scrollable.scrollTop = 0;
                        }, 100);
                    @endif

                    // Función para cerrar el modal desde el botón Cancelar
                    btnCerrar.addEventListener('click', function() {
                        cerrarModal();
                    });

                    // Función para cerrar el modal si se hace clic afuera
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            cerrarModal();
                        }
                    });

                    function cerrarModal() {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.style.overflow = '';
                    }


                    // ===== ASIDE DETALLE DE REGISTRO =====
                    const asideVacio     = document.getElementById('asideVacio');
                    const asideContenido = document.getElementById('asideContenido');

                    function poblarAside(fila) {
                        const d = fila.dataset;
                        document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('bg-blue-50', 'dark:bg-blue-900/10'));
                        fila.classList.add('bg-blue-50', 'dark:bg-blue-900/10');

                        // Guardamos todo el dataset en sessionStorage para mantenerlo entre páginas
                        const dataToSave = { ...d };
                        sessionStorage.setItem('externarec_selected', JSON.stringify(dataToSave));
                        
                        renderAsideData(dataToSave);
                        cargarArchivosAside(d.id, d.archivo);
                    }

                    function renderAsideData(d) {
                        document.getElementById('aside-asunto').textContent = d.asunto || '(Sin asunto)';
                        let radTxt = '';
                        if (d.radicadoInt) radTxt += 'Int: ' + d.radicadoInt;
                        if (d.radicadoExt) radTxt += (radTxt ? '  ·  Ext: ' : 'Ext: ') + d.radicadoExt;
                        document.getElementById('aside-radicados').textContent = radTxt;
                        const esPersona = d.tipoRemitente === 'persona';
                        const iconEl = document.getElementById('aside-tipo-icon');
                        iconEl.textContent = esPersona ? 'person' : 'business';
                        iconEl.className = 'material-symbols-outlined text-sm ' + (esPersona ? 'text-purple-500' : 'text-blue-500');
                        document.getElementById('aside-remitente').textContent = d.remitente || '—';
                        const correoEl = document.getElementById('aside-correo');
                        if (d.correo) { correoEl.textContent = d.correo; correoEl.classList.remove('hidden'); } else { correoEl.classList.add('hidden'); }
                        const telEl = document.getElementById('aside-telefono');
                        if (d.telefono) { telEl.textContent = '📞 ' + d.telefono; telEl.classList.remove('hidden'); } else { telEl.classList.add('hidden'); }
                        document.getElementById('aside-fecha').textContent = d.fecha || '—';
                        const tipoDocWrap = document.getElementById('aside-tipo-doc-wrap');
                        if (d.tipoDoc) { document.getElementById('aside-tipo-doc').textContent = d.tipoDoc; tipoDocWrap.classList.remove('hidden'); } else { tipoDocWrap.classList.add('hidden'); }
                        
                        const destWrap = document.getElementById('aside-destinatarios-wrap');
                        if (d.destinatarios && d.destinatarios !== '—') {
                            document.getElementById('aside-destinatarios').innerHTML = d.destinatarios.replace(/,/g, '<br>');
                            destWrap.classList.remove('hidden');
                        } else {
                            destWrap.classList.add('hidden');
                        }

                        const obsWrap = document.getElementById('aside-observaciones-wrap');
                        if (d.observaciones) {
                            document.getElementById('aside-observaciones').textContent = d.observaciones;
                            obsWrap.classList.remove('hidden');
                        } else {
                            obsWrap.classList.add('hidden');
                        }

                        const priorEl = document.getElementById('aside-prioridad');
                        priorEl.textContent = d.prioridad || '—';
                        priorEl.className = 'text-xs font-medium px-2 py-0.5 rounded-full ' + (d.prioridadClases || 'bg-gray-100 text-gray-600');
                        const estadoEl = document.getElementById('aside-estado');
                        estadoEl.textContent = d.estado || '—';
                        estadoEl.className = 'text-xs font-medium px-2 py-0.5 rounded-full ' + (d.estadoClases || 'bg-gray-100 text-gray-600');
                        asideVacio.classList.add('hidden');
                        asideContenido.classList.remove('hidden');

                        cargarArchivosAside(d.id, d.archivo);
                    }

                    function cargarArchivosAside(id, archivoPrincipalRow) {
                        const lista = document.getElementById('aside-archivos-lista');
                        const spinner = document.getElementById('aside-archivos-spinner');
                        const errorEl = document.getElementById('aside-archivos-error');

                        lista.innerHTML = '';
                        errorEl.classList.add('hidden');
                        spinner.classList.remove('hidden');

                        // Si tenemos el archivo principal en el row de una vez lo mostramos (optimistic UI)
                        if (archivoPrincipalRow) {
                            const nombre = archivoPrincipalRow.split('/').pop();
                            lista.innerHTML = `
                                <div class="mb-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-2">Documento Principal</div>
                                <a href="/storage/${archivoPrincipalRow}" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center gap-2 p-2.5 rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors group mb-2 text-left">
                                    <span class="material-symbols-outlined text-blue-500 text-base flex-shrink-0">picture_as_pdf</span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-blue-700 dark:text-blue-300 truncate group-hover:underline">${nombre}</p>
                                    </div>
                                    <span class="material-symbols-outlined text-blue-400 text-xs flex-shrink-0">open_in_new</span>
                                </a>
                            `;
                        }

                        fetch('{{ url('/remitente/externarec') }}/' + id + '/archivos', {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(r => r.json())
                        .then(data => {
                            spinner.classList.add('hidden');
                            
                            const tienePrincipal = !!data.archivo_principal;
                            const tieneAnexos = data.anexos && data.anexos.length > 0;

                            if (!tienePrincipal && !tieneAnexos) {
                                lista.innerHTML = '<div class="text-xs text-gray-400 dark:text-gray-500 italic p-3 text-center bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">Sin archivos adjuntos.</div>';
                                return;
                            }

                            let html = '';

                            if (tienePrincipal) {
                                const href = '/storage/' + data.archivo_principal;
                                const nombre = data.archivo_principal.split('/').pop();
                                html += `
                                    <div class="mb-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-2">Documento Principal</div>
                                    <a href="${href}" target="_blank" rel="noopener noreferrer"
                                        class="flex items-center gap-2 p-2.5 rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors group mb-2 text-left">
                                        <span class="material-symbols-outlined text-blue-500 text-base flex-shrink-0">picture_as_pdf</span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-blue-700 dark:text-blue-300 truncate group-hover:underline">${nombre}</p>
                                        </div>
                                        <span class="material-symbols-outlined text-blue-400 text-xs flex-shrink-0">open_in_new</span>
                                    </a>
                                `;
                            }

                            if (tieneAnexos) {
                                html += `<div class="mb-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-3">Anexos</div>`;
                                data.anexos.forEach(a => {
                                    const href = '/storage/' + a.ruta_archivo;
                                    html += `
                                        <a href="${href}" target="_blank" rel="noopener noreferrer"
                                            class="flex items-center gap-2 p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group mb-2 text-left">
                                            <span class="material-symbols-outlined text-gray-400 text-base flex-shrink-0">attach_file</span>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate group-hover:underline">${a.nombre_original}</p>
                                            </div>
                                            <span class="material-symbols-outlined text-gray-400 text-xs flex-shrink-0">open_in_new</span>
                                        </a>
                                    `;
                                });
                            }
                            
                            lista.innerHTML = html;
                        })
                        .catch(() => {
                            spinner.classList.add('hidden');
                            if (!archivoPrincipalRow) {
                                errorEl.classList.remove('hidden');
                            }
                        });
                    }

                    document.getElementById('tablaRecibidosBody').addEventListener('click', function(e) {
                        const fila = e.target.closest('.fila-registro');
                        if (fila) poblarAside(fila);
                    });

                    document.getElementById('btnCerrarAside').addEventListener('click', function() {
                        asideVacio.classList.remove('hidden');
                        asideContenido.classList.add('hidden');
                        document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('bg-blue-50', 'dark:bg-blue-900/10'));
                        sessionStorage.removeItem('externarec_selected');
                    });

                    // Intentar recuperar el estado previo al cargar la página
                    const storedAside = sessionStorage.getItem('externarec_selected');
                    if (storedAside) {
                        try {
                            const data = JSON.parse(storedAside);
                            renderAsideData(data);
                            // Resaltar la fila si existe en la página actual
                            const sRow = document.querySelector(`.fila-registro[data-id="${data.id}"]`);
                            if (sRow) {
                                sRow.classList.add('bg-blue-50', 'dark:bg-blue-900/10');
                            }
                        } catch (e) {
                            sessionStorage.removeItem('externarec_selected');
                        }
                    }
                    // ===== BUSCADOR DE CIUDAD PROVENIENTE =====
                    const TODAS_CIUDADES = @json($ciudades);
                    const btnToggleCiudades = document.getElementById('btnToggleCiudades');
                    const dropdownCiudades = document.getElementById('ciudadesDropdown');
                    const inputBuscarCiudad = document.getElementById('buscarCiudadInput');
                    const listaCiudadesEl = document.getElementById('listaCiudades');
                    const hiddenCiudad = document.getElementById('ciudad_proveniente_value');
                    const labelBtnCiudad = document.getElementById('btnToggleCiudadesLabel');
                    function renderCiudades(ciudadesMostrar) {
                        listaCiudadesEl.innerHTML = '';
                        if (ciudadesMostrar.length === 0) {
                            listaCiudadesEl.innerHTML = '<li class="px-3 py-2 text-slate-400 italic">Sin resultados</li>';
                            return;
                        }

                        // Protect against massive DOM updates, limit to 100 max
                        const totalMostrados = Math.min(ciudadesMostrar.length, 100);

                        for (let i = 0; i < totalMostrados; i++) {
                            const ciudad = ciudadesMostrar[i];
                            const li = document.createElement('li');
                            li.className = 'px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer flex flex-col gap-0.5';

                            // Added department to display
                            const deptoText = ciudad.departamento && ciudad.departamento.dpto_nombre ? ciudad.departamento.dpto_nombre : 'N/A';
                            
                            li.innerHTML = `
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-slate-400">location_city</span>
                                    <span>
                                        <span class="font-mono text-xs text-slate-500">${ciudad.ciudad_cod_post}</span> — ${ciudad.ciudad_nom}
                                    </span>
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium pl-6">
                                    Dpto: ${deptoText}
                                </div>
                            `;

                            li.addEventListener('click', function() {
                                hiddenCiudad.value = ciudad.ciudad_cod_post;
                                labelBtnCiudad.textContent = ciudad.ciudad_nom;
                                labelBtnCiudad.classList.remove('text-slate-400');
                                labelBtnCiudad.classList.add('text-slate-900', 'dark:text-white');
                                dropdownCiudades.classList.add('hidden');
                                inputBuscarCiudad.value = '';
                                // Re-render initial state for next open
                                renderCiudades(TODAS_CIUDADES);
                            });
                            listaCiudadesEl.appendChild(li);
                        }

                        if (ciudadesMostrar.length > 100) {
                            const liMore = document.createElement('li');
                            liMore.className = 'px-3 py-2 text-slate-400 italic text-xs text-center border-t border-slate-100 dark:border-slate-700/50';
                            liMore.textContent = `Mostrando 100 de ${ciudadesMostrar.length} resultados. Escriba para filtrar más.`;
                            listaCiudadesEl.appendChild(liMore);
                        }
                    }

                    // Render initial state when DOM is loaded
                    renderCiudades(TODAS_CIUDADES);

                    btnToggleCiudades.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdownCiudades.classList.toggle('hidden');
                        if (!dropdownCiudades.classList.contains('hidden')) {
                            inputBuscarCiudad.focus();
                        }
                    });

                    document.addEventListener('click', function(e) {
                        const wrapperCiudad = document.getElementById('ciudad-proveniente-wrapper');
                        if (wrapperCiudad && !wrapperCiudad.contains(e.target)) {
                            dropdownCiudades.classList.add('hidden');
                        }
                    });

                    inputBuscarCiudad.addEventListener('input', function() {
                        const q = this.value.trim().toLowerCase();
                        
                        // If empty, reset list to all cities
                        if (q.length === 0) {
                            renderCiudades(TODAS_CIUDADES);
                            return;
                        }

                        // Instant client-side filtering without debounce
                        const filtradas = TODAS_CIUDADES.filter(c => {
                            const matchCod = String(c.ciudad_cod_post).toLowerCase().includes(q);
                            const matchNom = String(c.ciudad_nom).toLowerCase().includes(q);
                            const matchDep = c.departamento && c.departamento.dpto_nombre 
                                            ? String(c.departamento.dpto_nombre).toLowerCase().includes(q) 
                                            : false;
                            return matchCod || matchNom || matchDep;
                        });

                        renderCiudades(filtradas);
                    });

                    // ===== BUSCADOR DE DESTINATARIOS (múltiple) =====
                    const TODOS_DESTINATARIOS = @json($todosDestinatarios);

                    /**
                     * Inicializa el buscador de empleados dentro de un bloque `.destinatario-block`.
                     */
                    function inicializarBuscadorDestinatario(block) {
                        const btnToggle = block.querySelector('.dest-btn-toggle');
                        const dropdown = block.querySelector('.dest-dropdown');
                        const searchInput = block.querySelector('.dest-search-input');
                        const lista = block.querySelector('.dest-list');
                        const hidden = block.querySelector('.dest-hidden-input');
                        const label = block.querySelector('.dest-label');
                        const btnRemove = block.querySelector('.dest-btn-remove');

                        function renderDestinatarios(destMostrar) {
                            lista.innerHTML = '';
                            if (destMostrar.length === 0) {
                                lista.innerHTML = '<li class="px-3 py-2 text-slate-400 italic">Sin resultados</li>';
                                return;
                            }

                            const totalMostrados = Math.min(destMostrar.length, 100);

                            for (let i = 0; i < totalMostrados; i++) {
                                const emp = destMostrar[i];
                                const li = document.createElement('li');
                                li.className = 'px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer flex flex-col gap-0.5';
                                
                                const areaHtml = emp.area_nombre ? `<div class="text-[10px] text-slate-400 font-medium pl-6">Área: ${emp.area_nombre}</div>` : '';

                                li.innerHTML = `
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-slate-400">person</span>
                                        <span>
                                            <span class="font-mono text-xs text-slate-500">${emp.emple_doc}</span> — ${emp.emple_nombres} ${emp.emple_apellidos}
                                        </span>
                                    </div>
                                    ${areaHtml}
                                `;
                                
                                li.addEventListener('click', function() {
                                    hidden.value = emp.emple_doc;
                                    label.textContent = emp.emple_doc + ' — ' + emp.emple_nombres + ' ' + emp.emple_apellidos;
                                    label.classList.remove('text-slate-400');
                                    label.classList.add('text-slate-900', 'dark:text-white');
                                    dropdown.classList.add('hidden');
                                    searchInput.value = '';
                                    renderDestinatarios(TODOS_DESTINATARIOS);
                                });
                                lista.appendChild(li);
                            }

                            if (destMostrar.length > 100) {
                                const liMore = document.createElement('li');
                                liMore.className = 'px-3 py-2 text-slate-400 italic text-xs text-center border-t border-slate-100 dark:border-slate-700/50';
                                liMore.textContent = `Mostrando 100 de ${destMostrar.length} resultados. Escriba para filtrar.`;
                                lista.appendChild(liMore);
                            }
                        }

                        // Render initial state
                        renderDestinatarios(TODOS_DESTINATARIOS);

                        // Abrir / cerrar dropdown
                        btnToggle.addEventListener('click', function(e) {
                            e.stopPropagation();
                            // Cerrar todos los demás dropdowns abiertos
                            document.querySelectorAll('.dest-dropdown').forEach(function(dd) {
                                if (dd !== dropdown) dd.classList.add('hidden');
                            });
                            dropdown.classList.toggle('hidden');
                            if (!dropdown.classList.contains('hidden')) searchInput.focus();
                        });

                        // Cerrar al hacer clic fuera del bloque
                        document.addEventListener('click', function(e) {
                            if (!block.contains(e.target)) dropdown.classList.add('hidden');
                        });

                        // Búsqueda instantánea
                        searchInput.addEventListener('input', function() {
                            const q = this.value.trim().toLowerCase();
                            
                            if (q.length === 0) {
                                renderDestinatarios(TODOS_DESTINATARIOS);
                                return;
                            }

                            const filtrados = TODOS_DESTINATARIOS.filter(emp => {
                                const matchDoc = String(emp.emple_doc).toLowerCase().includes(q);
                                const matchNom = String(emp.emple_nombres).toLowerCase().includes(q);
                                const matchApe = String(emp.emple_apellidos).toLowerCase().includes(q);
                                const matchArea = emp.area_nombre ? String(emp.area_nombre).toLowerCase().includes(q) : false;
                                
                                return matchDoc || matchNom || matchApe || matchArea;
                            });

                            renderDestinatarios(filtrados);
                        });

                        // Botón quitar
                        if (btnRemove) {
                            btnRemove.addEventListener('click', function() {
                                block.remove();
                            });
                        }
                    }

                    // Inicializar el primer bloque
                    document.querySelectorAll('.destinatario-block').forEach(inicializarBuscadorDestinatario);

                    // Botón "+ Agregar destinatario"
                    document.getElementById('btnAgregarDestinatario').addEventListener('click', function() {
                        const container = document.getElementById('destinatarios-container');
                        const template = container.querySelector('.destinatario-block');

                        // Clonar profundamente el primer bloque
                        const clone = template.cloneNode(true);

                        // Limpiar valores del clon
                        clone.querySelector('.dest-hidden-input').value = '';
                        clone.querySelector('.dest-label').textContent = 'Seleccione un documento o nombre...';
                        clone.querySelector('.dest-label').classList.add('text-slate-400');
                        clone.querySelector('.dest-label').classList.remove('text-slate-900', 'dark:text-white');
                        clone.querySelector('.dest-search-input').value = '';
                        clone.querySelector('.dest-list').innerHTML =
                            '<li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>';
                        clone.querySelector('.dest-dropdown').classList.add('hidden');

                        // Mostrar el botón de quitar en el clon
                        clone.querySelector('.dest-btn-remove').classList.remove('hidden');
                        clone.querySelector('.dest-btn-remove').classList.add('flex');

                        container.appendChild(clone);
                        inicializarBuscadorDestinatario(clone);
                    });

                    // ===== MANEJADOR DE ANEXO (máximo 1) =====

                    // Acumulador global (solo guardará 1 archivo a la vez)
                    window.dtAcumulador = new DataTransfer();

                    window.handleFileSelect = function(event, listId, inputId) {
                        const input = document.getElementById(inputId);
                        const container = document.getElementById(listId);

                        // Reemplazar siempre por el nuevo archivo (límite = 1)
                        window.dtAcumulador = new DataTransfer();
                        const newFile = event.target.files[0];
                        if (newFile) window.dtAcumulador.items.add(newFile);

                        input.files = window.dtAcumulador.files;

                        renderPills(input, container, inputId);
                    };

                    function renderPills(input, container, inputId) {
                        container.innerHTML = '';
                        Array.from(input.files).forEach((file, index) => {
                            const pill = document.createElement('div');
                            pill.className =
                                'flex items-center gap-1.5 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-full px-3 py-1 text-xs text-blue-700 dark:text-blue-300';
                            pill.innerHTML =
                                '<span class="material-symbols-outlined text-xs">description</span>' +
                                '<span class="max-w-[120px] truncate" title="' + file.name + '">' + file.name +
                                '</span>' +
                                '<button type="button" class="ml-1 text-blue-400 hover:text-red-500 transition-colors" aria-label="Quitar archivo">' +
                                '<span class="material-symbols-outlined text-sm">close</span></button>';

                            pill.querySelector('button').addEventListener('click', function() {
                                const newDt = new DataTransfer();
                                Array.from(input.files).forEach((f, i) => {
                                    if (i !== index) newDt.items.add(f);
                                });
                                input.files = newDt.files;
                                window.dtAcumulador = newDt;

                                // Resetear el conteo de folios del archivo quitado
                                if (inputId === 'anexos_nuevos_input' && typeof window.resetFoliosAnexo === 'function') {
                                    window.resetFoliosAnexo();
                                } else if (typeof window.resetFoliosPrincipal === 'function') {
                                    window.resetFoliosPrincipal();
                                }

                                renderPills(input, container, inputId);
                            });

                            container.appendChild(pill);
                        });
                    }
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const tabEmpresa = document.getElementById('tabEmpresa');
                    const tabPersona = document.getElementById('tabPersona');

                    const bloqueEmpresa = document.getElementById('bloqueEmpresa');
                    const bloquePersona = document.getElementById('bloquePersona');

                    const tipoRemitenteInput = document.getElementById('tipoRemitente');

                    // Inputs que cambian su estado "required"
                    const inputsEmpresa = document.querySelectorAll('.input-empresa');
                    const inputsPersona = document.querySelectorAll('.input-persona');

                    function activarTab(tipo) {
                        if (tipo === 'empresa') {
                            // Estilos del Tab
                            tabEmpresa.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                            tabEmpresa.classList.remove('font-medium', 'text-slate-500', 'dark:text-slate-400');

                            tabPersona.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                            tabPersona.classList.add('font-medium', 'text-slate-500', 'dark:text-slate-400');

                            // Mostrar/Ocultar
                            bloqueEmpresa.classList.remove('hidden');
                            bloquePersona.classList.add('hidden');

                            // Limpiar inputs del bloque oculto (persona)
                            bloquePersona.querySelectorAll('input, select, textarea').forEach(function(el) {
                                el.value = '';
                            });

                            // Valor al form
                            tipoRemitenteInput.value = 'empresa';

                            // Manejo de Required (evita que inputs ocultos bloqueen el submit)
                            inputsEmpresa.forEach(input => input.setAttribute('required', 'required'));
                            inputsPersona.forEach(input => input.removeAttribute('required'));

                        } else {
                            // Estilos del Tab
                            tabPersona.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                            tabPersona.classList.remove('font-medium', 'text-slate-500', 'dark:text-slate-400');

                            tabEmpresa.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                            tabEmpresa.classList.add('font-medium', 'text-slate-500', 'dark:text-slate-400');

                            // Mostrar/Ocultar
                            bloquePersona.classList.remove('hidden');
                            bloqueEmpresa.classList.add('hidden');

                            // Limpiar inputs del bloque oculto (empresa)
                            bloqueEmpresa.querySelectorAll('input, select, textarea').forEach(function(el) {
                                el.value = '';
                            });

                            // Valor al form
                            tipoRemitenteInput.value = 'persona';

                            // Manejo de Required
                            inputsPersona.forEach(input => input.setAttribute('required', 'required'));
                            inputsEmpresa.forEach(input => input.removeAttribute('required'));
                        }
                    }

                    // Event Listeners
                    if (tabEmpresa && tabPersona) {
                        tabEmpresa.addEventListener('click', () => activarTab('empresa'));
                        tabPersona.addEventListener('click', () => activarTab('persona'));
                    }
                });

                // ===== FILTRO DE REMITENTE — navegación por URL =====
                document.addEventListener('DOMContentLoaded', function() {
                    const btnFiltro = document.getElementById('btnFiltroRemitente');
                    const dropdown  = document.getElementById('dropdownFiltroRemitente');
                    const wrapper   = document.getElementById('filtroRemitenteWrapper');

                    if (!btnFiltro) return;

                    // Toggle dropdown
                    btnFiltro.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdown.classList.toggle('hidden');
                    });

                    // Cerrar si se hace clic fuera
                    document.addEventListener('click', function(e) {
                        if (wrapper && !wrapper.contains(e.target)) {
                            dropdown.classList.add('hidden');
                        }
                    });

                    // Al seleccionar opción â†’ navegar a URL con ?tipo=
                    document.querySelectorAll('.filtro-remitente-btn').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            const tipo = btn.dataset.tipo;
                            const url  = new URL(window.location.href);

                            if (tipo === 'todos') {
                                url.searchParams.delete('tipo');
                            } else {
                                url.searchParams.set('tipo', tipo);
                            }

                            // Siempre volver a la página 1 al cambiar filtro
                            url.searchParams.delete('page');

                            window.location.href = url.toString();
                        });
                    });

                    // ===== BUSQUEDA GLOBAL EN TIEMPO REAL =====
                    const searchInputGlobal = document.getElementById('searchInputGlobal');
                    const formSearchGlobal = document.getElementById('formSearchGlobal');
                    const btnClearSearchGlobal = document.getElementById('btnClearSearchGlobal');
                    const searchIconGlobal = document.getElementById('searchIconGlobal');
                    const searchSpinnerGlobal = document.getElementById('searchSpinnerGlobal');
                    const tablaRecibidosBody = document.getElementById('tablaRecibidosBody');
                    const paginacionRecibidos = document.getElementById('paginacionRecibidos');
                    const asideVacioForm = document.getElementById('asideVacio');
                    const asideContenidoForm = document.getElementById('asideContenido');

                    if (searchInputGlobal) {
                        let debounceTimer;

                        searchInputGlobal.addEventListener('input', function() {
                            clearTimeout(debounceTimer);
                            const query = this.value;

                            // Mostrar/Ocultar botón de limpiar
                            if (query.length > 0) {
                                btnClearSearchGlobal.classList.remove('hidden');
                                btnClearSearchGlobal.classList.add('flex');
                                searchInputGlobal.classList.remove('rounded-r-lg');
                            } else {
                                btnClearSearchGlobal.classList.add('hidden');
                                btnClearSearchGlobal.classList.remove('flex');
                                searchInputGlobal.classList.add('rounded-r-lg');
                            }

                            // Cerrar el aside al buscar para evitar desincronización
                            if(asideVacioForm && asideContenidoForm) {
                                asideVacioForm.classList.remove('hidden');
                                asideContenidoForm.classList.add('hidden');
                            }

                            debounceTimer = setTimeout(() => {
                                // Mostrar spinner
                                searchIconGlobal.classList.add('hidden');
                                searchSpinnerGlobal.classList.remove('hidden');

                                // Construir URL con los parámetros actuales
                                const url = new URL(window.location.href);
                                url.searchParams.set('search', query);
                                url.searchParams.delete('page'); // reset pagination

                                fetch(url.toString(), {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    // Parse HTML
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');

                                    // Extraer nuevas filas y nueva paginación
                                    const newTbody = doc.getElementById('tablaRecibidosBody');
                                    const newPagination = doc.getElementById('paginacionRecibidos');

                                    if (newTbody) tablaRecibidosBody.innerHTML = newTbody.innerHTML;
                                    if (newPagination) paginacionRecibidos.innerHTML = newPagination.innerHTML;

                                    // Actualizar URL sin recargar
                                    window.history.pushState({}, '', url.toString());
                                })
                                .catch(err => console.error('Error al buscar:', err))
                                .finally(() => {
                                    // Ocultar spinner
                                    searchSpinnerGlobal.classList.add('hidden');
                                    searchIconGlobal.classList.remove('hidden');
                                });
                            }, 400); // 400ms delay
                        });

                        if (btnClearSearchGlobal) {
                            btnClearSearchGlobal.addEventListener('click', function() {
                                searchInputGlobal.value = '';
                                searchInputGlobal.dispatchEvent(new Event('input', { bubbles: true }));
                            });
                        }
                    }
                });
            </script>
        @endsection

        @section('modals')

            <div id="modalCorrespondencia" tabindex="-1" aria-hidden="true"
                class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">

                <div class="relative w-full max-w-5xl max-h-full my-auto">

                    <form action="{{ route('externarec.store') }}" method="POST" class="relative"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- Campo oculto para saber qué tipo de formulario se envió --}}
                        <input type="hidden" name="tipo_remitente" id="tipoRemitente" value="empresa">

                        <div
                            class="space-y-8 bg-white dark:bg-slate-900 p-8 rounded-xl border border-slate-200 dark:border-slate-800 shadow-2xl max-h-[90vh] overflow-y-auto">

                            <div
                                class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 pb-4 mb-4">
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Registrar Nueva
                                    Correspondencia</h3>
                            </div>

                            {{-- Bloque de errores de validación --}}
                            @if ($errors->any())
                                <div
                                    class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-red-500 flex-shrink-0">error</span>
                                        <div>
                                            <p class="text-sm font-semibold text-red-700 dark:text-red-400 mb-1">Por favor
                                                corrige los siguientes errores:</p>
                                            <ul
                                                class="list-disc list-inside text-sm text-red-600 dark:text-red-300 space-y-0.5">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- ===== TABS DE SELECCIÓN ===== --}}
                            <div class="flex space-x-6 border-b border-slate-200 dark:border-slate-800">
                                <button type="button" id="tabEmpresa"
                                    class="pb-3 text-sm font-bold text-primary border-b-2 border-primary transition-colors">
                                    Entidad / Empresa
                                </button>
                                <button type="button" id="tabPersona"
                                    class="pb-3 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                                    Persona Natural
                                </button>
                            </div>

                            {{-- ===== BLOQUE 1: EMPRESA (Visible por defecto) ===== --}}
                            <div id="bloqueEmpresa" class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Núm. Radicado Externo</p>
                                        <input type="text" name="num_radicado_ext" maxlength="20"
                                            value="{{ old('num_radicado_ext') }}"
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Opcional" />
                                    </label>
                                </div>
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Nombre Institución *</p>
                                        <input type="text" name="nom_institucion" required maxlength="150"
                                            class="input-empresa form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Nombre de la entidad" />
                                    </label>
                                </div>
                            </div>

                            {{-- ===== BLOQUE 2: PERSONA NATURAL (Oculto por defecto) ===== --}}
                            <div id="bloquePersona" class="hidden space-y-8">
                                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <label class="flex flex-col">
                                            <p
                                                class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                                Nombre Completo *</p>
                                            <input type="text" name="nombre_persona" maxlength="150"
                                                class="input-persona form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                                placeholder="Nombres y apellidos" />
                                        </label>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label class="flex flex-col">
                                            <p
                                                class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                                Documento de Identidad *</p>
                                            <input type="text" name="documento_persona" maxlength="20"
                                                class="input-persona form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                                placeholder="Cédula, NIT, etc." />
                                        </label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <label class="flex flex-col">
                                            <p
                                                class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                                Correo Electrónico</p>
                                            <input type="email" name="correo_persona" maxlength="100"
                                                class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                                placeholder="correo@ejemplo.com" />
                                        </label>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label class="flex flex-col">
                                            <p
                                                class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                                Teléfono</p>
                                            <input type="text" name="telefono_persona" maxlength="20"
                                                class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                                placeholder="Opcional" />
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== CAMPOS COMPARTIDOS (Siempre visibles) ===== --}}
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1 relative" id="ciudad-proveniente-wrapper">
                                    <input type="hidden" name="ciudad_proveniente" id="ciudad_proveniente_value">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Ciudad Proveniente *</p>
                                        <button type="button" id="btnToggleCiudades"
                                            class="form-input flex items-center justify-between w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal text-left">
                                            <span id="btnToggleCiudadesLabel" class="text-slate-400">Seleccione una
                                                ciudad...</span>
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </label>

                                    <div id="ciudadesDropdown"
                                        class="hidden absolute z-10 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg shadow-lg overflow-hidden">
                                        <div class="p-2 border-b border-slate-200 dark:border-slate-700">
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                                <input type="text" id="buscarCiudadInput"
                                                    class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-900 text-slate-900 dark:text-white py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
                                                    placeholder="Buscar por código o nombre..." />
                                            </div>
                                        </div>
                                        <ul id="listaCiudades"
                                            class="max-h-48 overflow-y-auto py-1 text-sm text-slate-700 dark:text-slate-200">
                                            <li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== SECCIÓN DESTINATARIOS ===== --}}
                            <div class="space-y-3">
                                <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal">
                                    Destinatario(s) <span class="text-red-500">*</span>
                                </p>
                                <div id="destinatarios-container" class="space-y-2">
                                    <div class="destinatario-block flex items-start gap-2" data-index="0">
                                        <input type="hidden" name="destinatarios[]" class="dest-hidden-input">
                                        <div class="relative flex-1" style="min-width:0">
                                            <button type="button"
                                                class="dest-btn-toggle form-input flex items-center justify-between w-full rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal text-left">
                                                <span class="dest-label text-slate-400">Seleccione un documento o
                                                    nombre...</span>
                                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div
                                                class="dest-dropdown hidden absolute z-20 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg shadow-lg overflow-hidden">
                                                <div class="p-2 border-b border-slate-200 dark:border-slate-700">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                            <svg class="w-4 h-4 text-slate-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <input type="text"
                                                            class="dest-search-input w-full rounded-md border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-900 text-slate-900 dark:text-white py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
                                                            placeholder="Buscar por cédula o nombre..." />
                                                    </div>
                                                </div>
                                                <ul
                                                    class="dest-list max-h-48 overflow-y-auto py-1 text-sm text-slate-700 dark:text-slate-200">
                                                    <li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="dest-btn-remove hidden mt-1 flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg border border-red-200 dark:border-red-800 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors"
                                            title="Quitar destinatario">
                                            <span class="material-symbols-outlined text-sm">close</span>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" id="btnAgregarDestinatario"
                                    class="flex items-center gap-1.5 text-sm font-medium text-primary hover:text-primary/80 transition-colors mt-1">
                                    <span class="material-symbols-outlined text-base">person_add</span>
                                    + Agregar destinatario
                                </button>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-3">
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Asunto</p>
                                        <input type="text" name="asunto" maxlength="100"
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Resumen del documento" />
                                    </label>
                                </div>
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Tipo de Documento</p>
                                        <select name="id_tipo"
                                            class="form-select flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal">
                                            <option value="">Seleccione tipo</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id_tipo }}">{{ $tipo->tipo_nombre }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col h-full">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Observaciones</p>
                                        <textarea name="observaciones" rows="3" maxlength="250"
                                            class="form-textarea flex w-full min-w-0 flex-1 resize-y rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 p-3.5 text-base font-normal"
                                            placeholder="Notas adicionales sobre la correspondencia..."></textarea>
                                    </label>
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1 md:grid-cols-3 gap-5 p-4 bg-gray-50 dark:bg-slate-800/30 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="md:col-span-1">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento
                                        Principal (PDF)</label>
                                    <input type="file" name="archivo" accept=".pdf"
                                        class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Solo PDF · Tamaño máximo: 5MB
                                    </p>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anexo
                                        Adicional (PDF opcional)</label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 text-center hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors cursor-pointer relative"
                                        onclick="document.getElementById('anexos_nuevos_input').click()">
                                        <span class="material-symbols-outlined text-gray-400 text-2xl mb-1">note_add</span>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Clic aquí para añadir 1 PDF</p>
                                        <input type="file" id="anexos_nuevos_input" name="anexos[]" accept=".pdf"
                                            class="hidden"
                                            onchange="handleFileSelect(event, 'anexosNuevosList', 'anexos_nuevos_input')">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 1 anexo · 5 MB</p>
                                    <div id="anexosNuevosList" class="mt-2 flex flex-wrap gap-2 empty:hidden"></div>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Folios
                                            <span class="text-xs font-normal text-slate-400 dark:text-slate-500 ml-1">(calculado automáticamente)</span>
                                        </p>
                                        <div class="relative">
                                            <input type="text" name="folio" id="inputFolios" readonly
                                                class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-700/50 h-12 px-3.5 text-base font-semibold text-center cursor-not-allowed select-none"
                                                placeholder="—" />
                                            <span id="foliosSpinner"
                                                class="hidden absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined animate-spin text-blue-400 text-lg">progress_activity</span>
                                        </div>
                                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Se suma al adjuntar PDFs</p>
                                    </label>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    // â”€â”€ Configurar PDF.js worker â”€â”€
                                    pdfjsLib.GlobalWorkerOptions.workerSrc =
                                        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                                    const inputPrincipal = document.querySelector('input[name="archivo"]');
                                    const inputAnexos    = document.getElementById('anexos_nuevos_input');
                                    const inputFolios    = document.getElementById('inputFolios');
                                    const spinner        = document.getElementById('foliosSpinner');

                                    // Estado de páginas por tipo de archivo
                                    let paginasPrincipal = 0;
                                    let paginasAnexo     = 0;
                                    let cargando         = 0; // contador de operaciones async en curso

                                    // â”€â”€ UI helpers â”€â”€
                                    const iniciarCarga = () => {
                                        cargando++;
                                        spinner.classList.remove('hidden');
                                    };
                                    const finalizarCarga = () => {
                                        cargando = Math.max(0, cargando - 1);
                                        if (cargando === 0) spinner.classList.add('hidden');
                                    };

                                    // â”€â”€ Actualizar el valor del input â”€â”€
                                    const actualizar = () => {
                                        const total = paginasPrincipal + paginasAnexo;
                                        inputFolios.value = total > 0 ? total : '';
                                    };

                                    // â”€â”€ Contar páginas de un PDF â”€â”€
                                    const contarPaginas = async (file) => {
                                        if (!file || file.type !== 'application/pdf') return 0;
                                        try {
                                            const buf = await file.arrayBuffer();
                                            const pdf = await pdfjsLib.getDocument({ data: buf }).promise;
                                            return pdf.numPages;
                                        } catch (err) {
                                            console.error('[PDF.js] Error al leer:', err);
                                            return 0;
                                        }
                                    };

                                    // â”€â”€ Listener: documento principal â”€â”€
                                    if (inputPrincipal) {
                                        inputPrincipal.addEventListener('change', async (e) => {
                                            const file = e.target.files[0];
                                            iniciarCarga();
                                            paginasPrincipal = file ? await contarPaginas(file) : 0;
                                            finalizarCarga();
                                            actualizar();
                                        });
                                    }

                                    // â”€â”€ Listener: anexo â”€â”€
                                    if (inputAnexos) {
                                        inputAnexos.addEventListener('change', async (e) => {
                                            const file = e.target.files[0];
                                            iniciarCarga();
                                            paginasAnexo = file ? await contarPaginas(file) : 0;
                                            finalizarCarga();
                                            actualizar();
                                        });
                                    }

                                    // â”€â”€ Funciones globales llamadas desde renderPills al pulsar X â”€â”€
                                    window.resetFoliosPrincipal = () => {
                                        paginasPrincipal = 0;
                                        actualizar();
                                    };
                                    window.resetFoliosAnexo = () => {
                                        paginasAnexo = 0;
                                        actualizar();
                                    };
                                });
                            </script>

                            <div
                                class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 dark:border-slate-800">
                                <button id="btnCerrarModal" type="button"
                                    class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Cancelar</button>
                                <button type="submit"
                                    class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">Enviar
                                    Correspondencia</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @endsection

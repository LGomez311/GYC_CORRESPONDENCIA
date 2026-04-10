@extends('remitente.layouts.app')

@section('title', 'Panel de Remitente - Enviados')

@section('content')

    {{-- Área principal con scroll --}}
    <div class="flex flex-col p-4 md:p-6 min-w-0 gap-8">

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

        {{-- Cabecera y Stats --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Correspondencia Externa Enviada
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Administre y consulte todos los envíos realizados.</p>
            </div>
            <div class="flex flex-col sm:flex-row w-full md:w-auto gap-4">
                <button type="button" onclick="openModal('salienteModal')"
                    class="flex items-center justify-center gap-3 px-6 py-3 text-sm font-bold text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 transition-all active:scale-95 w-full sm:w-auto shadow-md">
                    <span class="material-symbols-outlined text-[24px]">outbox</span>
                    Registrar Saliente
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10 w-full relative z-0">
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

        <!-- Search and Filters Section -->


        <!-- Correspondence Table Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm block w-full overflow-hidden">
            <!-- Header with Filters -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 block w-full">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 w-full">
                    <div class="w-full">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Correspondencia Enviada</h2>
                        <p class="text-sm text-gray-500 mt-1">Administre sus registros externos y estados actuales.</p>
                    </div>
                    <form id="formSearchGlobal" method="GET" action="{{ route('ventanilla.externaenv') }}"
                        class="flex flex-col sm:flex-row w-full lg:w-auto gap-4">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            {{-- Filtro Prioridad --}}
                            <div class="relative w-full sm:w-48">
                                <select name="prioridad_id" onchange="this.form.submit()"
                                    class="block w-full h-11 px-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-2 focus:ring-primary focus:border-primary dark:text-white appearance-none cursor-pointer">
                                    <option value="">Todas las Prioridades</option>
                                    @foreach ($prioridades as $prior)
                                        <option value="{{ $prior->id_prioridad }}"
                                            {{ request('prioridad_id') == $prior->id_prioridad ? 'selected' : '' }}>
                                            {{ $prior->prioridad_nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                     <span class="material-symbols-outlined text-sm">expand_more</span>
                                </div>
                            </div>

                            {{-- Filtro Estado --}}
                            <div class="relative w-full sm:w-48">
                                <select name="estado_id" onchange="this.form.submit()"
                                    class="block w-full h-11 px-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-2 focus:ring-primary focus:border-primary dark:text-white appearance-none cursor-pointer">
                                    <option value="">Todos los estados</option>
                                    @foreach ($estados as $est)
                                        @if (in_array($est->id_estado, [7, 8, 9, 10, 11, 12, 13, 14, 15]))
                                            <option value="{{ $est->id_estado }}"
                                                {{ request('estado_id') == $est->id_estado ? 'selected' : '' }}>
                                                {{ $est->estado_nomb }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                     <span class="material-symbols-outlined text-sm">expand_more</span>
                                </div>
                            </div>

                                {{-- Filtro Fecha --}}
                                <div class="relative w-full sm:w-56 flex items-center gap-2">
                                    <input type="date" name="fecha" value="{{ request('fecha') }}" onchange="this.form.submit()"
                                        max="{{ date('Y-m-d') }}"
                                        class="block w-full h-11 px-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-2 focus:ring-primary focus:border-primary dark:text-white appearance-none cursor-pointer flex-1">
                                    @if (request('fecha'))
                                        <a href="{{ request()->fullUrlWithQuery(['fecha' => null]) }}"
                                            class="p-2 bg-red-50 dark:bg-red-400/10 text-red-500 hover:bg-red-100 dark:hover:bg-red-400/20 rounded-xl transition-all"
                                            title="Limpiar filtro de fecha">
                                            <span class="material-symbols-outlined text-sm">close</span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="material-symbols-outlined text-gray-400 text-sm">search</span>
                            </span>
                            <input id="searchInputGlobal" type="text" autocomplete="off" name="search"
                                class="block w-full h-11 pl-10 pr-10 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary dark:text-white placeholder:text-gray-500 dark:placeholder:text-gray-400"
                                placeholder="Buscar por asunto, radicado..." value="{{ request('search') }}" />
                            @if(request('search'))
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                <button type="button" id="btnClearSearchGlobal"
                                    class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                                    title="Limpiar búsqueda">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-container-remitente overflow-x-auto w-full custom-scrollbar min-w-0" style="min-height: 400px; padding-bottom: 2rem;">
                <table class="w-full text-left text-sm responsive-table min-w-[1000px]">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3 font-medium whitespace-nowrap">Asunto</th>
                            <th class="px-6 py-3 font-medium whitespace-nowrap">Destino</th>
                            <th class="px-6 py-3 font-medium whitespace-nowrap">Fecha Envío</th>
                            <th class="px-6 py-3 font-medium text-center">Prioridad</th>
                            <th class="px-6 py-3 font-medium text-center whitespace-nowrap">Estado</th>
                            <th class="px-6 py-3 font-medium text-center whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEnviadosBody" class="divide-y divide-gray-50 dark:divide-gray-800/50">
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

                                // Usar el destino configurado para externos
                                $nombreDestinatario = trim($envio->destino) ?: 'Destino no especificado';

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

                            <tr class="fila-registro group hover:bg-gray-50/50 dark:hover:bg-gray-800/20 cursor-pointer bg-white dark:bg-gray-800 transition-all duration-200"
                                data-id="{{ $envio->id_envio }}" data-asunto="{{ $envio->asunto }}"
                                data-radicado="{{ $numRadicado }}" data-destinatario="{{ $nombreDestinatario }}"
                                data-fecha="{{ $fechaEnvio }}" data-prioridad="{{ $nombrePrioridad }}"
                                data-prioridad-clases="{{ $priorClases }}" data-estado="{{ $nombreEstado }}"
                                data-estado-clases="{{ $estadoClases }}" data-icono="{{ $iconoDoc }}"
                                data-tipo-doc="{{ $tipoDoc }}" data-archivo="{{ $rutaArchivo }}"
                                data-anexos='@json($envio->anexos)'>

                                <td class="px-6 py-4 align-top" data-label="Asunto">
                                    <div class="font-medium text-gray-900 dark:text-gray-100 mb-1 max-w-[250px] whitespace-normal break-words">{{ $envio->asunto ?? '(Sin asunto)' }}</div>
                                    @if ($numRadicado)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 text-[10px] font-bold border border-[#cfd7e7] dark:border-slate-700 mt-1">
                                            <span class="material-symbols-outlined text-[12px]">tag</span>
                                            {{ $numRadicado }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 align-middle" data-label="Destinatario">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="px-1.5 py-0.5 bg-blue-50/50 dark:bg-blue-900/10 text-blue-600 dark:text-blue-400 text-[9px] font-black uppercase rounded border border-blue-100/50 dark:border-blue-800/50 tracking-widest shadow-sm">EXTERNO</span>
                                            <span class="text-sm font-bold text-gray-800 dark:text-gray-100 truncate max-w-[200px]" title="{{ $nombreDestinatario }}">
                                                {{ $nombreDestinatario }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1 text-gray-400 dark:text-gray-500 mt-0.5 border-t border-gray-50 dark:border-gray-800/50 pt-1.5 w-fit">
                                            <span class="material-symbols-outlined text-[14px] font-variation-icon">location_on</span>
                                            <span class="text-[9px] font-bold uppercase tracking-tighter">Entidad Destino</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap" data-label="Fecha Envío">
                                    {{ $fechaEnvio }}
                                </td>

                                <td class="px-6 py-4 text-center" data-label="Prioridad">
                                    <span
                                        class="{{ $priorClases }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $nombrePrioridad }}</span>
                                </td>

                                <td class="px-6 py-4 text-center" data-label="Estado">
                                    <span
                                        class="{{ $estadoClases }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $nombreEstado }}</span>
                                </td>

                                <td class="px-6 py-4 text-center" data-label="Acciones">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                            class="btn-ver-detalle flex items-center justify-center gap-1.5 px-3 py-1.5 bg-blue-50/50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 rounded-lg text-[10px] font-bold transition-all uppercase tracking-widest border border-blue-100/50 dark:border-blue-800/50">
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
                @if($envios->hasPages())
                <div id="paginacionEnviados"
                    class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 flex justify-end bg-gray-50/50 dark:bg-gray-900/50">
                    {{ $envios->links() }}
                </div>
                @endif
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
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tipo Documento
                                    </p>
                                    <p id="detailType" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Prioridad</p>
                                    <p id="detailPriority" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Content Area -->
                    <div class="flex-1 p-8 space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Asunto</h4>
                            <p id="detailAsunto" class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                            </p>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Destinatario /
                                Institución</h4>
                            <p id="detailDestinatario" class="text-sm text-gray-700 dark:text-gray-300 font-bold"></p>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Trazabilidad Reciente
                                </h4>
                                <button id="btnVerTrazabilidadCompleta"
                                    class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">Ver
                                    Historial</button>
                            </div>
                            <div id="detailTimeline" class="space-y-4 max-h-48 overflow-y-auto pr-2">
                                <!-- Mini timeline here -->
                                <p class="text-[10px] text-gray-400 italic">Cargando trazabilidad...</p>
                            </div>
                        </div>

                        <div class="pt-4">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Documentos del Envío
                            </h4>
                            <div id="detailActionsContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Documents buttons here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Historial y Línea de Tiempo Unificado -->
    <div id="historyModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 translate-z-0">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col border border-gray-100 dark:border-gray-800 animate-in fade-in zoom-in duration-200">
            <!-- Header -->
            <div class="p-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
                <div>
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">history</span>
                        Historial de Correspondencia
                    </h3>
                    <div class="flex items-center gap-3 mt-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400" id="historyRadText">Radicado: #---</p>
                        <a id="btnDownloadTrazabilidad" href="#" target="_blank"
                            class="flex items-center gap-1.5 px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white text-[9px] font-black uppercase tracking-widest rounded-lg transition-all shadow-md">
                            <span class="material-symbols-outlined text-[14px]">download</span>
                            PDF
                        </a>
                    </div>
                </div>
                <button onclick="closeModal('historyModal')" class="bg-white dark:bg-slate-800 text-gray-400 hover:text-red-500 hover:rotate-90 dark:hover:text-red-400 p-2 rounded-full transition-all duration-300 shadow-sm border border-gray-100 dark:border-gray-700">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <!-- Timeline Content -->
            <div class="p-6 overflow-y-auto flex-1 bg-white dark:bg-slate-900 scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-gray-800">
                <div class="relative ml-4 pl-8 border-l-2 border-dashed border-gray-200 dark:border-gray-800 space-y-10" id="history-timeline">
                    <!-- Se inyectará vía JS -->
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end">
                <button onclick="closeModal('historyModal')" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-all shadow-sm">
                    Cerrar Historial
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Nueva Correspondencia Saliente (Rediseñado) --}}
    <div id="salienteModal" class="hidden fixed inset-0 z-50 overflow-y-auto transition-all animate-in fade-in">
        <div class="min-h-full w-full p-4 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('salienteModal')"></div>

            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-emerald-50/50 dark:bg-emerald-900/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <span class="material-symbols-outlined">outbox</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">Registrar Saliente</h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Respuesta Oficial</p>
                        </div>
                    </div>
                    <button onclick="closeModal('salienteModal')"
                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form id="formNuevaCorrespondencia" action="{{ route('remitente.externaenv.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto scrollbar-thin">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Asunto -->
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Asunto *</label>
                                <input type="text" name="asunto" id="salienteAsunto" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white"
                                    placeholder="Asunto del envío">
                            </div>

                            <!-- Destino -->
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Destino / Institución *</label>
                                <textarea name="destino" required rows="2"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white"
                                    placeholder="Nombre de la institución o persona destino"></textarea>
                            </div>

                            <!-- Tipo de Documento Searchable -->
                            <div class="relative">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Tipo de Documento *</label>
                                <input type="hidden" name="id_tipo_envio" id="id_tipo_envio_value">
                                <button type="button" id="btnToggleTiposEnvio"
                                    class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm font-medium transition-all outline-none dark:text-white text-left">
                                    <span id="btnToggleTiposEnvioLabel" class="text-gray-400">Seleccione tipo...</span>
                                    <span class="material-symbols-outlined text-gray-400">expand_more</span>
                                </button>
                                <div id="tiposEnvioDropdown" class="hidden absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden">
                                    <div class="p-2 border-b border-gray-50 dark:border-gray-700">
                                        <input type="text" id="buscarTipoEnvioInput" placeholder="Buscar tipo..." 
                                            class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-900/50 border-none rounded-xl text-xs outline-none dark:text-white">
                                    </div>
                                    <ul id="listaTiposEnvio" class="max-h-48 overflow-y-auto p-1">
                                        @foreach($tipos as $t)
                                            <li class="tipo-envio-item px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/40 rounded-xl cursor-pointer transition-colors"
                                                data-id="{{ $t->id_tipo }}" data-nombre="{{ $t->tipo_nombre }}">
                                                {{ $t->tipo_nombre }}
                                            </li>
                                        @endforeach
                                        <li class="tipo-envio-item px-3 py-2 text-xs font-bold text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/40 rounded-xl cursor-pointer transition-colors border-t border-gray-50 dark:border-gray-700"
                                            data-id="OTRO" data-nombre="OTRO (Especificar)">
                                            OTRO (Especificar)
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Especificar Tipo (Solo si elige OTRO) -->
                            <div id="containerTipoOtro" class="hidden md:col-span-1">
                                <label class="block text-[10px] font-black text-orange-400 uppercase tracking-widest mb-1.5 px-1">Especificar Tipo *</label>
                                <input type="text" name="tipo_otro" id="tipoOtroInput"
                                    class="w-full px-4 py-3 bg-orange-50/30 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800 rounded-2xl text-sm focus:ring-2 focus:ring-orange-500/20 transition-all outline-none dark:text-white"
                                    placeholder="¿Qué tipo de documento es?">
                            </div>

                            <!-- Folios -->
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Folios (Auto)</label>
                                <input type="number" name="folio" id="salienteFolio" value="1" readonly
                                    class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm font-bold text-emerald-600 outline-none cursor-not-allowed">
                            </div>

                            <!-- Correo de Notificación (Opcional) -->
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Correo a Notificar (Opcional)</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400 text-[18px]">email</span>
                                    </span>
                                    <input type="email" name="notificar_correo" 
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none dark:text-white"
                                        placeholder="correo@ejemplo.com">
                                </div>
                            </div>


                            <!-- Funcionario que envía -->
                            <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Funcionario que envía</label>
                            <select name="doc_quien_envia" id="salienteFuncionario" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white appearance-none">
                                <option value="">Seleccionar...</option>
                                {{-- Add the current Remitente (Ventanilla) --}}
                                <option value="{{ auth()->guard('remitente')->user()->rem_doc }}">
                                    {{ auth()->guard('remitente')->user()->rem_nombres }} {{ auth()->guard('remitente')->user()->rem_apellidos }} (Ventanilla)
                                </option>
                                @foreach ($empleados as $e)
                                    @if($e->emple_doc != auth()->guard('remitente')->user()->rem_doc)
                                        <option value="{{ $e->emple_doc }}">{{ $e->emple_nombres }} {{ $e->emple_apellidos }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Funcionario Responsable -->

                            <div class="md:col-span-2">
                                <div class="flex items-center justify-between mb-2 px-1">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Funcionario Responsable *</label>
                                </div>
                                <div id="funcionarios-container" class="space-y-2">
                                    @php
                                        $currentUser = Auth::guard('remitente')->user();
                                        $fullName = $currentUser ? ($currentUser->rem_nombres . ' ' . $currentUser->rem_apellidos) : '';
                                        $doc = $currentUser ? $currentUser->rem_doc : '';
                                    @endphp
                                    <div class="funcionario-block relative" data-index="0">
                                        <input type="hidden" name="doc_quien_registra" value="{{ $doc }}" required>
                                        <div class="relative group">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="material-symbols-outlined text-emerald-500 transition-colors text-[18px]">person</span>
                                            </span>
                                            <input type="text" value="{{ $fullName }}" readonly
                                                class="w-full pl-10 pr-4 py-3 bg-emerald-50/30 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800 rounded-2xl text-sm font-bold outline-none dark:text-white cursor-not-allowed">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Archivo -->
                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1 flex justify-between items-center">
                                    <span>Documento Principal (PDF) *</span>
                                    <div id="main-file-actions" class="hidden flex items-center gap-2 animate-in fade-in">
                                        <button type="button" onclick="previewMainFile()" class="text-emerald-600 hover:text-emerald-700 font-bold text-[9px] uppercase tracking-widest flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">visibility</span> Ver
                                        </button>
                                        <button type="button" onclick="clearMainFile()" class="text-red-500 hover:text-red-600 font-bold text-[9px] uppercase tracking-widest flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">close</span> Quitar
                                        </button>
                                    </div>
                                </label>
                                <div class="relative group">
                                    <div id="main-file-dropzone" class="w-full px-4 py-4 bg-gray-50 dark:bg-gray-900/50 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl flex items-center justify-between group-hover:border-emerald-500/50 transition-all pointer-events-none">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-emerald-600">picture_as_pdf</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span id="preview-principal" class="text-xs font-bold text-gray-700 dark:text-gray-300">Seleccionar PDF...</span>
                                                <span class="text-[10px] text-gray-400 font-medium">Máximo 5MB</span>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-gray-300 group-hover:text-emerald-500 transition-colors">cloud_upload</span>
                                    </div>
                                    <input type="file" name="archivo" id="archivoPrincipal" accept=".pdf" required
                                        onchange="handleFileSelect(this, 'preview-principal')"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-[60]">
                                </div>
                            </div>

                            <!-- Anexos -->
                            <div class="md:col-span-1">
                                <!-- Multiple Annexes (Dropzone style) -->
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest px-1 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px]">attachment</span>
                                        Anexos del Envío
                                    </label>
                                    <div class="group relative border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl p-8 transition-all hover:border-emerald-500/50 hover:bg-emerald-50/10 cursor-pointer text-center bg-gray-50/30 dark:bg-gray-900/20">
                                        <div class="flex flex-col items-center gap-2 pointer-events-none">
                                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <span class="material-symbols-outlined text-2xl">add_circle</span>
                                            </div>
                                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300">Click para agregar anexos</p>
                                            <p class="text-[10px] text-gray-400 font-medium">Formatos permitidos: PDF (Máx. 25MB)</p>
                                        </div>
                                        <input type="file" id="anexoHelper" accept=".pdf" onchange="handleAddAnexo(this)"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-[60]">
                                    </div>
                                    <div id="anexos-list" class="grid grid-cols-1 gap-2 mt-3">
                                        <!-- Dynamic List -->
                                    </div>
                                </div>
                                <div id="anexos-container-inputs" class="hidden"></div>
                            </div>

                            <!-- Observaciones -->
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Observaciones / Descripción</label>
                                <textarea name="observaciones" rows="2"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 transition-all outline-none dark:text-white resize-none"
                                    placeholder="Detalles adicionales opcionales..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end gap-3 rounded-b-3xl">
                        <button type="button" onclick="closeModal('salienteModal')"
                            class="px-6 py-3 text-xs font-black text-gray-500 uppercase tracking-widest hover:text-gray-700 dark:hover:text-white transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            Registrar y Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

        // --- GLOBAL FUNCTIONS ---
        window.openModal = function(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('hidden');
                el.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeModal = function(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('hidden');
                el.classList.remove('flex');
                document.body.style.overflow = '';
            }
        };
        
        // --- FILE HANDLING FUNCTIONS (GLOBAL) ---
        window.handleFileSelect = async function(input, previewId) {
            const preview = document.getElementById(previewId);
            const actions = document.getElementById('main-file-actions');
            const dropzone = document.getElementById('main-file-dropzone');

            if (input.files && input.files[0]) {
                preview.innerText = input.files[0].name;
                if(actions) actions.classList.remove('hidden');
                if(dropzone) {
                    dropzone.classList.remove('border-dashed', 'bg-gray-50');
                    dropzone.classList.add('border-solid', 'bg-emerald-50/20', 'border-emerald-200');
                }
            } else {
                preview.innerText = 'Seleccionar PDF...';
                if(actions) actions.classList.add('hidden');
                if(dropzone) {
                    dropzone.classList.add('border-dashed', 'bg-gray-50');
                    dropzone.classList.remove('border-solid', 'bg-emerald-50/20', 'border-emerald-200');
                }
            }
            await calculateTotalFolios();
        };

        window.previewMainFile = function() {
            const input = document.getElementById('archivoPrincipal');
            if (input && input.files && input.files[0]) {
                const url = URL.createObjectURL(input.files[0]);
                window.open(url, '_blank');
            }
        };

        window.clearMainFile = async function() {
            const input = document.getElementById('archivoPrincipal');
            if (input) {
                input.value = '';
                handleFileSelect(input, 'preview-principal');
            }
        };

        let anexoCounter = 0;
        window.handleAddAnexo = async function(helperInput) {
            if (!helperInput.files || !helperInput.files[0]) return;
            const file = helperInput.files[0];
            const id = 'anexo-' + (++anexoCounter);
            const list = document.getElementById('anexos-list');
            const item = document.createElement('div');
            item.id = 'item-' + id;
            item.className = 'flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700 animate-in fade-in slide-in-from-right-2';
            const icon = file.type === 'application/pdf' ? 'picture_as_pdf' : 'description';
            
            item.innerHTML = `
                <div class="flex items-center gap-2 overflow-hidden">
                    <span class="material-symbols-outlined text-gray-400 text-[18px]">${icon}</span>
                    <span class="text-[11px] font-bold text-gray-700 dark:text-gray-300 truncate">${file.name}</span>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button type="button" onclick="previewAnexo('${id}')" class="p-1 text-gray-400 hover:text-emerald-500 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                    </button>
                    <button type="button" onclick="removeAnexo('${id}')" class="p-1 text-gray-400 hover:text-red-500 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">close</span>
                    </button>
                </div>`;
            list.appendChild(item);

            const container = document.getElementById('anexos-container-inputs');
            const newInput = helperInput.cloneNode(true);
            newInput.id = id;
            newInput.name = 'anexos[]';
            newInput.onchange = null;
            container.appendChild(newInput);
            
            const dt = new DataTransfer();
            dt.items.add(file);
            newInput.files = dt.files;
            helperInput.value = '';
            await calculateTotalFolios();
        };

        window.removeAnexo = async function(id) {
            const item = document.getElementById('item-' + id);
            const input = document.getElementById(id);
            if (item) item.remove();
            if (input) input.remove();
            await calculateTotalFolios();
        };

        window.previewAnexo = function(id) {
            const input = document.getElementById(id);
            if (input && input.files && input.files[0]) {
                const url = URL.createObjectURL(input.files[0]);
                window.open(url, '_blank');
            }
        };

        async function calculateTotalFolios() {
            try {
                const mainInput = document.getElementById('archivoPrincipal');
                const annexInputs = document.querySelectorAll('#anexos-container-inputs input[type="file"]');
                const folioInput = document.getElementById('salienteFolio');
                if (!folioInput) return;

                let promises = [];

                // Archivo principal
                if (mainInput && mainInput.files && mainInput.files[0]) {
                    const file = mainInput.files[0];
                    if (file.type === 'application/pdf') {
                        promises.push(countPdfPages(file));
                    } else {
                        // Si no es PDF (imagen, etc), cuenta como 1 folio
                        promises.push(Promise.resolve(1));
                    }
                }

                // Anexos
                annexInputs.forEach(input => {
                    if (input.files && input.files[0]) {
                        const file = input.files[0];
                        if (file.type === 'application/pdf') {
                            promises.push(countPdfPages(file));
                        } else {
                            // Cualquier otro anexo no PDF cuenta como 1 folio
                            promises.push(Promise.resolve(1));
                        }
                    }
                });

                if (promises.length === 0) {
                    folioInput.value = 1;
                    return;
                }

                const counts = await Promise.all(promises);
                const total = counts.reduce((acc, curr) => acc + curr, 0);
                
                folioInput.value = Math.max(1, total);
            } catch (err) {
                console.error("Error en calculateTotalFolios:", err);
            }
        }

        async function countPdfPages(file) {
            if (!file || file.type !== 'application/pdf') return 0;
            
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = async function() {
                    try {
                        if (typeof pdfjsLib === 'undefined') {
                            console.warn("pdfjsLib is not defined");
                            return resolve(1); // Fallback to 1 page if lib missing
                        }
                        const typedarray = new Uint8Array(this.result);
                        const loadingTask = pdfjsLib.getDocument({ data: typedarray });
                        const pdf = await loadingTask.promise;
                        resolve(pdf.numPages || 1);
                    } catch (e) {
                        console.error("Error reading PDF pages:", e);
                        resolve(1); // Fallback to 1 page on error
                    }
                };
                reader.onerror = () => resolve(1);
                reader.readAsArrayBuffer(file);
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            // --- TIPO DOCUMENTO LOGIC ---
            const btnToggleTiposEnvio = document.getElementById('btnToggleTiposEnvio');
            if (btnToggleTiposEnvio) {
                const tiposEnvioDropdown = document.getElementById('tiposEnvioDropdown');
                const buscarTipoEnvioInput = document.getElementById('buscarTipoEnvioInput');
                const listaTiposEnvio = document.getElementById('listaTiposEnvio');
                const tipoEnvioValue = document.getElementById('id_tipo_envio_value');
                const btnToggleTiposEnvioLabel = document.getElementById('btnToggleTiposEnvioLabel');

                btnToggleTiposEnvio.onclick = (e) => {
                    e.stopPropagation();
                    tiposEnvioDropdown.classList.toggle('hidden');
                };

                buscarTipoEnvioInput.oninput = (e) => {
                    const q = e.target.value.toLowerCase();
                    listaTiposEnvio.querySelectorAll('li').forEach(li => {
                        li.classList.toggle('hidden', !li.innerText.toLowerCase().includes(q));
                    });
                };

                listaTiposEnvio.onclick = (e) => {
                    const li = e.target.closest('li');
                    if (li) {
                        const id = li.dataset.id;
                        const nombre = li.dataset.nombre;
                        
                        tipoEnvioValue.value = id;
                        btnToggleTiposEnvioLabel.innerText = nombre;
                        btnToggleTiposEnvioLabel.classList.remove('text-gray-400');
                        tiposEnvioDropdown.classList.add('hidden');

                        // Mostrar/Ocultar campo para especificar "Otro"
                        const containerOtro = document.getElementById('containerTipoOtro');
                        const inputOtro = document.getElementById('tipoOtroInput');
                        if (id === 'OTRO') {
                            containerOtro.classList.remove('hidden');
                            if(inputOtro) inputOtro.required = true;
                        } else {
                            containerOtro.classList.add('hidden');
                            if(inputOtro) {
                                inputOtro.required = false;
                                inputOtro.value = '';
                            }
                        }
                    }
                };

                document.addEventListener('click', (e) => {
                    if (!btnToggleTiposEnvio.contains(e.target) && !tiposEnvioDropdown.contains(e.target)) {
                        tiposEnvioDropdown.classList.add('hidden');
                    }
                });
            }

            // --- SEARCH FUNCIONARIO LOGIC ---
            window.setupFuncionarioSearch = function(block) {
                const input = block.querySelector('.func-search-input');
                const dropdown = block.querySelector('.func-dropdown');
                const hiddenInput = block.querySelector('.func-hidden-input');

                input.oninput = debounce(async (e) => {
                    const q = e.target.value.trim();
                    if (q.length < 2) {
                        dropdown.classList.add('hidden');
                        return;
                    }

                    try {
                        const res = await fetch(`{{ route('ventanilla.buscar_empleados') }}?q=${q}`);
                        const data = await res.json();

                        dropdown.innerHTML = '';
                        if (data.length === 0) {
                            dropdown.innerHTML = '<div class="p-2 text-xs text-gray-400 italic text-center">Sin resultados</div>';
                        } else {
                            data.forEach(emp => {
                                const li = document.createElement('div');
                                li.className = 'p-2 text-xs hover:bg-emerald-50 dark:hover:bg-emerald-900/40 rounded-xl cursor-pointer transition-colors border-b border-gray-50 dark:border-gray-700 last:border-0';
                                li.innerHTML = `
                                    <div class="font-bold dark:text-white">${emp.emple_nombres} ${emp.emple_apellidos}</div>
                                    <div class="text-[10px] text-gray-500">${emp.emple_doc} • ${emp.area_nom || 'Sin área'}</div>
                                `;
                                li.onclick = () => {
                                    input.value = `${emp.emple_nombres} ${emp.emple_apellidos}`;
                                    hiddenInput.value = emp.emple_doc;
                                    dropdown.classList.add('hidden');
                                };
                                dropdown.appendChild(li);
                            });
                        }
                        dropdown.classList.remove('hidden');
                    } catch(err) { console.error("Error buscando empleados:", err); }
                }, 300);

                document.addEventListener('click', (e) => {
                    if (!block.contains(e.target)) dropdown.classList.add('hidden');
                });
            }

            // Init first block
            const firstBlock = document.querySelector('.funcionario-block');
            if(firstBlock) setupFuncionarioSearch(firstBlock);


            // --- DETAILS & HISTORY LOGIC ---
            document.querySelectorAll('.btn-ver-detalle').forEach(btn => {
                btn.onclick = (e) => {
                    e.stopPropagation();
                    const fila = btn.closest('.fila-registro');
                    if (fila) openDetalleModal(fila.dataset);
                };
            });

            document.querySelectorAll('.fila-registro').forEach(fila => {
                fila.addEventListener('click', () => openDetalleModal(fila.dataset));
            });

            function openDetalleModal(data) {
                try {
                    document.getElementById('detailRadicado').textContent = data.radicado || 'SIN RADICADO';
                    document.getElementById('detailAsunto').textContent = data.asunto || '(Sin asunto)';
                    document.getElementById('detailDestinatario').textContent = data.destinatario || '—';
                    document.getElementById('detailDate').textContent = data.fecha || '—';
                    document.getElementById('detailType').textContent = data.tipoDoc || 'No especificado';
                    document.getElementById('detailPriority').textContent = data.prioridad || '—';

                    const statusEl = document.getElementById('detailStatus');
                        statusEl.textContent = data.estado || '—';
                        statusEl.className = `px-3 py-1 rounded-full text-[10px] font-bold mb-6 ${data.estadoClases || 'bg-gray-100 text-gray-700'}`;

                    const actionArea = document.getElementById('detailActionsContainer');
                        actionArea.innerHTML = '';

                        if (data.archivo) {
                            const btn = document.createElement('a');
                            btn.href = data.archivo; btn.target = '_blank';
                            btn.className = 'flex items-center gap-2 px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 rounded-xl hover:bg-blue-100 transition-all border border-blue-100 dark:border-blue-800';
                            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">description</span> Principal';
                            actionArea.appendChild(btn);
                        }

                        let anexos = [];
                        try { anexos = JSON.parse(data.anexos || '[]'); } catch(e) {}
                        anexos.forEach((anexo, idx) => {
                            const btn = document.createElement('a');
                            btn.href = `/storage/${anexo.ruta_archivo}`; btn.target = '_blank';
                            btn.className = 'flex items-center gap-2 px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-gray-600 bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400 rounded-xl hover:bg-gray-100 transition-all border border-gray-100 dark:border-gray-600';
                            btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">attach_file</span> Anexo ${idx + 1}`;
                            actionArea.appendChild(btn);
                        });

                    document.getElementById('btnVerTrazabilidadCompleta').onclick = () => {
                        closeModal('detailsModal');
                        showHistoryModal(data.id, data.radicado);
                    };
                    
                    loadMiniHistory(data.id);
                    openModal('detailsModal');
                } catch (err) { console.error(err); }
            }

            function loadMiniHistory(id) {
                const timeline = document.getElementById('detailTimeline');
                if(!timeline) return;
                timeline.innerHTML = '<p class="text-[10px] text-gray-400 italic animate-pulse">Cargando...</p>';
                fetch(`{{ url('/ventanilla/externaenv') }}/${id}/history`)
                    .then(res => res.json())
                    .then(data => {
                        timeline.innerHTML = data.length === 0 ? '<p class="text-[10px] text-gray-400 italic">Sin movimientos registrados</p>' : '';
                        data.slice(0, 3).forEach(item => {
                            const date = new Date(item.fecha).toLocaleDateString('es-ES', {day:'2-digit', month:'short'});
                            timeline.innerHTML += `
                                <div class="flex gap-3 text-[11px]">
                                    <span class="text-gray-400 font-bold shrink-0">${date}</span>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800 dark:text-gray-200 uppercase tracking-tight">${item.estado_nomb}</span>
                                        <span class="text-gray-500 text-[10px] text-left">${item.nombres} ${item.apellidos}</span>
                                    </div>
                                </div>`;
                        });
                    });
            }

            window.showHistoryModal = async function(id, radicado) {
                const timeline = document.getElementById('history-timeline');
                const btnDownload = document.getElementById('btnDownloadTrazabilidad');
                const radText = document.getElementById('historyRadText');

                if (btnDownload) {
                    btnDownload.href = `/ventanilla/trazabilidad/${id}/pdf?tipo=envio`;
                }
                
                radText.innerHTML = radicado ? `<span class='font-bold text-primary'>Radicado: #${radicado}</span>` : 'Cargando...';
                
                // Limpiar y mostrar cargando
                timeline.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                        <span class="material-symbols-outlined animate-spin text-4xl mb-4">sync</span>
                        <p class="text-sm font-medium">Cargando línea de tiempo...</p>
                    </div>
                `;
                
                openModal('historyModal');

                try {
                    const response = await fetch(`{{ url('/ventanilla/externaenv') }}/${id}/history`);
                    if (!response.ok) throw new Error('Error al obtener el historial');
                    const data = await response.json();

                    if (!data || data.length === 0) {
                        timeline.innerHTML = `<div class="text-center py-10 text-gray-500">No se encontró historial para este radicado.</div>`;
                        return;
                    }

                    if (!radicado && data[0].num_radicado) {
                        radText.innerHTML = `<span class='font-bold text-primary'>Radicado: #${data[0].num_radicado}</span>`;
                    }

                    let html = "";
                    data.forEach((entry, index) => {
                        const isFirst = index === 0;
                        
                        // Colores segmentados por estado
                        let dotColor = "bg-gray-300";
                        let textColor = "text-gray-900 dark:text-gray-100";
                        const est = (entry.estado_nomb || '').toLowerCase();
                        
                        if (est.includes('recibido')) dotColor = "bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]";
                        else if (est.includes('tramite') || est.includes('trámite')) dotColor = "bg-yellow-500 shadow-[0_0_10px_rgba(234,179,8,0.5)]";
                        else if (est.includes('resuelto') || est.includes('finalizado') || est.includes('enviado') || est.includes('salida')) dotColor = "bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]";
                        else if (est.includes('rechazado')) dotColor = "bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.5)]";
                        else if (est.includes('ingreso') || est.includes('registrado')) dotColor = "bg-primary shadow-[0_0_10px_rgba(32,73,222,0.5)]";

                        const dateObj = new Date(entry.fecha);
                        const dateStr = dateObj.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
                        const timeStr = dateObj.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', hour12: true });

                        html += `
                        <div class="relative animate-in slide-in-from-left-4 duration-500" style="animation-delay: ${index * 100}ms">
                            <!-- Dot -->
                            <div class="absolute -left-[41px] top-1.5 w-6 h-6 rounded-full ${dotColor} border-4 border-white dark:border-slate-900 z-10 flex items-center justify-center">
                                ${isFirst ? '<span class="w-1.5 h-1.5 bg-white rounded-full"></span>' : ''}
                            </div>

                            <!-- Content Card -->
                            <div class="bg-gray-50/50 dark:bg-slate-800/40 rounded-2xl p-4 border border-gray-100 dark:border-gray-800 hover:border-primary/30 dark:hover:border-primary/30 transition-all duration-300 group">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider ${entry.type === 'registry' ? 'bg-primary/10 text-primary border border-primary/20' : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-600'}">
                                        ${entry.estado_nomb}
                                    </span>
                                    <div class="flex items-center gap-2 text-[11px] text-gray-400 font-medium">
                                        <span class="material-symbols-outlined text-[14px]">calendar_month</span>
                                        ${dateStr} • ${timeStr}
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold ${textColor} group-hover:text-primary transition-colors text-left">
                                            ${entry.nombres} ${entry.apellidos}
                                        </h4>
                                        ${entry.area_e ? `<p class="text-[10px] text-primary/70 font-bold uppercase mt-0.5 flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">business</span> ${entry.area_e}</p>` : ''}
                                        
                                        ${entry.observaciones ? `
                                        <div class="mt-3 text-xs text-gray-600 dark:text-gray-400 leading-relaxed bg-white dark:bg-slate-900/50 p-3 rounded-xl border border-gray-100 dark:border-gray-800 italic text-left">
                                            "${entry.observaciones}"
                                        </div>` : ''}

                                        <!-- Anexos / Respuesta sections -->
                                        ${entry.archivo_res || (entry.anexos && entry.anexos.length > 0) ? `
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            ${entry.archivo_res ? `
                                            <a href="/storage/${entry.archivo_res}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-lg text-xs font-bold border border-green-100 dark:border-green-800/50 hover:bg-green-100 dark:hover:bg-green-900/30 transition-all">
                                                <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span>
                                                OFICIO RESPUESTA
                                            </a>` : ''}
                                            
                                            ${entry.anexos ? entry.anexos.map(anexo => `
                                            <a href="/storage/${anexo.ruta_archivo}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 rounded-lg text-xs font-bold border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-all">
                                                <span class="material-symbols-outlined text-[16px]">attachment</span>
                                                ${anexo.nombre_original.length > 20 ? anexo.nombre_original.substring(0, 17) + '...' : anexo.nombre_original}
                                            </a>`).join('') : ''}
                                        </div>` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });

                    timeline.innerHTML = html;

                } catch (error) {
                    console.error(error);
                    timeline.innerHTML = `<div class="text-center py-10 text-red-500 font-medium flex flex-col items-center gap-2">
                        <span class="material-symbols-outlined text-4xl">error</span>
                        Error al cargar el historial.
                    </div>`;
                }
            };

            // --- SEARCH & UTILS ---
            const searchInputGlobal = document.getElementById('searchInputGlobal');
            if (searchInputGlobal) {
                searchInputGlobal.onkeypress = (e) => { if (e.key === 'Enter') document.getElementById('formSearchGlobal').submit(); };
            }
            const btnClearSearchGlobal = document.getElementById('btnClearSearchGlobal');
            if (btnClearSearchGlobal) {
                btnClearSearchGlobal.onclick = () => { window.location.href = "{{ route('ventanilla.externaenv') }}"; };
            }

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('abrir') === 'nuevo') openModal('salienteModal');
        });
    </script>
@endsection
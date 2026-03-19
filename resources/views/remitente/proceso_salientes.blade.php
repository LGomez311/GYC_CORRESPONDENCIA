@extends('remitente.layouts.app')

@section('title', 'En Proceso Salientes - Remitente')

@section('content')
    <div class="flex flex-col h-screen w-full bg-gray-50 dark:bg-gray-900 overflow-hidden">
        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col p-6 overflow-y-auto">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        En Proceso Salientes
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Correspondencia con respuesta lista para ser registrada como saliente.</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('remitente.externarec') }}"
                        class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">move_to_inbox</span>
                        Registrar Recibido
                    </a>

                    <a href="{{ route('remitente.externaenv') }}"
                        class="flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">outbox</span>
                        Registrar Saliente
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Stat Card: Total -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex flex-col gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-[20px]">description</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Registros</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Rejected -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex flex-col gap-3">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center text-red-600 dark:text-red-400 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-[20px]">cancel</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Rechazados</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['rejected'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Pending -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex flex-col gap-3">
                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center text-orange-600 dark:text-orange-400 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-[20px]">pending_actions</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">En Trámite</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['pending'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Resolved -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex flex-col gap-3">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Finalizados</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['resolved'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Correspondence Table -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col flex-1">
                <div
                    class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Correspondencia Reciente</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Listado de tus registros y sus estados actuales.</p>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="material-symbols-outlined text-gray-400 text-sm">search</span>
                        </span>
                        <input type="text" id="tableSearch"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary dark:text-white"
                            placeholder="Filtrar por asunto, radicado...">
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-900/30 border-b border-gray-100 dark:border-gray-800">
                                <th class="px-4 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Radicados
                                </th>
                                <th class="px-4 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Procedencia
                                </th>
                                <th class="px-4 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Asunto</th>
                                <th class="px-4 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    Destinatarios</th>
                                <th class="px-4 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">
                                    Registro</th>
                                <th class="px-4 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">
                                    Estado</th>
                                <th class="px-4 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="correspondenceTableBody" class="divide-y divide-gray-50 dark:divide-gray-800/50">
                            @forelse($correspondencias as $c)
                                <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-all duration-200">

                                    <td class="px-4 py-4 whitespace-nowrap align-middle">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-bold text-gray-900 dark:text-white tracking-tight">
                                                {{ $c->radicado ? $c->radicado->num_radicado : 'SIN RADICADO' }}
                                            </span>
                                            @if ($c->num_radicado_ext)
                                                <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400">
                                                    EXT: {{ $c->num_radicado_ext }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 align-middle">
                                        <div class="flex flex-col gap-1.5">
                                            @if ($c->nom_institucion)
                                                {{-- Caso Entidad --}}
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="px-1.5 py-0.5 bg-blue-50/50 dark:bg-blue-900/10 text-blue-600 dark:text-blue-400 text-[10px] font-semibold rounded border border-blue-100/50 dark:border-blue-800/50">Entidad</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate max-w-[200px]"
                                                        title="{{ $c->nom_institucion }}">
                                                        {{ $c->nom_institucion }}
                                                    </span>
                                                </div>
                                                @if ($c->num_radicado_ext)
                                                    <div class="hidden items-center gap-1 text-gray-500">
                                                        <span class="material-symbols-outlined text-[12px]">tag</span>
                                                        <span class="text-[10px] font-medium italic">Rad. Ext:
                                                            {{ $c->num_radicado_ext }}</span>
                                                    </div>
                                                @endif
                                                @if ($c->correo_persona)
                                                    <div class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                                                        <span class="material-symbols-outlined text-[12px]">mail</span>
                                                        <span
                                                            class="text-[10px] lowercase truncate max-w-[180px]">{{ $c->correo_persona }}</span>
                                                    </div>
                                                @endif
                                            @else
                                                {{-- Caso Persona Natural --}}
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="px-1.5 py-0.5 bg-purple-50/50 dark:bg-purple-900/10 text-purple-600 dark:text-purple-400 text-[10px] font-semibold rounded border border-purple-100/50 dark:border-purple-800/50">Natural</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate max-w-[200px]">
                                                        {{ $c->nombre_persona ?? 'Particular' }}
                                                    </span>
                                                </div>
                                                <div class="hidden grid-cols-2 gap-x-2 mt-0.5">
                                                    @if ($c->doc_persona)
                                                        <div class="flex items-center gap-1 text-gray-500">
                                                            <span class="material-symbols-outlined text-[12px]">badge</span>
                                                            <span
                                                                class="text-[10px] font-medium">{{ $c->doc_persona }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($c->tel_persona)
                                                        <div class="flex items-center gap-1 text-gray-500">
                                                            <span class="material-symbols-outlined text-[12px]">call</span>
                                                            <span
                                                                class="text-[10px] font-medium">{{ $c->tel_persona }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if ($c->correo_persona)
                                                    <div
                                                        class="flex items-center gap-1 text-gray-500 dark:text-gray-400 mt-0.5">
                                                        <span class="material-symbols-outlined text-[12px]">mail</span>
                                                        <span
                                                            class="text-[10px] lowercase truncate max-w-[180px]">{{ $c->correo_persona }}</span>
                                                    </div>
                                                @endif
                                            @endif

                                            <div
                                                class="flex items-center gap-1 text-gray-500 dark:text-gray-400 mt-0.5 border-t border-gray-100 dark:border-gray-800/50 pt-1.5">
                                                <span
                                                    class="material-symbols-outlined text-[12px] font-variation-icon">location_on</span>
                                                <span class="text-[9px] font-semibold uppercase tracking-tight">
                                                    {{ $c->ciudad ? $c->ciudad->ciudad_nom : '-' }}
                                                    @if ($c->ciudad && $c->ciudad->departamento)
                                                        - {{ $c->ciudad->departamento->dpto_nombre }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 align-middle">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2 max-w-[250px]"
                                                title="{{ $c->asunto }}">
                                                {{ $c->asunto }}
                                            </span>

                                            <div class="hidden flex-wrap gap-1 mt-1">
                                                <div
                                                    class="flex items-center gap-0.5 bg-gray-100 dark:bg-gray-700/50 px-1.5 py-0.5 rounded text-[8px] font-bold text-gray-500 uppercase tracking-tighter">
                                                    <span
                                                        class="material-symbols-outlined text-[10px] font-variation-icon">layers</span>
                                                    F: {{ $c->folio ?? 0 }}
                                                </div>
                                                @if ($c->id_tipo_rec)
                                                    <div
                                                        class="flex items-center gap-0.5 bg-orange-50 dark:bg-orange-900/10 px-1.5 py-0.5 rounded text-[8px] font-bold text-orange-600 uppercase tracking-tighter">
                                                        {{ $c->tipo ? $c->tipo->tipo_nombre : 'TIPO' }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 align-middle">
                                        <div class="flex flex-wrap gap-2 max-w-[200px]">
                                            @php
                                                // Obtenemos solo el último estado de cada empleado y filtramos los históricos
                                                $filteredDetalles = $c->detalles
                                                    ->sortByDesc('id_det_recibido')
                                                    ->unique('det_doc_empleado')
                                                    ->filter(function ($d) {
                                                        // Ocultamos registros marcados como Resueltos (9)
                                                        // ya que representan gestiones pasadas o finalizadas.
                                                        // Mantenemos Archivados (10) para que no desaparezcan de la vista del remitente
                                                        // cuando otro usuario toma la correspondencia.
                                                        return $d->id_estado_rec != 9;
                                                    });
                                            @endphp
                                            @forelse($filteredDetalles as $det)
                                                <div class="flex items-center gap-2"
                                                    title="{{ $det->empleado->emple_nombres ?? 'Usuario' }} {{ $det->empleado->emple_apellidos ?? '' }}">
                                                    <div
                                                        class="w-7 h-7 rounded-full {{ $det->empleado && $det->empleado->emple_img ? '' : 'bg-blue-600' }} flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-700 flex-shrink-0">
                                                        @if ($det->empleado && $det->empleado->emple_img)
                                                            <img src="{{ asset('storage/' . $det->empleado->emple_img) }}"
                                                                class="w-full h-full object-cover">
                                                        @else
                                                            <span class="text-xs font-bold text-white">
                                                                {{ strtoupper(substr($det->empleado->emple_nombres ?? 'U', 0, 1)) }}{{ strtoupper(substr($det->empleado->emple_apellidos ?? 'A', 0, 1)) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex flex-col min-w-0">
                                                        <span
                                                            class="text-[10px] font-bold text-gray-700 dark:text-gray-300 leading-none truncate max-w-[120px]">
                                                            {{ $det->empleado->emple_nombres ?? 'Usuario' }}
                                                            {{ $det->empleado->emple_apellidos ?? '' }}
                                                        </span>
                                                        @php
                                                            $detStatusColor = match ($det->id_estado_rec) {
                                                                7 => 'text-green-600 dark:text-green-400',
                                                                11 => 'text-red-600 dark:text-red-400',
                                                                8 => 'text-amber-600 dark:text-amber-400',
                                                                9, 10, 14 => 'text-emerald-600 dark:text-emerald-400',
                                                                default => 'text-gray-500 dark:text-gray-400',
                                                            };
                                                        @endphp
                                                        <span
                                                            class="text-[9px] font-medium {{ $detStatusColor }} leading-none mt-1">
                                                            {{ $det->estado->estado_nomb ?? 'Pendiente' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @empty
                                                <span class="text-gray-400 text-xs italic">Sin asignar</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-center whitespace-nowrap align-middle">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="text-xs font-medium text-gray-900 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($c->fecha_hora_recib)->format('d M, Y') }}
                                            </span>
                                            <span class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">
                                                {{ \Carbon\Carbon::parse($c->fecha_hora_recib)->format('h:i A') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-center align-middle">
                                        @php
                                            $statusColor = match ($c->id_estado_rec) {
                                                11
                                                    => 'bg-red-50 text-red-600 border-red-200 dark:bg-red-900/20 dark:border-red-800',
                                                9,
                                                10
                                                    => 'bg-green-50 text-green-600 border-green-200 dark:bg-green-900/20 dark:border-green-800',
                                                8
                                                    => 'bg-amber-50 text-amber-600 border-amber-200 dark:bg-amber-900/20 dark:border-amber-800',
                                                14
                                                    => 'bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-900/20 dark:border-emerald-800',
                                                default
                                                    => 'bg-blue-50 text-blue-600 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold tracking-wide border {{ $statusColor }}">
                                            {{ $c->estado ? $c->estado->estado_nomb : 'PENDIENTE' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-center align-middle">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="viewDetails({{ $c->id_recibido }})"
                                                class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                                title="Ver Gestión y Documentos">
                                                <span
                                                    class="material-symbols-outlined text-[20px] font-variation-icon">visibility</span>
                                            </button>
                                            <button onclick="showHistory({{ $c->id_recibido }})"
                                                class="p-1.5 text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-gray-700/50 rounded-lg transition-colors"
                                                title="Trazabilidad">
                                                <span
                                                    class="material-symbols-outlined text-[20px] font-variation-icon">timeline</span>
                                            </button>
                                            @if ($c->id_estado_rec == 11)
                                                <button onclick="openEditModalById({{ $c->id_recibido }})"
                                                    class="p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                    title="Corregir">
                                                    <span class="material-symbols-outlined text-[20px]">edit_note</span>
                                                </button>
                                                <button onclick="confirmFinalize({{ $c->id_recibido }})"
                                                    class="p-1.5 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors"
                                                    title="Finalizar">
                                                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                                </button>
                                            @else
                                                @php
                                                    $hasResponse = $c->detalles->contains(
                                                        fn($d) => !empty($d->archivo_res),
                                                    );
                                                @endphp
                                                @if ($hasResponse && $c->id_estado_rec != 14 && $c->id_estado_rec != 10)
                                                    <button onclick="openSalienteModal({{ $c->id_recibido }})"
                                                        class="p-1.5 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors"
                                                        title="Registrar Saliente">
                                                        <span
                                                            class="material-symbols-outlined text-[20px] font-variation-icon">outbox</span>
                                                    </button>
                                                @else
                                                    <div class="p-1.5 text-gray-300 dark:text-gray-700 cursor-not-allowed">
                                                        <span class="material-symbols-outlined text-[20px]">lock</span>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-14 h-14 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center">
                                                <span
                                                    class="material-symbols-outlined text-gray-400 text-3xl font-variation-icon">inventory_2</span>
                                            </div>
                                            <p class="text-gray-500 text-sm font-medium">No se encontraron registros de
                                                correspondencia.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $correspondencias->appends(request()->query())->links() }}
                </div>
            </div>
        </main>
    </div>

    <!-- View Details Modal -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
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
                                <span class="material-symbols-outlined text-4xl">description</span>
                            </div>
                            <h3 id="detailRadicado" class="text-xl font-bold text-gray-900 dark:text-white mb-1"></h3>
                            <span id="detailStatus" class="px-3 py-1 rounded-full text-[10px] font-bold mb-6"></span>

                            <div class="w-full space-y-4 text-left">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fecha Registro
                                    </p>
                                    <p id="detailDate" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tipo Documento
                                    </p>
                                    <p id="detailType" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Folios</p>
                                    <p id="detailFolios" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
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

                        <div id="detailInstitutionRow">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Institución / Ciudad
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span id="detailInstitution" class="font-bold text-gray-700 dark:text-gray-300"></span>
                                <span class="mx-2">•</span>
                                <span id="detailCity"></span>
                            </p>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Observaciones</h4>
                            <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl text-sm text-gray-600 dark:text-gray-400 italic"
                                id="detailObservations"></div>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Destinatarios
                                Asignados</h4>
                            <div id="detailRecipients" class="flex flex-wrap gap-2"></div>
                        </div>

                        <div id="detailActionsContainer" class="pt-4 flex gap-3">
                            <a id="detailDownload" href="#" target="_blank"
                                class="flex-1 flex items-center justify-center gap-2 px-5 py-3 text-sm font-bold text-primary bg-primary/10 rounded-xl hover:bg-primary/20 transition-all">
                                <span class="material-symbols-outlined text-[20px]">download</span>
                                Ver Documento
                            </a>
                            <button id="detailActionBtn"
                                class="flex-1 flex items-center justify-center gap-2 px-5 py-3 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/95 transition-all shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                Editar Solicitud
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                onclick="closeModal('historyModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-middle bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div
                    class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Trazabilidad de Documento</h3>
                        <p class="text-xs text-gray-500 mt-0.5" id="historyRadText"></p>
                    </div>
                    <button onclick="closeModal('historyModal')"
                        class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="p-8 max-h-[70vh] overflow-y-auto bg-white dark:bg-gray-800">
                    <div id="historyTimeline" class="relative">
                        <!-- History items will be injected here -->
                    </div>
                </div>
                <div
                    class="px-8 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20 flex justify-end">
                    <button onclick="closeModal('historyModal')"
                        class="px-6 py-2 text-sm font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (for rejected) -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('editModal')">
            </div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden transform transition-all">
                <form id="editForm" method="POST">
                    @csrf
                    <div
                        class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Corregir Correspondencia</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Ajusta los datos y genera un nuevo radicado de envío.
                            </p>
                        </div>
                        <button type="button" onclick="closeModal('editModal')"
                            class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Asunto</label>
                            <input type="text" name="asunto" id="editAsunto"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white font-medium transition-all"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Observaciones
                                de Corrección</label>
                            <textarea name="observaciones" id="editObs" rows="3"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-primary focus:border-primary dark:text-white text-sm transition-all"
                                placeholder="Explica brevemente los cambios realizados..."></textarea>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <label
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Destinatarios</label>
                                <div class="relative w-48">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                        <span class="material-symbols-outlined text-gray-400 text-xs">search</span>
                                    </span>
                                    <input type="text" id="recipientSearch"
                                        class="block w-full pl-7 pr-2 py-1.5 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-[10px] focus:ring-primary focus:border-primary dark:text-white"
                                        placeholder="Documento, nombre o área...">
                                </div>
                            </div>
                            <div
                                class="bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden">
                                <div id="recipientList" class="max-h-56 overflow-y-auto p-2 space-y-1">
                                    @php
                                        $empleados = \App\Models\Empleado::with('area')
                                            ->where('emple_rol', '=', 3)
                                            ->orderBy('emple_nombres')
                                            ->get();
                                    @endphp
                                    @foreach ($empleados as $e)
                                        <label
                                            class="recipient-item flex items-center gap-3 p-2 rounded-lg hover:bg-white dark:hover:bg-gray-700 cursor-pointer transition-all border border-transparent hover:border-gray-100 dark:hover:border-gray-600"
                                            data-name="{{ strtolower($e->emple_nombres . ' ' . $e->emple_apellidos) }}"
                                            data-doc="{{ $e->emple_doc }}"
                                            data-area="{{ strtolower($e->area ? $e->area->area_nom : 'sin área') }}">
                                            <input type="checkbox" name="destinatarios[]" value="{{ $e->emple_doc }}"
                                                class="recipient-checkbox w-4 h-4 text-primary bg-white border-gray-300 rounded focus:ring-primary dark:bg-gray-600 dark:border-gray-500">

                                            <div class="flex items-center gap-3 flex-1">
                                                @if ($e->emple_img)
                                                    <img src="{{ asset('storage/' . $e->emple_img) }}"
                                                        class="w-8 h-8 rounded-full object-cover">
                                                @else
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-sm border border-blue-700">
                                                        {{ strtoupper(substr($e->emple_nombres, 0, 1)) }}{{ strtoupper(substr($e->emple_apellidos, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $e->emple_nombres }}
                                                        {{ $e->emple_apellidos }}</span>
                                                    <span
                                                        class="text-[10px] text-gray-400 capitalize">{{ $e->area ? $e->area->area_nom : 'Sin área' }}
                                                        • {{ $e->emple_doc }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">info</span>
                                Esta acción generará un nuevo número de radicado y archivará la solicitud anterior.
                            </p>
                        </div>
                    </div>
                    <div
                        class="px-8 py-6 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50/50 dark:bg-gray-900/20">
                        <button type="button" onclick="closeModal('editModal')"
                            class="px-6 py-2.5 text-sm text-gray-600 dark:text-gray-400 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cancelar</button>
                        <button type="submit"
                            class="px-8 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/95 transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            Generar Nuevo Envío
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Global data store to avoid quote/escaping issues in onclick handlers
        window.correspondenceData = @json($correspondencias->keyBy('id_recibido'));

        // Modal general logic
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Helper for initials/avatar
        function getAvatarHtml(dest) {
            if (dest.emple_img) {
                return `<img src="/storage/${dest.emple_img}" class="w-6 h-6 rounded-full object-cover border border-white dark:border-gray-700">`;
            }
            const initials = ((dest.emple_nombres ? dest.emple_nombres[0] : 'U') + (dest.emple_apellidos ? dest
                .emple_apellidos[0] : 'A')).toUpperCase();
            return `<div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold border border-blue-700 shadow-sm">${initials}</div>`;
        }

        // View Details Logic
        function viewDetails(id) {
            const c = window.correspondenceData[id];
            if (!c) return;

            document.getElementById('detailRadicado').textContent = c.radicado ? c.radicado.num_radicado : 'SIN RADICADO';
            document.getElementById('detailAsunto').textContent = c.asunto;
            document.getElementById('detailDate').textContent = new Date(c.fecha_hora_recib).toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('detailType').textContent = c.tipo ? c.tipo.tipo_nombre : 'No especificado';
            document.getElementById('detailFolios').textContent = c.folio || '0';
            document.getElementById('detailObservations').textContent = c.observaciones || 'Sin observaciones.';
            document.getElementById('detailInstitution').textContent = c.nom_institucion || 'Particular';
            document.getElementById('detailCity').textContent = c.ciudad ? c.ciudad.ciudad_nomb : 'No disponible';

            // Status pill
            const statusSpan = document.getElementById('detailStatus');
            statusSpan.textContent = c.estado ? c.estado.estado_nomb : 'Desconocido';
            statusSpan.className = 'px-3 py-1 rounded-full text-[10px] font-bold mb-6 ';
            if (c.id_estado_rec == 11) {
                statusSpan.classList.add('bg-red-100', 'text-red-700', 'dark:bg-red-900/50', 'dark:text-red-400');
            } else if (c.id_estado_rec == 9 || c.id_estado_rec == 10) {
                statusSpan.classList.add('bg-green-100', 'text-green-700', 'dark:bg-green-900/50', 'dark:text-green-400');
            } else {
                statusSpan.classList.add('bg-blue-100', 'text-blue-700', 'dark:bg-blue-900/50', 'dark:text-blue-400');
            }

            // Recipients refined with avatars
            const recipientsContainer = document.getElementById('detailRecipients');
            recipientsContainer.innerHTML = '';
            if (c.destinatarios && c.destinatarios.length > 0) {
                // Sorting and filtering in Details Modal to show latest active status
                const activeRecipients = c.destinatarios.filter(dest => {
                    const allDets = c.detalles ? c.detalles.filter(d => d.det_doc_empleado == dest.emple_doc) : [];
                    if (allDets.length === 0) return true;

                    // Get latest detail for this employee
                    const latestDet = allDets.sort((a, b) => b.id_det_recibido - a.id_det_recibido)[0];

                    // Filter out finished historical statuses (9)
                    // We keep status 10 (Archivado) visible because it's assigned to other 
                    // recipients when someone "takes" the document.
                    return parseInt(latestDet.id_estado_rec) !== 9;
                });

                if (activeRecipients.length > 0) {
                    activeRecipients.forEach(dest => {
                        const avatar = getAvatarHtml(dest);
                        const div = document.createElement('div');
                        div.className =
                            'inline-flex items-center gap-2 px-2 py-1 rounded-lg text-[10px] font-bold bg-gray-50 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 border border-gray-100 dark:border-gray-600';

                        const allDets = c.detalles ? c.detalles.filter(d => d.det_doc_empleado == dest.emple_doc) :
                            [];
                        const det = allDets.sort((a, b) => b.id_det_recibido - a.id_det_recibido)[0];

                        let statusHtml = '';
                        if (det) {
                            const statusName = det.estado ? det.estado.estado_nomb : (det.id_estado_rec == 7 ?
                                'Recibido' : (det.id_estado_rec == 11 ? 'Rechazado' : 'Pendiente'));
                            let colorClass = 'text-gray-500';
                            if (det.id_estado_rec == 7) colorClass = 'text-green-600 dark:text-green-400';
                            else if (det.id_estado_rec == 11) colorClass = 'text-red-600 dark:text-red-400';
                            else if (det.id_estado_rec == 8) colorClass = 'text-amber-600 dark:text-amber-400';
                            else if ([9, 10, 14].includes(parseInt(det.id_estado_rec))) colorClass =
                                'text-emerald-600 dark:text-emerald-400';

                            statusHtml =
                                `<span class="text-[8px] font-medium ${colorClass} mt-0.5">${statusName}</span>`;
                        }
                        div.innerHTML =
                            `${avatar} <div class="flex flex-col"><span class="leading-none">${dest.emple_nombres} ${dest.emple_apellidos}</span>${statusHtml}</div>`;
                        recipientsContainer.appendChild(div);
                    });
                } else {
                    recipientsContainer.innerHTML =
                    '<p class="text-gray-400 text-xs italic">Sin destinatarios activos.</p>';
                }
            } else {
                recipientsContainer.innerHTML =
                    '<p class="text-gray-400 text-xs italic">No hay destinatarios asignados.</p>';
            }

            // Attachments List Logic - Refactored to show Sent and Received docs
            const actionArea = document.getElementById('detailActionsContainer');
            actionArea.innerHTML = ''; // Clear action area

            const docsWrapper = document.createElement('div');
            docsWrapper.className = 'w-full space-y-6';
            actionArea.appendChild(docsWrapper);

            // SECTION 1: DOCUMENTOS ENVIADOS (ORIGINAL)
            const sentSection = document.createElement('div');
            sentSection.innerHTML =
                '<h5 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 px-1">Documentos Enviados</h5>';
            const sentGrid = document.createElement('div');
            sentGrid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-2';
            sentSection.appendChild(sentGrid);
            docsWrapper.appendChild(sentSection);

            // Principal
            if (c.archivo) {
                const btn = document.createElement('a');
                btn.href = `/storage/${c.archivo}`;
                btn.target = '_blank';
                btn.className =
                    'flex items-center gap-2 px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 rounded-xl hover:bg-blue-100 transition-all border border-blue-100 dark:border-blue-800';
                btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">description</span> Principal';
                sentGrid.appendChild(btn);
            }

            // Annexes
            if (c.anexos && c.anexos.length > 0) {
                c.anexos.forEach((anexo, idx) => {
                    const btn = document.createElement('a');
                    btn.href = `/storage/${anexo.ruta_archivo}`;
                    btn.target = '_blank';
                    btn.className =
                        'flex items-center gap-2 px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-gray-600 bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400 rounded-xl hover:bg-gray-100 transition-all border border-gray-100 dark:border-gray-600';
                    btn.title = anexo.nombre_original;
                    btn.innerHTML =
                        `<span class="material-symbols-outlined text-[18px]">attach_file</span> Anexo ${idx + 1}`;
                    sentGrid.appendChild(btn);
                });
            }

            // SECTION 2: RESPUESTAS RECIBIDAS
            const hasResponses = c.detalles && c.detalles.some(d => d.archivo_res || (d.anexos_respuesta && d
                .anexos_respuesta.length > 0));

            if (hasResponses) {
                const respSection = document.createElement('div');
                respSection.className = 'pt-2 border-t border-gray-100 dark:border-gray-700';
                respSection.innerHTML =
                    '<h5 class="text-[10px] font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400 mb-2 px-1">Respuestas y Evidencias</h5>';
                const respGrid = document.createElement('div');
                respGrid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-2';
                respSection.appendChild(respGrid);
                docsWrapper.appendChild(respSection);

                c.detalles.forEach(d => {
                    // Response Main Document
                    if (d.archivo_res) {
                        const btn = document.createElement('a');
                        btn.href = `/storage/${d.archivo_res}`;
                        btn.target = '_blank';
                        btn.className =
                            'flex items-center gap-2 px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400 rounded-xl hover:bg-emerald-100 transition-all border border-emerald-100 dark:border-emerald-800';
                        const empName = d.empleado ? d.empleado.emple_nombres.split(' ')[0] : 'Funcionario';
                        btn.innerHTML =
                            `<span class="material-symbols-outlined text-[18px]">task</span> Respuesta (${empName})`;
                        respGrid.appendChild(btn);
                    }

                    // Response Annexes
                    if (d.anexos_respuesta && d.anexos_respuesta.length > 0) {
                        d.anexos_respuesta.forEach((anexo, idx) => {
                            const btn = document.createElement('a');
                            btn.href = `/storage/${anexo.ruta_archivo}`;
                            btn.target = '_blank';
                            btn.className =
                                'flex items-center gap-2 px-3 py-2.5 text-[10px] font-bold uppercase tracking-wider text-teal-600 bg-teal-50 dark:bg-teal-900/20 dark:text-teal-400 rounded-xl hover:bg-teal-100 transition-all border border-teal-100 dark:border-teal-800';
                            btn.innerHTML =
                                `<span class="material-symbols-outlined text-[18px]">attachment</span> Evidencia ${idx + 1}`;
                            respGrid.appendChild(btn);
                        });
                    }
                });
            }

            // SECTION 3: ACTIONS (Correction if rejected)
            if (c.id_estado_rec == 11) {
                const editDiv = document.createElement('div');
                editDiv.className = 'pt-4';
                const editBtn = document.createElement('button');
                editBtn.className =
                    'w-full flex items-center justify-center gap-2 px-5 py-3 text-xs font-black uppercase tracking-widest text-white bg-red-500 rounded-2xl hover:bg-red-600 transition-all shadow-lg shadow-red-200 dark:shadow-red-900/30 active:scale-[0.98]';
                editBtn.innerHTML =
                    '<span class="material-symbols-outlined">edit_note</span> Corregir Correspondencia ahora';
                editBtn.onclick = () => {
                    closeModal('detailsModal');
                    openEditModalById(id);
                };
                editDiv.appendChild(editBtn);
                docsWrapper.appendChild(editDiv);
            }

            openModal('detailsModal');
        }

        // History Timeline Logic
        function showHistory(id) {
            const historyTimeline = document.getElementById('historyTimeline');
            historyTimeline.innerHTML =
                '<div class="flex justify-center p-12"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div></div>';
            openModal('historyModal');

            fetch(`/remitente/history/${id}`)
                .then(response => response.json())
                .then(data => {
                    historyTimeline.innerHTML = '';

                    if (!data || data.length === 0) {
                        historyTimeline.innerHTML =
                            '<div class="flex flex-col items-center py-12 text-gray-400"><span class="material-symbols-outlined text-4xl mb-2">history</span><p class="text-sm italic">No hay historial disponible.</p></div>';
                        return;
                    }

                    // Update header radicado info
                    const firstRecord = data.find(r => r.num_radicado);
                    document.getElementById('historyRadText').textContent = firstRecord ?
                        `Radicado: ${firstRecord.num_radicado}` : 'Historial de movimientos';

                    data.forEach((item, index) => {
                        const isLast = index === data.length - 1;
                        const dateObj = new Date(item.fecha);
                        const dateStr = dateObj.toLocaleDateString('es-ES', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        const timeStr = dateObj.toLocaleTimeString('es-ES', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });

                        // Icon and color mapping
                        let icon = 'info';
                        let colorClass = 'bg-blue-500';
                        let circleClass = 'bg-blue-100 text-blue-600';

                        if (item.type === 'registry') {
                            icon = 'outgoing_mail';
                            colorClass = 'bg-primary';
                            circleClass = 'bg-primary/10 text-primary';
                        } else {
                            const statusId = parseInt(item.id_estado_rec);
                            switch (statusId) {
                                case 7: // Recibido
                                    icon = 'inbox';
                                    colorClass = 'bg-orange-500';
                                    circleClass = 'bg-orange-100 text-orange-600';
                                    break;
                                case 8: // En Tramite
                                    icon = 'pending';
                                    colorClass = 'bg-amber-500';
                                    circleClass = 'bg-amber-100 text-amber-600';
                                    break;
                                case 9: // Resuelto
                                case 10: // Archivado
                                    icon = 'check_circle';
                                    colorClass = 'bg-green-500';
                                    circleClass = 'bg-green-100 text-green-600';
                                    break;
                                case 11: // Rechazado
                                    icon = 'cancel';
                                    colorClass = 'bg-red-500';
                                    circleClass = 'bg-red-100 text-red-600';
                                    break;
                                case 12: // Enviado
                                    icon = 'send';
                                    colorClass = 'bg-blue-500';
                                    circleClass = 'bg-blue-100 text-blue-600';
                                    break;
                                case 14: // Saliente
                                    icon = 'outbox';
                                    colorClass = 'bg-emerald-500';
                                    circleClass = 'bg-emerald-100 text-emerald-600';
                                    break;
                            }
                        }

                        const avatar = getAvatarHtml({
                            emple_img: item.img,
                            emple_nombres: item.nombres,
                            emple_apellidos: item.apellidos
                        });

                        const html = `
                            <div class="flex gap-4 relative">
                                ${!isLast ? `<div class="absolute left-[19px] top-10 bottom-0 w-0.5 bg-gray-100 dark:bg-gray-700/50"></div>` : ''}
                                
                                <div class="relative z-10">
                                    <div class="w-10 h-10 rounded-full ${circleClass} flex items-center justify-center shadow-sm">
                                        <span class="material-symbols-outlined text-[20px]">${icon}</span>
                                    </div>
                                </div>

                                <div class="flex-1 pb-10">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-1 gap-1">
                                        <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">${item.estado_nomb}</span>
                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-gray-400 bg-gray-50 dark:bg-gray-700 px-2 py-0.5 rounded-lg border border-gray-100 dark:border-gray-600">
                                            <span class="material-symbols-outlined text-[12px]">schedule</span>
                                            ${dateStr} • ${timeStr}
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 mb-3 mt-2 p-2 bg-gray-50/50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700/50 w-fit">
                                        ${avatar}
                                        <div class="flex flex-col pr-4">
                                            <p class="text-[11px] text-gray-800 dark:text-gray-200 font-bold leading-none">${item.nombres} ${item.apellidos}</p>
                                            <span class="text-[9px] text-gray-400 font-medium">Actor Responsable</span>
                                        </div>
                                    </div>

                                    ${item.observaciones ? `
                                                                <div class="relative p-4 bg-white dark:bg-gray-800 border-l-4 border-primary/20 rounded-r-xl shadow-sm group hover:border-primary transition-colors">
                                                                    <span class="material-symbols-outlined absolute -right-2 -top-2 text-primary/5 text-4xl group-hover:scale-110 transition-transform">format_quote</span>
                                                                    <p class="text-[12px] text-gray-600 dark:text-gray-400 italic leading-relaxed">"${item.observaciones}"</p>
                                                                </div>
                                                            ` : ''}

                                    ${item.archivo_res ? `
                                                    <div class="mt-3">
                                                        <a href="/storage/${item.archivo_res}" target="_blank" 
                                                           class="inline-flex items-center gap-2 px-3 py-2 text-xs font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl hover:bg-emerald-100 transition-all">
                                                            <span class="material-symbols-outlined text-[18px]">task</span>
                                                            Ver Documento de Respuesta
                                                        </a>
                                                    </div>
                                                ` : ''}

                                    ${item.anexos && item.anexos.length > 0 ? `
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        ${item.anexos.map((anexo, idx) => `
                                                <a href="/storage/${anexo.ruta_archivo}" target="_blank" 
                                                   class="inline-flex items-center gap-2 px-2.5 py-1.5 text-[10px] font-bold text-teal-600 bg-teal-50 dark:bg-teal-900/20 border border-teal-100 dark:border-teal-800 rounded-lg hover:bg-teal-100 transition-all"
                                                   title="${anexo.nombre_original}">
                                                    <span class="material-symbols-outlined text-[16px]">attachment</span>
                                                    Anexo ${idx + 1}
                                                </a>
                                            `).join('')}
                                                    </div>
                                                ` : ''}
                                </div>
                            </div>
                        `;
                        historyTimeline.innerHTML += html;
                    });
                })
                .catch(error => {
                    console.error('History error:', error);
                    historyTimeline.innerHTML =
                        '<div class="alert alert-danger p-4 rounded-xl text-red-500 bg-red-50 text-sm font-bold">Error al cargar el historial. Intenta de nuevo.</div>';
                });
        }

        // Edit Modal Logic with improved selection
        function openEditModalById(id) {
            const c = window.correspondenceData[id];
            if (!c) return;

            document.getElementById('editAsunto').value = c.asunto;
            document.getElementById('editObs').value = ''; // Clear notes for new corrections
            document.getElementById('editForm').action = `/remitente/${c.id_recibido}/update-rejected`;

            // Clear and set checkboxes
            const checkboxes = document.querySelectorAll('.recipient-checkbox');
            const currentRecipients = c.destinatarios ? c.destinatarios.map(d => String(d.emple_doc)) : [];

            checkboxes.forEach(cb => {
                cb.checked = currentRecipients.includes(String(cb.value));
            });

            openModal('editModal');
        }

        // Search recipients in Edit Modal (Multi-attribute)
        document.getElementById('recipientSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.recipient-item');

            items.forEach(item => {
                const name = item.dataset.name;
                const doc = item.dataset.doc;
                const area = item.dataset.area;

                const matches = name.includes(term) || doc.includes(term) || area.includes(term);
                item.style.display = matches ? 'flex' : 'none';
            });
        });

        // Search table logic
        document.getElementById('tableSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#correspondenceTableBody tr');

            rows.forEach(row => {
                // Skips "No se encontraron registros" row
                if (row.cells.length < 2) return;
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // SweetAlert for Finalize
        function confirmFinalize(id) {
            Swal.fire({
                title: '¿Finalizar correspondencia?',
                text: "Esta acción marcará la solicitud rechazada como archivada definitivamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#135bec',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, finalizar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    container: 'font-display',
                    popup: 'rounded-3xl border-none shadow-2xl dark:bg-gray-800 dark:text-white',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`finalize-form-${id}`).submit();
                }
            });
        }
        // Session Success Notifications (SweetAlert)
        @if (session('success'))
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#135bec',
                customClass: {
                    container: 'font-display',
                    popup: 'rounded-3xl border-none shadow-2xl dark:bg-gray-800 dark:text-white',
                    confirmButton: 'rounded-xl px-8 py-2.5 font-bold'
                }
            });
        @endif

        async function openSalienteModal(id) {
            const c = window.correspondenceData[id];
            if (!c) return;

            // Find response data
            const responseDetail = c.detalles.find(d => d.archivo_res);
            const responseAnnexes = c.detalles.flatMap(d => d.anexos_respuesta || []);

            document.getElementById('salienteForm').action = `/remitente/${id}/store-saliente`;
            document.getElementById('salienteAsunto').value = 'RESPUESTA: ' + c.asunto;
            document.getElementById('salienteDestino').value = c.nom_institucion || (c.nombre_persona ? c
                .nombre_persona : '');

            // Pre-fill fields
            const typeSelect = document.getElementById('salienteTipo');
            if (c.id_tipo) typeSelect.value = c.id_tipo;

            const officialSelect = document.getElementById('salienteFuncionario');
            if (responseDetail && responseDetail.det_doc_empleado) {
                officialSelect.value = responseDetail.det_doc_empleado;
            }

            // File Preview Section
            const previewContainer = document.getElementById('salienteFilePreview');
            previewContainer.innerHTML = '';

            if (responseDetail && responseDetail.archivo_res) {
                const mainFileDiv = document.createElement('div');
                mainFileDiv.className =
                    'flex items-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl mb-2 group cursor-pointer hover:bg-emerald-100 transition-all';
                mainFileDiv.onclick = () => window.open(`/storage/${responseDetail.archivo_res}`, '_blank');
                mainFileDiv.innerHTML = `
                    <span class="material-symbols-outlined text-emerald-600">description</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-bold text-emerald-900 dark:text-emerald-100 truncate">Documento Principal de Respuesta</p>
                        <p class="text-[9px] text-emerald-600 font-medium">Click para ver documento</p>
                    </div>
                    <span class="material-symbols-outlined text-emerald-400 text-sm group-hover:translate-x-0.5 transition-transform">open_in_new</span>
                `;
                previewContainer.appendChild(mainFileDiv);

                // Start page counting
                const folioInput = document.getElementById('salienteFolio');
                folioInput.value = '...';
                folioInput.disabled = true;

                try {
                    const pdfPath = `/storage/${responseDetail.archivo_res}`;
                    const loadingTask = pdfjsLib.getDocument(pdfPath);
                    const pdf = await loadingTask.promise;
                    folioInput.value = pdf.numPages;
                } catch (error) {
                    console.error('Error counting PDF pages:', error);
                    folioInput.value = 1;
                } finally {
                    folioInput.disabled = false;
                }
            }

            if (responseAnnexes.length > 0) {
                const annexGrid = document.createElement('div');
                annexGrid.className = 'grid grid-cols-1 gap-2';
                responseAnnexes.forEach((anexo, idx) => {
                    const div = document.createElement('div');
                    div.className =
                        'flex items-center gap-3 p-2.5 bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/50 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 transition-all group';
                    div.onclick = () => window.open(`/storage/${anexo.ruta_archivo}`, '_blank');
                    div.innerHTML = `
                        <span class="material-symbols-outlined text-gray-400 text-[18px]">attachment</span>
                        <p class="text-[10px] font-medium text-gray-600 dark:text-gray-300 truncate flex-1">${anexo.nombre_original || `Anexo ${idx + 1}`}</p>
                        <span class="material-symbols-outlined text-gray-300 text-sm group-hover:translate-x-0.5 transition-transform">visibility</span>
                    `;
                    annexGrid.appendChild(div);
                });
                previewContainer.appendChild(annexGrid);
            }

            // Set Notification Email
            const emailInput = document.getElementById('salienteEmailNotif');
            const emailContainer = document.getElementById('emailNotifContainer');
            if (c.correo_persona) {
                emailInput.value = c.correo_persona;
                emailContainer.classList.remove('hidden');
            } else {
                emailInput.value = '';
                emailContainer.classList.add('hidden');
            }

            openModal('salienteModal');
        }
    </script>
@endsection
<!-- Registrar Saliente Modal -->
<div id="salienteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
            onclick="closeModal('salienteModal')"></div>

        <div
            class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all font-display">
            <!-- Header -->
            <div
                class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-emerald-50/50 dark:bg-emerald-900/20">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <span class="material-symbols-outlined">outbox</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">Registrar
                            Saliente</h3>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Generar Radicado SAL-
                        </p>
                    </div>
                </div>
                <button onclick="closeModal('salienteModal')"
                    class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="salienteForm" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <!-- Destino -->
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Destino
                            / Institución</label>
                        <input type="text" name="destino" id="salienteDestino" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white"
                            placeholder="Nombre de la institución o persona destino">
                    </div>

                    <!-- Asunto -->
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Asunto</label>
                        <input type="text" name="asunto" id="salienteAsunto" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white"
                            placeholder="Asunto del envío">
                    </div>

                    <!-- Email de Notificación -->
                    <div id="emailNotifContainer" class="hidden">
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Correo de Notificación</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="material-symbols-outlined text-emerald-500 text-sm">mail</span>
                            </span>
                            <input type="email" id="salienteEmailNotif" disabled
                                class="w-full pl-10 pr-4 py-3 bg-emerald-50/30 dark:bg-emerald-900/10 border border-emerald-100/50 dark:border-emerald-800/50 rounded-2xl text-xs font-bold text-emerald-700 dark:text-emerald-400 cursor-not-allowed transition-all outline-none"
                                placeholder="No hay correo registrado">
                        </div>
                        <p class="text-[9px] text-gray-400 mt-1.5 px-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px]">info</span>
                            Se enviará un correo de notificación a esta dirección.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Tipo Envío -->
                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Tipo
                                de Envío</label>
                            <select name="id_tipo_envio" id="salienteTipo" required
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white appearance-none">
                                <option value="">Seleccionar...</option>
                                @foreach ($tipos as $t)
                                    <option value="{{ $t->id_tipo }}">{{ $t->tipo_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Folios -->
                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Folios</label>
                            <input type="text" name="folio" id="salienteFolio" required
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white">
                        </div>
                    </div>

                    <!-- Quien Envía -->
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 px-1">Funcionario
                            que envía</label>
                        <select name="doc_quien_envia" id="salienteFuncionario" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none dark:text-white appearance-none">
                            <option value="">Seleccionar funcionario...</option>
                            @foreach ($empleados as $e)
                                <option value="{{ $e->emple_doc }}">{{ $e->emple_nombres }}
                                    {{ $e->emple_apellidos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Preview Area -->
                    <div class="pt-2">
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Documentos
                            a enviar</label>
                        <div id="salienteFilePreview" class="space-y-2">
                            <!-- Dynamic Preview -->
                        </div>
                    </div>
                </div>

                <div
                    class="p-6 bg-gray-50/50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-700 flex gap-3">
                    <button type="button" onclick="closeModal('salienteModal')"
                        class="flex-1 px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-500 hover:text-gray-700 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="flex-[2] flex items-center justify-center gap-2 px-6 py-3 text-xs font-bold text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 dark:shadow-emerald-900/30 active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[18px]">done_all</span>
                        Registrar Envío Saliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@extends('empleado.layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- Header Page -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Hola
                    {{ auth()->user()->emple_nombres ?? 'Empleado' }} {{ auth()->user()->emple_apellidos ?? '' }}, tu área es
                    <span class="text-blue-700 dark:text-blue-500">{{ auth()->user()->area->area_nom ?? 'Sin Área' }}</span></h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Aquí tienes un resumen de la correspondencia mensual y tus tareas pendientes.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                    Mes en curso: <span
                        class="text-gray-900 dark:text-white font-bold">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </span>
            </div>
        </div>

        <!-- Monthly Report Stats (Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Ingresados este mes -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div
                    class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-blue-50 to-transparent dark:from-blue-900/20">
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Recibidos en el mes</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $recibidosMes }}</h3>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-2 flex items-center font-medium">
                            <span class="material-symbols-outlined text-[14px] mr-1">trending_up</span>
                            +12% vs mes anterior
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined">inbox</span>
                    </div>
                </div>
            </div>

            <!-- En Trámite / Asignados -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div
                    class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-yellow-50 to-transparent dark:from-yellow-900/20">
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tu Trámite Activo</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalTramiteActivo }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                            Asignados a tu área
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
            </div>

            <!-- Finalizados -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div
                    class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-green-50 to-transparent dark:from-green-900/20">
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Finalizados (Mes)</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalFinalizadosMes }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                            Resueltos este mes
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center text-green-600 dark:text-green-400">
                        <span class="material-symbols-outlined">task_alt</span>
                    </div>
                </div>
            </div>

            <!-- Alertas de Vencimiento -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div
                    class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-red-50 to-transparent dark:from-red-900/20">
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Próximos a Vencer</p>
                        <h3 class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $vencidas }}</h3>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-2 flex items-center font-medium">
                            <span class="material-symbols-outlined text-[14px] mr-1">warning</span>
                            Requieren atención urgente
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-red-600 dark:text-red-400 animate-pulse">
                        <span class="material-symbols-outlined">notifications_active</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Correspondencia por Responder / Nuevas (Take up 2 columns) -->
            <div
                class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col h-full">
                <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[20px]">mark_email_unread</span>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg dark:text-white">Notificaciones Pendientes</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Correspondencia sin responder o recién
                                llegada</p>
                        </div>
                    </div>
                    <span
                        class="bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 text-xs font-semibold px-2.5 py-1 rounded-full">
                        {{ $rechazosInternos->count() + $nuevasExternas->count() + $nuevasInternas->count() + $respuestasInternas->count() }}
                        pendientes
                    </span>
                </div>

                <div class="p-0 overflow-hidden flex-1">
                    <!-- List Items -->
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[500px] overflow-y-auto">

                        @forelse($rechazosInternos as $rechazo)
                            <!-- Rechazo Interno -->
                            <li
                                class="p-5 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors relative border-l-4 border-red-500">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex gap-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/40 flex-shrink-0 flex items-center justify-center text-red-600 dark:text-red-400">
                                            <span class="material-symbols-outlined">cancel</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-bold text-sm text-gray-900 dark:text-white">Correspondencia
                                                    Rechazada</h4>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rechazo</span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                Por: <strong>{{ $rechazo->quienRecibe->emple_nombres }}
                                                    {{ $rechazo->quienRecibe->emple_apellidos }}</strong>
                                            </p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
                                                {{ $rechazo->envio->asunto }}</p>
                                            <p class="text-xs text-red-600 dark:text-red-400 line-clamp-2">Motivo:
                                                {{ $rechazo->observaciones }}</p>

                                            <div class="mt-3 flex items-center gap-4 text-xs">
                                                <span
                                                    class="text-primary dark:text-blue-400 font-semibold flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">tag</span>
                                                    {{ $rechazo->envio->radicado->num_radicado ?? 'INT-S/R' }}
                                                </span>
                                                <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                    <span
                                                        class="material-symbols-outlined text-[14px]">calendar_month</span>
                                                    {{ $rechazo->fecha_traslado->format('d/m/Y h:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('empleado.correspondencia_recibida') }}?tab=interna"
                                            class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                                            Ver Detalle
                                        </a>
                                        <form
                                            action="{{ route('empleado.notificacion_visto', ['interna', $rechazo->id_detalle]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-700 hover:bg-green-100 dark:hover:bg-green-900/30 text-gray-500 hover:text-green-600 transition-colors"
                                                title="Marcar como leída">
                                                <span class="material-symbols-outlined text-[18px]">done_all</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @empty
                        @endforelse

                        @foreach ($nuevasExternas as $nueva)
                            <!-- Nueva Externa -->
                            <li
                                class="p-5 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors relative border-l-4 border-primary">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex gap-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex-shrink-0 flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined">inbox</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-bold text-sm text-gray-900 dark:text-white">Nueva
                                                    Correspondencia Externa</h4>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Nueva</span>
                                            </div>
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
                                                {{ $nueva->recibido->asunto }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">Procedencia:
                                                {{ $nueva->recibido->nom_institucion ?? $nueva->recibido->nombre_persona }}
                                            </p>

                                            <div class="mt-3 flex items-center gap-4 text-xs">
                                                <span
                                                    class="text-primary dark:text-blue-400 font-semibold flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">tag</span>
                                                    {{ $nueva->recibido->radicado->num_radicado ?? 'S/R' }}
                                                </span>
                                                <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                    {{ $nueva->fecha_re ? \Carbon\Carbon::parse($nueva->fecha_re)->diffForHumans() : 'Recientemente' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('empleado.correspondencia_recibida') }}"
                                            class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                                            Atender
                                        </a>
                                        <form
                                            action="{{ route('empleado.notificacion_visto', ['externa', $nueva->id_det_recibido]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-700 hover:bg-green-100 dark:hover:bg-green-900/30 text-gray-500 hover:text-green-600 transition-colors"
                                                title="Marcar como leída">
                                                <span class="material-symbols-outlined text-[18px]">done_all</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                        @foreach ($nuevasInternas as $nuevaInt)
                            <!-- Nueva Interna -->
                            <li
                                class="p-5 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors relative border-l-4 border-indigo-500">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex gap-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex-shrink-0 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                            <span class="material-symbols-outlined">forward_to_inbox</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-bold text-sm text-gray-900 dark:text-white">Nueva
                                                    Correspondencia Interna</h4>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400">Interna</span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                De: <strong>{{ $nuevaInt->quienEnvia->emple_nombres }}
                                                    {{ $nuevaInt->quienEnvia->emple_apellidos }}</strong>
                                            </p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
                                                {{ $nuevaInt->envio->asunto }}</p>

                                            <div class="mt-3 flex items-center gap-4 text-xs">
                                                <span
                                                    class="text-primary dark:text-blue-400 font-semibold flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">tag</span>
                                                    {{ $nuevaInt->envio->radicado->num_radicado ?? 'INT-S/R' }}
                                                </span>
                                                <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                    {{ $nuevaInt->fecha_traslado->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('empleado.correspondencia_recibida') }}?tab=interna"
                                            class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                                            Atender
                                        </a>
                                        <form
                                            action="{{ route('empleado.notificacion_visto', ['interna', $nuevaInt->id_detalle]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-700 hover:bg-green-100 dark:hover:bg-green-900/30 text-gray-500 hover:text-green-600 transition-colors"
                                                title="Marcar como leída">
                                                <span class="material-symbols-outlined text-[18px]">done_all</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                        @foreach ($respuestasInternas as $respuesta)
                            <!-- Respuesta/Archivado Interno para el Remitente -->
                            @php
                                $esArchivado = $respuesta->id_estado_rec == 10;
                                $borderColor = $esArchivado ? 'border-slate-400' : 'border-green-500';
                                $bgColor = $esArchivado
                                    ? 'bg-slate-100 dark:bg-slate-900/40'
                                    : 'bg-green-100 dark:bg-green-900/40';
                                $textColor = $esArchivado
                                    ? 'text-slate-600 dark:text-slate-400'
                                    : 'text-green-600 dark:text-green-400';
                                $icon = $esArchivado ? 'archive' : 'task_alt';
                                $badgeClass = $esArchivado
                                    ? 'bg-slate-100 text-slate-800 dark:bg-slate-900/30 dark:text-slate-400'
                                    : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                            @endphp
                            <li
                                class="p-5 hover:bg-gray-50 dark:hover:bg-gray-700/10 transition-colors relative border-l-4 {{ $borderColor }}">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex gap-4">
                                        <div
                                            class="w-10 h-10 rounded-full {{ $bgColor }} flex-shrink-0 flex items-center justify-center {{ $textColor }}">
                                            <span class="material-symbols-outlined">{{ $icon }}</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-bold text-sm text-gray-900 dark:text-white">
                                                    {{ $esArchivado ? 'Comunicado Archivado' : 'Correspondencia Resuelta' }}
                                                </h4>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium {{ $badgeClass }}">
                                                    {{ $esArchivado ? 'Archivado' : 'Finalizado' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                Por: <strong>{{ $respuesta->quienRecibe->emple_nombres }}
                                                    {{ $respuesta->quienRecibe->emple_apellidos }}</strong>
                                            </p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
                                                {{ $respuesta->envio->asunto }}</p>
                                            @if ($respuesta->observaciones)
                                                <p class="text-xs text-gray-600 dark:text-gray-400 italic line-clamp-2">
                                                    "{{ $respuesta->observaciones }}"</p>
                                            @endif

                                            <div class="mt-3 flex items-center gap-4 text-xs">
                                                <span
                                                    class="text-primary dark:text-blue-400 font-semibold flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">tag</span>
                                                    {{ $respuesta->envio->radicado->num_radicado ?? 'INT-S/R' }}
                                                </span>
                                                <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                    <span
                                                        class="material-symbols-outlined text-[14px]">calendar_month</span>
                                                    {{ $respuesta->fecha_traslado->format('d/m/Y h:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('empleado.historial_interna', $respuesta->id_detalle) }}"
                                            class="bg-blue-600 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                                            Ver Respuesta
                                        </a>
                                        <form
                                            action="{{ route('empleado.notificacion_visto', ['interna', $respuesta->id_detalle]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-700 hover:bg-green-100 dark:hover:bg-green-900/30 text-gray-500 hover:text-green-600 transition-colors"
                                                title="Marcar como leída">
                                                <span class="material-symbols-outlined text-[18px]">done_all</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                        @if (
                            count($rechazosInternos) === 0 &&
                                count($nuevasExternas) === 0 &&
                                count($nuevasInternas) === 0 &&
                                count($respuestasInternas) === 0)
                            <li class="p-10 text-center text-gray-500 dark:text-gray-400">
                                <span
                                    class="material-symbols-outlined text-5xl mb-3 block opacity-20">notifications_off</span>
                                <p>No tienes notificaciones pendientes.</p>
                            </li>
                        @endif
                    </ul>
                </div>
                <div
                    class="p-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800/50 text-center rounded-b-xl">
                    <a href="{{ route('empleado.correspondencia_recibida') }}"
                        class="text-sm font-medium text-primary dark:text-blue-400 hover:underline">Ver toda la
                        correspondencia</a>
                </div>
            </div>

            <!-- Right Side: Mini Reportes / Actividad Reciente (1 column) -->
            <div class="flex flex-col gap-6">

                <!-- Resumen Gráfico Mínimo -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-5">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Eficiencia Semanal</h3>

                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Respuestas a tiempo</span>
                                <span
                                    class="font-bold text-green-600 dark:text-green-400">{{ $eficiencia['a_tiempo_pct'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full"
                                    style="width: {{ $eficiencia['a_tiempo_pct'] }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Fuera de plazo</span>
                                <span
                                    class="font-bold text-red-600 dark:text-red-400">{{ $eficiencia['fuera_plazo_pct'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full"
                                    style="width: {{ $eficiencia['fuera_plazo_pct'] }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-900/50 text-center">
                        <span class="material-symbols-outlined text-blue-500 text-3xl mb-1">
                            {{ $eficiencia['total'] == 0 || $eficiencia['a_tiempo_pct'] >= 80 ? 'trophy' : 'timer' }}
                        </span>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ $eficiencia['total'] == 0 ? '¡Semana en curso!' : ($eficiencia['a_tiempo_pct'] >= 80 ? '¡Excelente Ritmo!' : 'Puedes Mejorar') }}
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            @if ($eficiencia['total'] == 0)
                                Aún no has finalizado correspondencia en esta semana.
                            @else
                                Has resuelto {{ $eficiencia['total'] }} documento(s) esta semana. El {{ $eficiencia['a_tiempo_pct'] }}% fue atendido a tiempo.
                    </div>
                </div>

                <!-- Actividad Reciente -->
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col h-full">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">history</span>
                            </div>
                            <h2 class="font-bold text-base text-gray-900 dark:text-white">Tu Actividad Reciente</h2>
                        </div>
                    </div>
                    <div class="p-0 overflow-y-auto max-h-[400px]">
                        @if(isset($actividad_reciente) && count($actividad_reciente) > 0)
                            <ul class="divide-y divide-gray-100 dark:divide-gray-700/50">
                                @foreach($actividad_reciente as $actividad)
                                    <li class="p-4 hover:bg-gray-50 dark:hover:bg-slate-800/80 transition-colors group cursor-pointer relative" onclick="window.location.href='{{ $actividad->url }}'">
                                        <!-- Tipo de Correspondencia Badge (Absoluto) -->
                                        <div class="absolute top-4 right-4">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold tracking-wide uppercase
                                                {{ $actividad->tipo === 'Interna' 
                                                    ? 'bg-indigo-50 text-indigo-600 border border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800' 
                                                    : 'bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800' }}">
                                                <span class="material-symbols-outlined text-[12px]">{{ $actividad->tipo === 'Interna' ? 'corporate_fare' : 'public' }}</span>
                                                {{ $actividad->tipo }}
                                            </span>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <!-- Icono Principal -->
                                            <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center
                                                {{ $actividad->tipo === 'Interna' ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-400' : 'bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400' }}">
                                                <span class="material-symbols-outlined text-[20px]">{{ $actividad->icon }}</span>
                                            </div>

                                            <div class="flex-1 min-w-0 pr-16 border-l pl-3 border-gray-100 dark:border-gray-700">
                                                <!-- Remitente/Entidad -->
                                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5 mt-0 flex items-center gap-1 truncate">
                                                    <span class="material-symbols-outlined text-[12px]">account_circle</span>
                                                    {{ $actividad->remitente }}
                                                </p>
                                                
                                                <!-- Asunto -->
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate mb-1 group-hover:text-primary transition-colors">
                                                    {{ $actividad->asunto }}
                                                </p>

                                                <!-- Meta inf (Radicado, Estado, Fecha) -->
                                                <div class="flex flex-wrap items-center gap-2 mt-2">
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-300 px-2 py-0.5 rounded-full">
                                                        <span class="material-symbols-outlined text-[12px]">tag</span>
                                                        {{ $actividad->radicado }}
                                                    </span>
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-green-50 text-green-600 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800 px-2 py-0.5 rounded-full">
                                                        <span class="material-symbols-outlined text-[12px]">info</span>
                                                        {{ $actividad->estado }}
                                                    </span>
                                                    <span class="text-[11px] text-gray-400 flex items-center gap-1 ml-auto">
                                                        <span class="material-symbols-outlined text-[12px]">schedule</span>
                                                        {{ \Carbon\Carbon::parse($actividad->fecha)->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="p-3 bg-gray-50/50 dark:bg-slate-800/30 text-center border-t border-gray-100 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                                <a href="{{ route('empleado.correspondencia_recibida') }}" class="text-xs font-semibold text-primary dark:text-blue-400 flex items-center justify-center gap-1">
                                    Ver toda la correspondencia
                                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </a>
                            </div>
                        @else
                            <div class="p-8 text-center flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-gray-50 dark:bg-slate-800 flex items-center justify-center mb-3">
                                    <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-3xl">history_toggle_off</span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">No hay actividad reciente.</p>
                                <p class="text-xs text-gray-400 mt-1">Los movimientos de correspondencia aparecerán aquí.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

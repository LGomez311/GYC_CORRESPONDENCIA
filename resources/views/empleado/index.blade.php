@extends('empleado.layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Hola, {{ auth()->user()->emple_nombres ?? 'Empleado' }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Aquí tienes un resumen de la correspondencia mensual y tus tareas pendientes.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                Mes en curso: <span class="text-gray-900 dark:text-white font-bold">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
            </span>
        </div>
    </div>

    <!-- Monthly Report Stats (Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Ingresados este mes -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-blue-50 to-transparent dark:from-blue-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Recibidos en el mes</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $recibidosMes }}</h3>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2 flex items-center font-medium">
                        <span class="material-symbols-outlined text-[14px] mr-1">trending_up</span>
                        +12% vs mes anterior
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <span class="material-symbols-outlined">inbox</span>
                </div>
            </div>
        </div>

        <!-- En Trámite / Asignados -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-yellow-50 to-transparent dark:from-yellow-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tu Trámite Activo</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalTramiteActivo }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                        <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                        Asignados a tu área
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
            </div>
        </div>

        <!-- Finalizados -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-green-50 to-transparent dark:from-green-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Finalizados (Mes)</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalFinalizadosMes }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        67% de eficiencia
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center text-green-600 dark:text-green-400">
                    <span class="material-symbols-outlined">task_alt</span>
                </div>
            </div>
        </div>

        <!-- Alertas de Vencimiento -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-red-50 to-transparent dark:from-red-900/20"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Próximos a Vencer</p>
                    <h3 class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $vencidas }}</h3>
                    <p class="text-xs text-red-600 dark:text-red-400 mt-2 flex items-center font-medium">
                        <span class="material-symbols-outlined text-[14px] mr-1">warning</span>
                        Requieren atención urgente
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-red-600 dark:text-red-400 animate-pulse">
                    <span class="material-symbols-outlined">notifications_active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Correspondencia por Responder / Nuevas (Take up 2 columns) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col h-full">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[20px]">mark_email_unread</span>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg dark:text-white">Notificaciones Pendientes</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Correspondencia sin responder o recién llegada</p>
                    </div>
                </div>
                <span class="bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 text-xs font-semibold px-2.5 py-1 rounded-full">
                    {{ $rechazosInternos->count() + $nuevasExternas->count() + $nuevasInternas->count() }} pendientes
                </span>
            </div>
            
            <div class="p-0 overflow-hidden flex-1">
                <!-- List Items -->
                <ul class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[500px] overflow-y-auto">
                    
                    @forelse($rechazosInternos as $rechazo)
                        <!-- Rechazo Interno -->
                        <li class="p-5 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors relative border-l-4 border-red-500">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/40 flex-shrink-0 flex items-center justify-center text-red-600 dark:text-red-400">
                                        <span class="material-symbols-outlined">cancel</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Correspondencia Rechazada</h4>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rechazo</span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            Por: <strong>{{ $rechazo->quienRecibe->emple_nombres }} {{ $rechazo->quienRecibe->emple_apellidos }}</strong>
                                        </p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">{{ $rechazo->envio->asunto }}</p>
                                        <p class="text-xs text-red-600 dark:text-red-400 line-clamp-2">Motivo: {{ $rechazo->observaciones }}</p>
                                        
                                        <div class="mt-3 flex items-center gap-4 text-xs">
                                            <span class="text-primary dark:text-blue-400 font-semibold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">tag</span>
                                                {{ $rechazo->envio->radicado->num_radicado ?? 'INT-S/R' }}
                                            </span>
                                            <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">calendar_month</span>
                                                {{ $rechazo->fecha_traslado->format('d/m/Y h:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('empleado.correspondencia_recibida') }}?tab=interna" class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                                        Ver Detalle
                                    </a>
                                    <form action="{{ route('empleado.notificacion_visto', ['interna', $rechazo->id_detalle]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-700 hover:bg-green-100 dark:hover:bg-green-900/30 text-gray-500 hover:text-green-600 transition-colors" title="Marcar como leída">
                                            <span class="material-symbols-outlined text-[18px]">done_all</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                    @endforelse

                    @foreach($nuevasExternas as $nueva)
                        <!-- Nueva Externa -->
                        <li class="p-5 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors relative border-l-4 border-primary">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex-shrink-0 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined">inbox</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Nueva Correspondencia Externa</h4>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Nueva</span>
                                        </div>
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">{{ $nueva->recibido->asunto }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">Procedencia: {{ $nueva->recibido->nom_institucion ?? $nueva->recibido->nombre_persona }}</p>
                                        
                                        <div class="mt-3 flex items-center gap-4 text-xs">
                                            <span class="text-primary dark:text-blue-400 font-semibold flex items-center gap-1">
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
                                    <a href="{{ route('empleado.correspondencia_recibida') }}" class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                                        Atender
                                    </a>
                                    <form action="{{ route('empleado.notificacion_visto', ['externa', $nueva->id_det_recibido]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-700 hover:bg-green-100 dark:hover:bg-green-900/30 text-gray-500 hover:text-green-600 transition-colors" title="Marcar como leída">
                                            <span class="material-symbols-outlined text-[18px]">done_all</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    @foreach($nuevasInternas as $nuevaInt)
                        <!-- Nueva Interna -->
                        <li class="p-5 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors relative border-l-4 border-indigo-500">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex-shrink-0 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                        <span class="material-symbols-outlined">forward_to_inbox</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Nueva Correspondencia Interna</h4>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400">Interna</span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            De: <strong>{{ $nuevaInt->quienEnvia->emple_nombres }} {{ $nuevaInt->quienEnvia->emple_apellidos }}</strong>
                                        </p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">{{ $nuevaInt->envio->asunto }}</p>
                                        
                                        <div class="mt-3 flex items-center gap-4 text-xs">
                                            <span class="text-primary dark:text-blue-400 font-semibold flex items-center gap-1">
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
                                    <a href="{{ route('empleado.correspondencia_recibida') }}?tab=interna" class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                                        Atender
                                    </a>
                                    <form action="{{ route('empleado.notificacion_visto', ['interna', $nuevaInt->id_detalle]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-slate-700 hover:bg-green-100 dark:hover:bg-green-900/30 text-gray-500 hover:text-green-600 transition-colors" title="Marcar como leída">
                                            <span class="material-symbols-outlined text-[18px]">done_all</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    @if($rechazosInternos->isEmpty() && $nuevasExternas->isEmpty() && $nuevasInternas->isEmpty())
                        <li class="p-10 text-center text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-5xl mb-3 block opacity-20">notifications_off</span>
                            <p>No tienes notificaciones pendientes.</p>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800/50 text-center rounded-b-xl">
                <a href="{{ route('empleado.correspondencia_recibida') }}" class="text-sm font-medium text-primary dark:text-blue-400 hover:underline">Ver toda la correspondencia</a>
            </div>
        </div>

        <!-- Right Side: Mini Reportes / Actividad Reciente (1 column) -->
        <div class="flex flex-col gap-6">
            
            <!-- Resumen Gráfico Mínimo -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-5">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Eficiencia Semanal</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Respuestas a tiempo</span>
                            <span class="font-bold text-green-600 dark:text-green-400">85%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Fuera de plazo</span>
                            <span class="font-bold text-red-600 dark:text-red-400">15%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: 15%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-900/50 text-center">
                    <span class="material-symbols-outlined text-blue-500 text-3xl mb-1">trophy</span>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">¡Buen Trabajo!</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Tu tiempo de respuesta promedio es de 2.4 días.</p>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-5 flex-1">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Últimas acciones</h3>
                
                <div class="space-y-4 relative before:absolute before:inset-0 before:ml-2 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 dark:before:via-gray-700 before:to-transparent">
                    
                    <!-- Acción 1 -->
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-4 h-4 rounded-full border-2 border-white dark:border-slate-800 bg-green-500 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow absolute left-0 md:left-1/2 -translate-x-1/2"></div>
                        <div class="w-[calc(100%-2rem)] md:w-[calc(50%-1.5rem)] ml-6 md:ml-0">
                            <div class="bg-gray-50 dark:bg-slate-800/80 p-3 rounded shadow-sm border border-gray-100 dark:border-gray-700">
                                <span class="font-bold text-xs text-green-600 dark:text-green-400">Tú</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400"> finalizaste el radicado </span>
                                <span class="font-medium text-xs dark:text-white">#RAD-2026-00120</span>
                                <div class="text-[10px] text-gray-400 mt-1">Hace 4 horas</div>
                            </div>
                        </div>
                    </div>

                    <!-- Acción 2 -->
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-4 h-4 rounded-full border-2 border-white dark:border-slate-800 bg-blue-500 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow absolute left-0 md:left-1/2 -translate-x-1/2"></div>
                        <div class="w-[calc(100%-2rem)] md:w-[calc(50%-1.5rem)] ml-6 md:ml-0 text-right">
                            <div class="bg-gray-50 dark:bg-slate-800/80 p-3 rounded shadow-sm border border-gray-100 dark:border-gray-700 text-left">
                                <span class="font-bold text-xs text-blue-600 dark:text-blue-400">Sistema</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400"> te asignó </span>
                                <span class="font-medium text-xs dark:text-white">#RAD-2026-00142</span>
                                <div class="text-[10px] text-gray-400 mt-1">Ayer a las 14:30</div>
                            </div>
                        </div>
                    </div>
                     <!-- Acción 3 -->
                     <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-4 h-4 rounded-full border-2 border-white dark:border-slate-800 bg-yellow-500 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow absolute left-0 md:left-1/2 -translate-x-1/2"></div>
                        <div class="w-[calc(100%-2rem)] md:w-[calc(50%-1.5rem)] ml-6 md:ml-0">
                            <div class="bg-gray-50 dark:bg-slate-800/80 p-3 rounded shadow-sm border border-gray-100 dark:border-gray-700">
                                <span class="font-bold text-xs text-yellow-600 dark:text-yellow-400">Tú</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400"> derivaste a Jurídica </span>
                                <span class="font-medium text-xs dark:text-white">#RAD-2026-00118</span>
                                <div class="text-[10px] text-gray-400 mt-1">2 de Marzo</div>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="mt-4 text-center">
                    <a href="#" class="text-xs text-primary dark:text-blue-400 hover:underline">Ver historial completo</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
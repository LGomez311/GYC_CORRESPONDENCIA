@extends('admin.layouts.app')

@section('title', 'Gestión de Estados')


@section('content')

<div class="p-4 md:p-8 space-y-8">

    {{-- License Info Card --}}
    <section>
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight">
                    Bienvenido,
                    <span class="text-primary">{{ Auth::user()->emple_nombres }} {{ Auth::user()->emple_apellidos }}</span>
                </h1>

                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base mt-1">
                    Estás logueado como <strong>{{ Auth::user()->rol->rol_nom }}</strong>. Desde aquí puedes administrar el sistema.
                </p>
            </div>

            <div class="hidden sm:flex items-center gap-4">
                <div class="text-sm text-[#4c669a] dark:text-gray-400">
                    {{ now()->format('d/m/Y') }}
                </div>
            </div>
        </div>
        <div
            class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 flex flex-col md:flex-row gap-6 items-center">

            <div class="size-20 bg-primary/10 rounded-xl flex items-center justify-center text-primary flex-shrink-0">
                <span class="material-symbols-outlined text-[40px]">verified_user</span>
            </div>

            <div class="flex-1 space-y-3 w-full">
                @if($licencia && $estaActiva)
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold">Días de licencia restantes</h2>
                            @if($nivelUrgencia === 'critico')
                                <p class="text-sm text-red-500 font-semibold">¡Tu licencia vence en {{ $tiempoRestante['dias'] }}d {{ $tiempoRestante['horas'] }}h {{ $tiempoRestante['minutos'] }}m!</p>
                            @elseif($nivelUrgencia === 'advertencia')
                                <p class="text-sm text-orange-500 font-semibold">Tu licencia vence pronto</p>
                            @else
                                <p class="text-sm text-slate-500">Su suscripción corporativa está activa</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div id="tiempoCounter" class="text-2xl font-bold {{ $nivelUrgencia === 'critico' ? 'text-red-500' : ($nivelUrgencia === 'advertencia' ? 'text-orange-500' : 'text-primary') }}">
                                <span>{{ $tiempoRestante['dias'] }}</span><span class="text-xs">d</span>
                                <span class="mx-1">{{ $tiempoRestante['horas'] }}</span><span class="text-xs">h</span>
                                <span class="mx-1">{{ $tiempoRestante['minutos'] }}</span><span class="text-xs">m</span>
                                <span class="mx-1">{{ $tiempoRestante['segundos'] }}</span><span class="text-xs">s</span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-3 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $nivelUrgencia === 'critico' ? 'bg-red-500' : ($nivelUrgencia === 'advertencia' ? 'bg-orange-500' : 'bg-primary') }}" style="width: {{ $porcentajeDiasRestantes }}%;"></div>
                    </div>

                    <div class="flex justify-between items-center">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">
                            Tiempo restante: {{ $porcentajeDiasRestantes }}% disponible
                        </p>
                        <a href="{{ route('admin.planes') }}"
                            class="bg-primary text-white text-xs font-bold px-4 py-1.5 rounded-lg hover:bg-primary/90 transition-colors uppercase">
                            Renovar ahora
                        </a>
                    </div>
                @else
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold">Licencia no activa</h2>
                            <p class="text-sm text-slate-500">No tienes una suscripción corporativa activa</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-red-500">Sin licencia</span>
                        </div>
                    </div>

                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-3 rounded-full overflow-hidden">
                        <div class="bg-red-500 h-full rounded-full" style="width: 0%;"></div>
                    </div>

                    <div class="flex justify-between items-center">
                        <p class="text-xs text-red-400 font-medium uppercase tracking-wider">
                            Requiere renovación inmediata
                        </p>
                        <a href="{{ route('admin.planes') }}"
                            class="bg-primary text-white text-xs font-bold px-4 py-1.5 rounded-lg hover:bg-primary/90 transition-colors uppercase">
                            Adquirir licencia
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            <a href="{{ route('admin.index') }}" class="group bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:border-primary transition-all">
                <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm dark:text-white">Usuarios</h3>
                    <p class="text-xs text-slate-400">Gestionar</p>
                </div>
            </a>
            <a href="{{ route('admin.correspondencia') }}" class="group bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:border-primary transition-all">
                <div class="size-10 bg-green-500/10 rounded-lg flex items-center justify-center text-green-500 group-hover:bg-green-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">mail</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm dark:text-white">Correspondencia</h3>
                    <p class="text-xs text-slate-400">Ver historial</p>
                </div>
            </a>
            <a href="{{ route('admin.planes') }}" class="group bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:border-primary transition-all">
                <div class="size-10 bg-purple-500/10 rounded-lg flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm dark:text-white">Planes</h3>
                    <p class="text-xs text-slate-400">Pagar suscripción</p>
                </div>
            </a>
            <a href="{{ route('admin.otros') }}" class="group bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:border-primary transition-all">
                <div class="size-10 bg-orange-500/10 rounded-lg flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">settings</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm dark:text-white">Otros</h3>
                    <p class="text-xs text-slate-400">Configuraciones</p>
                </div>
            </a>
        </div>
    </section>

    {{-- Stats Grid --}}
    @if($estaActiva)
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        @if($mensajeCorrespondencia)
            <div class="col-span-full bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">info</span>
                    <p class="text-yellow-800 dark:text-yellow-200 text-sm">{{ $mensajeCorrespondencia }}</p>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-slate-500 text-sm font-medium">Total</span>
                    <span class="material-symbols-outlined text-primary text-[20px]">inventory_2</span>
                </div>
                <div class="flex items-end gap-2">
                    <span class="text-2xl font-bold">{{ $totalCorrespondencia }}</span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Correspondencia total</p>
            </div>

            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-slate-500 text-sm font-medium">Pendientes</span>
                    <span class="material-symbols-outlined text-orange-500 text-[20px]">pending_actions</span>
                </div>
                <div class="flex items-end gap-2">
                    <span class="text-2xl font-bold">{{ $pendientes }}</span>
                    @if($pendientes > 0)
                        <span class="text-red-500 text-xs font-bold flex items-center mb-1">
                            <span class="material-symbols-outlined text-[14px]">priority_high</span>
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 mt-1">Requieren atención</p>
            </div>

            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-slate-500 text-sm font-medium">Recibidos</span>
                    <span class="material-symbols-outlined text-green-500 text-[20px]">move_to_inbox</span>
                </div>
                <div class="flex items-end gap-2">
                    <span class="text-2xl font-bold">{{ $recibidos }}</span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Entradas registradas</p>
            </div>

            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-slate-500 text-sm font-medium">Enviados</span>
                    <span class="material-symbols-outlined text-blue-500 text-[20px]">outbox</span>
                </div>
                <div class="flex items-end gap-2">
                    <span class="text-2xl font-bold">{{ $enviados }}</span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Salidas procesadas</p>
            </div>
        @endif

    </section>

    <!-- Actividad Reciente -->
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">history</span>
                <h3 class="font-bold text-lg dark:text-white">Actividad Reciente</h3>
            </div>
            <a href="{{ route('admin.correspondencia') }}" class="text-xs font-bold text-primary hover:underline">Ver Todo</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[11px] text-slate-400 uppercase bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-3 font-bold">Tipo / Remitente</th>
                        <th class="px-6 py-3 font-bold">Asunto</th>
                        <th class="px-6 py-3 font-bold">Radicado</th>
                        <th class="px-6 py-3 font-bold text-center">Estado</th>
                        <th class="px-6 py-3 font-bold text-right">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recientes as $reciente)
                        <tr onclick="window.location='{{ $reciente->url }}'" 
                            class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-lg flex items-center justify-center {{ $reciente->tipo == 'Interna' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                        <span class="material-symbols-outlined text-lg">{{ $reciente->icon }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] font-black uppercase text-slate-400 leading-none mb-1">{{ $reciente->tipo }}</span>
                                        <span class="block font-bold text-slate-700 dark:text-slate-200 truncate max-w-[150px]" title="{{ $reciente->remitente }}">
                                            {{ $reciente->remitente }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-slate-600 dark:text-gray-400 font-medium line-clamp-1 group-hover:text-primary transition-colors" title="{{ $reciente->asunto }}">
                                    {{ $reciente->asunto }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center gap-1.5 px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded font-mono text-[11px] text-slate-600 dark:text-slate-400 font-bold border border-slate-200 dark:border-slate-700">
                                    <span class="material-symbols-outlined text-[14px]">tag</span>
                                    {{ $reciente->radicado }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $estadoNomb = strtolower($reciente->estado);
                                    $badgeClass = 'bg-slate-100 text-slate-600';
                                    if (str_contains($estadoNomb, 'recibido') || str_contains($estadoNomb, 'espera')) {
                                        $badgeClass = 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300';
                                    } elseif (str_contains($estadoNomb, 'tramite') || str_contains($estadoNomb, 'trámite')) {
                                        $badgeClass = 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-300';
                                    } elseif (str_contains($estadoNomb, 'finalizado') || str_contains($estadoNomb, 'resuelto')) {
                                        $badgeClass = 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900/40 dark:text-green-300';
                                    } elseif (str_contains($estadoNomb, 'rechazado') || str_contains($estadoNomb, 'cancelado')) {
                                        $badgeClass = 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-300';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase border {{ $badgeClass }}">
                                    {{ $reciente->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex flex-col items-end">
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $reciente->fecha->format('d M, Y') }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase font-medium">{{ $reciente->fecha->diffForHumans() }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-slate-300 text-[48px] mb-2">inbox</span>
                                <p class="text-slate-500 font-medium">No hay actividad registrada recientemente.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @else
    <section class="w-full">
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
            <div class="flex items-center gap-4">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-[32px]">lock_clock</span>
                <div>
                    <h3 class="text-red-800 dark:text-red-200 font-semibold">Licencia no activa</h3>
                    <p class="text-red-700 dark:text-red-300 text-sm mt-1">La correspondencia está deshabilitada mientras tu licencia no esté activa.</p>
                    <a href="{{ route('admin.planes') }}" class="inline-block mt-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors">
                        Adquirir licencia
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

</div>

@if($licencia && $estaActiva)
<script>
    function actualizarContador() {
        const fechaFin = new Date('{{ $licencia->fecha_fin }}').getTime();
        const ahora = new Date().getTime();
        const diferencia = fechaFin - ahora;

        if (diferencia <= 0) {
            document.getElementById('tiempoCounter').textContent = '0d 0h 0m 0s';
            return;
        }

        const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
        const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
        const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

        document.getElementById('tiempoCounter').innerHTML = `
            <span>${dias}</span><span class="text-xs">d</span>
            <span class="mx-1">${horas}</span><span class="text-xs">h</span>
            <span class="mx-1">${minutos}</span><span class="text-xs">m</span>
            <span class="mx-1">${segundos}</span><span class="text-xs">s</span>
        `;
    }

    // Actualizar cada segundo
    actualizarContador();
    setInterval(actualizarContador, 1000);
</script>
@endif

@endsection
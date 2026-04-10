@extends('admin.layouts.app')

@section('title', 'Historial de Usuario - ' . $usuario->emple_nombres)

@section('content')
<div class="w-full max-w-7xl mx-auto p-4 md:px-6 lg:px-8 py-6">
    
    <!-- HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <a href="{{ route('admin.index') }}" class="p-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-gray-500">arrow_back</span>
                </a>
                <h1 class="text-[#0d121b] dark:text-white text-2xl font-black tracking-tight">
                    Historial de Correspondencia
                </h1>
            </div>
            <p class="text-[#4c669a] dark:text-gray-400 text-sm pl-12">
                Mostrando todos los movimientos de <strong>{{ $usuario->emple_nombres }} {{ $usuario->emple_apellidos }}</strong> ({{ $usuario->emple_doc }})
            </p>
        </div>
        
        <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                {{ substr($usuario->emple_nombres, 0, 1) }}
            </div>
            <div>
                <p class="text-xs text-[#4c669a] font-bold uppercase">{{ optional($usuario->rol)->rol_nom ?? 'Usuario' }}</p>
                <p class="text-sm font-bold dark:text-white">{{ $usuario->emple_nombres }} {{ $usuario->emple_apellidos }}</p>
            </div>
        </div>
    </div>

    <!-- TABLE / LIST -->
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm overflow-hidden min-h-[400px]">
        <div class="px-6 py-4 border-b border-[#cfd7e7] dark:border-gray-800 bg-slate-50/50 dark:bg-background-dark/20 flex items-center justify-between">
            <h2 class="text-lg font-bold text-[#0d121b] dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">timeline</span>
                Línea de Tiempo de Correspondencia
            </h2>
            <div class="text-xs font-bold text-[#4c669a] uppercase tracking-wider">
                {{ $correspondencia->count() }} Registros encontrados
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50 dark:bg-background-dark/50 border-b border-[#cfd7e7] dark:border-gray-800 uppercase text-[10px] font-bold text-[#4c669a] tracking-widest">
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Radicado</th>
                        <th class="px-6 py-4">Tipo</th>
                        <th class="px-6 py-4">Asunto / Resumen</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                    @forelse($correspondencia as $item)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $item->fecha_relevante->format('d/m/Y') }}
                                <span class="block text-xs text-[#4c669a] font-normal">{{ $item->fecha_relevante->format('h:i A') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-slate-100 dark:bg-gray-800 text-slate-700 dark:text-gray-300 rounded text-xs font-mono font-bold border border-slate-200 dark:border-gray-700">
                                    {{ $item->radicado->num_radicado ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded text-xs font-bold uppercase
                                    {{ $item->tipo_corresp == 'Externa' 
                                        ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' 
                                        : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' }}">
                                    <span class="material-symbols-outlined text-[14px]">
                                        {{ $item->tipo_corresp == 'Externa' ? 'inbox' : 'send' }}
                                    </span>
                                    {{ $item->tipo_corresp }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate max-w-xs">{{ $item->asunto }}</p>
                                <p class="text-xs text-[#4c669a] truncate max-w-xs">{{ $item->nom_institucion ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $est = $item->tipo_corresp == 'Externa' ? $item->estado : $item->estadoEnvio;
                                @endphp
                                @if($est)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border border-current opacity-80"
                                          style="color: {{ $est->id_estado == 9 ? '#10b981' : ($est->id_estado == 1 ? '#3b82f6' : '#64748b') }}">
                                        {{ $est->estado_nomb }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Sin estado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($item->tipo_corresp == 'Externa')
                                    <a href="{{ route('admin.correspondencia.historial_externa', $item->id_recibido) }}" 
                                       class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-all inline-flex items-center" title="Ver Detalle">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                @else
                                    <a href="{{ route('admin.correspondencia.historial_interna', $item->id_envio) }}" 
                                       class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-all inline-flex items-center" title="Ver Detalle">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="material-symbols-outlined text-gray-300 text-6xl">folder_off</span>
                                    <p class="text-gray-500 font-medium">No se encontró historial de correspondencia para este usuario.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

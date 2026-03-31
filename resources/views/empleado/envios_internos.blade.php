@extends('empleado.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-3xl text-primary">send</span>
                Mis Envíos Internos
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Consulta el estado y seguimiento de todos los comunicados que has enviado a otros colaboradores.
            </p>
        </div>
    </div>

    <!-- Filtros y Tabla -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-900/50 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-gray-800 dark:text-white text-sm uppercase tracking-wider">Listado de Correspondencia Enviada</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-slate-900/50 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 font-medium">Radicado</th>
                        <th class="px-6 py-3 font-medium">Asunto y Detalles</th>
                        <th class="px-6 py-3 font-medium">Fecha Envío</th>
                        <th class="px-6 py-3 font-medium">Destinatarios y Estado</th>
                        <th class="px-6 py-3 font-medium text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($envios as $envio)
                        @php
                            $primerDetalle = $envio->destinatarios_actuales->first();
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-primary dark:text-blue-400">
                                    {{ $envio->radicado->num_radicado ?? 'S/R' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900 dark:text-gray-100 max-w-[250px] truncate" title="{{ $envio->asunto }}">
                                    {{ $envio->asunto }}
                                </p>
                                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-tighter">
                                    {{ $envio->tipoEnvio->tipo_nombre ?? 'Interno' }} | Folios: {{ $envio->folio }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm dark:text-white">{{ $envio->fecha->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-500">{{ $envio->fecha->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center -space-x-2 overflow-hidden mb-2">
                                    @foreach($envio->destinatarios_actuales->take(3) as $dest)
                                        <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-slate-800 bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-[10px] font-bold" title="{{ $dest->quienRecibe->emple_nombres }}">
                                            {{ substr($dest->quienRecibe->emple_nombres, 0, 1) }}
                                        </div>
                                    @endforeach
                                    @if($envio->destinatarios_actuales->count() > 3)
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full ring-2 ring-white dark:ring-slate-800 bg-gray-100 dark:bg-gray-700 text-gray-500 text-[10px] font-bold">
                                            +{{ $envio->destinatarios_actuales->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-2 text-left">
                                    <button onclick="abrirModalDestinatarios({{ json_encode($envio->destinatarios_actuales->map(function($d){ 
                                        return [
                                            'nombre' => trim(($d->quienRecibe->emple_nombres ?? '') . ' ' . ($d->quienRecibe->emple_apellidos ?? '')),
                                            'doc' => $d->quienRecibe->emple_doc ?? 'N/A',
                                            'estado' => $d->estado?->estado_nomb ?? 'N/A',
                                            'area' => $d->quienRecibe->area->area_nom ?? 'Sin Área'
                                        ];
                                    })) }})" class="inline-flex items-center gap-1.5 text-[11px] text-primary hover:text-blue-700 bg-primary/10 hover:bg-primary/20 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-400 px-3 py-1.5 rounded-lg font-bold transition-colors w-fit shadow-sm">
                                        <span class="material-symbols-outlined text-[15px]">groups</span>
                                        Ver {{ $envio->destinatarios_actuales->count() }} destinatario(s) y estados
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($envio->destino === 'Ventanilla')
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-400 dark:bg-slate-700/50 dark:text-gray-500 rounded-lg text-xs font-bold cursor-not-allowed" title="Los envíos a Ventanilla no tienen trazabilidad interna">
                                        <span class="material-symbols-outlined text-[16px]">visibility_off</span>
                                        Sin Seguimiento
                                    </span>
                                @else
                                    <a href="{{ route('empleado.historial_interna', $primerDetalle->id_detalle ?? 0) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary/10 text-primary dark:bg-blue-900/20 dark:text-blue-400 rounded-lg text-xs font-bold hover:bg-primary hover:text-white transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        Ver Seguimiento
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <span class="material-symbols-outlined text-5xl mb-3 opacity-20">history_edu</span>
                                <p class="text-lg font-medium">No has enviado correspondencia interna aún.</p>
                                <p class="text-sm opacity-60">Tus envíos aparecerán aquí para que puedas rastrear su estado.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($envios->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-900/50">
                {{ $envios->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Destinatarios -->
<div id="modalDestinatarios" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl w-full max-w-md overflow-hidden flex flex-col">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-lg dark:text-white">Lista de Destinatarios</h3>
            <button onclick="cerrarModalDestinatarios()" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-4 overflow-y-auto max-h-[400px]">
            <ul id="listaDestinatariosModal" class="divide-y divide-gray-100 dark:divide-gray-800">
                <!-- Se inyecta por JS -->
            </ul>
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800/50 flex justify-end">
            <button onclick="cerrarModalDestinatarios()" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 dark:text-white rounded-lg text-sm font-medium hover:bg-gray-200">
                Cerrar
            </button>
        </div>
    </div>
</div>

<script>
function abrirModalDestinatarios(destinatarios) {
    const lista = document.getElementById('listaDestinatariosModal');
    lista.innerHTML = '';
    
    destinatarios.forEach(d => {
        const li = document.createElement('li');
        li.className = 'py-3 flex justify-between items-center';
        
        let dotClass = 'bg-gray-400';
        const estN = (d.estado || '').toLowerCase();
        if(estN.includes('recibido')) dotClass = 'bg-blue-500';
        else if(estN.includes('tramite')) dotClass = 'bg-yellow-500';
        else if(estN.includes('finalizado') || estN.includes('resuelto')) dotClass = 'bg-blue-500';

        li.innerHTML = `
            <div class="flex items-start gap-4 w-full">
                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex-shrink-0 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-sm shadow-inner">
                    ${d.nombre.charAt(0).toUpperCase()}
                </div>
                
                <!-- Info principal -->
                <div class="flex-1 min-w-0 flex flex-col justify-center">
                    <p class="text-sm font-bold text-gray-800 dark:text-white truncate" title="${d.nombre}">${d.nombre}</p>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-medium">Doc: <span class="text-gray-700 dark:text-gray-300">${d.doc}</span> • <span class="text-blue-600 dark:text-blue-400">${d.area}</span></p>
                </div>
                
                <!-- Estado flotante -->
                <div class="flex items-center flex-shrink-0">
                    <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-gray-700 shadow-sm">
                        <span class="w-2 h-2 rounded-full ${dotClass}"></span>
                        <span class="text-[10px] font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">${d.estado}</span>
                    </div>
                </div>
            </div>
        `;
        lista.appendChild(li);
    });
    
    document.getElementById('modalDestinatarios').classList.remove('hidden');
}

function cerrarModalDestinatarios() {
    document.getElementById('modalDestinatarios').classList.add('hidden');
}
</script>
@endsection

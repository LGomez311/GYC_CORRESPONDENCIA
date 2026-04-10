@extends('empleado.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- 
        ENCABEZADO DE LA SECCIÓN
        Muestra el título de la página y la descripción del módulo de envíos internos.
    -->
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

    <!-- 
        TABLA DE LISTADO Y FILTROS
        Visualiza todos los envíos realizados por el empleado con sus detalles principales, 
        destinatarios y acciones disponibles.
    -->
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
                                <button onclick="showHistory({{ $envio->id_envio }}, '{{ $envio->destino == 'Interno' ? 'interna' : 'saliente' }}')" 
                                   class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 p-1"
                                   title="Ver Trazabilidad">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
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

 <!-- 
    MODAL DE HISTORIAL (TRAZABILIDAD)
    Permite visualizar la línea de vida y los movimientos de un radicado específico en tiempo real.
 -->
<div id="historyModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 translate-z-0">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col border border-gray-100 dark:border-gray-800 animate-in fade-in zoom-in duration-200">
        <!-- Header -->
        <div class="p-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
            <div>
                <h3 class="font-bold text-xl text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    Historial de Correspondencia
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="historyRadicadoDisplay">Radicado: #---</p>
            </div>
            <button onclick="toggleModal('historyModal')" class="bg-white dark:bg-slate-800 text-gray-400 hover:text-red-500 hover:rotate-90 dark:hover:text-red-400 p-2 rounded-full transition-all duration-300 shadow-sm border border-gray-100 dark:border-gray-700">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <!-- Timeline Content -->
        <div class="p-6 overflow-y-auto flex-1 bg-white dark:bg-slate-900 scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-gray-800">
            <div class="relative ml-4 pl-8 border-l-2 border-dashed border-gray-200 dark:border-gray-800 space-y-10" id="timelineContainer">
                <!-- Se inyectará vía JS -->
            </div>
        </div>

        <!-- Footer -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-slate-800/50 flex justify-end">
            <button onclick="toggleModal('historyModal')" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-all shadow-sm">
                Cerrar Historial
            </button>
        </div>
    </div>
</div>
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

<!-- 
    SCRIPTS DE INTERACCIÓN
    Contiene la lógica JS para gestionar el historial (fetch a API) y mostrar detalles de destinatarios.
-->
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

    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.toggle('hidden');
        }
    }

    async function showHistory(id, modulo = 'externa') {
        const container = document.getElementById('timelineContainer');
        const radicadoDisplay = document.getElementById('historyRadicadoDisplay');
        const modal = document.getElementById('historyModal');

        // Reset and show loader
        container.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                <span class="material-symbols-outlined animate-spin text-4xl mb-4">sync</span>
                <p class="text-sm font-medium">Cargando línea de tiempo...</p>
            </div>
        `;
        radicadoDisplay.innerText = "Cargando...";
        modal.classList.remove('hidden');

        try {
            // Determinar URL según el módulo (Usando el endpoint unificado)
            let url = `/empleado/history/${id}?modulo=${modulo}`;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Error al obtener el historial');
            const data = await response.json();
            
            if (data.error) throw new Error(data.error);

            const history = data.history || [];
            const isResuelto = data.is_resuelto || false;
            const numRadicado = data.num_radicado || '---';

            if (!history || history.length === 0) {
                container.innerHTML = `<div class="text-center py-10 text-gray-500">No se encontró historial para este radicado.</div>`;
                return;
            }

            // Actualizar radicado en header
            radicadoDisplay.innerHTML = `<span class='font-bold text-primary'>Radicado: #${numRadicado}</span>`;

            let html = "";

            // Box de Proceso Consolidado (RICH UI)
            if (isResuelto) {
                html += `
                <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shrink-0 shadow-lg shadow-green-500/30">
                        <span class="material-symbols-outlined text-2xl font-bold">verified</span>
                    </div>
                    <div>
                        <h4 class="text-green-800 dark:text-green-300 font-bold text-base leading-tight uppercase tracking-tight">Trámite Finalizado</h4>
                        <p class="text-green-600 dark:text-green-400 text-xs mt-1 font-medium italic">Esta correspondencia ya se encuentra resuelta o finalizada en su totalidad. No requiere más gestiones.</p>
                    </div>
                </div>`;
            } else {
                html += `
                <div class="mb-8 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center text-white shrink-0 shadow-lg shadow-amber-500/30">
                        <span class="material-symbols-outlined text-2xl font-bold">pending_actions</span>
                    </div>
                    <div>
                        <h4 class="text-amber-800 dark:text-amber-300 font-bold text-base leading-tight uppercase tracking-tight">Seguimiento en Curso</h4>
                        <p class="text-amber-600 dark:text-amber-400 text-xs mt-1 font-medium italic">Esta correspondencia aún tiene respuestas pendientes por parte de algunos integrantes. Se encuentra en etapa de seguimiento.</p>
                    </div>
                </div>`;
            }

            history.forEach((entry, index) => {
                const isFirst = index === 0;
                const isLast = index === history.length - 1;
                
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
                <div class="relative">
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
                                <h4 class="text-sm font-bold ${textColor} group-hover:text-primary transition-colors">
                                    ${entry.nombres} ${entry.apellidos}
                                </h4>
                                ${entry.area_e ? `<p class="text-[10px] text-primary/70 font-bold uppercase mt-0.5 flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">business</span> ${entry.area_e}</p>` : ''}
                                
                                ${entry.observaciones ? `
                                <div class="mt-3 text-xs text-gray-600 dark:text-gray-400 leading-relaxed bg-white dark:bg-slate-900/50 p-3 rounded-xl border border-gray-100 dark:border-gray-800 italic">
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

            container.innerHTML = html;

        } catch (error) {
            console.error(error);
            container.innerHTML = `<div class="text-center py-10 text-red-500 font-medium flex flex-col items-center gap-2">
                <span class="material-symbols-outlined text-4xl">error</span>
                Error al cargar el historial: ${error.message}
            </div>`;
        }
    }

    function cerrarModalDestinatarios() {
        document.getElementById('modalDestinatarios').classList.add('hidden');
    }
</script>
@endsection

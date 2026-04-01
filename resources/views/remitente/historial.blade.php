@extends('remitente.layouts.app')

@section('title', 'Historial de Correspondencia')

@section('content')
<div class="flex flex-col flex-1 w-full bg-gray-50 dark:bg-gray-900 min-w-0">
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col p-6 min-w-0">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Historial de Correspondencia
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Consulta global de todos los documentos gestionados por Ventanilla.</p>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-6">
            <form method="GET" action="{{ route('remitente.historial') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2 relative">
                    <label class="text-xs font-bold text-gray-400 uppercase mb-1 block">Búsqueda General</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="material-symbols-outlined text-gray-400 text-sm">search</span>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary dark:text-white"
                            placeholder="Radicado, asunto, remitente...">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase mb-1 block">Fecha Desde</label>
                    <input type="date" name="desde" value="{{ request('desde') }}"
                        class="block w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary dark:text-white">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase mb-1 block">Fecha Hasta</label>
                    <input type="date" name="hasta" value="{{ request('hasta') }}"
                        class="block w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary dark:text-white">
                </div>
                <div class="md:col-span-4 flex justify-end gap-2 mt-2">
                    <a href="{{ route('remitente.historial') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">Limpiar</a>
                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-md">Filtrar Resultados</button>
                </div>
            </form>
        </div>

        <!-- Unified Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col flex-1">
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-900/30 border-b border-gray-100 dark:border-gray-800">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Radicado</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Tipo</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Asunto</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Origen/Destino</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Fecha</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Estado</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800/50">
                        @forelse($paginated as $item)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-all duration-200">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->radicado }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-lg bg-{{ $item->clase }}-50 dark:bg-{{ $item->clase }}-900/20 text-{{ $item->clase }}-600 font-bold text-[10px] uppercase border border-{{ $item->clase }}-100">
                                    {{ $item->tipo }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-1 max-w-md">{{ $item->asunto }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-400">
                                {{ $item->contacto }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->estado === 'RESUELTO' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $item->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button onclick="showHistory('{{ $item->rad_id }}', '{{ $item->radicado }}', '{{ $item->id_tipo_cor }}')" title="Ver Trazabilidad" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">timeline</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center text-gray-400 italic">No se encontraron registros en el historial.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-gray-100 dark:border-gray-700">
                {{ $paginated->links() }}
            </div>
        </div>
    </main>

    <!-- History Modal -->
    <div id="historyModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity duration-300" role="dialog" aria-modal="true">
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-2xl w-full max-w-xl transform scale-95 opacity-0 translate-y-4 transition-all duration-300 ease-out text-left">
            <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Historial de Movimientos</h3>
                    <p class="text-[10px] text-gray-500 font-bold mt-0.5" id="historyRadText"></p>
                </div>
                <button onclick="closeModal('historyModal')" class="p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-8 max-h-[60vh] overflow-y-auto bg-white dark:bg-gray-800">
                <div id="historyTimeline" class="relative">
                    <!-- History items will be injected here -->
                </div>
            </div>
            <div class="px-8 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20 flex justify-end">
                <button onclick="closeModal('historyModal')" class="px-6 py-2 text-xs font-bold text-gray-500 uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showHistory(id, radicadoText, tipoCor) {
        const modal = document.getElementById('historyModal');
        const timeline = document.getElementById('historyTimeline');
        const radText = document.getElementById('historyRadText');

        if (!modal || !timeline) {
            console.error('Modal elements not found');
            return;
        }

        radText.textContent = radicadoText ? `Radicado: ${radicadoText}` : 'Cargando trazabilidad...';
        timeline.innerHTML = '<div class="flex justify-center p-12"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div></div>';

        // Explicitly open the modal using the global helper
        if (window.openModal) {
            window.openModal('historyModal');
        } else {
            console.warn('Global openModal not found, using fallback');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        // Use absolute URL and include type to help backend find the correct Radicado ID
        const endpoint = `{{ url('/ventanilla/history') }}/${id}?type=${tipoCor}`;

        fetch(endpoint)
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw new Error(err.error || 'Error del servidor'); });
                }
                return res.json();
            })
            .then(data => {
                timeline.innerHTML = '';
                if (!data || data.length === 0) {
                    timeline.innerHTML = '<div class="py-10 text-center"><span class="material-symbols-outlined text-gray-300 text-4xl block mb-2">info</span><p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Sin trazabilidad registrada</p></div>';
                    return;
                }
                data.forEach((item, index) => {
                    const isLast = index === data.length - 1;
                    const date = new Date(item.fecha);
                    const dateStr = date.toLocaleDateString();
                    const timeStr = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    let icon = 'info';
                    let circleClass = 'bg-gray-100 text-gray-600';

                    if (item.type === 'registry') {
                        icon = 'edit_document';
                        circleClass = 'bg-blue-100 text-blue-600';
                    } else {
                        const state = parseInt(item.id_estado_rec || item.id_estado_envio || 0);
                        if (state === 7) { icon = 'mark_email_read'; circleClass = 'bg-green-100 text-green-600'; }
                        else if (state === 8) { icon = 'pending_actions'; circleClass = 'bg-amber-100 text-amber-600'; }
                        else if (state === 9 || state === 10) { icon = 'check_circle'; circleClass = 'bg-emerald-100 text-emerald-600'; }
                        else if (state === 11) { icon = 'cancel'; circleClass = 'bg-red-100 text-red-600'; }
                        else if (state === 12) { icon = 'send'; circleClass = 'bg-blue-100 text-blue-600'; }
                        else if (state === 14) { icon = 'outbox'; circleClass = 'bg-teal-100 text-teal-600'; }
                    }

                    const names = (item.nombres || '') + ' ' + (item.apellidos || '');
                    const avatar = item.img 
                        ? `<img src="/storage/${item.img}" class="w-8 h-8 rounded-full border border-white shadow-sm">`
                        : `<div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-[10px] font-bold border border-slate-200">${names.substring(0, 2).toUpperCase()}</div>`;

                    let html = '<div class="flex gap-4 ' + (!isLast ? 'pb-8' : '') + '">';
                    html += '<div class="flex flex-col items-center"><div class="w-10 h-10 rounded-full flex items-center justify-center shadow-sm ' + circleClass + '"><span class="material-symbols-outlined text-[18px]">' + icon + '</span></div>';
                    if (!isLast) html += '<div class="w-px h-full bg-gray-100 dark:bg-gray-800 my-1"></div>';
                    html += '</div>';
                    html += '<div class="flex-1 bg-gray-50/50 dark:bg-gray-900/30 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 hover:border-blue-200 transition-colors">';
                    html += '<div class="flex justify-between items-start mb-3"><div><h4 class="font-bold text-gray-900 dark:text-white text-sm">' + item.estado_nomb + '</h4>';
                    html += '<p class="text-[10px] text-gray-500 uppercase font-medium">' + dateStr + ' ' + timeStr + '</p></div>';
                    html += '<div class="flex items-center gap-2 bg-white dark:bg-gray-800 py-1 px-3 rounded-full shadow-sm border border-gray-50 dark:border-gray-700">' + avatar;
                    html += '<span class="text-[10px] font-black text-gray-700 dark:text-gray-300">' + names + '</span></div></div>';
                    html += '<div class="p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-50 dark:border-gray-700"><p class="text-sm text-gray-600 dark:text-gray-300">' + (item.observaciones || 'Registrado en sistema.') + '</p></div></div></div>';
                    
                    timeline.insertAdjacentHTML('beforeend', html);
                });
            })
            .catch(err => {
                console.error('History Fetch Error:', err);
                timeline.innerHTML = '<div class="p-6 text-center text-red-500 bg-red-50 rounded-2xl border border-red-100"><p class="font-bold text-sm">Error al obtener trazabilidad</p><p class="text-xs">' + err.message + '</p></div>';
            });
    }
</script>

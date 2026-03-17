@extends('admin.layouts.app')

@section('title', 'Consulta de Correspondencia')

@section('content')
    <div class="w-full max-w-7xl mx-auto p-4 md:px-6 lg:px-8 py-6">
        
        <!-- ================= HEADER ================= -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
            <div>
                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight mb-1">
                    Consulta de Correspondencia
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Vista detallada del historial de documentos vinculados a tu empresa.
                </p>
            </div>
            <div class="flex gap-3">
                <button onclick="openExportModalCor()"
                    class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Exportar
                </button>
            </div>
        </div>

                <!-- ================= EXTERNAL CORRESPONDENCE CONTAINER ================= -->
        <div class="bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm mb-8">
            
            <!-- Table Header / Search -->
            <div class="px-6 py-4 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-background-dark/20">
                <div>
                    <h2 class="text-lg font-bold text-[#0d121b] dark:text-white">Correspondencia Externa (Recibida)</h2>
                    <p class="text-xs text-[#4c669a] dark:text-gray-400">Documentos que provienen del exterior u otras instituciones.</p>
                </div>
                <div class="relative w-full md:w-96">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a] text-lg">search</span>
                    <input type="text" id="searchRecibidos" placeholder="Buscar por radicado o asunto..." 
                        class="pl-10 pr-4 py-2 bg-white dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm focus:outline-none focus:border-primary transition-all w-full shadow-sm">
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left min-w-full whitespace-nowrap responsive-table">
                    <thead>
                        <tr class="bg-slate-50/30 dark:bg-background-dark/10 border-b border-[#cfd7e7] dark:border-gray-800">
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Radicados</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Origen / Institución</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Asunto</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Destinatario</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Folios / Anexos</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableRecibidos" class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @forelse($recibidos as $cor)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors" 
                            data-search="{{ strtolower($cor->num_radicado_ext . ' ' . $cor->num_radicado_int . ' ' . $cor->asunto) }}">
                            <td class="px-6 py-4" data-label="Radicados">
                                <div class="flex flex-col">
                                    <span class="inline-flex items-center w-max px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $cor->origen == 'Interna' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-400' : 'bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-900/40 dark:text-fuchsia-400' }} mb-1">
                                        {{ $cor->origen }}
                                    </span>
                                    <span class="font-bold text-[#0d121b] dark:text-white">EXT: {{ $cor->num_radicado_ext }}</span>
                                    <span class="text-xs text-[#4c669a] font-mono">INT: {{ $cor->num_radicado_int }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Origen / Institución">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-gray-800 flex items-center justify-center text-[#4c669a] shrink-0">
                                        <span class="material-symbols-outlined text-[18px]">business</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold dark:text-white">{{ $cor->nom_institucion }}</span>
                                        <span class="text-xs text-[#4c669a]">{{ $cor->ciudad }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Asunto">
                                <div class="flex flex-col">
                                    <span class="text-sm text-[#0d121b] dark:text-white font-medium" title="{{ $cor->asunto }}">
                                        {{ $cor->asunto }}
                                    </span>
                                    <span class="text-xs text-[#4c669a]">{{ \Carbon\Carbon::parse($cor->fecha)->format('d M, Y H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Destinatario">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold dark:text-white">{{ $cor->destinatario_nombre }}</span>
                                    <span class="text-xs text-[#4c669a]">Doc: {{ $cor->doc_destinatario }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Folios / Anexos">
                                <div class="flex flex-col text-xs text-[#4c669a]">
                                    <span>Folios: {{ $cor->folio }}</span>
                                    <span>Anexos: {{ $cor->anexo ?? 'Ninguno' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Estado">
                                @php
                                    $estadoNom = $cor->estado_nomb;
                                    $bgColor = 'bg-slate-100 text-slate-700 dark:bg-gray-800 dark:text-gray-300';
                                    if(stripos($estadoNom, 'activo') !== false || stripos($estadoNom, 'radicado') !== false) {
                                        $bgColor = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400';
                                    } elseif(stripos($estadoNom, 'proceso') !== false || stripos($estadoNom, 'tramite') !== false) {
                                        $bgColor = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgColor }}">
                                    {{ $estadoNom }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right actions-cell" data-label="Acciones">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors btn-view-cor" title="Ver detalle"
                                        data-ext="{{ $cor->num_radicado_ext }}"
                                        data-int="{{ $cor->num_radicado_int }}"
                                        data-institucion="{{ $cor->nom_institucion }}"
                                        data-ciudad="{{ $cor->ciudad }}"
                                        data-asunto="{{ $cor->asunto }}"
                                        data-fecha="{{ \Carbon\Carbon::parse($cor->fecha)->format('d M, Y H:i') }}"
                                        data-destinatario="{{ $cor->destinatario_nombre }}"
                                        data-docdest="{{ $cor->doc_destinatario }}"
                                        data-folios="{{ $cor->folio }}"
                                        data-anexos="{{ $cor->anexo ?? 'Ninguno' }}"
                                        data-estado="{{ $estadoNom }}"
                                        data-archivo="{{ $cor->archivo ? asset('storage/' . $cor->archivo) : '' }}">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    @if($cor->archivo)
                                    <a href="{{ asset('storage/' . $cor->archivo) }}" target="_blank" class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Ver Archivo">
                                        <span class="material-symbols-outlined text-[20px]">description</span>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-[#cfd7e7] dark:text-gray-700 mb-2">mail</span>
                                    <p class="text-sm text-[#4c669a] dark:text-gray-400">No se encontraron registros de correspondencia externa.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-background-dark/30 border-t border-[#cfd7e7] dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-[#4c669a]">
                    Total: <span class="font-medium text-[#0d121b] dark:text-white">{{ count($recibidos) }}</span> registros vinculados
                </p>
                <div class="flex gap-2">
                    <button class="px-4 py-2 text-sm font-bold text-[#4c669a] bg-white dark:bg-gray-800 border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors disabled:opacity-50" disabled>
                        Anterior
                    </button>
                    <button class="px-4 py-2 text-sm font-bold text-[#4c669a] bg-white dark:bg-gray-800 border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors disabled:opacity-50" disabled>
                        Siguiente
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= INTERNAL CORRESPONDENCE CONTAINER ================= -->
        <div class="bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm mb-8">
            
            <!-- Table Header / Search -->
            <div class="px-6 py-4 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-background-dark/20">
                <div>
                    <h2 class="text-lg font-bold text-[#0d121b] dark:text-white">Correspondencia Interna (Enviada)</h2>
                    <p class="text-xs text-[#4c669a] dark:text-gray-400">Documentos generados internamente hacia otras dependencias o instituciones.</p>
                </div>
                <div class="relative w-full md:w-96">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a] text-lg">search</span>
                    <input type="text" id="searchEnvios" placeholder="Buscar por radicado o asunto..." 
                        class="pl-10 pr-4 py-2 bg-white dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm focus:outline-none focus:border-primary transition-all w-full shadow-sm">
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left min-w-full whitespace-nowrap responsive-table">
                    <thead>
                        <tr class="bg-slate-50/30 dark:bg-background-dark/10 border-b border-[#cfd7e7] dark:border-gray-800">
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Radicados</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Origen / Institución</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Asunto</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Destinatario</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Folios / Anexos</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableEnvios" class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @forelse($envios as $cor)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors" 
                            data-search="{{ strtolower($cor->num_radicado_int . ' ' . $cor->asunto . ' ' . $cor->destinatario_nombre) }}">
                            <td class="px-6 py-4" data-label="Radicados">
                                <div class="flex flex-col">
                                    <span class="inline-flex items-center w-max px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-400 mb-1">
                                        {{ $cor->origen }}
                                    </span>
                                    <span class="font-bold text-[#0d121b] dark:text-white">INT: {{ $cor->num_radicado_int }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Enviado por">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold dark:text-white">{{ $cor->registrado_por_nombre }}</span>
                                    <span class="text-xs text-[#4c669a]">Doc: {{ $cor->doc_registra }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Asunto">
                                <div class="flex flex-col">
                                    <span class="text-sm text-[#0d121b] dark:text-white font-medium" title="{{ $cor->asunto }}">
                                        {{ $cor->asunto }}
                                    </span>
                                    <span class="text-xs text-[#4c669a]">{{ \Carbon\Carbon::parse($cor->fecha)->format('d M, Y H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Destinatario">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold dark:text-white">{{ $cor->destinatario_nombre }}</span>
                                    <span class="text-xs text-[#4c669a]">Doc: {{ $cor->doc_destinatario ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Folios / Anexos">
                                <div class="flex flex-col text-xs text-[#4c669a]">
                                    <span>Folios: {{ $cor->folio }}</span>
                                    <span>Anexos: {{ $cor->anexo ?? 'Ninguno' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Estado">
                                @php
                                    $estadoNom = $cor->estado_nomb;
                                    $bgColor = 'bg-slate-100 text-slate-700 dark:bg-gray-800 dark:text-gray-300';
                                    if(stripos($estadoNom, 'activo') !== false || stripos($estadoNom, 'radicado') !== false || stripos($estadoNom, 'enviado') !== false) {
                                        $bgColor = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400';
                                    } elseif(stripos($estadoNom, 'proceso') !== false || stripos($estadoNom, 'tramite') !== false || stripos($estadoNom, 'pendiente') !== false) {
                                        $bgColor = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                                    } elseif(stripos($estadoNom, 'rechazado') !== false) {
                                        $bgColor = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgColor }}">
                                    {{ $estadoNom }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right actions-cell" data-label="Acciones">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors btn-view-cor" title="Ver detalle"
                                        data-ext="{{ $cor->num_radicado_ext }}"
                                        data-int="{{ $cor->num_radicado_int }}"
                                        data-institucion="{{ $cor->nom_institucion }}"
                                        data-ciudad="{{ $cor->ciudad }}"
                                        data-asunto="{{ $cor->asunto }}"
                                        data-fecha="{{ \Carbon\Carbon::parse($cor->fecha)->format('d M, Y H:i') }}"
                                        data-destinatario="{{ $cor->destinatario_nombre }}"
                                        data-docdest="{{ $cor->doc_destinatario ?? 'N/A' }}"
                                        data-folios="{{ $cor->folio }}"
                                        data-anexos="{{ $cor->anexo ?? 'Ninguno' }}"
                                        data-estado="{{ $estadoNom }}"
                                        data-archivo="{{ $cor->archivo ? asset('storage/' . $cor->archivo) : '' }}">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    @if($cor->archivo)
                                    <a href="{{ asset('storage/' . $cor->archivo) }}" target="_blank" class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Ver Archivo">
                                        <span class="material-symbols-outlined text-[20px]">description</span>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-[#cfd7e7] dark:text-gray-700 mb-2">mail</span>
                                    <p class="text-sm text-[#4c669a] dark:text-gray-400">No se encontraron registros de correspondencia interna.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-background-dark/30 border-t border-[#cfd7e7] dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-[#4c669a]">
                    Total: <span class="font-medium text-[#0d121b] dark:text-white">{{ count($envios) }}</span> registros vinculados
                </p>
                <div class="flex gap-2">
                    <button class="px-4 py-2 text-sm font-bold text-[#4c669a] bg-white dark:bg-gray-800 border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors disabled:opacity-50" disabled>
                        Anterior
                    </button>
                    <button class="px-4 py-2 text-sm font-bold text-[#4c669a] bg-white dark:bg-gray-800 border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors disabled:opacity-50" disabled>
                        Siguiente
                    </button>
                </div>
            </div>
            <div> 
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupSearch(inputId, tableBodyId) {
                const searchInput = document.getElementById(inputId);
                const tableBody = document.getElementById(tableBodyId);
                if (searchInput && tableBody) {
                    const rows = tableBody.querySelectorAll('tr[data-search]');
                    searchInput.addEventListener('input', function() {
                        const term = this.value.toLowerCase();
                        rows.forEach(row => {
                            const searchData = row.getAttribute('data-search');
                            if (searchData.includes(term)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });
                }
            }
            setupSearch('searchRecibidos', 'tableRecibidos');
            setupSearch('searchEnvios', 'tableEnvios');

            // MODAL DE DETALLES DE CORRESPONDENCIA
            const modalDetallesCor = document.getElementById('detallesCorModal');
            
            document.querySelectorAll('.btn-view-cor').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('detExt').textContent = btn.dataset.ext;
                    document.getElementById('detInt').textContent = btn.dataset.int;
                    document.getElementById('detInst').textContent = btn.dataset.institucion;
                    document.getElementById('detCiudad').textContent = btn.dataset.ciudad;
                    document.getElementById('detAsunto').textContent = btn.dataset.asunto;
                    document.getElementById('detFecha').textContent = btn.dataset.fecha;
                    document.getElementById('detDest').textContent = btn.dataset.destinatario;
                    document.getElementById('detDocDest').textContent = btn.dataset.docdest;
                    document.getElementById('detFolios').textContent = btn.dataset.folios;
                    document.getElementById('detAnexos').textContent = btn.dataset.anexos;
                    
                    const estado = btn.dataset.estado;
                    document.getElementById('detEstado').textContent = estado;

                    const btnArchivo = document.getElementById('detBtnArchivo');
                    if(btn.dataset.archivo) {
                        btnArchivo.href = btn.dataset.archivo;
                        btnArchivo.style.display = 'inline-flex';
                    } else {
                        btnArchivo.style.display = 'none';
                    }

                    modalDetallesCor.classList.remove('hidden');
                });
            });

            document.querySelectorAll('.btn-close-cor').forEach(btn => {
                btn.addEventListener('click', () => {
                    btn.closest('.fixed').classList.add('hidden');
                });
            });
        });
    </script>

    {{-- MODAL VER DETALLES CORRESPONDENCIA --}}
    <div id="detallesCorModal" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white dark:bg-[#161d2b] w-full max-w-2xl rounded-xl shadow-xl relative my-10 max-h-[90vh] flex flex-col overflow-hidden">
            <div class="px-6 pt-6 pb-4 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-[#0d121b] dark:text-white">Detalles de Correspondencia</h2>
                <button class="btn-close-cor text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto text-sm text-[#4c669a] dark:text-gray-300">
                <div class="flex flex-col md:flex-row gap-6 mb-6 items-start">
                    <div class="w-16 h-16 rounded-xl bg-slate-100 dark:bg-gray-800 flex-shrink-0 flex justify-center items-center border border-[#cfd7e7] dark:border-gray-700">
                        <span class="material-symbols-outlined text-3xl text-gray-400">mail</span>
                    </div>
                    <div class="flex flex-col gap-1 flex-1">
                        <h3 class="text-xl font-bold text-[#0d121b] dark:text-white" id="detAsunto">-</h3>
                        <p class="text-sm font-medium flex items-center gap-2 text-primary">EXT: <span id="detExt" class="font-bold">-</span> <span class="text-xs text-gray-400">|</span> INT: <span id="detInt" class="font-bold">-</span></p>
                        <p class="flex items-center gap-2 w-fit px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-lg text-xs font-semibold mt-1">
                            <span id="detEstado">-</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Institución / Origen</label>
                        <p class="text-base text-[#0d121b] dark:text-white font-medium break-all" id="detInst">-</p>
                        <p class="text-xs mt-0.5" id="detCiudad">-</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Fecha de Ingreso</label>
                        <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detFecha">-</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Destinatario (Dirigido a)</label>
                        <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detDest">-</p>
                        <p class="text-xs mt-0.5">Doc: <span id="detDocDest">-</span></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Documentos</label>
                        <p class="text-sm text-[#0d121b] dark:text-white font-medium">Folios: <span id="detFolios">-</span></p>
                        <p class="text-sm text-[#0d121b] dark:text-white font-medium">Anexos: <span id="detAnexos">-</span></p>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-center">
                    <a href="#" id="detBtnArchivo" target="_blank" class="px-4 py-2 bg-primary/10 text-primary border border-primary/20 rounded-lg flex items-center gap-2 hover:bg-primary hover:text-white transition-colors text-sm font-semibold" style="display:none;">
                        <span class="material-symbols-outlined text-[18px]">download</span> Ver Documento Adjunto
                    </a>
                </div>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800 flex justify-end">
                <button class="btn-close-cor px-6 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-colors font-medium">Cerrar</button>
            </div>
        </div>
    </div>

    {{-- MODAL EXPORTAR --}}
    <div id="exportModalCor" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5 relative">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                Exportar Correspondencia
            </h3>
            <div class="flex flex-col gap-3">
                <!-- PDF -->
                <a href="{{ route('admin.correspondencia.export.pdf') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 dark:text-white dark:border-gray-700 transition">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>
                <!-- Excel -->
                <a href="{{ route('admin.correspondencia.export.excel') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 dark:text-white dark:border-gray-700 transition">
                    <span class="material-symbols-outlined text-green-600">grid_on</span>
                    Excel
                </a>
            </div>
            <button onclick="closeExportModalCor()"
                class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium pb-1">
                Cancelar
            </button>
        </div>
    </div>

    <script>
        function openExportModalCor() {
            const modal = document.getElementById('exportModalCor');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeExportModalCor() {
            const modal = document.getElementById('exportModalCor');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection

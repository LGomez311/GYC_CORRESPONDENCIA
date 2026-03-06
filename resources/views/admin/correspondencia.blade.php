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
                <button
                    class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Exportar
                </button>
            </div>
        </div>

        <!-- ================= TABLE CONTAINER ================= -->
        <div class="bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm">
            
            <!-- Table Header / Search -->
            <div class="px-6 py-4 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-background-dark/20">
                <div>
                    <h2 class="text-lg font-bold text-[#0d121b] dark:text-white">Listado de Correspondencia</h2>
                    <p class="text-xs text-[#4c669a] dark:text-gray-400">Consulta radicado, asunto, remitente y destinatario.</p>
                </div>
                <div class="relative w-full md:w-96">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a] text-lg">search</span>
                    <input type="text" id="searchCorrespondence" placeholder="Buscar por radicado o asunto..." 
                        class="pl-10 pr-4 py-2 bg-white dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm focus:outline-none focus:border-primary transition-all w-full shadow-sm">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[1000px]">
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
                    <tbody id="tableCorrespondence" class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @forelse($correspondencias as $cor)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors" 
                            data-search="{{ strtolower($cor->num_radicado_ext . ' ' . $cor->num_radicado_int . ' ' . $cor->asunto) }}">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#0d121b] dark:text-white">EXT: {{ $cor->num_radicado_ext ?? 'N/A' }}</span>
                                    <span class="text-xs text-[#4c669a] font-mono">INT: {{ $cor->num_radicado_int }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-gray-800 flex items-center justify-center text-[#4c669a]">
                                        <span class="material-symbols-outlined text-[18px]">business</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold dark:text-white">{{ $cor->nom_institucion }}</span>
                                        <span class="text-xs text-[#4c669a]">{{ $cor->ciudad->ciudad_nom ?? $cor->ciudad_proveniente }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col max-w-xs">
                                    <span class="text-sm text-[#0d121b] dark:text-white font-medium truncate" title="{{ $cor->asunto }}">
                                        {{ $cor->asunto }}
                                    </span>
                                    <span class="text-xs text-[#4c669a]">{{ \Carbon\Carbon::parse($cor->fecha_hora_recib)->format('d M, Y H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold dark:text-white">{{ $cor->dirigidoA->emple_nombres ?? 'N/A' }} {{ $cor->dirigidoA->emple_apellidos ?? '' }}</span>
                                    <span class="text-xs text-[#4c669a]">Doc: {{ $cor->doc_quien_dirige }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col text-xs text-[#4c669a]">
                                    <span>Folios: {{ $cor->folio }}</span>
                                    <span class="truncate max-w-[120px]">Anexos: {{ $cor->anexo ?? 'Ninguno' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $estadoNom = $cor->estado->estado_nomb ?? 'Desconocido';
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
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Ver detalle">
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
                                    <p class="text-sm text-[#4c669a] dark:text-gray-400">No se encontraron registros de correspondencia.</p>
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
                    Total: <span class="font-medium text-[#0d121b] dark:text-white">{{ count($correspondencias) }}</span> registros vinculados
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchCorrespondence');
            const tableBody = document.getElementById('tableCorrespondence');
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
        });
    </script>
@endsection

@extends('admin.layouts.app')

@section('title', 'Gestión de Radicados')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

            <div>
                <div class="mb-3">
                    <a href="{{ route('admin.otros') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 
                    bg-white dark:bg-[#161d2b]
                    border border-[#cfd7e7] dark:border-gray-700
                    text-[#4c669a] dark:text-gray-300
                    rounded-lg text-sm font-medium
                    hover:bg-gray-100 dark:hover:bg-gray-800
                    transition-all duration-200">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Regresar
                    </a>
                </div>

                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight">
                    Gestión de Radicados
                </h1>

                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Administre los números de radicado y su estado asociado.
                </p>
            </div>

            <div class="w-full sm:w-auto mt-2 lg:mt-0"></div>
        </div>

        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">

            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Radicados Registrados</h2>
                <div class="flex gap-2">
                    <button onclick="openExportModal()"
                        class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Exportar
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">ID</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Número de Radicado</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Estado</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                        @foreach ($radicados as $r)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center dark:text-gray-300">{{ $r->id_radicado }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center font-bold text-[#0d121b] dark:text-white">{{ $r->num_radicado }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">{{ $r->estado->estado_nomb ?? 'N/A' }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="p-2 text-[#4c669a] hover:text-primary transition btn-view-radicado" title="Ver Detalle"
                                            data-id="{{ $r->id_radicado }}"
                                            data-num="{{ $r->num_radicado }}"
                                            data-estado="{{ $r->estado->estado_nomb ?? 'N/A' }}">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800">
                {{ $radicados->links() }}
            </div>

        </div>
    </div>
@endsection


@section('modals')

    <!-- MODAL CREAR -->
    <div id="createModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6">

            <h2 class="text-lg font-bold mb-4 dark:text-white">Crear Radicado</h2>

            <form action="{{ route('admin.radicado.store') }}" method="POST" id="createForm">
                @csrf
                <input type="hidden" name="form_type" value="create">

@section('modals')

    <!-- MODAL DETALLES RADICADO -->
    <div id="detallesRadicadoModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-[#161d2b] w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6 relative">
            <h2 class="text-lg font-bold mb-4 text-[#0d121b] dark:text-white border-b border-[#cfd7e7] dark:border-gray-800 pb-2">Detalles del Radicado</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider mb-1">ID Radicado</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detRadId">-</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider mb-1">Número de Radicado</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detRadNum">-</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider mb-1">Estado Actual</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detRadEstado">-</p>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-[#cfd7e7] dark:border-gray-800 flex justify-end">
                <button onclick="closeDetallesRadicadoModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-colors font-medium">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        function closeDetallesRadicadoModal() {
            const modal = document.getElementById('detallesRadicadoModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-view-radicado').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('detRadId').textContent = btn.dataset.id;
                    document.getElementById('detRadNum').textContent = btn.dataset.num;
                    document.getElementById('detRadEstado').textContent = btn.dataset.estado;
                    const modal = document.getElementById('detallesRadicadoModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });
        });
    </script>

    <!-- MODAL EXPORTAR -->
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <!-- Excel -->
                <a href="{{ route('admin.radicado.export.excel') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-green-600">grid_on</span>
                    Excel
                </a>

            </div>

            <button onclick="closeExportModal()"
                class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                Cancelar
            </button>

        </div>
    </div>

    <script>
        function openExportModal() {
            document.getElementById('exportModal').classList.remove('hidden');
            document.getElementById('exportModal').classList.add('flex');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.add('hidden');
            document.getElementById('exportModal').classList.remove('flex');
        }
    </script>
@endsection

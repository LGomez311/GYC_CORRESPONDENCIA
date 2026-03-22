@extends('admin.layouts.app')

@section('title', 'Panel de Pagos')

@section('content')


    <div class="p-4 md:p-8 max-w-7xl mx-auto w-full">

        {{-- HEADER --}}
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                    Historial de pagos
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">
                    Gestione y verifique los pagos de servicios realizados por las empresas.
                </p>
            </div>
        </div>

        {{-- TABLA --}}
        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Listado Detallado de Pagos</h2>
                <div class="flex gap-2">
                    <button onclick="openExportModal()"
                        class="px-3 py-1.5 text-xs font-bold border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-1 dark:text-white">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Exportar
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-full whitespace-nowrap responsive-table">

                    {{-- THEAD --}}
                        <thead class="bg-background-light dark:bg-background-dark/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">ID Pago</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Plan</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Pagado por</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Fecha de Pago</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Inicio de licencia</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Estado</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Comprobante</th>
                            </tr>
                        </thead>

                        {{-- TBODY --}}
                        <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                            @foreach ($pagos as $pago)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">

                                    {{-- ID PAGO --}}
                                    <td class="px-6 py-4 text-sm font-bold" data-label="ID Pago">
                                        {{ $pago->id_pago }}
                                    </td>

                                    {{-- PLAN --}}
                                    <td class="px-6 py-4 text-sm" data-label="Plan">
                                        {{ $pago->plan->nomb_plan }}
                                    </td>

                                    <td class="px-6 py-4 text-sm" data-label="Pagado por">
                                        <div class="flex flex-col">
                                            <span class="font-semibold">{{ $pago->admin?->emple_nombres }}
                                                {{ $pago->admin?->emple_apellidos }}</span>
                                            <span class="text-xs text-gray-500">{{ $pago->admin?->emple_correo }}</span>
                                        </div>
                                    </td>



                                    {{-- FECHA --}}
                                    <td class="px-6 py-4 text-sm" data-label="Fecha de Pago">
                                        <div class="flex flex-col">
                                            <span class="text-gray-500 text-xs">
                                                {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d') }}
                                            </span>
                                            <span class="text-gray-400 text-xs">
                                                {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('H:i:s') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm" data-label="Inicio de licencia">
                                        {{ $pago->fecha_inicio ? \Carbon\Carbon::parse($pago->fecha_inicio)->format('Y-m-d') : '—' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-bold" data-label="Estado">
                                        {{ $pago->estado->estado_nomb }}
                                    </td>

                                    <td class="px-6 py-4 actions-cell" data-label="Comprobante">
                                        @if($pago->ruta_archivo)
                                            <button
                                                class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-[#0d121b] dark:text-white text-xs font-bold rounded flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                                                onclick="abrirModal('{{ asset('storage/' . $pago->ruta_archivo) }}')">
                                                <span class="material-symbols-outlined text-sm">visibility</span> Ver
                                                Comprobante
                                            </button>
                                            @if($pago->motivo_rechazo)
                                                <div class="mt-2 text-xs text-red-600 dark:text-red-400 font-semibold max-w-xs break-words" title="{{ $pago->motivo_rechazo }}">
                                                    Motivo: {{ $pago->motivo_rechazo }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-500">No adjunto</span>
                                        @endif
                                    </td>



                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
                <div class="p-4 bg-slate-50 dark:bg-background-dark/30 border-t border-[#cfd7e7] dark:border-gray-800">
                    {{ $pagos->links('') }}
                </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('modalComprobante');
                const img = document.getElementById('imagenComprobante');
                const cerrar = document.getElementById('cerrarModal');

                window.abrirModal = function(rutaComprobante) {
                    if (!rutaComprobante) return;
                    img.src = rutaComprobante;
                    modal.classList.remove('hidden');
                }

                cerrar.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    img.src = '';
                });

                modal.addEventListener('click', function(e) {
                    if (e.target.id === 'modalComprobante') {
                        modal.classList.add('hidden');
                        img.src = '';
                    }
                });
            });
        </script>


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

    @section('modals')
        <!-- Modal -->
        <div id="modalComprobante"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg max-w-lg w-full p-4 relative">
                <!-- Botón cerrar -->
                <button id="cerrarModal"
                    class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    ✖
                </button>
                <!-- Imagen del comprobante -->
                <img id="imagenComprobante" src="" alt="Comprobante"
                    class="w-full max-h-[80vh] object-contain rounded">

            </div>
        </div>




        <!-- Modal Exportar -->
        <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

                <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                    Exportar como
                </h3>

                <div class="flex flex-col gap-3">
                    <!-- PDF -->
                    <a href="{{ route('pagos.export.pdf') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                        PDF
                    </a>

                    <!-- Excel -->
                    <a href="{{ route('pagos.export.excel') }}"
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


    @endsection

@extends('sadmin.layouts.app')

@section('title', 'Panel de Pagos')

@section('content')
<div class="p-8 max-w-7xl mx-auto w-full">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                Validación de Pagos
            </h1>
            <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">
                Gestione y verifique los pagos de servicios realizados por las empresas.
            </p>
        </div>
    </div>

    {{-- CONTENEDOR DE TABLA --}}
    <div
        class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

        {{-- HEADER TABLA --}}
        <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Listado de Pagos</h2>

            {{-- Botón Exportar --}}
            <button onclick="openExportModal()" class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                <span
                    class="material-symbols-outlined"
                    style="
                    font-size:14px;
                    line-height:1;
                    font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 20;">
                    download
                </span>
                Exportar
            </button>

            {{-- Modal Exportar --}}
            <div id="exportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5 relative">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Exportar como</h3>

                    <div class="flex flex-col gap-3">
                        <!-- PDF -->
                        <a href="{{ route('sadmin.pagos.export.pdf') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                            <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                            PDF
                        </a>

                        <!-- Excel -->
                        <a href="{{ route('sadmin.pagos.export.excel') }}"
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
        </div>

        {{-- TABLA --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">ID Pago</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Plan</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Pagado por</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Fecha Pago</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Inicio Licencia</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Comprobante</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Estado</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                    @forelse ($pagos as $pago)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-6 py-4 text-sm font-bold">{{ $pago->id_pago }}</td>
                        <td class="px-6 py-4 text-sm">{{ $pago->plan?->nomb_plan ?? 'Sin plan' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $pago->admin?->emple_nombres }}
                                    {{ $pago->admin?->emple_apellidos }}</span>
                                <span class="text-xs text-gray-500">
                                    {{ $pago->admin?->empresa?->nomb_empresa ?? 'Sin empresa' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $pago->fecha_pago ? \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $pago->fecha_inicio ? \Carbon\Carbon::parse($pago->fecha_inicio)->format('Y-m-d') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($pago->comprobante)
                            <button
                                class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-xs font-bold rounded hover:bg-gray-200"
                                onclick="abrirModal('{{ asset('storage/' . $pago->comprobante) }}')">
                                Ver comprobante
                            </button>
                            @else
                            <span class="text-gray-400 text-xs">No adjunto</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-bold">{{ $pago->estado?->estado_nomb ?? 'Sin estado' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($pago->estado?->estado_nomb === 'En espera')
                            <div class="flex justify-center gap-2">
                                <form action="{{ route('sadmin.pagos.aprobar', $pago->id_pago) }}"
                                    method="POST" class="form-aprobar">
                                    @csrf
                                    <button type="button"
                                        class="btn-aprobar px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded">
                                        Aprobar
                                    </button>
                                </form>

                                <form action="{{ route('sadmin.pagos.denegar', $pago->id_pago) }}"
                                    method="POST" class="form-denegar">
                                    @csrf
                                    <button type="button"
                                        class="btn-denegar px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded">
                                        Denegar
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-400 text-xs font-bold">Revisado</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-400">No hay pagos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINACIÓN --}}
            <div class="flex gap-1">
                {{ $pagos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

{{-- MODAL COMPROBANTE --}}
<div id="modalComprobante" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg max-w-lg w-full p-4 relative">
        <button id="cerrarModal"
            class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">✖</button>
        <img id="imagenComprobante" src="" alt="Comprobante" class="w-full max-h-[80vh] object-contain rounded">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Comprobante
        const modalComprobante = document.getElementById('modalComprobante');
        const imgComprobante = document.getElementById('imagenComprobante');
        const cerrarComprobante = document.getElementById('cerrarModal');

        window.abrirModal = function(ruta) {
            if (!ruta) return;
            imgComprobante.src = ruta;
            modalComprobante.classList.remove('hidden');
        }

        cerrarComprobante.addEventListener('click', function() {
            modalComprobante.classList.add('hidden');
            imgComprobante.src = '';
        });

        modalComprobante.addEventListener('click', function(e) {
            if (e.target === modalComprobante) {
                modalComprobante.classList.add('hidden');
                imgComprobante.src = '';
            }
        });

        // Modal Exportar
        const modalExport = document.getElementById('exportModal');

        window.openExportModal = function() {
            modalExport.classList.remove('hidden');
            modalExport.classList.add('flex');
        }

        window.closeExportModal = function() {
            modalExport.classList.add('hidden');
            modalExport.classList.remove('flex');
        }

        modalExport.addEventListener('click', function(e) {
            if (e.target.id === 'exportModal') closeExportModal();
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // CONFIRMAR APROBACIÓN
        document.querySelectorAll('.btn-aprobar').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: '¿Aprobar pago?',
                    text: "Esta acción activará la licencia del cliente.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, aprobar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // CONFIRMAR DENEGACIÓN
        document.querySelectorAll('.btn-denegar').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: '¿Denegar pago?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, denegar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

    });
</script>
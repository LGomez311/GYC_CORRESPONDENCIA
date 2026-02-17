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
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

        {{-- HEADER TABLA --}}
        <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Listado de Pagos</h2>
            <div class="flex gap-2">
                <button onclick="openExportModal()"
                    class="px-3 py-1.5 text-xs font-bold border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-1 dark:text-white">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Exportar
                </button>
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
                            <td class="px-6 py-4 text-sm">
                                <span class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $pago->plan?->nomb_plan ?? 'Sin plan' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col">
                                    <span class="font-semibold">
                                        {{ $pago->admin?->emple_nombres }} {{ $pago->admin?->emple_apellidos }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $pago->admin?->emple_correo }}
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
                                    <button class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-xs font-bold rounded hover:bg-gray-200"
                                            onclick="abrirModal('{{ asset('storage/'.$pago->comprobante) }}')">
                                        Ver comprobante
                                    </button>
                                @else
                                    <span class="text-gray-400 text-xs">No adjunto</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-bold">{{ $pago->estado?->estado_nomb ?? 'Sin estado' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($pago->estado?->estado_nomb === 'En espera')
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('sadmin.pagos.aprobar', $pago->id_pago) }}" method="POST">
                                            @csrf
                                            <button class="px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded">
                                                Aprobar
                                            </button>
                                        </form>

                                        <form action="{{ route('sadmin.pagos.denegar', $pago->id_pago) }}" method="POST">
                                            @csrf
                                            <button class="px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded">
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
                            <td colspan="8" class="text-center py-6 text-gray-400">
                                No hay pagos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINACIÓN --}}
            <div class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800 flex justify-center">
                {{ $pagos->links() }}
            </div>

        </div>
    </div>

</div>
@endsection

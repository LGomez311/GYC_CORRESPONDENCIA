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

    {{-- TABLA --}}
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                {{-- THEAD --}}
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


                {{-- TBODY --}}
                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                    @forelse ($pagos as $pago)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">

                        {{-- ID PAGO --}}
                        <td class="px-6 py-4 text-sm font-bold">
                            {{ $pago->id_pago }}
                        </td>

                        {{-- PLAN --}}
                        <td class="px-6 py-4 text-sm">
                            {{ $pago->plan?->nomb_plan ?? 'Sin plan' }}
                        </td>

                        {{-- ADMIN --}}
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-semibold">
                                    {{ $pago->admin?->emple_nombres }}
                                    {{ $pago->admin?->emple_apellidos }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    {{ $pago->admin?->emple_correo }}
                                </span>
                            </div>
                        </td>

                        {{-- FECHA PAGO --}}
                        <td class="px-6 py-4 text-sm">
                            {{ $pago->fecha_pago
            ? \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i')
            : '—' }}
                        </td>

                        {{-- FECHA INICIO --}}
                        <td class="px-6 py-4 text-sm">
                            {{ $pago->fecha_inicio
            ? \Carbon\Carbon::parse($pago->fecha_inicio)->format('Y-m-d')
            : '—' }}
                        </td>

                        {{-- COMPROBANTE --}}
                        <td class="px-6 py-4">
                            @if ($pago->comprobante)
                            <button
                                class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-xs font-bold rounded hover:bg-gray-200"
                                onclick="abrirModal('{{ asset('storage/'.$pago->comprobante) }}')">
                                Ver comprobante
                            </button>
                            @else
                            <span class="text-gray-400 text-xs">No adjunto</span>
                            @endif
                        </td>

                        {{-- ESTADO --}}
                        <td class="px-6 py-4 text-sm font-bold">
                            {{ $pago->estado?->estado_nomb ?? 'Sin estado' }}
                        </td>

                        {{-- ACCIONES --}}
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
            <div class="px-6 py-4 flex justify-center">
                {{ $pagos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
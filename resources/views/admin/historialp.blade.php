@extends('admin.layouts.app')

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
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    {{-- THEAD --}}
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">ID Pago</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Plan</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Monto</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Fecha de Pago</th>
                            <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Comprobante</th>
                        </tr>
                    </thead>

                    {{-- TBODY --}}
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                        {{-- @foreach ($pagos as $pago) --}}
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">

                                {{-- ID PAGO --}}
                                <td class="px-6 py-4 text-sm font-bold">
                                    {{-- {{ $pago->id_pago }} --}}
                                </td>

                                {{-- PLAN --}}
                                <td class="px-6 py-4 text-sm">

                                </td>

                                {{-- MONTO --}}
                                <td class="px-6 py-4 text-sm font-bold">
                                    {{-- {{ number_format($pago->monto, 2) }} --}}
                                </td>

                                {{-- FECHA --}}
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-col">
                                        <span class="text-gray-500 text-xs">
                                            {{-- {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d') }} --}}
                                        </span>
                                        <span class="text-gray-400 text-xs">
                                            {{-- {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('H:i:s') }} --}}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    {{-- <button
                                        class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-[#0d121b] dark:text-white text-xs font-bold rounded flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                                        onclick="abrirModal('{{ $pago->comprobante }}')">
                                        <span class="material-symbols-outlined text-sm">visibility</span> Ver Comprobante
                                    </button> --}}

                                </td>

                            </tr>
                            {{-- @empty --}}
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-400">
                                    No hay pagos registrados
                                </td>
                            </tr>
                        {{-- @endforeach --}}

                    </tbody>

                </table>
            </div>
        </div>
    </div>


@endsection

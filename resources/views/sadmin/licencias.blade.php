@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

@section('content')
<div class="p-8 max-w-7xl mx-auto w-full">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                Gestión de Licencias
            </h1>
            <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">
                Cree, gestione y active/desactive licencias para las empresas.
            </p>
        </div>
    </div>

    {{-- CONTENEDOR DE TABLA --}}
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

        {{-- HEADER TABLA --}}
        <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Listado de Licencias</h2>
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
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Empresa</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Plan</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Estado</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Inicio</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Fin</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Tipo de licencia</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                    @forelse($licencias as $licencia)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="px-6 py-4 text-sm font-bold">{{ $licencia->id_licencia }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col leading-tight">
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ $licencia->pago->admin->empresa->nomb_empresa ?? 'Empresa no encontrada' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        NIT: {{ $licencia->pago->admin->empresa->nit_empresa ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $licencia->pago->plan->nomb_plan ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold">{{ $licencia->estado->estado_nomb ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($licencia->fecha_inicio)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($licencia->fecha_fin)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $licencia->tipo_licencia }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('sadmin.licencias.toggle', $licencia->id_licencia) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1.5 rounded text-xs font-bold text-white
                                        {{ $licencia->id_estado == 1 ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} transition-colors shadow-sm">
                                        {{ $licencia->id_estado == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-400">
                                No hay licencias registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINACIÓN --}}
            <div class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800 flex justify-center">
                {{ $licencias->links() }}
            </div>

        </div>
    </div>

</div>
@endsection

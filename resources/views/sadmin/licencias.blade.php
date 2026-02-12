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

    {{-- FORMULARIO PARA CREAR LICENCIA --}}
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm mb-8 p-6">
        <form action="{{ route('sadmin.licencias.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- Empresa --}}
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-300 mb-1">Empresa (NIT)</label>
                    <input type="text" name="nit_empresa" class="w-full px-3 py-2 border rounded-lg text-sm dark:bg-[#1b2030] dark:border-gray-700 dark:text-gray-200" required>
                </div>

                {{-- Plan --}}
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-300 mb-1">Plan</label>
                    <select name="id_plan" class="w-full px-3 py-2 border rounded-lg text-sm dark:bg-[#1b2030] dark:border-gray-700 dark:text-gray-200" required>
                        <option value="">Seleccione un plan</option>
                        @foreach($planes as $plan)
                            <option value="{{ $plan->id_plan }}">{{ $plan->nomb_plan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Estado --}}
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-300 mb-1">Estado</label>
                    <select name="id_estado" class="w-full px-3 py-2 border rounded-lg text-sm dark:bg-[#1b2030] dark:border-gray-700 dark:text-gray-200" required>
                        <option value="">Seleccione un estado</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id_estado }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Pago --}}
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-300 mb-1">Pago</label>
                    <select name="id_pago" class="w-full px-3 py-2 border rounded-lg text-sm dark:bg-[#1b2030] dark:border-gray-700 dark:text-gray-200" required>
                        <option value="">Seleccione un pago</option>
                        @foreach($pagos as $pago)
                            <option value="{{ $pago->id_pago }}">#{{ $pago->id_pago }} - {{ $pago->nomb_plan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="mt-4 bg-primary text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition-colors shadow-sm">
                Crear Licencia
            </button>
        </form>
    </div>

    {{-- TABLA DE LICENCIAS --}}
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Empresa</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Plan</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Estado</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Pago</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Inicio</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Fin</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                    @forelse($licencias as $licencia)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="px-6 py-4 text-sm font-bold">{{ $licencia->id_licencia }}</td>
                            <td class="px-6 py-4 text-sm">{{ $licencia->nit_empresa }}</td>
                            <td class="px-6 py-4 text-sm">{{ $licencia->plan->nomb_plan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm font-bold">{{ $licencia->estado->nombre_estado ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $licencia->pago->nomb_plan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($licencia->fecha_inicio)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($licencia->fecha_fin)->format('Y-m-d') }}</td>
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
        </div>
    </div>

</div>
@endsection

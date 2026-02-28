@extends('admin.layouts.app')

@section('title', 'Panel de Admin de empresa')

@section('content')
    <div class="layout-content-container flex flex-col max-w-[1200px] flex-1 py-6 md:py-10 px-4 md:px-6">

        <!-- Page Heading -->
        <div class="flex flex-wrap justify-between gap-3 p-4 mb-8">
            <div class="flex flex-col gap-3">
                <h1 class="text-[#0d121b] dark:text-[#f8f9fc] text-4xl font-black tracking-tight">
                    Planes y Pago de Licencia
                </h1>
                <p class="text-[#4c669a] dark:text-[#a1b4d5] text-base">
                    Selecciona el plan que mejor se adapte a las necesidades de gestión de tu empresa.
                </p>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @foreach ($plans as $plan)
                <div
                    class="flex flex-col h-full min-h-[380px] p-6 transition
                    {{ $plan->es_destacado
                        ? 'relative scale-105 rounded-3xl border-2 border-primary bg-white shadow-2xl shadow-primary/10'
                        : 'rounded-2xl border border-[#cfd7e7] bg-white shadow-sm hover:shadow-xl' }}">

                    @if ($plan->es_destacado)
                        <div
                            class="absolute -top-4 left-1/2 -translate-x-1/2
               bg-primary text-white text-[10px] font-black uppercase
               tracking-widest px-4 py-1.5 rounded-full">
                            Más Popular
                        </div>
                    @endif


                    <!-- Plan Info -->
                    <div class="flex flex-col gap-2">
                        <h2 class="text-lg font-bold text-[#0d121b] dark:text-[#f8f9fc]">
                            {{ $plan->nomb_plan }}
                        </h2>

                        <div class="flex flex-col text-[#0d121b] dark:text-[#f8f9fc]">
                            <span
                                class="block text-4xl font-black
    {{ $plan->es_destacado ? 'text-primary' : 'text-[#0d121b]' }}">
                                ${{ number_format($plan->valor, 0, ',', '.') }}
                            </span>

                            <span class="text-sm font-semibold text-[#4c669a] dark:text-[#a1b4d5]">
                                {{ $plan->duracion }} días
                            </span>
                        </div>

                    </div>

                    <!-- Features -->
                    <div class="flex flex-col gap-3 mt-6 text-sm text-[#0d121b] dark:text-[#f8f9fc]">
                        @forelse ($plan->descripcion ?? [] as $beneficio)
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                {{ $beneficio }}
                            </div>
                        @empty
                            <span class="text-gray-400">
                                Este plan no tiene beneficios registrados
                            </span>
                        @endforelse
                    </div>




                    <!-- Button -->
                    <a href="{{ route('admin.pagos.index', $plan->id_plan) }}" class="mt-auto pt-4">
                        <button
                            class="w-full h-11 rounded-xl font-bold transition
                                {{ $plan->es_destacado
                                ? 'bg-primary text-white hover:bg-blue-700 shadow-lg shadow-primary/30'
                                : 'bg-[#e7ebf3] text-[#0d121b] hover:bg-primary hover:text-white' }}">
                            Seleccionar
                        </button>
                    </a>

                </div>
            @endforeach

        </div>
    </div>
@endsection

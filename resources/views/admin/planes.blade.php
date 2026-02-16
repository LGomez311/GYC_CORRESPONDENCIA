@extends('admin.layouts.app')

@section('title', 'Panel de Admin de empresa')

@section('content')
    <div class="layout-content-container flex flex-col max-w-[1200px] flex-1 py-10 px-6">

        <!-- Page Heading -->
        <div class="flex flex-wrap justify-between gap-3 p-4 mb-8">
            <div class="flex min-w-72 flex-col gap-3">
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
                    class="flex flex-col justify-between rounded-xl border border-[#cfd7e7] dark:border-[#2c3444]
                bg-white dark:bg-[#1a2130] p-6 shadow-sm hover:shadow-lg transition-shadow">

                    <!-- Plan Info -->
                    <div class="flex flex-col gap-2">
                        <h2 class="text-lg font-bold text-[#0d121b] dark:text-[#f8f9fc]">
                            {{ $plan->nomb_plan }}
                        </h2>

                        <div class="flex flex-col text-[#0d121b] dark:text-[#f8f9fc]">
                            <span class="text-4xl font-black leading-none">
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
                    <a href="{{ route('admin.pagos.index', $plan->id_plan) }}" class="mt-6">
                        <button
                            class="w-full h-10 rounded-lg bg-[#e7ebf3] dark:bg-[#2c3444]
                        text-[#0d121b] dark:text-[#f8f9fc] text-sm font-bold
                        hover:bg-primary hover:text-white transition-colors">
                            Seleccionar
                        </button>
                    </a>

                </div>
            @endforeach

        </div>
    </div>
@endsection

@extends('admin.layouts.app')


@section('title', 'Panel de Admin de empresa')
<!-- Main Content -->
@section('content')

    <div class="layout-content-container flex flex-col max-w-[1024px] flex-1 py-10 px-6">
        <!-- PageHeading -->
        <div class="flex flex-wrap justify-between gap-3 p-4 mb-6">
            <div class="flex min-w-72 flex-col gap-3">
                <h1 class="text-[#0d121b] dark:text-[#f8f9fc] text-4xl font-black leading-tight tracking-[-0.033em]">
                    Planes y Pago de Licencia</h1>
                <p class="text-[#4c669a] dark:text-[#a1b4d5] text-base font-normal leading-normal">
                    Selecciona el plan que mejor se adapte a las necesidades de gestión de tu empresa.</p>
            </div>
        </div>
        <!-- PricingCards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 py-3 mb-10">
            <!-- Plan Básico -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 py-3 mb-10">
                @foreach ($planes as $plan)
                    <div
                        class="flex flex-1 flex-col gap-4 rounded-xl 
            {{ $plan->destacado ? 'border-2 border-primary scale-105 shadow-lg' : 'border border-[#cfd7e7] shadow-sm' }}
            bg-white dark:bg-[#1a2130] p-6 relative transition-all">

                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-between">
                                <h2 class="text-[#0d121b] dark:text-[#f8f9fc] text-base font-bold">
                                    {{ $plan->nombre }}
                                </h2>

                                @if ($plan->destacado)
                                    <span
                                        class="text-white text-[10px] font-bold uppercase rounded-full bg-primary px-3 py-1">
                                        Recomendado
                                    </span>
                                @endif
                            </div>

                            <p class="flex items-baseline gap-1 text-[#0d121b] dark:text-[#f8f9fc]">
                                <span class="text-4xl font-black">${{ $plan->precio }}</span>
                                <span class="text-base font-bold">/mes</span>
                            </p>
                        </div>

                        <button
                            class="flex w-full items-center justify-center rounded-lg h-10 px-4
                {{ $plan->destacado ? 'bg-primary text-white' : 'bg-[#e7ebf3] dark:bg-[#2c3444]' }}
                text-sm font-bold">
                            Seleccionar
                        </button>

                        <div class="flex flex-col gap-3 mt-2 text-[#0d121b] dark:text-[#f8f9fc] text-[13px]">
                            {!! $plan->descripcion !!}
                        </div>
                    </div>
                @endforeach
            </div>


        </div>


    </div>


@endsection

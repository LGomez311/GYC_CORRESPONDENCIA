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
        <!-- Pri
                    
                    
                    cingCards -->


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 py-3 mb-10">

            @foreach ($plans as $plan)
                <div
                    class="flex flex-1 flex-col gap-4 rounded-xl border border-solid border-[#cfd7e7]
                   dark:border-[#2c3444] bg-white dark:bg-[#1a2130] p-6 shadow-sm
                   hover:shadow-md transition-shadow">

                    <div class="flex flex-col gap-1">
                        <h2 class="text-[#0d121b] dark:text-[#f8f9fc] text-base font-bold leading-tight">
                            {{ $plan->nomb_plan }}
                        </h2>

                        <p class="flex items-baseline gap-1 text-[#0d121b] dark:text-[#f8f9fc]">
                            <span class="text-4xl font-black">$ {{ $plan->valor }} </span>
                            <span class="text-base font-bold">/{{ $plan->duracion }} Dias</span>
                        </p>
                    </div>

                    <a href="{{ route('admin.pagos.index', $plan->id_plan) }}"
                        class="flex w-full items-center justify-center rounded-lg h-10 px-4
          bg-[#e7ebf3] dark:bg-[#2c3444]
          text-sm font-bold hover:border-primary/50 border-2 border-transparent">
                        Seleccionar
                    </a>

                    <div class="flex flex-col gap-3 mt-2 text-[13px] text-[#0d121b] dark:text-[#f8f9fc]">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            {{ $plan->descripcion }}
                        </div>
                    </div>

                </div>
            @endforeach

        </div>



    </div>


@endsection

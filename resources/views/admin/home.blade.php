@extends('admin.layouts.app')

@section('title', 'Inicio Admin')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight">
                    Bienvenido,
                    <span class="text-primary">{{ auth()->user()->emple_nombres }} {{ auth()->user()->emple_apellidos }}</span>
                </h1>

                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base mt-1">
                    Estás logueado como <strong>{{ auth()->user()->rol->rol_nom }}</strong>. Desde aquí puedes administrar el sistema.
                </p>
            </div>

            <div class="hidden sm:flex items-center gap-4">
                <div class="text-sm text-[#4c669a] dark:text-gray-400">
                    {{ now()->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-[#0d121b] dark:text-white mb-2">Información rápida</h3>
                <p class="text-sm text-[#4c669a] dark:text-gray-400">Accede a usuarios, planes y otros módulos desde la barra lateral.</p>
            </div>

            <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-[#0d121b] dark:text-white mb-2">Empresa</h3>
                <p class="text-sm text-[#4c669a] dark:text-gray-400">{{ auth()->user()->empresa->nomb_empresa ?? 'Sin empresa asignada' }}</p>
            </div>

            <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-[#0d121b] dark:text-white mb-2">Rol</h3>
                <p class="text-sm text-[#4c669a] dark:text-gray-400">{{ auth()->user()->rol->rol_nom }}</p>
            </div>
        </div>

    </div>
@endsection

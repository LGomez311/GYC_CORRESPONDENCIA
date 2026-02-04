@extends('sadmin.layouts.app')

@section('title', 'Panel de Usuarios')

@section('content')

    <div class="p-8 max-w-7xl mx-auto w-full">
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                    Gestión de Admins de Empresas</h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">Controle el acceso y gestione
                    los perfiles de administradores para cada organización.</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Crear Nuevo Admin
                </button>
            </div>
        </div>
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Administradores de
                    Empresas</h2>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1.5 text-xs font-bold border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-1 dark:text-white">
                        <span class="material-symbols-outlined text-sm">filter_list</span> Filtrar
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Nombre del Administrador</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Empresa Asociada</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Correo Electrónico</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Última Conexión</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Estado</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-right">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center overflow-hidden">
                                            <img alt="Avatar" class="w-full h-full object-cover"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAa9FqhbkbST6hYirkz22qcwuAL73VZgZw5SggCU4OJbc_kPlQmbfF6hNcaicJjtoPA_bSunEoT2olLz73oIHi8uYZyq0cRpQMGdZ3biETy3e-N7V0x-ZUcEUjPOfCjxff2LptzPfKqKNleEcKG-KEBxU7VM9qlqD9H6sF8Magu06qaUZqvqAFo4qTFiBAzIs1rhLYsz3pgUsddPBYUftR90hOEujnMQb_y6Q09Qi-Zoku2znxJ8_hcRoLh8UKjSnsJgXe3A-owXKI" />
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-[#0d121b] dark:text-white">{{ $user->emple_nombres }} {{ $user->emple_apellidos }}
                                                </span>
                                            <span class="text-xs text-[#4c669a] dark:text-gray-400">DOCUMENTO:
                                                {{ $user->emple_doc }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-[#0d121b] dark:text-gray-300">Global Tech
                                        Solutions</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30"></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-[#0d121b] dark:text-gray-300">Hoy, 10:45
                                            AM</span>
                                        <span class="text-[10px] text-[#4c669a]">IP: 192.168.1.45</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Activo
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                            title="Ver detalles">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                            title="Editar">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            <div class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800 flex items-center justify-between">
                <p class="text-xs text-[#4c669a] dark:text-gray-400">Mostrando 4 de 28 administradores
                    registrados</p>
                <div class="flex gap-1">
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button
                        class="size-8 flex items-center justify-center rounded bg-primary text-white font-bold text-xs">1</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 text-xs">2</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 text-xs">3</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

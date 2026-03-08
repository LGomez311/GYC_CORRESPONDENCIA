@extends('remitente.layouts.app')


@section('title', 'Panel de Remitente')
<!-- Main Content -->
@section('content')

    <div class="flex h-screen w-full">
        <!-- Main Content Area -->
        <main class="flex-1 flex overflow-hidden">
            <!-- Central Content Column -->
            <div class="flex-1 flex flex-col p-6 overflow-y-auto">
                <!-- PageHeading -->
                <div class="flex flex-wrap justify-between gap-3">
                    <h1 class="text-gray-900 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">
                        Gestión de Correspondencia</h1>
                </div>
                <!-- Search and Filters -->
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <!-- SearchBar -->
                    <div class="flex-grow">
                        <label class="flex flex-col min-w-40 h-12 w-full">
                            <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                                <div
                                    class="text-gray-500 dark:text-gray-400 flex border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                                    <span class="material-symbols-outlined">search</span>
                                </div>
                                <input
                                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                                    placeholder="Buscar por asunto, remitente..." value="" />
                            </div>
                        </label>
                    </div>
                    <!-- Chips -->
                    <div class="flex gap-3 items-center">
                        <button
                            class="flex h-12 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Interna/Externa
                            </p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button>
                        <button
                            class="flex h-12 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Estado</p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button>
                        <button
                            class="flex h-12 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Prioridad</p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button>
                    </div>
                </div>
                <!-- Tabs & Content -->
                <div class="mt-6">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <div class="flex px-4 gap-8">
                            <a class="flex items-center justify-center gap-2 border-b-[3px] border-b-primary text-primary pb-[13px] pt-4"
                                href="#">
                                <p class="text-sm font-bold leading-normal tracking-[0.015em]">Correspondencia Entrante
                                </p>
                                <span
                                    class="flex items-center justify-center text-xs font-bold text-white bg-red-500 rounded-full size-5">3</span>
                            </a>
                            <a class="flex items-center justify-center border-b-[3px] border-b-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 pb-[13px] pt-4"
                                href="#">
                                <p class="text-sm font-bold leading-normal tracking-[0.015em]">Correspondencia Saliente
                                </p>
                            </a>
                        </div>
                    </div>
                    <!-- Correspondence Table -->
                    <div
                        class="mt-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 font-bold" scope="col">Asunto</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Remitente</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Fecha</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Estado</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Prioridad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Solicitud de Propuesta Comercial</td>
                                    <td class="px-6 py-4">Innovatech Solutions</td>
                                    <td class="px-6 py-4">15 Oct, 2023</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Pendiente</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Urgente</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Informe Trimestral de Ventas</td>
                                    <td class="px-6 py-4">Contabilidad Interna</td>
                                    <td class="px-6 py-4">14 Oct, 2023</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Recibido</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Media</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Confirmación de Reunión de Proyecto</td>
                                    <td class="px-6 py-4">Cliente Corp</td>
                                    <td class="px-6 py-4">13 Oct, 2023</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Recibido</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Normal</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Invitación a Webinar de Marketing</td>
                                    <td class="px-6 py-4">Partner Agency</td>
                                    <td class="px-6 py-4">12 Oct, 2023</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Pendiente</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Normal</span>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <div class="flex gap-1">
                            {{-- {{ $correspondencias->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Sidebar for Actions -->
            <div
                class="w-80 border-l border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 flex flex-col gap-6">
                <!-- Action Buttons -->
                <div class="flex flex-col gap-4">
                    <button
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-white bg-primary rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/30">
                        <span class="material-symbols-outlined">add_circle</span>
                        Registrar Entrante
                    </button>
                    <button
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-primary bg-primary/10 rounded-lg hover:bg-primary/20 focus:outline-none focus:ring-4 focus:ring-primary/30">
                        <span class="material-symbols-outlined">edit</span>
                        Crear Saliente
                    </button>
                </div>
                <!-- Summary/Stats -->
                <div class="flex flex-col gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendientes de Acción</h3>
                        <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">5</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Recibidos Hoy</h3>
                        <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">12</p>
                    </div>
                </div>
                <!-- Preview Panel -->
                <div class="flex flex-col gap-4 flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Vista Previa</h3>
                    <div
                        class="flex-1 p-4 border border-gray-200 dark:border-gray-700 rounded-xl bg-background-light dark:bg-background-dark flex flex-col">
                        <h4 class="font-bold text-gray-900 dark:text-white">Solicitud de Propuesta...</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">De: Innovatech Solutions</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha: 15 Oct, 2023</p>
                        <hr class="my-3 border-gray-200 dark:border-gray-700" />
                        <p class="text-sm text-gray-600 dark:text-gray-300 flex-1">Estimados, nos dirigimos a ustedes
                            para solicitar una propuesta comercial detallada para los servicios de consultoría...</p>
                        <a class="mt-auto text-sm font-bold text-primary hover:underline" href="#">Ver detalles
                            completos</a>
                    </div>
                </div>
            </div>
        </main>
    </div>


@endsection

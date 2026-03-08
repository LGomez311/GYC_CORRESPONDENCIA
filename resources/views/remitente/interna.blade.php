@extends('remitente.layouts.app')


@section('title', 'Panel de Remitente')
<!-- Main Content -->
@section('content')


    <div class="flex h-screen w-full">
        
        <main class="flex-1 flex overflow-hidden">
            <div class="flex-1 flex flex-col p-6 overflow-y-auto">
                <div class="flex flex-wrap justify-between gap-3">
                    <h1 class="text-gray-900 dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">
                        Correspondencia Interna Enviada</h1>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-grow">
                        <label class="flex flex-col min-w-40 h-10 w-full">
                            <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                                <div
                                    class="text-gray-500 dark:text-gray-400 flex border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                                    <span class="material-symbols-outlined">search</span>
                                </div>
                                <input
                                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal"
                                    placeholder="Buscar documento..." value="" />
                            </div>
                        </label>
                    </div>
                    <div class="flex gap-3 items-center">
                        <button
                            class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <span
                                class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">filter_list</span>
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Prioridad</p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button>
                        <button
                            class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <span
                                class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">description</span>
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Tipo de
                                Documento</p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button>
                    </div>
                </div>
                <div
                    class="mt-6 flex-1 flex flex-col bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 sticky top-0">
                                <tr>
                                    <th class="px-6 py-3 font-bold w-12 text-center" scope="col">Tipo</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Asunto</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Remitente</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Fecha de Recepción</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Prioridad</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-blue-50/50 dark:bg-blue-900/10 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-blue-500">picture_as_pdf</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Contrato de Arrendamiento 2024</td>
                                    <td class="px-6 py-4">Inmobiliaria Central S.A.</td>
                                    <td class="px-6 py-4">24 Oct, 2023 - 09:30 AM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Alta</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Pendiente</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-green-500">description</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Factura Mensual Servicios IT</td>
                                    <td class="px-6 py-4">TechSolutions S.R.L.</td>
                                    <td class="px-6 py-4">23 Oct, 2023 - 14:15 PM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Media</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Leído</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-gray-500">mail</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Invitación Evento Anual</td>
                                    <td class="px-6 py-4">Cámara de Comercio</td>
                                    <td class="px-6 py-4">22 Oct, 2023 - 11:00 AM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Baja</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200 text-xs font-medium px-2.5 py-0.5 rounded-full">Archivado</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-blue-500">picture_as_pdf</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Propuesta Diseño Web</td>
                                    <td class="px-6 py-4">Creative Studio</td>
                                    <td class="px-6 py-4">21 Oct, 2023 - 16:45 PM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Media</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Pendiente</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-yellow-500">folder_zip</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Archivos de Proyecto Q3</td>
                                    <td class="px-6 py-4">Depto. Marketing (Interno)</td>
                                    <td class="px-6 py-4">20 Oct, 2023 - 08:20 AM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Alta</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Leído</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-green-500">description</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Cotización Equipos Oficina</td>
                                    <td class="px-6 py-4">Office Depot S.A.</td>
                                    <td class="px-6 py-4">19 Oct, 2023 - 10:10 AM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Baja</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Pendiente</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700">
                        <nav aria-label="Table navigation" class="flex items-center justify-between p-4">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Mostrando <span
                                    class="font-semibold text-gray-900 dark:text-white">1-6</span> de <span
                                    class="font-semibold text-gray-900 dark:text-white">45</span></span>
                            <ul class="inline-flex -space-x-px text-sm h-8">
                                <li><a class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        href="#">Anterior</a></li>
                                <li><a aria-current="page"
                                        class="flex items-center justify-center px-3 h-8 text-primary bg-primary/10 border border-primary hover:bg-primary/20 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                                        href="#">1</a></li>
                                <li><a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        href="#">2</a></li>
                                <li><a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        href="#">3</a></li>
                                <li><a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        href="#">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div
                class="w-80 border-l border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-col h-full overflow-hidden">
                <div class="p-6 flex flex-col h-full">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Detalle del Documento</h2>
                    <div class="flex-1 overflow-y-auto mb-6">
                        <div
                            class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="material-symbols-outlined text-blue-500 text-3xl">picture_as_pdf</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white text-base leading-tight">
                                        Contrato de Arrendamiento 2024</h3>
                                    <p class="text-xs text-gray-500 mt-1">ID: #DOC-84729</p>
                                </div>
                            </div>
                            <div class="space-y-3 mt-4">
                                <div class="flex flex-col">
                                    <span
                                        class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Remitente</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Inmobiliaria
                                        Central S.A.</span>
                                    <span class="text-xs text-gray-500">contacto@inmobiliariacentral.com</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Fecha
                                        de Recepción</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">24 Oct, 2023 -
                                        09:30 AM</span>
                                </div>
                                <div class="flex gap-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Prioridad</span>
                                        <span
                                            class="mt-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2 py-0.5 rounded w-max">Alta</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Estado</span>
                                        <span
                                            class="mt-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2 py-0.5 rounded w-max">Pendiente</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4 border-gray-200 dark:border-gray-700" />
                            <div class="flex flex-col">
                                <span
                                    class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-2">Mensaje
                                    / Resumen</span>
                                <p
                                    class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed bg-white dark:bg-gray-800 p-3 rounded border border-gray-200 dark:border-gray-700">
                                    Adjunto enviamos el contrato de arrendamiento para las nuevas oficinas ubicadas en
                                    el centro financiero. Por favor revisar las cláusulas 4 y 7 referentes a
                                    modificaciones estructurales. Requiere firma antes del fin de mes.
                                </p>
                            </div>
                            <button
                                class="mt-4 w-full flex items-center justify-center gap-2 px-3 py-2 text-sm font-medium text-primary bg-primary/5 rounded-lg border border-primary/20 hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                Abrir Documento Completo
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 mt-auto pt-4 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Acciones
                            Rápidas</span>
                        <button
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-primary rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/30 shadow-sm transition-all">
                            <span class="material-symbols-outlined text-base">assignment_ind</span>
                            Asignar a Departamento
                        </button>
                        <button
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-300 dark:text-gray-200 dark:bg-gray-800 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 transition-all">
                            <span class="material-symbols-outlined text-base">archive</span>
                            Archivar Documento
                        </button>
                        <button
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-green-700 bg-green-50 border border-green-200 dark:text-green-300 dark:bg-green-900/20 dark:border-green-800 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 focus:outline-none transition-all">
                            <span class="material-symbols-outlined text-base">mark_email_read</span>
                            Marcar como Leído
                        </button>
                    </div>
                </div>
            </div>
        


@endsection
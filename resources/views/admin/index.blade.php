@extends('admin.layouts.app')


@section('title', 'Panel de Admin de empresa')
<!-- Main Content -->
@section('content')

<div class="mx-auto flex w-full max-w-7xl flex-col">
    <!-- PageHeading -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Gestión de
                Usuarios</h1>
            <p class="text-gray-500 dark:text-gray-400 text-base font-normal">Añade, edita o elimina
                usuarios del sistema.</p>
        </div>
        <button
            class="flex items-center justify-center gap-2 overflow-hidden rounded-lg bg-primary h-10 px-5 text-white text-sm font-bold leading-normal tracking-wide shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
            <span class="material-symbols-outlined text-xl">add</span>
            <span class="truncate">Añadir Nuevo Usuario</span>
        </button>
    </div>
    <!-- Toolbar & Filters -->
    <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-center">
        <!-- SearchBar -->
        <div class="flex-1">
            <label class="flex w-full flex-col">
                <div class="relative flex h-12 w-full flex-1 items-stretch">
                    <div class="text-gray-400 absolute left-0 top-0 flex h-full items-center justify-center pl-4">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                    <input
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-background-dark py-2.5 pl-12 pr-4 text-gray-900 dark:text-white focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 placeholder:text-gray-400 h-full text-base"
                        placeholder="Buscar por nombre, correo..." value="" />
                </div>
            </label>
        </div>
        <!-- Chips/Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <button
                class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark px-4 hover:bg-gray-50 dark:hover:bg-gray-800">
                <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Rol</p>
                <span class="material-symbols-outlined text-gray-500 text-xl">expand_more</span>
            </button>
            <button
                class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark px-4 hover:bg-gray-50 dark:hover:bg-gray-800">
                <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Estado
                </p>
                <span class="material-symbols-outlined text-gray-500 text-xl">expand_more</span>
            </button>
        </div>
    </div>
    <!-- User Data Table -->
    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-600 dark:text-gray-300 sm:pl-6"
                            scope="col"><input
                                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                type="checkbox" /></th>
                        <th class="px-3 py-3.5 text-left font-semibold text-gray-600 dark:text-gray-300" scope="col">
                            Nombre</th>
                        <th class="px-3 py-3.5 text-left font-semibold text-gray-600 dark:text-gray-300" scope="col">
                            Correo Electrónico</th>
                        <th class="px-3 py-3.5 text-left font-semibold text-gray-600 dark:text-gray-300" scope="col">
                            Rol</th>
                        <th class="px-3 py-3.5 text-left font-semibold text-gray-600 dark:text-gray-300" scope="col">
                            Estado</th>
                        <th class="px-3 py-3.5 text-left font-semibold text-gray-600 dark:text-gray-300" scope="col">
                            Fecha de Creación</th>
                        <th class="relative py-3.5 pl-3 pr-4 sm:pr-6" scope="col"><span
                                class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800 bg-white dark:bg-background-dark">
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6"><input
                                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                type="checkbox" /></td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-800 dark:text-gray-200">Ana
                            Pérez</td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400">
                            ana.perez@empresa.com</td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400"><span
                                class="inline-flex items-center rounded-full bg-blue-50 dark:bg-blue-900/40 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-300 ring-1 ring-inset ring-blue-600/20">Administrador</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400"><span
                                class="inline-flex items-center rounded-full bg-green-50 dark:bg-green-900/40 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20">Activo</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400">15 de
                            Ene, 2023</td>
                        <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right sm:pr-6">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-gray-500 hover:text-primary dark:hover:text-primary"><span
                                        class="material-symbols-outlined">edit</span></button>
                                <button class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-500"><span
                                        class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6"><input
                                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                type="checkbox" /></td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-800 dark:text-gray-200">Carlos
                            Gómez</td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400">
                            carlos.gomez@empresa.com</td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400"><span
                                class="inline-flex items-center rounded-full bg-gray-50 dark:bg-gray-700/40 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 ring-1 ring-inset ring-gray-500/10">Usuario</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400"><span
                                class="inline-flex items-center rounded-full bg-green-50 dark:bg-green-900/40 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20">Activo</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400">22 de
                            Feb, 2023</td>
                        <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right sm:pr-6">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-gray-500 hover:text-primary dark:hover:text-primary"><span
                                        class="material-symbols-outlined">edit</span></button>
                                <button class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-500"><span
                                        class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6"><input
                                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                type="checkbox" /></td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-800 dark:text-gray-200">Luisa
                            Martínez</td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400">
                            luisa.martinez@empresa.com</td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400"><span
                                class="inline-flex items-center rounded-full bg-gray-50 dark:bg-gray-700/40 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 ring-1 ring-inset ring-gray-500/10">Usuario</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400"><span
                                class="inline-flex items-center rounded-full bg-yellow-50 dark:bg-yellow-900/40 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-300 ring-1 ring-inset ring-yellow-600/20">Inactivo</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400">10 de
                            Mar, 2023</td>
                        <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right sm:pr-6">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-gray-500 hover:text-primary dark:hover:text-primary"><span
                                        class="material-symbols-outlined">edit</span></button>
                                <button class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-500"><span
                                        class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6"><input
                                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                type="checkbox" /></td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-800 dark:text-gray-200">Jorge
                            Diaz</td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400">
                            jorge.diaz@empresa.com</td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400"><span
                                class="inline-flex items-center rounded-full bg-gray-50 dark:bg-gray-700/40 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 ring-1 ring-inset ring-gray-500/10">Usuario</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400"><span
                                class="inline-flex items-center rounded-full bg-green-50 dark:bg-green-900/40 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-600/20">Activo</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-gray-500 dark:text-gray-400">05 de
                            Abr, 2023</td>
                        <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right sm:pr-6">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-gray-500 hover:text-primary dark:hover:text-primary"><span
                                        class="material-symbols-outlined">edit</span></button>
                                <button class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-500"><span
                                        class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div
            class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark px-4 py-3 sm:px-6">
            <div class="flex flex-1 justify-between sm:hidden">
                <a class="relative inline-flex items-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700"
                    href="#">Anterior</a>
                <a class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700"
                    href="#">Siguiente</a>
            </div>
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Mostrando <span class="font-medium">1</span> a <span class="font-medium">4</span> de <span
                            class="font-medium">25</span>
                        resultados
                    </p>
                </div>
                <div>
                    <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                        <a class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 focus:z-20 focus:outline-offset-0"
                            href="#">
                            <span class="sr-only">Anterior</span>
                            <span class="material-symbols-outlined text-xl">chevron_left</span>
                        </a>
                        <a aria-current="page"
                            class="relative z-10 inline-flex items-center bg-primary/10 dark:bg-primary/20 px-4 py-2 text-sm font-semibold text-primary focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                            href="#">1</a>
                        <a class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 focus:z-20 focus:outline-offset-0"
                            href="#">2</a>
                        <a class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 focus:z-20 focus:outline-offset-0 md:inline-flex"
                            href="#">3</a>
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:outline-offset-0">...</span>
                        <a class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 focus:z-20 focus:outline-offset-0"
                            href="#">
                            <span class="sr-only">Siguiente</span>
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

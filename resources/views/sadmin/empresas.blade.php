@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

@section('content')
    <div class="p-8 max-w-7xl mx-auto w-full">

        <!-- Header -->
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black tracking-tight">
                    Gestión de Empresas
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400">
                    Administre el directorio de empresas clientes y sus planes activos.
                </p>
            </div>

            <button onclick="openCreateModal()"
                class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm">add</span>
                Añadir Empresa
            </button>
        </div>

        <!-- Tabla -->
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Empresa</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">NIT</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Dirección</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Teléfono</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Correo</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Estado</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->nomb_empresa }}</td>
                            <td>{{ $empresa->nit_empresa }}</td>
                            <td>{{ $empresa->direccion }}</td>
                            <td>{{ $empresa->contacto }}</td>
                            <td>{{ $empresa->empresa_correo }}</td>

                            <td class="text-right">
                                <div class="flex justify-end gap-2">

                                    <!-- EDITAR -->
                                    <button
                                        onclick="openEditModal(
                                        '{{ $empresa->nit_empresa }}',
                                        '{{ $empresa->nomb_empresa }}',
                                        '{{ $empresa->direccion }}',
                                        '{{ $empresa->contacto }}',
                                        '{{ $empresa->empresa_correo }}'
                                        )">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>

                                    <!-- ELIMINAR -->
                                    <form action="{{ route('empresas.destroy', $empresa->nit_empresa) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar esta empresa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- ===================== MODALES ===================== --}}
@section('modals')
    <!-- Modal Crear -->
    <div id="createModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div
            class="w-full max-w-[560px] bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden">

            <!-- Header -->
            <div class="px-8 pt-10 pb-6 text-center border-b border-slate-100 dark:border-slate-800 relative">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Registrar Nueva Empresa
                </h2>
                <p class="mt-2 text-slate-500 dark:text-slate-400">
                    Complete los datos de la organización.
                </p>

                <!-- Cerrar -->
                <button onclick="closeModals()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-700">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Formulario -->
            <form action="{{ route('empresas.store') }}" method="POST" class="px-8 pb-10 pt-8 space-y-6">
                @csrf

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nombre Empresa</label>
                    <input name="nomb_empresa" type="text"
                        class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Ej: Innova Tech S.A.S.">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">NIT</label>
                    <input name="nit_empresa" type="text"
                        class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="900.000.000-1">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Dirección</label>
                    <input name="direccion" type="text"
                        class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Calle 123 #45-67">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Teléfono</label>
                        <input name="contacto" type="tel"
                            class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="+57 300 000 0000">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Correo</label>
                        <input name="empresa_correo" type="email"
                            class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="contacto@empresa.com">
                    </div>
                </div>

                <!-- Acciones -->
                <div class="flex gap-4 pt-4">
                    <!-- VOLVER -->
                    <button type="button" onclick="closeModals()"
                        class="w-1/2 h-12 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">
                        Volver
                    </button>

                    <!-- GUARDAR -->
                    <button type="submit"
                        class="w-1/2 h-12 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg shadow-lg shadow-primary/25 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">save</span>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Editar -->
    <!-- Modal Editar -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div
            class="w-full max-w-[560px] bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden">

            <!-- Header -->
            <div class="px-8 pt-10 pb-6 text-center border-b border-slate-100 dark:border-slate-800 relative">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Editar Empresa
                </h2>
                <p class="mt-2 text-slate-500 dark:text-slate-400">
                    Modifique la información de la empresa.
                </p>

                <button onclick="closeModals()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-700">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="editForm" method="POST" class="px-8 pb-10 pt-8 space-y-6">
                @csrf
                @method('PUT')

                <input type="hidden" id="editNit">

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Nombre Empresa</label>
                    <input id="editNombre" name="nomb_empresa"
                        class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold">Dirección</label>
                    <input id="editDireccion" name="direccion"
                        class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Teléfono</label>
                        <input id="editContacto" name="contacto"
                            class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-semibold">Correo</label>
                        <input id="editCorreo" name="empresa_correo" type="email"
                            class="w-full h-12 px-4 rounded-lg border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <!-- Acciones -->
                <div class="flex gap-4 pt-4">
                    <!-- VOLVER -->
                    <button type="button" onclick="closeModals()"
                        class="w-1/2 h-12 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">
                        Volver
                    </button>

                    <!-- GUARDAR -->
                    <button type="submit"
                        class="w-1/2 h-12 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg shadow-lg shadow-primary/25 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">save</span>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>



    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.getElementById('modalOverlay').classList.remove('hidden');
        }

        function closeModals() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('modalOverlay').classList.add('hidden');
        }

        function openEditModal(nit, nombre, direccion, contacto, correo) {
            document.getElementById('editForm').action = `/sadmin/empresas/${nit}`;
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editDireccion').value = direccion;
            document.getElementById('editContacto').value = contacto;
            document.getElementById('editCorreo').value = correo;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('modalOverlay').classList.remove('hidden');
        }
    </script>


@endsection

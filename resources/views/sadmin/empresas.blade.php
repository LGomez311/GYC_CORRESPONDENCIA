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
                    Administre el directorio de empresas y clientes.
                </p>
            </div>

            <button onclick="openCreateModal()"
                class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm">add</span>
                Añadir Empresa
            </button>
        </div>
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800">
            <h2 class="text-lg font-bold dark:text-white">Empresas Registradas</h2>
        </div>

        <!-- Tabla -->
        <div
            class="bg-white dark:bg-[#161d2b] border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Empresa</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">NIT</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Dirección</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Teléfono</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Correo</th>

                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                    @foreach ($empresas as $empresa)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>

                                    </div>
                                    {{ $empresa->nomb_empresa }}
                            </td>
                            <td>{{ $empresa->nit_empresa }}</td>
                            <td>{{ $empresa->direccion }}</td>
                            <td>{{ $empresa->contacto }}</td>
                            <td>{{ $empresa->empresa_correo }}</td>

                            <td class="text-right">
                                <div class="flex justify-center gap-1">

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
                                    <form class="delete-form"
                                        action="{{ route('empresas.destroy', $empresa->nit_empresa) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>


                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Detiene el submit por defecto

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Si confirma, se envía el formulario
                        }
                    });
                });
            });
        });
    </script>

@endsection

{{-- ===================== MODALES ===================== --}}
@section('modals')

    <!-- Modal Crear Empresa -->
    <div id="createModal" class="fixed inset-0 flex items-center justify-center hidden z-50 bg-black/40">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        Registrar Nueva Empresa
                    </h2>
                    <p class="text-sm text-gray-500">
                        Complete los datos de la organización
                    </p>
                </div>

                <button onclick="closeModals()" class="text-gray-500 hover:text-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Formulario -->
            <form id="empresaForm" action="{{ route('empresas.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Empresa</label>
                        <input id="nomb_empresa" name="nomb_empresa" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-nombre"></p>
                    </div>

                    <!-- NIT -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIT</label>
                        <input id="nit_empresa" name="nit_empresa" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-nit"></p>
                    </div>

                    <!-- Dirección -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input id="direccion" name="direccion" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-direccion"></p>
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input id="contacto" name="contacto" type="text" class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-contacto"></p>
                    </div>

                    <!-- Correo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Correo</label>
                        <input id="empresa_correo" name="empresa_correo" type="email"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-correo"></p>
                    </div>

                </div>

                <!-- Acciones -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModals()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </button>

                    <button id="btnGuardar" type="submit" disabled
                        class="px-6 py-2 rounded-lg bg-blue-600 text-white flex items-center gap-2 opacity-50 cursor-not-allowed">
                        <span class="material-symbols-outlined">save</span>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>





    <!-- Modal Editar Empresa -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        Editar Empresa
                    </h2>
                    <p class="text-sm text-gray-500">
                        Modifique la información de la empresa
                    </p>
                </div>

                <button onclick="closeModals()" class="text-gray-500 hover:text-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="editForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- NIT ORIGINAL (para la URL) -->
                <input type="hidden" id="editNitOriginal">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- NIT EDITABLE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIT</label>
                        <input id="editNit" name="nit_empresa" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <!-- NOMBRE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Empresa</label>
                        <input id="editNombre" name="nomb_empresa" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <!-- DIRECCIÓN -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input id="editDireccion" name="direccion" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <!-- TELÉFONO -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input id="editContacto" name="contacto" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <!-- CORREO -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo</label>
                        <input id="editCorreo" name="empresa_correo" type="email"
                            class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                </div>

                <!-- Acciones -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModals()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </button>

                    <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white flex items-center gap-2">
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

            // La ruta sigue usando el NIT original
            document.getElementById('editForm').action = `/sadmin/empresas/${nit}`;

            // Guardamos el NIT original (por seguridad / referencia)
            document.getElementById('editNitOriginal').value = nit;

            // NIT editable
            document.getElementById('editNit').value = nit;

            // Resto de campos
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editDireccion').value = direccion;
            document.getElementById('editContacto').value = contacto;
            document.getElementById('editCorreo').value = correo;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('modalOverlay').classList.remove('hidden');
        }
    </script>

    <script>
        const form = document.getElementById('empresaForm');
        const btnGuardar = document.getElementById('btnGuardar');

        const fields = {
            nomb_empresa: {
                error: 'error-nombre',
                touched: false,
                max: 100,
                validate(v) {
                    if (!v) return 'El nombre es obligatorio';
                    if (v.length < 3) return 'Mínimo 3 caracteres';
                    if (v.length > this.max) return `Máximo ${this.max} caracteres`;
                    if (/^[0-9]+$/.test(v)) return 'No puede ser solo números';
                    if (/^[^a-zA-Z0-9 ]+$/.test(v)) return 'No puede ser solo símbolos';
                    return null;
                }
            },

            nit_empresa: {
                error: 'error-nit',
                touched: false,
                max: 15,
                validate(v) {
                    if (!v) return 'El NIT es obligatorio';
                    if (!/^[0-9]+$/.test(v)) return 'Solo números';
                    if (v.length < 6) return 'Mínimo 6 dígitos';
                    if (v.length > this.max) return `Máximo ${this.max} dígitos`;
                    return null;
                }
            },

            direccion: {
                error: 'error-direccion',
                touched: false,
                max: 150,
                validate(v) {
                    if (!v) return 'La dirección es obligatoria';
                    if (v.length < 5) return 'Mínimo 5 caracteres';
                    if (v.length > this.max) return `Máximo ${this.max} caracteres`;
                    if (/[<>$%{}]/.test(v)) return 'Caracteres no permitidos';
                    return null;
                }
            },

            contacto: {
                error: 'error-contacto',
                touched: false,
                max: 15,
                validate(v) {
                    if (!v) return 'El teléfono es obligatorio';
                    if (!/^[0-9]+$/.test(v)) return 'Solo números';
                    if (v.length < 7) return 'Mínimo 7 dígitos';
                    if (v.length > this.max) return `Máximo ${this.max} dígitos`;
                    return null;
                }
            },

            empresa_correo: {
                error: 'error-correo',
                touched: false,
                max: 100,
                validate(v) {
                    if (!v) return 'El correo es obligatorio';
                    if (v.length > this.max) return `Máximo ${this.max} caracteres`;
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return 'Correo inválido';
                    return null;
                }
            }
        };

        /**
         * Valida SOLO un campo
         */
        function validateField(input) {
            const field = fields[input.id];
            const errorEl = document.getElementById(field.error);
            const value = input.value.trim();

            if (!field.touched) return true;

            const error = field.validate(value);

            if (error) {
                input.classList.add('border-red-500');
                input.classList.remove('border-green-500');
                errorEl.textContent = error;
                errorEl.classList.remove('hidden');
                return false;
            } else {
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
                errorEl.classList.add('hidden');
                return true;
            }
        }

@endsection
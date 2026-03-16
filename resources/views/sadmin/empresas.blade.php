@extends('sadmin.layouts.app')

@section('title', 'Panel de Empresas')

{{-- ================= HEADER PERSONALIZADO ================= --}}
@section('header')
    <header
        class="h-16 bg-white dark:bg-[#161d2b] border-b border-[#cfd7e7] dark:border-gray-800 px-8 flex items-center justify-between sticky top-0 z-10">

        {{-- BUSCADOR --}}
        <form method="GET" class="w-1/2 max-w-2xl">
            <input id="searchEmpresa" name="search" value="{{ request('search') }}" type="text"
                placeholder="Buscar empresas por nombre o NIT..."
                class="w-full h-10 pl-10 pr-4 bg-background-light dark:bg-background-dark rounded-lg">
        </form>

        <div class="flex items-center gap-4"></div>
    </header>
@endsection

{{-- ================= CONTENIDO ================= --}}
@section('content')
    <div class="p-4 md:p-8 max-w-7xl mx-auto w-full">

        {{-- HEADER INTERNO --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">

            {{-- Título --}}
            <div>
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black tracking-tight">
                    Gestión de Empresas
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400">
                    Administre el directorio de empresas y clientes.
                </p>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3">

                {{-- Botón Crear --}}
                <button type="button" onclick="openCreateModal()"
                    class="px-5 py-2.5 bg-primary text-white rounded-lg 
                   font-bold text-sm flex items-center gap-2 
                   shadow-lg shadow-primary/20 
                   hover:bg-primary/90 transition-all duration-200 whitespace-nowrap">

                    <span class="material-symbols-outlined text-[18px]">
                        add
                    </span>
                    Añadir Empresa
                </button>

            </div>
        </div>

        {{-- CARD --}}
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex justify-between items-center">

                <h2 class="text-lg font-bold dark:text-white">Empresas</h2>

                <div class="flex items-center gap-3">
                    {{-- Botón Historial --}}
                    <button id="btnOpenHistorial"
                        class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                        <span class="material-symbols-outlined text-sm">history</span>
                        Historial
                    </button>

                    <button onclick="openExportModal()"
                        class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Exportar
                    </button>
                </div>

            </div>

            <div id="empresasWrapper">
                {{-- TABLA --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">

                        <thead class="bg-background-light dark:bg-background-dark/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Empresa / NIT</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Contacto</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Dirección</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Representante</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-right">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                            @forelse ($empresas as $empresa)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-[#0d121b] dark:text-white">
                                                {{ $empresa->nomb_empresa }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                NIT: {{ $empresa->nit_empresa }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30 break-all">
                                                {{ $empresa->empresa_correo }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">call</span>
                                                {{ $empresa->contacto }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        <div class="max-w-[200px] truncate" title="{{ $empresa->direccion }}">
                                            {{ $empresa->direccion }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                {{ $empresa->nomb_representante }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                Doc: {{ $empresa->doc_representante }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-1">
                                            <button type="button"
                                                onclick="openEditModal(
                                                    '{{ $empresa->nit_empresa }}',
                                                    '{{ $empresa->nomb_empresa }}',
                                                    '{{ $empresa->direccion }}',
                                                    '{{ $empresa->contacto }}',
                                                    '{{ $empresa->empresa_correo }}',
                                                    '{{ $empresa->doc_representante }}',
                                                    '{{ $empresa->nomb_representante }}'
                                                )"
                                                class="btn-edit p-2 text-[#4c669a] hover:text-primary transition"
                                                title="Editar Empresa">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center">
                                        <div
                                            class="flex flex-col items-center gap-2 text-sm text-[#4c669a] dark:text-gray-400">
                                            <span class="material-symbols-outlined text-4xl">search_off</span>
                                            No se encontraron empresas registradas.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- PAGINACIÓN --}}
                    <div class="flex gap-1 mt-2">
                        {{ $empresas->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>


    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación exitosa!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    {{-- ===================== Bloque de errores Crear ===================== --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al registrar',
                    html: `
            <ul style="text-align:left;">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        `,
                    confirmButtonColor: '#3085d6'
                });

                // Volver a abrir el modal automáticamente
                document.getElementById('createModal').classList.remove('hidden');
            });
        </script>
    @endif

    {{-- ===================== Bloque de errores Editar ===================== --}}
    @if ($errors->update->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar',
                    html: `
        <ul style="text-align:left;">
            @foreach ($errors->update->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
        `,
                    confirmButtonColor: '#3085d6'
                });

                //  Reabrir modal editar con los datos que quedaron
                openEditModal(
                    "{{ old('nit_empresa') }}",
                    "{{ old('nomb_empresa') }}",
                    "{{ old('direccion') }}",
                    "{{ old('contacto') }}",
                    "{{ old('empresa_correo') }}",
                    "{{ old('doc_representante') }}",
                    "{{ old('nomb_representante') }}"
                );

            });
        </script>
    @endif

@endsection

{{-- ===================== MODALES ===================== --}}
@section('modals')

    <!-- Modal Crear Empresa -->
    <div id="createModal" class="fixed inset-0 flex items-center justify-center hidden z-[60] bg-black/40">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        Registrar Nueva Empresa
                    </h2>
                    <p class="text-sm text-gray-500">
                        Complete los datos de la organización, los campos con (*) deben ser obligatorios.
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
                        <label class="block text-sm font-medium text-gray-700">Nombre Empresa (*)</label>
                        <input id="nomb_empresa" name="nomb_empresa" type="text" maxlength="50"
                            placeholder="Ingrese nombre de empresa..." class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-nombre"></p>
                    </div>

                    <!-- NIT -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIT (*)</label>
                        <input id="nit_empresa" name="nit_empresa" type="text" maxlength="10"
                            placeholder="Ingrese Nit de empresa..." class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-nit"></p>
                    </div>

                    <!-- Dirección -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input id="direccion" name="direccion" type="text" maxlength="150"
                            placeholder="Ingrese dirección de empresa... (opcional)"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-direccion"></p>
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input id="contacto" name="contacto" type="text" maxlength="12"
                            placeholder="Ingrese contacto de empresa... (opcional)"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-contacto"></p>
                    </div>

                    <!-- Correo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Correo (*)</label>
                        <input id="empresa_correo" name="empresa_correo" type="email" maxlength="150"
                            placeholder="Ingrese correo electrónico..." class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-correo"></p>
                    </div>


                    <!-- DOC REPRESENTANTE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Documento Representante (*)
                        </label>
                        <input id="doc_representante" name="doc_representante" type="text" maxlength="10"
                            placeholder="Ingrese documento de representante"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-doc"></p>
                    </div>

                    <!-- NOMBRE REPRESENTANTE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nombre Representante (*)
                        </label>
                        <input id="nomb_representante" name="nomb_representante" maxlength="100"
                            placeholder="Ingrese nombre de representante" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-nombre-rep"></p>
                    </div>

                </div>

                <!-- Acciones -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModals()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </button>

                    <button id="btnGuardar" type="submit"
                        class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center gap-2">
                        <span class="material-symbols-outlined">save</span>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>





    <!-- Modal Editar Empresa -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden z-[60] bg-black/40">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        Editar Empresa
                    </h2>
                    <p class="text-sm text-gray-500">
                        Modifique la información de la empresa, los campos con (*) son obligatorios.
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

                    <!-- NOMBRE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Empresa (*)</label>
                        <input id="editNombre" name="nomb_empresa" maxlength="50"
                            placeholder="Ingrese nombre de empresa..." class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-editNombre"></p>
                    </div>

                    <!-- NIT EDITABLE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIT (*)</label>
                        <input id="editNit" name="nit_empresa" type="text" maxlength="10"
                            placeholder="Ingrese Nit de empresa..." class="mt-1 w-full rounded-lg border-gray-300">

                        <p class="text-sm text-red-600 hidden" id="error-editNit"></p>
                    </div>

                    <!-- DIRECCIÓN -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input id="editDireccion" name="direccion" maxlength="150"
                            placeholder="Ingrese dirección de empresa... (opcional)"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-editDireccion"></p>
                    </div>

                    <!-- TELÉFONO -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input id="editContacto" name="contacto" type="text" maxlength="12"
                            placeholder="Ingrese contacto de empresa... (opcional)"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-editContacto"></p>
                    </div>

                    <!-- CORREO -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Correo (*)
                        </label>
                        <input id="editCorreo" name="empresa_correo" type="email" maxlength="150"
                            placeholder="Ingrese correo electrónico..." class="mt-1 w-full rounded-lg border-gray-300">

                        <p class="text-sm text-red-600 hidden mt-1" id="error-editCorreo"></p>
                    </div>

                    <!-- DOC REPRESENTANTE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Documento Representante (*)</label>
                        <input id="editDocRepresentante" name="doc_representante" type="text" maxlength="10"
                            placeholder="Ingrese documento de representante"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-editDocRepresentante"></p>
                    </div>


                    <!-- NOMBRE REPRESENTANTE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Representante (*)</label>
                        <input id="editNombRepresentante" name="nomb_representante" type="text" maxlength="100"
                            placeholder="Ingrese nombre de representante" class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-sm text-red-600 hidden" id="error-editNombRepresentante"></p>
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
        /**
         * ===== VALIDACIONES DEL FORMULARIO DE EDITAR EMPRESA =====
         */
        const editForm = document.getElementById('editForm');
        let editFormOriginalData = {};

        const editFields = {

            editNit: {
                touched: false,
                validate(v) {

                    if (!v) return 'El NIT es obligatorio';

                    if (/\s/.test(v))
                        return 'No se permiten espacios';

                    if (!/^[0-9]+$/.test(v))
                        return 'Solo números permitidos';

                    if (v.length < 9 || v.length > 10)
                        return 'Debe tener entre 9 y 10 dígitos';

                    return null;
                }
            },

            editNombre: {
                touched: false,
                validate(v) {

                    if (!v.trim())
                        return 'El nombre es obligatorio';

                    if (v.length < 3 || v.length > 150)
                        return 'Debe tener entre 3 y 150 caracteres';

                    if (/^[0-9]+$/.test(v))
                        return 'No puede ser solo números';

                    if (/^[^a-zA-ZÀ-ÿ0-9]+$/.test(v))
                        return 'No puede ser solo caracteres especiales';

                    return null;
                }
            },

            editDireccion: {
                touched: false,
                validate(v) {

                    if (!v) return null;

                    if (!v.trim())
                        return 'No puede contener solo espacios';

                    if (v.length < 25 || v.length > 150)
                        return 'Debe tener entre 25 y 150 caracteres';

                    return null;
                }
            },

            editContacto: {
                touched: false,
                validate(v) {

                    if (!v) return null;

                    if (!v.trim())
                        return 'No puede contener solo espacios';

                    if (!/^[0-9]+$/.test(v))
                        return 'Solo números permitidos';

                    if (v.length < 7 || v.length > 12)
                        return 'Debe tener entre 7 y 12 dígitos';

                    return null;
                }
            },

            editCorreo: {
                touched: false,
                validate(v) {

                    if (!v)
                        return 'El correo es obligatorio';

                    if (/\s/.test(v))
                        return 'No se permiten espacios';

                    if (v.length < 8 || v.length > 150)
                        return 'Debe tener entre 8 y 150 caracteres';

                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v))
                        return 'Formato inválido (ej: nombre@dominio.com)';

                    return null;
                }
            },

            editDocRepresentante: {
                touched: false,
                validate(v) {

                    if (!v) return 'Documento obligatorio';

                    if (/\s/.test(v))
                        return 'No se permiten espacios';

                    if (!/^[0-9]+$/.test(v))
                        return 'Solo números';

                    if (v.length < 6 || v.length > 10)
                        return 'Debe tener entre 6 y 10 dígitos';

                    if (/^([0-9])\1+$/.test(v))
                        return 'No se permiten números repetidos';

                    return null;
                }
            },

            editNombRepresentante: {
                touched: false,
                validate(v) {

                    if (!v.trim())
                        return 'Nombre obligatorio';

                    const palabras = v.trim().split(/\s+/);

                    if (palabras.length < 2 || palabras.length > 5)
                        return 'Debe tener entre 2 y 5 palabras';

                    if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\' ]+$/.test(v))
                        return 'Solo letras, tildes, espacios y apostrofe';

                    return null;
                }
            }
        };

        /**
         * Valida un campo del formulario de edición
         */
        function validateEditField(fieldId) {
            const field = editFields[fieldId];
            const input = document.getElementById(fieldId);
            const errorEl = document.getElementById('error-' + fieldId);
            let value = input.value.trim();

            if (!field.touched) return true;

            const error = field.validate(value);

            if (error) {
                input.classList.add('border-red-500');
                input.classList.remove('border-green-500');

                if (errorEl) {
                    errorEl.textContent = error;
                    errorEl.classList.remove('hidden');
                }

                return false;
            } else {
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');

                if (errorEl) {
                    errorEl.classList.add('hidden');
                }

                return true;
            }
        }

        /**
         * Verifica si el formulario de edición es válido
         */
        function isEditFormValid() {
            return Object.keys(editFields).every(id => {
                const input = document.getElementById(id);
                return !editFields[id].validate(input.value.trim());
            });
        }

        /**
         * Detecta cambios en el formulario de edición
         */
        function hasEditFormChanged() {
            return Object.keys(editFields).some(id => {
                const input = document.getElementById(id);
                return input.value.trim() !== editFormOriginalData[id];
            });
        }

        /**
         * Guarda los datos originales del formulario
         */
        function saveEditFormOriginalData() {
            editFormOriginalData = {};
            Object.keys(editFields).forEach(id => {
                const input = document.getElementById(id);
                editFormOriginalData[id] = input.value.trim();
            });
        }

        /**
         * Validación al enviar el formulario de edición
         */
        if (editForm) {
            editForm.addEventListener('submit', e => {
                // 🔒 Rate limiting
                if (!canSubmitForm()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Espera un momento',
                        text: 'Por favor, espera antes de enviar nuevamente',
                        timer: 1500
                    });
                    return;
                }

                let valid = true;
                const editFormData = {};

                // Recopilar datos del formulario
                Object.keys(editFields).forEach(id => {
                    const input = document.getElementById(id);
                    editFormData[id] = input.value.trim();
                });

                // 🔒 Validar seguridad de todo el formulario
                const securityCheck = validateSecurityThreats(editFormData);
                if (!securityCheck.valid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Alerta de Seguridad',
                        text: `Se detectó un intento de ${securityCheck.threat}. Campo: ${securityCheck.field}`,
                        timer: 3000
                    });
                    return;
                }

                // 🔒 Validar que haya cambios
                if (!hasEditFormChanged()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'info',
                        title: 'Sin cambios',
                        text: 'No hay cambios que guardar',
                        timer: 2000
                    });
                    return;
                }

                // Validar cada campo
                Object.keys(editFields).forEach(id => {
                    editFields[id].touched = true;
                    if (!validateEditField(id)) valid = false;
                });

                if (!valid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Errores de validación',
                        text: 'Por favor, verifica los campos resaltados',
                        timer: 2000
                    });
                }
            });

            /**
             * Validación en vivo para campos de edición
             */
            Object.keys(editFields).forEach(id => {
                const input = document.getElementById(id);

                input.addEventListener('input', () => {
                    editFields[id].touched = true;

                    //  Sanitizar según el tipo de campo
                    let value = input.value;

                    if (id === 'editNit' || id === 'editContacto' || id === 'editDocRepresentante') {
                        input.value = value.replace(/[^0-9]/g, '');
                    }

                    validateEditField(id);
                });

                input.addEventListener('blur', () => {
                    editFields[id].touched = true;
                    //  Sanitizar y eliminar espacios extras
                    input.value = input.value.trim();
                    validateEditField(id);
                });

                //  Prevenir pegado de contenido malicioso
                input.addEventListener('paste', (e) => {
                    const pastedText = e.clipboardData.getData('text');

                    if (detectXSSAttempt(pastedText) || detectSQLInjection(pastedText)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Contenido no permitido',
                            text: 'El contenido que intentas pegar contiene caracteres no válidos',
                            timer: 2000
                        });
                        return false;
                    }
                });
            });
        }
    </script>

    <script>
        /**
         * ===== FUNCIONES DE SEGURIDAD Y SANITIZACIÓN =====
         */

        /**
         * Sanitiza strings contra XSS
         */
        function sanitizeString(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#x27;')
                .replace(/\//g, '&#x2F;');
        }

        /**
         * Detecta patrones de inyección SQL
         */
        function detectSQLInjection(str) {
            const sqlPatterns = [
                /(\b(UNION|SELECT|INSERT|UPDATE|DELETE|DROP|EXEC|EXECUTE|SCRIPT|ALERT|EVAL)\b)/gi,
                /(-{2}|\/\*|\*\/|;|--)/g,
                /(javascript:|onerror=|onload=|onclick=)/gi
            ];
            return sqlPatterns.some(pattern => pattern.test(str));
        }

        /**
         * Valida contra XSS
         */
        function detectXSSAttempt(str) {
            const xssPatterns = [
                /<script[^>]*>.*?<\/script>/gi,
                /javascript:/gi,
                /<iframe[^>]*>/gi,
                /<img[^>]*on/gi,
                /on(load|error|click|mouse)[^=]*=/gi,
                /<svg[^>]*on/gi,
                /eval\(/gi
            ];
            return xssPatterns.some(pattern => pattern.test(str));
        }

        /**
         * Valida entrada de usuario
         */
        function validateSecurityThreats(fields = {}) {
            for (const [fieldName, value] of Object.entries(fields)) {
                if (!value) continue;

                if (detectSQLInjection(value)) {
                    console.warn(` Posible SQL injection en ${fieldName}:`, value);
                    return {
                        valid: false,
                        threat: 'SQL Injection',
                        field: fieldName
                    };
                }

                if (detectXSSAttempt(value)) {
                    console.warn(` Posible XSS en ${fieldName}:`, value);
                    return {
                        valid: false,
                        threat: 'XSS Attack',
                        field: fieldName
                    };
                }
            }
            return {
                valid: true
            };
        }

        /**
         * Previene múltiples envíos (rate limiting)
         */
        let formSubmitTimestamp = 0;
        const FORM_SUBMIT_COOLDOWN = 2000; // 2 segundos

        function canSubmitForm() {
            const now = Date.now();
            if (now - formSubmitTimestamp < FORM_SUBMIT_COOLDOWN) {
                console.warn(' Espera antes de enviar nuevamente');
                return false;
            }
            formSubmitTimestamp = now;
            return true;
        }

        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            // Limpiar formulario
            document.getElementById('empresaForm').reset();
        }

        function closeModals() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('editModal').classList.add('hidden');
            // Limpiar errores
            document.querySelectorAll('[id^="error-"]').forEach(el => el.classList.add('hidden'));
        }

        function openEditModal(
            nit,
            nombre,
            direccion,
            contacto,
            correo,
            docRepresentante,
            nombRepresentante
        ) {
            // Sanitizar
            nit = sanitizeString(nit);
            nombre = sanitizeString(nombre);
            direccion = sanitizeString(direccion);
            contacto = sanitizeString(contacto);
            correo = sanitizeString(correo);
            docRepresentante = sanitizeString(docRepresentante);
            nombRepresentante = sanitizeString(nombRepresentante);

            // Action del form (usa NIT original)
            document.getElementById('editForm').action = `/sadmin/empresas/${nit}`;

            // Guardar NIT original
            document.getElementById('editNitOriginal').value = nit;

            // Llenar campos
            document.getElementById('editNit').value = nit;
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editDireccion').value = direccion;
            document.getElementById('editContacto').value = contacto;
            document.getElementById('editCorreo').value = correo;

            // NUEVOS CAMPOS
            document.getElementById('editDocRepresentante').value = docRepresentante;
            document.getElementById('editNombRepresentante').value = nombRepresentante;

            // Limpiar validaciones visuales
            Object.keys(editFields).forEach(id => {
                editFields[id].touched = false;
                const input = document.getElementById(id);
                if (input) {
                    input.classList.remove('border-red-500', 'border-green-500');
                }
            });

            // Mostrar modal
            document.getElementById('editModal').classList.remove('hidden');

            // Limpiar mensajes de error
            document.querySelectorAll('[id^="error-edit"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            // Guardar datos originales
            saveEditFormOriginalData();
        }
    </script>

    <script>
        /**
         * ===== VALIDACIONES DEL FORMULARIO DE CREAR EMPRESA =====
         */
        const form = document.getElementById('empresaForm');
        const btnGuardar = document.getElementById('btnGuardar');

        const fields = {

            nomb_empresa: {
                error: 'error-nombre',
                touched: false,
                validate(v) {

                    if (!v.trim()) return 'El nombre es obligatorio';

                    if (v.length < 3 || v.length > 150)
                        return 'Debe tener entre 3 y 150 caracteres';

                    if (!v.trim())
                        return 'El nombre es obligatorio';

                    if (/^\s|\s$/.test(v))
                        return 'No debe iniciar ni terminar con espacios';

                    if (/\s{2,}/.test(v))
                        return 'No se permiten espacios dobles';

                    if (/^[0-9]+$/.test(v))
                        return 'No puede ser solo números';

                    if (/^[^a-zA-ZÀ-ÿ0-9]+$/.test(v))
                        return 'No puede ser solo caracteres especiales';

                    return null;
                }
            },

            nit_empresa: {
                error: 'error-nit',
                touched: false,
                validate(v) {

                    if (!v) return 'El NIT es obligatorio';

                    if (/\s/.test(v))
                        return 'No se permiten espacios';

                    if (!/^[0-9]+$/.test(v))
                        return 'Solo números permitidos';

                    if (v.length < 9 || v.length > 10)
                        return 'Debe tener entre 9 y 10 dígitos';

                    return null;
                }
            },

            direccion: {
                error: 'error-direccion',
                touched: false,
                validate(v) {

                    if (!v) return null;

                    if (!v.trim())
                        return 'No puede contener solo espacios';

                    if (/\s{2,}/.test(v))
                        return 'No se permiten espacios dobles';

                    if (v.length < 25 || v.length > 150)
                        return 'Debe tener entre 25 y 150 caracteres';

                    return null;
                }
            },

            contacto: {
                error: 'error-contacto',
                touched: false,
                validate(v) {

                    if (!v) return null;

                    if (!v.trim())
                        return 'No puede contener solo espacios';

                    if (!/^[0-9]+$/.test(v))
                        return 'Solo números permitidos';

                    if (v.length < 7 || v.length > 12)
                        return 'Debe tener entre 7 y 12 dígitos';

                    return null;
                }
            },

            empresa_correo: {
                error: 'error-correo',
                touched: false,
                validate(v) {

                    if (!v) return 'El correo es obligatorio';

                    if (/\s/.test(v))
                        return 'No se permiten espacios';

                    if (v.length < 8 || v.length > 150)
                        return 'Debe tener entre 8 y 150 caracteres';

                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v))
                        return 'Formato inválido (ej: nombre@dominio.com)';

                    return null;
                }
            },

            doc_representante: {
                error: 'error-doc',
                touched: false,
                validate(v) {

                    if (!v) return 'Documento obligatorio';

                    if (/\s/.test(v))
                        return 'No se permiten espacios';

                    if (!/^[0-9]+$/.test(v))
                        return 'Solo números';

                    if (v.length < 6 || v.length > 10)
                        return 'Debe tener entre 6 y 10 dígitos';

                    if (/^([0-9])\1+$/.test(v))
                        return 'No se permiten números repetidos';

                    return null;
                }
            },

            nomb_representante: {
                error: 'error-nombre-rep',
                touched: false,
                validate(v) {

                    if (!v.trim())
                        return 'Nombre obligatorio';

                    const palabras = v.trim().split(/\s+/);

                    if (palabras.length < 2 || palabras.length > 5)
                        return 'Debe tener entre 2 y 5 palabras';

                    if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ' ]+$/.test(v))
                        return 'Solo letras, tildes, espacios y apostrofe';

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
            let value = input.value.trim();

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

        /**
         * Revisa TODO el formulario SIN mostrar errores
         */
        function isFormValid() {
            return Object.keys(fields).every(id => {
                const input = document.getElementById(id);
                return !fields[id].validate(input.value.trim());
            });
        }

        /**
         * BLOQUEO REAL DEL SUBMIT con validaciones de seguridad
         */
        form.addEventListener('submit', e => {
            // 🔒 Rate limiting
            if (!canSubmitForm()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Espera un momento',
                    text: 'Por favor, espera antes de enviar nuevamente',
                    timer: 1500
                });
                return;
            }

            let valid = true;
            const formData = {};

            // Recopilar datos del formulario
            Object.keys(fields).forEach(id => {
                const input = document.getElementById(id);
                formData[id] = input.value.trim();
            });

            // 🔒 Validar seguridad de todo el formulario
            const securityCheck = validateSecurityThreats(formData);
            if (!securityCheck.valid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Alerta de Seguridad',
                    text: `Se detectó un intento de ${securityCheck.threat}. Campo: ${securityCheck.field}`,
                    timer: 3000
                });
                return;
            }

            // Validar cada campo
            Object.keys(fields).forEach(id => {
                const input = document.getElementById(id);
                fields[id].touched = true;
                if (!validateField(input)) valid = false;
            });

            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Errores de validación',
                    text: 'Por favor, verifica los campos resaltados',
                    timer: 2000
                });
            }
        });

        /**
         * Validación en vivo (campo por campo)
         */
        Object.keys(fields).forEach(id => {
            const input = document.getElementById(id);

            input.addEventListener('input', () => {
                fields[id].touched = true;

                // Sanitizar el input en tiempo real
                let value = input.value;

                // Prevenir caracteres especiales peligrosos en ciertos campos
                if (id === 'nit_empresa' || id === 'contacto' || id === 'doc_representante') {
                    input.value = value.replace(/[^0-9]/g, '');
                }

                validateField(input);
            });

            input.addEventListener('blur', () => {
                fields[id].touched = true;
                // 🔒 Sanitizar y eliminar espacios extras
                input.value = input.value.trim();
                validateField(input);
            });

            //  Prevenir pegado de contenido malicioso
            input.addEventListener('paste', (e) => {
                const pastedText = e.clipboardData.getData('text');

                // Validar lo que se va a pegar
                if (detectXSSAttempt(pastedText) || detectSQLInjection(pastedText)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Contenido no permitido',
                        text: 'El contenido que intentas pegar contiene caracteres no válidos',
                        timer: 2000
                    });
                    return false;
                }
            });
        });
    </script>

    {{-- MODAL HISTORIAL --}}
    <div id="historialModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-[60] p-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-4xl max-h-[85vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        Historial de Modificaciones
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Registro de cambios realizados a las empresas en el sistema.
                    </p>
                </div>
                <button onclick="closeHistorialModal()"
                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="p-5 overflow-y-auto flex-1">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-800/50 sticky top-0">
                            <tr>
                                <th
                                    class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Fecha / Hora</th>
                                <th
                                    class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Empresa Modificada</th>
                                <th
                                    class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Modificado Por</th>
                                <th
                                    class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
                                    Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse ($auditorias as $auditoria)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $auditoria->fecha_cambio->format('d/m/Y H:i A') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="font-semibold">
                                            {{ $auditoria->empresaAfectada->nomb_empresa ?? 'Desconocida' }}</div>
                                        <div class="text-xs text-gray-500">NIT:
                                            {{ $auditoria->nit_empresa_afectada }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="font-semibold">
                                            {{ $auditoria->responsable->emple_nombres ?? 'Sistema' }}
                                            {{ $auditoria->responsable->emple_apellidos ?? '' }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $auditoria->usuario_app ? 'C.C. ' . $auditoria->usuario_app : 'BD' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button onclick="verDetallesCambio({{ $auditoria->id_log }})"
                                            class="text-primary hover:text-blue-700 bg-blue-50 dark:bg-blue-900/20 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 mx-auto transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                                            Ver Cambios
                                        </button>
                                        <!-- Datos Ocultos para JS -->
                                        <div id="datos-ant-{{ $auditoria->id_log }}" class="hidden">
                                            {{ json_encode($auditoria->datos_anteriores) }}
                                        </div>
                                        <div id="datos-nue-{{ $auditoria->id_log }}" class="hidden">
                                            {{ json_encode($auditoria->datos_nuevos) }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <span
                                                class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">history</span>
                                            Aún no hay registros de modificaciones
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETALLES DE CAMBIOS --}}
    <div id="detallesCambioModal"
        class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-[60] p-4 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl w-full max-w-3xl flex flex-col overflow-hidden">
            <div
                class="p-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h4 class="text-md font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">compare_arrows</span>
                    Comparación de Datos
                </h4>
                <button onclick="closeDetallesCambioModal()" class="text-gray-500 hover:text-red-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <div class="grid grid-cols-2 gap-6" id="contenedor-comparacion">
                    <!-- Se renderiza via JS -->
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button onclick="closeDetallesCambioModal()"
                    class="px-5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg transition-colors">
                    Cerrar Detalles
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL EXPORTAR --}}
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[60]">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                Exportar Empresas
            </h3>

            <div class="flex flex-col gap-3">

                <!-- PDF -->
                <a href="{{ route('empresas.export.pdf') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <!-- Excel -->
                <a href="{{ route('empresas.export.excel') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-green-600">grid_on</span>
                    Excel
                </a>

            </div>

            <button onclick="closeExportModal()"
                class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                Cancelar
            </button>

        </div>
    </div>

    <script>
        function openExportModal() {
            document.getElementById('exportModal').classList.remove('hidden');
            document.getElementById('exportModal').classList.add('flex');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.add('hidden');
            document.getElementById('exportModal').classList.remove('flex');
        }

        /* ===========================
           HISTORIAL DE AUDITORÍA
        ============================*/
        document.addEventListener('DOMContentLoaded', function() {
            const btnHistorial = document.getElementById('btnOpenHistorial');
            if (btnHistorial) {
                btnHistorial.addEventListener('click', () => {
                    document.getElementById('historialModal').classList.remove('hidden');
                });
            }
        });

        window.closeHistorialModal = function() {
            document.getElementById('historialModal').classList.add('hidden');
        }

        window.closeDetallesCambioModal = function() {
            document.getElementById('detallesCambioModal').classList.add('hidden');
        }

        window.verDetallesCambio = function(idLog) {
            const modal = document.getElementById('detallesCambioModal');
            const contenedor = document.getElementById('contenedor-comparacion');

            try {
                const datosAnt = JSON.parse(document.getElementById(`datos-ant-${idLog}`).textContent
                    .trim() || '{}');
                const datosNue = JSON.parse(document.getElementById(`datos-nue-${idLog}`).textContent
                    .trim() || '{}');

                let htmlAnt =
                    '<div class="flex flex-col gap-3"><h5 class="font-bold text-red-600 border-b pb-2 mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">remove_circle</span> Datos Anteriores</h5>';
                let htmlNue =
                    '<div class="flex flex-col gap-3"><h5 class="font-bold text-green-600 border-b pb-2 mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">add_circle</span> Datos Nuevos</h5>';

                const camposRelevantes = ['nomb_empresa', 'doc_representante', 'nomb_representante', 'direccion',
                    'contacto', 'empresa_correo'
                ];
                const labelsMap = {
                    'nomb_empresa': 'Nombre Empresa',
                    'doc_representante': 'Doc. Representante',
                    'nomb_representante': 'Nom. Representante',
                    'direccion': 'Dirección',
                    'contacto': 'Teléfono',
                    'empresa_correo': 'Correo'
                };

                camposRelevantes.forEach(campo => {
                    const valAnt = datosAnt[campo] ?? 'No definido';
                    const valNue = datosNue[campo] ?? 'No definido';

                    const esDiferente = String(valAnt) !== String(valNue);

                    // Resaltar si cambió
                    const claseAnt = esDiferente ?
                        'bg-red-50 text-red-700 p-2 rounded border border-red-100' :
                        'p-2 text-gray-600';
                    const claseNue = esDiferente ?
                        'bg-green-50 text-green-700 p-2 rounded border border-green-100' :
                        'p-2 text-gray-600';

                    const label = labelsMap[campo] || campo;

                    htmlAnt += `
                    <div class="${claseAnt}">
                        <div class="text-xs font-bold uppercase tracking-wider mb-1 opacity-70">${label}</div>
                        <div class="text-sm break-words">${valAnt}</div>
                    </div>
                `;

                    htmlNue += `
                    <div class="${claseNue}">
                        <div class="text-xs font-bold uppercase tracking-wider mb-1 opacity-70">${label}</div>
                        <div class="text-sm break-words">${valNue}</div>
                    </div>
                `;
                });

                htmlAnt += '</div>';
                htmlNue += '</div>';

                contenedor.innerHTML = htmlAnt + htmlNue;
                modal.classList.remove('hidden');

            } catch (error) {
                console.error("Error al procesar JSON de detalles", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Datos',
                    text: 'No se pudieron cargar los detalles de este cambio.'
                });
            }
        }
    </script>

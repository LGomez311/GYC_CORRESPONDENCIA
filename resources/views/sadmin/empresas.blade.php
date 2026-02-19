@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

@section('content')
<div class="p-8 max-w-7xl mx-auto w-full">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">

        <!-- Título -->
        <div>
            <h1 class="text-[#0d121b] dark:text-white text-3xl font-black tracking-tight">
                Gestión de Empresas
            </h1>
            <p class="text-[#4c669a] dark:text-gray-400">
                Administre el directorio de empresas y clientes.
            </p>
        </div>

        <!-- Botones -->
        <div class="flex items-center gap-3">

            <!-- Botón Crear -->
            <button onclick="openCreateModal()"
                class="px-5 py-2.5 bg-primary text-white rounded-lg 
                   font-bold text-sm flex items-center gap-2 
                   shadow-lg shadow-primary/20 
                   hover:bg-primary/90 transition-all duration-200">

                <span class="material-symbols-outlined text-[18px]">
                    add
                </span>
                Añadir Empresa
            </button>

        </div>
    </div>

    <div
        class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
        <div
            class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Empresas Registradas</h2>
            <div class="flex gap-2">

                <button onclick="openExportModal()"
                    class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Exportar
                </button>

            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th
                            class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider align-middle text-center">
                            Empresa</th>
                        <th
                            class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider align-middle text-center">
                            NIT</th>
                        <th
                            class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider align-middle text-center">
                            Dirección</th>
                        <th
                            class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider align-middle text-center">
                            Teléfono</th>
                        <th
                            class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider align-middle text-center">
                            Correo</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-center">
                            Representante
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-center">
                            Documento Representante
                        </th>
                        <th
                            class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider align-middle text-center">
                            Acciones</th>



                    </tr>
                </thead>

                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                    @foreach ($empresas as $empresa)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                        <!-- EMPRESA -->
                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            <span class="text-sm font-bold text-[#0d121b] dark:text-white">
                                {{ $empresa->nomb_empresa }}
                            </span>
                        </td>

                        <!-- NIT -->
                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            {{ $empresa->nit_empresa }}
                        </td>

                        <!-- DIRECCIÓN -->
                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            {{ $empresa->direccion }}
                        </td>

                        <!-- TELÉFONO -->
                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            {{ $empresa->contacto }}
                        </td>

                        <!-- CORREO -->
                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            <span class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">
                                {{ $empresa->empresa_correo }}</span>
                        </td>

                        <!-- NOMBRE REPRESENTANTE -->

                        <td class="px-6 py-4 text-sm text-center">
                            {{ $empresa->nomb_representante }}
                        </td>

                        <!-- DOCUMENTO REPRESENTANTE -->

                        <td class="px-6 py-4 text-sm text-center">
                            {{ $empresa->doc_representante }}
                        </td>


                        <!-- ACCIONES -->
                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            <div class="flex items-center justify-end gap-1">

                                <!-- EDITAR -->
                                <button
                                    onclick="openEditModal(
                                    '{{ $empresa->nit_empresa }}',
                                    '{{ $empresa->nomb_empresa }}',
                                    '{{ $empresa->direccion }}',
                                    '{{ $empresa->contacto }}',
                                    '{{ $empresa->empresa_correo }}',
                                    '{{ $empresa->doc_representante }}',
                                    '{{ $empresa->nomb_representante }}'
                                )"
                                    class="p-2 text-[#4c669a] hover:text-primary transition">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                            </div>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="flex gap-1">
                {{ $empresas->links() }}
            </div>

        </div>

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

    // 🔥 Volver a abrir el modal automáticamente
    document.getElementById('createModal').classList.remove('hidden');
});
</script>
@endif



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
                        class="mt-1 w-full rounded-lg border-gray-300" maxlength="10">
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
                    <input id="contacto" name="contacto" type="text" class="mt-1 w-full rounded-lg border-gray-300" maxlength="12">
                    <p class="text-sm text-red-600 hidden" id="error-contacto"></p>
                </div>

                <!-- Correo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Correo</label>
                    <input id="empresa_correo" name="empresa_correo" type="email"
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p class="text-sm text-red-600 hidden" id="error-correo"></p>
                </div>

                <!-- REPRESENTANTE -->

                <!-- DOC REPRESENTANTE -->
                <div>
                    <label>Documento Representante</label>
                    <input
                        id="doc_representante"
                        name="doc_representante"
                        type="text"
                        maxlength="10"
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p class="text-sm text-red-600 hidden" id="error-doc"></p>
                </div>

                <!-- NOMBRE REPRESENTANTE -->
                <div>
                    <label>Nombre Representante</label>
                    <input
                        id="nomb_representante"
                        name="nomb_representante"
                        type="text"
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

                <!-- DOC REPRESENTANTE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Documento Representante</label>
                    <input id="editDocRepresentante"
                        name="doc_representante"
                        type="text"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>


                <!-- NOMBRE REPRESENTANTE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre Representante</label>
                    <input id="editNombRepresentante"
                        name="nomb_representante"
                        type="text"
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
                    return 'Solo números';

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
                    return 'Solo números';

                if (v.length < 7 || v.length > 12)
                    return 'Debe tener entre 7 y 12 dígitos';

                return null;
            }
        },

        editCorreo: {
            touched: false,
            validate(v) {

                if (!v)
                    return 'Correo obligatorio';

                if (/\s/.test(v))
                    return 'No se permiten espacios';

                if (v.length < 8 || v.length > 150)
                    return 'Debe tener entre 8 y 150 caracteres';

                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v))
                    return 'Correo inválido';

                return null;
            }
        },

        editDocRepresentante: {
            touched: false,
            validate(v) {

                if (!v)
                    return 'Documento obligatorio';

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
        }

    };

    /**
     * Valida un campo del formulario de edición
     */
    function validateEditField(fieldId) {
        const field = editFields[fieldId];
        const input = document.getElementById(fieldId);
        let value = input.value.trim();

        if (!field.touched) return true;

        const error = field.validate(value);

        if (error) {
            input.classList.add('border-red-500');
            input.classList.remove('border-green-500');
            return false;
        } else {
            input.classList.remove('border-red-500');
            input.classList.add('border-green-500');
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

                if (id === 'editNit' || id === 'editContacto' || id === 'doc_representante') {
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
            btnGuardar.disabled = true;
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
            btnGuardar.disabled = !isFormValid();
            btnGuardar.classList.toggle('opacity-50', btnGuardar.disabled);
            btnGuardar.classList.toggle('cursor-not-allowed', btnGuardar.disabled);
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

    //  Validar que el representante sea seleccionado
    const selectRepresentante = document.querySelector('select[name="id_representante"]');
    if (selectRepresentante) {
        selectRepresentante.addEventListener('change', () => {
            btnGuardar.disabled = !isFormValid();
            btnGuardar.classList.toggle('opacity-50', btnGuardar.disabled);
            btnGuardar.classList.toggle('cursor-not-allowed', btnGuardar.disabled);
        });
    }
</script>

{{-- MODAL EXPORTAR --}}
<div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
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
</script>
@endsection
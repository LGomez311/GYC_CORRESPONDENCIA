@extends('sadmin.layouts.app')

@section('title', 'Panel de Administradores')

@section('content')
<div class="p-8 max-w-7xl mx-auto w-full">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                Gestión de Administradores de Empresa
            </h1>
            <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">
                Controle el acceso y gestione los perfiles de administradores para la empresa
            </p>
        </div>
        <div class="flex gap-3">
            <button id="btnOpenCrear"
                class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm">person_add</span>
                Crear Nuevo Admin
            </button>
        </div>
    </div>


    {{-- TABLA --}}
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Administradores de Empresas</h2>
            <button onclick="openExportModal()"
                class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                <span class="material-symbols-outlined text-sm">download</span>
                Exportar
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">Nombre del Administrador</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-center">Empresa Asociada</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">Correo Electrónico</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                    @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center overflow-hidden">
                                    <img alt="Avatar" class="w-full h-full object-cover" src="{{ asset('storage/' . $user->emple_img) }}">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">
                                        {{ $user->emple_nombres }} {{ $user->emple_apellidos }}
                                    </span>
                                    <span class="text-xs text-[#4c669a] dark:text-gray-400">DOCUMENTO: {{ $user->emple_doc }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            <span class="text-sm font-bold text-[#0d121b] dark:text-white">
                                {{ $user->empresa->nomb_empresa }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">{{ $user->emple_tel }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">{{ $user->emple_correo }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                {{ $user->estado->estado_nomb }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-1">
                                <button class="p-2 text-[#4c669a] hover:text-primary transition-colors btn-open-edit"
                                    title="Editar"
                                    data-id="{{ $user->emple_doc }}"
                                    data-documento="{{ $user->emple_doc }}"
                                    data-nit="{{ $user->empresa?->nit_empresa }}"
                                    data-nombres="{{ $user->emple_nombres }}"
                                    data-apellidos="{{ $user->emple_apellidos }}"
                                    data-telefono="{{ $user->emple_tel }}"
                                    data-correo="{{ $user->emple_correo }}"
                                    data-estado="{{ $user->emple_estado }}">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if ($users->count() == 0)
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center">
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm">
                                <span class="material-symbols-outlined text-[18px]">info</span>
                                No hay registros disponibles
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <div class="flex gap-1 mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div id="userModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Registrar Nuevo Administrador
                </h2>
                <p class="text-sm text-gray-500">
                    Complete los datos del administrador, los campos con (*) son obligatorios.
                </p>
            </div>

            <button class="btn-close text-gray-500 hover:text-gray-800">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('sadmin.store') }}"
            id="userForm"
            enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- DOCUMENTO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Documento (*)
                    </label>
                    <input
                        name="emple_doc"
                        id="documento"
                        type="text"
                        maxlength="10"
                        placeholder="Ingrese documento..."
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="error-documento" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- EMPRESA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Empresa (NIT) (*)
                    </label>
                    <select
                        name="nit_empresa"
                        id="nit_empresa"
                        class="mt-1 w-full rounded-lg border-gray-300" required>
                        <option value="">Seleccionar empresa...</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->nit_empresa }}">
                            {{ $empresa->nit_empresa }} - {{ $empresa->nomb_empresa }}
                        </option>
                        @endforeach
                    </select>
                    <p id="error-nit" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- NOMBRES -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nombres (*)
                    </label>
                    <input
                        name="emple_nombres"
                        id="nombres"
                        type="text"
                        maxlength="50"
                        placeholder="Ingrese nombres..."
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="error-nombres" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- APELLIDOS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Apellidos (*)
                    </label>
                    <input
                        name="emple_apellidos"
                        id="apellidos"
                        type="text"
                        maxlength="50"
                        placeholder="Ingrese apellidos..."
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="error-apellidos" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Teléfono (*)
                    </label>
                    <input
                        name="emple_tel"
                        id="telefono"
                        type="text"
                        maxlength="12"
                        placeholder="Ingrese teléfono... "
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="error-telefono" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CORREO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Correo (*)
                    </label>
                    <input
                        name="emple_correo"
                        id="correo"
                        type="email"
                        maxlength="150"
                        placeholder="Ingrese correo electrónico..."
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="error-correo" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CONTRASEÑA -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Contraseña (*)
                    </label>
                    <input
                        name="password"
                        id="password"
                        type="password"
                        placeholder="Ingrese contraseña segura..."
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="error-password" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- FOTO -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Foto de perfil
                    </label>
                    <p class="block text-sm font-medium text-gray-700"> No se permite más de 1024 * 1024 MB, solo formato (JPEG, PNG, WEBP) </p>
                    <input
                        name="emple_img"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- ESTADO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Estado
                    </label>
                    <input
                        type="text"
                        value="{{ $estados->where('id_estado', 1)->first()->estado_nomb ?? 'Activo' }}"
                        readonly
                        class="mt-1 w-full rounded-lg bg-gray-100 border-gray-300 cursor-not-allowed">
                </div>

                <!-- ROL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Rol
                    </label>
                    <input
                        type="text"
                        value="Administrador"
                        readonly
                        class="mt-1 w-full rounded-lg bg-gray-100 border-gray-300 cursor-not-allowed">
                </div>

            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3 pt-6 border-t">
                <button type="button"
                    class="btn-close px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>

                <button id="btnGuardar"
                    type="submit"
                    disabled
                    class="px-6 py-2 rounded-lg bg-blue-600 text-white flex items-center gap-2 opacity-50 cursor-not-allowed">
                    <span class="material-symbols-outlined">save</span>
                    Guardar
                </button>
            </div>

        </form>
    </div>
</div>

{{-- MODAL EDITAR --}}
<div id="userModalEdit" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Editar Admin</h2>
            <button class="btn-close text-gray-500 hover:text-gray-800">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" id="formEdit" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="hidden" id="edit_id" name="emple_doc">

                {{-- DOCUMENTO --}}
                <div>
                    <label>Documento</label>
                    <input type="text" name="emple_doc" id="edit_documento" class="mt-1 w-full rounded-lg border border-gray-300 transition-all duration-200">
                    <p id="edit-error-documento" class="text-red-500 hidden">Solo números, 6-10 dígitos</p>
                </div>

                {{-- NIT EMPRESA --}}
                <div>
                    <label>Empresa (NIT)</label>
                    <select name="nit_empresa" id="edit_nit" class="mt-1 w-full rounded-lg border border-gray-300 transition-all duration-200">
                        <option value="">Seleccionar empresa...</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->nit_empresa }}">{{ $empresa->nomb_empresa }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- NOMBRES --}}
                <div>
                    <label>Nombres</label>
                    <input type="text" name="emple_nombres" id="edit_nombres" class="mt-1 w-full rounded-lg border border-gray-300 transition-all duration-200">
                    <p id="edit-error-nombres" class="text-red-500 hidden">Solo letras, máximo 2 palabras</p>
                </div>

                {{-- APELLIDOS --}}
                <div>
                    <label>Apellidos</label>
                    <input type="text" name="emple_apellidos" id="edit_apellidos" class="mt-1 w-full rounded-lg border border-gray-300 transition-all duration-200">
                    <p id="edit-error-apellidos" class="text-red-500 hidden">Solo letras, máximo 2 palabras</p>
                </div>

                {{-- TELÉFONO --}}
                <div>
                    <label>Teléfono</label>
                    <input type="text" name="emple_tel" id="edit_telefono" class="mt-1 w-full rounded-lg border border-gray-300 transition-all duration-200">
                    <p id="edit-error-telefono" class="text-red-500 hidden">Solo números, 7-12 dígitos</p>
                </div>

                {{-- CORREO --}}
                <div>
                    <label>Correo</label>
                    <input type="email" name="emple_correo" id="edit_correo" class="mt-1 w-full rounded-lg border border-gray-300 transition-all duration-200">
                    <p id="edit-error-correo" class="text-red-500 hidden">Correo inválido</p>
                </div>

                {{-- FOTO --}}
                <div>
                    <label>Foto</label>
                    <input type="file" name="emple_img" class="mt-1 w-full rounded-lg border-gray-300" accept=".jpg,.jpeg,.png,.webp">
                </div>

                {{-- ESTADO --}}
                <div>
                    <label>Estado</label>
                    <select name="emple_estado" id="edit_estado" class="mt-1 w-full rounded-lg border-gray-300">
                        <option value="">Seleccionar estado...</option>
                        @foreach($estados as $estado)
                        <option value="{{ $estado->id_estado }}">{{ $estado->estado_nomb }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-6 border-t">
                <button type="button" class="btn-close px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Cancelar</button>
                <button
                    id="btnGuardarEdit"
                    type="submit"
                    disabled
                    class="px-6 py-2 rounded-lg bg-blue-600 text-white flex items-center gap-2 opacity-50 cursor-not-allowed">
                    <span class="material-symbols-outlined">save</span>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')

{{-- SWEET ALERTS --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Operación exitosa',
        text: "{{ session('success') }}",
        confirmButtonColor: '#16a34a',
        confirmButtonText: 'Aceptar'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('error') }}",
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Entendido'
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Errores en el formulario',
        html: `
        <ul style="text-align:left;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    `,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ===========================
           VARIABLES GENERALES
        ============================*/

        const modalCrear = document.getElementById('userModal');
        const modalEditar = document.getElementById('userModalEdit');

        const btnGuardar = document.getElementById('btnGuardar');
        const btnGuardarEdit = document.getElementById('btnGuardarEdit');

        let originalEditData = {};
        let camposTocados = {};

        /* ===========================
           MODALES
        ============================*/

        document.getElementById('btnOpenCrear').addEventListener('click', () => {
            modalCrear.classList.remove('hidden');
        });

        document.querySelectorAll('.btn-close').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.closest('.fixed').classList.add('hidden');
            });
        });

        document.querySelectorAll('.btn-open-edit').forEach(btn => {
            btn.addEventListener('click', function() {

                const data = {
                    documento: btn.dataset.documento || '',
                    nit: btn.dataset.nit || '',
                    nombres: btn.dataset.nombres || '',
                    apellidos: btn.dataset.apellidos || '',
                    telefono: btn.dataset.telefono || '',
                    correo: btn.dataset.correo || '',
                    estado: btn.dataset.estado || ''
                };

                // Guardamos valores originales
                originalEditData = {
                    ...data
                };

                document.getElementById('edit_documento').value = data.documento;
                document.getElementById('edit_nit').value = data.nit;
                document.getElementById('edit_nombres').value = data.nombres;
                document.getElementById('edit_apellidos').value = data.apellidos;
                document.getElementById('edit_telefono').value = data.telefono;
                document.getElementById('edit_correo').value = data.correo;
                document.getElementById('edit_estado').value = data.estado;

                document.getElementById('formEdit').action =
                    "{{ url('sadmin/usuarios') }}/" + data.documento;

                updateEditButton();
                modalEditar.classList.remove('hidden');
            });
        });

        /* ===========================
           VALIDACIÓN CREAR
        ===========================*/

        const reglasCrear = {

            documento: {
                required: true,
                min: 6,
                max: 10,
                regex: /^[0-9]+$/,
                custom: function(valor) {
                    return !/^(\d)\1+$/.test(valor); // Evita 0000000, 1111111
                },
                error: 'error-documento',
                mensajes: {
                    required: 'El documento es obligatorio.',
                    min: 'El documento debe tener mínimo 6 dígitos.',
                    max: 'El documento no puede superar 10 dígitos.',
                    regex: 'El documento solo permite números sin espacios.',
                    custom: 'No se permiten números repetidos como 0000000.'
                }
            },


            nombres: {
                required: true,
                min: 3,
                max: 60,
                regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/,
                custom: function(valor) {
                    const palabras = valor.trim().split(/\s+/);
                    return palabras.length <= 2;
                },
                error: 'error-nombres',
                mensajes: {
                    required: 'El nombre es obligatorio.',
                    min: 'Debe tener al menos una palabra.',
                    max: 'No puede superar 60 caracteres.',
                    regex: 'Solo se permiten mínimo 3 letras',
                    custom: 'No puede superar 2 palabras.'
                }
            },

            apellidos: {
                required: true,
                min: 3,
                max: 60,
                regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/,
                custom: function(valor) {
                    const palabras = valor.trim().split(/\s+/);
                    return palabras.length <= 2;
                },
                error: 'error-apellidos',
                mensajes: {
                    required: 'Los apellidos son obligatorios.',
                    min: 'Debe tener al menos una palabra.',
                    max: 'No puede superar 60 caracteres.',
                    regex: 'Solo se permiten mínimo 3 letras',
                    custom: 'No puede superar 2 palabras.'
                }
            },

            telefono: {
                required: true,
                min: 7,
                max: 12,
                regex: /^[0-9]+$/,
                error: 'error-telefono',
                mensajes: {
                    required: 'El teléfono es obligatorio.',
                    min: 'El teléfono debe tener mínimo 7 dígitos.',
                    max: 'El teléfono no puede superar 12 dígitos.',
                    regex: 'El teléfono solo permite números sin espacios.'
                }
            },

            correo: {
                required: true,
                min: 8,
                max: 150,
                regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                error: 'error-correo',
                mensajes: {
                    required: 'El correo es obligatorio.',
                    min: 'El correo debe tener mínimo 8 caracteres.',
                    max: 'El correo no puede superar 150 caracteres.',
                    regex: 'Debe tener un formato válido ejemplo: nombre@dominio.com'
                }
            },

            password: {
                required: true,
                min: 10,
                regex: null,
                error: 'error-password',
                mensajes: {
                    required: 'La contraseña es obligatoria.',
                    min: 'Debe tener mínimo 10 caracteres.',
                    regex: 'Debe incluir: 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial (!"#$%&/()=@).'
                }
            }
        };

        Object.keys(reglasCrear).forEach(id => {

            const input = document.getElementById(id);

            //  Cuando escribe
            input.addEventListener('input', () => {

                const valor = input.value.trim();

                // Si empieza a escribir, marcamos como tocado
                if (valor.length > 0) {
                    camposTocados[id] = true;
                }

                validarCampoIndividual(id);
                validarFormularioCrear();
            });

            //  Cuando sale del campo
            input.addEventListener('blur', () => {
                camposTocados[id] = true;
                validarCampoIndividual(id);
                validarFormularioCrear(); // validamos
            });

        });

        const formCrear = document.getElementById('userForm');

        formCrear.addEventListener('submit', function(e) {

            const fileInput = this.querySelector('input[name="emple_img"]');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];

                // Validar tamaño
                const maxSizeMB = 1; // tu límite real
                const maxSizeBytes = maxSizeMB * 1024 * 1024;
                if (file.size > maxSizeBytes) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Imagen muy grande',
                        text: `La imagen no puede superar ${maxSizeMB} MB.`,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Entendido'
                    });
                    return false;
                }

                // Validar tipo
                const tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
                if (!tiposPermitidos.includes(file.type)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Formato inválido',
                        text: 'Solo se permiten imágenes JPEG, PNG o WEBP.',
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Entendido'
                    });
                    return false;
                }
            }

        });

        function validarCampoIndividual(id) {

            const input = document.getElementById(id);
            const regla = reglasCrear[id];
            const error = document.getElementById(regla.error);

            if (!camposTocados[id]) return;

            const valor = input.value.trim();

            // Reset visual
            input.classList.remove('border-red-500', 'border-green-500');
            error.classList.add('hidden');

            // 🔐 VALIDACIÓN ESPECIAL PASSWORD
            if (id === 'password') {

                // 🔴 Obligatorio
                if (valor === '') {
                    input.classList.add('border-red-500');
                    error.textContent = regla.mensajes.required;
                    error.classList.remove('hidden');
                    return;
                }

                // 🔴 Primero validar estructura (mayúscula, minúscula, número, especial)
                const regexEstructura = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!"#$%&\/()=@])/;

                if (!regexEstructura.test(valor)) {
                    input.classList.add('border-red-500');
                    error.textContent = regla.mensajes.regex;
                    error.classList.remove('hidden');
                    return;
                }

                // 🔴 Luego validar mínimo 10 caracteres
                if (valor.length < regla.min) {
                    input.classList.add('border-red-500');
                    error.textContent = regla.mensajes.min;
                    error.classList.remove('hidden');
                    return;
                }

                // 🟢 Correcto
                input.classList.add('border-green-500');
                return;
            }

            // 🔴 1. Campo obligatorio
            if (regla.required && valor === '') {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.required;
                error.classList.remove('hidden');
                return;
            }

            // 🔴 2. Longitud mínima
            if (regla.min && valor.length < regla.min) {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.min;
                error.classList.remove('hidden');
                return;
            }

            // 🔴 3. Longitud máxima
            if (regla.max && valor.length > regla.max) {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.max;
                error.classList.remove('hidden');
                return;
            }

            // 🔴 4. Validación personalizada
            if (regla.custom && !regla.custom(valor)) {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.custom;
                error.classList.remove('hidden');
                return;
            }

            // 🔴 5. Regex (estructura final)
            if (regla.regex && !regla.regex.test(valor)) {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.regex;
                error.classList.remove('hidden');
                return;
            }

            // 🟢 Todo correcto
            input.classList.add('border-green-500');
        }

        function validarCampo(id) {

            const input = document.getElementById(id);
            const regla = reglasCrear[id];

            if (!input || !regla) return false;

            const valor = input.value.trim();

            if (regla.required && valor === '') return false;
            if (regla.min && valor.length < regla.min) return false;
            if (regla.max && valor.length > regla.max) return false;
            if (regla.regex && !regla.regex.test(valor)) return false;
            if (regla.custom && !regla.custom(valor)) return false;

            return true;
        }

        function validarFormularioCrear() {

            let todoValido = true;

            Object.keys(reglasCrear).forEach(id => {

                if (!validarCampo(id)) {
                    todoValido = false;
                }

            });

            btnGuardar.disabled = !todoValido;

            btnGuardar.classList.toggle('opacity-50', !todoValido);
            btnGuardar.classList.toggle('cursor-not-allowed', !todoValido);
        }

        /* ===========================
           VALIDACIÓN EDITAR
        ============================*/

        const editInputs = [
            'edit_documento', 'edit_nombres',
            'edit_apellidos', 'edit_telefono', 'edit_correo'
        ];

        editInputs.forEach(id => {
            document.getElementById(id)?.addEventListener('input', updateEditButton);
        });

        function validarEditar() {

            const doc = document.getElementById('edit_documento').value.trim();
            const nom = document.getElementById('edit_nombres').value.trim();
            const ape = document.getElementById('edit_apellidos').value.trim();
            const tel = document.getElementById('edit_telefono').value.trim();
            const cor = document.getElementById('edit_correo').value.trim();

            const regexDoc = /^[0-9]{6,10}$/;
            const regexTxt = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,50}$/;
            const regexTel = /^[0-9]{7,12}$/;
            const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            return (
                regexDoc.test(doc) &&
                regexTxt.test(nom) &&
                regexTxt.test(ape) &&
                regexTel.test(tel) &&
                regexCorreo.test(cor)
            );
        }

        function huboCambios() {

            return (
                originalEditData.documento !== document.getElementById('edit_documento').value.trim() ||
                originalEditData.nombres !== document.getElementById('edit_nombres').value.trim() ||
                originalEditData.apellidos !== document.getElementById('edit_apellidos').value.trim() ||
                originalEditData.telefono !== document.getElementById('edit_telefono').value.trim() ||
                originalEditData.correo !== document.getElementById('edit_correo').value.trim() ||
                originalEditData.nit !== document.getElementById('edit_nit').value ||
                originalEditData.estado !== document.getElementById('edit_estado').value
            );
        }

        function updateEditButton() {

            const valido = validarEditar();
            const cambiado = huboCambios();

            const activar = valido && cambiado;

            btnGuardarEdit.disabled = !activar;
            btnGuardarEdit.classList.toggle('opacity-50', !activar);
            btnGuardarEdit.classList.toggle('cursor-not-allowed', !activar);
        }

    });
</script>
@endsection
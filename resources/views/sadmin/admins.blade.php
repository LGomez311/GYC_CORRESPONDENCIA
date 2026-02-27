@extends('sadmin.layouts.app')

@section('title', 'Panel de Administradores')

@section('content')
<div class="p-4 md:p-8 max-w-7xl mx-auto w-full">

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

        {{-- MODAL EXPORTAR ADMINISTRADORES --}}
        <div id="exportModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

                <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                    Exportar Administradores
                </h3>

                <div class="flex flex-col gap-3">

                    <!-- PDF -->
                    <a href="{{ route('sadmin.export.pdf') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                        PDF
                    </a>

                    <!-- Excel -->
                    <a href="{{ route('sadmin.export.excel') }}"
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
                    @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center overflow-hidden">
                                    <img alt="Avatar" class="w-full h-full object-cover"
                                        src="{{ asset('storage/' . $user->emple_img) }}">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">
                                        {{ $user->emple_nombres }} {{ $user->emple_apellidos }}
                                    </span>
                                    <span class="text-xs text-[#4c669a] dark:text-gray-400">
                                        DOCUMENTO: {{ $user->emple_doc }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            <span class="text-sm font-bold text-[#0d121b] dark:text-white">
                                {{ $user->empresa?->nomb_empresa ?? 'Sin empresa' }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">
                                {{ $user->emple_tel }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">
                                {{ $user->emple_correo }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                            <span class="text-sm font-bold text-[#0d121b] dark:text-white">
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

                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-400">No hay administradores registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="flex gap-1 mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div id="userModal"
    class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl relative my-10 max-h-[90vh] flex flex-col overflow-hidden">
        <div class="px-6 pt-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
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
        </div>

        <form method="POST"
            action="{{ route('admins.store') }}"
            id="userForm"
            enctype="multipart/form-data"
            class="flex-1 overflow-y-auto px-6 pb-6 space-y-6">
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
                        inputmode="numeric"
                        pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        maxlength="10"
                        placeholder="Ingrese documento..."
                        value="{{ old('emple_doc') }}"
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="error-documento" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- EMPRESA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Empresa NIT (*)
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

                        @if ($users->count() == 0)
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm">
                                    <span class="material-symbols-outlined text-[18px]">info</span>
                                    No hay registros disponibles
                                </div>
                            </td>
                        </tr>
                        @endif
                        </tbody>
                        </table>
                        <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800">
                            {{ $users->links() }}
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
                        value="{{ old('emple_nombres') }}"
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
                        value="{{ old('emple_apellidos') }}"
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
                        inputmode="numeric"
                        pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        maxlength="12"
                        placeholder="Ingrese teléfono... "
                        value="{{ old('emple_tel') }}"
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
                        value="{{ old('emple_correo') }}"
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
                        maxlength="64"
                        oninput="this.value = this.value.replace(/\s/g, '')"
                        placeholder="Ingrese contraseña segura..."
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="error-password" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- FOTO -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Foto de perfil (Solo formato JPEG, PNG, WEBP)
                    </label>
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
                    class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center gap-2">
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
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Editar Administrador
                </h2>
                <p class="text-sm text-gray-500">
                    Modifique los datos del administrador, los campos con (*) son obligatorios.
                </p>
            </div>

            <button class="btn-close text-gray-500 hover:text-gray-800">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST"
            id="formEdit"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <input type="hidden" name="modal_type" value="edit">

                <!-- DOCUMENTO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Documento (*)
                    </label>
                    <input
                        type="text"
                        name="emple_doc"
                        id="edit_documento"
                        maxlength="10"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        placeholder="Ingrese documento..."
                        value="{{ old('emple_doc') }}"
                        readonly
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="edit-error-documento" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- EMPRESA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Empresa (NIT) (*)
                    </label>
                    <select
                        name="nit_empresa"
                        id="edit_nit"
                        class="mt-1 w-full rounded-lg border-gray-300">
                        <option value="">Seleccionar empresa...</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->nit_empresa }}"
                            {{ old('nit_empresa') == $empresa->nit_empresa ? 'selected' : '' }}>
                            {{ $empresa->nit_empresa }} - {{ $empresa->nomb_empresa }}
                        </option>
                        @endforeach
                    </select>
                    <p id="edit-error-nit" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- NOMBRES -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nombres (*)
                    </label>
                    <input
                        type="text"
                        name="emple_nombres"
                        id="edit_nombres"
                        maxlength="50"
                        placeholder="Ingrese nombres..."
                        value="{{ old('emple_nombres') }}"
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="edit-error-nombres" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- APELLIDOS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Apellidos (*)
                    </label>
                    <input
                        type="text"
                        name="emple_apellidos"
                        id="edit_apellidos"
                        maxlength="50"
                        placeholder="Ingrese apellidos..."
                        value="{{ old('emple_apellidos') }}"
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="edit-error-apellidos" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Teléfono (*)
                    </label>
                    <input
                        type="text"
                        name="emple_tel"
                        id="edit_telefono"
                        maxlength="12"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        placeholder="Ingrese teléfono..."
                        value="{{ old('emple_tel') }}"
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="edit-error-telefono" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- CORREO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Correo (*)
                    </label>
                    <input
                        type="email"
                        name="emple_correo"
                        id="edit_correo"
                        maxlength="150"
                        placeholder="Ingrese correo electrónico..."
                        value="{{ old('emple_correo') }}"
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="edit-error-correo" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- FOTO -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Foto de perfil (Solo formato JPEG, PNG, WEBP)
                    </label>
                    <input
                        type="file"
                        name="emple_img"
                        id="edit_imagen"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="mt-1 w-full rounded-lg border-gray-300">
                    <p id="edit-error-imagen" class="text-sm text-red-600 hidden"></p>
                </div>

                <!-- ESTADO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Estado
                    </label>
                    <select
                        name="emple_estado"
                        id="edit_estado"
                        class="mt-1 w-full rounded-lg border-gray-300">
                        <option value="">Seleccionar estado...</option>
                        @foreach($estados as $estado)
                        @if(in_array($estado->id_estado, [1, 2]))
                        <option value="{{ $estado->id_estado }}"
                            {{ old('emple_estado') == $estado->id_estado ? 'selected' : '' }}>
                            {{ $estado->estado_nomb }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <!-- ROL (Solo visual) -->
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

                <button
                    id="btnGuardarEdit"
                    type="submit"
                    class="px-6 py-2 rounded-lg bg-blue-600 text-white flex items-center gap-2 opacity-50 cursor-not-allowed">
                    <span class="material-symbols-outlined">save</span>
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Determinar qué modal abrir: 'create' o 'edit'
        const modalType = "{{ old('modal_type', 'create') }}"; // por defecto 'create'

        if (modalType === 'create') {
            const modalCrear = document.getElementById('userModal');
            modalCrear.classList.remove('hidden');

            // Llenar automáticamente los inputs con old()
            modalCrear.querySelectorAll('input, select, textarea').forEach(input => {
                const name = input.name;
                if (!name) return;

                const valorOld = "{{ old('" + name + "') }}";
                if (valorOld !== '') input.value = valorOld;
            });

            // Habilitar botón guardar
            const btnGuardar = document.getElementById('btnGuardar');
            btnGuardar.disabled = false;
            btnGuardar.classList.remove('opacity-50', 'cursor-not-allowed');

        } else if (modalType === 'edit') {
            const modalEditar = document.getElementById('userModalEdit');
            modalEditar.classList.remove('hidden');

            const documento = "{{ old('emple_doc') }}";

            if (documento) {
                document.getElementById('formEdit').action =
                    "{{ route('admins.update', ':id') }}".replace(':id', documento);
            }

            // Llenar automáticamente los inputs con old()
            modalEditar.querySelectorAll('input, select, textarea').forEach(input => {
                const name = input.name;
                if (!name) return;

                const valorOld = "{{ old('" + name + "') }}";
                if (valorOld !== '') input.value = valorOld;
            });

            // Habilitar botón guardar
            const btnGuardarEdit = document.getElementById('btnGuardarEdit');
            btnGuardarEdit.disabled = false;
            btnGuardarEdit.classList.remove('opacity-50', 'cursor-not-allowed');
        }

    });
</script>
@endif

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
                $('#edit_nit').val(data.nit).trigger('change');
                document.getElementById('edit_nombres').value = data.nombres;
                document.getElementById('edit_apellidos').value = data.apellidos;
                document.getElementById('edit_telefono').value = data.telefono;
                document.getElementById('edit_correo').value = data.correo;
                document.getElementById('edit_estado').value = data.estado;
                document.getElementById('formEdit').action =
                    "{{ route('admins.update', ':id') }}".replace(':id', data.documento);

                Object.keys(reglasEditar).forEach(id => {
                    validarCampoEditar(id);
                });

                btnGuardarEdit.disabled = false;
                btnGuardarEdit.classList.remove('opacity-50', 'cursor-not-allowed');

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
                    regex: 'Solo letras, tildes, sin espacios.',
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
                    regex: 'Solo letras, tildes, sin espacios.',
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
                    regex: 'Debe tener un formato válido ejemplo: texto@texto.dominio'
                }
            },

            password: {
                required: true,
                min: 10,
                max: 64,
                regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!"#$%&\/()=@])[^\s]{10,64}$/,
                error: 'error-password',
                mensajes: {
                    required: 'La contraseña es obligatoria.',
                    min: 'Debe tener mínimo 10 caracteres.',
                    max: 'No puede superar 64 caracteres.',
                    regex: 'Debe incluir: 1 mayúscula, 1 minúscula, 1 número, 1 carácter especial y no contener espacios.'
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

            //  VALIDACIÓN ESPECIAL PASSWORD
            if (id === 'password') {

                if (valor === '') {
                    input.classList.add('border-red-500');
                    error.textContent = regla.mensajes.required;
                    error.classList.remove('hidden');
                    return;
                }

                if (valor.length > 64) {
                    input.classList.add('border-red-500');
                    error.textContent = regla.mensajes.max;
                    error.classList.remove('hidden');
                    return;
                }

                const regexEstructura = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!"#$%&\/()=@.,;:?~^_*+\-])[^\s]{10,64}$/;

                if (!regexEstructura.test(valor)) {
                    input.classList.add('border-red-500');
                    error.textContent = regla.mensajes.regex;
                    error.classList.remove('hidden');
                    return;
                }

                if (valor.length < regla.min) {
                    input.classList.add('border-red-500');
                    error.textContent = regla.mensajes.min;
                    error.classList.remove('hidden');
                    return;
                }

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



        /* ===========================
           VALIDACIÓN EDITAR
        ============================*/

        function validarImagenEdit() {

            const inputImagenEdit = document.getElementById('edit_imagen');
            const errorImagenEdit = document.getElementById('edit-error-imagen');

            const archivo = inputImagenEdit.files[0];

            if (!archivo) return true;

            const tamañoMaximo = 2 * 1024 * 1024;
            const tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

            if (archivo.size > tamañoMaximo) {

                errorImagenEdit.textContent = "La imagen no puede superar los 2MB";
                errorImagenEdit.classList.remove('hidden');

                Swal.fire({
                    icon: 'error',
                    title: 'Archivo demasiado grande',
                    text: 'La imagen no puede superar los 2MB',
                    confirmButtonText: 'OK'
                });

                return false;
            }

            if (!tiposPermitidos.includes(archivo.type)) {

                errorImagenEdit.textContent = "Formato inválido. Solo JPG, PNG o WEBP.";
                errorImagenEdit.classList.remove('hidden');

                Swal.fire({
                    icon: 'error',
                    title: 'Formato inválido',
                    text: 'Solo se permiten imágenes JPG, PNG o WEBP.',
                    confirmButtonText: 'OK'
                });

                return false;
            }

            errorImagenEdit.classList.add('hidden');
            return true;
        }

        let ultimoEnvio = 0;

        document.getElementById('formEdit').addEventListener('submit', function(e) {

            const ahora = Date.now();
            const diferencia = ahora - ultimoEnvio;

            // ⛔ Si intenta enviar antes de 2 segundos
            if (diferencia < 2000) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Espera un momento',
                    text: 'Por favor espera antes de enviar nuevamente.',
                    timer: 1500,
                    confirmButtonText: 'OK'
                });

                return;
            }

            // Guardamos el momento del envío
            ultimoEnvio = ahora;

            //  Validar campos
            if (!validarEditar()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Errores de Validación',
                    text: 'Por favor, verifica los campos resaltados',
                    timer: 2000,
                    confirmButtonText: 'OK'
                });
                return;
            }

            //  Validar imagen
            if (!validarImagenEdit()) {
                e.preventDefault();
                return;
            }

            //  Validar cambios
            if (!huboCambios()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Sin cambios',
                    text: 'No hay cambios que guardar.',
                    timer: 2000,
                    confirmButtonText: 'OK'
                });
                return;
            }

        });

        const reglasEditar = {

            edit_documento: {
                required: true,
                min: 6,
                max: 10,
                regex: /^[0-9]+$/,
                custom: function(valor) {
                    return !/^(\d)\1+$/.test(valor);
                },
                error: 'edit-error-documento',
                mensajes: {
                    required: 'El documento es obligatorio.',
                    min: 'Debe tener mínimo 6 dígitos.',
                    max: 'No puede superar 10 dígitos.',
                    regex: 'Solo números sin espacios.',
                    custom: 'No se permiten números repetidos.'
                }
            },

            edit_nombres: {
                required: true,
                min: 3,
                max: 60,
                regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/,
                custom: function(valor) {
                    return valor.trim().split(/\s+/).length <= 2;
                },
                error: 'edit-error-nombres',
                mensajes: {
                    required: 'El nombre es obligatorio.',
                    min: 'Debe tener mínimo 3 letras.',
                    max: 'No puede superar 60 caracteres.',
                    regex: 'Solo letras, tildes, sin espacios.',
                    custom: 'Máximo 2 palabras.'
                }
            },

            edit_apellidos: {
                required: true,
                min: 3,
                max: 60,
                regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3,}( [A-Za-zÁÉÍÓÚáéíóúÑñ]{3,})?$/,
                custom: function(valor) {
                    return valor.trim().split(/\s+/).length <= 2;
                },
                error: 'edit-error-apellidos',
                mensajes: {
                    required: 'Los apellidos son obligatorios.',
                    min: 'Debe tener mínimo 3 letras.',
                    max: 'No puede superar 60 caracteres.',
                    regex: 'Solo letras, tildes, sin espacios.',
                    custom: 'Máximo 2 palabras.'
                }
            },

            edit_telefono: {
                required: true,
                min: 7,
                max: 12,
                regex: /^[0-9]+$/,
                error: 'edit-error-telefono',
                mensajes: {
                    required: 'El teléfono es obligatorio.',
                    min: 'Mínimo 7 dígitos.',
                    max: 'Máximo 12 dígitos.',
                    regex: 'Solo números.'
                }
            },

            edit_correo: {
                required: true,
                min: 8,
                max: 150,
                regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                error: 'edit-error-correo',
                mensajes: {
                    required: 'El correo es obligatorio.',
                    min: 'Debe tener mínimo 8 caracteres.',
                    max: 'No puede superar 150 caracteres.',
                    regex: 'Formato inválido.'
                }
            }
        };

        function validarCampoEditar(id) {

            const input = document.getElementById(id);
            const regla = reglasEditar[id];
            const error = document.getElementById(regla.error);
            const valor = input.value.trim();

            input.classList.remove('border-red-500', 'border-green-500');
            error.classList.add('hidden');

            if (regla.required && valor === '') {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.required;
                error.classList.remove('hidden');
                return false;
            }

            if (regla.min && valor.length < regla.min) {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.min;
                error.classList.remove('hidden');
                return false;
            }

            if (regla.max && valor.length > regla.max) {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.max;
                error.classList.remove('hidden');
                return false;
            }

            if (regla.custom && !regla.custom(valor)) {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.custom;
                error.classList.remove('hidden');
                return false;
            }

            if (regla.regex && !regla.regex.test(valor)) {
                input.classList.add('border-red-500');
                error.textContent = regla.mensajes.regex;
                error.classList.remove('hidden');
                return false;
            }

            input.classList.add('border-green-500');
            return true;
        }


        Object.keys(reglasEditar).forEach(id => {

            const input = document.getElementById(id);

            if (!input) return; // ← protección

            input.addEventListener('input', () => {
                validarCampoEditar(id);
            });

        });

        // Activar botón cuando cambian los selects
        ['edit_nit', 'edit_estado'].forEach(id => {
            const input = document.getElementById(id);
            if (!input) return;

            input.addEventListener('change', () => {});
        });

        function validarEditar() {

            let todoValido = true;

            Object.keys(reglasEditar).forEach(id => {
                if (!validarCampoEditar(id)) {
                    todoValido = false;
                }
            });

            return todoValido;
        }

        function huboCambios() {


            const fotoInput = document.querySelector('#userModalEdit input[name="emple_img"]');

            return (
                originalEditData.documento !== document.getElementById('edit_documento').value.trim() ||
                originalEditData.nombres !== document.getElementById('edit_nombres').value.trim() ||
                originalEditData.apellidos !== document.getElementById('edit_apellidos').value.trim() ||
                originalEditData.telefono !== document.getElementById('edit_telefono').value.trim() ||
                originalEditData.correo !== document.getElementById('edit_correo').value.trim() ||
                originalEditData.nit !== document.getElementById('edit_nit').value ||
                originalEditData.estado !== document.getElementById('edit_estado').value ||
                (fotoInput && fotoInput.files.length > 0)
            );
        }

        window.openExportModal = function() {
            document.getElementById('exportModal').classList.remove('hidden');
        }

        window.closeExportModal = function() {
            document.getElementById('exportModal').classList.add('hidden');
        }

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        $('#nit_empresa').select2({
            placeholder: "Buscar por NIT o nombre...",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#userModal')
        });

        $('#edit_nit').select2({
            placeholder: "Buscar por NIT o nombre...",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#userModalEdit')
        });

    });
</script>
@endsection
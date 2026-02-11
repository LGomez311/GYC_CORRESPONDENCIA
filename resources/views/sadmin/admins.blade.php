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
                <button onclick="openModal()"
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

            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Nombre del Administrador
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Empresa Asociada
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Correo Electrónico
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Estado
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-right">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                <!-- Nombre + Imagen -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center overflow-hidden">
                                            <img alt="Avatar" class="w-full h-full object-cover"
                                                src="{{ $user->emple_img ? asset('storage/' . $user->emple_img) : asset('img/default-user.png') }}">
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

                                <!-- Empresa -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-[#0d121b] dark:text-gray-300">
                                        {{ $user->empresa->nomb_empresa ?? 'Sin empresa asignada' }}
                                    </span>
                                </td>

                                <!-- Correo -->
                                <td class="px-6 py-4">
                                    <span class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">
                                        {{ $user->emple_correo }}
                                    </span>
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ $user->estado->estado_nomb ?? 'Sin estado' }}
                                    </span>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1">

                                        <button onclick="openModalProfile(this)"
                                            class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                            title="Ver detalles" data-documento="{{ $user->emple_doc }}"
                                            data-nit="{{ $user->empresa->nit_empresa ?? '' }}"
                                            data-empresa="{{ $user->empresa->nomb_empresa ?? '' }}"
                                            data-nombres="{{ $user->emple_nombres }}"
                                            data-apellidos="{{ $user->emple_apellidos }}"
                                            data-telefono="{{ $user->emple_tel }}" data-correo="{{ $user->emple_correo }}"
                                            data-estado="{{ $user->estado->estado_nomb ?? '' }}"
                                            data-rol="{{ $user->rol->rol_nomb ?? '' }}"
                                            data-area="{{ $user->area->area_nomb ?? '' }}"
                                            data-foto="{{ $user->emple_img ? asset('storage/' . $user->emple_img) : asset('img/default-user.png') }}">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>

                                        <button onclick='openModalEdit(@json($user))'
                                            class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Editar">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>

                                        <form action="{{ route('usuarios.destroy', $user->emple_doc) }}" method="POST"
                                            class="form-eliminar inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                                title="Eliminar">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center">
                                    <div
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                        bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm">
                                        <span class="material-symbols-outlined text-[18px]">info</span>
                                        No hay registros disponibles
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
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626'
            });
        </script>
    @endif
    <script>
        document.querySelectorAll('.form-eliminar').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Eliminar usuario?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection

@section('modals')

    <!-- Overlay -->
    <div id="modalOverlay" class="fixed inset-0 bg-black/40 hidden z-40"></div>

    <!-- Modal -->
    <div id="userModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    Registrar Nuevo Admin
                </h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('sadmin.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Documento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Documento</label>
                        <input name="emple_doc" id="documento" type="text" class="mt-1 w-full rounded-lg border-gray-300"
                            oninput="validateDocumento(this)">
                        <p id="error-documento" class="text-sm text-red-500 hidden">
                            Solo números, sin puntos
                        </p>

                    </div>

                    <!-- NIT Empresa (automático) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Empresa (NIT)</label>
                        <select name="nit_empresa" class="mt-1 w-full rounded-lg border-gray-300">
                            <option value="">Seleccione una empresa</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->nit_empresa }}">
                                    {{ $empresa->nit_empresa }} - {{ $empresa->nomb_empresa }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Nombres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombres</label>
                        <input name="emple_nombres" id="nombres" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateTexto(this, 'error-nombres')">
                        <p id="error-nombres" class="text-sm text-red-500 hidden">
                            Solo letras, primera letra en mayúscula
                        </p>

                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input name="emple_apellidos" id="apellidos" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300"
                            oninput="validateTexto(this, 'error-apellidos')">
                        <p id="error-apellidos" class="text-sm text-red-500 hidden">
                            Solo letras, primera letra en mayúscula
                        </p>

                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input name="emple_tel" id="telefono" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateTelefono(this)">
                        <p id="error-telefono" class="text-sm text-red-500 hidden">
                            Solo números, máximo 10 dígitos
                        </p>

                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input name="emple_correo" id="correo" type="email"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateCorreo(this)">
                        <p id="error-correo" class="text-sm text-red-500 hidden">
                            Correo electrónico inválido
                        </p>

                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input name="password" id="password" type="password"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validatePassword(this)">
                        <p id="error-password" class="text-sm text-red-500 hidden">
                            Mín 8 caracteres, 1 minúscula y 3 números
                        </p>

                    </div>

                    <!-- Foto de perfil -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto de perfil</label>
                        <input name="emple_img" type="file" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <!-- Estado (automático) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select disabled class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100">
                            <option>Activo</option>
                        </select>
                    </div>

                    <input type="hidden" name="emple_estado" value="1">
                    <input type="hidden" name="emple_rol" value="2">


                    <!-- Rol (automático) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select disabled class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100">
                            <option>Administrador Empresa</option>
                        </select>
                    </div>

                </div>

                <!-- Acciones -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                        Cancelar
                    </button>
                    <button id="btnGuardar" type="submit" disabled
                        class="px-6 py-2 rounded-lg bg-blue-600 text-white opacity-50 cursor-not-allowed">
                        Registrar Usuario
                    </button>

                </div>

            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function openModal() {
            document.getElementById('userModal').classList.remove('hidden');
            document.getElementById('modalOverlay').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('modalOverlay').classList.add('hidden');
        }
    </script>
    <script>
        let valid = {
            documento: false,
            nombres: false,
            apellidos: false,
            telefono: false,
            correo: false,
            password: false
        };

        // Solo números
        function validateDocumento(input) {
            input.value = input.value.replace(/\D/g, '');
            valid.documento = input.value.length > 0;
            toggleError('error-documento', !valid.documento);
            checkForm();
        }

        // Letras + primera mayúscula
        function validateTexto(input, errorId) {
            input.value = input.value
                .replace(/[^a-zA-Z\s]/g, '')
                .replace(/\b\w/g, l => l.toUpperCase());

            const isValid = /^[A-Z][a-zA-Z\s]*$/.test(input.value);
            valid[input.id] = isValid;
            toggleError(errorId, !isValid);
            checkForm();
        }

        // Teléfono
        function validateTelefono(input) {
            input.value = input.value.replace(/\D/g, '').slice(0, 10);
            valid.telefono = input.value.length === 10;
            toggleError('error-telefono', !valid.telefono);
            checkForm();
        }

        // Correo
        function validateCorreo(input) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            valid.correo = regex.test(input.value);
            toggleError('error-correo', !valid.correo);
            checkForm();
        }

        // Contraseña
        function validatePassword(input) {
            const numbers = input.value.replace(/\D/g, '').length;
            const regex = /^(?=.*[a-z]).{8,}$/;

            valid.password = regex.test(input.value) && numbers >= 3;
            toggleError('error-password', !valid.password);
            checkForm();
        }

        // Mostrar / ocultar errores
        function toggleError(id, show) {
            document.getElementById(id).classList.toggle('hidden', !show);
        }

        // Habilitar botón
        function checkForm() {
            const isValid = Object.values(valid).every(v => v === true);
            const btn = document.getElementById('btnGuardar');

            btn.disabled = !isValid;
            btn.classList.toggle('opacity-50', !isValid);
            btn.classList.toggle('cursor-not-allowed', !isValid);
        }
    </script>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#16a34a'
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc2626'
            });
        </script>
    @endif

    @if (session()->has('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#d97706'
            });
        </script>
    @endif

    @if (session()->has('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Información',
                text: "{{ session('info') }}",
                confirmButtonColor: '#2563eb'
            });
        </script>
    @endif




    {{--  Formulario de editar usuarios --}}


    <!-- Overlay -->
    <div id="modalOverlayEdit" class="fixed inset-0 bg-black/40 hidden z-40"></div>

    <!-- Modal -->
    <div id="userModalEdit" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    Editar Admin
                </h2>
                <button onclick="closeModalEdit()" class="text-gray-500 hover:text-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>


            <!-- Formulario -->
            <form method="POST" action="" id="formEdit" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Documento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Documento</label>
                        <input name="emple_doc" id="edit_documento" class="mt-1 w-full rounded-lg border-gray-300"
                            oninput="validateDocumento(this)">
                        <p id="error-documento" class="text-sm text-red-500 hidden">
                            Solo números, sin puntos
                        </p>

                    </div>

                    <!-- NIT Empresa (automático) -->

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Empresa (NIT)</label>
                        <select name="nit_empresa" id="edit_empresa" class="mt-1 w-full rounded-lg border-gray-300">
                            <option value="">Seleccione una empresa</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->nit_empresa }}">
                                    {{ $empresa->nit_empresa }} - {{ $empresa->nomb_empresa }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Nombres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombres</label>
                        <input name="emple_nombres" id="edit_nombres" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateTexto(this, 'error-nombres')">
                        <p id="error-nombres" class="text-sm text-red-500 hidden">
                            Solo letras, primera letra en mayúscula
                        </p>

                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input name="emple_apellidos" id="edit_apellidos" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300"
                            oninput="validateTexto(this, 'error-apellidos')">
                        <p id="error-apellidos" class="text-sm text-red-500 hidden">
                            Solo letras, primera letra en mayúscula
                        </p>

                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input name="emple_tel" id="edit_telefono" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateTelefono(this)">
                        <p id="error-telefono" class="text-sm text-red-500 hidden">
                            Solo números, máximo 10 dígitos
                        </p>

                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input name="emple_correo" id="edit_correo" type="email"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateCorreo(this)">
                        <p id="error-correo" class="text-sm text-red-500 hidden">
                            Correo electrónico inválido
                        </p>

                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input name="password" id="edit_password" type="password"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validatePassword(this)">
                        <p id="error-password" class="text-sm text-red-500 hidden">
                            Mín 8 caracteres, 1 minúscula y 3 números
                        </p>

                    </div>

                    <!-- Foto de perfil -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto de perfil</label>
                        <input name="emple_img" type="file" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <!-- Estado (automático) -->
                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="emple_estado" id="edit_estado" class="mt-1 w-full rounded-lg border-gray-300">
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado }}">
                                    {{ $estado->estado_nomb }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Rol (automático) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select disabled class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100">
                            <option>Administrador Empresa</option>
                        </select>
                    </div>

                </div>

                <!-- Acciones -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModalEdit()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button id="btnGuardarEdit" type="submit"
                        class="px-6 py-2 rounded-lg bg-blue-600 text-white opacity-50 cursor-not-allowed">
                        Actualizar Usuario
                    </button>

                </div>

            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function openModalEdit(user) {

            const form = document.getElementById('formEdit');
            form.action = `{{ url('sadmin/admins') }}/${user.emple_doc}`;

            document.getElementById('edit_documento').value = user.emple_doc;
            document.getElementById('edit_nombres').value = user.emple_nombres;
            document.getElementById('edit_apellidos').value = user.emple_apellidos;
            document.getElementById('edit_telefono').value = user.emple_tel;
            document.getElementById('edit_correo').value = user.emple_correo;

            // 🔹 Empresa actual
            document.getElementById('edit_empresa').value = user.nit_empresa;

            // 🔹 Estado actual
            document.getElementById('edit_estado').value = user.emple_estado;

            document.getElementById('edit_password').value = '';

            document.getElementById('userModalEdit').classList.remove('hidden');
            document.getElementById('modalOverlayEdit').classList.remove('hidden');
        }
    </script>


    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#16a34a'
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc2626'
            });
        </script>
    @endif

    @if (session()->has('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#d97706'
            });
        </script>
    @endif

    @if (session()->has('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Información',
                text: "{{ session('info') }}",
                confirmButtonColor: '#2563eb'
            });
        </script>
    @endif






    {{-- Mostrar perfil --}}
    <!-- Overlay -->
    <div id="modalOverlayProfile" class="fixed inset-0 bg-black/40 hidden z-40"></div>

    <!-- Modal Perfil -->
    <div id="userModalProfile" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    Perfil del Usuario
                </h2>
                <button onclick="closeModalProfile()" class="text-gray-500 hover:text-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Contenido -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Foto de perfil -->
                <div class="flex flex-col items-center gap-4">
                    <img id="profile_foto"
                        src="{{ $user->emple_img ? asset('storage/' . $user->emple_img) : asset('img/default-user.png') }}"
                        class="w-40 h-40 rounded-full object-cover border shadow" alt="Foto de perfil">

                    <span class="text-sm text-gray-500">Foto de perfil</span>
                </div>


                <!-- Datos -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Documento -->
                    <div>
                        <label class="text-sm text-gray-500">Documento</label>
                        <p id="profile_documento" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="text-sm text-gray-500">Estado</label>
                        <p id="profile_estado" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- NIT Empresa -->
                    <div>
                        <label class="text-sm text-gray-500">NIT Empresa</label>
                        <p id="profile_nit" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Nombre Empresa -->
                    <div>
                        <label class="text-sm text-gray-500">Empresa</label>
                        <p id="profile_empresa" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Nombres -->
                    <div>
                        <label class="text-sm text-gray-500">Nombres</label>
                        <p id="profile_nombres" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label class="text-sm text-gray-500">Apellidos</label>
                        <p id="profile_apellidos" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="text-sm text-gray-500">Teléfono</label>
                        <p id="profile_telefono" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="text-sm text-gray-500">Correo</label>
                        <p id="profile_correo" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Rol -->
                    <div>
                        <label class="text-sm text-gray-500">Rol</label>
                        <p id="profile_rol" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Área -->
                    <div>
                        <label class="text-sm text-gray-500">Área</label>
                        <p id="profile_area" class="font-medium text-gray-800"></p>
                    </div>



                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end pt-6 border-t mt-6">
                <button onclick="closeModalProfile()"
                    class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
    <script>
        function openModalProfile(btn) {

            document.getElementById('profile_documento').textContent = btn.dataset.documento;
            document.getElementById('profile_nit').textContent = btn.dataset.nit;
            document.getElementById('profile_empresa').textContent = btn.dataset.empresa;
            document.getElementById('profile_nombres').textContent = btn.dataset.nombres;
            document.getElementById('profile_apellidos').textContent = btn.dataset.apellidos;
            document.getElementById('profile_telefono').textContent = btn.dataset.telefono;
            document.getElementById('profile_correo').textContent = btn.dataset.correo;
            document.getElementById('profile_estado').textContent = btn.dataset.estado;
            document.getElementById('profile_rol').textContent = btn.dataset.rol;
            document.getElementById('profile_area').textContent = btn.dataset.area;



            // Foto
            document.getElementById('profile_foto').src =
                btn.dataset.foto && btn.dataset.foto !== '' ?
                btn.dataset.foto :
                '/img/default-user.png';

            // Mostrar modal
            document.getElementById('modalOverlayProfile').classList.remove('hidden');
            document.getElementById('userModalProfile').classList.remove('hidden');
        }

        function closeModalProfile() {
            document.getElementById('modalOverlayProfile').classList.add('hidden');
            document.getElementById('userModalProfile').classList.add('hidden');
        }
    </script>



@endsection

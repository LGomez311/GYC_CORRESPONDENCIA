@extends('admin.layouts.app')

@section('title', 'Gestión de Ciudades')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- ================= HEADER ================= -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

            <div>
                <div class="mb-3">
                    <a href="{{ route('admin.otros') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 
                    bg-white dark:bg-[#161d2b]
                    border border-[#cfd7e7] dark:border-gray-700
                    text-[#4c669a] dark:text-gray-300
                    rounded-lg text-sm font-medium
                    hover:bg-gray-100 dark:hover:bg-gray-800
                    transition-all duration-200">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Regresar
                    </a>
                </div>

                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight">
                    Gestión de Ciudades
                </h1>

                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Administre las ciudades del sistema.
                </p>
            </div>

            <button onclick="openCreateModal()"
                class="w-full sm:w-auto px-5 py-2.5 bg-primary text-white rounded-lg 
            font-bold text-sm flex items-center justify-center gap-2 
            shadow-lg shadow-primary/20 
            hover:bg-primary/90 transition-all duration-200">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Añadir Ciudad
            </button>
        </div>

        <!-- ================= TABLA ================= -->
        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">

            <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">
                    Ciudades Registradas
                </h2>

                <div class="flex gap-2">
                    <button onclick="openExportModal()"
                        class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Exportar
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-[700px] w-full text-sm border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-center whitespace-nowrap">
                                Código Postal
                            </th>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-center whitespace-nowrap">
                                Ciudad
                            </th>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-center whitespace-nowrap">
                                Departamento
                            </th>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-center whitespace-nowrap">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @foreach ($ciudades as $ciudad)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    {{ $ciudad->ciudad_cod_post }}
                                </td>

                                <td class="px-6 py-4 text-center font-bold whitespace-nowrap">
                                    {{ $ciudad->ciudad_nom }}
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    {{ $ciudad->departamento->dpto_nombre ?? '' }}
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex justify-center gap-2">
                                        <button
                                            onclick="openEditModal(
                                    '{{ $ciudad->ciudad_cod_post }}',
                                    '{{ $ciudad->ciudad_nom }}',
                                    '{{ $ciudad->ciudad_id_dpto }}'
                                )"
                                            class="p-2 text-[#4c669a] hover:text-primary transition">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800">
                {{ $ciudades->links() }}
            </div>

        </div>
    </div>
@endsection

@section('modals')

    <!-- MODAL CREAR -->
    <div id="createModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6">

            <h2 class="text-lg font-bold mb-4 dark:text-white">Crear Ciudad</h2>

            <form action="{{ route('admin.ciudad.store') }}" method="POST" id="createForm">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="ciudad_nom" name="ciudad_nom"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Código Postal</label>
                    <input type="text" id="ciudad_cod_post" name="ciudad_cod_post"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Departamento</label>
                    <select name="ciudad_id_dpto" required
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                        <option value="">Seleccione un departamento</option>
                        @foreach ($departamentos as $dpto)
                            <option value="{{ $dpto->dpto_codigo_postal }}">
                                {{ $dpto->dpto_nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6">

            <h2 class="text-lg font-bold mb-4 dark:text-white">Editar Ciudad</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="edit_ciudad_nom" name="ciudad_nom" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Código Postal</label>
                    <input type="text" id="edit_ciudad_cod_post" name="ciudad_cod_post"
                        class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Departamento</label>
                    <select id="edit_ciudad_id_dpto" name="ciudad_id_dpto" class="w-full px-3 py-2 border rounded-lg">
                        @foreach ($departamentos as $dpto)
                            <option value="{{ $dpto->dpto_codigo_postal }}">
                                {{ $dpto->dpto_nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EXPORTAR -->
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                Exportar Ciudades
            </h3>

            <div class="flex flex-col gap-3">
                <a href="{{ route('admin.ciudad.export.pdf') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <a href="{{ route('admin.ciudad.export.excel') }}"
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

@endsection

@section('scripts')
    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.getElementById('createModal').classList.add('flex');
        }

        function closeModals() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('editModal').classList.add('hidden');
        }

        function openExportModal() {
            document.getElementById('exportModal').classList.remove('hidden');
            document.getElementById('exportModal').classList.add('flex');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.add('hidden');
            document.getElementById('exportModal').classList.remove('flex');
        }
    </script>

    <script>
        // ============================
        // UTILIDADES
        // ============================

        function setError(input, message) {
            input.classList.add('border-red-500');
            input.classList.remove('border-green-500');

            let small = input.parentNode.querySelector('.error-text');
            if (!small) {
                small = document.createElement('small');
                small.classList.add('error-text', 'text-red-500', 'block', 'mt-1');
                input.parentNode.appendChild(small);
            }
            small.innerText = message;
        }

        function setSuccess(input) {
            input.classList.remove('border-red-500');
            input.classList.add('border-green-500');

            let small = input.parentNode.querySelector('.error-text');
            if (small) small.remove();
        }

        // ============================
        // ELEMENTOS CREAR
        // ============================

        const nombre = document.getElementById('ciudad_nom');
        const codigo = document.getElementById('ciudad_cod_post');
        const departamento = document.querySelector('#createForm select[name="ciudad_id_dpto"]');
        const form = document.getElementById('createForm');

        let codigoValido = false;


        // ============================
        // ELEMENTOS EDITAR
        // ============================

        const editNombre = document.getElementById('edit_ciudad_nom');
        const editCodigo = document.getElementById('edit_ciudad_cod_post');
        const editDepartamento = document.getElementById('edit_ciudad_id_dpto');
        const editForm = document.getElementById('editForm');

        let editCodigoValido = true;
        let codigoActual = "";


        // ============================
        // CAPITALIZAR FUNCIÓN
        // ============================

        function validarNombre(input) {

            let value = input.value.trim();

            value = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            value = value.replace(/\s{2,}/g, ' ');
            value = value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());

            input.value = value;

            if (value.length < 3) {
                setError(input, "Debe tener mínimo 3 caracteres");
                return false;
            }

            if (value.length > 60) {
                setError(input, "Máximo 60 caracteres");
                return false;
            }

            const regex = /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)*$/;

            if (!regex.test(value)) {
                setError(input, "Solo letras y cada palabra debe iniciar en mayúscula");
                return false;
            }

            setSuccess(input);
            return true;
        }


        // ============================
        // VALIDAR CÓDIGO POSTAL
        // ============================

        function validarCodigo(input, esEditar = false) {

            let value = input.value.trim();

            // Eliminar cualquier cosa que no sea número
            value = value.replace(/\D/g, '');
            input.value = value;

            // Obligatorio
            if (value.length === 0) {
                setError(input, "El código postal es obligatorio");
                return false;
            }

            // Debe ser exactamente 5 dígitos (estándar Colombia)
            if (!/^\d{5}$/.test(value)) {
                setError(input, "Debe contener exactamente 5 dígitos");
                return false;
            }

            // Si estamos editando y no cambió el código, no validar duplicado
            if (esEditar && value === codigoActual) {
                setSuccess(input);
                editCodigoValido = true;
                return true;
            }

            // ============================
            // VALIDACIÓN AJAX (ANTI DUPLICADO)
            // ============================

            fetch("{{ route('admin.ciudad.check') }}?codigo=" +
                    value + "&actual=" + (esEditar ? codigoActual : ""))
                .then(response => response.json())
                .then(data => {

                    if (data.exists) {
                        setError(input, "Este código postal ya está registrado");
                        if (esEditar) editCodigoValido = false;
                        else codigoValido = false;
                    } else {
                        setSuccess(input);
                        if (esEditar) editCodigoValido = true;
                        else codigoValido = true;
                    }

                })
                .catch(() => {
                    setError(input, "Error verificando el código");
                });

            return true;
        }


        // ============================
        // EVENTOS CREAR
        // ============================

        nombre.addEventListener('input', function() {
            validarNombre(this);
        });

        codigo.addEventListener('input', function() {
            validarCodigo(this);
        });

        departamento.addEventListener('change', function() {
            if (!this.value) setError(this, "Seleccione un departamento");
            else setSuccess(this);
        });

        form.addEventListener('submit', function(e) {

            let nombreOk = validarNombre(nombre);
            let codigoOk = validarCodigo(codigo);
            let departamentoOk = departamento.value !== "";

            if (!departamentoOk) {
                setError(departamento, "Seleccione un departamento");
            }

            if (!nombreOk || !codigoOk || !departamentoOk || !codigoValido) {
                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Formulario inválido',
                    text: 'Corrige los errores antes de continuar'
                });
            }

        });


        // ============================
        // EVENTOS EDITAR
        // ============================

        editNombre.addEventListener('input', function() {
            validarNombre(this);
        });

        editCodigo.addEventListener('input', function() {
            validarCodigo(this, true);
        });

        editDepartamento.addEventListener('change', function() {
            if (!this.value) setError(this, "Seleccione un departamento");
            else setSuccess(this);
        });

        editForm.addEventListener('submit', function(e) {

            let nombreOk = validarNombre(editNombre);
            let codigoOk = validarCodigo(editCodigo, true);
            let departamentoOk = editDepartamento.value !== "";

            if (!departamentoOk) {
                setError(editDepartamento, "Seleccione un departamento");
            }

            if (!nombreOk || !codigoOk || !departamentoOk || !editCodigoValido) {
                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Formulario inválido',
                    text: 'Corrige los errores antes de continuar'
                });
            }

        });


        // ============================
        // CUANDO ABRE MODAL EDITAR
        // ============================

        function openEditModal(id, nombre, cod, dpto) {

            codigoActual = cod; // Guardamos código actual

            let url = "{{ route('admin.ciudad.update', ['id' => '__ID__']) }}";
            url = url.replace('__ID__', id);

            editForm.action = url;
            editNombre.value = nombre;
            editCodigo.value = cod;
            editDepartamento.value = dpto;

            editCodigoValido = true;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }
    </script>
@endsection

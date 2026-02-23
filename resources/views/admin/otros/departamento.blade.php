@extends('admin.layouts.app')

@section('title', 'Gestión de Departamentos')

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
                    Gestión de Departamentos
                </h1>

                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Administre los departamentos del sistema.
                </p>
            </div>

            <button onclick="openCreateModal()"
                class="w-full sm:w-auto px-5 py-2.5 bg-primary text-white rounded-lg 
            font-bold text-sm flex items-center justify-center gap-2 
            shadow-lg shadow-primary/20 
            hover:bg-primary/90 transition-all duration-200">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Añadir Departamento
            </button>
        </div>

        <!-- ================= TABLA ================= -->
        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
            <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Departamentos Registrados</h2>

                <div class="flex gap-2">
                    <button onclick="openExportModal()"
                        class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Exportar
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-center">Código Postal</th>
                            <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-center">Nombre</th>
                            <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @foreach ($departamentos as $dpto)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                <td class="px-4 sm:px-6 py-3 text-center">
                                    {{ $dpto->dpto_codigo_postal }}
                                </td>

                                <td class="px-4 sm:px-6 py-3 text-center font-bold">
                                    {{ $dpto->dpto_nombre }}
                                </td>

                                <td class="px-4 sm:px-6 py-3 text-center">
                                    <div class="flex justify-center gap-2 flex-wrap">

                                        <button
                                            onclick="openEditModal('{{ $dpto->dpto_codigo_postal }}','{{ $dpto->dpto_nombre }}')"
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
                {{ $departamentos->links() }}
            </div>

        </div>
    </div>
@endsection


@section('modals')

    <!-- ================= MODAL CREAR ================= -->
    <div id="createModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/40 px-4">
        <div class="bg-white dark:bg-gray-900 w-full max-w-md rounded-xl shadow-2xl p-5 sm:p-6 relative">

            <h2 class="text-lg font-bold mb-4 dark:text-white">Crear Departamento</h2>

            <form id="createForm" action="{{ route('admin.departamento.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="dpto_nombre" name="dpto_nombre"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Código Postal</label>
                    <input type="text" id="dpto_codigo_postal" name="dpto_codigo_postal"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">
                        Guardar
                    </button>
                </div>
            </form>

            <button onclick="closeModals()" class="absolute top-3 right-3">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>


    <!-- ================= MODAL EDITAR ================= -->
    <div id="editModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/40 px-4">
        <div class="bg-white dark:bg-gray-900 w-full max-w-md rounded-xl shadow-2xl p-5 sm:p-6 relative">

            <h2 class="text-lg font-bold mb-4 dark:text-white">Editar Departamento</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Código Postal</label>
                    <input type="text" id="edit_dpto_codigo_postal" name="dpto_codigo_postal" maxlength="10"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="editNombre" name="dpto_nombre"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">
                        Actualizar
                    </button>
                </div>
            </form>

            <button onclick="closeModals()" class="absolute top-3 right-3">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>

    {{-- ================= MODAL EXPORTAR ================= --}}
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5 relative">

            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                Exportar Departamentos
            </h3>

            <div class="flex flex-col gap-3">

                <!-- PDF -->
                <a href="{{ route('admin.departamento.export.pdf') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <!-- Excel -->
                <a href="{{ route('admin.departamento.export.excel') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="material-symbols-outlined text-green-600">grid_on</span>
                    Excel
                </a>

            </div>

            <button onclick="closeExportModal()"
                class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                Cancelar
            </button>

            <!-- Botón cerrar X -->
            <button onclick="closeExportModal()" class="absolute top-2 right-2">
                <span class="material-symbols-outlined text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    close
                </span>
            </button>

        </div>
    </div>
@endsection
@section('scripts')

    <script>
        // ============================
        // CONTROL GENERAL DE MODALES
        // ============================

        function openCreateModal() {
            const modal = document.getElementById('createModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function openEditModal(codigo, nombre) {

            let url = "{{ route('admin.departamento.update', ['id' => '__ID__']) }}";
            url = url.replace('__ID__', id);

            document.getElementById('editForm').action = url;
            document.getElementById('editNombre').value = nombre;

            const codigoInput = document.getElementById('edit_dpto_codigo_postal');
            codigoInput.value = codigo;
            codigoInput.dataset.actual = codigo;

            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }

        function closeModals() {
            document.querySelectorAll('#createModal, #editModal, #exportModal')
                .forEach(modal => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });

            document.body.classList.remove('overflow-hidden');
        }

        // Cerrar al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (
                e.target.id === 'createModal' ||
                e.target.id === 'editModal' ||
                e.target.id === 'exportModal'
            ) {
                closeModals();
            }
        });

        // Cerrar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                closeModals();
            }
        });
    </script>

    <script>
        // ============================
        // VALIDACIONES PROFESIONALES
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
        // ELEMENTOS
        // ============================

        const nombre = document.getElementById('dpto_nombre');
        const codigo = document.getElementById('dpto_codigo_postal');
        const form = document.getElementById('createForm');

        const editNombre = document.getElementById('editNombre');
        const editCodigo = document.getElementById('editCodigo');
        const editForm = document.getElementById('editForm');

        let codigoValido = false;
        let editCodigoValido = true;

        // ============================
        // VALIDAR NOMBRE
        // ============================

        function validarNombre(input) {

            let value = input.value;

            value = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            value = value.replace(/\s{2,}/g, ' ');
            value = value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());

            input.value = value;

            const regex = /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)*$/;

            if (value.length < 3) {
                setError(input, "Debe tener mínimo 3 caracteres");
                return false;
            }

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

            input.value = input.value.replace(/[^0-9]/g, '');

            const value = input.value;

            if (value.length === 0) {
                setError(input, "El código postal es obligatorio");
                return Promise.resolve(false);
            }

            if (!/^[0-9]+$/.test(value)) {
                setError(input, "Solo se permiten números");
                return Promise.resolve(false);
            }

            if (value.length < 2) {
                setError(input, "Debe tener mínimo 2 dígitos");
                return Promise.resolve(false);
            }

            if (value.length > 10) {
                setError(input, "Máximo 10 dígitos");
                return Promise.resolve(false);
            }

            // VALIDACIÓN AJAX ANTI DUPLICADOS
            return fetch("{{ route('admin.departamento.check') }}?codigo=" +
                    value +
                    "&actual=" + (esEditar ? input.dataset.actual || "" : ""))
                .then(response => response.json())
                .then(data => {

                    if (data.exists) {
                        setError(input, "Este código ya está registrado");

                        if (esEditar) editCodigoValido = false;
                        else codigoValido = false;

                        return false;

                    } else {
                        setSuccess(input);

                        if (esEditar) editCodigoValido = true;
                        else codigoValido = true;

                        return true;
                    }
                })
                .catch(() => {
                    setError(input, "Error al validar el código");
                    return false;
                });
        }

        // ============================
        // EVENTOS CREAR
        // ============================

        if (nombre) {
            nombre.addEventListener('input', function() {
                validarNombre(this);
            });
        }

        if (codigo) {
            codigo.addEventListener('input', function() {
                validarCodigo(this);
            });
        }

        if (form) {
    form.addEventListener('submit', async function(e) {

        let nombreOk = validarNombre(nombre);
        let codigoOk = await validarCodigo(codigo);

        if (!nombreOk || !codigoOk) {
            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Formulario inválido',
                text: 'Corrige los errores antes de continuar'
            });

            return false;
        }

        // Si todo está bien, NO bloqueamos el submit
    });
}

        // ============================
        // EVENTOS EDITAR
        // ============================

        if (editNombre) {
            editNombre.addEventListener('input', function() {
                validarNombre(this);
            });
        }

        if (editCodigo) {
            editCodigo.addEventListener('input', function() {
                validarCodigo(this, true);
            });
        }

        if (editForm) {
    editForm.addEventListener('submit', async function(e) {

        let nombreOk = validarNombre(editNombre);
        let codigoOk = await validarCodigo(editCodigo, true);

        if (!nombreOk || !codigoOk) {
            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Formulario inválido',
                text: 'Corrige los errores antes de continuar'
            });

            return false;
        }

    });
}
    </script>

@endsection

@extends('admin.layouts.app')

@section('title', 'Gestión de Departamentos')

@section('content')
    <div class="w-full max-w-7xl mx-auto p-4 md:px-6 lg:px-8 py-6">

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
                <div class="flex flex-col md:flex-row gap-4 items-center w-full md:w-auto">

                    <!-- Search Bar -->
                    <form action="{{ route('admin.departamento.index') }}" method="GET" class="relative w-full md:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a] text-lg">search</span>
                        <input type="text" id="searchInputDpto" name="search" placeholder="Buscar..." value="{{ request('search') }}"
                            class="pl-10 pr-4 py-2 bg-white dark:bg-[#0d121b] border border-[#cfd7e7] dark:border-gray-800 rounded-lg text-sm focus:outline-none focus:border-primary transition-all w-full shadow-sm">
                    </form>

                    <button onclick="openExportModal()"
                        class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white w-full md:w-auto justify-center">
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
                {{ $departamentos->appends(['search' => request('search')])->links() }}
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

                <input type="hidden" name="form_type" value="create">

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="dpto_nombre" name="dpto_nombre"
                        value="{{ old('form_type') == 'create' ? old('dpto_nombre') : '' }}"
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'create' && $errors->has('dpto_nombre')) ? 'border-red-500' : '' }}" required minlength="3" maxlength="100" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$" title="Debe iniciar con al menos 3 letras continuas sin espacios">
                    @if(old('form_type') == 'create')
                        @error('dpto_nombre')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Código Postal</label>
                    <input type="text" id="dpto_codigo_postal" name="dpto_codigo_postal"
                        value="{{ old('form_type') == 'create' ? old('dpto_codigo_postal') : '' }}"
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'create' && $errors->has('dpto_codigo_postal')) ? 'border-red-500' : '' }}" required minlength="2" maxlength="10" pattern="^[0-9]+$" title="Solo se permiten números">
                    <small id="dptoCodStatus" class="block text-xs mt-1"></small>
                    @if(old('form_type') == 'create')
                        @error('dpto_codigo_postal')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
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

                <input type="hidden" name="form_type" value="edit">

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Código Postal</label>
                    <input type="text" id="edit_dpto_codigo_postal" name="dpto_codigo_postal" maxlength="10"
                        value="{{ old('form_type') == 'edit' ? old('dpto_codigo_postal') : '' }}"
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'edit' && $errors->has('dpto_codigo_postal')) ? 'border-red-500' : '' }}" required minlength="2" pattern="^[0-9]+$" title="Solo se permiten números">
                    <small id="editDptoCodStatus" class="block text-xs mt-1"></small>
                    @if(old('form_type') == 'edit')
                        @error('dpto_codigo_postal')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="mb-4 pt-2">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="editNombre" name="dpto_nombre"
                        value="{{ old('form_type') == 'edit' ? old('dpto_nombre') : '' }}"
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'edit' && $errors->has('dpto_nombre')) ? 'border-red-500' : '' }}" required minlength="3" maxlength="100" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$" title="Debe iniciar con al menos 3 letras continuas sin espacios">
                    @if(old('form_type') == 'edit')
                        @error('dpto_nombre')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ============================
        // VARIABLES GLOBALES DE VALIDACION
        // ============================
        let debounceTimer;
        let codigoActual = "";
        let codigoValidoCreate = false;
        let codigoValidoEdit = true; // Por defecto true al editar si no se toca

        document.addEventListener('DOMContentLoaded', function() {

            // ================= ALERTS DE SESIÓN Y ERRORES =================
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session("success") }}',
                    timer: 3000,
                    showConfirmButton: false,
                    position: 'center'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session("error") }}',
                    timer: 4000,
                    showConfirmButton: false,
                    position: 'center'
                });
            @endif

            @if($errors->any())
                let errorMessages = "";
                @foreach ($errors->all() as $error)
                    errorMessages += "• {{ $error }}\n";
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: errorMessages,
                    timer: 5000,
                    showConfirmButton: true,
                    position: 'center'
                });

                @if(old('form_type') == 'create')
                    openCreateModal();
                @elseif(old('form_type') == 'edit')
                    let id = "{{ old('dpto_codigo_postal') }}";
                    let url = "{{ route('admin.departamento.update', ['id' => '__ID__']) }}";
                    url = url.replace('__ID__', id);
                    document.getElementById('editForm').action = url;
                    codigoActual = id;
                    document.getElementById('editModal').classList.remove('hidden');
                    document.getElementById('editModal').classList.add('flex');
                    document.body.classList.add('overflow-hidden');
                @endif
            @endif


            // ============================
            // ELEMENTOS CREAR Y EDITAR
            // ============================

            const nombre = document.getElementById('dpto_nombre');
            const codigo = document.getElementById('dpto_codigo_postal');
            const btnCreate = document.querySelector('#createModal button[type="submit"]');

            const editNombre = document.getElementById('editNombre');
            const editCodigo = document.getElementById('edit_dpto_codigo_postal');
            const btnEdit = document.querySelector('#editModal button[type="submit"]');
            

            // ============================
            // EVENTOS CREAR
            // ============================

            if(nombre) {
                function validateNombreEv() {
                    nombre.dataset.dirty = 'true';
                    nombre.value = nombre.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
                    actualizarBoton(btnCreate, false, nombre, codigo);
                }
                nombre.addEventListener('input', validateNombreEv);
                if(nombre.value) validateNombreEv();
            }
            
            if(codigo) {
                function validateCodigoEv() {
                    codigo.dataset.dirty = 'true';
                    validarCodigo(codigo, false, btnCreate, nombre);
                }
                codigo.addEventListener('input', validateCodigoEv);
                if(codigo.value) validateCodigoEv();
            }

            // ============================
            // EVENTOS EDITAR
            // ============================

            if(editNombre) {
                function validateEditNombreEv() {
                    editNombre.dataset.dirty = 'true';
                    editNombre.value = editNombre.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
                    actualizarBoton(btnEdit, true, editNombre, editCodigo);
                }
                editNombre.addEventListener('input', validateEditNombreEv);
            }

            if(editCodigo) {
                function validateEditCodigoEv() {
                    editCodigo.dataset.dirty = 'true';
                    validarCodigo(editCodigo, true, btnEdit, editNombre);
                }
                editCodigo.addEventListener('input', validateEditCodigoEv);
            }

            // Client-side search for live experience
            liveSearch('searchInputDpto', 'table');

        }); // END DOMContentLoaded

        // ============================
        // MODALS
        // ============================
            
        function openCreateModal() {
            const form = document.querySelector('#createForm');
            if(form && "{{ old('form_type') }}" !== "create") form.reset();
            
            const inputs = ['dpto_nombre', 'dpto_codigo_postal'];
            inputs.forEach(id => {
                const el = document.getElementById(id);
                if(el && "{{ old('form_type') }}" !== "create") {
                    el.dataset.dirty = '';
                    limpiarError(el);
                }
            });

            if("{{ old('form_type') }}" !== "create") {
                const btn = document.querySelector('#createModal button[type="submit"]');
                if(btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
                const status = document.getElementById('dptoCodStatus');
                if(status) {
                    status.textContent = "";
                    status.classList.remove('text-green-600', 'text-red-500');
                }
            }

            const modal = document.getElementById('createModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        window.openEditModal = function(codigo, nombre_val) {
            codigoActual = codigo;

            let url = "{{ route('admin.departamento.update', ['id' => '__ID__']) }}";
            url = url.replace('__ID__', codigo);

            const editForm = document.getElementById('editForm');
            const editNombre = document.getElementById('editNombre');
            const editCodigo = document.getElementById('edit_dpto_codigo_postal');
            const editStatusCod = document.getElementById('editDptoCodStatus');

            editForm.action = url;
            editNombre.value = nombre_val;
            editCodigo.value = codigo;

            editNombre.dataset.dirty = '';
            editCodigo.dataset.dirty = '';

            limpiarError(editNombre);
            limpiarError(editCodigo);
            
            if(editStatusCod) {
                editStatusCod.textContent = "";
                editStatusCod.classList.remove('text-green-600', 'text-red-500');
            }

            codigoValidoEdit = true;

            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            
            if(editNombre) editNombre.dispatchEvent(new Event('input'));
        }

        function closeModals() {
            document.querySelectorAll('#createModal, #editModal, #exportModal')
                .forEach(modal => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });

            document.body.classList.remove('overflow-hidden');
        }

        // Cerrar al hacer clic fuera eliminado por requerimiento

        // Cerrar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                closeModals();
            }
        });

        function openExportModal() {
            const modal = document.getElementById('exportModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeExportModal() {
            const modal = document.getElementById('exportModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // ============================
        // UTILIDADES Y VALIDACIONES
        // ============================
        
        function mostrarError(input, mensaje) {
            input.classList.remove('border-green-500');
            input.classList.add('border-red-500');

            let error = input.parentNode.querySelector('.error-msg');
            if (!error) {
                error = document.createElement('p');
                error.classList.add('error-msg', 'text-red-500', 'text-sm', 'mt-1');
                input.parentNode.appendChild(error);
            }
            error.textContent = mensaje;
            error.classList.remove('server-error');
        }

        function limpiarError(input) {
            if(!input) return;
            let error = input.parentNode.querySelector('.error-msg');
            if (error && error.classList.contains('server-error') && !input.dataset.dirty) {
                return;
            }

            input.classList.remove('border-red-500');
            input.classList.add('border-gray-300', 'dark:border-gray-700');
            input.classList.add('border-green-500');

            if (error) error.remove();
        }

        function validarNombre(input) {
            if(!input) return false;
            let valor = input.value.trim();
            
            let serverError = input.parentNode.querySelector('.server-error');
            if (serverError && !input.dataset.dirty) {
                input.classList.remove('border-green-500', 'border-gray-300');
                input.classList.add('border-red-500');
                return false; 
            }

            if (valor.length < 3) {
                mostrarError(input, "Debe tener mínimo 3 caracteres.");
                return false;
            }

            if (valor.length > 100) {
                mostrarError(input, "No puede superar 100 caracteres.");
                return false;
            }

            if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/.test(valor)) {
                mostrarError(input, "Debe iniciar con al menos 3 letras continuas sin espacios.");
                return false;
            }

            if (valor.includes("  ")) {
                mostrarError(input, "No se permiten espacios dobles.");
                return false;
            }

            limpiarError(input);
            return true;
        }

        function validarCodigo(input, isEdit = false, btnToUpdate, inputNom) {
            let valor = input.value.replace(/\D/g, ''); 
            input.value = valor;
            
            const statusLabel = isEdit ? document.getElementById('editDptoCodStatus') : document.getElementById('dptoCodStatus');
            
            let serverError = input.parentNode.querySelector('.server-error');
            if (serverError && !input.dataset.dirty) {
                input.classList.remove('border-green-500', 'border-gray-300');
                input.classList.add('border-red-500');
                if(isEdit) codigoValidoEdit = false; else codigoValidoCreate = false;
                actualizarBoton(btnToUpdate, isEdit, inputNom);
                return;
            }

            if (valor.length === 0) {
                mostrarError(input, "El código postal es obligatorio.");
                if(isEdit) codigoValidoEdit = false; else codigoValidoCreate = false;
                if(statusLabel) statusLabel.textContent = "";
                actualizarBoton(btnToUpdate, isEdit, inputNom);
                return;
            }

            if (valor.length < 2 || valor.length > 10) {
                mostrarError(input, "Debe tener de 2 a 10 dígitos.");
                if(isEdit) codigoValidoEdit = false; else codigoValidoCreate = false;
                if(statusLabel) statusLabel.textContent = "";
                actualizarBoton(btnToUpdate, isEdit, inputNom);
                return;
            }

            if (isEdit && valor === codigoActual) {
                limpiarError(input);
                if(statusLabel) statusLabel.textContent = "";
                codigoValidoEdit = true;
                actualizarBoton(btnToUpdate, isEdit, inputNom);
                return;
            }

            // AJAX validation
            if(statusLabel) {
                statusLabel.textContent = "Verificando disponibilidad...";
                statusLabel.classList.remove("text-red-500", "text-green-600");
                statusLabel.classList.add("text-gray-500");
            }

            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetch(`{{ route('admin.departamento.check') }}?codigo=${valor}&actual=${isEdit ? codigoActual : ''}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            mostrarError(input, "Este código postal ya está registrado.");
                            if(statusLabel) {
                                statusLabel.textContent = "No disponible";
                                statusLabel.classList.remove("text-gray-500", "text-green-600");
                                statusLabel.classList.add("text-red-500");
                            }
                            if(isEdit) codigoValidoEdit = false; else codigoValidoCreate = false;
                        } else {
                            limpiarError(input);
                            if(statusLabel) {
                                statusLabel.textContent = "Disponible";
                                statusLabel.classList.remove("text-gray-500", "text-red-500");
                                statusLabel.classList.add("text-green-600", "font-medium");
                            }
                            if(isEdit) codigoValidoEdit = true; else codigoValidoCreate = true;
                        }
                        actualizarBoton(btnToUpdate, isEdit, inputNom);
                    })
                    .catch(error => {
                        console.error("Error al validar código postal", error);
                    });
            }, 500);
        }

        function actualizarBoton(btn, isEdit, inputNom) {
            if(!btn) return;
            const okNombre = validarNombre(inputNom);
            const okCodigo = isEdit ? codigoValidoEdit : codigoValidoCreate;

            const ok = okNombre && okCodigo;
            
            btn.disabled = !ok;
            btn.classList.toggle('opacity-50', btn.disabled);
            btn.classList.toggle('cursor-not-allowed', btn.disabled);
        }

    </script>
@endsection

@extends('admin.layouts.app')

@section('title', 'Gestión de Tipos')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

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
                    Gestión de Tipos
                </h1>

                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Administre los tipos y su prioridad asociada.
                </p>
            </div>

            <button onclick="openCreateModal()"
                class="w-full sm:w-auto px-5 py-2.5 bg-primary text-white rounded-lg 
            font-bold text-sm flex items-center justify-center gap-2 
            shadow-lg shadow-primary/20 
            hover:bg-primary/90 transition-all duration-200">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Añadir Tipo
            </button>
        </div>

        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">

            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Tipos Registrados</h2>
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
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">ID</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Tipo</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Prioridad</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                        @foreach ($tipos as $t)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center dark:text-gray-300">{{ $t->id_tipo }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center font-bold text-[#0d121b] dark:text-white">{{ $t->tipo_nombre }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">{{ $t->prioridad->prioridad_nombre ?? '' }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal('{{ $t->id_tipo }}','{{ $t->tipo_nombre }}','{{ $t->id_prioridad }}')"
                                            class="p-2 text-[#4c669a] hover:text-primary transition">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800">
                {{ $tipos->links() }}
            </div>

        </div>
    </div>
@endsection


@section('modals')

    <!-- MODAL CREAR -->
    <div id="createModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6">

            <h2 class="text-lg font-bold mb-4 dark:text-white">Crear Tipo</h2>

            <form action="{{ route('admin.tipo.store') }}" method="POST" id="createForm">
                @csrf
                <input type="hidden" name="form_type" value="create">

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="tipo_nombre" name="tipo_nombre" 
                        value="{{ old('form_type') == 'create' ? old('tipo_nombre') : '' }}"
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'create' && $errors->has('tipo_nombre')) ? 'border-red-500' : '' }}" required minlength="3" maxlength="100" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$" title="Debe iniciar con al menos 3 letras continuas sin espacios">
                    
                    @if(old('form_type') == 'create')
                        @error('tipo_nombre')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Prioridad</label>
                    <select name="id_prioridad" id="id_prioridad" required
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'create' && $errors->has('id_prioridad')) ? 'border-red-500' : '' }}">
                        <option value="">Seleccione una prioridad</option>
                        @foreach($prioridades as $pr)
                            <option value="{{ $pr->id_prioridad }}" {{ (old('form_type') == 'create' && old('id_prioridad') == $pr->id_prioridad) ? 'selected' : '' }}>
                                {{ $pr->prioridad_nombre }}
                            </option>
                        @endforeach
                    </select>

                    @if(old('form_type') == 'create')
                        @error('id_prioridad')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6">

            <h2 class="text-lg font-bold mb-4 dark:text-white">Editar Tipo</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="edit">
                <input type="hidden" id="edit_id_tipo" name="id_tipo" value="{{ old('id_tipo') }}">

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="edit_tipo_nombre" name="tipo_nombre" 
                        value="{{ old('form_type') == 'edit' ? old('tipo_nombre') : '' }}"
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'edit' && $errors->has('tipo_nombre')) ? 'border-red-500' : '' }}" required minlength="3" maxlength="100" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$" title="Debe iniciar con al menos 3 letras continuas sin espacios">
                    
                    @if(old('form_type') == 'edit')
                        @error('tipo_nombre')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Prioridad</label>
                    <select id="edit_id_prioridad" name="id_prioridad" required
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'edit' && $errors->has('id_prioridad')) ? 'border-red-500' : '' }}">
                        <option value="">Seleccione una prioridad</option>
                        @foreach($prioridades as $pr)
                            <option value="{{ $pr->id_prioridad }}" {{ (old('form_type') == 'edit' && old('id_prioridad') == $pr->id_prioridad) ? 'selected' : '' }}>
                                {{ $pr->prioridad_nombre }}
                            </option>
                        @endforeach
                    </select>

                    @if(old('form_type') == 'edit')
                        @error('id_prioridad')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EXPORTAR -->
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Exportar Tipos</h3>

            <div class="flex flex-col gap-3">
                <a href="{{ route('admin.tipo.export.pdf') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <a href="{{ route('admin.tipo.export.excel') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-green-600">grid_on</span>
                    Excel
                </a>
            </div>

            <button onclick="closeExportModal()" class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancelar</button>

        </div>
    </div>

@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                    toggleModal('createModal', true);
                @elseif(old('form_type') == 'edit')
                    let editFormAction = `{{ url('/admin/tipos') }}/{{ old('id_tipo') }}`;
                    document.getElementById('editForm').action = editFormAction;
                    toggleModal('editModal', true);
                @endif
            @endif

            function toggleModal(id, show) {
                const modal = document.getElementById(id);
                modal.classList.toggle('hidden', !show);
                modal.classList.toggle('flex', show);
            }

            window.openCreateModal = function() {
                const form = document.querySelector('#createForm');
                if(form) form.reset();
                
                const inputNombre = document.getElementById('tipo_nombre');
                const inputPrioridad = document.getElementById('id_prioridad');
                
                if(inputNombre) {
                    inputNombre.dataset.dirty = '';
                    limpiarError(inputNombre);
                }
                
                if(inputPrioridad) {
                    inputPrioridad.dataset.dirty = '';
                    limpiarError(inputPrioridad);
                }

                const btn = document.querySelector('#createModal button[type="submit"]');
                if(btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
                
                toggleModal('createModal', true);
            }

            window.openEditModal = function(id, nombre, prioridad) {
                let url = "{{ route('admin.tipo.update', ['id' => '__ID__']) }}";
                url = url.replace('__ID__', id);
                document.getElementById('editForm').action = url;
                document.getElementById('edit_id_tipo').value = id;
                document.getElementById('edit_tipo_nombre').value = nombre;
                document.getElementById('edit_id_prioridad').value = prioridad;
                
                document.getElementById('edit_tipo_nombre').dataset.dirty = '';
                document.getElementById('edit_id_prioridad').dataset.dirty = '';

                limpiarError(document.getElementById('edit_tipo_nombre'));
                limpiarError(document.getElementById('edit_id_prioridad'));

                toggleModal('editModal', true);
                
                const input = document.getElementById('edit_tipo_nombre');
                if(input) input.dispatchEvent(new Event('input'));
            }

            window.closeModals = function() {
                toggleModal('createModal', false);
                toggleModal('editModal', false);
                toggleModal('exportModal', false);
            }

            // Validaciones
            function mostrarError(input, mensaje) {
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');

                let error = input.parentNode.querySelector('.error-msg');

                if (!error) {
                    error = document.createElement('p');
                    error.classList.add('error-msg','text-red-500','text-sm','mt-1');
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
                let valor = input.value.trim();

                let serverError = input.parentNode.querySelector('.server-error');
                if (serverError && !input.dataset.dirty) {
                    input.classList.remove('border-green-500', 'border-gray-300');
                    input.classList.add('border-red-500');
                    return false; 
                }

                if (valor === "") {
                    mostrarError(input, "El nombre es obligatorio.");
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
            
            function validarPrioridad(input) {
                let valor = input.value;
                let serverError = input.parentNode.querySelector('.server-error');
                if (serverError && !input.dataset.dirty) {
                    input.classList.remove('border-green-500', 'border-gray-300');
                    input.classList.add('border-red-500');
                    return false; 
                }
                
                if (valor === "") {
                    mostrarError(input, "Seleccione una prioridad.");
                    return false;
                }
                
                limpiarError(input);
                return true;
            }

            // Crear
            const inputCreate = document.getElementById('tipo_nombre');
            const selectCreate = document.getElementById('id_prioridad');
            const btnCreate = document.querySelector('#createModal button[type="submit"]');

            if (inputCreate && selectCreate && btnCreate) {
                function validarCreate() {
                    const okNombre = validarNombre(inputCreate);
                    const okPrioridad = validarPrioridad(selectCreate);
                    const ok = okNombre && okPrioridad;
                    
                    btnCreate.disabled = !ok;
                    btnCreate.classList.toggle('opacity-50', btnCreate.disabled);
                    btnCreate.classList.toggle('cursor-not-allowed', btnCreate.disabled);
                }

                inputCreate.addEventListener('input', function() {
                    this.dataset.dirty = 'true';
                    this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
                    validarCreate();
                });
                
                selectCreate.addEventListener('change', function() {
                    this.dataset.dirty = 'true';
                    validarCreate();
                });

                validarCreate();
            }

            // Editar
            const inputEdit = document.getElementById('edit_tipo_nombre');
            const selectEdit = document.getElementById('edit_id_prioridad');
            const btnEdit = document.querySelector('#editModal button[type="submit"]');

            if (inputEdit && selectEdit && btnEdit) {
                function validarEdit() {
                    const okNombre = validarNombre(inputEdit);
                    const okPrioridad = validarPrioridad(selectEdit);
                    const ok = okNombre && okPrioridad;
                    
                    btnEdit.disabled = !ok;
                    btnEdit.classList.toggle('opacity-50', btnEdit.disabled);
                    btnEdit.classList.toggle('cursor-not-allowed', btnEdit.disabled);
                }

                inputEdit.addEventListener('input', function() {
                    this.dataset.dirty = 'true';
                    this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
                    validarEdit();
                });
                
                selectEdit.addEventListener('change', function() {
                    this.dataset.dirty = 'true';
                    validarEdit();
                });
                
                validarEdit();
            }

        });
    </script>

    <script>
        function openExportModal() { document.getElementById('exportModal').classList.remove('hidden'); document.getElementById('exportModal').classList.add('flex'); }
        function closeExportModal() { document.getElementById('exportModal').classList.add('hidden'); document.getElementById('exportModal').classList.remove('flex'); }
    </script>
@endsection

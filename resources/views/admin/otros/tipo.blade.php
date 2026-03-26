@extends('admin.layouts.app')

@section('title', 'Gestión de Tipos')

@section('content')
    <div class="w-full max-w-7xl mx-auto p-4 md:px-6 lg:px-8 py-6">

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
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Tipos Registradas</h2>
                <div class="flex flex-col md:flex-row gap-4 items-center w-full md:w-auto">

                    <!-- Search Bar -->
                    <form action="{{ route('admin.tipo.index') }}" method="GET" class="relative w-full md:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#4c669a] text-lg">search</span>
                        <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}"
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
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">ID</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Tipo</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Prioridad</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Días Hábiles</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Req. Respuesta</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                        @foreach ($tipos as $t)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center dark:text-gray-300">{{ $t->id_tipo }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center font-bold text-[#0d121b] dark:text-white">{{ $t->tipo_nombre }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">{{ $t->prioridad->prioridad_nombre ?? '' }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">{{ $t->dias_respuesta }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                                    @if($t->requiere_respuesta)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sí
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> No
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal('{{ $t->id_tipo }}','{{ addslashes($t->tipo_nombre) }}','{{ $t->id_prioridad }}', '{{ $t->dias_respuesta }}', '{{ $t->requiere_respuesta }}')"
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
                {{ $tipos->appends(['search' => request('search')])->links() }}
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

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Días Hábiles de Respuesta</label>
                    <input type="number" id="dias_respuesta" name="dias_respuesta" 
                        value="{{ old('form_type') == 'create' ? old('dias_respuesta') : '' }}"
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'create' && $errors->has('dias_respuesta')) ? 'border-red-500' : '' }}" required min="1" title="Ingrese los días hábiles">
                    
                    @if(old('form_type') == 'create')
                        @error('dias_respuesta')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                {{-- Toggle Requiere Respuesta --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">¿Requiere Respuesta?</label>
                    {{-- Hidden input garantiza que se envíe 0 cuando el checkbox no está marcado --}}
                    <input type="hidden" name="requiere_respuesta" value="0">
                    <label class="inline-flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" id="requiere_respuesta" name="requiere_respuesta" value="1"
                            {{ (old('form_type') == 'create' && old('requiere_respuesta')) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-primary transition-colors
                                    after:content-[''] after:absolute after:top-0.5 after:left-[2px] 
                                    after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:after:translate-x-full dark:bg-slate-700">
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300" id="create_rr_label">No</span>
                    </label>
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

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Días Hábiles de Respuesta</label>
                    <input type="number" id="edit_dias_respuesta" name="dias_respuesta" 
                        value="{{ old('form_type') == 'edit' ? old('dias_respuesta') : '' }}"
                        class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:ring-primary {{ (old('form_type') == 'edit' && $errors->has('dias_respuesta')) ? 'border-red-500' : '' }}" required min="1" title="Ingrese los días hábiles">
                    
                    @if(old('form_type') == 'edit')
                        @error('dias_respuesta')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                {{-- Toggle Requiere Respuesta (Edit) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">¿Requiere Respuesta?</label>
                    <input type="hidden" name="requiere_respuesta" value="0">
                    <label class="inline-flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" id="edit_requiere_respuesta" name="requiere_respuesta" value="1"
                            {{ (old('form_type') == 'edit' && old('requiere_respuesta')) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-primary transition-colors
                                    after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                                    after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:after:translate-x-full dark:bg-slate-700">
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300" id="edit_rr_label">No</span>
                    </label>
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
                const inputDias = document.getElementById('dias_respuesta');
                
                if(inputNombre) {
                    inputNombre.dataset.dirty = '';
                    limpiarError(inputNombre);
                }
                
                if(inputPrioridad) {
                    inputPrioridad.dataset.dirty = '';
                    limpiarError(inputPrioridad);
                }

                if(inputDias) {
                    inputDias.dataset.dirty = '';
                    limpiarError(inputDias);
                }

                const btn = document.querySelector('#createModal button[type="submit"]');
                if(btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
                
                toggleModal('createModal', true);
            }

            window.openEditModal = function(id, nombre, prioridad, dias, reqResp) {
                let url = "{{ route('admin.tipo.update', ['id' => '__ID__']) }}";
                url = url.replace('__ID__', id);
                document.getElementById('editForm').action = url;
                document.getElementById('edit_id_tipo').value = id;
                document.getElementById('edit_tipo_nombre').value = nombre;
                document.getElementById('edit_id_prioridad').value = prioridad;
                document.getElementById('edit_dias_respuesta').value = dias;
                
                // Set toggle de requiere_respuesta
                const editRR = document.getElementById('edit_requiere_respuesta');
                const editRRLabel = document.getElementById('edit_rr_label');
                if (editRR) {
                    editRR.checked = (reqResp == '1' || reqResp === true);
                    if (editRRLabel) editRRLabel.textContent = editRR.checked ? 'Sí' : 'No';
                }
                
                document.getElementById('edit_tipo_nombre').dataset.dirty = '';
                document.getElementById('edit_id_prioridad').dataset.dirty = '';
                document.getElementById('edit_dias_respuesta').dataset.dirty = '';

                limpiarError(document.getElementById('edit_tipo_nombre'));
                limpiarError(document.getElementById('edit_id_prioridad'));
                limpiarError(document.getElementById('edit_dias_respuesta'));

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

            function validarDias(input) {
                let valor = input.value;
                let serverError = input.parentNode.querySelector('.server-error');
                if (serverError && !input.dataset.dirty) {
                    input.classList.remove('border-green-500', 'border-gray-300');
                    input.classList.add('border-red-500');
                    return false; 
                }
                
                if (valor === "" || valor < 1) {
                    mostrarError(input, "Ingrese un número válido mayor a 0.");
                    return false;
                }
                
                limpiarError(input);
                return true;
            }

            // Sincronizar labels del toggle con el estado del checkbox
            function setupToggleLabel(checkboxId, labelId) {
                const cb = document.getElementById(checkboxId);
                const lbl = document.getElementById(labelId);
                if (!cb || !lbl) return;
                const sync = () => { lbl.textContent = cb.checked ? 'Sí' : 'No'; };
                cb.addEventListener('change', sync);
                sync();
            }
            setupToggleLabel('requiere_respuesta', 'create_rr_label');
            setupToggleLabel('edit_requiere_respuesta', 'edit_rr_label');

            // Crear
            const inputCreate = document.getElementById('tipo_nombre');
            const selectCreate = document.getElementById('id_prioridad');
            const inputDiasCreate = document.getElementById('dias_respuesta');
            const btnCreate = document.querySelector('#createModal button[type="submit"]');

            if (inputCreate && selectCreate && inputDiasCreate && btnCreate) {
                function validarCreate() {
                    const okNombre = validarNombre(inputCreate);
                    const okPrioridad = validarPrioridad(selectCreate);
                    const okDias = validarDias(inputDiasCreate);
                    const ok = okNombre && okPrioridad && okDias;
                    
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

                inputDiasCreate.addEventListener('input', function() {
                    this.dataset.dirty = 'true';
                    validarCreate();
                });

                validarCreate();
            }

            // Editar
            const inputEdit = document.getElementById('edit_tipo_nombre');
            const selectEdit = document.getElementById('edit_id_prioridad');
            const inputDiasEdit = document.getElementById('edit_dias_respuesta');
            const btnEdit = document.querySelector('#editModal button[type="submit"]');

            if (inputEdit && selectEdit && inputDiasEdit && btnEdit) {
                function validarEdit() {
                    const okNombre = validarNombre(inputEdit);
                    const okPrioridad = validarPrioridad(selectEdit);
                    const okDias = validarDias(inputDiasEdit);
                    const ok = okNombre && okPrioridad && okDias;
                    
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

                inputDiasEdit.addEventListener('input', function() {
                    this.dataset.dirty = 'true';
                    validarEdit();
                });
                
                validarEdit();
            }

            // Client-side search removed for server-side search

        });
    </script>

    <script>
        function openExportModal() { document.getElementById('exportModal').classList.remove('hidden'); document.getElementById('exportModal').classList.add('flex'); }
        function closeExportModal() { document.getElementById('exportModal').classList.add('hidden'); document.getElementById('exportModal').classList.remove('flex'); }
    </script>
@endsection

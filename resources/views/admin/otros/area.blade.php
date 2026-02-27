@extends('admin.layouts.app')

@section('title', 'Gestión de Áreas')

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

                        <span class="material-symbols-outlined text-[18px]">
                            arrow_back
                        </span>
                        Regresar
                    </a>
                </div>

                <h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight">
                    Gestión de Áreas
                </h1>

                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Administre los sectores organizacionales de la empresa.
                </p>
            </div>

            <!-- Botón Crear -->
            <button onclick="openCreateModal()"
                class="w-full sm:w-auto px-5 py-2.5 bg-primary text-white rounded-lg 
            font-bold text-sm flex items-center justify-center gap-2 
            shadow-lg shadow-primary/20 
            hover:bg-primary/90 transition-all duration-200">

                <span class="material-symbols-outlined text-[18px]">add</span>
                Añadir Área
            </button>
        </div>


        <!-- ================= TABLA ================= -->
        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">
        <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Areas Registradas</h2>
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
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">ID
                            </th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">
                                Nombre</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">
                                Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                        @foreach ($areas as $area)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center dark:text-gray-300">
                                    {{ $area->id_area }}
                                </td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center font-bold text-[#0d121b] dark:text-white">
                                    {{ $area->area_nom }}
                                </td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal('{{ $area->id_area }}','{{ $area->area_nom }}')"
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
                {{ $areas->links() }}
            </div>

        </div>
    </div>
@endsection



@section('modals')

    <!-- ================= MODAL CREAR ================= -->
    <div id="createModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/40 px-4">
        <div class="bg-white dark:bg-[#161d2b] w-full max-w-md rounded-xl shadow-xl p-5 sm:p-6">

            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-lg font-semibold dark:text-white">Nueva Área</h2>
                <button onclick="closeModals()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="{{ route('admin.area.store') }}" method="POST" id="createForm">
                @csrf
                <input type="hidden" name="form_type" value="create">

                <div class="mb-4">
                    <input type="text" name="area_nom" id="area_nom"
                        value="{{ old('form_type') == 'create' ? old('area_nom') : '' }}"
                        class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-primary focus:border-primary {{ (old('form_type') == 'create' && $errors->has('area_nom')) ? 'border-red-500' : '' }}"
                        placeholder="Nombre del área" required minlength="3" maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$" title="Debe iniciar con al menos 3 letras continuas sin espacios">
                    
                    @if(old('form_type') == 'create')
                        @error('area_nom')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 border rounded-lg w-full sm:w-auto">
                        Cancelar
                    </button>

                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg w-full sm:w-auto">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- ================= MODAL EDITAR ================= -->
    <div id="editModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/40 px-4">
        <div class="bg-white dark:bg-[#161d2b] w-full max-w-md rounded-xl shadow-xl p-5 sm:p-6">

            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-lg font-semibold dark:text-white">Editar Área</h2>
                <button onclick="closeModals()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="edit">
                <input type="hidden" id="edit_id_area" name="id_area" value="{{ old('id_area') }}">

                <div class="mb-4">
                    <input type="text" id="editNombre" name="area_nom"
                        value="{{ old('form_type') == 'edit' ? old('area_nom') : '' }}"
                        class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-primary focus:border-primary {{ (old('form_type') == 'edit' && $errors->has('area_nom')) ? 'border-red-500' : '' }}" required minlength="3" maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$" title="Debe iniciar con al menos 3 letras continuas sin espacios">
                    
                    @if(old('form_type') == 'edit')
                        @error('area_nom')
                            <p class="error-msg server-error text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 border rounded-lg w-full sm:w-auto">
                        Cancelar
                    </button>

                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg w-full sm:w-auto">
                        Guardar Cambios
                    </button>
                </div>
            </form>
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

        // Reabrir modal correspondiente si hubo error
        @if(old('form_type') == 'create')
            toggleModal('createModal', true);
        @elseif(old('form_type') == 'edit')
            let editFormAction = `{{ url('/admin/areas') }}/{{ old('id_area') }}`;
            document.getElementById('editForm').action = editFormAction;
            toggleModal('editModal', true);
        @endif
    @endif

    // ================= MODALES =================
    window.openCreateModal = function() {
        // Limpiar el form por si quedó algo de antes usando reset y disparando input
        const form = document.querySelector('#createForm');
        if(form) form.reset();
        
        const input = document.getElementById('area_nom');
        if(input) {
            input.dataset.dirty = '';
            // Forzar limpeza visual
            limpiarError(input);
            const btn = document.querySelector('#createModal button[type="submit"]');
            if(btn) {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
        
        toggleModal('createModal', true);
    }

    window.openEditModal = function(id, nombre) {
        document.getElementById('editForm').action = `/admin/areas/${id}`;
        document.getElementById('edit_id_area').value = id;
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editNombre').dataset.dirty = ''; // Reset dirty
        
        // Trigger validate so the button isn't immediately disabled erroneously
        const input = document.getElementById('editNombre');
        limpiarError(input);
        
        toggleModal('editModal', true);
        // Despues de abrir reevaluamos validacion básica
        if(input) input.dispatchEvent(new Event('input'));
    }

    window.closeModals = function() {
        toggleModal('createModal', false);
        toggleModal('editModal', false);
    }

    function toggleModal(id, show) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden', !show);
        modal.classList.toggle('flex', show);
    }

    // ================= FUNCIONES DE ERROR =================
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
        let error = input.parentNode.querySelector('.error-msg');
        
        // Si hay un error del servidor, no lo limpiamos a menos que el input haya sido modificado
        if (error && error.classList.contains('server-error') && !input.dataset.dirty) {
            return;
        }

        input.classList.remove('border-red-500');
        input.classList.add('border-gray-300', 'dark:border-gray-700'); 
        input.classList.add('border-green-500');

        if (error) error.remove();
    }

    // ================= VALIDACIÓN NOMBRE =================
    function validarNombre(input) {
        let valor = input.value.trim();

        // Si es carga inicial y el backend dejó un error server-error
        let serverError = input.parentNode.querySelector('.server-error');
        if (serverError && !input.dataset.dirty) {
            input.classList.remove('border-green-500', 'border-gray-300');
            input.classList.add('border-red-500');
            return false; 
        }

        if (valor === "") {
            mostrarError(input, "El nombre del área es obligatorio.");
            return false;
        }

        if (valor.length < 3) {
            mostrarError(input, "Debe tener mínimo 3 caracteres.");
            return false;
        }

        if (valor.length > 50) {
            mostrarError(input, "No puede superar 50 caracteres.");
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

    // ================= ACTIVAR VALIDACIÓN =================
    function activarValidacion(input, boton) {

        function validarTodo() {
            const valido = validarNombre(input);

            boton.disabled = !valido;
            boton.classList.toggle('opacity-50', boton.disabled);
            boton.classList.toggle('cursor-not-allowed', boton.disabled);
        }

        input.addEventListener('input', function() {
            this.dataset.dirty = 'true';
            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
            validarTodo();
        });

        // Trigger validación inicial
        validarTodo();
    }

    // ================= CREAR =================
    const inputCreate = document.getElementById('area_nom');
    const btnCreate = document.querySelector('#createModal button[type="submit"]');

    if (inputCreate && btnCreate) {
        activarValidacion(inputCreate, btnCreate);
    }

    // ================= EDITAR =================
    const inputEdit = document.getElementById('editNombre');
    const btnEdit = document.querySelector('#editModal button[type="submit"]');

    if (inputEdit && btnEdit) {
        activarValidacion(inputEdit, btnEdit);
    }

});
</script>


{{-- MODAL EXPORTAR --}}
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                Exportar Empresas
            </h3>

            <div class="flex flex-col gap-3">

                <!-- PDF -->
                <a href="{{ route('admin.areas.export.pdf') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <!-- Excel -->
                <a href="{{ route('admin.areas.export.excel') }}"
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

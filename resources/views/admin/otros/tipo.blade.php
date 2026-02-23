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

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="tipo_nombre" name="tipo_nombre" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Prioridad</label>
                    <select name="id_prioridad" id="id_prioridad" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Seleccione una prioridad</option>
                        @foreach($prioridades as $pr)
                            <option value="{{ $pr->id_prioridad }}">{{ $pr->prioridad_nombre }}</option>
                        @endforeach
                    </select>
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

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" id="edit_tipo_nombre" name="tipo_nombre" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Prioridad</label>
                    <select id="edit_id_prioridad" name="id_prioridad" class="w-full px-3 py-2 border rounded-lg">
                        @foreach($prioridades as $pr)
                            <option value="{{ $pr->id_prioridad }}">{{ $pr->prioridad_nombre }}</option>
                        @endforeach
                    </select>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function toggleModal(id, show) {
                const modal = document.getElementById(id);
                modal.classList.toggle('hidden', !show);
                modal.classList.toggle('flex', show);
            }

            window.openCreateModal = function() {
                toggleModal('createModal', true);
            }

            window.openEditModal = function(id, nombre, prioridad) {
                let url = "{{ route('admin.tipo.update', ['id' => '__ID__']) }}";
                url = url.replace('__ID__', id);
                document.getElementById('editForm').action = url;
                document.getElementById('edit_tipo_nombre').value = nombre;
                document.getElementById('edit_id_prioridad').value = prioridad;
                toggleModal('editModal', true);
            }

            window.closeModals = function() {
                toggleModal('createModal', false);
                toggleModal('editModal', false);
            }

            // Validaciones
            function setError(input, message) {
                input.classList.add('border-red-500');
                input.classList.remove('border-green-500');
                let small = input.parentNode.querySelector('.error-text');
                if (!small) { small = document.createElement('small'); small.classList.add('error-text','text-red-500','block','mt-1'); input.parentNode.appendChild(small); }
                small.innerText = message;
            }

            function setSuccess(input) {
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
                let small = input.parentNode.querySelector('.error-text'); if (small) small.remove();
            }

            // Crear
            const nombre = document.getElementById('tipo_nombre');
            const prioridad = document.getElementById('id_prioridad');
            const form = document.getElementById('createForm');

            if (nombre) nombre.addEventListener('input', function(){
                let value = this.value.trim();
                value = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g,'');
                value = value.replace(/\s{2,}/g,' ');
                value = value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
                this.value = value;

                if (value.length < 2) { setError(this,'Mínimo 2 caracteres'); return false; }
                if (value.length > 100) { setError(this,'Máximo 100 caracteres'); return false; }
                setSuccess(this);
                return true;
            });

            if (form) form.addEventListener('submit', function(e){
                let ok = true;
                if (!nombre || nombre.value.trim().length < 2) { setError(nombre,'Mínimo 2 caracteres'); ok=false; }
                if (!prioridad || prioridad.value === '') { setError(prioridad,'Seleccione una prioridad'); ok=false; }
                if (!ok) { e.preventDefault(); Swal.fire({ icon:'error', title:'Formulario inválido', text:'Corrige los errores antes de continuar' }); }
            });

            // Editar validations
            const editNombre = document.getElementById('edit_tipo_nombre');
            const editPrioridad = document.getElementById('edit_id_prioridad');
            const editForm = document.getElementById('editForm');

            if (editNombre) editNombre.addEventListener('input', function(){
                let value = this.value.trim();
                value = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g,'');
                value = value.replace(/\s{2,}/g,' ');
                value = value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
                this.value = value;
                if (value.length < 2) { setError(this,'Mínimo 2 caracteres'); return false; }
                setSuccess(this);
                return true;
            });

            if (editForm) editForm.addEventListener('submit', function(e){
                let ok = true;
                if (!editNombre || editNombre.value.trim().length < 2) { setError(editNombre,'Mínimo 2 caracteres'); ok=false; }
                if (!editPrioridad || editPrioridad.value === '') { setError(editPrioridad,'Seleccione una prioridad'); ok=false; }
                if (!ok) { e.preventDefault(); Swal.fire({ icon:'error', title:'Formulario inválido', text:'Corrige los errores antes de continuar' }); }
            });

        });
    </script>

    <script>
        function openExportModal() { document.getElementById('exportModal').classList.remove('hidden'); document.getElementById('exportModal').classList.add('flex'); }
        function closeExportModal() { document.getElementById('exportModal').classList.add('hidden'); document.getElementById('exportModal').classList.remove('flex'); }
    </script>
@endsection

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

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-center">ID</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-center">Nombre</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-center">Código Postal</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                    @foreach ($departamentos as $dpto)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                            <td class="px-4 sm:px-6 py-3 text-center">
                                {{ $dpto->id_departamento }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 text-center font-bold">
                                {{ $dpto->dpto_nombre }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 text-center">
                                {{ $dpto->dpto_codigo_postal }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 text-center">
                                <div class="flex justify-center gap-2 flex-wrap">

                                    <button
                                        onclick="openEditModal('{{ $dpto->id_departamento }}','{{ $dpto->dpto_nombre }}','{{ $dpto->dpto_codigo_postal }}')"
                                        class="p-2 text-[#4c669a] hover:text-primary transition">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>

                                    <form action="{{ route('admin.departamento.destroy', $dpto->id_departamento) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:text-red-700">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>

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

        <form action="{{ route('admin.departamento.store') }}" method="POST" id="createForm">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nombre</label>
                <input type="text" id="dpto_nombre" name="dpto_nombre"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Código Postal</label>
                <input type="text" id="dpto_codigo_postal" name="dpto_codigo_postal" maxlength="10"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg w-full sm:w-auto">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg w-full sm:w-auto">
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
                <label class="block text-sm font-medium mb-1">Nombre</label>
                <input type="text" id="editNombre" name="dpto_nombre"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Código Postal</label>
                <input type="text" id="editCodigo" name="dpto_codigo_postal" maxlength="10"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg w-full sm:w-auto">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg w-full sm:w-auto">
                    Actualizar
                </button>
            </div>
        </form>

        <button onclick="closeModals()" class="absolute top-3 right-3">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
</div>

@endsection



@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    window.openCreateModal = function() {
        document.getElementById('createModal').classList.remove('hidden');
        document.getElementById('createModal').classList.add('flex');
    }

    window.openEditModal = function(id, nombre, codigo) {

        let url = "{{ route('admin.departamento.update', ':id') }}";
        url = url.replace(':id', id);

        document.getElementById('editForm').action = url;

        document.getElementById('editNombre').value = nombre;
        document.getElementById('editCodigo').value = codigo;

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    window.closeModals = function() {
        document.getElementById('createModal').classList.add('hidden');
        document.getElementById('editModal').classList.add('hidden');
    }

    function validar(nombre, codigo) {

        if (nombre === "" || codigo === "") {
            Swal.fire('Error', 'Todos los campos son obligatorios.', 'error');
            return false;
        }

        if (nombre.length < 3 || nombre.length > 30) {
            Swal.fire('Error', 'El nombre debe tener entre 3 y 30 caracteres.', 'error');
            return false;
        }

        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/.test(nombre)) {
            Swal.fire('Error', 'Solo se permiten letras y espacios.', 'error');
            return false;
        }

        if (nombre.includes("  ")) {
            Swal.fire('Error', 'No se permiten espacios dobles.', 'error');
            return false;
        }

        if (codigo.length < 6 || codigo.length > 10) {
            Swal.fire('Error', 'El código postal debe tener entre 6 y 10 dígitos.', 'error');
            return false;
        }

        return true;
    }

    document.getElementById('createForm').addEventListener('submit', function(e){
        let nombre = dpto_nombre.value.trim();
        let codigo = dpto_codigo_postal.value.trim();

        if(!validar(nombre,codigo)){
            e.preventDefault();
        }
    });

    document.getElementById('editForm').addEventListener('submit', function(e){
        let nombre = editNombre.value.trim();
        let codigo = editCodigo.value.trim();

        if(!validar(nombre,codigo)){
            e.preventDefault();
        }
    });

});
</script>
@endsection

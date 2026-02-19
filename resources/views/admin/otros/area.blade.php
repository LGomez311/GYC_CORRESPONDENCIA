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

            <div class="p-4 sm:p-6 border-b border-[#cfd7e7] dark:border-gray-800">
                <h2 class="text-[#0d121b] dark:text-white text-base sm:text-lg font-bold">
                    Áreas Registradas
                </h2>
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

            <form action="{{ route('admin.area.store') }}" method="POST">
                @csrf

                <input type="text" name="area_nom" id="area_nom"
                    class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 mb-4"
                    placeholder="Nombre del área">

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

                <input type="text" id="editNombre" name="area_nom"
                    class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 mb-4" required>

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
    <script>
        function openCreateModal() {
            const modal = document.getElementById('createModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openEditModal(id, nombre) {
            document.getElementById('editForm').action = `/admin/areas/${id}`;
            document.getElementById('editNombre').value = nombre;

            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModals() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('editModal').classList.add('hidden');
        }


        document.addEventListener('DOMContentLoaded', function() {

            const form = document.querySelector('#createModal form');
            const input = document.getElementById('area_nom');

            if (!form || !input) return;

            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '');
            });

            form.addEventListener('submit', function(e) {

                e.preventDefault();
                let nombre = input.value.trim();

                if (nombre === "") {
                    Swal.fire('Error', 'El nombre del área es obligatorio.', 'error');
                    return;
                }

                if (nombre.length < 3) {
                    Swal.fire('Error', 'Debe tener mínimo 3 caracteres.', 'error');
                    return;
                }

                if (nombre.length > 50) {
                    Swal.fire('Error', 'No puede superar 50 caracteres.', 'error');
                    return;
                }

                if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/.test(nombre)) {
                    Swal.fire('Error', 'Solo se permiten letras y espacios.', 'error');
                    return;
                }

                if (nombre.includes("  ")) {
                    Swal.fire('Error', 'No se permiten espacios dobles.', 'error');
                    return;
                }

                nombre = nombre.toLowerCase()
                    .replace(/\b\w/g, l => l.toUpperCase());

                input.value = nombre;

                this.submit();
            });

        });
    </script>
@endsection

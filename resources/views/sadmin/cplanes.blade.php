@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

@section('content')

<div class="p-8 max-w-7xl mx-auto w-full">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
        <div class="flex flex-col gap-1">
            <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                Gestión de Planes
            </h1>
            <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">
                Administre los planes y licencias del sistema.
            </p>
        </div>

        <button
            onclick="openCreateModal()"
            class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg hover:bg-primary/90">
            <span class="material-symbols-outlined text-sm">add</span>
            Crear Nuevo Plan
        </button>
    </div>

    {{-- CARD --}}
    <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

        <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800">
            <h2 class="text-lg font-bold dark:text-white">Planes Registrados</h2>
        </div>

        {{-- TABLA --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-background-light dark:bg-background-dark/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Plan</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Descripción</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Precio</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Duración</th>
                        <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                    @foreach ($planes as $plan)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                        {{-- PLAN --}}
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold dark:text-white">
                                {{ $plan->nomb_plan }}
                            </span>
                        </td>

                        {{-- DESCRIPCIÓN --}}
                        <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400">
                            {{ $plan->descripcion }}
                        </td>

                        {{-- PRECIO --}}
                        <td class="px-6 py-4 font-bold dark:text-gray-300">
                            ${{ number_format($plan->valor, 0) }}
                        </td>

                        {{-- DURACIÓN --}}
                        <td class="px-6 py-4 text-sm dark:text-gray-300">
                            {{ $plan->duracion }} mes/es
                        </td>

                        {{-- ACCIONES --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-1">

                                {{-- EDITAR --}}
                                <button
                                    onclick="openEditModal(
                                        {{ $plan->id_plan }},
                                        @js($plan->nomb_plan),
                                        {{ $plan->valor }},
                                        {{ $plan->duracion }},
                                        @js($plan->descripcion)
                                    )"
                                    class="p-2 text-[#4c669a] hover:text-primary">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>

                                {{-- ELIMINAR --}}
                                <button
                                    onclick="openDeleteModal(
                                        {{ $plan->id_plan }},
                                        @js($plan->nomb_plan),
                                        '{{ route('planes.destroy', ':id') }}'
                                            )"
                                    class="p-2 text-[#4c669a] hover:text-red-500">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>


                            </div>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL CREAR ================= --}}
<div id="createModal" class="fixed inset-0 hidden z-50 bg-black/50 items-center justify-center">
    <div class="bg-white dark:bg-[#161d2b] rounded-xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold mb-4 dark:text-white">Crear Plan</h3>

        <form action="{{ route('planes.store') }}" method="POST" class="space-y-4">
            @csrf

            <input name="nomb_plan" required placeholder="Nombre del plan"
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

            <input name="valor" type="number" required placeholder="Valor"
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

            <input name="duracion" type="number" required placeholder="Duración (meses)"
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

            <textarea name="descripcion" placeholder="Descripción"
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCreateModal()" class="border px-4 py-2 rounded">
                    Cancelar
                </button>
                <button class="bg-primary text-white px-4 py-2 rounded font-bold">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDITAR ================= --}}
<div id="editModal" class="fixed inset-0 hidden z-50 bg-black/50 items-center justify-center">
    <div class="bg-white dark:bg-[#161d2b] rounded-xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold mb-4 dark:text-white">Editar Plan</h3>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input id="edit_nomb_plan" name="nomb_plan" required
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

            <input id="edit_valor" name="valor" type="number" required
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

            <input id="edit_duracion" name="duracion" type="number" required
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

            <textarea id="edit_descripcion" name="descripcion"
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="border px-4 py-2 rounded">
                    Cancelar
                </button>
                <button class="bg-primary text-white px-4 py-2 rounded font-bold">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Eliminar -->
<div id="deleteModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="bg-white dark:bg-[#161d2b] rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-red-500 text-3xl">
                warning
            </span>
            <h3 class="text-lg font-bold text-[#0d121b] dark:text-white">
                Confirmar eliminación
            </h3>
        </div>

        <p class="text-sm text-[#4c669a] dark:text-gray-400 mb-6">
            ¿Seguro que deseas eliminar el plan
            <span id="deletePlanName" class="font-bold text-[#0d121b] dark:text-white"></span>?
            <br>
            <span class="text-red-500 font-medium">Esta acción no se puede deshacer.</span>
        </p>

        <div class="flex justify-end gap-2">
            <button
                onclick="closeDeleteModal()"
                class="px-4 py-2 text-sm font-bold rounded-lg border border-gray-300 dark:border-gray-700 text-[#4c669a] hover:bg-gray-100 dark:hover:bg-gray-800">
                Cancelar
            </button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-bold rounded-lg bg-red-500 text-white hover:bg-red-600">
                    Sí, eliminar
                </button>
            </form>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    function openCreateModal() {
        createModal.classList.remove('hidden')
        createModal.classList.add('flex')
    }

    function closeCreateModal() {
        createModal.classList.add('hidden')
        createModal.classList.remove('flex')
    }

    function openEditModal(id, nombre, valor, duracion, descripcion) {
        document.getElementById('editForm').action = `sadmin/planes/${id}`
        edit_nomb_plan.value = nombre
        edit_valor.value = valor
        edit_duracion.value = duracion
        edit_descripcion.value = descripcion ?? ''
        editModal.classList.remove('hidden')
        editModal.classList.add('flex')
    }

    function closeEditModal() {
        editModal.classList.add('hidden')
        editModal.classList.remove('flex')
    }

    function openDeleteModal(id, name) {
        document.getElementById('deletePlanName').textContent = name;
        document.getElementById('deleteForm').action = `sadmin/planes/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>



@endsection
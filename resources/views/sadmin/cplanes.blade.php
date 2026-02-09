@extends('sadmin.layouts.app')

@section('title', 'Panel de Licencias')

{{-- ================= HEADER PERSONALIZADO ================= --}}
@section('header')
    <header
        class="h-16 bg-white dark:bg-[#161d2b] border-b border-[#cfd7e7] dark:border-gray-800 px-8 flex items-center justify-between sticky top-0 z-10">

        {{-- BUSCADOR --}}
        <form method="GET" class="w-1/2 max-w-2xl">
            <input id="searchPlan" name="search" value="{{ request('search') }}" type="text"
                placeholder="Buscar planes por nombre..."
                class="w-full h-10 pl-10 pr-4 bg-background-light dark:bg-background-dark rounded-lg">
        </form>

        <div class="flex items-center gap-4"></div>
    </header>
@endsection

@if (session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif

@if (session('error'))
    <script>
        alert('{{ session('error') }}');
    </script>
@endif

@if ($errors->any())
    <script>
        let errores = "";
        @foreach ($errors->all() as $error)
            errores += "{{ $error }}\n";
        @endforeach
        alert(errores);
    </script>
@endif

{{-- ================= CONTENIDO ================= --}}
@section('content')

    <div class="p-8 max-w-7xl mx-auto w-full">

        {{-- HEADER INTERNO --}}
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                    Gestión de Planes
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">
                    Administre los planes del sistema.
                </p>
            </div>

            <button onclick="openCreateModal()"
                class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg hover:bg-primary/90">
                <span class="material-symbols-outlined text-sm">add</span>
                Crear Nuevo Plan
            </button>
        </div>

        {{-- CARD --}}
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800">
                <h2 class="text-lg font-bold dark:text-white">Planes Disponibles</h2>
            </div>

            <div id="plansWrapper">
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

                            @forelse ($planes as $plan)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold dark:text-white">
                                            {{ $plan->nomb_plan }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400">
                                        {{ $plan->descripcion }}
                                    </td>

                                    <td class="px-6 py-4 font-bold dark:text-gray-300">
                                        ${{ number_format($plan->valor, 0) }}
                                    </td>

                                    <td class="px-6 py-4 text-sm dark:text-gray-300">
                                        {{ $plan->duracion }} mes/es
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-1">
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

                                            <button
                                                onclick="openDeleteModal({{ $plan->id_plan }}, @js($plan->nomb_plan))"
                                                class="p-2 text-[#4c669a] hover:text-red-500">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center">
                                        <div
                                            class="flex flex-col items-center gap-2 text-sm text-[#4c669a] dark:text-gray-400">
                                            <span class="material-symbols-outlined text-4xl">search_off</span>
                                            No se encontraron planes con ese nombre.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- MODAL CREAR --}}
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

                {{-- MODAL EDITAR --}}
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
                


                {{-- MODAL ELIMINAR --}}
                <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

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
                            <button onclick="closeDeleteModal()"
                                class="px-4 py-2 text-sm font-bold rounded-lg border border-gray-300 dark:border-gray-700 text-[#4c669a] hover:bg-gray-100 dark:hover:bg-gray-800">
                                Cancelar
                            </button>

                            <form id="deleteForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-bold rounded-lg bg-red-500 text-white hover:bg-red-600">
                                    Sí, eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- PAGINACIÓN --}}
                @if ($planes->hasPages())
                    <div id="paginationInfo"
                        class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800 flex flex-wrap gap-3 items-center justify-between">

                        <p class="text-xs text-[#4c669a] dark:text-gray-400">
                            Mostrando {{ $planes->firstItem() }} - {{ $planes->lastItem() }} de {{ $planes->total() }}
                            planes registrados
                        </p>

                        <div class="flex gap-1">
                            <a href="{{ $planes->previousPageUrl() }}"
                                class="size-8 flex items-center justify-center rounded border {{ $planes->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
                                <span class="material-symbols-outlined text-sm">chevron_left</span>
                            </a>

                            @foreach ($planes->getUrlRange(1, $planes->lastPage()) as $page => $url)
                                <a href="{{ $url }}"
                                    class="size-8 flex items-center justify-center rounded text-xs font-bold
                        {{ $planes->currentPage() == $page ? 'bg-primary text-white' : 'border' }}">
                                    {{ $page }}
                                </a>
                            @endforeach

                            <a href="{{ $planes->nextPageUrl() }}"
                                class="size-8 flex items-center justify-center rounded border {{ !$planes->hasMorePages() ? 'pointer-events-none opacity-50' : '' }}">
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
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
            editForm.action = `sadmin/planes/${id}`
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
            deletePlanName.textContent = name
            deleteForm.action = `sadmin/planes/${id}`
            deleteModal.classList.remove('hidden')
            deleteModal.classList.add('flex')
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden')
            deleteModal.classList.remove('flex')
        }

        let debounce = null
        let currentSearch = ''

        const searchInput = document.getElementById('searchPlan')
        const wrapper = document.getElementById('plansWrapper')

        function loadPlans(url) {
            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html')
                    const newWrapper = doc.getElementById('plansWrapper')

                    if (newWrapper) {
                        wrapper.innerHTML = newWrapper.innerHTML
                        bindPaginationLinks()
                    }
                })
        }

        function bindPaginationLinks() {
            document.querySelectorAll('#plansWrapper a').forEach(link => {
                if (link.href) {
                    link.addEventListener('click', e => {
                        e.preventDefault()

                        const url = new URL(link.href)
                        url.searchParams.set('search', currentSearch)

                        loadPlans(url.toString())
                    })
                }
            })
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(debounce)
            currentSearch = this.value.trim()

            debounce = setTimeout(() => {
                const url = new URL(`{{ route('cplanes') }}`)
                if (currentSearch) {
                    url.searchParams.set('search', currentSearch)
                }

                loadPlans(url.toString())
            }, 300)
        })

        // inicial
        bindPaginationLinks()
    </script>

@endsection

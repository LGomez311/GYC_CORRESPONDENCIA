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

            {{-- Nombre --}}
            <div>
                <input
                    id="create_nomb_plan"
                    name="nomb_plan"
                    value="{{ old('nomb_plan') }}"
                    required
                    placeholder="Nombre del plan"
                    oninput="validateCreatePlan()"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white
                    @error('nomb_plan') border-red-500 @enderror">

                {{-- Error JS --}}
                <p id="error_create_nomb_plan" class="text-xs text-red-500 mt-1 hidden"></p>

                {{-- Error Laravel --}}
                @error('nomb_plan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Valor --}}
            <div>
                <input
                    id="create_valor"
                    name="valor"
                    type="number"
                    value="{{ old('valor') }}"
                    required
                    placeholder="Valor"
                    oninput="validateCreatePlan()"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white
                    @error('valor') border-red-500 @enderror">

                {{-- Error JS --}}
                <p id="error_create_valor" class="text-xs text-red-500 mt-1 hidden"></p>

                {{-- Error Laravel --}}
                @error('valor')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Duración --}}
            <div>
                <input
                    id="create_duracion"
                    name="duracion"
                    type="number"
                    value="{{ old('duracion') }}"
                    required
                    placeholder="Duración (meses)"
                    oninput="validateCreatePlan()"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white
                    @error('duracion') border-red-500 @enderror">

                {{-- Error JS --}}
                <p id="error_create_duracion" class="text-xs text-red-500 mt-1 hidden"></p>

                {{-- Error Laravel --}}
                @error('duracion')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <textarea
                    id="create_descripcion"
                    name="descripcion"
                    required
                    placeholder="Descripción del plan"
                    oninput="validateCreatePlan()"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white
                    @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>

                {{-- Error JS --}}
                <p id="error_create_descripcion" class="text-xs text-red-500 mt-1 hidden"></p>

                {{-- Error Laravel --}}
                @error('descripcion')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCreateModal()" class="border px-4 py-2 rounded">
                    Cancelar
                </button>

                <button
                    id="btnCreatePlan"
                    disabled
                    class="bg-primary text-white px-4 py-2 rounded font-bold opacity-50 cursor-not-allowed">
                    Crear
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

            {{-- Nombre --}}
            <div>
                <input
                    id="edit_nomb_plan"
                    name="nomb_plan"
                    required
                    placeholder="Nombre del plan"
                    oninput="validateEditPlan()"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

                <p id="error_edit_nomb_plan" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            {{-- Valor --}}
            <div>
                <input
                    id="edit_valor"
                    name="valor"
                    type="number"
                    required
                    placeholder="Valor del plan"
                    oninput="validateEditPlan()"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

                <p id="error_edit_valor" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            {{-- Duración --}}
            <div>
                <input
                    id="edit_duracion"
                    name="duracion"
                    type="number"
                    required
                    placeholder="Duración (meses)"
                    oninput="validateEditPlan()"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white">

                <p id="error_edit_duracion" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            {{-- Descripción --}}
            <div>
                <textarea
                    id="edit_descripcion"
                    name="descripcion"
                    required
                    placeholder="Descripción del plan"
                    oninput="validateEditPlan()"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white"></textarea>

                <p id="error_edit_descripcion" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="border px-4 py-2 rounded">
                    Cancelar
                </button>

                <button
                    id="btnEditPlan"
                    disabled
                    class="bg-primary text-white px-4 py-2 rounded font-bold opacity-50 cursor-not-allowed">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>



            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
            </form>

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

<script>
/* =========================
    REFERENCIAS
========================= */
const createModal = document.getElementById('createModal')
const editModal   = document.getElementById('editModal')
const editForm    = document.getElementById('editForm')

const searchInput = document.getElementById('searchPlan')
const wrapper     = document.getElementById('plansWrapper')

/* =========================
    MODALES
========================= */
function openCreateModal() {
    createModal.classList.remove('hidden')
    createModal.classList.add('flex')
    validateCreatePlan()
}

function closeCreateModal() {
    createModal.classList.add('hidden')
    createModal.classList.remove('flex')
}

function openEditModal(id, nombre, valor, duracion, descripcion) {
    editForm.action = `/sadmin/planes/${id}`

    document.getElementById('edit_nomb_plan').value = nombre
    document.getElementById('edit_valor').value = valor
    document.getElementById('edit_duracion').value = duracion
    document.getElementById('edit_descripcion').value = descripcion ?? ''

    validateEditPlan()

    editModal.classList.remove('hidden')
    editModal.classList.add('flex')
}

function closeEditModal() {
    editModal.classList.add('hidden')
    editModal.classList.remove('flex')
}

/* =========================
    ELIMINAR
========================= */
function openDeleteModal(id, name) {
    Swal.fire({
        title: '¿Eliminar plan?',
        text: `Se eliminará el plan "${name}". Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm')
            form.action = `/sadmin/planes/${id}`
            form.submit()
        }
    })
}

/* =========================
    BUSCADOR AJAX
========================= */
let debounce = null
let currentSearch = ''

function loadPlans(url) {
    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
        if (!link.href) return
        link.addEventListener('click', e => {
            e.preventDefault()
            const url = new URL(link.href)
            url.searchParams.set('search', currentSearch)
            loadPlans(url.toString())
        })
    })
}

if (searchInput) {
    searchInput.addEventListener('input', function () {
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
}

bindPaginationLinks()

/* =========================
    VALIDACIONES CREATE
========================= */
function validateCreatePlan() {
    const nombre = document.getElementById('create_nomb_plan')
    const valor = document.getElementById('create_valor')
    const duracion = document.getElementById('create_duracion')
    const descripcion = document.getElementById('create_descripcion')
    const btn = document.getElementById('btnCreatePlan')

    let valid = true

    if (nombre.value.trim().length < 3) {
        showError('error_create_nomb_plan', 'El nombre debe tener al menos 3 caracteres')
        valid = false
    } else hideError('error_create_nomb_plan')

    if (Number(valor.value) <= 0) {
        showError('error_create_valor', 'El valor debe ser mayor a 0')
        valid = false
    } else hideError('error_create_valor')

    if (Number(duracion.value) <= 0) {
        showError('error_create_duracion', 'La duración debe ser mayor a 0')
        valid = false
    } else hideError('error_create_duracion')

    if (descripcion.value.trim().length < 5) {
        showError('error_create_descripcion', 'La descripción es obligatoria y debe tener al menos 5 caracteres')
        valid = false
    } else hideError('error_create_descripcion')

    btn.disabled = !valid
    btn.classList.toggle('opacity-50', !valid)
    btn.classList.toggle('cursor-not-allowed', !valid)
}

/* =========================
    VALIDACIONES EDIT
========================= */
function validateEditPlan() {
        const nombre = document.getElementById('edit_nomb_plan')
        const valor = document.getElementById('edit_valor')
        const duracion = document.getElementById('edit_duracion')
        const descripcion = document.getElementById('edit_descripcion')
        const btn = document.getElementById('btnEditPlan')

        let valid = true
        const regexLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/

        // Nombre
        if (nombre.value.trim().length < 3) {
            showError('error_edit_nomb_plan', 'Debe tener al menos 3 caracteres')
            valid = false
        } else if (!regexLetras.test(nombre.value)) {
            showError('error_edit_nomb_plan', 'Solo se permiten letras')
            valid = false
        } else {
            hideError('error_edit_nomb_plan')
        }

        // Valor
        if (Number(valor.value) <= 0) {
            showError('error_edit_valor', 'Debe ser mayor a 0')
            valid = false
        } else {
            hideError('error_edit_valor')
        }

        // Duración
        if (Number(duracion.value) <= 0) {
            showError('error_edit_duracion', 'Debe ser mayor a 0')
            valid = false
        } else {
            hideError('error_edit_duracion')
        }

        // Descripción
        if (descripcion.value.trim().length < 5) {
            showError('error_edit_descripcion', 'La descripción es obligatoria y minimo 5 caracteres')
            valid = false
        } else {
            hideError('error_edit_descripcion')
        }

        btn.disabled = !valid
        btn.classList.toggle('opacity-50', !valid)
        btn.classList.toggle('cursor-not-allowed', !valid)
    }

/* =========================
    HELPERS
========================= */
function showError(id, message) {
    const el = document.getElementById(id)
    if (!el) return
    el.textContent = message
    el.classList.remove('hidden')
}

function hideError(id) {
    const el = document.getElementById(id)
    if (!el) return
    el.textContent = ''
    el.classList.add('hidden')
}



/* =========================
    EVENTOS INPUT
========================= */
document.querySelectorAll(
    '#create_nomb_plan, #create_valor, #create_duracion, #create_descripcion'
).forEach(el => el.addEventListener('input', validateCreatePlan))

document.querySelectorAll(
    '#edit_nomb_plan, #edit_valor, #edit_duracion, #edit_descripcion'
).forEach(el => el.addEventListener('input', validateEditPlan))
</script>



{{-- ALERTAS --}}
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#16a34a'
        })
    })
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc2626'
        })
    })
</script>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'error',
            title: 'Errores de validación',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#dc2626'
        })
    })
</script>
@endif



@endsection
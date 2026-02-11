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
                                        data-id="{{ $plan->id_plan }}"
                                        data-nombre="{{ $plan->nomb_plan }}"
                                        data-valor="{{ $plan->valor }}"
                                        data-duracion="{{ $plan->duracion }}"
                                        data-descripcion="{{ $plan->descripcion }}"
                                        class="btn-edit p-2 text-[#4c669a] hover:text-primary">
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

            <!-- Overlay Crear -->
            <div id="overlayCreatePlan" class="fixed inset-0 bg-black/50 hidden z-40"></div>

            <!-- MODAL CREAR -->
            <div id="createModal" class="fixed inset-0 hidden z-50 flex items-center justify-center">
                <div class="bg-white dark:bg-[#161d2b] w-full max-w-md rounded-xl shadow-xl p-6 relative">

                    <!-- Header -->
                    <div class="flex justify-between items-center border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold dark:text-white">Crear Plan</h3>
                        <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-700">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <!-- Body -->
                    <form action="{{ route('planes.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Nombre -->
                        <div>
                            <input
                                id="create_nomb_plan"
                                name="nomb_plan"
                                value="{{ old('nomb_plan') }}"
                                required
                                placeholder="Nombre del plan"
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white
                        @error('nomb_plan') border-red-500 @enderror"
                                oninput="validateCreatePlan()">
                            <p id="error_create_nomb_plan" class="text-xs text-red-500 mt-1 hidden"></p>
                            @error('nomb_plan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valor -->
                        <div>
                            <input
                                id="create_valor"
                                name="valor"
                                type="number"
                                value="{{ old('valor') }}"
                                required
                                placeholder="Valor"
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white
                        @error('valor') border-red-500 @enderror"
                                oninput="validateCreatePlan()">
                            <p id="error_create_valor" class="text-xs text-red-500 mt-1 hidden"></p>
                            @error('valor')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duración -->
                        <div>
                            <input
                                id="create_duracion"
                                name="duracion"
                                type="number"
                                value="{{ old('duracion') }}"
                                required
                                placeholder="Duración (meses)"
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white
                        @error('duracion') border-red-500 @enderror"
                                oninput="validateCreatePlan()">
                            <p id="error_create_duracion" class="text-xs text-red-500 mt-1 hidden"></p>
                            @error('duracion')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <textarea
                                id="create_descripcion"
                                name="descripcion"
                                required
                                placeholder="Descripción del plan"
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white
                        @error('descripcion') border-red-500 @enderror"
                                oninput="validateCreatePlan()">{{ old('descripcion') }}</textarea>
                            <p id="error_create_descripcion" class="text-xs text-red-500 mt-1 hidden"></p>
                            @error('descripcion')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Footer -->
                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                Cancelar
                            </button>

                            <button
                                id="btnCreatePlan"
                                disabled
                                class="px-4 py-2 rounded-lg bg-primary text-white font-bold opacity-50 cursor-not-allowed">
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
            </div>



            {{-- MODAL EDITAR --}}
            <div id="editModal" class="fixed inset-0 hidden z-50 flex items-center justify-center">
                <div class="bg-white dark:bg-[#161d2b] w-full max-w-md rounded-xl shadow-xl p-6 relative">

                    <!-- Header -->
                    <div class="flex justify-between items-center border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold dark:text-white">Editar Plan</h3>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-700">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <!-- Body -->
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
                                placeholder="Valor"
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
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white"></textarea>

                            <p id="error_edit_descripcion" class="text-xs text-red-500 mt-1 hidden"></p>
                        </div>

                        <!-- Footer -->
                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                Cancelar
                            </button>

                            <button id="btnEditPlan" type="submit" disabled
                                class="px-4 py-2 rounded-lg bg-primary text-white font-bold opacity-50 cursor-not-allowed">
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
const editModal = document.getElementById('editModal')
const editForm = document.getElementById('editForm')
const wrapper = document.getElementById('plansWrapper')
const searchInput = document.getElementById('searchPlan')

/* =========================
   ESTADO (TOUCHED)
========================= */
const touchedCreate = { nombre:false, valor:false, duracion:false, descripcion:false }
const touchedEdit   = { nombre:false, valor:false, duracion:false, descripcion:false }

/* =========================
   MODALES
========================= */
function openCreateModal(){
    createModal.classList.remove('hidden')
    document.getElementById('overlayCreatePlan').classList.remove('hidden')

    // Reinicia formulario y estado
    resetCreateForm()
}


function closeCreateModal(){
    createModal.classList.add('hidden')
    document.getElementById('overlayCreatePlan').classList.add('hidden')
    resetCreateForm()
}

function openEditModal(id,nombre,valor,duracion,descripcion){
    editForm.action = `/sadmin/planes/${id}`
    document.getElementById('edit_nomb_plan').value = nombre
    document.getElementById('edit_valor').value = valor
    document.getElementById('edit_duracion').value = duracion
    document.getElementById('edit_descripcion').value = descripcion ?? ''
    
    // Marcar todos los inputs como touched y validar para habilitar el botón
    Object.keys(touchedEdit).forEach(k => touchedEdit[k]=true)
    validateEditPlan()

    editModal.classList.remove('hidden')
    document.getElementById('overlayEditPlan')?.classList.remove('hidden')
}

function closeEditModal(){
    editModal.classList.add('hidden')
    document.getElementById('overlayEditPlan')?.classList.add('hidden')
}

/* =========================
   ELIMINAR
========================= */
function openDeleteModal(id,name){
    Swal.fire({
        title: '¿Eliminar plan?',
        text: `Se eliminará el plan "${name}". Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(result=>{
        if(result.isConfirmed){
            const form = document.getElementById('deleteForm')
            form.action = `/sadmin/planes/${id}`
            form.submit()
        }
    })
}

/* =========================
   BUSCADOR + PAGINACIÓN AJAX
========================= */
let debounce = null
let currentSearch = ''

function loadPlans(url){
    fetch(url,{ headers:{'X-Requested-With':'XMLHttpRequest'}})
        .then(res=>res.text())
        .then(html=>{
            const doc = new DOMParser().parseFromString(html,'text/html')
            const newWrapper = doc.getElementById('plansWrapper')
            if(newWrapper){
                wrapper.innerHTML = newWrapper.innerHTML
            }
        })
}

function bindPaginationLinks(){
    document.querySelectorAll('#plansWrapper a').forEach(link=>{
        if(!link.href) return
        link.addEventListener('click', e=>{
            e.preventDefault()
            const url = new URL(link.href)
            if(currentSearch) url.searchParams.set('search',currentSearch)
            loadPlans(url.toString())
        })
    })
}

if(searchInput){
    searchInput.addEventListener('input', function(){
        clearTimeout(debounce)
        currentSearch = this.value.trim()
        debounce = setTimeout(()=>{
            const url = new URL(`{{ route('cplanes') }}`)
            if(currentSearch) url.searchParams.set('search',currentSearch)
            loadPlans(url.toString())
        },300)
    })
}

/* =========================
   DELEGACIÓN DE EVENTOS PARA BOTONES DINÁMICOS
========================= */
wrapper.addEventListener('click', function(e){
    const editBtn = e.target.closest('.btn-edit')
    const deleteBtn = e.target.closest('.btn-delete')
    
    if(editBtn){
        const data = editBtn.dataset
        openEditModal(data.id, data.nombre, data.valor, data.duracion, data.descripcion)
    }
    if(deleteBtn){
        const data = deleteBtn.dataset
        openDeleteModal(data.id, data.nombre)
    }
})

document.getElementById('btnOpenCreateModal')?.addEventListener('click', openCreateModal)

/* =========================
   VALIDACIONES
========================= */
function validateCreatePlan(){
    const nombre = document.getElementById('create_nomb_plan')
    const valor = document.getElementById('create_valor')
    const duracion = document.getElementById('create_duracion')
    const descripcion = document.getElementById('create_descripcion')
    const btn = document.getElementById('btnCreatePlan')
    let valid = true

    // Solo mostramos errores si el campo fue tocado
    if(touchedCreate.nombre && nombre.value.trim().length < 3){
        showError('error_create_nomb_plan','El nombre debe tener al menos 3 caracteres')
        nombre.classList.add('border-red-500')
        valid = false
    } else {
        hideError('error_create_nomb_plan')
        nombre.classList.remove('border-red-500')
    }

    const valorNum = Number(valor.value) || 0
    if(touchedCreate.valor && valorNum <= 0){
        showError('error_create_valor','El valor debe ser mayor a 0')
        valor.classList.add('border-red-500')
        valid = false
    } else {
        hideError('error_create_valor')
        valor.classList.remove('border-red-500')
    }

    const duracionNum = Number(duracion.value) || 0
    if(touchedCreate.duracion && duracionNum <= 0){
        showError('error_create_duracion','La duración debe ser mayor a 0')
        duracion.classList.add('border-red-500')
        valid = false
    } else {
        hideError('error_create_duracion')
        duracion.classList.remove('border-red-500')
    }

    if(touchedCreate.descripcion && descripcion.value.trim().length < 5){
        showError('error_create_descripcion','La descripción debe tener al menos 5 caracteres')
        descripcion.classList.add('border-red-500')
        valid = false
    } else {
        hideError('error_create_descripcion')
        descripcion.classList.remove('border-red-500')
    }

    // Para habilitar el botón, validamos todos los campos independientemente de touched
    const allValid = nombre.value.trim().length >= 3 &&
                     valorNum > 0 &&
                     duracionNum > 0 &&
                     descripcion.value.trim().length >= 5

    btn.disabled = !allValid
    btn.classList.toggle('opacity-50', !allValid)
    btn.classList.toggle('cursor-not-allowed', !allValid)
}


function validateEditPlan(){
    const nombre = document.getElementById('edit_nomb_plan')
    const valor = document.getElementById('edit_valor')
    const duracion = document.getElementById('edit_duracion')
    const descripcion = document.getElementById('edit_descripcion')
    const btn = document.getElementById('btnEditPlan')
    let valid = true

    if(touchedEdit.nombre){
        if(nombre.value.trim().length<3){ showError('error_edit_nomb_plan','Debe tener al menos 3 caracteres'); nombre.classList.add('border-red-500'); valid=false }
        else{ hideError('error_edit_nomb_plan'); nombre.classList.remove('border-red-500') }
    }else valid=false

    const valorNum = Number(valor.value)||0
    if(touchedEdit.valor){
        if(valorNum<=0){ showError('error_edit_valor','Debe ser mayor a 0'); valor.classList.add('border-red-500'); valid=false }
        else{ hideError('error_edit_valor'); valor.classList.remove('border-red-500') }
    }else valid=false

    const duracionNum = Number(duracion.value)||0
    if(touchedEdit.duracion){
        if(duracionNum<=0){ showError('error_edit_duracion','Debe ser mayor a 0'); duracion.classList.add('border-red-500'); valid=false }
        else{ hideError('error_edit_duracion'); duracion.classList.remove('border-red-500') }
    }else valid=false

    if(touchedEdit.descripcion){
        if(descripcion.value.trim().length<5){ showError('error_edit_descripcion','Debe tener al menos 5 caracteres'); descripcion.classList.add('border-red-500'); valid=false }
        else{ hideError('error_edit_descripcion'); descripcion.classList.remove('border-red-500') }
    }else valid=false

    btn.disabled = !valid
    btn.classList.toggle('opacity-50',!valid)
    btn.classList.toggle('cursor-not-allowed',!valid)
}

/* =========================
   EVENTOS INPUTS
========================= */
['create_nomb_plan','create_valor','create_duracion','create_descripcion'].forEach(id=>{
    document.getElementById(id)?.addEventListener('input', ()=>{
        touchedCreate[id.replace('create_','').replace('_plan','')]=true
        validateCreatePlan()
    })
})
['edit_nomb_plan','edit_valor','edit_duracion','edit_descripcion'].forEach(id=>{
    document.getElementById(id)?.addEventListener('input', ()=>{
        touchedEdit[id.replace('edit_','').replace('_plan','')]=true
        validateEditPlan()
    })
})

/* =========================
   RESET FORMULARIOS
========================= */
function resetCreateForm(){
    Object.keys(touchedCreate).forEach(k=>touchedCreate[k]=false)
    ['error_create_nomb_plan','error_create_valor','error_create_duracion','error_create_descripcion'].forEach(hideError)
    const btn = document.getElementById('btnCreatePlan')
    btn.disabled=true
    btn.classList.add('opacity-50','cursor-not-allowed')
    ['create_nomb_plan','create_valor','create_duracion','create_descripcion'].forEach(id=>document.getElementById(id)?.classList.remove('border-red-500'))
}

function resetEditForm(){
    Object.keys(touchedEdit).forEach(k=>touchedEdit[k]=false)
    ['error_edit_nomb_plan','error_edit_valor','error_edit_duracion','error_edit_descripcion'].forEach(hideError)
    const btn = document.getElementById('btnEditPlan')
    btn.disabled=true
    btn.classList.add('opacity-50','cursor-not-allowed')
    ['edit_nomb_plan','edit_valor','edit_duracion','edit_descripcion'].forEach(id=>document.getElementById(id)?.classList.remove('border-red-500'))
}

/* =========================
   HELPERS
========================= */
function showError(id,message){
    const el=document.getElementById(id)
    if(!el) return
    el.textContent=message
    el.classList.remove('hidden')
}

function hideError(id){
    const el=document.getElementById(id)
    if(!el) return
    el.textContent=''
    el.classList.add('hidden')
}

/* =========================
   INICIALIZACIÓN
========================= */
bindPaginationLinks()
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
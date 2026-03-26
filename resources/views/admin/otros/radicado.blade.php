@extends('admin.layouts.app')

@section('title', 'Gestión de Radicados')

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
                    Gestión de Radicados
                </h1>

                <p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
                    Administre los números de radicado y su estado asociado.
                </p>
            </div>

            <div class="w-full sm:w-auto mt-2 lg:mt-0"></div>
        </div>

        <div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">

            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Radicados Registrados</h2>
                <div class="flex flex-col md:flex-row gap-4 items-center w-full md:w-auto">

                    <!-- Search Bar -->
                    <form action="{{ route('admin.radicado.index') }}" method="GET" class="relative w-full md:w-64">
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
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Número de Radicado</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

                        @foreach ($radicados as $r)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center dark:text-gray-300">{{ $r->id_radicado }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center font-bold text-[#0d121b] dark:text-white">{{ $r->num_radicado }}</td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="p-2 text-[#4c669a] hover:text-primary transition btn-view-radicado" title="Ver Detalle"
                                            data-id="{{ $r->id_radicado }}"
                                            data-num="{{ $r->num_radicado }}">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button class="p-2 text-[#4c669a] hover:text-primary transition" title="Editar Radicado"
                                            onclick="openEditModal({{ $r->id_radicado }}, '{{ $r->num_radicado }}')">
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
                {{ $radicados->appends(['search' => request('search')])->links() }}
            </div>

        </div>
    </div>
@endsection


@section('modals')

    <!-- MODAL CREAR -->
    <div id="createModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-[#161d2b] w-full max-w-md rounded-xl shadow-2xl p-6 relative">
            <h2 class="text-lg font-bold mb-4 dark:text-white">Crear Radicado</h2>
            <form action="{{ route('admin.radicado.store') }}" method="POST" id="createForm">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de Radicado <span class="text-red-500">*</span></label>
                        <input type="text" name="num_radicado" value="{{ old('num_radicado', old('form_type') === 'create' ? old('num_radicado') : '') }}" class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg p-2 focus:ring-primary focus:border-primary transition-colors" placeholder="Ej: 20261234567890">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-colors font-medium">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-[#161d2b] w-full max-w-md rounded-xl shadow-2xl p-6 relative">
            <h2 class="text-lg font-bold mb-4 dark:text-white">Editar Radicado</h2>
            <form action="" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="edit">
                <input type="hidden" name="id_radicado" id="edit_id_radicado">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de Radicado <span class="text-red-500">*</span></label>
                        <input type="text" name="num_radicado" id="edit_num_radicado" class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg p-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-colors font-medium">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETALLES RADICADO -->
    <div id="detallesRadicadoModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-[#161d2b] w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6 relative">
            <h2 class="text-lg font-bold mb-4 text-[#0d121b] dark:text-white border-b border-[#cfd7e7] dark:border-gray-800 pb-2">Detalles del Radicado</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider mb-1">ID Radicado</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detRadId">-</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider mb-1">Número de Radicado</label>
                    <p class="text-base text-[#0d121b] dark:text-white font-medium" id="detRadNum">-</p>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-[#cfd7e7] dark:border-gray-800 flex justify-end">
                <button onclick="closeDetallesRadicadoModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-colors font-medium">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        function closeDetallesRadicadoModal() {
            const modal = document.getElementById('detallesRadicadoModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

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
                    let id = "{{ old('id_radicado') }}";
                    let url = "{{ route('admin.radicado.update', ['id' => '__ID__']) }}".replace('__ID__', id);
                    document.getElementById('editForm').action = url;
                    toggleModal('editModal', true);
                @endif
            @endif

            function toggleModal(id, show) {
                const modal = document.getElementById(id);
                if(!modal) return;
                modal.classList.toggle('hidden', !show);
                modal.classList.toggle('flex', show);
            }

            window.openCreateModal = function() {
                const form = document.querySelector('#createForm');
                if(form) form.reset();
                
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.dataset.dirty = '';
                    limpiarError(input);
                });

                const btn = form.querySelector('button[type="submit"]');
                if(btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }

                toggleModal('createModal', true);
            }

            window.openEditModal = function(id, num) {
                let url = "{{ route('admin.radicado.update', ['id' => '__ID__']) }}";
                url = url.replace('__ID__', id);
                document.getElementById('editForm').action = url;
                document.getElementById('edit_id_radicado').value = id;
                document.getElementById('edit_num_radicado').value = num;

                const form = document.getElementById('editForm');
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.dataset.dirty = '';
                    limpiarError(input);
                });

                toggleModal('editModal', true);
                
                // Trigger validation for current values
                validarForm(form);
            }

            window.closeModals = function() {
                toggleModal('createModal', false);
                toggleModal('editModal', false);
            }

            // Validaciones
            function mostrarError(input, mensaje) {
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');

                let error = input.parentNode.querySelector('.error-msg');
                if (!error) {
                    error = document.createElement('p');
                    error.classList.add('error-msg', 'text-red-500', 'text-sm', 'mt-1');
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

            async function validarNumero(input, id = null) {
                let valor = input.value.trim();
                
                if (valor === "") {
                    mostrarError(input, "El número de radicado es obligatorio.");
                    return false;
                }

                if (!/^20[2-9][0-9][0-9]{6,14}$/.test(valor)) {
                    mostrarError(input, "Debe ser numérico, tener entre 10 y 18 dígitos y comenzar con el año (ej: 2026...).");
                    return false;
                }

                // Validación de duplicados vía AJAX
                try {
                    let url = `{{ route('admin.radicado.check') }}?numero=${encodeURIComponent(valor)}`;
                    if (id) url += `&id=${id}`;
                    
                    const response = await fetch(url);
                    const data = await response.json();
                    
                    if (data.exists) {
                        mostrarError(input, "Este número de radicado ya existe.");
                        return false;
                    }
                } catch (e) {
                    console.error("Error al validar duplicado:", e);
                }

                limpiarError(input);
                return true;
            }

            function validarEstado(input) {
                if (input.value === "") {
                    mostrarError(input, "Seleccione un estado.");
                    return false;
                }
                limpiarError(input);
                return true;
            }

            async function validarForm(form) {
                const btn = form.querySelector('button[type="submit"]');
                const isEdit = form.id === 'editForm';
                const id = isEdit ? document.getElementById('edit_id_radicado').value : null;
                
                const numInput = form.querySelector('input[name="num_radicado"]');
                
                const okNum = await validarNumero(numInput, id);
                
                const ok = okNum;
                
                if(btn) {
                    btn.disabled = !ok;
                    btn.classList.toggle('opacity-50', !ok);
                    btn.classList.toggle('cursor-not-allowed', !ok);
                }
                return ok;
            }

            // Event Listeners para validación en tiempo real
            const forms = ['createForm', 'editForm'];
            forms.forEach(formId => {
                const form = document.getElementById(formId);
                if (!form) return;

                const numInput = form.querySelector('input[name="num_radicado"]');

                if (numInput) {
                    numInput.addEventListener('input', function() {
                        this.dataset.dirty = 'true';
                        this.value = this.value.replace(/[^0-9]/g, '');
                        validarForm(form);
                    });
                }
            });



            document.querySelectorAll('.btn-view-radicado').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('detRadId').textContent = btn.dataset.id;
                    document.getElementById('detRadNum').textContent = btn.dataset.num;
                    const modal = document.getElementById('detallesRadicadoModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });
            // Client-side search removed for server-side search

        });
    </script>

    <!-- MODAL EXPORTAR -->
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Exportar Radicados</h3>
            <div class="flex flex-col gap-3">
                <a href="{{ route('admin.radicado.export.pdf') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <!-- Excel -->
                <a href="{{ route('admin.radicado.export.excel') }}"
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

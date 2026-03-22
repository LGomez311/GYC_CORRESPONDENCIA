@extends('sadmin.layouts.app')

@section('title', 'Panel de Planes')

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

    <div class="p-4 md:p-8 max-w-7xl mx-auto w-full">

        {{-- HEADER --}}
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">

            {{-- Título --}}
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                    Gestión de Planes
                </h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">
                    Administre los planes del sistema.
                </p>
            </div>

            {{-- Botones --}}
            <div class="flex gap-3">

                {{-- Botón Crear --}}
                <button type="button" onclick="openCreatePlanModal()" aria-haspopup="dialog" aria-controls="planModal"
                    class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined" style="font-size: 18px;">
                        add
                    </span>
                    Añadir Plan
                </button>

            </div>
        </div>

        {{-- CARD --}}
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">

                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Planes Disponibles</h2>

                <div class="flex items-center gap-3">
                    {{-- Botón Historial --}}
                    <button id="btnOpenHistorial"
                        class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                        <span class="material-symbols-outlined" style="font-size: 18px;">history</span>
                        Historial
                    </button>

                    <button onclick="openExportModal()"
                        class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                        <span class="material-symbols-outlined" style="font-size: 18px;">download</span>
                        Exportar
                    </button>
                </div>

            </div>


            <div>
                {{-- TABLA --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">

                        <thead class="bg-background-light dark:bg-background-dark/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Plan</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Descripción</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Precio</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Duración (Dias)</th>
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-center">
                                    Destacado
                                </th>
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
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($plan->descripcion as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </td>





                                    <td class="px-6 py-4 font-bold dark:text-gray-300">
                                        ${{ number_format($plan->valor, 0) }}
                                    </td>

                                    <td class="px-6 py-4 text-sm dark:text-gray-300">
                                        {{ $plan->duracion }} Días
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if ($plan->es_destacado)
                                            <span class="text-blue-600 text-lg">Destacado</span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-1">
                                            <button type="button" onclick='openEditPlanModal(@json($plan))'
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
            </div>

            {{-- PAGINACIÓN --}}
            <div class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800">
                {{ $planes->links('') }}
            </div>


                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(planId, planNombre) {

            Swal.fire({
                title: '¿Estás seguro?',
                text: `El plan "${planNombre}" será eliminado y esta acción no se podrá deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {


                    const form = document.getElementById('deleteForm');

                    form.action = "{{ route('planes.destroy', ':id') }}".replace(':id', planId);

                    form.submit();

                }
            });
        }
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




    <script>
        let planOriginal = null;

        /* =========================
           MODAL CONTROL
        ========================= */
        function openModal() {
            const modal = document.getElementById('planModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePlanCreateModal() {
            const modal = document.getElementById('planModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        /* =========================
           CREAR PLAN
        ========================= */
        function openCreatePlanModal() {
            openModal();

            const form = document.getElementById('planForm');
            form.action = "{{ route('planes.store') }}";

            document.getElementById('planFormMethod').value = "POST";
            document.getElementById('planModalTitle').innerText = 'Crear nuevo plan';

            form.reset();

            const container = document.getElementById('beneficios-container');
            container.innerHTML = '';
            agregarBeneficio();

            planOriginal = null; // importante
        }

        /* =========================
           EDITAR PLAN
        ========================= */
        function openEditPlanModal(plan) {
            openModal();

            const form = document.getElementById('planForm');
            form.action = `/sadmin/planes/${plan.id_plan}`;
            document.getElementById('planFormMethod').value = "PUT";
            document.getElementById('planModalTitle').innerText = 'Editar plan';

            // Básicos
            document.getElementById('nomb_plan').value = plan.nomb_plan ?? '';
            document.getElementById('valor_real').value = plan.valor ?? '0';
            document.getElementById('duracion_real').value = plan.duracion ?? '';

            // Valor
            // Valor
            const valorVisual = document.getElementById('valor_visual');
            const planGratuito = document.getElementById('plan_gratuito');

            if (!plan.valor || Number(plan.valor) === 0) {
                planGratuito.checked = true;
                valorVisual.value = '';
                valorVisual.disabled = true;
                document.getElementById('valor_real').value = '0';
            } else {
                planGratuito.checked = false;
                valorVisual.disabled = false;
                valorVisual.value = new Intl.NumberFormat('es-CO').format(plan.valor);
                document.getElementById('valor_real').value = plan.valor;
            }

            // Duración
            const duracionVisual = document.getElementById('duracion_visual');
            const planInfinito = document.getElementById('plan_infinito');

            const isInfinito = !plan.duracion || Number(plan.duracion) === 0;

            planInfinito.checked = isInfinito;

            if (isInfinito) {
                duracionVisual.value = '';
                duracionVisual.disabled = true;
                duracionVisual.placeholder = 'Este plan se enviará con duración infinita';
                document.getElementById('duracion_real').value = '0';
            } else {
                duracionVisual.disabled = false;
                duracionVisual.value = plan.duracion;
                duracionVisual.placeholder = '60';
                document.getElementById('duracion_real').value = plan.duracion;
            }

            // Destacado
            document.getElementById('es_destacado').checked = !!plan.es_destacado;

            // Beneficios
            const container = document.getElementById('beneficios-container');
            container.innerHTML = '';

            let beneficios = plan.descripcion;

            // Asegurar que siempre sea array de strings
            if (!Array.isArray(beneficios)) {
                try {
                    beneficios = JSON.parse(beneficios);
                } catch {
                    beneficios = [];
                }
            }

            if (!Array.isArray(beneficios) || beneficios.length === 0) {
                agregarBeneficio();
            } else {
                beneficios.forEach(b => agregarBeneficio(b ?? ''));
            }

            // Guardar estado original NORMALIZADO
            setTimeout(() => {
                planOriginal = {
                    nomb_plan: document.getElementById('nomb_plan').value.trim(),
                    valor: document.getElementById('valor_real').value || '0',
                    duracion: document.getElementById('duracion_real').value || '',
                    es_destacado: document.getElementById('es_destacado').checked,
                    plan_gratuito: document.getElementById('plan_gratuito').checked,
                    plan_infinito: document.getElementById('plan_infinito').checked,
                    descripcion: Array.from(
                        document.querySelectorAll('input[name="descripcion[]"]')
                    ).map(i => i.value.trim())
                };
            }, 0);
        }

        /* =========================
           VALIDACIÓN BENEFICIOS
        ========================= */
        const MIN_CHARS = 10;
        const MAX_CHARS = 120;

        function agregarBeneficio(valor = '') {
            const container = document.getElementById('beneficios-container');

            const wrapper = document.createElement('div');
            wrapper.className = 'space-y-1';

            wrapper.innerHTML = `
            <div class="flex gap-2">
                <input type="text"
                    name="descripcion[]"
                    value="${valor}"
                    placeholder="Ej: Acceso a todas las funciones"
                    maxlength="${MAX_CHARS}"
                    class="flex-1 rounded-xl border border-gray-300 px-4 py-3"
                    oninput="limitarYValidar(this)"
                    onblur="validarBeneficio(this)">
                    <button type="button" onclick="eliminarBeneficio(this)"
                    class="px-3 text-red-500">✕</button>
                </div>
                <p class="text-sm text-red-500 hidden"></p>
            `;

            container.appendChild(wrapper);
        }

        function eliminarBeneficio(btn) {
            const container = document.getElementById('beneficios-container');

            if (container.children.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No permitido',
                    text: 'Debes tener al menos un beneficio en el plan.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            btn.closest('.space-y-1').remove();
        }

        function limitarYValidar(input) {
            if (input.value.length > MAX_CHARS) {
                input.value = input.value.slice(0, MAX_CHARS);
            }
            validarBeneficio(input);
        }

        function validarBeneficio(input) {
            const error = input.closest('div').nextElementSibling;
            const value = input.value.trim();

            limpiarError(input, error);

            if (!value) return mostrarError(input, error, 'El beneficio es obligatorio.');
            if (value.length < MIN_CHARS)
                return mostrarError(input, error, `Debe tener al menos ${MIN_CHARS} caracteres.`);
            if (/^(.)\1+$/.test(value.replace(/\s/g, '')))
                return mostrarError(input, error, 'El texto no puede ser repetitivo.');
            if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑ]/.test(value))
                return mostrarError(input, error, 'Debe contener texto válido.');

            return true;
        }

        function mostrarError(input, error, mensaje) {
            error.textContent = mensaje;
            error.classList.remove('hidden');
            input.classList.add('border-red-500');
            return false;
        }

        function limpiarError(input, error) {
            error.textContent = '';
            error.classList.add('hidden');
            input.classList.remove('border-red-500');
        }
    </script>

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

    <script>
        function mostrarErrorSwal(titulo, mensaje) {
            Swal.fire({
                icon: 'error',
                title: titulo,
                text: mensaje,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#dc2626'
            });
        }
    </script>
@endsection

@section('modals')

    {{-- MODAL --}}
    <div id="planModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/40 p-4">

        <div
            class="bg-white dark:bg-[#161d2b] w-full max-w-3xl rounded-xl shadow-xl relative my-10 max-h-[90vh] flex flex-col overflow-hidden border border-[#cfd7e7] dark:border-gray-800">

            {{-- HEADER --}}
            <div class="px-6 pt-6">
                <div class="flex justify-between items-center border-b border-[#cfd7e7] dark:border-gray-800 pb-4 mb-4">
                    <div>
                        <h2 id="planModalTitle" class="text-xl font-semibold text-[#0d121b] dark:text-white">
                            Crear nuevo plan
                        </h2>
                        <p class="text-sm text-[#4c669a] dark:text-gray-400">
                            Los campos con (*) son obligatorios.
                        </p>
                    </div>

                    <button type="button" onclick="closePlanCreateModal()"
                        class="text-gray-500 hover:text-gray-800 dark:hover:text-white">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>

            {{-- BODY --}}
            <form id="planForm" method="POST" class="flex-1 overflow-y-auto px-6 pb-6 space-y-8">
                @csrf
                <input type="hidden" name="_method" id="planFormMethod" value="POST">


                <input type="hidden" id="valor_real" name="valor" value="0">
                <input type="hidden" id="duracion_real" name="duracion" value="0">
                {{-- NOMBRE --}}
                <div>
                    <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">
                        Nombre del plan (*)
                    </label>
                    <input id="nomb_plan" type="text" name="nomb_plan" placeholder="Ej: Plan Profesional"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-3
                       focus:ring-2 focus:ring-primary focus:outline-none">
                </div>
                <p id="nomb_plan_error" class="mt-1 text-sm text-red-600 hidden"></p>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const input = document.getElementById('nomb_plan');
                        const error = document.getElementById('nomb_plan_error');
                        const form = input.closest('form');

                        const allowedRegex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9._\- ]+$/;

                        function showError(message) {
                            error.textContent = message;
                            error.classList.remove('hidden');
                            input.classList.add('border-red-500');
                        }

                        function clearError() {
                            error.textContent = '';
                            error.classList.add('hidden');
                            input.classList.remove('border-red-500');
                        }

                        /**
                         * @returns {string|null}  null = válido | string = mensaje de error
                         */
                        function validatePlanName(value) {
                            const trimmed = value.trim();

                            if (trimmed.length === 0) {
                                const msg = 'El nombre del plan es obligatorio.';
                                showError(msg);
                                return msg;
                            }

                            if (trimmed.length < 3) {
                                const msg = 'Debe tener al menos 3 caracteres.';
                                showError(msg);
                                return msg;
                            }

                            if (trimmed.length > 50) {
                                const msg = 'No puede superar los 50 caracteres.';
                                showError(msg);
                                return msg;
                            }

                            // ❗ NO permitir espacios al inicio o final
                            if (value.startsWith(' ') || value.endsWith(' ')) {
                                const msg = 'No debe comenzar ni terminar con espacios.';
                                showError(msg);
                                return msg;
                            }

                            if (/\s{2,}/.test(value)) {
                                const msg = 'No se permiten múltiples espacios seguidos.';
                                showError(msg);
                                return msg;
                            }

                            if (!allowedRegex.test(value)) {
                                const msg =
                                    'Solo se permiten letras, números, espacios, guion (-), guion bajo (_), punto (.)';
                                showError(msg);
                                return msg;
                            }

                            clearError();
                            return null; // ✅ válido
                        }

                        // Validación en tiempo real
                        input.addEventListener('input', () => {
                            validatePlanName(input.value);
                        });

                        input.addEventListener('blur', () => {
                            validatePlanName(input.value);
                        });

                        // 🔥 VALIDACIÓN FINAL + SWEETALERT
                        form.addEventListener('submit', (e) => {
                            let errores = [];

                            const nombreError = validatePlanName(input.value);
                            if (nombreError) {
                                errores.push(` <b>Nombre del plan</b>: ${nombreError}`);
                            }

                            if (errores.length > 0) {
                                e.preventDefault();
                                input.focus();

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Formulario inválido',
                                    html: `
                                            <div style="text-align:left">
                                                <ul style="padding-left:18px">
                                                ${errores.map(err => `<li>${err}</li>`).join('')}
                                                </ul>
                                            </div>
                                            `,
                                    confirmButtonColor: '#dc2626'
                                });
                            }
                        });
                    });
                </script>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- VALOR --}}
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">
                            Valor del plan (*)
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">$</span>

                            <input id="valor_visual" type="text" placeholder="50000"
                                class="w-full pl-10 rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-3
            focus:ring-2 focus:ring-primary focus:outline-none">
                        </div>

                        <p id="valor_error" class="mt-1 text-sm text-red-600 hidden"></p>

                        {{-- CHECKBOX PLAN GRATUITO --}}
                        <label class="flex items-center gap-3 text-sm font-semibold text-[#0d121b] dark:text-white">
                            <input type="checkbox" id="plan_gratuito"
                                class="rounded border-gray-300 dark:border-gray-700 text-primary focus:ring-primary">
                            ¿Plan gratuito?
                        </label>

                        <p class="text-xs text-gray-500 dark:text-gray-400 ml-7">
                            Al seleccionar esta opción, el plan será gratuito y no podrás asignar un precio.
                        </p>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const inputVisual = document.getElementById('valor_visual');
                            const inputReal = document.getElementById('valor_real');
                            const error = document.getElementById('valor_error');
                            const checkbox = document.getElementById('plan_gratuito');

                            const MIN_VALUE = 100000;
                            const MAX_VALUE = 99999999;
                            const MAX_DIGITS = 8;

                            function showError(message) {
                                error.textContent = message;
                                error.classList.remove('hidden');
                                inputVisual.classList.add('border-red-500');
                            }

                            function clearError() {
                                error.textContent = '';
                                error.classList.add('hidden');
                                inputVisual.classList.remove('border-red-500');
                            }

                            function sanitize(value) {
                                return value.replace(/\D/g, '');
                            }

                            function formatNumber(value) {
                                return new Intl.NumberFormat('es-CO').format(value);
                            }

                            function validateValor(rawValue) {

                                // ⛔ Si es plan gratuito, no validar
                                if (checkbox.checked) {
                                    clearError();
                                    return true;
                                }

                                if (rawValue.length === 0) {
                                    showError('El valor del plan es obligatorio.');
                                    return false;
                                }

                                if (rawValue.length > MAX_DIGITS) {
                                    showError('El valor no puede tener más de 8 dígitos.');
                                    return false;
                                }

                                const number = Number(rawValue);

                                if (Number.isNaN(number)) {
                                    showError('El valor ingresado no es válido.');
                                    return false;
                                }

                                if (number < MIN_VALUE) {
                                    showError(`El valor mínimo permitido es ${MIN_VALUE}.`);
                                    return false;
                                }

                                if (number > MAX_VALUE) {
                                    showError('El valor máximo permitido es 99.999.999 COP.');
                                    return false;
                                }

                                clearError();
                                return true;
                            }

                            // ⛔ Bloquear teclas inválidas
                            inputVisual.addEventListener('keydown', (e) => {
                                if (['e', 'E', '+', '-', '.', ',', ' '].includes(e.key)) {
                                    e.preventDefault();
                                }
                            });

                            // 🔒 Escritura y pegado
                            inputVisual.addEventListener('input', () => {
                                if (checkbox.checked) return;

                                const raw = sanitize(inputVisual.value);

                                if (raw.length > MAX_DIGITS) {
                                    inputVisual.value = formatNumber(raw.slice(0, MAX_DIGITS));
                                    inputReal.value = raw.slice(0, MAX_DIGITS);
                                    validateValor(raw.slice(0, MAX_DIGITS));
                                } else {
                                    inputVisual.value = raw ? formatNumber(raw) : '';
                                    inputReal.value = raw;
                                    validateValor(raw);
                                }
                            });

                            // 🔍 Validación final
                            inputVisual.addEventListener('blur', () => {
                                if (checkbox.checked) return;

                                const raw = sanitize(inputVisual.value);
                                validateValor(raw);
                                inputVisual.value = raw ? formatNumber(raw) : '';
                                inputReal.value = raw;
                            });

                            // ✅ PLAN GRATUITO
                            checkbox.addEventListener('change', () => {
                                if (checkbox.checked) {
                                    clearError();

                                    inputVisual.value = '';
                                    inputVisual.disabled = true;
                                    inputVisual.placeholder = 'Este plan se enviará con valor 0';
                                    inputReal.value = '0'; // 🔥 AQUÍ EL CAMBIO

                                    error.classList.add('hidden');
                                } else {
                                    inputVisual.disabled = false;
                                    inputVisual.placeholder = '60';
                                    inputVisual.value = '';
                                    inputReal.value = '0';
                                }
                            });
                        });
                    </script>

                    {{-- DURACIÓN --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">
                            Duración (días) (*)
                        </label>

                        <input id="duracion_visual" type="text" placeholder="60"
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-3
        focus:ring-2 focus:ring-primary focus:outline-none">

                        <p id="duracion_error" class="mt-1 text-sm text-red-600 hidden"></p>

                        {{-- CHECKBOX PLAN INFINITO --}}
                        <label class="flex items-center gap-3 text-sm font-semibold text-[#0d121b] dark:text-white mt-2">
                            <input type="checkbox" id="plan_infinito"
                                class="rounded border-gray-300 dark:border-gray-700 text-primary focus:ring-primary">
                            ¿Plan infinito?
                        </label>

                        <p class="text-xs text-gray-500 dark:text-gray-400 ml-7">
                            Al seleccionar esta opción, el plan no tendrá fecha de vencimiento.
                        </p>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const inputVisual = document.getElementById('duracion_visual');
                        const inputReal = document.getElementById('duracion_real');
                        const error = document.getElementById('duracion_error');
                        const checkbox = document.getElementById('plan_infinito');

                        const MIN_VALUE = 7; // 👈 se mantiene
                        const MAX_VALUE = 9999;
                        const MAX_DIGITS = 4;

                        function showError(message) {
                            error.textContent = message;
                            error.classList.remove('hidden');
                            inputVisual.classList.add('border-red-500');
                        }

                        function clearError() {
                            error.textContent = '';
                            error.classList.add('hidden');
                            inputVisual.classList.remove('border-red-500');
                        }

                        function sanitize(value) {
                            return value.replace(/\D/g, '');
                        }

                        function formatNumber(value) {
                            return Number(value).toLocaleString('es-CO');
                        }

                        function validateDuracion(rawValue) {

                            // ⛔ Si es plan infinito, no validar
                            if (checkbox.checked) {
                                clearError();
                                return true;
                            }

                            if (rawValue.length === 0) {
                                showError('La duración del plan es obligatoria.');
                                return false;
                            }

                            const number = Number(rawValue);

                            if (Number.isNaN(number)) {
                                showError('La duración ingresada no es válida.');
                                return false;
                            }

                            if (number < 0) {
                                showError('La duración no puede ser negativa.');
                                return false;
                            }

                            if (number < MIN_VALUE) {
                                showError(`El valor mínimo permitido es ${MIN_VALUE}.`);
                                return false;
                            }

                            if (number > MAX_VALUE) {
                                showError('La duración máxima es 9999 días.');
                                return false;
                            }

                            clearError();
                            return true;
                        }

                        // ⛔ Bloquear teclas inválidas
                        inputVisual.addEventListener('keydown', (e) => {
                            if (['e', 'E', '+', '-', '.', ',', ' '].includes(e.key)) {
                                e.preventDefault();
                            }
                        });

                        // 🔒 Escritura + formato
                        inputVisual.addEventListener('input', () => {
                            if (checkbox.checked) return;

                            const raw = sanitize(inputVisual.value);

                            if (raw.length > MAX_DIGITS) {
                                inputVisual.value = formatNumber(raw.slice(0, MAX_DIGITS));
                                inputReal.value = raw.slice(0, MAX_DIGITS);
                            } else if (raw.length > 0) {
                                inputVisual.value = formatNumber(raw);
                                inputReal.value = raw;
                            } else {
                                inputVisual.value = '';
                                inputReal.value = '';
                            }

                            validateDuracion(raw);
                        });

                        // 🔍 Al salir
                        inputVisual.addEventListener('blur', () => {
                            if (checkbox.checked) return;

                            const raw = sanitize(inputVisual.value);
                            validateDuracion(raw);
                            inputReal.value = raw;
                        });

                        // ✅ PLAN INFINITO
                        checkbox.addEventListener('change', () => {
                            if (checkbox.checked) {
                                clearError(); // 👈 fuerza ocultar el mensaje SIEMPRE

                                inputVisual.value = '';
                                inputVisual.disabled = true;
                                inputVisual.placeholder = 'Este plan se enviará con duración infinita';
                                inputReal.value = '0'; // ✅ plan gratuito

                                error.classList.add('hidden'); // 👈 refuerzo visual
                            } else {
                                inputVisual.disabled = false;
                                inputVisual.placeholder = '60'; // placeholder original
                                inputVisual.value = '';
                                inputReal.value = '0';
                            }
                        });

                        // 🧼 Antes de enviar → asegurar valor limpio o null
                        inputVisual.closest('form')?.addEventListener('submit', () => {
                            if (!checkbox.checked) {
                                inputReal.value = sanitize(inputVisual.value);
                            }
                        });
                    });
                </script>

                {{-- BENEFICIOS --}}
                <div>
                    <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-3">
                        Beneficios del plan (*)
                    </label>

                    <div id="beneficios-container" class="space-y-3"></div>

                    <button type="button" onclick="agregarBeneficio()"
                        class="mt-3 text-sm font-semibold text-primary hover:underline">
                        + Agregar beneficio
                    </button>
                    <p class="text-sm mt-1 hidden"></p>
                </div>




                {{-- DESTACADO --}}
                <div class="flex items-center justify-between rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <div>
                        <p class="font-bold text-[#0d121b] dark:text-white">
                            Plan recomendado
                        </p>
                        <p class="text-sm text-[#4c669a] dark:text-gray-400">
                            Se mostrará como destacado
                        </p>
                    </div>

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input id="es_destacado" type="checkbox" name="es_destacado" value="1"
                            class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-primary
                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                            after:bg-white after:rounded-full after:h-5 after:w-5
                            after:transition-all peer-checked:after:translate-x-full">
                        </div>
                    </label>
                </div>

                {{-- FOOTER --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-[#cfd7e7] dark:border-gray-800">
                    <button type="button" onclick="closePlanCreateModal()"
                        class="px-6 py-2 rounded-xl border border-gray-300 dark:border-gray-700
                       text-[#4c669a] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="px-8 py-2 rounded-xl bg-primary font-bold text-white
                       hover:bg-primary/90 transition">
                        Guardar plan
                    </button>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const form = document.getElementById('planForm');

                        form.addEventListener('submit', (e) => {

                            let valido = true;
                            let errores = [];

                            document.getElementById('valor_real').value =
                                document.getElementById('valor_real').value || '0';

                            document.getElementById('duracion_real').value =
                                document.getElementById('duracion_real').value || '0';

                            // =========================
                            // OBTENER CAMPOS
                            // =========================
                            const nombre = document.getElementById('nomb_plan');
                            const valor = document.getElementById('valor_visual');
                            const duracion = document.getElementById('duracion_visual');
                            const beneficios = document.querySelectorAll('input[name="descripcion[]"]');
                            const planInfinito = document.getElementById('plan_infinito');

                            const valorRaw = document.getElementById('valor_real')?.value;
                            const duracionRaw = document.getElementById('duracion_real')?.value;
                            const planGratuito = document.getElementById('plan_gratuito');

                            if (!planGratuito.checked && (!valorRaw || valorRaw === '0')) {
                                valido = false;
                                errores.push(' <b>Valor</b>: es obligatorio.');

                                const valorInput = document.getElementById('valor_visual');
                                const valorError = document.getElementById('valor_error');

                                valorInput.classList.add('border-red-500');
                                valorError.textContent = 'El valor es obligatorio.';
                                valorError.classList.remove('hidden');
                            } else {
                                // Si es gratuito o tiene valor válido, limpiar error
                                const valorInput = document.getElementById('valor_visual');
                                const valorError = document.getElementById('valor_error');

                                valorInput.classList.remove('border-red-500');
                                valorError.classList.add('hidden');
                                valorError.textContent = '';
                            }

                            // =========================
                            // NOMBRE
                            // =========================
                            const nombreValue = nombre.value;

                            if (!nombreValue.trim()) {
                                valido = false;
                                errores.push(' <b>Nombre del plan</b>: es obligatorio.');
                            }

                            if (nombreValue.trim() && nombreValue.trim().length < 3) {
                                valido = false;
                                errores.push(' <b>Nombre del plan</b>: mínimo 3 caracteres.');
                            }

                            if (nombreValue.startsWith(' ') || nombreValue.endsWith(' ')) {
                                valido = false;
                                errores.push(' <b>Nombre del plan</b>: no debe comenzar ni terminar con espacios.');
                            }

                            if (/\s{2,}/.test(nombreValue)) {
                                valido = false;
                                errores.push(' <b>Nombre del plan</b>: no se permiten múltiples espacios seguidos.');
                            }

                            // =========================
                            // VALOR (🔥 SOLO SE AGREGA LO VISUAL)
                            // =========================
                            const valorError = document.getElementById('valor_error');

                            if (!valorRaw || valorRaw === '') {
                                valido = false;
                                errores.push(' <b>Valor</b>: es obligatorio.');

                                const valorInput = document.getElementById('valor_visual');
                                const valorError = document.getElementById('valor_error');

                                valorInput.classList.add('border-red-500');
                                valorError.textContent = 'El valor es obligatorio.';
                                valorError.classList.remove('hidden');
                            }

                            // =========================
                            // DURACIÓN (🔥 SOLO SE AGREGA LO VISUAL)
                            // =========================
                            const duracionError = document.getElementById('duracion_error');

                            if (!planInfinito.checked && (!duracionRaw || duracionRaw === '0')) {
                                valido = false;
                                errores.push(' <b>Duración</b>: es obligatoria.');

                                const duracionInput = document.getElementById('duracion_visual');
                                const duracionError = document.getElementById('duracion_error');

                                duracionInput.classList.add('border-red-500');
                                duracionError.textContent = 'La duración es obligatoria.';
                                duracionError.classList.remove('hidden');
                            }



                            // =========================
                            // BENEFICIOS
                            // =========================
                            if (beneficios.length === 0) {
                                valido = false;
                                errores.push(' <b>Beneficios</b>: debes agregar al menos uno.');
                            }

                            beneficios.forEach((input, index) => {
                                if (!validarBeneficio(input)) {
                                    valido = false;

                                    const mensaje = input
                                        .closest('.space-y-1')
                                        .querySelector('p')
                                        .textContent;

                                    errores.push(` <b>Beneficio #${index + 1}</b>: ${mensaje}`);
                                }
                            });

                            // =========================
                            // UPDATE SIN CAMBIOS
                            // =========================
                            const method = document.getElementById('planFormMethod').value;

                            if (method === 'PUT' && planOriginal) {
                                const current = {
                                    nomb_plan: nombre.value.trim(),
                                    valor: valorRaw,
                                    duracion: duracionRaw,
                                    es_destacado: document.getElementById('es_destacado').checked,
                                    descripcion: Array.from(beneficios).map(b => b.value.trim())
                                };

                                const sinCambios =
                                    planOriginal.nomb_plan === current.nomb_plan &&
                                    planOriginal.valor === current.valor &&
                                    planOriginal.duracion === current.duracion &&
                                    planOriginal.es_destacado === current.es_destacado &&
                                    JSON.stringify(planOriginal.descripcion) === JSON.stringify(current.descripcion);

                                if (sinCambios) {
                                    e.preventDefault();
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Sin cambios',
                                        text: 'Debes modificar al menos un campo para actualizar el plan.',
                                        confirmButtonColor: '#3085d6'
                                    });
                                    return;
                                }
                            }

                            // =========================
                            // BLOQUEAR ENVÍO
                            // =========================
                            if (!valido) {
                                e.preventDefault();

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Formulario inválido',
                                    html: `
                    <div style="text-align:left">
                        <ul style="padding-left:18px">
                            ${errores.map(e => `<li>${e}</li>`).join('')}
                        </ul>
                    </div>
                `,
                                    confirmButtonColor: '#dc2626'
                                });
                            }
                        });
                    });
                </script>
            </form>
        </div>
    </div>





    {{-- MODAL HISTORIAL --}}
    <div id="historialModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-[60] p-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-4xl max-h-[85vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                        Historial de Modificaciones
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Registro de cambios realizados a los planes en el sistema.
                    </p>
                </div>
                <button onclick="closeHistorialModal()"
                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="p-5 overflow-y-auto flex-1">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-800/50 sticky top-0">
                            <tr>
                                <th
                                    class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Fecha / Hora</th>
                                <th
                                    class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Plan Afectado</th>
                                <th
                                    class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Modificado Por</th>
                                <th
                                    class="px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
                                    Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse ($auditorias as $auditoria)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $auditoria->fecha_cambio->format('d/m/Y H:i A') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="font-semibold text-primary">
                                            Plan #{{ $auditoria->id_plan_afectado }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="font-semibold">
                                            {{ $auditoria->responsable->emple_nombres ?? 'Sistema' }}
                                            {{ $auditoria->responsable->emple_apellidos ?? '' }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $auditoria->usuario_app ? 'C.C. ' . $auditoria->usuario_app : 'BD' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button onclick="verDetallesCambio({{ $auditoria->id_log }})"
                                            class="text-primary hover:text-blue-700 bg-blue-50 dark:bg-blue-900/20 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 mx-auto transition-colors">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">visibility</span>
                                            Ver Cambios
                                        </button>
                                        <!-- Datos Ocultos para JS -->
                                        <div id="datos-ant-{{ $auditoria->id_log }}" class="hidden">
                                            {{ json_encode($auditoria->datos_anteriores) }}
                                        </div>
                                        <div id="datos-nue-{{ $auditoria->id_log }}" class="hidden">
                                            {{ json_encode($auditoria->datos_nuevos) }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <span
                                                class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">history</span>
                                            Aún no hay registros de modificaciones
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETALLES DE CAMBIOS --}}
    <div id="detallesCambioModal"
        class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-[60] p-4 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl w-full max-w-3xl flex flex-col overflow-hidden">
            <div
                class="p-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h4 class="text-md font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">compare_arrows</span>
                    Comparación de Datos
                </h4>
                <button onclick="closeDetallesCambioModal()" class="text-gray-500 hover:text-red-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <div class="grid grid-cols-2 gap-6" id="contenedor-comparacion">
                    <!-- Se renderiza via JS -->
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button onclick="closeDetallesCambioModal()"
                    class="px-5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg transition-colors">
                    Cerrar Detalles
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /* ===========================
               HISTORIAL DE AUDITORÍA
            ============================*/
            const btnHistorial = document.getElementById('btnOpenHistorial');
            if (btnHistorial) {
                btnHistorial.addEventListener('click', () => {
                    document.getElementById('historialModal').classList.remove('hidden');
                });
            }

            window.closeHistorialModal = function() {
                document.getElementById('historialModal').classList.add('hidden');
            }

            window.closeDetallesCambioModal = function() {
                document.getElementById('detallesCambioModal').classList.add('hidden');
            }

            window.verDetallesCambio = function(idLog) {
                const modal = document.getElementById('detallesCambioModal');
                const contenedor = document.getElementById('contenedor-comparacion');

                try {
                    const datosAnt = JSON.parse(document.getElementById(`datos-ant-${idLog}`).textContent
                        .trim() || '{}');
                    const datosNue = JSON.parse(document.getElementById(`datos-nue-${idLog}`).textContent
                        .trim() || '{}');

                    let htmlAnt =
                        '<div class="flex flex-col gap-3"><h5 class="font-bold text-red-600 border-b pb-2 mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">remove_circle</span> Datos Anteriores</h5>';
                    let htmlNue =
                        '<div class="flex flex-col gap-3"><h5 class="font-bold text-green-600 border-b pb-2 mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">add_circle</span> Datos Nuevos</h5>';

                    const camposRelevantes = ['nomb_plan', 'valor', 'duracion', 'descripcion', 'es_destacado'];
                    const labelsMap = {
                        'nomb_plan': 'Nombre del Plan',
                        'valor': 'Valor (COP)',
                        'duracion': 'Duración (Días)',
                        'descripcion': 'Beneficios',
                        'es_destacado': 'Destacado'
                    };

                    camposRelevantes.forEach(campo => {
                        let valAnt = datosAnt[campo];
                        let valNue = datosNue[campo];

                        // Parse JSON fields like descripcion if they come stringified
                        if (campo === 'descripcion') {
                            try {
                                if (typeof valAnt === 'string') valAnt = JSON.parse(valAnt);
                            } catch (e) {}
                            try {
                                if (typeof valNue === 'string') valNue = JSON.parse(valNue);
                            } catch (e) {}

                            // Convert arrays to string representation
                            if (Array.isArray(valAnt)) valAnt = valAnt.join(' | ');
                            if (Array.isArray(valNue)) valNue = valNue.join(' | ');
                        }

                        // Parse boolean inputs
                        if (campo === 'es_destacado') {
                            valAnt = (valAnt == 1 || valAnt === true) ? 'Sí' : 'No';
                            valNue = (valNue == 1 || valNue === true) ? 'Sí' : 'No';
                        }

                        // Prevent "No definido" on standard outputs if null
                        if (valAnt === null || valAnt === undefined) valAnt = 'No definido';
                        if (valNue === null || valNue === undefined) valNue = 'No definido';

                        const esDiferente = String(valAnt) !== String(valNue);

                        // Resaltar si cambió
                        const claseAnt = esDiferente ?
                            'bg-red-50 text-red-700 p-2 rounded border border-red-100' :
                            'p-2 text-gray-600';
                        const claseNue = esDiferente ?
                            'bg-green-50 text-green-700 p-2 rounded border border-green-100' :
                            'p-2 text-gray-600';

                        const label = labelsMap[campo] || campo;

                        htmlAnt += `
                            <div class="${claseAnt}">
                                <div class="text-xs font-bold uppercase tracking-wider mb-1 opacity-70">${label}</div>
                                <div class="text-sm break-words">${valAnt}</div>
                            </div>
                        `;

                        htmlNue += `
                            <div class="${claseNue}">
                                <div class="text-xs font-bold uppercase tracking-wider mb-1 opacity-70">${label}</div>
                                <div class="text-sm break-words">${valNue}</div>
                            </div>
                        `;
                    });

                    htmlAnt += '</div>';
                    htmlNue += '</div>';

                    contenedor.innerHTML = htmlAnt + htmlNue;
                    modal.classList.remove('hidden');

                } catch (error) {
                    console.error("Error al procesar JSON de detalles", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Datos',
                        text: 'No se pudieron cargar los detalles de este cambio.'
                    });
                }
            }
        });
    </script>

    {{-- MODAL EXPORTAR --}}
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[60]">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                Exportar Planes
            </h3>

            <div class="flex flex-col gap-3">

                <!-- PDF -->
                <a href="{{ route('planes.export.pdf') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <!-- Excel -->
                <a href="{{ route('planes.export.excel') }}"
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
@endsection

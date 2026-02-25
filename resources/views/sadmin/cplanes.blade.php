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

            <button type="button" onclick="openCreatePlanModal()" aria-haspopup="dialog" aria-controls="planModal"
                class="group inline-flex items-center gap-2
           rounded-xl bg-primary px-6 py-3
           text-sm font-bold text-white
           shadow-lg
           hover:bg-primary/90 hover:scale-[1.02]
           focus:outline-none focus:ring-2 focus:ring-primary/50
           transition">
                <span class="material-symbols-outlined text-base group-hover:rotate-90 transition">
                    add
                </span>
                Crear nuevo plan
            </button>

        </div>

        {{-- CARD --}}
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">

            <div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex justify-between items-center">

                <h2 class="text-lg font-bold dark:text-white">Planes Disponibles</h2>

                <button onclick="openExportModal()"
                    class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Exportar
                </button>

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
                                <th class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Duración (Dias)</th>
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
                    {{-- PAGINACIÓN --}}
                    <div class="flex gap-1">
                        {{ $planes->links('') }}
                    </div>
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

    <script>
        let planOriginal = null;

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

            document.getElementById('nomb_plan').value = plan.nomb_plan;
            document.getElementById('valor').value = plan.valor;
            document.getElementById('duracion').value = plan.duracion;
            document.getElementById('es_destacado').checked = !!plan.es_destacado;

            const container = document.getElementById('beneficios-container');
            container.innerHTML = '';



            // 🔥 NORMALIZACIÓN CLAVE
            let beneficios = plan.descripcion;

            if (typeof beneficios === 'string') {
                try {
                    beneficios = JSON.parse(beneficios);
                } catch (e) {
                    beneficios = [];
                }
            }

            if (!Array.isArray(beneficios)) {
                beneficios = [];
            }

            // Si no hay beneficios, deja uno vacío
            if (beneficios.length === 0) {
                agregarBeneficio();
                return;
            }

            // Si no hay beneficios, deja uno vacío
            if (beneficios.length === 0) {
                agregarBeneficio();
                return;
            }

            // 🔥 USAR LA MISMA FUNCIÓN QUE EN CREAR
            beneficios.forEach(desc => {
                agregarBeneficio(desc);
            });

            // =========================
            // GUARDAR ESTADO ORIGINAL (SEGURO)
            // =========================
            setTimeout(() => {
                planOriginal = {
                    nomb_plan: document.getElementById('nomb_plan').value.trim(),
                    valor: String(plan.valor),
                    duracion: String(plan.duracion),
                    es_destacado: !!plan.es_destacado,
                    descripcion: Array.from(
                        document.querySelectorAll('input[name="descripcion[]"]')
                    ).map(i => i.value.trim())
                };
            }, 0);
        }

        /* =========================
           CONFIGURACIÓN
        ========================= */
        const MIN_CHARS = 10;
        const MAX_CHARS = 120;

        /* =========================
           AGREGAR BENEFICIO
        ========================= */
        function agregarBeneficio(valor = '') {
            const container = document.getElementById('beneficios-container');

            const wrapper = document.createElement('div');
            wrapper.className = 'space-y-1';

            wrapper.innerHTML = `
        <div class="flex gap-2">
            <input type="text"
                name="descripcion[]"
                value="${valor}"
                maxlength="${MAX_CHARS}"
                placeholder="Ej: Soporte prioritario"
                class="flex-1 rounded-xl border border-gray-300 px-4 py-3
                       focus:ring-2 focus:ring-primary focus:outline-none"
                oninput="limitarYValidar(this)"
                onblur="validarBeneficio(this)">
            <button type="button" onclick="eliminarBeneficio(this)"
                class="px-3 text-red-500 hover:text-red-700">✕</button>
        </div>
        <p class="text-sm text-red-500 hidden"></p>
    `;

            container.appendChild(wrapper);
        }

        /* =========================
           ELIMINAR BENEFICIO
        ========================= */
        function eliminarBeneficio(btn) {
            const container = document.getElementById('beneficios-container');

            if (container.children.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debe existir al menos un beneficio.',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            btn.closest('.space-y-1').remove();
        }

        /* =========================
           LIMITAR + VALIDAR EN TIEMPO REAL
        ========================= */
        function limitarYValidar(input) {
            if (input.value.length > MAX_CHARS) {
                input.value = input.value.slice(0, MAX_CHARS);
            }
            validarBeneficio(input);
        }

        /* =========================
           VALIDACIÓN DE BENEFICIO
        ========================= */
        function validarBeneficio(input) {
            const error = input.closest('div').nextElementSibling;
            const value = input.value.trim();

            limpiarError(input, error);

            // Obligatorio
            if (!value) {
                return mostrarError(input, error, 'El beneficio es obligatorio.');
            }

            // Mínimo
            if (value.length < MIN_CHARS) {
                return mostrarError(
                    input,
                    error,
                    `Debe tener al menos ${MIN_CHARS} caracteres.`
                );
            }

            // Máximo (seguridad extra)
            if (value.length > MAX_CHARS) {
                return mostrarError(
                    input,
                    error,
                    `No puede superar los ${MAX_CHARS} caracteres.`
                );
            }

            // Texto repetitivo (aaaaaa, dddddd)
            if (/^(.)\1+$/.test(value.replace(/\s/g, ''))) {
                return mostrarError(input, error, 'El texto no puede ser repetitivo.');
            }

            // Debe contener letras reales
            if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑ]/.test(value)) {
                return mostrarError(input, error, 'Debe contener texto válido.');
            }

            return true;
        }

        /* =========================
           HELPERS
        ========================= */
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



        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('planForm');

            form.addEventListener('submit', (e) => {

                // 🔹 Solo aplica en UPDATE
                const method = document.getElementById('planFormMethod')?.value;
                if (method !== 'PUT') return;

                if (!planOriginal) return;

                // 🔍 Estado actual del formulario
                const current = {
                    nomb_plan: document.getElementById('nomb_plan').value.trim(),
                    valor: document.getElementById('valor').value.replace(/\D/g, ''),
                    duracion: document.getElementById('duracion').value.replace(/\D/g, ''),
                    es_destacado: document.getElementById('es_destacado').checked,
                    descripcion: Array.from(
                        document.querySelectorAll('input[name="descripcion[]"]')
                    ).map(i => i.value.trim())
                };

                // 🔄 Comparación profunda
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
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        });
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
    <div id="planModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

        <div
            class="relative w-full max-w-3xl mx-4
           bg-white dark:bg-[#161d2b]
           rounded-2xl shadow-xl border border-[#cfd7e7] dark:border-gray-800
           max-h-[90vh] overflow-y-auto">

            {{-- HEADER --}}
            <div class="flex items-center justify-between p-6 border-b border-[#cfd7e7] dark:border-gray-800">
                <div>
                    <h2 id="planModalTitle" class="text-xl font-black text-[#0d121b] dark:text-white">
                        Crear nuevo plan
                    </h2>
                    <p class="text-sm text-[#4c669a] dark:text-gray-400">
                        Los campos con (*) son obligatorios.
                    </p>
                </div>

                <button onclick="closePlanCreateModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                    &times;
                </button>
            </div>

            {{-- BODY --}}
            <form id="planForm" method="POST" class="p-6 space-y-8">
                @csrf
                <input type="hidden" name="_method" id="planFormMethod" value="POST">

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

                {{-- VALOR + DURACIÓN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">
                            Valor del plan (*)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">$</span>
                            <input id="valor" type="text" name="valor" placeholder="50000"
                                class="w-full pl-10 rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-3
           focus:ring-2 focus:ring-primary focus:outline-none">

                            <p id="valor_error" class="mt-1 text-sm text-red-600 hidden"></p>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const input = document.getElementById('valor');
                            const error = document.getElementById('valor_error');

                            const MIN_VALUE = 0;
                            const MAX_VALUE = 99999999;
                            const MAX_DIGITS = 8;

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

                            function sanitize(value) {
                                return value.replace(/\D/g, '');
                            }

                            function formatNumber(value) {
                                return new Intl.NumberFormat('es-CO').format(value);
                            }

                            function validateValor(rawValue) {
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
                            input.addEventListener('keydown', (e) => {
                                if (['e', 'E', '+', '-', '.', ',', ' '].includes(e.key)) {
                                    e.preventDefault();
                                }
                            });

                            // 🔒 Escritura y pegado con formato
                            input.addEventListener('input', () => {
                                const raw = sanitize(input.value);

                                if (raw.length > MAX_DIGITS) {
                                    input.value = formatNumber(raw.slice(0, MAX_DIGITS));
                                    validateValor(raw.slice(0, MAX_DIGITS));
                                } else {
                                    input.value = raw ? formatNumber(raw) : '';
                                    validateValor(raw);
                                }
                            });

                            // 🔍 Validación final
                            input.addEventListener('blur', () => {
                                const raw = sanitize(input.value);
                                validateValor(raw);
                                input.value = raw ? formatNumber(raw) : '';
                            });
                        });
                    </script>

                    <div>
                        <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">
                            Duración (días)
                        </label>

                        <input id="duracion" type="text" name="duracion" placeholder="60"
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-3
                            focus:ring-2 focus:ring-primary focus:outline-none">

                        <p id="duracion_error" class="mt-1 text-sm text-red-600 hidden"></p>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const input = document.getElementById('duracion');
                        const error = document.getElementById('duracion_error');

                        const MIN_VALUE = 0; // 👈 ahora permite 0 (ilimitado)
                        const MAX_VALUE = 9999;
                        const MAX_DIGITS = 4;

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

                        function sanitize(value) {
                            // quitar todo excepto números
                            return value.replace(/\D/g, '');
                        }

                        function formatNumber(value) {
                            // formatear con separador de miles (es-CO usa punto)
                            return Number(value).toLocaleString('es-CO');
                        }

                        function validateDuracion(rawValue) {
                            if (rawValue.length === 0) {
                                showError('La duración del plan es obligatoria.');
                                return false;
                            }

                            const number = Number(rawValue);

                            if (Number.isNaN(number)) {
                                showError('La duración ingresada no es válida.');
                                return false;
                            }

                            if (number < MIN_VALUE) {
                                showError('La duración no puede ser negativa.');
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
                        input.addEventListener('keydown', (e) => {
                            if (['e', 'E', '+', '-', '.', ',', ' '].includes(e.key)) {
                                e.preventDefault();
                            }
                        });

                        // 🔒 Control total + formato visual
                        input.addEventListener('input', () => {
                            const raw = sanitize(input.value);

                            if (raw.length > MAX_DIGITS) {
                                input.value = formatNumber(raw.slice(0, MAX_DIGITS));
                            } else if (raw.length > 0) {
                                input.value = formatNumber(raw);
                            } else {
                                input.value = '';
                            }

                            validateDuracion(raw);
                        });

                        // 🔍 Al salir, validar
                        input.addEventListener('blur', () => {
                            const raw = sanitize(input.value);
                            validateDuracion(raw);
                        });

                        // 🧼 Antes de enviar el form → enviar valor limpio
                        input.closest('form')?.addEventListener('submit', () => {
                            input.value = sanitize(input.value);
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

                            // =========================
                            // OBTENER CAMPOS
                            // =========================
                            const nombre = document.getElementById('nomb_plan');
                            const valor = document.getElementById('valor');
                            const duracion = document.getElementById('duracion');
                            const beneficios = document.querySelectorAll('input[name="descripcion[]"]');

                            const valorRaw = valor.value.replace(/\D/g, '');
                            const duracionRaw = duracion.value.replace(/\D/g, '');

                            // =========================
                            // NOMBRE
                            // =========================
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

                            if (!valorRaw) {
                                valido = false;
                                errores.push(' <b>Valor</b>: es obligatorio.');

                                valor.classList.add('border-red-500');
                                valorError.textContent = 'El valor es obligatorio.';
                                valorError.classList.remove('hidden');
                            }

                            // =========================
                            // DURACIÓN (🔥 SOLO SE AGREGA LO VISUAL)
                            // =========================
                            const duracionError = document.getElementById('duracion_error');

                            if (!duracionRaw) {
                                valido = false;
                                errores.push(' <b>Duración</b>: es obligatoria.');

                                duracion.classList.add('border-red-500');
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





    {{-- MODAL EXPORTAR --}}
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
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
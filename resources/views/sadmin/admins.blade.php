@extends('sadmin.layouts.app')

@section('title', 'Panel de Usuarios')

@section('content')

    <script>
        /**
         * ===== FUNCIONES DE SEGURIDAD Y SANITIZACIÓN (Se cargan PRIMERO) =====
         */

        /**
         * Sanitiza strings contra XSS
         */
        function sanitizeString(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#x27;')
                .replace(/\//g, '&#x2F;');
        }

        /**
         * Detecta patrones de inyección SQL
         */
        function detectSQLInjection(str) {
            if (!str) return false;
            const sqlPatterns = [
                /(\b(UNION|SELECT|INSERT|UPDATE|DELETE|DROP|EXEC|EXECUTE|SCRIPT|ALERT|EVAL)\b)/gi,
                /(-{2}|\/\*|\*\/|;)/g,
                /(javascript:|onerror=|onload=|onclick=)/gi
            ];
            return sqlPatterns.some(pattern => {
                pattern.lastIndex = 0;
                return pattern.test(str);
            });
        }

        /**
         * Valida contra XSS
         */
        function detectXSSAttempt(str) {
            if (!str) return false;
            const xssPatterns = [
                /<script[^>]*>.*?<\/script>/gi,
                /javascript:/gi,
                /<iframe[^>]*>/gi,
                /<img[^>]*on/gi,
                /on(load|error|click|mouse)[^=]*=/gi,
                /<svg[^>]*on/gi,
                /eval\(/gi
            ];
            return xssPatterns.some(pattern => {
                pattern.lastIndex = 0;
                return pattern.test(str);
            });
        }

        /**
         * Valida entrada de usuario
         */
        function validateSecurityThreats(fields = {}) {
            for (const [fieldName, value] of Object.entries(fields)) {
                if (!value) continue;
                if (detectSQLInjection(value)) {
                    return {
                        valid: false,
                        threat: 'SQL Injection',
                        field: fieldName
                    };
                }
                if (detectXSSAttempt(value)) {
                    return {
                        valid: false,
                        threat: 'XSS Attack',
                        field: fieldName
                    };
                }
            }
            return {
                valid: true
            };
        }

        /**
         * Previene múltiples envíos (rate limiting)
         */
        let formSubmitTimestamp = 0;
        const FORM_SUBMIT_COOLDOWN = 2000;

        function canSubmitForm() {
            const now = Date.now();
            if (now - formSubmitTimestamp < FORM_SUBMIT_COOLDOWN) {
                return false;
            }
            formSubmitTimestamp = now;
            return true;
        }
    </script>

    <div class="p-8 max-w-7xl mx-auto w-full">
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                    Gestión de Admins de Empresas</h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">Controle el acceso y gestione
                    los perfiles de administradores para cada organización.</p>
            </div>
            <div class="flex gap-3">




                {{-- BOTÓN CREAR --}}
                <button onclick="openModal()"
                    class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Crear Nuevo Admin
                </button>



            </div>
        </div>
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Administradores de
                    Empresas</h2>

                {{-- BOTÓN EXPORTAR --}}
                <button onclick="openExportModal()"
                    class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Exportar
                </button>

            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Nombre del Administrador</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-center">
                                Empresa Asociada
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Correo Electrónico</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Estado</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-right">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center overflow-hidden">
                                            <img alt="Avatar" class="w-full h-full object-cover"
                                                src="{{ asset('storage/' . $user->emple_img) }}">
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-bold text-[#0d121b] dark:text-white">{{ $user->emple_nombres }}
                                                {{ $user->emple_apellidos }}
                                            </span>
                                            <span class="text-xs text-[#4c669a] dark:text-gray-400">DOCUMENTO:
                                                {{ $user->emple_doc }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm dark:text-gray-300 align-middle text-center">
                                    <span class="text-sm font-bold text-[#0d121b] dark:text-white">
                                        {{ $user->empresa->nomb_empresa }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">{{ $user->emple_correo }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ $user->estado->estado_nomb }}

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button onclick="openModalProfile(this)"
                                            class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                            title="Ver detalles" data-documento="{{ $user->emple_doc }}"
                                            data-nit="{{ $user->empresa->nit_empresa ?? '' }}"
                                            data-empresa="{{ $user->empresa->nombre_empresa ?? '' }}"
                                            data-nombres="{{ $user->emple_nombres }}"
                                            data-apellidos="{{ $user->emple_apellidos }}"
                                            data-telefono="{{ $user->emple_tel }}" data-correo="{{ $user->emple_correo }}"
                                            data-estado="{{ $user->estado->estado_nomb ?? '' }}"
                                            data-rol="{{ $user->rol->rol_nomb ?? '' }}"
                                            data-area="{{ $user->area->area_nomb ?? '' }}"
                                            data-foto="{{ asset('storage/' . $user->emple_img) }}"
                                            class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                            title="Ver detalles">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-[#4c669a] hover:text-primary transition-colors btn-open-edit"
                                            title="Editar" data-documento="{{ $user->emple_doc }}"
                                            data-nit="{{ $user->nit_empresa }}" data-nombres="{{ $user->emple_nombres }}"
                                            data-apellidos="{{ $user->emple_apellidos }}"
                                            data-telefono="{{ $user->emple_tel }}" data-correo="{{ $user->emple_correo }}"
                                            data-estado="{{ $user->emple_estado }}">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>

                                        <form action="{{ route('usuarios.destroy', $user->emple_doc) }}" method="POST"
                                            class="form-eliminar inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                                title="Eliminar">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($users->count() == 0)
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <div
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm">
                                        <span class="material-symbols-outlined text-[18px]">info</span>
                                        No hay registros disponibles
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="flex gap-1">
                    {{ $users->links() }}
                </div>

            </div>


        </div>
    </div>
    </div>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626'
            });
        </script>
    @endif
    <script>
        document.querySelectorAll('.form-eliminar').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Eliminar usuario?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    {{-- MODAL EXPORTAR --}}
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">
                Exportar Administradores
            </h3>

            <div class="flex flex-col gap-3">

                <!-- PDF -->
                <a href="{{ route('sadmin.export.pdf') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                    PDF
                </a>

                <!-- Excel -->
                <a href="{{ route('sadmin.export.excel') }}"
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

@section('modals')

    <!-- Scripts globales (cargados primero) -->
    <script>
        /**
         * ===== VALIDACIONES DEL FORMULARIO DE EDITAR ADMIN =====
         */
        let validEdit = {
            nombres: false,
            apellidos: false,
            telefono: false,
            correo: false,
            estado: false
        };

        let editFormOriginalData = {};

        // Validación de texto para edición
        function validateTextoEdit(input, errorId) {
            input.value = input.value
                .replace(/[^a-zA-Z\s]/g, '')
                .replace(/\b\w/g, l => l.toUpperCase());

            const isValid = /^[A-Z][a-zA-Z\s]*$/.test(input.value);

            // 🔒 Validar contra XSS
            if (detectXSSAttempt(input.value)) {
                const errorEl = document.getElementById(errorId);
                if (errorEl) errorEl.textContent = 'Caracteres no permitidos (XSS detectado)';
                toggleErrorEdit(errorId, true);
                validEdit[input.id.replace('edit_', '')] = false;
            } else {
                validEdit[input.id.replace('edit_', '')] = isValid;
                toggleErrorEdit(errorId, !isValid);
            }
            checkFormEdit();
        }

        // Validación de teléfono para edición
        function validateTelefonoEdit(input) {
            input.value = input.value.replace(/\D/g, '').slice(0, 10);
            validEdit.telefono = input.value.length === 10;
            toggleErrorEdit('edit-error-telefono', !validEdit.telefono);
            checkFormEdit();
        }

        // Validación de correo para edición
        function validateCorreoEdit(input) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            validEdit.correo = regex.test(input.value);

            // 🔒 Validar contra XSS
            if (detectXSSAttempt(input.value)) {
                const errorEl = document.getElementById('edit-error-correo');
                if (errorEl) errorEl.textContent = 'Correo contiene caracteres no permitidos';
                toggleErrorEdit('edit-error-correo', true);
                validEdit.correo = false;
            } else {
                toggleErrorEdit('edit-error-correo', !validEdit.correo);
            }
            checkFormEdit();
        }

        // Validación de estado para edición
        function validateEstadoEdit(input) {
            validEdit.estado = input.value !== '';
            checkFormEdit();
        }

        // Mostrar/ocultar errores para edición
        function toggleErrorEdit(id, show) {
            const element = document.getElementById(id);
            if (element) {
                element.classList.toggle('hidden', !show);
            }
        }

        // Detectar cambios en el formulario de edición
        function hasEditFormChanged() {
            const fieldMap = {
                'edit_nombres': 'edit_nombres',
                'edit_apellidos': 'edit_apellidos',
                'edit_telefono': 'edit_telefono',
                'edit_correo': 'edit_correo',
                'edit_estado': 'edit_estado'
            };

            for (const [fieldId, key] of Object.entries(fieldMap)) {
                const input = document.getElementById(fieldId);
                if (input && input.value.trim() !== editFormOriginalData[key]) {
                    return true;
                }
            }
            return false;
        }

        // Guardar datos originales
        function saveEditFormOriginalData() {
            editFormOriginalData = {
                edit_nombres: document.getElementById('edit_nombres')?.value.trim() || '',
                edit_apellidos: document.getElementById('edit_apellidos')?.value.trim() || '',
                edit_telefono: document.getElementById('edit_telefono')?.value.trim() || '',
                edit_correo: document.getElementById('edit_correo')?.value.trim() || '',
                edit_estado: document.getElementById('edit_estado')?.value.trim() || ''
            };
        }

        // Habilitar botón de edición
        function checkFormEdit() {
            const isValid = Object.values(validEdit).every(v => v === true);
            const btn = document.getElementById('btnGuardarEdit');

            btn.disabled = !isValid;
            btn.classList.toggle('opacity-50', !isValid);
            btn.classList.toggle('cursor-not-allowed', !isValid);
        }

        // FUNCIÓN PARA ABRIR MODAL DE EDICIÓN
        function openModalEdit(btn) {
            try {
                if (!btn || !btn.dataset) {
                    console.error('Botón no válido');
                    return;
                }

                const form = document.getElementById('formEdit');
                const editDoc = document.getElementById('edit_documento');
                const editNit = document.getElementById('edit_nit');
                const editNombres = document.getElementById('edit_nombres');
                const editApellidos = document.getElementById('edit_apellidos');
                const editTelefono = document.getElementById('edit_telefono');
                const editCorreo = document.getElementById('edit_correo');
                const editEstado = document.getElementById('edit_estado');
                const editPassword = document.getElementById('edit_password');
                const userModalEdit = document.getElementById('userModalEdit');
                const modalOverlayEdit = document.getElementById('modalOverlayEdit');

                if (!form || !editDoc || !editNombres || !editApellidos || !editTelefono ||
                    !editCorreo || !editEstado || !userModalEdit || !modalOverlayEdit) {
                    console.error('Algunos elementos no existen en el DOM');
                    return;
                }

                // Obtener y sanitizar datos del botón
                const data = {
                    documento: sanitizeString(btn.dataset.documento || ''),
                    nit: sanitizeString(btn.dataset.nit || ''),
                    nombres: sanitizeString(btn.dataset.nombres || ''),
                    apellidos: sanitizeString(btn.dataset.apellidos || ''),
                    telefono: sanitizeString(btn.dataset.telefono || ''),
                    correo: sanitizeString(btn.dataset.correo || ''),
                    estado: sanitizeString(btn.dataset.estado || '')
                };

                // 🔒 Validar seguridad de los datos
                const securityCheck = validateSecurityThreats(data);
                if (!securityCheck.valid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Seguridad',
                        text: `Datos sospechosos detectados en: ${securityCheck.field}`,
                        timer: 3000
                    });
                    return;
                }

                // Establecer la acción del formulario
                form.action = `/sadmin/admins/${data.documento}`;

                // Llenar los campos
                editDoc.value = data.documento;
                editNit.value = data.nit;
                editNombres.value = data.nombres;
                editApellidos.value = data.apellidos;
                editTelefono.value = data.telefono;
                editCorreo.value = data.correo;
                editEstado.value = data.estado;
                if (editPassword) {
                    editPassword.value = '';
                }

                // 🔒 Guardar datos originales para detectar cambios
                saveEditFormOriginalData();

                // Validar campos al abrir
                validEdit.nombres = data.nombres && /^[A-Z][a-zA-Z\s]*$/.test(data.nombres);
                validEdit.apellidos = data.apellidos && /^[A-Z][a-zA-Z\s]*$/.test(data.apellidos);
                validEdit.telefono = data.telefono && data.telefono.toString().length === 10;
                validEdit.correo = data.correo && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.correo);
                validEdit.estado = data.estado && data.estado !== '';

                // 🔒 Limpiar errores visuales
                Object.keys(validEdit).forEach(key => {
                    const errorEl = document.getElementById(`edit-error-${key}`);
                    if (errorEl) errorEl.classList.add('hidden');
                });

                checkFormEdit();
                userModalEdit.classList.remove('hidden');
                modalOverlayEdit.classList.remove('hidden');

                console.log('Modal abierto exitosamente');
            } catch (e) {
                console.error('Error al abrir modal:', e);
                alert('Error: ' + e.message);
            }
        }

        function closeModalEdit() {
            const userModalEdit = document.getElementById('userModalEdit');
            const modalOverlayEdit = document.getElementById('modalOverlayEdit');
            if (userModalEdit) userModalEdit.classList.add('hidden');
            if (modalOverlayEdit) modalOverlayEdit.classList.add('hidden');
        }

        // Exponer funciones globalmente para llamadas inline (onclick)
        try {
            window.openModalEdit = openModalEdit;
            window.closeModalEdit = closeModalEdit;
        } catch (e) {
            console.warn('No se pudo exponer funciones de modal globalmente', e);
        }

        // Asociar listeners a botones de editar (evita depender de onclick inline)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-open-edit').forEach(btn => {
                // evitar doble registro
                if (btn.dataset.listenerAttached) return;
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    try {
                        openModalEdit(this);
                    } catch (err) {
                        console.error('Error al abrir modal edit programático:', err);
                    }
                });
                btn.dataset.listenerAttached = '1';
            });
        });

        // 🔒 Validación al enviar formulario de edición
        document.addEventListener('DOMContentLoaded', function() {
            const formEdit = document.getElementById('formEdit');
            if (formEdit) {
                formEdit.addEventListener('submit', function(e) {
                    // Rate limiting
                    if (!canSubmitForm()) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Espera un momento',
                            text: 'Por favor, espera antes de enviar nuevamente',
                            timer: 1500
                        });
                        return;
                    }

                    // Recopilar datos del formulario
                    const formData = {
                        nombres: document.getElementById('edit_nombres').value,
                        apellidos: document.getElementById('edit_apellidos').value,
                        correo: document.getElementById('edit_correo').value
                    };

                    // Validar seguridad
                    const securityCheck = validateSecurityThreats(formData);
                    if (!securityCheck.valid) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Alerta de Seguridad',
                            text: `Se detectó un intento de ${securityCheck.threat}. Campo: ${securityCheck.field}`,
                            timer: 3000
                        });
                        return;
                    }

                    // Validar que haya cambios
                    if (!hasEditFormChanged()) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin cambios',
                            text: 'No hay cambios que guardar',
                            timer: 2000
                        });
                        return;
                    }

                    // Validar que todos los campos sean válidos
                    if (!Object.values(validEdit).every(v => v === true)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Errores de validación',
                            text: 'Por favor, verifica los campos resaltados',
                            timer: 2000
                        });
                    }
                });

                // 🔒 Prevenir pegado de contenido malicioso en editar
                const editForm = document.getElementById('formEdit');
                if (editForm) {
                    const editInputs = editForm.querySelectorAll('input[type="text"], input[type="email"]');
                    editInputs.forEach(input => {
                        input.addEventListener('paste', (e) => {
                            const pastedText = e.clipboardData.getData('text');

                            if (detectXSSAttempt(pastedText) || detectSQLInjection(pastedText)) {
                                e.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Contenido no permitido',
                                    text: 'El contenido que intentas pegar contiene caracteres no válidos',
                                    timer: 2000
                                });
                                return false;
                            }
                        });
                    });
                }
            }
        });
    </script>

    <!-- Overlay -->
    <div id="modalOverlay" class="fixed inset-0 bg-black/40 hidden z-40"></div>

    <!-- Modal -->
    <div id="userModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    Registrar Nuevo Admin
                </h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('sadmin.store') }}" id="userForm" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Documento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Documento</label>
                        <input name="emple_doc" id="documento" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateDocumento(this)">
                        <p id="error-documento" class="text-sm text-red-500 hidden">
                            Solo números, sin puntos
                        </p>

                    </div>

                    <!-- NIT Empresa -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Empresa (NIT)</label>
                        <select name="nit_empresa" class="mt-1 w-full rounded-lg border-gray-300" required>
                            <option value="">Seleccionar empresa...</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->nit_empresa }}">{{ $empresa->nit_empresa }} -
                                    {{ $empresa->nomb_empresa ?? 'Sin nombre' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nombres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombres</label>
                        <input name="emple_nombres" id="nombres" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateTexto(this, 'error-nombres')">
                        <p id="error-nombres" class="text-sm text-red-500 hidden">
                            Solo letras, primera letra en mayúscula
                        </p>

                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input name="emple_apellidos" id="apellidos" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300"
                            oninput="validateTexto(this, 'error-apellidos')">
                        <p id="error-apellidos" class="text-sm text-red-500 hidden">
                            Solo letras, primera letra en mayúscula
                        </p>

                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input name="emple_tel" id="telefono" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateTelefono(this)">
                        <p id="error-telefono" class="text-sm text-red-500 hidden">
                            Solo números, máximo 10 dígitos
                        </p>

                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input name="emple_correo" id="correo" type="email"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateCorreo(this)">
                        <p id="error-correo" class="text-sm text-red-500 hidden">
                            Correo electrónico inválido
                        </p>

                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input name="password" id="password" type="password"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validatePassword(this)">
                        <p id="error-password" class="text-sm text-red-500 hidden">
                            Mín 8 caracteres, 1 minúscula y 3 números
                        </p>

                    </div>

                    <!-- Foto de perfil -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto de perfil</label>
                        <input name="emple_img" type="file" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <!-- Estado (automático) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select disabled class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100">
                            <option>Activo</option>
                        </select>
                    </div>
                    <input type="hidden" name="emple_estado" value="1">
                    <input type="hidden" name="emple_rol" value="2">


                    <!-- Rol (automático) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select disabled class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100">
                            <option>Administrador Empresa</option>
                        </select>
                    </div>

                </div>

                <!-- Acciones -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button id="btnGuardar" type="submit" disabled
                        class="px-6 py-2 rounded-lg bg-blue-600 text-white opacity-50 cursor-not-allowed">
                        Registrar Usuario
                    </button>

                </div>

            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        /**
         * ===== VALIDACIONES DEL FORMULARIO DE CREAR ADMIN =====
         */
        let valid = {
            documento: false,
            nombres: false,
            apellidos: false,
            telefono: false,
            correo: false,
            password: false
        };

        // Validar Documento - Solo números
        function validateDocumento(input, errorId = 'error-documento') {
            input.value = input.value.replace(/\D/g, '');
            valid.documento = input.value.length > 0;

            // 🔒 Validar contra inyecciones
            if (detectSQLInjection(input.value)) {
                toggleError(errorId, true);
                valid.documento = false;
            } else {
                toggleError(errorId, !valid.documento);
            }
            checkForm();
        }

        // Validar texto - Letras + primera mayúscula
        function validateTexto(input, errorId) {
            input.value = input.value
                .replace(/[^a-zA-Z\s]/g, '')
                .replace(/\b\w/g, l => l.toUpperCase());

            const isValid = /^[A-Z][a-zA-Z\s]*$/.test(input.value);

            // 🔒 Validar contra XSS
            if (detectXSSAttempt(input.value)) {
                toggleError(errorId, true);
                valid[input.id] = false;
            } else {
                valid[input.id] = isValid;
                toggleError(errorId, !isValid);
            }
            checkForm();
        }

        // Validar Teléfono
        function validateTelefono(input) {
            input.value = input.value.replace(/\D/g, '').slice(0, 10);
            valid.telefono = input.value.length === 10;
            toggleError('error-telefono', !valid.telefono);
            checkForm();
        }

        // Validar Correo
        function validateCorreo(input) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            valid.correo = regex.test(input.value);

            // 🔒 Validar contra XSS
            if (detectXSSAttempt(input.value)) {
                toggleError('error-correo', true);
                valid.correo = false;
            } else {
                toggleError('error-correo', !valid.correo);
            }
            checkForm();
        }

        // Validar Contraseña
        function validatePassword(input) {
            const numbers = input.value.replace(/\D/g, '').length;
            const regex = /^(?=.*[a-z]).{8,}$/;

            valid.password = regex.test(input.value) && numbers >= 3;
            toggleError('error-password', !valid.password);
            checkForm();
        }

        // Mostrar / ocultar errores
        function toggleError(id, show) {
            const element = document.getElementById(id);
            if (element) {
                element.classList.toggle('hidden', !show);
            }
        }

        // Habilitar botón
        function checkForm() {
            const isValid = Object.values(valid).every(v => v === true);
            const btn = document.getElementById('btnGuardar');

            btn.disabled = !isValid;
            btn.classList.toggle('opacity-50', !isValid);
            btn.classList.toggle('cursor-not-allowed', !isValid);
        }

        // 🔒 Prevenir pegado de contenido malicioso y asociar envío seguro cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            const formInputs = document.querySelectorAll(
                '#userForm input[type="text"], #userForm input[type="email"]');

            formInputs.forEach(input => {
                input.addEventListener('paste', (e) => {
                    const pastedText = e.clipboardData.getData('text');

                    if (detectXSSAttempt(pastedText) || detectSQLInjection(pastedText)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Contenido no permitido',
                            text: 'El contenido que intentas pegar contiene caracteres no válidos',
                            timer: 2000
                        });
                        return false;
                    }
                });
            });

            // 🔒 Validación al enviar formulario (adjuntar listener ahora que el formulario existe)
            const userForm = document.getElementById('userForm');
            if (userForm) {
                userForm.addEventListener('submit', function(e) {
                    // Rate limiting
                    if (!canSubmitForm()) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Espera un momento',
                            text: 'Por favor, espera antes de enviar nuevamente',
                            timer: 1500
                        });
                        return;
                    }

                    // Recopilar datos
                    const formData = {
                        documento: document.getElementById('documento').value,
                        nombres: document.getElementById('nombres').value,
                        apellidos: document.getElementById('apellidos').value,
                        correo: document.getElementById('correo').value
                    };

                    // Validar seguridad
                    const securityCheck = validateSecurityThreats(formData);
                    if (!securityCheck.valid) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Alerta de Seguridad',
                            text: `Se detectó un intento de ${securityCheck.threat}. Campo: ${securityCheck.field}`,
                            timer: 3000
                        });
                        return;
                    }

                    // Validar que todos los campos sean válidos
                    if (!Object.values(valid).every(v => v === true)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Errores de validación',
                            text: 'Por favor, verifica los campos resaltados',
                            timer: 2000
                        });
                    }
                });
            }
        });

        // Funciones para abrir/cerrar modal de creación
        function openModal() {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById('userModal');
            if (overlay) overlay.classList.remove('hidden');
            if (modal) modal.classList.remove('hidden');
        }

        function closeModal() {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById('userModal');
            if (overlay) overlay.classList.add('hidden');
            if (modal) modal.classList.add('hidden');
        }

        // Exponer openModal/closeModal globalmente
        try {
            window.openModal = openModal;
            window.closeModal = closeModal;
        } catch (e) {
            console.warn('No se pudo exponer funciones openModal/closeModal', e);
        }
    </script>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#16a34a'
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc2626'
            });
        </script>
    @endif

    @if (session()->has('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#d97706'
            });
        </script>
    @endif

    @if (session()->has('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Información',
                text: "{{ session('info') }}",
                confirmButtonColor: '#2563eb'
            });
        </script>
    @endif




    {{--  Formulario de editar usuarios --}}


    <!-- Overlay -->
    <div id="modalOverlayEdit" class="fixed inset-0 bg-black/40 hidden z-40"></div>

    <!-- Modal -->
    <div id="userModalEdit" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    Editar Admin
                </h2>
                <button onclick="closeModalEdit()" class="text-gray-500 hover:text-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>


            <!-- Formulario -->
            <form method="POST" action="" id="formEdit" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Documento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Documento</label>
                        <input name="emple_doc" id="edit_documento" class="mt-1 w-full rounded-lg border-gray-300"
                            oninput="validateDocumento(this, 'edit-error-documento')">
                        <p id="edit-error-documento" class="text-sm text-red-500 hidden">
                            Solo números, sin puntos
                        </p>

                    </div>

                    <!-- NIT Empresa -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Empresa (NIT)</label>
                        <select name="nit_empresa" id="edit_nit" class="mt-1 w-full rounded-lg border-gray-300"
                            required>
                            <option value="">Seleccionar empresa...</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->nit_empresa }}">{{ $empresa->nit_empresa }} -
                                    {{ $empresa->nomb_empresa ?? 'Sin nombre' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nombres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombres</label>
                        <input name="emple_nombres" id="edit_nombres" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300"
                            oninput="validateTextoEdit(this, 'edit-error-nombres')">
                        <p id="edit-error-nombres" class="text-sm text-red-500 hidden">
                            Solo letras, primera letra en mayúscula
                        </p>

                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input name="emple_apellidos" id="edit_apellidos" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300"
                            oninput="validateTextoEdit(this, 'edit-error-apellidos')">
                        <p id="edit-error-apellidos" class="text-sm text-red-500 hidden">
                            Solo letras, primera letra en mayúscula
                        </p>

                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input name="emple_tel" id="edit_telefono" type="text"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateTelefonoEdit(this)">
                        <p id="edit-error-telefono" class="text-sm text-red-500 hidden">
                            Solo números, máximo 10 dígitos
                        </p>

                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input name="emple_correo" id="edit_correo" type="email"
                            class="mt-1 w-full rounded-lg border-gray-300" oninput="validateCorreoEdit(this)">
                        <p id="edit-error-correo" class="text-sm text-red-500 hidden">
                            Correo electrónico inválido
                        </p>

                    </div>

                    <!-- Password (OPCIONAL) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña (Opcional)</label>
                        <input name="password" id="edit_password" type="password"
                            class="mt-1 w-full rounded-lg border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">
                            Déjalo en blanco para mantener la contraseña actual
                        </p>

                    </div>

                    <!-- Foto de perfil -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto de perfil</label>
                        <input name="emple_img" type="file" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="emple_estado" id="edit_estado" class="mt-1 w-full rounded-lg border-gray-300"
                            onchange="validateEstadoEdit(this)">
                            <option value="">Seleccionar estado...</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado }}">
                                    {{ $estado->estado_nomb }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rol (automático) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select disabled class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100">
                            <option>Administrador Empresa</option>
                        </select>
                    </div>

                </div>

                <!-- Acciones -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModalEdit()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button id="btnGuardarEdit" type="submit"
                        class="px-6 py-2 rounded-lg bg-blue-600 text-white opacity-50 cursor-not-allowed">
                        Actualizar Usuario
                    </button>

                </div>

            </form>
        </div>
    </div>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#16a34a'
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc2626'
            });
        </script>
    @endif

    @if (session()->has('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#d97706'
            });
        </script>
    @endif

    @if (session()->has('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Información',
                text: "{{ session('info') }}",
                confirmButtonColor: '#2563eb'
            });
        </script>
    @endif






    {{-- Mostrar perfil --}}
    <!-- Overlay -->
    <div id="modalOverlayProfile" class="fixed inset-0 bg-black/40 hidden z-40"></div>

    <!-- Modal Perfil -->
    <div id="userModalProfile" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-xl p-6 relative">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    Perfil del Usuario
                </h2>
                <button onclick="closeModalProfile()" class="text-gray-500 hover:text-gray-800">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Contenido -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Foto de perfil -->
                <div class="flex flex-col items-center gap-4">
                    <img id="profile_foto" src="/img/default-user.png"
                        class="w-40 h-40 rounded-full object-cover border shadow" alt="Foto de perfil">

                    <span class="text-sm text-gray-500">Foto de perfil</span>
                </div>


                <!-- Datos -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Documento -->
                    <div>
                        <label class="text-sm text-gray-500">Documento</label>
                        <p id="profile_documento" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="text-sm text-gray-500">Estado</label>
                        <p id="profile_estado" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- NIT Empresa -->
                    <div>
                        <label class="text-sm text-gray-500">NIT Empresa</label>
                        <p id="profile_nit" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Nombre Empresa -->
                    <div>
                        <label class="text-sm text-gray-500">Empresa</label>
                        <p id="profile_empresa" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Nombres -->
                    <div>
                        <label class="text-sm text-gray-500">Nombres</label>
                        <p id="profile_nombres" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label class="text-sm text-gray-500">Apellidos</label>
                        <p id="profile_apellidos" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="text-sm text-gray-500">Teléfono</label>
                        <p id="profile_telefono" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="text-sm text-gray-500">Correo</label>
                        <p id="profile_correo" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Rol -->
                    <div>
                        <label class="text-sm text-gray-500">Rol</label>
                        <p id="profile_rol" class="font-medium text-gray-800"></p>
                    </div>

                    <!-- Área -->
                    <div>
                        <label class="text-sm text-gray-500">Área</label>
                        <p id="profile_area" class="font-medium text-gray-800"></p>
                    </div>



                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end pt-6 border-t mt-6">
                <button onclick="closeModalProfile()"
                    class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
    <script>
        function openModalProfile(btn) {
            // 🔒 Sanitizar todos los datos antes de mostrar
            const sanitizedData = {
                documento: sanitizeString(btn.dataset.documento || ''),
                nit: sanitizeString(btn.dataset.nit || ''),
                empresa: sanitizeString(btn.dataset.empresa || ''),
                nombres: sanitizeString(btn.dataset.nombres || ''),
                apellidos: sanitizeString(btn.dataset.apellidos || ''),
                telefono: sanitizeString(btn.dataset.telefono || ''),
                correo: sanitizeString(btn.dataset.correo || ''),
                estado: sanitizeString(btn.dataset.estado || ''),
                rol: sanitizeString(btn.dataset.rol || ''),
                area: sanitizeString(btn.dataset.area || ''),
                foto: sanitizeString(btn.dataset.foto || '')
            };

            // Mostrar datos sanitizados
            document.getElementById('profile_documento').textContent = sanitizedData.documento;
            document.getElementById('profile_nit').textContent = sanitizedData.nit;
            document.getElementById('profile_empresa').textContent = sanitizedData.empresa;
            document.getElementById('profile_nombres').textContent = sanitizedData.nombres;
            document.getElementById('profile_apellidos').textContent = sanitizedData.apellidos;
            document.getElementById('profile_telefono').textContent = sanitizedData.telefono;
            document.getElementById('profile_correo').textContent = sanitizedData.correo;
            document.getElementById('profile_estado').textContent = sanitizedData.estado;
            document.getElementById('profile_rol').textContent = sanitizedData.rol;
            document.getElementById('profile_area').textContent = sanitizedData.area;

            // Foto
            document.getElementById('profile_foto').src =
                sanitizedData.foto && sanitizedData.foto !== '' ?
                sanitizedData.foto :
                '/img/default-user.png';

            // Mostrar modal
            document.getElementById('modalOverlayProfile').classList.remove('hidden');
            document.getElementById('userModalProfile').classList.remove('hidden');
        }

        function closeModalProfile() {
            document.getElementById('modalOverlayProfile').classList.add('hidden');
            document.getElementById('userModalProfile').classList.add('hidden');
        }
    </script>



@endsection
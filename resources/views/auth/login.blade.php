{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión - Sistema de Gestión de Correspondencia</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" crossorigin href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Public Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>

<body class="font-display">
    <div class="flex h-screen w-full items-center justify-center bg-background-light dark:bg-background-dark">
        <div class="flex w-full max-w-6xl rounded-xl bg-white dark:bg-slate-900 shadow-lg overflow-hidden">
            {{-- Lado izquierdo decorativo --}}
            <div class="hidden lg:flex lg:w-1/2 flex-col items-center justify-center bg-primary p-12 text-white">
                <div class="flex flex-col items-center text-center gap-4">
                    <span class="material-symbols-outlined text-6xl text-white/80"> all_inbox </span>
                    <h2 class="text-3xl font-bold">Sistema de Gestión de Correspondencia</h2>
                    <p class="text-lg text-white/80">Centralizando la comunicación para una mayor eficiencia y
                        organización.</p>
                </div>
            </div>



            {{-- Formulario de login --}}
            <div class="w-full lg:w-1/2 p-8 sm:p-12 md:p-16">

                {{-- Botón volver --}}
                <a href="{{ route('web.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline mb-6">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Volver
                </a>

                <h1 class="text-4xl font-black text-[#0d121b] dark:text-gray-100 pb-2">Iniciar Sesión</h1>
                <p class="text-base text-[#4c669a] dark:text-gray-400 mb-6">Ingresa tus credenciales para acceder al
                    sistema.</p>

                @if (session('success'))
                    <div id="success-alert"
                        class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-2 rounded mb-4 shadow-sm text-sm">
                        {{ session('success') }}
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const alert = document.getElementById('success-alert');
                            if (alert) {
                                setTimeout(() => {
                                    alert.style.opacity = 0;
                                    alert.style.transition = "opacity 0.5s ease";
                                    setTimeout(() => alert.remove(), 500); // elimina del DOM después de la transición
                                }, 3000); // desaparece después de 3 segundos
                            }
                        });
                    </script>
                @endif

                <form id="loginForm" method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                    @csrf

                    {{-- Documento --}}
                    <label class="flex flex-col w-full">
                        <p class="text-base font-medium text-[#0d121b] dark:text-gray-200 pb-2">Documento</p>
                        <input id="documento" name="number" type="text" placeholder="Ingresa tu documento"
                            value="{{ old('number') }}" maxlength="10"
                            class="form-input w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-gray-100 p-3 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary" />
                        <p id="docHelp" class="text-sm mt-1 text-red-500 dark:text-red-400"></p>
                        @error('number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const input = document.getElementById('documento');
                            const help = document.getElementById('docHelp');

                            const showError = (msg) => {
                                help.textContent = msg;
                                help.classList.remove('hidden');
                                input.classList.add('border-red-500');
                            };

                            const clearError = () => {
                                help.textContent = '';
                                help.classList.add('hidden');
                                input.classList.remove('border-red-500');
                            };

                            /* 🔒 1. BLOQUEO TOTAL DE TECLADO */
                            input.addEventListener('keydown', (e) => {
                                const allowedKeys = [
                                    'Backspace', 'Delete', 'Tab',
                                    'ArrowLeft', 'ArrowRight',
                                    'Home', 'End'
                                ];

                                if (allowedKeys.includes(e.key)) return;

                                // Solo dígitos reales 0–9
                                if (!/^[0-9]$/.test(e.key)) {
                                    e.preventDefault();
                                }
                            });

                            /* 🔒 2. BLOQUEO DE PEGADO */
                            input.addEventListener('paste', (e) => {
                                e.preventDefault();
                            });

                            /* 🔒 3. SANITIZACIÓN EXTRA (por seguridad) */
                            input.addEventListener('input', () => {
                                input.value = input.value.replace(/[^0-9]/g, '');

                                const value = input.value;

                                // Máximo 10
                                if (value.length > 10) {
                                    showError('Máximo 10 caracteres.');
                                    return;
                                }

                                // Mínimo 6
                                if (value.length > 0 && value.length < 6) {
                                    showError('Debe tener mínimo 6 caracteres.');
                                    return;
                                }

                                // Repetidos (111111, 000000)
                                if (value.length >= 6 && /^(\d)\1+$/.test(value)) {
                                    showError('No se permiten caracteres repetidos.');
                                    return;
                                }

                                // ✅ Todo correcto → NO mostramos nada
                                clearError();
                            });

                            /* ❗ Al salir, NO borrar nada */
                            input.addEventListener('blur', () => {
                                if (input.value.length === 0) {
                                    showError('El documento es obligatorio.');
                                }
                            });
                        });
                    </script>

                    {{-- Contraseña --}}
                    <label class="flex flex-col w-full">
                        <p class="text-base font-medium text-[#0d121b] dark:text-gray-200 pb-2">Contraseña</p>
                        <input id="password" name="password" type="password" placeholder="Ingresa tu contraseña"
                            class="form-input w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-gray-100 p-3 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary" />
                        <!-- Mensaje de error -->
                        <p id="passHelp" class="text-sm mt-1 text-red-500 hidden"></p>

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const input = document.getElementById('password');
                            const help = document.getElementById('passHelp');

                            const showError = (msg) => {
                                help.textContent = msg;
                                help.classList.remove('hidden');
                                input.classList.add('border-red-500');
                            };

                            const clearError = () => {
                                help.textContent = '';
                                help.classList.add('hidden');
                                input.classList.remove('border-red-500');
                            };

                            const hasInjectionPattern = (value) => {
                                return /(<script>|<\/script>|--|;|\b(select|insert|update|delete|drop|truncate|union)\b)/i.test(
                                    value);
                            };

                            input.addEventListener('input', () => {
                                const value = input.value;

                                // Máximo 64
                                if (value.length > 64) {
                                    showError('Máximo 64 caracteres.');
                                    return;
                                }

                                // Mínimo 8
                                if (value.length > 0 && value.length < 8) {
                                    showError('Debe tener mínimo 8 caracteres.');
                                    return;
                                }

                                // Inyección básica
                                if (hasInjectionPattern(value)) {
                                    showError('Formato de contraseña no permitido.');
                                    return;
                                }

                                // ✅ Todo correcto → ocultar errores
                                clearError();
                            });

                            input.addEventListener('blur', () => {
                                if (input.value.length === 0) {
                                    showError('La contraseña es obligatoria.');
                                }
                            });
                        });
                    </script>

                    {{-- Errores de login --}}
                    @if ($errors->has('login'))
                        <p class="text-red-500 text-sm">{{ $errors->first('login') }}</p>
                    @endif

                

                    {{-- Botón --}}
                    <button id="submitBtn" type="submit"
                        class="w-full rounded-lg bg-primary text-white font-bold py-3 hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/30 transition-colors">
                        Iniciar Sesión
                    </button>

                    {{-- Olvidó contraseña --}}
                    <a href="{{ route('empleado.password.forgot') }}"
                        class="text-sm text-primary hover:underline text-right mt-2">
                        ¿Olvidaste tu contraseña?
                    </a>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const form = document.getElementById('loginForm');
                        const submitBtn = document.getElementById('submitBtn');

                        const documento = document.getElementById('documento');
                        const docHelp = document.getElementById('docHelp');

                        const password = document.getElementById('password');
                        const passHelp = document.getElementById('passHelp');

                        const hasRepeatedNumbers = (value) => /^(\d)\1+$/.test(value);
                        const hasInjection = (value) =>
                            /(<script>|<\/script>|--|;|\b(select|insert|update|delete|drop|truncate|union)\b)/i.test(value);

                        form.addEventListener('submit', (e) => {
                            let hasError = false;

                            /* ================= DOCUMENTO ================= */
                            const docValue = documento.value;

                            if (!docValue) {
                                docHelp.textContent = 'El documento es obligatorio.';
                                docHelp.classList.remove('hidden');
                                documento.classList.add('border-red-500');
                                hasError = true;
                            } else if (docValue.length < 6 || docValue.length > 10) {
                                docHelp.textContent = 'Debe tener entre 6 y 10 caracteres.';
                                hasError = true;
                            } else if (hasRepeatedNumbers(docValue)) {
                                docHelp.textContent = 'No se permiten caracteres repetidos.';
                                hasError = true;
                            }

                            /* ================= PASSWORD ================= */
                            const passValue = password.value;

                            if (!passValue) {
                                passHelp.textContent = 'La contraseña es obligatoria.';
                                passHelp.classList.remove('hidden');
                                password.classList.add('border-red-500');
                                hasError = true;
                            } else if (passValue.length < 8 || passValue.length > 64) {
                                passHelp.textContent = 'Debe tener entre 8 y 64 caracteres.';
                                hasError = true;
                            } else if (hasInjection(passValue)) {
                                passHelp.textContent = 'Formato de contraseña no permitido.';
                                hasError = true;
                            }

                            /* ================= BLOQUEO FINAL ================= */
                            if (hasError) {
                                e.preventDefault(); // 🚫 NO SE ENVÍA
                                submitBtn.disabled = true;

                                // Rehabilitar botón si el usuario corrige
                                setTimeout(() => {
                                    submitBtn.disabled = false;
                                }, 800);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>


</body>

</html>

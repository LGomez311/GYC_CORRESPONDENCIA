{{-- resources/views/auth/2fa.blade.php --}}
<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verificación de Dos Pasos - Sistema de Gestión de Correspondencia</title>
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
                        "primary": "#00b5a3",
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
        .code-input:focus {
            letter-spacing: 0.5rem;
        }
    </style>
</head>

<body class="font-display">
    <div class="flex h-screen w-full items-center justify-center bg-background-light dark:bg-background-dark">
        <div class="flex w-full max-w-6xl rounded-xl bg-white dark:bg-slate-900 shadow-lg overflow-hidden">
            {{-- Lado izquierdo decorativo --}}
            <div class="hidden lg:flex lg:w-1/2 flex-col items-center justify-center bg-primary p-12 text-white">
                <div class="flex flex-col items-center text-center gap-4">
                    <span class="material-symbols-outlined text-6xl text-white/80"> shield_lock </span>
                    <h2 class="text-3xl font-bold">Seguridad de la Cuenta</h2>
                    <p class="text-lg text-white/80">Hemos enviado un código de seguridad a tu correo electrónico para verificar tu identidad.</p>
                </div>
            </div>

            {{-- Formulario de 2FA --}}
            <div class="w-full lg:w-1/2 p-8 sm:p-12 md:p-16">

                {{-- Botón volver --}}
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline mb-6">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Volver al login
                </a>

                <h1 class="text-4xl font-black text-[#0d121b] dark:text-gray-100 pb-2">Verificación</h1>
                <p class="text-base text-[#4c669a] dark:text-gray-400 mb-6 font-medium">Ingresa el código de 6 dígitos enviado a tu correo.</p>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6 shadow-sm text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('2fa.verify') }}" class="flex flex-col gap-6">
                    @csrf

                    {{-- Código --}}
                    <div class="flex flex-col w-full">
                        <label for="code" class="text-base font-bold text-[#0d121b] dark:text-gray-200 pb-3">Código de Seguridad</label>
                        <div class="relative">
                            <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" maxlength="6"
                                placeholder="000000" autofocus
                                class="code-input w-full rounded-xl border-2 border-[#cfd7e7] dark:border-slate-700 bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-gray-100 p-4 text-center text-3xl font-black tracking-[1rem] focus:outline-none focus:ring-4 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-300 dark:placeholder:text-gray-600" />
                        </div>
                        <p class="text-xs text-gray-500 mt-3 text-center italic">Si no has recibido el código, revisa tu carpeta de spam.</p>
                    </div>

                    {{-- Botón --}}
                    <button type="submit"
                        class="w-full rounded-xl bg-primary text-white font-black py-4 text-lg hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/30 transition-all transform hover:scale-[1.01] active:scale-95 shadow-lg shadow-primary/20">
                        Verificar y Acceder
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-100 dark:border-slate-800 text-center">
                    <p class="text-sm text-gray-400">¿Tienes problemas? Contacta a soporte técnico.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Formateo visual del input de código
        const codeInput = document.getElementById('code');
        
        codeInput.addEventListener('input', (e) => {
            // Solo permitir números
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });

        // Soporte para pegar el código
        codeInput.addEventListener('paste', (e) => {
            const pasteData = e.clipboardData.getData('text');
            if (!/^[0-9]{6}$/.test(pasteData)) {
                // Si no es un código de 6 dígitos, limpiar
                e.preventDefault();
            }
        });
    </script>
</body>

</html>

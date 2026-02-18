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

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                    @csrf

                    {{-- Documento --}}
                    <label class="flex flex-col w-full">
                        <p class="text-base font-medium text-[#0d121b] dark:text-gray-200 pb-2">Documento</p>
                        <input name="number" type="text" placeholder="Ingresa tu documento"
                            value="{{ old('number') }}"
                            class="form-input w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-gray-100 p-3 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary" />
                        @error('number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Contraseña --}}
                    <label class="flex flex-col w-full">
                        <p class="text-base font-medium text-[#0d121b] dark:text-gray-200 pb-2">Contraseña</p>
                        <input name="password" type="password" placeholder="Ingresa tu contraseña"
                            class="form-input w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-gray-100 p-3 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary" />
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Recordarme --}}
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="remember"
                            class="form-checkbox h-5 w-5 rounded border-[#cfd7e7] dark:border-slate-600 text-primary focus:ring-2 focus:ring-primary/50" />
                        <span class="text-base text-[#0d121b] dark:text-gray-200">Recordarme</span>
                    </label>

                    {{-- Errores de login --}}
                    @if ($errors->has('login'))
                        <p class="text-red-500 text-sm">{{ $errors->first('login') }}</p>
                    @endif

                    {{-- Botón --}}
                    <button type="submit"
                        class="w-full rounded-lg bg-primary text-white font-bold py-3 hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/30 transition-colors">
                        Iniciar Sesión
                    </button>

                    {{-- Olvidó contraseña --}}
                    <a href="{{ route('empleado.password.forgot') }}"
                        class="text-sm text-primary hover:underline text-right mt-2">
                        ¿Olvidaste tu contraseña?
                    </a>
            </div>
        </div>
    </div>
</body>

</html>

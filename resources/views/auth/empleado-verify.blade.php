<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verificar Código</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        display: ["Public Sans", "sans-serif"]
                    },
                },
            },
        }
    </script>
</head>

<body class="font-display">

    <div class="flex h-screen w-full items-center justify-center bg-background-light dark:bg-background-dark">

        <div class="flex w-full max-w-6xl rounded-xl bg-white dark:bg-slate-900 shadow-lg overflow-hidden">

            {{-- Panel decorativo --}}
            <div class="hidden lg:flex lg:w-1/2 flex-col items-center justify-center bg-primary p-12 text-white">
                <span class="material-symbols-outlined text-6xl text-white/80">verified_user</span>
                <h2 class="text-3xl font-bold mt-4">Verificar Código</h2>
                <p class="text-lg text-white/80 mt-2 text-center">
                    Ingresa el código enviado y establece tu nueva contraseña.
                </p>
            </div>

            {{-- Formulario --}}
            <div class="w-full lg:w-1/2 p-8 sm:p-12 md:p-16">

                {{-- Botón volver --}}
                <a href="{{ route('empleado.password.forgot') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline mb-6">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Volver
                </a>

                <h1 class="text-4xl font-black text-[#0d121b] dark:text-gray-100 pb-2">
                    Restablecer Contraseña
                </h1>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('empleado.password.reset') }}" class="flex flex-col gap-4">
                    @csrf

                    <input type="email" name="email" placeholder="Correo"
                        class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 
                    bg-background-light dark:bg-background-dark p-3"
                        required>

                    <input type="text" name="code" placeholder="Código de verificación"
                        class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 
                    bg-background-light dark:bg-background-dark p-3"
                        required>

                    <input type="password" name="password" placeholder="Nueva contraseña"
                        class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 
                    bg-background-light dark:bg-background-dark p-3"
                        required>

                    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña"
                        class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 
                    bg-background-light dark:bg-background-dark p-3"
                        required>

                    <button type="submit"
                        class="w-full rounded-lg bg-primary text-white font-bold py-3 
                    hover:bg-primary/90 focus:ring-4 focus:ring-primary/30 transition">
                        Actualizar Contraseña
                    </button>

                    <a href="{{ route('empleado.password.forgot') }}"
                        class="text-sm text-primary hover:underline text-right">
                        Solicitar nuevo código
                    </a>

                </form>
            </div>
        </div>
    </div>
</body>

</html>

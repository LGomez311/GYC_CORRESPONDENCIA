<!DOCTYPE html>

<html class="light" lang="es">


<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Consulta de Correspondencia (Solo Lectura) - Sistema de Mensajería</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#2563eb",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.75rem",
                    },
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        body {
            font-family: 'Inter', sans-serif;
        }

        .active-nav {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .dark .active-nav {
            background-color: #1e293b;
            color: #60a5fa;
        }

        .sidebar-item-active {
            @apply bg-blue-50 text-primary dark:bg-slate-800 dark:text-blue-400;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex">
    <aside
        class="w-64 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col h-screen sticky top-0">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                <span class="material-icons-round">mail</span>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">Sistema de<br />Mensajería</h1>
            </div>
        </div>
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="px-3 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 mt-6">
                Gestión Central</p>

            <a href="{{ route('resumen') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-icons-round text-[20px]">dashboard</span>
                Resumen
            </a>

            <a href="{{ route('correspondencia') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg active-nav font-medium transition-colors">
                <span class="material-symbols-outlined">inbox</span>
                Correspondencia
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                href="#">
                <span class="material-icons-round text-[20px]">bar_chart</span>
                Reportes
            </a>
            <p class="px-3 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 mt-8">
                Sistema</p>

            <a href="{{ route('usuarios') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-icons-round text-[20px]">people</span>
                Ususarios
            </a>

            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                href="#">
                <span class="material-icons-round text-[20px]">settings</span>
                Configuración
            </a>
        </nav>
        
        <div class="mt-auto p-6 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                    <img class="w-full h-full object-cover" data-alt="Avatar de perfil de usuario administrador"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDeOwG6ve_Mksrm4Ma_20obFe7IX0H7gK7EgSTEuguFi38JMMXi7xWA0zh7rWaUjBVeCUQhWoKl9rrSxB-9usSvJoaJRPFdGFzLYd3HL1mkeeluCWsYDO-2xQwyPYSPaVSCL3VXfCkPPfMcS-IUZ5AOCjlyj2DOfv8BKyx_bNcTCVc4rnrG_DhjdhbA9NoKwG2xxyQsK53tD6U_en-paoCHMpK8TtslKuPYLsKugXgYFufOuReZuBf0tnmXdB4euWGOHx4xsHZ-Oh8E" />
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-semibold">Cerrar Sesión</span>
                </div>
                <span class="material-symbols-outlined text-slate-400 ml-auto cursor-pointer">logout</span>
            </div>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 ml-64">
        <!-- Header -->
        <header
            class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-8 sticky top-0 z-10">
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <div class="relative w-full">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-background-light dark:bg-slate-800 border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/50 transition-all"
                        placeholder="Buscar usuarios, áreas o correos..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                    <span class="material-symbols-outlined">notifications</span>
                    <span
                        class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                </button>
                <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                    <span class="material-symbols-outlined">help</span>
                </button>
                <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-700 mx-2"></div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium">Admin User</span>
                    <div
                        class="w-9 h-9 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                        AU
                    </div>
                </div>
            </div>
        </header>
        <div class="p-1">
            <!-- Page Title and Action -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">Gestión de
                        Usuarios</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Administra los accesos y perfiles de
                        los empleados de la organización.</p>
                </div>
                <button
                    class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold text-sm shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Crear Nuevo Usuario
                </button>
            </div>
            <!-- Stats Overview (Optional but adds to the modern look) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div
                    class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total
                            Usuarios</span>
                        <span class="material-symbols-outlined text-primary">groups</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold">1,248</div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Activos</span>
                        <span class="material-symbols-outlined text-green-500">check_circle</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold">1,120</div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Inactivos</span>
                        <span class="material-symbols-outlined text-slate-400">do_not_disturb_on</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold">128</div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Nuevos
                            (Mes)</span>
                        <span class="material-symbols-outlined text-orange-400">person_add</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold">42</div>
                </div>
            </div>
            <!-- Users Table -->
            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Nombre Completo</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Correo Electrónico</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Rol</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Área</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Estado</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <!-- Row 1 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center font-bold text-xs text-slate-500">
                                            JP</div>
                                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">Juan
                                            Pérez</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    juan.perez@empresa.com</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">Administrador</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">IT</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        <span
                                            class="text-sm font-medium text-slate-700 dark:text-slate-300">Activo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-colors"
                                            title="Ver Detalles">
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center font-bold text-xs text-slate-500">
                                            MG</div>
                                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">María
                                            García</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    maria.garcia@empresa.com</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">Editor</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Marketing</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        <span
                                            class="text-sm font-medium text-slate-700 dark:text-slate-300">Activo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-colors"
                                            title="Ver Detalles">
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center font-bold text-xs text-slate-500">
                                            CR</div>
                                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">Carlos
                                            Ruiz</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    carlos.ruiz@empresa.com</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">Lector</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Ventas</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                        <span
                                            class="text-sm font-medium text-slate-500 dark:text-slate-500">Inactivo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-colors"
                                            title="Ver Detalles">
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 4 -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center font-bold text-xs text-slate-500">
                                            AL</div>
                                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">Ana
                                            López</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    ana.lopez@empresa.com</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">Editor</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">RRHH</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        <span
                                            class="text-sm font-medium text-slate-700 dark:text-slate-300">Activo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-colors"
                                            title="Ver Detalles">
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Mostrando 1-4 de 1,248
                        usuarios</span>
                    <div class="flex gap-1">
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 disabled:opacity-50 transition-all"
                            disabled="">
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-xs shadow-sm">1</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 font-medium text-xs">2</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 font-medium text-xs">3</button>
                        <span class="flex items-center px-1 text-slate-400">...</span>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 font-medium text-xs">312</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700 transition-all">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
</body>

</html>

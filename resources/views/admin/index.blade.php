<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dashboard de Administración (Solo Lectura)</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .active-nav {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .dark .active-nav {
            background-color: #1e293b;
            color: #60a5fa;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex">
    <aside
        class="w-64 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hidden lg:flex flex-col">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                <span class="material-symbols-outlined">corporate_fare</span>
            </div>
            <span class="font-bold text-lg leading-tight">Gestión de<br /><span
                    class="text-primary">Correspondencia</span></span>
        </div>
        <nav class="flex-1 px-4 py-4 space-y-1">
            <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 mb-2">
                Gestión Central</div>
            <a href="{{ route('resumen') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-icons-round text-[20px]">dashboard</span>
                Resumen
            </a>
            <a href="{{ route('correspondencia') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined">inbox</span>
                Correspondencia
            </a>
            <div
                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 mt-8 mb-2">
                Sistema</div>
            
            <a href="{{ route('usuarios') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-icons-round text-[20px]">people</span>
                Ususarios
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                href="#">
                <span class="material-symbols-outlined">settings</span>
                Configuración
            </a>
        </nav>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3 p-2">
                <img alt="Avatar de administrador"
                    class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBdb-6p41zc5tII4gshe4LPrAsrIT0NougDMW4Xzry8rwSkv1R_dL10S4CYtefS4vFhaRVyW9ZbSWtxxLfcPJBifvL_qdFGWnRMYqdSNw-uTL2zNtvPmC8cMXQ11PT-bbxrbMK59GdJAn6QL6GlbaJfyuQbPKtS9zWGyTZHPVX-M5qPEfdK8H0Zhe-MPxCNgg8TZzSK8kpO_IsoEdodHwPQoIebmEHoU-Kh8c5T56lJWTtSZGW1hQ1t7hHyE0NBXotIRc5_bE7FiT2A" />
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold truncate">Kevin Villafrade</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Administrador</p>
                </div>
            </div>
        </div>
    </aside>
    <main class="flex-1 flex flex-col min-w-0">
        <header
            class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-8 sticky top-0 z-10">
            <div class="flex items-center bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg w-full max-w-md">
                <span class="material-symbols-outlined text-slate-400 text-lg">search</span>
                <input
                    class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-slate-400 dark:text-slate-200"
                    placeholder="Buscar correspondencia, radicado..." type="text" />
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg"
                    onclick="document.documentElement.classList.toggle('dark')">
                    <span class="material-symbols-outlined">dark_mode</span>
                </button>
                <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span
                        class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                </button>
                <button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                    <span class="material-symbols-outlined">help</span>
                </button>
            </div>
        </header>
        <div class="p-8 space-y-8 overflow-y-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">Panel de Gestión de Correspondencia</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Vista de solo lectura del ciclo de vida de los
                        servicios de correspondencia.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Correspondencia Recibida
                            </p>
                            <h3 class="text-3xl font-bold mt-2">1,240</h3>
                            <div
                                class="flex items-center gap-1 mt-2 text-emerald-600 dark:text-emerald-400 text-sm font-medium">
                                <span class="material-symbols-outlined text-lg leading-none">trending_up</span>
                                +5.4%
                            </div>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/30 p-2.5 rounded-xl">
                            <span class="material-symbols-outlined text-primary">mail</span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Envíos Pendientes</p>
                            <h3 class="text-3xl font-bold mt-2">45</h3>
                            <div
                                class="flex items-center gap-1 mt-2 text-amber-600 dark:text-amber-400 text-sm font-medium">
                                <span class="material-symbols-outlined text-lg leading-none">schedule</span>
                                Por vencer
                            </div>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/30 p-2.5 rounded-xl">
                            <span class="material-symbols-outlined text-amber-500">local_shipping</span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Alertas Críticas</p>
                            <h3 class="text-3xl font-bold mt-2">12</h3>
                            <div
                                class="flex items-center gap-1 mt-2 text-rose-600 dark:text-rose-400 text-sm font-medium">
                                <span class="material-symbols-outlined text-lg leading-none">warning</span>
                                Revisión req.
                            </div>
                        </div>
                        <div class="bg-rose-50 dark:bg-rose-900/30 p-2.5 rounded-xl">
                            <span class="material-symbols-outlined text-rose-500">warning</span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-2xl border-2 border-primary/10 dark:border-primary/20 shadow-md relative overflow-hidden group">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-sm font-bold text-primary uppercase tracking-tight">Gestión de Usuarios</p>
                            <h3 class="text-3xl font-bold mt-2">84</h3>
                            <div
                                class="flex items-center gap-1 mt-2 text-emerald-600 dark:text-emerald-400 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block mr-1"></span>
                                Usuarios activos
                            </div>
                            <a class="mt-4 flex items-center gap-2 text-sm font-semibold text-primary hover:underline transition-all"
                                href="#">
                                Ver listado completo
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                        <div class="bg-primary text-white p-2.5 rounded-xl shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined">group</span>
                        </div>
                    </div>
                    <div
                        class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.06] transition-opacity">
                        <span class="material-symbols-outlined text-9xl">group</span>
                    </div>
                </div>
            </div>
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div
                    class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-lg font-bold">Listado Detallado de Correspondencia</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Información actualizada en tiempo real
                            (Solo Lectura)</p>
                    </div>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button
                            class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <span class="material-symbols-outlined text-lg">filter_list</span>
                            Filtrar
                        </button>
                        <button
                            class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <span class="material-symbols-outlined text-lg">download</span>
                            Exportar
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50">
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Radicado / ID</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Asunto</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Remitente / Destinatario</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Estado</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center w-32">
                                    Vista</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900 dark:text-slate-100">RAD-2024-001</span>
                                        <span class="text-xs text-slate-400 font-mono uppercase">ID: 55432-A</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-800 dark:text-slate-200">Facturación
                                            Mensual</span>
                                        <span class="text-xs text-slate-400">12 Dic, 2024</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-800 dark:text-slate-200">Tech Solutions
                                            S.A.</span>
                                        <span class="text-xs text-slate-400">Caja de Compensación</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                        Recibido
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button
                                        class="p-2 text-slate-400 hover:text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-full transition-all"
                                        title="Ver detalles">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900 dark:text-slate-100">RAD-2024-152</span>
                                        <span class="text-xs text-slate-400 font-mono uppercase">ID: 88721-B</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-800 dark:text-slate-200">Contrato
                                            Logístico</span>
                                        <span class="text-xs text-slate-400">15 Oct, 2024</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-800 dark:text-slate-200">Logística
                                            Global</span>
                                        <span class="text-xs text-slate-400">Dpto. Operaciones</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                        En Proceso
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button
                                        class="p-2 text-slate-400 hover:text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-full transition-all"
                                        title="Ver detalles">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900 dark:text-slate-100">RAD-2023-989</span>
                                        <span class="text-xs text-slate-400 font-mono uppercase">ID: 11200-F</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-800 dark:text-slate-200">Notificación
                                            Judicial</span>
                                        <span class="text-xs text-slate-400">02 Sep, 2024</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-800 dark:text-slate-200">Poder
                                            Ejecutivo</span>
                                        <span class="text-xs text-slate-400">Oficina Principal</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                        Entregado
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-cFenter">
                                    <button
                                        class="p-2 text-slate-400 hover:text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-full transition-all"
                                        title="Ver detalles">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="p-4 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center text-sm">
                    <p class="text-slate-500 dark:text-slate-400">Mostrando 3 de 1,240 registros</p>
                    <div class="flex gap-2">
                        <button
                            class="px-3 py-1 border border-slate-200 dark:border-slate-700 rounded-md hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-50 transition-colors"
                            disabled="">Anterior</button>
                        <button
                            class="px-3 py-1 border border-slate-200 dark:border-slate-700 rounded-md hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>

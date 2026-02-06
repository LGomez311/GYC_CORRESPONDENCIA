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
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-3 p-2">
                <img alt="Admin Avatar" class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-700"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCDg5Lu_uvMkhWOpvZGeQgiJMpTcUvQidTTazvpsen_46IEfqHqMLatmLUCgfhKwC1YlYr6V88MtLqA9Zdn0_Lp2cLlW22UkNYtO_c6pmhY2_rGfAstQ8SO3UyMyc569EbapRwg77Imfzbqupdz5Kw5islEsA4QJsu9Jv6-ibRKdshU-Nl6AKdcbRx5wkjVnzvWbFyBWHPKZLdc7waZwayxEXuE8zU8LNxTzFye98QXoXzLTOBGnp8WKyqgy8407m_RaqKeVWL4lMWy" />
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold truncate">Administrador Empresa</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Solo Lectura</p>
                </div>
            </div>
        </div>
    </aside>
    <main class="flex-1 overflow-x-hidden">
        <header
            class="h-16 border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-10 px-8 flex items-center justify-between">
            <div class="flex-1 max-w-xl">
                <div class="relative">
                    <span
                        class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-full text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-500"
                        placeholder="Buscar radicado, institución o asunto..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div
                    class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 rounded-full">
                    <span class="material-symbols-outlined text-amber-600 dark:text-amber-500 text-sm">visibility</span>
                    <span
                        class="text-[11px] font-semibold text-amber-700 dark:text-amber-400 uppercase tracking-tight">Modo
                        de visualización: No tiene permisos de edición</span>
                </div>
                <button
                    class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full text-slate-500 dark:text-slate-400"
                    onclick="document.documentElement.classList.toggle('dark')">
                    <span class="material-icons-round">dark_mode</span>
                </button>
                <button
                    class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full text-slate-500 dark:text-slate-400 relative">
                    <span class="material-icons-round">notifications</span>
                    <span
                        class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                </button>
                <div class="h-8 w-px bg-slate-200 dark:bg-slate-800 mx-2"></div>
                <button
                    class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full text-slate-500 dark:text-slate-400">
                    <span class="material-icons-round">help_outline</span>
                </button>
            </div>
        </header>
        <div class="p-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight mb-1">Consulta de Correspondencia</h2>
                    <p class="text-slate-500 dark:text-slate-400">Vista detallada del historial de documentos recibidos
                        y enviados.</p>
                </div>
                <div class="flex gap-3">
                    <button
                        class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-icons-round text-[18px]">download</span>
                        Exportar
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Recibidos Hoy</p>
                        <span class="p-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                            <span class="material-icons-round">inbox</span>
                        </span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-bold">24</h3>
                        <span class="text-xs font-bold text-emerald-500 flex items-center">
                            <span class="material-icons-round text-[14px]">trending_up</span>
                            12%
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Documentos procesados este turno</p>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Pendientes de Trámite</p>
                        <span
                            class="p-2 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl">
                            <span class="material-icons-round">pending_actions</span>
                        </span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-bold">08</h3>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Documentos en proceso de revisión</p>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Enviados (Mes)</p>
                        <span
                            class="p-2 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                            <span class="material-icons-round">outbox</span>
                        </span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-bold">342</h3>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Total de envíos registrados este mes</p>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 mb-6">
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label
                            class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Rango
                            de Fechas</label>
                        <div class="relative">
                            <span
                                class="material-icons-round absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">calendar_today</span>
                            <input
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-primary focus:border-primary"
                                type="text" value="01 Dic, 2024 - 15 Dic, 2024" />
                        </div>
                    </div>
                    <div class="w-48">
                        <label
                            class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tipo</label>
                        <select
                            class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-primary focus:border-primary">
                            <option>Todos los tipos</option>
                            <option>Recibido Externo</option>
                            <option>Enviado Externo</option>
                            <option>Interno</option>
                        </select>
                    </div>
                    <div class="w-48">
                        <label
                            class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Estado</label>
                        <select
                            class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-primary focus:border-primary">
                            <option>Cualquier estado</option>
                            <option>Radicado</option>
                            <option>En Trámite</option>
                            <option>Finalizado</option>
                        </select>
                    </div>
                    <button
                        class="bg-slate-900 dark:bg-white dark:text-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 transition-colors flex items-center gap-2">
                        <span class="material-icons-round text-[18px]">filter_alt</span>
                        Filtrar
                    </button>
                    <button
                        class="px-4 py-2.5 text-slate-500 dark:text-slate-400 hover:text-primary transition-colors text-sm font-semibold">
                        Limpiar
                    </button>
                </div>
            </div>
            <div
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr
                                class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    No. Radicado / ID</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Institución / Origen</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Asunto</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Fecha / Hora</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">
                                    Estado</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900 dark:text-white">EXT-2024-00124</span>
                                        <span class="text-xs text-slate-500 font-mono">ID: 88412</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500">
                                            <span class="material-icons-round text-sm">business</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium">Ministerio de Transporte</span>
                                            <span class="text-xs text-slate-500">Bogotá D.C.</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-600 dark:text-slate-300 max-w-xs truncate">Solicitud
                                        de prórroga licitación corredor vial norte etapa 2...</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm">12 Dic, 2024</span>
                                        <span class="text-xs text-slate-500">09:45 AM</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                        Radicado
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                            title="Ver detalle">
                                            <span class="material-icons-round text-[20px]">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                            title="Descargar Adjunto">
                                            <span class="material-icons-round text-[20px]">attachment</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900 dark:text-white">INT-2024-00085</span>
                                        <span class="text-xs text-slate-500 font-mono">ID: 88415</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500">
                                            <span class="material-icons-round text-sm">person</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium">Gerencia General</span>
                                            <span class="text-xs text-slate-500">Interno</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-600 dark:text-slate-300 max-w-xs truncate">Circular
                                        informativa 015: Nuevas políticas de seguridad</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm">11 Dic, 2024</span>
                                        <span class="text-xs text-slate-500">03:20 PM</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                        En Trámite
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                            title="Ver detalle">
                                            <span class="material-icons-round text-[20px]">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                            title="Descargar Adjunto">
                                            <span class="material-icons-round text-[20px]">attachment</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900 dark:text-white">SAL-2024-01042</span>
                                        <span class="text-xs text-slate-500 font-mono">ID: 88421</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500">
                                            <span class="material-icons-round text-sm">local_shipping</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium">Logística Global S.A.</span>
                                            <span class="text-xs text-slate-500">Medellín</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-600 dark:text-slate-300 max-w-xs truncate">Envío de
                                        facturación correspondiente a Noviembre 2024</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm">10 Dic, 2024</span>
                                        <span class="text-xs text-slate-500">11:15 AM</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                        Finalizado
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                            title="Ver detalle">
                                            <span class="material-icons-round text-[20px]">visibility</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                            title="Descargar Adjunto">
                                            <span class="material-icons-round text-[20px]">attachment</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Mostrando <span
                            class="font-medium text-slate-900 dark:text-white">1</span> a <span
                            class="font-medium text-slate-900 dark:text-white">3</span> de <span
                            class="font-medium text-slate-900 dark:text-white">124</span> resultados</p>
                    <div class="flex gap-2">
                        <button
                            class="px-4 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 transition-colors disabled:opacity-50"
                            disabled="">Anterior</button>
                        <button
                            class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-700 transition-colors">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>

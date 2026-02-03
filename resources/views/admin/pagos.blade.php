<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Planes y Pago de Licencia - GestionCorr</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;900&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
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
                        "display": ["Public Sans"]
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
            font-size: 20px;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#0d121b] dark:text-[#f8f9fc] min-h-screen">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <!-- TopNavBar -->
            <header
                class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e7ebf3] dark:border-b-[#2c3444] px-10 py-3 bg-white dark:bg-[#1a2130] sticky top-0 z-50">
                <div class="flex items-center gap-4">
                    <div class="size-6 text-primary">
                        <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z"
                                fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-[#0d121b] dark:text-[#f8f9fc] text-lg font-bold leading-tight tracking-[-0.015em]">
                        GestionCorr</h2>
                </div>
                <div class="flex flex-1 justify-end gap-8">
                    <div class="flex items-center gap-9">
                        <a class="text-[#0d121b] dark:text-[#f8f9fc] text-sm font-medium leading-normal hover:text-primary transition-colors"
                            href="#">Dashboard</a>
                        <a class="text-[#0d121b] dark:text-[#f8f9fc] text-sm font-medium leading-normal hover:text-primary transition-colors"
                            href="#">Correspondencia</a>
                        <a class="text-[#0d121b] dark:text-[#f8f9fc] text-sm font-medium leading-normal hover:text-primary transition-colors"
                            href="#">Configuración</a>
                    </div>
                    <button
                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
                        <span class="truncate">Cerrar Sesión</span>
                    </button>
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border border-gray-200"
                        data-alt="User avatar profile picture"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDeNk-IJVsr-_HPCzEb_eQ5Iv3WXxO7EbfYBn95-qRQaFE0q0RWbLivCDKwOWANgh9QkNH7iJTl_eA0zK1X6IjqyNjjRkjx8LnyyxlBzwevro2Jxme3X0PPVw591lmKUh5EEd6bFPL187oX-EyvG_6F-8uGp3idcB3ooW7aokhuY1kNlbyrwV0b3Yj9jtPCvMrvJ6pR5-h7HSb62RlG2rjMCkul93UtFbZRDpRW6wZ_xtzg4fgGKEEAD_cfuPus8ChiFY8iWTJJ-2w");'>
                    </div>
                </div>
            </header>
            <main class="flex-1 flex justify-center overflow-y-auto">
                <div class="layout-content-container flex flex-col max-w-[1024px] flex-1 py-10 px-6">
                    <!-- PageHeading -->
                    <div class="flex flex-wrap justify-between gap-3 p-4 mb-6">
                        <div class="flex min-w-72 flex-col gap-3">
                            <h1
                                class="text-[#0d121b] dark:text-[#f8f9fc] text-4xl font-black leading-tight tracking-[-0.033em]">
                                Planes y Pago de Licencia</h1>
                            <p class="text-[#4c669a] dark:text-[#a1b4d5] text-base font-normal leading-normal">
                                Selecciona el plan que mejor se adapte a las necesidades de gestión de tu empresa.</p>
                        </div>
                    </div>
                    <!-- PricingCards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 py-3 mb-10">
                        <!-- Plan Básico -->
                        <div
                            class="flex flex-1 flex-col gap-4 rounded-xl border border-solid border-[#cfd7e7] dark:border-[#2c3444] bg-white dark:bg-[#1a2130] p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col gap-1">
                                <h2 class="text-[#0d121b] dark:text-[#f8f9fc] text-base font-bold leading-tight">Básico
                                </h2>
                                <p class="flex items-baseline gap-1 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="text-4xl font-black leading-tight tracking-[-0.033em]">$29</span>
                                    <span class="text-base font-bold leading-tight">/mes</span>
                                </p>
                            </div>
                            <button
                                class="flex min-w-[84px] w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#e7ebf3] dark:bg-[#2c3444] text-[#0d121b] dark:text-[#f8f9fc] text-sm font-bold leading-normal tracking-[0.015em] border-2 border-transparent hover:border-primary/50 transition-all">
                                <span class="truncate">Seleccionar</span>
                            </button>
                            <div class="flex flex-col gap-3 mt-2">
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    Hasta 5 usuarios
                                </div>
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    10GB de almacenamiento
                                </div>
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    Soporte por email
                                </div>
                            </div>
                        </div>
                        <!-- Plan Profesional -->
                        <div
                            class="flex flex-1 flex-col gap-4 rounded-xl border-2 border-solid border-primary bg-white dark:bg-[#1a2130] p-6 shadow-lg relative transform scale-105 z-10">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-[#0d121b] dark:text-[#f8f9fc] text-base font-bold leading-tight">
                                        Profesional</h2>
                                    <p
                                        class="text-white text-[10px] font-bold leading-normal tracking-[0.05em] uppercase rounded-full bg-primary px-3 py-1">
                                        Recomendado</p>
                                </div>
                                <p class="flex items-baseline gap-1 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="text-4xl font-black leading-tight tracking-[-0.033em]">$79</span>
                                    <span class="text-base font-bold leading-tight">/mes</span>
                                </p>
                            </div>
                            <button
                                class="flex min-w-[84px] w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] shadow-sm">
                                <span class="truncate">Seleccionado</span>
                            </button>
                            <div class="flex flex-col gap-3 mt-2">
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    Usuarios ilimitados
                                </div>
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    100GB de almacenamiento
                                </div>
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    Soporte 24/7
                                </div>
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    API de integración
                                </div>
                            </div>
                        </div>
                        <!-- Plan Empresarial -->
                        <div
                            class="flex flex-1 flex-col gap-4 rounded-xl border border-solid border-[#cfd7e7] dark:border-[#2c3444] bg-white dark:bg-[#1a2130] p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col gap-1">
                                <h2 class="text-[#0d121b] dark:text-[#f8f9fc] text-base font-bold leading-tight">
                                    Empresarial</h2>
                                <p class="flex items-baseline gap-1 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="text-4xl font-black leading-tight tracking-[-0.033em]">$149</span>
                                    <span class="text-base font-bold leading-tight">/mes</span>
                                </p>
                            </div>
                            <button
                                class="flex min-w-[84px] w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#e7ebf3] dark:bg-[#2c3444] text-[#0d121b] dark:text-[#f8f9fc] text-sm font-bold leading-normal tracking-[0.015em] border-2 border-transparent hover:border-primary/50 transition-all">
                                <span class="truncate">Seleccionar</span>
                            </button>
                            <div class="flex flex-col gap-3 mt-2">
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    Almacenamiento ilimitado
                                </div>
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    Seguridad avanzada
                                </div>
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    Gerente de cuenta dedicado
                                </div>
                                <div
                                    class="text-[13px] font-normal leading-normal flex items-center gap-3 text-[#0d121b] dark:text-[#f8f9fc]">
                                    <span class="material-symbols-outlined text-primary">check_circle</span>
                                    Despliegue On-premise
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Section Header -->
                    <h2
                        class="text-[#0d121b] dark:text-[#f8f9fc] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                        Resumen de Orden e Información de Pago</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 px-4 py-3">
                        <!-- Order Summary Table -->
                        <div class="flex flex-col gap-4">
                            <div
                                class="overflow-hidden rounded-lg border border-[#cfd7e7] dark:border-[#2c3444] bg-white dark:bg-[#1a2130]">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="bg-[#f8f9fc] dark:bg-[#161d2a]">
                                            <th
                                                class="px-4 py-3 text-[#0d121b] dark:text-[#f8f9fc] text-sm font-semibold leading-normal">
                                                Producto</th>
                                            <th
                                                class="px-4 py-3 text-[#0d121b] dark:text-[#f8f9fc] text-sm font-semibold leading-normal text-right">
                                                Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-[#2c3444]">
                                        <tr>
                                            <td
                                                class="px-4 py-4 text-[#0d121b] dark:text-[#f8f9fc] text-sm font-normal">
                                                Plan Profesional - Suscripción Mensual
                                            </td>
                                            <td
                                                class="px-4 py-4 text-[#4c669a] dark:text-[#a1b4d5] text-sm font-medium text-right">
                                                $79.00</td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="px-4 py-4 text-[#0d121b] dark:text-[#f8f9fc] text-sm font-normal">
                                                Impuestos (IVA 16%)
                                            </td>
                                            <td
                                                class="px-4 py-4 text-[#4c669a] dark:text-[#a1b4d5] text-sm font-medium text-right">
                                                $12.64</td>
                                        </tr>
                                        <tr class="bg-[#f8f9fc] dark:bg-[#161d2a] font-bold">
                                            <td class="px-4 py-4 text-[#0d121b] dark:text-[#f8f9fc] text-base">Total
                                            </td>
                                            <td class="px-4 py-4 text-primary text-base text-right">$91.64</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-[12px] text-[#4c669a] dark:text-[#a1b4d5] italic px-1">
                                * Se realizará un cargo automático mensual de $79.00 a partir de hoy.
                            </p>
                        </div>
                        <!-- Payment Form -->
                        <div
                            class="bg-white dark:bg-[#1a2130] p-6 rounded-xl border border-[#cfd7e7] dark:border-[#2c3444] shadow-sm">
                            <div class="flex flex-col gap-6">
                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-bold text-[#0d121b] dark:text-[#f8f9fc]">Nombre en la
                                        tarjeta</label>
                                    <input
                                        class="flex h-10 w-full rounded-lg border border-[#cfd7e7] dark:border-[#2c3444] bg-white dark:bg-[#161d2a] px-4 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none text-[#0d121b] dark:text-[#f8f9fc]"
                                        placeholder="Ej. Juan Pérez" type="text" />
                                </div>
                                <div class="flex flex-col gap-2 relative">
                                    <label class="text-sm font-bold text-[#0d121b] dark:text-[#f8f9fc]">Número de
                                        tarjeta</label>
                                    <div class="relative">
                                        <input
                                            class="flex h-10 w-full rounded-lg border border-[#cfd7e7] dark:border-[#2c3444] bg-white dark:bg-[#161d2a] px-4 pr-10 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none text-[#0d121b] dark:text-[#f8f9fc]"
                                            placeholder="0000 0000 0000 0000" type="text" />
                                        <span
                                            class="material-symbols-outlined absolute right-3 top-2.5 text-[#4c669a]">credit_card</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex flex-col gap-2">
                                        <label
                                            class="text-sm font-bold text-[#0d121b] dark:text-[#f8f9fc]">Vencimiento</label>
                                        <input
                                            class="flex h-10 w-full rounded-lg border border-[#cfd7e7] dark:border-[#2c3444] bg-white dark:bg-[#161d2a] px-4 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none text-[#0d121b] dark:text-[#f8f9fc]"
                                            placeholder="MM/YY" type="text" />
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-sm font-bold text-[#0d121b] dark:text-[#f8f9fc]">CVC</label>
                                        <input
                                            class="flex h-10 w-full rounded-lg border border-[#cfd7e7] dark:border-[#2c3444] bg-white dark:bg-[#161d2a] px-4 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none text-[#0d121b] dark:text-[#f8f9fc]"
                                            placeholder="123" type="text" />
                                    </div>
                                </div>
                                <button
                                    class="mt-2 flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-all">
                                    <span class="truncate">Confirmar Suscripción</span>
                                </button>
                                <div class="flex items-center justify-center gap-2 text-[#4c669a]">
                                    <span class="material-symbols-outlined text-xs">lock</span>
                                    <span class="text-[11px]">Pago seguro procesado por Stripe</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Footer-like space -->
            <footer class="py-10 text-center border-t border-[#e7ebf3] dark:border-[#2c3444] mt-auto">
                <p class="text-xs text-[#4c669a] dark:text-[#a1b4d5]">© 2024 GestionCorr Inc. Todos los derechos
                    reservados.</p>
            </footer>
        </div>
    </div>
</body>

</html>

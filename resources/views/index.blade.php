<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>GestionCorr - Gestión de Correspondencia Digital</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
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
            font-family: 'Public Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0d121b] antialiased">
    <!-- Top Navigation Bar -->
    <header
        class="sticky top-0 z-50 w-full border-b border-solid border-[#e7ebf3] bg-white/80 backdrop-blur-md px-6 md:px-20 py-4">
        <div class="max-w-[1280px] mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-primary text-white p-1.5 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">mail</span>
                </div>
                <h2 class="text-[#0d121b] text-xl font-extrabold tracking-tight">GestionCorr</h2>
            </div>
            <nav class="hidden md:flex items-center gap-10">
                <a class="text-[#4c669a] hover:text-primary text-sm font-semibold transition-colors"
                    href="#features">Características</a>
                <a class="text-[#4c669a] hover:text-primary text-sm font-semibold transition-colors"
                    href="#how-it-works">Cómo funciona</a>
                <a class="text-[#4c669a] hover:text-primary text-sm font-semibold transition-colors"
                    href="#pricing">Planes</a>
                <a class="text-[#4c669a] hover:text-primary text-sm font-semibold transition-colors"
                    href="#">Soporte</a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}">
                    <button
                        class="hidden sm:flex px-5 py-2.5 text-[#0d121b] hover:bg-gray-100 rounded-lg text-sm font-bold transition-all">
                        Iniciar sesión
                    </button>
                </a>
                <button
                    class="bg-primary hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-lg shadow-primary/20 transition-all">
                    Empezar ahora
                </button>
            </div>
        </div>
    </header>
    <main class="flex flex-col">
        <!-- Hero Section -->
        <section class="relative overflow-hidden pt-16 pb-20 md:pt-24 md:pb-32">
            <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-12 items-center">
                <div class="flex flex-col gap-8">
                    <div
                        class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full w-fit border border-primary/20">
                        <span class="material-symbols-outlined text-sm">verified</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Gestión Profesional 2.0</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-[#0d121b] leading-[1.1] tracking-tight">
                        Transforme su Gestión de <span class="text-primary">Correspondencia</span>
                    </h1>
                    <p class="text-lg text-[#4c669a] leading-relaxed max-w-xl">
                        Optimice el control, seguimiento y archivo digital de toda su mensajería institucional en una
                        sola plataforma segura, rápida y centralizada.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button
                            class="bg-primary hover:bg-blue-700 text-white px-8 py-4 rounded-xl text-base font-bold shadow-xl shadow-primary/30 flex items-center justify-center gap-2 transition-all">
                            Empezar ahora <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                        <button
                            class="bg-white border border-[#e7ebf3] hover:border-primary/30 text-[#0d121b] px-8 py-4 rounded-xl text-base font-bold flex items-center justify-center gap-2 transition-all">
                            Ver demo en vivo <span class="material-symbols-outlined">play_circle</span>
                        </button>
                    </div>
                    <div class="flex items-center gap-6 pt-4 border-t border-[#e7ebf3]">
                        <div class="flex -space-x-3">
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-200 overflow-hidden">
                                <img alt="Usuario" data-alt="Avatar of a happy customer"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBAHiGYNWERMdir4eG9c6P3gy3ZcCqRSvjpomfpIu1yzukqENW4xLguyWYoNcL_PcP1hZlHhfl_0rsJRnYTObwoR6fLqZa67zOqZwP_UyP7TB4zl0tqXt1xWthb8l_KLjOaDkb_x-rLWEBeolqdUWpvniQFXk_8-Pg9vX8TFWPBEqgzi_QoRExpd6b9yo7Mpb5IzUWsnY9hNpitpRjfUSVgtz7YlhsFwROnx9q07WktmRWSwjAAGHhNgAaNvjI3d6omuEQ2tko_fJk" />
                            </div>
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-200 overflow-hidden">
                                <img alt="Usuario" data-alt="Avatar of a business professional"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuByB3rUvImQxhzNpmY5HXhEABYgUQIZXmFWVy3VGo65XdGmboFfDu45o2-pUsUFNMw5z4J8bppPNY-Sm0-sgodBZwbCGTNXvTjAt8i7w2j8zj9EzGuyrgPwgySG0LRiUkhm2oeuvIpbLZXAMfxCOM1g6XSI8ZppdcMr6O3rprTv43Emdt3f26RonvOBKhlF75OTMBTS8zQDp9ziFXBDrzEPk6C7cwe_XT4r0-gfCF_3EFUq9RO5RaUQuZ7brUxAFGLuaKb6WGZ_pxc" />
                            </div>
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-200 overflow-hidden">
                                <img alt="Usuario" data-alt="Avatar of a corporate manager"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBHOC__-q7k1tQo8I_mdNpIhNoOtJdC0uuDsUdOCwHuY7OfwG2o_x30w6QQMyo-NaM9wD0elFiit36IITVsOEc3wovDDOLPagQaCMF5_FEFhyHcI22gxlX4JYcK6Kq_NXAY8shAqE6qgteatVIF_-DLmC-bXNh9UqzCBC3LkvJQl3xRKnQyWQ4avlhGQCT8wwUQMWARrgiIRdVO6v4PvfkdVlWXO9zL57Zh-WKSM4zHO0b4R13WMFp4Y01QP0BuhBNoUpwyUkcDTFM" />
                            </div>
                        </div>
                        <p class="text-sm text-[#4c669a] font-medium">+2,500 instituciones confían en nosotros</p>
                    </div>
                </div>
                <div class="relative group">
                    <div
                        class="absolute -inset-4 bg-gradient-to-r from-primary/20 to-blue-400/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all">
                    </div>
                    <div
                        class="relative bg-white border border-[#e7ebf3] rounded-3xl shadow-2xl overflow-hidden aspect-[4/3] flex items-center justify-center">
                        <div class="w-full h-full bg-cover bg-center"
                            data-alt="Modern software dashboard preview interface"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDJdAEO033LvNdWSE9fvgkhecTEXFhYQ4FeYHw10qWx_fdkeMADZN4G9doXXl_mCOnvVQV1Wp2z2wn977kPsnDkxVk78eScZ8_fuVWJq0XKpg5SmyH9yA8N3RumZzykpIG2aenaS4ulaBm2V2FKPFuj8vbyS_g-jrQjc-Upgj0cN1XqD1oLSYvgvrkKpdk6GHxYTGO7eYvuGMPQMzg_tKEx1G_k0xgW1KQMEyZuLuhik1iJT0GACrJPrt6cs1MleLwcdPFttS-t3Ok");'>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Process Section: How it Works -->
        <section class="py-20 bg-white" id="how-it-works">
            <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center mb-16">
                <h3 class="text-primary font-bold text-sm uppercase tracking-[0.2em] mb-4">Proceso Ágil</h3>
                <h2 class="text-3xl md:text-4xl font-black text-[#0d121b]">¿Cómo empezar con GestionCorr?</h2>
            </div>
            <div class="max-w-[1280px] mx-auto px-6 md:px-20">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="relative flex flex-col items-center text-center group">
                        <div
                            class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">person_add</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">1. Registro</h4>
                        <p class="text-sm text-[#4c669a] leading-relaxed">Cree su cuenta institucional en minutos con
                            sus datos básicos.</p>
                        <div
                            class="hidden md:block absolute top-8 left-1/2 w-full h-[2px] bg-gradient-to-r from-primary/20 to-transparent ml-8">
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="relative flex flex-col items-center text-center group">
                        <div
                            class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">fact_check</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">2. Selección de Plan</h4>
                        <p class="text-sm text-[#4c669a] leading-relaxed">Elija el nivel de servicio que mejor se adapte
                            a sus necesidades operativas.</p>
                        <div
                            class="hidden md:block absolute top-8 left-1/2 w-full h-[2px] bg-gradient-to-r from-primary/20 to-transparent ml-8">
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="relative flex flex-col items-center text-center group">
                        <div
                            class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">qr_code_2</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">3. Pago QR</h4>
                        <p class="text-sm text-[#4c669a] leading-relaxed">Escanee el código para un procesamiento de
                            pago inmediato y seguro.</p>
                        <div
                            class="hidden md:block absolute top-8 left-1/2 w-full h-[2px] bg-gradient-to-r from-primary/20 to-transparent ml-8">
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="relative flex flex-col items-center text-center group">
                        <div
                            class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">rocket_launch</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">4. Activación</h4>
                        <p class="text-sm text-[#4c669a] leading-relaxed">Acceso instantáneo a todas las herramientas de
                            control y seguimiento.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features Grid Section -->
        <section class="py-20 bg-background-light" id="features">
            <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-2 gap-20 items-center">
                <div class="order-2 md:order-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div
                            class="bg-white p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary/50 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-primary text-3xl mb-4">track_changes</span>
                            <h4 class="font-bold text-lg mb-2">Trazabilidad Total</h4>
                            <p class="text-sm text-[#4c669a] leading-relaxed">Historial completo desde la recepción
                                hasta la entrega final.</p>
                        </div>
                        <div
                            class="bg-white p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary/50 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-primary text-3xl mb-4">archive</span>
                            <h4 class="font-bold text-lg mb-2">Archivo Digital</h4>
                            <p class="text-sm text-[#4c669a] leading-relaxed">Escanee y almacene documentos físicos en
                                nuestra nube segura.</p>
                        </div>
                        <div
                            class="bg-white p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary/50 transition-all shadow-sm">
                            <span
                                class="material-symbols-outlined text-primary text-3xl mb-4">notifications_active</span>
                            <h4 class="font-bold text-lg mb-2">Alertas en Vivo</h4>
                            <p class="text-sm text-[#4c669a] leading-relaxed">Notificaciones automáticas vía email o
                                SMS para entregas urgentes.</p>
                        </div>
                        <div
                            class="bg-white p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary/50 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-primary text-3xl mb-4">security</span>
                            <h4 class="font-bold text-lg mb-2">Máxima Seguridad</h4>
                            <p class="text-sm text-[#4c669a] leading-relaxed">Encriptación de grado bancario para toda
                                su información sensible.</p>
                        </div>
                    </div>
                </div>
                <div class="order-1 md:order-2 flex flex-col gap-6">
                    <h3 class="text-primary font-bold text-sm uppercase tracking-[0.2em]">Características Clave</h3>
                    <h2 class="text-4xl font-black text-[#0d121b] leading-tight">Diseñado para la eficiencia
                        institucional</h2>
                    <p class="text-lg text-[#4c669a] leading-relaxed">
                        No pierda nunca más un sobre o paquete. GestionCorr centraliza la entrada y salida de
                        mensajería, eliminando el error humano y acelerando los procesos internos.
                    </p>
                    <ul class="flex flex-col gap-4">
                        <li class="flex items-center gap-3 text-sm font-semibold text-[#0d121b]">
                            <span class="material-symbols-outlined text-green-500 font-bold">check_circle</span>
                            Multiusuario con roles jerárquicos definidos
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-[#0d121b]">
                            <span class="material-symbols-outlined text-green-500 font-bold">check_circle</span>
                            Reportes inteligentes y estadísticas de flujo
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-[#0d121b]">
                            <span class="material-symbols-outlined text-green-500 font-bold">check_circle</span>
                            Firma digital para confirmación de entrega
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Pricing Section -->
        <section class="py-24 bg-white" id="pricing">
            <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center mb-16">
                <h2 class="text-4xl font-black text-[#0d121b] mb-4">Planes diseñados para cada tamaño</h2>
                <p class="text-[#4c669a] text-lg max-w-2xl mx-auto">Precios transparentes y escalables. Comience gratis
                    y crezca con nosotros.</p>
            </div>
            <div class="max-w-[1100px] mx-auto px-6 grid md:grid-cols-3 gap-8">
                <!-- Basic Plan -->
                <div
                    class="bg-white border border-[#e7ebf3] rounded-3xl p-8 flex flex-col hover:border-primary/30 transition-all shadow-lg shadow-gray-100/50">
                    <h3 class="text-lg font-bold mb-2">Básico</h3>
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-4xl font-black">$29</span>
                        <span class="text-[#4c669a] text-sm">/mes</span>
                    </div>
                    <p class="text-sm text-[#4c669a] mb-8">Para oficinas pequeñas y despachos independientes.</p>
                    <ul class="flex flex-col gap-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary text-xl">check</span>
                            Hasta 500 envíos/mes
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary text-xl">check</span>
                            3 Usuarios simultáneos
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-400">
                            <span class="material-symbols-outlined text-xl">close</span>
                            Firma Digital
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-400">
                            <span class="material-symbols-outlined text-xl">close</span>
                            Soporte Prioritario
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 border border-primary text-primary font-bold rounded-xl hover:bg-primary/5 transition-all">Seleccionar
                        Plan</button>
                </div>
                <!-- Professional Plan (Featured) -->
                <div
                    class="bg-white border-2 border-primary rounded-3xl p-8 flex flex-col relative transform scale-105 shadow-2xl shadow-primary/10">
                    <div
                        class="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary text-white text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full">
                        Más Popular
                    </div>
                    <h3 class="text-lg font-bold mb-2">Profesional</h3>
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-4xl font-black text-primary">$79</span>
                        <span class="text-[#4c669a] text-sm">/mes</span>
                    </div>
                    <p class="text-sm text-[#4c669a] mb-8">Ideal para medianas empresas e instituciones públicas.</p>
                    <ul class="flex flex-col gap-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm font-medium">
                            <span class="material-symbols-outlined text-primary text-xl font-bold">check</span>
                            Envíos ilimitados
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium">
                            <span class="material-symbols-outlined text-primary text-xl font-bold">check</span>
                            15 Usuarios simultáneos
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium">
                            <span class="material-symbols-outlined text-primary text-xl font-bold">check</span>
                            Firma Digital incluida
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium">
                            <span class="material-symbols-outlined text-primary text-xl font-bold">check</span>
                            API de integración
                        </li>
                    </ul>
                    <button
                        class="w-full py-4 bg-primary text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-primary/30">Seleccionar
                        Plan</button>
                </div>
                <!-- Enterprise Plan -->
                <div
                    class="bg-white border border-[#e7ebf3] rounded-3xl p-8 flex flex-col hover:border-primary/30 transition-all shadow-lg shadow-gray-100/50">
                    <h3 class="text-lg font-bold mb-2">Corporativo</h3>
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-4xl font-black">Personalizado</span>
                    </div>
                    <p class="text-sm text-[#4c669a] mb-8">Soluciones a medida para grandes corporaciones.</p>
                    <ul class="flex flex-col gap-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary text-xl">check</span>
                            Servidor dedicado (On-premise)
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary text-xl">check</span>
                            Usuarios ilimitados
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary text-xl">check</span>
                            Soporte 24/7 Premium
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <span class="material-symbols-outlined text-primary text-xl">check</span>
                            Capacitación presencial
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 border border-[#0d121b] text-[#0d121b] font-bold rounded-xl hover:bg-gray-50 transition-all">Contactar
                        Ventas</button>
                </div>
            </div>
        </section>
        <!-- CTA Section -->
        <section class="py-20 px-6">
            <div
                class="max-w-[1280px] mx-auto bg-primary rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl shadow-primary/40">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400/20 rounded-full -ml-32 -mb-32 blur-3xl">
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-white mb-8 relative z-10 leading-tight">
                    ¿Listo para digitalizar su <br class="hidden md:block" /> centro de correspondencia?
                </h2>
                <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
                    <button
                        class="bg-white text-primary px-10 py-5 rounded-2xl text-lg font-black hover:bg-gray-100 transition-all shadow-xl">
                        Empezar Prueba Gratis
                    </button>
                    <button
                        class="bg-primary/20 backdrop-blur-md border border-white/30 text-white px-10 py-5 rounded-2xl text-lg font-black hover:bg-white/10 transition-all">
                        Contactar Soporte
                    </button>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-white border-t border-[#e7ebf3] pt-20 pb-10">
        <div class="max-w-[1280px] mx-auto px-6 md:px-20 grid md:grid-cols-4 gap-12 mb-16">
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-primary text-white p-1 rounded-md flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">mail</span>
                    </div>
                    <h2 class="text-[#0d121b] text-lg font-bold">GestionCorr</h2>
                </div>
                <p class="text-sm text-[#4c669a] leading-relaxed mb-6">
                    La plataforma líder en gestión de mensajería institucional en Latinoamérica. Innovación y seguridad
                    en cada entrega.
                </p>
                <div class="flex gap-4">
                    <a class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[#4c669a] hover:bg-primary hover:text-white transition-all"
                        href="#">
                        <svg class="w-4 h-4" fill="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z">
                            </path>
                        </svg>
                    </a>
                    <a class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[#4c669a] hover:bg-primary hover:text-white transition-all"
                        href="#">
                        <svg class="w-4 h-4" fill="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.058-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-[#0d121b] mb-6">Producto</h4>
                <ul class="flex flex-col gap-4 text-sm text-[#4c669a]">
                    <li><a class="hover:text-primary transition-colors" href="#">Características</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Seguridad</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Precios</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Versión Mobile</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-[#0d121b] mb-6">Empresa</h4>
                <ul class="flex flex-col gap-4 text-sm text-[#4c669a]">
                    <li><a class="hover:text-primary transition-colors" href="#">Sobre nosotros</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Blog</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Clientes</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-[#0d121b] mb-6">Legal</h4>
                <ul class="flex flex-col gap-4 text-sm text-[#4c669a]">
                    <li><a class="hover:text-primary transition-colors" href="#">Privacidad</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Términos de servicio</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Cookies</a></li>
                </ul>
            </div>
        </div>
        <div
            class="max-w-[1280px] mx-auto px-6 md:px-20 pt-8 border-t border-[#e7ebf3] flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-[#4c669a]">© 2024 GestionCorr Inc. Todos los derechos reservados.</p>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <p class="text-xs text-[#4c669a] font-medium">Sistemas Operativos 100%</p>
            </div>
        </div>
    </footer>
</body>

</html>

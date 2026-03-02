<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>IncolDev - Gestión de Correspondencia Digital</title>
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
                <h2 class="text-[#0d121b] text-xl font-extrabold tracking-tight">IncolDEV</h2>
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
                {{-- <a href="">
                    <button
                        class="hidden sm:flex px-5 py-2.5 text-[#0d121b] hover:bg-gray-100 rounded-lg text-sm font-bold transition-all">
                        Iniciar sesión
                    </button>
                </a> --}}
                <a href="{{ route('login') }}">
                    <button
                        class="bg-primary hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-lg shadow-primary/20 transition-all">
                        Iniciar sesión
                    </button>
                </a>
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
                        <span class="text-xs font-bold uppercase tracking-wider">Gestión Profesional</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-[#0d121b] leading-[1.1] tracking-tight">
                        Transforme su Gestión de <span class="text-primary">Correspondencia</span>
                    </h1>
                    <p class="text-lg text-[#4c669a] leading-relaxed max-w-xl">
                        Optimice el control, seguimiento y archivo digital de toda su mensajería institucional en una
                        sola plataforma segura, rápida y centralizada.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#pricing">
                            <button
                                class="bg-primary hover:bg-blue-700 text-white px-8 py-4 rounded-xl text-base font-bold shadow-xl shadow-primary/30 flex items-center justify-center gap-2 transition-all">
                                Empezar ahora
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </button>
                        </a>
                        {{-- <button
                            class="bg-white border border-[#e7ebf3] hover:border-primary/30 text-[#0d121b] px-8 py-4 rounded-xl text-base font-bold flex items-center justify-center gap-2 transition-all">
                            Ver demo en vivo <span class="material-symbols-outlined">play_circle</span>
                        </button> --}}
                    </div>
                    {{-- <div class="flex items-center gap-6 pt-4 border-t border-[#e7ebf3]">
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
                    </div> --}}
                </div>
                <div class="relative group">
                    <div
                        class="absolute -inset-4 bg-gradient-to-r from-primary/20 to-blue-400/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all">
                    </div>
                    <div
                        class="relative bg-white border border-[#e7ebf3] rounded-3xl shadow-2xl overflow-hidden aspect-[4/3] flex items-center justify-center">
                        <div class="w-full h-full bg-cover bg-center"
                            data-alt="Modern software dashboard preview interface"
                            style="background-image: url('{{ asset('storage/public/s.png') }}');">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Process Section: How it Works -->
        <section class="py-20 bg-white" id="how-it-works">
            <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center mb-16">
                <h3 class="text-primary font-bold text-sm uppercase tracking-[0.2em] mb-4">Proceso Ágil</h3>
                <h2 class="text-3xl md:text-4xl font-black text-[#0d121b]">¿Cómo empezar con IncolDEV?</h2>
            </div>
            <div class="max-w-[1280px] mx-auto px-6 md:px-20">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="relative flex flex-col items-center text-center group">
                        <div
                            class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">support_agent</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">1. Contacto y Diagnóstico</h4>
                        <p class="text-sm text-[#4c669a] leading-relaxed">El cliente se comunica con nuestro equipo para
                            validar sus necesidades y confirmar que GYC Correspondencia es la solución adecuada.</p>
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
                        <h4 class="text-lg font-bold mb-2">2. Selección del Plan</h4>
                        <p class="text-sm text-[#4c669a] leading-relaxed">El cliente elige el plan que mejor se adapta a
                            su organización según los usuarios y funcionalidades mostradas en esta página.</p>
                        <div
                            class="hidden md:block absolute top-8 left-1/2 w-full h-[2px] bg-gradient-to-r from-primary/20 to-transparent ml-8">
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="relative flex flex-col items-center text-center group">
                        <div
                            class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">settings</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">3. Instalación y Configuración</h4>
                        <p class="text-sm text-[#4c669a] leading-relaxed">Nuestro equipo instala el sistema en la
                            infraestructura del cliente y configura usuarios, áreas y permisos según el plan contratado.
                        </p>
                        <div
                            class="hidden md:block absolute top-8 left-1/2 w-full h-[2px] bg-gradient-to-r from-primary/20 to-transparent ml-8">
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="relative flex flex-col items-center text-center group">
                        <div
                            class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                            <span class="material-symbols-outlined text-3xl">school</span>
                        </div>
                        <h4 class="text-lg font-bold mb-2">4. Capacitación</h4>
                        <p class="text-sm text-[#4c669a] leading-relaxed">Se capacita al personal autorizado y se deja
                            el sistema completamente operativo.</p>
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
                            <p class="text-sm text-[#4c669a] leading-relaxed">Escanee y almacene documentos físicos.</p>
                        </div>
                        <div
                            class="bg-white p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary/50 transition-all shadow-sm">
                            <span
                                class="material-symbols-outlined text-primary text-3xl mb-4">notifications_active</span>
                            <h4 class="font-bold text-lg mb-2">Alertas en Vivo</h4>
                            <p class="text-sm text-[#4c669a] leading-relaxed">Notificaciones automáticas para entregas
                                urgentes.</p>
                        </div>
                        <div
                            class="bg-white p-8 rounded-2xl border border-[#e7ebf3] hover:border-primary/50 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-primary text-3xl mb-4">security</span>
                            <h4 class="font-bold text-lg mb-2">Máxima Seguridad</h4>
                            <p class="text-sm text-[#4c669a] leading-relaxed">Seguridad para toda
                                su información sensible.</p>
                        </div>
                    </div>
                </div>
                <div class="order-1 md:order-2 flex flex-col gap-6">
                    <h3 class="text-primary font-bold text-sm uppercase tracking-[0.2em]">Características Clave</h3>
                    <h2 class="text-4xl font-black text-[#0d121b] leading-tight">Diseñado para la eficiencia
                        institucional</h2>
                    <p class="text-lg text-[#4c669a] leading-relaxed">
                        No pierda nunca más un sobre o paquete. GYC Correspondencia centraliza la entrada y salida de
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
                            Copias de seguridad de toda la correspondencia
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Pricing Section -->
        <section class="py-24 bg-white" id="pricing">
            <div class="max-w-[1280px] mx-auto px-6 md:px-20 text-center mb-16">
                <h2 class="text-4xl font-black text-[#0d121b] mb-4">
                    Planes diseñados para cada tamaño
                </h2>
                <p class="text-[#4c669a] text-lg max-w-2xl mx-auto">
                    Precios transparentes y escalables. Comience gratis y crezca con nosotros.
                </p>
            </div>

            <div class="max-w-7xl mx-auto px-6 md:px-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">


                    @foreach ($planes as $plan)
                        <div
                            class="flex flex-col h-full min-h-[380px] p-6 transition
                                {{ $plan->es_destacado
                                    ? 'relative scale-105 rounded-3xl border-2 border-primary bg-white shadow-2xl shadow-primary/10'
                                    : 'rounded-2xl border border-[#cfd7e7] bg-white shadow-sm hover:shadow-xl' }}">

                            @if ($plan->es_destacado)
                                <div
                                    class="absolute -top-4 left-1/2 -translate-x-1/2
                                        bg-primary text-white text-[10px] font-black uppercase
                                        tracking-widest px-4 py-1.5 rounded-full">
                                    Más Popular
                                </div>
                            @endif

                            <!-- Info -->
                            <div>
                                <h2 class="text-xl font-extrabold text-[#0d121b] mb-3">
                                    {{ $plan->nomb_plan }}
                                </h2>

                                <div class="mb-4">
                                    <span
                                        class="block text-4xl font-black
    {{ $plan->es_destacado ? 'text-primary' : 'text-[#0d121b]' }}">
                                        ${{ number_format($plan->valor, 0, ',', '.') }}
                                    </span>

                                    <span class="text-sm font-semibold text-[#4c669a]">
                                        {{ $plan->duracion ? $plan->duracion . ' días' : 'Pago único' }}
                                    </span>
                                </div>

                                <!-- Beneficios -->
                                <div class="flex flex-col gap-3 text-sm text-[#0d121b]">
                                    @forelse ($plan->descripcion ?? [] as $beneficio)
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-primary text-base">
                                                check_circle
                                            </span>
                                            {{ $beneficio }}
                                        </div>
                                    @empty
                                        <span class="text-gray-400">
                                            Este plan no tiene beneficios registrados
                                        </span>
                                    @endforelse
                                </div>
                            </div>

                            @php
                                $mensaje =
                                    "Hola 👋, estoy interesado en el plan {$plan->nomb_plan} de IncolDEV.
💼 Precio: $" .
                                    number_format($plan->valor, 0, ',', '.') .
                                    "
📅 Duración: " .
                                    ($plan->duracion ? $plan->duracion . ' días' : 'Pago único') .
                                    "
¿Podrían asesorarme?";
                                $whatsappUrl =
                                    'https://wa.me/' .
                                    config('services.whatsapp.number') .
                                    '?text=' .
                                    urlencode($mensaje);
                            @endphp

                            <!-- Botón -->
                            <a href="{{ $whatsappUrl }}" target="_blank" class="mt-auto pt-4">
                                <button
                                    class="w-full h-11 rounded-xl font-bold transition
                                {{ $plan->es_destacado
                                    ? 'bg-primary text-white hover:bg-blue-700 shadow-lg shadow-primary/30'
                                    : 'bg-[#e7ebf3] text-[#0d121b] hover:bg-primary hover:text-white' }}">
                                    Contactar asesor
                                </button>
                            </a>
                        </div>
                    @endforeach

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
                    @php
                        $demoMsg = "Hola 👋, me gustaría solicitar una demostración del sistema IncolDEV.
¿Podrían mostrarme cómo funciona?";
                        $demoUrl =
                            'https://wa.me/' . config('services.whatsapp.number') . '?text=' . urlencode($demoMsg);
                    @endphp

                    <a href="{{ $demoUrl }}" target="_blank">
                        <button
                            class="bg-white text-primary px-10 py-5 rounded-2xl text-lg font-black hover:bg-gray-100 transition-all shadow-xl">
                            Solicitar demostración
                        </button>
                    </a>
                    @php
                        $soporteMsg = 'Hola 👋, necesito ayuda con IncolDEV. ¿Podrían apoyarme?';
                        $soporteUrl =
                            'https://wa.me/' . config('services.whatsapp.number') . '?text=' . urlencode($soporteMsg);
                    @endphp

                    <a href="{{ $soporteUrl }}" target="_blank">
                        <button
                            class="bg-primary/20 backdrop-blur-md border border-white/30 text-white px-10 py-5 rounded-2xl text-lg font-black hover:bg-white/10 transition-all">
                            Contactar Soporte
                        </button>
                    </a>
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
                    <h2 class="text-[#0d121b] text-lg font-bold">IncolDEV</h2>
                </div>
                <p class="text-sm text-[#4c669a] leading-relaxed mb-6">
                    La plataforma líder en gestión de mensajería institucional en Latinoamérica. Innovación y seguridad
                    en cada entrega.
                </p>
                <div class="flex gap-4">
                    <a class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all"
                        href="https://wa.me/573150168048?text=Hola%20👋,%20estoy%20interesado%20en%20contratar%20un%20plan%20de%20IncolDEV.%20¿Podrían%20asesorarme?"
                        target="_blank">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.52 3.48A11.82 11.82 0 0012.01 0C5.38 0 .02 5.36.02 11.99c0 2.11.55 4.17 1.6 6L0 24l6.2-1.6a11.93 11.93 0 005.81 1.48h.01c6.63 0 11.99-5.36 11.99-11.99a11.9 11.9 0 00-3.49-8.41zM12.01 21.3a9.3 9.3 0 01-4.74-1.3l-.34-.2-3.68.95.98-3.59-.22-.37a9.29 9.29 0 0114.34-11.47 9.24 9.24 0 012.72 6.55c0 5.13-4.18 9.33-9.32 9.33zm5.11-6.97c-.28-.14-1.65-.81-1.91-.9-.26-.1-.45-.14-.64.14-.18.28-.73.9-.9 1.09-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.39-.83-.74-1.39-1.66-1.55-1.94-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.1-.18.05-.35-.02-.48-.07-.14-.64-1.54-.88-2.11-.23-.55-.47-.48-.64-.49l-.55-.01c-.18 0-.48.07-.73.35-.25.28-.96.94-.96 2.29s.99 2.66 1.13 2.84c.14.18 1.95 2.98 4.73 4.18.66.29 1.18.46 1.58.59.66.21 1.26.18 1.73.11.53-.08 1.65-.67 1.88-1.32.23-.65.23-1.21.16-1.32-.07-.11-.25-.18-.53-.32z" />
                        </svg>
                    </a>
                    <a class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[#4c669a] hover:bg-primary hover:text-white transition-all"
                        href="mailto:contacto@tudominio.com">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                    </a>

                </div>
            </div>
            <div>
                <h4 class="font-bold text-[#0d121b] mb-6">Producto</h4>
                <ul class="flex flex-col gap-4 text-sm text-[#4c669a]">
                    <li><a class="hover:text-primary transition-colors"
                            href="{{ route('caracteristicas') }}">Características</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('seguridad') }}">Seguridad</a>
                    </li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('precios') }}">Precios</a>
                    </li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('mobile') }}">Versión
                            Mobile</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-[#0d121b] mb-6">Empresa</h4>
                <ul class="flex flex-col gap-4 text-sm text-[#4c669a]">
                    <li><a class="hover:text-primary transition-colors" href="{{ route('sobre.nosotros') }}">Sobre
                            nosotros</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('blog') }}">Blog</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('clientes') }}">Clientes</a>
                    </li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('contacto') }}">Contacto</a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-[#0d121b] mb-6">Legal</h4>
                <ul class="flex flex-col gap-4 text-sm text-[#4c669a]">
                    <li><a class="hover:text-primary transition-colors"
                            href="{{ route('privacidad') }}">Privacidad</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('terminos') }}">Términos de
                            servicio</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('cookies') }}">Cookies</a>
                    </li>
                </ul>
            </div>
        </div>
        <div
            class="max-w-[1280px] mx-auto px-6 md:px-20 pt-8 border-t border-[#e7ebf3] flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-[#4c669a]">© 2026 IncolDEV. Todos los derechos reservados.</p>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <p class="text-xs text-[#4c669a] font-medium">Sistemas Operativos 100%</p>
            </div>
        </div>
    </footer>
</body>

</html>

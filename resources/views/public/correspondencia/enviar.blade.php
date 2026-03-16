<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enviar Correspondencia - Sistema de Gestión</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" crossorigin href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
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

<body class="font-display bg-background-light dark:bg-background-dark min-h-screen py-10 px-4 flex items-center justify-center">
    <div class="w-full max-w-4xl bg-white dark:bg-slate-900 rounded-xl shadow-lg sm:p-10 p-6">
        <a href="{{ route('web.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline mb-6">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Volver al inicio
        </a>

        <div class="mb-8 text-center sm:text-left flex flex-col sm:flex-row items-center sm:items-start gap-4">
            <div class="bg-primary/10 p-3 rounded-full text-primary hidden sm:block">
                <span class="material-symbols-outlined text-4xl">outgoing_mail</span>
            </div>
            <div>
                <h1 class="text-3xl font-black text-[#0d121b] dark:text-gray-100">Enviar Correspondencia</h1>
                <p class="text-[#4c669a] dark:text-gray-400 mt-2">
                    Complete el formulario para radicar un documento en nuestra entidad.
                    Si ya radicó un documento, puede 
                    <a href="{{ route('public.correspondencia.consultar') }}" class="text-primary font-medium hover:underline">consultar su estado aquí</a>.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 flex flex-col gap-2">
                <p class="font-bold text-lg">Radicación Exitosa</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <p class="font-bold mb-2">Por favor, corrija los siguientes errores:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('public.correspondencia.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- SELECCIÓN DE TIPO DE REMITENTE -->
            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-lg border border-slate-100 dark:border-slate-800">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Tipo de Remitente</h2>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer bg-white dark:bg-slate-800 p-3 rounded-lg border border-[#cfd7e7] dark:border-slate-700 flex-1 hover:bg-slate-50 transition">
                        <input type="radio" name="tipo_remitente" value="Persona" class="text-primary focus:ring-primary w-4 h-4" checked onchange="toggleFormularioRemitente()">
                        <span class="text-sm font-medium text-[#0d121b] dark:text-slate-200">Persona Natural</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer bg-white dark:bg-slate-800 p-3 rounded-lg border border-[#cfd7e7] dark:border-slate-700 flex-1 hover:bg-slate-50 transition">
                        <input type="radio" name="tipo_remitente" value="Empresa" class="text-primary focus:ring-primary w-4 h-4" {{ old('tipo_remitente') == 'Empresa' ? 'checked' : '' }} onchange="toggleFormularioRemitente()">
                        <span class="text-sm font-medium text-[#0d121b] dark:text-slate-200">Empresa / Entidad</span>
                    </label>
                </div>
            </div>

            <!-- SECCIÓN REMITENTE: PERSONA -->
            <div id="seccion_persona" class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-lg border border-slate-100 dark:border-slate-800 block">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Información de la Persona</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Tipo de Documento <span class="text-red-500">*</span></label>
                        <select name="tipo_documento" id="tipo_documento" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required>
                            <option value="">Seleccione...</option>
                            <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                            <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                            <option value="PASAPORTE" {{ old('tipo_documento') == 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="OTRO" {{ old('tipo_documento') == 'OTRO' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Número de Documento <span class="text-red-500">*</span></label>
                        <input type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required maxlength="20">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre_persona" id="nombre_persona" value="{{ old('nombre_persona') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required maxlength="100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                        <input type="email" name="correo_persona" id="correo_persona" value="{{ old('correo_persona') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Teléfono</label>
                        <input type="text" name="tel_persona" id="tel_persona" value="{{ old('tel_persona') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="25">
                    </div>
                </div>
            </div>

            <!-- SECCIÓN REMITENTE: EMPRESA -->
            <div id="seccion_empresa" class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-lg border border-slate-100 dark:border-slate-800 hidden">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Información de la Empresa</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">NIT <span class="text-red-500">*</span></label>
                        <input type="text" name="nit_empresa_remitente" id="nit_empresa_remitente" value="{{ old('nit_empresa_remitente') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="20">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Radicado Interno de Empresa</label>
                        <input type="text" name="radicado_empresa" value="{{ old('radicado_empresa') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none uppercase" maxlength="100" placeholder="Opcional. Ej: RAD-001">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Razón Social o Nombre de la Empresa <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre_empresa" id="nombre_empresa" value="{{ old('nombre_empresa') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Correo Electrónico de Contacto <span class="text-red-500">*</span></label>
                        <input type="email" name="correo_empresa" id="correo_empresa" value="{{ old('correo_empresa') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Teléfono</label>
                        <input type="text" name="tel_empresa" id="tel_empresa" value="{{ old('tel_empresa') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="25">
                    </div>
                </div>
            </div>

            <!-- SECCIÓN DOCUMENTO -->
            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-lg border border-slate-100 dark:border-slate-800">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Detalles de la Correspondencia</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Empresa de Destino <span class="text-red-500">*</span></label>
                        <select name="empresa_destino" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required>
                            <option value="">Buscar y seleccionar empresa...</option>
                            @foreach($empresas as $emp)
                                <option value="{{ $emp->nit_empresa }}" {{ old('empresa_destino') == $emp->nit_empresa ? 'selected' : '' }}>
                                    {{ $emp->nit_empresa }} - {{ $emp->nomb_empresa }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Seleccione la entidad hacia la cual va dirigida la correspondencia.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Ciudad de Origen <span class="text-red-500">*</span></label>
                        <select name="ciudad_proveniente" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required>
                            <option value="">Seleccione...</option>
                            @foreach($ciudades as $ciudad)
                                <option value="{{ $ciudad->ciudad_cod_post }}" {{ old('ciudad_proveniente') == $ciudad->ciudad_cod_post ? 'selected' : '' }}>
                                    {{ $ciudad->ciudad_nom }} - {{ $ciudad->departamento->depar_nom ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Tipo de Correspondencia <span class="text-red-500">*</span></label>
                        <select name="id_tipo" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required>
                            <option value="">Seleccione...</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id_tipo }}" {{ old('id_tipo') == $tipo->id_tipo ? 'selected' : '' }}>
                                    {{ $tipo->tipo_nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Asunto <span class="text-red-500">*</span></label>
                        <input type="text" name="asunto" value="{{ old('asunto') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required maxlength="100" placeholder="Breve descripción del motivo del documento">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="3" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="250" placeholder="Información adicional (opcional)">{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Documento Escaneado o Digital (SOLO PDF) <span class="text-red-500">*</span></label>
                        <input type="file" name="archivo" accept=".pdf" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2 focus:ring-2 focus:ring-primary/50 outline-none cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required>
                        <p class="text-xs text-slate-500 mt-1">Formato permitido: PDF. Tamaño máximo: 10MB. Los folios se calcularán automáticamente.</p>
                    </div>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-4 mt-8 pt-4 border-t border-slate-200 dark:border-slate-700">
                <button type="reset" class="px-6 py-2.5 border border-[#cfd7e7] text-[#4c669a] rounded-lg hover:bg-slate-50 font-medium transition-colors">Limpiar</button>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 font-medium shadow flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-sm">send</span>
                    Radicar Documento
                </button>
            </div>
        </form>

        <script>
            function toggleFormularioRemitente() {
                var tipo = document.querySelector('input[name="tipo_remitente"]:checked').value;
                if (tipo === 'Empresa') {
                    document.getElementById('seccion_persona').classList.add('hidden');
                    document.getElementById('tipo_documento').removeAttribute('required');
                    document.getElementById('numero_documento').removeAttribute('required');
                    document.getElementById('nombre_persona').removeAttribute('required');
                    document.getElementById('correo_persona').removeAttribute('required');
                    
                    document.getElementById('seccion_empresa').classList.remove('hidden');
                    document.getElementById('nit_empresa_remitente').setAttribute('required', 'required');
                    document.getElementById('nombre_empresa').setAttribute('required', 'required');
                    document.getElementById('correo_empresa').setAttribute('required', 'required');
                } else {
                    document.getElementById('seccion_empresa').classList.add('hidden');
                    document.getElementById('nit_empresa_remitente').removeAttribute('required');
                    document.getElementById('nombre_empresa').removeAttribute('required');
                    document.getElementById('correo_empresa').removeAttribute('required');
                    
                    document.getElementById('seccion_persona').classList.remove('hidden');
                    document.getElementById('tipo_documento').setAttribute('required', 'required');
                    document.getElementById('numero_documento').setAttribute('required', 'required');
                    document.getElementById('nombre_persona').setAttribute('required', 'required');
                    document.getElementById('correo_persona').setAttribute('required', 'required');
                }
            }

            // Inicializar al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                toggleFormularioRemitente();
            });
        </script>

    </div>
</body>
</html>

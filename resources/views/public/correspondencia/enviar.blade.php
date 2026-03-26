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
    
    {{-- Dependencias para Validaciones y PDF.js --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    {{-- jQuery y Select2 para buscadores --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Radicación Exitosa',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#00b5a3',
                    });
                });
            </script>
        @endif
        
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Errores en el formulario',
                        html: `
                            <ul class="text-sm text-left list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        `,
                        confirmButtonColor: '#00b5a3',
                    });
                });
            </script>
        @endif

        <form action="{{ route('public.correspondencia.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="form-correspondencia">
            @csrf

            <!-- SELECCIÓN DE TIPO DE REMITENTE -->
            <input type="hidden" name="tipo_remitente" id="tipo_remitente_hidden" value="{{ old('tipo_remitente', 'Persona') }}">
            <div class="mb-2">
                <div class="flex space-x-6 border-b border-slate-200 dark:border-slate-700">
                    <button type="button" id="tabPersona" class="pb-3 text-sm font-bold text-primary border-b-2 border-primary transition-colors" onclick="activarTab('Persona')">
                        Persona Natural
                    </button>
                    <button type="button" id="tabEmpresa" class="pb-3 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors" onclick="activarTab('Empresa')">
                        Empresa / Entidad
                    </button>
                </div>
            </div>

            <!-- SECCIÓN REMITENTE: PERSONA -->
            <div id="seccion_persona" class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-lg border border-slate-100 dark:border-slate-800 block">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Información de la Persona</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Tipo de Documento <span class="text-red-500">*</span></label>
                        <select name="tipo_documento" id="tipo_documento" class="w-full rounded-lg border @error('tipo_documento') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required>
                            <option value="">Seleccione...</option>
                            <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                            <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                            <option value="PASAPORTE" {{ old('tipo_documento') == 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="OTRO" {{ old('tipo_documento') == 'OTRO' ? 'selected' : '' }}>Otro</option>
                        </select>
                        <p id="error-tipo_documento" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('tipo_documento') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Número de Documento <span class="text-red-500">*</span></label>
                        <input type="text" name="numero_documento" id="numero_documento" value="{{ old('numero_documento') }}" class="w-full rounded-lg border @error('numero_documento') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required maxlength="20" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <p id="error-numero_documento" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('numero_documento') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre_persona" id="nombre_persona" value="{{ old('nombre_persona') }}" class="w-full rounded-lg border @error('nombre_persona') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required maxlength="100" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                        <p id="error-nombre_persona" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('nombre_persona') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                        <input type="email" name="correo_persona" id="correo_persona" value="{{ old('correo_persona') }}" class="w-full rounded-lg border @error('correo_persona') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required>
                        <p id="error-correo_persona" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('correo_persona') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Teléfono</label>
                        <input type="text" name="tel_persona" id="tel_persona" value="{{ old('tel_persona') }}" class="w-full rounded-lg border @error('tel_persona') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="25" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9\+]/g, '')">
                        <p id="error-tel_persona" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('tel_persona') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- SECCIÓN REMITENTE: EMPRESA -->
            <div id="seccion_empresa" class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-lg border border-slate-100 dark:border-slate-800 hidden">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Información de la Empresa</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">NIT <span class="text-red-500">*</span></label>
                        <input type="text" name="nit_empresa_remitente" id="nit_empresa_remitente" value="{{ old('nit_empresa_remitente') }}" class="w-full rounded-lg border @error('nit_empresa_remitente') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="20" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9\-]/g, '')">
                        <p id="error-nit_empresa_remitente" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('nit_empresa_remitente') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Radicado Externo de la Empresa <span class="text-red-500">*</span></label>
                        <input type="text" name="radicado_empresa" id="radicado_empresa" value="{{ old('radicado_empresa') }}" class="w-full rounded-lg border @error('radicado_empresa') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none uppercase" maxlength="100" required placeholder="Ej: EXT-2026-00123">
                        <p class="text-xs text-slate-500 mt-1">Número de radicado interno que asignó su empresa a este documento.</p>
                        @error('radicado_empresa') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Razón Social o Nombre de la Empresa <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre_empresa" id="nombre_empresa" value="{{ old('nombre_empresa') }}" class="w-full rounded-lg border @error('nombre_empresa') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="100">
                        <p id="error-nombre_empresa" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('nombre_empresa') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Correo Electrónico de Contacto <span class="text-red-500">*</span></label>
                        <input type="email" name="correo_empresa" id="correo_empresa" value="{{ old('correo_empresa') }}" class="w-full rounded-lg border @error('correo_empresa') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none">
                        <p id="error-correo_empresa" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('correo_empresa') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Teléfono</label>
                        <input type="text" name="tel_empresa" id="tel_empresa" value="{{ old('tel_empresa') }}" class="w-full rounded-lg border @error('tel_empresa') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="25" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9\+]/g, '')">
                        <p id="error-tel_empresa" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('tel_empresa') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- SECCIÓN DOCUMENTO -->
            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-lg border border-slate-100 dark:border-slate-800">
                <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Detalles de la Correspondencia</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 relative" id="empresa-destino-wrapper">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Empresa de Destino <span class="text-red-500">*</span></label>
                        
                        <!-- Input oculto que pasa el valor seleccionado al backend -->
                        <input type="hidden" name="empresa_destino" id="empresa_destino_value" value="{{ old('empresa_destino') }}" required>
                        
                        <!-- Botón simulador de Select + botón X para limpiar -->
                        <div class="flex items-center gap-2">
                            <button type="button" id="btnToggleEmpresas" class="flex-1 flex items-center justify-between rounded-lg border @error('empresa_destino') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-left p-2.5 focus:ring-2 focus:ring-primary/50 outline-none transition-colors group">
                                <span id="btnToggleEmpresasLabel" class="block truncate {{ old('empresa_destino') ? 'text-slate-900 dark:text-white' : 'text-slate-400 dark:text-gray-400' }}">
                                    @if(old('empresa_destino'))
                                        @php
                                            $oldEmp = $empresas->firstWhere('nit_empresa', old('empresa_destino'));
                                        @endphp
                                        {{ $oldEmp ? $oldEmp->nit_empresa . ' - ' . $oldEmp->nomb_empresa : 'Buscar y seleccionar empresa...' }}
                                    @else
                                        Buscar y seleccionar empresa...
                                    @endif
                                </span>
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors pointer-events-none">expand_content</span>
                            </button>
                            <!-- Botón X para limpiar la empresa seleccionada -->
                            <button type="button" id="btnClearEmpresa"
                                class="{{ old('empresa_destino') ? '' : 'hidden' }} flex-shrink-0 p-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-400 hover:text-red-500 hover:border-red-300 transition-colors"
                                title="Limpiar empresa seleccionada">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>
                        </div>
                        
                        <!-- Dropdown (Lista y Buscador) -->
                        <div id="empresasDropdown" class="hidden absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden">
                            <div class="p-2 border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 sticky top-0">
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                                    <input type="text" id="buscarEmpresaInput" class="w-full text-sm rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white pl-9 pr-3 py-2 outline-none focus:ring-2 focus:ring-blue-500 max-h-12" placeholder="Escriba el NIT o nombre para buscar...">
                                </div>
                            </div>
                            <!-- Contenedor scrolleable de resultados -->
                            <ul id="listaEmpresas" class="max-h-60 overflow-y-auto text-sm text-slate-700 dark:text-slate-300">
                                <!-- Llenado por JavaScript -->
                            </ul>
                        </div>
                        
                        <p class="text-xs text-slate-500 mt-1">Seleccione la entidad hacia la cual va dirigida la correspondencia.</p>
                        @error('empresa_destino') <p class="text-xs text-red-500 mt-1" id="error_empresa">{{ $message }}</p> @enderror
                    </div>

                    <div class="relative" id="ciudad-proveniente-wrapper">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Ciudad de Origen <span class="text-red-500">*</span></label>
                        <select name="ciudad_proveniente" id="ciudad_proveniente_value" class="w-full rounded-lg border @error('ciudad_proveniente') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none select2-ciudad-public" required>
                            <option value="">Seleccione Ciudad...</option>
                            @foreach($ciudades as $ciudad)
                                <option value="{{ $ciudad->ciudad_cod_post }}" {{ old('ciudad_proveniente') == $ciudad->ciudad_cod_post ? 'selected' : '' }}>
                                    {{ $ciudad->ciudad_nom }} - {{ $ciudad->departamento->depar_nom ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('ciudad_proveniente') <p class="text-xs text-red-500 mt-1" id="error_ciudad">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Tipo de Correspondencia <span class="text-red-500">*</span></label>
                        <select name="id_tipo" id="id_tipo" class="w-full rounded-lg border @error('id_tipo') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none select2-tipo-public" required>
                            <option value="">Seleccione...</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id_tipo }}" {{ old('id_tipo') == $tipo->id_tipo ? 'selected' : '' }}>
                                    {{ $tipo->tipo_nombre }}
                                </option>
                            @endforeach
                        </select>
                        <p id="error-id_tipo" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('id_tipo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Asunto <span class="text-red-500">*</span></label>
                        <input type="text" name="asunto" id="asunto" value="{{ old('asunto') }}" class="w-full rounded-lg border @error('asunto') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" required maxlength="100" placeholder="Breve descripción del motivo del documento">
                        <p id="error-asunto" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('asunto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="w-full rounded-lg border @error('observaciones') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 p-2.5 focus:ring-2 focus:ring-primary/50 outline-none" maxlength="250" placeholder="Información adicional (opcional)">{{ old('observaciones') }}</textarea>
                        <p id="error-observaciones" class="text-sm text-red-600 mt-1 hidden"></p>
                        @error('observaciones') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Documento Principal Escaneado (SOLO PDF) <span class="text-red-500">*</span></label>
                                <input type="file" name="archivo" id="archivoPrincipal" accept=".pdf" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer border @error('archivo') border-red-500 @else border-[#cfd7e7] dark:border-slate-700 @enderror bg-white dark:bg-slate-800" required>
                                <p class="text-xs text-slate-500 mt-1 pl-1">Formato permitido: PDF. Tamaño máximo: <strong>5 MB</strong>.</p>
                                @error('archivo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                
                                <div class="mt-4 border-t border-slate-200 dark:border-slate-700 pt-3">
                                    <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Anexo Adicional (Opcional, máx. 1)</label>
                                    <input type="file" name="anexos[]" id="archivosAnexos" accept=".pdf" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 dark:file:bg-slate-700 dark:file:text-white dark:hover:file:bg-slate-600 file:cursor-pointer cursor-pointer border border-[#cfd7e7] dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800">
                                    <p class="text-xs text-slate-500 mt-1 pl-1 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">info</span> 1 archivo PDF, máximo <strong>25 MB</strong>.</p>
                                    
                                    <!-- Contenedor visual para el anexo seleccionado -->
                                    <div id="listaAnexosVisual" class="mt-3 space-y-2"></div>
                                    
                                    @error('anexos') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    @error('anexos.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            
                            <div class="md:col-span-1">
                                <label class="flex flex-col">
                                    <p class="text-[#0d121b] dark:text-gray-200 text-sm font-medium leading-normal pb-1">
                                        Total Folios
                                    </p>
                                    <div class="relative">
                                        <input type="text" name="folio" id="inputFolios" readonly
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-[#0d121b] dark:text-white border border-[#cfd7e7] dark:border-slate-700 bg-slate-100 dark:bg-slate-700/50 h-[42px] px-3.5 text-base font-semibold text-center cursor-not-allowed select-none"
                                            placeholder="—" />
                                        <span id="foliosSpinner"
                                            class="hidden absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined animate-spin text-primary text-lg">progress_activity</span>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-500 pl-1">Se calculan automáticamente al subir su archivo PDF.</p>
                                </label>
                            </div>
                        </div>
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
            // Configurar PDF.js worker
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            function activarTab(tipo) {
                const tabPersona = document.getElementById('tabPersona');
                const tabEmpresa = document.getElementById('tabEmpresa');
                const seccionPersona = document.getElementById('seccion_persona');
                const seccionEmpresa = document.getElementById('seccion_empresa');
                const hiddenInput = document.getElementById('tipo_remitente_hidden');

                if (tipo === 'Empresa') {
                    // Estilos de Tab
                    tabEmpresa.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                    tabEmpresa.classList.remove('font-medium', 'text-slate-500', 'dark:text-slate-400');
                    tabPersona.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                    tabPersona.classList.add('font-medium', 'text-slate-500', 'dark:text-slate-400');

                    // Mostrar/Ocultar
                    seccionPersona.classList.add('hidden');
                    seccionEmpresa.classList.remove('hidden');

                    // Required
                    document.getElementById('tipo_documento').removeAttribute('required');
                    document.getElementById('numero_documento').removeAttribute('required');
                    document.getElementById('nombre_persona').removeAttribute('required');
                    document.getElementById('correo_persona').removeAttribute('required');
                    
                    document.getElementById('nit_empresa_remitente').setAttribute('required', 'required');
                    document.getElementById('nombre_empresa').setAttribute('required', 'required');
                    document.getElementById('correo_empresa').setAttribute('required', 'required');
                    document.getElementById('radicado_empresa').setAttribute('required', 'required');

                    hiddenInput.value = 'Empresa';
                } else {
                    // Estilos de Tab
                    tabPersona.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                    tabPersona.classList.remove('font-medium', 'text-slate-500', 'dark:text-slate-400');
                    tabEmpresa.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                    tabEmpresa.classList.add('font-medium', 'text-slate-500', 'dark:text-slate-400');

                    // Mostrar/Ocultar
                    seccionEmpresa.classList.add('hidden');
                    seccionPersona.classList.remove('hidden');

                    // Required
                    document.getElementById('nit_empresa_remitente').removeAttribute('required');
                    document.getElementById('nombre_empresa').removeAttribute('required');
                    document.getElementById('correo_empresa').removeAttribute('required');
                    document.getElementById('radicado_empresa').removeAttribute('required');
                    
                    document.getElementById('tipo_documento').setAttribute('required', 'required');
                    document.getElementById('numero_documento').setAttribute('required', 'required');
                    document.getElementById('nombre_persona').setAttribute('required', 'required');
                    document.getElementById('correo_persona').setAttribute('required', 'required');

                    hiddenInput.value = 'Persona';
                }

                // Limpiar posibles errores visuales al cambiar de tab
                document.querySelectorAll('.border-red-500').forEach(el => {
                    el.classList.remove('border-red-500');
                    el.classList.add('border-[#cfd7e7]', 'dark:border-slate-700');
                });
                document.querySelectorAll('p[id^="error-"]').forEach(el => el.classList.add('hidden'));
            }

            // Inicializar al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                const initialType = document.getElementById('tipo_remitente_hidden').value;
                activarTab(initialType);

                const spinner = document.getElementById('foliosSpinner');
                const inputFolios = document.getElementById('inputFolios');
                let paginasPrincipal = 0;
                let paginasAnexos = 0;

                const contarPaginas = async (file) => {
                    if (!file || file.type !== 'application/pdf') return 0;
                    try {
                        const buf = await file.arrayBuffer();
                        const pdfDocument = await pdfjsLib.getDocument({ data: buf }).promise;
                        return pdfDocument.numPages;
                    } catch (err) {
                        console.error('[PDF.js] Error al leer:', err);
                        return 0;
                    }
                };

                const actualizarTotalFolios = () => {
                    const total = paginasPrincipal + paginasAnexos;
                    inputFolios.value = total > 0 ? total : '';
                };

                // ----- 1. Buscador Ciudad de Origen -----
                const TODAS_CIUDADES = @json($ciudades);
                const btnToggleCiudades = document.getElementById('btnToggleCiudades');
                const dropdownCiudades = document.getElementById('ciudadesDropdown');
                const inputBuscarCiudad = document.getElementById('buscarCiudadInput');
                const listaCiudadesEl = document.getElementById('listaCiudades');
                const hiddenCiudad = document.getElementById('ciudad_proveniente_value');
                const labelBtnCiudad = document.getElementById('btnToggleCiudadesLabel');

                function renderCiudades(ciudadesMostrar) {
                    listaCiudadesEl.innerHTML = '';
                    if (ciudadesMostrar.length === 0) {
                        listaCiudadesEl.innerHTML = '<li class="px-3 py-2 text-slate-400 italic">Sin resultados</li>';
                        return;
                    }
                    const totalMostrados = Math.min(ciudadesMostrar.length, 50);

                    for (let i = 0; i < totalMostrados; i++) {
                        const ciudad = ciudadesMostrar[i];
                        const li = document.createElement('li');
                        li.className = 'px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer flex flex-col gap-0.5 border-b border-slate-50 dark:border-slate-700/50 last:border-0';
                        const deptoText = ciudad.departamento && ciudad.departamento.depar_nom ? ciudad.departamento.depar_nom : 'N/A';

                        li.innerHTML = `
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-slate-400">location_city</span>
                                <span>
                                    <span class="font-mono text-xs text-slate-500">${ciudad.ciudad_cod_post}</span> — ${ciudad.ciudad_nom}
                                </span>
                            </div>
                            <div class="text-[10px] text-slate-400 font-medium pl-6">Dpto: ${deptoText}</div>
                        `;

                        li.addEventListener('click', function() {
                            hiddenCiudad.value = ciudad.ciudad_cod_post;
                            labelBtnCiudad.textContent = ciudad.ciudad_nom;
                            labelBtnCiudad.classList.remove('text-slate-400');
                            labelBtnCiudad.classList.add('text-slate-900', 'dark:text-white', 'font-medium');
                            dropdownCiudades.classList.add('hidden');
                            inputBuscarCiudad.value = '';
                            renderCiudades(TODAS_CIUDADES);

                            // Validar cambio
                            validarCampoEspecial('ciudad_proveniente', true);
                        });
                        listaCiudadesEl.appendChild(li);
                    }
                }

                renderCiudades(TODAS_CIUDADES);

                btnToggleCiudades.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownCiudades.classList.toggle('hidden');
                    if (!dropdownCiudades.classList.contains('hidden')) {
                        inputBuscarCiudad.focus();
                    }
                });

                inputBuscarCiudad.addEventListener('input', function() {
                    const q = this.value.trim().toLowerCase();
                    if (q.length === 0) {
                        renderCiudades(TODAS_CIUDADES);
                        return;
                    }
                    const filtradas = TODAS_CIUDADES.filter(c => {
                        return String(c.ciudad_cod_post).toLowerCase().includes(q) || 
                               String(c.ciudad_nom).toLowerCase().includes(q) ||
                               (c.departamento && String(c.departamento.depar_nom).toLowerCase().includes(q));
                    });
                    renderCiudades(filtradas);
                });

                // ----- 2. Buscador Empresa Destino Strict -----
                const TODAS_EMPRESAS = @json($empresas);
                const btnToggleEmpresas = document.getElementById('btnToggleEmpresas');
                const dropdownEmpresas = document.getElementById('empresasDropdown');
                const inputBuscarEmpresa = document.getElementById('buscarEmpresaInput');
                const listaEmpresasEl = document.getElementById('listaEmpresas');
                const hiddenEmpresa = document.getElementById('empresa_destino_value');
                const labelBtnEmpresa = document.getElementById('btnToggleEmpresasLabel');
                const errorEmpresa = document.getElementById('error_empresa');

                function renderEmpresas(empresasMostrar, isSearching = false) {
                    listaEmpresasEl.innerHTML = '';
                    if (!isSearching) {
                        listaEmpresasEl.innerHTML = '<li class="px-3 py-4 text-slate-500 text-center text-sm font-medium">Escriba el NIT o el Nombre completo para buscar...</li>';
                        return;
                    }
                    if (empresasMostrar.length === 0) {
                        listaEmpresasEl.innerHTML = '<li class="px-3 py-3 text-slate-400 italic text-sm text-center">No se encontraron empresas.</li>';
                        return;
                    }
                    const totalMostrados = Math.min(empresasMostrar.length, 50);

                    for (let i = 0; i < totalMostrados; i++) {
                        const emp = empresasMostrar[i];
                        const li = document.createElement('li');
                        li.className = 'px-3 py-2.5 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer flex flex-col gap-0.5 border-b border-slate-50 dark:border-slate-700/50 last:border-0';
                        li.innerHTML = `
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-sm text-slate-400 mt-0.5">business</span>
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-slate-700 dark:text-slate-200 truncate">${emp.nomb_empresa}</div>
                                    <div class="text-xs text-blue-600 dark:text-blue-400 font-mono mt-0.5">NIT: ${emp.nit_empresa}</div>
                                </div>
                            </div>
                        `;

                        li.addEventListener('click', function() {
                            hiddenEmpresa.value = emp.nit_empresa;
                            labelBtnEmpresa.textContent = emp.nit_empresa + ' - ' + emp.nomb_empresa;
                            labelBtnEmpresa.classList.remove('text-slate-400');
                            labelBtnEmpresa.classList.add('text-slate-900', 'dark:text-white', 'font-medium');
                            dropdownEmpresas.classList.add('hidden');
                            inputBuscarEmpresa.value = '';
                            validarCampoEspecial('empresa_destino', true);
                            renderEmpresas([], false);
                            // Mostrar botón X
                            const xBtn = document.getElementById('btnClearEmpresa');
                            if (xBtn) xBtn.classList.remove('hidden');
                        });
                        listaEmpresasEl.appendChild(li);
                    }
                }

                btnToggleEmpresas.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownEmpresas.classList.toggle('hidden');
                    if (!dropdownEmpresas.classList.contains('hidden') && inputBuscarEmpresa.value.trim() === '') {
                        renderEmpresas([], false);
                        inputBuscarEmpresa.focus();
                    }
                });

                inputBuscarEmpresa.addEventListener('input', function() {
                    const q = this.value.trim().toLowerCase();
                    if (q.length === 0) { renderEmpresas([], false); return; }
                    const filtradas = TODAS_EMPRESAS.filter(c => String(c.nit_empresa).toLowerCase().includes(q) || String(c.nomb_empresa).toLowerCase().includes(q));
                    renderEmpresas(filtradas, true);
                });

                document.addEventListener('click', function(e) {
                    if (!document.getElementById('empresa-destino-wrapper').contains(e.target)) dropdownEmpresas.classList.add('hidden');
                    if (!dropdownCiudades.classList.contains('hidden') && !document.getElementById('ciudad-proveniente-wrapper').contains(e.target)) dropdownCiudades.classList.add('hidden');
                });

                // Botón X: limpiar empresa seleccionada
                const btnClearEmpresa = document.getElementById('btnClearEmpresa');
                if (btnClearEmpresa) {
                    btnClearEmpresa.addEventListener('click', function(e) {
                        e.stopPropagation();
                        hiddenEmpresa.value = '';
                        const label = document.getElementById('btnToggleEmpresasLabel');
                        if (label) {
                            label.textContent = 'Buscar y seleccionar empresa...';
                            label.className = label.className.replace('text-slate-900 dark:text-white', 'text-slate-400 dark:text-gray-400');
                        }
                        btnClearEmpresa.classList.add('hidden');
                        // Reset search box
                        const buscar = document.getElementById('buscarEmpresaInput');
                        if (buscar) buscar.value = '';
                    });
                }

                // ----- 3. Gestión Visual de Anexos -----
                const inputPrincipal = document.getElementById('archivoPrincipal');
                const inputAnexos = document.getElementById('archivosAnexos');
                const visualList = document.getElementById('listaAnexosVisual');
                let listaArchivosAnexos = [];

                if (inputPrincipal) {
                    inputPrincipal.addEventListener('change', async (e) => {
                        const file = e.target.files[0];
                        spinner.classList.remove('hidden');
                        paginasPrincipal = file ? await contarPaginas(file) : 0;
                        actualizarTotalFolios();
                        spinner.classList.add('hidden');
                        validarCampoEspecial('archivoPrincipal', !!file);
                    });
                }

                const renderAnexosVisual = async () => {
                    spinner.classList.remove('hidden');
                    visualList.innerHTML = '';
                    let tempPags = 0;

                    for (let i = 0; i < listaArchivosAnexos.length; i++) {
                        const file = listaArchivosAnexos[i];
                        const pages = await contarPaginas(file);
                        tempPags += pages;

                        const div = document.createElement('div');
                        div.className = 'flex items-center justify-between p-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md text-xs';
                        div.innerHTML = `
                            <div class="flex items-center gap-1 min-w-0">
                                <span class="material-symbols-outlined text-sm text-red-500">picture_as_pdf</span>
                                <span class="truncate font-medium">${file.name}</span>
                                <span class="text-slate-400">(${pages} pág.)</span>
                            </div>
                            <button type="button" class="text-red-500 hover:text-red-700 font-bold p-1 flex items-center" onclick="window.removerAnexo(${i})">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        `;
                        visualList.appendChild(div);
                    }

                    paginasAnexos = tempPags;
                    actualizarTotalFolios();
                    spinner.classList.add('hidden');

                    const dt = new DataTransfer();
                    listaArchivosAnexos.forEach(f => dt.items.add(f));
                    inputAnexos.files = dt.files;
                };

                window.removerAnexo = (index) => {
                    listaArchivosAnexos.splice(index, 1);
                    renderAnexosVisual();
                };

                if (inputAnexos) {
                    inputAnexos.addEventListener('change', async (e) => {
                        // Solo aceptamos 1 archivo
                        const files = Array.from(e.target.files).filter(f => f.type === 'application/pdf').slice(0, 1);
                        listaArchivosAnexos = files; // Reemplaza completamente (no acumula)
                        await renderAnexosVisual();
                        inputAnexos.value = ''; // Reset so change triggers again if needed
                    });
                }
                // ----- 4. Validaciones En Vivo -----
                const reglasCrear = {
                    tipo_documento: {
                        required: true,
                        error: 'error-tipo_documento',
                        mensajes: { required: 'Debe seleccionar un tipo de documento.' }
                    },
                    numero_documento: {
                        required: true, min: 6, max: 10, regex: /^[0-9]+$/,
                        custom: function(valor) { return !/^(\d)\1+$/.test(valor); },
                        error: 'error-numero_documento',
                        mensajes: { required: 'El documento es obligatorio.', min: 'Mínimo 6 dígitos.', max: 'Máximo 10 dígitos.', regex: 'Solo números.', custom: 'Evite números repetidos.' }
                    },
                    nombre_persona: {
                        required: true, min: 3, max: 100, regex: /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/,
                        custom: function(valor) { return valor.trim().split(/\s+/).length >= 1; },
                        error: 'error-nombre_persona',
                        mensajes: { required: 'El nombre es obligatorio.', min: 'Debe tener al menos 3 letras.', max: 'Máximo 100 caracteres.', regex: 'Solo letras y tildes.', custom: 'Escriba su nombre completo.' }
                    },
                    correo_persona: {
                        required: true, regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                        error: 'error-correo_persona',
                        mensajes: { required: 'El correo es obligatorio.', regex: 'Formato inválido.' }
                    },
                    tel_persona: {
                        required: false, min: 7, max: 12, regex: /^[0-9]+$/,
                        error: 'error-tel_persona',
                        mensajes: { min: 'Mínimo 7 dígitos.', max: 'Máximo 12 dígitos.', regex: 'Solo números.' }
                    },
                    nit_empresa_remitente: {
                        required: true, min: 7, max: 15, regex: /^[0-9\-]+$/,
                        error: 'error-nit_empresa_remitente',
                        mensajes: { required: 'El NIT es obligatorio.', min: 'Mínimo 7 caracteres.', max: 'Máximo 15 caracteres.', regex: 'Formato NIT inválido.' }
                    },
                    nombre_empresa: {
                        required: true, min: 3, max: 100,
                        error: 'error-nombre_empresa',
                        mensajes: { required: 'El nombre es obligatorio.', min: 'Mínimo 3 letras.', max: 'Máximo 100 caracteres.' }
                    },
                    correo_empresa: {
                        required: true, regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                        error: 'error-correo_empresa',
                        mensajes: { required: 'El correo es obligatorio.', regex: 'Formato inválido.' }
                    },
                    tel_empresa: {
                        required: false, min: 7, max: 12, regex: /^[0-9]+$/,
                        error: 'error-tel_empresa',
                        mensajes: { min: 'Mínimo 7 dígitos.', max: 'Máximo 12 dígitos.', regex: 'Solo números.' }
                    },
                    asunto: {
                        required: true, min: 5, max: 100,
                        error: 'error-asunto',
                        mensajes: { required: 'El asunto es obligatorio.', min: 'Mínimo 5 letras.', max: 'Máximo 100 caracteres.' }
                    },
                    id_tipo: {
                        required: true,
                        error: 'error-id_tipo',
                        mensajes: { required: 'Seleccione un tipo de correspondencia.' }
                    },
                    observaciones: {
                        max: 250,
                        error: 'error-observaciones',
                        mensajes: { max: 'Máximo 250 caracteres.' }
                    }
                };

                let camposTocados = {};

                Object.keys(reglasCrear).forEach(id => {
                    const input = document.getElementById(id);
                    if (!input) return;

                    input.addEventListener('input', () => {
                        camposTocados[id] = true;
                        validarCampoIndividual(id);
                    });
                    input.addEventListener('blur', () => {
                        camposTocados[id] = true;
                        validarCampoIndividual(id);
                    });
                });

                function validarCampoIndividual(id) {
                    const input = document.getElementById(id);
                    const regla = reglasCrear[id];
                    if (!input || !regla) return true;

                    if (input.closest('.hidden')) return true;

                    const error = document.getElementById(regla.error);
                    const valor = input.value.trim();

                    if (!camposTocados[id] && valor === '') return true; // Evitar error inicial

                    input.classList.remove('border-red-500', 'border-green-500', 'border-[#cfd7e7]', 'dark:border-slate-700');
                    if (error) error.classList.add('hidden');

                    let errorTexto = '';

                    if (regla.required && valor === '') {
                        errorTexto = regla.mensajes.required;
                    } else if (regla.min && valor.length < regla.min) {
                        errorTexto = regla.mensajes.min;
                    } else if (regla.max && valor.length > regla.max) {
                        errorTexto = regla.mensajes.max;
                    } else if (regla.regex && !regla.regex.test(valor)) {
                        errorTexto = regla.mensajes.regex;
                    } else if (regla.custom && !regla.custom(valor)) {
                        errorTexto = regla.mensajes.custom;
                    }

                    if (errorTexto) {
                        if (regla.required || valor !== '') {
                            input.classList.add('border-red-500');
                            if (error) {
                                error.textContent = errorTexto;
                                error.classList.remove('hidden');
                            }
                            return false;
                        }
                    } else if (valor !== '') {
                        input.classList.add('border-green-500');
                    } else {
                        input.classList.add('border-[#cfd7e7]', 'dark:border-slate-700');
                    }

                    return true;
                }

                function validarCampoEspecial(tipo, valido) {
                    const wrapper = document.getElementById(tipo === 'empresa_destino' ? 'empresa-destino-wrapper' : 
                                                          (tipo === 'ciudad_proveniente' ? 'ciudad-proveniente-wrapper' : ''));
                    const btn = tipo === 'archivoPrincipal' ? inputPrincipal : (wrapper ? wrapper.querySelector('button') : null);

                    if (!btn) return;

                    btn.classList.remove('border-red-500', 'border-green-500', 'border-[#cfd7e7]', 'dark:border-slate-700');
                    if (valido) btn.classList.add('border-green-500');
                    else btn.classList.add('border-red-500');
                }

                // El tipo de remitente se maneja mediante tabs y activarTab()

                document.getElementById('form-correspondencia').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    let formValido = true;

                    // Marcar todos como tocados para forzar validación
                    Object.keys(reglasCrear).forEach(id => { camposTocados[id] = true; });

                    // Validar campos de texto normales activos
                    Object.keys(reglasCrear).forEach(id => {
                        const input = document.getElementById(id);
                        if (input && !input.closest('.hidden')) {
                            const v = validarCampoIndividual(id);
                            if (reglasCrear[id].required && !v) formValido = false;
                        }
                    });

                    // Validar Especiales
                    if (!hiddenCiudad.value) { validarCampoEspecial('ciudad_proveniente', false); formValido = false; }
                    if (!hiddenEmpresa.value) { validarCampoEspecial('empresa_destino', false); formValido = false; }
                    if (!inputPrincipal.files.length) { validarCampoEspecial('archivoPrincipal', false); formValido = false; }

                    if (!formValido) {
                        Swal.fire({
                            title: 'Errores en el formulario',
                            text: "Por favor, complete todos los campos marcados en rojo correctamente.",
                            icon: 'warning',
                            confirmButtonColor: '#e3342f',
                            confirmButtonText: 'Revisar'
                        });
                        return;
                    }

                    // Validar Archivos Client-Side (Tamaño)
                    if (inputPrincipal.files.length > 0) {
                        const file = inputPrincipal.files[0];
                        if (file.size > 5 * 1024 * 1024) {
                            Swal.fire({ icon: 'error', title: 'Archivo Principal muy grande', text: 'El archivo principal no puede superar los 5MB.', confirmButtonColor: '#dc2626' });
                            return;
                        }
                    }

                    if (listaArchivosAnexos.length > 0) {
                        for (let f of listaArchivosAnexos) {
                            if (f.size > 25 * 1024 * 1024) {
                                Swal.fire({ icon: 'error', title: 'Anexo muy grande', text: `El anexo "${f.name}" supera los 25 MB.`, confirmButtonColor: '#dc2626' });
                                return;
                            }
                        }
                    }
                    
                    Swal.fire({
                        title: '¿Confirmar Radicación?',
                        text: "Verifique que todos los datos, destinos y documentos adjuntos sean correctos antes de radicar el documento definitivamente.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00b5a3',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: 'Sí, radicar documento',
                        cancelButtonText: 'Revisar nuevamente'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Asegurar que el input de anexos tenga todos los archivos antes de enviar
                            const dt = new DataTransfer();
                            listaArchivosAnexos.forEach(f => dt.items.add(f));
                            inputAnexos.files = dt.files;

                            Swal.fire({ title: 'Procesando...', text: 'Registrando correspondencia, por favor espere.', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                            document.getElementById('form-correspondencia').submit();
                        }
                    });
                });

                // Initialize Select2 in a Tailwind-friendly way
                if (typeof jQuery !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
                    $('.select2-tipo-public').select2({
                        placeholder: "Buscar tipo de correspondencia...",
                        allowClear: true,
                        width: '100%',
                    });
                    $('.select2-ciudad-public').select2({
                        placeholder: "Seleccione Ciudad...",
                        allowClear: true,
                        width: '100%',
                    });
                    
                    // Style Select2 to match Tailwind input boxes
                    $('.select2-container--default .select2-selection--single').css({
                        'height': '46px',
                        'padding': '8px',
                        'border': '1px solid #cfd7e7',
                        'border-radius': '0.5rem',
                        'display': 'flex',
                        'align-items': 'center'
                    });
                    $('.select2-selection__arrow').css('top', '9px');
                }

            });
        </script>

    </div>
</body>
</html>

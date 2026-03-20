<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Consultar Estado de Correspondencia - Sistema de Gestión</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-display bg-background-light dark:bg-background-dark min-h-screen py-10 px-4 flex items-center justify-center">
    <div class="w-full max-w-2xl bg-white dark:bg-slate-900 rounded-xl shadow-lg sm:p-10 p-6">
        <a href="{{ route('public.correspondencia.enviar') }}" class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline mb-6">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Volver a inicio
        </a>

        <div class="mb-8 text-center sm:text-left flex flex-col sm:flex-row items-center sm:items-start gap-4">
            <div class="bg-primary/10 p-3 rounded-full text-primary hidden sm:block">
                <span class="material-symbols-outlined text-4xl">search</span>
            </div>
            <div>
                <h1 class="text-3xl font-black text-[#0d121b] dark:text-gray-100">Consultar Estado</h1>
                <p class="text-[#4c669a] dark:text-gray-400 mt-2">
                    Ingrese el número de radicado asignado y su documento de identidad para verificar el estado de su trámite.
                </p>
            </div>
        </div>

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en la consulta',
                        html: `
                            <ul class="text-sm text-center">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        `,
                        confirmButtonColor: '#135bec',
                    });
                });
            </script>
        @endif

        <form action="{{ route('public.correspondencia.buscar') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Selector de Tipo de Remitente -->
            <div>
                <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-2">Busca como:</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer bg-slate-50 dark:bg-slate-800/50 p-3 rounded-lg border border-slate-200 dark:border-slate-700 flex-1 hover:bg-slate-100 transition">
                        <input type="radio" name="tipo_remitente" value="Persona" class="text-primary focus:ring-primary w-4 h-4" checked onchange="toggleBusquedaTipo()">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Persona</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer bg-slate-50 dark:bg-slate-800/50 p-3 rounded-lg border border-slate-200 dark:border-slate-700 flex-1 hover:bg-slate-100 transition">
                        <input type="radio" name="tipo_remitente" value="Empresa" class="text-primary focus:ring-primary w-4 h-4" {{ old('tipo_remitente') == 'Empresa' ? 'checked' : '' }} onchange="toggleBusquedaTipo()">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Empresa</span>
                    </label>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Número de Radicado</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <span class="material-symbols-outlined text-xl">tag</span>
                    </span>
                    <input type="text" name="numero_radicado" value="{{ old('numero_radicado') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 pl-10 p-3 focus:ring-2 focus:ring-primary/50 outline-none uppercase" required placeholder="Ej: EXT-2026-00001">
                </div>
            </div>

            <div id="campo_documento_persona" class="{{ old('tipo_remitente') == 'Empresa' ? 'hidden' : 'block' }}">
                <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">Número de Documento del Remitente</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <span class="material-symbols-outlined text-xl">badge</span>
                    </span>
                    <input type="text" id="input_documento" name="numero_documento" value="{{ old('numero_documento') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 pl-10 p-3 focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Sin puntos ni espacios">
                </div>
            </div>

            <div id="campo_documento_empresa" class="{{ old('tipo_remitente') == 'Empresa' ? 'block' : 'hidden' }}">
                <label class="block text-sm font-medium text-[#0d121b] dark:text-gray-200 mb-1">NIT de la Empresa</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <span class="material-symbols-outlined text-xl">apartment</span>
                    </span>
                    <input type="text" id="input_nit" name="nit_empresa_remitente" value="{{ old('nit_empresa_remitente') }}" class="w-full rounded-lg border border-[#cfd7e7] dark:border-slate-700 bg-white dark:bg-slate-800 text-[#0d121b] dark:text-gray-100 pl-10 p-3 focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Sin puntos ni guiones">
                </div>
            </div>

            <button type="submit" class="w-full rounded-lg bg-primary text-white font-bold py-3 hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/30 transition-colors flex justify-center items-center gap-2">
                <span class="material-symbols-outlined text-base">search</span>
                Consultar Correspondencia
            </button>
        </form>

        <script>
            function toggleBusquedaTipo() {
                var tipo = document.querySelector('input[name="tipo_remitente"]:checked').value;
                if (tipo === 'Empresa') {
                    document.getElementById('campo_documento_persona').classList.add('hidden');
                    document.getElementById('input_documento').removeAttribute('required');
                    
                    document.getElementById('campo_documento_empresa').classList.remove('hidden');
                    document.getElementById('input_nit').setAttribute('required', 'required');
                } else {
                    document.getElementById('campo_documento_empresa').classList.add('hidden');
                    document.getElementById('input_nit').removeAttribute('required');
                    
                    document.getElementById('campo_documento_persona').classList.remove('hidden');
                    document.getElementById('input_documento').setAttribute('required', 'required');
                }
            }
            
            // Inicializar al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                toggleBusquedaTipo();
            });
        </script>

        @if(isset($resultado))
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4">Resultados de la Búsqueda</h3>
                
                <div class="bg-blue-50/50 dark:bg-slate-800 p-5 rounded-lg border border-blue-100 dark:border-slate-700 space-y-4 text-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                        <span class="material-symbols-outlined text-8xl text-primary">description</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 font-medium">Radicado</p>
                            <p class="text-[#0d121b] dark:text-gray-100 font-bold text-base">{{ $resultado->radicado->num_radicado }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 font-medium">Estado del trámite</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ stripos($resultado->estado->estado_nomb, 'finalizado') !== false ? 'bg-green-100 text-green-800' : (stripos($resultado->estado->estado_nomb, 'rechazado') !== false ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $resultado->estado->estado_nomb }}
                            </span>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-slate-500 dark:text-slate-400 font-medium">Asunto</p>
                            <p class="text-[#0d121b] dark:text-gray-100">{{ $resultado->asunto }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-slate-500 dark:text-slate-400 font-medium">Tipo de Correspondencia</p>
                            <p class="text-[#0d121b] dark:text-gray-100">{{ $resultado->tipo->tipo_nombre }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 font-medium">Fecha de Recepción</p>
                            <p class="text-[#0d121b] dark:text-gray-100">{{ \Carbon\Carbon::parse($resultado->fecha_hora_recib)->format('d/m/Y h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Sección de Documentos de Respuesta --}}
                    @if($resultado->detalles && $resultado->detalles->count() > 0)
                        <div class="mt-4 pt-4 border-t border-blue-100 dark:border-slate-700 relative z-10">
                            <h4 class="text-sm font-bold text-primary dark:text-blue-400 mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">task</span>
                                Documentos de Respuesta
                            </h4>
                            <div class="space-y-3">
                                @foreach($resultado->detalles as $detalle)
                                    @if($detalle->archivo_res)
                                        <div class="flex items-center justify-between bg-white dark:bg-slate-900/50 p-3 rounded-xl border border-blue-100 dark:border-slate-700">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-emerald-500">description</span>
                                                <div class="flex flex-col">
                                                    <p class="text-[11px] font-bold text-slate-700 dark:text-slate-300 leading-none">Respuesta Oficial</p>
                                                    <p class="text-[9px] text-slate-500 mt-1">Soporte principal de respuesta</p>
                                                </div>
                                            </div>
                                            <a href="{{ asset('storage/' . $detalle->archivo_res) }}" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 text-white rounded-lg text-[10px] font-bold hover:bg-emerald-600 transition-colors shrink-0">
                                                <span class="material-symbols-outlined text-sm">visibility</span>
                                                Ver
                                            </a>
                                        </div>
                                    @endif

                                    @if($detalle->anexosRespuesta && $detalle->anexosRespuesta->count() > 0)
                                        @foreach($detalle->anexosRespuesta as $anexo)
                                            <div class="flex items-center justify-between bg-white dark:bg-slate-900/50 p-3 rounded-xl border border-blue-100 dark:border-slate-700">
                                                <div class="flex items-center gap-3">
                                                    <span class="material-symbols-outlined text-amber-500">attach_file</span>
                                                    <div class="flex flex-col">
                                                        <p class="text-[11px] font-bold text-slate-700 dark:text-slate-300 leading-none">Anexo de Respuesta</p>
                                                        <p class="text-[9px] text-slate-500 mt-1 truncate max-w-[150px]">{{ $anexo->nombre_original }}</p>
                                                    </div>
                                                </div>
                                                <a href="{{ asset('storage/' . $anexo->ruta_archivo) }}" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-500 text-white rounded-lg text-[10px] font-bold hover:bg-amber-600 transition-colors shrink-0">
                                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                                    Ver
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
</body>
</html>

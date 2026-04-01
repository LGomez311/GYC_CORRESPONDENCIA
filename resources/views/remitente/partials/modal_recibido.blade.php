{{-- Modal Registrar Nueva Correspondencia --}}
<div id="modalCorrespondencia" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen w-full p-4 relative">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
            onclick="closeModal('modalCorrespondencia')"></div>

        <div class="relative bg-white dark:bg-slate-900 rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden my-auto z-10 transition-all">

            <form action="{{ route('externarec.store') }}" method="POST" class="flex flex-col flex-1 min-h-0"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tipo_remitente" id="tipoRemitente" value="empresa">

                {{-- Header Fijo --}}
                <div class="px-8 py-5 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex justify-between items-center shrink-0">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Registrar Nueva Correspondencia</h3>
                    <button type="button" onclick="closeModal('modalCorrespondencia')"
                        class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full">
                        <span class="material-symbols-outlined font-bold text-xl leading-none">close</span>
                    </button>
                </div>

                {{-- Body con scroll --}}
                <div class="flex-1 overflow-y-auto form-body-scroll px-8 pt-3 pb-8 space-y-6 bg-white dark:bg-slate-900">

                {{-- Bloque de errores de validación --}}
                @if ($errors->any())
                    <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-red-500 flex-shrink-0">error</span>
                            <div>
                                <p class="text-sm font-semibold text-red-700 dark:text-red-400 mb-1">Por favor
                                    corrige los siguientes errores:</p>
                                <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-300 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ===== TABS DE SELECCIÓN ===== --}}
                <div class="flex space-x-6 border-b border-slate-200 dark:border-slate-800">
                    <button type="button" id="tabEmpresa"
                        class="pb-3 text-sm font-bold text-primary border-b-2 border-primary transition-colors">
                        Entidad / Empresa
                    </button>
                    <button type="button" id="tabPersona"
                        class="pb-3 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                        Persona Natural
                    </button>
                </div>

                {{-- ===== BLOQUE 1: EMPRESA (Visible por defecto) ===== --}}
                <div id="bloqueEmpresa" class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Nombre Institución *</p>
                            <input type="text" name="nom_institucion" required maxlength="150"
                                class="input-empresa form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="Nombre de la entidad o empresa" />
                        </label>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                NIT *</p>
                            <input type="text" name="nit_institucion" required maxlength="20"
                                class="input-empresa form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="Número de Identificación Tributaria" />
                        </label>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Núm. Radicado Externo</p>
                            <input type="text" name="num_radicado_ext" maxlength="20"
                                value="{{ old('num_radicado_ext') }}"
                                class="input-empresa form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="Opcional" />
                        </label>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Correo Electrónico</p>
                            <input type="email" name="correo_persona" maxlength="100"
                                class="input-empresa form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="correo@ejemplo.com" />
                        </label>
                    </div>
                </div>

                {{-- ===== BLOQUE 2: PERSONA NATURAL (Oculto por defecto) ===== --}}
                <div id="bloquePersona" class="hidden grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Nombre Completo *</p>
                            <input type="text" name="nombre_persona" required maxlength="150" disabled
                                class="input-persona form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="Nombres y apellidos" />
                        </label>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Documento de Identidad *</p>
                            <input type="text" name="numero_documento" required maxlength="20" disabled
                                class="input-persona form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="Número de documento de identidad" />
                        </label>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Tipo de Documento *</p>
                            <select name="tipo_documento" disabled 
                                class="input-persona form-select flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal">
                                <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                <option value="TI" {{ old('tipo_documento') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                                <option value="NIT" {{ old('tipo_documento') == 'NIT' ? 'selected' : '' }}>NIT</option>
                                <option value="PAS" {{ old('tipo_documento') == 'PAS' ? 'selected' : '' }}>Pasaporte</option>
                            </select>
                        </label>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Correo Electrónico *</p>
                            <input type="email" name="correo_persona" maxlength="100" disabled required
                                class="input-persona form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="correo@ejemplo.com" />
                        </label>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Teléfono</p>
                            <input type="text" name="telefono_persona" maxlength="20" disabled
                                class="input-persona form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="Opcional" />
                        </label>
                    </div>
                </div>

                {{-- ===== CAMPOS COMPARTIDOS (Siempre visibles) ===== --}}
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2 pt-2">
                    <div class="sm:col-span-1 relative" id="ciudad-proveniente-wrapper">
                        <input type="hidden" name="ciudad_proveniente" id="ciudad_proveniente_value">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Ciudad Proveniente *</p>
                            <button type="button" id="btnToggleCiudades"
                                class="form-input flex items-center justify-between w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal text-left">
                                <span id="btnToggleCiudadesLabel" class="text-slate-400">Seleccione una ciudad...</span>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-slate-400 text-xl pointer-events-none">location_city</span>
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                        </label>

                        <div id="ciudadesDropdown"
                            class="hidden absolute z-[60] w-full mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden">
                            <div class="p-2 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 sticky top-0">
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                                    <input type="text" id="buscarCiudadInput"
                                        class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
                                        placeholder="Buscar por código o nombre..." />
                                </div>
                            </div>
                            <ul id="listaCiudades" class="max-h-60 overflow-y-auto py-1 text-sm text-slate-700 dark:text-slate-200 custom-scrollbar">
                                {{-- Llenado por JS --}}
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- ===== SECCIÓN DESTINATARIOS ===== --}}
                <div class="space-y-3">
                    <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal">
                        Destinatario(s) <span class="text-red-500">*</span>
                    </p>
                    <div id="destinatarios-container" class="space-y-2">
                        <div class="destinatario-block flex items-start gap-2" data-index="0">
                            <input type="hidden" name="destinatarios[]" class="dest-hidden-input">
                            <div class="relative flex-1" style="min-width:0">
                                <button type="button"
                                    class="dest-btn-toggle form-input flex items-center justify-between w-full rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal text-left">
                                    <span class="dest-label text-slate-400">Seleccione un documento o
                                        nombre...</span>
                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div
                                    class="dest-dropdown hidden absolute z-20 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-200 dark:border-slate-700">
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-slate-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                            </div>
                                            <input type="text"
                                                class="dest-search-input w-full rounded-md border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-900 text-slate-900 dark:text-white py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
                                                placeholder="Buscar por cédula o nombre..." />
                                        </div>
                                    </div>
                                    <ul
                                        class="dest-list max-h-48 overflow-y-auto py-1 text-sm text-slate-700 dark:text-slate-200">
                                        <li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>
                                    </ul>
                                </div>
                            </div>
                            <button type="button"
                                class="dest-btn-remove hidden mt-1 flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg border border-red-200 dark:border-red-800 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors"
                                title="Quitar destinatario">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="btnAgregarDestinatario"
                        class="flex items-center gap-1.5 text-sm font-medium text-primary hover:text-primary/80 transition-colors mt-1">
                        <span class="material-symbols-outlined text-base">person_add</span>
                        + Agregar destinatario
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2 pt-2">
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Asunto *</p>
                            <input type="text" name="asunto" required maxlength="100"
                                class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                placeholder="Resumen del documento" />
                        </label>
                    </div>
                    <div class="sm:col-span-1 relative" id="tipo-documento-wrapper">
                        <input type="hidden" name="id_tipo" id="id_tipo_value">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Tipo de Documento *</p>
                            <div class="relative">
                                <button type="button" id="btnToggleTipos"
                                    class="form-input flex items-center justify-between w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal text-left">
                                    <span id="btnToggleTiposLabel" class="text-slate-400">Seleccione tipo...</span>
                                    <div class="flex items-center gap-2">
                                        <span id="btnClearTipo" class="hidden material-symbols-outlined text-slate-400 hover:text-red-500 cursor-pointer text-xl">close</span>
                                        <span class="material-symbols-outlined text-slate-400 text-xl pointer-events-none">category</span>
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        </label>

                        <div id="tiposDropdown"
                            class="hidden absolute z-[60] w-full mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden">
                            <div class="p-2 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 sticky top-0">
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                                    <input type="text" id="buscarTipoInput"
                                        class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
                                        placeholder="Buscar tipo de documento..." />
                                </div>
                            </div>
                            <ul id="listaTipos" class="max-h-60 overflow-y-auto py-1 text-sm text-slate-700 dark:text-slate-200 custom-scrollbar">
                                @foreach ($tipos as $tipo)
                                    <li class="tipo-item px-3 py-2.5 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer border-b border-slate-50 dark:border-slate-700/50 last:border-0"
                                        data-id="{{ $tipo->id_tipo }}" data-nombre="{{ $tipo->tipo_nombre }}">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-slate-400 text-sm">description</span>
                                            <span class="font-medium">{{ $tipo->tipo_nombre }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-1 pt-2">
                    <div class="sm:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Observaciones</p>
                            <textarea name="observaciones" rows="3" maxlength="250"
                                class="form-textarea flex w-full min-w-0 flex-1 resize-y rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 p-3.5 text-base font-normal"
                                placeholder="Notas adicionales..."></textarea>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-4 bg-gray-50 dark:bg-slate-800/30 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento
                            Principal (PDF) *</label>
                        <div class="border-2 border-dashed border-primary/30 dark:border-primary/20 rounded-lg p-3 text-center hover:bg-blue-50 dark:hover:bg-slate-800 transition-colors cursor-pointer relative"
                            onclick="document.getElementById('archivo_principal_input').click()">
                            <span class="material-symbols-outlined text-primary text-2xl mb-1">picture_as_pdf</span>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Clic aquí para añadir Principal</p>
                            <input type="file" id="archivo_principal_input" name="archivo" accept=".pdf"
                                class="hidden" required
                                onchange="handleFileSelectModal(event, 'archivoPrincipalList', 'archivo_principal_input')">
                        </div>
                        <div id="archivoPrincipalList" class="mt-2 flex flex-wrap gap-2 empty:hidden"></div>
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anexos
                            Adicionales (PDF)</label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 text-center hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors cursor-pointer relative"
                            onclick="document.getElementById('anexos_nuevos_input').click()">
                            <span class="material-symbols-outlined text-gray-400 text-2xl mb-1">note_add</span>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Clic aquí para añadir anexos</p>
                            <input type="file" id="anexos_nuevos_input" name="anexos[]" accept=".pdf" multiple
                                class="hidden"
                                onchange="handleFileSelectModal(event, 'anexosNuevosList', 'anexos_nuevos_input')">
                        </div>
                        <div id="anexosNuevosList" class="mt-2 flex flex-wrap gap-2 empty:hidden"></div>
                    </div>

                    <div class="md:col-span-1">
                        <label class="flex flex-col">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                Folios *</p>
                            <div class="relative">
                                <input type="number" name="folio" id="inputFolios" required min="1"
                                    class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-700/50 h-12 px-3.5 text-base font-semibold text-center"
                                    placeholder="Total folios" />
                                <span id="foliosSpinner"
                                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined animate-spin text-blue-400 text-lg">progress_activity</span>
                            </div>
                        </label>
                    </div>
                </div>

                </div>

                {{-- Footer Fijo --}}
                <div class="flex items-center justify-end gap-4 px-8 py-5 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shrink-0">
                    <button type="button" onclick="closeModal('modalCorrespondencia')"
                        class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors">Cancelar</button>
                    <button type="submit"
                        class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">Guardar
                        Registro</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // JS Logic for the Modal - Extracted for reusable partial
    document.addEventListener("DOMContentLoaded", function() {
        // Tab switching logic
        const tabEmpresa = document.getElementById('tabEmpresa');
        const tabPersona = document.getElementById('tabPersona');
        const bloqueEmpresa = document.getElementById('bloqueEmpresa');
        const bloquePersona = document.getElementById('bloquePersona');
        const tipoRemitenteHidden = document.getElementById('tipoRemitente');

        if (tabEmpresa && tabPersona) {
            tabEmpresa.addEventListener('click', () => {
                tipoRemitenteHidden.value = 'empresa';
                bloqueEmpresa.classList.remove('hidden');
                bloquePersona.classList.add('hidden');
                
                tabEmpresa.classList.add('text-primary', 'border-primary', 'border-b-2');
                tabEmpresa.classList.remove('text-slate-500', 'font-medium');
                tabPersona.classList.remove('text-primary', 'border-primary', 'border-b-2');
                tabPersona.classList.add('text-slate-500', 'font-medium');

                bloqueEmpresa.querySelectorAll('input').forEach(i => i.disabled = false);
                bloquePersona.querySelectorAll('input, select').forEach(i => i.disabled = true);
            });

            tabPersona.addEventListener('click', () => {
                tipoRemitenteHidden.value = 'persona';
                bloquePersona.classList.remove('hidden');
                bloqueEmpresa.classList.add('hidden');

                tabPersona.classList.add('text-primary', 'border-primary', 'border-b-2');
                tabPersona.classList.remove('text-slate-500', 'font-medium');
                tabEmpresa.classList.remove('text-primary', 'border-primary', 'border-b-2');
                tabEmpresa.classList.add('text-slate-500', 'font-medium');

                bloquePersona.querySelectorAll('input, select').forEach(i => i.disabled = false);
                bloqueEmpresa.querySelectorAll('input').forEach(i => i.disabled = true);
            });
        }

        // City Search Logic
        const TODAS_CIUDADES = @json($ciudades ?? []);
        const btnToggleCiudades = document.getElementById('btnToggleCiudades');
        const dropdownCiudades = document.getElementById('ciudadesDropdown');
        const inputBuscarCiudad = document.getElementById('buscarCiudadInput');
        const listaCiudadesEl = document.getElementById('listaCiudades');
        const hiddenCiudad = document.getElementById('ciudad_proveniente_value');
        const labelBtnCiudad = document.getElementById('btnToggleCiudadesLabel');

        function renderCiudades(ciudadesMostrar) {
            if(!listaCiudadesEl) return;
            listaCiudadesEl.innerHTML = '';
            if (ciudadesMostrar.length === 0) {
                listaCiudadesEl.innerHTML = '<li class="px-3 py-2 text-slate-400 italic">Sin resultados</li>';
                return;
            }

            const total = Math.min(ciudadesMostrar.length, 100);
            for (let i = 0; i < total; i++) {
                const ciudad = ciudadesMostrar[i];
                const li = document.createElement('li');
                li.className = 'px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer flex flex-col gap-0.5';
                const deptoText = ciudad.departamento?.dpto_nombre || 'N/A';
                li.innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-slate-400">location_city</span>
                        <span><span class="font-mono text-xs text-slate-500">${ciudad.ciudad_cod_post}</span> — ${ciudad.ciudad_nom}</span>
                    </div>
                    <div class="text-[10px] text-slate-400 font-medium pl-6">Dpto: ${deptoText}</div>
                `;
                li.addEventListener('click', () => {
                    hiddenCiudad.value = ciudad.ciudad_cod_post;
                    labelBtnCiudad.textContent = ciudad.ciudad_nom;
                    labelBtnCiudad.classList.remove('text-slate-400');
                    labelBtnCiudad.classList.add('text-slate-900', 'dark:text-white');
                    dropdownCiudades.classList.add('hidden');
                });
                listaCiudadesEl.appendChild(li);
            }
        }

        if(btnToggleCiudades) {
            renderCiudades(TODAS_CIUDADES);
            btnToggleCiudades.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownCiudades.classList.toggle('hidden');
                if(!dropdownCiudades.classList.contains('hidden')) inputBuscarCiudad.focus();
            });
            inputBuscarCiudad.addEventListener('input', function() {
                const q = this.value.trim().toLowerCase();
                const filtradas = TODAS_CIUDADES.filter(c => 
                    String(c.ciudad_cod_post).toLowerCase().includes(q) || 
                    String(c.ciudad_nom).toLowerCase().includes(q)
                );
                renderCiudades(filtradas);
            });
        }

        // Type Search Logic
        const btnToggleTipos = document.getElementById('btnToggleTipos');
        const dropdownTipos = document.getElementById('tiposDropdown');
        const inputBuscarTipo = document.getElementById('buscarTipoInput');
        const hiddenTipo = document.getElementById('id_tipo_value');
        const labelBtnTipo = document.getElementById('btnToggleTiposLabel');
        const btnClearTipo = document.getElementById('btnClearTipo');

        if(btnToggleTipos) {
            btnToggleTipos.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownTipos.classList.toggle('hidden');
                if(!dropdownTipos.classList.contains('hidden')) inputBuscarTipo.focus();
            });

            inputBuscarTipo.addEventListener('input', function() {
                const q = this.value.trim().toLowerCase();
                document.querySelectorAll('.tipo-item').forEach(item => {
                    const nombre = item.dataset.nombre.toLowerCase();
                    if (nombre.includes(q)) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });

            document.querySelectorAll('.tipo-item').forEach(item => {
                item.addEventListener('click', () => {
                    hiddenTipo.value = item.dataset.id;
                    labelBtnTipo.textContent = item.dataset.nombre;
                    labelBtnTipo.classList.remove('text-slate-400');
                    labelBtnTipo.classList.add('text-slate-900', 'dark:text-white');
                    dropdownTipos.classList.add('hidden');
                    btnClearTipo.classList.remove('hidden');
                });
            });
            btnClearTipo.addEventListener('click', (e) => {
                e.stopPropagation();
                hiddenTipo.value = '';
                labelBtnTipo.textContent = 'Seleccione tipo...';
                labelBtnTipo.classList.add('text-slate-400');
                btnClearTipo.classList.add('hidden');
            });
        }

        // Destination Search Logic
        const TODOS_DESTINATARIOS = @json($todosDestinatarios ?? []);

        function initDestinatorSearch(block) {
            const btn = block.querySelector('.dest-btn-toggle');
            const dd = block.querySelector('.dest-dropdown');
            const search = block.querySelector('.dest-search-input');
            const list = block.querySelector('.dest-list');
            const hidden = block.querySelector('.dest-hidden-input');
            const label = block.querySelector('.dest-label');
            const removeBtn = block.querySelector('.dest-btn-remove');

            function render(mostrar) {
                list.innerHTML = mostrar.length ? '' : '<li class="px-3 py-2 text-slate-400 italic">Sin resultados</li>';
                mostrar.slice(0, 50).forEach(emp => {
                    const li = document.createElement('li');
                    li.className = 'px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer flex flex-col gap-0.5';
                    li.innerHTML = `
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-slate-400">person</span>
                            <span><span class="font-mono text-xs text-slate-500">${emp.emple_doc}</span> — ${emp.emple_nombres} ${emp.emple_apellidos}</span>
                        </div>
                    `;
                    li.addEventListener('click', () => {
                        hidden.value = emp.emple_doc;
                        label.textContent = emp.emple_nombres + ' ' + emp.emple_apellidos;
                        label.classList.remove('text-slate-400');
                        dd.classList.add('hidden');
                    });
                    list.appendChild(li);
                });
            }

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                dd.classList.toggle('hidden');
                if(!dd.classList.contains('hidden')) {
                    render(TODOS_DESTINATARIOS);
                    search.focus();
                }
            });
            search.addEventListener('input', () => {
                const q = search.value.toLowerCase();
                render(TODOS_DESTINATARIOS.filter(e => 
                    e.emple_doc.includes(q) || e.emple_nombres.toLowerCase().includes(q) || e.emple_apellidos.toLowerCase().includes(q)
                ));
            });
            if(removeBtn) removeBtn.addEventListener('click', () => block.remove());
        }

        document.querySelectorAll('.destinatario-block').forEach(initDestinatorSearch);

        document.getElementById('btnAgregarDestinatario')?.addEventListener('click', () => {
            const container = document.getElementById('destinatarios-container');
            const clone = container.querySelector('.destinatario-block').cloneNode(true);
            clone.querySelector('.dest-hidden-input').value = '';
            clone.querySelector('.dest-label').textContent = 'Seleccione un documento o nombre...';
            clone.querySelector('.dest-label').classList.add('text-slate-400');
            clone.querySelector('.dest-btn-remove').classList.remove('hidden');
            container.appendChild(clone);
            initDestinatorSearch(clone);
        });

        // Global click to close dropdowns
        document.addEventListener('click', () => {
            document.querySelectorAll('#ciudadesDropdown, #tiposDropdown, .dest-dropdown').forEach(d => d.classList.add('hidden'));
        });
    });

    // File handling
    const customFilesStateModal = {
        'archivo_principal_input': new DataTransfer(),
        'anexos_nuevos_input': new DataTransfer()
    };

    window.handleFileSelectModal = async (event, containerId, inputId) => {
        const input = event.target;
        const container = document.getElementById(containerId);
        const dt = customFilesStateModal[inputId];
        
        if (inputId === 'archivo_principal_input') dt.items.clear(); // One file only
        
        Array.from(input.files).forEach(f => dt.items.add(f));
        input.files = dt.files;
        
        renderFilePillsModal(inputId, containerId);
        
        // Auto-count if possible
        if (inputId === 'archivo_principal_input' || inputId === 'anexos_nuevos_input') {
            countPagesModal();
        }
    };

    function renderFilePillsModal(inputId, containerId) {
        const container = document.getElementById(containerId);
        const dt = customFilesStateModal[inputId];
        container.innerHTML = '';
        
        Array.from(dt.files).forEach((f, i) => {
            const pill = document.createElement('div');
            pill.className = 'flex items-center gap-2 bg-blue-50 dark:bg-slate-800 text-primary px-3 py-1.5 rounded-lg text-xs font-bold border border-blue-100';
            pill.innerHTML = `
                <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                <span class="truncate max-w-[120px]">${f.name}</span>
                <button type="button" onclick="removeFileModal('${inputId}', '${containerId}', ${i})" class="ml-1 text-red-500 hover:text-red-700">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            `;
            container.appendChild(pill);
        });
    }

    window.removeFileModal = (inputId, containerId, index) => {
        const dt = customFilesStateModal[inputId];
        const newDt = new DataTransfer();
        Array.from(dt.files).forEach((f, i) => { if(i !== index) newDt.items.add(f); });
        customFilesStateModal[inputId] = newDt;
        document.getElementById(inputId).files = newDt.files;
        renderFilePillsModal(inputId, containerId);
        countPagesModal();
    };

    async function countPagesModal() {
        if (typeof pdfjsLib === 'undefined') return;
        const principal = customFilesStateModal['archivo_principal_input'].files[0];
        const annexes = customFilesStateModal['anexos_nuevos_input'].files;
        let total = 0;
        
        const count = async (f) => {
            if (!f || f.type !== 'application/pdf') return 0;
            try {
                const pdf = await pdfjsLib.getDocument({data: await f.arrayBuffer()}).promise;
                return pdf.numPages;
            } catch(e) { return 1; }
        };

        total += await count(principal);
        for(let f of annexes) total += await count(f);
        
        const input = document.getElementById('inputFolios');
        if(input) input.value = total > 0 ? total : '';
    }
</script>

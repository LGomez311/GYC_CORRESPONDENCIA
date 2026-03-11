@extends('remitente.layouts.app')


@section('title', 'Panel de Remitente')
<!-- Main Content -->
@section('content')
    <div class="flex h-screen w-full">
        <main class="flex-1 flex overflow-hidden">
            <div class="flex-1 flex flex-col p-6 overflow-y-auto">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <h1 class="text-gray-900 dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">
                        Correspondencia Externa Recibida
                    </h1>

                    <button id="btnAbrirModal"
                        class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all shadow-sm dark:bg-blue-500 dark:hover:bg-blue-600 w-max">
                        <span class="material-symbols-outlined text-base">add</span>
                        Nueva Correspondencia
                    </button>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-grow">
                        <label class="flex flex-col min-w-40 h-10 w-full">
                            <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                                <div
                                    class="text-gray-500 dark:text-gray-400 flex border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                                    <span class="material-symbols-outlined">search</span>
                                </div>
                                <input
                                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal"
                                    placeholder="Buscar documento..." value="" />
                            </div>
                        </label>
                    </div>
                    <div class="flex gap-3 items-center flex-wrap">
                        <button
                            class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <span
                                class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">filter_list</span>
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Prioridad</p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button>
                        <button
                            class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                            <span
                                class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">description</span>
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Tipo de
                                Documento</p>
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                        </button>

                        {{-- Filtro: Tipo de Remitente --}}
                        <div class="relative" id="filtroRemitenteWrapper">
                            <button type="button" id="btnFiltroRemitente"
                                class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 px-4">
                                <span class="material-symbols-outlined text-gray-500 dark:text-gray-400 text-sm">person_search</span>
                                <p id="btnFiltroRemitenteLabel" class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Remitente</p>
                                <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">expand_more</span>
                            </button>
                            <div id="dropdownFiltroRemitente"
                                class="hidden absolute right-0 z-20 mt-1 w-52 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg overflow-hidden">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-300">
                                    <li><button type="button" data-tipo="todos"
                                            class="filtro-remitente-btn w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium">Todos</button></li>
                                    <li><button type="button" data-tipo="persona"
                                            class="filtro-remitente-btn w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Persona Natural</button></li>
                                    <li><button type="button" data-tipo="entidad"
                                            class="filtro-remitente-btn w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Entidad / Empresa</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 flex-1 flex flex-col bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 sticky top-0">
                                <tr>
                                    <th class="px-6 py-3 font-bold w-12 text-center" scope="col">Tipo</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Asunto</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Remitente</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Fecha de Recepción</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Prioridad</th>
                                    <th class="px-6 py-3 font-bold" scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody id="tablaRecibidosBody">
                                @forelse($recibidos as $rec)
                                    @php
                                        // --- Tipo de remitente ---
                                        $esPersona = !empty($rec->nombre_persona) || !empty($rec->doc_persona);
                                        $tipoRow   = $esPersona ? 'persona' : 'entidad';

                                        // --- Remitente display ---
                                        $remitenteDisplay = $esPersona
                                            ? ($rec->nombre_persona ?: $rec->doc_persona)
                                            : ($rec->nom_institucion ?: '—');

                                        // --- Estado badge ---
                                        $estadoNombre = $rec->estado_nomb ?? 'Sin estado';
                                        $low = strtolower($estadoNombre);
                                        if (str_contains($low, 'pendiente') || str_contains($low, 'recibido')) {
                                            $estadoClases = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                                        } elseif (str_contains($low, 'tramite') || str_contains($low, 'proceso') || str_contains($low, 'tránsito')) {
                                            $estadoClases = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                                        } elseif (str_contains($low, 'finaliz') || str_contains($low, 'complet') || str_contains($low, 'resuel')) {
                                            $estadoClases = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                        } elseif (str_contains($low, 'rechaz') || str_contains($low, 'cancel')) {
                                            $estadoClases = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                        } elseif (str_contains($low, 'leido') || str_contains($low, 'leído') || str_contains($low, 'visto')) {
                                            $estadoClases = 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300';
                                        } elseif (str_contains($low, 'archiv')) {
                                            $estadoClases = 'bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200';
                                        } else {
                                            $estadoClases = 'bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200';
                                        }

                                        // --- Prioridad badge ---
                                        $priorNombre = $rec->prioridad_nombre ?? null;
                                        $priorClases = 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
                                        if ($priorNombre) {
                                            $pl = strtolower($priorNombre);
                                            if (str_contains($pl, 'alta') || str_contains($pl, 'urgente') || str_contains($pl, 'critica') || str_contains($pl, 'crítica')) {
                                                $priorClases = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                            } elseif (str_contains($pl, 'media') || str_contains($pl, 'normal') || str_contains($pl, 'moderada')) {
                                                $priorClases = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300';
                                            } elseif (str_contains($pl, 'baja') || str_contains($pl, 'bajo')) {
                                                $priorClases = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                            }
                                        }

                                        // --- Fecha ---
                                        $fechaFormateada = $rec->fecha_hora_recib
                                            ? \Carbon\Carbon::parse($rec->fecha_hora_recib)->format('d M, Y - H:i')
                                            : '—';
                                    @endphp
                                    <tr data-tipo="{{ $tipoRow }}"
                                        class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer bg-white dark:bg-gray-800">
                                        <td class="px-6 py-4 text-center">
                                            <span class="material-symbols-outlined text-gray-400">description</span>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $rec->asunto ?? '(Sin asunto)' }}
                                            @if($rec->num_radicado_ext)
                                                <span class="block text-xs text-gray-400 font-normal">Ext: {{ $rec->num_radicado_ext }}</span>
                                            @endif
                                            <span class="block text-xs text-gray-400 font-normal">Int: #{{ $rec->num_radicado_int }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $remitenteDisplay }}</span>
                                            @if($esPersona && $rec->correo_persona)
                                                <span class="block text-xs text-gray-400">{{ $rec->correo_persona }}</span>
                                            @endif
                                            <span class="flex items-center gap-0.5 text-xs {{ $esPersona ? 'text-purple-500' : 'text-blue-500' }} mt-0.5">
                                                <span class="material-symbols-outlined" style="font-size:13px">{{ $esPersona ? 'person' : 'business' }}</span>
                                                {{ $esPersona ? 'Persona Natural' : 'Entidad / Empresa' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ $fechaFormateada }}</td>
                                        <td class="px-6 py-4">
                                            @if($priorNombre)
                                                <span class="{{ $priorClases }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $priorNombre }}</span>
                                            @else
                                                <span class="text-gray-400 text-xs italic">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="{{ $estadoClases }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $estadoNombre }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyStateRow">
                                        <td colspan="6" class="px-6 py-14 text-center text-gray-400 dark:text-gray-500">
                                            <span class="material-symbols-outlined text-5xl mb-3 block">inbox</span>
                                            <p class="text-sm font-medium">No hay correspondencia registrada aún.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700">
                        <nav aria-label="Table navigation" class="flex items-center justify-between p-4">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Mostrando <span
                                    class="font-semibold text-gray-900 dark:text-white">1-6</span> de <span
                                    class="font-semibold text-gray-900 dark:text-white">45</span></span>
                            <ul class="inline-flex -space-x-px text-sm h-8">
                                <li><a class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        href="#">Anterior</a></li>
                                <li><a aria-current="page"
                                        class="flex items-center justify-center px-3 h-8 text-primary bg-primary/10 border border-primary hover:bg-primary/20 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                                        href="#">1</a></li>
                                <li><a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        href="#">2</a></li>
                                <li><a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        href="#">3</a></li>
                                <li><a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        href="#">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div
                class="w-80 border-l border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-col h-full overflow-hidden">
                <div class="p-6 flex flex-col h-full">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Detalle del Documento</h2>
                    <div class="flex-1 overflow-y-auto mb-6">
                        <div
                            class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="material-symbols-outlined text-blue-500 text-3xl">picture_as_pdf</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white text-base leading-tight">
                                        Contrato de Arrendamiento 2024</h3>
                                    <p class="text-xs text-gray-500 mt-1">ID: #DOC-84729</p>
                                </div>
                            </div>
                            <div class="space-y-3 mt-4">
                                <div class="flex flex-col">
                                    <span
                                        class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Remitente</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Inmobiliaria
                                        Central S.A.</span>
                                    <span class="text-xs text-gray-500">contacto@inmobiliariacentral.com</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Fecha
                                        de Recepción</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">24 Oct, 2023 -
                                        09:30 AM</span>
                                </div>
                                <div class="flex gap-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Prioridad</span>
                                        <span
                                            class="mt-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2 py-0.5 rounded w-max">Alta</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Estado</span>
                                        <span
                                            class="mt-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2 py-0.5 rounded w-max">Pendiente</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4 border-gray-200 dark:border-gray-700" />
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-2">Mensaje
                                    / Resumen</span>
                                <p
                                    class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed bg-white dark:bg-gray-800 p-3 rounded border border-gray-200 dark:border-gray-700">
                                    Adjunto enviamos el contrato de arrendamiento para las nuevas oficinas ubicadas en
                                    el centro financiero. Por favor revisar las cláusulas 4 y 7 referentes a
                                    modificaciones estructurales. Requiere firma antes del fin de mes.
                                </p>
                            </div>
                            <button
                                class="mt-4 w-full flex items-center justify-center gap-2 px-3 py-2 text-sm font-medium text-primary bg-primary/5 rounded-lg border border-primary/20 hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                Abrir Documento Completo
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 mt-auto pt-4 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Acciones
                            Rápidas</span>
                        <button
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-primary rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/30 shadow-sm transition-all">
                            <span class="material-symbols-outlined text-base">assignment_ind</span>
                            Asignar a Departamento
                        </button>
                        <button
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-300 dark:text-gray-200 dark:bg-gray-800 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 transition-all">
                            <span class="material-symbols-outlined text-base">archive</span>
                            Archivar Documento
                        </button>
                        <button
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-green-700 bg-green-50 border border-green-200 dark:text-green-300 dark:bg-green-900/20 dark:border-green-800 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 focus:outline-none transition-all">
                            <span class="material-symbols-outlined text-base">mark_email_read</span>
                            Marcar como Leído
                        </button>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const modal = document.getElementById('modalCorrespondencia');
                    const btnAbrir = document.getElementById('btnAbrirModal');
                    const btnCerrar = document.getElementById('btnCerrarModal');

                    // Función para abrir el modal
                    btnAbrir.addEventListener('click', function(e) {
                        e.preventDefault();
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                    });

                    // Auto-abrir el modal si hay errores de validación del intento anterior
                    @if ($errors->any() || session('success'))
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                        // Scroll al tope del modal para ver el bloque de errores
                        setTimeout(function() {
                            const scrollable = modal.querySelector('.overflow-y-auto');
                            if (scrollable) scrollable.scrollTop = 0;
                        }, 100);
                    @endif

                    // Función para cerrar el modal desde el botón Cancelar
                    btnCerrar.addEventListener('click', function() {
                        cerrarModal();
                    });

                    // Función para cerrar el modal si se hace clic afuera
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            cerrarModal();
                        }
                    });

                    function cerrarModal() {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.style.overflow = '';
                    }

                    // ===== BUSCADOR DE CIUDAD PROVENIENTE =====
                    const btnToggleCiudades = document.getElementById('btnToggleCiudades');
                    const dropdownCiudades = document.getElementById('ciudadesDropdown');
                    const inputBuscarCiudad = document.getElementById('buscarCiudadInput');
                    const listaCiudadesEl = document.getElementById('listaCiudades');
                    const hiddenCiudad = document.getElementById('ciudad_proveniente_value');
                    const labelBtnCiudad = document.getElementById('btnToggleCiudadesLabel');
                    let debouncerCiudad = null;

                    btnToggleCiudades.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdownCiudades.classList.toggle('hidden');
                        if (!dropdownCiudades.classList.contains('hidden')) {
                            inputBuscarCiudad.focus();
                        }
                    });

                    document.addEventListener('click', function(e) {
                        const wrapperCiudad = document.getElementById('ciudad-proveniente-wrapper');
                        if (wrapperCiudad && !wrapperCiudad.contains(e.target)) {
                            dropdownCiudades.classList.add('hidden');
                        }
                    });

                    inputBuscarCiudad.addEventListener('input', function() {
                        clearTimeout(debouncerCiudad);
                        const q = this.value.trim();
                        if (q.length < 1) {
                            listaCiudadesEl.innerHTML =
                                '<li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>';
                            return;
                        }
                        listaCiudadesEl.innerHTML = '<li class="px-3 py-2 text-slate-400 italic">Buscando...</li>';
                        debouncerCiudad = setTimeout(function() {
                            fetch('{{ route('externarec.ciudades.buscar') }}?q=' + encodeURIComponent(q), {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(r => r.json())
                                .then(data => {
                                    listaCiudadesEl.innerHTML = '';
                                    if (data.length === 0) {
                                        listaCiudadesEl.innerHTML =
                                            '<li class="px-3 py-2 text-slate-400 italic">Sin resultados</li>';
                                        return;
                                    }
                                    data.forEach(function(ciudad) {
                                        const li = document.createElement('li');
                                        li.className =
                                            'px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer flex items-center gap-2';
                                        li.innerHTML =
                                            '<span class="material-symbols-outlined text-sm text-slate-400">location_city</span>' +
                                            '<span><span class="font-mono text-xs text-slate-500">' +
                                            ciudad.ciudad_cod_post + '</span> — ' + ciudad
                                            .ciudad_nom + '</span>';
                                        li.addEventListener('click', function() {
                                            hiddenCiudad.value = ciudad.ciudad_cod_post;
                                            labelBtnCiudad.textContent = ciudad
                                                .ciudad_nom;
                                            labelBtnCiudad.classList.remove(
                                                'text-slate-400');
                                            labelBtnCiudad.classList.add(
                                                'text-slate-900', 'dark:text-white');
                                            dropdownCiudades.classList.add('hidden');
                                            inputBuscarCiudad.value = '';
                                        });
                                        listaCiudadesEl.appendChild(li);
                                    });
                                })
                                .catch(function() {
                                    listaCiudadesEl.innerHTML =
                                        '<li class="px-3 py-2 text-red-400 italic">Error al buscar</li>';
                                });
                        }, 300);
                    });

                    // ===== BUSCADOR DE DESTINATARIOS (múltiple) =====
                    const EMPLEADOS_URL = '{{ route('externarec.empleados.buscar') }}';

                    /**
                     * Inicializa el buscador de empleados dentro de un bloque `.destinatario-block`.
                     */
                    function inicializarBuscadorDestinatario(block) {
                        const btnToggle = block.querySelector('.dest-btn-toggle');
                        const dropdown = block.querySelector('.dest-dropdown');
                        const searchInput = block.querySelector('.dest-search-input');
                        const lista = block.querySelector('.dest-list');
                        const hidden = block.querySelector('.dest-hidden-input');
                        const label = block.querySelector('.dest-label');
                        const btnRemove = block.querySelector('.dest-btn-remove');
                        let debouncer = null;

                        // Abrir / cerrar dropdown
                        btnToggle.addEventListener('click', function(e) {
                            e.stopPropagation();
                            // Cerrar todos los demás dropdowns abiertos
                            document.querySelectorAll('.dest-dropdown').forEach(function(dd) {
                                if (dd !== dropdown) dd.classList.add('hidden');
                            });
                            dropdown.classList.toggle('hidden');
                            if (!dropdown.classList.contains('hidden')) searchInput.focus();
                        });

                        // Cerrar al hacer clic fuera del bloque
                        document.addEventListener('click', function(e) {
                            if (!block.contains(e.target)) dropdown.classList.add('hidden');
                        });

                        // Búsqueda con debounce
                        searchInput.addEventListener('input', function() {
                            clearTimeout(debouncer);
                            const q = this.value.trim();
                            if (q.length < 1) {
                                lista.innerHTML =
                                    '<li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>';
                                return;
                            }
                            lista.innerHTML = '<li class="px-3 py-2 text-slate-400 italic">Buscando...</li>';
                            debouncer = setTimeout(function() {
                                fetch(EMPLEADOS_URL + '?q=' + encodeURIComponent(q), {
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        lista.innerHTML = '';
                                        if (data.length === 0) {
                                            lista.innerHTML =
                                                '<li class="px-3 py-2 text-slate-400 italic">Sin resultados</li>';
                                            return;
                                        }
                                        data.forEach(function(emp) {
                                            const li = document.createElement('li');
                                            li.className =
                                                'px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer flex items-center gap-2';
                                            li.innerHTML =
                                                '<span class="material-symbols-outlined text-sm text-slate-400">person</span>' +
                                                '<span><span class="font-mono text-xs text-slate-500">' +
                                                emp.emple_doc +
                                                '</span> — ' + emp.emple_nombres + ' ' + emp
                                                .emple_apellidos + '</span>';
                                            li.addEventListener('click', function() {
                                                hidden.value = emp.emple_doc;
                                                label.textContent = emp.emple_doc +
                                                    ' — ' + emp.emple_nombres + ' ' +
                                                    emp.emple_apellidos;
                                                label.classList.remove(
                                                    'text-slate-400');
                                                label.classList.add('text-slate-900',
                                                    'dark:text-white');
                                                dropdown.classList.add('hidden');
                                                searchInput.value = '';
                                            });
                                            lista.appendChild(li);
                                        });
                                    })
                                    .catch(function() {
                                        lista.innerHTML =
                                            '<li class="px-3 py-2 text-red-400 italic">Error al buscar</li>';
                                    });
                            }, 300);
                        });

                        // Botón quitar
                        if (btnRemove) {
                            btnRemove.addEventListener('click', function() {
                                block.remove();
                            });
                        }
                    }

                    // Inicializar el primer bloque
                    document.querySelectorAll('.destinatario-block').forEach(inicializarBuscadorDestinatario);

                    // Botón "+ Agregar destinatario"
                    document.getElementById('btnAgregarDestinatario').addEventListener('click', function() {
                        const container = document.getElementById('destinatarios-container');
                        const template = container.querySelector('.destinatario-block');

                        // Clonar profundamente el primer bloque
                        const clone = template.cloneNode(true);

                        // Limpiar valores del clon
                        clone.querySelector('.dest-hidden-input').value = '';
                        clone.querySelector('.dest-label').textContent = 'Seleccione un documento o nombre...';
                        clone.querySelector('.dest-label').classList.add('text-slate-400');
                        clone.querySelector('.dest-label').classList.remove('text-slate-900', 'dark:text-white');
                        clone.querySelector('.dest-search-input').value = '';
                        clone.querySelector('.dest-list').innerHTML =
                            '<li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>';
                        clone.querySelector('.dest-dropdown').classList.add('hidden');

                        // Mostrar el botón de quitar en el clon
                        clone.querySelector('.dest-btn-remove').classList.remove('hidden');
                        clone.querySelector('.dest-btn-remove').classList.add('flex');

                        container.appendChild(clone);
                        inicializarBuscadorDestinatario(clone);
                    });

                    // ===== MANEJADOR DE ANEXOS MÚLTIPLES =====
                    /**
                     * Muestra un "pill" por cada archivo seleccionado.
                     * Al hacer clic en la X del pill, el archivo se elimina de la lista.
                     */
                    // ===== MANEJADOR DE ANEXOS MÚLTIPLES =====

                    // 1. Declaramos el acumulador FUERA de la función para que no se reinicie
                    window.dtAcumulador = new DataTransfer();

                    window.handleFileSelect = function(event, listId, inputId) {
                        const input = document.getElementById(inputId);
                        const container = document.getElementById(listId);

                        // 2. Agregamos los archivos recién elegidos al acumulador existente
                        Array.from(event.target.files).forEach(f => window.dtAcumulador.items.add(f));

                        // 3. Actualizamos el input con TODOS los archivos acumulados
                        input.files = window.dtAcumulador.files;

                        renderPills(input, container);
                    };

                    function renderPills(input, container) {
                        container.innerHTML = '';
                        Array.from(input.files).forEach((file, index) => {
                            const pill = document.createElement('div');
                            pill.className =
                                'flex items-center gap-1.5 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-full px-3 py-1 text-xs text-blue-700 dark:text-blue-300';
                            pill.innerHTML =
                                '<span class="material-symbols-outlined text-xs">description</span>' +
                                '<span class="max-w-[120px] truncate" title="' + file.name + '">' + file.name +
                                '</span>' +
                                '<button type="button" class="ml-1 text-blue-400 hover:text-red-500 transition-colors" aria-label="Quitar archivo">' +
                                '<span class="material-symbols-outlined text-sm">close</span></button>';

                            pill.querySelector('button').addEventListener('click', function() {
                                const newDt = new DataTransfer();
                                Array.from(input.files).forEach((f, i) => {
                                    if (i !== index) newDt.items.add(f);
                                });
                                input.files = newDt.files;

                                // 4. MUY IMPORTANTE: Sincronizar el acumulador al borrar un archivo
                                window.dtAcumulador = newDt;

                                renderPills(input, container);
                            });

                            container.appendChild(pill);
                        });
                    }
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const tabEmpresa = document.getElementById('tabEmpresa');
                    const tabPersona = document.getElementById('tabPersona');

                    const bloqueEmpresa = document.getElementById('bloqueEmpresa');
                    const bloquePersona = document.getElementById('bloquePersona');

                    const tipoRemitenteInput = document.getElementById('tipoRemitente');

                    // Inputs que cambian su estado "required"
                    const inputsEmpresa = document.querySelectorAll('.input-empresa');
                    const inputsPersona = document.querySelectorAll('.input-persona');

                    function activarTab(tipo) {
                        if (tipo === 'empresa') {
                            // Estilos del Tab
                            tabEmpresa.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                            tabEmpresa.classList.remove('font-medium', 'text-slate-500', 'dark:text-slate-400');

                            tabPersona.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                            tabPersona.classList.add('font-medium', 'text-slate-500', 'dark:text-slate-400');

                            // Mostrar/Ocultar
                            bloqueEmpresa.classList.remove('hidden');
                            bloquePersona.classList.add('hidden');

                            // Limpiar inputs del bloque oculto (persona)
                            bloquePersona.querySelectorAll('input, select, textarea').forEach(function(el) {
                                el.value = '';
                            });

                            // Valor al form
                            tipoRemitenteInput.value = 'empresa';

                            // Manejo de Required (evita que inputs ocultos bloqueen el submit)
                            inputsEmpresa.forEach(input => input.setAttribute('required', 'required'));
                            inputsPersona.forEach(input => input.removeAttribute('required'));

                        } else {
                            // Estilos del Tab
                            tabPersona.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                            tabPersona.classList.remove('font-medium', 'text-slate-500', 'dark:text-slate-400');

                            tabEmpresa.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary');
                            tabEmpresa.classList.add('font-medium', 'text-slate-500', 'dark:text-slate-400');

                            // Mostrar/Ocultar
                            bloquePersona.classList.remove('hidden');
                            bloqueEmpresa.classList.add('hidden');

                            // Limpiar inputs del bloque oculto (empresa)
                            bloqueEmpresa.querySelectorAll('input, select, textarea').forEach(function(el) {
                                el.value = '';
                            });

                            // Valor al form
                            tipoRemitenteInput.value = 'persona';

                            // Manejo de Required
                            inputsPersona.forEach(input => input.setAttribute('required', 'required'));
                            inputsEmpresa.forEach(input => input.removeAttribute('required'));
                        }
                    }

                    // Event Listeners
                    if (tabEmpresa && tabPersona) {
                        tabEmpresa.addEventListener('click', () => activarTab('empresa'));
                        tabPersona.addEventListener('click', () => activarTab('persona'));
                    }
                });

                // ===== FILTRO DE REMITENTE (Persona Natural / Entidad) =====
                document.addEventListener('DOMContentLoaded', function () {
                    const btnFiltro = document.getElementById('btnFiltroRemitente');
                    const dropdown  = document.getElementById('dropdownFiltroRemitente');
                    const label     = document.getElementById('btnFiltroRemitenteLabel');
                    const wrapper   = document.getElementById('filtroRemitenteWrapper');

                    if (!btnFiltro) return;

                    // Toggle dropdown
                    btnFiltro.addEventListener('click', function (e) {
                        e.stopPropagation();
                        dropdown.classList.toggle('hidden');
                    });

                    // Cerrar si se hace clic fuera
                    document.addEventListener('click', function (e) {
                        if (wrapper && !wrapper.contains(e.target)) {
                            dropdown.classList.add('hidden');
                        }
                    });

                    // Opciones del filtro
                    document.querySelectorAll('.filtro-remitente-btn').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            const tipo = btn.dataset.tipo;

                            // Actualizar label del botón
                            const labels = { todos: 'Remitente', persona: 'Persona Natural', entidad: 'Entidad / Empresa' };
                            label.textContent = labels[tipo] || 'Remitente';
                            dropdown.classList.add('hidden');

                            // Filtrar filas
                            const filas = document.querySelectorAll('#tablaRecibidosBody tr[data-tipo]');
                            let visibles = 0;
                            filas.forEach(function (fila) {
                                if (tipo === 'todos' || fila.dataset.tipo === tipo) {
                                    fila.classList.remove('hidden');
                                    visibles++;
                                } else {
                                    fila.classList.add('hidden');
                                }
                            });

                            // Mostrar/ocultar empty-state dinámico
                            let emptyDyn = document.getElementById('emptyDynamicRow');
                            if (visibles === 0) {
                                if (!emptyDyn) {
                                    emptyDyn = document.createElement('tr');
                                    emptyDyn.id = 'emptyDynamicRow';
                                    emptyDyn.innerHTML = '<td colspan="6" class="px-6 py-14 text-center text-gray-400 dark:text-gray-500">' +
                                        '<span class="material-symbols-outlined text-5xl mb-3 block">search_off</span>' +
                                        '<p class="text-sm font-medium">No hay registros de tipo "' + (labels[tipo] || tipo) + '".</p>' +
                                        '</td>';
                                    document.getElementById('tablaRecibidosBody').appendChild(emptyDyn);
                                }
                                emptyDyn.classList.remove('hidden');
                            } else if (emptyDyn) {
                                emptyDyn.classList.add('hidden');
                            }
                        });
                    });
                });
            </script>
        @endsection

        @section('modals')

            <div id="modalCorrespondencia" tabindex="-1" aria-hidden="true"
                class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">

                <div class="relative w-full max-w-5xl max-h-full my-auto">

                    <form action="{{ route('externarec.store') }}" method="POST" class="relative"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- Campo oculto para saber qué tipo de formulario se envió --}}
                        <input type="hidden" name="tipo_remitente" id="tipoRemitente" value="empresa">

                        <div
                            class="space-y-8 bg-white dark:bg-slate-900 p-8 rounded-xl border border-slate-200 dark:border-slate-800 shadow-2xl max-h-[90vh] overflow-y-auto">

                            <div
                                class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 pb-4 mb-4">
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Registrar Nueva
                                    Correspondencia</h3>
                            </div>

                            {{-- Bloque de errores de validación --}}
                            @if ($errors->any())
                                <div
                                    class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-red-500 flex-shrink-0">error</span>
                                        <div>
                                            <p class="text-sm font-semibold text-red-700 dark:text-red-400 mb-1">Por favor
                                                corrige los siguientes errores:</p>
                                            <ul
                                                class="list-disc list-inside text-sm text-red-600 dark:text-red-300 space-y-0.5">
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
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Núm. Radicado Externo</p>
                                        <input type="text" name="num_radicado_ext" maxlength="20"
                                            value="{{ old('num_radicado_ext') }}"
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Opcional" />
                                    </label>
                                </div>
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Nombre Institución *</p>
                                        <input type="text" name="nom_institucion" required maxlength="150"
                                            class="input-empresa form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Nombre de la entidad" />
                                    </label>
                                </div>
                            </div>

                            {{-- ===== BLOQUE 2: PERSONA NATURAL (Oculto por defecto) ===== --}}
                            <div id="bloquePersona" class="hidden space-y-8">
                                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <label class="flex flex-col">
                                            <p
                                                class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                                Nombre Completo *</p>
                                            <input type="text" name="nombre_persona" maxlength="150"
                                                class="input-persona form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                                placeholder="Nombres y apellidos" />
                                        </label>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label class="flex flex-col">
                                            <p
                                                class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                                Documento de Identidad *</p>
                                            <input type="text" name="documento_persona" maxlength="20"
                                                class="input-persona form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                                placeholder="Cédula, NIT, etc." />
                                        </label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <label class="flex flex-col">
                                            <p
                                                class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                                Correo Electrónico</p>
                                            <input type="email" name="correo_persona" maxlength="100"
                                                class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                                placeholder="correo@ejemplo.com" />
                                        </label>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label class="flex flex-col">
                                            <p
                                                class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                                Teléfono</p>
                                            <input type="text" name="telefono_persona" maxlength="20"
                                                class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                                placeholder="Opcional" />
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== CAMPOS COMPARTIDOS (Siempre visibles) ===== --}}
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1 relative" id="ciudad-proveniente-wrapper">
                                    <input type="hidden" name="ciudad_proveniente" id="ciudad_proveniente_value">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Ciudad Proveniente *</p>
                                        <button type="button" id="btnToggleCiudades"
                                            class="form-input flex items-center justify-between w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal text-left">
                                            <span id="btnToggleCiudadesLabel" class="text-slate-400">Seleccione una
                                                ciudad...</span>
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </label>

                                    <div id="ciudadesDropdown"
                                        class="hidden absolute z-10 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg shadow-lg overflow-hidden">
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
                                                <input type="text" id="buscarCiudadInput"
                                                    class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-900 text-slate-900 dark:text-white py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
                                                    placeholder="Buscar por código o nombre..." />
                                            </div>
                                        </div>
                                        <ul id="listaCiudades"
                                            class="max-h-48 overflow-y-auto py-1 text-sm text-slate-700 dark:text-slate-200">
                                            <li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>
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

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-3">
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Asunto</p>
                                        <input type="text" name="asunto" maxlength="100"
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Resumen del documento" />
                                    </label>
                                </div>
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Tipo de Documento</p>
                                        <select name="id_tipo"
                                            class="form-select flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal">
                                            <option value="">Seleccione tipo</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id_tipo }}">{{ $tipo->tipo_nombre }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col h-full">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Observaciones</p>
                                        <textarea name="observaciones" rows="3" maxlength="250"
                                            class="form-textarea flex w-full min-w-0 flex-1 resize-y rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 p-3.5 text-base font-normal"
                                            placeholder="Notas adicionales sobre la correspondencia..."></textarea>
                                    </label>
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1 md:grid-cols-3 gap-5 p-4 bg-gray-50 dark:bg-slate-800/30 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="md:col-span-1">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento
                                        Principal (PDF, JPG, PNG)</label>
                                    <input type="file" name="archivo" accept=".pdf,.jpg,.jpeg,.png"
                                        class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-900">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tamaño máximo: 5MB</p>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anexos
                                        (PDFs Opcionales)</label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 text-center hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors cursor-pointer relative"
                                        onclick="document.getElementById('anexos_nuevos_input').click()">
                                        <span class="material-symbols-outlined text-gray-400 text-2xl mb-1">note_add</span>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Clic aquí para añadir PDFs</p>
                                        <input type="file" id="anexos_nuevos_input" name="anexos[]" multiple
                                            accept=".pdf" class="hidden"
                                            onchange="handleFileSelect(event, 'anexosNuevosList', 'anexos_nuevos_input')">
                                    </div>
                                    <div id="anexosNuevosList" class="mt-2 flex flex-wrap gap-2 empty:hidden"></div>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Folios *</p>
                                        <input type="number" name="folio" required
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Número de hojas" />
                                    </label>
                                </div>
                            </div>

                            <div
                                class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 dark:border-slate-800">
                                <button id="btnCerrarModal" type="button"
                                    class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Cancelar</button>
                                <button type="button"
                                    class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-100 hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">Guardar
                                    Borrador</button>
                                <button type="submit"
                                    class="flex items-center justify-center h-11 px-6 rounded-lg text-sm font-bold bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">Enviar
                                    Correspondencia</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @endsection

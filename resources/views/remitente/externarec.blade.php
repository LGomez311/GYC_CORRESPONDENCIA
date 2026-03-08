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
                    <div class="flex gap-3 items-center">
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
                            <tbody>
                                <tr
                                    class="bg-blue-50/50 dark:bg-blue-900/10 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-blue-500">picture_as_pdf</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Contrato de Arrendamiento 2024</td>
                                    <td class="px-6 py-4">Inmobiliaria Central S.A.</td>
                                    <td class="px-6 py-4">24 Oct, 2023 - 09:30 AM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Alta</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Pendiente</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-green-500">description</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Factura Mensual Servicios IT</td>
                                    <td class="px-6 py-4">TechSolutions S.R.L.</td>
                                    <td class="px-6 py-4">23 Oct, 2023 - 14:15 PM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Media</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Leído</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-gray-500">mail</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Invitación Evento Anual</td>
                                    <td class="px-6 py-4">Cámara de Comercio</td>
                                    <td class="px-6 py-4">22 Oct, 2023 - 11:00 AM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Baja</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200 text-xs font-medium px-2.5 py-0.5 rounded-full">Archivado</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-blue-500">picture_as_pdf</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Propuesta Diseño Web</td>
                                    <td class="px-6 py-4">Creative Studio</td>
                                    <td class="px-6 py-4">21 Oct, 2023 - 16:45 PM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Media</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Pendiente</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-yellow-500">folder_zip</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Archivos de Proyecto Q3</td>
                                    <td class="px-6 py-4">Depto. Marketing (Interno)</td>
                                    <td class="px-6 py-4">20 Oct, 2023 - 08:20 AM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Alta</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Leído</span>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                    <td class="px-6 py-4 text-center"><span
                                            class="material-symbols-outlined text-green-500">description</span></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        Cotización Equipos Oficina</td>
                                    <td class="px-6 py-4">Office Depot S.A.</td>
                                    <td class="px-6 py-4">19 Oct, 2023 - 10:10 AM</td>
                                    <td class="px-6 py-4"><span
                                            class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Baja</span>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full">Pendiente</span>
                                    </td>
                                </tr>
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
            {{-- Alerta de éxito --}}
            @if (session('success'))
                <div id="alertaExito"
                    class="mt-4 flex items-center gap-3 p-4 text-green-800 bg-green-100 border border-green-300 rounded-lg dark:bg-green-900/30 dark:text-green-300 dark:border-green-800">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button onclick="document.getElementById('alertaExito').remove()"
                        class="ml-auto text-green-600 hover:text-green-800 dark:text-green-400">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>
            @endif

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

                    // ===== BUSCADOR DE EMPLEADOS (Quien Dirige) =====
                    const btnToggle = document.getElementById('btnToggleEmpleados');
                    const dropdown = document.getElementById('empleadosDropdown');
                    const inputBuscar = document.getElementById('buscarEmpleadoInput');
                    const listaEl = document.getElementById('listaEmpleados');
                    const hiddenDoc = document.getElementById('doc_quien_dirige_value');
                    const labelBtn = document.getElementById('btnToggleEmpleadosLabel');
                    let debouncer = null;

                    btnToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdown.classList.toggle('hidden');
                        if (!dropdown.classList.contains('hidden')) {
                            inputBuscar.focus();
                        }
                    });

                    // Cerrar dropdown al hacer clic fuera
                    document.addEventListener('click', function(e) {
                        const wrapper = document.getElementById('quien-dirige-wrapper');
                        if (wrapper && !wrapper.contains(e.target)) {
                            dropdown.classList.add('hidden');
                        }
                    });

                    inputBuscar.addEventListener('input', function() {
                        clearTimeout(debouncer);
                        const q = this.value.trim();
                        if (q.length < 1) {
                            listaEl.innerHTML =
                                '<li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>';
                            return;
                        }
                        listaEl.innerHTML = '<li class="px-3 py-2 text-slate-400 italic">Buscando...</li>';
                        debouncer = setTimeout(function() {
                            fetch('{{ route('externarec.empleados.buscar') }}?q=' + encodeURIComponent(q), {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(r => r.json())
                                .then(data => {
                                    listaEl.innerHTML = '';
                                    if (data.length === 0) {
                                        listaEl.innerHTML =
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
                                            emp.emple_doc + '</span> — ' + emp.emple_nombres +
                                            ' ' + emp.emple_apellidos + '</span>';
                                        li.addEventListener('click', function() {
                                            hiddenDoc.value = emp.emple_doc;
                                            labelBtn.textContent = emp.emple_doc +
                                                ' — ' + emp.emple_nombres + ' ' + emp
                                                .emple_apellidos;
                                            labelBtn.classList.remove('text-slate-400');
                                            labelBtn.classList.add('text-slate-900',
                                                'dark:text-white');
                                            dropdown.classList.add('hidden');
                                            inputBuscar.value = '';
                                        });
                                        listaEl.appendChild(li);
                                    });
                                })
                                .catch(function() {
                                    listaEl.innerHTML =
                                        '<li class="px-3 py-2 text-red-400 italic">Error al buscar</li>';
                                });
                        }, 300);
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
                        <div
                            class="space-y-8 bg-white dark:bg-slate-900 p-8 rounded-xl border border-slate-200 dark:border-slate-800 shadow-2xl max-h-[90vh] overflow-y-auto">

                            <div
                                class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 pb-4 mb-4">
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Registrar Nueva
                                    Correspondencia</h3>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Núm. Radicado Interno *
                                        </p>
                                        <select name="num_radicado_int" required
                                            class="form-select flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal">

                                            <option value="" disabled selected>Seleccione un radicado...</option>
                                            @foreach ($radicados as $radicado)
                                                <option value="{{ $radicado->id_radicado }}">{{ $radicado->num_radicado }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('num_radicado_int')
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>
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
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Nombre Institución *</p>
                                        <input type="text" name="nom_institucion" required maxlength="150"
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Nombre de la entidad" />
                                    </label>
                                </div>
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Ciudad Proveniente *
                                        </p>
                                        <select name="ciudad_proveniente" required
                                            class="form-select flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal">

                                            <option value="" disabled selected>Seleccione una ciudad...</option>
                                            @foreach ($ciudades as $ciudad)
                                                <option value="{{ $ciudad->ciudad_cod_post }}">{{ $ciudad->ciudad_nom }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-3">

                                <div class="sm:col-span-1 relative" id="quien-dirige-wrapper">
                                    {{-- Campo oculto que guarda el doc seleccionado --}}
                                    <input type="hidden" name="doc_quien_dirige" id="doc_quien_dirige_value">

                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Quien Dirige (Doc)
                                        </p>

                                        <button type="button" id="btnToggleEmpleados"
                                            class="form-input flex items-center justify-between w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal text-left">
                                            <span id="btnToggleEmpleadosLabel" class="text-slate-400">Seleccione un
                                                documento o nombre...</span>
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </label>

                                    <div id="empleadosDropdown"
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
                                                <input type="text" id="buscarEmpleadoInput"
                                                    class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-900 text-slate-900 dark:text-white py-2 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
                                                    placeholder="Buscar por cédula o nombre..." />
                                            </div>
                                        </div>

                                        <ul id="listaEmpleados"
                                            class="max-h-48 overflow-y-auto py-1 text-sm text-slate-700 dark:text-slate-200">
                                            <li class="px-3 py-2 text-slate-400 italic">Escriba para buscar...</li>
                                        </ul>

                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Asunto</p>
                                        <input type="text" name="asunto" maxlength="100"
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Resumen del documento" />
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-3">
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
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Estado</p>
                                        <select name="id_estado_rec"
                                            class="form-select flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal">
                                            <option value="">Seleccione estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado->id_estado }}">{{ $estado->estado_nomb }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Folios *</p>
                                        <input type="number" name="folio" required
                                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 h-12 px-3.5 text-base font-normal"
                                            placeholder="Número de hojas" />
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <label class="flex flex-col">
                                        <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                            Anexos</p>
                                        <textarea name="anexo" rows="3" maxlength="500"
                                            class="form-textarea flex w-full min-w-0 flex-1 resize-y rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-slate-800 p-3.5 text-base font-normal"
                                            placeholder="CDs, carpetas, etc."></textarea>
                                    </label>
                                </div>
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

                            <div>
                                <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">
                                    Documento Digitalizado (PDF/Imagen)
                                </p>

                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 dark:border-slate-700 border-dashed rounded-lg cursor-pointer bg-background-light dark:bg-slate-800 hover:bg-slate-200/50 dark:hover:bg-slate-700/50 transition-colors">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <span
                                                class="material-symbols-outlined text-3xl text-slate-500 dark:text-slate-400">upload_file</span>
                                            <p class="text-sm text-slate-500 dark:text-slate-400"><span
                                                    class="font-semibold">Subir archivo</span> para el campo 'archivo'</p>
                                        </div>
                                        <input type="file" id="file-input" name="archivo" class="hidden"
                                            accept=".pdf, image/*" />
                                    </label>
                                </div>

                                <div id="file-preview-container"
                                    class="hidden mt-4 flex items-center justify-between p-3 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                    <div class="flex items-center space-x-3 overflow-hidden">
                                        <span
                                            class="material-symbols-outlined text-slate-500 dark:text-slate-400">description</span>
                                        <span id="file-name"
                                            class="text-sm text-slate-700 dark:text-slate-300 truncate max-w-[200px] md:max-w-xs"></span>
                                    </div>
                                    <button type="button" id="remove-file-btn"
                                        class="text-red-500 hover:text-red-700 focus:outline-none p-1 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </div>
                            </div>

                            <script>
                                // Referencias a los elementos del DOM
                                const fileInput = document.getElementById('file-input');
                                const previewContainer = document.getElementById('file-preview-container');
                                const fileNameDisplay = document.getElementById('file-name');
                                const removeFileBtn = document.getElementById('remove-file-btn');

                                // Escuchar el evento cuando el usuario selecciona un archivo
                                fileInput.addEventListener('change', function(event) {
                                    const file = event.target.files[0];

                                    if (file) {
                                        // Si hay un archivo, mostramos el nombre y el contenedor
                                        fileNameDisplay.textContent = file.name;
                                        previewContainer.classList.remove('hidden');
                                    } else {
                                        // Si el usuario cancela, ocultamos el contenedor
                                        previewContainer.classList.add('hidden');
                                    }
                                });

                                // Escuchar el evento de clic en el botón de la papelera
                                removeFileBtn.addEventListener('click', function() {
                                    // Limpiamos el valor del input
                                    fileInput.value = '';
                                    // Ocultamos el contenedor de previsualización
                                    previewContainer.classList.add('hidden');
                                    fileNameDisplay.textContent = '';
                                });
                            </script>

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

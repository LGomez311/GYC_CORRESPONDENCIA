@extends('sadmin.layouts.app')

@section('title', 'Panel de Usuarios')

@section('content')

    <div class="p-8 max-w-7xl mx-auto w-full">
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#0d121b] dark:text-white text-3xl font-black leading-tight tracking-tight">
                    Gestión de Admins de Empresas</h1>
                <p class="text-[#4c669a] dark:text-gray-400 text-base font-normal">Controle el acceso y gestione
                    los perfiles de administradores para cada organización.</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Crear Nuevo Admin
                </button>
            </div>
        </div>
        <div
            class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 overflow-hidden shadow-sm">
            <div
                class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Administradores de
                    Empresas</h2>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1.5 text-xs font-bold border border-[#cfd7e7] dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-1 dark:text-white">
                        <span class="material-symbols-outlined text-sm">filter_list</span> Filtrar
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-background-light dark:bg-background-dark/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Nombre del Administrador</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Empresa Asociada</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Correo Electrónico</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Última Conexión</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider">
                                Estado</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-[#4c669a] dark:text-gray-400 uppercase tracking-wider text-right">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center overflow-hidden">
                                        <img alt="Avatar" class="w-full h-full object-cover"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAa9FqhbkbST6hYirkz22qcwuAL73VZgZw5SggCU4OJbc_kPlQmbfF6hNcaicJjtoPA_bSunEoT2olLz73oIHi8uYZyq0cRpQMGdZ3biETy3e-N7V0x-ZUcEUjPOfCjxff2LptzPfKqKNleEcKG-KEBxU7VM9qlqD9H6sF8Magu06qaUZqvqAFo4qTFiBAzIs1rhLYsz3pgUsddPBYUftR90hOEujnMQb_y6Q09Qi-Zoku2znxJ8_hcRoLh8UKjSnsJgXe3A-owXKI" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">Alejandro
                                            Ruiz</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">ID:
                                            ADM-1029</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-[#0d121b] dark:text-gray-300">Global Tech
                                    Solutions</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">aruiz@globaltech.com</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-[#0d121b] dark:text-gray-300">Hoy, 10:45
                                        AM</span>
                                    <span class="text-[10px] text-[#4c669a]">IP: 192.168.1.45</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Activo
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                        title="Ver detalles">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Eliminar">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                                        <img alt="Avatar" class="w-full h-full object-cover"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCt7aBQ4Q0eB5z6Zm2HWE50DuOuBsx5ue7rPICwGXSAakSY6WuzQIAe389Gly9rlHkfAyCBkC6Lep4MagEaABqDTf3ReI5-MKWaGuure82N3rupBemICW83xBRRBxZVsQM9OUd_VFb3mTIqopQVUPYgm3ysqe34xSLT49HZoq6rCf_ZJ3g9Vp3Fb1PnhbHK8C1RQW5LqqNrEkZmPyho5qciaYjGqav3M_sF88LtJ98HwrvPMjkJbkxN5cNgc_Qsm1-a3Y2GdjJzbMs" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">Elena
                                            Martínez</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">ID:
                                            ADM-2241</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-[#0d121b] dark:text-gray-300">Logística
                                    Integral S.A.</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">e.martinez@logisa.es</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-[#0d121b] dark:text-gray-300">Ayer, 16:20
                                        PM</span>
                                    <span class="text-[10px] text-[#4c669a]">IP: 85.12.98.22</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Activo
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                        title="Ver detalles">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors" title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Eliminar">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                                        <img alt="Avatar" class="w-full h-full object-cover"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAEu_gNUJa8jimNbPDZWoZUxkxkg5qDCnw23hWoD8J4aVgMBgVTYxZprLt8HSxlWGLIe2XI_idvKqJPOAS6snLVuRU-TBSjEdmoVe3Apf96qaKu_vZohFQYaTkRFxXyKAzwuHZMCYYWRBPeu8xGDPLKspXEpbV6tEaXhbFvU5XR61uXXX8YMWW53FW4i3e8NtEOOpvLKmFkLbxywJERY_qJwJhESpMWhPwqUSTJOAGz-yGpX2eRfa2PJBEmr-zrLycoBd--WOxDhSU" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">Roberto
                                            García</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">ID:
                                            ADM-0992</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-[#0d121b] dark:text-gray-300">Banco del
                                    Norte</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">rgarcia@banconorte.com</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-[#0d121b] dark:text-gray-300">02 Nov, 2023</span>
                                    <span class="text-[10px] text-[#4c669a]">IP: 201.2.3.4</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    Inactivo
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                        title="Ver detalles">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                        title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Eliminar">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-yellow-50 dark:bg-yellow-900/20 flex items-center justify-center overflow-hidden">
                                        <img alt="Avatar" class="w-full h-full object-cover"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6IerINz5ANVpU7MLTYI1uFA6VfD7-TLd7ymfILTEqYlGcPrdcHZVeFP_ZTFFr5aYyfCrHkBm__8OjpA0nV1zEF_aqho9i-R4hCdMfCAQHUFNhfTkcc2vPXs3zXFHrW23sEhnV63HE-P0A_IrodeUNbc2KNGhmgSvhv0spv2VRGuhyDN9wopZRPrj45jaWhBwW0gXp4ivTrcRW5ORHq3OFd1pwtjc0BDFTPu8UaUzQkoIVToImfZPFDpy6gunW7X4bmz7kDSO2lKE" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-[#0d121b] dark:text-white">Patricia
                                            Soto</span>
                                        <span class="text-xs text-[#4c669a] dark:text-gray-400">ID:
                                            ADM-3110</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-[#0d121b] dark:text-gray-300">Retail
                                    Group LATAM</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-sm text-[#4c669a] dark:text-gray-400 underline decoration-primary/30">psoto@retailgroup.com</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-[#0d121b] dark:text-gray-300">Hace 3 horas</span>
                                    <span class="text-[10px] text-[#4c669a]">IP: 190.45.2.11</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Activo
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                        title="Ver detalles">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-primary transition-colors"
                                        title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 text-[#4c669a] hover:text-red-500 transition-colors"
                                        title="Eliminar">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-[#cfd7e7] dark:border-gray-800 flex items-center justify-between">
                <p class="text-xs text-[#4c669a] dark:text-gray-400">Mostrando 4 de 28 administradores
                    registrados</p>
                <div class="flex gap-1">
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button
                        class="size-8 flex items-center justify-center rounded bg-primary text-white font-bold text-xs">1</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 text-xs">2</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 text-xs">3</button>
                    <button
                        class="size-8 flex items-center justify-center rounded border border-[#cfd7e7] dark:border-gray-700 text-[#4c669a] dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

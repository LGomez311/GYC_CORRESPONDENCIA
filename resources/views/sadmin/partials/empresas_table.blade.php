<div class="overflow-x-auto min-h-[260px]">
    <table class="w-full text-left border-collapse">
        <thead class="bg-background-light dark:bg-background-dark/50">
            <tr>
                <th scope="col" class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Empresa</th>
                <th scope="col" class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">NIT</th>
                <th scope="col" class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase">Estado Licencia</th>
                <th scope="col" class="px-6 py-4 text-xs font-bold text-[#4c669a] uppercase text-right">Vigencia</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">
            @forelse($empresasPaginadas as $datos)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-bold text-[#0d121b] dark:text-white">
                        {{ $datos['empresa']->nomb_empresa }}
                    </td>
                    <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400">
                        {{ $datos['empresa']->nit_empresa }}
                    </td>
                    <td class="px-6 py-4">
                        @if($datos['activa'] && !$datos['vence_pronto'])
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                Activa
                            </span>
                        @elseif($datos['activa'] && $datos['vence_pronto'])
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                Vence pronto
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                Sin Licencia
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-[#4c669a] dark:text-gray-400 text-right">
                        @if($datos['tiene_licencia'] && $datos['mejor_licencia'])
                            @if($datos['activa'])
                                Quedan {{ $datos['dias_restantes'] }}
                            @else
                                Vencida el {{ \Carbon\Carbon::parse($datos['mejor_licencia']->fecha_fin)->format('d/m/Y') }}
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-[#4c669a] dark:text-gray-400 text-sm">
                        No hay empresas que coincidan con la búsqueda
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginación -->
<div class="mt-4 flex justify-end ajax-pagination">
    {{ $empresasPaginadas->links() }}
</div>

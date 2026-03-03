<div class="overflow-x-auto min-h-[260px]">
    <table class="w-full text-sm text-left">
        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-800/50 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3 rounded-l-lg">Empresa</th>
                <th scope="col" class="px-4 py-3">NIT</th>
                <th scope="col" class="px-4 py-3">Estado Licencia</th>
                <th scope="col" class="px-4 py-3 rounded-r-lg">Vigencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($empresasPaginadas as $datos)
                <tr class="border-b dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                        {{ $datos['empresa']->nomb_empresa }}
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                        {{ $datos['empresa']->nit_empresa }}
                    </td>
                    <td class="px-4 py-3">
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
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
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
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
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

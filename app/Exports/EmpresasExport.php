<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpresasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Empresa::with([
            'representante.pagos.plan'
        ])->get()->map(function ($empresa) {

            $plan = optional(
                $empresa->representante?->pagos->last()?->plan
            );

            return [
                'Empresa'        => (string) $empresa->nomb_empresa,
                'NIT'            => (string) $empresa->nit_empresa,
                'Plan Actual'    => $plan->nomb_plan ?? 'Sin plan',
                'Dirección'      => (string) $empresa->direccion,
                'Teléfono'       => (string) $empresa->contacto,
                'Correo'         => (string) $empresa->empresa_correo,
                'Representante'  => $empresa->representante->emple_nombres ?? 'Sin asignar',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Empresa',
            'NIT',
            'Plan Actual',
            'Dirección',
            'Teléfono',
            'Correo',
            'Representante',
        ];
    }
}

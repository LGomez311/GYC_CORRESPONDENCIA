<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpresasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Empresa::with('plan')->get()->map(function ($empresa) {
            return [
                'Empresa' => (string) $empresa->nomb_empresa,
                'NIT' => (string) $empresa->nit_empresa,
                'Plan Actual' => optional($empresa->plan)->nomb_plan ?? 'Sin plan',
                'Dirección' => (string) $empresa->direccion,
                'Teléfono' => (string) $empresa->contacto,
                'Correo' => (string) $empresa->empresa_correo,
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
        ];
    }
}

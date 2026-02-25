<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpresasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Empresa::all()->map(function ($empresa) {

            return [
                'Empresa'        => (string) $empresa->nomb_empresa,
                'NIT'            => (string) $empresa->nit_empresa,
                'Dirección'      => (string) $empresa->direccion,
                'Teléfono'       => (string) $empresa->contacto,
                'Correo'         => (string) $empresa->empresa_correo,
                'Documento Rep.' => (string) $empresa->doc_representante,
                'Representante'  => (string) $empresa->nomb_representante,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Empresa',
            'NIT',
            'Dirección',
            'Teléfono',
            'Correo',
            'Documento Rep.',
            'Representante',
        ];
    }
}
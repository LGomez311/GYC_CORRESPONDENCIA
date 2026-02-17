<?php

namespace App\Exports;

use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Solo rol 2 = AdminEmpresa
        return Empleado::with(['empresa', 'estado', 'rol', 'area'])
            ->where('emple_rol', 2)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Documento',
            'Nombres',
            'Apellidos',
            'Empresa',
            'Correo',
            'Teléfono',
            'Estado',
            'Rol',
            'Área'
        ];
    }

    public function map($empleado): array
    {
        return [
            $empleado->emple_doc,
            $empleado->emple_nombres,
            $empleado->emple_apellidos,
            $empleado->empresa->nomb_empresa ?? '',
            $empleado->emple_correo,
            $empleado->emple_tel,
            $empleado->estado->estado_nomb ?? '',
            $empleado->rol->rol_nom ?? '',
            $empleado->area->area_nom ?? '',
        ];
    }
}

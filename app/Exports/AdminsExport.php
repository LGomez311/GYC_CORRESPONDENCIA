<?php

namespace App\Exports;

use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Empleado::with(['empresa','estado','rol'])
            ->where('emple_rol', 2)
            ->whereHas('empresa')
            ->get()
            ->map(function ($admin) {
                return [
                    $admin->emple_doc,
                    $admin->emple_nombres,
                    $admin->emple_apellidos,
                    $admin->empresa->nomb_empresa ?? '',
                    $admin->emple_correo,
                    $admin->emple_tel,
                    $admin->estado->estado_nomb ?? '',
                    $admin->rol->rol_nom ?? '',
                ];
            });
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
            'Rol'
        ];
    }
}

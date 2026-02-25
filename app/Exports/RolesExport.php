<?php

namespace App\Exports;

use App\Models\Rol;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RolesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Rol::select('id_rol', 'rol_nom')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Rol'
        ];
    }
}

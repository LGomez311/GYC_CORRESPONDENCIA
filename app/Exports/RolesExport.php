<?php

namespace App\Exports;

use App\Models\Rol;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RolesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $firstTwoIds = Rol::orderBy('id_rol')->limit(2)->pluck('id_rol');
        return Rol::select('id_rol', 'rol_nom')
            ->whereNotIn('id_rol', $firstTwoIds)
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Rol'
        ];
    }
}

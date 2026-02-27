<?php

namespace App\Exports;

use App\Models\Tipo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TiposExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Tipo::select('id_tipo', 'tipo_nombre', 'id_prioridad')->with('prioridad')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Tipo',
            'ID Prioridad'
        ];
    }
}

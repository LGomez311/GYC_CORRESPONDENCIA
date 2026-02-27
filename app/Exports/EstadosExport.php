<?php

namespace App\Exports;

use App\Models\Estado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EstadosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Estado::whereIn('id_estado', [1, 2])
            ->orWhere('id_estado', '>', 5)
            ->select('id_estado', 'estado_nomb')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Estado'
        ];
    }
}

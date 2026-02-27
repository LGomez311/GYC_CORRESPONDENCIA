<?php

namespace App\Exports;

use App\Models\Prioridad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrioridadesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Prioridad::select('id_prioridad', 'prioridad_nombre')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Prioridad'
        ];
    }
}

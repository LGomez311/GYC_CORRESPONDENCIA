<?php

namespace App\Exports;

use App\Models\Radicado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RadicadoExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Radicado::with('estado')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Número de Radicado',
            'Estado',
        ];
    }

    public function map($radicado): array
    {
        return [
            $radicado->id_radicado,
            $radicado->num_radicado,
            $radicado->estado->estado_nomb ?? 'N/A',
        ];
    }
}

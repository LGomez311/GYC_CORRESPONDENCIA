<?php

namespace App\Exports;

use App\Models\Pago;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pago::with(['plan', 'estado'])->get()->map(function ($pago) {
            return [
                'ID Pago' => $pago->id_pago,
                'Plan' => $pago->plan->nomb_plan ?? '',
                'Monto' => $pago->monto,
                'Fecha de Pago' => $pago->fecha_pago,
                'Estado' => $pago->estado->estado_nomb ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Pago',
            'Plan',
            'Monto',
            'Fecha de Pago',
            'Estado',
        ];
    }
}


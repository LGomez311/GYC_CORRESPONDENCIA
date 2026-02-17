<?php

namespace App\Exports;

use App\Models\Pago;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pago::with(['plan', 'estado', 'admin'])->get()->map(function ($pago) {
            return [
                'ID Pago' => $pago->id_pago,
                'Plan' => $pago->plan->nomb_plan ?? '',
                'Pagado por' => $pago->admin
                    ? $pago->admin->emple_nombres . ' ' . $pago->admin->emple_apellidos
                    : '',
                'Fecha Pago' => $pago->fecha_pago,
                'Inicio Licencia' => $pago->fecha_inicio,
                'Estado' => $pago->estado->estado_nomb ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Pago',
            'Plan',
            'Pagado por',
            'Fecha Pago',
            'Inicio Licencia',
            'Estado',
        ];
    }
}

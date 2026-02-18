<?php

namespace App\Exports;

use App\Models\Plan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PlanesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Plan::all()->map(function ($plan) {
            return [
                'Nombre' => (string) $plan->nomb_plan,
                'Descripción' => is_array($plan->descripcion)
                    ? implode(', ', $plan->descripcion)
                    : (string) $plan->descripcion,
                'Precio' => (string) $plan->valor,
                'Duración' => (string) $plan->duracion,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Descripción',
            'Precio',
            'Duración',
        ];
    }
}

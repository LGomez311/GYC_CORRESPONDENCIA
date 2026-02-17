<?php

namespace App\Exports;

use App\Models\Licencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LicenciasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Licencia::with(['pago.admin.empresa','pago.plan','estado'])
            ->get()
            ->map(function($licencia){
                return [
                    'ID' => $licencia->id_licencia,
                    'Empresa' => $licencia->pago->admin->empresa->nomb_empresa ?? 'Empresa no encontrada',
                    'NIT' => $licencia->pago->admin->empresa->nit_empresa ?? '-',
                    'Plan' => $licencia->pago->plan->nomb_plan ?? '-',
                    'Estado' => $licencia->estado->estado_nomb ?? '-',
                    'Inicio' => $licencia->fecha_inicio,
                    'Fin' => $licencia->fecha_fin,
                    'Tipo de licencia' => $licencia->tipo_licencia,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID','Empresa','NIT','Plan','Estado','Inicio','Fin','Tipo de licencia'];
    }
}

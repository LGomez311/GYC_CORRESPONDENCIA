<?php

namespace App\Exports;

use App\Models\Ciudad;
use Maatwebsite\Excel\Concerns\FromCollection;

class CiudadExport implements FromCollection
{
    public function collection()
    {
        return Ciudad::with('departamento')
            ->orderByRaw('CAST(ciudad_cod_post AS UNSIGNED) ASC')
            ->get()
            ->map(function ($c) {
                return [
                    'ID' => $c->id_ciudad,
                    'Ciudad' => $c->ciudad_nom,
                    'Código Postal' => $c->ciudad_cod_post,
                    'Departamento' => $c->departamento->dpto_nombre ?? ''
                ];
            });
    }
}
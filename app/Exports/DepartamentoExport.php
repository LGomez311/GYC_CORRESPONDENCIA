<?php

namespace App\Exports;

use App\Models\Departamento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class DepartamentoExport implements FromCollection
{
    public function collection()
    {
        return Departamento::select('dpto_codigo_postal', 'dpto_nombre')->get();
    }
    public function checkCodigo(Request $request)
    {
        $codigo = $request->codigo;
        $actual = $request->actual;

        $query = \App\Models\Departamento::where('dpto_codigo_postal', $codigo);

        if ($actual) {
            $query->where('dpto_codigo_postal', '!=', $actual);
        }

        return response()->json([
            'exists' => $query->exists()
        ]);
    }
}

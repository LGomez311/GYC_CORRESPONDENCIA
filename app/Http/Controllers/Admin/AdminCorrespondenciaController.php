<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recibido;
use Illuminate\Http\Request;

class AdminCorrespondenciaController extends Controller
{
    public function index()
    {
        // Obtener el NIT de la empresa del admin logeado
        $nitEmpresa = auth()->user()->nit_empresa;

        // Filtrar correspondencia que fue registrada por un remitente de la misma empresa
        // O dirigida a un empleado de la misma empresa.
        // Según lo hablado, usualmente se filtra por la empresa asociada.
        $correspondencias = Recibido::with(['dirigidoA', 'registradoPor', 'tipo', 'estado', 'ciudad'])
            ->whereHas('registradoPor', function($query) use ($nitEmpresa) {
                $query->where('nit_empresa', $nitEmpresa);
            })
            ->orWhereHas('dirigidoA', function($query) use ($nitEmpresa) {
                $query->where('nit_empresa', $nitEmpresa);
            })
            ->get();

        return view('admin.correspondencia', compact('correspondencias'));
    }
}

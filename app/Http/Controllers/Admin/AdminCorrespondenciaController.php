<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recibido;
use Illuminate\Http\Request;
use App\Exports\CorrespondenciaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

    private function getCorrespondenciaFiltered()
    {
        $nitEmpresa = auth()->user()->nit_empresa;

        return Recibido::with(['dirigidoA', 'registradoPor', 'tipo', 'estado', 'ciudad'])
            ->whereHas('registradoPor', function($query) use ($nitEmpresa) {
                $query->where('nit_empresa', $nitEmpresa);
            })
            ->orWhereHas('dirigidoA', function($query) use ($nitEmpresa) {
                $query->where('nit_empresa', $nitEmpresa);
            })
            ->get();
    }

    public function exportExcel()
    {
        $correspondencias = $this->getCorrespondenciaFiltered();
        return Excel::download(new CorrespondenciaExport($correspondencias), 'correspondencia.xlsx');
    }

    public function exportPdf()
    {
        $correspondencias = $this->getCorrespondenciaFiltered();
        $pdf = Pdf::loadView('admin.pdf.correspondencia_pdf', compact('correspondencias'))->setPaper('A4', 'landscape');
        return $pdf->download('correspondencia.pdf');
    }
}

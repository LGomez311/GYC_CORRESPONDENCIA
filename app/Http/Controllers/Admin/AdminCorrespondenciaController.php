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
        $data = $this->getCorrespondenciaFiltered();
        return view('admin.correspondencia', [
            'recibidos' => $data['recibidos'],
            'envios' => $data['envios']
        ]);
    }

    private function getCorrespondenciaFiltered()
    {
        /** @var \App\Models\Empleado $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $nitEmpresa = $user->nit_empresa;

        // Recibido (Externa)
        $recibidos = Recibido::with(['destinatarios', 'registradoPor', 'estado', 'ciudad'])
            ->whereHas('registradoPor', function($query) use ($nitEmpresa) {
                $query->where('nit_empresa', $nitEmpresa);
            })
            ->orWhereHas('destinatarios', function($query) use ($nitEmpresa) {
                $query->where('nit_empresa', $nitEmpresa);
            })
            ->get()
            ->map(function ($item) {
                return (object) [
                    'origen' => 'Externa',
                    'num_radicado_ext' => $item->num_radicado_ext,
                    'num_radicado_int' => $item->num_radicado_int,
                    'nom_institucion' => $item->nom_institucion,
                    'ciudad' => $item->ciudad ? $item->ciudad->ciudad_nom : $item->ciudad_proveniente,
                    'asunto' => $item->asunto,
                    'fecha' => $item->fecha_hora_recib,
                    'destinatario_nombre' => $item->destinatarios->count() > 0 ? $item->destinatarios->first()->emple_nombres . ' ' . $item->destinatarios->first()->emple_apellidos : 'N/A',
                    'doc_destinatario' => $item->destinatarios->count() > 0 ? $item->destinatarios->first()->emple_doc : null,
                    'folio' => $item->folio,
                    'anexo' => $item->anexo,
                    'estado_nomb' => $item->estado ? $item->estado->estado_nomb : 'Desconocido',
                    'archivo' => $item->archivo
                ];
            })
            ->sortByDesc('fecha')->values();

        // Envio (Interna)
        $envios = \App\Models\Envio::with(['quienDirigido', 'quienEnvia', 'estadoEnvio'])
            ->whereHas('quienEnvia', function($query) use ($nitEmpresa) {
                $query->where('nit_empresa', $nitEmpresa);
            })
            ->orWhereHas('quienDirigido', function($query) use ($nitEmpresa) {
                $query->where('nit_empresa', $nitEmpresa);
            })
            ->get()
            ->map(function ($item) {
                return (object) [
                    'origen' => 'Interna',
                    'num_radicado_ext' => 'N/A',
                    'num_radicado_int' => $item->num_radicado_int,
                    'nom_institucion' => $item->quienEnvia ? $item->quienEnvia->emple_nombres . ' ' . $item->quienEnvia->emple_apellidos : 'N/A',
                    'ciudad' => 'N/A',
                    'asunto' => $item->asunto,
                    'fecha' => $item->fecha,
                    'destinatario_nombre' => $item->quienDirigido ? $item->quienDirigido->emple_nombres . ' ' . $item->quienDirigido->emple_apellidos : $item->destino,
                    'doc_destinatario' => $item->doc_quien_dirigido,
                    'folio' => $item->folio,
                    'anexo' => $item->anexo,
                    'estado_nomb' => $item->estadoEnvio ? $item->estadoEnvio->estado_nomb : 'Desconocido',
                    'archivo' => $item->archivo
                ];
            })
            ->sortByDesc('fecha')->values();

        return [
            'recibidos' => $recibidos,
            'envios' => $envios
        ];
    }

    public function exportExcel()
    {
        $data = $this->getCorrespondenciaFiltered();
        $correspondencias = $data['recibidos']->concat($data['envios'])->sortByDesc('fecha')->values();
        return Excel::download(new CorrespondenciaExport($correspondencias), 'correspondencia.xlsx');
    }

    public function exportPdf()
    {
        $data = $this->getCorrespondenciaFiltered();
        $correspondencias = $data['recibidos']->concat($data['envios'])->sortByDesc('fecha')->values();
        $pdf = Pdf::loadView('admin.pdf.correspondencia_pdf', compact('correspondencias'))->setPaper('A4', 'landscape');
        return $pdf->download('correspondencia.pdf');
    }
}

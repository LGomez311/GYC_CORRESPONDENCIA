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

        // ---- Correspondencia Externa (Recibida) ----
        // Incluye documentos donde la empresa sea la destinataria o la registró
        $recibidos = Recibido::with(['destinatarios', 'registradoPor', 'estado', 'ciudad', 'radicado'])
            ->where(function($q) use ($nitEmpresa) {
                $q->where('recibido.nit_empresa', $nitEmpresa)
                  ->orWhereHas('registradoPor', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  })
                  ->orWhereHas('destinatarios', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  });
            })
            ->get()
            ->map(function ($item) {
                $radicadoNum = $item->radicado ? $item->radicado->num_radicado : 'N/A';

                if ($item->destinatarios->count() > 0) {
                    $dest = $item->destinatarios->first();
                    $destNombre = $dest->emple_nombres . ' ' . $dest->emple_apellidos;
                    $destDoc = $dest->emple_doc;
                } elseif ($item->registradoPor) {
                    $destNombre = $item->registradoPor->emple_nombres . ' ' . $item->registradoPor->emple_apellidos;
                    $destDoc = $item->registradoPor->emple_doc;
                } else {
                    $destNombre = 'N/A';
                    $destDoc = null;
                }

                return (object) [
                    'origen'              => 'Externa',
                    'num_radicado_ext'    => $item->num_radicado_ext ?? 'N/A',
                    'num_radicado_int'    => $radicadoNum,
                    'nom_institucion'     => $item->nom_institucion ?? ($item->nombre_persona ?? 'Externo'),
                    'ciudad'              => $item->ciudad ? $item->ciudad->ciudad_nom : $item->ciudad_proveniente,
                    'asunto'             => $item->asunto,
                    'fecha'              => $item->fecha_hora_recib,
                    'registrado_por_nombre' => $item->registradoPor
                                             ? $item->registradoPor->emple_nombres . ' ' . $item->registradoPor->emple_apellidos
                                             : ($item->nombre_persona ?? 'Ciudadano/Externo'),
                    'doc_registra'        => $item->registradoPor ? $item->registradoPor->emple_doc : ($item->doc_persona ?? '-'),
                    'destinatario_nombre' => $destNombre,
                    'doc_destinatario'    => $destDoc,
                    'folio'               => $item->folio,
                    'anexo'               => $item->anexo,
                    'estado_nomb'         => $item->estado ? $item->estado->estado_nomb : 'Desconocido',
                    'archivo'             => $item->archivo,
                ];
            })
            ->sortByDesc('fecha')
            ->values();

        // ---- Correspondencia Interna (Envio) ----
        // Incluye documentos donde la empresa sea el remitente o el destinatario
        $envios = \App\Models\Envio::with(['quienDirigido', 'quienEnvia', 'estadoEnvio', 'radicado'])
            ->where(function($q) use ($nitEmpresa) {
                $q->whereHas('quienEnvia', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  })
                  ->orWhereHas('quienDirigido', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  });
            })
            ->get()
            ->map(function ($item) {
                $radicadoNum = $item->radicado ? $item->radicado->num_radicado : 'N/A';

                return (object) [
                    'origen' => 'Interna',
                    'num_radicado_ext' => 'N/A',
                    'num_radicado_int' => $item->num_radicado_int,
                    'nom_institucion' => $item->quienEnvia ? $item->quienEnvia->emple_nombres . ' ' . $item->quienEnvia->emple_apellidos : 'N/A',
                    'ciudad' => 'N/A',
                    'asunto' => $item->asunto,
                    'fecha' => $item->fecha,
                    'destinatario_nombre' => $item->quienDirigido ? $item->quienDirigido->rem_nombres . ' ' . $item->quienDirigido->rem_apellidos : $item->destino,
                    'doc_destinatario' => $item->doc_quien_registra,
                    'folio' => $item->folio,
                    'anexo' => $item->anexo,
                    'estado_nomb' => $item->estadoEnvio ? $item->estadoEnvio->estado_nomb : 'Desconocido',
                    'archivo' => $item->archivo
                ];
            })
            ->sortByDesc('fecha')
            ->values();

        return [
            'recibidos' => $recibidos,
            'envios'    => $envios,
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

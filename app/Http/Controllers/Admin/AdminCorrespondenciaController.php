<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recibido;
use App\Models\Envio;
use App\Models\DetalleEnvio;
use App\Models\DetalleRecibido;
use Illuminate\Http\Request;
use App\Exports\CorrespondenciaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AdminCorrespondenciaController extends Controller
{
    public function index()
    {
        $nitEmpresa = Auth::user()->nit_empresa;

        // ---- 1. Correspondencia Externa (Recibida) ----
        $queryExt = $this->getBaseRecibidosQuery($nitEmpresa);

        $totalRecibidas = (clone $queryExt)->count();
        $enTramite      = (clone $queryExt)->where('id_estado_rec', 8)->count();
        $finalizadas    = (clone $queryExt)->where('id_estado_rec', 9)->count();
        $archivadas     = (clone $queryExt)->where('id_estado_rec', 10)->count();
        $vencidas       = 0; 

        $correspondencias = $queryExt->orderBy('id_recibido', 'desc')->paginate(15, ['*'], 'ext_page');

        // ---- 2. Correspondencia Interna (Envio) ----
        $queryInt = $this->getBaseEnviosQuery($nitEmpresa);

        $totalInternas = (clone $queryInt)->count();
        $enTramiteInt  = (clone $queryInt)->where('id_estado_envio', 8)->count();
        $finalizadasInt = (clone $queryInt)->where('id_estado_envio', 9)->count();
        $archivadasInt  = (clone $queryInt)->where('id_estado_envio', 10)->count();
        $vencidasInt   = 0; 

        $correspondenciasInternas = $queryInt->orderBy('id_envio', 'desc')->paginate(15, ['*'], 'int_page');

        return view('admin.correspondencia', compact(
            'correspondencias', 'totalRecibidas', 'enTramite', 'finalizadas', 'archivadas', 'vencidas',
            'correspondenciasInternas', 'totalInternas', 'enTramiteInt', 'finalizadasInt', 'archivadasInt', 'vencidasInt'
        ));
    }

    private function getCorrespondenciaFiltered()
    {
        $nitEmpresa = Auth::user()->nit_empresa;

        $recibidos = $this->getBaseRecibidosQuery($nitEmpresa)
            ->get()
            ->map(function ($item) {
                return $this->formatRecibidoExport($item);
            })
            ->sortByDesc('fecha')
            ->values();

        $envios = $this->getBaseEnviosQuery($nitEmpresa)
            ->get()
            ->map(function ($item) {
                return $this->formatEnvioExport($item);
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

    public function historialInterna($id)
    {
        $detalle = DetalleEnvio::with(['envio.radicado', 'envio.tipoEnvio', 'envio.anexos', 'quienEnvia.area', 'quienRecibe.area'])
            ->where('id_envio', $id)->first();

        if (!$detalle) {
            $env = Envio::with(['radicado', 'tipoEnvio', 'anexos', 'quienEnvia.area'])->findOrFail($id);
            $detalle = (object)[
                'envio' => $env,
                'quienEnvia' => $env->quienEnvia,
                'id_envio' => $id
            ];
        }

        $trazabilidad = DetalleEnvio::with(['quienRecibe', 'estado', 'anexosRespuesta'])
            ->where('id_envio', $id)
            ->orderBy('fecha_traslado', 'asc')
            ->get();

        $destinatarios = $trazabilidad->groupBy('id_quien_recibe');
        $empleados = []; 

        return view('admin.historial_interna', compact('detalle', 'trazabilidad', 'destinatarios', 'empleados'));
    }

    public function historialExterna($id)
    {
        $recibido = Recibido::with(['radicado', 'tipo.prioridad', 'anexos', 'registradoPor.area'])->findOrFail($id);
        
        $trazabilidad = DetalleRecibido::with(['empleado.area', 'estado', 'anexosRespuesta'])
            ->where('det_id_recibido', $id)
            ->orderBy('fecha_re', 'asc')
            ->get();

        $destinatarios = $trazabilidad->groupBy('det_doc_empleado');
        $empleados = []; 

        $remitenteMock = (object)[
            'emple_nombres' => $recibido->registradoPor ? $recibido->registradoPor->emple_nombres : ($recibido->nom_institucion ?? ($recibido->nombre_persona ?? 'Externo')),
            'emple_apellidos' => $recibido->registradoPor ? $recibido->registradoPor->emple_apellidos : '',
            'area_nom' => $recibido->registradoPor ? ($recibido->registradoPor->area->area_nom ?? 'Sin Área') : 'Externo/Remitente'
        ];

        return view('admin.historial_externa', compact('recibido', 'trazabilidad', 'destinatarios', 'empleados', 'remitenteMock'));
    }

    // ==========================================================
    // MÉTODOS PRIVADOS PARA DRY (Consultas Base)
    // ==========================================================

    private function getBaseRecibidosQuery($nitEmpresa)
    {
        return Recibido::with(['destinatarios', 'registradoPor', 'estado', 'ciudad', 'radicado', 'tipo.prioridad', 'anexos', 'detalles.anexosRespuesta'])
            ->where(function($q) use ($nitEmpresa) {
                $q->where('recibido.nit_empresa', $nitEmpresa)
                  ->orWhereHas('registradoPor', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  })
                  ->orWhereHas('destinatarios', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  });
            });
    }

    private function getBaseEnviosQuery($nitEmpresa)
    {
        return Envio::with(['detalles.quienRecibe', 'quienEnvia', 'estadoEnvio', 'radicado', 'tipoEnvio.prioridad', 'anexos', 'detalles.anexosRespuesta'])
            ->where(function($q) use ($nitEmpresa) {
                $q->where('envio.nit_empresa', $nitEmpresa)
                  ->orWhereHas('quienEnvia', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  })
                  ->orWhereHas('detalles.quienRecibe', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  });
            });
    }

    private function getDigitalAnexosCount($item)
    {
        $count = $item->anexos ? $item->anexos->count() : 0;
        if ($item->detalles) {
            foreach ($item->detalles as $det) {
                if ($det->anexosRespuesta) {
                    $count += $det->anexosRespuesta->count();
                }
            }
        }
        return $count;
    }

    private function formatRecibidoExport($item)
    {
        $radicadoNum = $item->radicado ? $item->radicado->num_radicado : 'N/A';
        $destNombre = 'N/A';
        $destDoc = null;

        if ($item->destinatarios->count() > 0) {
            $dest = $item->destinatarios->first();
            $destNombre = $dest->emple_nombres . ' ' . $dest->emple_apellidos;
            $destDoc = $dest->emple_doc;
        } elseif ($item->registradoPor) {
            $destNombre = $item->registradoPor->emple_nombres . ' ' . $item->registradoPor->emple_apellidos;
            $destDoc = $item->registradoPor->emple_doc;
        }

        return (object) [
            'origen'                => 'Externa',
            'num_radicado_ext'      => $item->num_radicado_ext ?? null,
            'num_radicado_int'      => $radicadoNum,
            'nom_institucion'       => $item->nom_institucion ?? ($item->nombre_persona ?? 'Externo'),
            'ciudad'                => $item->ciudad ? $item->ciudad->ciudad_nom : $item->ciudad_proveniente,
            'asunto'                => $item->asunto,
            'fecha'                 => $item->fecha_hora_recib,
            'registrado_por_nombre' => $item->registradoPor
                                     ? $item->registradoPor->emple_nombres . ' ' . $item->registradoPor->emple_apellidos
                                     : ($item->nombre_persona ?? 'Ciudadano/Externo'),
            'doc_registra'          => $item->registradoPor ? $item->registradoPor->emple_doc : ($item->doc_persona ?? '-'),
            'destinatario_nombre'   => $destNombre,
            'doc_destinatario'      => $destDoc,
            'folio'                 => $item->folio,
            'anexo'                 => $item->anexo,
            'digital_anexos'        => $this->getDigitalAnexosCount($item),
            'estado_nomb'           => $item->estado ? $item->estado->estado_nomb : 'Desconocido',
            'archivo'               => $item->archivo,
        ];
    }

    private function formatEnvioExport($item)
    {
        $radicadoNum = $item->radicado ? $item->radicado->num_radicado : 'N/A';
        $destNombre = $item->destino ?? 'Destino no especificado';
        $destDoc = null;

        if ($item->detalles->count() > 0) {
            $det = $item->detalles->first();
            if ($det && $det->quienRecibe) {
                $destNombre = $det->quienRecibe->emple_nombres . ' ' . $det->quienRecibe->emple_apellidos;
                $destDoc = $det->quienRecibe->emple_doc;
            }
        }

        return (object) [
            'origen'                => 'Interna',
            'num_radicado_ext'      => null,
            'num_radicado_int'      => $radicadoNum,
            'nom_institucion'       => $item->quienEnvia
                                     ? $item->quienEnvia->emple_nombres . ' ' . $item->quienEnvia->emple_apellidos
                                     : 'N/A',
            'ciudad'                => 'N/A',
            'asunto'                => $item->asunto,
            'fecha'                 => $item->fecha,
            'registrado_por_nombre' => $item->quienEnvia
                                     ? $item->quienEnvia->emple_nombres . ' ' . $item->quienEnvia->emple_apellidos
                                     : 'N/A',
            'doc_registra'          => $item->quienEnvia ? $item->quienEnvia->emple_doc : '-',
            'destinatario_nombre'   => $destNombre,
            'doc_destinatario'      => $destDoc,
            'folio'                 => $item->folio,
            'anexo'                 => null,
            'digital_anexos'        => $this->getDigitalAnexosCount($item),
            'estado_nomb'           => $item->estadoEnvio ? $item->estadoEnvio->estado_nomb : 'Desconocido',
            'archivo'               => $item->archivo,
        ];
    }
}

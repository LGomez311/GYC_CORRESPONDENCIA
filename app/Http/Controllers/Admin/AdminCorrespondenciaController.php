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
    /**
     * VISTA PRINCIPAL DE CORRESPONDENCIA (ADMIN)
     * Centraliza la visualización de correspondencia externa, interna y saliente con contadores globales.
     */
    public function index(Request $request)
    {
        $nitEmpresa = Auth::user()->nit_empresa;

        // ---- 1. Correspondencia Externa (Recibida) ----
        $queryExt = $this->getBaseRecibidosQuery($nitEmpresa, $request);

        $totalRecibidas = (clone $queryExt)->count();
        $enTramite      = (clone $queryExt)->where('id_estado_rec', 8)->count();
        $finalizadas    = (clone $queryExt)->where('id_estado_rec', 9)->count();
        $archivadas     = (clone $queryExt)->where('id_estado_rec', 10)->count();
        $vencidas       = 0;

        $correspondencias = $queryExt->paginate(15, ['*'], 'ext_page');

        // ---- 2. Correspondencia Interna (solo prefijo INT-) ----
        $queryInt = $this->getBaseEnviosQuery($nitEmpresa, $request)
            ->whereHas('radicado', fn($q) => $q->where('num_radicado', 'like', 'INT-%'));

        $totalInternas = (clone $queryInt)->count();
        $enTramiteInt  = (clone $queryInt)->where('id_estado_envio', 8)->count();
        $finalizadasInt = (clone $queryInt)->where('id_estado_envio', 9)->count();
        $archivadasInt  = (clone $queryInt)->where('id_estado_envio', 10)->count();
        $vencidasInt   = 0;

        $correspondenciasInternas = $queryInt->paginate(15, ['*'], 'int_page');

        // ---- 3. T3: Correspondencia Saliente (Strictly SAL-) ----
        $querySal = $this->getBaseEnviosQuery($nitEmpresa, $request)
            ->whereHas('radicado', fn($qr) => $qr->where('num_radicado', 'like', 'SAL-%'));

        $totalSalientes = (clone $querySal)->count();
        $correspondenciasSalientes = $querySal->paginate(15, ['*'], 'sal_page');

        // Data for filters
        $ciudades = \App\Models\Ciudad::orderBy('ciudad_nom')->get();
        $tipos = \App\Models\Tipo::orderBy('tipo_nombre')->get();

        return view('admin.correspondencia', compact(
            'correspondencias', 'totalRecibidas', 'enTramite', 'finalizadas', 'archivadas', 'vencidas',
            'correspondenciasInternas', 'totalInternas', 'enTramiteInt', 'finalizadasInt', 'archivadasInt', 'vencidasInt',
            'correspondenciasSalientes', 'totalSalientes',
            'ciudades', 'tipos'
        ));
    }

    private function getCorrespondenciaFiltered(Request $request = null)
    {
        $nitEmpresa = Auth::user()->nit_empresa;

        $recibidos = $this->getBaseRecibidosQuery($nitEmpresa, $request)
            ->get()
            ->map(function ($item) {
                return $this->formatRecibidoExport($item);
            })
            ->sortByDesc('fecha')
            ->values();

        $envios = $this->getBaseEnviosQuery($nitEmpresa, $request)
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

    /**
     * EXPORTAR A EXCEL
     * Genera un archivo .xlsx filtrado según la pestaña activa y los criterios de búsqueda.
     */
    public function exportExcel(Request $request)
    {
        $data = $this->getCorrespondenciaFiltered($request);
        $tab = $request->get('tab', 'todas');

        if ($tab === 'externa') {
            $correspondencias = $data['recibidos'];
        } elseif ($tab === 'interna') {
            $correspondencias = $data['envios']->filter(fn($i) => $i->origen === 'Interna');
        } elseif ($tab === 'saliente') {
            $correspondencias = $data['envios']->filter(fn($i) => $i->origen === 'Saliente');
        } else {
            $correspondencias = $data['recibidos']->concat($data['envios'])->sortByDesc('fecha')->values();
        }

        return Excel::download(new CorrespondenciaExport($correspondencias), 'correspondencia_' . $tab . '.xlsx');
    }

    /**
     * EXPORTAR A PDF
     * Genera un listado en PDF con orientación landscape de los registros filtrados.
     */
    public function exportPdf(Request $request)
    {
        $tab = $request->get('tab', 'todas');
        $nitEmpresa = Auth::user()->nit_empresa;

        // Segun tab activa, exportar solo esa categoria
        if ($tab === 'externa') {
            $items = $this->getBaseRecibidosQuery($nitEmpresa, $request)->get()
                ->map(fn($i) => $this->formatRecibidoExport($i));
        } elseif ($tab === 'interna') {
            $items = $this->getBaseEnviosQuery($nitEmpresa, $request)
                ->whereHas('radicado', fn($q) => $q->where('num_radicado', 'like', 'INT-%'))
                ->get()->map(fn($i) => $this->formatEnvioExport($i));
        } elseif ($tab === 'saliente') {
            $items = $this->getBaseEnviosQuery($nitEmpresa, $request)
                ->where(function($q) {
                    $q->whereHas('radicado', fn($qr) => $qr->where('num_radicado', 'like', 'EXT-%')
                        ->orWhere('num_radicado', 'like', 'SAL-%'))
                      ->orWhere('id_estado_envio', 14);
                })
                ->get()->map(fn($i) => $this->formatEnvioExport($i));
        } else {
            // Todas las categorias combinadas
            $data = $this->getCorrespondenciaFiltered($request);
            $items = $data['recibidos']->concat($data['envios']);
        }

        $correspondencias = $items->sortByDesc('fecha')->values();

        // Mapeo de estados para el resumen de filtros
        $estadosMap = ['7' => 'Recibido', '8' => 'En Trámite', '9' => 'Resuelto', '10' => 'Archivado', '11' => 'Rechazado'];
        $estadoNome = isset($estadosMap[$request->estado_fil]) ? $estadosMap[$request->estado_fil] : $request->estado_fil;

        $filtrosActivos = array_filter([
            'Tipo' => $request->tipo ? \App\Models\Tipo::find($request->tipo)?->tipo_nombre : null,
            'Estado' => $estadoNome,
            'Desde' => $request->fecha_desde,
            'Hasta' => $request->fecha_hasta,
            'Busqueda' => $request->q,
            'Pestaña' => $tab !== 'todas' ? ucfirst($tab) : null,
        ]);

        $pdf = Pdf::loadView('admin.pdf.correspondencia_pdf', compact('correspondencias', 'filtrosActivos'))->setPaper('A4', 'landscape');
        return $pdf->download('correspondencia_' . $tab . '.pdf');
    }

    /**
     * VER HISTORIAL DE CORRESPONDENCIA INTERNA
     * Carga el detalle y la línea de tiempo de trazabilidad para un radicado tipo INT/SAL.
     */
    public function historialInterna($id)
    {
        $env = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'anexos', 'quienEnvia.area'])->findOrFail($id);
        $radId = $env->num_radicado_int;

        // Fetch ALL related records sharing the same Radicado
        $recibidos = \App\Models\Recibido::with(['registradoPor.area', 'remitenteRegistrador', 'detalles.empleado.area', 'detalles.estado', 'detalles.anexosRespuesta'])
            ->where('num_radicado_int', $radId)
            ->get();

        $envios = \App\Models\Envio::with(['quienEnvia.area', 'tipoEnvio', 'detalles.quienRecibe.area', 'detalles.estado', 'detalles.anexosRespuesta'])
            ->where('num_radicado_int', $radId)
            ->get();

        $timeline = collect();

        // 1. Process Recibidos
        foreach ($recibidos as $rec) {
            // Main Registration Event
            $statusId = $rec->detalles->first()->det_id_estado ?? 7; // Default to Received
            $timeline->push((object)[
                'tipo' => 'Entrada',
                'fecha' => $rec->created_at ?? $rec->fecha_hora_recib,
                'titulo' => 'Ingreso a Ventanilla',
                'id_estado' => $statusId,
                'det_id_estado' => $statusId,
                'id_estado_rec' => $statusId,
                'id_estado_envio' => $statusId,
                'responsable' => ($rec->registradoPor->emple_nombres ?? 'Ventanilla') . ' ' . ($rec->registradoPor->emple_apellidos ?? ''),
                'area' => $rec->registradoPor->area->area_nom ?? 'Recepción',
                'detalle' => '(Radicado Principal) ' . $rec->asunto,
                'icon' => 'inbox',
                'color' => 'bg-blue-600',
                'original' => $rec,
                'is_main' => true
            ]);

            // Its Traceability
            foreach ($rec->detalles as $det) {
                $nombre = $det->empleado->emple_nombres ?? 'N/A';
                $apellido = $det->empleado->emple_apellidos ?? '';
                $area = $det->empleado->area->area_nom ?? 'Sin Área';

                if (stripos($det->observaciones, '(Remitente)') !== false || stripos($det->observaciones, 'Ventanilla') !== false) {
                     $rem = $rec->remitenteRegistrador;
                     if ($rem) {
                         $nombre = $rem->rem_nombres;
                         $apellido = $rem->rem_apellidos;
                         $area = 'Ventanilla / Remitente Exterior';
                     }
                }

                $statusName = strtolower($det->estado->estado_nomb ?? '');
                $isResolved = in_array($det->det_id_estado, [9, 10]) || 
                             str_contains($statusName, 'resuelt') || 
                             str_contains($statusName, 'finaliz') || 
                             str_contains($statusName, 'archiv');

                $timeline->push((object)[
                    'tipo' => 'Entrada',
                    'fecha' => $det->fecha_re,
                    'titulo' => $det->estado->estado_nomb ?? 'Gestión',
                    'id_estado' => $det->det_id_estado,
                    'det_id_estado' => $det->det_id_estado,
                    'id_estado_rec' => $det->det_id_estado,
                    'id_estado_envio' => $det->det_id_estado,
                    'responsable' => "$nombre $apellido",
                    'area' => $area,
                    'detalle' => $det->observaciones,
                    'icon' => $isResolved ? 'check_circle' : 'pending_actions',
                    'color' => $isResolved ? 'bg-green-600' : 'bg-blue-400',
                    'original' => $det,
                    'is_main' => false
                ]);
            }
        }

        // 2. Process Envios
        foreach ($envios as $e) {
            $isResolved = in_array($e->id_estado_envio, [9, 10]);
            // Main Outgoing Registration Event
            $timeline->push((object)[
                'tipo' => 'Salida',
                'fecha' => $e->created_at ?? $e->fecha,
                'titulo' => 'Radicado Saliente Generado',
                'id_estado' => $e->id_estado_envio,
                'det_id_estado' => $e->id_estado_envio,
                'id_estado_rec' => $e->id_estado_envio,
                'id_estado_envio' => $e->id_estado_envio,
                'responsable' => ($e->quienEnvia->emple_nombres ?? 'Ventanilla') . ' ' . ($e->quienEnvia->emple_apellidos ?? ''),
                'area' => $e->quienEnvia->area->area_nom ?? 'Oficina',
                'detalle' => '(Documento de Respuesta/Envío) ' . $e->asunto,
                'icon' => $isResolved ? 'check_circle' : 'outgoing_mail',
                'color' => $isResolved ? 'bg-green-600' : 'bg-amber-600',
                'original' => $e,
                'is_main' => true
            ]);

            // Its Traceability
            foreach ($e->detalles as $det) {
                $statusName = strtolower($det->estado->estado_nomb ?? '');
                $isResolved = in_array($det->id_estado_rec, [9, 10]) || 
                             str_contains($statusName, 'resuelt') || 
                             str_contains($statusName, 'finaliz') || 
                             str_contains($statusName, 'archiv');
                
                $timeline->push((object)[
                    'tipo' => 'Salida',
                    'fecha' => $det->fecha_traslado,
                    'titulo' => $det->estado->estado_nomb ?? 'Gestión Interna',
                    'id_estado' => $det->id_estado_rec,
                    'det_id_estado' => $det->id_estado_rec,
                    'id_estado_rec' => $det->id_estado_rec,
                    'id_estado_envio' => $det->id_estado_rec,
                    'responsable' => ($det->quienRecibe->emple_nombres ?? 'N/A') . ' ' . ($det->quienRecibe->emple_apellidos ?? ''),
                    'area' => $det->quienRecibe->area->area_nom ?? 'Sin Área',
                    'detalle' => $det->observaciones,
                    'icon' => $isResolved ? 'check_circle' : 'move_to_inbox',
                    'color' => $isResolved ? 'bg-green-600' : 'bg-amber-400',
                    'original' => $det,
                    'is_main' => false
                ]);
            }
        }

        $timeline = $timeline->sortBy('fecha');

        // We use $trazabilidad as the variable name for the view to minimize changes
        $trazabilidad = $timeline;
        $detalle = \App\Models\DetalleEnvio::where('id_envio', $id)->first() ?? (object)['envio' => $env, 'quienEnvia' => $env->quienEnvia, 'id_envio' => $id];
        $destinatarios = $trazabilidad->groupBy('responsable'); // Simplified grouping for sidebars if used
        $empleados = [];

        return view('admin.historial_interna', compact('detalle', 'trazabilidad', 'destinatarios', 'empleados'));
    }

    /**
     * VER HISTORIAL DE CORRESPONDENCIA EXTERNA
     * Muestra la trazabilidad detallada de un radicado tipo EXT recibido desde ventanilla o externo.
     */
    public function historialExterna($id)
    {
        $recibido = \App\Models\Recibido::with(['radicado', 'tipo.prioridad', 'anexos', 'registradoPor.area', 'remitenteRegistrador'])->findOrFail($id);
        $radId = $recibido->num_radicado_int;

        // Fetch ALL related records sharing the same Radicado
        $recibidos = \App\Models\Recibido::with(['registradoPor.area', 'remitenteRegistrador', 'detalles.empleado.area', 'detalles.estado', 'detalles.anexosRespuesta'])
            ->where('num_radicado_int', $radId)
            ->get();

        $envios = \App\Models\Envio::with(['quienEnvia.area', 'tipoEnvio', 'detalles.quienRecibe.area', 'detalles.estado', 'detalles.anexosRespuesta'])
            ->where('num_radicado_int', $radId)
            ->get();

        $timeline = collect();

        // 1. Process Recibidos
        foreach ($recibidos as $rec) {
            $statusId = $rec->detalles->first()->det_id_estado ?? 7;
            $timeline->push((object)[
                'tipo' => 'Entrada',
                'fecha' => $rec->created_at ?? $rec->fecha_hora_recib,
                'titulo' => 'Ingreso a Ventanilla',
                'id_estado' => $statusId,
                'det_id_estado' => $statusId,
                'id_estado_rec' => $statusId,
                'id_estado_envio' => $statusId,
                'responsable' => ($rec->registradoPor->emple_nombres ?? 'Ventanilla') . ' ' . ($rec->registradoPor->emple_apellidos ?? ''),
                'area' => $rec->registradoPor->area->area_nom ?? 'Recepción',
                'detalle' => '(Radicado Principal) ' . $rec->asunto,
                'icon' => 'inbox',
                'color' => 'bg-blue-600',
                'original' => $rec,
                'is_main' => true
            ]);

            foreach ($rec->detalles as $det) {
                $nombre = $det->empleado->emple_nombres ?? 'N/A';
                $apellido = $det->empleado->emple_apellidos ?? '';
                $area = $det->empleado->area->area_nom ?? 'Sin Área';

                if (stripos($det->observaciones, '(Remitente)') !== false || stripos($det->observaciones, 'Ventanilla') !== false) {
                     $rem = $rec->remitenteRegistrador;
                     if ($rem) {
                          $nombre = $rem->rem_nombres;
                          $apellido = $rem->rem_apellidos;
                          $area = 'Ventanilla / Remitente Exterior';
                     }
                }

                $statusName = strtolower($det->estado->estado_nomb ?? '');
                $isResolved = in_array($det->det_id_estado, [9, 10]) || 
                             str_contains($statusName, 'resuelt') || 
                             str_contains($statusName, 'finaliz') || 
                             str_contains($statusName, 'archiv');

                $timeline->push((object)[
                    'tipo' => 'Entrada',
                    'fecha' => $det->fecha_re,
                    'titulo' => $det->estado->estado_nomb ?? 'Gestión',
                    'id_estado' => $det->det_id_estado,
                    'det_id_estado' => $det->det_id_estado,
                    'id_estado_rec' => $det->det_id_estado,
                    'id_estado_envio' => $det->det_id_estado,
                    'responsable' => "$nombre $apellido",
                    'area' => $area,
                    'detalle' => $det->observaciones,
                    'icon' => $isResolved ? 'check_circle' : 'pending_actions',
                    'color' => $isResolved ? 'bg-green-600' : 'bg-blue-400',
                    'original' => $det,
                    'is_main' => false
                ]);
            }
        }

        // 2. Process Envios
        foreach ($envios as $e) {
            $isResolved = in_array($e->id_estado_envio, [9, 10]);
            $timeline->push((object)[
                'tipo' => 'Salida',
                'fecha' => $e->created_at ?? $e->fecha,
                'titulo' => 'Radicado Saliente Generado',
                'id_estado' => $e->id_estado_envio,
                'det_id_estado' => $e->id_estado_envio,
                'id_estado_rec' => $e->id_estado_envio,
                'id_estado_envio' => $e->id_estado_envio,
                'responsable' => ($e->quienEnvia->emple_nombres ?? 'Ventanilla') . ' ' . ($e->quienEnvia->emple_apellidos ?? ''),
                'area' => $e->quienEnvia->area->area_nom ?? 'Oficina',
                'detalle' => '(Documento de Respuesta/Envío) ' . $e->asunto,
                'icon' => $isResolved ? 'check_circle' : 'outgoing_mail',
                'color' => $isResolved ? 'bg-green-600' : 'bg-amber-600',
                'original' => $e,
                'is_main' => true
            ]);

            foreach ($e->detalles as $det) {
                $statusName = strtolower($det->estado->estado_nomb ?? '');
                $isResolved = in_array($det->id_estado_rec, [9, 10]) || 
                             str_contains($statusName, 'resuelt') || 
                             str_contains($statusName, 'finaliz') || 
                             str_contains($statusName, 'archiv');

                $timeline->push((object)[
                    'tipo' => 'Salida',
                    'fecha' => $det->fecha_traslado,
                    'titulo' => $det->estado->estado_nomb ?? 'Gestión Interna',
                    'id_estado' => $det->id_estado_rec,
                    'det_id_estado' => $det->id_estado_rec,
                    'id_estado_rec' => $det->id_estado_rec,
                    'id_estado_envio' => $det->id_estado_rec,
                    'responsable' => ($det->quienRecibe->emple_nombres ?? 'N/A') . ' ' . ($det->quienRecibe->emple_apellidos ?? ''),
                    'area' => $det->quienRecibe->area->area_nom ?? 'Sin Área',
                    'detalle' => $det->observaciones,
                    'icon' => $isResolved ? 'check_circle' : 'move_to_inbox',
                    'color' => $isResolved ? 'bg-green-600' : 'bg-amber-400',
                    'original' => $det,
                    'is_main' => false
                ]);
            }
        }

        $timeline = $timeline->sortBy('fecha');

        $trazabilidadRaw = $timeline; // Alias to match existing Blade
        $destinatarios = $trazabilidadRaw->groupBy('responsable');
        $empleados = [];
        $ultimo = $trazabilidadRaw->last();
        $remitenteMock = (object)[
            'emple_nombres' => $recibido->registradoPor ? $recibido->registradoPor->emple_nombres : ($recibido->nom_institucion ?? ($recibido->nombre_persona ?? 'Externo')),
            'emple_apellidos' => $recibido->registradoPor ? $recibido->registradoPor->emple_apellidos : '',
            'area_nom' => $recibido->registradoPor ? ($recibido->registradoPor->area->area_nom ?? 'Sin Área') : 'Externo/Remitente'
        ];

        return view('admin.historial_externa', compact('recibido', 'trazabilidadRaw', 'destinatarios', 'empleados', 'ultimo', 'remitenteMock'));
    }

    // ==========================================================
    // MÉTODOS PRIVADOS PARA DRY (Consultas Base)
    // ==========================================================

    /**
     * CONSULTA BASE DE RECIBIDOS
     * Aplica los filtros de búsqueda y empresa para registros de correspondencia externa.
     */
    private function getBaseRecibidosQuery($nitEmpresa, Request $request = null)
    {
        $query = Recibido::with(['destinatarios', 'registradoPor', 'estado', 'ciudad', 'radicado', 'tipo.prioridad', 'anexos', 'detalles.anexosRespuesta'])
            ->where(function($q) use ($nitEmpresa) {
                $q->where('recibido.nit_empresa', $nitEmpresa)
                  ->orWhereHas('registradoPor', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  })
                  ->orWhereHas('destinatarios', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  });
            });

        if ($request) {
            if ($request->q) {
                $query->where(function($q) use ($request) {
                    $q->where('asunto', 'LIKE', '%' . $request->q . '%')
                      ->orWhereHas('radicado', function($qr) use ($request) {
                          $qr->where('num_radicado', 'LIKE', '%' . $request->q . '%');
                      })
                      ->orWhere('nom_institucion', 'LIKE', '%' . $request->q . '%')
                      ->orWhere('nombre_persona', 'LIKE', '%' . $request->q . '%');
                });
            }
            if ($request->ciudad) {
                $query->where('ciudad_proveniente', $request->ciudad);
            }
            // T5: Filtro por tipo de documento
            if ($request->tipo) {
                $query->where('id_tipo', $request->tipo);
            }
            // T6: Filtro por estado
            if ($request->estado_fil) {
                $query->where('id_estado_rec', $request->estado_fil);
            }
            // T6: Filtro por rango de fechas
            if ($request->fecha_desde) {
                $query->whereDate('fecha_hora_recib', '>=', $request->fecha_desde);
            }
            if ($request->fecha_hasta) {
                $query->whereDate('fecha_hora_recib', '<=', $request->fecha_hasta);
            }
        }

        // Ordenamiento: Fecha de Recepción (DESC)
        $query->orderBy('fecha_hora_recib', 'desc');

        return $query;
    }

    /**
     * CONSULTA BASE DE ENVIOS
     * Aplica filtros para correspondencia interna y saliente.
     */
    private function getBaseEnviosQuery($nitEmpresa, Request $request = null)
    {
        $query = Envio::with(['detalles.quienRecibe', 'quienEnvia', 'estadoEnvio', 'radicado', 'tipoEnvio.prioridad', 'anexos', 'detalles.anexosRespuesta'])
            ->where(function($q) use ($nitEmpresa) {
                $q->where('envio.nit_empresa', $nitEmpresa)
                  ->orWhereHas('quienEnvia', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  })
                  ->orWhereHas('detalles.quienRecibe', function($q2) use ($nitEmpresa) {
                      $q2->where('nit_empresa', $nitEmpresa);
                  });
            });

        if ($request) {
            if ($request->q) {
                $query->where(function($q) use ($request) {
                    $q->where('asunto', 'LIKE', '%' . $request->q . '%')
                      ->orWhereHas('radicado', function($qr) use ($request) {
                          $qr->where('num_radicado', 'LIKE', '%' . $request->q . '%');
                      })
                      ->orWhere('nom_institucion', 'LIKE', '%' . $request->q . '%')
                      ->orWhere('nombre_persona', 'LIKE', '%' . $request->q . '%');
                });
            }
            // T5: Filtro por tipo de documento
            if ($request->tipo) {
                $query->where('id_tipo_envio', $request->tipo);
            }
            // T6: Filtro por estado
            if ($request->estado_fil) {
                $query->where('id_estado_envio', $request->estado_fil);
            }
            // T6: Filtro por rango de fechas
            if ($request->fecha_desde) {
                $query->whereDate('fecha', '>=', $request->fecha_desde);
            }
            if ($request->fecha_hasta) {
                $query->whereDate('fecha', '<=', $request->fecha_hasta);
            }

            // Si se filtra por ciudad, y Envio no tiene ciudad, por lógica de negocio
            // podríamos querer filtrar envíos que van a esa ciudad (destino) o simplemente ignorar.
            // Por ahora ignoramos para no vaciar la tabla si es una búsqueda general,
            // pero si el usuario explícitamente selecciona una ciudad, tal vez espera no ver envíos internos.
        }

        // Ordenamiento: Fecha de Envío (DESC)
        $query->orderBy('fecha', 'desc');

        return $query;
    }

    // T4: Endpoint para obtener estado actual de una correspondencia (JSON)
    public function getEstadoRecibido($id)
    {
        $rec = Recibido::with('estado')->find($id);
        if (!$rec) return response()->json(['estado' => 'N/A', 'estado_id' => null], 404);
        return response()->json([
            'estado' => $rec->estado ? $rec->estado->estado_nomb : 'Sin estado',
            'estado_id' => $rec->id_estado_rec
        ]);
    }

    public function getEstadoEnvio($id)
    {
        $env = Envio::with('estadoEnvio')->find($id);
        if (!$env) return response()->json(['estado' => 'N/A', 'estado_id' => null], 404);
        return response()->json([
            'estado' => $env->estadoEnvio ? $env->estadoEnvio->estado_nomb : 'Sin estado',
            'estado_id' => $env->id_estado_envio
        ]);
    }

    /**
     * OBTENER TRAZABILIDAD (JSON API)
     * Método centralizado para reconstruir la cronología de eventos de cualquier radicado.
     */
    public function getHistory($id)
    {
        try {
            // Priority 1: Check if the ID is already a Radicado ID
            $isRadicado = \Illuminate\Support\Facades\DB::table('radicados')->where('id_radicado', $id)->exists();
            if ($isRadicado) {
                $radId = $id;
            } else {
                // Priority 2: Traditional ID lookup (Recibido or Envio)
                $radId = \Illuminate\Support\Facades\DB::table('recibido')->where('id_recibido', $id)->value('num_radicado_int');
                if (!$radId) {
                    $radId = \Illuminate\Support\Facades\DB::table('envio')->where('id_envio', $id)->value('num_radicado_int');
                }
            }

            if (!$radId) return response()->json([]);

            // 1. Initial Registrations (Incoming)
            $recibidos = \Illuminate\Support\Facades\DB::table('recibido as r')
                ->join('radicados as rad', 'r.num_radicado_int', '=', 'rad.id_radicado')
                ->leftJoin('remitente as rem', 'r.doc_quien_registra', '=', 'rem.rem_doc')
                ->where('r.num_radicado_int', $radId)
                ->select(
                    \Illuminate\Support\Facades\DB::raw("'registry' as type"),
                    'r.fecha_hora_recib as fecha',
                    \Illuminate\Support\Facades\DB::raw("COALESCE(rem.rem_nombres, 'Sistema') as nombres"),
                    \Illuminate\Support\Facades\DB::raw("COALESCE(rem.rem_apellidos, 'Ventanilla') as apellidos"),
                    'rad.num_radicado',
                    \Illuminate\Support\Facades\DB::raw("'Ingreso a Ventanilla' as estado_nomb"),
                    'r.asunto as observaciones',
                    \Illuminate\Support\Facades\DB::raw("NULL as img")
                )->get();

            // 2. Registrations (Outgoing)
            $envios = \Illuminate\Support\Facades\DB::table('envio as env')
                ->join('radicados as rad', 'env.num_radicado_int', '=', 'rad.id_radicado')
                ->leftJoin('remitente as rem', 'env.doc_quien_registra', '=', 'rem.rem_doc')
                ->leftJoin('empleado as emp_env', 'env.doc_quien_envia', '=', 'emp_env.emple_doc')
                ->where('env.num_radicado_int', $radId)
                ->select(
                    \Illuminate\Support\Facades\DB::raw("'registry' as type"),
                    'env.fecha as fecha',
                    \Illuminate\Support\Facades\DB::raw("COALESCE(rem.rem_nombres, 'Sistema') as nombres"),
                    \Illuminate\Support\Facades\DB::raw("COALESCE(rem.rem_apellidos, 'Oficial') as apellidos"),
                    'rad.num_radicado',
                    \Illuminate\Support\Facades\DB::raw("'Registro de Salida/Respuesta' as estado_nomb"),
                    \Illuminate\Support\Facades\DB::raw("CONCAT('Origen: ', COALESCE(emp_env.emple_nombres, 'N/A'), ' ', COALESCE(emp_env.emple_apellidos, ''), ' | Asunto: ', env.asunto) as observaciones"),
                    \Illuminate\Support\Facades\DB::raw("NULL as img")
                )->get();

            // 3. Lifecycle transitions (Details)
            $detailsRec = \Illuminate\Support\Facades\DB::table('detalle_recibido as dr')
                ->join('recibido as r', 'dr.det_id_recibido', '=', 'r.id_recibido')
                ->leftJoin('estado as e', 'dr.id_estado_rec', '=', 'e.id_estado')
                ->leftJoin('empleado as emp', 'dr.det_doc_empleado', '=', 'emp.emple_doc')
                ->leftJoin('area as area_e', 'emp.emple_area', '=', 'area_e.id_area')
                ->leftJoin('remitente as rem_det', 'dr.det_doc_empleado', '=', 'rem_det.rem_doc')
                ->where('r.num_radicado_int', $radId)
                ->select(
                    \Illuminate\Support\Facades\DB::raw("'detail' as type"),
                    'dr.fecha_re as fecha',
                    \Illuminate\Support\Facades\DB::raw("CASE WHEN dr.observaciones LIKE '%(Remitente)%' THEN COALESCE(rem_det.rem_nombres, 'Ventanilla') ELSE COALESCE(emp.emple_nombres, 'Funcionario') END as nombres"),
                    \Illuminate\Support\Facades\DB::raw("CASE WHEN dr.observaciones LIKE '%(Remitente)%' THEN COALESCE(rem_det.rem_apellidos, '') ELSE COALESCE(emp.emple_apellidos, '') END as apellidos"),
                    \Illuminate\Support\Facades\DB::raw("NULL as num_radicado"),
                    \Illuminate\Support\Facades\DB::raw("COALESCE(e.estado_nomb, 'Gestión') as estado_nomb"),
                    'dr.observaciones',
                    'area_e.area_nom as area_e',
                    'emp.emple_img as img',
                    'dr.id_estado_rec',
                    'dr.id_det_recibido',
                    \Illuminate\Support\Facades\DB::raw("dr.archivo_res as archivo_res")
                )->get();

            $detailsEnv = \Illuminate\Support\Facades\DB::table('detalle_envio as de')
                ->join('envio as env', 'de.id_envio', '=', 'env.id_envio')
                ->leftJoin('estado as e', 'de.id_estado_rec', '=', 'e.id_estado')
                ->leftJoin('empleado as emp', 'de.id_quien_recibe', '=', 'emp.emple_doc')
                ->leftJoin('area as area_e', 'emp.emple_area', '=', 'area_e.id_area')
                ->leftJoin('remitente as rem_det', 'de.id_quien_recibe', '=', 'rem_det.rem_doc')
                ->where('env.num_radicado_int', $radId)
                ->select(
                    \Illuminate\Support\Facades\DB::raw("'detail' as type"),
                    'de.fecha_traslado as fecha',
                    \Illuminate\Support\Facades\DB::raw("CASE WHEN de.observaciones LIKE '%(Remitente)%' THEN COALESCE(rem_det.rem_nombres, 'Ventanilla') ELSE COALESCE(emp.emple_nombres, 'Funcionario') END as nombres"),
                    \Illuminate\Support\Facades\DB::raw("CASE WHEN de.observaciones LIKE '%(Remitente)%' THEN COALESCE(rem_det.rem_apellidos, '') ELSE COALESCE(emp.emple_apellidos, '') END as apellidos"),
                    \Illuminate\Support\Facades\DB::raw("NULL as num_radicado"),
                    \Illuminate\Support\Facades\DB::raw("COALESCE(e.estado_nomb, 'Saliente') as estado_nomb"),
                    'de.observaciones',
                    'area_e.area_nom as area_e',
                    'emp.emple_img as img',
                    'de.id_estado_rec',
                    \Illuminate\Support\Facades\DB::raw("de.id_detalle as id_det_recibido"),
                    \Illuminate\Support\Facades\DB::raw("NULL as archivo_res")
                )->get();

            // Merge and cleanup
            $historyCollection = $recibidos
                ->concat($envios)
                ->concat($detailsRec)
                ->concat($detailsEnv)
                ->sortBy('fecha');

            $finalHistory = [];
            foreach ($historyCollection as $h) {
                $item = (array) $h;
                $finalHistory[] = $item;
            }

            return response()->json($finalHistory);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

        // Exclude role 2 (Admin) from being listed as responsible in exports
        $validDestinatarios = $item->destinatarios->filter(fn($d) => $d->emple_rol != 2);

        if ($validDestinatarios->count() > 0) {
            $dest = $validDestinatarios->first();
            $destNombre = $dest->emple_nombres . ' ' . $dest->emple_apellidos;
            $destDoc = $dest->emple_doc;
        } elseif ($item->registradoPor && $item->registradoPor->emple_rol != 2) {
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
            // Filter recipients: exclude role 2 (Admin)
            $det = $item->detalles->filter(fn($d) => $d->quienRecibe && $d->quienRecibe->emple_rol != 2)->first();
            if ($det && $det->quienRecibe) {
                $destNombre = $det->quienRecibe->emple_nombres . ' ' . $det->quienRecibe->emple_apellidos;
                $destDoc = $det->quienRecibe->emple_doc;
            }
        }

        $origen = 'Interna';
        if (str_contains($radicadoNum, 'SAL-')) {
            $origen = 'Saliente';
        }

        // For Saliente, Ventanilla (quienDirigido/doc_quien_registra) is the Responsible Official
        $responsableNombre = 'N/A';
        $docResponsable = '-';
        
        if ($origen === 'Saliente' && $item->quienDirigido) {
            $responsableNombre = $item->quienDirigido->rem_nombres . ' ' . $item->quienDirigido->rem_apellidos;
            $docResponsable = $item->quienDirigido->rem_doc;
        } else if ($item->quienEnvia && $item->quienEnvia->emple_rol != 2) {
            $responsableNombre = $item->quienEnvia->emple_nombres . ' ' . $item->quienEnvia->emple_apellidos;
            $docResponsable = $item->quienEnvia->emple_doc;
        }

        return (object) [
            'origen'                => $origen,
            'num_radicado_ext'      => null,
            'num_radicado_int'      => $radicadoNum,
            'nom_institucion'       => $responsableNombre,
            'ciudad'                => 'N/A',
            'asunto'                => $item->asunto,
            'fecha'                 => $item->fecha,
            'registrado_por_nombre' => $responsableNombre,
            'doc_registra'          => $docResponsable,
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DetalleEnvio;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\DetalleRecibido;
use App\Models\Envio;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    /**
     * Muestra el resumen de correspondencia por dependencia
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->nit_empresa) {
            return view('admin.reportes', ['reporteAreas' => [], 'mensaje' => 'No estás registrado a una empresa.']);
        }

        $datos = $this->calcularReporteAreas($request);
        $reporteAreas = $datos['areas'];
        $resumenTipos = $datos['tipos'];
        
        $areas = \App\Models\Area::orderBy('area_nom')->get();
        $tipos = \App\Models\Tipo::orderBy('tipo_nombre')->get();
        $estados = \App\Models\Estado::all();

        return view('admin.reportes', compact('reporteAreas', 'resumenTipos', 'areas', 'tipos', 'estados'));
    }

    /**
     * Exporta el reporte a PDF con gráficas
     */
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        if (!$user->nit_empresa) {
            return redirect()->back()->with('error', 'No estás registrado a una empresa.');
        }

        $datos = $this->calcularReporteAreas($request);
        $reporteAreas = $datos['areas'];
        $resumenTipos = $datos['tipos'];

        $barChart = $request->input('barChart');
        $doughnutChart = $request->input('doughnutChart');

        $filtrosActivos = [
            'periodo'    => $request->periodo ?? 'todo',
            'fecha'      => $request->fecha,
            'mes'        => $request->mes,
            'trimestre'  => $request->trimestre,
            'ano'        => $request->ano,
            'tipo_doc'   => $request->tipo_doc ? \App\Models\Tipo::find($request->tipo_doc)?->tipo_nombre : null,
            'estado_rep' => $request->estado_rep ? \App\Models\Estado::find($request->estado_rep)?->estado_nomb : null,
            'area'       => $request->area_id ? \App\Models\Area::find($request->area_id)?->area_nom : null,
        ];

        // Generar etiqueta de filtros legible (Estilo Remitente)
        $periodo = $request->input('periodo', 'todo');
        $labelPeriodo = match($periodo) {
            'dia'       => 'Día: ' . ($request->fecha ? \Carbon\Carbon::parse($request->fecha)->translatedFormat('d F Y') : '—'),
            'mes'       => 'Mes: ' . ($request->mes ? \Carbon\Carbon::parse($request->mes.'-01')->translatedFormat('F Y') : '—'),
            'trimestre' => 'Trimestre ' . ($request->trimestre ?? '—') . ' (' . ($request->ano ?? date('Y')) . ')',
            'ano'       => 'Año: ' . ($request->ano ?? date('Y')),
            default     => 'Histórico Completo',
        };

        // Filtros adicionales legibles
        $labelAvanzado = "";
        if ($filtrosActivos['tipo_doc']) $labelAvanzado .= " | Tipo: " . $filtrosActivos['tipo_doc'];
        if ($filtrosActivos['estado_rep']) $labelAvanzado .= " | Estado: " . $filtrosActivos['estado_rep'];
        if ($filtrosActivos['area']) $labelAvanzado .= " | Área: " . $filtrosActivos['area'];

        $filtroLabel = $labelPeriodo . $labelAvanzado;

        // Calcular totales globales para el encabezado del PDF
        $totalAsignados  = collect($reporteAreas)->sum('asignados');
        $totalTramite    = collect($reporteAreas)->sum('tramite');
        $totalFinalizado = collect($reporteAreas)->sum('finalizado');
        $totalVencidos   = collect($reporteAreas)->sum('vencidos');
        $eficienciaGlobal = $totalAsignados > 0 ? round(($totalFinalizado / $totalAsignados) * 100) : 0;

        $pdf = Pdf::loadView('admin.pdf.reportes_pdf', compact(
            'reporteAreas', 'resumenTipos', 'barChart', 'doughnutChart', 'filtrosActivos', 'filtroLabel',
            'totalAsignados', 'totalTramite', 'totalFinalizado', 'totalVencidos', 'eficienciaGlobal'
        ))->setPaper('A4', 'portrait');
        return $pdf->download('reporte_avanzado.pdf');
    }

    /**
     * Método auxiliar para calcular estadísticas aplicando filtros
     */
    private function calcularReporteAreas(Request $request)
    {
        $user = Auth::user();
        $nit = $user->nit_empresa;
        $periodo = $request->input('periodo');
        $tipoDoc = $request->input('tipo_doc');    // T6: Filtro por tipo de documento
        $estadoRep = $request->input('estado_rep'); // T6: Filtro por estado
        $areaFiltro = $request->input('area_id');   // Nuevo: Filtro por área específica

        // Subquery for the latest internal detail per document/recipient
        $latestInternalSubquery = DetalleEnvio::select(DB::raw('MAX(id_detalle) as id_detalle'))
            ->groupBy('id_envio', 'id_quien_recibe');

        // Si se filtra por área específica, solo cargar esa área; sino todas
        $areasQuery = Area::query();
        if ($areaFiltro) {
            $areasQuery->where('id_area', $areaFiltro);
        }
        $areas = $areasQuery->get();
        $reporteAreas = [];
        
        $resumenTipos = [
            'Interna' => 0,
            'Externa' => 0,
            'Saliente' => 0
        ];

        foreach ($areas as $area) {
            $empleadosDocs = Empleado::where('emple_area', $area->id_area)
                ->where('nit_empresa', $nit)
                ->pluck('emple_doc');

            if ($empleadosDocs->isEmpty()) continue;

            // --- 1. INTERNAL CORRESPONDENCE (Envio) ---
            $queryInterna = DetalleEnvio::whereIn('id_quien_recibe', $empleadosDocs)
                ->whereIn('id_detalle', $latestInternalSubquery)
                ->with(['envio.tipoEnvio', 'envio.radicado']);

            if ($periodo && $periodo != 'todo') {
                $queryInterna->whereHas('envio', function ($q) use ($request, $periodo) {
                    $this->applyDateFilters($q, $request, $periodo, 'fecha');
                });
            }

            // T6: Filtrar por tipo de documento en internos
            if ($tipoDoc) {
                $queryInterna->whereHas('envio', fn($q) => $q->where('id_tipo_envio', $tipoDoc));
            }

            // T6: Filtrar por estado en internos
            if ($estadoRep) {
                $queryInterna->where('id_estado_rec', $estadoRep);
            }

            // --- 2. EXTERNAL CORRESPONDENCE (Recibido) ---
            $queryExterna = DetalleRecibido::whereIn('det_doc_empleado', $empleadosDocs)
                ->with(['recibido.tipo']);

            if ($periodo && $periodo != 'todo') {
                $queryExterna->whereHas('recibido', function ($q) use ($request, $periodo) {
                    $this->applyDateFilters($q, $request, $periodo, 'fecha_hora_recib');
                });
            }

            // T6: Filtrar por tipo de documento en externos
            if ($tipoDoc) {
                $queryExterna->whereHas('recibido', fn($q) => $q->where('id_tipo', $tipoDoc));
            }

            // T6: Filtrar por estado en externos
            if ($estadoRep) {
                $queryExterna->where('id_estado_rec', $estadoRep);
            }

            $detallesInternos = $queryInterna->get();
            $detallesExternos = $queryExterna->get();

            // Categorization by type
            foreach ($detallesInternos as $det) {
                $prefijo = substr($det->envio?->radicado?->num_radicado ?? '', 0, 3);
                if ($prefijo === 'SAL') $resumenTipos['Saliente']++;
                else $resumenTipos['Interna']++;
            }
            foreach ($detallesExternos as $det) {
                $resumenTipos['Externa']++;
            }

            $totalAsignados = $detallesInternos->count() + $detallesExternos->count();
            $countTramite = 0;
            $countFinalizado = 0;
            $countVencidos = 0;

            // Merge details for status processing (both use id_estado_rec)
            $allDetails = $detallesInternos->concat($detallesExternos);

            foreach ($allDetails as $det) {
                $idEstado = $det->id_estado_rec;
                
                if ($idEstado == 8) {
                    $countTramite++;
                } elseif (in_array($idEstado, [9, 10, 11])) {
                    $countFinalizado++;
                }

                // Vencidos Calculation
                $doc = $det instanceof DetalleEnvio ? $det->envio : $det->recibido;
                if ($doc) {
                    $tipo = $det instanceof DetalleEnvio ? ($doc->tipoEnvio) : ($doc->tipo);
                    $diasTotales = $tipo->dias_respuesta ?? 0;
                    if ($diasTotales > 0 && !in_array($idEstado, [9, 10, 11])) {
                        $fechaBase = $det instanceof DetalleEnvio ? $doc->fecha : $doc->fecha_hora_recib;
                        $diasTranscurridos = Carbon::parse($fechaBase)->diffInDaysFiltered(fn(Carbon $d) => $d->isWeekday(), Carbon::now());
                        if (($diasTotales - $diasTranscurridos) < 0) {
                            $countVencidos++;
                        }
                    }
                }
            }

            $reporteAreas[] = [
                'area_nom'  => $area->area_nom,
                'asignados' => $totalAsignados,
                'tramite'   => $countTramite,
                'finalizado' => $countFinalizado,
                'vencidos'  => $countVencidos,
                'eficiencia' => $totalAsignados > 0 ? round(($countFinalizado / $totalAsignados) * 100) : 0
            ];
        }

        return [
            'areas' => $reporteAreas,
            'tipos' => $resumenTipos
        ];
    }

    /**
     * Helper to apply common date filters
     */
    private function applyDateFilters($query, Request $request, $periodo, $dateColumn)
    {
        if ($periodo == 'dia' && $request->fecha) {
            $query->whereDate($dateColumn, $request->fecha);
        } elseif ($periodo == 'mes' && $request->mes) {
            $query->whereYear($dateColumn, substr($request->mes, 0, 4))
                  ->whereMonth($dateColumn, substr($request->mes, 5, 2));
        } elseif ($periodo == 'trimestre' && $request->trimestre && $request->ano) {
            $query->whereYear($dateColumn, $request->ano);
            if ($request->trimestre == 1) $query->whereBetween(DB::raw("MONTH($dateColumn)"), [1, 3]);
            elseif ($request->trimestre == 2) $query->whereBetween(DB::raw("MONTH($dateColumn)"), [4, 6]);
            elseif ($request->trimestre == 3) $query->whereBetween(DB::raw("MONTH($dateColumn)"), [7, 9]);
            elseif ($request->trimestre == 4) $query->whereBetween(DB::raw("MONTH($dateColumn)"), [10, 12]);
        } elseif ($periodo == 'ano' && $request->ano) {
            $query->whereYear($dateColumn, $request->ano);
        }
    }


    public function exportCorrespondenciaPdf(Request $request)
    {
        $user = Auth::user();
        if (!$user->nit_empresa) {
            return redirect()->back()->with('error', 'No autorizado.');
        }
        $nitEmpresa = $user->nit_empresa;

        // An Admin should see all correspondence of the company. 
        // If an area_id is provided, filter by that area's employees.
        $query = \App\Models\Recibido::with(['estado','tipo','radicado','destinatarios','ciudad'])
            ->where('nit_empresa', $nitEmpresa);

        $filtrosActivos = [];

        if ($request->filled('area_id')) {
            $empleadosArea = \App\Models\Empleado::where('emple_area', $request->area_id)
                ->where('nit_empresa', $nitEmpresa)
                ->pluck('emple_doc');
                
            $query->whereHas('detalles', function($q) use ($empleadosArea) {
                $q->whereIn('det_doc_empleado', $empleadosArea);
            });
            
            $area = \App\Models\Area::find($request->area_id);
            $filtrosActivos['Área'] = $area->area_nom ?? 'ID '.$request->area_id;
        }

        // Filter: desde
        if ($request->filled('desde')) {
            $query->whereDate('fecha_hora_recib', '>=', $request->desde);
            $filtrosActivos['Desde'] = \Carbon\Carbon::parse($request->desde)->format('d/m/Y');
        }

        // Filter: hasta
        if ($request->filled('hasta')) {
            $query->whereDate('fecha_hora_recib', '<=', $request->hasta);
            $filtrosActivos['Hasta'] = \Carbon\Carbon::parse($request->hasta)->format('d/m/Y');
        }

        // Filter: area (by destinatario employee's area)
        if ($request->filled('area_id')) {
            $query->whereHas('destinatarios', function($q) use ($request) {
                $q->where('emple_area', $request->area_id);
            });
            $area = Area::find($request->area_id);
            $filtrosActivos['Área'] = $area->area_nom ?? 'ID '.$request->area_id;
        }

        // Filter: tipo de documento
        if ($request->filled('tipo_id')) {
            $query->where('id_tipo', $request->tipo_id);
            $tipo = \App\Models\Tipo::find($request->tipo_id);
            $filtrosActivos['Tipo Doc.'] = $tipo->tipo_nombre ?? 'ID '.$request->tipo_id;
        }

        // Filter: estado
        if ($request->filled('estado_id')) {
            $query->where('id_estado_rec', $request->estado_id);
            $estado = \App\Models\Estado::find($request->estado_id);
            $filtrosActivos['Estado'] = $estado->estado_nomb ?? 'ID '.$request->estado_id;
        }

        $correspondencias = $query->orderBy('fecha_hora_recib', 'desc')->get();

        // Calculate statistics for the report header
        $totalRegistros = $correspondencias->count();
        $totalFinalizados = $correspondencias->filter(fn($c) => in_array($c->id_estado_rec, [9, 10, 14]))->count();
        $totalRechazados = $correspondencias->filter(fn($c) => $c->id_estado_rec == 11)->count();
        $totalEnProceso = $totalRegistros - $totalFinalizados - $totalRechazados;

        $pdf = Pdf::loadView('remitente.pdf.correspondencia_reporte_pdf', compact(
            'correspondencias', 
            'filtrosActivos',
            'totalRegistros',
            'totalEnProceso',
            'totalFinalizados',
            'totalRechazados'
        ))
            ->setPaper('A4', 'landscape');

        return $pdf->download('listado_correspondencia.pdf');
    }
}

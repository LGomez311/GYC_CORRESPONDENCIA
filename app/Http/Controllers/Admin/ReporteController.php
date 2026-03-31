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

        $reporteAreas = $this->calcularReporteAreas($request);

        return view('admin.reportes', compact('reporteAreas'));
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

        $reporteAreas = $this->calcularReporteAreas($request);

        $barChart = $request->input('barChart');
        $doughnutChart = $request->input('doughnutChart');

        // Pasar los filtros activos al PDF para mostrarlo en el documento
        $filtrosActivos = [
            'periodo'    => $request->periodo ?? 'todo',
            'tipo_doc'   => $request->tipo_doc,
            'estado_rep' => $request->estado_rep,
            'area_id'    => $request->area_id,
            'fecha'      => $request->fecha,
            'mes'        => $request->mes,
            'trimestre'  => $request->trimestre,
            'ano'        => $request->ano,
        ];

        $pdf = Pdf::loadView('admin.pdf.reportes_pdf', compact('reporteAreas', 'barChart', 'doughnutChart', 'filtrosActivos'))->setPaper('A4', 'portrait');
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

        foreach ($areas as $area) {
            $empleadosDocs = Empleado::where('emple_area', $area->id_area)
                ->where('nit_empresa', $nit)
                ->pluck('emple_doc');

            if ($empleadosDocs->isEmpty()) continue;

            // --- 1. INTERNAL CORRESPONDENCE (Envio) ---
            $queryInterna = DetalleEnvio::whereIn('id_quien_recibe', $empleadosDocs)
                ->whereIn('id_detalle', $latestInternalSubquery)
                ->with(['envio.tipoEnvio']);

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

        return $reporteAreas;
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
}

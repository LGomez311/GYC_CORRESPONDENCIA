<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DetalleEnvio;
use App\Models\Area;
use App\Models\Empleado;
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

        $pdf = Pdf::loadView('admin.pdf.reportes_pdf', compact('reporteAreas', 'barChart', 'doughnutChart'))->setPaper('A4', 'portrait');
        return $pdf->download('reporte_avanzado.pdf');
    }

    /**
     * Método auxiliar para calcular estadísticas aplicando filtros
     */
    private function calcularReporteAreas(Request $request)
    {
        $user = Auth::user();
        $nit = $user->nit_empresa;

        $latestDetalleSubquery = DetalleEnvio::select(DB::raw('MAX(id_detalle) as id_detalle'))
            ->groupBy('id_envio', 'id_quien_recibe');

        $areas = Area::all();
        $reporteAreas = [];

        foreach ($areas as $area) {
            $empleadosDocs = Empleado::where('emple_area', $area->id_area)
                ->where('nit_empresa', $nit)
                ->pluck('emple_doc');

            if ($empleadosDocs->isEmpty()) continue;

            $queryDetalles = DetalleEnvio::whereIn('id_detalle', $latestDetalleSubquery)
                ->whereIn('id_quien_recibe', $empleadosDocs)
                ->with(['estado', 'envio.tipoEnvio']);

            // Aplicar Filtros Temporales
            $periodo = $request->input('periodo');
            if ($periodo && $periodo != 'todo') {
                $queryDetalles->whereHas('envio', function ($q) use ($request, $periodo) {
                    if ($periodo == 'dia' && $request->fecha) {
                        $q->whereDate('envio.fecha', $request->fecha);
                    } elseif ($periodo == 'mes' && $request->mes) {
                        $q->whereYear('envio.fecha', substr($request->mes, 0, 4))
                          ->whereMonth('envio.fecha', substr($request->mes, 5, 2));
                    } elseif ($periodo == 'trimestre' && $request->trimestre && $request->ano) {
                        $q->whereYear('envio.fecha', $request->ano);
                        if ($request->trimestre == 1) $q->whereBetween(DB::raw('MONTH(envio.fecha)'), [1, 3]);
                        if ($request->trimestre == 2) $q->whereBetween(DB::raw('MONTH(envio.fecha)'), [4, 6]);
                        if ($request->trimestre == 3) $q->whereBetween(DB::raw('MONTH(envio.fecha)'), [7, 9]);
                        if ($request->trimestre == 4) $q->whereBetween(DB::raw('MONTH(envio.fecha)'), [10, 12]);
                    } elseif ($periodo == 'ano' && $request->ano) {
                        $q->whereYear('envio.fecha', $request->ano);
                    }
                });
            }

            $detalles = $queryDetalles->get();

            $countAsignados = $detalles->count();
            $countTramite = $countFinalizado = $countVencidos = 0;

            foreach ($detalles as $detalle) {
                $idEstado = $detalle->id_estado_rec;
                
                if ($idEstado == 8) {
                    $countTramite++;
                } elseif (in_array($idEstado, [9, 10, 11])) {
                    $countFinalizado++;
                }

                $envio = $detalle->envio;
                if ($envio && $envio->tipoEnvio) {
                    $diasTotales = $envio->tipoEnvio->dias_respuesta ?? 0;
                    if ($diasTotales > 0) {
                        $diasTranscurridos = Carbon::parse($envio->fecha)->diffInDaysFiltered(fn(Carbon $d) => $d->isWeekday(), Carbon::now());
                        if (($diasTotales - $diasTranscurridos) < 0 && !in_array($idEstado, [9, 10, 11])) {
                            $countVencidos++;
                        }
                    }
                }
            }

            $reporteAreas[] = [
                'area_nom' => $area->area_nom,
                'asignados' => $countAsignados,
                'tramite' => $countTramite,
                'finalizado' => $countFinalizado,
                'vencidos' => $countVencidos,
                'eficiencia' => $countAsignados > 0 ? round(($countFinalizado / $countAsignados) * 100) : 0
            ];
        }

        return $reporteAreas;
    }
}

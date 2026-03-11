<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DetalleEnvio;

class ReporteController extends Controller
{
    /**
     * Display a dashboard with real, non-duplicated statistics for the Employee.
     * We filter the 'detalle_envio' table to find only the MAX(id_detalle)
     * for every id_envio assigned to the current employee, ensuring
     * each document is only counted in its current, latest state.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Subquery to get the latest id_detalle for each id_envio for this user
        // This ensures if a radicado went from Recibido -> Trámite -> Finalizado,
        // it only counts as Finalizado.
        $latestDetalleSubquery = DetalleEnvio::select(DB::raw('MAX(id_detalle) as id_detalle'))
            ->where('id_quien_recibe', $user->emple_doc)
            ->groupBy('id_envio');

        // Main query fetching only those latest records
        $queryBase = DetalleEnvio::with(['estado'])
            ->whereIn('id_detalle', $latestDetalleSubquery)
            ->where('id_quien_recibe', $user->emple_doc);

        $totales = (clone $queryBase)->get();

        // Counters initialization
        $countRecibido = 0;
        $countTramite = 0;
        $countFinalizado = 0;
        $countArchivado = 0;
        $countRechazado = 0;

        foreach ($totales as $detalle) {
            $estadoNomb = strtolower($detalle->estado->estado_nomb ?? '');

            if (str_contains($estadoNomb, 'recibido')) {
                $countRecibido++;
            } elseif (str_contains($estadoNomb, 'tramit') || str_contains($estadoNomb, 'trámit')) { // En trámite
                $countTramite++;
            } elseif (str_contains($estadoNomb, 'finalizado') || str_contains($estadoNomb, 'resuelto')) {
                $countFinalizado++;
            } elseif (str_contains($estadoNomb, 'archivado')) {
                $countArchivado++;
            } elseif (str_contains($estadoNomb, 'rechazado')) {
                $countRechazado++;
            }
        }

        $totalUnicos = $totales->count();

        return view('empleado.reportes', compact(
            'countRecibido',
            'countTramite',
            'countFinalizado',
            'countArchivado',
            'countRechazado',
            'totalUnicos'
        ));
    }
}

<?php

namespace App\Http\Controllers\Remitente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Recibido;
use App\Models\DetalleRecibido;
use App\Models\Empleado;

class DashboardController extends Controller
{
    public function index()
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;

        // --- HEALING LOGIC ---
        // Sync parent table 'recibido' if any detail says it's rejected (11)
        // This fixes legacy data or cases where sync might have failed.
        DB::table('recibido')
            ->where('doc_quien_registra', $remDoc)
            ->where('id_estado_rec', '!=', 11)
            ->whereIn('id_recibido', function($query) {
                $query->select('det_id_recibido')
                    ->from('detalle_recibido')
                    ->where('id_estado_rec', 11);
            })
            ->update(['id_estado_rec' => 11]);
        // ---------------------

        // Statistics
        $stats = [
            'total' => DB::table('recibido')->where('doc_quien_registra', $remDoc)->count(),
            'rejected' => DB::table('recibido')->where('doc_quien_registra', $remDoc)->where('id_estado_rec', 11)->count(),
            'resolved' => DB::table('recibido')->where('doc_quien_registra', $remDoc)->whereIn('id_estado_rec', [9, 10])->count(),
            'pending' => DB::table('recibido')->where('doc_quien_registra', $remDoc)->whereNotIn('id_estado_rec', [9, 10, 11])->count(),
        ];

        // Correspondences list
        // Ordered by Rejected (11) first, then by date descending
        $correspondencias = Recibido::with(['estado', 'tipo', 'radicado', 'destinatarios.area', 'ciudad.departamento', 'anexos'])
            ->where('doc_quien_registra', $remDoc)
            ->orderByRaw('CASE WHEN id_estado_rec = 11 THEN 0 ELSE 1 END')
            ->orderBy('fecha_hora_recib', 'desc')
            ->paginate(10);

        return view('remitente.index', compact('stats', 'correspondencias'));
    }

    public function getHistory($id)
    {
        $remitente = Auth::guard('remitente')->user();
        
        // 1. Initial Registration Data from 'recibido'
        $registration = DB::table('recibido as r')
            ->join('radicados as rad', 'r.num_radicado_int', '=', 'rad.id_radicado')
            ->leftJoin('remitente as rem', 'r.doc_quien_registra', '=', 'rem.rem_doc')
            ->where('r.id_recibido', $id)
            ->select(
                DB::raw("'registry' as type"),
                'r.fecha_hora_recib as fecha',
                'rem.rem_nombres as nombres',
                'rem.rem_apellidos as apellidos',
                'rad.num_radicado',
                DB::raw("'Registrado y Enviado' as estado_nomb"),
                'r.observaciones',
                DB::raw("NULL as img")
            )
            ->first();

        // 2. Lifecycle transitions from 'detalle_recibido'
        $details = DB::table('detalle_recibido as dr')
            ->join('estado as e', 'dr.id_estado_rec', '=', 'e.id_estado')
            ->leftJoin('empleado as emp', 'dr.det_doc_empleado', '=', 'emp.emple_doc')
            ->leftJoin('remitente as rem', 'dr.det_doc_empleado', '=', 'rem.rem_doc')
            ->where('dr.det_id_recibido', $id)
            ->select(
                DB::raw("'detail' as type"),
                'dr.fecha_re as fecha',
                DB::raw("COALESCE(emp.emple_nombres, rem.rem_nombres) as nombres"),
                DB::raw("COALESCE(emp.emple_apellidos, rem.rem_apellidos) as apellidos"),
                DB::raw("NULL as num_radicado"),
                'e.estado_nomb',
                'dr.observaciones',
                'emp.emple_img as img',
                'dr.id_estado_rec'
            )
            ->orderBy('dr.fecha_re', 'asc')
            ->get();

        $history = [];
        if ($registration) {
            $history[] = $registration;
        }
        foreach ($details as $d) {
            $history[] = $d;
        }

        return response()->json($history);
    }

    public function finalize($id)
    {
        $remitente = Auth::guard('remitente')->user();
        
        $recibido = Recibido::where('id_recibido', $id)
            ->where('doc_quien_registra', $remitente->rem_doc)
            ->firstOrFail();

        $recibido->id_estado_rec = 10; // Archivado/Finalizado
        $recibido->save();

        // Also mark details as resolved if they were rejected
        DB::table('detalle_recibido')
            ->where('det_id_recibido', $id)
            ->where('id_estado_rec', 11)
            ->update(['id_estado_rec' => 10]);

        return redirect()->back()->with('success', 'Correspondencia finalizada exitosamente.');
    }

    public function updateRejected(Request $request, $id)
    {
        $remitente = Auth::guard('remitente')->user();
        
        $recibido = Recibido::where('id_recibido', $id)
            ->where('doc_quien_registra', $remitente->rem_doc)
            ->firstOrFail();

        $request->validate([
            'asunto'        => 'required|string|max:100',
            'observaciones' => 'nullable|string|max:250',
            'destinatarios' => 'required|array',
            'destinatarios.*' => 'required|string|exists:empleado,emple_doc',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Existing Record
            $recibido->asunto = $request->asunto;
            $recibido->observaciones = $request->observaciones;
            $recibido->id_estado_rec = 12; // Enviado (Restart cycle)
            $recibido->save();

            // 2. Mark previous rejections as "Resuelto" (9) to clear the "Rejected" status from the history
            DB::table('detalle_recibido')
                ->where('det_id_recibido', $id)
                ->where('id_estado_rec', 11)
                ->update(['id_estado_rec' => 9]);

            // 3. Create NEW Details for the new cycle (Sequence: 12 then 7)
            foreach ($request->destinatarios as $docEmpleado) {
                // First: 12 (Enviado) - Records the act of sending
                DB::table('detalle_recibido')->insert([
                    'det_id_recibido'  => $id,
                    'det_doc_empleado' => $docEmpleado,
                    'fecha_re'         => now()->subSecond(), // Slight offset to ensure order in history
                    'id_estado_rec'    => 12, // Enviado
                    'observaciones'    => 'Correspondencia re-enviada tras corrección.',
                ]);

                // Second: 7 (Recibido) - Current active state for the employee
                DB::table('detalle_recibido')->insert([
                    'det_id_recibido'  => $id,
                    'det_doc_empleado' => $docEmpleado,
                    'fecha_re'         => now(),
                    'id_estado_rec'    => 7, // Recibido/Inicial
                    'observaciones'    => 'Recibido para nueva gestión tras corrección: ' . ($request->observaciones ?? 'Sin detalle adicional'),
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Correspondencia corregida y re-enviada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar: ' . $e->getMessage());
        }
    }
}

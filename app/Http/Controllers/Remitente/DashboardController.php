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
        $correspondencias = Recibido::with([
            'estado', 
            'tipo', 
            'radicado', 
            'destinatarios.area', 
            'ciudad.departamento', 
            'anexos', 
            'detalles' => function($q) {
                $q->orderBy('fecha_re', 'desc');
            },
            'detalles.anexosRespuesta',
            'detalles.empleado.area',
            'detalles.estado'
        ])
            ->where('doc_quien_registra', $remDoc)
            ->orderByRaw('CASE WHEN id_estado_rec = 11 THEN 0 ELSE 1 END')
            ->orderBy('fecha_hora_recib', 'desc')
            ->paginate(10);

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();

        return view('remitente.index', compact('stats', 'correspondencias', 'tipos', 'empleados'));
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
            ->leftJoin('estado as e', 'dr.id_estado_rec', '=', 'e.id_estado')
            ->leftJoin('empleado as emp', 'dr.det_doc_empleado', '=', 'emp.emple_doc')
            ->leftJoin('remitente as rem', 'dr.det_doc_empleado', '=', 'rem.rem_doc')
            ->where('dr.det_id_recibido', $id)
            ->select(
                DB::raw("'detail' as type"),
                'dr.fecha_re as fecha',
                DB::raw("COALESCE(emp.emple_nombres, rem.rem_nombres) as nombres"),
                DB::raw("COALESCE(emp.emple_apellidos, rem.rem_apellidos) as apellidos"),
                DB::raw("NULL as num_radicado"),
                DB::raw("COALESCE(e.estado_nomb, CASE WHEN dr.id_estado_rec = 14 THEN 'Saliente' ELSE 'Estado desconocido' END) as estado_nomb"),
                'dr.observaciones',
                'emp.emple_img as img',
                'dr.id_estado_rec',
                'dr.id_det_recibido',
                'dr.archivo_res'
            )
            ->orderBy('dr.fecha_re', 'asc')
            ->get();

        $history = [];
        if ($registration) {
            $history[] = (array) $registration;
        }

        foreach ($details as $d) {
            $det = (array) $d;
            
            // Fetch annexes for this detail
            $det['anexos'] = DB::table('anexo_respuesta')
                ->where('id_detalle', $d->id_det_recibido)
                ->select('ruta_archivo', 'nombre_original')
                ->get();
                
            $history[] = $det;
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

            // 2. Mark ALL previous assignment records as "Resuelto/Histórico" (9) 
            // to ensure a clean slate for the new cycle and hide stale recipients.
            DB::table('detalle_recibido')
                ->where('det_id_recibido', $id)
                ->whereIn('id_estado_rec', [7, 8, 10, 11, 12]) // All active/transitory states from previous cycle
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

    public function storeSalienteFromResponse(Request $request, $id)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;
        $docQuienRegistra = $remitente ? $remitente->rem_doc : null;

        $recibido = Recibido::where('id_recibido', $id)
            ->where('nit_empresa', $nitEmpresa)
            ->firstOrFail();

        $request->validate([
            'destino'         => 'required|string|max:200',
            'asunto'          => 'required|string|max:100',
            'doc_quien_envia' => 'required|string|max:20',
            'id_tipo_envio'   => 'required|integer',
            'folio'           => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // 1. Radicado SAL- Logic
            $currentYear = date('Y');
            $prefix = 'SAL-' . $currentYear . '-';
            
            $latestRadicado = \App\Models\Radicado::where('nit_empresa', $nitEmpresa)
                ->where('num_radicado', 'like', $prefix . '%')
                ->orderBy('num_radicado', 'desc')
                ->first();

            $newNumber = $latestRadicado ? intval(substr($latestRadicado->num_radicado, -5)) + 1 : 1;
            
            $radicado = \App\Models\Radicado::create([
                'num_radicado' => $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT),
                'nit_empresa'  => $nitEmpresa,
            ]);

            // 2. Identify the response file and annexes
            $responseDetail = $recibido->detalles()->whereNotNull('archivo_res')->first();
            $archivoPrincipal = $responseDetail ? $responseDetail->archivo_res : '';
            
            // 3. Create Envio
            $envio = \App\Models\Envio::create([
                'num_radicado_int'   => $radicado->id_radicado,
                'asunto'             => $request->asunto,
                'destino'            => $request->destino,
                'doc_quien_envia'    => $request->doc_quien_envia,
                'fecha'              => now(),
                'folio'              => $request->folio,
                'id_tipo_envio'      => $request->id_tipo_envio,
                'id_estado_envio'    => 12, // Enviado
                'archivo'            => $archivoPrincipal, // FIX: Field archivo is required
                'nit_empresa'        => $nitEmpresa,
                'doc_quien_registra' => $docQuienRegistra,
            ]);

            // 4. Transfer Annexes if they exist
            if ($responseDetail) {
                $annexes = DB::table('anexo_respuesta')
                    ->where('id_detalle', $responseDetail->id_det_recibido)
                    ->get();
                
                foreach ($annexes as $annex) {
                    DB::table('anexo_envio')->insert([
                        'id_envio'        => $envio->id_envio,
                        'ruta_archivo'    => $annex->ruta_archivo,
                        'nombre_original' => $annex->nombre_original,
                    ]);
                }
            }

            // 5. Mark the received correspondence as Saliente (14)
            if ($recibido->id_estado_rec != 10) {
                $recibido->id_estado_rec = 14; 
                $recibido->save();

                // 6. Log traceability entry
                DetalleRecibido::create([
                    'det_id_recibido'  => $recibido->id_recibido,
                    'det_doc_empleado' => $request->doc_quien_envia,
                    'fecha_re'         => now(),
                    'id_estado_rec'    => 14,
                    'observaciones'    => 'Registrado como envío saliente con radicado: ' . $radicado->num_radicado,
                    'visto'            => 1
                ]);
            }

            // 7. Send Email Notification to the original sender
            if (!empty($recibido->correo_persona)) {
                try {
                    $correoDestino = $recibido->correo_persona;
                    $numRadicado = $radicado->num_radicado;
                    $asuntoEmail = 'Respuesta a su correspondencia - Radicado: ' . $numRadicado;
                    $urlConsulta = route('public.correspondencia.consultar');

                    \Illuminate\Support\Facades\Log::info("Enviando correo de notificación a: $correoDestino para el radicado: $numRadicado");

                    \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($correoDestino, $numRadicado, $asuntoEmail, $urlConsulta, $recibido) {
                        $message->to($correoDestino)
                            ->subject($asuntoEmail)
                            ->html("
                            <div style='font-family: Arial, sans-serif; background-color: #f8fafc; padding: 40px;'>
                                <div style='max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;'>
                                    <div style='text-align: center; margin-bottom: 32px;'>
                                        <div style='display: inline-block; padding: 12px; background-color: #ecfdf5; border-radius: 12px;'>
                                            <span style='font-size: 32px;'>📩</span>
                                        </div>
                                    </div>
                                    <h2 style='color: #1e293b; font-size: 24px; font-weight: 700; text-align: center; margin-bottom: 8px;'>Su correspondencia tiene una respuesta</h2>
                                    <p style='color: #64748b; font-size: 16px; text-align: center; margin-bottom: 32px;'>Le informamos que se ha registrado una respuesta oficial a su solicitud en nuestro sistema de gestión documental.</p>
                                    
                                    <div style='background-color: #f1f5f9; border-radius: 12px; padding: 24px; margin-bottom: 32px;'>
                                        <div style='margin-bottom: 16px;'>
                                            <span style='color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;'>Radicado Inicial</span>
                                            <p style='color: #1e293b; font-size: 18px; font-weight: 700; margin: 4px 0 0;'>" . ($recibido->radicado ? $recibido->radicado->num_radicado : 'N/A') . "</p>
                                        </div>
                                        <div>
                                            <span style='color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;'>Radicado de Respuesta</span>
                                            <p style='color: #059669; font-size: 18px; font-weight: 700; margin: 4px 0 0;'>$numRadicado</p>
                                        </div>
                                    </div>

                                    <div style='text-align: center; margin-bottom: 32px;'>
                                        <a href='$urlConsulta' style='display: inline-block; background-color: #10b981; color: #ffffff; font-size: 15px; font-weight: 700; text-decoration: none; padding: 14px 32px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);'>Consultar mi respuesta</a>
                                    </div>
                                    
                                    <p style='color: #94a3b8; font-size: 12px; line-height: 1.6; text-align: center; margin: 0;'>
                                        Si tiene problemas con el botón, copie y pegue el siguiente enlace en su navegador: <br>
                                        <a href='$urlConsulta' style='color: #10b981; text-decoration: underline;'>$urlConsulta</a>
                                    </p>
                                    
                                    <hr style='margin: 32px 0; border: none; border-top: 1px solid #e2e8f0;'>
                                    <p style='font-size: 11px; color: #cbd5e1; text-align: center; margin: 0;'>Este es un mensaje automático generado por el Sistema de Gestión Documental. Por favor no responda a este correo.</p>
                                </div>
                            </div>");
                    });
                } catch (\Exception $mailEx) {
                    \Illuminate\Support\Facades\Log::error('Error enviando correo de respuesta saliente: ' . $mailEx->getMessage());
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Envío saliente registrado exitosamente con radicado: ' . $radicado->num_radicado);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar envío: ' . $e->getMessage());
        }
    }
}

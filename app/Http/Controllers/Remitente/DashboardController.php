<?php

namespace App\Http\Controllers\Remitente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Recibido;
use App\Models\DetalleRecibido;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\DetalleEnvio;
use App\Models\Envio;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;

        $this->syncRejected($remDoc);

        // Statistics
        $stats = $this->getStats($remDoc);
        $estadoId = $request->input('estado_id');

        // Dashboard: Show all records NOT "salientes" (14) or "finalizados" (10).
        $query = $this->getBaseQuery($remDoc)
            ->whereNotIn('id_estado_rec', [10, 14]);

        if ($estadoId) {
            $query->where('id_estado_rec', $estadoId);
        }

        $correspondencias = $query->paginate(10)->appends($request->query());

        $enviosPendientes = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'quienEnvia', 'anexos'])
            ->where('doc_quien_registra', $remDoc)
            ->where('id_estado_envio', 0)
            ->orderBy('fecha', 'desc')
            ->get();

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();
        $estados = \App\Models\Estado::all();

        $todosDestinatarios = \App\Models\Empleado::with('area')
            ->where('emple_rol', '=', 3)
            ->get()
            ->map(function($e) {
                return [
                    'emple_doc' => (string) $e->emple_doc,
                    'emple_nombres' => $e->emple_nombres,
                    'emple_apellidos' => $e->emple_apellidos,
                    'tipo' => 'empleado',
                    'area_nombre' => $e->area ? $e->area->area_nom : null
                ];
            })
            ->sortBy('emple_nombres')
            ->values();

        return view('remitente.index', compact('stats', 'correspondencias', 'enviosPendientes', 'tipos', 'empleados', 'estados', 'estadoId', 'todosDestinatarios'));
    }

    public function recibidosProceso(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;

        $this->syncRejected($remDoc);
        $stats = $this->getStats($remDoc);
        $estadoId = $request->input('estado_id');

        // ONLY records received that are Terminados (9), Archivados (10) or Salientes (14)
        $query = $this->getBaseQuery($remDoc)
            ->whereIn('id_estado_rec', [9, 10, 14]);
            
        if ($estadoId) {
            $query->where('id_estado_rec', $estadoId);
        }

        $correspondencias = $query->paginate(10)->appends($request->query());

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();
        $estados = \App\Models\Estado::all();
        $ciudades = \App\Models\Ciudad::with('departamento')->orderBy('ciudad_nom')->get();

        $todosDestinatarios = \App\Models\Empleado::with('area')
            ->where('emple_rol', '=', 3)
            ->get()
            ->map(function($e) {
                return [
                    'emple_doc' => (string) $e->emple_doc,
                    'emple_nombres' => $e->emple_nombres,
                    'emple_apellidos' => $e->emple_apellidos,
                    'tipo' => 'empleado',
                    'area_nombre' => $e->area ? $e->area->area_nom : null
                ];
            })
            ->sortBy('emple_nombres')
            ->values();

        return view('remitente.recibidos', compact('stats', 'correspondencias', 'tipos', 'empleados', 'estados', 'estadoId', 'ciudades', 'todosDestinatarios'));
    }

    public function procesoSalientes()
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;

        $this->syncRejected($remDoc);
        $stats = $this->getStats($remDoc);

        // Records WITH response from employee and NOT salientes/finalizados
        $correspondencias = $this->getBaseQuery($remDoc)
            ->whereNotIn('id_estado_rec', [10, 14])
            ->whereHas('detalles', function($q) {
                $q->whereNotNull('archivo_res');
            })
            ->paginate(10);

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();

        return view('remitente.proceso_salientes', compact('stats', 'correspondencias', 'tipos', 'empleados'));
    }

    public function finalizados()
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;

        $this->syncRejected($remDoc);
        $stats = $this->getStats($remDoc);

        // ALL correspondence finished (14, 10)
        $correspondencias = $this->getBaseQuery($remDoc)
            ->whereIn('id_estado_rec', [10, 14])
            ->paginate(10);

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();

        return view('remitente.finalizados', compact('stats', 'correspondencias', 'tipos', 'empleados'));
    }

    private function getBaseQuery($remDoc)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        return Recibido::with([
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
            ->where('nit_empresa', $nitEmpresa)
            ->where(function($q) use ($remDoc) {
                $q->where('doc_quien_registra', $remDoc)
                  ->orWhereNull('doc_quien_registra');
            })
            ->orderByRaw('CASE WHEN id_estado_rec = 11 THEN 0 ELSE 1 END')
            ->orderByRaw('DATE(fecha_hora_recib) DESC')
            ->orderBy(\App\Models\Tipo::select('id_prioridad')
                ->whereColumn('tipo.id_tipo', 'recibido.id_tipo')
                ->limit(1), 'asc')
            ->orderBy('fecha_hora_recib', 'desc');
    }

    private function getStats($remDoc)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        $base = DB::table('recibido')
            ->where('nit_empresa', $nitEmpresa)
            ->where(function($q) use ($remDoc) {
                $q->where('doc_quien_registra', $remDoc)
                  ->orWhereNull('doc_quien_registra');
            });

        return [
            'total' => (clone $base)->count(),
            'rejected' => (clone $base)->where('id_estado_rec', 11)->count(),
            'resolved' => (clone $base)->whereIn('id_estado_rec', [9, 10, 14])->count(),
            'pending' => (clone $base)->whereNotIn('id_estado_rec', [9, 10, 11, 14])->count(),
        ];
    }

    private function syncRejected($remDoc)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        DB::table('recibido')
            ->where('nit_empresa', $nitEmpresa)
            ->where(function($q) use ($remDoc) {
                $q->where('doc_quien_registra', $remDoc)
                  ->orWhereNull('doc_quien_registra');
            })
            ->where('id_estado_rec', '!=', 11)
            ->whereIn('id_recibido', function($query) {
                $query->select('det_id_recibido')
                    ->from('detalle_recibido')
                    ->where('id_estado_rec', 11);
            })
            ->update(['id_estado_rec' => 11]);
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
            // 1. SKIP Radicado SAL- Logic. Use existing Radicado INT-
            $radicado = $recibido->radicado;
            if (!$radicado) {
                // Should not happen for public registration, but for safety:
                throw new \Exception('La correspondencia no tiene un radicado asociado.');
            }


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
                    'observaciones'    => 'Registrado como envío saliente (Respuesta enviada).',
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
                                        <div style='text-align: center;'>
                                            <span style='color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;'>Número de Radicado</span>
                                            <p style='color: #059669; font-size: 24px; font-weight: 700; margin: 8px 0 0;'>$numRadicado</p>
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
            return redirect()->back()->with('success', 'Envío saliente registrado exitosamente con el radicado: ' . $radicado->num_radicado);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar envío: ' . $e->getMessage());
        }
    }

    public function storeSalienteFromEnvio(Request $request, $id)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        $envio = \App\Models\Envio::where('id_envio', $id)
            ->where('nit_empresa', $nitEmpresa)
            ->firstOrFail();

        $request->validate([
            'destino' => 'required|string|max:200',
            'asunto'  => 'required|string|max:100',
            'correo'  => 'nullable|email|max:150',
            'observaciones' => 'nullable|string|max:250',
        ]);

        DB::beginTransaction();
        try {
            $envio->destino = $request->destino;
            $envio->asunto = $request->asunto;
            
            $obs = $request->observaciones ?? '';
            if ($request->filled('correo')) {
                $obs = trim($obs . ' [Correo Notificación: ' . $request->correo . ']');
            }
            $envio->observaciones = substr($obs, 0, 250);
            
            $envio->id_estado_envio = 12; // Enviado
            $envio->save();
            
            // Log trazabilidad if needed
            DB::table('detalle_envio')->insert([
                'id_envio' => $envio->id_envio,
                'id_quien_envie' => $envio->doc_quien_envia,
                'id_quien_recibe' => $envio->doc_quien_envia, // Copiamos el mismo ID o dejamos null
                'fecha_traslado' => now(),
                'id_estado_rec' => 12,
                'observaciones' => 'Envío procesado por ventanilla. ' . $envio->observaciones
            ]);

            DB::commit();
            
            // Send Notification Email if requested
            if ($request->filled('correo')) {
                try {
                    $radNum = $envio->radicado ? $envio->radicado->num_radicado : 'N/A';
                    // URL to the public consultation page with pre-filled radicado
                    $url = route('consultar', ['radicado' => $radNum]);
                    
                    $html = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <title>Notificación de Correspondencia Saliente</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
                        
                        <div style="background-color: #f8f9fa; border-radius: 8px; padding: 20px; border: 1px solid #e9ecef;">
                            <h2 style="color: #1a56db; margin-top: 0;">Tiene una nueva correspondencia</h2>
                            
                            <p>Estimado/a señor/a,</p>
                            
                            <p>Le informamos que se ha generado una nueva correspondencia a su nombre en nuestro sistema.</p>
                            
                            <div style="background-color: #fff; border-left: 4px solid #1a56db; padding: 15px; margin: 20px 0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                <p style="margin: 0; font-size: 16px;">
                                    <strong>Número de Radicado:</strong> <span style="color: #1a56db; font-weight: bold; font-size: 18px;">'.$radNum.'</span>
                                </p>
                            </div>
                            
                            <p>Para consultar el documento y sus detalles, por favor ingrese al siguiente enlace y utilice el número de radicado proporcionado:</p>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="'.$url.'" style="background-color: #1a56db; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                                    Consultar Correspondencia
                                </a>
                            </div>
                            
                            <p style="font-size: 13px; color: #6c757d; margin-top: 30px; border-top: 1px solid #e9ecef; padding-top: 20px;">
                                <small>
                                    Este es un mensaje automático, por favor no responda a este correo. Si no puede hacer clic en el botón, copie y pegue la siguiente URL en su navegador:<br>
                                    <a href="'.$url.'" style="color: #1a56db; word-break: break-all;">'.$url.'</a>
                                </small>
                            </p>
                        </div>
                    </body>
                    </html>';

                    Mail::html($html, function ($message) use ($request, $radNum) {
                        $message->to($request->correo)
                                ->subject('Notificación de Correspondencia Saliente - Radicado ' . $radNum);
                    });
                } catch (\Exception $mailEx) {
                    \Illuminate\Support\Facades\Log::error('Error enviando correo de notificacion saliente: ' . $mailEx->getMessage());
                    // we still proceed to return success even if mail fails, just log it.
                }
            }
            
            // If we need to return the URL for printing
            // Since it's a form submit, we can just redirect back and maybe flash a message or a print URL
            return redirect()->back()->with('success', 'Envío procesado exitosamente. Radicado: ' . ($envio->radicado ? $envio->radicado->num_radicado : 'N/A'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar el envío: ' . $e->getMessage());
        }
    }

    /**
     * Reportes de gestión para el Remitente (Scoped by NIT)
     */
    public function reportes(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        if (!$remitente || !$remitente->nit_empresa) {
            return view('remitente.reportes', ['reporteAreas' => [], 'mensaje' => 'No estás registrado a una empresa.']);
        }

        $reporteAreas = $this->calcularReporteAreas($request);
        return view('remitente.reportes', compact('reporteAreas'));
    }

    public function exportPdf(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        if (!$remitente || !$remitente->nit_empresa) {
            return redirect()->back()->with('error', 'No estás registrado a una empresa.');
        }

        $reporteAreas = $this->calcularReporteAreas($request);
        $barChart = $request->input('barChart');
        $doughnutChart = $request->input('doughnutChart');

        $pdf = Pdf::loadView('admin.pdf.reportes_pdf', compact('reporteAreas', 'barChart', 'doughnutChart'))->setPaper('A4', 'portrait');
        return $pdf->download('reporte_gestion_remitente.pdf');
    }

    private function calcularReporteAreas(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $nit = $remitente->nit_empresa;
        $periodo = $request->input('periodo');

        // Subquery for the latest internal detail per document/recipient
        $latestInternalSubquery = DetalleEnvio::select(DB::raw('MAX(id_detalle) as id_detalle'))
            ->groupBy('id_envio', 'id_quien_recibe');

        $areas = Area::all();
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

            // --- 2. EXTERNAL CORRESPONDENCE (Recibido) ---
            $queryExterna = DetalleRecibido::whereIn('det_doc_empleado', $empleadosDocs)
                ->with(['recibido.tipo']);

            if ($periodo && $periodo != 'todo') {
                $queryExterna->whereHas('recibido', function ($q) use ($request, $periodo) {
                    $this->applyDateFilters($q, $request, $periodo, 'fecha_hora_recib');
                });
            }

            $detallesInternos = $queryInterna->get();
            $detallesExternos = $queryExterna->get();

            $totalAsignados = $detallesInternos->count() + $detallesExternos->count();
            $countTramite = 0;
            $countFinalizado = 0;
            $countVencidos = 0;

            $allDetails = $detallesInternos->concat($detallesExternos);

            foreach ($allDetails as $det) {
                $idEstado = $det->id_estado_rec;
                
                if ($idEstado == 8) {
                    $countTramite++;
                } elseif (in_array($idEstado, [9, 10, 11])) {
                    $countFinalizado++;
                }

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
                'area_nom' => $area->area_nom,
                'asignados' => $totalAsignados,
                'tramite' => $countTramite,
                'finalizado' => $countFinalizado,
                'vencidos' => $countVencidos,
                'eficiencia' => $totalAsignados > 0 ? round(($countFinalizado / $totalAsignados) * 100) : 0
            ];
        }

        return $reporteAreas;
    }

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

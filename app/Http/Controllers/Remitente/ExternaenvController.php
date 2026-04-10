<?php

namespace App\Http\Controllers\Remitente;

use App\Http\Controllers\Controller;
use App\Models\Envio;
use App\Models\Tipo;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\Empleado;
use App\Models\Radicado;
use App\Models\Remitente;
use App\Models\Area;
use App\Models\AnexoEnvio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExternaenvController extends Controller
{
    /**
     * BANDEJA DE ENVIADOS (VENTANILLA)
     * Visualiza el historial de correspondencia despachada por la empresa a destinatarios externos o internos.
     */
    public function index(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        $search = $request->input('search');
        $estadoId = $request->input('estado_id');
        $tab = $request->input('tab', 'interna');

        // Traemos los envíos con sus relaciones cargadas.
        $query = Envio::with([
            'radicado', 
            'tipoEnvio', 
            'estadoEnvio',
            'anexos'
        ])
        ->where('nit_empresa', $nitEmpresa)
        ->where('id_estado_envio', '!=', 0); // Exclude 'En espera' from external view until registered

        // Filtrar por pestaña según el prefijo del radicado
        if ($tab === 'interna') {
            $query->whereHas('radicado', function($q) {
                $q->where('num_radicado', 'like', 'INT-%');
            });
        } elseif ($tab === 'saliente') {
            $query->whereHas('radicado', function($q) {
                $q->where('num_radicado', 'like', 'SAL-%');
            });
        } else {
            $query->whereHas('radicado', function($q) {
                $q->where('num_radicado', 'like', 'EXT-%');
            });
        }

        $query->orderByRaw('DATE(fecha) DESC')
        ->orderBy(\App\Models\Tipo::select('id_prioridad')
            ->whereColumn('tipo.id_tipo', 'envio.id_tipo_envio')
            ->limit(1), 'asc')
        ->orderBy('fecha', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('asunto', 'like', "%{$search}%")
                  ->orWhere('destino', 'like', "%{$search}%")
                  ->orWhereHas('radicado', function($qr) use ($search) {
                      $qr->where('num_radicado', 'like', "%{$search}%");
                  });
            });
        }

        if ($estadoId) {
            $query->where('id_estado_envio', $estadoId);
        }

        // T10: Filtro adicional por fecha
        if ($request->fecha) {
            $query->whereDate('envio.fecha', $request->fecha);
        }

        // T11: Filtro por prioridad (buscando a través de la tabla tipo)
        if ($request->prioridad_id) {
            $query->whereHas('tipoEnvio', function($q) use ($request) {
                $q->where('id_prioridad', $request->prioridad_id);
            });
        }

        // Re-ordering logic ensuring priority
        $query->orderByRaw('DATE(fecha) DESC')
            ->orderBy(\App\Models\Tipo::select('id_prioridad')
                ->whereColumn('tipo.id_tipo', 'envio.id_tipo_envio')
                ->limit(1), 'asc')
            ->orderBy('fecha', 'desc');

        $envios = $query->paginate(10)->appends($request->query());

        $stats = [
            'total' => Envio::where('nit_empresa', $nitEmpresa)->count(),
            'rejected' => Envio::where('nit_empresa', $nitEmpresa)->whereHas('estadoEnvio', function ($q) {
                $q->where('estado_nomb', 'like', '%rechazado%');
            })->count(),
            'pending' => Envio::where('nit_empresa', $nitEmpresa)->whereHas('estadoEnvio', function ($q) {
                $q->where('estado_nomb', 'like', '%pendiente%')->orWhere('estado_nomb', 'like', '%espera%');
            })->count(),
            'resolved' => Envio::where('nit_empresa', $nitEmpresa)->whereHas('estadoEnvio', function ($q) {
                $q->where('estado_nomb', 'like', '%enviado%')->orWhere('estado_nomb', 'like', '%resuelto%');
            })->count(),
        ];

        $tipos = Tipo::all();
        $estados = Estado::all();
        $empleados = Empleado::where('emple_rol', 3)->where('nit_empresa', $nitEmpresa)->get();
        $ciudades = Ciudad::orderBy('ciudad_nom')->get();
        $areas = Area::orderBy('area_nom')->get();
        $prioridades = \App\Models\Prioridad::all();

        return view('remitente.externaenv', compact('envios', 'tipos', 'estados', 'ciudades', 'areas', 'search', 'estadoId', 'stats', 'tab', 'prioridades', 'empleados'));
    }

    /**
     * REGISTRAR ENVÍO SALIENTE
     * Crea un nuevo radicado de salida, guarda el documento principal y notifica por correo al destinatario.
     */
    public function store(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;
        $docQuienRegistra = $remitente ? $remitente->rem_doc : null;

        $request->validate([
            'destino'            => 'required|string|max:255',
            'asunto'             => 'required|string|max:500',
            'id_tipo_envio'      => 'required', // Se valida manualmente si es OTRO
            'tipo_otro'          => 'required_if:id_tipo_envio,OTRO|nullable|string|max:100',
            'notificar_correo'   => 'nullable|email|max:150',
            'doc_quien_envia'    => 'nullable|string|max:20',
            'folio'              => 'required|integer|min:1|max:999',
            'archivo'            => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:20480',
            'anexos'             => 'nullable|array|max:10',
            'anexos.*'           => 'file|mimes:pdf,doc,docx,jpg,png|max:20480',
        ], [
            'destino.required'         => 'El destino es obligatorio.',
            'asunto.required'          => 'El asunto es obligatorio.',
            'id_tipo_envio.required'   => 'Debe seleccionar un tipo de documento.',
            'tipo_otro.required_if'    => 'Debe especificar el tipo de documento.',
            'notificar_correo.email'   => 'El correo de notificación no es válido.',
            'folio.required'           => 'El número de folios es obligatorio.',
            'folio.min'                => 'El número de folios debe ser al menos 1.',
            'archivo.mimes'            => 'El archivo debe ser en formato PDF, Word o Imagen.',
            'archivo.max'              => 'El archivo no debe superar los 20MB.',
            'anexos.*.max'             => 'Cada anexo no debe superar los 20MB.',
        ]);

        // Validación de tamaño total acumulado (principal + todos los anexos) = máximo 20MB
        $totalBytes = 0;
        if ($request->hasFile('archivo')) {
            $totalBytes += $request->file('archivo')->getSize();
        }
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $anexoFile) {
                $totalBytes += $anexoFile->getSize();
            }
        }
        if ($totalBytes > 20 * 1024 * 1024) {
            return redirect()->back()->withInput()->withErrors([
                'archivo' => 'El tamaño total de todos los archivos adjuntos no debe superar los 20MB. Tamaño actual: ' . round($totalBytes / 1024 / 1024, 2) . 'MB.',
            ]);
        }

        // Validación de tamaño total acumulado (archivo + anexos) = máximo 20MB
        $totalBytes = 0;
        if ($request->hasFile('archivo')) {
            $totalBytes += $request->file('archivo')->getSize();
        }
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $anexoFile) {
                $totalBytes += $anexoFile->getSize();
            }
        }
        $maxBytes = 20 * 1024 * 1024; // 20MB
        if ($totalBytes > $maxBytes) {
            return redirect()->back()->withInput()->withErrors([
                'archivo' => 'El tamaño total de archivos adjuntos no debe superar los 20MB. Tamaño actual: ' . round($totalBytes / 1024 / 1024, 2) . 'MB.',
            ]);
        }

        // Responsable: El quien envía (seleccionado) y quien registra (automático)
        $docQuienEnvio = $request->doc_quien_envia ?? $docQuienRegistra; 
        $docQuienRegistra = $request->doc_quien_registra ?? $docQuienRegistra;

        $rutaArchivo = null;
        if ($request->hasFile('archivo')) {
            $rutaArchivo = $request->file('archivo')->store('correspondencia/enviados', 'public');
        }

        DB::beginTransaction();
        try {
            // Generación de Radicado — prefijo SAL para correspondencia saliente
            $currentYear = date('Y');
            $latestRadicado = Radicado::where('nit_empresa', $nitEmpresa)
                ->where('num_radicado', 'like', 'SAL-' . $currentYear . '-%')
                ->orderBy('num_radicado', 'desc')
                ->lockForUpdate()
                ->first();

            $newNumber = $latestRadicado ? intval(substr($latestRadicado->num_radicado, -5)) + 1 : 1;
            
            $radicado = Radicado::create([
                'num_radicado' => 'SAL-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT),
                'nit_empresa'  => $nitEmpresa,
            ]);

            $idTipo = $request->id_tipo_envio;
            $asuntoFinal = $request->asunto;

            // Manejo de "Otro" tipo de documento
            if ($idTipo === 'OTRO') {
                $asuntoFinal = "[TIPO: " . strtoupper($request->tipo_otro) . "] " . $asuntoFinal;
                // Buscamos un tipo válido para asignar en la BD (el primero disponible)
                $tipoDefault = \App\Models\Tipo::first();
                $idTipo = $tipoDefault ? $tipoDefault->id_tipo : null;
            }

            $envio = Envio::create([
                'num_radicado_int'   => $radicado->id_radicado,
                'asunto'             => $asuntoFinal,
                'destino'            => $request->destino,
                'doc_quien_envia'    => $docQuienEnvio,
                'fecha'              => now(),
                'folio'              => $request->folio,
                'id_tipo_envio'      => $idTipo,
                'id_estado_envio'    => 12, // 'Enviado' 
                'archivo'            => $rutaArchivo,
                'nit_empresa'        => $nitEmpresa,
                'doc_quien_registra' => $docQuienRegistra,
            ]);

            // Guardar anexos si existen
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $file) {
                    $path = $file->store('correspondencia/anexos', 'public');
                    AnexoEnvio::create([
                        'id_envio' => $envio->id_envio,
                        'ruta_archivo' => $path,
                        'nombre_original' => $file->getClientOriginalName(),
                    ]);
                }
            }

            // Envío de correo de notificación si se proporcionó
            if ($request->notificar_correo) {
                $empresa = \App\Models\Empresa::find($nitEmpresa);
                $nombreEmpresa = $empresa ? $empresa->nomb_empresa : 'Nuestra Empresa';
                $nombreRemitente = $remitente->rem_nombres . ' ' . $remitente->rem_apellidos;
                $emailDestino = $request->notificar_correo;
                $radicadoGenerado = $radicado->num_radicado;

                try {
                    \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($emailDestino, $nombreEmpresa, $nombreRemitente, $asuntoFinal, $radicadoGenerado) {
                        $message->to($emailDestino)
                            ->subject('Notificación de Envío de Correspondencia - ' . $radicadoGenerado)
                            ->html("
                                <div style='font-family: Arial, sans-serif; padding: 20px; color: #333;'>
                                    <h2 style='color: #1e63e9;'>Notificación de Envío</h2>
                                    <p>Se le informa que la empresa <strong>{$nombreEmpresa}</strong>, a través del funcionario <strong>{$nombreRemitente}</strong>, ha realizado un envío de correspondencia.</p>
                                    <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                                    <p><strong>Número de Radicado:</strong> {$radicadoGenerado}</p>
                                    <p><strong>Asunto:</strong> {$asuntoFinal}</p>
                                    <p><strong>Fecha:</strong> " . now()->format('d/m/Y H:i') . "</p>
                                    <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                                    <p style='font-size: 13px; color: #666;'>Puede consultar el estado de este envío en nuestro portal de correspondencia con su número de radicado.</p>
                                    <p style='font-size: 11px; color: #999; margin-top: 30px;'>© " . date('Y') . " EASYCOR. Mensaje automático.</p>
                                </div>
                            ");
                    });
                } catch (\Exception $eEmail) {
                    // Si falla el envío de correo, no revertimos el registro, solo registramos el error
                    \Illuminate\Support\Facades\Log::error("Error al enviar correo de notificación: " . $eEmail->getMessage());
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Correspondencia saliente registrada exitosamente con radicado: ' . $radicado->num_radicado);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al registrar: ' . $e->getMessage()]);
        }
    }


    public function buscarEmpleados(Request $request)
    {
        $q = trim($request->get('q', ''));
        $areaId = $request->get('area_id');
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente ? $remitente->rem_doc : null;
        
        $query = Empleado::leftJoin('area', 'empleado.emple_area', '=', 'area.id_area')
            ->where('empleado.nit_empresa', $remitente->nit_empresa)
            ->where('empleado.emple_rol', 3) // Solo rol empleado
            ->where('empleado.emple_rol', '!=', 1); // T8b: Excluir Super Admin

        if ($areaId) {
            $query->where('empleado.emple_area', $areaId);
        }

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('empleado.emple_nombres', 'like', "%{$q}%")
                   ->orWhere('empleado.emple_apellidos', 'like', "%{$q}%")
                   ->orWhere('empleado.emple_doc', 'like', "%{$q}%")
                   ->orWhere('area.area_nom', 'like', "%{$q}%");
            });
        }

        $empleados = $query->limit(10)
            ->get([
                'empleado.emple_doc', 
                'empleado.emple_nombres', 
                'empleado.emple_apellidos',
                'area.area_nom'
            ]);

        return response()->json($empleados);
    }

    /**
     * OBTENER HISTORIAL DE ENVÍO
     * Recupera la trazabilidad completa (registro inicial + traslados) para el componente de línea de tiempo.
     */
    public function getHistory($id)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        // 1. Registro inicial (envio)
        $registration = DB::table('envio as e')
            ->join('radicados as rad', 'e.num_radicado_int', '=', 'rad.id_radicado')
            ->leftJoin('remitente as rem', 'e.doc_quien_registra', '=', 'rem.rem_doc')
            ->where('e.id_envio', $id)
            ->where('e.nit_empresa', $nitEmpresa)
            ->select(
                DB::raw("'registry' as type"),
                'e.fecha as fecha',
                'rem.rem_nombres as nombres',
                'rem.rem_apellidos as apellidos',
                'rad.num_radicado',
                DB::raw("'Registrado y Enviado Externamente' as estado_nomb"),
                DB::raw("NULL as observaciones"),
                DB::raw("NULL as img")
            )
            ->first();

        if (!$registration) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        // 2. Transiciones de ciclo (detalle_envio)
        $details = DB::table('detalle_envio as de')
            ->leftJoin('estado as est', 'de.id_estado_rec', '=', 'est.id_estado')
            ->leftJoin('empleado as emp_e', 'de.id_quien_envie', '=', 'emp_e.emple_doc')
            ->leftJoin('area as area_e', 'emp_e.emple_area', '=', 'area_e.id_area')
            ->leftJoin('empleado as emp_r', 'de.id_quien_recibe', '=', 'emp_r.emple_doc')
            ->leftJoin('area as area_r', 'emp_r.emple_area', '=', 'area_r.id_area')
            ->where('de.id_envio', $id)
            ->select(
                DB::raw("'detail' as type"),
                'de.fecha_traslado as fecha',
                DB::raw("COALESCE(emp_e.emple_nombres, 'No') as nombres_e"),
                DB::raw("COALESCE(emp_e.emple_apellidos, 'asignada') as apellidos_e"),
                DB::raw("COALESCE(emp_r.emple_nombres, 'No') as nombres_r"),
                DB::raw("COALESCE(emp_r.emple_apellidos, 'asignado') as apellidos_r"),
                'est.estado_nomb',
                'de.observaciones',
                'area_e.area_nom as area_e',
                'area_r.area_nom as area_r',
                'emp_e.emple_img as img',
                'de.id_estado_rec',
                'de.id_detalle',
                'de.archivo_respuesta as archivo_res'
            )
            ->orderBy('de.fecha_traslado', 'asc')
            ->get();

        $history = [];
        $history[] = (array) $registration;

        foreach ($details as $d) {
            $det = (array) $d;
            $det['nombres'] = $d->nombres_e;
            $det['apellidos'] = $d->apellidos_e;
            
            if ($d->nombres_r && $d->nombres_r !== 'No') {
                $receptor = " -> Destino: {$d->nombres_r} {$d->apellidos_r}";
                $det['observaciones'] = ($det['observaciones'] ?? '') . $receptor;
            }

            // Strip sensitive document info from observations
            $det['observaciones'] = preg_replace('/^(CC|TI|CE|NIT|PAS|PEP)\s+\d+\s+-\s+/', '', $det['observaciones'] ?? '');

            $det['anexos'] = DB::table('anexo_respuesta')
                ->where('id_det_interna', $d->id_detalle)
                ->select('ruta_archivo', 'nombre_original')
                ->get();
                
            $history[] = $det;
        }

        return response()->json($history);
    }
}

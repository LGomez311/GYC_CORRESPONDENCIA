<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recibido;
use App\Models\DetalleEnvio;
use App\Models\DetalleRecibido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\RespuestaCorrespondenciaExterna;
use App\Mail\CorrespondenciaSalienteNotification;


class CorrespondenciaController extends Controller
{
    /**
     * BANDEJA DE ENTRADA (MÓDULO PRINCIPAL)
     * Carga y filtra las correspondencias externas e internas pendientes de gestión para el empleado autenticado.
     */
    public function recibida(Request $request)
    {
        // Get the current user
        $user = Auth::user();

        // ============================================================
        // BANDEJA EXTERNA: basada en detalle_recibido del empleado.
        // El estado en 'recibido' lo maneja el recepcionista (Enviado=12).
        // El estado del empleado se almacena en 'detalle_recibido.id_estado_rec'.
        // ============================================================
        $queryExt = DetalleRecibido::where('det_doc_empleado', $user->emple_doc);

        // Para evitar duplicados de historial: solo el último detalle por id_recibido
        $latestExtSubquery = clone $queryExt;
        $latestExtSubquery = $latestExtSubquery
            ->select(\Illuminate\Support\Facades\DB::raw('MAX(id_det_recibido) as id_det_recibido'))
            ->groupBy('det_id_recibido');

        $queryBandejaUnicaExt = DetalleRecibido::whereIn('id_det_recibido', $latestExtSubquery)
            ->where('det_doc_empleado', $user->emple_doc);

        $totalRecibidas = (clone $queryBandejaUnicaExt)->count();
        $enTramite      = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 8)->count();
        $finalizadas    = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 9)->count();
        $archivadas     = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 10)->count();
        $vencidas       = 0;

        $searchExt = $request->input('search_ext', '');
        $estadoExt = $request->input('estado_ext', '');

        $estadosPermitidosExt = [7, 8];
        if ($estadoExt == '7') {
            $estadosPermitidosExt = [7];
        } elseif ($estadoExt == '8') {
            $estadosPermitidosExt = [8];
        }

        // Solo mostramos los que el empleado aún tiene activos (Recibido=7, En Tramite=8)
        $correspondencias = (clone $queryBandejaUnicaExt)
            ->whereIn('detalle_recibido.id_estado_rec', $estadosPermitidosExt)
            ->with(['recibido.radicado', 'recibido.tipo.prioridad', 'recibido.ciudad', 'recibido.anexos', 'estado', 'anexosRespuesta', 'recibido.destinatarios'])
            ->leftJoin('recibido', 'detalle_recibido.det_id_recibido', '=', 'recibido.id_recibido')
            ->leftJoin('tipo', 'recibido.id_tipo', '=', 'tipo.id_tipo')
            ->leftJoin('prioridad', 'tipo.id_prioridad', '=', 'prioridad.id_prioridad')
            ->leftJoin('radicados', 'recibido.num_radicado_int', '=', 'radicados.id_radicado')
            ->where(function ($q) use ($searchExt) {
                if ($searchExt) {
                    $q->where('radicados.num_radicado', 'like', '%' . $searchExt . '%')
                      ->orWhere('recibido.num_radicado_ext', 'like', '%' . $searchExt . '%')
                      ->orWhere('recibido.asunto', 'like', '%' . $searchExt . '%')
                      ->orWhere('tipo.tipo_nombre', 'like', '%' . $searchExt . '%');
                }
            })
            ->select('detalle_recibido.*')
            ->orderByRaw("
                CASE 
                    WHEN detalle_recibido.id_estado_rec = 7 THEN 1
                    WHEN detalle_recibido.id_estado_rec = 8 THEN 2
                    ELSE 3
                END ASC
            ")
            ->orderByRaw("
                CASE 
                    WHEN prioridad.prioridad_nombre LIKE '%Urgente%' OR tipo.id_prioridad = 4 THEN 1
                    WHEN prioridad.prioridad_nombre LIKE '%Alta%' OR tipo.id_prioridad = 1 THEN 2
                    WHEN prioridad.prioridad_nombre LIKE '%Media%' OR tipo.id_prioridad = 2 THEN 3
                    WHEN prioridad.prioridad_nombre LIKE '%Baja%' OR tipo.id_prioridad = 3 THEN 4
                    ELSE 5
                END ASC
            ")
            ->orderBy('detalle_recibido.id_det_recibido', 'desc')
            ->paginate(10, ['*'], 'ext_page');

        // Start query for BANDEJA INTERNA
        $queryInterna = DetalleEnvio::with(['envio', 'envio.tipoEnvio', 'envio.radicado', 'quienEnvia', 'quienEnvia.area', 'estado', 'anexosRespuesta'])
            ->where('id_quien_recibe', $user->emple_doc);

        // Fix counters using grouping subquery so we don't count history duplicates
        $latestDetalleSubqueryInt = clone $queryInterna;
        $latestDetalleSubqueryInt = $latestDetalleSubqueryInt->select(\Illuminate\Support\Facades\DB::raw('MAX(id_detalle) as id_detalle'))->groupBy('id_envio');

        $queryBandejaUnicaInt = DetalleEnvio::whereIn('id_detalle', $latestDetalleSubqueryInt)->where('id_quien_recibe', $user->emple_doc);

        $totalInternas = (clone $queryBandejaUnicaInt)->count();
        $enTramiteInt = (clone $queryBandejaUnicaInt)->where('id_estado_rec', 8)->count();
        $finalizadasInt = (clone $queryBandejaUnicaInt)->where('id_estado_rec', 9)->count();
        $archivadasInt = (clone $queryBandejaUnicaInt)->where('id_estado_rec', 10)->count();
        $vencidasInt = 0; // Marcador de posición para vencidas.

        $searchInt = $request->input('search_int', '');
        $estadoInt = $request->input('estado_int', '');

        $estadosPermitidosInt = [7, 8];
        if ($estadoInt == '7') {
            $estadosPermitidosInt = [7];
        } elseif ($estadoInt == '8') {
            $estadosPermitidosInt = [8];
        }

        // Custom Sorting for Internas
        $correspondenciasInternas = clone $queryBandejaUnicaInt;
        $correspondenciasInternas = $correspondenciasInternas
            ->whereIn('detalle_envio.id_estado_rec', $estadosPermitidosInt)
            ->with(['envio', 'envio.tipoEnvio.prioridad', 'envio.radicado', 'quienEnvia', 'quienEnvia.area', 'estado', 'anexosRespuesta', 'envio.recipients'])
            ->leftJoin('envio', 'detalle_envio.id_envio', '=', 'envio.id_envio')
            ->leftJoin('tipo', 'envio.id_tipo_envio', '=', 'tipo.id_tipo')
            ->leftJoin('prioridad', 'tipo.id_prioridad', '=', 'prioridad.id_prioridad')
            ->leftJoin('radicados', 'envio.num_radicado_int', '=', 'radicados.id_radicado')
            ->where(function ($q) use ($searchInt) {
                if ($searchInt) {
                    $q->where('radicados.num_radicado', 'like', '%' . $searchInt . '%')
                      ->orWhere('envio.asunto', 'like', '%' . $searchInt . '%')
                      ->orWhere('tipo.tipo_nombre', 'like', '%' . $searchInt . '%');
                }
            })
            ->select('detalle_envio.*') // Evitar superposición de columnas
            ->orderByRaw("
                CASE 
                    WHEN detalle_envio.id_estado_rec = 7 THEN 1
                    WHEN detalle_envio.id_estado_rec = 8 THEN 2
                    ELSE 3 
                END ASC
            ")
            ->orderByRaw("
                CASE 
                    WHEN prioridad.prioridad_nombre LIKE '%Urgente%' OR tipo.id_prioridad = 4 THEN 1
                    WHEN prioridad.prioridad_nombre LIKE '%Alta%' OR tipo.id_prioridad = 1 THEN 2
                    WHEN prioridad.prioridad_nombre LIKE '%Media%' OR tipo.id_prioridad = 2 THEN 3
                    WHEN prioridad.prioridad_nombre LIKE '%Baja%' OR tipo.id_prioridad = 3 THEN 4
                    ELSE 5
                END ASC
            ")
            ->orderBy('detalle_envio.id_detalle', 'desc')
            ->paginate(10, ['*'], 'int_page');

        // T8b: Excluir Super Admin (rol=1) de la lista de disponibles
        $empleados = \App\Models\Empleado::where('emple_estado', 1)
            ->where('nit_empresa', $user->nit_empresa)
            ->where('emple_rol', '!=', 1)
            ->get();

        // Fetch document types
        $tipos = \App\Models\Tipo::all();

        // Fetch remitentes of the same company (Ventanilla users)
        $remitentes = \App\Models\Remitente::where('nit_empresa', $user->nit_empresa)->get();
        
        // Fetch sent internal communications (Outbox)
        $enviosInternos = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'quienDirigido'])
            ->where('doc_quien_envia', $user->emple_doc)
            ->where('nit_empresa', $user->nit_empresa)
            ->orderBy('id_envio', 'desc')
            ->take(20)
            ->get();
            
        // Fetch current recipients for each sent item
        foreach ($enviosInternos as $e) {
            $e->destinatarios_actuales = \App\Models\DetalleEnvio::with(['quienRecibe.area', 'estado'])
                ->where('id_envio', $e->id_envio)
                ->whereIn('id_detalle', function($query) use ($e) {
                    $query->select(\Illuminate\Support\Facades\DB::raw('MAX(id_detalle)'))
                        ->from('detalle_envio')
                        ->where('id_envio', $e->id_envio)
                        ->groupBy('id_quien_recibe');
                })->get();
        }

        // Fetch areas
        $areas = \App\Models\Area::orderBy('area_nom')->get();

        return view('empleado.correspondencia_recibida', compact(
            'correspondencias', 'totalRecibidas', 'enTramite', 'finalizadas', 'archivadas', 'vencidas',
            'correspondenciasInternas', 'totalInternas', 'enTramiteInt', 'finalizadasInt', 'archivadasInt', 'vencidasInt',
            'empleados', 'tipos', 'remitentes', 'areas', 'enviosInternos'
        ));
    }

    /**
     * BANDEJA DE FINALIZADAS
     * Muestra el histórico de correspondencias que ya han sido resueltas, archivadas o rechazadas por el empleado.
     */
    public function finalizada(Request $request)
    {
        // Get the current user
        $user = Auth::user();

        // BANDEJA EXTERNA FINALIZADA: filtramos por el estado del empleado en detalle_recibido
        $queryExtFin = DetalleRecibido::where('det_doc_empleado', $user->emple_doc);

        $latestExtFinSubquery = clone $queryExtFin;
        $latestExtFinSubquery = $latestExtFinSubquery
            ->select(\Illuminate\Support\Facades\DB::raw('MAX(id_det_recibido) as id_det_recibido'))
            ->groupBy('det_id_recibido');

        $queryBandejaUnicaExt = DetalleRecibido::whereIn('id_det_recibido', $latestExtFinSubquery)
            ->where('det_doc_empleado', $user->emple_doc);

        $totalRecibidas = (clone $queryBandejaUnicaExt)->count();
        $enTramite      = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 8)->count();
        $finalizadas    = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 9)->count();
        $archivadas     = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 10)->count();
        $vencidas       = 0;
        $searchExt = $request->input('search_ext', '');
        $estadoExt = $request->input('estado_ext', '');

        $estadosPermitidosExt = [9, 10, 11];
        if ($estadoExt == '9') {
            $estadosPermitidosExt = [9, 11]; // Resueltas o rechazados
        } elseif ($estadoExt == '10') {
            $estadosPermitidosExt = [10]; // Archivados
        }

        $queryBandejaUnicaExtFin = DetalleRecibido::whereIn('id_det_recibido', $latestExtFinSubquery)
            ->where('det_doc_empleado', $user->emple_doc);

        $correspondencias = (clone $queryBandejaUnicaExtFin)
            ->whereIn('detalle_recibido.id_estado_rec', $estadosPermitidosExt)
            ->with(['recibido.radicado', 'recibido.tipo.prioridad', 'recibido.ciudad', 'recibido.anexos', 'estado', 'anexosRespuesta', 'recibido.destinatarios'])
            ->leftJoin('recibido', 'detalle_recibido.det_id_recibido', '=', 'recibido.id_recibido')
            ->leftJoin('tipo', 'recibido.id_tipo', '=', 'tipo.id_tipo')
            ->leftJoin('prioridad', 'tipo.id_prioridad', '=', 'prioridad.id_prioridad')
            ->leftJoin('radicados', 'recibido.num_radicado_int', '=', 'radicados.id_radicado')
            ->where(function ($q) use ($searchExt) {
                if ($searchExt) {
                    $q->where('radicados.num_radicado', 'like', '%' . $searchExt . '%')
                      ->orWhere('recibido.num_radicado_ext', 'like', '%' . $searchExt . '%')
                      ->orWhere('recibido.asunto', 'like', '%' . $searchExt . '%')
                      ->orWhere('tipo.tipo_nombre', 'like', '%' . $searchExt . '%');
                }
            })
            ->select('detalle_recibido.*')
            ->orderBy('detalle_recibido.id_det_recibido', 'desc')
            ->paginate(10, ['*'], 'ext_page');

        // Start query for BANDEJA INTERNA
        $queryInterna = DetalleEnvio::with(['envio', 'envio.tipoEnvio', 'envio.radicado', 'quienEnvia', 'quienEnvia.area', 'estado', 'anexosRespuesta'])
            ->where('id_quien_recibe', $user->emple_doc);

        $latestDetalleSubqueryInt = clone $queryInterna;
        $latestDetalleSubqueryInt = $latestDetalleSubqueryInt->select(\Illuminate\Support\Facades\DB::raw('MAX(id_detalle) as id_detalle'))->groupBy('id_envio');

        $queryBandejaUnicaInt = DetalleEnvio::whereIn('id_detalle', $latestDetalleSubqueryInt)->where('id_quien_recibe', $user->emple_doc);

        $totalInternas = (clone $queryBandejaUnicaInt)->count();
        $enTramiteInt = (clone $queryBandejaUnicaInt)->where('id_estado_rec', 8)->count();
        $finalizadasInt = (clone $queryBandejaUnicaInt)->where('id_estado_rec', 9)->count();
        $archivadasInt = (clone $queryBandejaUnicaInt)->where('id_estado_rec', 10)->count();
        $vencidasInt = 0;

        $searchInt = $request->input('search_int', '');
        $estadoInt = $request->input('estado_int', '');

        $estadosPermitidosInt = [9, 10, 11];
        if ($estadoInt == '9') {
            $estadosPermitidosInt = [9, 11]; // Resueltas o rechazados
        } elseif ($estadoInt == '10') {
            $estadosPermitidosInt = [10]; // Archivados
        }

        $correspondenciasInternas = clone $queryBandejaUnicaInt;
        $correspondenciasInternas = $correspondenciasInternas
            ->whereIn('detalle_envio.id_estado_rec', $estadosPermitidosInt)
            ->with(['envio', 'envio.tipoEnvio.prioridad', 'envio.radicado', 'quienEnvia', 'quienEnvia.area', 'estado', 'anexosRespuesta', 'envio.recipients'])
            ->leftJoin('envio', 'detalle_envio.id_envio', '=', 'envio.id_envio')
            ->leftJoin('tipo', 'envio.id_tipo_envio', '=', 'tipo.id_tipo')
            ->leftJoin('prioridad', 'tipo.id_prioridad', '=', 'prioridad.id_prioridad')
            ->leftJoin('radicados', 'envio.num_radicado_int', '=', 'radicados.id_radicado')
            ->where(function ($q) use ($searchInt) {
                if ($searchInt) {
                    $q->where('radicados.num_radicado', 'like', '%' . $searchInt . '%')
                      ->orWhere('envio.asunto', 'like', '%' . $searchInt . '%')
                      ->orWhere('tipo.tipo_nombre', 'like', '%' . $searchInt . '%');
                }
            })
            ->select('detalle_envio.*')
            ->orderBy('detalle_envio.id_detalle', 'desc')
            ->paginate(10, ['*'], 'int_page');

        // Fetch all active employees for the reassignment modal
        $empleados = \App\Models\Empleado::where('emple_estado', 1)
            ->where('nit_empresa', $user->nit_empresa)
            ->get();

        // Fetch document types
        $tipos = \App\Models\Tipo::all();

        return view('empleado.correspondencia_finalizada', compact(
            'correspondencias', 'totalRecibidas', 'enTramite', 'finalizadas', 'archivadas', 'vencidas',
            'correspondenciasInternas', 'totalInternas', 'enTramiteInt', 'finalizadasInt', 'archivadasInt', 'vencidasInt',
            'empleados', 'tipos'
        ));
    }

    /**
     * ACTUALIZAR ESTADO (CORRESPONDENCIA EXTERNA)
     * Permite al empleado cambiar el estado de una correspondencia externa, adjuntar archivos de respuesta 
     * y registrar observaciones en la trazabilidad.
     */
    public function actualizarEstado(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'estado_nomb'        => 'required',
            'observaciones'      => 'nullable|string',
            'archivo_respuesta'  => 'nullable|file|mimes:pdf|max:5120',
            'archivos_respuesta.*' => 'nullable|file|mimes:pdf|max:25600',
            'folios_respuesta'   => 'nullable|integer',
        ]);

        // $id es ahora id_det_recibido (el registro personal del empleado)
        $detalleAntiguo = DetalleRecibido::with('estado')->findOrFail($id);

        if (in_array($detalleAntiguo->id_estado_rec, [9, 10]) || stripos($detalleAntiguo->estado?->estado_nomb ?? '', 'rechazado') !== false) {
            return back()->with('error', 'Esta correspondencia ya se encuentra finalizada, archivada o rechazada.');
        }

        $estado = \App\Models\Estado::where('estado_nomb', $request->estado_nomb)->first();
        if (!$estado) {
            return back()->with('error', 'Estado no válido.');
        }

        if (stripos($estado->estado_nomb, 'rechazado') !== false) {
            if (empty(trim($request->observaciones))) {
                return back()->with('error', 'Para rechazar un documento, es obligatorio redactar una observación explicando el motivo.');
            }
        }

        if ($estado->id_estado < $detalleAntiguo->id_estado_rec) {
            return back()->with('error', 'No está permitido regresar la correspondencia a un estado anterior.');
        }

        // Validación requiere_respuesta: No se puede archivar (10) o Resolver (9) si requiere respuesta y no hay archivo
        $requiereRespuesta = $detalleAntiguo->recibido?->tipo?->requiere_respuesta ?? 0;
        if ($requiereRespuesta == 1) {
            if ($estado->id_estado == 10) {
            return back()->with('error', 'Esta correspondencia requiere una respuesta obligatoria y no puede ser archivada sin ser resuelta.');
            }
            if ($estado->id_estado == 9) {
                if (!$request->hasFile('archivo_respuesta') && !$request->hasFile('archivos_respuesta')) {
                    return back()->with('error', 'Este tipo de documento requiere obligatoriamente adjuntar un archivo de respuesta para poder marcarlo como Resuelto/Finalizado.');
                }
            }
        }

        // Crear un NUEVO registro para la trazabilidad
        $nuevoRegistro = new DetalleRecibido();
        $nuevoRegistro->det_id_recibido = $detalleAntiguo->det_id_recibido;
        $nuevoRegistro->det_doc_empleado = $detalleAntiguo->det_doc_empleado;
        $nuevoRegistro->fecha_re = now();
        $nuevoRegistro->id_estado_rec = $estado->id_estado;
        $nuevoRegistro->observaciones = $request->observaciones;

        // No propagar el archivo de respuesta anterior
        if ($request->hasFile('archivo_respuesta')) {
            $nuevoRegistro->archivo_res = $request->file('archivo_respuesta')->store('correspondencia', 'public');
        } else {
            $nuevoRegistro->archivo_res = null;
        }

        // Propagar los folios de respuesta o actualizar
        $nuevoRegistro->folios_res = $request->filled('folios_respuesta') ? $request->folios_respuesta : ($detalleAntiguo->folios_res ?? 0);

        $nuevoRegistro->save();

        // Implementación de lógica: Si un empleado pone la correspondencia 'En Trámite' (8) o 'Resuelto' (9),
        // se le quita a los demás destinatarios de su bandeja de entrada (pasan a Archivado 10).
        if (in_array($estado->id_estado, [8, 9])) {
            $otrosDestinatarios = DetalleRecibido::where('det_id_recibido', $nuevoRegistro->det_id_recibido)
                ->where('det_doc_empleado', '!=', $user->emple_doc)
                ->whereIn('id_det_recibido', function ($query) use ($nuevoRegistro) {
                    $query->selectRaw('MAX(id_det_recibido)')
                        ->from('detalle_recibido')
                        ->where('det_id_recibido', $nuevoRegistro->det_id_recibido)
                        ->groupBy('det_doc_empleado');
                })
                ->where('id_estado_rec', 7) // Solo si aún está en estado 'Recibido'
                ->get();

            foreach ($otrosDestinatarios as $otro) {
                DetalleRecibido::create([
                    'det_id_recibido'  => $otro->det_id_recibido,
                    'det_doc_empleado' => $otro->det_doc_empleado,
                    'fecha_re'         => now(),
                    'id_estado_rec'    => 10, // Archivado
                    'observaciones'    => 'Tomado por: ' . $user->emple_nombres . ' ' . $user->emple_apellidos,
                    'visto'            => 1 // Marcado como visto para que desaparezca de notificaciones
                ]);
            }
        }

        // Evaluación absoluta del estado global para Recibido
        $recibido = $nuevoRegistro->recibido;
        if ($recibido) {
            $latestDetallesRec = DetalleRecibido::where('det_id_recibido', $recibido->id_recibido)
                ->whereIn('id_det_recibido', function ($query) use ($recibido) {
                    $query->selectRaw('MAX(id_det_recibido)')
                        ->from('detalle_recibido')
                        ->where('det_id_recibido', $recibido->id_recibido)
                        ->groupBy('det_doc_empleado');
                })->get();
            
            $todosFinalizados = true;
            $algunTramite = false;

            foreach ($latestDetallesRec as $det) {
                if (!in_array($det->id_estado_rec, [9, 10, 11])) {
                    $todosFinalizados = false;
                }
                if ($det->id_estado_rec == 8) {
                    $algunTramite = true;
                }
            }

            if ($todosFinalizados && $latestDetallesRec->count() > 0) {
                // If any rejection exists, keep it rejected or just finalized. Let's set to finalized (9) unless explicitly all rejected.
                // Usually reaching here means the document should be considered finalized.
                $rechazosCount = $latestDetallesRec->where('id_estado_rec', 11)->count();
                $recibido->id_estado_rec = ($rechazosCount > 0 && $rechazosCount == $latestDetallesRec->count()) ? 11 : 9;
            } elseif ($algunTramite) {
                $recibido->id_estado_rec = 8;
            }
            $recibido->save();

            // NOTIFICACIÓN POR CORREO AL REMITENTE (SI EXISTE CORREO)
            // Se envía si el estado es 'Resuelto' (ID 9)
            if ($nuevoRegistro->id_estado_rec == 9 && !empty($recibido->correo_persona)) {
                try {
                    Mail::to($recibido->correo_persona)
                        ->send(new RespuestaCorrespondenciaExterna($recibido, $nuevoRegistro));
                    Log::info("Email de notificación de respuesta enviado a: " . $recibido->correo_persona . " para Radicado: " . ($recibido->radicado->num_radicado ?? 'N/A'));
                } catch (\Exception $e) {
                    Log::error("Error enviando email de notificación de respuesta: " . $e->getMessage());
                }
            }
        }

        // Ya no iteramos sobre Anexos previos para evitar duplicados en la trazabilidad

        // Guardar nuevos anexos si se subieron usando id_detalle
        if ($request->hasFile('archivos_respuesta')) {
            foreach ($request->file('archivos_respuesta') as $file) {
                $pathAnexoResp = $file->store('correspondencia', 'public');
                \App\Models\AnexoRespuesta::create([
                    'id_detalle'      => $nuevoRegistro->id_det_recibido,
                    'ruta_archivo'    => $pathAnexoResp,
                    'nombre_original' => $file->getClientOriginalName()
                ]);
            }
        }

        return back()->with('success', 'Estado de correspondencia externa actualizado correctamente con trazabilidad.');
    }


    /**
     * ACTUALIZAR ESTADO (CORRESPONDENCIA INTERNA)
     * Realiza el mismo proceso que actualizarEstado pero para comunicados internos entre colaboradores.
     */
    public function actualizarEstadoInterna(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'estado_nomb' => 'required',
            'observaciones' => 'nullable|string',
            'archivo_respuesta' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB
            'archivos_respuesta.*' => 'nullable|file|mimes:pdf|max:25600', // Max 25MB
            'folios_respuesta' => 'nullable|integer'
        ]);

        $detalleAntiguo = DetalleEnvio::with('estado')->findOrFail($id);

        if (in_array($detalleAntiguo->id_estado_rec, [9, 10]) || stripos($detalleAntiguo->estado->estado_nomb, 'rechazado') !== false) {
            return back()->with('error', 'Esta correspondencia interna ya se encuentra finalizada, archivada o rechazada.');
        }

        // Prevent updating historical records via API manipulation
        // VERY IMPORTANT: Check the latest ID strictly for this recipient's thread 
        // because an internal document can be sent to multiple users at once.
        $latestDetalleId = DetalleEnvio::where('id_envio', $detalleAntiguo->id_envio)
            ->where('id_quien_recibe', $detalleAntiguo->id_quien_recibe)
            ->max('id_detalle');
        if ($detalleAntiguo->id_detalle != $latestDetalleId) {
            return back()->with('error', 'No se puede modificar un historial pasado. Solo el estado más reciente puede ser actualizado.');
        }

        // Find state ID
        $estado = \App\Models\Estado::where('estado_nomb', $request->estado_nomb)->first();
        if (!$estado)
            return back()->with('error', 'Estado no válido');

        if (stripos($estado->estado_nomb, 'rechazado') !== false) {
            if (empty(trim($request->observaciones))) {
                return back()->with('error', 'Para rechazar un documento interno, es obligatorio redactar una observación explicando el motivo.');
            }
        }

        // Prevent going backwards
        if ($estado->id_estado < $detalleAntiguo->id_estado_rec) {
            return back()->with('error', 'No está permitido regresar la correspondencia interna a un estado anterior.');
        }

        // Validación requiere_respuesta: No se puede archivar (10) o Resolver (9) si requiere respuesta y no hay archivo
        $requiereRespuestaInt = $detalleAntiguo->envio?->tipoEnvio?->requiere_respuesta ?? 0;
        if ($requiereRespuestaInt == 1) {
            if ($estado->id_estado == 10) {
            return back()->with('error', 'Esta correspondencia interna requiere una respuesta obligatoria y no puede ser archivada sin ser resuelta.');
            }
            if ($estado->id_estado == 9) {
                if (!$request->hasFile('archivo_respuesta') && !$request->hasFile('archivos_respuesta')) {
                    return back()->with('error', 'Esta correspondencia interna requiere obligatoriamente adjuntar un archivo de respuesta para poder marcarla como Resuelto/Finalizado.');
                }
            }
        }

        // Create new trace for internal
        $nuevoRegistro = new DetalleEnvio();
        $nuevoRegistro->id_quien_envie = $detalleAntiguo->id_quien_envie;
        $nuevoRegistro->id_quien_recibe = $detalleAntiguo->id_quien_recibe;
        $nuevoRegistro->id_envio = $detalleAntiguo->id_envio;
        $nuevoRegistro->fecha_traslado = now();
        $nuevoRegistro->id_estado_rec = $estado->id_estado;
        $nuevoRegistro->observaciones = $request->observaciones;
        $nuevoRegistro->folios_respuesta = $request->folios_respuesta ?? 0;

        // Si se subió un archivo de respuesta, guardarlo
        if ($request->hasFile('archivo_respuesta')) {
            $path = $request->file('archivo_respuesta')->store('correspondencia', 'public');
            $nuevoRegistro->archivo_respuesta = $path;
        } else {
            $nuevoRegistro->archivo_respuesta = null;
        }

        $nuevoRegistro->save();

        // Evaluar estado global del Envío Interno
        $envioObj = \App\Models\Envio::find($detalleAntiguo->id_envio);
        if ($envioObj) {
            $latestDetallesEnv = DetalleEnvio::where('id_envio', $envioObj->id_envio)
                ->whereIn('id_detalle', function ($query) use ($envioObj) {
                    $query->selectRaw('MAX(id_detalle)')
                          ->from('detalle_envio')
                          ->where('id_envio', $envioObj->id_envio)
                          ->groupBy('id_quien_recibe');
                })->get();
            
            $todosFinalizados = true;
            $algunTramite = false;

            foreach ($latestDetallesEnv as $det) {
                if (!in_array($det->id_estado_rec, [9, 10, 11])) {
                    $todosFinalizados = false;
                }
                if ($det->id_estado_rec == 8) {
                    $algunTramite = true;
                }
            }

            if ($todosFinalizados && $latestDetallesEnv->count() > 0) {
                $rechazosCount = $latestDetallesEnv->where('id_estado_rec', 11)->count();
                $envioObj->id_estado_envio = ($rechazosCount > 0 && $rechazosCount == $latestDetallesEnv->count()) ? 11 : 9;
            } elseif ($algunTramite) {
                $envioObj->id_estado_envio = 8;
            }
            $envioObj->save();
        }

        // Ya no duplicamos los Anexos antiguos para evitar repetición en el historial

        // Process new Anexos Respuesta Múltiples as part of the overall Envio thread (Usa id_det_interna)
        if ($request->hasFile('archivos_respuesta')) {
            foreach ($request->file('archivos_respuesta') as $file) {
                $pathAnexoResp = $file->store('correspondencia', 'public');
                \App\Models\AnexoRespuesta::create([
                    'id_det_interna' => $nuevoRegistro->id_detalle,
                    'ruta_archivo' => $pathAnexoResp,
                    'nombre_original' => $file->getClientOriginalName(),
                ]);
            }
        }

        return back()->with('success', 'Estado de correspondencia interna actualizado correctamente.');
    }

    /**
     * REASIGNAR CORRESPONDENCIA
     * Permite transferir un radicado a otro empleado para que este continúe con la gestión.
     */
    public function reasignar(Request $request, $id)
    {
        $request->validate([
            'doc_quien_dirige' => 'required|exists:empleado,emple_doc',
            'observaciones' => 'required|string'
        ]);

        $recibidoAntiguo = Recibido::with('estado')->findOrFail($id);

        if (in_array($recibidoAntiguo->id_estado_rec, [9, 10]) || stripos($recibidoAntiguo->estado->estado_nomb, 'rechazado') !== false) {
            return back()->with('error', 'No se puede reasignar una correspondencia que ya está finalizada, archivada o rechazada.');
        }

        // Prevent updating historical records via API manipulation
        if ($recibidoAntiguo->num_radicado_int) {
            $latestId = Recibido::where('num_radicado_int', $recibidoAntiguo->num_radicado_int)->max('id_recibido');
            if ($recibidoAntiguo->id_recibido != $latestId) {
                return back()->with('error', 'No se puede reasignar un historial pasado. Solo el estado más reciente puede ser reasignado.');
            }
        }

        // State for "Reasignado" might not exist explicitly in typical systems, 
        // but let's see if we should just mark it "En Tramite" for the new person.
        $estadoEnTramite = \App\Models\Estado::where('estado_nomb', 'En Tramite')->first();

        // 1. Mark current row as somewhat archived or just keep its trace. 
        // We will create the NEW row for the NEW employee.
        $nuevoRegistro = new Recibido();
        $nuevoRegistro->num_radicado_ext = $recibidoAntiguo->num_radicado_ext;
        $nuevoRegistro->num_radicado_int = $recibidoAntiguo->num_radicado_int;
        $nuevoRegistro->asunto = $recibidoAntiguo->asunto;
        $nuevoRegistro->fecha_hora_recib = now();
        $nuevoRegistro->nom_institucion = $recibidoAntiguo->nom_institucion;
        $nuevoRegistro->ciudad_proveniente = $recibidoAntiguo->ciudad_proveniente;
        $nuevoRegistro->folio = $recibidoAntiguo->folio;
        $nuevoRegistro->anexo = $recibidoAntiguo->anexo;
        $nuevoRegistro->observaciones = 'Reasignado: ' . $request->observaciones;
        $nuevoRegistro->doc_quien_registra = $recibidoAntiguo->doc_quien_registra;
        // ✨ This is the core of reassignment
        $nuevoRegistro->doc_quien_dirige = $request->doc_quien_dirige;
        $nuevoRegistro->id_tipo = $recibidoAntiguo->id_tipo;
        $nuevoRegistro->id_estado_rec = $estadoEnTramite ? $estadoEnTramite->id_estado : $recibidoAntiguo->id_estado_rec; // Reset to En Tramite
        $nuevoRegistro->archivo = $recibidoAntiguo->archivo;
        $nuevoRegistro->nit_empresa = $recibidoAntiguo->nit_empresa;
        $nuevoRegistro->save();

        // ✨ Insert the new recipient into the pivot table
        \App\Models\DetalleRecibido::create([
            'det_id_recibido' => $nuevoRegistro->id_recibido,
            'det_doc_empleado' => $request->doc_quien_dirige,
        ]);

        // Duplicate any Anexos for the new trace
        $anexosAntiguos = \App\Models\AnexoRecibido::where('id_recibido', $recibidoAntiguo->id_recibido)->get();
        foreach ($anexosAntiguos as $anexo) {
            \App\Models\AnexoRecibido::create([
                'id_recibido' => $nuevoRegistro->id_recibido,
                'ruta_archivo' => $anexo->ruta_archivo,
                'nombre_original' => $anexo->nombre_original,
            ]);
        }

        // Optional: Update the old row to indicate it was reassigned to remove it from the current user's active view
        // 10 = Archivado as a fallback to hide it, or we could leave it if the view query filters by latest.
        // For now, let's keep it simple. If we need to hide it, we can set it to "Archivado"
        $estadoArchivado = \App\Models\Estado::where('estado_nomb', 'Archivado')->first();
        return back()->with('success', 'Correspondencia reasignada correctamente al nuevo empleado.');
    }

    /**
     * CREAR NUEVA CORRESPONDENCIA INTERNA
     * Inicia un radicado de tipo interno (INT) dirigido a uno o varios colaboradores de la empresa.
     */
    public function nuevaInterna(Request $request)
    {
        try {
            $request->validate([
                'asunto' => 'required|string|max:100',
                'doc_quien_dirigido' => 'required|array|min:1',
                'doc_quien_dirigido.*' => 'exists:empleado,emple_doc',
                'id_tipo_envio' => 'required|exists:tipo,id_tipo',
                'nom_institucion' => 'nullable|string|max:200',
                'nombre_persona' => 'nullable|string|max:200',
                'correo_persona' => 'nullable|email|max:150',
                'observaciones' => 'nullable|string',
                'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
                'anexos.*' => 'nullable|file|mimes:pdf|max:25600', // Max 25MB
                'folio' => 'nullable|integer'
            ]);

            \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                $user = Auth::user();

                $estadoRecibido = \App\Models\Estado::where('estado_nomb', 'Recibido')->first();
                $estadoEnviado = \App\Models\Estado::where('estado_nomb', 'Enviado')->first();

                $estadoRecibidoId = $estadoRecibido ? $estadoRecibido->id_estado : 7; // Fallback
                $estadoEnviadoId = $estadoEnviado ? $estadoEnviado->id_estado : 7; // Fallback if not found

                $radicado = $this->generarRadicadoSeguro($user->nit_empresa, 'INT');

                $envio = new \App\Models\Envio();
                $envio->num_radicado_int = $radicado->id_radicado;
                $envio->asunto = $request->asunto;
                $envio->doc_quien_envia = $user->emple_doc;
                $envio->doc_quien_registra = null; // Internal, not a remitente
                $envio->fecha = now();
                $envio->folio = $request->folio ?? 0;
                $envio->id_tipo_envio = $request->id_tipo_envio;
                $envio->id_estado_envio = $estadoEnviadoId; // El que envía (remitente) inicia en 'Enviado'
                $envio->nit_empresa = $user->nit_empresa;
                $envio->destino = 'Interno';
                $envio->observaciones = $request->observaciones;

                if ($request->hasFile('archivo')) {
                    $path = $request->file('archivo')->store('correspondencia', 'public');
                    $envio->archivo = $path;
                }
                else {
                    $envio->archivo = '';
                }

                $envio->save();

                // Procesar los Anexos Múltiples
                if ($request->hasFile('anexos')) {
                    foreach ($request->file('anexos') as $file) {
                        $pathAnexo = $file->store('correspondencia', 'public');
                        \App\Models\AnexoEnvio::create([
                            'id_envio' => $envio->id_envio,
                            'ruta_archivo' => $pathAnexo,
                            'nombre_original' => $file->getClientOriginalName(),
                        ]);
                    }
                }

                // T8a: Bloquear auto-envío
                foreach ($request->doc_quien_dirigido as $dest) {
                    if ($dest == $user->emple_doc) {
                        throw new \Exception('No puede enviarse correspondencia a usted mismo.');
                    }
                }

                // T8b: Bloquear envio a Super Admin (rol=1)
                $destinatariosValidos = \App\Models\Empleado::whereIn('emple_doc', $request->doc_quien_dirigido)
                    ->where('emple_rol', '!=', 1)
                    ->pluck('emple_doc')->toArray();

                // Create DetalleEnvio (Receiver tracking) for each recipient
                foreach ($destinatariosValidos as $destinatario_doc) {
                    $detalle = new \App\Models\DetalleEnvio();
                    $detalle->id_quien_envie = $user->emple_doc;
                    $detalle->id_quien_recibe = $destinatario_doc;
                    $detalle->id_envio = $envio->id_envio;
                    $detalle->fecha_traslado = now();
                    $detalle->id_estado_rec = $estadoRecibidoId; // El que recibe (destinatario) inicia en 'Recibido'
                    $detalle->observaciones = $request->observaciones;
                    $detalle->save();
                }
            });

            return back()->with('success', 'Correspondencia interna creada y enviada exitosamente.');

        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();

        }
        catch (\Exception $e) {
            Log::error('Error guardando correspondencia interna: ' . $e->getMessage());
            return back()->with('error', 'Error interno al guardar: ' . $e->getMessage())->withInput();
        }
    }
    /**
     * CREAR ENVÍO A VENTANILLA
     * Registra un radicado de salida (SAL) dirigido a los usuarios de Ventanilla/Remitente para despacho físico.
     */
    public function nuevaVentanilla(Request $request)
    {
        try {
            $request->validate([
                'asunto' => 'required|string|max:100',
                'doc_quien_dirigido' => 'required|exists:remitente,rem_doc',
                'id_tipo_envio' => 'required|exists:tipo,id_tipo',
                'nom_institucion' => 'nullable|string|max:200',
                'nombre_persona' => 'nullable|string|max:200',
                'correo_persona' => 'nullable|email|max:150',
                'observaciones' => 'nullable|string',
                'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
                'anexos.*' => 'nullable|file|mimes:pdf|max:25600', // Max 25MB
                'folio' => 'nullable|integer'
            ]);

            \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                $user = Auth::user();

                $idTipo = $request->id_tipo_envio;
                $asuntoFinal = $request->asunto;

                if ($idTipo === 'OTRO') {
                    $asuntoFinal = "[TIPO: " . strtoupper($request->tipo_otro) . "] " . $asuntoFinal;
                    $tipoDefault = \App\Models\Tipo::first();
                    $idTipo = $tipoDefault ? $tipoDefault->id_tipo : null;
                }
                $estadoEnviadoId = 0; // 0 = En espera

                $radicado = $this->generarRadicadoSeguro($user->nit_empresa, 'SAL');

                $envio = new \App\Models\Envio();
                $envio->num_radicado_int = $radicado->id_radicado;
                $envio->asunto = $asuntoFinal;
                $envio->doc_quien_envia = $user->emple_doc;
                $envio->doc_quien_registra = $request->doc_quien_dirigido; // Directed to Remitente
                $envio->fecha = now();
                $envio->folio = $request->folio ?? 0;
                $envio->id_tipo_envio = $idTipo;
                $envio->id_estado_envio = $estadoEnviadoId;
                $envio->nit_empresa = $user->nit_empresa;
                $envio->destino = 'Ventanilla';
                $envio->nom_institucion = $request->nom_institucion;
                $envio->nombre_persona = $request->nombre_persona;
                $envio->correo_persona = $request->correo_persona;
                $envio->observaciones = $request->observaciones;

                if ($request->hasFile('archivo')) {
                    $path = $request->file('archivo')->store('correspondencia', 'public');
                    $envio->archivo = $path;
                } else {
                    $envio->archivo = '';
                }

                $envio->save();

                // Process Multiple Annexes
                if ($request->hasFile('anexos')) {
                    foreach ($request->file('anexos') as $file) {
                        $pathAnexo = $file->store('correspondencia', 'public');
                        \App\Models\AnexoEnvio::create([
                            'id_envio' => $envio->id_envio,
                            'ruta_archivo' => $pathAnexo,
                            'nombre_original' => $file->getClientOriginalName(),
                        ]);
                    }
                }
            });

            return back()->with('success', 'Correspondencia a Ventanilla creada exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error guardando correspondencia a Ventanilla: ' . $e->getMessage());
            return back()->with('error', 'Error interno al guardar: ' . $e->getMessage())->withInput();
        }
    }

    // Historial Interna Normalizado
    public function historialInterna($id)
    {
        $detalle = \App\Models\DetalleEnvio::with(['envio.radicado', 'envio.tipoEnvio', 'envio.anexos', 'quienEnvia.area', 'quienRecibe.area'])
            ->findOrFail($id);
        $radId = $detalle->envio->num_radicado_int;

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
            $timeline->push((object)[
                'tipo' => 'Entrada',
                'fecha' => $rec->created_at ?? $rec->fecha_hora_recib,
                'titulo' => 'Ingreso a Ventanilla',
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

                $timeline->push((object)[
                    'tipo' => 'Entrada',
                    'fecha' => $det->fecha_re,
                    'titulo' => $det->estado->estado_nomb ?? 'Gestión',
                    'responsable' => "$nombre $apellido",
                    'area' => $area,
                    'detalle' => $det->observaciones,
                    'icon' => 'pending_actions',
                    'color' => 'bg-blue-400',
                    'original' => $det,
                    'is_main' => false
                ]);
            }
        }

        // 2. Process Envios
        foreach ($envios as $e) {
            $timeline->push((object)[
                'tipo' => 'Salida',
                'fecha' => $e->created_at ?? $e->fecha,
                'titulo' => 'Radicado Saliente Generado',
                'responsable' => ($e->quienEnvia->emple_nombres ?? 'Ventanilla') . ' ' . ($e->quienEnvia->emple_apellidos ?? ''),
                'area' => $e->quienEnvia->area->area_nom ?? 'Oficina',
                'detalle' => '(Documento de Respuesta/Envío) ' . $e->asunto,
                'icon' => 'outgoing_mail',
                'color' => 'bg-amber-600',
                'original' => $e,
                'is_main' => true
            ]);

            foreach ($e->detalles as $det) {
                $timeline->push((object)[
                    'tipo' => 'Salida',
                    'fecha' => $det->fecha_traslado,
                    'titulo' => $det->estado->estado_nomb ?? 'Gestión Interna',
                    'responsable' => ($det->quienRecibe->emple_nombres ?? 'N/A') . ' ' . ($det->quienRecibe->emple_apellidos ?? ''),
                    'area' => $det->quienRecibe->area->area_nom ?? 'Sin Área',
                    'detalle' => $det->observaciones,
                    'icon' => 'move_to_inbox',
                    'color' => 'bg-amber-400',
                    'original' => $det,
                    'is_main' => false
                ]);
            }
        }

        $trazabilidad = $timeline->sortBy('fecha');
        $destinatarios = $trazabilidad->groupBy('responsable');
        $empleados = \App\Models\Empleado::where('nit_empresa', Auth::user()->nit_empresa)->where('emple_doc', '!=', Auth::user()->emple_doc)->with('area')->get();

        return view('empleado.historial_interna', compact('detalle', 'trazabilidad', 'destinatarios', 'empleados'));
    }

    public function historialExterna($id)
    {
        $detalle = \App\Models\DetalleRecibido::with(['recibido.radicado', 'recibido.tipo.prioridad', 'recibido.anexos', 'recibido.ciudad', 'empleado.area', 'estado'])
            ->findOrFail($id);
        $radId = $detalle->recibido->num_radicado_int;

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
            $timeline->push((object)[
                'tipo' => 'Entrada',
                'fecha' => $rec->created_at ?? $rec->fecha_hora_recib,
                'titulo' => 'Ingreso a Ventanilla',
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

                $timeline->push((object)[
                    'tipo' => 'Entrada',
                    'fecha' => $det->fecha_re,
                    'titulo' => $det->estado->estado_nomb ?? 'Gestión',
                    'responsable' => "$nombre $apellido",
                    'area' => $area,
                    'detalle' => $det->observaciones,
                    'icon' => 'pending_actions',
                    'color' => 'bg-blue-400',
                    'original' => $det,
                    'is_main' => false
                ]);
            }
        }

        // 2. Process Envios
        foreach ($envios as $e) {
            $timeline->push((object)[
                'tipo' => 'Salida',
                'fecha' => $e->created_at ?? $e->fecha,
                'titulo' => 'Radicado Saliente Generado',
                'responsable' => ($e->quienEnvia->emple_nombres ?? 'Ventanilla') . ' ' . ($e->quienEnvia->emple_apellidos ?? ''),
                'area' => $e->quienEnvia->area->area_nom ?? 'Oficina',
                'detalle' => '(Documento de Respuesta/Envío) ' . $e->asunto,
                'icon' => 'outgoing_mail',
                'color' => 'bg-amber-600',
                'original' => $e,
                'is_main' => true
            ]);

            foreach ($e->detalles as $det) {
                $timeline->push((object)[
                    'tipo' => 'Salida',
                    'fecha' => $det->fecha_traslado,
                    'titulo' => $det->estado->estado_nomb ?? 'Gestión Interna',
                    'responsable' => ($det->quienRecibe->emple_nombres ?? 'N/A') . ' ' . ($det->quienRecibe->emple_apellidos ?? ''),
                    'area' => $det->quienRecibe->area->area_nom ?? 'Sin Área',
                    'detalle' => $det->observaciones,
                    'icon' => 'move_to_inbox',
                    'color' => 'bg-amber-400',
                    'original' => $det,
                    'is_main' => false
                ]);
            }
        }

        $trazabilidad = $timeline->sortBy('fecha');
        $destinatarios = $trazabilidad->groupBy('responsable');
        $empleados = \App\Models\Empleado::where('nit_empresa', Auth::user()->nit_empresa)->where('emple_doc', '!=', Auth::user()->emple_doc)->with('area')->get();

        return view('empleado.historial_externa', compact('detalle', 'trazabilidad', 'destinatarios', 'empleados'));
    }

    public function enviosInternos()
    {
        $user = Auth::user();

        // Obtener los documentos enviados por el usuario (un registro por radicado)
        $envios = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'quienDirigido'])
            ->where('doc_quien_envia', $user->emple_doc)
            ->where('nit_empresa', $user->nit_empresa)
            ->orderBy('id_envio', 'desc')
            ->paginate(15);

        // Para cada envío, cargamos la relación de quiénes lo recibieron y su estado actual
        foreach ($envios as $envio) {
            if ($envio->destino === 'Ventanilla') {
                // Para Ventanilla no hay detalle_envio, simulamos el destinatario actual
                $envio->destinatarios_actuales = collect();
                if ($envio->quienDirigido) {
                    $mock = new \stdClass();
                    $mock->quienRecibe = new \stdClass();
                    $mock->quienRecibe->emple_nombres = $envio->quienDirigido->rem_nombres;
                    $mock->quienRecibe->emple_apellidos = $envio->quienDirigido->rem_apellidos;
                    $mock->quienRecibe->area = new \stdClass();
                    $mock->quienRecibe->area->area_nom = 'Ventanilla / Remitente';
                    $mock->estado = new \stdClass();
                    $mock->estado->estado_nomb = $envio->estadoEnvio->estado_nombre ?? 'Enviado';
                    $mock->id_detalle = 0; // Para el link de seguimiento (aunque para ventanilla será limitado)
                    $envio->destinatarios_actuales->push($mock);
                }
            } else {
                $envio->destinatarios_actuales = \App\Models\DetalleEnvio::with(['quienRecibe.area', 'estado'])
                    ->where('id_envio', $envio->id_envio)
                    ->whereIn('id_detalle', function($query) use ($envio) {
                        $query->select(\Illuminate\Support\Facades\DB::raw('MAX(id_detalle)'))
                            ->from('detalle_envio')
                            ->where('id_envio', $envio->id_envio)
                            ->groupBy('id_quien_recibe');
                    })
                    ->get();
            }
        }

        return view('empleado.envios_internos', compact('envios'));
    }

    public function gestionarRechazoInterno(Request $request)
    {
        $request->validate([
            'ids_detalle' => 'nullable|array',
            'ids_detalle.*' => 'exists:detalle_envio,id_detalle',
            'id_detalle' => 'nullable|exists:detalle_envio,id_detalle',
            'accion' => 'required|in:finalizar,reenviar,reasignar',
            'ids_nuevos_destinatarios' => 'nullable|required_if:accion,reasignar|array',
            'ids_nuevos_destinatarios.*' => 'exists:empleado,emple_doc',
            'observaciones' => 'nullable|string',
            'archivo_nuevo' => 'nullable|file|mimes:pdf|max:5120',
            'anexos_nuevos.*' => 'nullable|file|mimes:pdf|max:25600',
            'folios_nuevos' => 'nullable|integer',
        ]);

        $ids_detalle = [];
        if ($request->has('ids_detalle') && is_array($request->ids_detalle)) {
            $ids_detalle = $request->ids_detalle;
        } elseif ($request->has('id_detalle')) {
            $ids_detalle = [$request->id_detalle];
        }

        if (empty($ids_detalle)) {
            return back()->with('error', 'No se ha seleccionado ningún rechazo para gestionar.');
        }

        $user = Auth::user();
        $archivosAnexosGuardados = [];
        $archivoPrincipalPath = null;
        
        // Guardar el archivo principal una sola vez si aplica a todos (solo se usa en 'reenviar')
        if ($request->hasFile('archivo_nuevo') && $request->accion === 'reenviar') {
            $archivoPrincipalPath = $request->file('archivo_nuevo')->store('correspondencia', 'public');
        }

        if ($request->hasFile('anexos_nuevos') && $request->accion === 'reenviar') {
            foreach ($request->file('anexos_nuevos') as $file) {
                $pathAnexo = $file->store('correspondencia', 'public');
                $archivosAnexosGuardados[] = [
                    'path' => $pathAnexo,
                    'name' => $file->getClientOriginalName()
                ];
            }
        }

        $enviosProcesadosReasignacion = [];

        foreach ($ids_detalle as $id_det) {
            $detalle = \App\Models\DetalleEnvio::with('envio')->findOrFail($id_det);
            
            // Verificar que el usuario es el remitente original
            if ($detalle->envio->doc_quien_envia != $user->emple_doc) {
                continue;
            }

            $envio = $detalle->envio;

            if ($request->accion === 'finalizar') {
                $nuevo = new \App\Models\DetalleEnvio();
                $nuevo->id_quien_envie = $user->emple_doc;
                $nuevo->id_quien_recibe = $detalle->id_quien_recibe;
                $nuevo->id_envio = $envio->id_envio;
                $nuevo->fecha_traslado = now();
                $nuevo->id_estado_rec = 9; // Resuelto/Finalizado
                $nuevo->observaciones = 'Rechazo aceptado: ' . $request->observaciones;
                $nuevo->save();

            } elseif ($request->accion === 'reenviar') {
                $nuevo = new \App\Models\DetalleEnvio();
                $nuevo->id_quien_envie = $user->emple_doc;
                $nuevo->id_quien_recibe = $detalle->id_quien_recibe;
                $nuevo->id_envio = $envio->id_envio;
                $nuevo->fecha_traslado = now();
                $nuevo->id_estado_rec = 7; // Recibido
                $nuevo->observaciones = 'Reenviado tras corrección: ' . $request->observaciones;

                if ($archivoPrincipalPath) {
                    $nuevo->archivo_respuesta = $archivoPrincipalPath;
                }

                if ($request->filled('folios_nuevos')) {
                    $nuevo->folios_respuesta = $request->folios_nuevos;
                }

                $nuevo->save();

                foreach ($archivosAnexosGuardados as $anexoGuardado) {
                    \App\Models\AnexoRespuesta::create([
                        'id_det_interna' => $nuevo->id_detalle,
                        'ruta_archivo' => $anexoGuardado['path'],
                        'nombre_original' => $anexoGuardado['name'],
                    ]);
                }

            } elseif ($request->accion === 'reasignar') {
                $cierreRechazo = new \App\Models\DetalleEnvio();
                $cierreRechazo->id_quien_envie = $user->emple_doc;
                $cierreRechazo->id_quien_recibe = $detalle->id_quien_recibe;
                $cierreRechazo->id_envio = $envio->id_envio;
                $cierreRechazo->fecha_traslado = now();
                $cierreRechazo->id_estado_rec = 9; // Resuelto
                $cierreRechazo->observaciones = 'Trámite reasignado a ' . count($request->ids_nuevos_destinatarios) . ' nuevo(s) colaborador(es).';
                $cierreRechazo->save();

                if (!in_array($envio->id_envio, $enviosProcesadosReasignacion)) {
                    foreach ($request->ids_nuevos_destinatarios as $nuevoId) {
                        $nuevo = new \App\Models\DetalleEnvio();
                        $nuevo->id_quien_envie = $user->emple_doc;
                        $nuevo->id_quien_recibe = $nuevoId;
                        $nuevo->id_envio = $envio->id_envio;
                        $nuevo->fecha_traslado = now();
                        $nuevo->id_estado_rec = 7; // Recibido
                        $nuevo->observaciones = 'Reasignado tras rechazo original: ' . $request->observaciones;
                        $nuevo->save();
                    }
                    $enviosProcesadosReasignacion[] = $envio->id_envio;
                }
            }
        }

        if (count($ids_detalle) > 1) {
            $mensaje = 'Rechazos gestionados correctamente (' . count($ids_detalle) . ' destinatarios).';
        } else {
            $mensaje = 'Rechazo gestionado correctamente.';
        }

        return back()->with('success', $mensaje);
    }

    private function generarRadicadoSeguro($nitEmpresa, $prefijo)
    {
        $currentYear = date('Y');
        $latestRadicado = \App\Models\Radicado::where('nit_empresa', $nitEmpresa)
            ->where('num_radicado', 'like', $prefijo . '-' . $currentYear . '-%')
            ->orderBy('num_radicado', 'desc')
            ->lockForUpdate() // BLOQUEO PARA EVITAR DUPLICADOS
            ->first();

        $newNumber = $latestRadicado ? intval(substr($latestRadicado->num_radicado, -5)) + 1 : 1;

        $radicado = new \App\Models\Radicado();
        $radicado->num_radicado = $prefijo . '-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        $radicado->nit_empresa = $nitEmpresa;
        $radicado->save();

        return $radicado;
    }

    public function historialPersonal()
    {
        $doc = \Illuminate\Support\Facades\Auth::user()->emple_doc;
        
        $recibidos = \App\Models\Recibido::with(['estado','tipo','radicado','destinatarios'])
            ->whereHas('detalles', function($q) use ($doc) {
                $q->where('det_doc_empleado', $doc);
            })->get()->map(function($r) {
                $r->tipo_corresp = 'Externa';
                $r->fecha_relevante = $r->fecha_hora_recib;
                return $r;
            });

        $envios = \App\Models\Envio::with(['estado','tipoEnvio','radicado','recibidoPor'])
            ->whereHas('detalles', function($q) use ($doc) {
                $q->where('id_quien_recibe', $doc)->orWhere('id_quien_envia', $doc);
            })->get()->map(function($e) {
                $e->tipo_corresp = 'Interna/Saliente';
                $e->fecha_relevante = $e->fecha;
                return $e;
            });

        $correspondencia = $recibidos->concat($envios)->sortByDesc('fecha_relevante');

        return view('empleado.historial_personal', compact('correspondencia'));
    }

    public function getHistory($id, Request $request)
    {
        try {
            $modulo = $request->query('modulo');
            $radId = null;

            // Priority 0: If modulo is specified, try that path specifically first
            if ($modulo === 'interna' || $modulo === 'saliente' || $modulo === 'envio') {
                $radId = DB::table('envio')->where('id_envio', $id)->value('num_radicado_int');
            } elseif ($modulo === 'externa' || $modulo === 'recibida') {
                $radId = DB::table('recibido')->where('id_recibido', $id)->value('num_radicado_int');
            }

            // Priority 1: Check if the ID is already a Radicado ID if not found yet
            if (!$radId) {
                $isRadicado = DB::table('radicados')->where('id_radicado', $id)->exists();
                if ($isRadicado) {
                    $radId = $id;
                }
            }

            // Priority 2: Traditional ID lookup (Recibido or Envio)
            if (!$radId) {
                $radId = DB::table('recibido')->where('id_recibido', $id)->value('num_radicado_int');
                if (!$radId) {
                    $radId = DB::table('envio')->where('id_envio', $id)->value('num_radicado_int');
                }
            }
            
            // Priority 3: Lookup from Details IDs (Common in employee module)
            if (!$radId) {
                $recId = DB::table('detalle_recibido')->where('id_det_recibido', $id)->value('det_id_recibido');
                if ($recId) {
                    $radId = DB::table('recibido')->where('id_recibido', $recId)->value('num_radicado_int');
                }
            }
            if (!$radId) {
                $envId = DB::table('detalle_envio')->where('id_detalle', $id)->value('id_envio');
                if ($envId) {
                    $radId = DB::table('envio')->where('id_envio', $envId)->value('num_radicado_int');
                }
            }

            if (!$radId) return response()->json([]);

            // 1. Initial Registrations (Incoming)
            $recibidos = DB::table('recibido as r')
                ->join('radicados as rad', 'r.num_radicado_int', '=', 'rad.id_radicado')
                ->leftJoin('remitente as rem', 'r.doc_quien_registra', '=', 'rem.rem_doc')
                ->where('r.num_radicado_int', $radId)
                ->select(
                    DB::raw("'registry' as type"),
                    'r.fecha_hora_recib as fecha',
                    DB::raw("COALESCE(rem.rem_nombres, 'Sistema') as nombres"),
                    DB::raw("COALESCE(rem.rem_apellidos, 'Ventanilla') as apellidos"),
                    'rad.num_radicado',
                    DB::raw("'Ingreso a Ventanilla' as estado_nomb"),
                    'r.asunto as observaciones',
                    DB::raw("NULL as img")
                )->get();

            // 2. Registrations (Outgoing)
            $envios = DB::table('envio as env')
                ->join('radicados as rad', 'env.num_radicado_int', '=', 'rad.id_radicado')
                ->leftJoin('remitente as rem', 'env.doc_quien_registra', '=', 'rem.rem_doc')
                ->leftJoin('empleado as emp_env', 'env.doc_quien_envia', '=', 'emp_env.emple_doc')
                ->where('env.num_radicado_int', $radId)
                ->select(
                    DB::raw("'registry' as type"),
                    'env.fecha as fecha',
                    DB::raw("COALESCE(rem.rem_nombres, 'Sistema') as nombres"),
                    DB::raw("COALESCE(rem.rem_apellidos, 'Oficial') as apellidos"),
                    'rad.num_radicado',
                    DB::raw("'Registro de Salida/Respuesta' as estado_nomb"),
                    DB::raw("CONCAT('Origen: ', COALESCE(emp_env.emple_nombres, 'N/A'), ' ', COALESCE(emp_env.emple_apellidos, ''), ' | Asunto: ', env.asunto) as observaciones"),
                    DB::raw("NULL as img")
                )->get();

            // 3. Lifecycle transitions (Details)
            $detailsRec = DB::table('detalle_recibido as dr')
                ->join('recibido as r', 'dr.det_id_recibido', '=', 'r.id_recibido')
                ->leftJoin('estado as e', 'dr.id_estado_rec', '=', 'e.id_estado')
                ->leftJoin('empleado as emp', 'dr.det_doc_empleado', '=', 'emp.emple_doc')
                ->leftJoin('area as area_e', 'emp.emple_area', '=', 'area_e.id_area')
                ->leftJoin('remitente as rem_det', 'dr.det_doc_empleado', '=', 'rem_det.rem_doc')
                ->where('r.num_radicado_int', $radId)
                ->select(
                    DB::raw("'detail' as type"),
                    'dr.fecha_re as fecha',
                    DB::raw("CASE WHEN dr.observaciones LIKE '%(Remitente)%' THEN COALESCE(rem_det.rem_nombres, 'Ventanilla') ELSE COALESCE(emp.emple_nombres, 'Funcionario') END as nombres"),
                    DB::raw("CASE WHEN dr.observaciones LIKE '%(Remitente)%' THEN COALESCE(rem_det.rem_apellidos, '') ELSE COALESCE(emp.emple_apellidos, '') END as apellidos"),
                    DB::raw("NULL as num_radicado"),
                    DB::raw("COALESCE(e.estado_nomb, 'Gestión') as estado_nomb"),
                    'dr.observaciones',
                    'area_e.area_nom as area_e',
                    'emp.emple_img as img',
                    'dr.id_estado_rec',
                    'dr.id_det_recibido',
                    DB::raw("dr.archivo_res as archivo_res")
                )->get();

            $detailsEnv = DB::table('detalle_envio as de')
                ->join('envio as env', 'de.id_envio', '=', 'env.id_envio')
                ->leftJoin('estado as e', 'de.id_estado_rec', '=', 'e.id_estado')
                ->leftJoin('empleado as emp', 'de.id_quien_recibe', '=', 'emp.emple_doc')
                ->leftJoin('area as area_e', 'emp.emple_area', '=', 'area_e.id_area')
                ->leftJoin('remitente as rem_det', 'de.id_quien_recibe', '=', 'rem_det.rem_doc')
                ->where('env.num_radicado_int', $radId)
                ->select(
                    DB::raw("'detail' as type"),
                    'de.fecha_traslado as fecha',
                    DB::raw("CASE WHEN de.observaciones LIKE '%(Remitente)%' THEN COALESCE(rem_det.rem_nombres, 'Ventanilla') ELSE COALESCE(emp.emple_nombres, 'Funcionario') END as nombres"),
                    DB::raw("CASE WHEN de.observaciones LIKE '%(Remitente)%' THEN COALESCE(rem_det.rem_apellidos, '') ELSE COALESCE(emp.emple_apellidos, '') END as apellidos"),
                    DB::raw("NULL as num_radicado"),
                    DB::raw("COALESCE(e.estado_nomb, 'Saliente') as estado_nomb"),
                    'de.observaciones',
                    'area_e.area_nom as area_e',
                    'emp.emple_img as img',
                    'de.id_estado_rec',
                    DB::raw("de.id_detalle as id_det_recibido"),
                    DB::raw("NULL as archivo_res")
                )->get();

            // Final Merge
            $historyCollection = $recibidos
                ->concat($envios)
                ->concat($detailsRec)
                ->concat($detailsEnv)
                ->sortBy('fecha');

            $finalHistory = [];
            foreach ($historyCollection as $h) {
                $item = (array) $h;
                
                // Add anexos if possible
                if (!empty($item['id_det_recibido'])) {
                    $item['anexos'] = DB::table('anexo_respuesta')
                        ->where('id_detalle', $item['id_det_recibido'])
                        ->orWhere('id_det_interna', $item['id_det_recibido'])
                        ->select('ruta_archivo', 'nombre_original')
                        ->get();
                } else {
                    $item['anexos'] = [];
                }
                $finalHistory[] = $item;
            }

            // Check if consolidated radicado is resolved
            $isResuelto = false;
            
            // Check states in 'recibido' table
            $recState = DB::table('recibido')->where('num_radicado_int', $radId)->value('id_estado_rec');
            if ($recState && in_array($recState, [9, 10, 11])) {
                $isResuelto = true;
            }
            
            // Check states in 'envio' table if not already resolved
            if (!$isResuelto) {
                $envState = DB::table('envio')->where('num_radicado_int', $radId)->value('id_estado_envio');
                if ($envState && in_array($envState, [9, 10, 11])) {
                    $isResuelto = true;
                }
            }

            $numRadicado = DB::table('radicados')->where('id_radicado', $radId)->value('num_radicado');

            return response()->json([
                'history' => $finalHistory,
                'is_resuelto' => $isResuelto,
                'num_radicado' => $numRadicado ?? 'N/A'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getHistoryEnvio($id, Request $request)
    {
        return $this->getHistory($id, $request);
    }

}

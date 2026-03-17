<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recibido;
use App\Models\DetalleEnvio;
use App\Models\DetalleRecibido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CorrespondenciaController extends Controller
{
    public function recibida()
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

        // Solo mostramos los que el empleado aún tiene activos (Recibido=7, En Tramite=8)
        $correspondencias = (clone $queryBandejaUnicaExt)
            ->whereIn('detalle_recibido.id_estado_rec', [7, 8])
            ->with(['recibido.radicado', 'recibido.tipo.prioridad', 'recibido.ciudad', 'recibido.anexos', 'estado', 'anexosRespuesta', 'recibido.destinatarios'])
            ->leftJoin('recibido', 'detalle_recibido.det_id_recibido', '=', 'recibido.id_recibido')
            ->leftJoin('tipo', 'recibido.id_tipo', '=', 'tipo.id_tipo')
            ->leftJoin('prioridad', 'tipo.id_prioridad', '=', 'prioridad.id_prioridad')
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
        $vencidasInt = 0; // Same, placeholder for overdue.

        // Custom Sorting for Internas
        $correspondenciasInternas = clone $queryBandejaUnicaInt;
        $correspondenciasInternas = $correspondenciasInternas
            ->whereIn('detalle_envio.id_estado_rec', [7, 8])
            ->with(['envio', 'envio.tipoEnvio.prioridad', 'envio.radicado', 'quienEnvia', 'quienEnvia.area', 'estado', 'anexosRespuesta', 'envio.recipients'])
            ->leftJoin('envio', 'detalle_envio.id_envio', '=', 'envio.id_envio')
            ->leftJoin('tipo', 'envio.id_tipo_envio', '=', 'tipo.id_tipo')
            ->leftJoin('prioridad', 'tipo.id_prioridad', '=', 'prioridad.id_prioridad')
            ->select('detalle_envio.*') // Prevent column overlap
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

        // Fetch all active employees for the reassignment modal
        $empleados = \App\Models\Empleado::where('emple_estado', 1)
            ->where('nit_empresa', $user->nit_empresa)
            ->get();

        // Fetch document types
        $tipos = \App\Models\Tipo::all();

        // Fetch remitentes of the same company (Ventanilla users)
        $remitentes = \App\Models\Remitente::where('nit_empresa', $user->nit_empresa)->get();

        return view('empleado.correspondencia_recibida', compact(
            'correspondencias', 'totalRecibidas', 'enTramite', 'finalizadas', 'archivadas', 'vencidas',
            'correspondenciasInternas', 'totalInternas', 'enTramiteInt', 'finalizadasInt', 'archivadasInt', 'vencidasInt',
            'empleados', 'tipos', 'remitentes'
        ));
    }

    public function finalizada()
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
        $queryBandejaUnicaExtFin = DetalleRecibido::whereIn('id_det_recibido', $latestExtFinSubquery)
            ->where('det_doc_empleado', $user->emple_doc);

        $correspondencias = (clone $queryBandejaUnicaExtFin)
            ->whereIn('detalle_recibido.id_estado_rec', [9, 10, 11])
            ->with(['recibido.radicado', 'recibido.tipo.prioridad', 'recibido.ciudad', 'recibido.anexos', 'estado', 'anexosRespuesta', 'recibido.destinatarios'])
            ->leftJoin('recibido', 'detalle_recibido.det_id_recibido', '=', 'recibido.id_recibido')
            ->leftJoin('tipo', 'recibido.id_tipo', '=', 'tipo.id_tipo')
            ->leftJoin('prioridad', 'tipo.id_prioridad', '=', 'prioridad.id_prioridad')
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

        $correspondenciasInternas = clone $queryBandejaUnicaInt;
        $correspondenciasInternas = $correspondenciasInternas
            ->where('detalle_envio.id_estado_rec', '>', 8)
            ->with(['envio', 'envio.tipoEnvio.prioridad', 'envio.radicado', 'quienEnvia', 'quienEnvia.area', 'estado', 'anexosRespuesta', 'envio.recipients'])
            ->leftJoin('envio', 'detalle_envio.id_envio', '=', 'envio.id_envio')
            ->leftJoin('tipo', 'envio.id_tipo_envio', '=', 'tipo.id_tipo')
            ->leftJoin('prioridad', 'tipo.id_prioridad', '=', 'prioridad.id_prioridad')
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

        if ($estado->id_estado < $detalleAntiguo->id_estado_rec) {
            return back()->with('error', 'No está permitido regresar la correspondencia a un estado anterior.');
        }

        // Crear un NUEVO registro para la trazabilidad
        $nuevoRegistro = new DetalleRecibido();
        $nuevoRegistro->det_id_recibido = $detalleAntiguo->det_id_recibido;
        $nuevoRegistro->det_doc_empleado = $detalleAntiguo->det_doc_empleado;
        $nuevoRegistro->fecha_re = now();
        $nuevoRegistro->id_estado_rec = $estado->id_estado;
        $nuevoRegistro->observaciones = $request->observaciones;

        // Propagar el archivo de respuesta anterior si no se sube uno nuevo
        $nuevoRegistro->archivo_res = $detalleAntiguo->archivo_res;
        if ($request->hasFile('archivo_respuesta')) {
            $nuevoRegistro->archivo_res = $request->file('archivo_respuesta')->store('correspondencia', 'public');
        }

        // Propagar los folios de respuesta o actualizar
        $nuevoRegistro->folios_res = $request->filled('folios_respuesta') ? $request->folios_respuesta : ($detalleAntiguo->folios_res ?? 0);

        $nuevoRegistro->save();

        // Implementación de lógica: Si un empleado pone la correspondencia 'En Trámite' (8) o 'Resuelto' (9),
        // se le quita a los demás destinatarios de su bandeja de entrada (pasan a Archivado 10).
        // NOTA: Se eliminó 'Rechazado' (11) de esta lista para que el rechazo sea individual.
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
                    'observaciones'    => ($estado->id_estado == 11 ? 'Rechazado por: ' : 'Tomado por: ') . $user->emple_nombres . ' ' . $user->emple_apellidos,
                    'visto'            => 1 // Marcado como visto para que desaparezca de notificaciones
                ]);
            }

            // Actualizar el estado global del documento Recibido
            $recibido = $nuevoRegistro->recibido;
            if ($recibido && $recibido->id_estado_rec != $estado->id_estado) {
                $recibido->id_estado_rec = $estado->id_estado;
                $recibido->save();
            }
        }

        // Duplicar los Anexos de Respuesta previos para el nuevo registro usando id_detalle
        $anexosPrevios = \App\Models\AnexoRespuesta::where('id_detalle', $detalleAntiguo->id_det_recibido)->get();
        foreach ($anexosPrevios as $anexo) {
            \App\Models\AnexoRespuesta::create([
                'id_detalle'      => $nuevoRegistro->id_det_recibido,
                'ruta_archivo'    => $anexo->ruta_archivo,
                'nombre_original' => $anexo->nombre_original
            ]);
        }

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

        // Prevent going backwards
        if ($estado->id_estado < $detalleAntiguo->id_estado_rec) {
            return back()->with('error', 'No está permitido regresar la correspondencia interna a un estado anterior.');
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
        }
        else {
            // Mantener el archivo previo si existe o dejar nulo (depende la regla de negocio, 
            // usualmente el archivo de respuesta es único al finalizar, pero lo propagamos por si acaso)
            $nuevoRegistro->archivo_respuesta = $detalleAntiguo->archivo_respuesta;
        }

        $nuevoRegistro->save();

        // Duplicate any existing AnexosRespuesta (Interna usa id_det_interna)
        $anexosAntiguos = \App\Models\AnexoRespuesta::where('id_det_interna', $detalleAntiguo->id_detalle)->get();
        foreach ($anexosAntiguos as $anexo) {
            \App\Models\AnexoRespuesta::create([
                'id_det_interna' => $nuevoRegistro->id_detalle,
                'ruta_archivo' => $anexo->ruta_archivo,
                'nombre_original' => $anexo->nombre_original,
            ]);
        }

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
        if ($estadoArchivado) {
            $recibidoAntiguo->id_estado_rec = $estadoArchivado->id_estado;
            $recibidoAntiguo->save();
        }

        return back()->with('success', 'Correspondencia reasignada correctamente al nuevo empleado.');
    }

    public function nuevaInterna(Request $request)
    {
        try {
            $request->validate([
                'asunto' => 'required|string|max:100',
                'doc_quien_dirigido' => 'required|array|min:1',
                'doc_quien_dirigido.*' => 'exists:empleado,emple_doc',
                'id_tipo_envio' => 'required|exists:tipo,id_tipo',
                'observaciones' => 'nullable|string',
                'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
                'anexos.*' => 'nullable|file|mimes:pdf|max:25600', // Max 25MB
                'folio' => 'nullable|integer'
            ]);

            $user = Auth::user();

            // Let's create a fake or generated radicado_int since internal requires it
            // Depending on your actual process you might use the radicados table. 
            // We will insert a new Radicado automatically for internal to maintain consistency.

            $estadoRecibido = \App\Models\Estado::where('estado_nomb', 'Recibido')->first();
            $estadoEnviado = \App\Models\Estado::where('estado_nomb', 'Enviado')->first();

            $estadoRecibidoId = $estadoRecibido ? $estadoRecibido->id_estado : 7; // Fallback
            $estadoEnviadoId = $estadoEnviado ? $estadoEnviado->id_estado : 7; // Fallback if not found
            $estadoActivoId = 1; // ID 1 = Activo (basado en EstadoSeeder)

            // Create Radicado (using sequential numbering INT-YYYY-00001)
            $currentYear = date('Y');

            // Find the latest internal radicado for this year and company
            $latestRadicado = \App\Models\Radicado::where('nit_empresa', $user->nit_empresa)
                ->where('num_radicado', 'like', 'INT-' . $currentYear . '-%')
                ->orderBy('num_radicado', 'desc')
                ->first();

            if ($latestRadicado) {
                // Extract the last 5 digits and increment
                $lastNumber = intval(substr($latestRadicado->num_radicado, -5));
                $newNumber = $lastNumber + 1;
            }
            else {
                // Start at 1 if no previous radicado exists for this year
                $newNumber = 1;
            }

            $radicado = new \App\Models\Radicado();
            $radicado->num_radicado = 'INT-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
            $radicado->nit_empresa = $user->nit_empresa;
            $radicado->save();

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

            // Create DetalleEnvio (Receiver tracking) for each recipient
            foreach ($request->doc_quien_dirigido as $destinatario_doc) {
                $detalle = new \App\Models\DetalleEnvio();
                $detalle->id_quien_envie = $user->emple_doc;
                $detalle->id_quien_recibe = $destinatario_doc;
                $detalle->id_envio = $envio->id_envio;
                $detalle->fecha_traslado = now();
                $detalle->id_estado_rec = $estadoRecibidoId; // El que recibe (destinatario) inicia en 'Recibido'
                $detalle->observaciones = $request->observaciones;
                $detalle->save();
            }

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
    public function nuevaVentanilla(Request $request)
    {
        try {
            $request->validate([
                'asunto' => 'required|string|max:100',
                'doc_quien_dirigido' => 'required|exists:remitente,rem_doc',
                'id_tipo_envio' => 'required|exists:tipo,id_tipo',
                'observaciones' => 'nullable|string',
                'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
                'anexos.*' => 'nullable|file|mimes:pdf|max:25600', // Max 25MB
                'folio' => 'nullable|integer'
            ]);

            $user = Auth::user();
            $estadoRecibidoId = 7; // Recibido/Inicial
            $estadoEnviadoId = 9; // Resuelto (para el emisor)

            // Create Radicado (using sequential numbering SAL-YYYY-00001)
            $currentYear = date('Y');

            // Find the latest output radicado for this year and company
            $latestRadicado = \App\Models\Radicado::where('nit_empresa', $user->nit_empresa)
                ->where('num_radicado', 'like', 'SAL-' . $currentYear . '-%')
                ->orderBy('num_radicado', 'desc')
                ->first();

            if ($latestRadicado) {
                // Extract the last 5 digits and increment
                $lastNumber = intval(substr($latestRadicado->num_radicado, -5));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $radicado = new \App\Models\Radicado();
            $radicado->num_radicado = 'SAL-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
            $radicado->nit_empresa = $user->nit_empresa;
            $radicado->save();

            $envio = new \App\Models\Envio();
            $envio->num_radicado_int = $radicado->id_radicado;
            $envio->asunto = $request->asunto;
            $envio->doc_quien_envia = $user->emple_doc;
            $envio->doc_quien_registra = $request->doc_quien_dirigido; // Directed to Remitente
            $envio->fecha = now();
            $envio->folio = $request->folio ?? 0;
            $envio->id_tipo_envio = $request->id_tipo_envio;
            $envio->id_estado_envio = $estadoEnviadoId;
            $envio->nit_empresa = $user->nit_empresa;
            $envio->destino = 'Ventanilla';
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

            // NOTA: No se crea registro en detalle_envio para Ventanilla 
            // ya que el destinatario es un Remitente, no un Empleado.
            // El registro en la tabla 'envio' es suficiente para la trazabilidad.

            return back()->with('success', 'Correspondencia a Ventanilla creada exitosamente con radicado ' . $radicado->num_radicado);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error guardando correspondencia a Ventanilla: ' . $e->getMessage());
            return back()->with('error', 'Error interno al guardar: ' . $e->getMessage())->withInput();
        }
    }

    public function historialInterna($id)
    {
        $detalle = \App\Models\DetalleEnvio::with(['envio.radicado', 'envio.tipoEnvio', 'envio.anexos', 'quienEnvia.area', 'quienRecibe.area'])
            ->findOrFail($id);

        $trazabilidad = \App\Models\DetalleEnvio::with(['quienRecibe', 'estado', 'anexosRespuesta'])
            ->where('id_envio', $detalle->id_envio)
            ->orderBy('fecha_traslado', 'asc')
            ->get();

        $destinatarios = $trazabilidad->groupBy('id_quien_recibe');

        return view('empleado.historial_interna', compact('detalle', 'trazabilidad', 'destinatarios'));
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
}

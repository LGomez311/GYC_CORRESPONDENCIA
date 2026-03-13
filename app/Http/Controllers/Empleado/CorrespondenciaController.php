<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recibido;
use App\Models\DetalleEnvio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CorrespondenciaController extends Controller
{
    public function recibida()
    {
        // Get the current user
        $user = Auth::user();
        
        // Fetch real data. We assume the user has a nit_empresa attribute based on the database schema.
        // Fetch stats
        // Fetch stats using grouping subqueries to avoid duplicate history traces
        // Filter by the current user being a recipient
        $queryBase = Recibido::whereHas('destinatarios', function($query) use ($user) {
            $query->where('det_doc_empleado', $user->emple_doc);
        });

        $latestRecibidoSubquery = clone $queryBase;
        $latestRecibidoSubquery = $latestRecibidoSubquery->select(\Illuminate\Support\Facades\DB::raw('MAX(id_recibido) as id_recibido'))->groupBy('num_radicado_ext', 'num_radicado_int');
        
        // We must re-apply the filter here for safety, or join. 
        // A simple way is to use whereIn on id_recibido but also ensure it matches the user.
        $queryBandejaUnicaExt = Recibido::whereIn('id_recibido', $latestRecibidoSubquery)
            ->whereHas('destinatarios', function($query) use ($user) {
                $query->where('det_doc_empleado', $user->emple_doc);
            });

        $totalRecibidas = (clone $queryBandejaUnicaExt)->count();
        $enTramite = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 8)->count(); 
        $finalizadas = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 9)->count();
        $archivadas = (clone $queryBandejaUnicaExt)->where('id_estado_rec', 10)->count();
        $vencidas = 0; // Se puede implementar luego la logica o join para buscar vencimiento de radicados. 
        
        $correspondencias = (clone $queryBandejaUnicaExt)->with(['radicado', 'estado', 'destinatarios', 'registradoPor', 'tipo.prioridad', 'ciudad', 'anexos'])
            ->orderBy('id_recibido', 'desc')
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

        $correspondenciasInternas = clone $queryBandejaUnicaInt;
        $correspondenciasInternas = $correspondenciasInternas->with(['envio', 'envio.tipoEnvio.prioridad', 'envio.radicado', 'quienEnvia', 'quienEnvia.area', 'estado', 'anexosRespuesta'])
            ->orderBy('id_detalle', 'desc')
            ->paginate(10, ['*'], 'int_page');

        // Fetch all active employees for the reassignment modal
        $empleados = \App\Models\Empleado::where('emple_estado', 1)
            ->where('nit_empresa', $user->nit_empresa)
            ->get();

        // Fetch document types
        $tipos = \App\Models\Tipo::all();

        return view('empleado.correspondencia_recibida', compact(
            'correspondencias', 'totalRecibidas', 'enTramite', 'finalizadas', 'archivadas', 'vencidas',
            'correspondenciasInternas', 'totalInternas', 'enTramiteInt', 'finalizadasInt', 'archivadasInt', 'vencidasInt',
            'empleados', 'tipos'
        ));
    }

    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'estado_nomb' => 'required',
            'observaciones' => 'nullable|string'
        ]);

        $recibidoAntiguo = Recibido::with('estado')->findOrFail($id);

        if (in_array($recibidoAntiguo->id_estado_rec, [9, 10]) || stripos($recibidoAntiguo->estado->estado_nomb, 'rechazado') !== false) {
            return back()->with('error', 'Esta correspondencia ya se encuentra finalizada, archivada o rechazada.');
        }

        // Prevent updating historical records via API manipulation
        if ($recibidoAntiguo->num_radicado_int) {
            $latestId = Recibido::where('num_radicado_int', $recibidoAntiguo->num_radicado_int)->max('id_recibido');
            if ($recibidoAntiguo->id_recibido != $latestId) {
                return back()->with('error', 'No se puede modificar un historial pasado. Solo el estado más reciente puede ser actualizado o finalizado.');
            }
        }

        // Find state ID
        $estado = \App\Models\Estado::where('estado_nomb', $request->estado_nomb)->first();
        if(!$estado) return back()->with('error', 'Estado no válido');

        // Prevent going backwards
        if ($estado->id_estado < $recibidoAntiguo->id_estado_rec) {
            return back()->with('error', 'No está permitido regresar la correspondencia a un estado anterior.');
        }

        // Create new row to keep history trace
        $nuevoRegistro = new Recibido();
        $nuevoRegistro->num_radicado_ext = $recibidoAntiguo->num_radicado_ext;
        $nuevoRegistro->num_radicado_int = $recibidoAntiguo->num_radicado_int;
        $nuevoRegistro->asunto = $recibidoAntiguo->asunto;
        $nuevoRegistro->fecha_hora_recib = now();
        $nuevoRegistro->nom_institucion = $recibidoAntiguo->nom_institucion;
        $nuevoRegistro->ciudad_proveniente = $recibidoAntiguo->ciudad_proveniente;
        $nuevoRegistro->folio = $recibidoAntiguo->folio;
        $nuevoRegistro->anexo = $recibidoAntiguo->anexo;
        $nuevoRegistro->observaciones = $request->observaciones ?? 'Cambio de estado';
        $nuevoRegistro->doc_quien_registra = $recibidoAntiguo->doc_quien_registra;
        $nuevoRegistro->id_tipo = $recibidoAntiguo->id_tipo;
        $nuevoRegistro->id_estado_rec = $estado->id_estado;
        $nuevoRegistro->archivo = $recibidoAntiguo->archivo;
        $nuevoRegistro->nit_empresa = $recibidoAntiguo->nit_empresa;
        $nuevoRegistro->save();

        // Duplicar también los destinatarios en detalle_recibido para este nuevo registro
        $destinatariosAntiguos = \App\Models\DetalleRecibido::where('det_id_recibido', $recibidoAntiguo->id_recibido)->get();
        foreach ($destinatariosAntiguos as $dest) {
            \App\Models\DetalleRecibido::create([
                'det_id_recibido' => $nuevoRegistro->id_recibido,
                'det_doc_empleado' => $dest->det_doc_empleado,
            ]);
        }

        // Duplicate any Anexos for the new trace
        $anexosAntiguos = \App\Models\AnexoRecibido::where('id_recibido', $recibidoAntiguo->id_recibido)->get();
        foreach ($anexosAntiguos as $anexo) {
            \App\Models\AnexoRecibido::create([
                'id_recibido' => $nuevoRegistro->id_recibido,
                'ruta_archivo' => $anexo->ruta_archivo,
                'nombre_original' => $anexo->nombre_original,
            ]);
        }

        return back()->with('success', 'Estado de correspondencia externa actualizado correctamente.');
    }

    public function actualizarEstadoInterna(Request $request, $id)
    {
        $request->validate([
            'estado_nomb' => 'required',
            'observaciones' => 'nullable|string',
            'archivo_respuesta' => 'nullable|file|mimes:pdf|max:5120',
            'archivos_respuesta.*' => 'nullable|file|mimes:pdf|max:5120', // Array de PDFs opcional
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
        if(!$estado) return back()->with('error', 'Estado no válido');

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
        } else {
            // Mantener el archivo previo si existe o dejar nulo (depende la regla de negocio, 
            // usualmente el archivo de respuesta es único al finalizar, pero lo propagamos por si acaso)
            $nuevoRegistro->archivo_respuesta = $detalleAntiguo->archivo_respuesta;
        }

        $nuevoRegistro->save();

        // Duplicate any existing AnexosRespuesta
        $anexosAntiguos = \App\Models\AnexoRespuesta::where('id_detalle', $detalleAntiguo->id_detalle)->get();
        foreach ($anexosAntiguos as $anexo) {
            \App\Models\AnexoRespuesta::create([
                'id_detalle' => $nuevoRegistro->id_detalle,
                'ruta_archivo' => $anexo->ruta_archivo,
                'nombre_original' => $anexo->nombre_original,
            ]);
        }

        // Process new Anexos Respuesta Múltiples as part of the overall Envio thread
        if ($request->hasFile('archivos_respuesta')) {
            foreach ($request->file('archivos_respuesta') as $file) {
                $pathAnexoResp = $file->store('correspondencia', 'public');
                \App\Models\AnexoRespuesta::create([
                    'id_detalle' => $nuevoRegistro->id_detalle,
                    'ruta_archivo' => $pathAnexoResp,
                    'nombre_original' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Si el estado es finalizado (9=Archivado, 10=Resuelto, u otros considerados finales en tu negocio)
        // marcamos el radicado asociado como "Inactivo" (id_estado = 2 asumiendo Activo=1 e Inactivo=2 del EstadoSeeder)
        if (in_array($estado->id_estado, [9, 10]) || stripos($estado->estado_nomb, 'rechazado') !== false) {
            $envioAsociado = \App\Models\Envio::find($detalleAntiguo->id_envio);
            if ($envioAsociado && $envioAsociado->num_radicado_int) {
                $radicadoInt = \App\Models\Radicado::find($envioAsociado->num_radicado_int);
                if ($radicadoInt) {
                    $radicadoInt->id_est_radicado = 2; // Inactivo
                    $radicadoInt->save();
                }
            }
        }

        return back()->with('success', 'Estado de correspondencia interna actualizado correctamente.', ['int_page' => request('int_page')]);
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
            'anexos.*' => 'nullable|file|mimes:pdf|max:5120', // Array de Archivos, Max 5MB
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

        // Create Radicado (using a logical numbering for internal, you could customize this)
        $radicado = new \App\Models\Radicado();
        $radicado->num_radicado = 'INT-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $radicado->nit_empresa = $user->nit_empresa;
        $radicado->save();

        $envio = new \App\Models\Envio();
        $envio->num_radicado_int = $radicado->id_radicado;
        $envio->asunto = $request->asunto;
        $envio->doc_quien_envia = $user->emple_doc;
        $envio->doc_quien_dirigido = null; // Internal, not a remitente
        $envio->fecha = now();
        $envio->anexo = $request->has('anexo') ? $request->anexo : null;
        $envio->folio = $request->folio ?? 0;
        $envio->id_tipo_envio = $request->id_tipo_envio;
        $envio->id_estado_envio = $estadoEnviadoId; // El que envía (remitente) inicia en 'Enviado'
        $envio->nit_empresa = $user->nit_empresa;
        $envio->destino = 'Interno';

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('correspondencia', 'public');
            $envio->archivo = $path;
        } else {
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

        return back()->with('success', 'Correspondencia interna creada y enviada exitosamente a los destinatarios seleccionados.', ['int_page' => 1]);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error guardando correspondencia interna: ' . $e->getMessage());
            return back()->with('error', 'Error interno al guardar: ' . $e->getMessage())->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\Remitente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tipo;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\Empleado;

class ExternarecController extends Controller
{
    public function index(Request $request)
    {
        $tipos     = Tipo::all();
        $estados   = Estado::all();
        $ciudades  = Ciudad::with('departamento')->orderBy('ciudad_nom')->get();
        $radicados = DB::table('radicados')->orderBy('id_radicado')->get();

        // Fetch the logged-in remitente to scope records
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        // Filtro de tipo recibido desde la URL (?tipo=persona|entidad)
        $tipoFiltro = $request->input('tipo', 'todos');

        $tab = $request->input('tab', 'externa');

        // Pull recibido records for this company, joined with tipo, prioridad and estado
        $query = DB::table('recibido as r')
            ->leftJoin('tipo as t',      'r.id_tipo',       '=', 't.id_tipo')
            ->leftJoin('prioridad as p', 't.id_prioridad',  '=', 'p.id_prioridad')
            ->leftJoin('estado as e',    'r.id_estado_rec', '=', 'e.id_estado')
            ->leftJoin('radicados as rad', 'r.num_radicado_int', '=', 'rad.id_radicado')
            ->where('r.nit_empresa', $nitEmpresa)
            ->whereIn('r.id_estado_rec', [7, 8, 9, 11, 12, 13]); // Show all management states including Resolved

        // Filtrar por pestaña según el prefijo del radicado
        if ($tab === 'interna') {
            $query->where('rad.num_radicado', 'like', 'INT-%');
        } elseif ($tab === 'saliente') {
            $query->where('rad.num_radicado', 'like', 'SAL-%');
        } else { // externa
            $query->where('rad.num_radicado', 'like', 'EXT-%');
        }

        $query->orderByDesc('r.fecha_hora_recib')
            ->select(
                'r.id_recibido',
                'r.num_radicado_ext',
                'rad.num_radicado',
                'r.asunto',
                'r.fecha_hora_recib',
                'r.nom_institucion',
                'r.nombre_persona',
                'r.doc_persona',
                'r.correo_persona',
                'r.tel_persona',
                'r.archivo',
                'r.observaciones',
                't.tipo_nombre',
                'p.prioridad_nombre',
                'e.estado_nomb',
                'r.id_estado_rec',
                'r.folio',
                DB::raw("(
                    SELECT GROUP_CONCAT(DISTINCT COALESCE(CONCAT(emp.emple_nombres, ' ', emp.emple_apellidos), CONCAT(rem.rem_nombres, ' ', rem.rem_apellidos)) SEPARATOR ', ')
                    FROM detalle_recibido dr
                    LEFT JOIN empleado emp ON dr.det_doc_empleado = emp.emple_doc
                    LEFT JOIN remitente rem ON dr.det_doc_empleado = rem.rem_doc
                    WHERE dr.det_id_recibido = r.id_recibido
                ) as destinatarios_nombres")
            );

        // Filtro de recibido enviado desde el campo de busqueda
        $searchQuery = $request->input('search', '');

        // Aplicar filtro por tipo de remitente
        if ($tipoFiltro === 'persona') {
            $query->where(function ($q) {
                $q->whereNotNull('r.nombre_persona')->orWhereNotNull('r.doc_persona');
            });
        } elseif ($tipoFiltro === 'entidad') {
            $query->whereNull('r.nombre_persona')->whereNull('r.doc_persona');
        }

        // Aplicar filtro de búsqueda
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('r.asunto', 'like', "%{$searchQuery}%")
                  ->orWhere('r.num_radicado_ext', 'like', "%{$searchQuery}%")
                  ->orWhere('rad.num_radicado', 'like', "%{$searchQuery}%")
                  ->orWhere('r.nom_institucion', 'like', "%{$searchQuery}%")
                  ->orWhere('r.nombre_persona', 'like', "%{$searchQuery}%")
                  ->orWhere('r.doc_persona', 'like', "%{$searchQuery}%")
                  ->orWhere('r.correo_persona', 'like', "%{$searchQuery}%")
                  ->orWhere('r.tel_persona', 'like', "%{$searchQuery}%")
                  ->orWhere('t.tipo_nombre', 'like', "%{$searchQuery}%")
                  ->orWhere('p.prioridad_nombre', 'like', "%{$searchQuery}%")
                  ->orWhere('e.estado_nomb', 'like', "%{$searchQuery}%")
                  ->orWhereRaw("EXISTS (
                      SELECT 1 FROM detalle_recibido dr 
                      LEFT JOIN empleado emp ON dr.det_doc_empleado = emp.emple_doc 
                      LEFT JOIN remitente rem ON dr.det_doc_empleado = rem.rem_doc 
                      WHERE dr.det_id_recibido = r.id_recibido 
                      AND (CONCAT(emp.emple_nombres, ' ', emp.emple_apellidos) LIKE ? 
                           OR CONCAT(rem.rem_nombres, ' ', rem.rem_apellidos) LIKE ?)
                  )", ["%{$searchQuery}%", "%{$searchQuery}%"]);
            });
        }

        $recibidos = $query->paginate(4)->appends(['tipo' => $tipoFiltro, 'search' => $searchQuery]);

        // T8b: Excluir Super Admin (rol=1) de la lista de destinatarios
        $todosDestinatarios = Empleado::with('area')
            ->where('emple_rol', '=', 3)
            ->where('emple_rol', '!=', 1)
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
        $remDoc = $remitente ? $remitente->rem_doc : null;
        $statsBase = DB::table('recibido')
            ->where('nit_empresa', $nitEmpresa)
            ->where(function($q) use ($remDoc) {
                $q->where('doc_quien_registra', $remDoc)
                  ->orWhereNull('doc_quien_registra');
            });

        $stats = [
            'total'     => (clone $statsBase)->count(),
            'rejected'  => (clone $statsBase)->where('id_estado_rec', 11)->count(),
            'resolved'  => (clone $statsBase)->whereIn('id_estado_rec', [9, 10, 14])->count(),
            'pending'   => (clone $statsBase)->whereNotIn('id_estado_rec', [9, 10, 11, 14])->count(),
        ];

        return view('remitente.recibidos', compact('tipos', 'estados', 'ciudades', 'radicados', 'recibidos', 'tipoFiltro', 'todosDestinatarios', 'tab', 'stats'));
    }

    /**
     * Endpoint AJAX para buscar ciudades por código postal o nombre.
     */
    public function buscarCiudades(Request $request)
    {
        $query = $request->get('q', '');

        $ciudades = Ciudad::where('ciudad_cod_post', 'like', "%{$query}%")
            ->orWhere('ciudad_nom', 'like', "%{$query}%")
            ->select('ciudad_cod_post', 'ciudad_nom')
            ->orderBy('ciudad_nom')
            ->limit(20)
            ->get();

        return response()->json($ciudades);
    }

    /**
     * Endpoint AJAX para buscar destinatarios: empleados (sin super admin) + remitentes.
     */
    public function buscarEmpleados(Request $request)
    {
        $q = trim($request->get('q', ''));
        $like = "%{$q}%";

        // Only employees with role 3
        $results = DB::table('empleado')
            ->where('emple_rol', '=', 3)
            ->where(function ($sub) use ($like) {
                $sub->where('emple_doc',       'like', $like)
                    ->orWhere('emple_nombres',  'like', $like)
                    ->orWhere('emple_apellidos','like', $like);
            })
            ->select(
                DB::raw("CAST(emple_doc AS CHAR) as emple_doc"),
                'emple_nombres',
                'emple_apellidos',
                DB::raw("'empleado' as tipo")
            )
            ->orderBy('emple_nombres')
            ->limit(30)
            ->get();

        return response()->json($results);
    }

    public function store(Request $request)
    {
        // 1. Obtener el remitente autenticado
        $remitente = Auth::guard('remitente')->user();

        $tipoRemitente = $request->input('tipo_remitente', 'empresa');

        // 2. Validación condicional según tipo de remitente
        $rules = [
            'tipo_remitente'     => 'required|in:empresa,persona',
            'num_radicado_ext'   => 'nullable|string|max:20',
            'ciudad_proveniente' => 'required|string|max:20',
            'doc_quien_dirige'   => 'nullable|string|max:20',
            'asunto'             => 'nullable|string|max:100',
            'id_tipo'            => 'nullable|integer',
            'folio'              => 'nullable|integer|min:1',
            'anexo'              => 'nullable|string|max:500',
            'observaciones'      => 'nullable|string|max:250',
            'archivo'            => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:20480',
            'anexos'             => 'nullable|array|max:5', // Aumentado para permitir más anexos si es necesario
            'anexos.*'           => 'file|mimes:pdf,doc,docx,jpg,png|max:20480',
            'destinatarios'      => 'nullable|array',
            'destinatarios.*'    => 'nullable|string|max:20',
        ];

        if ($tipoRemitente === 'persona') {
            $rules['nombre_persona']    = 'required|string|max:100';
            $rules['tipo_documento']    = 'required|string|max:20';
            $rules['numero_documento']  = 'required|string|max:20';
            $rules['telefono_persona']  = 'nullable|string|max:25';
        } else {
            $rules['nom_institucion'] = 'required|string|max:150';
            $rules['nit_institucion'] = 'required|string|max:20';
        }

        $rules['correo_persona'] = 'required|email|max:255';

        $validated = $request->validate($rules);

        // Filtrar destinatarios vacíos y verificar que haya al menos uno válido
        $destinatarios = array_values(array_filter(
            $request->input('destinatarios', []),
            fn($d) => !empty(trim($d))
        ));

        if (empty($destinatarios)) {
            return redirect()->back()->withInput()->withErrors([
                'destinatarios' => 'Debe seleccionar al menos un destinatario.',
            ]);
        }

        // 3. Procesamiento del archivo digitalizado (documento principal)
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

        $rutaArchivo = null;
        if ($request->hasFile('archivo')) {
            $rutaArchivo = $request->file('archivo')->store('correspondencia', 'public');
        }

        // 4. Valores automáticos del servidor
        $docQuienRegistra = $remitente ? $remitente->rem_doc : null;
        $nitEmpresa       = $remitente ? $remitente->nit_empresa : null;

        // INICIO DE LA TRANSACCIÓN
        DB::beginTransaction();

        try {
            // T1: Generación de Radicado con prefijo EXT para correspondencia externa recibida
            $currentYear = date('Y');
            $latestRadicado = \App\Models\Radicado::where('nit_empresa', $nitEmpresa)
                ->where('num_radicado', 'like', 'EXT-' . $currentYear . '-%')
                ->orderBy('num_radicado', 'desc')
                ->first();

            if ($latestRadicado) {
                $lastNumber = intval(substr($latestRadicado->num_radicado, -5));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $radicado = new \App\Models\Radicado();
            $radicado->num_radicado = 'EXT-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
            $radicado->nit_empresa  = $nitEmpresa;
            $radicado->save();

            // 6. Inserción en la tabla recibido — usamos insertGetId para obtener el id_recibido generado
            $nomInstitucion  = $tipoRemitente === 'empresa'
                ? ($validated['nom_institucion'] ?? null)
                : null;

            $nombrePersona   = $tipoRemitente === 'persona' ? ($validated['nombre_persona'] ?? null)   : null;
            $docPersona      = $tipoRemitente === 'persona' 
                ? ($validated['tipo_documento'] . ' ' . $validated['numero_documento']) 
                : ($validated['nit_institucion'] ?? null);
            $correoPersona   = $validated['correo_persona'] ?? null;
            $telPersona      = $tipoRemitente === 'persona' ? ($validated['telefono_persona'] ?? null)  : null;

            $idRecibido = DB::table('recibido')->insertGetId([
                'num_radicado_int'   => $radicado->id_radicado,
                'num_radicado_ext'   => $validated['num_radicado_ext'] ?: null,
                'fecha_hora_recib'   => now(),
                'nom_institucion'    => $nomInstitucion,
                'nit_empresa'        => $nitEmpresa,
                'ciudad_proveniente' => $validated['ciudad_proveniente'],
                'doc_quien_registra' => $docQuienRegistra,
                'asunto'             => $validated['asunto'] ?? null,
                'id_tipo'            => $validated['id_tipo'] ?? null,
                'id_estado_rec'      => 7, // Recibido (ya que en este formulario se asignan destinatarios inmediatamente)
                'folio'              => $validated['folio'],
                'anexo'              => $validated['anexo'] ?? null,
                'observaciones'      => $validated['observaciones'] ?? null,
                'archivo'            => $rutaArchivo,
                'nombre_persona'     => $nombrePersona,
                'doc_persona'        => $docPersona,
                'correo_persona'     => $correoPersona,
                'tel_persona'        => $telPersona,
            ]);

            // 7. Guardar cada anexo PDF en storage y registrar en tabla anexo_recibido
            if ($request->hasFile('anexos')) {
                foreach ($request->file('anexos') as $anexoFile) {
                    $rutaAnexo = $anexoFile->store('correspondencia', 'public');
                    DB::table('anexo_recibido')->insert([
                        'id_recibido'     => $idRecibido,
                        'ruta_archivo'    => $rutaAnexo,
                        'nombre_original' => $anexoFile->getClientOriginalName(),
                    ]);
                }
            }

            // 8. Registrar cada destinatario en detalle_recibido con estado Recibido (7)
            // Un único registro por destinatario con todos los datos completos.
            // Esto replica el flujo empleado→empleado y garantiza que TODOS los destinatarios
            // reciban el documento correctamente sin registros nulos duplicados.
            foreach ($destinatarios as $docEmpleado) {
                DB::table('detalle_recibido')->insert([
                    'det_id_recibido'  => $idRecibido,
                    'det_doc_empleado' => $docEmpleado,
                    'fecha_re'         => now(),
                    'id_estado_rec'    => 7, // Estado: Recibido
                    'observaciones'    => $validated['observaciones'] ?? 'Documento recibido (Registro Externo)',
                ]);
            }

            // Si todo salió bien, confirmamos los cambios en la BD
            DB::commit();

            return redirect()->back()->with('success', 'Correspondencia registrada exitosamente con el radicado ' . $radicado->num_radicado);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar el registro: ' . $e->getMessage()]);
        }
    }

    /**
     * Endpoint AJAX: devuelve el archivo principal y los anexos de un recibido.
     */
    public function getArchivos(Request $request, $id)
    {
        $remitente  = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        // Verificar que el registro pertenezca a la empresa
        $recibido = DB::table('recibido')
            ->where('id_recibido', $id)
            ->where('nit_empresa', $nitEmpresa)
            ->select('id_recibido', 'archivo', 'asunto')
            ->first();

        if (!$recibido) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        $anexos = DB::table('anexo_recibido')
            ->where('id_recibido', $id)
            ->select('ruta_archivo', 'nombre_original')
            ->get();

        return response()->json([
            'archivo_principal' => $recibido->archivo,
            'asunto'            => $recibido->asunto,
            'anexos'            => $anexos,
        ]);
    }

    /**
     * Asigna uno o más destinatarios a una correspondencia externa recien registrada.
     */
    public function asignarDestinatarios(Request $request, $id)
    {
        $validated = $request->validate([
            'destinatarios'   => 'required|array|min:1',
            'destinatarios.*' => 'required|string|max:20',
            'observaciones'   => 'nullable|string|max:250',
        ]);

        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        // Verificar que la correspondencia pertenezca a la empresa
        $recibido = DB::table('recibido')
            ->where('id_recibido', $id)
            ->where('nit_empresa', $nitEmpresa)
            ->first();

        if (!$recibido) {
            return redirect()->back()->withErrors(['error' => 'No se encontró la correspondencia o no tiene permisos.']);
        }

        DB::beginTransaction();
        try {
            // 1. Eliminar asignaciones previas (la por defecto del formulario público)
            DB::table('detalle_recibido')->where('det_id_recibido', $id)->delete();

            // 2. Insertar los nuevos destinatarios
            foreach ($request->input('destinatarios') as $docEmpleado) {
                DB::table('detalle_recibido')->insert([
                    'det_id_recibido'  => $id,
                    'det_doc_empleado' => $docEmpleado,
                    'fecha_re'         => now(),
                    'id_estado_rec'    => 7, // Recibido
                    'observaciones'    => $validated['observaciones'] ?? 'Asignación manual de destinatarios',
                ]);
            }

            // 3. Cambiamos el estado de la correspondencia a "Recibido" (7) si estaba en "Enviado" (12)
            // Y asignamos el documento de quien registra para que aparezca en su dashboard
            DB::table('recibido')->where('id_recibido', $id)->update([
                'id_estado_rec'      => 7, // Estado: Recibido (ahora que tiene destinatarios)
                'doc_quien_registra' => $remitente->rem_doc
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Destinatarios asignados exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al asignar destinatarios: ' . $e->getMessage()]);
        }
    }

    /**
     * Rechaza una correspondencia y notifica al remitente original.
     */
    public function rechazar(Request $request, $id)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'observaciones' => 'required|string|max:250',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $validated = $validator->validated();

        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        // Verificar que la correspondencia pertenezca a la empresa
        $recibido = DB::table('recibido')
            ->where('id_recibido', $id)
            ->where('nit_empresa', $nitEmpresa)
            ->first();

        if (!$recibido) {
            return redirect()->back()->with('error', 'No se encontró la correspondencia o no tiene permisos.');
        }

        DB::beginTransaction();
        try {
            // 1. Actualizar estado de la correspondencia a Rechazado (11)
            DB::table('recibido')->where('id_recibido', $id)->update([
                'id_estado_rec' => 11,
                'doc_quien_registra' => $remitente->rem_doc
            ]);

            // 2. Buscar un responsable técnico válido (Empleado) para satisfacer la FK de detalle_recibido
            // Buscamos primero un administrador o el primer empleado disponible de la misma empresa
            $responsableTecnico = DB::table('empleado')
                ->where('nit_empresa', $remitente->nit_empresa)
                ->orderBy('emple_rol', 'asc') // Admins suelen tener roles bajos (1 o 2)
                ->first();

            $idResponsable = $responsableTecnico ? $responsableTecnico->emple_doc : 999000; // Fallback extremo a Super Admin

            // 3. Insertar registro en detalle_recibido (usando un empleado válido para la FK)
            DB::table('detalle_recibido')->insert([
                'det_id_recibido'  => $id,
                'det_doc_empleado' => $idResponsable,
                'fecha_re'         => now(),
                'id_estado_rec'    => 11, // Rechazado
                'observaciones'    => "Rechazado por (Remitente) {$remitente->rem_nombres} {$remitente->rem_apellidos}: " . $validated['observaciones'],
            ]);

            DB::commit();

            // 3. Notificar por correo si hay un correo registrado
            if (!empty($recibido->correo_persona)) {
                $correoDestino = $recibido->correo_persona;
                $asuntoEmail = 'Su correspondencia ha sido RECHAZADA';
                $motivo = $validated['observaciones'];
                $urlEnviar = route('public.correspondencia.enviar');

                // Obtener anexos para adjuntar
                $anexos_originales = DB::table('anexo_recibido')
                    ->where('id_recibido', $id)
                    ->get();

                try {
                    \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($correoDestino, $asuntoEmail, $motivo, $recibido, $urlEnviar, $anexos_originales) {
                        $message->to($correoDestino)
                            ->subject($asuntoEmail)
                            ->html("
                            <div style='font-family: Arial, sans-serif; background-color: #f8fafc; padding: 40px;'>
                                <div style='max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;'>
                                    <div style='text-align: center; margin-bottom: 32px;'>
                                        <div style='display: inline-block; padding: 12px; background-color: #fef2f2; border-radius: 12px;'>
                                            <span style='font-size: 32px;'>❌</span>
                                        </div>
                                    </div>
                                    <h2 style='color: #991b1b; font-size: 24px; font-weight: 700; text-align: center; margin-bottom: 8px;'>Su correspondencia ha sido rechazada</h2>
                                    <p style='color: #64748b; font-size: 16px; text-align: center; margin-bottom: 32px;'>Le informamos que su solicitud ha sido rechazada por el siguiente motivo:</p>
                                    
                                    <div style='background-color: #fff1f2; border-left: 4px solid #f43f5e; border-radius: 8px; padding: 24px; margin-bottom: 32px;'>
                                        <p style='color: #9f1239; font-size: 16px; font-weight: 600; margin: 0;'>$motivo</p>
                                    </div>

                                    <div style='background-color: #f1f5f9; border-radius: 12px; padding: 24px; margin-bottom: 32px;'>
                                        <div style='margin-bottom: 12px;'>
                                            <span style='color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;'>Asunto Original</span>
                                            <p style='color: #1e293b; font-size: 14px; font-weight: 600; margin: 4px 0 0;'>{$recibido->asunto}</p>
                                        </div>
                                        <div>
                                            <span style='color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;'>Fecha de Registro</span>
                                            <p style='color: #1e293b; font-size: 14px; font-weight: 600; margin: 4px 0 0;'>".\Carbon\Carbon::parse($recibido->fecha_hora_recib)->format('d/m/Y h:i A')."</p>
                                        </div>
                                    </div>
                                    
                                    <div style='text-align: center; margin-bottom: 32px;'>
                                        <p style='color: #334155; font-size: 15px; margin-bottom: 16px;'>Por favor, corrija los inconvenientes mencionados y vuelva a radicar su correspondencia haciendo clic en el siguiente botón:</p>
                                        <a href='{$urlEnviar}' style='background-color: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;'>Volver a Enviar Documento</a>
                                    </div>

                                    <p style='color: #64748b; font-size: 12px; font-style: italic; text-align: center; margin-bottom: 24px;'>Adjunto a este correo encontrará el/los documento(s) que usted envió originalmente para su referencia.</p>
                                    
                                    <p style='font-size: 11px; color: #94a3b8; text-align: center; margin: 0;'>Este es un mensaje automático generado por el Sistema de Gestión Documental. Por favor no responda a este correo.</p>
                                </div>
                            </div>");

                        // Adjuntar Documento Principal
                        if ($recibido->archivo) {
                            $pathP = storage_path('app/public/' . $recibido->archivo);
                            if (file_exists($pathP)) {
                                $message->attach($pathP, [
                                    'as' => 'Documento_Original_' . $recibido->id_recibido . '.pdf'
                                ]);
                            }
                        }

                        // Adjuntar Anexos
                        foreach ($anexos_originales as $an) {
                            if ($an->ruta_archivo) {
                                $pathA = storage_path('app/public/' . $an->ruta_archivo);
                                if (file_exists($pathA)) {
                                    $message->attach($pathA, [
                                        'as' => $an->nombre_original ?: 'Anexo_' . $an->id_anexo_rec . '.pdf'
                                    ]);
                                }
                            }
                        }
                    });
                } catch (\Exception $mailEx) {
                    \Illuminate\Support\Facades\Log::error('Error enviando correo de rechazo: ' . $mailEx->getMessage());
                    // Correo falló pero se continua con el éxito del rechazo en base de datos.
                }
            }


            return redirect()->back()->with('success', 'Correspondencia rechazada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al rechazar correspondencia: ' . $e->getMessage());
        }
    }
}

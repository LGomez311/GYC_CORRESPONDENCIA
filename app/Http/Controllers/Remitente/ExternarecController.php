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

        // Pull recibido records for this company, joined with tipo, prioridad and estado
        $query = DB::table('recibido as r')
            ->leftJoin('tipo as t',      'r.id_tipo',       '=', 't.id_tipo')
            ->leftJoin('prioridad as p', 't.id_prioridad',  '=', 'p.id_prioridad')
            ->leftJoin('estado as e',    'r.id_estado_rec', '=', 'e.id_estado')
            ->leftJoin('radicados as rad', 'r.num_radicado_int', '=', 'rad.id_radicado')
            ->where('r.nit_empresa', $nitEmpresa)
            ->whereIn('r.id_estado_rec', [7, 12]) // Show 'Recibido' (External) and 'Enviado' records
            ->orderByDesc('r.fecha_hora_recib')
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

        $todosDestinatarios = Empleado::with('area')
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

        return view('remitente.externarec', compact('tipos', 'estados', 'ciudades', 'radicados', 'recibidos', 'tipoFiltro', 'todosDestinatarios'));
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
            'archivo'            => 'nullable|file|mimes:pdf|max:5120',
            'anexos'             => 'nullable|array|max:1',
            'anexos.*'           => 'file|mimes:pdf|max:5120',
            'destinatarios'      => 'nullable|array',
            'destinatarios.*'    => 'nullable|string|max:20',
        ];

        if ($tipoRemitente === 'persona') {
            $rules['nombre_persona']   = 'required|string|max:100';
            $rules['documento_persona'] = 'required|string|max:20';
            $rules['telefono_persona'] = 'nullable|string|max:25';
        } else {
            $rules['nom_institucion'] = 'required|string|max:150';
            $rules['nit_institucion'] = 'required|string|max:20';
        }

        $rules['correo_persona'] = 'nullable|email|max:255';

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
            // 5. Creación automática del Radicado
            $currentYear = date('Y');
            $latestRadicado = \App\Models\Radicado::where('nit_empresa', $nitEmpresa)
                ->where('num_radicado', 'like', 'INT-' . $currentYear . '-%')
                ->orderBy('num_radicado', 'desc')
                ->first();

            if ($latestRadicado) {
                // Extract the last 5 digits and increment
                $lastNumber = intval(substr($latestRadicado->num_radicado, -5));
                $newNumber = $lastNumber + 1;
            } else {
                // Start at 1 if no previous radicado exists for this year
                $newNumber = 1;
            }

            $radicado = new \App\Models\Radicado();
            $radicado->num_radicado = 'INT-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
            $radicado->nit_empresa  = $nitEmpresa;
            $radicado->save();

            // 6. Inserción en la tabla recibido — usamos insertGetId para obtener el id_recibido generado
            $nomInstitucion  = $tipoRemitente === 'empresa'
                ? ($validated['nom_institucion'] ?? null)
                : null;

            $nombrePersona   = $tipoRemitente === 'persona' ? ($validated['nombre_persona'] ?? null)   : null;
            $docPersona      = $tipoRemitente === 'persona' ? ($validated['documento_persona'] ?? null) : ($validated['nit_institucion'] ?? null);
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
}

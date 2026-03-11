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
use App\Models\DetalleRecibido;

class ExternarecController extends Controller
{
    public function index()
    {
        $tipos     = Tipo::all();
        $estados   = Estado::all();
        $ciudades  = Ciudad::orderBy('ciudad_nom')->get();
        $radicados = DB::table('radicados')->orderBy('id_radicado')->get();

        // Fetch the logged-in remitente to scope records
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        // Pull recibido records for this company, joined with tipo, prioridad and estado
        $recibidos = DB::table('recibido as r')
            ->leftJoin('tipo as t',      'r.id_tipo',       '=', 't.id_tipo')
            ->leftJoin('prioridad as p', 't.id_prioridad',  '=', 'p.id_prioridad')
            ->leftJoin('estado as e',    'r.id_estado_rec', '=', 'e.id_estado')
            ->where('r.nit_empresa', $nitEmpresa)
            ->orderByDesc('r.fecha_hora_recib')
            ->select(
                'r.id_recibido',
                'r.num_radicado_ext',
                'r.num_radicado_int',
                'r.asunto',
                'r.fecha_hora_recib',
                'r.nom_institucion',
                'r.nombre_persona',
                'r.doc_persona',
                'r.correo_persona',
                'r.tel_persona',
                'r.archivo',
                't.tipo_nombre',
                'p.prioridad_nombre',
                'e.estado_nomb'
            )
            ->get();

        return view('remitente.externarec', compact('tipos', 'estados', 'ciudades', 'radicados', 'recibidos'));
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

        // Empleados excluyendo el rol super admin (id_rol = 1)
        $empleados = DB::table('empleado')
            ->where('emple_rol', '!=', 1)
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
            );

        // Remitentes — todos incluidos
        $remitentes = DB::table('remitente')
            ->where(function ($sub) use ($like) {
                $sub->where('rem_doc',        'like', $like)
                    ->orWhere('rem_nombres',   'like', $like)
                    ->orWhere('rem_apellidos', 'like', $like);
            })
            ->select(
                DB::raw("CAST(rem_doc AS CHAR) as emple_doc"),
                DB::raw("rem_nombres  as emple_nombres"),
                DB::raw("rem_apellidos as emple_apellidos"),
                DB::raw("'remitente' as tipo")
            );

        $results = $empleados->union($remitentes)
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
            'folio'              => 'required|integer|min:1',
            'anexo'              => 'nullable|string|max:500',
            'observaciones'      => 'nullable|string|max:250',
            'archivo'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'anexos'             => 'nullable|array|max:10',
            'anexos.*'           => 'file|mimes:pdf|max:5120',
            'destinatarios'      => 'nullable|array',
            'destinatarios.*'    => 'nullable|string|max:20',
        ];

        if ($tipoRemitente === 'persona') {
            $rules['nombre_persona']   = 'required|string|max:100';
            $rules['documento_persona'] = 'required|string|max:20';
            $rules['correo_persona']   = 'nullable|email|max:255';
            $rules['telefono_persona'] = 'nullable|string|max:25';
        } else {
            $rules['nom_institucion'] = 'required|string|max:150';
        }

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
            $radicado = new \App\Models\Radicado();
            $radicado->num_radicado = 'INT-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $radicado->nit_empresa  = $nitEmpresa;
            $radicado->save();

            // 6. Inserción en la tabla recibido — usamos insertGetId para obtener el id_recibido generado
            $nomInstitucion  = $tipoRemitente === 'empresa'
                ? ($validated['nom_institucion'] ?? null)
                : null;

            $nombrePersona   = $tipoRemitente === 'persona' ? ($validated['nombre_persona'] ?? null)   : null;
            $docPersona      = $tipoRemitente === 'persona' ? ($validated['documento_persona'] ?? null) : null;
            $correoPersona   = $tipoRemitente === 'persona' ? ($validated['correo_persona'] ?? null)    : null;
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
                'id_estado_rec'      => 12,
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

            // 8. Registrar los destinatarios en detalle_recibido
            foreach ($destinatarios as $docEmpleado) {
                DetalleRecibido::create([
                    'det_id_recibido'  => $idRecibido,
                    'det_doc_empleado' => $docEmpleado,
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
}

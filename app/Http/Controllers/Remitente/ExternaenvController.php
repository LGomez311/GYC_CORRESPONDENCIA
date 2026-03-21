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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExternaenvController extends Controller
{
    public function index(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        $search = $request->input('search');
        $estadoId = $request->input('estado_id');

        // Traemos los envíos con sus relaciones cargadas.
        $query = Envio::with([
            'radicado', 
            'tipoEnvio', 
            'estadoEnvio',
            'anexos'
        ])
        ->where('nit_empresa', $nitEmpresa)
        ->where('id_estado_envio', '!=', 0) // Exclude 'En espera' from external view until registered
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

        $envios = $query->paginate(10)->appends(['search' => $search, 'estado_id' => $estadoId]);

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
        $ciudades = Ciudad::orderBy('ciudad_nom')->get();

        return view('remitente.externaenv', compact('envios', 'tipos', 'estados', 'ciudades', 'search', 'estadoId', 'stats'));
    }

    public function store(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;
        $docQuienRegistra = $remitente ? $remitente->rem_doc : null;

        $validated = $request->validate([
            'destino'            => 'required|string|max:200',
            'asunto'             => 'required|string|max:100',
            'id_tipo_envio'      => 'required|integer',
            'doc_quien_envia'    => 'required|string|max:20',
            'folio'              => 'required|integer|min:1',
            'archivo'            => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $rutaArchivo = null;
        if ($request->hasFile('archivo')) {
            $rutaArchivo = $request->file('archivo')->store('correspondencia/enviados', 'public');
        }

        DB::beginTransaction();
        try {
            // Generación de Radicado (Lógica de ExternarecController)
            $currentYear = date('Y');
            $latestRadicado = Radicado::where('nit_empresa', $nitEmpresa)
                ->where('num_radicado', 'like', 'INT-' . $currentYear . '-%')
                ->orderBy('num_radicado', 'desc')
                ->lockForUpdate()
                ->first();

            $newNumber = $latestRadicado ? intval(substr($latestRadicado->num_radicado, -5)) + 1 : 1;
            
            $radicado = Radicado::create([
                'num_radicado' => 'INT-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT),
                'nit_empresa'  => $nitEmpresa,
            ]);

            Envio::create([
                'num_radicado_int'   => $radicado->id_radicado,
                'asunto'             => $validated['asunto'],
                'destino'            => $validated['destino'],
                'doc_quien_envia'    => $validated['doc_quien_envia'],
                'fecha'              => now(),
                'folio'              => $validated['folio'],
                'id_tipo_envio'      => $validated['id_tipo_envio'],
                'id_estado_envio'    => 12, // 'Enviado' (según la tabla estado en SQL es 12)
                'archivo'            => $rutaArchivo,
                'nit_empresa'        => $nitEmpresa,
                'doc_quien_registra' => $docQuienRegistra,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Correspondencia enviada exitosamente con radicado: ' . $radicado->num_radicado);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al registrar: ' . $e->getMessage()]);
        }
    }


    public function buscarEmpleados(Request $request)
    {
        $q = trim($request->get('q', ''));
        
        $empleados = Empleado::leftJoin('area', 'empleado.emple_area', '=', 'area.id_area')
            ->where('empleado.emple_rol', 3) // Solo rol 3
            ->where(function($query) use ($q) {
                $query->where('empleado.emple_nombres', 'like', "%{$q}%")
                    ->orWhere('empleado.emple_apellidos', 'like', "%{$q}%")
                    ->orWhere('empleado.emple_doc', 'like', "%{$q}%")
                    ->orWhere('area.area_nom', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get([
                'empleado.emple_doc', 
                'empleado.emple_nombres', 
                'empleado.emple_apellidos',
                'area.area_nom'
            ]);

        return response()->json($empleados);
    }

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
            ->leftJoin('empleado as emp_r', 'de.id_quien_recibe', '=', 'emp_r.emple_doc')
            ->where('de.id_envio', $id)
            ->select(
                DB::raw("'detail' as type"),
                'de.fecha_traslado as fecha',
                'emp_e.emple_nombres as nombres_e',
                'emp_e.emple_apellidos as apellidos_e',
                'emp_r.emple_nombres as nombres_r',
                'emp_r.emple_apellidos as apellidos_r',
                'est.estado_nomb',
                'de.observaciones',
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
            
            if ($d->nombres_r) {
                $receptor = " -> Destino: {$d->nombres_r} {$d->apellidos_r}";
                $det['observaciones'] = ($det['observaciones'] ?? '') . $receptor;
            }

            $det['anexos'] = DB::table('anexo_respuesta')
                ->where('id_det_interna', $d->id_detalle)
                ->select('ruta_archivo', 'nombre_original')
                ->get();
                
            $history[] = $det;
        }

        return response()->json($history);
    }
}
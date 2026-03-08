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
    public function index()
    {
        $tipos     = Tipo::all();
        $estados   = Estado::all();
        $ciudades  = Ciudad::orderBy('ciudad_nom')->get();
        $radicados = DB::table('radicados')->orderBy('id_radicado')->get();

        return view('remitente.externarec', compact('tipos', 'estados', 'ciudades', 'radicados'));
    }

    /**
     * Endpoint AJAX para buscar empleados por doc o nombre.
     */
    public function buscarEmpleados(Request $request)
    {
        $query = $request->get('q', '');

        $empleados = Empleado::where('emple_doc', 'like', "%{$query}%")
            ->orWhere('emple_nombres', 'like', "%{$query}%")
            ->orWhere('emple_apellidos', 'like', "%{$query}%")
            ->select('emple_doc', 'emple_nombres', 'emple_apellidos')
            ->limit(20)
            ->get();

        return response()->json($empleados);
    }

    public function store(Request $request)
    {
        // 1. Obtener el remitente autenticado
        $remitente = Auth::guard('remitente')->user();

        // 2. Validación
        $validated = $request->validate([
            'num_radicado_int'   => 'required|integer',
            'num_radicado_ext'   => 'nullable|string|max:20',
            'nom_institucion'    => 'required|string|max:150',
            'ciudad_proveniente' => 'required|string|max:20',
            'doc_quien_dirige'   => 'nullable|string|max:20',
            'asunto'             => 'nullable|string|max:100',
            'id_tipo'            => 'nullable|integer',
            'id_estado_rec'      => 'nullable|integer',
            'folio'              => 'required|integer|min:1',
            'anexo'              => 'nullable|string|max:500',
            'observaciones'      => 'nullable|string|max:250',
            'archivo'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // 3. Procesamiento del archivo digitalizado
        $rutaArchivo = null;
        if ($request->hasFile('archivo')) {
            $rutaArchivo = $request->file('archivo')->store('correspondencia', 'public');
        }

        // 4. Valores automáticos del servidor
        $docQuienRegistra = $remitente ? $remitente->rem_doc : null;
        $nitEmpresa       = $remitente ? $remitente->nit_empresa : null;

        // 5. Inserción en la base de datos (Tabla: recibido)
        DB::table('recibido')->insert([
            'num_radicado_int'   => $validated['num_radicado_int'],
            'num_radicado_ext'   => $validated['num_radicado_ext'] ?: null,
            'fecha_hora_recib'   => now(),                                         // Fecha automática del servidor
            'nom_institucion'    => $validated['nom_institucion'],
            'nit_empresa'        => $nitEmpresa,                                   // Tomado del remitente autenticado
            'ciudad_proveniente' => $validated['ciudad_proveniente'],
            'doc_quien_registra' => $docQuienRegistra,                             // Doc del usuario logueado
            'doc_quien_dirige'   => ($validated['doc_quien_dirige'] ?? '') ?: null, // NULL si vacío
            'asunto'             => $validated['asunto'] ?? null,
            'id_tipo'            => $validated['id_tipo'] ?? null,
            'id_estado_rec'      => $validated['id_estado_rec'] ?? null,
            'folio'              => $validated['folio'],
            'anexo'              => $validated['anexo'] ?? null,
            'observaciones'      => $validated['observaciones'] ?? null,
            'archivo'            => $rutaArchivo,
        ]);

        // 6. Redirección con mensaje de éxito
        return redirect()->back()->with('success', 'Correspondencia registrada exitosamente.');
    }
}

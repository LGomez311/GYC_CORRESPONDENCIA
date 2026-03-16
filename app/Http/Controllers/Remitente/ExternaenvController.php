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
    public function index()
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        // Traemos los envíos con sus relaciones cargadas.
        $envios = Envio::with([
            'radicado', 
            'tipoEnvio', 
            'estadoEnvio',
            'anexos'
        ])
        ->where('nit_empresa', $nitEmpresa)
        ->orderBy('fecha', 'desc')
        ->paginate(10);

        $tipos = Tipo::all();
        $estados = Estado::all();
        $ciudades = Ciudad::orderBy('ciudad_nom')->get();

        return view('remitente.externaenv', compact('envios', 'tipos', 'estados', 'ciudades'));
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
}
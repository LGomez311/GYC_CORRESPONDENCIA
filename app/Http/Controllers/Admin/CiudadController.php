<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ciudad;
use App\Models\Departamento;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CiudadExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CiudadController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $ciudades = Ciudad::with('departamento')
            ->when($search, function ($query, $search) {
                return $query->where('ciudad_nom', 'like', '%' . $search . '%')
                             ->orWhere('ciudad_cod_post', 'like', '%' . $search . '%');
            })
            ->orderByRaw('CAST(ciudad_cod_post AS UNSIGNED) ASC')
            ->paginate(10);

        $departamentos = Departamento::orderBy('dpto_nombre', 'asc')->get();

        return view('admin.otros.ciudad', compact('ciudades', 'departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCiudad($request);

        Ciudad::create([
            'ciudad_cod_post' => $validated['ciudad_cod_post'],
            'ciudad_nom'      => $this->formatNombre($validated['ciudad_nom']),
            'ciudad_id_dpto'  => $validated['ciudad_id_dpto'],
        ]);

        return redirect()->back()->with('success', 'Ciudad creada correctamente');
    }

    public function update(Request $request, $id)
    {
        // $id = ciudad_cod_post (porque es tu PK)
        $ciudad = Ciudad::findOrFail($id);
        
        $validated = $this->validateCiudad($request, $id);

        $nombreCiudad = $this->formatNombre($validated['ciudad_nom']);

        // ⚠ Si cambian el código postal (PK), hay que actualizar manualmente
        if ($validated['ciudad_cod_post'] !== $id) {
            $ciudad->delete();

            Ciudad::create([
                'ciudad_cod_post' => $validated['ciudad_cod_post'],
                'ciudad_nom'      => $nombreCiudad,
                'ciudad_id_dpto'  => $validated['ciudad_id_dpto'],
            ]);
        } else {
            $ciudad->update([
                'ciudad_nom'     => $nombreCiudad,
                'ciudad_id_dpto' => $validated['ciudad_id_dpto'],
            ]);
        }

        return redirect()->route('admin.ciudad.index')
            ->with('success', 'Ciudad actualizada correctamente');
    }

    public function exportPDF()
    {
        // Se mantiene el get() original pero se podría limitar select si futuro requiere
        $ciudades = Ciudad::with('departamento')
            ->orderByRaw('CAST(ciudad_cod_post AS UNSIGNED) ASC')
            ->get();

        $pdf = Pdf::loadView('admin.pdf.ciudad_pdf', compact('ciudades'));

        return $pdf->download('ciudades.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new CiudadExport, 'ciudades.xlsx');
    }

    public function checkCodigo(Request $request)
    {
        $codigo = $request->codigo;
        $actual = $request->actual; // código actual si está editando

        $query = \App\Models\Ciudad::where('ciudad_cod_post', $codigo);

        if ($actual) {
            $query->where('ciudad_cod_post', '!=', $actual);
        }

        return response()->json([
            'exists' => $query->exists()
        ]);
    }

    // ==========================================
    // MÉTODOS PRIVADOS PARA DRY
    // ==========================================

    private function validateCiudad(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:ciudad,ciudad_cod_post,' . $id . ',ciudad_cod_post' : 'unique:ciudad,ciudad_cod_post';

        return $request->validate([
            'ciudad_nom' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/'
            ],
            'ciudad_cod_post' => [
                'required',
                'max:10',
                $uniqueRule,
                function ($attribute, $value, $fail) use ($request) {
                    $dpto = $request->ciudad_id_dpto;
                    if ($dpto && strpos($value, $dpto) !== 0) {
                        $fail('El código de la ciudad debe iniciar con el código del departamento seleccionado (' . $dpto . ').');
                    }
                }
            ],
            'ciudad_id_dpto' => 'required|exists:departamento,dpto_codigo_postal'
        ], [
            'ciudad_nom.required'      => 'El nombre de la ciudad es obligatorio.',
            'ciudad_nom.min'           => 'Debe tener mínimo 3 caracteres.',
            'ciudad_nom.max'           => 'No puede superar 100 caracteres.',
            'ciudad_nom.regex'         => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'ciudad_cod_post.required' => 'El código postal es obligatorio.',
            'ciudad_cod_post.unique'   => 'Este código postal ya existe.',
            'ciudad_id_dpto.required'  => 'Debe seleccionar un departamento.'
        ]);
    }

    private function formatNombre($nombre)
    {
        return ucfirst(strtolower(trim($nombre)));
    }
}

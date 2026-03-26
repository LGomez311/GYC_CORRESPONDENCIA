<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prioridad;
use Illuminate\Http\Request;
use App\Exports\PrioridadesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PrioridadController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $prioridades = Prioridad::when($search, function ($query, $search) {
                        return $query->where('prioridad_nombre', 'like', '%' . $search . '%');
                    })
                    ->paginate(10);
        return view('admin.otros.prioridad', compact('prioridades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prioridad_nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:prioridad,prioridad_nombre'
            ]
        ], [
            'prioridad_nombre.required' => 'El nombre de la prioridad es obligatorio.',
            'prioridad_nombre.min' => 'Debe tener mínimo 3 caracteres.',
            'prioridad_nombre.max' => 'No puede superar 100 caracteres.',
            'prioridad_nombre.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'prioridad_nombre.unique' => 'Esta prioridad ya existe.'
        ]);

        $validated['prioridad_nombre'] = ucfirst(strtolower(trim($validated['prioridad_nombre'])));

        Prioridad::create($validated);

        return redirect()->back()->with('success', 'Prioridad creada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prioridad_nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:prioridad,prioridad_nombre,' . $id . ',id_prioridad'
            ]
        ], [
            'prioridad_nombre.required' => 'El nombre de la prioridad es obligatorio.',
            'prioridad_nombre.min' => 'Debe tener mínimo 3 caracteres.',
            'prioridad_nombre.max' => 'No puede superar 100 caracteres.',
            'prioridad_nombre.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'prioridad_nombre.unique' => 'Esta prioridad ya existe.'
        ]);

        $p = Prioridad::findOrFail($id);
        $p->update(['prioridad_nombre' => $request->prioridad_nombre]);

        return redirect()->route('admin.prioridad.index')->with('success', 'Prioridad actualizada correctamente');
    }



    public function exportExcel()
    {
        return Excel::download(new PrioridadesExport, 'prioridades.xlsx');
    }

    public function exportPdf()
    {
        $prioridades = Prioridad::all();
        $pdf = Pdf::loadView('admin.pdf.prioridad_pdf', compact('prioridades'));
        return $pdf->download('prioridades.pdf');
    }

    // Optional AJAX check for duplicates
    public function check(Request $request)
    {
        $nombre = $request->query('nombre');
        $actual = $request->query('actual');

        $exists = Prioridad::where('prioridad_nombre', $nombre)
            ->when($actual, function ($q) use ($actual) {
                return $q->where('prioridad_nombre', '!=', $actual);
            })->exists();

        return response()->json(['exists' => $exists]);
    }
}

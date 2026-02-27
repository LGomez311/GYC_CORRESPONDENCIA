<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use Illuminate\Http\Request;
use App\Exports\EstadosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Estado::whereIn('id_estado', [1, 2])
                        ->orWhere('id_estado', '>', 5)
                        ->paginate(10);
        return view('admin.otros.estado', compact('estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estado_nomb' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:estado,estado_nomb'
            ]
        ], [
            'estado_nomb.required' => 'El nombre del estado es obligatorio.',
            'estado_nomb.min' => 'Debe tener mínimo 3 caracteres.',
            'estado_nomb.max' => 'No puede superar 100 caracteres.',
            'estado_nomb.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'estado_nomb.unique' => 'Este estado ya existe.'
        ]);

        $validated['estado_nomb'] = ucfirst(strtolower(trim($validated['estado_nomb'])));

        Estado::create($validated);

        return redirect()->back()->with('success', 'Estado creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado_nomb' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:estado,estado_nomb,' . $id . ',id_estado'
            ]
        ], [
            'estado_nomb.required' => 'El nombre del estado es obligatorio.',
            'estado_nomb.min' => 'Debe tener mínimo 3 caracteres.',
            'estado_nomb.max' => 'No puede superar 100 caracteres.',
            'estado_nomb.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'estado_nomb.unique' => 'Este estado ya existe.'
        ]);

        $e = Estado::findOrFail($id);
        $e->update(['estado_nomb' => $request->estado_nomb]);

        return redirect()->route('admin.estado.index')->with('success', 'Estado actualizado correctamente');
    }

    public function destroy($id)
    {
        $e = Estado::findOrFail($id);
        $e->delete();
        return redirect()->route('admin.estado.index')->with('success', 'Estado eliminado correctamente');
    }

    public function exportExcel()
    {
        return Excel::download(new EstadosExport, 'estados.xlsx');
    }

    public function exportPdf()
    {
        $estados = Estado::whereIn('id_estado', [1, 2])
                        ->orWhere('id_estado', '>', 5)
                        ->get();
        $pdf = Pdf::loadView('admin.pdf.estado_pdf', compact('estados'));
        return $pdf->download('estados.pdf');
    }

    public function check(Request $request)
    {
        $nombre = $request->query('nombre');
        $actual = $request->query('actual');

        $exists = Estado::where('estado_nomb', $nombre)
            ->when($actual, function ($q) use ($actual) {
                return $q->where('estado_nomb', '!=', $actual);
            })->exists();

        return response()->json(['exists' => $exists]);
    }
}

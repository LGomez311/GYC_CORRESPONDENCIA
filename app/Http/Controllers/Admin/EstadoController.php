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
        // Mostrar solo registros con id_estado >= 6
        $estados = Estado::where('id_estado', '>=', 6)->paginate(10);
        return view('admin.otros.estado', compact('estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estado_nomb' => 'required|string|min:2|max:100|unique:estado,estado_nomb'
        ], [
            'estado_nomb.required' => 'El nombre del estado es obligatorio.'
        ]);

        $validated['estado_nomb'] = ucfirst(strtolower(trim($validated['estado_nomb'])));

        Estado::create($validated);

        return redirect()->back()->with('success', 'Estado creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado_nomb' => 'required|string|max:100'
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
        $estados = Estado::where('id_estado', '>=', 6)->get();
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

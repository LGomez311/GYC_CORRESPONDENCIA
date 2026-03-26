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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $estados = Estado::where(function ($query) {
                        $query->whereIn('id_estado', [1, 2])
                              ->orWhere('id_estado', '>', 12);
                    })
                    ->when($search, function ($query, $search) {
                        return $query->where('estado_nomb', 'like', '%' . $search . '%');
                    })
                    ->paginate(10);
        return view('admin.otros.estado', compact('estados'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateEstado($request);

        $validated['estado_nomb'] = $this->formatNombre($validated['estado_nomb']);

        Estado::create($validated);

        return redirect()->back()->with('success', 'Estado creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateEstado($request, $id);

        $estado = Estado::findOrFail($id);
        
        $estado->update([
            'estado_nomb' => $this->formatNombre($validated['estado_nomb'])
        ]);

        return redirect()->route('admin.estado.index')->with('success', 'Estado actualizado correctamente');
    }

    public function exportExcel()
    {
        return Excel::download(new EstadosExport, 'estados.xlsx');
    }

    public function exportPdf()
    {
        $estados = Estado::whereIn('id_estado', [1, 2])
                        ->orWhere('id_estado', '>', 12)
                        ->get(['id_estado', 'estado_nomb']);
                        
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

    // ==========================================
    // MÉTODOS PRIVADOS PARA DRY
    // ==========================================

    private function validateEstado(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:estado,estado_nomb,' . $id . ',id_estado' : 'unique:estado,estado_nomb';

        return $request->validate([
            'estado_nomb' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                $uniqueRule
            ]
        ], [
            'estado_nomb.required' => 'El nombre del estado es obligatorio.',
            'estado_nomb.min'      => 'Debe tener mínimo 3 caracteres.',
            'estado_nomb.max'      => 'No puede superar 100 caracteres.',
            'estado_nomb.regex'    => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'estado_nomb.unique'   => 'Este estado ya existe.'
        ]);
    }

    private function formatNombre($nombre)
    {
        return ucfirst(strtolower(trim($nombre)));
    }
}

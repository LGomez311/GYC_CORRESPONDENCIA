<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Exports\AreasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AreaController extends Controller
{
    /**
     * Muestra el listado de áreas.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $areas = Area::when($search, function ($query, $search) {
            return $query->where('area_nom', 'like', '%' . $search . '%');
        })->paginate(5);
        
        return view('admin.otros.area', compact('areas'));
    }

    /**
     * Almacena una nueva área.
     */
    public function store(Request $request)
    {
        $validated = $this->validateArea($request);

        // Limpieza y formato del dato
        $validated['area_nom'] = $this->formatNombre($validated['area_nom']);

        Area::create($validated);

        return redirect()->back()->with('success', 'Área creada correctamente.');
    }

    /**
     * Actualiza un área existente.
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validateArea($request, $id);

        $area = Area::findOrFail($id);
        
        // Se aplica la misma limpieza de datos que en store
        $area->update([
            'area_nom' => $this->formatNombre($validated['area_nom'])
        ]);

        return redirect()->route('admin.area.index')->with('success', 'Área actualizada correctamente');
    }

    /**
     * Exporta las áreas a Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new AreasExport, 'areas.xlsx');
    }

    /**
     * Exporta las áreas a PDF.
     */
    public function exportPdf()
    {
        $areas = Area::get(['id_area', 'area_nom']); 
        
        $pdf = Pdf::loadView('admin.pdf.area_pdf', compact('areas'));
        return $pdf->download('areas.pdf');
    }

    // ==========================================
    // MÉTODOS PRIVADOS PARA DRY
    // ==========================================

    private function validateArea(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:area,area_nom,' . $id . ',id_area' : 'unique:area,area_nom';

        return $request->validate([
            'area_nom' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                $uniqueRule
            ]
        ], [
            'area_nom.required' => 'El nombre del área es obligatorio.',
            'area_nom.min'      => 'Debe tener mínimo 3 caracteres.',
            'area_nom.max'      => 'No puede superar 50 caracteres.',
            'area_nom.regex'    => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'area_nom.unique'   => 'Esta área ya existe.'
        ]);
    }

    private function formatNombre($nombre)
    {
        return ucfirst(strtolower(trim($nombre)));
    }
}

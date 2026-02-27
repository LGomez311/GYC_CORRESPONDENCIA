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
    public function index()
    {
        $areas = Area::paginate(5);
        return view('admin.otros.area', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_nom' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:area,area_nom'
            ]
        ], [
            'area_nom.required' => 'El nombre del área es obligatorio.',
            'area_nom.min' => 'Debe tener mínimo 3 caracteres.',
            'area_nom.max' => 'No puede superar 50 caracteres.',
            'area_nom.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'area_nom.unique' => 'Esta área ya existe.'
        ]);

        $validated['area_nom'] = ucfirst(strtolower(trim($validated['area_nom'])));

        Area::create($validated);

        return redirect()->back()->with('success', 'Área creada correctamente.');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'area_nom' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:area,area_nom,' . $id . ',id_area'
            ]
        ], [
            'area_nom.required' => 'El nombre del área es obligatorio.',
            'area_nom.min' => 'Debe tener mínimo 3 caracteres.',
            'area_nom.max' => 'No puede superar 50 caracteres.',
            'area_nom.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'area_nom.unique' => 'Esta área ya existe.'
        ]);

        $area = Area::findOrFail($id);
        $area->update([
            'area_nom' => $request->area_nom
        ]);

        return redirect()->route('admin.area.index')
            ->with('success', 'Área actualizada correctamente');
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);

        if ($area->empleados()->count() > 0) {
            return redirect()->route('admin.area.index')
                ->with('error', 'No se puede eliminar el área porque tiene empleados asignados.');
        }

        $area->delete();

        return redirect()->route('admin.area.index')
            ->with('success', 'Área eliminada correctamente');
    }

    public function exportExcel()
    {
        return Excel::download(new AreasExport, 'areas.xlsx');
    }
    public function exportPdf()
    {
        $areas = Area::all();

        $pdf = Pdf::loadView('admin.pdf.area_pdf', compact('areas'));

        return $pdf->download('areas.pdf');
    }
}

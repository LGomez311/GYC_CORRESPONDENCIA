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
    /**
     * Muestra el listado de prioridades con paginación y búsqueda.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $prioridades = Prioridad::when($search, function ($query, $search) {
            return $query->where('prioridad_nombre', 'like', '%' . $search . '%');
        })->paginate(10);
        
        return view('admin.otros.prioridad', compact('prioridades'));
    }

    /**
     * Almacena una nueva prioridad en la BD.
     */
    public function store(Request $request)
    {
        $validated = $this->validatePrioridad($request);

        // Limpieza y formato del dato (Mejora: Encapsulado)
        $validated['prioridad_nombre'] = $this->formatNombre($validated['prioridad_nombre']);

        Prioridad::create($validated);

        return redirect()->back()->with('success', 'Prioridad creada correctamente.');
    }

    /**
     * Actualiza una prioridad existente.
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validatePrioridad($request, $id);

        $prioridad = Prioridad::findOrFail($id); // Mejora: Nombre de variable más claro ($p -> $prioridad)
        
        // Mejora Crítica de QA: Aplicamos la misma limpieza que en store para evitar inconsistencias
        $prioridad->update([
            'prioridad_nombre' => $this->formatNombre($validated['prioridad_nombre'])
        ]);

        return redirect()->route('admin.prioridad.index')->with('success', 'Prioridad actualizada correctamente');
    }

    /**
     * Exporta las prioridades a Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new PrioridadesExport, 'prioridades.xlsx');
    }

    /**
     * Exporta las prioridades a PDF.
     */
    public function exportPdf()
    {
        // Mejora de Rendimiento: Se listan solo los campos estrictamente necesarios
        $prioridades = Prioridad::get(['id_prioridad', 'prioridad_nombre']); 
        
        $pdf = Pdf::loadView('admin.pdf.prioridad_pdf', compact('prioridades'));
        return $pdf->download('prioridades.pdf');
    }

    /**
     * Comprueba vía AJAX si una prioridad ya existe sin sobrecargar la vista.
     */
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

    // =========================================================
    // MÉTODOS PRIVADOS PARA ABSTRACCIÓN (DRY - Don't Repeat Yourself)
    // =========================================================

    /**
     * Centraliza la lógica y reglas de validación (QA: Evita diferencias entre crear y actualizar).
     */
    private function validatePrioridad(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:prioridad,prioridad_nombre,' . $id . ',id_prioridad' : 'unique:prioridad,prioridad_nombre';

        return $request->validate([
            'prioridad_nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                $uniqueRule
            ]
        ], [
            'prioridad_nombre.required' => 'El nombre de la prioridad es obligatorio.',
            'prioridad_nombre.min'      => 'Debe tener mínimo 3 caracteres.',
            'prioridad_nombre.max'      => 'No puede superar 100 caracteres.',
            'prioridad_nombre.regex'    => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'prioridad_nombre.unique'   => 'Esta prioridad ya existe.'
        ]);
    }

    /**
     * Estandariza el formato del String (Seguridad/Homogeneidad).
     */
    private function formatNombre($nombre)
    {
        return ucfirst(strtolower(trim($nombre)));
    }
}

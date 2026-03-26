<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DepartamentoExport;
use Illuminate\Validation\Rule;

class DepartamentoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $departamentos = Departamento::when($search, function ($query, $search) {
                return $query->where('dpto_nombre', 'like', '%' . $search . '%')
                             ->orWhere('dpto_codigo_postal', 'like', '%' . $search . '%');
            })
            ->orderByRaw('CAST(dpto_codigo_postal AS UNSIGNED) ASC')
            ->paginate(10);

        return view('admin.otros.departamento', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateDepartamento($request);

        Departamento::create([
            'dpto_codigo_postal' => $validated['dpto_codigo_postal'],
            'dpto_nombre'        => $this->formatNombre($validated['dpto_nombre']),
        ]);

        return redirect()->back()->with('success', 'Departamento creado correctamente');
    }

    public function update(Request $request, $codigo)
    {
        $validated = $this->validateDepartamento($request, $codigo);
        
        $departamento = Departamento::findOrFail($codigo);

        $departamento->update([
            'dpto_nombre'        => $this->formatNombre($validated['dpto_nombre']),
            'dpto_codigo_postal' => $validated['dpto_codigo_postal']
        ]);

        return back()->with('success', 'Departamento actualizado correctamente');
    }

    public function exportPDF()
    {
        $departamentos = Departamento::get(['dpto_codigo_postal', 'dpto_nombre']);

        $pdf = Pdf::loadView('admin.pdf.departamento_pdf', compact('departamentos'));
        
        return $pdf->download('departamentos.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new DepartamentoExport, 'departamentos.xlsx');
    }

    public function checkCodigo(Request $request)
    {
        $exists = Departamento::where('dpto_codigo_postal', $request->codigo)->exists();
        return response()->json(['exists' => $exists]);
    }

    // ==========================================
    // MÉTODOS PRIVADOS PARA DRY
    // ==========================================

    private function validateDepartamento(Request $request, $codigo = null)
    {
        $uniqueRule = $codigo 
            ? Rule::unique('departamento', 'dpto_codigo_postal')->ignore($codigo, 'dpto_codigo_postal')
            : 'unique:departamento,dpto_codigo_postal';

        return $request->validate([
            'dpto_nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/'
            ],
            'dpto_codigo_postal' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'min:2',
                'max:10',
                $uniqueRule
            ],
        ], [
            'dpto_nombre.required'        => 'El nombre del departamento es obligatorio.',
            'dpto_nombre.min'             => 'Debe tener mínimo 3 caracteres.',
            'dpto_nombre.max'             => 'No puede superar 100 caracteres.',
            'dpto_nombre.regex'           => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'dpto_codigo_postal.required' => 'El código postal es obligatorio.',
            'dpto_codigo_postal.regex'    => 'Solo se permiten números.',
            'dpto_codigo_postal.min'      => 'Debe tener mínimo 2 dígitos.',
            'dpto_codigo_postal.max'      => 'Máximo 10 dígitos.',
            'dpto_codigo_postal.unique'   => 'El código postal ya está registrado.'
        ]);
    }

    private function formatNombre($nombre)
    {
        return ucfirst(strtolower(trim($nombre)));
    }
}

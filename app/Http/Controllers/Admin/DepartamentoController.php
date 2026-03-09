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
    // LISTAR
    public function index()
    {
        $departamentos = Departamento::orderByRaw('CAST(dpto_codigo_postal AS UNSIGNED) ASC')
            ->paginate(10); // cantidad por página

        return view('admin.otros.departamento', compact('departamentos'));
    }

    // CREAR
    public function store(Request $request)
{
    $request->validate([
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
            'unique:departamento,dpto_codigo_postal'
        ],
    ], [
        'dpto_nombre.required' => 'El nombre del departamento es obligatorio.',
        'dpto_nombre.min' => 'Debe tener mínimo 3 caracteres.',
        'dpto_nombre.max' => 'No puede superar 100 caracteres.',
        'dpto_nombre.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
        'dpto_codigo_postal.required' => 'El código postal es obligatorio.',
        'dpto_codigo_postal.regex' => 'Solo se permiten números.',
        'dpto_codigo_postal.min' => 'Debe tener mínimo 2 dígitos.',
        'dpto_codigo_postal.max' => 'Máximo 10 dígitos.',
        'dpto_codigo_postal.unique' => 'El código postal ya está registrado.'
    ]);

    Departamento::create($request->all());

    return redirect()->back()->with('success', 'Departamento creado correctamente');
}
    // ACTUALIZAR
    public function update(Request $request, $codigo)
{
    $request->validate([
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
            Rule::unique('departamento', 'dpto_codigo_postal')
                ->ignore($codigo, 'dpto_codigo_postal')
        ],
    ], [
        'dpto_nombre.required' => 'El nombre del departamento es obligatorio.',
        'dpto_nombre.min' => 'Debe tener mínimo 3 caracteres.',
        'dpto_nombre.max' => 'No puede superar 100 caracteres.',
        'dpto_nombre.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
        'dpto_codigo_postal.required' => 'El código postal es obligatorio.',
        'dpto_codigo_postal.regex' => 'Solo se permiten números.',
        'dpto_codigo_postal.min' => 'Debe tener mínimo 2 dígitos.',
        'dpto_codigo_postal.max' => 'Máximo 10 dígitos.',
        'dpto_codigo_postal.unique' => 'El código postal ya está registrado.'
    ]);

    $departamento = Departamento::findOrFail($codigo);

    $departamento->update([
        'dpto_nombre' => $request->dpto_nombre,
        'dpto_codigo_postal' => $request->dpto_codigo_postal
    ]);

    return back()->with('success', 'Departamento actualizado correctamente');
}

    // ELIMINAR (con control FK)



    // EXPORTAR PDF
    public function exportPDF()
    {
        $departamentos = Departamento::all();

        $pdf = Pdf::loadView('admin.pdf.departamento_pdf', compact('departamentos'));

        return $pdf->download('departamentos.pdf');
    }

    // EXPORTAR EXCEL
    public function exportExcel()
    {
        return Excel::download(new DepartamentoExport, 'departamentos.xlsx');
    }

    public function checkCodigo(Request $request)
{
    $exists = Departamento::where('dpto_codigo_postal', $request->codigo)->exists();

    return response()->json([
        'exists' => $exists
    ]);
}
}

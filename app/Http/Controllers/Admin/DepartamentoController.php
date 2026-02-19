<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departamento;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::paginate(10);
        return view('admin.otros.departamento', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dpto_nombre' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
                'max:100',
                'unique:departamento,dpto_nombre'
            ],
            'dpto_codigo_postal' => [
                'required',
                'numeric',
                'digits_between:4,10',
                'unique:departamento,dpto_codigo_postal'
            ],
        ], [
            'dpto_nombre.required' => 'El nombre es obligatorio.',
            'dpto_nombre.regex' => 'El nombre solo puede contener letras.',
            'dpto_nombre.unique' => 'Ya existe un departamento con ese nombre.',
            'dpto_codigo_postal.required' => 'El código postal es obligatorio.',
            'dpto_codigo_postal.numeric' => 'El código postal solo puede contener números.',
            'dpto_codigo_postal.unique' => 'Ya existe un departamento con ese código postal.',
        ]);

        Departamento::create([
            'dpto_nombre' => ucfirst(strtolower($request->dpto_nombre)),
            'dpto_codigo_postal' => $request->dpto_codigo_postal
        ]);

        return redirect()->back()->with('success', 'Departamento creado correctamente.');
    }


    public function update(Request $request, $id)
{
    $request->validate([
        'dpto_nombre' => 'required|string|min:3|max:30',
        'dpto_codigo_postal' => 'required|string|min:4|max:10',
    ]);

    $departamento = Departamento::findOrFail($id);

    $departamento->update([
        'dpto_nombre' => $request->dpto_nombre,
        'dpto_codigo_postal' => $request->dpto_codigo_postal,
    ]);

    return redirect()
        ->route('admin.departamento.index')
        ->with('success', 'Departamento actualizado correctamente.');
}



    public function destroy($id)
    {
        Departamento::findOrFail($id)->delete();

        return back()->with('success', 'Departamento eliminado correctamente.');
    }
    
}

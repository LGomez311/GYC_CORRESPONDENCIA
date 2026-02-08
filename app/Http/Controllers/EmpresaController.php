<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        return view('sadmin.empresas', compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nit_empresa'    => 'required|unique:empresa,nit_empresa',
            'nomb_empresa'   => 'required',
            'direccion'      => 'required',
            'contacto'       => 'required',
            'empresa_correo' => 'required|email',
        ]);

        Empresa::create([
            'nit_empresa'    => $request->nit_empresa,
            'nomb_empresa'   => $request->nomb_empresa,
            'direccion'      => $request->direccion,
            'contacto'       => $request->contacto,
            'empresa_correo' => $request->empresa_correo,
        ]);

        return redirect()->route('empresas')
            ->with('success', 'Empresa creada correctamente');
    }

    public function update(Request $request, $nit)
    {
        $empresa = Empresa::where('nit_empresa', $nit)->firstOrFail();

        $empresa->update([
            'nomb_empresa'   => $request->nomb_empresa,
            'direccion'      => $request->direccion,
            'contacto'       => $request->contacto,
            'empresa_correo' => $request->empresa_correo,
        ]);

        return redirect()->route('empresas')
            ->with('success', 'Empresa actualizada');
    }

    public function destroy($nit)
    {
        Empresa::where('nit_empresa', $nit)->delete();

        return redirect()->route('empresas')
            ->with('success', 'Empresa eliminada');
    }
}

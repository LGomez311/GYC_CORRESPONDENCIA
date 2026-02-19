<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmpresasExport;
use App\Models\Plan;
use App\Models\Empleado;


class EmpresaController extends Controller
{
    /**
     * Listado de empresas
     */
    public function index()
    {
        $empresas = Empresa::paginate(5);

        return view('sadmin.empresas', compact('empresas'));
    }

    /**
     * Crear empresa
     */
    public function store(Request $request)
    {
        $request->validate([
            'nit_empresa' => [
                'required',
                'string',
                'max:25',
                'unique:empresa,nit_empresa',
            ],

            'nomb_empresa' => [
                'required',
                'string',
                'max:50',
            ],

            'doc_representante' => [
                'required',
                'numeric',
            ],

            'nomb_representante' => [
                'required',
                'string',
                'max:100',
            ],

            'direccion' => [
                'required',
                'string',
                'max:50',
            ],

            'contacto' => [
                'required',
                'string',
                'max:100',
            ],

            'empresa_correo' => [
                'required',
                'email',
                'max:100',
            ],
        ]);

        Empresa::create([
            'nit_empresa'         => $request->nit_empresa,
            'nomb_empresa'        => $request->nomb_empresa,
            'doc_representante'  => $request->doc_representante,
            'nomb_representante' => $request->nomb_representante,
            'direccion'           => $request->direccion,
            'contacto'            => $request->contacto,
            'empresa_correo'      => $request->empresa_correo,
        ]);

        return redirect()->back()->with('success', 'Empresa registrada correctamente');
    }


    /**
     * Actualizar empresa (incluye edición de NIT)
     */
public function update(Request $request, $nit)
{
    $empresa = Empresa::where('nit_empresa', $nit)->firstOrFail();

    $request->validate([
        'nit_empresa'         => 'required',
        'nomb_empresa'        => 'required|string|max:100',
        'direccion'           => 'required|string|max:150',
        'contacto'            => 'required|string|max:20',
        'empresa_correo'      => 'required|email|max:100',
        'doc_representante'   => 'required|string|max:20',
        'nomb_representante'  => 'required|string|max:100',
    ]);

    $empresa->update([
        'nit_empresa'        => $request->nit_empresa,
        'nomb_empresa'       => $request->nomb_empresa,
        'direccion'          => $request->direccion,
        'contacto'           => $request->contacto,
        'empresa_correo'     => $request->empresa_correo,
        'doc_representante'  => $request->doc_representante,
        'nomb_representante' => $request->nomb_representante,
    ]);

    return redirect()->back()->with('success', 'Empresa actualizada correctamente');
}


    /**
     * Eliminar empresa
     */
    public function destroy($nit)
    {
        Empresa::where('nit_empresa', $nit)->delete();

        return redirect()->route('empresas')
            ->with('success', 'Empresa eliminada correctamente');
    }

    // Exportar empresas a PDF y Excel

    public function exportPdf()
    {
        $empresas = Empresa::with([
            'representante.pagos.plan'
        ])->get();

        $pdf = Pdf::loadView('sadmin.exports.empresas_pdf', compact('empresas'));

        return $pdf->download('empresas_sistema.pdf');
    }


    public function exportExcel()
    {
        return Excel::download(new EmpresasExport, 'empresas_sistema.xlsx');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}

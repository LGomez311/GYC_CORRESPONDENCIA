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
        $empresas = Empresa::with([
            'representante.pagos.plan'
        ])->paginate(1);

        $empleados = Empleado::all(); // 👈 agregamos esto

        return view('sadmin.empresas', compact('empresas', 'empleados'));
    }



    /**
     * Crear empresa
     */
    public function store(Request $request)
    {
        $request->validate([
            'nit_empresa'      => 'required|unique:empresa,nit_empresa',
            'nomb_empresa'     => 'required|string|max:255',
            'direccion'        => 'required|string|max:255',
            'contacto'         => 'required|string|max:50',
            'empresa_correo'   => 'required|email|max:255',
            'id_representante' => 'required|exists:empleado,emple_doc',
        ]);


        Empresa::create([
            'nit_empresa'     => $request->nit_empresa,
            'nomb_empresa'    => $request->nomb_empresa,
            'direccion'       => $request->direccion,
            'contacto'        => $request->contacto,
            'empresa_correo'  => $request->empresa_correo,
            'id_representante' => $request->id_representante,
        ]);


        return redirect()->route('empresas')
            ->with('success', 'Empresa creada correctamente');
    }

    /**
     * Actualizar empresa (incluye edición de NIT)
     */
    public function update(Request $request, $nit)
    {
        // Buscar por NIT original (URL)
        $empresa = Empresa::where('nit_empresa', $nit)->firstOrFail();

        // Validación (permite mantener o cambiar el NIT)
        $request->validate([
            'nit_empresa'    => 'required|unique:empresa,nit_empresa,' . $empresa->nit_empresa . ',nit_empresa',
            'nomb_empresa'   => 'required|string|max:255',
            'direccion'      => 'required|string|max:255',
            'contacto'       => 'required|string|max:50',
            'empresa_correo' => 'required|email|max:255',
        ]);

        // Actualizar datos
        $empresa->update([
            'nit_empresa'    => $request->nit_empresa,
            'nomb_empresa'   => $request->nomb_empresa,
            'direccion'      => $request->direccion,
            'contacto'       => $request->contacto,
            'empresa_correo' => $request->empresa_correo,
        ]);

        return redirect()->route('empresas')
            ->with('success', 'Empresa actualizada correctamente');
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

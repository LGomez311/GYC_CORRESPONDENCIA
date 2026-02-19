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
use Illuminate\Validation\Rule;


class EmpresaController extends Controller
{

    // listado de empresas
    public function index()
    {
        $empresas = Empresa::paginate(5);
        return view('sadmin.empresas', compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'nit_empresa' => [
                'required',
                'digits_between:9,10',
                'regex:/^[0-9]+$/',
                'unique:empresa,nit_empresa',
            ],

            'nomb_empresa' => [
                'required',
                'min:3',
                'max:150',
            ],

            'doc_representante' => [
                'required',
                'digits_between:6,10',
                'regex:/^[0-9]+$/',
                'unique:empresa,doc_representante',
            ],

            'nomb_representante' => [
                'required',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\' ]+$/',
                function ($attribute, $value, $fail) {
                    $words = preg_split('/\s+/', trim($value));
                    if (count($words) < 2 || count($words) > 5) {
                        $fail('El nombre debe tener entre 2 y 5 palabras.');
                    }
                }
            ],

            'direccion' => [
                'nullable',
                'min:25',
                'max:150',
            ],

            'contacto' => [
                'nullable',
                'digits_between:7,12',
                'regex:/^[0-9]+$/',
            ],

            'empresa_correo' => [
                'required',
                'email',
                'max:150',
                'unique:empresa,empresa_correo',
            ],
        ]);

        Empresa::create($request->all());

        return redirect()->back()
            ->with('success', 'Empresa registrada correctamente');
            
    }


    /**
     * Actualizar empresa (incluye edición de NIT)
     */
    public function update(Request $request, $nit)
    {
        $empresa = Empresa::where('nit_empresa', $nit)->firstOrFail();

        $request->validate([

            'nit_empresa' => [
                'required',
                'digits_between:9,10',
                Rule::unique('empresa', 'nit_empresa')
                    ->ignore($empresa->nit_empresa, 'nit_empresa'),
            ],

            'nomb_empresa' => [
                'required',
                'min:3',
                'max:150',
            ],

            'direccion' => [
                'nullable',
                'min:25',
                'max:150',
            ],

            'contacto' => [
                'nullable',
                'digits_between:7,12',
            ],

            'empresa_correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('empresa', 'empresa_correo')
                    ->ignore($empresa->nit_empresa, 'nit_empresa'),
            ],

            'doc_representante' => [
                'required',
                'digits_between:6,10',
                Rule::unique('empresa', 'doc_representante')
                    ->ignore($empresa->nit_empresa, 'nit_empresa'),
            ],

            'nomb_representante' => [
                'required',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\' ]+$/',
                function ($attribute, $value, $fail) {
                    $words = preg_split('/\s+/', trim($value));
                    if (count($words) < 2 || count($words) > 5) {
                        $fail('El nombre debe tener entre 2 y 5 palabras.');
                    }
                }
            ],

        ]);

        $empresa->update($request->all());

        return redirect()->back()
            ->with('success', 'Empresa actualizada correctamente');
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
}

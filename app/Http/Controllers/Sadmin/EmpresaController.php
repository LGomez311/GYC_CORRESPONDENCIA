<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\AuditoriaEmpresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmpresasExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class EmpresaController extends Controller
{

    // listado de empresas
    /**
     * LISTADO DE EMPRESAS
     * Muestra todas las empresas registradas en el sistema con su historial de auditoría.
     */
    public function index()
    {

        $empresas = Empresa::paginate(5);
        $auditorias = AuditoriaEmpresa::with(['empresaAfectada', 'responsable'])
            ->orderBy('fecha_cambio', 'desc')
            ->get();

        return view('sadmin.empresas', compact('empresas', 'auditorias'));
    }

    /**
     * REGISTRAR NUEVA EMPRESA
     * Valida y crea una nueva entidad empresarial en el sistema.
     */
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

        ], [

            // NIT
            'nit_empresa.required' => '• El NIT es obligatorio.',
            'nit_empresa.digits_between' => '• El NIT debe tener entre 9 y 10 dígitos.',
            'nit_empresa.regex' => '• El NIT solo puede contener números.',
            'nit_empresa.unique' => '• Este NIT ya está registrado en el sistema.',

            // Nombre empresa
            'nomb_empresa.required' => '• El nombre de la empresa es obligatorio.',
            'nomb_empresa.min' => '• El nombre debe tener mínimo 3 caracteres.',
            'nomb_empresa.max' => '• El nombre no puede superar los 150 caracteres.',

            // Documento representante
            'doc_representante.required' => '• El documento del representante es obligatorio.',
            'doc_representante.digits_between' => '• El documento debe tener entre 6 y 10 dígitos.',
            'doc_representante.regex' => '• El documento solo puede contener números.',
            'doc_representante.unique' => '• Este documento ya está registrado en el sistema.',

            // Nombre representante
            'nomb_representante.required' => '• El nombre del representante es obligatorio.',
            'nomb_representante.max' => '• El nombre no puede superar los 100 caracteres.',
            'nomb_representante.regex' => '• El nombre solo puede contener letras y espacios.',

            // Dirección
            'direccion.min' => '• La dirección debe tener mínimo 25 caracteres.',
            'direccion.max' => '• La dirección no puede superar los 150 caracteres.',

            // Contacto
            'contacto.digits_between' => '• El contacto debe tener entre 7 y 12 dígitos.',
            'contacto.regex' => '• El contacto solo puede contener números.',

            // Correo
            'empresa_correo.required' => '• El correo empresarial es obligatorio.',
            'empresa_correo.email' => '• Debe ingresar un correo válido.',
            'empresa_correo.max' => '• El correo no puede superar los 150 caracteres.',
            'empresa_correo.unique' => '• Este correo ya está registrado en el sistema.',
        ]);

        Empresa::create($request->all());

        return redirect()->back()
            ->with('success', 'Empresa registrada correctamente');
    }

    /**
     * Actualizar empresa (incluye edición de NIT)
     */
    /**
     * ACTUALIZAR EMPRESA
     * Modifica los datos de una empresa existente, permitiendo el cambio de NIT solo si no tiene empleados.
     */
    public function update(Request $request, $nit)

    {
        $empresa = Empresa::where('nit_empresa', $nit)->firstOrFail();

        //  BLOQUEO DE CAMBIO DE NIT SI TIENE EMPLEADOS
        if (
            $empresa->empleados()->exists() &&
            $request->nit_empresa != $empresa->nit_empresa
        ) {
            return redirect()->back()
                ->withErrors([
                    'nit_empresa' => 'No puedes modificar el NIT porque la empresa ya tiene personas registradas.'
                ], 'update')
                ->withInput()
                ->with('edit_nit', $nit);
        }

        try {

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

            ], [

                // NIT
                'nit_empresa.required' => '• El NIT es obligatorio.',
                'nit_empresa.digits_between' => '• El NIT debe tener entre 9 y 10 dígitos.',
                'nit_empresa.unique' => '• Este NIT ya está registrado en el sistema.',

                // Nombre empresa
                'nomb_empresa.required' => '• El nombre de la empresa es obligatorio.',
                'nomb_empresa.min' => '• El nombre debe tener mínimo 3 caracteres.',
                'nomb_empresa.max' => '• El nombre no puede superar los 150 caracteres.',

                // Documento representante
                'doc_representante.required' => '• El documento del representante es obligatorio.',
                'doc_representante.digits_between' => '• El documento debe tener entre 6 y 10 dígitos.',
                'doc_representante.unique' => '• Este documento ya está registrado en el sistema.',

                // Nombre representante
                'nomb_representante.required' => '• El nombre del representante es obligatorio.',
                'nomb_representante.max' => '• El nombre no puede superar los 100 caracteres.',
                'nomb_representante.regex' => '• El nombre solo puede contener letras y espacios.',

                // Dirección
                'direccion.min' => '• La dirección debe tener mínimo 25 caracteres.',
                'direccion.max' => '• La dirección no puede superar los 150 caracteres.',

                // Contacto
                'contacto.digits_between' => '• El contacto debe tener entre 7 y 12 dígitos.',

                // Correo
                'empresa_correo.required' => '• El correo empresarial es obligatorio.',
                'empresa_correo.email' => '• Debe ingresar un correo válido.',
                'empresa_correo.max' => '• El correo no puede superar los 150 caracteres.',
                'empresa_correo.unique' => '• Este correo ya está registrado en el sistema.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->validator, 'update')
                ->withInput()
                ->with('edit_nit', $nit); // guardamos cuál se estaba editando
        }

        // Si NO tiene empleados, puede actualizar todo
        if (!$empresa->empleados()->exists()) {
            $empresa->fill($request->all());
        } else {
            // Si tiene empleados, nunca tocamos el NIT
            $empresa->fill($request->except('nit_empresa'));
        }

        $empresa->actualizado_por = Auth::user()->emple_doc;
        $empresa->save();

        return redirect()->back()
            ->with('success', 'Empresa actualizada correctamente');
    }


    // Exportar empresas a PDF y Excel

    /**
     * EXPORTAR EMPRESAS A PDF
     * Genera un reporte descargable con el listado completo de empresas registradas.
     */
    public function exportPdf()
    {
        $empresas = Empresa::orderBy('nomb_empresa')->get();

        $pdf = Pdf::loadView('sadmin.pdf.empresas_pdf', compact('empresas'));

        return $pdf->download('empresas_sistema.pdf');
    }


    public function exportExcel()
    {
        return Excel::download(new EmpresasExport, 'empresas_sistema.xlsx');
    }
}

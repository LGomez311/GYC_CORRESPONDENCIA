<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use SebastianBergmann\Timer\Timer;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminsExport;

class UsuarioController extends Controller
{
    public function index()
    {
        $users = Empleado::with(['empresa', 'estado', 'rol'])
            ->where('emple_rol', 2)
            ->whereHas('empresa')
            ->paginate(10);


        $empresas = \App\Models\Empresa::all();
        $estados = \App\Models\Estado::all();
        $estadoActivo = \App\Models\Estado::where('estado_nomb', 'Activo')->first();

        return view('sadmin.admins', compact('users', 'empresas', 'estados', 'estadoActivo'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'emple_doc' => [
                'required',
                'numeric',
                'digits_between:6,10',
                'regex:/^[0-9]+$/',
                'unique:empleado,emple_doc',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^(\d)\1+$/', $value)) {
                        $fail('No se permiten números repetidos como 000000 o 111111.');
                    }
                }
            ],

            'nit_empresa' => 'required|exists:empresa,nit_empresa',

            'emple_nombres' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\' ]+$/'
            ],

            'emple_apellidos' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\' ]+$/'
            ],

            'emple_tel' => [
                'nullable',
                'digits_between:7,12',
                'regex:/^[0-9]+$/'
            ],

            'emple_correo' => [
                'required',
                'email',
                'min:8',
                'max:150',
                'unique:empleado,emple_correo',
                'regex:/^\S+$/'
            ],

            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[!"#$%&\/()=@]/',
                'regex:/^\S+$/'
            ],

            'emple_img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:1024'
            ],

        ], [

            // DOCUMENTO
            'emple_doc.required' => 'El documento es obligatorio.',
            'emple_doc.numeric' => 'El documento solo puede contener números.',
            'emple_doc.digits_between' => 'El documento debe tener entre 6 y 10 dígitos.',
            'emple_doc.unique' => '• Este documento ya está registrado en el sistema.',
            'emple_doc.regex' => 'El documento solo puede contener números.',

            // EMPRESA
            'nit_empresa.required' => '• Debe seleccionar una empresa.',
            'nit_empresa.exists' => 'La empresa seleccionada no es válida.',

            // NOMBRES
            'emple_nombres.required' => 'El nombre es obligatorio.',
            'emple_nombres.regex' => 'El nombre solo puede contener letras.',
            'emple_nombres.max' => 'El nombre no puede superar los 50 caracteres.',

            // APELLIDOS
            'emple_apellidos.required' => 'El apellido es obligatorio.',
            'emple_apellidos.regex' => 'El apellido solo puede contener letras.',
            'emple_apellidos.max' => 'El apellido no puede superar los 50 caracteres.',

            // TELÉFONO
            'emple_tel.digits_between' => 'El teléfono debe tener entre 7 y 12 dígitos.',
            'emple_tel.regex' => 'El teléfono solo puede contener números.',

            // CORREO
            'emple_correo.required' => 'El correo electrónico es obligatorio.',
            'emple_correo.email' => 'El correo no tiene un formato válido.',
            'emple_correo.unique' => '• Este correo ya está registrado en el sistema.',
            'emple_correo.regex' => 'El correo no puede contener espacios.',

            // PASSWORD
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener mínimo 10 caracteres.',
            'password.regex' => 'La contraseña debe incluir mayúscula, minúscula, número y símbolo.',

            // IMAGEN
            'emple_img.image' => 'El archivo debe ser una imagen válida.',
            'emple_img.mimes' => 'La imagen debe ser jpg, jpeg, png o webp.',
            'emple_img.max' => 'La imagen no puede pesar más de 1MB.'

        ], [

            // Nombres amigables
            'emple_doc' => 'documento',
            'emple_nombres' => 'nombre',
            'emple_apellidos' => 'apellido',
            'emple_correo' => 'correo electrónico',
            'emple_tel' => 'teléfono',
            'password' => 'contraseña',
        ]);

        $empleado = new Empleado();
        $empleado->emple_doc = $request->emple_doc;
        $empleado->nit_empresa = $request->nit_empresa;
        $empleado->emple_nombres = $request->emple_nombres;
        $empleado->emple_apellidos = $request->emple_apellidos;
        $empleado->emple_tel = $request->emple_tel;
        $empleado->emple_correo = $request->emple_correo;
        $empleado->emple_estado = $request->emple_estado ?? 1;
        $empleado->emple_rol = $request->emple_rol ?? 2;
        $empleado->password = Hash::make($request->password);

        // Manejo de imagen
        if ($request->hasFile('emple_img')) {

            $image = $request->file('emple_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image->getRealPath());
            $img->cover(256, 256)->save($path);

            $empleado->emple_img = $filename;
        }

        $empleado->save();

        return redirect()->back()->with('success', 'Administrador creado correctamente');
    }

    public function update(Request $request, $emple_doc)
    {
        $empleado = Empleado::with(['estado', 'rol'])->findOrFail($emple_doc);

        $request->validate([

            'emple_doc' => [
                'required',
                'numeric',
                'digits_between:6,10',
                Rule::unique('empleado', 'emple_doc')
                    ->ignore($empleado->emple_doc, 'emple_doc'),
            ],

            'nit_empresa' => 'required|exists:empresa,nit_empresa',

            'emple_nombres' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\' ]+$/'
            ],

            'emple_apellidos' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\' ]+$/'
            ],

            'emple_tel' => [
                'nullable',
                'digits_between:7,12',
                'regex:/^[0-9]+$/'
            ],

            'emple_correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('empleado', 'emple_correo')
                    ->ignore($empleado->emple_doc, 'emple_doc'),
            ],

            'emple_estado' => 'required|exists:estado,id_estado',

        ], [

            // DOCUMENTO
            'emple_doc.required' => 'El documento es obligatorio.',
            'emple_doc.numeric' => 'El documento solo puede contener números.',
            'emple_doc.digits_between' => 'El documento debe tener entre 6 y 10 dígitos.',
            'emple_doc.unique' => '• Este documento ya está registrado en el sistema.',

            // EMPRESA
            'nit_empresa.required' => '• Debe seleccionar una empresa.',
            'nit_empresa.exists' => 'La empresa seleccionada no es válida.',

            // NOMBRES
            'emple_nombres.required' => 'El nombre es obligatorio.',
            'emple_nombres.regex' => 'El nombre solo puede contener letras.',
            'emple_nombres.max' => 'El nombre no puede superar los 50 caracteres.',

            // APELLIDOS
            'emple_apellidos.required' => 'El apellido es obligatorio.',
            'emple_apellidos.regex' => 'El apellido solo puede contener letras.',
            'emple_apellidos.max' => 'El apellido no puede superar los 50 caracteres.',

            // TELÉFONO
            'emple_tel.digits_between' => 'El teléfono debe tener entre 7 y 12 dígitos.',
            'emple_tel.regex' => 'El teléfono solo puede contener números.',

            // CORREO
            'emple_correo.required' => 'El correo electrónico es obligatorio.',
            'emple_correo.email' => 'El correo no tiene un formato válido.',
            'emple_correo.unique' => '• Este correo ya está registrado en el sistema.',

            // ESTADO
            'emple_estado.required' => '• Debe seleccionar un estado.',
            'emple_estado.exists' => 'El estado seleccionado no es válido.',

        ], [

            // Nombres amigables
            'emple_doc' => 'documento',
            'emple_nombres' => 'nombre',
            'emple_apellidos' => 'apellido',
            'emple_correo' => 'correo electrónico',
            'emple_tel' => 'teléfono',
        ]);

        $empleado->emple_doc = $request->emple_doc;
        $empleado->nit_empresa = $request->nit_empresa;
        $empleado->emple_nombres = $request->emple_nombres;
        $empleado->emple_apellidos = $request->emple_apellidos;
        $empleado->emple_tel = $request->emple_tel;
        $empleado->emple_correo = $request->emple_correo;
        $empleado->emple_estado = $request->emple_estado;

        // Manejo de imagen
        if ($request->hasFile('emple_img')) {
            if ($empleado->emple_img) Storage::delete('public/' . $empleado->emple_img);

            $image = $request->file('emple_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image->getRealPath());
            $img->cover(256, 256)->save($path);

            $empleado->emple_img = $filename;
        }

        $empleado->save();

        return redirect()->back()->with('success', 'Administrador actualizado correctamente');
    }

    public function exportPdf()
    {
        $admins = Empleado::with(['empresa', 'estado', 'rol'])
            ->where('emple_rol', 2)
            ->whereHas('empresa')
            ->get();

        $pdf = Pdf::loadView('sadmin.pdf.admins_pdf', compact('admins'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('administradores.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new AdminsExport, 'administradores.xlsx');
    }
}

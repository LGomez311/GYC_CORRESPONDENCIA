<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Remitente;
use App\Models\Rol;
use App\Models\Estado;
use App\Models\Area;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function index()
    {
        // Obtener el NIT de la empresa del admin logeado
        $nitEmpresa = Auth::user()->nit_empresa;

        // Traer Empleados de la empresa, filtrando los SuperAdmin (id_rol = 1)
        $empleados = Empleado::with(['rol', 'estado', 'area', 'empresa'])
            ->where('emple_rol', '!=', 1)
            ->where('nit_empresa', $nitEmpresa)
            ->get();
        
        // Traer Remitentes asociados a la misma empresa
        $remitentes = Remitente::with(['ciudad', 'empresa'])
            ->where('nit_empresa', $nitEmpresa)
            ->get();

        // Heurística para "nuevos" (ya que no existe created_at): usuarios sin correspondencia
        $empleadosNuevos = Empleado::where('nit_empresa', $nitEmpresa)
            ->where('emple_rol', '!=', 1)
            ->whereDoesntHave('enviosEnviados')
            ->whereDoesntHave('enviosRecibidos')
            ->count();

        $remitentesNuevos = Remitente::where('nit_empresa', $nitEmpresa)
            ->whereNotIn('rem_doc', function($query) {
                $query->select('doc_persona')->from('recibido')->whereNotNull('doc_persona');
            })
            ->count();

        // Calcular estadísticas para la empresa actual (excluyendo SuperAdmin)
        $stats = [
            'total' => $empleados->count() + $remitentes->count(),
            'activos' => $empleados->where('emple_estado', 1)->count() + $remitentes->where('rem_estado', 1)->count(),
            'inactivos' => $empleados->where('emple_estado', 2)->count() + $remitentes->where('rem_estado', 2)->count(),
            'nuevos' => $empleadosNuevos + $remitentesNuevos,
        ];

        // Catálogos para los modales
        $roles = Rol::where('id_rol', '!=', 1)->get(); // No permitir rol SuperAdmin (1)
        $estados = Estado::all();
        $areas = Area::all();
        $ciudades = Ciudad::all();

        return view('admin.usuarios', compact('empleados', 'remitentes', 'stats', 'roles', 'estados', 'areas', 'ciudades'));
    }

    public function storeEmpleado(Request $request)
    {
        $request->validate([
            'emple_doc' => [
                'required', 'numeric', 'digits_between:6,10', 'max:2147483647', 'regex:/^[0-9]+$/', 'unique:empleado,emple_doc',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^(\d)\1+$/', $value)) {
                        $fail('No se permiten números repetidos como 000000 o 111111.');
                    }
                }
            ],
            'emple_area' => 'required|exists:area,id_area',
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
                'required',
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
                'max:64',
                Password::min(10)->letters()->mixedCase()->numbers()->symbols()->uncompromised()
            ],
            'emple_img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:1024'
            ]
        ], [
            // DOCUMENTO
            'emple_doc.required' => '• El documento es obligatorio.',
            'emple_doc.numeric' => '• El documento solo puede contener números.',
            'emple_doc.digits_between' => '• El documento debe tener entre 6 y 10 dígitos.',
            'emple_doc.max' => '• El documento es demasiado largo (máx: 2147483647).',
            'emple_doc.unique' => '• Este documento ya está registrado en el sistema.',
            'emple_doc.regex' => '• El documento solo puede contener números.',

            // APLICACIÓN
            'emple_area.required' => '• El área es obligatoria.',
            'emple_area.exists' => '• El área seleccionada no es válida.',

            // NOMBRES
            'emple_nombres.required' => '• El nombre es obligatorio.',
            'emple_nombres.regex' => '• El nombre solo puede contener letras.',
            'emple_nombres.max' => '• El nombre no puede superar los 50 caracteres.',

            // APELLIDOS
            'emple_apellidos.required' => '• El apellido es obligatorio.',
            'emple_apellidos.regex' => '• El apellido solo puede contener letras.',
            'emple_apellidos.max' => '• El apellido no puede superar los 50 caracteres.',

            // TELÉFONO
            'emple_tel.required' => '• El teléfono es obligatorio.',
            'emple_tel.digits_between' => '• El teléfono debe tener entre 7 y 12 dígitos.',
            'emple_tel.regex' => '• El teléfono solo puede contener números.',

            // CORREO
            'emple_correo.required' => '• El correo electrónico es obligatorio.',
            'emple_correo.email' => '• El correo no tiene un formato válido.',
            'emple_correo.unique' => '• Este correo ya está registrado en el sistema.',
            'emple_correo.regex' => '• El correo no puede contener espacios.',

            // PASSWORD
            'password.required' => '• La contraseña es obligatoria.',
            'password.min' => '• La contraseña debe tener mínimo 10 caracteres.',
            'password' => '• La contraseña debe incluir mayúscula, minúscula, número y símbolo.',
            'password.max' => '• La contraseña no puede superar los 64 caracteres.',

            // IMAGEN
            'emple_img.image' => '• El archivo debe ser una imagen válida.',
            'emple_img.mimes' => '• La imagen debe ser jpg, jpeg, png o webp.',
            'emple_img.max' => '• La imagen no puede pesar más de 1MB.',
        ], [

            // Nombres amigables
            'emple_doc' => 'documento',
            'emple_nombres' => 'nombre',
            'emple_apellidos' => 'apellido',
            'emple_correo' => 'correo electrónico',
            'emple_tel' => 'teléfono',
            'password' => 'contraseña',
            'emple_area' => 'área',
        ]);

        $empleado = new Empleado();
        $empleado->emple_doc = $request->emple_doc;
        $empleado->nit_empresa = Auth::user()->nit_empresa;
        $empleado->emple_nombres = Str::title($request->emple_nombres);
        $empleado->emple_apellidos = Str::title($request->emple_apellidos);
        $empleado->emple_tel = $request->emple_tel;
        $empleado->emple_correo = $request->emple_correo;
        $empleado->emple_estado = $request->emple_estado ?? 1;
        $empleado->emple_rol = 3; // 3 = Empleado
        $empleado->emple_area = $request->emple_area;
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

        return redirect()->back()->with('success', 'Empleado creado correctamente');
    }

    public function updateEmpleado(Request $request, $emple_doc)
    {
        $empleado = Empleado::findOrFail($emple_doc);

        if ($request->emple_doc != $empleado->emple_doc) {
            abort(403, 'No se permite modificar el documento.');
        }

        if ($empleado->nit_empresa != Auth::user()->nit_empresa) {
            abort(403, 'No tienes permiso para editar este empleado.');
        }

        $request->validate([
            'emple_area' => 'required|exists:area,id_area',
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
                'required',
                'digits_between:7,12',
                'regex:/^[0-9]+$/'
            ],
            'emple_correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('empleado', 'emple_correo')->ignore($empleado->emple_doc, 'emple_doc'),
                'regex:/^\S+$/'
            ],
            'emple_estado' => 'required|exists:estado,id_estado',
        ], [
            'emple_area.required' => '• El área es obligatoria.',
            'emple_nombres.required' => '• El nombre es obligatorio.',
            'emple_nombres.regex' => '• El nombre solo puede contener letras.',
            'emple_nombres.max' => '• El nombre no puede superar los 50 caracteres.',
            'emple_apellidos.required' => '• El apellido es obligatorio.',
            'emple_apellidos.regex' => '• El apellido solo puede contener letras.',
            'emple_apellidos.max' => '• El apellido no puede superar los 50 caracteres.',
            'emple_tel.required' => '• El teléfono es obligatorio.',
            'emple_tel.digits_between' => '• El teléfono debe tener entre 7 y 12 dígitos.',
            'emple_tel.regex' => '• El teléfono solo puede contener números.',
            'emple_correo.required' => '• El correo electrónico es obligatorio.',
            'emple_correo.email' => '• El correo no tiene un formato válido.',
            'emple_correo.unique' => '• Este correo ya está registrado en el sistema.',
            'emple_estado.required' => '• Debe seleccionar un estado.',
            'emple_estado.exists' => '• El estado seleccionado no es válido.',
        ], [
            // Nombres amigables
            'emple_nombres' => 'nombre',
            'emple_apellidos' => 'apellido',
            'emple_correo' => 'correo electrónico',
            'emple_tel' => 'teléfono',
            'emple_area' => 'área',
            'emple_estado' => 'estado'
        ]);

        $empleado->emple_nombres = Str::title($request->emple_nombres);
        $empleado->emple_apellidos = Str::title($request->emple_apellidos);
        $empleado->emple_tel = $request->emple_tel;
        $empleado->emple_correo = $request->emple_correo;
        $empleado->emple_estado = $request->emple_estado;
        $empleado->emple_area = $request->emple_area;

        // Manejo de imagen
        if ($request->hasFile('emple_img')) {
            if ($empleado->emple_img) {
                Storage::disk('public')->delete($empleado->emple_img);
            }

            $image = $request->file('emple_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image->getRealPath());
            $img->cover(256, 256)->save($path);

            $empleado->emple_img = $filename;
        }

        $empleado->actualizado_por = Auth::user()->emple_doc;

        $empleado->save();

        return redirect()->back()->with('success', 'Empleado actualizado correctamente');
    }

    public function storeRemitente(Request $request)
    {
        $request->validate([
            'rem_doc' => [
                'required', 'numeric', 'digits_between:6,10', 'max:2147483647', 'regex:/^[0-9]+$/', 'unique:remitente,rem_doc',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^(\d)\1+$/', $value)) {
                        $fail('No se permiten números repetidos como 000000 o 111111.');
                    }
                }
            ],
            'rem_ciudad' => ['required', 'exists:ciudad,ciudad_cod_post'],
            'rem_nombres' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\' ]+$/'
            ],
            'rem_apellidos' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\' ]+$/'
            ],
            'rem_correo' => [
                'required',
                'email',
                'min:8',
                'max:150',
                'unique:remitente,rem_correo',
                'regex:/^\S+$/'
            ],
            'rem_tel' => [
                'required',
                'digits_between:7,12',
                'regex:/^[0-9]+$/'
            ],
            'password' => [
                'required',
                'string',
                'max:64',
                Password::min(10)->letters()->mixedCase()->numbers()->symbols()->uncompromised()
            ],
            'rem_img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:1024'
            ]
        ], [
            'rem_doc.required' => '• El documento es obligatorio.',
            'rem_doc.numeric' => '• El documento solo puede contener números.',
            'rem_doc.digits_between' => '• El documento debe tener entre 6 y 10 dígitos.',
            'rem_doc.max' => '• El documento es demasiado largo (máx: 2147483647).',
            'rem_doc.unique' => '• Este documento ya está registrado.',
            'rem_nombres.required' => '• El nombre es obligatorio.',
            'rem_apellidos.required' => '• El apellido es obligatorio.',
            'rem_correo.required' => '• El correo es obligatorio.',
            'rem_correo.unique' => '• Este correo ya está en uso.',
            'rem_tel.required' => '• El teléfono es obligatorio.',
            'rem_ciudad.required' => '• La ciudad es obligatoria.',
            'rem_ciudad.exists' => '• La ciudad es inválida.',
            'password.required' => '• La contraseña es obligatoria.',
            'password' => '• La contraseña debe incluir mayúscula, minúscula, número y símbolo.',
            'rem_img.image' => '• El archivo debe ser una imagen válida.',
            'rem_img.mimes' => '• La imagen debe ser jpg, jpeg, png o webp.',
            'rem_img.max' => '• La imagen no puede pesar más de 1MB.',
        ], [
            // Nombres amigables
            'rem_doc' => 'documento',
            'rem_nombres' => 'nombre',
            'rem_apellidos' => 'apellido',
            'rem_correo' => 'correo electrónico',
            'rem_tel' => 'teléfono',
            'rem_ciudad' => 'ciudad',
            'password' => 'contraseña',
        ]);

        $remitente = new Remitente();
        $remitente->rem_doc = $request->rem_doc;
        $remitente->rem_nombres = Str::title($request->rem_nombres);
        $remitente->rem_apellidos = Str::title($request->rem_apellidos);
        $remitente->rem_correo = $request->rem_correo;
        $remitente->rem_tel = $request->rem_tel;
        $remitente->rem_ciudad = $request->rem_ciudad;
        $remitente->nit_empresa = Auth::user()->nit_empresa;
        $remitente->rem_estado = $request->rem_estado ?? 1; // Asumiendo que 1 es activo
        $remitente->password = Hash::make($request->password);

        // Manejo de imagen
        try {
            if ($request->hasFile('rem_img')) {
                $image = $request->file('rem_img');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);

                $manager = new ImageManager(new Driver());
                $img = $manager->read($image->getRealPath());
                $img->cover(256, 256)->save($path);

                $remitente->rem_img = $filename;
            } else {
                $remitente->rem_img = '';
            }

            $remitente->save();
            return redirect()->back()->with('success', 'Remitente externo creado correctamente');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al crear el remitente: ' . $e->getMessage())->withInput();
        }
    }

    public function updateRemitente(Request $request, $rem_doc)
    {
        $remitente = Remitente::findOrFail($rem_doc);

        if ($request->rem_doc != $remitente->rem_doc) {
            abort(403, 'No se permite modificar el documento.');
        }

        if ($remitente->nit_empresa != Auth::user()->nit_empresa) {
            abort(403, 'No tienes permiso para editar este remitente.');
        }

        $request->validate([
            'rem_nombres' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\' ]+$/'
            ],
            'rem_apellidos' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\' ]+$/'
            ],
            'rem_ciudad' => [
                'required',
                'exists:ciudad,ciudad_cod_post'
            ],
            'rem_correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('remitente', 'rem_correo')->ignore($remitente->rem_doc, 'rem_doc'),
                'regex:/^\S+$/'
            ],
            'rem_tel' => [
                'required',
                'digits_between:7,12',
                'regex:/^[0-9]+$/'
            ],
            'rem_estado' => 'required',
            'rem_img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:1024'
            ]
        ], [
            // Mensajes amigables
            'rem_nombres.required' => '• El nombre es obligatorio.',
            'rem_nombres.regex' => '• El nombre solo puede contener letras.',
            'rem_nombres.max' => '• El nombre no puede superar los 50 caracteres.',

            'rem_apellidos.required' => '• El apellido es obligatorio.',
            'rem_apellidos.regex' => '• El apellido solo puede contener letras.',
            'rem_apellidos.max' => '• El apellido no puede superar los 50 caracteres.',

            'rem_correo.required' => '• El correo es obligatorio.',
            'rem_correo.email' => '• El correo no tiene un formato válido.',
            'rem_correo.unique' => '• Este correo ya está en uso.',
            'rem_correo.regex' => '• El correo no puede contener espacios.',

            'rem_tel.required' => '• El teléfono es obligatorio.',
            'rem_tel.digits_between' => '• El teléfono debe tener entre 7 y 12 dígitos.',
            'rem_tel.regex' => '• El teléfono solo puede contener números.',

            'rem_ciudad.required' => '• La ciudad es obligatoria.',
            'rem_ciudad.exists' => '• La ciudad es inválida.',
            'rem_img.image' => '• El archivo debe ser una imagen válida.',
            'rem_img.mimes' => '• La imagen debe ser jpg, jpeg, png o webp.',
            'rem_img.max' => '• La imagen no puede pesar más de 1MB.',
        ], [
            // Nombres amigables
            'rem_nombres' => 'nombre',
            'rem_apellidos' => 'apellido',
            'rem_correo' => 'correo electrónico',
            'rem_tel' => 'teléfono',
            'rem_ciudad' => 'ciudad',
            'rem_estado' => 'estado'
        ]);

        $remitente->rem_nombres = Str::title($request->rem_nombres);
        $remitente->rem_apellidos = Str::title($request->rem_apellidos);
        $remitente->rem_correo = $request->rem_correo;
        $remitente->rem_tel = $request->rem_tel;
        $remitente->rem_ciudad = $request->rem_ciudad;
        $remitente->rem_estado = $request->rem_estado;
        
        // Manejo de imagen
        try {
            if ($request->hasFile('rem_img')) {
                if ($remitente->rem_img) {
                    Storage::disk('public')->delete($remitente->rem_img);
                }

                $image = $request->file('rem_img');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);

                $manager = new ImageManager(new Driver());
                $img = $manager->read($image->getRealPath());
                $img->cover(256, 256)->save($path);

                $remitente->rem_img = $filename;
            }

            $remitente->save();
            return redirect()->back()->with('success', 'Remitente externo actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar: ' . $e->getMessage())->withInput();
        }
    }
}

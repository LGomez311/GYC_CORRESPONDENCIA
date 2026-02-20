<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Estado;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UsuarioController extends Controller
{
    public function index()
    {
        $users = Empleado::with(['rol'])
            ->where('emple_rol', 2)
            ->orderBy('emple_nombres')
            ->paginate(3);

        $estados = Estado::all();
        $empresas = Empresa::all();

        return view('sadmin.admins', compact('users', 'estados', 'empresas'));
    }


    public function store(Request $request)
    {
        $request->validate([

            // DOCUMENTO
            'emple_doc' => [
                'required',
                'digits_between:6,10',
                'regex:/^(?!^(\d)\1+$)\d+$/',
                'unique:empleado,emple_doc'
            ],

            // NOMBRES
            'emple_nombres' => [
                'required',
                'max:60',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:[\' ]?[A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,1}$/'
            ],

            // APELLIDOS
            'emple_apellidos' => [
                'required',
                'max:60',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:[\' ]?[A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,1}$/'
            ],

            // TELÉFONO
            'emple_tel' => [
                'nullable',
                'digits_between:7,12'
            ],

            // CORREO
            'emple_correo' => [
                'required',
                'email:rfc,dns',
                'min:8',
                'max:150',
                'unique:empleado,emple_correo'
            ],

            // CONTRASEÑA
            'password' => [
                'required',
                'min:10',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!\"#$%&\/()=@]).{10,}$/'
            ],

            // IMAGEN
            'emple_img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:1024',
                'dimensions:min_width=200,min_height=200,max_width=1024,max_height=1024,ratio=1/1'
            ],

            'nit_empresa' => 'required|exists:empresa,nit_empresa',

        ]);

        $data = $request->all();

        // Forzar rol y estado
        $data['emple_rol'] = 2;
        $data['emple_estado'] = 1;

        // Hash contraseña
        $data['password'] = Hash::make($request->password);

        // 🖼 Redimensionar imagen
        if ($request->hasFile('emple_img')) {

            $image = $request->file('emple_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            Image::make($image)
                ->fit(256, 256)
                ->save(storage_path('app/public/empleado/' . $filename));

            $data['emple_img'] = 'empleado/' . $filename;
        }

        Empleado::create($data);

        return back()->with('success', 'Administrador creado correctamente');
    }

    public function update(Request $request, $documento)
    {
        $empleado = Empleado::findOrFail($documento);

        $request->validate([

            'emple_nombres' => [
                'required',
                'max:60',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:[\' ]?[A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,1}$/'
            ],

            'emple_apellidos' => [
                'required',
                'max:60',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:[\' ]?[A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,1}$/'
            ],

            'emple_tel' => [
                'nullable',
                'digits_between:7,12'
            ],

            'emple_correo' => [
                'required',
                'email:rfc,dns',
                'min:8',
                'max:150',
                Rule::unique('empleado', 'emple_correo')
                    ->ignore($documento, 'emple_doc')
            ],

            'password' => [
                'nullable',
                'min:10',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!\"#$%&\/()=@]).{10,}$/'
            ],

            'emple_img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:1024',
                'dimensions:min_width=200,min_height=200,max_width=1024,max_height=1024,ratio=1/1'
            ],

            'nit_empresa' => 'required|exists:empresa,nit_empresa',
        ]);

        $data = $request->only([
            'emple_nombres',
            'emple_apellidos',
            'emple_tel',
            'emple_correo',
            'nit_empresa'
        ]);

        // 🔐 Password opcional
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 🖼 Imagen
        if ($request->hasFile('emple_img')) {

            if ($empleado->emple_img && Storage::disk('public')->exists($empleado->emple_img)) {
                Storage::disk('public')->delete($empleado->emple_img);
            }

            $image = $request->file('emple_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            Image::make($image)
                ->fit(256, 256)
                ->save(storage_path('app/public/empleado/' . $filename));

            $data['emple_img'] = 'empleado/' . $filename;
        }

        $empleado->update($data);

        return back()->with('success', 'Administrador actualizado correctamente');
    }

    public function destroy($emple_doc)
    {
        $user = Empleado::findOrFail($emple_doc);

        // Eliminar imagen si existe
        if ($user->emple_img && Storage::disk('public')->exists($user->emple_img)) {
            Storage::disk('public')->delete($user->emple_img);
        }

        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente');
    }



    public function exportExcel()
    {
        return Excel::download(new AdminsExport, 'admins_empresas.xlsx');
    }


    public function exportPdf()
    {
        $admins = Empleado::with(['empresa', 'estado', 'rol', 'area'])
            ->where('emple_rol', 2) // solo admins empresa si quieres
            ->get();

        $pdf = Pdf::loadView('sadmin.exports.admins_pdf', compact('admins'));

        return $pdf->download('admins_empresas.pdf');
    }
}

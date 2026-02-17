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

class UsuarioController extends Controller
{
    public function index()
    {
        $users = Empleado::with(['rol'])
            ->where('emple_rol', 2)
            ->orderBy('emple_nombres')
            ->paginate(1);

        $estados = Estado::all();
        $empresas = Empresa::all();

        return view('sadmin.admins', compact('users', 'estados', 'empresas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'emple_doc'       => 'nullable',
            'emple_nombres'   => 'nullable',
            'emple_apellidos' => 'nullable',
            'emple_tel'       => 'nullable',
            'emple_correo'    => 'nullable',
            'password'        => 'nullable',
            'emple_img'       => 'nullable',
            'nit_empresa'     => 'nullable',
            'emple_estado'    => 'nullable',
            'emple_rol'       => 'nullable',
            'emple_area'      => 'nullable',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('emple_img')) {
            $rutaImagen = $request->file('emple_img')
                ->store('empleado', 'public');
        }

        Empleado::create([
            'emple_doc'       => $request->emple_doc,
            'nit_empresa'     => $request->nit_empresa,
            'password'        => Hash::make($request->password),
            'emple_nombres'   => $request->emple_nombres,
            'emple_apellidos' => $request->emple_apellidos,
            'emple_tel'       => $request->emple_tel,
            'emple_correo'    => $request->emple_correo,
            'emple_img'       => $rutaImagen,
            'emple_estado'    => $request->emple_estado,
            'emple_rol'       => $request->emple_rol,
            'emple_area'      => $request->emple_area,
        ]);

        return redirect()->back()->with('success', 'Usuario registrado correctamente');
    }

    public function update(Request $request, $documento)
    {
        // 1. Validación primero
        $request->validate([
            'emple_nombres'   => 'required|string|max:100',
            'emple_apellidos' => 'required|string|max:100',
            'emple_tel'       => 'required|digits:10',
            'emple_correo'    => 'required|email|unique:empleado,emple_correo,' . $documento . ',emple_doc',
            'password'        => 'nullable|min:8',
            'emple_img'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'emple_estado'    => 'required|exists:estado,id_estado',
            'nit_empresa'     => 'required|exists:empresa,nit_empresa',
        ]);

        // 2. Buscar empleado
        $empleado = Empleado::findOrFail($documento);

        // 3. Datos a actualizar
        $data = [
            'emple_nombres'   => $request->emple_nombres,
            'emple_apellidos' => $request->emple_apellidos,
            'emple_tel'       => $request->emple_tel,
            'emple_correo'    => $request->emple_correo,
            'emple_estado'    => $request->emple_estado,
            'nit_empresa'     => $request->nit_empresa,
        ];

        // 4. Solo actualizar password si viene en el request
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 5. Foto de perfil
        if ($request->hasFile('emple_img')) {

            // Eliminar foto anterior si existe
            if ($empleado->emple_img && Storage::disk('public')->exists($empleado->emple_img)) {
                Storage::disk('public')->delete($empleado->emple_img);
            }

            // Guardar nueva foto
            $ruta = $request->file('emple_img')->store('empleado', 'public');

            $data['emple_img'] = $ruta;
        }

        // 6. Update
        $empleado->update($data);

        return redirect()->back()->with('success', 'Usuario actualizado correctamente');
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use App\Exports\RolesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RolController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $firstTwoIds = Rol::orderBy('id_rol')->limit(2)->pluck('id_rol');
        $roles = Rol::whereNotIn('id_rol', $firstTwoIds)
                    ->when($search, function ($query, $search) {
                        return $query->where('rol_nom', 'like', '%' . $search . '%');
                    })
                    ->paginate(10);
        return view('admin.otros.rol', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rol_nom' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:rol,rol_nom'
            ]
        ], [
            'rol_nom.required' => 'El nombre del rol es obligatorio.',
            'rol_nom.min' => 'Debe tener mínimo 3 caracteres.',
            'rol_nom.max' => 'No puede superar 100 caracteres.',
            'rol_nom.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'rol_nom.unique' => 'Este rol ya existe.'
        ]);

        $validated['rol_nom'] = ucfirst(strtolower(trim($validated['rol_nom'])));

        Rol::create($validated);

        return redirect()->back()->with('success', 'Rol creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rol_nom' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:rol,rol_nom,' . $id . ',id_rol'
            ]
        ], [
            'rol_nom.required' => 'El nombre del rol es obligatorio.',
            'rol_nom.min' => 'Debe tener mínimo 3 caracteres.',
            'rol_nom.max' => 'No puede superar 100 caracteres.',
            'rol_nom.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'rol_nom.unique' => 'Este rol ya existe.'
        ]);

        $r = Rol::findOrFail($id);
        $r->update(['rol_nom' => $request->rol_nom]);

        return redirect()->route('admin.rol.index')->with('success', 'Rol actualizado correctamente');
    }



    public function exportExcel()
    {
        return Excel::download(new RolesExport, 'roles.xlsx');
    }

    public function exportPdf()
    {
        $firstTwoIds = Rol::orderBy('id_rol')->limit(2)->pluck('id_rol');
        $roles = Rol::whereNotIn('id_rol', $firstTwoIds)->get();
        $pdf = Pdf::loadView('admin.pdf.rol_pdf', compact('roles'));
        return $pdf->download('roles.pdf');
    }

    public function check(Request $request)
    {
        $nombre = $request->query('nombre');
        $actual = $request->query('actual');

        $exists = Rol::where('rol_nom', $nombre)
            ->when($actual, function ($q) use ($actual) {
                return $q->where('rol_nom', '!=', $actual);
            })->exists();

        return response()->json(['exists' => $exists]);
    }
}

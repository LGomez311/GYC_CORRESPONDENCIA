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
    public function index()
    {
        $roles = Rol::paginate(10);
        return view('admin.otros.rol', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rol_nom' => 'required|string|min:2|max:100|unique:rol,rol_nom'
        ], [
            'rol_nom.required' => 'El nombre del rol es obligatorio.'
        ]);

        $validated['rol_nom'] = ucfirst(strtolower(trim($validated['rol_nom'])));

        Rol::create($validated);

        return redirect()->back()->with('success', 'Rol creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rol_nom' => 'required|string|max:100'
        ]);

        $r = Rol::findOrFail($id);
        $r->update(['rol_nom' => $request->rol_nom]);

        return redirect()->route('admin.rol.index')->with('success', 'Rol actualizado correctamente');
    }

    public function destroy($id)
    {
        $r = Rol::findOrFail($id);
        $r->delete();
        return redirect()->route('admin.rol.index')->with('success', 'Rol eliminada correctamente');
    }

    public function exportExcel()
    {
        return Excel::download(new RolesExport, 'roles.xlsx');
    }

    public function exportPdf()
    {
        $roles = Rol::all();
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

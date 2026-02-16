<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    /**
     * Listado de empresas
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('sadmin.empresas', compact('empresas'));
    }

    /**
     * Crear empresa
     */
    public function store(Request $request)
    {
        $request->validate([
            'nit_empresa'    => 'required|unique:empresa,nit_empresa',
            'nomb_empresa'   => 'required|string|max:255',
            'direccion'      => 'required|string|max:255',
            'contacto'       => 'required|string|max:50',
            'empresa_correo' => 'required|email|max:255',
        ]);

        Empresa::create([
            'nit_empresa'    => $request->nit_empresa,
            'nomb_empresa'   => $request->nomb_empresa,
            'direccion'      => $request->direccion,
            'contacto'       => $request->contacto,
            'empresa_correo' => $request->empresa_correo,
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

    /**
 * Exportar empresas a CSV
 */
public function exportCsv()
{
    $empresas = Empresa::orderBy('nomb_empresa')->get();

    $filename = "empresas_" . now()->format('Ymd_His') . ".csv";

    $headers = [
        "Content-Type" => "text/csv; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=\"$filename\"",
    ];

    $callback = function () use ($empresas) {

        $file = fopen('php://output', 'w');

        // 👇 Esto evita problemas de tildes en Excel
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

        // Encabezados
        fputcsv($file, [
            'Empresa',
            'NIT',
            'Dirección',
            'Teléfono',
            'Correo',
        ]);

        foreach ($empresas as $empresa) {
            fputcsv($file, [
                $empresa->nomb_empresa,
                $empresa->nit_empresa,
                $empresa->direccion,
                $empresa->contacto,
                $empresa->empresa_correo,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

}

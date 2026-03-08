<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Radicado;
use App\Models\Estado;
use Illuminate\Http\Request;
use App\Exports\RadicadoExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RadicadoController extends Controller
{
    public function index()
    {
        $radicados = Radicado::with('estado')->paginate(5);
        $estados = Estado::where('id_estado', '>=', 1)->get(); // Filtrar estados según necesidad
        return view('admin.otros.radicado', compact('radicados', 'estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'num_radicado' => [
                'required',
                'string',
                'min:10',
                'max:18',
                'unique:radicados,num_radicado',
                'regex:/^20[2-9][0-9][0-9]{6,14}$/'
            ],
            'id_est_radicado' => 'required|exists:estado,id_estado'
        ], [
            'num_radicado.required' => 'El número de radicado es obligatorio.',
            'num_radicado.unique' => 'Este número de radicado ya existe.',
            'num_radicado.min' => 'El radicado debe tener al menos 10 dígitos.',
            'num_radicado.max' => 'El radicado no puede superar los 18 dígitos.',
            'num_radicado.regex' => 'Formato inválido. Debe ser numérico y comenzar con el año (ej: 2026...).',
            'id_est_radicado.required' => 'El estado es obligatorio.',
            'id_est_radicado.exists' => 'El estado seleccionado no es válido.'
        ]);

        Radicado::create($validated);

        return redirect()->back()->with('success', 'Radicado creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'num_radicado' => [
                'required',
                'string',
                'min:10',
                'max:18',
                'unique:radicados,num_radicado,' . $id . ',id_radicado',
                'regex:/^20[2-9][0-9][0-9]{6,14}$/'
            ],
            'id_est_radicado' => 'required|exists:estado,id_estado'
        ], [
            'num_radicado.required' => 'El número de radicado es obligatorio.',
            'num_radicado.unique' => 'Este número de radicado ya existe.',
            'num_radicado.min' => 'El radicado debe tener al menos 10 dígitos.',
            'num_radicado.max' => 'El radicado no puede superar los 18 dígitos.',
            'num_radicado.regex' => 'Formato inválido. Debe ser numérico y comenzar con el año (ej: 2026...).',
            'id_est_radicado.required' => 'El estado es obligatorio.',
            'id_est_radicado.exists' => 'El estado seleccionado no es válido.'
        ]);

        $radicado = Radicado::findOrFail($id);
        $radicado->update($validated);

        return redirect()->back()->with('success', 'Radicado actualizado correctamente.');
    }



    public function check(Request $request)
    {
        $numero = $request->query('numero');
        $id = $request->query('id');

        $exists = Radicado::where('num_radicado', $numero)
            ->when($id, function ($q) use ($id) {
                return $q->where('id_radicado', '!=', $id);
            })->exists();

        return response()->json(['exists' => $exists]);
    }

    public function exportExcel()
    {
        return Excel::download(new RadicadoExport, 'radicados.xlsx');
    }

    public function exportPdf()
    {
        $radicados = Radicado::with('estado')->get();
        $pdf = Pdf::loadView('admin.pdf.radicado_pdf', compact('radicados'));
        return $pdf->download('radicados.pdf');
    }
}

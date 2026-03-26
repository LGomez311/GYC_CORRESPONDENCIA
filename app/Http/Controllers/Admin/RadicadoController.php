<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Radicado;
use Illuminate\Http\Request;
use App\Exports\RadicadoExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RadicadoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $radicados = Radicado::when($search, function ($query, $search) {
                        return $query->where('num_radicado', 'like', '%' . $search . '%');
                    })
                    ->paginate(10);
        return view('admin.otros.radicado', compact('radicados'));
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
            ]
        ], [
            'num_radicado.required' => 'El número de radicado es obligatorio.',
            'num_radicado.unique' => 'Este número de radicado ya existe.',
            'num_radicado.min' => 'El radicado debe tener al menos 10 dígitos.',
            'num_radicado.max' => 'El radicado no puede superar los 18 dígitos.',
            'num_radicado.regex' => 'Formato inválido. Debe ser numérico y comenzar con el año (ej: 2026...).'
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
            ]
        ], [
            'num_radicado.required' => 'El número de radicado es obligatorio.',
            'num_radicado.unique' => 'Este número de radicado ya existe.',
            'num_radicado.min' => 'El radicado debe tener al menos 10 dígitos.',
            'num_radicado.max' => 'El radicado no puede superar los 18 dígitos.',
            'num_radicado.regex' => 'Formato inválido. Debe ser numérico y comenzar con el año (ej: 2026...).'
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
        $radicados = Radicado::get();
        $pdf = Pdf::loadView('admin.pdf.radicado_pdf', compact('radicados'));
        return $pdf->download('radicados.pdf');
    }
}

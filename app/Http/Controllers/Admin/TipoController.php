<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tipo;
use App\Models\Prioridad;
use Illuminate\Http\Request;
use App\Exports\TiposExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TipoController extends Controller
{
    public function index()
    {
        $tipos = Tipo::with('prioridad')->paginate(10);
        $prioridades = Prioridad::all();
        return view('admin.otros.tipo', compact('tipos', 'prioridades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:tipo,tipo_nombre'
            ],
            'id_prioridad'      => 'required|integer|exists:prioridad,id_prioridad',
            'dias_respuesta'    => 'required|integer|min:1',
            'requiere_respuesta'=> 'required|boolean',
        ], [
            'tipo_nombre.required' => 'El nombre del tipo es obligatorio.',
            'tipo_nombre.min' => 'Debe tener mínimo 3 caracteres.',
            'tipo_nombre.max' => 'No puede superar 100 caracteres.',
            'tipo_nombre.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'tipo_nombre.unique' => 'Este tipo ya existe.',
            'id_prioridad.required' => 'Seleccione una prioridad.',
            'id_prioridad.exists' => 'La prioridad seleccionada no es válida.',
            'dias_respuesta.required' => 'Debe indicar los días hábiles de respuesta.',
            'dias_respuesta.min' => 'Los días de respuesta deben ser al menos 1.',
            'requiere_respuesta.required' => 'Debe indicar si el tipo requiere respuesta.',
        ]);

        $validated['tipo_nombre'] = ucfirst(strtolower(trim($validated['tipo_nombre'])));
        $validated['requiere_respuesta'] = $request->boolean('requiere_respuesta') ? 1 : 0;

        Tipo::create($validated);

        return redirect()->back()->with('success', 'Tipo creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{3}[A-Za-zÁÉÍÓÚáéíóúÑñ ]*$/',
                'unique:tipo,tipo_nombre,' . $id . ',id_tipo'
            ],
            'id_prioridad'       => 'required|integer|exists:prioridad,id_prioridad',
            'dias_respuesta'     => 'required|integer|min:1',
            'requiere_respuesta' => 'required|boolean',
        ], [
            'tipo_nombre.required' => 'El nombre del tipo es obligatorio.',
            'tipo_nombre.min' => 'Debe tener mínimo 3 caracteres.',
            'tipo_nombre.max' => 'No puede superar 100 caracteres.',
            'tipo_nombre.regex' => 'Debe iniciar con al menos 3 letras continuas sin espacios.',
            'tipo_nombre.unique' => 'Este tipo ya existe.',
            'id_prioridad.required' => 'Seleccione una prioridad.',
            'id_prioridad.exists' => 'La prioridad seleccionada no es válida.',
            'dias_respuesta.required' => 'Debe indicar los días hábiles de respuesta.',
            'dias_respuesta.min' => 'Los días de respuesta deben ser al menos 1.',
            'requiere_respuesta.required' => 'Debe indicar si el tipo requiere respuesta.',
        ]);

        $t = Tipo::findOrFail($id);
        $t->update([
            'tipo_nombre'        => $request->tipo_nombre,
            'id_prioridad'       => $request->id_prioridad,
            'dias_respuesta'     => $request->dias_respuesta,
            'requiere_respuesta' => $request->boolean('requiere_respuesta') ? 1 : 0,
        ]);

        return redirect()->route('admin.tipo.index')->with('success', 'Tipo actualizado correctamente');
    }



    public function exportExcel()
    {
        return Excel::download(new TiposExport, 'tipos.xlsx');
    }

    public function exportPdf()
    {
        $tipos = Tipo::with('prioridad')->get();
        $pdf = Pdf::loadView('admin.pdf.tipo_pdf', compact('tipos'));
        return $pdf->download('tipos.pdf');
    }

    public function check(Request $request)
    {
        $nombre = $request->query('nombre');
        $actual = $request->query('actual');

        $exists = Tipo::where('tipo_nombre', $nombre)
            ->when($actual, function ($q) use ($actual) {
                return $q->where('tipo_nombre', '!=', $actual);
            })->exists();

        return response()->json(['exists' => $exists]);
    }
}

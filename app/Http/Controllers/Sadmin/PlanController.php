<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanesExport;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $planes = Plan::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nomb_plan', 'LIKE', "%{$search}%");
            })
            ->orderBy('id_plan', 'asc')
            ->paginate(3)
            ->withQueryString();

        return view('sadmin.cplanes', compact('planes'));
    }


    public function store(Request $request)
    {
        try {


            $request->merge([
                'valor'    => preg_replace('/\D/', '', $request->valor),
                'duracion' => preg_replace('/\D/', '', $request->duracion),
            ]);

            $request->validate([
                'nomb_plan'   => 'nullable',
                'valor'       => 'nullable',
                'duracion'    => 'nullable',
                'descripcion' => 'required|array|min:1',
                'descripcion.*' => 'required|string|max:255',
            ]);

            if ($request->boolean('es_destacado')) {
                Plan::where('es_destacado', true)->update(['es_destacado' => false]);
            }



            Plan::create([
                'nomb_plan'    => $request->nomb_plan,
                'valor'        => (int) $request->valor,
                'duracion'     => (int) $request->duracion,
                'descripcion'  => $request->descripcion,
                'es_destacado' => $request->boolean('es_destacado'),
            ]);

            return redirect()
                ->route('cplanes')
                ->with('success', 'Plan creado correctamente');
        } catch (ValidationException $e) {
            // Retornar con errores en forma de alert
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Hubo errores en el formulario');
        }
    }


    public function update(Request $request, $id)
    {

        $request->merge([
            'valor'    => preg_replace('/\D/', '', $request->valor),
            'duracion' => preg_replace('/\D/', '', $request->duracion),
        ]);

        $request->validate([
            'nomb_plan' => 'required|string|max:50',
            'valor' => 'nullable',
            'duracion' => 'nullable',
            'descripcion' => 'required|array|min:1',
            'descripcion.*' => 'required|string|max:255',
        ]);

        $plan = Plan::findOrFail($id);

        $plan->update([
            'nomb_plan'    => $request->nomb_plan,
            'valor'        => (int) $request->valor,
            'duracion'     => (int) $request->duracion,
            // 👇 AQUÍ ESTÁ LA CLAVE
            'descripcion'  => array_values($request->descripcion),
            'es_destacado' => $request->has('es_destacado'),
        ]);

        return redirect()->back()->with('success', 'Plan actualizado correctamente');
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()
            ->route('cplanes')
            ->with('success', 'Plan eliminado correctamente');
    }

    public function exportPdf()
    {
        $planes = Plan::all();

        $pdf = Pdf::loadView('sadmin.pdf.planes_pdf', compact('planes'));

        return $pdf->download('planes_sistema.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PlanesExport, 'planes_sistema.xlsx');
    }
}

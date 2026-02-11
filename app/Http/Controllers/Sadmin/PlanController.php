<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $planes = Plan::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nomb_plan', 'LIKE', "%{$search}%");
            })
            ->orderBy('id_plan', 'asc')
            ->paginate(4)
            ->withQueryString();

        return view('sadmin.cplanes', compact('planes'));
    }




    public function store(Request $request)
    {
        try {
            $request->validate([
                'nomb_plan'   => 'nullable',
                'valor'       => 'nullable',
                'descripcion' => 'nullable',
                'duracion'    => 'nullable',
            ]);

            Plan::create([
                'nomb_plan'   => $request->nomb_plan,
                'valor'       => $request->valor,
                'descripcion' => $request->descripcion,
                'duracion'    => $request->duracion,
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
        $request->validate([
            'nomb_plan'   => 'nullable',
            'valor'       => 'nullable',
            'descripcion' => 'nullable',
            'duracion'    => 'nullable',
        ]);

        $plan = Plan::findOrFail($id);

        $plan->update([
            'nomb_plan'   => $request->nomb_plan,
            'valor'       => $request->valor,
            'descripcion' => $request->descripcion,
            'duracion'    => $request->duracion,
        ]);

        return redirect()->route('cplanes')->with('success', 'Plan actualizado correectamente');
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()
            ->route('cplanes')
            ->with('success', 'Plan eliminado correctamente');
    }
}

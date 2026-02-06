<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $planes = Plan::orderBy('id_plan', 'desc')->get();
        return view('sadmin.cplanes', compact('planes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomb_plan'   => 'required|string|max:150',
            'valor'       => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:255',
            'duracion'    => 'required|integer|min:1',
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
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomb_plan'   => 'required|string|max:150',
            'valor'       => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:255',
            'duracion'    => 'required|integer|min:1',
        ]);

        $plan = Plan::findOrFail($id);

        $plan->update([
            'nomb_plan'   => $request->nomb_plan,
            'valor'       => $request->valor,
            'descripcion' => $request->descripcion,
            'duracion'    => $request->duracion,
        ]);

        return redirect()
            ->route('cplanes')
            ->with('success', 'Plan actualizado correctamente');
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

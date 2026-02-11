<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // ================= LISTAR =================
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

    // ================= CREAR =================
    public function store(Request $request)
{
    $request->validate(
        [
            'nomb_plan'   => ['required', 'string', 'min:3', 'max:100'],
            'valor'       => 'required|numeric|min:1',
            'duracion'    => 'required|integer|min:1',
            'descripcion' => 'required|string|max:255',
        ],
        [
            'nomb_plan.required'   => 'El nombre del plan es obligatorio',
            'nomb_plan.min'        => 'El nombre debe tener al menos 3 caracteres',
            'valor.required'       => 'El valor del plan es obligatorio',
            'valor.numeric'        => 'El valor debe ser numérico',
            'valor.min'            => 'El valor debe ser mayor a 0',
            'duracion.required'    => 'La duración es obligatoria',
            'duracion.integer'     => 'La duración debe ser un número entero',
            'duracion.min'         => 'La duración debe ser mayor a 0',
            'descripcion.required' => 'La descripción no puede estar vacía',
        ]
    );

    Plan::create($request->only([
        'nomb_plan',
        'valor',
        'duracion',
        'descripcion'
    ]));

    return redirect()
        ->route('cplanes')
        ->with('success', 'Plan creado correctamente');
}


    // ================= ACTUALIZAR =================
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nomb_plan'   => 'required|string|min:3|max:100',
                'valor'       => 'required|numeric|min:1',
                'duracion'    => 'required|integer|min:1',
                'descripcion' => 'required|string|max:255',
            ],
            [
                'nomb_plan.required'   => 'El nombre del plan es obligatorio',
                'nomb_plan.min'        => 'El nombre debe tener al menos 3 caracteres',
                'valor.required'       => 'El valor del plan es obligatorio',
                'valor.numeric'        => 'El valor debe ser numérico',
                'valor.min'            => 'El valor debe ser mayor a 0',
                'duracion.required'    => 'La duración es obligatoria',
                'duracion.integer'     => 'La duración debe ser un número entero',
                'duracion.min'         => 'La duración debe ser mayor a 0',
                'descripcion.required' => 'La descripción no puede estar vacía y debe al menos 5 caracteres',
            ]
        );

        $plan = Plan::findOrFail($id);

        $plan->update($request->only([
            'nomb_plan',
            'valor',
            'duracion',
            'descripcion'
        ]));

        return redirect()
            ->route('cplanes')
            ->with('success', 'Plan actualizado correctamente');
    }

    // ================= ELIMINAR =================
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()
            ->route('cplanes')
            ->with('success', 'Plan eliminado correctamente');
    }
}

<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Licencia;

class LicenciaController extends Controller
{
    public function index()
    {
        $licencias = Licencia::with([
                'estado',
                'pago.plan',
                'pago.admin.empresa'
            ])
            ->orderBy('fecha_inicio', 'asc')
            ->paginate(5); 

        return view('sadmin.licencias', compact('licencias'));
    }

    public function toggle($id)
    {
        $licencia = Licencia::findOrFail($id);

        $licencia->id_estado = $licencia->id_estado == 1 ? 2 : 1;
        $licencia->save();

        return back()->with('success', 'Estado de la licencia actualizado correctamente.');
    }
}

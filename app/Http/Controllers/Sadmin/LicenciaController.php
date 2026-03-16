<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Licencia;
use App\Models\AuditoriaLicencia;
use App\Models\Estado;
use Illuminate\Support\Facades\Auth;

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
            ->paginate(4); 

        // Historial de auditoría
        $auditorias = AuditoriaLicencia::with(['licenciaAfectada', 'responsable'])
            ->orderBy('fecha_cambio', 'desc')
            ->get();

        // Estados para el modal de auditoría
        $estados = Estado::all();

        return view('sadmin.licencias', compact('licencias', 'auditorias', 'estados'));
    }

    public function toggle($id)
    {
        $licencia = Licencia::findOrFail($id);

        $licencia->id_estado = $licencia->id_estado == 1 ? 2 : 1;
        $licencia->actualizado_por = Auth::user()->emple_doc;
        $licencia->save();

        return back()->with('success', 'Estado de la licencia actualizado correctamente.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Pago;
use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    public function index(Plan $plan)
    {
        return view('admin.pagos', compact('plan'));
    }

    public function historial()
    {
        $user = Auth::user();

        $pagos = Pago::with(['plan', 'estado', 'admin'])
            ->where('nit_empresa', $user->nit_empresa)
            ->orderBy('fecha_pago', 'desc')
            ->paginate(10); // increased for better experience

        return view('admin.historialp', compact('pagos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_plan'     => 'required|exists:plan,id_plan',
            'fecha_inicio'  => 'nullable|date|after_or_equal:today',
            'comprobante' => 'nullable|image|max:2048',
        ]);

        $plan = Plan::findOrFail($request->id_plan);
        $user = Auth::user();

        // Guardar comprobante
        $rutaComprobante = null;
        if ($request->hasFile('comprobante')) {
            $rutaComprobante = $request->file('comprobante')
                ->store('comprobantes', 'public');
        }

        // Crear pago
        Pago::create([
            'id_plan'       => $plan->id_plan,
            'monto'         => $plan->valor,
            'comprobante'   => $rutaComprobante,
            'moneda'        => 'COP',
            'nit_empresa'   => $user->nit_empresa,
            'id_est_pago'   => 0, // 0 = Pendiente (Estado inicial)
            'id_admin'      => $user->emple_doc,
            'fecha_pago'    => Carbon::now('America/Bogota'),
            'fecha_inicio'  => $request->fecha_inicio,
        ]);

        return redirect()
            ->route('admin.historialp')
            ->with('success', 'Pago notificado correctamente. En espera de aprobación.');
    }
}

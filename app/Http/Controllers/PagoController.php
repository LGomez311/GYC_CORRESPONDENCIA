<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Pago;
use App\Models\Empresa;
use Carbon\Carbon;


class PagoController extends Controller
{
    public function index(Plan $plan)
    {
        return view('admin.pagos', compact('plan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:planes,id',
            'comprobante' => 'nullable|image|max:2048',
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        // 🔹 Obtener automáticamente el NIT de la única empresa
        $empresa = Empresa::first(); // SOLO HAY UNA

        // 🔹 Guardar comprobante si existe
        $rutaComprobante = null;
        if ($request->hasFile('comprobante')) {
            $rutaComprobante = $request->file('comprobante')
                ->store('comprobantes', 'public');
        }

        // 🔹 Crear pago
        Pago::create([
            'id_plan'     => $plan->id,
            'monto'       => $plan->valor,
            'comprobante' => $rutaComprobante,
            'moneda'      => 'COP',
            'nit_empresa' => $empresa->nit,
            'id_est_pago' => 0, // EN ESPERA
            'fecha_pago'  => Carbon::now(),
        ]);

        return back()->with('success', 'Pago notificado correctamente. En espera de aprobación.');
    }
}

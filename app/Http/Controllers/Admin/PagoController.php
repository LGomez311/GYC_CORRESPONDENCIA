<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Pago;
use App\Models\Empresa;


class PagoController extends Controller
{
    public function index(Plan $plan)
    {
        return view('admin.pagos', compact('plan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_plan' => '',
            'comprobante' => 'nullable|image|max:2048',
        ]);

        $id_plan = Plan::findOrFail($request->id_plan);

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
            'id_plan'     => $id_plan->id_plan,
            'monto'       => $id_plan->valor,
            'comprobante' => $rutaComprobante,
            'moneda'      => 'COP',
            'nit_empresa' => $empresa->nit,
            'id_est_pago' => 0, // EN ESPERA
            'fecha_pago'  => now(),
        ]);

        return back()->with('success', 'Pago notificado correctamente. En espera de aprobación.');
    }
}

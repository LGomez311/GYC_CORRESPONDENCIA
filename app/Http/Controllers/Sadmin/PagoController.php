<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = DB::table('pagos')
            ->join('plan', 'pagos.id_plan', '=', 'plan.id_plan')
            ->join('estado', 'pagos.id_est_pago', '=', 'estado.id_estado')
            ->select(
                'pagos.id_pago',
                'plan.nomb_plan',
                'pagos.monto',
                'pagos.comprobante',
                'pagos.moneda',
                'estado.estado_nomb',
                'pagos.fecha_pago'
            )
            ->orderBy('pagos.fecha_pago', 'asc')
            ->get();

        return view('sadmin.pagos', compact('pagos'));
    }
    public function aprobar($id)
    {
        DB::table('pagos')->where('id_pago', $id)->update(['id_est_pago' => 4]); // 4 = Aprobado
        return back()->with('success', 'Pago aprobado correctamente.');
    }

    public function denegar($id)
    {
        DB::table('pagos')->where('id_pago', $id)->update(['id_est_pago' => 5]); // 5 = No Aprobado
        return back()->with('error', 'Pago denegado.');
    }
}

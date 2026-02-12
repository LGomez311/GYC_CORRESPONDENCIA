<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Licencia;
use App\Models\Plan;
use Carbon\Carbon;
use App\Models\Pago; 

class LicenciaController extends Controller
{

 public function index()
    {
        $licencias = Licencia::with('plan')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        $planes = Plan::all();

        $pagos = Pago::where('id_est_pago', 4)->get();
        // 4 = Aprobado (según tu tabla estado)

         $estados = Estado::all();

        return view('sadmin.licencias', compact(
            'licencias',
            'planes',
            'pagos'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nit_empresa' => 'required|string|max:25',
            'id_plan'     => 'required|exists:plan,id_plan',
            'id_pago'     => 'required|exists:pago,id_pago',
        ]);

        $plan = Plan::findOrFail($request->id_plan);

        // 🔎 Última licencia activa de la empresa
        $licenciaAnterior = Licencia::where('nit_empresa', $request->nit_empresa)
            ->where('id_estado', 1) // Activa
            ->orderBy('fecha_fin', 'desc')
            ->first();

        if ($licenciaAnterior) {

            // Si la licencia sigue vigente, se renueva desde la fecha_fin
            // Si ya venció, se reactiva desde hoy
            if (Carbon::parse($licenciaAnterior->fecha_fin)->isFuture()) {
                $fechaInicio = Carbon::parse($licenciaAnterior->fecha_fin);
            } else {
                $fechaInicio = Carbon::now();
            }

            $tipo_licencia  = 'RENOVACION';
            $licenciaOrigen = $licenciaAnterior->id_licencia;
        } else {

            // Primera activación
            $fechaInicio     = Carbon::now();
            $tipo_licencia   = 'ACTIVACION';
            $licenciaOrigen  = null;
        }


        $fechaFin = (clone $fechaInicio)->addDays($plan->duracion_dias);

        Licencia::create([
            'nit_empresa'     => $request->nit_empresa,
            'id_plan'         => $plan->id_plan,
            'id_pago'         => $request->id_pago,
            'id_estado'       => 1, // Activo
            'fecha_inicio'    => $fechaInicio,
            'fecha_fin'       => $fechaFin,
            'tipo_licencia'   => $tipo_licencia,
            'licencia_origen' => $licenciaOrigen,
        ]);

        return redirect()
            ->route('sadmin.licencias')
            ->with('success', "Licencia {$tipo_licencia} realizada correctamente.");
    }
}

<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Licencia;
use App\Models\Plan;
use App\Models\Pago;
use App\Models\Estado;
use App\Models\Empresa;
use Carbon\Carbon;

class LicenciaController extends Controller
{

    public function index()
    {
        $licencias = Licencia::with('plan')
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        $planes = Plan::all();

        $pagos = Pago::where('id_est_pago', 4)
            ->whereNotIn('id_pago', function ($query) {
                $query->select('id_pago')
                    ->from('licencia')
                    ->whereNotNull('id_pago');
            })
            ->with('plan') // importante para mostrar el nombre del plan
            ->get();

        // 4 = Aprobado (según tu tabla estado)

        // SOLO estados 1 y 2
        $estados = Estado::whereIn('id_estado', [1, 2])->get();

        // Empresas existentes
        $empresas = Empresa::select('nit_empresa')->get();

        return view('sadmin.licencias', compact(
            'licencias',
            'planes',
            'pagos',
            'estados',
            'empresas'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nit_empresa' => 'required|string|max:25',
            'id_plan'     => 'required|exists:plan,id_plan',
            'id_pago'     => 'required|exists:pagos,id_pago',
            'id_estado'   => 'required|in:1,2'
        ]);

        $plan = Plan::findOrFail($request->id_plan);

        //  Última licencia activa de la empresa
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


        $fechaFin = (clone $fechaInicio)->addDays($plan->duracion);

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
    public function toggle($id)
    {
        $licencia = Licencia::findOrFail($id);

        // Si está activa (1) → pasar a inactiva (2)
        if ($licencia->id_estado == 1) {
            $licencia->id_estado = 2;
        } else {
            $licencia->id_estado = 1;
        }

        $licencia->save();

        return redirect()
            ->route('sadmin.licencias')
            ->with('success', 'Estado de la licencia actualizado correctamente.');
    }
}

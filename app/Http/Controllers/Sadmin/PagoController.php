<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Licencia;
use App\Models\AuditoriaPagos;
use App\Models\Estado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class PagoController extends Controller
{
    public function index()
    {
        // Paginación: 10 registros por página (ajusta a tu gusto)
        $pagos = Pago::with(['plan', 'estado', 'admin', 'admin.empresa'])
            ->orderBy('fecha_pago', 'desc')
            ->paginate(4);

        // Historial de auditoría
        $auditorias = AuditoriaPagos::with(['pagoAfectado', 'responsable'])
            ->orderBy('fecha_cambio', 'desc')
            ->get();

        // Estados para el modal de auditoría
        $estados = Estado::all();

        return view('sadmin.pagos', compact('pagos', 'auditorias', 'estados'));
    }


    public function aprobar($id)
    {

        $pago = Pago::with(['plan', 'admin'])->findOrFail($id);

        // Aprobar el pago
        $pago->id_est_pago = 4; // APROBADO
        $pago->actualizado_por = Auth::user()->emple_doc;
        $pago->save();

        // Obtener el empleado (admin) que pagó
        $empleado = $pago->admin;

        if (!$empleado) {
            return back()->withErrors('El pago no tiene un admin asociado');
        }

        // Buscar última licencia de la empresa
        $licenciaAnterior = Licencia::whereHas('pago.admin', function ($q) use ($empleado) {
            $q->where('nit_empresa', $empleado->nit_empresa);
        })->orderByDesc('fecha_fin')->first();

        if ($licenciaAnterior) {
            // RENOVACIÓN
            $fechaFinAnterior = Carbon::parse($licenciaAnterior->fecha_fin);
            $fechaInicioPago  = Carbon::parse($pago->fecha_inicio);

            $fechaInicio = $fechaInicioPago->gt($fechaFinAnterior)
                ? $fechaInicioPago // renovación diferida
                : $fechaFinAnterior; // renovación continua

            $tipo = 'RENOVACION';
            $licenciaOrigen = $licenciaAnterior->id_licencia;
        } else {
            // ACTIVACIÓN
            $fechaInicio = Carbon::parse($pago->fecha_inicio);
            $tipo = 'ACTIVACION';
            $licenciaOrigen = null;
        }

        $fechaFin = (clone $fechaInicio)->addDays($pago->plan->duracion);

        // Crear licencia
        Licencia::create([
            'id_pago'         => $pago->id_pago,
            'id_estado'       => 1, // ACTIVA
            'fecha_inicio'    => $fechaInicio,
            'fecha_fin'       => $fechaFin,
            'tipo_licencia'   => $tipo,
            'licencia_origen' => $licenciaOrigen,
        ]);

        return back()->with('success', 'Pago aprobado y licencia generada correctamente');
    }

    public function denegar($id)
    {
        $pago = Pago::findOrFail($id);

        // Cambiar estado a DENEGADO
        $pago->id_est_pago = 5; // Ajusta según tu estado DENEGADO
        $pago->actualizado_por = Auth::user()->emple_doc;
        $pago->save();

        return back()->with('success', 'Pago denegado correctamente');
    }
}

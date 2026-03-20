<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use App\Models\DetalleEnvio;
use App\Models\DetalleRecibido;
use App\Models\Recibido;
use App\Models\Envio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // --- ESTADÍSTICAS ---

        // 1. Recibidos en el mes (Externa)
        $recibidosMes = Recibido::where('nit_empresa', $user->nit_empresa)
            ->whereBetween('fecha_hora_recib', [$startOfMonth, $endOfMonth])
            ->count();

        // 2. Trámite Activo del empleado (Externa + Interna)
        // Solo el estado más reciente por cada radicado para este empleado
        $latestExt = DetalleRecibido::where('det_doc_empleado', $user->emple_doc)
            ->selectRaw('MAX(id_det_recibido) as id')
            ->groupBy('det_id_recibido')
            ->pluck('id');
        
        $enTramiteExt = DetalleRecibido::whereIn('id_det_recibido', $latestExt)
            ->where('id_estado_rec', 8)
            ->count();

        $latestInt = DetalleEnvio::where('id_quien_recibe', $user->emple_doc)
            ->selectRaw('MAX(id_detalle) as id')
            ->groupBy('id_envio')
            ->pluck('id');

        $enTramiteInt = DetalleEnvio::whereIn('id_detalle', $latestInt)
            ->where('id_estado_rec', 8)
            ->count();

        $totalTramiteActivo = $enTramiteExt + $enTramiteInt;

        // 3. Finalizados en el mes
        $finalizadosExt = DetalleRecibido::where('det_doc_empleado', $user->emple_doc)
            ->where('id_estado_rec', 9)
            ->whereBetween('fecha_re', [$startOfMonth, $endOfMonth])
            ->count();
        
        $finalizadosInt = DetalleEnvio::where('id_quien_recibe', $user->emple_doc)
            ->where('id_estado_rec', 9)
            ->whereBetween('fecha_traslado', [$startOfMonth, $endOfMonth])
            ->count();
        
        $totalFinalizadosMes = $finalizadosExt + $finalizadosInt;

        // 4. Próximos a vencer
        $vencidas = 0;
        $activasExt = DetalleRecibido::whereIn('id_det_recibido', $latestExt)
            ->whereIn('id_estado_rec', [7, 8])
            ->with('recibido.tipo')
            ->get();
        foreach($activasExt as $ext) {
            if($ext->recibido && $ext->recibido->tipo && $ext->recibido->tipo->dias_respuesta) {
                $fechaRecibido = Carbon::parse($ext->recibido->fecha_hora_recib);
                $limite = $fechaRecibido->copy()->addDays($ext->recibido->tipo->dias_respuesta);
                if($now->diffInDays($limite, false) <= 2 && $now->diffInDays($limite, false) >= 0) {
                    $vencidas++;
                }
            }
        }

        $activasInt = DetalleEnvio::whereIn('id_detalle', $latestInt)
            ->whereIn('id_estado_rec', [7, 8])
            ->with('envio.tipoEnvio')
            ->get();
        foreach($activasInt as $int) {
            if($int->envio && $int->envio->tipoEnvio && $int->envio->tipoEnvio->dias_respuesta) {
                $fechaEnvio = Carbon::parse($int->envio->fecha);
                $limite = $fechaEnvio->copy()->addDays($int->envio->tipoEnvio->dias_respuesta);
                if($now->diffInDays($limite, false) <= 2 && $now->diffInDays($limite, false) >= 0) {
                    $vencidas++;
                }
            }
        }

        // --- EFICIENCIA SEMANAL ---
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $resueltasExtSemana = DetalleRecibido::where('det_doc_empleado', $user->emple_doc)
            ->where('id_estado_rec', 9)
            ->whereBetween('fecha_re', [$startOfWeek, $endOfWeek])
            ->with('recibido.tipo')
            ->get();

        $resueltasIntSemana = DetalleEnvio::where('id_quien_recibe', $user->emple_doc)
            ->where('id_estado_rec', 9)
            ->whereBetween('fecha_traslado', [$startOfWeek, $endOfWeek])
            ->with('envio.tipoEnvio')
            ->get();

        $totalResueltasSemana = 0;
        $aTiempo = 0;
        $fueraPlazo = 0;
        $sumaDias = 0;

        foreach($resueltasExtSemana as $ext) {
            if($ext->recibido && $ext->recibido->tipo) {
                $totalResueltasSemana++;
                $inicio = Carbon::parse($ext->recibido->fecha_hora_recib);
                $fin = Carbon::parse($ext->fecha_re);
                $diasTomados = $inicio->diffInDays($fin);
                $sumaDias += $diasTomados;
                
                if ($diasTomados <= $ext->recibido->tipo->dias_respuesta) {
                    $aTiempo++;
                } else {
                    $fueraPlazo++;
                }
            }
        }

        foreach($resueltasIntSemana as $int) {
            if($int->envio && $int->envio->tipoEnvio) {
                $totalResueltasSemana++;
                $inicio = Carbon::parse($int->envio->fecha);
                $fin = Carbon::parse($int->fecha_traslado);
                $diasTomados = $inicio->diffInDays($fin);
                $sumaDias += $diasTomados;
                
                if ($diasTomados <= $int->envio->tipoEnvio->dias_respuesta) {
                    $aTiempo++;
                } else {
                    $fueraPlazo++;
                }
            }
        }

        $eficiencia = [
            'a_tiempo_pct' => $totalResueltasSemana > 0 ? round(($aTiempo / $totalResueltasSemana) * 100) : 0,
            'fuera_plazo_pct' => $totalResueltasSemana > 0 ? round(($fueraPlazo / $totalResueltasSemana) * 100) : 0,
            'promedio_dias' => $totalResueltasSemana > 0 ? round($sumaDias / $totalResueltasSemana, 1) : 0,
            'total' => $totalResueltasSemana
        ];

        // --- NOTIFICACIONES ---

        // Filtrar rechazos de correspondencia INTERNA enviada por el usuario
        $rechazosInternos = DetalleEnvio::with(['envio.radicado', 'quienRecibe'])
            ->where('id_quien_envie', $user->emple_doc)
            ->where('id_estado_rec', 11)
            ->where('visto', 0)
            ->whereIn('id_detalle', function($query) {
                $query->selectRaw('MAX(id_detalle)')
                    ->from('detalle_envio')
                    ->groupBy('id_envio', 'id_quien_recibe');
            })
            ->orderBy('fecha_traslado', 'desc')
            ->get();

        // Nuevas correspondencias (Estado "Recibido" = 7)
        $nuevasExternas = DetalleRecibido::with(['recibido.radicado', 'recibido.tipo'])
            ->where('det_doc_empleado', $user->emple_doc)
            ->where('id_estado_rec', 7)
            ->where('visto', 0)
            ->whereIn('id_det_recibido', $latestExt)
            ->get();
        
        $nuevasInternas = DetalleEnvio::with(['envio.radicado', 'quienEnvia'])
            ->where('id_quien_recibe', $user->emple_doc)
            ->where('id_estado_rec', 7)
            ->where('visto', 0)
            ->whereIn('id_detalle', $latestInt)
            ->get();

        // Respuestas/Archivados de correspondencia INTERNA enviada por el usuario
        $respuestasInternas = DetalleEnvio::with(['envio.radicado', 'quienRecibe'])
            ->where('id_quien_envie', $user->emple_doc)
            ->whereIn('id_estado_rec', [9, 10])
            ->where('visto', 0)
            ->whereIn('id_detalle', function($query) {
                $query->selectRaw('MAX(id_detalle)')
                    ->from('detalle_envio')
                    ->groupBy('id_envio', 'id_quien_recibe');
            })
            ->orderBy('fecha_traslado', 'desc')
            ->get();

        return view('empleado.index', compact(
            'recibidosMes',
            'totalTramiteActivo',
            'totalFinalizadosMes',
            'vencidas',
            'rechazosInternos',
            'nuevasExternas',
            'nuevasInternas',
            'respuestasInternas',
            'eficiencia'
        ));
    }

    public function markAsRead($type, $id)
    {
        $user = Auth::user();

        if ($type === 'interna') {
            $notification = DetalleEnvio::where('id_detalle', $id)
                ->where(function($q) use ($user) {
                    $q->where('id_quien_recibe', $user->emple_doc)
                      ->orWhere('id_quien_envie', $user->emple_doc);
                })->firstOrFail();
            
            $notification->update(['visto' => 1]);
        } 
        elseif ($type === 'externa') {
            $notification = DetalleRecibido::where('id_det_recibido', $id)
                ->where('det_doc_empleado', $user->emple_doc)
                ->firstOrFail();
            
            $notification->update(['visto' => 1]);
        }

        return back()->with('success', 'Notificación marcada como leída.');
    }
}

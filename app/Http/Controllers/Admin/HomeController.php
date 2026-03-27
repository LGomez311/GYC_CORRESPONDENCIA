<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Licencia;
use App\Models\Envio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Muestra el dashboard del admin
     */
    public function index()
    {
        $user = Auth::user();
        
        // Obtener la licencia activa más reciente del usuario (incluye renovaciones)
        $licencia = Licencia::whereHas('pago', function ($query) use ($user) {
            $query->where('id_admin', $user->emple_doc);
        })
        // eliminamos el filtro por tipo para considerar activaciones y renovaciones
        ->orderBy('fecha_fin', 'desc')
        ->first();

        // Si no encuentra por admin, intenta obtener por empresa (para empleados)
        if (!$licencia && $user->nit_empresa) {
            $licencia = Licencia::whereHas('pago', function ($query) use ($user) {
                $query->whereHas('admin', function ($subquery) use ($user) {
                    $subquery->where('nit_empresa', $user->nit_empresa);
                });
            })
            // incluir renovaciones también
            ->orderBy('fecha_fin', 'desc')
            ->first();
        }

        $diasRestantes = 0;
        $tiempoRestante = [
            'dias' => 0,
            'horas' => 0,
            'minutos' => 0,
            'segundos' => 0,
        ];
        $porcentajeDiasRestantes = 0;
        $estaActiva = false;
        $nivelUrgencia = 'normal'; // normal, advertencia, critico

        if ($licencia) {
            $diasRestantes = $licencia->diasRestantes();
            $tiempoRestante = $licencia->getTiempoRestante();
            $porcentajeDiasRestantes = $licencia->porcentajeDiasRestantes();
            $estaActiva = $licencia->estaActiva();

            // Determinar nivel de urgencia
            if ($diasRestantes <= 7) {
                $nivelUrgencia = 'critico';
            } elseif ($diasRestantes <= 14) {
                $nivelUrgencia = 'advertencia';
            }
        }

        // Datos de correspondencia
        $totalCorrespondencia = 0;
        $pendientes = 0;
        $recibidos = 0;
        $enviados = 0;
        $mensajeCorrespondencia = '';
        $recientes = []; // Para actividad reciente

        // Solo mostrar datos si la licencia está activa
        if ($estaActiva) {
            // Verificar si el usuario está registrado a una empresa
            if (!$user->nit_empresa) {
                $mensajeCorrespondencia = 'No estás registrado a una empresa';
            } else {
                // Obtener todos los envios de los empleados de la empresa
                $enviosEmpresa = Envio::whereHas('quienEnvia', function ($query) use ($user) {
                    $query->where('nit_empresa', $user->nit_empresa);
                })
                ->orWhereHas('detalles.quienRecibe', function ($query) use ($user) {
                    $query->where('nit_empresa', $user->nit_empresa);
                })
                ->get();

                if ($enviosEmpresa->isEmpty()) {
                    $mensajeCorrespondencia = 'No hay correspondencia registrada';
                } else {
                    // Total
                    $totalCorrespondencia = $enviosEmpresa->count();

                    // Pendientes (estado 0 = En espera)
                    $pendientes = $enviosEmpresa->where('id_estado_envio', 0)->count();

                    // Recibidos (donde el usuario es el destinatario)
                    $recibidos = Envio::whereHas('detalles', function ($query) use ($user) {
                        $query->where('id_quien_recibe', $user->emple_doc);
                    })->count();

                    // Enviados (donde el usuario es el remitente)
                    $enviados = Envio::where('doc_quien_envia', $user->emple_doc)->count();

                    // --- ACTIVIDAD RECIENTE UNIFICADA CON PAGINACIÓN ---
                    $recientesInternos = Envio::whereHas('quienEnvia', function ($query) use ($user) {
                        $query->where('nit_empresa', $user->nit_empresa);
                    })
                    ->with(['estadoEnvio', 'radicado', 'quienEnvia'])
                    ->orderBy('fecha', 'desc')
                    ->take(50) // Suficientes para las primeras páginas
                    ->get()
                    ->map(function ($envio) {
                        return (object)[
                            'tipo' => 'Interna',
                            'icon' => 'mail',
                            'id' => $envio->id_envio,
                            'asunto' => $envio->asunto,
                            'radicado' => $envio->radicado ? $envio->radicado->num_radicado : 'S/R',
                            'estado' => $envio->estadoEnvio->estado_nomb ?? 'En espera',
                            'fecha' => $envio->fecha,
                            'remitente' => ($envio->quienEnvia->emple_nombres ?? 'Desconocido') . ' ' . ($envio->quienEnvia->emple_apellidos ?? ''),
                            'url' => route('admin.correspondencia.historial_interna', $envio->id_envio)
                        ];
                    });

                    $recientesExternos = \App\Models\Recibido::where('nit_empresa', $user->nit_empresa)
                    ->with(['estado', 'radicado', 'registradoPor'])
                    ->orderBy('fecha_hora_recib', 'desc')
                    ->take(50)
                    ->get()
                    ->map(function ($recibido) {
                        $remitente = $recibido->registradoPor 
                            ? ($recibido->registradoPor->emple_nombres . ' ' . $recibido->registradoPor->emple_apellidos)
                            : ($recibido->nom_institucion ?? ($recibido->nombre_persona ?? 'Externo'));
                            
                        return (object)[
                            'tipo' => 'Externa',
                            'icon' => 'send',
                            'id' => $recibido->id_recibido,
                            'asunto' => $recibido->asunto,
                            'radicado' => $recibido->radicado ? $recibido->radicado->num_radicado : 'S/R',
                            'estado' => $recibido->estado->estado_nomb ?? 'Recibido',
                            'fecha' => $recibido->fecha_hora_recib,
                            'remitente' => $remitente,
                            'url' => route('admin.correspondencia.historial_externa', $recibido->id_recibido)
                        ];
                    });

                    $allItems = $recientesInternos->concat($recientesExternos)
                        ->sortByDesc('fecha');

                    $currentPage = request()->get('page', 1);
                    $perPage = 10;
                    $currentItems = $allItems->slice(($currentPage - 1) * $perPage, $perPage)->values();

                    $recientes = new \Illuminate\Pagination\LengthAwarePaginator(
                        $currentItems,
                        $allItems->count(),
                        $perPage,
                        $currentPage,
                        ['path' => request()->url(), 'query' => request()->query()]
                    );
                }
            }
        }

        return view('admin.home', compact(
            'licencia',
            'diasRestantes',
            'tiempoRestante',
            'porcentajeDiasRestantes',
            'estaActiva',
            'nivelUrgencia',
            'totalCorrespondencia',
            'pendientes',
            'recibidos',
            'enviados',
            'mensajeCorrespondencia',
            'recientes'
        ));
    }
}

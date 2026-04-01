<?php

namespace App\Http\Controllers\Remitente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Recibido;
use App\Models\DetalleRecibido;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\DetalleEnvio;
use App\Models\Envio;
use App\Models\Radicado;
use App\Models\AnexoEnvio;
use App\Mail\CorrespondenciaSalienteNotification;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        if (!$remitente) return redirect()->route('login');
        $remDoc = $remitente->rem_doc;
        $nit = $remitente->nit_empresa;

        $this->syncRejected($remDoc);

        // --- 1. RECIBIDOS NUEVOS (Recientes o Pendientes) ---
        $queryRec = $this->getBaseQuery($remDoc)
            ->whereNotIn('id_estado_rec', [10, 14])
            ->where(function($q) {
                $q->whereDate('fecha_hora_recib', '>=', now()->subDays(7))
                  ->orWhereIn('id_estado_rec', [7, 8, 13]);
            });

        // --- 2. ENVIOS INTERNOS NUEVOS (Recientes o Pendientes) ---
        $queryInt = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'quienEnvia', 'estadoEnvio', 'anexos', 'detalles.quienRecibe.area'])
            ->where('doc_quien_registra', $remDoc)
            ->whereHas('radicado', fn($q) => $q->where('num_radicado', 'like', 'INT-%'))
            ->where(function($q) {
                $q->whereDate('fecha', '>=', now()->subDays(7))
                  ->orWhereIn('id_estado_envio', [8, 12, 13]);
            });

        // --- 3. ENVIOS SALIENTES NUEVOS (Sin Recibido asociado para evitar duplicidad) ---
        $querySal = Envio::with(['radicado', 'tipoEnvio', 'quienEnvia', 'estadoEnvio', 'anexos', 'detalles.quienRecibe.area'])
            ->where('doc_quien_registra', $remDoc)
            ->where(function($q) {
                // Solo envios que NO sean respuestas a un recibidido
                $q->whereNotExists(function($sub) {
                    $sub->select(DB::raw(1))
                        ->from('recibido')
                        ->whereRaw('recibido.num_radicado_int = envio.num_radicado_int');
                });
            })
            ->where(function($q) {
                // Incluir todos los de estado 0/8/12/13/14 o los últimos 7 días
                $q->whereDate('fecha', '>=', now()->subDays(7))
                  ->orWhereIn('id_estado_envio', [0, 8, 12, 13, 14]);
            });

        // NORMALIZACIÓN PARA TABLA ÚNICA
        $recibidos = $queryRec->get()->map(function($item) {
            return (object)[
                'id' => 'EXT_' . $item->id_recibido,
                'id_original' => $item->id_recibido,
                'radicado' => $item->radicado?->num_radicado ?? 'EXT-N/A',
                'asunto' => $item->asunto,
                'fecha' => $item->fecha_hora_recib,
                'tipo' => 'Externa',
                'tipo_label' => 'IN',
                'clase' => 'orange',
                'contacto' => $item->nom_institucion ?: ($item->nombre_persona ?: 'Externo'),
                'estado' => in_array($item->id_estado_rec, [9, 10]) ? 'RESUELTO' : ($item->estado?->estado_nomb ?? 'Sin estado'),
                'id_estado' => $item->id_estado_rec,
                'radicado_ext' => $item->num_radicado_ext,
                'folios' => $item->folio,
                'archivo' => $item->archivo,
                'anexos' => $item->anexos,
                'destinatarios' => $item->destinatarios,
                'is_assigned' => $item->destinatarios && $item->destinatarios->count() > 0,
                'correo' => $item->correo_persona,
                'id_tipo' => $item->id_tipo,
                'rad_id' => $item->num_radicado_int,
                'url_historial' => route('remitente.recibidos') . '?q=' . ($item->radicado?->num_radicado),
                'has_response' => $item->envios->count() > 0
            ];
        });

        $internos = $queryInt->get()->map(function($item) {
            $primer = $item->detalles->first();
            return (object)[
                'id' => 'INT_' . $item->id_envio,
                'id_original' => $item->id_envio,
                'radicado' => $item->radicado?->num_radicado ?? 'INT-N/A',
                'asunto' => $item->asunto,
                'fecha' => $item->fecha,
                'tipo' => 'Interna',
                'tipo_label' => 'INT',
                'clase' => 'indigo',
                'contacto' => $primer?->quienRecibe ? $primer->quienRecibe->emple_nombres . ' ' . $primer->quienRecibe->emple_apellidos : 'N/A',
                'estado' => $item->id_estado_envio == 9 ? 'RESUELTO' : ($item->estadoEnvio?->estado_nomb ?? 'Sin estado'),
                'id_estado' => $item->id_estado_envio,
                'folios' => $item->folio,
                'archivo' => $item->archivo,
                'anexos' => $item->anexos,
                'url_historial' => route('remitente.historial') . '?q=' . ($item->radicado?->num_radicado),
                'correo' => $item->correo ?? null,
                'id_tipo' => $item->id_tipo_envio,
                'rad_id' => $item->num_radicado_int
            ];
        });

        $salientes = $querySal->get()->map(function($item) {
            return (object)[
                'id' => 'SAL_' . $item->id_envio,
                'id_original' => $item->id_envio,
                'radicado' => $item->radicado?->num_radicado ?? 'SAL-N/A',
                'asunto' => $item->asunto,
                'fecha' => $item->fecha,
                'tipo' => 'Saliente',
                'tipo_label' => 'SAL',
                'clase' => 'blue',
                'contacto' => $item->destino ?: 'Externo',
                'estado' => in_array($item->id_estado_envio, [9, 14]) ? 'RESUELTO' : ($item->estadoEnvio?->estado_nomb ?? 'Sin estado'),
                'id_estado' => $item->id_estado_envio,
                'folios' => $item->folio,
                'archivo' => $item->archivo,
                'anexos' => $item->anexos,
                'url_historial' => route('remitente.historial') . '?q=' . ($item->radicado?->num_radicado),
                'correo' => $item->correo ?? null,
                'id_tipo' => $item->id_tipo_envio,
                'rad_id' => $item->num_radicado_int
            ];
        });

        $completo = $recibidos->concat($internos)->concat($salientes)
            ->groupBy('radicado')
            ->map(function($group) {
                return $group->sortByDesc('fecha')->first();
            })
            ->sortByDesc('fecha')
            ->values();
        
        $page = $request->input('page', 1);
        $perPage = 15;
        $correspondenciaNueva = new \Illuminate\Pagination\LengthAwarePaginator(
            $completo->forPage($page, $perPage),
            $completo->count(),
            $perPage,
            $page,
            ['path' => route('remitente.index'), 'query' => $request->query()]
        );

        $stats = $this->getStats($remDoc);
        
        // Mantener colecciones originales para los modales de JS (Compatibilidad)
        $correspondencias = $queryRec->get();
        $enviosPendientes = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'quienEnvia', 'anexos', 'detalles.quienRecibe.area'])
            ->where('doc_quien_registra', $remDoc)
            ->where('id_estado_envio', 0)
            ->get();

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();
        $estados = \App\Models\Estado::all();
        
        // T8b: Excluir Super Admin (rol=1) y propio usuario para modales de asignación
        $todosDestinatarios = \App\Models\Empleado::with('area')
            ->where('emple_rol', '=', 3)
            ->where('emple_rol', '!=', 1)
            ->where('emple_doc', '!=', $remDoc)
            ->get()
            ->map(function($e) {
                return [
                    'emple_doc' => (string) $e->emple_doc,
                    'emple_nombres' => $e->emple_nombres,
                    'emple_apellidos' => $e->emple_apellidos,
                    'tipo' => 'empleado',
                    'area_nombre' => $e->area ? $e->area->area_nom : null
                ];
            });

        $ciudades = \App\Models\Ciudad::with('departamento')->orderBy('ciudad_nom')->get();

        return view('remitente.index', compact('stats', 'correspondenciaNueva', 'correspondencias', 'enviosPendientes', 'tipos', 'empleados', 'estados', 'todosDestinatarios', 'ciudades'));

    }

    public function historial(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;
        $nit = $remitente->nit_empresa;

        $q = $request->input('q');
        $tipo = $request->input('tipo');
        $estado = $request->input('estado');
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        // RE-FETCH PARA HISTORIAL COMPLETO
        $queryRec = $this->getBaseQuery($remDoc);
        $queryEnv = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'quienEnvia', 'estadoEnvio', 'anexos', 'detalles.quienRecibe.area'])
            ->where('doc_quien_registra', $remDoc);

        if ($q) {
            $queryRec->where(function($sub) use ($q) {
                $sub->where('asunto', 'like', "%$q%")->orWhereHas('radicado', fn($r) => $r->where('num_radicado', 'like', "%$q%"));
            });
            $queryEnv->where(function($sub) use ($q) {
                $sub->where('asunto', 'like', "%$q%")->orWhereHas('radicado', fn($r) => $r->where('num_radicado', 'like', "%$q%"));
            });
        }

        if ($desde) {
            $queryRec->whereDate('fecha_hora_recib', '>=', $desde);
            $queryEnv->whereDate('fecha', '>=', $desde);
        }
        if ($hasta) {
            $queryRec->whereDate('fecha_hora_recib', '<=', $hasta);
            $queryEnv->whereDate('fecha', '<=', $hasta);
        }

        // Mapeo y Unificación
        $recibidos = $queryRec->get()->map(function($item) {
            return (object)[
                'id_original' => $item->id_recibido,
                'radicado' => $item->radicado?->num_radicado ?? 'EXT-N/A',
                'asunto' => $item->asunto,
                'fecha' => $item->fecha_hora_recib,
                'tipo' => 'Externa',
                'clase' => 'orange',
                'contacto' => $item->nom_institucion ?: ($item->nombre_persona ?: 'Externo'),
                'estado' => in_array($item->id_estado_rec, [9, 10]) ? 'RESUELTO' : ($item->estado?->estado_nomb ?? 'Sin estado'),
                'id_tipo_cor' => 'EXT',
                'rad_id' => $item->num_radicado_int
            ];
        });

        $envios = $queryEnv->get()->map(function($item) {
            $prefijo = substr($item->radicado?->num_radicado ?? '', 0, 3);
            $isSal = ($prefijo === 'SAL' || $prefijo === 'EXT');
            return (object)[
                'id_original' => $item->id_envio,
                'radicado' => $item->radicado?->num_radicado ?? ($isSal ? 'SAL-N/A' : 'INT-N/A'),
                'asunto' => $item->asunto,
                'fecha' => $item->fecha,
                'tipo' => $isSal ? 'Saliente' : 'Interna',
                'clase' => $isSal ? 'blue' : 'indigo',
                'contacto' => $isSal ? ($item->destino ?: 'Externo') : ($item->detalles->first()?->quienRecibe->emple_nombres ?? 'N/A'),
                'estado' => in_array($item->id_estado_envio, [9, 14]) ? 'RESUELTO' : ($item->estadoEnvio?->estado_nomb ?? 'Sin estado'),
                'id_tipo_cor' => $isSal ? 'SAL' : 'INT',
                'rad_id' => $item->num_radicado_int
            ];
        });

        $completo = $recibidos->concat($envios)
            ->groupBy('radicado')
            ->map(function($group) {
                return $group->sortByDesc('fecha')->first();
            })
            ->sortByDesc('fecha');

        // Paginación manual para la colección unificada
        $perPage = 15;
        $page = $request->input('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $completo->forPage($page, $perPage),
            $completo->count(),
            $perPage,
            $page,
            ['path' => route('remitente.historial'), 'query' => $request->query()]
        );

        $estados = \App\Models\Estado::all();

        return view('remitente.historial', compact('paginated', 'estados'));
    }

    public function recibidosProceso(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;

        $this->syncRejected($remDoc);
        $stats = $this->getStats($remDoc);
        $estadoId = $request->input('estado_id');
        $fecha = $request->input('fecha');
        $q = $request->input('q');

        $query = $this->getBaseQuery($remDoc);
            
        if ($estadoId) {
            $query->where('id_estado_rec', $estadoId);
        }

        if ($fecha) {
            $query->whereDate('fecha_hora_recib', $fecha);
        }

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('asunto', 'like', "%$q%")
                    ->orWhereHas('radicado', function($r) use ($q) {
                        $r->where('num_radicado', 'like', "%$q%");
                    })
                    ->orWhere('num_radicado_ext', 'like', "%$q%")
                    ->orWhere('nombre_persona', 'like', "%$q%")
                    ->orWhere('nom_institucion', 'like', "%$q%");
            });
        }

        $recibidos = $query->paginate(15)->appends($request->query());

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();
        $estados = \App\Models\Estado::all();
        $ciudades = \App\Models\Ciudad::with('departamento')->orderBy('ciudad_nom')->get();

        // T8b: Excluir Super Admin (rol=1) y propio usuario
        $todosDestinatarios = \App\Models\Empleado::with('area')
            ->where('emple_rol', '=', 3)
            ->where('emple_rol', '!=', 1)
            ->where('emple_doc', '!=', $remDoc)
            ->get()
            ->map(function($e) {
                return [
                    'emple_doc' => (string) $e->emple_doc,
                    'emple_nombres' => $e->emple_nombres,
                    'emple_apellidos' => $e->emple_apellidos,
                    'tipo' => 'empleado',
                    'area_nombre' => $e->area ? $e->area->area_nom : null
                ];
            })
            ->sortBy('emple_nombres')
            ->values();

        // Envios internos del remitente (radicado INT-)
        $enviosInternos = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'estadoEnvio', 'quienEnvia',
            'detalles.quienRecibe.area'])
            ->where('doc_quien_registra', $remDoc)
            ->whereHas('radicado', fn($q) => $q->where('num_radicado', 'like', 'INT-%'))
            ->orderBy('fecha', 'desc')
            ->paginate(10, ['*'], 'int_page');

        // Envios salientes del remitente (radicado EXT-/SAL- o estado 14)
        $enviosSalientes = \App\Models\Envio::with(['radicado', 'tipoEnvio', 'estadoEnvio', 'quienEnvia',
            'detalles.quienRecibe.area'])
            ->where('doc_quien_registra', $remDoc)
            ->where(function($q) {
                $q->whereHas('radicado', fn($qr) => $qr->where('num_radicado', 'like', 'EXT-%')
                        ->orWhere('num_radicado', 'like', 'SAL-%'))
                  ->orWhere('id_estado_envio', 14);
            })
            ->orderBy('fecha', 'desc')
            ->paginate(10, ['*'], 'sal_page');
        // Filtros adicionales para la vista unificada
        $tipoFiltro = $request->input('tipo', 'todos');
        $tab = $request->input('tab', 'externa');

        return view('remitente.recibidos', compact('stats', 'recibidos', 'tipos', 'empleados', 'estados', 'estadoId', 'ciudades', 'todosDestinatarios', 'enviosInternos', 'enviosSalientes', 'tipoFiltro', 'tab'));
    }

    public function procesoSalientes()
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;

        $this->syncRejected($remDoc);
        $stats = $this->getStats($remDoc);

        // Records WITH response from employee and NOT salientes/finalizados
        $correspondencias = $this->getBaseQuery($remDoc)
            ->whereNotIn('id_estado_rec', [10, 14])
            ->whereHas('detalles', function($q) {
                $q->whereNotNull('archivo_res');
            })
            ->paginate(10);

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();

        return view('remitente.proceso_salientes', compact('stats', 'correspondencias', 'tipos', 'empleados'));
    }

    public function finalizados()
    {
        $remitente = Auth::guard('remitente')->user();
        $remDoc = $remitente->rem_doc;

        $this->syncRejected($remDoc);
        $stats = $this->getStats($remDoc);

        // ALL correspondence finished (14, 10)
        $correspondencias = $this->getBaseQuery($remDoc)
            ->whereIn('id_estado_rec', [10, 14])
            ->paginate(10);

        $tipos = \App\Models\Tipo::all();
        $empleados = \App\Models\Empleado::where('emple_rol', 3)->get();

        return view('remitente.finalizados', compact('stats', 'correspondencias', 'tipos', 'empleados'));
    }

    private function getBaseQuery($remDoc)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        return Recibido::with([
            'estado', 
            'tipo', 
            'radicado', 
            'destinatarios.area', 
            'ciudad.departamento', 
            'anexos', 
            'detalles' => function($q) {
                $q->orderBy('fecha_re', 'desc');
            },
            'detalles.anexosRespuesta',
            'detalles.empleado.area',
            'detalles.estado',
            'envios'
        ])
            ->where('nit_empresa', $nitEmpresa)
            ->where(function($q) use ($remDoc) {
                $q->where('doc_quien_registra', $remDoc)
                  ->orWhereNull('doc_quien_registra');
            })
            // T2: Ordenar por fecha de recepción descendente (más recientes primero)
            ->orderBy('fecha_hora_recib', 'desc');
    }

    private function getStats($remDoc)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        $base = DB::table('recibido')
            ->where('nit_empresa', $nitEmpresa)
            ->where(function($q) use ($remDoc) {
                $q->where('doc_quien_registra', $remDoc)
                  ->orWhereNull('doc_quien_registra');
            });

        return [
            'total' => (clone $base)->count(),
            'rejected' => (clone $base)->where('id_estado_rec', 11)->count(),
            'resolved' => (clone $base)->whereIn('id_estado_rec', [9, 10, 14])->count(),
            'pending' => (clone $base)->whereNotIn('id_estado_rec', [9, 10, 11, 14])->count(),
        ];
    }

    private function syncRejected($remDoc)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        DB::table('recibido')
            ->where('nit_empresa', $nitEmpresa)
            ->where(function($q) use ($remDoc) {
                $q->where('doc_quien_registra', $remDoc)
                  ->orWhereNull('doc_quien_registra');
            })
            ->where('id_estado_rec', '!=', 11)
            ->whereIn('id_recibido', function($query) {
                $query->select('det_id_recibido')
                    ->from('detalle_recibido')
                    ->where('id_estado_rec', 11);
            })
            ->update(['id_estado_rec' => 11]);
    }

    public function getHistory($id)
    {
        try {
            $remitente = Auth::guard('remitente')->user();
            
            // Priority 1: Check if the ID is already a Radicado ID (recommended for unified processes)
            $isRadicado = DB::table('radicados')->where('id_radicado', $id)->exists();
            if ($isRadicado) {
                $radId = $id;
            } else {
                // Priority 2: Traditional ID lookup (Recibido or Envio)
                $radId = DB::table('recibido')->where('id_recibido', $id)->value('num_radicado_int');
                if (!$radId) {
                    $radId = DB::table('envio')->where('id_envio', $id)->value('num_radicado_int');
                }
            }

            if (!$radId) return response()->json([]);

            // 1. Initial Registrations (Incoming/Outgoing)
            $recibidos = DB::table('recibido as r')
                ->join('radicados as rad', 'r.num_radicado_int', '=', 'rad.id_radicado')
                ->leftJoin('remitente as rem', 'r.doc_quien_registra', '=', 'rem.rem_doc')
                ->where('r.num_radicado_int', $radId)
                ->select(
                    DB::raw("'registry' as type"),
                    'r.fecha_hora_recib as fecha',
                    DB::raw("COALESCE(rem.rem_nombres, 'Sistema') as nombres"),
                    DB::raw("COALESCE(rem.rem_apellidos, '') as apellidos"),
                    'rad.num_radicado',
                    DB::raw("'Ingreso a Ventanilla' as estado_nomb"),
                    'r.observaciones',
                    DB::raw("NULL as img")
                )->get();

            $envios = DB::table('envio as env')
                ->join('radicados as rad', 'env.num_radicado_int', '=', 'rad.id_radicado')
                ->leftJoin('remitente as rem', 'env.doc_quien_registra', '=', 'rem.rem_doc')
                ->where('env.num_radicado_int', $radId)
                ->select(
                    DB::raw("'registry' as type"),
                    'env.fecha as fecha',
                    DB::raw("COALESCE(rem.rem_nombres, 'Sistema') as nombres"),
                    DB::raw("COALESCE(rem.rem_apellidos, '') as apellidos"),
                    'rad.num_radicado',
                    DB::raw("'Registro de Salida/Respuesta' as estado_nomb"),
                    'env.asunto as observaciones',
                    DB::raw("NULL as img")
                )->get();

            // 2. Lifecycle transitions (Details)
            $detailsRec = DB::table('detalle_recibido as dr')
                ->join('recibido as r', 'dr.det_id_recibido', '=', 'r.id_recibido')
                ->leftJoin('estado as e', 'dr.id_estado_rec', '=', 'e.id_estado')
                ->leftJoin('empleado as emp', 'dr.det_doc_empleado', '=', 'emp.emple_doc')
                ->leftJoin('area as area_e', 'emp.emple_area', '=', 'area_e.id_area')
                ->leftJoin('remitente as rem_d', 'dr.det_doc_empleado', '=', 'rem_d.rem_doc')
                ->where('r.num_radicado_int', $radId)
                ->select(
                    DB::raw("'detail' as type"),
                    'dr.fecha_re as fecha',
                    DB::raw("COALESCE(emp.emple_nombres, rem_d.rem_nombres, 'Destinatario') as nombres"),
                    DB::raw("COALESCE(emp.emple_apellidos, rem_d.rem_apellidos, '') as apellidos"),
                    DB::raw("NULL as num_radicado"),
                    DB::raw("COALESCE(e.estado_nomb, 'Gestión') as estado_nomb"),
                    'dr.observaciones',
                    'area_e.area_nom as area_e',
                    'emp.emple_img as img',
                    'dr.id_estado_rec',
                    'dr.id_det_recibido',
                    'dr.archivo_res'
                )->get();

            $detailsEnv = DB::table('detalle_envio as de')
                ->join('envio as env', 'de.id_envio', '=', 'env.id_envio')
                ->leftJoin('estado as e', 'de.id_estado_rec', '=', 'e.id_estado')
                ->leftJoin('empleado as emp', 'de.id_quien_recibe', '=', 'emp.emple_doc')
                ->leftJoin('area as area_e', 'emp.emple_area', '=', 'area_e.id_area')
                ->where('env.num_radicado_int', $radId)
                ->select(
                    DB::raw("'detail' as type"),
                    'de.fecha_traslado as fecha',
                    DB::raw("COALESCE(emp.emple_nombres, 'Funcionario') as nombres"),
                    DB::raw("COALESCE(emp.emple_apellidos, '') as apellidos"),
                    DB::raw("NULL as num_radicado"),
                    DB::raw("COALESCE(e.estado_nomb, 'Saliente') as estado_nomb"),
                    'de.observaciones',
                    'area_e.area_nom as area_e',
                    'emp.emple_img as img',
                    'de.id_estado_rec',
                    DB::raw("de.id_detalle as id_det_recibido"),
                    DB::raw("NULL as archivo_res")
                )->get();

            // 3. Merge and cleanup
            $historyCollection = $recibidos
                ->concat($envios)
                ->concat($detailsRec)
                ->concat($detailsEnv)
                ->sortBy('fecha');

            $finalHistory = [];
            foreach ($historyCollection as $h) {
                $item = (array) $h;
                
                if (!empty($item['id_det_recibido'])) {
                    $item['anexos'] = DB::table('anexo_respuesta')
                        ->where('id_detalle', $item['id_det_recibido'])
                        ->select('ruta_archivo', 'nombre_original')
                        ->get();
                } else {
                    $item['anexos'] = [];
                }

                if (!empty($item['observaciones'])) {
                    $item['observaciones'] = preg_replace('/^(CC|TI|CE|NIT|PAS|PEP)\s*[\d\.\-]+\s*-\s*/i', '', $item['observaciones']);
                }
                    
                $finalHistory[] = $item;
            }

            return response()->json($finalHistory);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna el historial de trazabilidad de un Envio (interno/saliente)
     * en el mismo formato que getHistory() para reutilizar el historyModal.
     */
    public function getHistoryEnvio($id)
    {
        return $this->getHistory($id);
    }

    public function exportHistoryPdf(Request $request, $id)
    {
        $tipo = $request->query('tipo', 'recibido');
        
        $historyResponse = $tipo === 'envio' ? $this->getHistoryEnvio($id) : $this->getHistory($id);
        $history = json_decode($historyResponse->content(), true);
        
        if (empty($history)) {
            return redirect()->back()->with('error', 'No se encontró historial para generar el PDF.');
        }

        $radicado = $history[0]['num_radicado'] ?? 'S/R';
        if ($radicado === 'S/R' || !$radicado) {
            foreach($history as $h) {
                if (!empty($h['num_radicado'])) {
                    $radicado = $h['num_radicado'];
                    break;
                }
            }
        }
        $asunto = $history[0]['observaciones'] ?? 'Sin Asunto';
        
        try {
            $pdf = Pdf::loadView('remitente.pdf.trazabilidad_pdf', compact('history', 'radicado', 'asunto', 'tipo'))->setPaper('A4', 'portrait');
            return $pdf->download('Trazabilidad_Radicado_' . $radicado . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF de Trazabilidad: ' . $e->getMessage());
        }
    }

    public function finalize($id)
    {
        $remitente = Auth::guard('remitente')->user();
        
        $recibido = Recibido::where('id_recibido', $id)
            ->where('doc_quien_registra', $remitente->rem_doc)
            ->firstOrFail();

        $recibido->id_estado_rec = 10; // Archivado/Finalizado
        $recibido->save();

        // Also mark details as resolved if they were rejected
        DB::table('detalle_recibido')
            ->where('det_id_recibido', $id)
            ->where('id_estado_rec', 11)
            ->update(['id_estado_rec' => 10]);

        return redirect()->back()->with('success', 'Correspondencia finalizada exitosamente.');
    }

    public function updateRejected(Request $request, $id)
    {
        $remitente = Auth::guard('remitente')->user();
        
        $recibido = Recibido::where('id_recibido', $id)
            ->where('doc_quien_registra', $remitente->rem_doc)
            ->firstOrFail();

        $request->validate([
            'asunto'        => 'required|string|max:100',
            'observaciones' => 'nullable|string|max:250',
            'destinatarios' => 'required|array',
            'destinatarios.*' => 'required|string|exists:empleado,emple_doc',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Existing Record
            $recibido->asunto = $request->asunto;
            $recibido->observaciones = $request->observaciones;
            $recibido->id_estado_rec = 12; // Enviado (Restart cycle)
            $recibido->save();

            // 2. Mark ALL previous assignment records as "Resuelto/Histórico" (9) 
            // to ensure a clean slate for the new cycle and hide stale recipients.
            DB::table('detalle_recibido')
                ->where('det_id_recibido', $id)
                ->whereIn('id_estado_rec', [7, 8, 10, 11, 12]) // All active/transitory states from previous cycle
                ->update(['id_estado_rec' => 9]);

            // 3. Create NEW Details for the new cycle (Sequence: 12 then 7)
            foreach ($request->destinatarios as $docEmpleado) {
                // First: 12 (Enviado) - Records the act of sending
                DB::table('detalle_recibido')->insert([
                    'det_id_recibido'  => $id,
                    'det_doc_empleado' => $docEmpleado,
                    'fecha_re'         => now()->subSecond(), // Slight offset to ensure order in history
                    'id_estado_rec'    => 12, // Enviado
                    'observaciones'    => 'Correspondencia re-enviada tras corrección.',
                ]);

                // Second: 7 (Recibido) - Current active state for the employee
                DB::table('detalle_recibido')->insert([
                    'det_id_recibido'  => $id,
                    'det_doc_empleado' => $docEmpleado,
                    'fecha_re'         => now(),
                    'id_estado_rec'    => 7, // Recibido/Inicial
                    'observaciones'    => 'Recibido para nueva gestión tras corrección: ' . ($request->observaciones ?? 'Sin detalle adicional'),
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Correspondencia corregida y re-enviada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar: ' . $e->getMessage());
        }
    }

    public function storeSalienteFromResponse(Request $request, $id)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;
        $docQuienRegistra = $remitente ? $remitente->rem_doc : null;

        $recibido = Recibido::where('id_recibido', $id)
            ->where('nit_empresa', $nitEmpresa)
            ->firstOrFail();

        $request->validate([
            'destino'         => 'required|string|max:255',
            'asunto'          => 'required|string|max:500',
            'doc_quien_envia' => 'nullable|string|max:20',
            'id_tipo_envio'   => 'required|integer',
            'folio'           => 'required|integer|min:1',
            'correo'          => 'nullable|email|max:150',
        ]);

        $docQuienEnvioAuto = $docQuienRegistra;

        // Ensure doc_quien_envia exists in empleado table to avoid FK error
        $senderId = $request->doc_quien_envia ?? $docQuienEnvioAuto;
        $existsInEmpleado = DB::table('empleado')->where('emple_doc', $senderId)->exists();
        
        if (!$existsInEmpleado) {
            // Find any valid official from this company as proxy (rol 1 or 3)
            $proxy = DB::table('empleado')
                ->where('nit_empresa', $nitEmpresa)
                ->orderByRaw("FIELD(emple_rol, 3, 1) DESC") // Preferrol 3 then 1
                ->first();
            if ($proxy) {
                $senderId = $proxy->emple_doc;
            }
        }

        DB::beginTransaction();
        try {
            // Use the original radicado record from the correspondence base
            $radicadoId = $recibido->num_radicado_int;
            $numRadicado = $recibido->radicado?->num_radicado ?? 'S/R';

            // Identify the response file and annexes
            $responseDetail = $recibido->detalles()->whereNotNull('archivo_res')->first();
            $archivoPrincipal = $responseDetail ? $responseDetail->archivo_res : '';
            
            // Create Envio
            $envio = Envio::create([
                'num_radicado_int'   => $radicadoId,
                'asunto'             => $request->asunto,
                'destino'            => $request->destino,
                'doc_quien_envia'    => $senderId,
                'fecha'              => now(),
                'folio'              => $request->folio,
                'id_tipo_envio'      => $request->id_tipo_envio,
                'id_estado_envio'    => 12, // Enviado
                'archivo'            => $archivoPrincipal,
                'nit_empresa'        => $nitEmpresa,
                'doc_quien_registra' => $docQuienRegistra,
                'correo_persona'     => $request->correo,
            ]);

            // 4. Transfer Annexes if they exist
            if ($responseDetail) {
                $annexes = DB::table('anexo_respuesta')
                    ->where('id_detalle', $responseDetail->id_det_recibido)
                    ->get();
                
                foreach ($annexes as $annex) {
                    DB::table('anexo_envio')->insert([
                        'id_envio'        => $envio->id_envio,
                        'ruta_archivo'    => $annex->ruta_archivo,
                        'nombre_original' => $annex->nombre_original,
                    ]);
                }
            }

            // 5. Mark the received correspondence as Finalized (9)
            if ($recibido->id_estado_rec != 10) {
                $recibido->id_estado_rec = 9; 
                $recibido->save();

                // 6. Log traceability entry with Technical Responsible for FK
                $responsableTecnico = DB::table('empleado')
                    ->where('nit_empresa', $nitEmpresa)
                    ->orderBy('emple_rol', 'asc')
                    ->first();
                $idResponsable = $responsableTecnico ? $responsableTecnico->emple_doc : 999000;

                DetalleRecibido::create([
                    'det_id_recibido'  => $recibido->id_recibido,
                    'det_doc_empleado' => $idResponsable,
                    'fecha_re'         => now(),
                    'id_estado_rec'    => 9,
                    'observaciones'    => "Respuesta enviada al ciudadano y radicado finalizado por (Remitente) {$remitente->rem_nombres} {$remitente->rem_apellidos}.",
                    'visto'            => 1
                ]);
            }

            // 7. Commit and Notify
            DB::commit();

            if ($envio->correo_persona) {
                try {
                    \Illuminate\Support\Facades\Log::info("Enviando correo de notificación a: {$envio->correo_persona} para el radicado: {$numRadicado}");
                    \Illuminate\Support\Facades\Mail::to($envio->correo_persona)->send(new \App\Mail\CorrespondenciaSalienteNotification($envio));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Error sending dispatch notification: " . $e->getMessage());
                }
            }

            return redirect()->back()->with('success', 'Respuesta registrada exitosamente bajo el radicado: ' . $numRadicado);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar envío: ' . $e->getMessage());
        }
    }

    public function storeSalienteFromEnvio(Request $request, $id)
    {
        $remitente = Auth::guard('remitente')->user();
        $nitEmpresa = $remitente ? $remitente->nit_empresa : null;

        $envio = \App\Models\Envio::where('id_envio', $id)
            ->where('nit_empresa', $nitEmpresa)
            ->firstOrFail();

        $request->validate([
            'destino' => 'required|string|max:200',
            'asunto'  => 'required|string|max:100',
            'correo'  => 'nullable|email|max:150',
            'observaciones' => 'nullable|string|max:250',
        ]);

        DB::beginTransaction();
        try {
            $currentYear = date('Y');
            $radicado = $envio->radicado;
            $radicadoId = $radicado ? $radicado->id_radicado : null;

            $envio->destino = $request->destino;
            $envio->asunto = $request->asunto;
            
            $obs = $request->observaciones ?? '';
            if ($request->filled('correo')) {
                $envio->correo_persona = $request->correo;
                $obs = trim($obs . ' [Correo Notificación: ' . $request->correo . ']');
            }
            $envio->observaciones = substr($obs, 0, 250);
            
            $envio->id_estado_envio = 9; // Terminado/Finalizado por Ventanilla
            // Asegurar responsable automático
            if (!$envio->doc_quien_envia) {
                $envio->doc_quien_envia = $remitente->rem_doc;
            }
            $envio->save();
            
            // Buscar un responsable técnico válido (Empleado) para satisfacer la FK de detalle_envio
            $responsableTecnico = DB::table('empleado')
                ->where('nit_empresa', $nitEmpresa)
                ->orderBy('emple_rol', 'asc')
                ->first();
            $idResponsable = $responsableTecnico ? $responsableTecnico->emple_doc : 999000;

            // Verificar si el documento del remitente existe en empleados para evitar fallo de FK
            $docSenderTrace = $remitente->rem_doc;
            if (!DB::table('empleado')->where('emple_doc', $docSenderTrace)->exists()) {
                $docSenderTrace = $idResponsable;
            }

            // Log trazabilidad (Cierre por Ventanilla)
            DB::table('detalle_envio')->insert([
                'id_envio'        => $envio->id_envio,
                'id_quien_envie'  => $docSenderTrace,
                'id_quien_recibe' => $idResponsable,
                'fecha_traslado'  => now(),
                'id_estado_rec'   => 9,
                'observaciones'   => "Correspondencia despachada y radicado finalizado por (Remitente) {$remitente->rem_nombres} {$remitente->rem_apellidos}."
            ]);

            DB::commit();
            
            // Send Notification Email if requested
            if ($envio->correo_persona) {
                try {
                    \Illuminate\Support\Facades\Mail::to($envio->correo_persona)->send(new \App\Mail\CorrespondenciaSalienteNotification($envio));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Error sending dispatch notification (from envio): " . $e->getMessage());
                }
            }
            
            return redirect()->back()->with('success', 'Envío procesado exitosamente. Radicado: ' . ($envio->radicado ? $envio->radicado->num_radicado : 'N/A'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar el envío: ' . $e->getMessage());
        }
    }

    /**
     * Reportes de gestión para el Remitente (Scoped by NIT)
     */
    public function reportes(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        if (!$remitente || !$remitente->nit_empresa) {
            return view('remitente.reportes', ['reporteAreas' => [], 'mensaje' => 'No estás registrado a una empresa.']);
        }

        $datos = $this->calcularReporteAreas($request);
        $reporteAreas = $datos['areas'];
        $resumenTipos = $datos['tipos'];

        $nitEmpresa = $remitente->nit_empresa;
        // Obtener áreas que tienen empleados en la empresa del remitente
        $areas = Area::whereExists(function($q) use ($nitEmpresa) {
            $q->select(\Illuminate\Support\Facades\DB::raw(1))
              ->from('empleado')
              ->whereColumn('empleado.emple_area', 'area.id_area')
              ->where('empleado.nit_empresa', $nitEmpresa);
        })->get();
        $tipos = \App\Models\Tipo::all();

        return view('remitente.reportes', compact('reporteAreas', 'resumenTipos', 'areas', 'tipos'));
    }

    /**
     * Exportar correspondencia filtrada a PDF (Módulo Remitente)
     */
    public function exportCorrespondenciaPdf(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        if (!$remitente) {
            return redirect()->back()->with('error', 'No autorizado.');
        }

        $remDoc  = $remitente->rem_doc;
        $nitEmpresa = $remitente->nit_empresa;

        // --- Build filtered query (same scope as getBaseQuery) ---
        $query = \App\Models\Recibido::with(['estado','tipo','radicado','destinatarios','ciudad'])
            ->where('nit_empresa', $nitEmpresa)
            ->where(function($q) use ($remDoc) {
                $q->where('doc_quien_registra', $remDoc)
                  ->orWhereNull('doc_quien_registra');
            });

        $filtrosActivos = [];

        // Filter: desde
        if ($request->filled('desde')) {
            $query->whereDate('fecha_hora_recib', '>=', $request->desde);
            $filtrosActivos['Desde'] = \Carbon\Carbon::parse($request->desde)->format('d/m/Y');
        }

        // Filter: hasta
        if ($request->filled('hasta')) {
            $query->whereDate('fecha_hora_recib', '<=', $request->hasta);
            $filtrosActivos['Hasta'] = \Carbon\Carbon::parse($request->hasta)->format('d/m/Y');
        }

        // Filter: area (by destinatario employee's area)
        if ($request->filled('area_id')) {
            $query->whereHas('destinatarios', function($q) use ($request) {
                $q->where('emple_area', $request->area_id);
            });
            $area = Area::find($request->area_id);
            $filtrosActivos['Área'] = $area->area_nom ?? 'ID '.$request->area_id;
        }

        // Filter: tipo de documento
        if ($request->filled('tipo_id')) {
            $query->where('id_tipo', $request->tipo_id);
            $tipo = \App\Models\Tipo::find($request->tipo_id);
            $filtrosActivos['Tipo Doc.'] = $tipo->tipo_nombre ?? 'ID '.$request->tipo_id;
        }

        // Filter: estado
        if ($request->filled('estado_id')) {
            $query->where('id_estado_rec', $request->estado_id);
            $estado = \App\Models\Estado::find($request->estado_id);
            $filtrosActivos['Estado'] = $estado->estado_nomb ?? 'ID '.$request->estado_id;
        }

        $correspondencias = $query->orderBy('fecha_hora_recib', 'desc')->get();

        // Stats
        $totalRegistros  = $correspondencias->count();
        $totalEnProceso  = $correspondencias->whereNotIn('id_estado_rec', [9,10,11,14])->count();
        $totalFinalizados = $correspondencias->whereIn('id_estado_rec', [9,10,14])->count();
        $totalRechazados = $correspondencias->where('id_estado_rec', 11)->count();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('remitente.pdf.correspondencia_reporte_pdf', compact(
            'correspondencias','filtrosActivos',
            'totalRegistros','totalEnProceso','totalFinalizados','totalRechazados'
        ))->setPaper('A4', 'landscape');

        $filename = 'Reporte_Correspondencia_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportPdf(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        if (!$remitente || !$remitente->nit_empresa) {
            return redirect()->back()->with('error', 'No estás registrado a una empresa.');
        }

        $datos = $this->calcularReporteAreas($request);
        $reporteAreas  = $datos['areas'];
        $resumenTipos  = $datos['tipos'];
        $barChart      = $request->input('barChart');
        $doughnutChart = $request->input('doughnutChart');

        // Compute totals for the PDF
        $totalAsignados  = collect($reporteAreas)->sum('asignados');
        $totalTramite    = collect($reporteAreas)->sum('tramite');
        $totalFinalizado = collect($reporteAreas)->sum('finalizado');
        $totalVencidos   = collect($reporteAreas)->sum('vencidos');
        $eficienciaGlobal = $totalAsignados > 0 ? round(($totalFinalizado / $totalAsignados) * 100) : 0;

        // Build filter label for the PDF header
        $periodo = $request->input('periodo', 'todo');
        $filtroLabel = match($periodo) {
            'dia'       => 'Día: ' . ($request->fecha ? \Carbon\Carbon::parse($request->fecha)->format('d/m/Y') : '—'),
            'mes'       => 'Mes: ' . ($request->mes ?? '—'),
            'trimestre' => 'Trimestre ' . ($request->trimestre ?? '—') . ' (' . ($request->ano ?? date('Y')) . ')',
            'ano'       => 'Año: ' . ($request->ano ?? date('Y')),
            default     => 'Histórico Completo',
        };

        $pdf = Pdf::loadView('remitente.pdf.reporte_gestion_pdf', compact(
            'reporteAreas', 'resumenTipos',
            'barChart', 'doughnutChart',
            'totalAsignados', 'totalTramite', 'totalFinalizado', 'totalVencidos',
            'eficienciaGlobal', 'filtroLabel'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('reporte_gestion_remitente.pdf');
    }

    private function calcularReporteAreas(Request $request)
    {
        $remitente = Auth::guard('remitente')->user();
        $nit = $remitente->nit_empresa;
        $periodo = $request->input('periodo');

        // Subquery for the latest internal detail per document/recipient
        $latestInternalSubquery = DetalleEnvio::select(DB::raw('MAX(id_detalle) as id_detalle'))
            ->groupBy('id_envio', 'id_quien_recibe');

        $areas = Area::all();
        $reporteAreas = [];
        $resumenTipos = [
            'Interna' => 0,
            'Externa' => 0,
            'Saliente' => 0
        ];

        foreach ($areas as $area) {
            $empleadosDocs = Empleado::where('emple_area', $area->id_area)
                ->where('nit_empresa', $nit)
                ->pluck('emple_doc');

            if ($empleadosDocs->isEmpty()) continue;

            // --- 1. INTERNAL CORRESPONDENCE (Envio) ---
            $queryInterna = DetalleEnvio::whereIn('id_quien_recibe', $empleadosDocs)
                ->whereIn('id_detalle', $latestInternalSubquery)
                ->with(['envio.tipoEnvio', 'envio.radicado'])
                ->whereHas('envio', fn($q) => $q->where('nit_empresa', $nit));

            if ($periodo && $periodo != 'todo') {
                $queryInterna->whereHas('envio', function ($q) use ($request, $periodo) {
                    $this->applyDateFilters($q, $request, $periodo, 'fecha');
                });
            }

            // --- 2. EXTERNAL CORRESPONDENCE (Recibido) ---
            $queryExterna = DetalleRecibido::whereIn('det_doc_empleado', $empleadosDocs)
                ->with(['recibido.tipo'])
                ->whereHas('recibido', fn($q) => $q->where('nit_empresa', $nit));

            if ($periodo && $periodo != 'todo') {
                $queryExterna->whereHas('recibido', function ($q) use ($request, $periodo) {
                    $this->applyDateFilters($q, $request, $periodo, 'fecha_hora_recib');
                });
            }

            $detallesInternos = $queryInterna->get();
            $detallesExternos = $queryExterna->get();

            // Categorization by type — safe null access
            foreach ($detallesInternos as $det) {
                $prefijo = substr($det->envio?->radicado?->num_radicado ?? '', 0, 3);
                if ($prefijo === 'SAL') $resumenTipos['Saliente']++;
                else $resumenTipos['Interna']++;
            }
            foreach ($detallesExternos as $det) {
                $resumenTipos['Externa']++;
            }

            $totalAsignados = $detallesInternos->count() + $detallesExternos->count();
            $countTramite = 0;
            $countFinalizado = 0;
            $countVencidos = 0;

            $allDetails = $detallesInternos->concat($detallesExternos);

            foreach ($allDetails as $det) {
                $idEstado = $det->id_estado_rec;
                
                if ($idEstado == 8) {
                    $countTramite++;
                } elseif (in_array($idEstado, [9, 10, 11])) {
                    $countFinalizado++;
                }

                $doc = $det instanceof DetalleEnvio ? $det->envio : $det->recibido;
                if ($doc) {
                    $tipo = $det instanceof DetalleEnvio ? ($doc->tipoEnvio) : ($doc->tipo);
                    $diasTotales = $tipo?->dias_respuesta ?? 0;
                    if ($diasTotales > 0 && !in_array($idEstado, [9, 10, 11])) {
                        $fechaBase = $det instanceof DetalleEnvio ? $doc->fecha : $doc->fecha_hora_recib;
                        if ($fechaBase) {
                            try {
                                $diasTranscurridos = Carbon::parse($fechaBase)->diffInDaysFiltered(fn(Carbon $d) => $d->isWeekday(), Carbon::now());
                                if (($diasTotales - $diasTranscurridos) < 0) {
                                    $countVencidos++;
                                }
                            } catch (\Exception $e) {
                                // skip invalid dates
                            }
                        }
                    }
                }
            }

            $reporteAreas[] = [
                'area_nom'   => $area->area_nom,
                'asignados'  => $totalAsignados,
                'tramite'    => $countTramite,
                'finalizado' => $countFinalizado,
                'vencidos'   => $countVencidos,
                'eficiencia' => $totalAsignados > 0 ? round(($countFinalizado / $totalAsignados) * 100) : 0
            ];
        }

        return [
            'areas' => $reporteAreas,
            'tipos' => $resumenTipos
        ];
    }

    private function applyDateFilters($query, Request $request, $periodo, $dateColumn)
    {
        if ($periodo == 'dia' && $request->fecha) {
            $query->whereDate($dateColumn, $request->fecha);
        } elseif ($periodo == 'mes' && $request->mes) {
            $query->whereYear($dateColumn, substr($request->mes, 0, 4))
                  ->whereMonth($dateColumn, substr($request->mes, 5, 2));
        } elseif ($periodo == 'trimestre' && $request->trimestre && $request->ano) {
            $query->whereYear($dateColumn, $request->ano);
            if ($request->trimestre == 1) $query->whereBetween(DB::raw("MONTH($dateColumn)"), [1, 3]);
            elseif ($request->trimestre == 2) $query->whereBetween(DB::raw("MONTH($dateColumn)"), [4, 6]);
            elseif ($request->trimestre == 3) $query->whereBetween(DB::raw("MONTH($dateColumn)"), [7, 9]);
            elseif ($request->trimestre == 4) $query->whereBetween(DB::raw("MONTH($dateColumn)"), [10, 12]);
        } elseif ($periodo == 'ano' && $request->ano) {
            $query->whereYear($dateColumn, $request->ano);
        }
    }
}

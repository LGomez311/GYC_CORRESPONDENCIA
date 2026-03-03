<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Traemos todas las empresas con sus relaciones hasta llegar a licencias
        $empresas = Empresa::with([
            'empleados.pagos' => function ($q) {
                $q->whereHas('estado', function($e) {
                    $e->where('estado_nomb', 'Aprobado')->orWhere('id_estado', 1); // asumiendo estado aprobado
                })->orWhere('id_est_pago', '!=', 0); // fallback simple
            },
            'empleados.pagos.plan'
            // no podemos hacer direct eager load de licencias a menos que exista la relación en Pago. 
            // Espera, revisamos App\Models\Pago y no vi la relación `licencias` declarada. 
            // Mejor hagámoslo manual o asumiendo que Licencia tiene id_pago.
        ])->get();

        // Para evitar errores si la relación no está bien definida en Pago:
        // Buscamos todas las licencias y las mapeamos por los roles administrativos

        $totalEmpresas = Empresa::count();
        $activas = 0;
        $inactivasOsinLicencia = 0;
        $proximasAVencer = 0; 
        
        $hoy = Carbon::now();

        // Obtener la "mejor" licencia para cada empresa para sacar las estadísticas
        $estadoEmpresas = [];

        $todasLasEmpresas = Empresa::all();
        foreach($todasLasEmpresas as $empresa) {
            $estadoEmpresas[$empresa->nit_empresa] = [
                'empresa' => $empresa,
                'mejor_licencia' => null,
                'tiene_licencia' => false,
                'dias_restantes' => 0,
                'vence_pronto' => false,
                'activa' => false
            ];
        }

        // Revisar todas las licencias
        $todasLicencias = \App\Models\Licencia::with(['pago.admin.empresa'])->get();
        
        foreach ($todasLicencias as $licencia) {
            if ($licencia->pago && $licencia->pago->admin && $licencia->pago->admin->empresa) {
                $nit = $licencia->pago->admin->empresa->nit_empresa;
                
                if (isset($estadoEmpresas[$nit])) {
                    $actual = $estadoEmpresas[$nit]['mejor_licencia'];
                    // Si no tiene o la nueva licencia es más lejana en el tiempo
                    if (!$actual || Carbon::parse($licencia->fecha_fin) > Carbon::parse($actual->fecha_fin)) {
                        $estadoEmpresas[$nit]['mejor_licencia'] = $licencia;
                        $estadoEmpresas[$nit]['tiene_licencia'] = true;
                    }
                }
            }
        }

        // Calcular stats
        foreach ($estadoEmpresas as $nit => &$datos) {
            if ($datos['tiene_licencia'] && $datos['mejor_licencia']) {
                $fin = Carbon::parse($datos['mejor_licencia']->fecha_fin);
                if ($fin->isAfter($hoy) || $fin->isSameDay($hoy)) {
                    $activas++;
                    $datos['activa'] = true;
                    $dias = (int) $hoy->diffInDays($fin);
                    $datos['dias_restantes_int'] = $dias; // Para filtrar
                    
                    if ($dias > 0) {
                        $diffString = $dias . ($dias === 1 ? ' día, ' : ' días, ') . $hoy->diff($fin)->format('%h horas');
                    } else {
                        $diffString = $hoy->diff($fin)->format('%h horas, %i minutos');
                    }
                    
                    $datos['dias_restantes'] = $diffString;
                    
                    if ($dias <= 15) { // Próximas a vencer en 15 días
                        $proximasAVencer++;
                        $datos['vence_pronto'] = true;
                    }
                } else {
                    $inactivasOsinLicencia++;
                }
            } else {
                $inactivasOsinLicencia++;
            }
        }

        // --- FILTRO Y ORDENAMIENTO DE LAS EMPRESAS ---
        $filtroDias = $request->input('dias_restantes');
        
        $empresasFiltradas = collect($estadoEmpresas)->filter(function($datos) use ($filtroDias) {
            if ($filtroDias !== null && $filtroDias !== '') {
                // Solo empresas que tienen licencia activa y coincida con el número exacto de días consultado
                if (!$datos['tiene_licencia'] || !$datos['activa']) {
                    return false;
                }
                return $datos['dias_restantes_int'] <= $filtroDias;
            }
            return true;
        })
        // Opcional: ordenar para que las próximas a vencer aparezcan primero
        ->sortBy('dias_restantes_int')->values();

        // --- PAGINATION (4 registros por página) ---
        $perPage = 4;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $items = $empresasFiltradas->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $empresasPaginadas = new LengthAwarePaginator($items, $empresasFiltradas->count(), $perPage, $currentPage, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
            'query' => $request->query() // Para que no pierda el filtro en los links
        ]);

        if ($request->ajax()) {
            return view('sadmin.partials.empresas_table', compact('empresasPaginadas'))->render();
        }

        return view('sadmin.index', compact(
            'totalEmpresas', 
            'activas',  
            'inactivasOsinLicencia', 
            'proximasAVencer',
            'empresasPaginadas',
            'filtroDias'
        ));
    }
}

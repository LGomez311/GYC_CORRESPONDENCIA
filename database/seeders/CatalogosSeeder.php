<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Rol;
use App\Models\Area;
use App\Models\Estado;
use App\Models\Prioridad;
use App\Models\Tipo;
use App\Models\Radicado;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $roles = [
            'SuperAdministrador', 'Administrador', 'Usuario Estandar'
        ];
        foreach ($roles as $r) {
            Rol::firstOrCreate(['rol_nom' => $r]);
        }

        // 2. Áreas
        $areas = [
            'Gerencia General', 'Recursos Humanos', 'Contabilidad', 'Correspondencia', 'Archivo Central', 'Oficina Asesora Juridica'
        ];
        foreach ($areas as $a) {
            Area::firstOrCreate(['area_nom' => $a]);
        }

        // 3. Estados
        $estados = [
            'Recibido', 'En Tramite', 'Resuelto', 'Archivado', 'Rechazado', 'Digitalizado'
        ];
        foreach ($estados as $e) {
            Estado::firstOrCreate(['estado_nomb' => $e]);
        }

        // 4. Prioridades
        $prioridades = [
            'Alta', 'Media', 'Baja', 'Urgente'
        ];
        foreach ($prioridades as $p) {
            Prioridad::firstOrCreate(['prioridad_nombre' => $p]);
        }

        // 5. Tipos de Documento
        $tipos = [
            ['nombre' => 'Derecho de Peticion', 'prioridad' => 'Urgente', 'dias' => 15],
            ['nombre' => 'Queja', 'prioridad' => 'Alta', 'dias' => 15],
            ['nombre' => 'Reclamo', 'prioridad' => 'Alta', 'dias' => 15],
            ['nombre' => 'Solicitud', 'prioridad' => 'Media', 'dias' => 10],
            ['nombre' => 'Carta', 'prioridad' => 'Baja', 'dias' => 5],
            ['nombre' => 'Memorando', 'prioridad' => 'Media', 'dias' => 5],
            ['nombre' => 'Circular', 'prioridad' => 'Baja', 'dias' => 5],
            ['nombre' => 'Resolucion', 'prioridad' => 'Media', 'dias' => 15],
            ['nombre' => 'Contrato', 'prioridad' => 'Alta', 'dias' => 10],
        ];
        
        foreach ($tipos as $t) {
            $prioridad = Prioridad::where('prioridad_nombre', $t['prioridad'])->first();
            
            Tipo::updateOrCreate(
                ['tipo_nombre' => $t['nombre']],
                [
                    'id_prioridad' => $prioridad ? $prioridad->id_prioridad : null,
                    'dias_respuesta' => $t['dias']
                ]
            );
        }

        // 6. Radicados de ejemplo (formato AGN colombiano)
        $estadoRecibido = Estado::where('estado_nomb', 'Recibido')->first();
        $estadoTramite = Estado::where('estado_nomb', 'En Tramite')->first();
        $estadoResuelto = Estado::where('estado_nomb', 'Resuelto')->first();

        if ($estadoRecibido && $estadoTramite && $estadoResuelto) {
            $radicados = [
                ['num_radicado' => '20261000000001', 'id_est_radicado' => $estadoRecibido->id_estado],
                ['num_radicado' => '20261000000002', 'id_est_radicado' => $estadoTramite->id_estado],
                ['num_radicado' => '20261000000003', 'id_est_radicado' => $estadoResuelto->id_estado],
                ['num_radicado' => '20261000000004', 'id_est_radicado' => $estadoRecibido->id_estado],
                ['num_radicado' => '20261000000005', 'id_est_radicado' => $estadoTramite->id_estado],
            ];

            foreach ($radicados as $rad) {
                Radicado::firstOrCreate(['num_radicado' => $rad['num_radicado']], $rad);
            }
        }
    }
}
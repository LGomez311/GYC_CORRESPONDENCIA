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
            ['nombre' => 'Solicitud', 'prioridad' => 'Media', 'dias' => 15],
            ['nombre' => 'Carta', 'prioridad' => 'Media', 'dias' => 15],
            ['nombre' => 'Memorando', 'prioridad' => 'Media', 'dias' => 5],
            ['nombre' => 'Circular', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Resolucion', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Contrato', 'prioridad' => 'Alta', 'dias' => 5],
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
        $radicados = [
            '20261000000001',
            '20261000000002',
            '20261000000003',
            '20261000000004',
            '20261000000005',
        ];

        $empresa = \App\Models\Empresa::first();
        $nitEmpresa = $empresa ? $empresa->nit_empresa : '1234567890';

        foreach ($radicados as $num) {
            Radicado::firstOrCreate(
                ['num_radicado' => $num],
                ['nit_empresa' => $nitEmpresa]
            );
        }
    }
}
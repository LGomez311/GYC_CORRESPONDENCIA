<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Estado;
use App\Models\Prioridad;
use App\Models\Radicado;
use App\Models\Rol;
use App\Models\Tipo;
use Illuminate\Database\Seeder;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $roles = [
            'SuperAdministrador', 'Administrador', 'Usuario Estandar',
        ];
        foreach ($roles as $r) {
            Rol::firstOrCreate(['rol_nom' => $r]);
        }

        // 2. Áreas
        $areas = [
            'Gerencia General', 'Recursos Humanos', 'Contabilidad', 'Correspondencia', 'Archivo Central', 'Oficina Asesora Juridica',
        ];
        foreach ($areas as $a) {
            Area::firstOrCreate(['area_nom' => $a]);
        }

        // 3. Estados
        $estados = [
            'Recibido', 'En Tramite', 'Resuelto', 'Archivado', 'Rechazado', 'Digitalizado',
        ];
        foreach ($estados as $e) {
            Estado::firstOrCreate(['estado_nomb' => $e]);
        }

        // 4. Prioridades
        $prioridades = [
            'Alta', 'Media', 'Baja', 'Urgente',
        ];
        foreach ($prioridades as $p) {
            Prioridad::firstOrCreate(['prioridad_nombre' => $p]);
        }

        // 5. Tipos de Documento
        $tipos = [
            // PQRS y Atención al Ciudadano (Ley 1755 y otros)
            ['nombre' => 'Derecho de Peticion', 'prioridad' => 'Urgente', 'dias' => 15],
            ['nombre' => 'Peticion de Informacion', 'prioridad' => 'Alta', 'dias' => 10],
            ['nombre' => 'Peticion de Consulta', 'prioridad' => 'Media', 'dias' => 30],
            ['nombre' => 'Queja', 'prioridad' => 'Alta', 'dias' => 15],
            ['nombre' => 'Reclamo', 'prioridad' => 'Alta', 'dias' => 15],
            ['nombre' => 'Denuncia', 'prioridad' => 'Urgente', 'dias' => 15],
            ['nombre' => 'Sugerencia', 'prioridad' => 'Media', 'dias' => 15],
            ['nombre' => 'Felicitacion', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Solicitud', 'prioridad' => 'Media', 'dias' => 15],

            // Comunicaciones Administrativas
            ['nombre' => 'Carta', 'prioridad' => 'Media', 'dias' => 15],
            ['nombre' => 'Oficio', 'prioridad' => 'Media', 'dias' => 15],
            ['nombre' => 'Memorando', 'prioridad' => 'Media', 'dias' => 5],
            ['nombre' => 'Circular', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Resolucion', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Decreto / Acuerdo', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Acta', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Informe', 'prioridad' => 'Media', 'dias' => 0],

            // Documentos Legales y Judiciales
            ['nombre' => 'Accion de Tutela', 'prioridad' => 'Urgente', 'dias' => 2], // Usualmente 48h
            ['nombre' => 'Notificacion Judicial', 'prioridad' => 'Urgente', 'dias' => 5],
            ['nombre' => 'Citacion', 'prioridad' => 'Urgente', 'dias' => 5],
            ['nombre' => 'Requerimiento', 'prioridad' => 'Urgente', 'dias' => 10],

            // Documentos Comerciales, Financieros y Contractuales
            ['nombre' => 'Factura Electronica', 'prioridad' => 'Alta', 'dias' => 3],
            ['nombre' => 'Cuenta de Cobro', 'prioridad' => 'Media', 'dias' => 5],
            ['nombre' => 'Cotizacion', 'prioridad' => 'Media', 'dias' => 5],
            ['nombre' => 'Orden de Compra', 'prioridad' => 'Alta', 'dias' => 3],
            ['nombre' => 'Contrato', 'prioridad' => 'Alta', 'dias' => 5],
            ['nombre' => 'Poliza / Garantia', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Propuesta / Licitacion', 'prioridad' => 'Alta', 'dias' => 5],
            ['nombre' => 'Comprobante Contable', 'prioridad' => 'Baja', 'dias' => 0],

            // Recursos Humanos
            ['nombre' => 'Incapacidad Medica', 'prioridad' => 'Urgente', 'dias' => 3],
            ['nombre' => 'Hoja de Vida', 'prioridad' => 'Baja', 'dias' => 0],
            ['nombre' => 'Carta de Renuncia', 'prioridad' => 'Alta', 'dias' => 1],
            ['nombre' => 'Solicitud Certificado Laboral', 'prioridad' => 'Media', 'dias' => 5],
        ];

        foreach ($tipos as $t) {
            $prioridad = Prioridad::where('prioridad_nombre', $t['prioridad'])->first();

            Tipo::updateOrCreate(
                ['tipo_nombre' => $t['nombre']],
                [
                    'id_prioridad' => $prioridad ? $prioridad->id_prioridad : null,
                    'dias_respuesta' => $t['dias'],
                    'requiere_respuesta' => $t['dias'] > 0 ? 1 : 0,
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

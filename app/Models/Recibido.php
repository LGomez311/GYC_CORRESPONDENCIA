<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tipo;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\Radicado;
use App\Models\Empleado;
use App\Models\Remitente;
use App\Models\Empresa;

class Recibido extends Model
{
    protected $table = 'recibido';
    protected $primaryKey = 'id_recibido';
    public $timestamps = false; // Based on SQL, no created_at/updated_at

    protected $fillable = [
        'num_radicado_ext',
        'num_radicado_int',
        'asunto',
        'fecha_hora_recib',
        'nom_institucion',
        'ciudad_proveniente',
        'folio',
        'anexo',
        'observaciones',
        'doc_quien_registra',
        'id_tipo',
        'id_estado_rec',
        'archivo',
        'nit_empresa'
    ];

    /**
     * Relación con Empleado (quien registra)
     */
    public function registradoPor()
    {
        return $this->belongsTo(Empleado::class, 'doc_quien_registra', 'emple_doc');
    }

    /**
     * Relación con Empleados (a quienes se dirige) a través de detalle_recibido
     */
    public function destinatarios()
    {
        return $this->belongsToMany(Empleado::class, 'detalle_recibido', 'det_id_recibido', 'det_doc_empleado');
    }

    /**
     * Accesor para mantener compatibilidad temporal con vistas que asumen un solo destinatario
     */
    public function getDirigidoAAttribute()
    {
        return $this->destinatarios->first();
    }

    /**
     * Relación con Tipo de correspondencia
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'id_tipo', 'id_tipo');
    }

    /**
     * Relación con Estado
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado_rec', 'id_estado');
    }

    /**
     * Relación con Ciudad
     */
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_proveniente', 'ciudad_cod_post');
    }

    /**
     * Relación con Radicado central (si existe)
     */
    public function radicado()
    {
        return $this->belongsTo(Radicado::class, 'num_radicado_int', 'id_radicado');

    }

    /**
     * Relación con los anexos
     */
    public function anexos()
    {
        return $this->hasMany(AnexoRecibido::class, 'id_recibido', 'id_recibido');

    }
}

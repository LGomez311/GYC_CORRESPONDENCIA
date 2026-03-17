<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table = 'envio';
    protected $primaryKey = 'id_envio';
    public $timestamps = false;

    protected $fillable = [
        'num_radicado_int',
        'asunto',
        'doc_quien_registra',
        'doc_quien_envia',
        'fecha',
        'destino',
        'folio',
        'id_tipo_envio',
        'id_estado_envio',
        'archivo',
        'nit_empresa',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    // Relación con Estado
    public function estadoEnvio()
    {
        return $this->belongsTo(Estado::class, 'id_estado_envio', 'id_estado');
    }

    // Relación con Tipo
    public function tipoEnvio()
    {
        return $this->belongsTo(Tipo::class, 'id_tipo_envio', 'id_tipo');
    }

    // Quien envía
    public function quienEnvia()
    {
        return $this->belongsTo(Empleado::class, 'doc_quien_envia', 'emple_doc');
    }

    public function quienRegistra()
    {
        return $this->belongsTo(Remitente::class, 'doc_quien_registra', 'rem_doc');
    }

    // Relación con el número de radicado interno generado
    public function radicado()
    {
        return $this->belongsTo(Radicado::class, 'num_radicado_int', 'id_radicado');
    }

    // Relación con los anexos
    public function anexos()
    {
        return $this->hasMany(AnexoEnvio::class, 'id_envio', 'id_envio');
    }

    // Relación con los detalles de seguimiento (destinatarios)
    public function detalles()
    {
        return $this->hasMany(DetalleEnvio::class, 'id_envio', 'id_envio');
    }

    /**
     * Relación con los empleados destinatarios
     */
    public function recipients()
    {
        return $this->belongsToMany(Empleado::class, 'detalle_envio', 'id_envio', 'id_quien_recibe')->distinct();
    }
}

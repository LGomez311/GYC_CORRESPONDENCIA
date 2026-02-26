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
        'doc_quien_dirigido',
        'doc_quien_envia',
        'fecha',
        'destino',
        'anexo',
        'id_tipo_envio',
        'id_estado_envio',
        'archivo',
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

    // Quien recibe
    public function quienDirigido()
    {
        return $this->belongsTo(Empleado::class, 'doc_quien_dirigido', 'emple_doc');
    }
}

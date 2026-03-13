<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleEnvio extends Model
{
    protected $table = 'detalle_envio';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false; // Using fecha_traslado instead

    protected $fillable = [
        'id_envio',
        'id_quien_envie',
        'id_quien_recibe',
        'fecha_traslado',
        'id_estado_rec',
        'observaciones',
        'archivo_respuesta',
        'folios_respuesta'
    ]; // Added by user for traceability

    protected $casts = [
        'fecha_traslado' => 'datetime',
    ];

    // The document details
    public function envio()
    {
        return $this->belongsTo(Envio::class, 'id_envio', 'id_envio');
    }

    // Sender
    public function quienEnvia()
    {
        return $this->belongsTo(Empleado::class, 'id_quien_envie', 'emple_doc');
    }

    // Receiver
    public function quienRecibe()
    {
        return $this->belongsTo(Empleado::class, 'id_quien_recibe', 'emple_doc');
    }

    // Status
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado_rec', 'id_estado');
    }

    // Archivos Respuesta Multiples (Interna usa id_det_interna)
    public function anexosRespuesta()
    {
        return $this->hasMany(AnexoRespuesta::class, 'id_det_interna', 'id_detalle');
    }
}

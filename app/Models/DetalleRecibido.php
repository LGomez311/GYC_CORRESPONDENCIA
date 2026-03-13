<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRecibido extends Model
{
    public $timestamps = false;

    protected $table = 'detalle_recibido';

    protected $primaryKey = 'id_det_recibido';

    protected $fillable = [
        'det_id_recibido',
        'det_doc_empleado',
        'fecha_re',
        'id_estado_rec',
        'observaciones',
        'archivo_res',
        'folios_res',
    ];

    // Relación con el registro de recibido (documento principal)
    public function recibido()
    {
        return $this->belongsTo(Recibido::class, 'det_id_recibido', 'id_recibido');
    }

    // Estado propio del empleado en este detalle
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado_rec', 'id_estado');
    }

    // Empleado destinatario
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'det_doc_empleado', 'emple_doc');
    }

    // Anexos de respuesta para externa
    public function anexosRespuesta()
    {
        return $this->hasMany(AnexoRespuesta::class, 'id_detalle', 'id_det_recibido');
    }
}

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
    ];

    // Relación con recibido
    public function recibido()
    {
        return $this->belongsTo(Recibido::class, 'det_id_recibido', 'id_recibido');
    }

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'det_doc_empleado', 'emple_doc');
    }
}

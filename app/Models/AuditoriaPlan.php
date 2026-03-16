<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaPlan extends Model
{
    protected $table = 'auditoria_plan';
    protected $primaryKey = 'id_log';

    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false; // La tabla ya maneja `fecha_cambio` con current_timestamp()

    protected $fillable = [
        'id_plan_afectado',
        'usuario_app',
        'usuario_bd',
        'accion',
        'fecha_cambio',
        'datos_anteriores',
        'datos_nuevos',
    ];

    protected $casts = [
        'fecha_cambio' => 'datetime',
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
    ];

    // Relación con el plan afectado
    public function planAfectado()
    {
        return $this->belongsTo(Plan::class, 'id_plan_afectado', 'id_plan');
    }

    // Relación con el empleado (administrador) que realizó el cambio en el sistema
    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'usuario_app', 'emple_doc');
    }
}

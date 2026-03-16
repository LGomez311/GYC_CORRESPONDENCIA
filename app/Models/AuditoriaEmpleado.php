<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaEmpleado extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auditoria_empleado';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_log';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; // We are tracking time with 'fecha_cambio', eloquent timestamps are not used

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doc_empleado_afectado',
        'usuario_app',
        'usuario_bd',
        'accion',
        'fecha_cambio',
        'datos_anteriores',
        'datos_nuevos',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha_cambio' => 'datetime',
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
    ];

    /**
     * Get the affected employee.
     */
    public function empleadoAfectado()
    {
        return $this->belongsTo(Empleado::class, 'doc_empleado_afectado', 'emple_doc');
    }

    /**
     * Get the app user who made the change.
     */
    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'usuario_app', 'emple_doc');
    }
}

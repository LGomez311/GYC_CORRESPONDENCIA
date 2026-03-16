<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaLicencia extends Model
{
    protected $table = 'auditoria_licencia';
    protected $primaryKey = 'id_log';

    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false; // La tabla ya maneja `fecha_cambio` con current_timestamp()

    protected $fillable = [
        'id_licencia_afectada',
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

    // Relación con la licencia afectada
    public function licenciaAfectada()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia_afectada', 'id_licencia');
    }

    // Relación con el empleado (administrador) que realizó el cambio en el sistema
    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'usuario_app', 'emple_doc');
    }
}

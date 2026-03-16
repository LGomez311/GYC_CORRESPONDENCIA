<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaEmpresa extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auditoria_empresa';

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
    public $timestamps = false; // We use 'fecha_cambio' natively

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nit_empresa_afectada',
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
     * Get the affected company.
     */
    public function empresaAfectada()
    {
        return $this->belongsTo(Empresa::class, 'nit_empresa_afectada', 'nit_empresa');
    }

    /**
     * Get the app user who made the change.
     */
    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'usuario_app', 'emple_doc');
    }
}

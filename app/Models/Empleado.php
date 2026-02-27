<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Rol;
use App\Models\Estado;


class Empleado extends Authenticatable
{
    use Notifiable;

    protected $table = 'empleado';
    protected $primaryKey = 'emple_doc';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'emple_doc',
        'nit_empresa',
        'password',
        'emple_nombres',
        'emple_apellidos',
        'emple_tel',
        'emple_correo',
        'emple_img',
        'emple_estado',
        'emple_rol',
        'emple_area'
    ];


    protected $hidden = [
        'password', // Evita mostrar la contraseña en JSON
    ];

    /**
     * Laravel usará esta columna para autenticación
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Relaciones
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'emple_estado', 'id_estado');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'emple_rol', 'id_rol');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'nit_empresa');
    }


    public $timestamps = false;

    public function pagos()
    {
        return $this->hasMany(
            \App\Models\Pago::class,
            'id_admin',   // FK en pagos
            'emple_doc'   // PK en empleado
        );
    }
    public function enviosEnviados()
    {
        return $this->hasMany(
            \App\Models\Envio::class,
            'doc_quien_envia',   // FK en envio
            'emple_doc'          // PK en empleado
        );
    }

    public function enviosRecibidos()
    {
        return $this->hasMany(
            \App\Models\Envio::class,
            'doc_quien_dirigido',  // FK en envio
            'emple_doc'            // PK en empleado
        );
    }
}

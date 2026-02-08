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
    protected $keyType = 'int';

    protected $fillable = [
        'emple_doc',
        'emple_nombres',
        'emple_apellidos',
        'emple_correo',
        'emple_estado',
        'emple_tel',
        'emple_area',
        'emple_rol',
        'password' // Debe coincidir con la columna de la DB
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
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'emple_rol', 'id_rol');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'emple_area', 'id_area');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'emple_estado', 'id_estado');
    }

    public $timestamps = false;
}

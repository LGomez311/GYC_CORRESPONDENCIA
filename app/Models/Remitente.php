<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Remitente extends Authenticatable
{
    use Notifiable;

    protected $table = 'remitente';
    protected $primaryKey = 'rem_doc';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'rem_doc',
        'rem_nombres',
        'rem_apellidos',
        'rem_correo',
        'rem_tel',
        'rem_ciudad',
        'password' // columna usada para autenticación
    ];

    protected $hidden = [
        'password', // oculta la contraseña en respuestas JSON
    ];

    /**
     * Laravel usará esta columna para autenticación
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Opcional: relación con ciudad
     */
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'rem_ciudad', 'ciudad_cod_post');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'nit_empresa', 'nit_empresa');
    }

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol'; // o 'roles' según tu BD
    protected $primaryKey = 'id_rol';
    public $timestamps = false;

    protected $fillable = [
        'rol_nom'
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'emple_rol', 'id_rol');
    }
}

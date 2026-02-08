<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estado';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'emple_estado', 'id_estado');
    }
}

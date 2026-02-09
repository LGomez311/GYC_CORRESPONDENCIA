<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area'; // o 'roles' según tu BD
    protected $primaryKey = 'id_area';
    public $timestamps = false;

    protected $fillable = [
        'area_nom'
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'area_nom', 'id_area');
    }
}
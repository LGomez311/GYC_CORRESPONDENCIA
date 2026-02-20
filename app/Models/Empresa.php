<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;
use App\Models\Empleado;


class Empresa extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'nit_empresa';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nit_empresa',
        'nomb_empresa',
        'direccion',
        'contacto',
        'empresa_correo',
        'doc_representante',
        'nomb_representante'
    ];

    // relacion de empleados con la empresa
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'nit_empresa', 'nit_empresa');
    }
}

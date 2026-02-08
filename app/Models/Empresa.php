<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'nit_empresa';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nit_empresa',
        'nomb_empresa',
        'direccion',
        'contacto',
        'empresa_correo',
    ];
}

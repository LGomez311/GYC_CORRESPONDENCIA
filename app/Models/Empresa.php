<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;


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
        'doc_representante',
        'nomb_representante',
        'direccion',
        'contacto',
        'empresa_correo',
    ];
}

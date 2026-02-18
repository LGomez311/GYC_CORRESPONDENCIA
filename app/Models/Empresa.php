<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;


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
        'id_representante',
        'direccion',
        'contacto',
        'empresa_correo'
    ];

    public function representante()
    {
        return $this->belongsTo(
            Empleado::class,
            'id_representante',
            'emple_doc'
        );
    }
    }

    

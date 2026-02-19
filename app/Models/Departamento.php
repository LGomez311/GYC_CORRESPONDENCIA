<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento'; // tu nombre real de tabla

    protected $primaryKey = 'id_departamento';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'dpto_nombre',
        'dpto_codigo_postal'
    ];

    public $timestamps = false; // si tu tabla no tiene created_at y updated_at
}

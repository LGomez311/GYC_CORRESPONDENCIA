<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';

    protected $primaryKey = 'dpto_codigo_postal';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'dpto_codigo_postal',
        'dpto_nombre'
    ];

    public function ciudades()
    {
        return $this->hasMany(\App\Models\Ciudad::class, 'ciudad_id_dpto', 'dpto_codigo_postal');
    }
}

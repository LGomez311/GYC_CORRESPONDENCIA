<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudad';

    protected $primaryKey = 'ciudad_cod_post';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ciudad_cod_post',
        'ciudad_nom',
        'ciudad_id_dpto'
    ];

    public function departamento()
    {
        return $this->belongsTo(
            Departamento::class,
            'ciudad_id_dpto',          
            'dpto_codigo_postal'       
        );
    }
}

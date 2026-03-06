<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Plan extends Model
{
    protected $table = 'plan';
    protected $primaryKey = 'id_plan';

    public $timestamps = false; 

    protected $fillable = [
        'nomb_plan',
        'valor',
        'duracion',
        'descripcion',
        'es_destacado',
    ];

    protected $casts = [
        'descripcion' => 'array',  
        'es_destacado' => 'boolean',
    ];
}

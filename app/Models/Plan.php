<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Plan extends Model
{
    protected $table = 'plan';
    protected $primaryKey = 'id_plan';

    public $timestamps = false; // no tiene created at or updated at

    protected $fillable = [
        'nomb_plan',
        'valor',
        'descripcion',
        'duracion',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model
{
    protected $table = 'prioridad';
    protected $primaryKey = 'id_prioridad';
    public $timestamps = false;

    protected $fillable = [
        'prioridad_nombre'
    ];
}

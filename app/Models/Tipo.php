<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipo';
    protected $primaryKey = 'id_tipo';
    public $timestamps = false;

    protected $fillable = [
        'tipo_nombre',
        'id_prioridad',
        'dias_respuesta',
        'requiere_respuesta'
    ];

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'id_prioridad', 'id_prioridad');
    }
}

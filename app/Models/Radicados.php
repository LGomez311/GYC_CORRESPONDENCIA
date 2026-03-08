<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radicado extends Model
{
    protected $table = 'radicados';
    protected $primaryKey = 'id_radicado';
    public $timestamps = false;

    protected $fillable = [
        'num_radicado',
        'id_est_radicado'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_est_radicado', 'id_estado');
    }
}
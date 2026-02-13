<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;

class Licencia extends Model
{
    protected $table = 'licencia';

    protected $primaryKey = 'id_licencia';

    public $timestamps = false;

    protected $fillable = [
        'nit_empresa',
        'id_plan',
        'id_pago',
        'id_estado',
        'fecha_inicio',
        'fecha_fin',
        'tipo_licencia',
        'licencia_origen',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }

    public function licenciaPadre()
    {
        return $this->belongsTo(Licencia::class, 'licencia_origen');
    }
}

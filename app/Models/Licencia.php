<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pago;
use App\Models\Estado;

class Licencia extends Model
{
    protected $table = 'licencia';
    protected $primaryKey = 'id_licencia';
    public $timestamps = false;

    protected $fillable = [
        'id_pago',
        'id_estado',
        'fecha_inicio',
        'fecha_fin',
        'tipo_licencia',
        'licencia_origen',
    ];

    // Licencia → Pago
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'id_pago');
    }

    // Licencia → Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    // Licencia padre (renovación)
    public function licenciaPadre()
    {
        return $this->belongsTo(Licencia::class, 'licencia_origen');
    }
}

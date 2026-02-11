<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos'; // nombre real de tu tabla
    protected $primaryKey = 'id_pago';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pago',
        'id_plan',
        'monto',
        'moneda',
        'id_est_pago',
        'fecha_pago'
    ];

    // Relaciones opcionales
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoPago::class, 'id_est_pago');
    }
}

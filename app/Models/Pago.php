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
        'nit_empresa',
        'fecha_pago',
        'comprobante',
    ];

    // Relaciones opcionales
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plan', );
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_est_pago');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}

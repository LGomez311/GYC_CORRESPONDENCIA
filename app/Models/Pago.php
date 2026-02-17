<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';

    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id_plan',
        'id_admin',
        'id_est_pago',
        'moneda',
        'fecha_pago',
        'fecha_inicio',
        'comprobante',
    ];

    // 🔹 Plan pagado
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }

    // 🔹 Estado del pago
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_est_pago');
    }

    // 🔹 Admin / empleado que realizó el pago
    public function admin()
    {
        return $this->belongsTo(Empleado::class, 'id_admin');
    }
}

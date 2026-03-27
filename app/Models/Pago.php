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
        'nit_empresa',
        'monto',
        'moneda',
        'fecha_pago',
        'fecha_inicio',
        'comprobante',
        'actualizado_por',
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

    // 🔹 Obtener la ruta segura del comprobante
    public function getRutaArchivoAttribute()
    {
        if (!$this->comprobante) return null;
        $data = json_decode($this->comprobante, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($data) && isset($data['ruta'])) {
            return $data['ruta'];
        }
        return $this->comprobante;
    }

    // 🔹 Obtener el motivo del rechazo
    public function getMotivoRechazoAttribute()
    {
        if (!$this->comprobante) return null;
        $data = json_decode($this->comprobante, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($data) && isset($data['motivo'])) {
            return $data['motivo'];
        }
        return null;
    }
}

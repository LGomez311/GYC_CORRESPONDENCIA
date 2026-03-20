<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pago;
use App\Models\Estado;
use Carbon\Carbon;

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
        'actualizado_por',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
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

    /**
     * Calcula los días restantes de la licencia
     */
    public function diasRestantes()
    {
        if (!$this->fecha_fin) {
            return 0;
        }

        $hoy = Carbon::now();
        $finalizacion = Carbon::parse($this->fecha_fin);

        if ($hoy->isAfter($finalizacion)) {
            return 0;
        }

        return (int) $hoy->diffInDays($finalizacion);
    }

    /**
     * Obtiene el tiempo restante desglosado en días, horas, minutos y segundos
     */
    public function getTiempoRestante()
    {
        if (!$this->fecha_fin) {
            return [
                'dias' => 0,
                'horas' => 0,
                'minutos' => 0,
                'segundos' => 0,
            ];
        }

        $hoy = Carbon::now();
        $finalizacion = Carbon::parse($this->fecha_fin);

        if ($hoy->isAfter($finalizacion)) {
            return [
                'dias' => 0,
                'horas' => 0,
                'minutos' => 0,
                'segundos' => 0,
            ];
        }

        $diff = $finalizacion->diff($hoy);

        return [
            'dias' => $diff->days,
            'horas' => $diff->h,
            'minutos' => $diff->i,
            'segundos' => $diff->s,
        ];
    }

    /**
     * Calcula la duración total de la licencia en días
     */
    public function duracionTotal()
    {
        if (!$this->fecha_inicio || !$this->fecha_fin) {
            return 0;
        }

        $inicio = Carbon::parse($this->fecha_inicio);
        $fin = Carbon::parse($this->fecha_fin);

        return $inicio->diffInDays($fin);
    }

    /**
     * Calcula el porcentaje de días restantes de la licencia
     */
    public function porcentajeDiasRestantes()
    {
        $duracionTotal = $this->duracionTotal();

        if ($duracionTotal === 0) {
            return 0;
        }

        $diasRestantes = $this->diasRestantes();
        $porcentaje = (int) (($diasRestantes / $duracionTotal) * 100);
        
        return min(100, max(0, $porcentaje));
    }

    /**
     * Verifica si la licencia está activa
     */
    public function estaActiva()
    {
        if (!$this->fecha_fin) {
            return false;
        }

        $hoy = Carbon::now();
        $finalizacion = Carbon::parse($this->fecha_fin);

        return $hoy->isBefore($finalizacion) || $hoy->isSameDay($finalizacion);
    }
}

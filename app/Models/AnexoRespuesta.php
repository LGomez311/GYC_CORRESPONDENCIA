<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnexoRespuesta extends Model
{
    protected $table = 'anexo_respuesta';
    protected $primaryKey = 'id_anexo_resp';
    public $timestamps = false; // Add created_at/updated_at if needed, but keeping it simple to match your DB style

    protected $fillable = [
        'id_detalle',
        'ruta_archivo',
        'nombre_original',
    ];

    public function detalleEnvio()
    {
        return $this->belongsTo(DetalleEnvio::class, 'id_detalle', 'id_detalle');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnexoEnvio extends Model
{
    protected $table = 'anexo_envio';
    protected $primaryKey = 'id_anexo';
    public $timestamps = false; // Add created_at/updated_at if needed, but keeping it simple to match your DB style

    protected $fillable = [
        'id_envio',
        'ruta_archivo',
        'nombre_original',
    ];

    public function envio()
    {
        return $this->belongsTo(Envio::class, 'id_envio', 'id_envio');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnexoRecibido extends Model
{
    protected $table = 'anexo_recibido';
    protected $primaryKey = 'id_anexo';
    public $timestamps = false; 

    protected $fillable = [
        'id_recibido',
        'ruta_archivo',
        'nombre_original',
    ];

    public function recibido()
    {
        return $this->belongsTo(Recibido::class, 'id_recibido', 'id_recibido');
    }
}

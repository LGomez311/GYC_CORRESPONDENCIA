<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordCode extends Model
{
    protected $fillable = [
        'emple_correo',
        'code',
        'expires_at'
    ];
}


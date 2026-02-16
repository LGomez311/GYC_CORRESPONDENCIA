<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LicenciaActiva
{
    public function handle(Request $request, Closure $next)
    {
        // 🚫 Sin validaciones
        // 🚫 Sin licencias
        // 🚫 Sin sesiones
        // 🚫 Sin redirecciones

        return $next($request);
    }
}

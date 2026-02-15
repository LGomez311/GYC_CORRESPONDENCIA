<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Licencia;
use Carbon\Carbon;

class LicenciaActiva
{
    public function handle(Request $request, Closure $next)
    {
        // 🔹 SuperAdmin libre
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->emple_rol == 1) {
            return $next($request);
        }

        // 🔹 Empleado / Admin
        if (Auth::guard('web')->check()) {

            $user = Auth::guard('web')->user();

            $licencia = Licencia::where('nit_empresa', $user->nit_empresa)
                ->where('id_estado', 1)
                ->where('fecha_fin', '>=', Carbon::now())
                ->first();

            if (!$licencia) {
                Auth::guard('web')->logout();

                return redirect()->route('login')
                    ->withErrors(['login' => 'Licencia inactiva o vencida']);
            }
        }

        // 🔹 Remitente
        if (Auth::guard('remitente')->check()) {

            $user = Auth::guard('remitente')->user();

            $licencia = Licencia::where('nit_empresa', $user->nit_empresa)
                ->where('id_estado', 1)
                ->where('fecha_fin', '>=', Carbon::now())
                ->first();

            if (!$licencia) {
                Auth::guard('remitente')->logout();

                return redirect()->route('login')
                    ->withErrors(['login' => 'Licencia inactiva o vencida']);
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Licencia;
use Illuminate\Support\Facades\Auth;

class LicenciaActiva
{
    public function handle(Request $request, Closure $next)
    {
        /**
         * 🔹 Si no hay sesión iniciada, continuar
         */
        if (!Auth::check() && !Auth::guard('remitente')->check()) {
            return $next($request);
        }

        /**
         * 🔹 Super Admin (rol 1) → nunca se bloquea
         */
        if (Auth::check() && Auth::user()->emple_rol == 1) {
            View::share('licenciaBloqueada', false);
            return $next($request);
        }

        /**
         * 🔹 Admin Empresa (rol 2) → NO se cierra sesión
         * Solo tendrá restricciones desde el sidebar
         */
        if (Auth::check() && Auth::user()->emple_rol == 2) {

            $licenciaActiva = Licencia::where('id_estado', 1)
                ->where('fecha_fin', '>=', now())
                ->exists();

            View::share('licenciaBloqueada', !$licenciaActiva);

            return $next($request);
        }

        /**
         * 🔹 Verificar licencia (para empleados y remitentes)
         */
        $licenciaActiva = Licencia::where('id_estado', 1)
            ->where('fecha_fin', '>=', now())
            ->exists();

        /**
         * ❌ Licencia vencida → cerrar sesión SOLO empleados y remitentes
         */
        if (!$licenciaActiva) {

            Auth::logout();
            Auth::guard('remitente')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'login' => 'La licencia de la empresa ha vencido'
            ]);
        }

        /**
         * 🔹 Licencia activa
         */
        View::share('licenciaBloqueada', false);

        return $next($request);
    }
}

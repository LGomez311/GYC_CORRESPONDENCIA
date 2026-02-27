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
        // 🔹 Si no hay sesión iniciada, continuar normalmente
        if (!Auth::check() && !Auth::guard('remitente')->check()) {
            return $next($request);
        }

        // 🔹 Super Admin (rol 1) → nunca se bloquea
        if (Auth::check() && Auth::user()->emple_rol == 1) {
            View::share('licenciaBloqueada', false);
            return $next($request);
        }

        // 🔹 Obtener la empresa del usuario actual
        $empresaId = null;
        if (Auth::check()) {
            $empresaId = Auth::user()->nit_empresa;
        } elseif (Auth::guard('remitente')->check()) {
            $empresaId = Auth::guard('remitente')->user()->nit_empresa;
        }

        // 🔹 Verificar que pertenezca a una empresa
        if (!$empresaId) {
            Auth::logout();
            Auth::guard('remitente')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'login' => 'No estás asociado a ninguna empresa'
            ]);
        }

        // 🔹 Verificar licencia activa mediante relaciones reales
        $licenciaActiva = Licencia::where('id_estado', 1)
            ->whereDate('fecha_fin', '>=', now())
            ->whereHas('pago', function ($query) use ($empresaId) {
                $query->whereHas('admin', function ($q) use ($empresaId) {
                    $q->where('nit_empresa', $empresaId);
                });
            })
            ->exists();

        // 🔹 Admin Empresa (rol 2) → entra siempre, solo restricciones visuales
        if (Auth::check() && Auth::user()->emple_rol == 2) {
            $licenciaBloqueada = !$licenciaActiva; // solo visual
            View::share('licenciaBloqueada', $licenciaBloqueada);
            return $next($request);
        }

        // 🔹 Empleados y remitentes (rol 3 u otros) → cerrar sesión si no hay licencia activa
        if (!$licenciaActiva) {
            Auth::logout();
            Auth::guard('remitente')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'login' => 'La licencia de la empresa ha vencido'
            ]);
        }

        // 🔹 Licencia activa → todo normal
        View::share('licenciaBloqueada', false);

        return $next($request);
    }
}
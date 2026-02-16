<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Licencia;
use Illuminate\Support\Facades\View;

class LicenciaActiva
{
    public function handle(Request $request, Closure $next)
    {
        /**
         * 🔹 SuperAdmin libre
         */
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->emple_rol == 1) {
            View::share('licenciaBloqueada', false);
            return $next($request);
        }

        /**
         * 🔹 ADMIN / USUARIO
         */
        if (Auth::guard('web')->check()) {

            $user = Auth::guard('web')->user();

            $licenciaActiva = Licencia::where('nit_empresa', $user->nit_empresa)
                ->where('id_estado', 1)
                ->where('fecha_fin', '>=', now())
                ->exists();

            // 🔑 Compartimos el estado SOLO para la vista
            View::share('licenciaBloqueada', !$licenciaActiva);


            // 🔑 PERMITIR SOLO ESTAS RUTAS CON LICENCIA VENCIDA
            $rutasPermitidas = [
                'admin.planes',
                'admin.historialp',
                'admin.pagos.index',
                'pagos.store',
            ];

            if ($request->routeIs($rutasPermitidas)) {
                return $next($request);
            }

            if (!$licenciaActiva) {

                if (!session()->has('licencia_alert_mostrada')) {
                    session()->flash('licencia_vencida', true);
                    session()->put('licencia_alert_mostrada', true);
                }

                return redirect()->route('admin.planes');
            }
        }

        /**
         * 🔹 REMITENTE (bloqueo total)
         */
        if (Auth::guard('remitente')->check()) {

            $user = Auth::guard('remitente')->user();

            // Buscar si hay alguna licencia activa
            $licenciaValida = Licencia::where('nit_empresa', $user->nit_empresa)
                ->where('id_estado', 1) // activo
                ->where('fecha_fin', '>=', now())
                ->exists();

            // Si NO hay licencia válida, cerrar sesión
            if (!$licenciaValida) {
                Auth::guard('remitente')->logout();

                return redirect()->route('login')
                    ->withErrors(['login' => 'Licencia inactiva, vencida o desactivada']);
            }
        }




        return $next($request);
    }
}

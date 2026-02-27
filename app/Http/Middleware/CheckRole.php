<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  int  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if (!in_array($user->emple_rol, $roles)) {
            $mensaje = 'No tienes permisos para acceder a este módulo u opción.';
            
            if ($user->emple_rol == 1) {
                return redirect()->route('sadmin.index')->with('error', $mensaje);
            } elseif ($user->emple_rol == 2) {
                return redirect()->route('admin.home')->with('error', $mensaje);
            } elseif ($user->emple_rol == 3) {
                return redirect()->route('empleado.index')->with('error', $mensaje);
            } else {
                return redirect()->route('web.index')->with('error', $mensaje);
            }
        }

        return $next($request);
    }
}

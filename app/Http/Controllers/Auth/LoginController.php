<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Licencia;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * 🔹 Verifica si existe una licencia activa
     */
    private function licenciaActiva(): bool
    {
        return Licencia::where('id_estado', 1)
            ->where('fecha_fin', '>=', now())
            ->exists();
    }

    public function login(Request $request)
    {
        $request->validate([
            'number'   => 'required|numeric',
            'password' => 'required|string',
        ]);

        /**
         * 🔹 LOGIN EMPLEADOS (SuperAdmin / Admin Empresa / Empleado)
         */
        if (Auth::guard('web')->attempt([
            'emple_doc' => $request->number,
            'password'  => $request->password
        ])) {

            $empleado = Auth::guard('web')->user();

            /**
             * 🔓 SuperAdmin → siempre entra
             */
            if ($empleado->emple_rol == 1) {
                return redirect()->route('sadmin.index');
            }

            /**
             * 🔓 Admin Empresa → entra siempre
             * 🔒 Restricciones se manejan en el sidebar
             */
            if ($empleado->emple_rol == 2) {
                return redirect()->route('admin.index');
            }

            /**
             * ❌ Otros empleados → requieren licencia activa
             */
            if (!$this->licenciaActiva()) {

                Auth::guard('web')->logout();

                return back()->withErrors([
                    'login' => 'La licencia de la empresa está vencida'
                ]);
            }

            return redirect()->route('empleado.index');
        }

        /**
         * 🔹 LOGIN REMITENTE
         */
        if (Auth::guard('remitente')->attempt([
            'rem_doc'  => $request->number,
            'password' => $request->password
        ])) {

            if (!$this->licenciaActiva()) {

                Auth::guard('remitente')->logout();

                return back()->withErrors([
                    'login' => 'La licencia de la empresa está vencida'
                ]);
            }

            return redirect()->route('remitente.index');
        }

        /**
         * ❌ Credenciales inválidas
         */
        return back()->withErrors([
            'login' => 'Credenciales incorrectas'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('remitente')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

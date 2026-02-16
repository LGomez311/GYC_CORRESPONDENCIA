<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'number'   => 'required|numeric',
            'password' => 'required|string',
        ]);

        $credentials = [
            'password' => $request->password
        ];

        /**
         * 🔹 LOGIN EMPLEADO / ADMIN / SUPERADMIN
         */
        if (Auth::guard('web')->attempt([
            'emple_doc' => $request->number,
            'password'  => $request->password
        ])) {

            $empleado = Auth::guard('web')->user();

            return match ($empleado->emple_rol) {
                1 => redirect()->route('sadmin.index'),
                2 => redirect()->route('admin.index'),
                default => redirect()->route('empleado.index'),
            };
        }

        /**
         * 🔹 LOGIN REMITENTE
         */
        if (Auth::guard('remitente')->attempt([
            'rem_doc'  => $request->number,
            'password' => $request->password
        ])) {

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

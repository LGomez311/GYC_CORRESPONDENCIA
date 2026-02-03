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
            'number' => 'required|numeric',
            'password' => 'required|string',
        ]);

        $number = $request->number;
        $password = $request->password;

        // Intentar login como empleado
        if (Auth::guard('web')->attempt(['emple_doc' => $number, 'password' => $password])) {
            $empleado = Auth::guard('web')->user();
            
            if ($empleado->emple_rol == 1) return redirect()->route('superadmin.dashboard');
            if ($empleado->emple_rol == 2) return redirect()->route('admin.dashboard');
            return redirect()->route('empleado.index');
        }

        // Intentar login como remitente
        if (Auth::guard('remitente')->attempt(['rem_doc' => $number, 'password' => $password])) {
            return redirect()->route('remitente.index');
        }

        return back()->withErrors(['login' => 'Credenciales incorrectas']);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('remitente')->check()) {
            Auth::guard('remitente')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
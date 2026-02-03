<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Empleado;

public function login(Request $request)
{
    $credentials = [
        'emple_doc' => $request->number,
        'password' => $request->password,
    ];

    if (Auth::guard('web')->attempt($credentials)) {

        $empleado = Auth::guard('web')->user();

        // Redireccionar según rol
        if ($empleado->emple_rol == 1) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($empleado->emple_rol == 2) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('empleado.index');
        }
    }

    return back()->withErrors(['login' => 'Credenciales incorrectas']);
}

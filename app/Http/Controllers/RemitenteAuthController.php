<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Remitente;

public function login(Request $request)
{
    $credentials = [
        'rem_doc' => $request->number,
        'password' => $request->password,
    ];

    if (Auth::guard('remitente')->attempt($credentials)) {
        return redirect()->route('remitente.index'); // Solo un dashboard
    }

    return back()->withErrors(['login' => 'Credenciales incorrectas']);
}
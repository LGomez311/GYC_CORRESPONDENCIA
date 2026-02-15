<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Licencia;
use Carbon\Carbon;

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

        //  Intentar login como empleado
        if (Auth::guard('web')->attempt(['emple_doc' => $number, 'password' => $password])) {

            $empleado = Auth::guard('web')->user();

            // Validar licencia SOLO si NO es SuperAdmin
            if ($empleado->emple_rol != 1) {

                $licenciaActiva = Licencia::where('nit_empresa', $empleado->nit_empresa)
                    ->where('id_estado', 1)
                    ->where('fecha_fin', '>=', Carbon::now())
                    ->first();

                if (!$licenciaActiva) {
                    Auth::guard('web')->logout();

                    return back()->withErrors([
                        'login' => 'La licencia de la empresa está inactiva o vencida'
                    ]);
                }
            }

            if ($empleado->emple_rol == 1) return redirect()->route('sadmin.index');
            if ($empleado->emple_rol == 2) return redirect()->route('admin.index');

            return redirect()->route('empleado.index');
        }

        //  Intentar login como remitente
        if (Auth::guard('remitente')->attempt(['rem_doc' => $number, 'password' => $password])) {

            $remitente = Auth::guard('remitente')->user();

            $licenciaActiva = Licencia::where('nit_empresa', $remitente->nit_empresa)
                ->where('id_estado', 1)
                ->where('fecha_fin', '>=', Carbon::now())
                ->first();

            if (!$licenciaActiva) {
                Auth::guard('remitente')->logout();

                return back()->withErrors([
                    'login' => 'La licencia de la empresa está inactiva o vencida'
                ]);
            }

            return redirect()->route('remitente.index');
        }

        //  Si no autenticó ninguno
        return back()->withErrors([
            'login' => 'Credenciales incorrectas'
        ]);
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

        return redirect()->route('login');
    }
}

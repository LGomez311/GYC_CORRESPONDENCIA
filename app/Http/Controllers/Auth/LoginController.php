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
            'number'   => 'required|numeric',
            'password' => 'required|string',
        ]);

        $number   = $request->number;
        $password = $request->password;

        // 🔹 LOGIN EMPLEADO / ADMIN / SUPERADMIN
        if (Auth::guard('web')->attempt(['emple_doc' => $number, 'password' => $password])) {

            $empleado = Auth::guard('web')->user();

            // 🔹 Validar licencia SOLO si NO es SuperAdmin
            if ($empleado->emple_rol != 1) {

                $licenciaActiva = Licencia::where('nit_empresa', $empleado->nit_empresa)
                    ->where('id_estado', 1)
                    ->where('fecha_fin', '>=', Carbon::now())
                    ->first();

                // ❌ Sin licencia
                if (!$licenciaActiva) {

                    // 🟡 Admin empresa → entra con advertencia
                    if ($empleado->emple_rol == 2) {
                        session(['licencia_vencida' => true]);
                    } else {
                        // 🔴 Empleado normal → fuera
                        Auth::guard('web')->logout();

                        return back()->withErrors([
                            'login' => 'La licencia de la empresa está inactiva o vencida'
                        ]);
                    }
                }
            }

            if ($empleado->emple_rol == 1) return redirect()->route('sadmin.index');
            if ($empleado->emple_rol == 2) return redirect()->route('admin.index');

            return redirect()->route('empleado.index');
        }

        // 🔹 LOGIN REMITENTE
        if (Auth::guard('remitente')->attempt(['rem_doc' => $number, 'password' => $password])) {

            $remitente = Auth::guard('remitente')->user();

            $licenciaActiva = Licencia::where('nit_empresa', $remitente->nit_empresa)
                ->where('id_estado', 1)
                ->where('fecha_fin', '>=', Carbon::now())
                ->first();

            // ❌ Remitente sin licencia → fuera SIEMPRE
            if (!$licenciaActiva) {

                Auth::guard('remitente')->logout();

                return back()->withErrors([
                    'login' => 'La licencia de la empresa está inactiva o vencida'
                ]);
            }

            return redirect()->route('remitente.index');
        }

        // ❌ Ningún login válido
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

        return redirect()
            ->route('login')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }

}

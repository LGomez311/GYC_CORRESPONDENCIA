<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TwoFactorController extends Controller
{
    /**
     * Muestra la vista para ingresar el código de 2FA.
     */
    public function showTwoFactorForm()
    {
        if (!Session::has('2fa_user_doc')) {
            return redirect()->route('login');
        }

        return view('auth.2fa');
    }

    /**
     * Verifica el código ingresado por el usuario.
     */
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.digits' => 'El código debe ser de 6 dígitos.',
        ]);

        if (!Session::has('2fa_user_doc')) {
            return redirect()->route('login');
        }

        $storedCode = Session::get('2fa_code');
        $expiresAt = Session::get('2fa_expires_at');
        $attempts = Session::get('2fa_attempts', 0);

        // Verificar expiración
        if (now()->greaterThan($expiresAt)) {
            $this->clearTwoFactorSession();
            return redirect()->route('login')->withErrors(['login' => 'El código de verificación ha expirado. Por favor, inicia sesión de nuevo.']);
        }

        // Verificar intentos
        if ($attempts >= 3) {
            $this->clearTwoFactorSession();
            return redirect()->route('login')->withErrors(['login' => 'Has superado el número máximo de intentos (3). Por favor, inicia sesión de nuevo.']);
        }

        // Verificar código
        if ($request->code == $storedCode) {
            $userDoc = Session::get('2fa_user_doc');
            $this->clearTwoFactorSession();

            // Iniciar sesión oficialmente
            Auth::guard('web')->loginUsingId($userDoc);

            $user = Auth::guard('web')->user();

            // Redirección basada en el rol (copiado de LoginController)
            if ($user->emple_rol == 1) {
                return redirect()->route('sadmin.index');
            }
            if ($user->emple_rol == 2) {
                return redirect()->route('admin.home');
            }

            return redirect()->route('empleado.index');
        }

        // Incremento de intentos si el código es incorrecto
        $attempts++;
        Session::put('2fa_attempts', $attempts);

        $remaining = 3 - $attempts;
        
        if ($remaining <= 0) {
            $this->clearTwoFactorSession();
            return redirect()->route('login')->withErrors(['login' => 'Has superado el número máximo de intentos (3).']);
        }

        return back()->withErrors(['code' => "Código incorrecto. Te quedan {$remaining} intentos."]);
    }

    /**
     * Limpia las variables de sesión de 2FA.
     */
    private function clearTwoFactorSession()
    {
        Session::forget(['2fa_user_doc', '2fa_code', '2fa_attempts', '2fa_expires_at']);
    }
}

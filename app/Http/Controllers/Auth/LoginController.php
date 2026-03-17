<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Licencia;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $throttleKey = 'login|' . request()->ip();
        $remainingAttempts = $this->maxAttempts() - RateLimiter::attempts($throttleKey);
        
        $lockoutSeconds = 0;
        if (RateLimiter::tooManyAttempts($throttleKey, $this->maxAttempts())) {
            $lockoutSeconds = RateLimiter::availableIn($throttleKey);
        }

        return view('auth.login', compact('remainingAttempts', 'lockoutSeconds'));
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
            'number' => [
                'required',
                'digits_between:6,10',
                'regex:/^(?!([0-9])\1+$)[0-9]+$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:64'
            ],
        ]);


        // 🚫 Verificar si está bloqueado
        if (RateLimiter::tooManyAttempts(
            $this->throttleKey($request),
            $this->maxAttempts()
        )) {

            $seconds = RateLimiter::availableIn(
                $this->throttleKey($request)
            );

            return back()->withErrors([
                'login' => "Demasiados intentos. Intenta nuevamente en {$seconds} segundos."
            ])->with('lockout_seconds', $seconds);
        }

        /**
         * 🔹 LOGIN EMPLEADOS (SuperAdmin / Admin Empresa / Empleado)
         */
        if (Auth::guard('web')->attempt([
            'emple_doc' => $request->number,
            'password'  => $request->password
        ])) {

            RateLimiter::clear($this->throttleKey($request));

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
                return redirect()->route('admin.home');
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

            RateLimiter::clear($this->throttleKey($request));

            if (!$this->licenciaActiva()) {

                Auth::guard('remitente')->logout();

                return back()->withErrors([
                    'login' => 'La licencia de la empresa está vencida'
                ]);
            }

            return redirect()->route('remitente.index');
        }

        RateLimiter::hit(
            $this->throttleKey($request),
            $this->decayMinutes() * 60
        );

        $throttleKey = $this->throttleKey($request);
        $remainingAttempts = $this->maxAttempts() - RateLimiter::attempts($throttleKey);
        
        $seconds = 0;
        if (RateLimiter::tooManyAttempts($throttleKey, $this->maxAttempts())) {
            $seconds = RateLimiter::availableIn($throttleKey);
        }

        return back()->withErrors([
            'login' => 'Credenciales incorrectas.'
        ])->with([
            'remaining_attempts' => $remainingAttempts,
            'lockout_seconds' => $seconds
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
    protected function throttleKey(Request $request)
    {
        return 'login|' . $request->ip();
    }

    protected function maxAttempts()
    {
        return 5; // intentos
    }

    protected function decayMinutes()
    {
        return 5; // minutos bloqueado
    }
}

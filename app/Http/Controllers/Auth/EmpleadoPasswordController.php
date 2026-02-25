<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Empleado;
use App\Models\Remitente;

class EmpleadoPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.empleado-forgot');
    }

    public function sendCode(Request $request)
    {
        // ✅ Validar que el correo exista en empleado o remitente
        $request->validate([
            'email' => ['required', 'email', function ($attribute, $value, $fail) {
                $existsEmpleado = Empleado::where('emple_correo', $value)->exists();
                $existsRemitente = Remitente::where('rem_correo', $value)->exists();

                if (!$existsEmpleado && !$existsRemitente) {
                    $fail('El correo no se encuentra registrado.');
                }
            }]
        ]);

        $code = rand(100000, 999999);

        // ✅ Guardar o actualizar el código
        DB::table('password_codes')->updateOrInsert(
            ['emple_correo' => $request->email],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // ✅ Envío de correo
        Mail::send([], [], function ($message) use ($request, $code) {
            $message->to($request->email)
                ->subject('Código de recuperación de contraseña')
                ->html("
            <div style='
                font-family: Arial, Helvetica, sans-serif;
                background-color: #f4f6fb;
                padding: 40px;
            '>
                <div style='
                    max-width: 520px;
                    margin: auto;
                    background-color: #ffffff;
                    border-radius: 12px;
                    padding: 30px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
                '>

                    <h2 style='
                        color: #0d121b;
                        margin-bottom: 10px;
                        text-align: center;
                    '>
                        Recuperación de contraseña
                    </h2>

                    <p style='
                        color: #4c669a;
                        font-size: 15px;
                        text-align: center;
                    '>
                        Hemos recibido una solicitud para restablecer tu contraseña.
                    </p>

                    <div style='
                        margin: 30px 0;
                        padding: 20px;
                        background-color: #f0f4ff;
                        border-radius: 10px;
                        text-align: center;
                    '>
                        <p style='
                            margin: 0;
                            font-size: 14px;
                            color: #4c669a;
                        '>
                            Tu código de recuperación es:
                        </p>

                        <p style='
                            margin: 10px 0 0;
                            font-size: 28px;
                            font-weight: bold;
                            letter-spacing: 4px;
                            color: #4c669a;
                        '>
                            $code
                        </p>
                    </div>

                    <p style='
                        font-size: 14px;
                        color: #6b7280;
                        line-height: 1.6;
                    '>
                        ⚠️ <strong>No compartas este código con nadie.</strong>  
                        Nuestro equipo nunca te pedirá este código por correo, teléfono o mensaje.
                    </p>

                    <p style='
                        font-size: 14px;
                        color: #6b7280;
                        line-height: 1.6;
                    '>
                        Si no solicitaste este cambio, puedes ignorar este correo de forma segura.
                    </p>

                    <hr style='
                        margin: 30px 0;
                        border: none;
                        border-top: 1px solid #e5e7eb;
                    '>

                    <p style='
                        font-size: 12px;
                        color: #9ca3af;
                        text-align: center;
                    '>
                        © " . date('Y') . " IncolDev. Todos los derechos reservados.
                    </p>

                </div>
            </div>
        ");
        });


        return redirect()->route('empleado.password.verify')
            ->with('success', 'Código enviado al correo.');
    }

    public function showVerifyForm()
    {
        return view('auth.empleado-verify');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        // ✅ Validar código
        $record = DB::table('password_codes')
            ->where('emple_correo', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Código inválido']);
        }

        if (Carbon::now()->greaterThan($record->expires_at)) {
            return back()->withErrors(['code' => 'Código expirado']);
        }

        // ✅ Buscar usuario en ambas tablas
        $empleado = Empleado::where('emple_correo', $request->email)->first();
        $remitente = Remitente::where('rem_correo', $request->email)->first();

        if (!$empleado && !$remitente) {
            return back()->withErrors(['email' => 'Usuario no encontrado']);
        }

        // ✅ Actualizar contraseña según tipo de usuario
        if ($empleado) {
            $empleado->password = Hash::make($request->password);
            $empleado->save();
        }

        if ($remitente) {
            $remitente->password = Hash::make($request->password);
            $remitente->save();
        }

        // ✅ Eliminar código usado
        DB::table('password_codes')
            ->where('emple_correo', $request->email)
            ->delete();

        return redirect()->route('login')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}

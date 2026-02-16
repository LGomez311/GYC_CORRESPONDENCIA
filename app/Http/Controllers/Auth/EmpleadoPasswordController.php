<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Empleado;
use Carbon\Carbon;

class EmpleadoPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.empleado-forgot');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:empleado,emple_correo'
        ]);

        $code = rand(100000, 999999);

        DB::table('password_codes')->updateOrInsert(
            ['emple_correo' => $request->email],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        Mail::raw("Tu código de recuperación es: $code", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Código de Recuperación');
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

        $empleado = Empleado::where('emple_correo', $request->email)->first();
        if (!$empleado) {
            return back()->withErrors(['email' => 'Usuario no encontrado']);
        }
        $empleado->password = Hash::make($request->password);
        $empleado->save();

        DB::table('password_codes')->where('emple_correo', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}

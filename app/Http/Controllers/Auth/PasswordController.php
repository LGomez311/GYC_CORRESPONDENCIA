<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordCodeMail;
use App\Models\User; // ajusta si tu modelo es diferente
use Carbon\Carbon;

class PasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.passwords.email');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Correo no encontrado']);
        }

        $code = rand(100000, 999999);

        DB::table('password_codes')->updateOrInsert(
            ['email' => $request->email],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        Mail::to($request->email)->send(new PasswordCodeMail($code));

        return redirect()->route('password.verify')
                         ->with('email', $request->email);
    }

    public function showVerifyForm()
    {
        return view('auth.passwords.verify');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required'
        ]);

        $record = DB::table('password_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record || Carbon::now()->gt($record->expires_at)) {
            return back()->withErrors(['code' => 'Código inválido o expirado']);
        }

        return redirect()->route('password.reset.form')
                         ->with('email', $request->email);
    }

    public function showResetForm()
    {
        return view('auth.passwords.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_codes')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')
            ->with('success', 'Contraseña actualizada correctamente');
    }
}

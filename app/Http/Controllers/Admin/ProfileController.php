<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Empleado|\App\Models\Remitente $user */
        /** @var \App\Models\Empleado|\App\Models\Remitente $user */
        $user = auth()->user();
        $isEmpleado = $user instanceof \App\Models\Empleado;
        
        $telField = $isEmpleado ? 'emple_tel' : 'rem_tel';
        $emailField = $isEmpleado ? 'emple_correo' : 'rem_correo';
        $docField = $isEmpleado ? 'emple_doc' : 'rem_doc';
        $imgField = $isEmpleado ? 'emple_img' : 'rem_img';
        $tableName = $isEmpleado ? 'empleado' : 'remitente';

        $request->validate([
            $emailField => "required|email|max:150|unique:$tableName,$emailField," . $user->$docField . ",$docField",
            $telField => "required|string|min:7|max:15|regex:/^[0-9]+$/",
            'profile_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            "$emailField.unique" => 'Este correo ya está en uso por otro usuario.',
            "$emailField.email" => 'Debe proporcionar un correo electrónico válido.',
            "$telField.required" => 'El número de teléfono es obligatorio.',
            "$telField.min" => 'El teléfono debe tener al menos 7 dígitos.',
            "$telField.max" => 'El teléfono no puede superar los 15 caracteres.',
            "$telField.regex" => 'El teléfono solo debe contener números.',
            'profile_img.max' => 'La imagen no debe superar los 2MB.',
        ]);

        $user->$emailField = $request->$emailField;
        $user->$telField = $request->$telField;

        if ($request->hasFile('profile_img')) {
            $image = $request->file('profile_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image->getRealPath());

            // Resize maintaining aspect ratio
            $img->scaleDown(300, 300);

            // Create circular crop
            $size = min($img->width(), $img->height());
            $img->cover($size, $size);

            $img->save($path);

            if ($user->$imgField && Storage::disk('public')->exists($user->$imgField)) {
                Storage::disk('public')->delete($user->$imgField);
            }

            $user->$imgField = $filename;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Perfil actualizado correctamente.']);
    }

    public function sendVerificationCode(Request $request)
    {
        /** @var \App\Models\Empleado|\App\Models\Remitente $user */
        $user = auth()->user();
        $isEmpleado = $user instanceof \App\Models\Empleado;
        $emailField = $isEmpleado ? 'emple_correo' : 'rem_correo';
        $userEmail = $user->$emailField;
        
        $code = rand(100000, 999999);

        DB::table('password_codes')->updateOrInsert(
            ['emple_correo' => $userEmail],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        Mail::send([], [], function ($message) use ($userEmail, $code) {
            $message->to($userEmail)
                ->subject('Código de verificación - Cambio de contraseña')
                ->html("
                <div style='font-family: Arial, Helvetica, sans-serif; background-color: #f4f6fb; padding: 40px;'>
                    <div style='max-width: 520px; margin: auto; background-color: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);'>
                        <h2 style='color: #0d121b; margin-bottom: 10px; text-align: center;'>Cambio de contraseña</h2>
                        <p style='color: #4c669a; font-size: 15px; text-align: center;'>Has solicitado cambiar tu contraseña desde tu perfil.</p>
                        <div style='margin: 30px 0; padding: 20px; background-color: #f0f4ff; border-radius: 10px; text-align: center;'>
                            <p style='margin: 0; font-size: 14px; color: #4c669a;'>Tu código de verificación es:</p>
                            <p style='margin: 10px 0 0; font-size: 28px; font-weight: bold; letter-spacing: 4px; color: #4c669a;'>$code</p>
                        </div>
                        <p style='font-size: 14px; color: #6b7280; line-height: 1.6;'>⚠️ <strong>No compartas este código con nadie.</strong> Nuestro equipo nunca te pedirá este código por correo, teléfono o mensaje.</p>
                        <hr style='margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;'>
                        <p style='font-size: 12px; color: #9ca3af; text-align: center;'>© " . date('Y') . " EASYCOR. Todos los derechos reservados.</p>
                    </div>
                </div>
            ");
        });

        return response()->json(['success' => true, 'message' => 'Código enviado al correo electrónico.']);
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\Empleado|\App\Models\Remitente $user */
        /** @var \App\Models\Empleado|\App\Models\Remitente $user */
        $user = auth()->user();

        $request->validate([
            'password_old' => 'required|string',
            'password' => [
                'required',
                'string',
                'max:64',
                'confirmed',
                Password::min(10)->letters()->mixedCase()->numbers()->symbols()
            ],
        ], [
            'password_old.required' => 'La contraseña anterior es obligatoria.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        if (!Hash::check($request->password_old, $user->password)) {
            return response()->json(['success' => false, 'message' => 'La contraseña anterior es incorrecta.'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $emailField = ($user instanceof \App\Models\Empleado) ? 'emple_correo' : 'rem_correo';
        $userEmail = $user->$emailField;

        try {
            Mail::send([], [], function ($message) use ($userEmail) {
                $message->to($userEmail)
                    ->subject('Contraseña actualizada exitosamente')
                    ->html("
                    <div style='font-family: Arial, Helvetica, sans-serif; background-color: #f4f6fb; padding: 40px;'>
                        <div style='max-width: 520px; margin: auto; background-color: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);'>
                            <h2 style='color: #0d121b; margin-bottom: 10px; text-align: center;'>Cambio de contraseña exitoso</h2>
                            <p style='color: #4c669a; font-size: 15px; text-align: center;'>Te confirmamos que tu contraseña ha sido actualizada correctamente.</p>
                            <p style='font-size: 14px; color: #6b7280; line-height: 1.6;'>Si no solicitaste este cambio, por favor comunícate con el administrador del sistema inmediatamente.</p>
                            <hr style='margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;'>
                            <p style='font-size: 12px; color: #9ca3af; text-align: center;'>© " . date('Y') . " EASYCOR. Todos los derechos reservados.</p>
                        </div>
                    </div>
                ");
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("No se pudo enviar el correo de cambio de contraseña: " . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Contraseña actualizada correctamente.']);
    }
}

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
        $user = auth('web')->user();

        $request->validate([
            'emple_correo' => 'required|email|max:150|unique:empleado,emple_correo,' . $user->emple_doc . ',emple_doc',
            'emple_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'emple_correo.unique' => 'Este correo ya está en uso por otro empleado.',
            'emple_img.max' => 'La imagen no debe superar los 2MB.',
        ]);

        $user->emple_correo = $request->emple_correo;

        if ($request->hasFile('emple_img')) {
            $image = $request->file('emple_img');
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

            if ($user->emple_img && Storage::disk('public')->exists($user->emple_img)) {
                Storage::disk('public')->delete($user->emple_img);
            }

            $user->emple_img = $filename;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Perfil actualizado correctamente.']);
    }

    public function sendVerificationCode(Request $request)
    {
        $user = auth('web')->user();
        $code = rand(100000, 999999);

        DB::table('password_codes')->updateOrInsert(
            ['emple_correo' => $user->emple_correo],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        Mail::send([], [], function ($message) use ($user, $code) {
            $message->to($user->emple_correo)
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
                        <p style='font-size: 12px; color: #9ca3af; text-align: center;'>© " . date('Y') . " IncolDev. Todos los derechos reservados.</p>
                    </div>
                </div>
            ");
        });

        return response()->json(['success' => true, 'message' => 'Código enviado al correo electrónico.']);
    }

    public function updatePassword(Request $request)
    {
        $user = auth('web')->user();

        $request->validate([
            'code' => 'required|digits:6',
            'password' => [
                'required',
                'string',
                'max:64',
                'confirmed',
                Password::min(10)->letters()->mixedCase()->numbers()->symbols()->uncompromised()
            ],
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.digits' => 'El código debe tener 6 dígitos.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $record = DB::table('password_codes')->where('emple_correo', $user->emple_correo)->first();

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'No existe una solicitud de código para este usuario.'], 400);
        }

        if (Carbon::now()->greaterThan($record->expires_at)) {
            return response()->json(['success' => false, 'message' => 'El código ha expirado. Solicita uno nuevo.'], 400);
        }

        if ($record->code != $request->code) {
            return response()->json(['success' => false, 'message' => 'El código ingresado no es válido.'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_codes')->where('emple_correo', $user->emple_correo)->delete();

        return response()->json(['success' => true, 'message' => 'Contraseña actualizada correctamente.']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class NuevaContraseñaController extends Controller
{
    //

    public function olvideMiContrasena(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $estado = Password::sendResetLink(
            $request->only('email')
        );

        if ($estado == Password::RESET_LINK_SENT) {
            return [
                'status' => __($estado)
            ];
        }

        // throw ValidationException::withMessages([
        //     'email' => [trans($estado)],
        // ]);
        else {
            return response(['message' => __($estado)], 400);
        }
        // return $estado === Password::RESET_LINK_SENT
        //         ? back()->with(['status' => __($estado)])
        //         : back()->withErrors(['email' => __($estado)]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();   

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message' => 'Contraseña restaurada correctamente'
            ]);
        }

        return response([
            'message' => __($status)
        ], 500);
    }
}

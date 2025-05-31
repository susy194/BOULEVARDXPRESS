<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }


    public function validateUser(Request $request)
    {
        $request->validate([
            "username" => ['required', 'string'],
            "password" => ['required', 'string']
        ]);

        $user = User::where('usuario', $request->input('username'))->first();

        if (!$user) {
            return response()->json([
                'ok' => false,
                'error' => 'Credenciales incorrectas'
            ], 422);
        }

        // Verificar si el usuario está bloqueado
        if ($user->bloqueado) {
            return response()->json([
                'ok' => false,
                'error' => 'Usuario bloqueado, contacta al administrador para ser desbloqueado'
            ], 422);
        }

        if ($user->password === $request->input('password')) {
            // Reiniciar intentos fallidos si la contraseña es correcta
            DB::table('Usuarios_Sistema')
                ->where('usuario', $request->input('username'))
                ->update([
                    'intentos_fallidos' => 0,
                    'bloqueado' => false
                ]);

            Auth::login($user);
            $request->session()->regenerate();

            $rol = Auth::user()->rol;

            $ruta = match($rol) {
                'Administrador' => route('home-admin'),
                'Chef'          => route('home-chef'),
                'Mesero'        => route('home-mesero'),
                default         => route('login')
            };

            return response()->json([
                'ok'       => true,
                'redirect' => $ruta
            ]);
        }

        // Incrementar intentos fallidos
        $intentos = DB::table('Usuarios_Sistema')
            ->where('usuario', $request->input('username'))
            ->value('intentos_fallidos') ?? 0;

        $intentos++;

        if ($intentos >= 3) {
            // Bloquear usuario después de 3 intentos fallidos
            DB::table('Usuarios_Sistema')
                ->where('usuario', $request->input('username'))
                ->update([
                    'intentos_fallidos' => $intentos,
                    'bloqueado' => true
                ]);

            return response()->json([
                'ok' => false,
                'error' => 'Usuario bloqueado, contacta al administrador para ser desbloqueado'
            ], 422);
        }

        // Actualizar intentos fallidos
        DB::table('Usuarios_Sistema')
            ->where('usuario', $request->input('username'))
            ->update(['intentos_fallidos' => $intentos]);

        return response()->json([
            'ok' => false,
            'error' => 'Credenciales incorrectas'
        ], 422);
    }


    public function logout(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

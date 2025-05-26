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

        if ( $user && $user->password === $request->input('password') ) {
            Auth::login($user);
            $request->session()->regenerate();

            $rol = Auth::user()->rol;

            $ruta = match( $rol ) {
                'Administrador' => route('home-admin' ),
                'Chef'          => route('home-chef'  ),
                'Mesero'        => route('home-mesero'),
                default         => route('login'      )
            };

            return response()->json([
                'ok'       => true,
                'redirect' => $ruta
            ]);
        }

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

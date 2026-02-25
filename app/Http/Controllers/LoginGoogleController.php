<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;
use Google_Client;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Storage;


class LoginGoogleController extends Controller
{
    // Redirigir a Google para autenticación
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Manejar el callback de Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                Auth::login($user);
                return redirect('/user');
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(uniqid()),
                    'tipo' => 'google',
                    'photo_url' => $googleUser->avatar,
                    'role_id' => 2,
                    'estado' => 'activo',
                ]);

                Auth::login($user);
                return redirect('/user');
            }
        } catch (\Exception $e) {
            return redirect('/register')->with('error', 'Error al autenticar con Google: ' . $e->getMessage());
        }
    }

    public function redirectToGoogleForLogin()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }
}
